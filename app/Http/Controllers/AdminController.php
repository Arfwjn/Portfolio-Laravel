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

    /**
     * Menampilkan halaman utama dashboard admin.
     * Berisi statistik ringkasan dan pesan terbaru.
     */
    public function dashboard(): View
    {
        $stats = [
            'total_projects'  => Project::count(),
            'published'       => Project::published()->count(),
            'unread_messages' => ContactMessage::unread()->count(),
        ];

        $recentMessages = ContactMessage::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentMessages'));
    }

    // ===================================================================
    // PROFILE MANAGEMENT
    // ===================================================================

    /**
     * Menampilkan form untuk mengedit profil.
     */
    public function editProfile(): View
    {
        $profile = Profile::getSingle() ?? new Profile();
        return view('admin.profile.edit', compact('profile'));
    }

    /**
     * Menyimpan perubahan profil ke database.
     * Hanya memvalidasi kolom yang benar-benar ada di tabel profiles.
     */
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
            'interests'        => ['nullable', 'string'],
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

        // Upload avatar baru — hapus file lama kalau ada
        if ($request->hasFile('avatar')) {
            if ($profile->avatar) {
                Storage::disk('public')->delete($profile->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Upload hero image baru
        if ($request->hasFile('hero_image')) {
            if ($profile->hero_image) {
                Storage::disk('public')->delete($profile->hero_image);
            }
            $validated['hero_image'] = $request->file('hero_image')->store('heroes', 'public');
        }

        // Decode JSON interests dari hidden input
        $validated['interests'] = $this->decodeJsonField($validated['interests'] ?? null);

        $profile->fill($validated)->save();

        return redirect()
            ->route('admin.profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    // ===================================================================
    // PROJECT CRUD
    // ===================================================================

    /**
     * Menampilkan daftar semua proyek.
     */
    public function projects(): View
    {
        $projects = Project::ordered()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Menampilkan form untuk menambahkan proyek baru.
     */
    public function createProject(): View
    {
        return view('admin.projects.create');
    }

    /**
     * Menyimpan proyek baru ke database.
     */
    public function storeProject(Request $request): RedirectResponse
    {
        $validated = $this->validateProject($request);

        // Upload thumbnail jika ada
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('projects', 'public');
        }

        // Decode JSON tech_stack dari hidden input
        $validated['tech_stack'] = $this->decodeJsonField($validated['tech_stack'] ?? null) ?? [];

        Project::create($validated);

        return redirect()
            ->route('admin.projects')
            ->with('success', 'Proyek baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit proyek.
     */
    public function editProject(Project $project): View
    {
        // Arahkan ke view 'create' karena file tersebut sudah didesain untuk menangani edit
        return view('admin.projects.create', compact('project'));
    }

    /**
     * Memperbarui data proyek di database.
     */
    public function updateProject(Request $request, Project $project): RedirectResponse
    {
        $validated = $this->validateProject($request);

        // Ganti thumbnail — hapus file lama dulu
        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('projects', 'public');
        }

        // Decode JSON tech_stack
        $validated['tech_stack'] = $this->decodeJsonField($validated['tech_stack'] ?? null) ?? [];

        $project->update($validated);

        return redirect()
            ->route('admin.projects')
            ->with('success', 'Proyek berhasil diperbarui!');
    }

    /**
     * Menghapus proyek beserta thumbnail-nya dari storage.
     */
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

    /**
     * Menampilkan daftar semua pesan kontak masuk.
     */
    public function messages(): View
    {
        $messages = ContactMessage::latest()->paginate(15);
        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Menandai pesan sebagai sudah dibaca.
     */
    public function readMessage(ContactMessage $message): RedirectResponse
    {
        $message->markAsRead();
        return redirect()->back()->with('success', 'Pesan ditandai sudah dibaca.');
    }

    /**
     * Menghapus pesan kontak.
     */
    public function destroyMessage(ContactMessage $message): RedirectResponse
    {
        $message->delete();
        return redirect()->back()->with('success', 'Pesan berhasil dihapus.');
    }

    // ===================================================================
    // PRIVATE HELPER
    // ===================================================================

    /**
     * Validasi data proyek.
     */
    private function validateProject(Request $request): array
    {
        return $request->validate([
            'title'        => ['required', 'string', 'max:200'],
            'description'  => ['required', 'string', 'max:500'],
            'demo_url'     => ['nullable', 'url', 'max:255'],
            'github_url'   => ['nullable', 'url', 'max:255'],
            'tech_stack'   => ['required', 'string'],
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
     * Decode JSON string dari hidden input form.
     * Mengembalikan array kalau valid, null kalau kosong atau tidak valid JSON.
     */
    private function decodeJsonField(?string $value): ?array
    {
        if (empty($value)) return null;
        $decoded = json_decode($value, true);
        return is_array($decoded) ? $decoded : null;
    }
}

