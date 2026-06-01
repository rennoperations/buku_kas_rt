<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Login — Kas Digital RT</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=Geist:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --navy:      #0F2A4A;
      --navy-mid:  #1A3D6B;
      --blue:      #1E6FD9;
      --blue-soft: #E8F1FB;
      --teal:      #0EA882;
      --red:       #E53535;
      --red-soft:  #FDE8E8;
      --ink:       #0D1B2A;
      --ink-mid:   #4A6074;
      --ink-soft:  #8FA3B8;
      --surface:   #F4F7FB;
      --white:     #FFFFFF;
      --border:    #DDE6F0;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Geist', sans-serif;
      background: var(--navy);
      min-height: 100dvh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 24px 16px;
      position: relative;
      overflow: hidden;
    }

    /* Decorative circles */
    body::before {
      content: '';
      position: absolute;
      top: -80px; right: -80px;
      width: 300px; height: 300px;
      border-radius: 50%;
      background: rgba(30,111,217,.15);
    }

    body::after {
      content: '';
      position: absolute;
      bottom: -60px; left: -60px;
      width: 220px; height: 220px;
      border-radius: 50%;
      background: rgba(14,168,130,.1);
    }

    /* Brand */
    .brand {
      text-align: center;
      margin-bottom: 32px;
      position: relative;
      z-index: 1;
      animation: fadeDown .4s ease both;
    }

    @keyframes fadeDown {
      from { opacity: 0; transform: translateY(-12px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .brand-icon {
      width: 56px; height: 56px;
      background: var(--blue);
      border-radius: 16px;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 12px;
      box-shadow: 0 8px 24px rgba(30,111,217,.4);
    }

    .brand-name {
      font-family: 'Syne', sans-serif;
      font-size: 22px;
      font-weight: 700;
      color: #fff;
    }

    .brand-sub {
      font-size: 13px;
      color: rgba(255,255,255,.5);
      margin-top: 3px;
    }

    /* Card */
    .card {
      background: var(--white);
      border-radius: 20px;
      padding: 28px 24px 32px;
      width: 100%;
      max-width: 400px;
      position: relative;
      z-index: 1;
      box-shadow: 0 24px 60px rgba(0,0,0,.25);
      animation: slideUp .4s cubic-bezier(.22,.68,0,1.2) .1s both;
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(24px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .card-title {
      font-family: 'Syne', sans-serif;
      font-size: 20px;
      font-weight: 700;
      color: var(--navy);
      margin-bottom: 4px;
    }

    .card-sub {
      font-size: 13px;
      color: var(--ink-soft);
      margin-bottom: 24px;
    }

    /* Error alert */
    .alert-error {
      background: var(--red-soft);
      border: 1px solid rgba(229,53,53,.25);
      border-radius: 10px;
      padding: 10px 14px;
      font-size: 13px;
      color: #991B1B;
      margin-bottom: 16px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    /* Fields */
    .field { margin-bottom: 16px; }

    .field label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      letter-spacing: .05em;
      text-transform: uppercase;
      color: var(--ink-mid);
      margin-bottom: 7px;
    }

    .field input {
      width: 100%;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 13px 14px;
      font-family: 'Geist', sans-serif;
      font-size: 14px;
      color: var(--ink);
      outline: none;
      transition: border-color .2s, box-shadow .2s;
      background: var(--white);
    }

    .field input:focus {
      border-color: var(--blue);
      box-shadow: 0 0 0 3px rgba(30,111,217,.12);
    }

    .field input.error { border-color: var(--red); }

    .field-error {
      font-size: 12px;
      color: var(--red);
      margin-top: 5px;
    }

    /* Remember */
    .remember-row {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 20px;
    }

    .remember-row input[type=checkbox] {
      width: 16px; height: 16px;
      accent-color: var(--blue);
      cursor: pointer;
    }

    .remember-row label {
      font-size: 13px;
      color: var(--ink-mid);
      cursor: pointer;
    }

    /* Submit */
    .btn-login {
      width: 100%;
      padding: 14px;
      background: var(--navy);
      color: #fff;
      border: none;
      border-radius: 12px;
      font-family: 'Syne', sans-serif;
      font-size: 15px;
      font-weight: 700;
      cursor: pointer;
      transition: background .2s, transform .15s;
      box-shadow: 0 4px 16px rgba(15,42,74,.25);
    }

    .btn-login:hover   { background: var(--navy-mid); transform: translateY(-1px); }
    .btn-login:active  { transform: translateY(0); }

    /* Demo accounts info */
    .demo-box {
      margin-top: 20px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 12px 14px;
    }

    .demo-title {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: .06em;
      text-transform: uppercase;
      color: var(--ink-soft);
      margin-bottom: 8px;
    }

    .demo-item {
      font-size: 12px;
      color: var(--ink-mid);
      line-height: 1.8;
    }

    .demo-item strong { color: var(--navy); }

    .footer-text {
      text-align: center;
      font-size: 12px;
      color: rgba(255,255,255,.35);
      margin-top: 20px;
      position: relative;
      z-index: 1;
    }
  </style>
</head>
<body>

  <!-- Brand -->
  <div class="brand">
    <div class="brand-icon">
      <svg width="26" height="26" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
        <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
        <polyline points="9 22 9 12 15 12 15 22"/>
      </svg>
    </div>
    <div class="brand-name">Kas Digital RT</div>
    <div class="brand-sub">Sistem Iuran Warga Terintegrasi</div>
  </div>

  <!-- Card Login -->
  <div class="card">
    <div class="card-title">Selamat Datang 👋</div>
    <div class="card-sub">Masuk untuk melanjutkan ke sistem</div>

    {{-- Error dari Laravel --}}
    @if ($errors->any())
      <div class="alert-error">
        <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="/login">
      @csrf

      <div class="field">
        <label for="email">Email</label>
        <input type="email"
               id="email"
               name="email"
               value="{{ old('email') }}"
               placeholder="nama@kasrt.com"
               class="{{ $errors->has('email') ? 'error' : '' }}"
               required autofocus>
        @error('email')
          <div class="field-error">{{ $message }}</div>
        @enderror
      </div>

      <div class="field">
        <label for="password">Password</label>
        <input type="password"
               id="password"
               name="password"
               placeholder="••••••••"
               required>
      </div>

      <div class="remember-row">
        <input type="checkbox" id="remember" name="remember">
        <label for="remember">Ingat saya</label>
      </div>

      <button type="submit" class="btn-login">Masuk ke Sistem</button>
    </form>

    <!-- Info akun demo -->
    <div class="demo-box">
      <div class="demo-title">Akun Demo</div>
      <div class="demo-item">
        <strong>Bendahara:</strong> bendahara@kasrt.com / bendahara123<br>
        <strong>Warga:</strong> siti@kasrt.com / warga123
      </div>
    </div>
  </div>

  <div class="footer-text">Kas Digital RT © 2025</div>

</body>
</html>
