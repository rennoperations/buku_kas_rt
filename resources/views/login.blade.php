<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Masuk — Kas Digital RT</title>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;1,9..144,400;1,9..144,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --navy:      #0B2545;
      --navy-2:    #13406e;
      --blue:      #1A6FE0;
      --blue-soft: #dbeafe;
      --teal:      #0DA880;
      --teal-soft: #d1fae5;
      --red:       #E53535;
      --red-soft:  #fef2f2;
      --ink:       #0D1B2A;
      --ink-2:     #3b556a;
      --ink-3:     #8fa3b8;
      --surface:   #F7F9FC;
      --white:     #FFFFFF;
      --border:    #dce4ef;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      min-height: 100dvh;
      display: grid;
      grid-template-columns: 1fr 1fr;
      background: var(--white);
      color: var(--ink);
    }

    /* ─── LEFT PANEL ─── */
    .auth-left {
      padding: 48px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: flex-start;
    }

    .auth-left-inner {
      max-width: 380px;
      width: 100%;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 9px;
      margin-bottom: 48px;
      text-decoration: none;
    }

    .brand-logo {
      width: 32px; height: 32px;
      border-radius: 8px;
      background: var(--navy);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }

    .brand-name {
      font-family: 'Fraunces', serif;
      font-size: 17px;
      font-weight: 600;
      letter-spacing: -0.01em;
      color: var(--navy);
    }

    .auth-title {
      font-family: 'Fraunces', serif;
      font-size: 36px;
      font-weight: 600;
      color: var(--navy);
      line-height: 1.1;
      letter-spacing: -0.02em;
      margin-bottom: 8px;
    }

    .auth-sub {
      font-size: 15px;
      font-weight: 400;
      color: var(--ink-3);
      margin-bottom: 30px;
    }

    .auth-sub a {
      color: var(--blue);
      font-weight: 500;
      text-decoration: none;
    }

    .auth-sub a:hover { text-decoration: underline; }

    /* Alert */
    .alert-error {
      background: var(--red-soft);
      border: 1px solid rgba(229,53,53,.2);
      border-radius: 10px;
      padding: 11px 15px;
      font-size: 14px;
      color: #991b1b;
      margin-bottom: 18px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    /* Success alert */
    .alert-success {
      background: #ECFDF5;
      border: 1px solid rgba(16, 185, 129, 0.3);
      border-radius: 10px;
      padding: 11px 15px;
      font-size: 14px;
      color: #047857;
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
      letter-spacing: .04em;
      text-transform: uppercase;
      color: var(--ink-2);
      margin-bottom: 8px;
    }

    .field input {
      width: 100%;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 13px 16px;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 15px;
      color: var(--ink);
      outline: none;
      background: var(--white);
      transition: border-color .2s, box-shadow .2s;
    }

    .field input:focus {
      border-color: var(--blue);
      box-shadow: 0 0 0 3px rgba(26,111,224,.1);
    }

    .field input.is-invalid { border-color: var(--red); }

    .field-error {
      font-size: 12px;
      color: var(--red);
      margin-top: 5px;
    }

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
      font-size: 14px;
      color: var(--ink-2);
      cursor: pointer;
    }

    .btn-auth {
      width: 100%;
      padding: 14px;
      background: var(--navy);
      color: #fff;
      border: none;
      border-radius: 11px;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 15px;
      font-weight: 700;
      cursor: pointer;
      transition: background .2s, transform .15s;
      box-shadow: 0 4px 16px rgba(11,37,69,.2);
      margin-bottom: 14px;
      letter-spacing: 0.01em;
    }

    .btn-auth:hover { background: var(--navy-2); transform: translateY(-1px); }
    .btn-auth:active { transform: translateY(0); }

    .divider {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 14px;
    }

    .divider-line { flex: 1; height: 1px; background: var(--border); }
    .divider span { font-size: 13px; color: var(--ink-3); }

    .demo-box {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 12px 14px;
    }

    .demo-title {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: .08em;
      text-transform: uppercase;
      color: var(--ink-3);
      margin-bottom: 8px;
    }

    .demo-item {
      font-size: 13.5px;
      color: var(--ink-2);
      line-height: 1.9;
    }

    .demo-item strong { color: var(--navy); }

    /* ─── RIGHT PANEL ─── */
    .auth-right {
      background: var(--navy);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 60px 48px;
      position: relative;
      overflow: hidden;
    }

    .auth-right::before {
      content: '';
      position: absolute; top: -120px; right: -80px;
      width: 300px; height: 300px; border-radius: 50%;
      background: radial-gradient(circle, rgba(26,111,224,.2) 0%, transparent 70%);
    }

    .auth-right::after {
      content: '';
      position: absolute; bottom: -80px; left: -60px;
      width: 240px; height: 240px; border-radius: 50%;
      background: radial-gradient(circle, rgba(13,168,128,.15) 0%, transparent 70%);
    }

    .auth-right-inner {
      position: relative; z-index: 1;
      max-width: 320px; width: 100%;
    }

    .right-title {
      font-family: 'Fraunces', serif;
      font-size: 32px;
      font-weight: 600;
      color: #fff;
      line-height: 1.15;
      letter-spacing: -0.02em;
      margin-bottom: 12px;
    }

    .right-desc {
      font-size: 15px;
      color: rgba(255,255,255,.45);
      line-height: 1.65;
      margin-bottom: 36px;
    }

    .feat-list {
      display: flex;
      flex-direction: column;
      gap: 14px;
      margin-bottom: 36px;
    }

    .feat-item {
      display: flex;
      align-items: flex-start;
      gap: 12px;
    }

    .feat-icon {
      width: 34px; height: 34px;
      border-radius: 9px;
      background: rgba(255,255,255,.08);
      border: 1px solid rgba(255,255,255,.1);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0; font-size: 16px;
    }

    .feat-title { font-size: 14.5px; font-weight: 600; color: rgba(255,255,255,.85); }
    .feat-desc  { font-size: 13px; color: rgba(255,255,255,.35); line-height: 1.5; }

    .testi {
      background: rgba(255,255,255,.05);
      border: 1px solid rgba(255,255,255,.09);
      border-radius: 14px;
      padding: 18px;
    }

    .testi-quote {
      font-family: 'Fraunces', serif;
      font-size: 16px;
      font-style: italic;
      color: rgba(255,255,255,.8);
      line-height: 1.65;
      margin-bottom: 14px;
    }

    .testi-quote .hl {
      background: rgba(245,158,11,.22);
      color: #fbbf24;
      border-radius: 3px;
      padding: 0 3px;
    }

    .testi-author {
      display: flex; align-items: center; gap: 10px;
    }

    .testi-avatar {
      width: 34px; height: 34px; border-radius: 50%;
      background: linear-gradient(135deg, #1a6fe0, #0da880);
      display: flex; align-items: center; justify-content: center;
      font-size: 12px; color: #fff; font-weight: 700;
      flex-shrink: 0;
    }

    .testi-name { font-size: 14px; font-weight: 600; color: rgba(255,255,255,.75); }
    .testi-role { font-size: 12.5px; color: rgba(255,255,255,.35); }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 768px) {
      body { grid-template-columns: 1fr; }
      .auth-right { display: none; }
      .auth-left { padding: 48px 24px; }
      .auth-left-inner { max-width: 100%; }
    }
  </style>
