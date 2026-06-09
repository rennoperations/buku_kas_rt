<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Data Warga — Kas Digital RT</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=Geist:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --navy:       #0F2A4A;
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
      --sidebar-w:  240px;
      --header-h:   64px;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Geist','Segoe UI',sans-serif; background: var(--surface); color: var(--ink); display: flex; min-height: 100vh; font-size: 14px; }

    /* ── SIDEBAR ── */
    .sidebar { width: var(--sidebar-w); background: var(--navy); min-height: 100vh; display: flex; flex-direction: column; position: fixed; top: 0; left: 0; z-index: 100; }
    .sidebar-brand { padding: 22px 24px 20px; border-bottom: 1px solid rgba(255,255,255,.08); }
    .brand-name { font-family: 'Syne',sans-serif; font-size: 17px; font-weight: 700; color: #fff; }
    .brand-sub  { font-size: 11px; color: rgba(255,255,255,.45); margin-top: 2px; }
    .sidebar-nav { flex: 1; padding: 16px 12px; display: flex; flex-direction: column; gap: 2px; }
    .nav-section-label { font-size: 10px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: rgba(255,255,255,.3); padding: 12px 12px 6px; }
    .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 8px; color: rgba(255,255,255,.6); text-decoration: none; font-size: 13.5px; font-weight: 500; transition: background .15s, color .15s; }
    .nav-item:hover { background: rgba(255,255,255,.07); color: rgba(255,255,255,.9); }
    .nav-item.active { background: var(--blue); color: #fff; }
    .nav-badge { margin-left: auto; background: var(--red); color: #fff; font-size: 10px; font-weight: 700; padding: 1px 6px; border-radius: 99px; }
    .sidebar-footer { padding: 16px 12px; border-top: 1px solid rgba(255,255,255,.08); }
    .user-card { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 8px; background: rgba(255,255,255,.05); }
    .user-avatar { width: 32px; height: 32px; border-radius: 50%; background: var(--blue); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: #fff; }
    .user-name { font-size: 13px; font-weight: 600; color: #fff; }
    .user-role { font-size: 11px; color: rgba(255,255,255,.4); }

    /* ── MAIN ── */
    .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; }
    .topbar { height: var(--header-h); background: var(--white); border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 32px; position: sticky; top: 0; z-index: 50; }
    .topbar-title { font-family: 'Syne',sans-serif; font-size: 18px; font-weight: 700; color: var(--navy); }
    .topbar-date  { font-size: 12px; color: var(--ink-soft); background: var(--surface); border: 1px solid var(--border); padding: 5px 12px; border-radius: 6px; }
    .content { padding: 28px 32px; display: flex; flex-direction: column; gap: 24px; }

    /* ── FLASH MESSAGES ── */
    .flash { padding: 12px 18px; border-radius: 10px; font-size: 13.5px; font-weight: 500; display: flex; align-items: center; gap: 8px; }
    .flash-success { background: var(--teal-soft); color: #065F46; border: 1px solid rgba(14,168,130,.25); }
    .flash-error   { background: var(--red-soft);  color: #991B1B; border: 1px solid rgba(229,53,53,.25); }

    /* ── SECTION CARD ── */
    .section-card { background: var(--white); border: 1px solid var(--border); border-radius: 14px; overflow: hidden; }
    .section-header { padding: 18px 24px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
    .section-title { font-family: 'Syne',sans-serif; font-size: 15px; font-weight: 700; color: var(--navy); }
    .section-sub   { font-size: 12px; color: var(--ink-soft); margin-top: 2px; }
    .action-group  { display: flex; gap: 8px; align-items: center; }
    .search-box { display: flex; align-items: center; gap: 8px; background: var(--surface); border: 1px solid var(--border); border-radius: 8px; padding: 7px 12px; }
    .search-box input { border: none; background: transparent; outline: none; font-family: 'Geist',sans-serif; font-size: 13px; color: var(--ink); width: 180px; }
    .search-box input::placeholder { color: var(--ink-soft); }

    /* ── TABLE ── */
    table { width: 100%; border-collapse: collapse; }
    thead th { background: var(--surface); padding: 11px 16px; text-align: left; font-size: 11px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: var(--ink-soft); border-bottom: 1px solid var(--border); }
    tbody tr { border-bottom: 1px solid var(--border); transition: background .12s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: var(--surface); }
    tbody td { padding: 13px 16px; font-size: 13.5px; vertical-align: middle; }
    .td-nama    { font-weight: 600; color: var(--navy); }
    .td-nominal { font-weight: 700; font-variant-numeric: tabular-nums; }
    .td-muted   { color: var(--ink-soft); font-size: 12.5px; }
    .empty-row td { text-align: center; color: var(--ink-soft); padding: 40px; }

    /* ── BADGES ── */
    .badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 99px; font-size: 11.5px; font-weight: 600; }
    .badge-pending  { background: var(--amber-soft); color: #92400E; }
    .badge-approved { background: var(--teal-soft);  color: #065F46; }
    .badge-rejected { background: var(--red-soft);   color: #991B1B; }
    .badge-belum    { background: var(--surface);    color: var(--ink-soft); border: 1px solid var(--border); }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }

    /* ── BUTTONS ── */
    .btn-action { padding: 5px 12px; border-radius: 6px; border: none; font-family: 'Geist',sans-serif; font-size: 12px; font-weight: 600; cursor: pointer; transition: opacity .15s, transform .1s; }
    .btn-action:hover  { opacity: .85; transform: translateY(-1px); }
    .btn-action:active { transform: translateY(0); }
    .btn-primary { background: var(--blue); color: #fff; padding: 8px 18px; font-size: 13px; }
    .btn-edit    { background: var(--blue-soft); color: var(--blue); }
    .btn-hapus   { background: var(--red-soft);  color: var(--red); }

    /* ── MODAL ── */
    .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(10,20,35,.55); backdrop-filter: blur(4px); z-index: 200; align-items: center; justify-content: center; }
    .modal-overlay.open { display: flex; }
    .modal-box { background: var(--white); border-radius: 16px; width: 460px; max-width: 95vw; overflow: hidden; animation: popIn .25s cubic-bezier(.22,.68,0,1.2) both; }
    @keyframes popIn { from { opacity: 0; transform: scale(.92); } to { opacity: 1; transform: scale(1); } }
    .modal-header { padding: 18px 24px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
    .modal-title  { font-family: 'Syne',sans-serif; font-size: 16px; font-weight: 700; color: var(--navy); }
    .modal-close  { background: none; border: none; font-size: 22px; cursor: pointer; color: var(--ink-soft); line-height: 1; }
    .modal-close:hover { color: var(--ink); }
    .modal-body   { padding: 24px; display: flex; flex-direction: column; gap: 16px; }
    .modal-footer { padding: 16px 24px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px; }

    /* ── FORM ── */
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group label { font-size: 11.5px; font-weight: 600; letter-spacing: .04em; color: var(--ink-mid); text-transform: uppercase; }
    .form-group input { padding: 9px 12px; border: 1px solid var(--border); border-radius: 8px; font-family: 'Geist',sans-serif; font-size: 13.5px; color: var(--ink); outline: none; transition: border-color .15s, box-shadow .15s; background: var(--surface); }
    .form-group input:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(30,111,217,.12); background: var(--white); }
    .form-group .hint { font-size: 11px; color: var(--ink-soft); }
    .form-group input.error { border-color: var(--red); }

    /* ── MODAL KONFIRMASI HAPUS ── */
    .confirm-box { background: var(--white); border-radius: 16px; width: 380px; max-width: 95vw; overflow: hidden; animation: popIn .25s cubic-bezier(.22,.68,0,1.2) both; padding: 28px; text-align: center; display: flex; flex-direction: column; gap: 16px; align-items: center; }
    .confirm-icon { width: 52px; height: 52px; border-radius: 50%; background: var(--red-soft); display: flex; align-items: center; justify-content: center; }
    .confirm-title { font-family: 'Syne',sans-serif; font-size: 17px; font-weight: 700; color: var(--navy); }
    .confirm-sub   { font-size: 13.5px; color: var(--ink-mid); line-height: 1.5; }
    .confirm-actions { display: flex; gap: 10px; width: 100%; }
    .confirm-actions button { flex: 1; padding: 10px; font-size: 13px; }
    .btn-cancel { background: var(--surface); color: var(--ink-mid); border: 1px solid var(--border); border-radius: 8px; font-family: 'Geist',sans-serif; font-weight: 600; cursor: pointer; transition: background .15s; }
    .btn-cancel:hover { background: var(--border); }

    /* ── TOAST ── */
    .toast { position: fixed; bottom: 24px; right: 24px; background: var(--navy); color: #fff; padding: 12px 18px; border-radius: 10px; font-size: 13.5px; font-weight: 500; z-index: 999; opacity: 0; transform: translateY(12px); transition: opacity .25s, transform .25s; pointer-events: none; }
    .toast.show { opacity: 1; transform: translateY(0); }
    .toast.success { background: var(--teal); }
    .toast.error   { background: var(--red); }
  </style>
</head>
<body>

  <!-- ════ SIDEBAR ════ -->
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="brand-name">Kas Digital RT</div>
      <div class="brand-sub">Panel Bendahara</div>
    </div>
    <nav class="sidebar-nav">
      <div class="nav-section-label">Utama</div>
      <a class="nav-item" href="{{ url('/bendahara') }}">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
        Dashboard
      </a>
      <a class="nav-item" href="{{ url('/bendahara/verifikasi-pembayaran') }}">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="10"/></svg>
        Verifikasi Pembayaran
      </a>
      <div class="nav-section-label">Manajemen</div>
      <a class="nav-item active" href="{{ url('/bendahara/data-warga') }}">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
        Data Warga
      </a>
      <a class="nav-item" href="{{ url('/bendahara/pemasukan') }}">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
        Pemasukan Kas
      </a>
      <a class="nav-item" href="{{ url('/bendahara/laporan') }}">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
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
        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
        <div>
          <div class="user-name">{{ Auth::user()->name }}</div>
          <div class="user-role">Bendahara RT</div>
        </div>
      </div>
    </div>
  </aside>

  <!-- ════ MAIN ════ -->
  <div class="main">
    <header class="topbar">
      <div class="topbar-title">Data Warga</div>
      <div class="topbar-date" id="todayDate">—</div>
    </header>

    <div class="content">

      {{-- Flash Messages --}}
      @if(session('success'))
        <div class="flash flash-success">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
          {{ session('success') }}
        </div>
      @endif
      @if(session('error') || $errors->any())
        <div class="flash flash-error">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          {{ session('error') ?? $errors->first() }}
        </div>
      @endif

      <!-- Tabel Warga -->
      <div class="section-card">
        <div class="section-header">
          <div>
            <div class="section-title">Data Warga RT</div>
            <div class="section-sub">Total {{ $warga->count() }} warga terdaftar</div>
          </div>
          <div class="action-group">
            <!-- Search langsung via GET -->
            <form method="GET" action="{{ url('/bendahara/data-warga') }}" style="display:flex;">
              <div class="search-box">
                <svg width="14" height="14" fill="none" stroke="var(--ink-soft)" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" name="q" placeholder="Cari nama/no rumah..." value="{{ request('q') }}">
              </div>
            </form>
            <button class="btn-action btn-primary" onclick="bukaModalTambah()">+ Tambah Warga</button>
          </div>
        </div>

        <table>
          <thead>
            <tr>
              <th>No. Rumah</th>
              <th>Nama Kepala Keluarga</th>
              <th>Email</th>
              <th>No. WhatsApp</th>
              <th>Status Bulan Ini</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($warga as $w)
            <tr>
              <td class="td-nominal">{{ $w->no_rumah }}</td>
              <td class="td-nama">{{ $w->name }}</td>
              <td class="td-muted">{{ $w->email }}</td>
              <td>{{ $w->no_wa ?? '—' }}</td>
              <td>
                @php
                  $status = $w->status_bulan_ini;
                  $labelMap = ['approved'=>'Lunas','pending'=>'Menunggu Verifikasi','rejected'=>'Ditolak','belum'=>'Belum Bayar'];
                  $classMap = ['approved'=>'badge-approved','pending'=>'badge-pending','rejected'=>'badge-rejected','belum'=>'badge-belum'];
                @endphp
                <span class="badge {{ $classMap[$status] ?? 'badge-belum' }}">
                  <span class="badge-dot"></span>
                  {{ $labelMap[$status] ?? 'Belum Bayar' }}
                </span>
              </td>
              <td>
                <div class="action-group">
                  <button class="btn-action btn-edit"
                    onclick="bukaModalEdit(
                      {{ $w->id }},
                      '{{ addslashes($w->name) }}',
                      '{{ $w->email }}',
                      '{{ $w->no_rumah }}',
                      '{{ $w->no_wa ?? '' }}'
                    )">Edit</button>
                  <button class="btn-action btn-hapus"
                    onclick="bukaKonfirmasiHapus({{ $w->id }}, '{{ addslashes($w->name) }}')">Hapus</button>
                </div>
              </td>
            </tr>
            @empty
            <tr class="empty-row">
              <td colspan="6">
                <svg width="40" height="40" fill="none" stroke="var(--border)" stroke-width="1.5" viewBox="0 0 24 24" style="margin-bottom:8px;display:block;margin-left:auto;margin-right:auto;"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                Belum ada warga terdaftar
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div><!-- /content -->
  </div><!-- /main -->


  <!-- ════ MODAL TAMBAH WARGA ════ -->
  <div class="modal-overlay" id="modalTambah" onclick="tutupJikaLuar(event,'modalTambah')">
    <div class="modal-box">
      <div class="modal-header">
        <div class="modal-title">Tambah Warga Baru</div>
        <button class="modal-close" onclick="tutupModal('modalTambah')">×</button>
      </div>
      <form method="POST" action="{{ url('/bendahara/data-warga') }}">
        @csrf
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group">
              <label>Nama Lengkap *</label>
              <input type="text" name="name" placeholder="Bapak Budi Santoso" required>
            </div>
            <div class="form-group">
              <label>No. Rumah *</label>
              <input type="text" name="no_rumah" placeholder="A-01" required maxlength="10">
            </div>
          </div>
          <div class="form-group">
            <label>Email *</label>
            <input type="email" name="email" placeholder="budi@email.com" required>
          </div>
          <div class="form-group">
            <label>No. WhatsApp</label>
            <input type="text" name="no_wa" placeholder="0812-3456-7890" maxlength="20">
          </div>
          <div class="form-group">
            <label>Password *</label>
            <input type="password" name="password" placeholder="Min 6 karakter" required minlength="6">
            <span class="hint">Password untuk login warga ke aplikasi</span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-cancel" onclick="tutupModal('modalTambah')">Batal</button>
          <button type="submit" class="btn-action btn-primary">Simpan Warga</button>
        </div>
      </form>
    </div>
  </div>

  <!-- ════ MODAL EDIT WARGA ════ -->
  <div class="modal-overlay" id="modalEdit" onclick="tutupJikaLuar(event,'modalEdit')">
    <div class="modal-box">
      <div class="modal-header">
        <div class="modal-title">Edit Data Warga</div>
        <button class="modal-close" onclick="tutupModal('modalEdit')">×</button>
      </div>
      <form method="POST" id="formEdit" action="">
        @csrf
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group">
              <label>Nama Lengkap *</label>
              <input type="text" name="name" id="editName" required>
            </div>
            <div class="form-group">
              <label>No. Rumah *</label>
              <input type="text" name="no_rumah" id="editNoRumah" required maxlength="10">
            </div>
          </div>
          <div class="form-group">
            <label>Email *</label>
            <input type="email" name="email" id="editEmail" required>
          </div>
          <div class="form-group">
            <label>No. WhatsApp</label>
            <input type="text" name="no_wa" id="editNoWa" maxlength="20">
          </div>
          <div class="form-group">
            <label>Password Baru</label>
            <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" minlength="6">
            <span class="hint">Biarkan kosong jika tidak ingin mengubah password</span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-cancel" onclick="tutupModal('modalEdit')">Batal</button>
          <button type="submit" class="btn-action btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- ════ MODAL KONFIRMASI HAPUS ════ -->
  <div class="modal-overlay" id="modalHapus" onclick="tutupJikaLuar(event,'modalHapus')">
    <div class="confirm-box">
      <div class="confirm-icon">
        <svg width="24" height="24" fill="none" stroke="var(--red)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
      </div>
      <div class="confirm-title">Hapus Warga?</div>
      <div class="confirm-sub" id="hapusKonfirmasiTeks">—</div>
      <form method="POST" id="formHapus" action="">
        @csrf
        <div class="confirm-actions">
          <button type="button" class="btn-cancel" onclick="tutupModal('modalHapus')">Batal</button>
          <button type="submit" class="btn-action btn-hapus" style="border-radius:8px;padding:10px;">Ya, Hapus</button>
        </div>
      </form>
    </div>
  </div>

  <!-- TOAST -->
  <div class="toast" id="toast"></div>

  <script>
    /* ── Tanggal ── */
    document.getElementById('todayDate').textContent =
      new Date().toLocaleDateString('id-ID', { weekday:'long', year:'numeric', month:'long', day:'numeric' });

    /* ── Helper modal ── */
    function bukaModal(id)  { document.getElementById(id).classList.add('open'); }
    function tutupModal(id) { document.getElementById(id).classList.remove('open'); }
    function tutupJikaLuar(e, id) {
      if (e.target === document.getElementById(id)) tutupModal(id);
    }

    /* ── Tambah Warga ── */
    function bukaModalTambah() { bukaModal('modalTambah'); }

    /* ── Edit Warga ── */
    function bukaModalEdit(id, name, email, noRumah, noWa) {
      document.getElementById('editName').value    = name;
      document.getElementById('editEmail').value   = email;
      document.getElementById('editNoRumah').value = noRumah;
      document.getElementById('editNoWa').value    = noWa;
      document.getElementById('formEdit').action   = `/bendahara/data-warga/${id}/update`;
      bukaModal('modalEdit');
    }

    /* ── Hapus Warga ── */
    function bukaKonfirmasiHapus(id, nama) {
      document.getElementById('hapusKonfirmasiTeks').textContent =
        `Semua data pembayaran ${nama} juga akan ikut terhapus. Tindakan ini tidak bisa dibatalkan.`;
      document.getElementById('formHapus').action = `/bendahara/data-warga/${id}/hapus`;
      bukaModal('modalHapus');
    }

    /* ── Toast ── */
    function tampilToast(pesan, tipe = '') {
      const el = document.getElementById('toast');
      el.textContent = pesan;
      el.className   = `toast ${tipe} show`;
      setTimeout(() => el.classList.remove('show'), 3000);
    }

    /* Tampilkan flash as toast juga */
    @if(session('success'))
      tampilToast('{{ session('success') }}', 'success');
    @endif
  </script>
</body>
</html>
