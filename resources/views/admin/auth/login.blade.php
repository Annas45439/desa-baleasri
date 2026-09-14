<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin — Desa Baleasri</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400..800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
<style>
  :root {
    --bg-start: #081821;
    --bg-end: #11263d;
    --panel: rgba(17, 34, 48, 0.84);
    --panel-border: rgba(148, 163, 184, 0.18);
    --soft-white: #edf4f7;
    --muted: #9db0bf;
    --primary: #7dd3c5;
    --primary-strong: #58b9af;
    --accent: #c8b6ff;
    --shadow: rgba(5, 12, 20, 0.4);
    --danger-soft: rgba(248, 113, 113, 0.12);
    --danger-text: #fecaca;
  }

  * { box-sizing: border-box; }

  body {
    margin: 0;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background:
      radial-gradient(circle at top left, rgba(125, 211, 197, 0.18), transparent 35%),
      radial-gradient(circle at bottom right, rgba(200, 182, 255, 0.18), transparent 28%),
      linear-gradient(135deg, var(--bg-start), var(--bg-end));
    font-family: "Plus Jakarta Sans", sans-serif;
    color: var(--soft-white);
  }

  .page-shell {
    width: min(100%, 1120px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 32px;
  }

  .login-card {
    width: min(100%, 460px);
    background: var(--panel);
    border: 1px solid var(--panel-border);
    border-radius: 28px;
    padding: 34px 30px 28px;
    box-shadow: 0 30px 60px var(--shadow), inset 0 1px 0 rgba(255,255,255,0.04);
    backdrop-filter: blur(10px);
  }

  .brand {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    margin-bottom: 18px;
    font-weight: 700;
    letter-spacing: 0.02em;
  }

  .brand-mark {
    width: 56px;
    height: 56px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #7dd3c5, #c8b6ff);
    color: #071a24;
    font-family: "Bricolage Grotesque", sans-serif;
    font-size: 1.7rem;
    font-weight: 800;
    box-shadow: 0 12px 24px rgba(125, 211, 197, 0.25);
  }

  .brand-logo {
    width: 56px;
    height: 56px;
    object-fit: contain;
    border-radius: 18px;
    background: #fff;
    padding: 4px;
    box-shadow: 0 12px 24px rgba(125, 211, 197, 0.25);
  }

  .brand-title {
    font-size: 1.05rem;
    color: rgba(237, 244, 247, 0.9);
  }

  .login-head {
    text-align: center;
    margin-bottom: 26px;
  }

  .login-head h1 {
    margin: 0;
    font-size: clamp(2rem, 4vw, 2.6rem);
    font-weight: 800;
    line-height: 1.15;
    font-family: "Bricolage Grotesque", sans-serif;
  }

  .login-head p {
    margin: 10px 0 0;
    color: var(--muted);
    font-size: 0.96rem;
  }

  .field {
    margin-bottom: 18px;
  }

  .field label {
    display: block;
    margin-bottom: 8px;
    color: rgba(237, 244, 247, 0.9);
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.02em;
  }

  .field input {
    width: 100%;
    border: 1px solid rgba(148, 163, 184, 0.22);
    background: rgba(255,255,255,0.97);
    color: #102030;
    border-radius: 14px;
    padding: 14px 16px;
    font-size: 0.95rem;
    transition: all 0.2s ease;
  }

  .field input:focus {
    outline: none;
    border-color: rgba(125, 211, 197, 0.9);
    box-shadow: 0 0 0 4px rgba(125, 211, 197, 0.18);
  }

  .remember {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 4px 0 22px;
    color: rgba(237, 244, 247, 0.9);
    font-size: 0.92rem;
    cursor: pointer;
  }

  .remember input {
    width: 16px;
    height: 16px;
    accent-color: #c8b6ff;
  }

  .btn-login {
    width: 100%;
    border: 0;
    border-radius: 14px;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    color: #0c1a25;
    padding: 14px 16px;
    font-size: 1rem;
    font-weight: 800;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    box-shadow: 0 12px 24px rgba(125, 211, 197, 0.2);
  }

  .btn-login:hover {
    transform: translateY(-1px);
    box-shadow: 0 18px 28px rgba(125, 211, 197, 0.28);
  }

  .err {
    background: var(--danger-soft);
    color: var(--danger-text);
    border: 1px solid rgba(248, 113, 113, 0.18);
    border-radius: 12px;
    padding: 11px 14px;
    margin-bottom: 18px;
    font-size: 0.86rem;
    font-weight: 600;
  }

  @media (max-width: 520px) {
    .page-shell { padding: 18px; }
    .login-card { padding: 24px 18px 20px; }
  }
</style>
</head>
<body>
  <div class="page-shell">
    <div class="login-card">
      <div class="brand">
        <img class="brand-logo" src="{{ asset('assets/logo/logo magetan.png') }}" alt="Logo Desa Baleasri">
        <div class="brand-title">Desa Baleasri</div>
      </div>

      <div class="login-head">
        <h1>Panel Admin</h1>
        <p>Masuk untuk mengelola situs Desa Baleasri.</p>
      </div>

      @if($errors->any())
        <div class="err">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('admin.login.attempt') }}">
        @csrf

        <div class="field">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="field">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
        </div>

        <label class="remember">
          <input type="checkbox" name="remember">
          <span>Ingat saya</span>
        </label>

        <button type="submit" class="btn-login">Masuk</button>

        <div style="display:flex; align-items:center; gap:12px; margin:20px 0;">
          <div style="flex:1; height:1px; background:rgba(255,255,255,0.12);"></div>
          <span style="font-size:0.75rem; color:var(--muted); text-transform:uppercase; letter-spacing:0.05em;">atau</span>
          <div style="flex:1; height:1px; background:rgba(255,255,255,0.12);"></div>
        </div>

        <a href="{{ route('auth.google') }}" style="display:flex; align-items:center; justify-content:center; gap:10px; width:100%; padding:13px 16px; border-radius:14px; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.18); color:#fff; font-weight:700; text-decoration:none; transition:all 0.2s ease;">
          <svg width="18" height="18" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/></svg>
          <span>Masuk / Daftar dengan Google</span>
        </a>
      </form>
    </div>
  </div>
</body>
</html>