</head>
<body>

  <!-- Left: Form -->
  <div class="auth-left">
    <div class="auth-left-inner">

      <a href="{{ url('/') }}" class="brand">
        <div class="brand-logo">
          <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
            <polyline points="9 22 9 12 15 12 15 22"/>
          </svg>
        </div>
        <span class="brand-name">Kas Digital RT</span>
      </a>

      <h1 class="auth-title">Selamat datang<br>kembali 👋</h1>
      <p class="auth-sub">
        Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
      </p>

      {{-- Notifikasi Sukses --}}
    @if (session('success'))
      <div class="alert-success">
        <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        {{ session('success') }}
      </div>
    @endif
    
    {{-- Error dari Laravel --}}
      @if ($errors->any())
        <div class="alert-error">
          <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
          </svg>
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="field">
          <label for="email">Alamat Email</label>
          <input type="email"
                 id="email"
                 name="email"
                 value="{{ old('email') }}"
                 placeholder="nama@email.com"
                 class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
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
                 class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                 required>
          @error('password')
            <div class="field-error">{{ $message }}</div>
          @enderror
        </div>

        <div class="remember-row">
          <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
          <label for="remember">Ingat saya selama 30 hari</label>
        </div>

        <button type="submit" class="btn-auth">Masuk ke Sistem</button>
      </form>

      <div class="divider">
        <div class="divider-line"></div>
        <span>Akun Demo</span>
        <div class="divider-line"></div>
      </div>

      <div class="demo-box">
        <div class="demo-title">Coba tanpa daftar</div>
        <div class="demo-item">
          <strong>Bendahara:</strong> bendahara@kasrt.com / bendahara123<br>
          <strong>Warga:</strong> siti@kasrt.com / warga123
        </div>
      </div>

    </div>
  </div>

  <!-- Right: Visual panel -->
  <div class="auth-right">
    <div class="auth-right-inner">

      <h2 class="right-title">Kelola kas RT dengan lebih mudah</h2>
      <p class="right-desc">Ribuan bendahara dan warga sudah menggunakan Kas Digital RT untuk pengelolaan iuran yang transparan.</p>

      <div class="feat-list">
        <div class="feat-item">
          <div class="feat-icon">🤖</div>
          <div>
            <div class="feat-title">Verifikasi AI otomatis</div>
            <div class="feat-desc">Upload bukti transfer, AI langsung baca nominal</div>
          </div>
        </div>
        <div class="feat-item">
          <div class="feat-icon">📊</div>
          <div>
            <div class="feat-title">Laporan real-time</div>
            <div class="feat-desc">Saldo dan pengeluaran terpantau kapan saja</div>
          </div>
        </div>
        <div class="feat-item">
          <div class="feat-icon">🔔</div>
          <div>
            <div class="feat-title">Notifikasi otomatis</div>
            <div class="feat-desc">Pengingat jatuh tempo tanpa WhatsApp manual</div>
          </div>
        </div>
      </div>

      <div class="testi">
        <div class="testi-quote">
          "Dulu bendahara harus manual cek transfer satu-satu. Sekarang <span class="hl">AI langsung verifikasi otomatis</span> — hemat 2 jam tiap bulan."
        </div>
        <div class="testi-author">
          <div class="testi-avatar">AH</div>
          <div>
            <div class="testi-name">Pak Ahmad Hidayat</div>
            <div class="testi-role">Bendahara RT 05 Griya Asri</div>
          </div>
        </div>
      </div>

    </div>
  </div>

</body>
</html>