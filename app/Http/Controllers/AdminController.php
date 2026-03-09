<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Project;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

/**
 * Controller untuk mengelola halaman admin.
 * Semua method di sini dilindungi oleh middleware 'auth',
 * sehingga hanya pengguna yang sudah login yang bisa mengakses.
 */
class AdminController extends Controller
{
    // ===================================================================
    // DASHBOARD
    // ===================================================================

    public function dashboard(): View
    {
        $stats = [
            'total_projects'  => Project::count(),
            'published'       => Project::published()->count(),
            'unread_messages' => ContactMessage::unread()->count(),
        ];

        // Optimalisasi: Hanya ambil kolom yang diperlukan untuk performa lebih baik
        $recentMessages = ContactMessage::select('id', 'name', 'email', 'is_read', 'created_at')
                            ->latest()
                            ->limit(5)
                            ->get();

        return view('admin.dashboard', compact('stats', 'recentMessages'));
    }

    // ===================================================================
    // PROFILE MANAGEMENT
    // ===================================================================

    public function editProfile(): View
    {
        $profile = Profile::getSingle() ?? new Profile();
        return view('admin.profile.edit', compact('profile'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name'        => ['required', 'string', 'max:150'],
            'title'            => ['required', 'string', 'max:200'],
            'subtitle'         => ['nullable', 'string', 'max:255'],
            'bio'              => ['required', 'string'],
            'experience_years' => ['nullable', 'string', 'max:50'],
            'education'        => ['nullable', 'string', 'max:255'],
            'location'         => ['nullable', 'string', 'max:150'],
            // Hapus aturan 'string' agar dapat menerima array langsung dari form frontend
            'interests'        => ['nullable'], 
            'email'            => ['nullable', 'email', 'max:255'],
            'phone'            => ['nullable', 'string', 'max:30'],
            'github_url'       => ['nullable', 'url', 'max:255'],
            'linkedin_url'     => ['nullable', 'url', 'max:255'],
            'twitter_url'      => ['nullable', 'url', 'max:255'],
            'is_open_to_work'  => ['boolean'],
            'avatar'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'hero_image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $profile = Profile::getSingle() ?? new Profile();

        if ($request->hasFile('avatar')) {
            if ($profile->avatar) Storage::disk('public')->delete($profile->avatar);
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->hasFile('hero_image')) {
            if ($profile->hero_image) Storage::disk('public')->delete($profile->hero_image);
            $validated['hero_image'] = $request->file('hero_image')->store('heroes', 'public');
        }

        // Tangani interests baik itu dikirim sebagai JSON string maupun Array
        $validated['interests'] = $this->parseArrayField($request->input('interests'));

        $profile->fill($validated)->save();

        return redirect()
            ->route('admin.profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    // ===================================================================
    // PROJECT CRUD
    // ===================================================================

    public function projects(): View
    {
        $projects = Project::ordered()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function createProject(): View
    {
        return view('admin.projects.create');
    }

    public function storeProject(Request $request): RedirectResponse
    {
        $validated = $this->validateProject($request);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('projects', 'public');
        }

        // Gunakan helper cerdas untuk menangani array atau string JSON
        $validated['tech_stack'] = $this->parseArrayField($request->input('tech_stack'));

        Project::create($validated);

        return redirect()
            ->route('admin.projects')
            ->with('success', 'Proyek baru berhasil ditambahkan!');
    }

    public function editProject(Project $project): View
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function updateProject(Request $request, Project $project): RedirectResponse
    {
        $validated = $this->validateProject($request);

        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail) Storage::disk('public')->delete($project->thumbnail);
            $validated['thumbnail'] = $request->file('thumbnail')->store('projects', 'public');
        }

        $validated['tech_stack'] = $this->parseArrayField($request->input('tech_stack'));

        $project->update($validated);

        return redirect()
            ->route('admin.projects')
            ->with('success', 'Proyek berhasil diperbarui!');
    }

    public function destroyProject(Project $project): RedirectResponse
    {
        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }
        $project->delete();

        return redirect()
            ->route('admin.projects')
            ->with('success', 'Proyek berhasil dihapus.');
    }

    // ===================================================================
    // CONTACT MESSAGES
    // ===================================================================

    public function messages(): View
    {
        $messages = ContactMessage::latest()->paginate(15);
        return view('admin.messages.index', compact('messages'));
    }

    public function readMessage(ContactMessage $message): RedirectResponse
    {
        $message->markAsRead();
        return redirect()->back()->with('success', 'Pesan ditandai sudah dibaca.');
    }

    public function destroyMessage(ContactMessage $message): RedirectResponse
    {
        $message->delete();
        return redirect()->back()->with('success', 'Pesan berhasil dihapus.');
    }

    // ===================================================================
    // PRIVATE HELPERS
    // ===================================================================

    private function validateProject(Request $request): array
    {
        return $request->validate([
            'title'        => ['required', 'string', 'max:200'],
            'description'  => ['required', 'string', 'max:500'],
            'demo_url'     => ['nullable', 'url', 'max:255'],
            'github_url'   => ['nullable', 'url', 'max:255'],
            // FIX: Hapus aturan 'string' untuk tech_stack agar support array dari form select-multiple
            'tech_stack'   => ['required'], 
            'category'     => ['nullable', 'string', 'max:100'],
            'sort_order'   => ['integer', 'min:0'],
            'is_featured'  => ['boolean'],
            'is_published' => ['boolean'],
            'built_at'     => ['nullable', 'date'],
            'thumbnail'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:3072'],
        ], [
            'title.required'       => 'Judul proyek wajib diisi.',
            'description.required' => 'Deskripsi singkat wajib diisi.',
            'tech_stack.required'  => 'Minimal satu tech stack harus diisi.',
        ]);
    }

    /**
     * Memproses data field agar aman di-convert ke bentuk Array.
     * Mengantisipasi data yang masuk berupa Array murni atau JSON String.
     */
    private function parseArrayField($value): array
    {
        if (empty($value)) return [];
        if (is_array($value)) return $value;
        
        $decoded = json_decode($value, true);
        return is_array($decoded) ? $decoded : [];
    }
}