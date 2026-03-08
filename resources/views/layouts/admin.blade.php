<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin – @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #0f172a; color: #cbd5e1; display: flex; min-height: 100vh; }
        aside { width: 240px; background: #1e293b; display: flex; flex-direction: column; padding: 1.5rem 0; flex-shrink: 0; }
        aside .logo { padding: 0 1.5rem 1.5rem; font-size: 1.2rem; font-weight: 700; color: #7c3aed; border-bottom: 1px solid #334155; }
        aside nav { padding: 1rem 0; flex: 1; }
        aside nav a { display: flex; align-items: center; gap: .75rem; padding: .65rem 1.5rem; color: #94a3b8; font-size: .9rem; transition: all .2s; }
        aside nav a:hover, aside nav a.active { background: #334155; color: #e2e8f0; }
        aside nav a i { width: 16px; }
        aside .logout-btn { padding: 1rem 1.5rem; border-top: 1px solid #334155; }
        aside .logout-btn form button { background: none; border: none; color: #94a3b8; cursor: pointer; display: flex; align-items: center; gap: .75rem; font-size: .9rem; padding: .5rem 0; width: 100%; }
        aside .logout-btn form button:hover { color: #f87171; }
        .main-wrapper { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        header { background: #1e293b; padding: .75rem 2rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #334155; }
        header h1 { font-size: 1.1rem; font-weight: 600; }
        header span { font-size: .85rem; color: #94a3b8; }
        .content { padding: 2rem; flex: 1; overflow-y: auto; }
        .alert-success { background: #064e3b; color: #6ee7b7; padding: .75rem 1.25rem; border-radius: 8px; margin-bottom: 1.5rem; }
        .alert-error   { background: #7f1d1d; color: #fca5a5; padding: .75rem 1.25rem; border-radius: 8px; margin-bottom: 1.5rem; }
        .card { background: #1e293b; border-radius: 12px; padding: 1.5rem; border: 1px solid #334155; }
        .btn { display: inline-flex; align-items: center; gap: .5rem; padding: .5rem 1.25rem; border-radius: 8px; font-size: .9rem; cursor: pointer; border: none; transition: all .2s; }
        .btn-primary { background: #7c3aed; color: #fff; }
        .btn-primary:hover { background: #6d28d9; }
        .btn-danger  { background: #dc2626; color: #fff; }
        .btn-danger:hover { background: #b91c1c; }
        .btn-secondary { background: #334155; color: #e2e8f0; }
        .btn-secondary:hover { background: #475569; }
        table { width: 100%; border-collapse: collapse; font-size: .9rem; }
        th, td { padding: .75rem 1rem; text-align: left; border-bottom: 1px solid #334155; }
        th { color: #94a3b8; font-weight: 600; font-size: .8rem; text-transform: uppercase; }
        td a { color: #818cf8; }
        td a:hover { text-decoration: underline; }
        .form-group { margin-bottom: 1.25rem; }
        .form-group label { display: block; margin-bottom: .4rem; font-size: .85rem; color: #94a3b8; }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%; padding: .6rem .9rem; background: #0f172a; border: 1px solid #334155;
            border-radius: 8px; color: #e2e8f0; font-size: .9rem;
        }
        .form-group input:focus, .form-group textarea:focus { outline: none; border-color: #7c3aed; }
        .badge { padding: .2rem .6rem; border-radius: 999px; font-size: .75rem; font-weight: 600; }
        .badge-green  { background: #064e3b; color: #6ee7b7; }
        .badge-gray   { background: #334155; color: #94a3b8; }
        .badge-purple { background: #4c1d95; color: #c4b5fd; }
        .unread-row   { background: #1e2a3a; }
    </style>
    @stack('styles')
</head>
<body>

<aside>
    <div class="logo"><i class="fas fa-code"></i> Admin Panel</div>
    <nav>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="{{ route('admin.projects') }}" class="{{ request()->routeIs('admin.projects*') ? 'active' : '' }}">
            <i class="fas fa-folder-open"></i> Proyek
        </a>
        <a href="{{ route('admin.messages') }}" class="{{ request()->routeIs('admin.messages*') ? 'active' : '' }}">
            <i class="fas fa-envelope"></i> Pesan
        </a>
        <a href="{{ route('admin.profile.edit') }}" class="{{ request()->routeIs('admin.profile*') ? 'active' : '' }}">
            <i class="fas fa-user-circle"></i> Profil
        </a>
        <a href="{{ route('home') }}" target="_blank">
            <i class="fas fa-external-link-alt"></i> Lihat Website
        </a>
    </nav>
    <div class="logout-btn">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </form>
    </div>
</aside>

<div class="main-wrapper">
    <header>
        <h1>@yield('title', 'Dashboard')</h1>
        <span>Halo, {{ Auth::user()->name ?? 'Admin' }}</span>
    </header>
    <div class="content">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-error">
                <ul style="padding-left:1rem">
                    @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</div>

@stack('scripts')
</body>
</html>