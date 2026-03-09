@extends('layouts.app')

@section('title', ($profile->full_name ?? 'Portofolio') . ' – Developer')

@push('styles')
<style>
    /* Global & Typography enhancements */
    body { background-color: #0f0f13; color: #f3f4f6; font-family: 'Inter', sans-serif; }
    section { padding: 6rem 2rem; max-width: 1100px; margin: 0 auto; }
    
    /* Hero Section */
    .hero { min-height: 90vh; display: flex; flex-direction: column; justify-content: center; padding: 5rem 2rem; max-width: 1100px; margin: 0 auto; position: relative; }
    .hero::before { content: ''; position: absolute; width: 300px; height: 300px; background: #7c3aed; filter: blur(150px); opacity: 0.15; z-index: -1; top: 10%; left: -5%; border-radius: 50%; }
    .hero h1 { font-size: clamp(2.5rem, 6vw, 4.5rem); font-weight: 800; line-height: 1.1; letter-spacing: -0.02em; }
    .hero h1 span { background: linear-gradient(135deg, #a78bfa, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .hero p { margin-top: 1.5rem; font-size: 1.15rem; color: #9ca3af; max-width: 600px; line-height: 1.8; }
    
    /* Buttons */
    .hero-btns { margin-top: 2.5rem; display: flex; gap: 1rem; flex-wrap: wrap; }
    .btn { padding: .8rem 2rem; border-radius: 99px; font-size: .95rem; font-weight: 600; cursor: pointer; border: none; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); display: inline-flex; align-items: center; gap: .6rem; text-decoration: none; }
    .btn-primary { background: #7c3aed; color: #fff; box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3); }
    .btn-primary:hover { background: #6d28d9; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(124, 58, 237, 0.4); }
    .btn-outline { background: rgba(255, 255, 255, 0.03); color: #e2e8f0; border: 1px solid rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); }
    .btn-outline:hover { border-color: #7c3aed; color: #fff; background: rgba(124, 58, 237, 0.1); transform: translateY(-2px); }
    
    /* Titles */
    h2.section-title { font-size: 2.2rem; font-weight: 800; margin-bottom: 3rem; position: relative; display: inline-block; }
    h2.section-title span { color: #7c3aed; }
    h2.section-title::after { content: ''; position: absolute; bottom: -10px; left: 0; width: 40%; height: 4px; background: #7c3aed; border-radius: 2px; }
    
    /* About */
    .about-grid { display: grid; grid-template-columns: 1fr auto; gap: 4rem; align-items: center; }
    .about-grid p { color: #d1d5db; line-height: 1.9; font-size: 1.05rem; }
    .about-meta { display: flex; flex-direction: column; gap: 1rem; margin-top: 2rem; background: rgba(255,255,255,0.02); padding: 1.5rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); }
    .about-meta span { display: flex; align-items: center; gap: 1rem; font-size: .95rem; color: #d1d5db; }
    .about-meta i { color: #a78bfa; width: 20px; font-size: 1.1rem; }
    
    /* Projects (Glassmorphism Cards) */
    .projects-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 2rem; }
    .project-card { background: rgba(17, 17, 17, 0.6); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.05); border-radius: 16px; overflow: hidden; transition: all 0.3s ease; position: relative; }
    .project-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, rgba(124, 58, 237, 0.5), transparent); opacity: 0; transition: opacity 0.3s; }
    .project-card:hover { transform: translateY(-8px); box-shadow: 0 12px 30px rgba(0,0,0,0.5); border-color: rgba(124, 58, 237, 0.3); }
    .project-card:hover::before { opacity: 1; }
    .project-card img { width: 100%; height: 200px; object-fit: cover; transition: transform 0.5s ease; }
    .project-card:hover img { transform: scale(1.05); }
    .project-card-no-img { width: 100%; height: 200px; background: linear-gradient(135deg, #1e1b4b, #312e81); display: flex; align-items: center; justify-content: center; font-size: 3.5rem; }
    .project-card-body { padding: 1.5rem; position: relative; background: #111; z-index: 1; }
    .project-card-body h3 { font-size: 1.2rem; font-weight: 700; margin-bottom: .75rem; color: #fff; }
    .project-card-body p { font-size: .9rem; color: #9ca3af; line-height: 1.6; margin-bottom: 1.25rem; }
    .tech-tags { display: flex; flex-wrap: wrap; gap: .5rem; margin-bottom: 1.5rem; }
    .tech-tag { background: rgba(124, 58, 237, 0.15); color: #c4b5fd; padding: .3rem .8rem; border-radius: 6px; font-size: .75rem; font-weight: 600; border: 1px solid rgba(124, 58, 237, 0.2); }
    
    /* Project Links */
    .project-links { display: flex; gap: 1rem; }
    .project-links a { font-size: .85rem; color: #fff; padding: .4rem 1rem; border-radius: 6px; transition: all .2s; background: rgba(255,255,255,0.05); text-decoration: none; font-weight: 500; }
    .project-links a:hover { background: #7c3aed; }
    
    /* Contact Form */
    .contact-form { max-width: 600px; background: rgba(255,255,255,0.02); padding: 2rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.05); }
    .contact-form input, .contact-form textarea { width: 100%; padding: .9rem 1.2rem; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #e0e0e0; font-size: .95rem; margin-bottom: 1.25rem; transition: all 0.2s; font-family: inherit; }
    .contact-form input:focus, .contact-form textarea:focus { outline: none; border-color: #7c3aed; background: rgba(124, 58, 237, 0.05); box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1); }
    .contact-form textarea { height: 150px; resize: vertical; }
    
    /* Socials */
    .social-links { display: flex; gap: 1rem; }
    .social-links a { display: flex; align-items: center; justify-content: center; width: 45px; height: 45px; border-radius: 50%; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); color: #9ca3af; font-size: 1.2rem; transition: all .3s ease; }
    .social-links a:hover { background: #7c3aed; color: #fff; border-color: #7c3aed; transform: translateY(-3px); box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3); }
    
    @media(max-width: 768px) { .about-grid { grid-template-columns: 1fr; gap: 2rem; } .social-links { flex-direction: row !important; margin-top: 1rem; } }
</style>
@endpush

@section('content')

{{-- ── HERO ─────────────────────────────────────────────────────── --}}
<div class="hero" id="hero">
    <div style="z-index: 1;">
        <h1>
            Halo, saya<br>
            <span>{{ $profile->full_name ?? 'Nama Developer' }}</span>
        </h1>
        <p>{{ $profile->subtitle ?? $profile->title ?? 'Full-Stack Developer yang bersemangat membangun solusi digital.' }}</p>
        <div class="hero-btns">
            <a href="#projects" class="btn btn-primary"><i class="fas fa-folder-open"></i> Lihat Proyek</a>
            <a href="#contact" class="btn btn-outline"><i class="fas fa-paper-plane"></i> Hubungi Saya</a>
            @if($profile?->resume_url)
                <a href="{{ $profile->resume_url }}" target="_blank" class="btn btn-outline">
                    <i class="fas fa-file-download"></i> Download CV
                </a>
            @endif
        </div>
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
                    <span><i class="fas fa-check-circle" style="color:#22c55e;"></i> Terbuka untuk peluang kerja</span>
                @endif
            </div>
        </div>
        <div class="social-links" style="flex-direction:column; gap:1rem">
            @if($profile?->github_url)
                <a href="{{ $profile->github_url }}" target="_blank" aria-label="GitHub"><i class="fab fa-github"></i></a>
            @endif
            @if($profile?->linkedin_url)
                <a href="{{ $profile->linkedin_url }}" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            @endif
            @if($profile?->twitter_url)
                <a href="{{ $profile->twitter_url }}" target="_blank" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            @endif
        </div>
    </div>
</section>

{{-- ── PROJECTS ─────────────────────────────────────────────────── --}}
<section id="projects">
    <h2 class="section-title">Proyek <span>Saya</span></h2>
    @if($projects->isEmpty())
        <div style="background: rgba(255,255,255,0.02); padding: 3rem; text-align: center; border-radius: 12px; border: 1px dashed rgba(255,255,255,0.1);">
            <i class="fas fa-laptop-code" style="font-size: 3rem; color: #4b5563; margin-bottom: 1rem;"></i>
            <p style="color:#9ca3af; margin:0;">Belum ada proyek yang dipublikasikan saat ini.</p>
        </div>
    @else
        <div class="projects-grid">
            @foreach($projects as $project)
            <div class="project-card">
                <div style="overflow: hidden;">
                    @if($project->thumbnail_url)
                        <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}" loading="lazy">
                    @else
                        <div class="project-card-no-img">💻</div>
                    @endif
                </div>
                <div class="project-card-body">
                    <h3>{{ $project->title }}</h3>
                    <p>{{ Str::limit($project->description, 110) }}</p>
                    
                    @if(is_array($project->tech_stack) && count($project->tech_stack))
                        <div class="tech-tags">
                            @foreach($project->tech_stack as $tech)
                                <span class="tech-tag">{{ trim($tech) }}</span>
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
        <div style="background: rgba(16, 185, 129, 0.1); color: #34d399; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 2rem; border: 1px solid rgba(16, 185, 129, 0.2); display: flex; align-items: center; gap: 0.75rem;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div style="background: rgba(239, 68, 68, 0.1); color: #f87171; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 2rem; border: 1px solid rgba(239, 68, 68, 0.2);">
            <ul style="margin:0; padding-left:1.5rem;">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form class="contact-form" method="POST" action="{{ route('contact.send') }}">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <input type="text"  name="name"    placeholder="Nama Lengkap"  value="{{ old('name') }}"    required style="margin-bottom:0;">
            <input type="email" name="email"   placeholder="Alamat Email" value="{{ old('email') }}"   required style="margin-bottom:0;">
        </div>
        <input type="text"  name="subject" placeholder="Subjek Pembicaraan"     value="{{ old('subject') }}" style="margin-top: 1.25rem;">
        <textarea           name="message" placeholder="Tulis pesan Anda di sini..." required>{{ old('message') }}</textarea>
        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
            <i class="fas fa-paper-plane"></i> Kirim Pesan Sekarang
        </button>
    </form>
</section>

@endsection