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
  body{display:flex; align-items:center; justify-content:center; min-height:100vh;}
  .login-card{
    background:var(--card); border:1px solid var(--line); border-radius:24px;
    padding:40px 36px; width:100%; max-width:380px; box-shadow:0 20px 50px rgba(18,32,27,0.08);
  }
  .login-mark{
    width:48px; height:48px; border-radius:14px; margin-bottom:18px;
    background:linear-gradient(135deg, var(--teal), var(--violet));
    display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800; font-family:var(--font-display); font-size:1.3rem;
  }
  .login-card h1{font-family:var(--font-display); font-weight:800; font-size:1.4rem; margin-bottom:4px;}
  .login-card p.sub{color:var(--text-muted); font-size:0.85rem; margin-bottom:28px;}
  .field{margin-bottom:16px;}
  .field label{display:block; font-size:0.8rem; font-weight:700; margin-bottom:6px;}
  .field input{
    width:100%; padding:12px 14px; border-radius:12px; border:1px solid var(--line);
    font-family:var(--font-body); font-size:0.9rem; background:#FBFAF7;
  }
  .field input:focus{outline:2px solid var(--teal); border-color:var(--teal);}
  .remember{display:flex; align-items:center; gap:8px; font-size:0.82rem; margin-bottom:20px;}
  .btn-login{
    width:100%; background:var(--ink); color:#fff; padding:13px; border:none; border-radius:12px;
    font-weight:700; font-size:0.92rem; cursor:pointer; font-family:var(--font-body);
  }
  .btn-login:hover{background:var(--teal-deep);}
  .err{background:var(--coral-soft); color:var(--coral); border-radius:10px; padding:10px 14px; font-size:0.82rem; margin-bottom:18px; font-weight:600;}
</style>
</head>
<body>
  <div class="login-card">
    <div class="login-mark">B</div>
    <h1>Panel Admin</h1>
    <p class="sub">Masuk untuk mengelola situs Desa Baleasri.</p>

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
        <input type="checkbox" name="remember"> Ingat saya
      </label>
      <button type="submit" class="btn-login">Masuk</button>
    </form>
  </div>
</body>
</html>
