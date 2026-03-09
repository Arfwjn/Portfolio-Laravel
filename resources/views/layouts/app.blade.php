<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portofolio')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --bg-body: #0a0a0a;
            --bg-nav: #111;
            --text-main: #e0e0e0;
            --accent: #7c3aed;
            --card-bg: #111;
            --border: #222;
        }
        body.light-mode {
            --bg-body: #f8fafc;
            --bg-nav: #ffffff;
            --text-main: #1e293b;
            --card-bg: #ffffff;
            --border: #e2e8f0;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; transition: background 0.3s, color 0.3s; }
        body { font-family: 'Segoe UI', sans-serif; background: var(--bg-body); color: var(--text-main); overflow-x: hidden; }
        nav { background: var(--bg-nav); padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 1000; border-bottom: 1px solid var(--border); }
        nav .brand { font-size: 1.4rem; font-weight: 700; color: var(--accent); }
        nav ul { list-style: none; display: flex; gap: 1.5rem; align-items: center; }
        .theme-toggle { cursor: pointer; font-size: 1.2rem; color: var(--accent); border: none; background: none; }
        footer { background: var(--bg-nav); text-align: center; padding: 2rem; color: #666; border-top: 1px solid var(--border); }
        
        /* Background Animation */
        .bg-objects { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; pointer-events: none; opacity: 0.15; }
        .floating-icon { position: absolute; font-size: 3rem; color: var(--accent); animation: float 10s infinite ease-in-out; }
        @keyframes float { 0%, 100% { transform: translateY(0) rotate(0); } 50% { transform: translateY(-20px) rotate(10deg); } }
    </style>
    @stack('styles')
</head>
<body class="{{ session('theme') === 'light' ? 'light-mode' : '' }}">
    <div class="bg-objects">
        <i class="fab fa-html5 floating-icon" style="top: 10%; left: 10%;"></i>
        <i class="fab fa-css3-alt floating-icon" style="top: 70%; left: 80%; animation-delay: 2s;"></i>
        <i class="fab fa-js floating-icon" style="top: 40%; left: 50%; animation-delay: 4s;"></i>
        <i class="fas fa-database floating-icon" style="top: 80%; left: 15%; animation-delay: 1s;"></i>
    </div>

    <nav>
        <a class="brand" href="{{ route('home') }}">
            {{ optional(App\Models\Profile::getSingle())->full_name ?? 'Portofolio' }}
        </a>
        <ul>
            <li><a href="{{ route('home') }}#about">Tentang</a></li>
            <li><a href="{{ route('home') }}#projects">Proyek</a></li>
            <li><button class="theme-toggle" onclick="toggleTheme()"><i class="fas fa-moon"></i></button></li>
            @auth
                <li><a href="{{ route('admin.dashboard') }}" class="btn-primary" style="padding: 0.5rem 1rem; border-radius: 5px;">Admin</a></li>
            @else
                <li><a href="{{ route('login') }}"><i class="fas fa-lock"></i></a></li>
            @endauth
        </ul>
    </nav>

    <main>@yield('content')</main>

    <footer>
        <p>&copy; {{ date('Y') }} {{ optional(App\Models\Profile::getSingle())->full_name }}. All rights reserved.</p>
    </footer>

    <script>
        function toggleTheme() {
            const isLight = document.body.classList.toggle('light-mode');
            fetch('{{ url("/toggle-theme") }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
            localStorage.setItem('theme', isLight ? 'light' : 'dark');
        }
    </script>
</body>
</html>