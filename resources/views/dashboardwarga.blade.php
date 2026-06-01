<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="theme-color" content="#0F2A4A">
  <title>Kas Digital RT</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=Geist:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    /* ═══════════════════════════════════════════
       TOKENS — same palette as Bendahara
    ═══════════════════════════════════════════ */
    :root {
      --navy:       #0F2A4A;
      --navy-mid:   #1A3D6B;
      --blue:       #1E6FD9;
      --blue-soft:  #E8F1FB;
      --teal:       #0EA882;
      --teal-soft:  #D6F5EE;
      --red:        #E53535;
      --red-soft:   #FDE8E8;
      --amber:      #F59E0B;
      --amber-soft: #FEF3C7;
      --ink:        #0D1B2A;
      --ink-mid:    #4A6074;
      --ink-soft:   #8FA3B8;
      --surface:    #F4F7FB;
      --white:      #FFFFFF;
      --border:     #DDE6F0;
      --nav-h:      64px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html, body {
      height: 100%;
      overflow: hidden; /* managed per-screen */
    }

    body {
      font-family: 'Geist', 'Segoe UI', sans-serif;
      background: var(--surface);
      color: var(--ink);
      font-size: 14px;
      /* Simulate phone width in browser */
      max-width: 430px;
      margin: 0 auto;
      position: relative;
    }

    /* ═══════════════════════════════════════════
       SCREENS (single-page navigation)
    ═══════════════════════════════════════════ */
    .screen {
      display: none;
      flex-direction: column;
      height: 100dvh;
      overflow-y: auto;
      padding-bottom: var(--nav-h);
      animation: screenIn .25s ease both;
    }

    .screen.active { display: flex; }

    @keyframes screenIn {
      from { opacity: 0; transform: translateX(12px); }
      to   { opacity: 1; transform: translateX(0); }
    }

    /* ═══════════════════════════════════════════
       HEADER (mobile topbar)
    ═══════════════════════════════════════════ */
    .mobile-header {
      background: var(--navy);
      color: #fff;
      padding: 52px 20px 20px;
      position: relative;
      overflow: hidden;
    }

    /* Decorative circle */
    .mobile-header::before {
      content: '';
      position: absolute;
      top: -40px; right: -40px;
      width: 160px; height: 160px;
      border-radius: 50%;
      background: rgba(255,255,255,.05);
    }

    .mobile-header::after {
      content: '';
      position: absolute;
      top: 20px; right: 60px;
      width: 80px; height: 80px;
      border-radius: 50%;
      background: rgba(255,255,255,.04);
    }

    .header-greeting {
      font-size: 12px;
      color: rgba(255,255,255,.55);
      margin-bottom: 3px;
    }

    .header-name {
      font-family: 'Syne', sans-serif;
      font-size: 20px;
      font-weight: 700;
      color: #fff;
    }

    /* ═══════════════════════════════════════════
       SCREEN 1 — DASHBOARD WARGA
    ═══════════════════════════════════════════ */
    .dash-header {
      background: var(--navy);
      padding: 52px 20px 28px;
      position: relative;
      overflow: hidden;
    }

    .dash-header::before {
      content: '';
      position: absolute;
      top: -50px; right: -50px;
      width: 200px; height: 200px;
      border-radius: 50%;
      background: rgba(30,111,217,.25);
    }

    .dash-top {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      margin-bottom: 20px;
      position: relative;
      z-index: 1;
    }

    .dash-greeting { font-size: 11.5px; color: rgba(255,255,255,.5); margin-bottom: 3px; }
    .dash-name { font-family: 'Syne', sans-serif; font-size: 18px; font-weight: 700; color: #fff; }

    .notif-btn {
      width: 36px; height: 36px;
      border-radius: 50%;
      background: rgba(255,255,255,.1);
      border: none;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer;
      position: relative;
    }

    .notif-dot {
      position: absolute;
      top: 8px; right: 8px;
      width: 7px; height: 7px;
      border-radius: 50%;
      background: var(--red);
      border: 1.5px solid var(--navy);
    }

    /* Status card */
    .status-card {
      background: rgba(255,255,255,.1);
      border: 1px solid rgba(255,255,255,.12);
      border-radius: 14px;
      padding: 16px 18px;
      position: relative;
      z-index: 1;
    }

    .status-label {
      font-size: 11px;
      font-weight: 600;
      letter-spacing: .07em;
      text-transform: uppercase;
      color: rgba(255,255,255,.5);
      margin-bottom: 6px;
    }

    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 5px 12px;
      border-radius: 99px;
      font-size: 13px;
      font-weight: 700;
      margin-bottom: 12px;
    }

    .status-badge.belum { background: var(--red-soft); color: var(--red); }
    .status-badge.lunas { background: var(--teal-soft); color: var(--teal); }

    .status-period { font-size: 12px; color: rgba(255,255,255,.5); margin-bottom: 16px; }

    .kas-label { font-size: 11px; font-weight: 600; letter-spacing: .05em; text-transform: uppercase; color: rgba(255,255,255,.4); margin-bottom: 4px; }
    .kas-amount {
      font-family: 'Syne', sans-serif;
      font-size: 26px;
      font-weight: 700;
      color: #fff;
      margin-bottom: 6px;
    }

    .kas-sub { font-size: 11.5px; color: rgba(255,255,255,.4); }

    /* CTA Button */
    .btn-bayar {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      width: 100%;
      margin-top: 16px;
      padding: 13px;
      background: var(--blue);
      color: #fff;
      border: none;
      border-radius: 12px;
      font-family: 'Syne', sans-serif;
      font-size: 14px;
      font-weight: 700;
      cursor: pointer;
      transition: opacity .15s, transform .1s;
      box-shadow: 0 4px 16px rgba(30,111,217,.4);
    }

    .btn-bayar:active { opacity: .85; transform: scale(.98); }

    /* Riwayat */
    .section-wrap {
      padding: 20px 20px 0;
    }

    .section-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 14px;
    }

    .section-heading {
      font-family: 'Syne', sans-serif;
      font-size: 15px;
      font-weight: 700;
      color: var(--navy);
    }

    .btn-lihat-semua {
      font-size: 12.5px;
      font-weight: 600;
      color: var(--blue);
      background: none;
      border: none;
      cursor: pointer;
    }

    .riwayat-list {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .riwayat-item {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 13px 16px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      animation: fadeUp .3s ease both;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(8px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .riwayat-item:nth-child(1) { animation-delay: .05s; }
    .riwayat-item:nth-child(2) { animation-delay: .10s; }
    .riwayat-item:nth-child(3) { animation-delay: .15s; }

    .riwayat-left {}
    .riwayat-bulan { font-size: 13px; font-weight: 600; color: var(--navy); }
    .riwayat-nominal { font-size: 12px; color: var(--ink-soft); margin-top: 2px; }

    .chip {
      padding: 4px 10px;
      border-radius: 99px;
      font-size: 11.5px;
      font-weight: 700;
    }
    .chip-lunas   { background: var(--teal-soft); color: var(--teal); }
    .chip-gagal   { background: var(--red-soft);  color: var(--red); }
    .chip-pending { background: var(--amber-soft); color: var(--amber); }

    /* ═══════════════════════════════════════════
       SCREEN 2 — FORM BAYAR
    ═══════════════════════════════════════════ */
    .form-header {
      background: var(--navy);
      padding: 52px 20px 20px;
      display: flex;
      align-items: center;
      gap: 12px;
      position: relative;
    }

    .back-btn {
      width: 36px; height: 36px;
      border-radius: 50%;
      background: rgba(255,255,255,.1);
      border: none;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer;
      flex-shrink: 0;
    }

    .form-header-title {
      font-family: 'Syne', sans-serif;
      font-size: 18px;
      font-weight: 700;
      color: #fff;
    }

    .form-close-btn {
      margin-left: auto;
      width: 32px; height: 32px;
      border-radius: 50%;
      background: rgba(255,255,255,.1);
      border: none;
      color: rgba(255,255,255,.7);
      font-size: 18px;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer;
    }

    /* Deadline alert */
    .deadline-alert {
      margin: 16px 20px 0;
      background: var(--amber-soft);
      border: 1px solid rgba(245,158,11,.3);
      border-radius: 10px;
      padding: 11px 14px;
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 12.5px;
      font-weight: 600;
      color: #92400E;
    }

    /* Form fields */
    .form-body {
      padding: 16px 20px;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .field-group {}
    .field-label {
      font-size: 12px;
      font-weight: 600;
      letter-spacing: .04em;
      text-transform: uppercase;
      color: var(--ink-mid);
      margin-bottom: 8px;
      display: block;
    }

    /* Info readonly fields */
    .field-info {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 12px 14px;
      font-size: 14px;
      font-weight: 600;
      color: var(--navy);
    }

    /* Bank highlight card */
    .bank-card {
      background: var(--navy);
      border-radius: 12px;
      padding: 16px;
      color: #fff;
    }

    .bank-label-sm { font-size: 10.5px; color: rgba(255,255,255,.45); letter-spacing: .06em; text-transform: uppercase; margin-bottom: 4px; }
    .bank-name     { font-size: 15px; font-weight: 700; margin-bottom: 12px; }
    .bank-row      { display: flex; align-items: center; justify-content: space-between; }
    .bank-norek    { font-family: 'Geist', monospace; font-size: 18px; font-weight: 600; letter-spacing: .05em; }
    .bank-an       { font-size: 12px; color: rgba(255,255,255,.5); margin-top: 4px; }

    .copy-btn {
      background: rgba(255,255,255,.12);
      border: none;
      border-radius: 8px;
      padding: 7px 12px;
      font-size: 12px;
      font-weight: 600;
      color: #fff;
      cursor: pointer;
      transition: background .15s;
    }
    .copy-btn:active { background: rgba(255,255,255,.2); }

    /* Upload zone */
    .upload-zone {
      border: 2px dashed var(--border);
      border-radius: 12px;
      background: var(--white);
      padding: 28px 16px;
      text-align: center;
      cursor: pointer;
      transition: border-color .2s, background .2s;
      position: relative;
    }

    .upload-zone:hover, .upload-zone.dragover {
      border-color: var(--blue);
      background: var(--blue-soft);
    }

    .upload-zone input {
      position: absolute;
      inset: 0;
      opacity: 0;
      cursor: pointer;
      font-size: 0;
    }

    .upload-icon {
      width: 44px; height: 44px;
      background: var(--blue-soft);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 10px;
    }

    .upload-text-main { font-size: 13.5px; font-weight: 600; color: var(--navy); margin-bottom: 3px; }
    .upload-text-sub  { font-size: 11.5px; color: var(--ink-soft); }

    /* Preview */
    .upload-preview {
      display: none;
      border: 1px solid var(--border);
      border-radius: 12px;
      overflow: hidden;
      background: var(--white);
    }

    .upload-preview img {
      width: 100%;
      max-height: 180px;
      object-fit: contain;
      display: block;
    }

    .preview-bar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 8px 12px;
      border-top: 1px solid var(--border);
    }

    .preview-fname { font-size: 12px; font-weight: 500; color: var(--ink-mid); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 200px; }
    .preview-rm    { background: none; border: none; font-size: 12px; font-weight: 700; color: var(--red); cursor: pointer; }

    /* Nominal input */
    .nominal-wrap {
      display: flex;
      align-items: center;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      overflow: hidden;
      background: var(--white);
      transition: border-color .2s;
    }

    .nominal-wrap:focus-within { border-color: var(--blue); }
    .nominal-wrap.locked { background: var(--surface); border-style: dashed; opacity: .65; pointer-events: none; }

    .nominal-prefix {
      padding: 12px 14px;
      font-size: 14px;
      font-weight: 700;
      color: var(--ink-soft);
      background: var(--surface);
      border-right: 1.5px solid var(--border);
    }

    #nominalInput {
      flex: 1;
      border: none;
      outline: none;
      background: transparent;
      font-family: 'Geist', sans-serif;
      font-size: 15px;
      font-weight: 600;
      color: var(--navy);
      padding: 12px 14px;
    }

    /* Catatan */
    .notes-input {
      width: 100%;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 12px 14px;
      font-family: 'Geist', sans-serif;
      font-size: 13.5px;
      color: var(--ink);
      outline: none;
      resize: none;
      min-height: 72px;
      transition: border-color .2s;
    }
    .notes-input:focus { border-color: var(--blue); }
    .notes-input::placeholder { color: var(--ink-soft); }

    /* Scan button & submit */
    .btn-scan {
      width: 100%;
      padding: 14px;
      background: var(--navy);
      color: #fff;
      border: none;
      border-radius: 12px;
      font-family: 'Syne', sans-serif;
      font-size: 14px;
      font-weight: 700;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: opacity .15s, transform .1s;
    }

    .btn-scan:active  { opacity: .85; transform: scale(.98); }
    .btn-scan.confirm { background: var(--teal); }
    .btn-scan:disabled { opacity: .5; pointer-events: none; }

    .btn-batal {
      width: 100%;
      padding: 13px;
      background: var(--surface);
      color: var(--ink-mid);
      border: 1px solid var(--border);
      border-radius: 12px;
      font-family: 'Geist', sans-serif;
      font-size: 13.5px;
      font-weight: 600;
      cursor: pointer;
      margin-top: 8px;
      transition: background .15s;
    }

    .btn-batal:active { background: var(--border); }

    /* Alert inside form */
    .form-alert {
      display: none;
      padding: 11px 14px;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 500;
      animation: fadeUp .25s ease both;
    }

    .form-alert.success { background: var(--teal-soft); color: #065F46; display: flex; gap: 8px; align-items: center; }
    .form-alert.error   { background: var(--red-soft);  color: #991B1B; display: flex; gap: 8px; align-items: center; }
    .form-alert.warning { background: var(--amber-soft); color: #92400E; display: flex; gap: 8px; align-items: center; }

    /* Spinner */
    @keyframes spin { to { transform: rotate(360deg); } }
    .spinner {
      width: 16px; height: 16px;
      border: 2px solid rgba(255,255,255,.3);
      border-top-color: #fff;
      border-radius: 50%;
      animation: spin .65s linear infinite;
      display: none;
    }

    /* ═══════════════════════════════════════════
       BOTTOM NAVIGATION
    ═══════════════════════════════════════════ */
    .bottom-nav {
      position: fixed;
      bottom: 0; left: 50%;
      transform: translateX(-50%);
      width: 100%;
      max-width: 430px;
      height: var(--nav-h);
      background: var(--white);
      border-top: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: space-around;
      z-index: 100;
      box-shadow: 0 -4px 20px rgba(15,42,74,.06);
    }

    .nav-tab {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 4px;
      padding: 10px 4px;
      cursor: pointer;
      border: none;
      background: none;
      color: var(--ink-soft);
      font-family: 'Geist', sans-serif;
      font-size: 10.5px;
      font-weight: 500;
      transition: color .15s;
    }

    .nav-tab.active     { color: var(--blue); }
    .nav-tab svg        { transition: transform .15s; }
    .nav-tab:active svg { transform: scale(.85); }

    /* FAB-style center bayar button */
    .nav-tab.nav-bayar {
      position: relative;
      top: -8px;
    }

    .nav-bayar-circle {
      width: 52px; height: 52px;
      border-radius: 50%;
      background: var(--blue);
      display: flex; align-items: center; justify-content: center;
      box-shadow: 0 4px 14px rgba(30,111,217,.4);
      transition: transform .15s;
    }

    .nav-tab.nav-bayar:active .nav-bayar-circle { transform: scale(.9); }

    /* ═══════════════════════════════════════════
       SUCCESS SHEET
    ═══════════════════════════════════════════ */
    .success-sheet {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(10,20,35,.6);
      backdrop-filter: blur(4px);
      z-index: 200;
      align-items: flex-end;
      justify-content: center;
    }

    .success-sheet.open { display: flex; }

    .success-box {
      background: var(--white);
      border-radius: 20px 20px 0 0;
      padding: 32px 24px 40px;
      width: 100%;
      max-width: 430px;
      text-align: center;
      animation: slideUp .35s cubic-bezier(.22,.68,0,1.2) both;
    }

    @keyframes slideUp {
      from { transform: translateY(100%); }
      to   { transform: translateY(0); }
    }

    .success-icon {
      width: 64px; height: 64px;
      border-radius: 50%;
      background: var(--teal-soft);
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 16px;
    }

    .success-title { font-family: 'Syne', sans-serif; font-size: 20px; font-weight: 700; color: var(--navy); margin-bottom: 6px; }
    .success-sub   { font-size: 13.5px; color: var(--ink-soft); line-height: 1.6; }

    .success-detail {
      background: var(--surface);
      border-radius: 12px;
      padding: 14px 16px;
      margin: 20px 0;
      text-align: left;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .detail-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .detail-row span:first-child { font-size: 12px; color: var(--ink-soft); }
    .detail-row span:last-child  { font-size: 13px; font-weight: 600; color: var(--navy); }

    .btn-done {
      width: 100%;
      padding: 14px;
      background: var(--navy);
      color: #fff;
      border: none;
      border-radius: 12px;
      font-family: 'Syne', sans-serif;
      font-size: 14px;
      font-weight: 700;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <!-- ════════════════════════════════════════
       SCREEN 1: DASHBOARD WARGA
  ════════════════════════════════════════ -->
  <div class="screen active" id="screenDashboard">

    <!-- Header navy -->
    <div class="dash-header">
      <div class="dash-top">
        <div>
          <div class="dash-greeting">Selamat datang,</div>
          <div class="dash-name">Pak Ahmad Hidayat</div>
        </div>
        <button class="notif-btn">
          <svg width="18" height="18" fill="none" stroke="rgba(255,255,255,.8)" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
          <span class="notif-dot"></span>
        </button>
      </div>

      <!-- Status Card -->
      <div class="status-card">
        <div class="status-label">Status Pembayaran</div>
        <div class="status-badge belum">
          <svg width="11" height="11" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
          BELUM LUNAS
        </div>
        <div class="status-period">Juni 2025</div>

        <div class="kas-label">Saldo Kas RT</div>
        <div class="kas-amount">Rp 12.450.000</div>
        <div class="kas-sub">Diperbarui 5 Jun 2025, 20:15</div>

        <button class="btn-bayar" onclick="goTo('screenForm')">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M3 10h18M7 15h1m4 0h1M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"/></svg>
          Bayar Kas Bulan Ini
        </button>
      </div>
    </div>

    <!-- Riwayat Pembayaran -->
    <div class="section-wrap">
      <div class="section-row">
        <div class="section-heading">Riwayat Pembayaran</div>
        <button class="btn-lihat-semua">Lihat Semua</button>
      </div>

      <div class="riwayat-list">
        <div class="riwayat-item">
          <div class="riwayat-left">
            <div class="riwayat-bulan">Mei 2025</div>
            <div class="riwayat-nominal">Rp 50.000</div>
          </div>
          <span class="chip chip-lunas">Lunas</span>
        </div>
        <div class="riwayat-item">
          <div class="riwayat-left">
            <div class="riwayat-bulan">April 2025</div>
            <div class="riwayat-nominal">Rp 50.000</div>
          </div>
          <span class="chip chip-lunas">Lunas</span>
        </div>
        <div class="riwayat-item">
          <div class="riwayat-left">
            <div class="riwayat-bulan">Maret 2025</div>
            <div class="riwayat-nominal">Rp 50.000</div>
          </div>
          <span class="chip chip-lunas">Lunas</span>
        </div>
      </div>
    </div>
  </div>


  <!-- ════════════════════════════════════════
       SCREEN 2: FORM BAYAR KAS
  ════════════════════════════════════════ -->
  <div class="screen" id="screenForm">

    <!-- Header -->
    <div class="form-header">
      <button class="back-btn" onclick="goTo('screenDashboard')">
        <svg width="18" height="18" fill="none" stroke="rgba(255,255,255,.8)" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
      </button>
      <div class="form-header-title">Bayar Kas</div>
      <button class="form-close-btn" onclick="goTo('screenDashboard')">×</button>
    </div>

    <!-- Deadline Alert -->
    <div class="deadline-alert">
      <svg width="15" height="15" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
      Batas pembayaran: <strong>10 Juni 2025</strong>
    </div>

    <!-- Form Body -->
    <div class="form-body">

      <!-- Periode & Jumlah -->
      <div class="field-group">
        <label class="field-label">Periode Pembayaran</label>
        <div class="field-info">Juni 2025</div>
      </div>

      <div class="field-group">
        <label class="field-label">Jumlah Kas</label>
        <div class="field-info">Rp 50.000</div>
      </div>

      <!-- Metode Pembayaran -->
      <div class="field-group">
        <label class="field-label">Metode Pembayaran</label>
        <div class="field-info">Transfer Bank</div>
      </div>

      <!-- Info Rekening -->
      <div class="field-group">
        <label class="field-label">Rekening Tujuan</label>
        <div class="bank-card">
          <div class="bank-label-sm">Rekening Transfer</div>
          <div class="bank-name">BCA</div>
          <div class="bank-row">
            <div>
              <div class="bank-norek">1234567890</div>
              <div class="bank-an">a.n. RT 05 Desa Airi</div>
            </div>
            <button class="copy-btn" onclick="salinNorek()">Salin</button>
          </div>
        </div>
      </div>

      <!-- Upload Bukti -->
      <div class="field-group">
        <label class="field-label">Upload Bukti Transfer *</label>

        <!-- Drop zone -->
        <div class="upload-zone" id="uploadZone" onclick="document.getElementById('fileInput').click()">
          <input type="file" id="fileInput" accept="image/*" capture="environment" onchange="handleFile(event)">
          <div class="upload-icon">
            <svg width="20" height="20" fill="none" stroke="var(--blue)" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
          </div>
          <div class="upload-text-main">Klik untuk upload foto/screenshot</div>
          <div class="upload-text-sub">JPG, PNG, HEIC • Maks 5MB</div>
        </div>

        <!-- Preview -->
        <div class="upload-preview" id="uploadPreview">
          <img id="previewImg" src="#" alt="Preview">
          <div class="preview-bar">
            <span class="preview-fname" id="previewFname">—</span>
            <button class="preview-rm" onclick="hapusFile()">Hapus</button>
          </div>
        </div>
      </div>

      <!-- Nominal (diisi AI) -->
      <div class="field-group">
        <label class="field-label">
          Nominal Terdeteksi AI
          <span id="nominalHint" style="font-weight:400;color:var(--ink-soft);font-size:11px;margin-left:4px;">— upload foto dulu</span>
        </label>
        <div class="nominal-wrap locked" id="nominalWrap">
          <div class="nominal-prefix">Rp</div>
          <input type="number" id="nominalInput" placeholder="Otomatis dari OCR…" readonly>
        </div>
      </div>

      <!-- Catatan -->
      <div class="field-group">
        <label class="field-label">Catatan (Opsional)</label>
        <textarea class="notes-input" placeholder="Tambahkan catatan jika ada…" id="notesInput"></textarea>
      </div>

      <!-- Alert -->
      <div class="form-alert" id="formAlert"></div>

      <!-- Tombol -->
      <button class="btn-scan" id="btnAksi" onclick="handleAksi()">
        <span class="spinner" id="btnSpinner"></span>
        <svg id="btnIcon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7.5 3.75H6A2.25 2.25 0 003.75 6v1.5M16.5 3.75H18A2.25 2.25 0 0120.25 6v1.5m0 9V18A2.25 2.25 0 0118 20.25h-1.5m-9 0H6A2.25 2.25 0 013.75 18v-1.5M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        <span id="btnLabel">Scan Struk dengan AI</span>
      </button>

      <button class="btn-batal" onclick="goTo('screenDashboard')">Batal</button>
    </div>
  </div>

  <!-- ════════════════════════════════════════
       BOTTOM NAVIGATION
  ════════════════════════════════════════ -->
  <nav class="bottom-nav">
    <button class="nav-tab active" id="tab-beranda" onclick="navGo('screenDashboard','tab-beranda')">
      <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      Beranda
    </button>

    <button class="nav-tab nav-bayar" onclick="navGo('screenForm','tab-bayar')">
      <div class="nav-bayar-circle">
        <svg width="24" height="24" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      </div>
      Bayar
    </button>

    <button class="nav-tab" id="tab-riwayat" onclick="navGo('screenDashboard','tab-riwayat')">
      <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
      Riwayat
    </button>

    <button class="nav-tab" id="tab-profil" onclick="navGo('screenDashboard','tab-profil')">
      <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      Profil
    </button>
  </nav>

  <!-- ════════════════════════════════════════
       SUCCESS BOTTOM SHEET
  ════════════════════════════════════════ -->
  <div class="success-sheet" id="successSheet">
    <div class="success-box">
      <div class="success-icon">
        <svg width="28" height="28" fill="none" stroke="var(--teal)" stroke-width="2.5" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
      </div>
      <div class="success-title">Pembayaran Terkirim!</div>
      <div class="success-sub">Menunggu verifikasi dari bendahara RT dalam 1×24 jam.</div>

      <div class="success-detail">
        <div class="detail-row">
          <span>Periode</span><span>Juni 2025</span>
        </div>
        <div class="detail-row">
          <span>Nominal</span><span id="successNominal">—</span>
        </div>
        <div class="detail-row">
          <span>Status</span><span style="color:var(--amber);font-weight:700;">Menunggu Verifikasi</span>
        </div>
      </div>

      <button class="btn-done" onclick="selesai()">Kembali ke Beranda</button>
    </div>
  </div>

  <!-- ════════════════════════════════════════
       JAVASCRIPT
  ════════════════════════════════════════ -->
  <script>
    /* ── State ───────────────────────────────── */
    let tahap    = 1;       // 1=scan, 2=konfirmasi
    let fileBlob = null;

    /* ── Navigasi antar screen ───────────────── */
    function goTo(screenId) {
      document.querySelectorAll('.screen').forEach(s => s.classList.remove('active'));
      document.getElementById(screenId).classList.add('active');
      document.getElementById(screenId).scrollTo(0, 0);
    }

    function navGo(screenId, tabId) {
      goTo(screenId);
      document.querySelectorAll('.nav-tab').forEach(t => t.classList.remove('active'));
      document.getElementById(tabId)?.classList.add('active');
    }

    /* ── Salin nomor rekening ────────────────── */
    function salinNorek() {
      navigator.clipboard?.writeText('1234567890').catch(() => {});
      const btn = document.querySelector('.copy-btn');
      btn.textContent = '✓ Tersalin';
      setTimeout(() => btn.textContent = 'Salin', 1800);
    }

    /* ── Handle file upload ──────────────────── */
    function handleFile(e) {
      const file = e.target.files[0];
      if (!file) return;
      if (file.size > 5 * 1024 * 1024) {
        tampilAlert('error', 'Ukuran file melebihi 5MB.');
        return;
      }
      fileBlob = file;
      const reader = new FileReader();
      reader.onload = ev => {
        document.getElementById('previewImg').src     = ev.target.result;
        document.getElementById('previewFname').textContent = file.name;
        document.getElementById('uploadZone').style.display    = 'none';
        document.getElementById('uploadPreview').style.display = 'block';
      };
      reader.readAsDataURL(file);
      sembunyiAlert();
    }

    function hapusFile() {
      fileBlob = null;
      document.getElementById('fileInput').value = '';
      document.getElementById('uploadPreview').style.display = 'none';
      document.getElementById('uploadZone').style.display    = 'block';
      resetKeTahap1();
    }

    /* ── Dispatcher tombol utama ─────────────── */
    function handleAksi() {
      if (tahap === 1) scanOCR();
      else             simpanPembayaran();
    }

    /* ── Tahap 1: Scan OCR ───────────────────── */
    async function scanOCR() {
      if (!fileBlob) {
        tampilAlert('error', 'Upload foto struk/bukti transfer terlebih dahulu.');
        return;
      }
      setLoading(true);
      sembunyiAlert();

      const formData = new FormData();
      formData.append('bukti_bayar', fileBlob);

      try {
        const res  = await fetch('/api/scan-struk', {
          method:  'POST',
          headers: {
            'Accept':        'application/json',
            'X-CSRF-TOKEN':  document.querySelector('meta[name=csrf-token]')?.content ?? '',
          },
          body: formData,
        });
        const data = await res.json();

        if (res.ok && data.nominal_terdeteksi) {
          bukaInputNominal(data.nominal_terdeteksi);
          tampilAlert('success', `✓ AI mendeteksi Rp ${Number(data.nominal_terdeteksi).toLocaleString('id-ID')}. Koreksi jika perlu.`);
          tahap = 2;
        } else {
          bukaInputNominal('');
          tampilAlert('warning', 'AI tidak berhasil membaca nominal. Silakan isi secara manual.');
          tahap = 2;
        }
      } catch {
        tampilAlert('error', 'Gagal terhubung ke server. Periksa koneksi Anda.');
      } finally {
        setLoading(false);
      }
    }

    /* ── Tahap 2: Simpan ke DB ───────────────── */
    async function simpanPembayaran() {
      const nominal = document.getElementById('nominalInput').value;
      if (!nominal || Number(nominal) <= 0) {
        tampilAlert('error', 'Nominal tidak boleh kosong atau nol.');
        return;
      }
      setLoading(true);
      sembunyiAlert();

      const formData = new FormData();
      formData.append('bukti_bayar',        fileBlob);
      formData.append('nominal_konfirmasi', nominal);
      formData.append('catatan',            document.getElementById('notesInput').value);

      try {
        const res  = await fetch('/api/bayar-iuran', {
          method:  'POST',
          headers: {
            'Accept':       'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content ?? '',
          },
          body: formData,
        });
        const data = await res.json();

        if (res.ok) {
          document.getElementById('successNominal').textContent =
            'Rp ' + Number(nominal).toLocaleString('id-ID');
          document.getElementById('successSheet').classList.add('open');
        } else {
          tampilAlert('error', data.message ?? 'Terjadi kesalahan. Coba lagi.');
        }
      } catch {
        tampilAlert('error', 'Server bermasalah. Coba beberapa saat lagi.');
      } finally {
        setLoading(false);
      }
    }

    /* ── Selesai → reset form & kembali ─────── */
    function selesai() {
      document.getElementById('successSheet').classList.remove('open');
      resetKeTahap1();
      hapusFile();
      document.getElementById('notesInput').value = '';
      goTo('screenDashboard');
    }

    /* ── Helpers ─────────────────────────────── */
    function bukaInputNominal(nilai) {
      const wrap  = document.getElementById('nominalWrap');
      const input = document.getElementById('nominalInput');
      const hint  = document.getElementById('nominalHint');
      wrap.classList.remove('locked');
      input.readOnly = false;
      if (nilai) { input.value = nilai; }
      else       { input.placeholder = 'Isi manual…'; input.focus(); }
      hint.textContent = '— koreksi jika berbeda';
      hint.style.color = 'var(--teal)';
    }

    function resetKeTahap1() {
      tahap = 1;
      const wrap  = document.getElementById('nominalWrap');
      const input = document.getElementById('nominalInput');
      const hint  = document.getElementById('nominalHint');
      wrap.classList.add('locked');
      input.readOnly    = true;
      input.value       = '';
      input.placeholder = 'Otomatis dari OCR…';
      hint.textContent  = '— upload foto dulu';
      hint.style.color  = '';
      setLoading(false, true);
    }

    function setLoading(on, forceReset = false) {
      const btn     = document.getElementById('btnAksi');
      const spinner = document.getElementById('btnSpinner');
      const icon    = document.getElementById('btnIcon');
      const label   = document.getElementById('btnLabel');
      btn.disabled          = on;
      spinner.style.display = on  ? 'block'  : 'none';
      icon.style.display    = on  ? 'none'   : 'inline';
      if (forceReset)      { label.textContent = 'Scan Struk dengan AI'; btn.classList.remove('confirm'); return; }
      if (on)              { label.textContent = tahap === 1 ? 'Memindai…' : 'Mengirim…'; return; }
      if (tahap === 2)     { label.textContent = 'Konfirmasi & Kirim'; btn.classList.add('confirm'); }
      else                 { label.textContent = 'Scan Struk dengan AI'; btn.classList.remove('confirm'); }
    }

    function tampilAlert(tipe, pesan) {
      const el = document.getElementById('formAlert');
      const icon = tipe === 'success' ? '✓' : tipe === 'error' ? '✕' : '⚠';
      el.innerHTML  = `<span>${icon}</span><span>${pesan}</span>`;
      el.className  = `form-alert ${tipe}`;
    }

    function sembunyiAlert() {
      document.getElementById('formAlert').className = 'form-alert';
    }
  </script>
</body>
</html>