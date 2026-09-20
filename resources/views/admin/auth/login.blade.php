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
    --bg-dark: #070D18;
    --emerald: #10B981;
    --emerald-deep: #059669;
    --violet: #818CF8;
    --sky: #38BDF8;
    --ink: #F0F4FC;
    --ink-muted: #94A3B8;
    --glass-bg: rgba(15, 23, 42, 0.55);
    --glass-border: rgba(255, 255, 255, 0.14);
    --glass-border-focus: rgba(16, 185, 129, 0.6);
    --glass-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6), inset 0 1px 1px rgba(255, 255, 255, 0.15);
  }

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    min-height: 100vh;
    min-height: 100dvh;
    background-color: var(--bg-dark);
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--ink);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow-x: hidden;
    padding: 20px 16px;
  }

  /* Animated Ambient Background Glows */
  .bg-orb {
    position: fixed;
    border-radius: 50%;
    filter: blur(90px);
    pointer-events: none;
    z-index: 0;
    opacity: 0.65;
    animation: orbPulse 8s ease-in-out infinite alternate;
  }

  .orb-1 {
    top: -100px;
    left: -100px;
    width: 380px;
    height: 380px;
    background: radial-gradient(circle, rgba(16, 185, 129, 0.35), transparent 70%);
  }

  .orb-2 {
    bottom: -120px;
    right: -120px;
    width: 440px;
    height: 440px;
    background: radial-gradient(circle, rgba(129, 140, 248, 0.35), transparent 70%);
    animation-delay: -4s;
  }

  .orb-3 {
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(56, 189, 248, 0.2), transparent 70%);
    animation: orbFloat 12s ease-in-out infinite alternate;
  }

  @keyframes orbPulse {
    0% { transform: scale(1) translateY(0); opacity: 0.55; }
    100% { transform: scale(1.18) translateY(20px); opacity: 0.75; }
  }

  @keyframes orbFloat {
    0% { transform: translate(-50%, -50%) scale(0.9); }
    100% { transform: translate(-45%, -55%) scale(1.2); }
  }

  /* Main Shell */
  .page-shell {
    width: 100%;
    max-width: 440px;
    position: relative;
    z-index: 10;
    animation: cardEntrance 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  }

  @keyframes cardEntrance {
    0% { opacity: 0; transform: translateY(32px) scale(0.95); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
  }

  /* Glassmorphism Card Container */
  .glass-card {
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    backdrop-filter: blur(24px) saturate(180%);
    -webkit-backdrop-filter: blur(24px) saturate(180%);
    border-radius: 28px;
    padding: 36px 32px 30px;
    box-shadow: var(--glass-shadow);
    transition: transform 0.3s ease, border-color 0.3s ease;
  }

  .glass-card:hover {
    border-color: rgba(255, 255, 255, 0.22);
  }

  /* Header Brand */
  .brand {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    margin-bottom: 20px;
  }

  .brand-logo {
    width: 46px;
    height: 46px;
    object-fit: contain;
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.95);
    padding: 3px;
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.25);
    transition: transform 0.3s ease;
  }

  .brand:hover .brand-logo {
    transform: rotate(5deg) scale(1.05);
  }

  .brand-txt {
    font-family: 'Bricolage Grotesque', sans-serif;
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--ink);
    letter-spacing: -0.01em;
  }

  .brand-txt small {
    display: block;
    font-size: 0.65rem;
    font-weight: 600;
    color: var(--ink-muted);
    text-transform: uppercase;
    letter-spacing: 0.08em;
  }

  .login-head {
    text-align: center;
    margin-bottom: 28px;
  }

  .login-head h1 {
    font-family: 'Bricolage Grotesque', sans-serif;
    font-size: 1.85rem;
    font-weight: 800;
    color: var(--ink);
    background: linear-gradient(135deg, #FFFFFF 30%, var(--emerald) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .login-head p {
    font-size: 0.86rem;
    color: var(--ink-muted);
    margin-top: 6px;
  }

  /* Form Controls */
  .field {
    margin-bottom: 18px;
  }

  .field label {
    display: block;
    font-size: 0.8rem;
    font-weight: 700;
    margin-bottom: 8px;
    color: var(--ink);
    letter-spacing: 0.01em;
  }

  .input-wrap {
    position: relative;
    display: flex;
    align-items: center;
  }

  .input-wrap input {
    width: 100%;
    padding: 13px 16px;
    background: rgba(255, 255, 255, 0.06);
    border: 1px solid var(--glass-border);
    border-radius: 14px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.92rem;
    color: var(--ink);
    outline: none;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .password-wrap input {
    padding-right: 52px;
  }

  .password-toggle {
    position: absolute;
    right: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    border: 0;
    border-radius: 9px;
    background: transparent;
    color: var(--ink-muted);
    cursor: pointer;
  }

  .password-toggle:hover,
  .password-toggle:focus-visible {
    color: var(--emerald);
    background: rgba(16, 185, 129, 0.12);
    outline: none;
  }

  .password-toggle svg {
    width: 18px;
    height: 18px;
  }

  .input-wrap input::placeholder {
    color: rgba(148, 163, 184, 0.5);
  }

  .input-wrap input:focus {
    background: rgba(255, 255, 255, 0.1);
    border-color: var(--emerald);
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.18), 0 0 20px rgba(16, 185, 129, 0.15);
    transform: translateY(-2px);
  }

  .remember-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 6px 0 24px;
  }

  .remember-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.84rem;
    color: var(--ink-muted);
    cursor: pointer;
    user-select: none;
    transition: color 0.18s ease;
  }

  .remember-label:hover { color: var(--ink); }

  .remember-label input[type=checkbox] {
    width: 17px;
    height: 17px;
    border-radius: 5px;
    accent-color: var(--emerald);
    cursor: pointer;
  }

  /* Glass Buttons */
  .btn-submit {
    width: 100%;
    padding: 13px 20px;
    border: none;
    border-radius: 14px;
    background: linear-gradient(135deg, var(--emerald) 0%, var(--emerald-deep) 100%);
    color: #FFFFFF;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.95rem;
    font-weight: 800;
    cursor: pointer;
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.35);
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
  }

  .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 32px rgba(16, 185, 129, 0.45);
  }

  .btn-submit:active {
    transform: scale(0.98);
  }

  .divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 22px 0;
  }

  .divider::before, .divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: rgba(255, 255, 255, 0.12);
  }

  .divider span {
    font-size: 0.72rem;
    color: var(--ink-muted);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    font-weight: 700;
  }

  .btn-google {
    width: 100%;
    padding: 12px 18px;
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.06);
    border: 1px solid var(--glass-border);
    color: var(--ink);
    font-size: 0.88rem;
    font-weight: 700;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.22s ease;
  }

  .btn-google:hover {
    background: rgba(255, 255, 255, 0.12);
    border-color: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px);
  }

  .err-alert {
    background: rgba(244, 63, 94, 0.15);
    border: 1px solid rgba(244, 63, 94, 0.3);
    color: #FECDD3;
    border-radius: 14px;
    padding: 12px 16px;
    margin-bottom: 20px;
    font-size: 0.84rem;
    font-weight: 600;
    animation: shakeAlert 0.4s ease;
  }

  @keyframes shakeAlert {
    0%, 100% { transform: translateX(0); }
    20%, 60% { transform: translateX(-6px); }
    40%, 80% { transform: translateX(6px); }
  }

  /* Responsive Rules for HP / Mobile */
  @media (max-width: 480px) {
    body { padding: 14px 12px; }
    .glass-card {
      padding: 28px 20px 24px;
      border-radius: 24px;
    }
    .login-head h1 { font-size: 1.55rem; }
    .brand-logo { width: 40px; height: 40px; }
    .btn-submit { padding: 12px 16px; font-size: 0.9rem; }
  }
