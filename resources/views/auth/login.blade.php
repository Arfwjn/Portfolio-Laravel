<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: #0f172a; color: #e2e8f0; font-family: 'Segoe UI', sans-serif;
               display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .box { background: #1e293b; border: 1px solid #334155; border-radius: 16px;
               padding: 2.5rem; width: 100%; max-width: 420px; }
        h1 { text-align: center; font-size: 1.5rem; margin-bottom: .5rem; color: #7c3aed; }
        p.sub { text-align: center; font-size: .85rem; color: #94a3b8; margin-bottom: 2rem; }
        label { display: block; font-size: .85rem; color: #94a3b8; margin-bottom: .35rem; }
        input { width: 100%; padding: .65rem .9rem; background: #0f172a; border: 1px solid #334155;
                border-radius: 8px; color: #e2e8f0; font-size: .95rem; margin-bottom: 1.25rem; }
        input:focus { outline: none; border-color: #7c3aed; }
        .remember { display: flex; align-items: center; gap: .5rem; margin-bottom: 1.5rem; font-size: .85rem; color: #94a3b8; }
        .remember input { width: auto; margin: 0; }
        button { width: 100%; padding: .75rem; background: #7c3aed; color: #fff; border: none;
                 border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: background .2s; }
        button:hover { background: #6d28d9; }
        .error { background: #7f1d1d; color: #fca5a5; padding: .75rem 1rem; border-radius: 8px;
                 margin-bottom: 1.25rem; font-size: .85rem; }
    </style>
</head>
<body>
<div class="box">
    <h1>🔒 Admin Login</h1>
    <p class="sub">Masuk ke panel administrasi</p>

    @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $e) {{ $e }}<br> @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}">
        @csrf
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <div class="remember">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember" style="margin:0">Ingat saya</label>
        </div>

        <button type="submit">Masuk</button>
    </form>
</div>
</body>
</html>