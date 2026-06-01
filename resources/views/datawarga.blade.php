<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Dashboard Bendahara — Kas Digital RT</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=Geist:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    /* ═══════════════════════════════════════════
       DESIGN TOKENS
    ═══════════════════════════════════════════ */
    :root {
      --navy:        #0F2A4A;
      --navy-mid:    #1A3D6B;
      --navy-light:  #234E8C;
      --blue:        #1E6FD9;
      --blue-soft:   #E8F1FB;
      --teal:        #0EA882;
      --teal-soft:   #D6F5EE;
      --red:         #E53535;
      --red-soft:    #FDE8E8;
      --amber:       #F59E0B;
      --amber-soft:  #FEF3C7;
      --ink:         #0D1B2A;
      --ink-mid:     #4A6074;
      --ink-soft:    #8FA3B8;
      --surface:     #F4F7FB;
      --white:       #FFFFFF;
      --border:      #DDE6F0;
      --sidebar-w:   240px;
      --header-h:    64px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Geist', 'Segoe UI', sans-serif;
      background: var(--surface);
      color: var(--ink);
      display: flex;
      min-height: 100vh;
      font-size: 14px;
    }

    /* ═══════════════════════════════════════════
       SIDEBAR
    ═══════════════════════════════════════════ */
    .sidebar {
      width: var(--sidebar-w);
      background: var(--navy);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0; left: 0;
      z-index: 100;
      animation: sideIn .4s cubic-bezier(.22,.68,0,1) both;
    }

    @keyframes sideIn {
      from { transform: translateX(-100%); opacity: 0; }
      to   { transform: translateX(0);     opacity: 1; }
    }

    .sidebar-brand {
      padding: 22px 24px 20px;
      border-bottom: 1px solid rgba(255,255,255,.08);
    }

    .brand-name {
      font-family: 'Syne', sans-serif;
      font-size: 17px;
      font-weight: 700;
      color: #fff;
      line-height: 1.2;
    }

    .brand-sub {
      font-size: 11px;
      color: rgba(255,255,255,.45);
      margin-top: 2px;
      letter-spacing: .04em;
    }

    .sidebar-nav {
      flex: 1;
      padding: 16px 12px;
      display: flex;
      flex-direction: column;
      gap: 2px;
    }

    .nav-section-label {
      font-size: 10px;
      font-weight: 600;
      letter-spacing: .1em;
      text-transform: uppercase;
      color: rgba(255,255,255,.3);
      padding: 12px 12px 6px;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 12px;
      border-radius: 8px;
      color: rgba(255,255,255,.6);
      text-decoration: none;
      font-size: 13.5px;
      font-weight: 500;
      transition: background .15s, color .15s;
      cursor: pointer;
    }

    .nav-item:hover {
      background: rgba(255,255,255,.07);
      color: rgba(255,255,255,.9);
    }

    .nav-item.active {
      background: var(--blue);
      color: #fff;
    }

    .nav-item svg { flex-shrink: 0; opacity: .85; }
    .nav-item.active svg { opacity: 1; }

    .nav-badge {
      margin-left: auto;
      background: var(--red);
      color: #fff;
      font-size: 10px;
      font-weight: 700;
      padding: 1px 6px;
      border-radius: 99px;
      min-width: 18px;
      text-align: center;
    }

    .sidebar-footer {
      padding: 16px 12px;
      border-top: 1px solid rgba(255,255,255,.08);
    }

    .user-card {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 12px;
      border-radius: 8px;
      background: rgba(255,255,255,.05);
    }

    .user-avatar {
      width: 32px; height: 32px;
      border-radius: 50%;
      background: var(--blue);
      display: flex; align-items: center; justify-content: center;
      font-size: 12px;
      font-weight: 700;
      color: #fff;
      flex-shrink: 0;
    }

    .user-info { overflow: hidden; }
    .user-name  { font-size: 13px; font-weight: 600; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .user-role  { font-size: 11px; color: rgba(255,255,255,.4); }

    /* ═══════════════════════════════════════════
       MAIN CONTENT
    ═══════════════════════════════════════════ */
    .main {
      margin-left: var(--sidebar-w);
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    /* TOPBAR */
    .topbar {
      height: var(--header-h);
      background: var(--white);
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 32px;
      position: sticky;
      top: 0;
      z-index: 50;
    }

    .topbar-title {
      font-family: 'Syne', sans-serif;
      font-size: 18px;
      font-weight: 700;
      color: var(--navy);
    }

    .topbar-right {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .topbar-date {
      font-size: 12px;
      color: var(--ink-soft);
      background: var(--surface);
      border: 1px solid var(--border);
      padding: 5px 12px;
      border-radius: 6px;
    }

    /* PAGE CONTENT */
    .content {
      padding: 28px 32px;
      display: flex;
      flex-direction: column;
      gap: 24px;
    }

    /* ═══════════════════════════════════════════
       ALERT BANNER
    ═══════════════════════════════════════════ */
    .alert-banner {
      background: var(--teal-soft);
      border: 1px solid rgba(14,168,130,.25);
      border-radius: 10px;
      padding: 12px 18px;
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 13.5px;
      font-weight: 500;
      color: #0A6B51;
      animation: fadeDown .4s ease both;
    }

    @keyframes fadeDown {
      from { opacity: 0; transform: translateY(-8px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .alert-banner strong { font-weight: 700; }

    /* ═══════════════════════════════════════════
       METRIC CARDS
    ═══════════════════════════════════════════ */
    .metrics-row {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 16px;
    }

    .metric-card {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 22px 24px;
      display: flex;
      flex-direction: column;
      gap: 6px;
      animation: cardIn .45s cubic-bezier(.22,.68,0,1) both;
      transition: box-shadow .2s, transform .2s;
    }

    .metric-card:hover {
      box-shadow: 0 8px 24px rgba(15,42,74,.08);
      transform: translateY(-2px);
    }

    .metric-card:nth-child(1) { animation-delay: .05s; }
    .metric-card:nth-child(2) { animation-delay: .10s; }
    .metric-card:nth-child(3) { animation-delay: .15s; }

    @keyframes cardIn {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .metric-label {
      font-size: 11px;
      font-weight: 600;
      letter-spacing: .06em;
      text-transform: uppercase;
      color: var(--ink-soft);
    }

    .metric-value {
      font-family: 'Syne', sans-serif;
      font-size: 28px;
      font-weight: 700;
      color: var(--navy);
      line-height: 1.1;
    }

    .metric-value.danger  { color: var(--red); }
    .metric-value.warning { color: var(--amber); }

    .metric-sub {
      font-size: 12px;
      color: var(--ink-soft);
      margin-top: 2px;
    }

    .metric-sub .up   { color: var(--teal);   font-weight: 600; }
    .metric-sub .down { color: var(--red);     font-weight: 600; }

    /* ═══════════════════════════════════════════
       VERIFICATION TABLE
    ═══════════════════════════════════════════ */
    .section-card {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 14px;
      overflow: hidden;
      animation: cardIn .5s cubic-bezier(.22,.68,0,1) .2s both;
    }

    .section-header {
      padding: 18px 24px;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .section-title {
      font-family: 'Syne', sans-serif;
      font-size: 15px;
      font-weight: 700;
      color: var(--navy);
    }

    .section-sub {
      font-size: 12px;
      color: var(--ink-soft);
      margin-top: 2px;
    }

    .search-box {
      display: flex;
      align-items: center;
      gap: 8px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 8px;
      padding: 7px 12px;
    }

    .search-box input {
      border: none;
      background: transparent;
      outline: none;
      font-family: 'Geist', sans-serif;
      font-size: 13px;
      color: var(--ink);
      width: 180px;
    }

    .search-box input::placeholder { color: var(--ink-soft); }

    /* TABLE */
    table {
      width: 100%;
      border-collapse: collapse;
    }

    thead th {
      background: var(--surface);
      padding: 11px 16px;
      text-align: left;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: .06em;
      text-transform: uppercase;
      color: var(--ink-soft);
      border-bottom: 1px solid var(--border);
    }

    tbody tr {
      border-bottom: 1px solid var(--border);
      transition: background .12s;
    }

    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: var(--surface); }

    tbody td {
      padding: 13px 16px;
      font-size: 13.5px;
      vertical-align: middle;
    }

    .td-nama { font-weight: 600; color: var(--navy); }
    .td-nominal { font-weight: 700; color: var(--ink); font-variant-numeric: tabular-nums; }
    .td-waktu { color: var(--ink-soft); font-size: 12.5px; }

    /* Status badge */
    .badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 4px 10px;
      border-radius: 99px;
      font-size: 11.5px;
      font-weight: 600;
    }

    .badge-pending  { background: var(--amber-soft); color: #92400E; }
    .badge-approved { background: var(--teal-soft);  color: #065F46; }
    .badge-rejected { background: var(--red-soft);   color: #991B1B; }

    .badge-dot {
      width: 5px; height: 5px;
      border-radius: 50%;
      background: currentColor;
    }

    /* Action buttons */
    .action-group {
      display: flex;
      gap: 6px;
    }

    .btn-action {
      padding: 5px 12px;
      border-radius: 6px;
      border: none;
      font-family: 'Geist', sans-serif;
      font-size: 12px;
      font-weight: 600;
      cursor: pointer;
      transition: opacity .15s, transform .1s;
    }

    .btn-action:hover   { opacity: .85; transform: translateY(-1px); }
    .btn-action:active  { transform: translateY(0); }

    .btn-setuju { background: var(--teal); color: #fff; }
    .btn-tolak  { background: var(--red);  color: #fff; }
    .btn-lihat  { background: var(--blue-soft); color: var(--blue); }

    /* Struk thumbnail */
    .struk-thumb {
      width: 36px; height: 36px;
      border-radius: 6px;
      background: var(--surface);
      border: 1px solid var(--border);
      object-fit: cover;
      cursor: pointer;
      transition: transform .15s;
    }
    .struk-thumb:hover { transform: scale(1.1); }

    /* ═══════════════════════════════════════════
       MODAL PREVIEW
    ═══════════════════════════════════════════ */
    .modal-overlay {
      display: none;
      position: fixed; inset: 0;
      background: rgba(10,20,35,.6);
      backdrop-filter: blur(4px);
      z-index: 200;
      align-items: center;
      justify-content: center;
    }
    .modal-overlay.open { display: flex; }

    .modal-box {
      background: var(--white);
      border-radius: 16px;
      width: 420px;
      max-width: 90vw;
      overflow: hidden;
      animation: popIn .25s cubic-bezier(.22,.68,0,1.2) both;
    }

    @keyframes popIn {
      from { opacity: 0; transform: scale(.9); }
      to   { opacity: 1; transform: scale(1); }
    }

    .modal-header {
      padding: 16px 20px;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .modal-title { font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700; color: var(--navy); }
    .modal-close { background: none; border: none; font-size: 20px; cursor: pointer; color: var(--ink-soft); line-height: 1; }
    .modal-close:hover { color: var(--ink); }

    .modal-body { padding: 20px; }
    .modal-img { width: 100%; border-radius: 8px; border: 1px solid var(--border); }

    .modal-detail {
      margin-top: 16px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
    }

    .detail-item label { font-size: 11px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; color: var(--ink-soft); display: block; margin-bottom: 3px; }
    .detail-item span  { font-size: 14px; font-weight: 600; color: var(--navy); }

    .modal-actions {
      padding: 16px 20px;
      border-top: 1px solid var(--border);
      display: flex;
      gap: 10px;
    }

    .modal-actions .btn-action { flex: 1; padding: 10px; font-size: 13px; }

    /* ═══════════════════════════════════════════
       TOAST NOTIFICATION
    ═══════════════════════════════════════════ */
    .toast {
      position: fixed;
      bottom: 24px; right: 24px;
      background: var(--navy);
      color: #fff;
      padding: 12px 18px;
      border-radius: 10px;
      font-size: 13.5px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 8px;
      z-index: 999;
      opacity: 0;
      transform: translateY(12px);
      transition: opacity .25s, transform .25s;
      pointer-events: none;
    }
    .toast.show { opacity: 1; transform: translateY(0); }
    .toast.success { background: var(--teal); }
    .toast.error   { background: var(--red); }
  </style>
</head>
<body>

  <!-- ════════════════════════════════════════
       SIDEBAR
  ════════════════════════════════════════ -->
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="brand-name">Kas Digital RT</div>
      <div class="brand-sub">Panel Bendahara</div>
    </div>

    <nav class="sidebar-nav">
      <div class="nav-section-label">Utama</div>

      <a class="nav-item active" href="{{ url('/datawarga') }}">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
        Dashboard
      </a>

      <a class="nav-item" href="{{ url('/bendahara/verifikasi-pembayaran') }}">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4"/><path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Verifikasi Pembayaran
        <span class="nav-badge" id="sidebarBadge">3</span>
      </a>

      <div class="nav-section-label">Manajemen</div>

      <a class="nav-item" href="{{ url('/bendahara/data-warga') }}">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
        Data Warga
      </a>

      <a class="nav-item" href="{{ url('/bendahara/pemasukan') }}">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
        Pemasukan Kas
      </a>

      <a class="nav-item" href="{{ url('/bendahara/laporan') }}">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
        Laporan Keuangan
      </a>

      <div class="nav-section-label">Sistem</div>

      <a class="nav-item" href="{{ url('/bendahara/pengaturan') }}">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93l-1.41 1.41M4.93 4.93l1.41 1.41M4.93 19.07l1.41-1.41M19.07 19.07l-1.41-1.41M1 12h2M21 12h2M12 1v2M12 21v2"/></svg>
        Pengaturan
      </a>
    </nav>

    <div class="sidebar-footer">
      <div class="user-card">
        <div class="user-avatar">BH</div>
        <div class="user-info">
          <div class="user-name">Pak Ahmad Hidayat</div>
          <div class="user-role">Bendahara RT 05</div>
        </div>
      </div>
    </div>
  </aside>

  <!-- ════════════════════════════════════════
       MAIN
  ════════════════════════════════════════ -->
  <div class="main">

    <!-- TOPBAR -->
    <header class="topbar">
      <div class="topbar-title">Dashboard Bendahara</div>
      <div class="topbar-right">
        <div class="topbar-date" id="todayDate">—</div>
      </div>
    </header>

    <!-- CONTENT -->
    <div class="content">
      <div class="section-card">
        <div class="section-header">
          <div>
            <div class="section-title">Data Warga RT 05</div>
            <div class="section-sub">Kelola informasi warga dan pantau status iuran</div>
          </div>
          <div class="action-group">
            <div class="search-box">
              <svg width="14" height="14" fill="none" stroke="var(--ink-soft)" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
              <input type="text" placeholder="Cari warga/no rumah...">
            </div>
            <button class="btn-action btn-setuju" style="padding: 8px 16px;">+ Tambah Warga</button>
          </div>
        </div>
        <table>
          <thead>
            <tr>
              <th>No. Rumah</th>
              <th>Nama Kepala Keluarga</th>
              <th>No. WhatsApp</th>
              <th>Status Bulan Ini</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="td-nominal">A-01</td>
              <td class="td-nama">Bapak Budi Santoso</td>
              <td>0812-3456-7890</td>
              <td><span class="badge badge-approved"><span class="badge-dot"></span>Lunas</span></td>
              <td><button class="btn-action btn-lihat">Edit</button></td>
            </tr>
            <tr>
              <td class="td-nominal">A-02</td>
              <td class="td-nama">Ibu Siti Aminah</td>
              <td>0812-9876-5432</td>
              <td><span class="badge badge-rejected"><span class="badge-dot"></span>Belum Bayar</span></td>
              <td><button class="btn-action btn-lihat">Edit</button></td>
            </tr>
            <tr>
              <td class="td-nominal">A-03</td>
              <td class="td-nama">Bapak Andi Wijaya</td>
              <td>0857-1122-3344</td>
              <td><span class="badge badge-pending"><span class="badge-dot"></span>Menunggu Verifikasi</span></td>
              <td><button class="btn-action btn-lihat">Edit</button></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  <!-- ════════════════════════════════════════
       MODAL DETAIL STRUK
  ════════════════════════════════════════ -->
  <div class="modal-overlay" id="modalOverlay" onclick="closeModal(event)">
    <div class="modal-box">
      <div class="modal-header">
        <div class="modal-title" id="modalTitle">Detail Pembayaran</div>
        <button class="modal-close" onclick="closeModalDirect()">×</button>
      </div>
      <div class="modal-body">
        <div id="modalImgWrap" style="background:var(--surface);border-radius:8px;border:1px solid var(--border);height:200px;display:flex;align-items:center;justify-content:center;">
          <svg width="48" height="48" fill="none" stroke="var(--ink-soft)" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        </div>
        <div class="modal-detail" id="modalDetail"></div>
      </div>
      <div class="modal-actions">
        <button class="btn-action btn-tolak"  id="modalBtnTolak"  onclick="aksiBendahara('tolak')">✕ Tolak</button>
        <button class="btn-action btn-setuju" id="modalBtnSetuju" onclick="aksiBendahara('setuju')">✓ Setujui</button>
      </div>
    </div>
  </div>

  <!-- TOAST -->
  <div class="toast" id="toast"></div>

  <!-- ════════════════════════════════════════
       JAVASCRIPT
  ════════════════════════════════════════ -->
  <script>
    /* ── Tanggal ─────────────────────────────── */
    const opts = { weekday:'long', year:'numeric', month:'long', day:'numeric' };
    document.getElementById('todayDate').textContent =
      new Date().toLocaleDateString('id-ID', opts);

    /* ── Data dummy (nanti diganti fetch dari Laravel API) ── */
    let transaksiData = [];

    let activeId = null;

    /* ── Render tabel ─────────────────────────── */
    function renderTable(data) {
      const tbody = document.getElementById('tableBody');
      tbody.innerHTML = '';

      data.forEach(t => {
        const statusMap = {
          pending:  `<span class="badge badge-pending"><span class="badge-dot"></span>Menunggu</span>`,
          approved: `<span class="badge badge-approved"><span class="badge-dot"></span>Disetujui</span>`,
          rejected: `<span class="badge badge-rejected"><span class="badge-dot"></span>Ditolak</span>`,
        };

        const aksiMap = {
          pending:  `<div class="action-group">
                       <button class="btn-action btn-lihat"  onclick="bukaModal(${t.id})">Lihat</button>
                       <button class="btn-action btn-setuju" onclick="aksiBendaharaInline(${t.id},'setuju')">✓</button>
                       <button class="btn-action btn-tolak"  onclick="aksiBendaharaInline(${t.id},'tolak')">✕</button>
                     </div>`,
          approved: `<span style="color:var(--teal);font-weight:600;font-size:12px;">✓ Selesai</span>`,
          rejected: `<span style="color:var(--red);font-weight:600;font-size:12px;">✕ Ditolak</span>`,
        };

        const row = document.createElement('tr');
        row.id = `row-${t.id}`;
        row.innerHTML = `
          <td class="td-nama">${t.nama}</td>
          <td>${t.periode}</td>
          <td class="td-nominal">Rp ${t.nominal.toLocaleString('id-ID')}</td>
          <td class="td-waktu">${t.waktu}</td>
          <td>
            <div style="width:36px;height:36px;background:var(--surface);border:1px solid var(--border);border-radius:6px;display:flex;align-items:center;justify-content:center;cursor:pointer;" onclick="bukaModal(${t.id})">
              <svg width="16" height="16" fill="none" stroke="var(--ink-soft)" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            </div>
          </td>
          <td>${statusMap[t.status]}</td>
          <td>${aksiMap[t.status]}</td>
        `;
        tbody.appendChild(row);
      });

      /* Update badge & alert */
      const pendingCount = transaksiData.filter(t => t.status === 'pending').length;
      document.getElementById('alertCount').textContent  = pendingCount;
      document.getElementById('sidebarBadge').textContent = pendingCount;
      document.getElementById('alertBanner').style.display = pendingCount ? 'flex' : 'none';
    }

    renderTable(transaksiData);

    /* ── Filter / search ─────────────────────── */
    function filterTable() {
      const q = document.getElementById('searchInput').value.toLowerCase();
      renderTable(transaksiData.filter(t => t.nama.toLowerCase().includes(q)));
    }

    /* ── Buka modal ──────────────────────────── */
    function bukaModal(id) {
      activeId = id;
      const t = transaksiData.find(x => x.id === id);
      document.getElementById('modalTitle').textContent = `Detail — ${t.nama}`;
      document.getElementById('modalDetail').innerHTML = `
        <div class="detail-item"><label>Nama</label><span>${t.nama}</span></div>
        <div class="detail-item"><label>Periode</label><span>${t.periode}</span></div>
        <div class="detail-item"><label>Nominal (AI OCR)</label><span>Rp ${t.nominal.toLocaleString('id-ID')}</span></div>
        <div class="detail-item"><label>Waktu Upload</label><span>${t.waktu}</span></div>
      `;
      /* Tombol aksi di modal */
      const isPending = t.status === 'pending';
      document.getElementById('modalBtnSetuju').style.display = isPending ? '' : 'none';
      document.getElementById('modalBtnTolak').style.display  = isPending ? '' : 'none';
      document.getElementById('modalOverlay').classList.add('open');
    }

    function closeModal(e) {
      if (e.target === document.getElementById('modalOverlay')) closeModalDirect();
    }
    function closeModalDirect() {
      document.getElementById('modalOverlay').classList.remove('open');
      activeId = null;
    }

    /* ── Aksi dari modal ─────────────────────── */
    function aksiBendahara(aksi) {
      if (activeId === null) return;
      prosesAksi(activeId, aksi);
      closeModalDirect();
    }

    /* ── Aksi inline (langsung dari tabel) ────── */
    function aksiBendaharaInline(id, aksi) {
      prosesAksi(id, aksi);
    }

    /* ── Proses aksi (kirim ke Laravel) ─────── */
    async function prosesAksi(id, aksi) {
      const t = transaksiData.find(x => x.id === id);
      if (!t) return;

      /* Update lokal dulu (optimistic UI) */
      t.status = aksi === 'setuju' ? 'approved' : 'rejected';
      renderTable(transaksiData);

      tampilToast(
        aksi === 'setuju'
          ? `✓ Pembayaran ${t.nama} disetujui`
          : `✕ Pembayaran ${t.nama} ditolak`,
        aksi === 'setuju' ? 'success' : 'error'
      );

      /* Kirim ke backend Laravel:
         POST /api/transaksi/{id}/verifikasi
         body: { aksi: 'setuju'|'tolak' }
      */
      try {
        await fetch(`/api/transaksi/${id}/verifikasi`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content ?? '',
          },
          body: JSON.stringify({ aksi }),
        });
      } catch (err) {
        console.error('Gagal kirim verifikasi ke server:', err);
      }
    }

    /* ── Toast ───────────────────────────────── */
    function tampilToast(pesan, tipe = '') {
      const el = document.getElementById('toast');
      el.textContent = pesan;
      el.className   = `toast ${tipe} show`;
      setTimeout(() => el.classList.remove('show'), 3000);
    }
  </script>
</body>
</html>