</style>
</head>
<body>

  <!-- Ambient Animated Glass Orbs -->
  <div class="bg-orb orb-1"></div>
  <div class="bg-orb orb-2"></div>
  <div class="bg-orb orb-3"></div>

  <div class="page-shell">
    <div class="glass-card">
      <div class="brand">
        <img class="brand-logo" src="{{ asset('assets/logo/logo magetan.png') }}" alt="Logo Desa Baleasri">
        <div class="brand-txt">Baleasri<small>Panel Admin</small></div>
      </div>

      <div class="login-head">
        <h1>Selamat Datang</h1>
        <p>Masuk ke akun admin untuk mengelola situs desa.</p>
      </div>

      @if($errors->any())
        <div class="err-alert">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('admin.login.attempt') }}">
        @csrf

        <div class="field">
          <label for="email">Email</label>
          <div class="input-wrap">
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="admin@baleasri.desa.id" required autofocus>
          </div>
        </div>

        <div class="field">
          <label for="password">Password</label>
          <div class="input-wrap password-wrap">
            <input type="password" id="password" name="password" placeholder="••••••••" required>
            <button type="button" class="password-toggle" id="passwordToggle"
                    aria-label="Tampilkan password" aria-pressed="false">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M2 12s3.5-6.5 10-6.5S22 12 22 12s-3.5 6.5-10 6.5S2 12 2 12Z"></path>
                <circle cx="12" cy="12" r="2.6"></circle>
              </svg>
            </button>
          </div>
        </div>

        <div class="remember-row">
          <label class="remember-label">
            <input type="checkbox" name="remember">
            <span>Ingat saya</span>
          </label>
        </div>

        <button type="submit" class="btn-submit">
          <span>Masuk ke Panel</span>
          <svg class="icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>

        <div class="divider">
          <span>atau</span>
        </div>

        <a href="{{ route('auth.google') }}" class="btn-google">
          <svg width="18" height="18" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/></svg>
          <span>Masuk dengan Google</span>
        </a>
      </form>
    </div>
  </div>

<script>
  document.getElementById('passwordToggle')?.addEventListener('click', function () {
    const password = document.getElementById('password');
    const visible = password.type === 'text';

    password.type = visible ? 'password' : 'text';
    this.setAttribute('aria-pressed', String(!visible));
    this.setAttribute('aria-label', visible ? 'Tampilkan password' : 'Sembunyikan password');
  });
</script>

</body>
</html>
