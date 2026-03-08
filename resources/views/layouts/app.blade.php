<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portofolio')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #0a0a0a; color: #e0e0e0; }
        a { color: inherit; text-decoration: none; }
        nav { background: #111; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 100; border-bottom: 1px solid #222; }
        nav .brand { font-size: 1.4rem; font-weight: 700; color: #7c3aed; }
        nav ul { list-style: none; display: flex; gap: 2rem; }
        nav ul a { font-size: 0.95rem; transition: color .2s; }
        nav ul a:hover { color: #7c3aed; }
        footer { background: #111; text-align: center; padding: 2rem; color: #666; font-size: 0.85rem; border-top: 1px solid #222; }
        .alert-success { background: #064e3b; color: #6ee7b7; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 1.5rem; }
        .alert-error   { background: #7f1d1d; color: #fca5a5; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 1.5rem; }
    </style>
    @stack('styles')
</head>
<body>

<nav>
    <a class="brand" href="{{ route('home') }}">
        {{ optional(App\Models\Profile::getSingle())->full_name ?? 'Portofolio' }}
    </a>
    <ul>
        <li><a href="{{ route('home') }}#about">Tentang</a></li>
        <li><a href="{{ route('home') }}#projects">Proyek</a></li>
        <li><a href="{{ route('home') }}#contact">Kontak</a></li>
    </ul>
</nav>

<main>
    @yield('content')
</main>

<footer>
    <p>&copy; {{ date('Y') }}
        {{ optional(App\Models\Profile::getSingle())->full_name ?? 'Portfolio' }}.
        All rights reserved.
    </p>
</footer>

@stack('scripts')
</body>
</html>