<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Profile;
use App\Models\Project;
use Illuminate\Http\Request;

/**
 * Controller untuk halaman publik portofolio.
 * Menampilkan profil, proyek, dan form kontak.
 */
class PortfolioController extends Controller
{
    /**
     * Menampilkan halaman utama portofolio.
     */
    public function index()
    {
        $profile  = Profile::getSingle();
        $projects = Project::published()->ordered()->get();
        $featured = Project::featured()->published()->ordered()->get();

        return view('portfolio.index', compact('profile', 'projects', 'featured'));
    }

    /**
     * Memproses pengiriman pesan kontak.
     */
    public function sendContact(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:100',
            'subject' => 'nullable|string|max:200',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'subject'    => $request->subject,
            'message'    => $request->message,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Pesan berhasil dikirim! Saya akan membalas secepatnya.');
    }
}

