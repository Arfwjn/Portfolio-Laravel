@extends('layouts.app')

@section('title', ($profile->full_name ?? 'Portofolio') . ' – Developer')

@push('styles')
<style>
    section { padding: 5rem 2rem; max-width: 1100px; margin: 0 auto; }
    .hero { min-height: 90vh; display: flex; flex-direction: column; justify-content: center; padding: 5rem 2rem; max-width: 1100px; margin: 0 auto; }
    .hero h1 { font-size: clamp(2rem, 5vw, 4rem); font-weight: 800; line-height: 1.1; }
    .hero h1 span { color: #7c3aed; }
    .hero p { margin-top: 1.25rem; font-size: 1.1rem; color: #9ca3af; max-width: 550px; line-height: 1.7; }
    .hero-btns { margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap; }
    .btn { padding: .75rem 1.75rem; border-radius: 8px; font-size: .95rem; font-weight: 600; cursor: pointer; border: none; transition: all .2s; display: inline-flex; align-items: center; gap: .5rem; }
    .btn-primary { background: #7c3aed; color: #fff; }
    .btn-primary:hover { background: #6d28d9; }
    .btn-outline { background: transparent; color: #e2e8f0; border: 1px solid #374151; }
    .btn-outline:hover { border-color: #7c3aed; color: #7c3aed; }
    h2.section-title { font-size: 2rem; font-weight: 700; margin-bottom: 2.5rem; }
    h2.section-title span { color: #7c3aed; }
    .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center; }
    .about-grid p { color: #9ca3af; line-height: 1.8; }
    .about-meta { display: flex; flex-direction: column; gap: .75rem; margin-top: 1.5rem; }
    .about-meta span { display: flex; align-items: center; gap: .75rem; font-size: .9rem; color: #9ca3af; }
    .about-meta i { color: #7c3aed; width: 16px; }
    .projects-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem; }
    .project-card { background: #111; border: 1px solid #1f1f1f; border-radius: 12px; overflow: hidden; transition: transform .2s, border-color .2s; }
    .project-card:hover { transform: translateY(-4px); border-color: #7c3aed; }
    .project-card img { width: 100%; height: 180px; object-fit: cover; }
    .project-card-no-img { width: 100%; height: 180px; background: linear-gradient(135deg, #1e1b4b, #312e81); display: flex; align-items: center; justify-content: center; font-size: 3rem; }
    .project-card-body { padding: 1.25rem; }
    .project-card-body h3 { font-size: 1.05rem; font-weight: 600; margin-bottom: .5rem; }
    .project-card-body p { font-size: .85rem; color: #9ca3af; line-height: 1.6; margin-bottom: 1rem; }
    .tech-tags { display: flex; flex-wrap: wrap; gap: .4rem; margin-bottom: 1rem; }
    .tech-tag { background: #1e1b4b; color: #a5b4fc; padding: .2rem .6rem; border-radius: 999px; font-size: .75rem; }
    .project-links { display: flex; gap: .75rem; }
    .project-links a { font-size: .8rem; color: #7c3aed; border: 1px solid #7c3aed; padding: .3rem .8rem; border-radius: 6px; transition: all .2s; }
    .project-links a:hover { background: #7c3aed; color: #fff; }
    .contact-form { max-width: 600px; }
    .contact-form input, .contact-form textarea { width: 100%; padding: .7rem 1rem; background: #111; border: 1px solid #222; border-radius: 8px; color: #e0e0e0; font-size: .95rem; margin-bottom: 1rem; }
    .contact-form input:focus, .contact-form textarea:focus { outline: none; border-color: #7c3aed; }
    .contact-form textarea { height: 130px; resize: vertical; }
    .social-links { display: flex; gap: 1rem; margin-top: 1.5rem; }
    .social-links a { display: flex; align-items: center; justify-content: center; width: 42px; height: 42px; border-radius: 8px; background: #111; border: 1px solid #222; color: #9ca3af; font-size: 1.1rem; transition: all .2s; }
    .social-links a:hover { border-color: #7c3aed; color: #7c3aed; }
    @media(max-width: 768px) { .about-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')

{{-- ── HERO ─────────────────────────────────────────────────────── --}}
<div class="hero" id="hero">
    <h1>
        Halo, saya<br>
        <span>{{ $profile->full_name ?? 'Nama Developer' }}</span>
    </h1>
    <p>{{ $profile->subtitle ?? $profile->title ?? 'Full-Stack Developer yang bersemangat membangun solusi digital.' }}</p>
    <div class="hero-btns">
        <a href="#projects" class="btn btn-primary"><i class="fas fa-folder"></i> Lihat Proyek</a>
        <a href="#contact" class="btn btn-outline"><i class="fas fa-envelope"></i> Hubungi Saya</a>
        @if($profile?->resume_url)
            <a href="{{ $profile->resume_url }}" target="_blank" class="btn btn-outline">
                <i class="fas fa-download"></i> Download CV
            </a>
        @endif
    </div>
</div>

{{-- ── ABOUT ────────────────────────────────────────────────────── --}}
<section id="about">
    <h2 class="section-title">Tentang <span>Saya</span></h2>
    <div class="about-grid">
        <div>
            <p>{{ $profile->bio ?? 'Belum ada deskripsi profil.' }}</p>
            <div class="about-meta">
                @if($profile?->location)
                    <span><i class="fas fa-map-marker-alt"></i> {{ $profile->location }}</span>
                @endif
                @if($profile?->education)
                    <span><i class="fas fa-graduation-cap"></i> {{ $profile->education }}</span>
                @endif
                @if($profile?->experience_years)
                    <span><i class="fas fa-briefcase"></i> {{ $profile->experience_years }} pengalaman</span>
                @endif
                @if($profile?->is_open_to_work)
                    <span><i class="fas fa-circle" style="color:#22c55e;font-size:.6rem"></i> Terbuka untuk peluang kerja</span>
                @endif
            </div>
        </div>
        <div class="social-links" style="flex-direction:column;justify-content:flex-start;gap:.75rem">
            @if($profile?->github_url)
                <a href="{{ $profile->github_url }}" target="_blank"><i class="fab fa-github"></i></a>
            @endif
            @if($profile?->linkedin_url)
                <a href="{{ $profile->linkedin_url }}" target="_blank"><i class="fab fa-linkedin"></i></a>
            @endif
            @if($profile?->twitter_url)
                <a href="{{ $profile->twitter_url }}" target="_blank"><i class="fab fa-twitter"></i></a>
            @endif
        </div>
    </div>
</section>

{{-- ── PROJECTS ─────────────────────────────────────────────────── --}}
<section id="projects">
    <h2 class="section-title">Proyek <span>Saya</span></h2>
    @if($projects->isEmpty())
        <p style="color:#6b7280">Belum ada proyek yang dipublikasikan.</p>
    @else
        <div class="projects-grid">
            @foreach($projects as $project)
            <div class="project-card">
                @if($project->thumbnail_url)
                    <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}">
                @else
                    <div class="project-card-no-img">💻</div>
                @endif
                <div class="project-card-body">
                    <h3>{{ $project->title }}</h3>
                    <p>{{ Str::limit($project->description, 100) }}</p>
                    @if(is_array($project->tech_stack) && count($project->tech_stack))
                        <div class="tech-tags">
                            @foreach($project->tech_stack as $tech)
                                <span class="tech-tag">{{ $tech }}</span>
                            @endforeach
                        </div>
                    @endif
                    <div class="project-links">
                        @if($project->demo_url)
                            <a href="{{ $project->demo_url }}" target="_blank"><i class="fas fa-external-link-alt"></i> Demo</a>
                        @endif
                        @if($project->github_url)
                            <a href="{{ $project->github_url }}" target="_blank"><i class="fab fa-github"></i> Code</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</section>

{{-- ── CONTACT ──────────────────────────────────────────────────── --}}
<section id="contact">
    <h2 class="section-title">Hubungi <span>Saya</span></h2>

    @if(session('success'))
        <div style="background:#064e3b;color:#6ee7b7;padding:.9rem 1.25rem;border-radius:8px;margin-bottom:1.5rem">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div style="background:#7f1d1d;color:#fca5a5;padding:.9rem 1.25rem;border-radius:8px;margin-bottom:1.5rem">
            @foreach($errors->all() as $e) {{ $e }}<br> @endforeach
        </div>
    @endif

    <form class="contact-form" method="POST" action="{{ route('contact.send') }}">
        @csrf
        <input type="text"  name="name"    placeholder="Nama Anda"  value="{{ old('name') }}"    required>
        <input type="email" name="email"   placeholder="Email Anda" value="{{ old('email') }}"   required>
        <input type="text"  name="subject" placeholder="Subjek"     value="{{ old('subject') }}">
        <textarea           name="message" placeholder="Pesan Anda..." required>{{ old('message') }}</textarea>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-paper-plane"></i> Kirim Pesan
        </button>
    </form>
</section>

@endsection