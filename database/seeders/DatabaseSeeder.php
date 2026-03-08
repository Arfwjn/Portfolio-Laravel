<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder untuk mengisi database dengan data awal.
 * Membuat user admin, profil, dan beberapa proyek contoh.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── User Admin ──────────────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'ariefsidik2016@gmail.com'],
            [
                'name'     => 'Admin',
                'email'    => 'ariefsidik2016@gmail.com',
                'password' => Hash::make('ariefsidik123'),
            ]
        );

        // ── Profile ─────────────────────────────────────────────────────
        Profile::firstOrCreate(
            [],
            [
                'full_name'        => 'Arief Sidik Wijayanto',
                'title'            => 'Data Enthusiast & Junior Machine Learning Engineer',
                'subtitle'         => 'Membangun solusi cerdas dengan data dan AI',
                'bio'              => "Hai! Saya Arief, seorang yang tertarik dengan Data Science berbasis di Indonesia dengan passion mendalam pada pengembangan web modern dan kecerdasan buatan.\n\nSaya percaya bahwa program yang baik bukan hanya soal fungsi, tapi juga soal maintainability. Setiap proyek adalah kesempatan untuk belajar hal baru dan memberikan dampak nyata.\n\nSaat ini sedang mendalami Machine Learning dan Deep Learning untuk mengintegrasikan AI ke dalam produk web.",
                'experience_years' => '1+ Tahun',
                'education'        => 'S1 Teknik Informatika',
                'location'         => 'Purwokerto, Indonesia',
                'is_open_to_work'  => true,
                'interests'        => ['Web Development', 'Machine Learning', 'Deep Learning', 'Data Visualization', 'MLOps'],
                'email'            => 'ariefsidik2016@gmail.com',
                'phone'            => null,
                'github_url'       => 'https://github.com/Arfwjn',
                'linkedin_url'     => 'https://www.linkedin.com/in/arief-sidik-55838031b',
                'twitter_url'      => null,
                'website_url'      => null,
                'resume_url'       => null,
                'avatar'           => null,
                'hero_image'       => null,
            ]
        );

        // ── Projects ────────────────────────────────────────────────────
        $projects = [
            [
                'title'        => 'A.I.R.A.',
                'description'  => 'Platform perekrutan dan penilaian interview kandidat karyawan secara otomatis berbasis AI menggunakan model Whisper ONNX untuk Speech to Text dan Mediapipe untuk analisis Gaze-Tracking, serta dilengkapi dengan penilaian menggunakan Gemini 3 API.',
                'tech_stack'   => ['Whisper ONNX', 'Mediapipe', 'Gemini LLM', 'Flask', 'Tailwind CSS'],
                'category'     => 'AI Web App',
                'github_url'   => 'https://github.com/Arfwjn/AIRA',
                'demo_url'     => 'https://drive.google.com/drive/u/0/folders/1goof4ua1n7VfZsfLzcbgUkTDdV1tb8Ff',
                'thumbnail'    => null,
                'is_featured'  => true,
                'is_published' => true,
                'sort_order'   => 1,
                'built_at'     => '2025-12-01',
            ],
            [
                'title'        => 'TRAVVEL',
                'description'  => 'Aplikasi mobile untuk menyimpan destinasi/wisata berbasis Flutter.',
                'tech_stack'   => ['Flutter', 'SQLite'],
                'category'     => 'Mobile App',
                'github_url'   => 'https://github.com/Arfwjn/TRAVVEL',
                'demo_url'     => null,
                'thumbnail'    => null,
                'is_featured'  => true,
                'is_published' => true,
                'sort_order'   => 2,
                'built_at'     => '2025-11-15',
            ],
            [
                'title'        => 'Warkop KUP!',
                'description'  => 'Website landing page kedai kopi Warkop KUP!.',
                'tech_stack'   => ['Tailwind CSS', 'JavaScript'],
                'category'     => 'Landing Page',
                'github_url'   => 'https://github.com/Arfwjn/kedai-kopi',
                'demo_url'     => null,
                'thumbnail'    => null,
                'is_featured'  => false,
                'is_published' => true,
                'sort_order'   => 3,
                'built_at'     => '2023-11-01',
            ],
        ];

        foreach ($projects as $data) {
            Project::firstOrCreate(['title' => $data['title']], $data);
        }

        $this->command->info('Seeder selesai! Login dengan: ariefsidik2016@gmail.com / ariefsidik123');
    }
}

