<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kas Digital RT — Sistem Iuran Warga Modern</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap" rel="stylesheet">
  <style>
    /* ══════════════════════════════════════════
       TOKENS
    ══════════════════════════════════════════ */
    :root {
      --bg:        #0A0D12;
      --surface:   #111520;
      --surface2:  #181D2A;
      --border:    rgba(255,255,255,.07);
      --border2:   rgba(255,255,255,.12);
      --white:     #FFFFFF;
      --muted:     rgba(255,255,255,.45);
      --muted2:    rgba(255,255,255,.25);
      --blue:      #3B82F6;
      --blue-glow: rgba(59,130,246,.25);
      --teal:      #14B8A6;
      --teal-glow: rgba(20,184,166,.2);
      --accent:    #60A5FA;
      --navy:      #0F2A4A;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html { scroll-behavior: smooth; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--bg);
      color: var(--white);
      overflow-x: hidden;
      line-height: 1.6;
    }

    /* ══════════════════════════════════════════
       NOISE TEXTURE OVERLAY
    ══════════════════════════════════════════ */
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
      pointer-events: none;
      z-index: 0;
      opacity: .6;
    }

    /* ══════════════════════════════════════════
       NAV
    ══════════════════════════════════════════ */
    nav {
      position: fixed;
      top: 0; left: 0; right: 0;
      z-index: 100;
      padding: 20px 40px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid transparent;
      transition: background .3s, border-color .3s, backdrop-filter .3s;
    }

    nav.scrolled {
      background: rgba(10,13,18,.8);
      backdrop-filter: blur(20px);
      border-color: var(--border);
    }

    .nav-brand {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
    }

    .nav-logo {
      width: 32px; height: 32px;
      background: linear-gradient(135deg, var(--blue), var(--teal));
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
    }

    .nav-name {
      font-family: 'Instrument Serif', serif;
      font-size: 18px;
      color: var(--white);
      letter-spacing: -.01em;
    }

    .nav-right {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .btn-ghost {
      padding: 8px 18px;
      border: 1px solid var(--border2);
      border-radius: 8px;
      background: rgba(255,255,255,.04);
      color: rgba(255,255,255,.75);
      font-family: 'DM Sans', sans-serif;
      font-size: 13.5px;
      font-weight: 500;
      text-decoration: none;
      cursor: pointer;
      transition: background .15s, color .15s, border-color .15s;
    }

    .btn-ghost:hover {
      background: rgba(255,255,255,.08);
      color: var(--white);
      border-color: rgba(255,255,255,.2);
    }

    .btn-primary {
      padding: 8px 20px;
      background: var(--white);
      color: #0A0D12;
      border: none;
      border-radius: 8px;
      font-family: 'DM Sans', sans-serif;
      font-size: 13.5px;
      font-weight: 600;
      text-decoration: none;
      cursor: pointer;
      transition: opacity .15s, transform .1s;
    }

    .btn-primary:hover { opacity: .9; transform: translateY(-1px); }

    /* ══════════════════════════════════════════
       HERO
    ══════════════════════════════════════════ */
    .hero {
      min-height: 100dvh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 120px 24px 80px;
      position: relative;
      z-index: 1;
    }

    /* Radial gradient orbs */
    .orb {
      position: absolute;
      border-radius: 50%;
      filter: blur(120px);
      pointer-events: none;
    }

    .orb-1 {
      width: 600px; height: 600px;
      background: radial-gradient(circle, rgba(59,130,246,.18) 0%, transparent 70%);
      top: -100px; left: 50%;
      transform: translateX(-50%);
      animation: pulse-orb 8s ease-in-out infinite;
    }

    .orb-2 {
      width: 400px; height: 400px;
      background: radial-gradient(circle, rgba(20,184,166,.12) 0%, transparent 70%);
      bottom: 0; right: -100px;
      animation: pulse-orb 10s ease-in-out infinite reverse;
    }

    .orb-3 {
      width: 300px; height: 300px;
      background: radial-gradient(circle, rgba(99,102,241,.1) 0%, transparent 70%);
      top: 30%; left: -80px;
      animation: pulse-orb 12s ease-in-out infinite;
    }

    @keyframes pulse-orb {
      0%, 100% { transform: scale(1) translateX(0); opacity: .8; }
      50%       { transform: scale(1.15) translateX(10px); opacity: 1; }
    }

    /* Badge */
    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(59,130,246,.1);
      border: 1px solid rgba(59,130,246,.25);
      border-radius: 99px;
      padding: 5px 14px 5px 8px;
      font-size: 12px;
      font-weight: 500;
      color: var(--accent);
      margin-bottom: 28px;
      animation: fadeDown .6s ease both;
    }

    .badge-dot {
      width: 6px; height: 6px;
      border-radius: 50%;
      background: var(--accent);
      animation: blink 2s ease-in-out infinite;
    }

    @keyframes blink {
      0%, 100% { opacity: 1; }
      50%       { opacity: .3; }
    }

    /* Headline */
    .hero-headline {
      font-family: 'Instrument Serif', serif;
      font-size: clamp(48px, 8vw, 88px);
      font-weight: 400;
      line-height: 1.05;
      letter-spacing: -.03em;
      max-width: 900px;
      animation: fadeDown .6s ease .1s both;
    }

    .hero-headline em {
      font-style: italic;
      background: linear-gradient(135deg, var(--blue) 0%, var(--teal) 60%, #a78bfa 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* Sub */
    .hero-sub {
      margin-top: 20px;
      font-size: clamp(15px, 2vw, 18px);
      color: var(--muted);
      max-width: 520px;
      font-weight: 300;
      line-height: 1.7;
      animation: fadeDown .6s ease .2s both;
    }

    /* CTA group */
    .hero-cta {
      margin-top: 40px;
      display: flex;
      align-items: center;
      gap: 12px;
      flex-wrap: wrap;
      justify-content: center;
      animation: fadeDown .6s ease .3s both;
    }

    .btn-hero-primary {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 14px 28px;
      background: var(--white);
      color: #0A0D12;
      border: none;
      border-radius: 10px;
      font-family: 'DM Sans', sans-serif;
      font-size: 15px;
      font-weight: 600;
      text-decoration: none;
      cursor: pointer;
      transition: opacity .15s, transform .15s, box-shadow .15s;
      box-shadow: 0 0 40px rgba(255,255,255,.08);
    }

    .btn-hero-primary:hover {
      opacity: .92;
      transform: translateY(-2px);
      box-shadow: 0 8px 40px rgba(255,255,255,.12);
    }

    .btn-hero-ghost {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 14px 28px;
      background: rgba(255,255,255,.05);
      border: 1px solid var(--border2);
      border-radius: 10px;
      color: rgba(255,255,255,.8);
      font-family: 'DM Sans', sans-serif;
      font-size: 15px;
      font-weight: 500;
      text-decoration: none;
      cursor: pointer;
      transition: background .15s, border-color .15s;
    }

    .btn-hero-ghost:hover {
      background: rgba(255,255,255,.08);
      border-color: rgba(255,255,255,.2);
      color: var(--white);
    }

    /* ── 3D Card Visual ── */
    .hero-visual {
      margin-top: 72px;
      position: relative;
      animation: fadeUp .8s ease .4s both;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(24px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .card-3d-wrap {
      perspective: 1200px;
    }

    .card-3d {
      width: min(720px, 90vw);
      background: var(--surface);
      border: 1px solid var(--border2);
      border-radius: 20px;
      overflow: hidden;
      box-shadow:
        0 0 0 1px rgba(255,255,255,.05),
        0 32px 80px rgba(0,0,0,.6),
        0 0 120px rgba(59,130,246,.08);
      transform: rotateX(4deg);
      transition: transform .4s ease;
    }

    .card-3d:hover { transform: rotateX(0deg); }

    /* Mock dashboard inside card */
    .mock-topbar {
      padding: 14px 20px;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: rgba(255,255,255,.02);
    }

    .mock-dots { display: flex; gap: 6px; }
    .mock-dot {
      width: 10px; height: 10px; border-radius: 50%;
    }
    .mock-dot:nth-child(1) { background: #FF5F57; }
    .mock-dot:nth-child(2) { background: #FEBC2E; }
    .mock-dot:nth-child(3) { background: #28C840; }

    .mock-url {
      background: rgba(255,255,255,.05);
      border: 1px solid var(--border);
      border-radius: 6px;
      padding: 4px 14px;
      font-size: 11.5px;
      color: var(--muted);
      font-family: monospace;
    }

    .mock-body {
      display: flex;
      height: 320px;
    }

    /* Sidebar */
    .mock-sidebar {
      width: 160px;
      background: rgba(15,42,74,.5);
      border-right: 1px solid var(--border);
      padding: 16px 12px;
      display: flex;
      flex-direction: column;
      gap: 3px;
      flex-shrink: 0;
    }

    .mock-nav-item {
      padding: 7px 10px;
      border-radius: 6px;
      font-size: 11px;
      color: var(--muted);
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .mock-nav-item.active {
      background: rgba(59,130,246,.15);
      color: var(--accent);
    }

    .mock-nav-dot {
      width: 5px; height: 5px; border-radius: 50%;
      background: currentColor; flex-shrink: 0;
    }

    /* Main content */
    .mock-main {
      flex: 1;
      padding: 16px;
      overflow: hidden;
    }

    .mock-stats {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 10px;
      margin-bottom: 14px;
    }

    .mock-stat {
      background: rgba(255,255,255,.03);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 12px;
    }

    .mock-stat-label {
      font-size: 9px;
      color: var(--muted2);
      letter-spacing: .06em;
      text-transform: uppercase;
      margin-bottom: 4px;
    }

    .mock-stat-value {
      font-family: 'Instrument Serif', serif;
      font-size: 20px;
      color: var(--white);
      line-height: 1;
    }

    .mock-stat-value.danger { color: #F87171; }
    .mock-stat-value.teal   { color: var(--teal); }

    .mock-stat-sub {
      font-size: 9px;
      color: var(--muted2);
      margin-top: 2px;
    }

    .mock-table-header {
      font-size: 11px;
      font-weight: 600;
      color: var(--white);
      margin-bottom: 8px;
    }

    .mock-row {
      display: flex;
      align-items: center;
      padding: 8px 10px;
      border-radius: 7px;
      gap: 8px;
      margin-bottom: 4px;
      font-size: 10px;
      background: rgba(255,255,255,.02);
      border: 1px solid var(--border);
    }

    .mock-avatar {
      width: 22px; height: 22px; border-radius: 50%;
      flex-shrink: 0;
    }

    .mock-name { flex: 1; color: rgba(255,255,255,.8); font-weight: 500; }
    .mock-amount { color: var(--muted); margin-right: 8px; }

    .chip {
      padding: 2px 8px; border-radius: 99px; font-size: 9px; font-weight: 600;
    }
    .chip-pending  { background: rgba(251,191,36,.1); color: #FBB724; }
    .chip-approved { background: rgba(20,184,166,.1); color: var(--teal); }

    .mock-actions { display: flex; gap: 4px; margin-left: auto; }

    .mock-btn {
      padding: 2px 8px; border-radius: 4px; font-size: 9px; font-weight: 600; border: none; cursor: default;
    }
    .mock-btn-approve { background: rgba(20,184,166,.2); color: var(--teal); }
    .mock-btn-reject  { background: rgba(239,68,68,.15); color: #F87171; }

    /* Glow bottom */
    .card-glow {
      position: absolute;
      bottom: -40px; left: 50%;
      transform: translateX(-50%);
      width: 80%;
      height: 80px;
      background: radial-gradient(ellipse, rgba(59,130,246,.2) 0%, transparent 70%);
      filter: blur(20px);
      pointer-events: none;
    }

    /* ══════════════════════════════════════════
       FEATURES SECTION
    ══════════════════════════════════════════ */
    .features {
      padding: 120px 24px;
      max-width: 1100px;
      margin: 0 auto;
      position: relative;
      z-index: 1;
    }

    .section-label {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 11.5px;
      font-weight: 600;
      letter-spacing: .12em;
      text-transform: uppercase;
      color: var(--accent);
      margin-bottom: 16px;
    }

    .section-label::before {
      content: '';
      display: block;
      width: 20px; height: 1px;
      background: var(--accent);
    }

    .section-title {
      font-family: 'Instrument Serif', serif;
      font-size: clamp(32px, 5vw, 52px);
      font-weight: 400;
      line-height: 1.15;
      letter-spacing: -.02em;
      max-width: 600px;
      margin-bottom: 60px;
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 16px;
    }

    .feature-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 28px;
      transition: border-color .2s, background .2s, transform .2s;
      position: relative;
      overflow: hidden;
    }

    .feature-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,.1), transparent);
    }

    .feature-card:hover {
      border-color: rgba(255,255,255,.15);
      background: var(--surface2);
      transform: translateY(-3px);
    }

    .feature-icon {
      width: 40px; height: 40px;
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 16px;
    }

    .feature-icon-blue { background: rgba(59,130,246,.12); }
    .feature-icon-teal { background: rgba(20,184,166,.12); }
    .feature-icon-purple { background: rgba(139,92,246,.12); }
    .feature-icon-amber { background: rgba(245,158,11,.12); }

    .feature-title {
      font-family: 'Instrument Serif', serif;
      font-size: 20px;
      font-weight: 400;
      color: var(--white);
      margin-bottom: 8px;
      letter-spacing: -.01em;
    }

    .feature-desc {
      font-size: 14px;
      color: var(--muted);
      line-height: 1.7;
    }

    /* ══════════════════════════════════════════
       STATS STRIP
    ══════════════════════════════════════════ */
    .stats-strip {
      border-top: 1px solid var(--border);
      border-bottom: 1px solid var(--border);
      padding: 48px 24px;
      position: relative;
      z-index: 1;
      overflow: hidden;
    }

    .stats-strip::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(59,130,246,.03) 0%, rgba(20,184,166,.03) 100%);
    }

    .stats-inner {
      max-width: 1100px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 40px;
      text-align: center;
      position: relative;
    }

    .stat-item-value {
      font-family: 'Instrument Serif', serif;
      font-size: 44px;
      font-weight: 400;
      letter-spacing: -.03em;
      line-height: 1;
      background: linear-gradient(135deg, var(--white) 30%, rgba(255,255,255,.5));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .stat-item-label {
      font-size: 13px;
      color: var(--muted);
      margin-top: 6px;
      font-weight: 300;
    }

    /* ══════════════════════════════════════════
       CTA SECTION
    ══════════════════════════════════════════ */
    .cta-section {
      padding: 120px 24px;
      text-align: center;
      position: relative;
      z-index: 1;
    }

    .cta-card {
      max-width: 680px;
      margin: 0 auto;
      background: var(--surface);
      border: 1px solid var(--border2);
      border-radius: 24px;
      padding: 60px 48px;
      position: relative;
      overflow: hidden;
    }

    .cta-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,.15), transparent);
    }

    .cta-orb {
      position: absolute;
      width: 400px; height: 400px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(59,130,246,.08) 0%, transparent 70%);
      top: -200px; left: 50%;
      transform: translateX(-50%);
      filter: blur(40px);
      pointer-events: none;
    }

    .cta-title {
      font-family: 'Instrument Serif', serif;
      font-size: clamp(28px, 4vw, 44px);
      font-weight: 400;
      letter-spacing: -.02em;
      line-height: 1.15;
      margin-bottom: 14px;
      position: relative;
    }

    .cta-sub {
      font-size: 15px;
      color: var(--muted);
      margin-bottom: 36px;
      font-weight: 300;
      position: relative;
    }

    .cta-buttons {
      display: flex;
      gap: 10px;
      justify-content: center;
      flex-wrap: wrap;
      position: relative;
    }

    /* ══════════════════════════════════════════
       FOOTER
    ══════════════════════════════════════════ */
    footer {
      border-top: 1px solid var(--border);
      padding: 32px 40px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: relative;
      z-index: 1;
      flex-wrap: wrap;
      gap: 12px;
    }

    .footer-brand {
      font-family: 'Instrument Serif', serif;
      font-size: 16px;
      color: var(--white);
    }

    .footer-copy {
      font-size: 12.5px;
      color: var(--muted2);
    }

    /* ══════════════════════════════════════════
       ANIMATIONS
    ══════════════════════════════════════════ */
    @keyframes fadeDown {
      from { opacity: 0; transform: translateY(-12px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .reveal {
      opacity: 0;
      transform: translateY(20px);
      transition: opacity .6s ease, transform .6s ease;
    }

    .reveal.visible {
      opacity: 1;
      transform: translateY(0);
    }

    /* ══════════════════════════════════════════
       RESPONSIVE
    ══════════════════════════════════════════ */
    @media (max-width: 640px) {
      nav { padding: 16px 20px; }
      .mock-sidebar { display: none; }
      .mock-stats { grid-template-columns: repeat(2, 1fr); }
      footer { padding: 24px 20px; flex-direction: column; align-items: flex-start; }
      .cta-card { padding: 40px 24px; }
    }
  </style>
</head>
<body>

  <!-- ══════════════════════════════════════════
       NAV
  ══════════════════════════════════════════ -->
  <nav id="navbar">
    <a href="/" class="nav-brand">
      <div class="nav-logo">
        <svg width="16" height="16" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24">
          <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
          <polyline points="9 22 9 12 15 12 15 22"/>
        </svg>
      </div>
      <span class="nav-name">Kas Digital RT</span>
    </a>
    <div class="nav-right">
      <a href="/login" class="btn-ghost">Masuk</a>
      <a href="/login" class="btn-primary">Mulai Sekarang →</a>
    </div>
  </nav>

  <!-- ══════════════════════════════════════════
       HERO
  ══════════════════════════════════════════ -->
  <section class="hero">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="hero-badge">
      <span class="badge-dot"></span>
      Sistem Kas RT Modern — Powered by AI
    </div>

    <h1 class="hero-headline">
      Kelola iuran RT<br>
      <em>tanpa ribet,</em><br>
      tanpa antre.
    </h1>

    <p class="hero-sub">
      Warga bayar lewat HP, struk dipindai otomatis oleh AI,
      bendahara verifikasi dalam satu klik. Transparansi penuh, real-time.
    </p>

    <div class="hero-cta">
      <a href="/login" class="btn-hero-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        Masuk ke Sistem
      </a>
      <a href="#fitur" class="btn-hero-ghost">
        Lihat Fitur
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
      </a>
    </div>

    <!-- Mock Dashboard Preview -->
    <div class="hero-visual">
      <div class="card-3d-wrap">
        <div class="card-3d">
          <!-- Browser chrome -->
          <div class="mock-topbar">
            <div class="mock-dots">
              <div class="mock-dot"></div>
              <div class="mock-dot"></div>
              <div class="mock-dot"></div>
            </div>
            <div class="mock-url">bukukasrt.up.railway.app/bendahara</div>
            <div style="width:56px"></div>
          </div>

          <!-- Dashboard body -->
          <div class="mock-body">
            <!-- Sidebar -->
            <div class="mock-sidebar">
              <div style="font-size:10px;color:rgba(255,255,255,.25);padding:4px 10px 8px;letter-spacing:.08em;text-transform:uppercase">Menu</div>
              <div class="mock-nav-item active"><span class="mock-nav-dot"></span>Dashboard</div>
              <div class="mock-nav-item"><span class="mock-nav-dot"></span>Verifikasi</div>
              <div class="mock-nav-item"><span class="mock-nav-dot"></span>Data Warga</div>
              <div class="mock-nav-item"><span class="mock-nav-dot"></span>Laporan</div>
              <div class="mock-nav-item"><span class="mock-nav-dot"></span>Pengaturan</div>
            </div>

            <!-- Main -->
            <div class="mock-main">
              <div class="mock-stats">
                <div class="mock-stat">
                  <div class="mock-stat-label">Total Kas RT</div>
                  <div class="mock-stat-value">12,4 Jt</div>
                  <div class="mock-stat-sub">↑ dari bulan lalu</div>
                </div>
                <div class="mock-stat">
                  <div class="mock-stat-label">Warga Lunas</div>
                  <div class="mock-stat-value teal">42<span style="font-size:13px;opacity:.5">/50</span></div>
                  <div class="mock-stat-sub">Juni 2025</div>
                </div>
                <div class="mock-stat">
                  <div class="mock-stat-label">Belum Bayar</div>
                  <div class="mock-stat-value danger">8</div>
                  <div class="mock-stat-sub">perlu tindakan</div>
                </div>
              </div>

              <div class="mock-table-header">Menunggu Verifikasi</div>

              <div class="mock-row">
                <div class="mock-avatar" style="background:linear-gradient(135deg,#3B82F6,#14B8A6)"></div>
                <div class="mock-name">Ibu Siti Rahmawati</div>
                <div class="mock-amount">Rp 50.000</div>
                <span class="chip chip-pending">Pending</span>
                <div class="mock-actions">
                  <div class="mock-btn mock-btn-approve">✓</div>
                  <div class="mock-btn mock-btn-reject">✕</div>
                </div>
              </div>
              <div class="mock-row">
                <div class="mock-avatar" style="background:linear-gradient(135deg,#8B5CF6,#EC4899)"></div>
                <div class="mock-name">Bapak Joko Susanto</div>
                <div class="mock-amount">Rp 50.000</div>
                <span class="chip chip-approved">✓ Lunas</span>
              </div>
              <div class="mock-row">
                <div class="mock-avatar" style="background:linear-gradient(135deg,#F59E0B,#EF4444)"></div>
                <div class="mock-name">Ibu Maya Kusuma</div>
                <div class="mock-amount">Rp 50.000</div>
                <span class="chip chip-pending">Pending</span>
                <div class="mock-actions">
                  <div class="mock-btn mock-btn-approve">✓</div>
                  <div class="mock-btn mock-btn-reject">✕</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-glow"></div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════
       STATS
  ══════════════════════════════════════════ -->
  <div class="stats-strip">
    <div class="stats-inner">
      <div class="stat-item reveal">
        <div class="stat-item-value">100%</div>
        <div class="stat-item-label">Transparansi keuangan RT</div>
      </div>
      <div class="stat-item reveal">
        <div class="stat-item-value">&lt;3 dtk</div>
        <div class="stat-item-label">Waktu scan struk oleh AI</div>
      </div>
      <div class="stat-item reveal">
        <div class="stat-item-value">0 antre</div>
        <div class="stat-item-label">Bayar kapan saja, dari mana saja</div>
      </div>
      <div class="stat-item reveal">
        <div class="stat-item-value">2 klik</div>
        <div class="stat-item-label">Verifikasi oleh bendahara</div>
      </div>
    </div>
  </div>

  <!-- ══════════════════════════════════════════
       FEATURES
  ══════════════════════════════════════════ -->
  <section class="features" id="fitur">
    <div class="section-label">Fitur Unggulan</div>
    <h2 class="section-title reveal">Dirancang untuk kemudahan warga dan bendahara.</h2>

    <div class="features-grid">
      <div class="feature-card reveal">
        <div class="feature-icon feature-icon-blue">
          <svg width="18" height="18" fill="none" stroke="#60A5FA" stroke-width="2" viewBox="0 0 24 24"><path d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg>
        </div>
        <div class="feature-title">OCR Struk Otomatis</div>
        <p class="feature-desc">AI membaca nominal transfer dari foto struk secara instan. Warga tidak perlu mengetik angka secara manual — cukup foto, kirim, selesai.</p>
      </div>

      <div class="feature-card reveal">
        <div class="feature-icon feature-icon-teal">
          <svg width="18" height="18" fill="none" stroke="#14B8A6" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="feature-title">Verifikasi Satu Klik</div>
        <p class="feature-desc">Bendahara cukup cocokkan nominal yang sudah dibaca AI, lalu klik Setujui atau Tolak. Tanpa kertas, tanpa spreadsheet manual.</p>
      </div>

      <div class="feature-card reveal">
        <div class="feature-icon feature-icon-purple">
          <svg width="18" height="18" fill="none" stroke="#A78BFA" stroke-width="2" viewBox="0 0 24 24"><path d="M16 8v8m-4-5v5m-4-2v2M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <div class="feature-title">Laporan Real-Time</div>
        <p class="feature-desc">Total kas, warga lunas, dan tunggakan tersedia setiap saat. Transparansi penuh untuk seluruh warga RT tanpa harus menunggu rapat bulanan.</p>
      </div>

      <div class="feature-card reveal">
        <div class="feature-icon feature-icon-amber">
          <svg width="18" height="18" fill="none" stroke="#FBB724" stroke-width="2" viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
        </div>
        <div class="feature-title">Akses dari HP</div>
        <p class="feature-desc">Tersedia sebagai APK yang bisa diinstall langsung di Android. Warga bayar iuran kapan saja tanpa perlu buka laptop atau antre ke bendahara.</p>
      </div>

      <div class="feature-card reveal">
        <div class="feature-icon feature-icon-blue">
          <svg width="18" height="18" fill="none" stroke="#60A5FA" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
        </div>
        <div class="feature-title">Manajemen Warga</div>
        <p class="feature-desc">Database warga RT terpusat. Bendahara bisa mengelola data penghuni, melihat riwayat pembayaran per warga, dan memantau tunggakan dengan mudah.</p>
      </div>

      <div class="feature-card reveal">
        <div class="feature-icon feature-icon-teal">
          <svg width="18" height="18" fill="none" stroke="#14B8A6" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
        </div>
        <div class="feature-title">Aman & Terenkripsi</div>
        <p class="feature-desc">Data warga disimpan di PostgreSQL terenkripsi. Akses terpisah untuk warga dan bendahara dengan sistem login berbasis role.</p>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════
       CTA
  ══════════════════════════════════════════ -->
  <section class="cta-section">
    <div class="cta-card reveal">
      <div class="cta-orb"></div>
      <h2 class="cta-title">Siap modernisasi<br>administrasi RT Anda?</h2>
      <p class="cta-sub">Mulai sekarang, gratis. Tidak perlu instalasi server — langsung pakai dari browser atau HP.</p>
      <div class="cta-buttons">
        <a href="/login" class="btn-hero-primary">
          Masuk ke Sistem →
        </a>
        <a href="/login" class="btn-hero-ghost">
          Lihat Demo
        </a>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════
       FOOTER
  ══════════════════════════════════════════ -->
  <footer>
    <div class="footer-brand">Kas Digital RT</div>
    <div class="footer-copy">© 2025 — Sistem Iuran Warga Modern</div>
  </footer>

  <script>
    /* Nav scroll */
    const nav = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
      nav.classList.toggle('scrolled', window.scrollY > 40);
    });

    /* Reveal on scroll */
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
          setTimeout(() => entry.target.classList.add('visible'), i * 60);
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
  </script>
</body>
</html>