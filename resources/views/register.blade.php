<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Daftar Akun — Kas Digital RT</title>
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
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
      font-family: 'DM Sans', sans-serif;
      min-height: 100dvh;
      display: grid;
      grid-template-columns: 1fr 1fr;
      background: var(--white);
      color: var(--ink);
    }

    /* ─── LEFT PANEL ─── */
    .auth-left {
      padding: 40px 48px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: flex-start;
      overflow-y: auto;
    }

    .auth-left-inner {
      max-width: 400px;
      width: 100%;
      padding: 8px 0;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 9px;
      margin-bottom: 36px;
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
      font-family: 'Instrument Serif', serif;
      font-size: 16px;
      color: var(--navy);
    }

    .auth-title {
      font-family: 'Instrument Serif', serif;
      font-size: 30px;
      color: var(--navy);
      line-height: 1.15;
      margin-bottom: 6px;
    }

    .auth-sub {
      font-size: 14px;
      color: var(--ink-3);
      margin-bottom: 24px;
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
      padding: 10px 14px;
      font-size: 13px;
      color: #991b1b;
      margin-bottom: 18px;
      display: flex;
      align-items: flex-start;
      gap: 8px;
    }

    .alert-error ul {
      list-style: none;
      margin: 0; padding: 0;
    }

    .alert-error ul li { margin-bottom: 2px; }

    /* Fields */
    .field { margin-bottom: 14px; }

    .field-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
    }

    .field label {
      display: block;
      font-size: 11.5px;
      font-weight: 600;
      letter-spacing: .05em;
      text-transform: uppercase;
      color: var(--ink-2);
      margin-bottom: 7px;
    }

    .field input,
    .field select {
      width: 100%;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 12px 14px;
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      color: var(--ink);
      outline: none;
      background: var(--white);
      transition: border-color .2s, box-shadow .2s;
      appearance: none;
      -webkit-appearance: none;
    }

    .field input:focus,
    .field select:focus {
      border-color: var(--blue);
      box-shadow: 0 0 0 3px rgba(26,111,224,.1);
    }

    .field input.is-invalid,
    .field select.is-invalid { border-color: var(--red); }

    .field-error {
      font-size: 12px;
      color: var(--red);
      margin-top: 5px;
    }

    /* Select arrow */
    .select-wrap { position: relative; }

    .select-wrap::after {
      content: '';
      position: absolute;
      right: 14px; top: 50%;
      transform: translateY(-50%);
      width: 0; height: 0;
      border-left: 5px solid transparent;
      border-right: 5px solid transparent;
      border-top: 5px solid var(--ink-3);
      pointer-events: none;
    }

    /* Terms */
    .terms-row {
      display: flex;
      align-items: flex-start;
      gap: 9px;
      margin-bottom: 18px;
      margin-top: 4px;
    }

    .terms-row input {
      margin-top: 3px;
      flex-shrink: 0;
      width: 15px; height: 15px;
      accent-color: var(--blue);
      cursor: pointer;
    }

    .terms-row label {
      font-size: 12.5px;
      color: var(--ink-2);
      line-height: 1.55;
      cursor: pointer;
    }

    .terms-row a {
      color: var(--blue);
      text-decoration: none;
      font-weight: 500;
    }

    .terms-row a:hover { text-decoration: underline; }

    .btn-auth {
      width: 100%;
      padding: 13px;
      background: var(--navy);
      color: #fff;
      border: none;
      border-radius: 11px;
      font-family: 'DM Sans', sans-serif;
      font-size: 14.5px;
      font-weight: 600;
      cursor: pointer;
      transition: background .2s, transform .15s;
      box-shadow: 0 4px 16px rgba(11,37,69,.2);
    }

    .btn-auth:hover { background: var(--navy-2); transform: translateY(-1px); }
    .btn-auth:active { transform: translateY(0); }

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
      position: sticky;
      top: 0;
      height: 100dvh;
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
      font-family: 'Instrument Serif', serif;
      font-size: 28px;
      color: #fff;
      line-height: 1.2;
      margin-bottom: 10px;
    }

    .right-desc {
      font-size: 14px;
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

    .feat-title { font-size: 13.5px; font-weight: 600; color: rgba(255,255,255,.85); }
    .feat-desc  { font-size: 12px; color: rgba(255,255,255,.35); line-height: 1.5; }

    .testi {
      background: rgba(255,255,255,.05);
      border: 1px solid rgba(255,255,255,.09);
      border-radius: 14px;
      padding: 18px;
    }

    .testi-quote {
      font-family: 'Instrument Serif', serif;
      font-size: 15px;
      font-style: italic;
      color: rgba(255,255,255,.8);
      line-height: 1.6;
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
      background: linear-gradient(135deg, #7c3aed, #1a6fe0);
      display: flex; align-items: center; justify-content: center;
      font-size: 12px; color: #fff; font-weight: 700;
      flex-shrink: 0;
    }

    .testi-name { font-size: 13px; font-weight: 600; color: rgba(255,255,255,.75); }
    .testi-role { font-size: 11.5px; color: rgba(255,255,255,.35); }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 768px) {
      body { grid-template-columns: 1fr; }
      .auth-right { display: none; }
      .auth-left { padding: 48px 24px; }
      .auth-left-inner { max-width: 100%; }
      .field-row { grid-template-columns: 1fr; }
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

      <h1 class="auth-title">Buat akun baru</h1>
      <p class="auth-sub">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
      </p>

      {{-- Error dari Laravel --}}
      @if ($errors->any())
        <div class="alert-error">
          <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" style="flex-shrink:0;margin-top:1px">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
          </svg>
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="field-row">
          <div class="field">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text"
                   id="nama_lengkap"
                   name="name"
                   value="{{ old('name') }}"
                   placeholder="Ibu Siti Rahmawati"
                   class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                   required autofocus>
            @error('name')
              <div class="field-error">{{ $message }}</div>
            @enderror
          </div>

          <div class="field">
            <label for="nomor_rumah">No. Rumah / KK</label>
            <input type="text"
                   id="nomor_rumah"
                   name="no_rumah"
                   value="{{ old('no_rumah') }}"
                   placeholder="Blok A-12"
                   class="{{ $errors->has('no_rumah') ? 'is-invalid' : '' }}"
                   required>
            @error('no_rumah')
              <div class="field-error">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="field">
          <label for="email">Alamat Email</label>
          <input type="email"
                 id="email"
                 name="email"
                 value="{{ old('email') }}"
                 placeholder="nama@email.com"
                 class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                 required>
          @error('email')
            <div class="field-error">{{ $message }}</div>
          @enderror
        </div>

        <div class="field">
          <label for="nomor_hp">Nomor HP / WhatsApp</label>
          <input type="tel"
                 id="nomor_hp"
                 name="nomor_hp"
                 value="{{ old('nomor_hp') }}"
                 placeholder="08xxxxxxxxxx"
                 class="{{ $errors->has('nomor_hp') ? 'is-invalid' : '' }}"
                 required>
          @error('nomor_hp')
            <div class="field-error">{{ $message }}</div>
          @enderror
        </div>

        <div class="field-row">
          <div class="field">
            <label for="password">Password</label>
            <input type="password"
                   id="password"
                   name="password"
                   placeholder="Min. 8 karakter"
                   class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                   required minlength="8">
            @error('password')
              <div class="field-error">{{ $message }}</div>
            @enderror
          </div>

          <div class="field">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password"
                   id="password_confirmation"
                   name="password_confirmation"
                   placeholder="Ulangi password"
                   required>
          </div>
        </div>

        <div class="field">
          <label for="role">Daftar Sebagai</label>
          <div class="select-wrap">
            <select id="role"
                    name="role"
                    class="{{ $errors->has('role') ? 'is-invalid' : '' }}"
                    required>
              <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih peran Anda</option>
              <option value="warga"      {{ old('role') === 'warga'      ? 'selected' : '' }}>Warga RT</option>
              <option value="bendahara"  {{ old('role') === 'bendahara'  ? 'selected' : '' }}>Bendahara / Pengurus RT</option>
            </select>
          </div>
          @error('role')
            <div class="field-error">{{ $message }}</div>
          @enderror
        </div>

        <div class="terms-row">
          <input type="checkbox" id="terms" name="terms" required>
          <label for="terms">
            Saya menyetujui <a href="#">syarat penggunaan</a> dan
            <a href="#">kebijakan privasi</a> Kas Digital RT
          </label>
        </div>

        <button type="submit" class="btn-auth">Buat Akun Sekarang</button>
      </form>

    </div>
  </div>

  <!-- Right: Visual panel -->
  <div class="auth-right">
    <div class="auth-right-inner">

      <h2 class="right-title">Bergabung dengan ribuan RT yang sudah digital</h2>
      <p class="right-desc">Setup 5 menit. Gratis selamanya untuk RT hingga 100 KK. Tidak perlu kartu kredit.</p>

      <div class="feat-list">
        <div class="feat-item">
          <div class="feat-icon">✅</div>
          <div>
            <div class="feat-title">Akun langsung aktif</div>
            <div class="feat-desc">Setelah daftar, langsung bisa akses semua fitur</div>
          </div>
        </div>
        <div class="feat-item">
          <div class="feat-icon">🔒</div>
          <div>
            <div class="feat-title">Data aman & terenkripsi</div>
            <div class="feat-desc">Email dan data pribadi tidak pernah dibagikan</div>
          </div>
        </div>
        <div class="feat-item">
          <div class="feat-icon">📱</div>
          <div>
            <div class="feat-title">Akses dari mana saja</div>
            <div class="feat-desc">Web, HP, tablet — semua didukung</div>
          </div>
        </div>
      </div>

      <div class="testi">
        <div class="testi-quote">
          "Proses daftarnya <span class="hl">cuma 2 menit</span> dan langsung bisa bayar iuran. Tidak perlu WhatsApp bendahara lagi tiap bulan!"
        </div>
        <div class="testi-author">
          <div class="testi-avatar">SR</div>
          <div>
            <div class="testi-name">Ibu Siti Rahmawati</div>
            <div class="testi-role">Warga RT 05 Griya Asri</div>
          </div>
        </div>
      </div>

    </div>
  </div>

</body>
</html>