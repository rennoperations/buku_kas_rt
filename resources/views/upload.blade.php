<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Token CSRF dibutuhkan oleh Laravel untuk request dari web --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Upload Struk Pembayaran — Iuran Warga</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">

    <style>
        /* ─── Design Tokens ─────────────────────────────────────────── */
        :root {
            --cream:       #FAF7F2;
            --warm-white:  #FFFCF8;
            --clay:        #C45E2E;
            --clay-light:  #E8956A;
            --clay-dim:    #F0CDB8;
            --forest:      #2D5A3D;
            --forest-dim:  #C8DDD0;
            --ink:         #1A1410;
            --ink-mid:     #5C4A3A;
            --ink-soft:    #9C8A7A;
            --border:      #E2D9CE;
            --shadow-sm:   0 2px 8px rgba(26,20,16,.06);
            --shadow-md:   0 8px 32px rgba(26,20,16,.10);
            --shadow-lg:   0 20px 60px rgba(26,20,16,.14);
            --radius:      16px;
            --radius-sm:   10px;
        }

        /* ─── Reset & Base ───────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--cream);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            /* Subtle noise texture */
            background-image:
                radial-gradient(ellipse 80% 60% at 20% 10%, rgba(196,94,46,.08) 0%, transparent 60%),
                radial-gradient(ellipse 60% 80% at 80% 90%, rgba(45,90,61,.06) 0%, transparent 60%);
        }

        /* ─── Card ───────────────────────────────────────────────────── */
        .card {
            width: 100%;
            max-width: 520px;
            background: var(--warm-white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            animation: slideUp .45s cubic-bezier(.22,.68,0,1.2) both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(28px) scale(.98); }
            to   { opacity: 1; transform: translateY(0)   scale(1); }
        }

        /* ─── Card Header ─────────────────────────────────────────────── */
        .card-header {
            padding: 32px 36px 24px;
            border-bottom: 1px solid var(--border);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--clay-dim);
            color: var(--clay);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 99px;
            margin-bottom: 14px;
        }

        .badge-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--clay);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: .5; transform: scale(.8); }
        }

        h1 {
            font-family: 'DM Serif Display', serif;
            font-size: 26px;
            line-height: 1.2;
            color: var(--ink);
            margin-bottom: 6px;
        }

        .subtitle {
            font-size: 14px;
            color: var(--ink-soft);
            line-height: 1.6;
        }

        /* ─── Card Body ───────────────────────────────────────────────── */
        .card-body { padding: 28px 36px 36px; }

        .field + .field { margin-top: 20px; }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--ink-mid);
            margin-bottom: 8px;
            letter-spacing: .01em;
        }

        /* ─── Drop Zone ───────────────────────────────────────────────── */
        .drop-zone {
            border: 2px dashed var(--border);
            border-radius: var(--radius-sm);
            background: var(--cream);
            padding: 32px 20px;
            text-align: center;
            cursor: pointer;
            transition: border-color .2s, background .2s, transform .15s;
            position: relative;
        }

        .drop-zone:hover,
        .drop-zone.dragover {
            border-color: var(--clay);
            background: rgba(196,94,46,.04);
            transform: scale(1.005);
        }

        /* Hidden real input */
        #bukti_bayar {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            font-size: 0; /* hide any text in old browsers */
        }

        .drop-icon {
            width: 48px; height: 48px;
            background: var(--clay-dim);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 14px;
            transition: background .2s, transform .2s;
        }

        .drop-zone:hover .drop-icon,
        .drop-zone.dragover .drop-icon {
            background: var(--clay);
            transform: scale(1.1);
        }

        .drop-icon svg { transition: stroke .2s; }
        .drop-zone:hover .drop-icon svg path,
        .drop-zone.dragover .drop-icon svg path { stroke: #fff; }

        .drop-text-main {
            font-size: 14px;
            font-weight: 500;
            color: var(--ink-mid);
            margin-bottom: 4px;
        }

        .drop-text-main span { color: var(--clay); text-decoration: underline; text-underline-offset: 3px; }

        .drop-text-sub {
            font-size: 12px;
            color: var(--ink-soft);
        }

        /* ─── Preview Box ─────────────────────────────────────────────── */
        .preview-box {
            display: none;
            border-radius: var(--radius-sm);
            overflow: hidden;
            border: 1px solid var(--border);
            position: relative;
            background: var(--cream);
            animation: fadeIn .3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(.97); }
            to   { opacity: 1; transform: scale(1); }
        }

        .preview-box img {
            width: 100%;
            max-height: 220px;
            object-fit: contain;
            display: block;
            padding: 12px;
        }

        .preview-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            border-top: 1px solid var(--border);
            background: var(--warm-white);
        }

        .preview-filename {
            font-size: 12px;
            font-weight: 500;
            color: var(--ink-mid);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 260px;
        }

        .btn-remove {
            background: none;
            border: none;
            font-size: 12px;
            font-weight: 600;
            color: var(--clay);
            cursor: pointer;
            padding: 2px 8px;
            border-radius: 6px;
            transition: background .15s;
        }

        .btn-remove:hover { background: var(--clay-dim); }

        /* ─── Input Nominal ───────────────────────────────────────────── */
        .input-wrapper {
            display: flex;
            align-items: center;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            overflow: hidden;
            background: var(--warm-white);
            transition: border-color .2s, box-shadow .2s;
        }

        .input-wrapper:focus-within {
            border-color: var(--clay);
            box-shadow: 0 0 0 3px rgba(196,94,46,.12);
        }

        /* Terkunci sebelum AI scan */
        .input-wrapper.locked {
            background: var(--cream);
            border-style: dashed;
            opacity: .6;
            pointer-events: none;
        }

        /* Terisi oleh AI — highlight hijau sebentar */
        .input-wrapper.ai-filled {
            border-color: var(--forest);
            box-shadow: 0 0 0 3px rgba(45,90,61,.12);
            animation: aiHighlight 1.8s ease forwards;
        }

        @keyframes aiHighlight {
            0%   { border-color: var(--forest); box-shadow: 0 0 0 3px rgba(45,90,61,.2); }
            100% { border-color: var(--border); box-shadow: none; }
        }

        .input-prefix {
            padding: 13px 14px;
            background: var(--cream);
            border-right: 1.5px solid var(--border);
            font-size: 13px;
            font-weight: 600;
            color: var(--ink-soft);
            white-space: nowrap;
        }

        #nominal_konfirmasi {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            color: var(--ink);
            padding: 13px 16px;
        }

        /* ─── Alert Banner ────────────────────────────────────────────── */
        .alert {
            display: none;
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            line-height: 1.5;
            margin-top: 20px;
            animation: fadeIn .25s ease;
        }

        .alert-success {
            background: var(--forest-dim);
            color: var(--forest);
            border: 1px solid rgba(45,90,61,.2);
        }

        .alert-error {
            background: #FDE8E0;
            color: #8B2500;
            border: 1px solid rgba(196,94,46,.25);
        }

        /* ─── Submit Button ───────────────────────────────────────────── */
        .btn-submit {
            width: 100%;
            margin-top: 24px;
            padding: 15px 24px;
            background: var(--clay);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: .01em;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: background .2s, transform .15s, box-shadow .2s;
            box-shadow: 0 4px 16px rgba(196,94,46,.35);
        }

        .btn-submit:hover:not(:disabled) {
            background: #B5511F;
            transform: translateY(-1px);
            box-shadow: 0 6px 22px rgba(196,94,46,.45);
        }

        .btn-submit:active:not(:disabled) {
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(196,94,46,.3);
        }

        .btn-submit:disabled {
            background: var(--ink-soft);
            cursor: not-allowed;
            box-shadow: none;
            transform: none;
        }

        /* Spinner */
        .spinner {
            display: none;
            width: 18px; height: 18px;
            border: 2.5px solid rgba(255,255,255,.35);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* ─── Footer ──────────────────────────────────────────────────── */
        .card-footer {
            padding: 16px 36px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-footer svg { flex-shrink: 0; }

        .card-footer p {
            font-size: 12px;
            color: var(--ink-soft);
            line-height: 1.5;
        }

        /* ─── Responsive ──────────────────────────────────────────────── */
        @media (max-width: 560px) {
            .card-header, .card-body { padding-left: 24px; padding-right: 24px; }
            .card-footer { padding-left: 24px; padding-right: 24px; }
            h1 { font-size: 22px; }
        }
    </style>
</head>
<body>

<div class="card">

    {{-- ── Header ────────────────────────────────────────────────── --}}
    <div class="card-header">
        <div class="badge">
            <span class="badge-dot"></span>
            Konfirmasi Pembayaran
        </div>
        <h1>Upload Struk<br><em>Pembayaran Iuran</em></h1>
        <p class="subtitle">
            Foto struk transfer akan kami verifikasi dalam 1×24 jam.
            Pastikan nominal dan nama pengirim terlihat jelas.
        </p>
    </div>

    {{-- ── Body ──────────────────────────────────────────────────── --}}
    <div class="card-body">

        {{-- Foto Struk --}}
        <div class="field">
            <label for="bukti_bayar">Foto Struk / Bukti Transfer</label>

            {{-- Drop zone (tampil saat belum ada file) --}}
            <div class="drop-zone" id="dropZone">
                <input type="file"
                       id="bukti_bayar"
                       name="bukti_bayar"
                       accept="image/*"
                       capture="environment">

                <div class="drop-icon">
                    {{-- Upload icon --}}
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--clay)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="17 8 12 3 7 8"/>
                        <line x1="12" y1="3" x2="12" y2="15"/>
                    </svg>
                </div>
                <p class="drop-text-main">
                    <span>Pilih foto</span> atau seret ke sini
                </p>
                <p class="drop-text-sub">JPG, PNG, HEIC — maks. 5 MB</p>
            </div>

            {{-- Preview (muncul setelah file dipilih) --}}
            <div class="preview-box" id="previewBox">
                <img id="previewImg" src="#" alt="Preview struk">
                <div class="preview-label">
                    <span class="preview-filename" id="previewFilename">—</span>
                    <button type="button" class="btn-remove" id="btnRemove">× Hapus</button>
                </div>
            </div>
        </div>

        {{-- Nominal Konfirmasi --}}
        <div class="field">
            <label for="nominal_konfirmasi">Nominal Transfer
                <span id="nominalHint" style="font-weight:400;color:var(--ink-soft);margin-left:6px;">
                    — terisi otomatis setelah scan
                </span>
            </label>
            <div class="input-wrapper locked" id="nominalWrapper">
                <span class="input-prefix">Rp</span>
                <input type="number"
                       id="nominal_konfirmasi"
                       name="nominal_konfirmasi"
                       placeholder="Otomatis dari AI…"
                       min="0"
                       inputmode="numeric"
                       readonly>
            </div>
        </div>

        {{-- Alert --}}
        <div class="alert" id="alertBox"></div>

        {{-- Submit --}}
        <button type="button" class="btn-submit" id="btnSubmit" onclick="handleSubmit()">
            <span class="spinner" id="spinner"></span>
            <span id="btnLabel">Scan Struk dengan AI</span>
        </button>

    </div>

    {{-- ── Footer ─────────────────────────────────────────────────── --}}
    <div class="card-footer">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--ink-soft)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
        </svg>
        <p>Data Anda dienkripsi dan hanya diakses oleh pengurus RT/RW.</p>
    </div>

</div>

{{-- ─── JavaScript ─────────────────────────────────────────────────── --}}
<script>
    /* ── Elemen ───────────────────────────────────────────────────── */
    const dropZone    = document.getElementById('dropZone');
    const fileInput   = document.getElementById('bukti_bayar');
    const previewBox  = document.getElementById('previewBox');
    const previewImg  = document.getElementById('previewImg');
    const previewName = document.getElementById('previewFilename');
    const btnRemove   = document.getElementById('btnRemove');
    const alertBox    = document.getElementById('alertBox');
    const btnSubmit   = document.getElementById('btnSubmit');
    const spinner     = document.getElementById('spinner');
    const btnLabel    = document.getElementById('btnLabel');

    /* Ambil CSRF token dari <meta> (untuk route web); 
       Route API Laravel biasanya tidak butuh ini,
       tapi kita sertakan agar fleksibel. */
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    /* ── Drag & Drop Events ───────────────────────────────────────── */
    ['dragenter', 'dragover'].forEach(evt =>
        dropZone.addEventListener(evt, e => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        })
    );

    ['dragleave', 'drop'].forEach(evt =>
        dropZone.addEventListener(evt, e => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
        })
    );

    dropZone.addEventListener('drop', e => {
        const file = e.dataTransfer.files[0];
        if (file) tampilkanPreview(file);
    });

    /* ── File Input Change ────────────────────────────────────────── */
    fileInput.addEventListener('change', () => {
        const file = fileInput.files[0];
        if (file) tampilkanPreview(file);
    });

    /* ── Tampilkan Preview ────────────────────────────────────────── */
    function tampilkanPreview(file) {
        /* Validasi tipe file */
        if (!file.type.startsWith('image/')) {
            tampilkanAlert('error', 'File harus berupa gambar (JPG, PNG, HEIC).');
            return;
        }

        /* Validasi ukuran file (maks 5 MB) */
        if (file.size > 5 * 1024 * 1024) {
            tampilkanAlert('error', 'Ukuran file melebihi batas 5 MB.');
            return;
        }

        /* Tampilkan preview */
        const reader = new FileReader();
        reader.onload = e => {
            previewImg.src = e.target.result;
            previewName.textContent = file.name;
            dropZone.style.display = 'none';
            previewBox.style.display = 'block';
        };
        reader.readAsDataURL(file);

        sembunyikanAlert();
    }

    /* ── Hapus File → reset ke Tahap 1 ──────────────────────────── */
    btnRemove.addEventListener('click', () => {
        fileInput.value = '';
        previewImg.src = '#';
        previewBox.style.display = 'none';
        dropZone.style.display = 'block';
        sembunyikanAlert();
        resetKeTahap1();
    });

    /* ─────────────────────────────────────────────────────────────
       STATE — pelacak tahap aktif
       tahap 1 = belum scan  |  tahap 2 = sudah scan, siap simpan
    ───────────────────────────────────────────────────────────── */
    let tahap = 1;

    const inputNominal   = document.getElementById('nominal_konfirmasi');
    const nominalWrapper = document.getElementById('nominalWrapper');
    const nominalHint    = document.getElementById('nominalHint');

    /* ── Dispatcher: satu onclick untuk dua tahap ────────────────── */
    function handleSubmit() {
        if (tahap === 1) scanStruk();
        else             simpanPembayaran();
    }

    /* ── Tahap 1: Kirim gambar ke AI, terima nominal ─────────────── */
    async function scanStruk() {
        if (!fileInput.files[0]) {
            tampilkanAlert('error', 'Pilih foto struk terlebih dahulu.');
            return;
        }

        setLoading(true);
        sembunyikanAlert();

        const formData = new FormData();
        formData.append('bukti_bayar', fileInput.files[0]);

        try {
            const response = await fetch('/api/scan-struk', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: formData,
            });

            const data = await response.json();

            if (response.ok && data.nominal_terdeteksi) {
                /* ✓ AI berhasil membaca — isi nominal & buka kunci field */
                buka_nominalField(data.nominal_terdeteksi);
                tampilkanAlert('success',
                    `✓ AI mendeteksi nominal Rp ${Number(data.nominal_terdeteksi).toLocaleString('id-ID')}. ` +
                    `Koreksi jika perlu, lalu klik Konfirmasi.`
                );
                /* Naik ke Tahap 2 */
                tahap = 2;
                setLoading(false);
            } else {
                /* AI gagal baca — buka kunci supaya user isi manual */
                const pesanGagal = data.message ?? 'AI tidak dapat membaca nominal. Silakan isi manual.';
                buka_nominalField('');
                tampilkanAlert('error', pesanGagal);
                tahap = 2; // tetap lanjut ke tahap 2 dengan isi manual
                setLoading(false);
            }
        } catch (err) {
            tampilkanAlert('error', 'Gagal terhubung ke server. Periksa koneksi Anda.');
            setLoading(false);
            console.error('Scan error:', err);
        }
    }

    /* ── Tahap 2: Simpan transaksi ke database ───────────────────── */
    async function simpanPembayaran() {
        const nominal = inputNominal.value;

        if (!nominal || Number(nominal) <= 0) {
            tampilkanAlert('error', 'Nominal transfer tidak boleh kosong atau nol.');
            return;
        }

        setLoading(true);
        sembunyikanAlert();

        const formData = new FormData();
        formData.append('bukti_bayar',        fileInput.files[0]);
        formData.append('nominal_konfirmasi', nominal);

        try {
            const response = await fetch('/api/simpan-transaksi', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: formData,
            });

            const data = await response.json();

            if (response.ok) {
                tampilkanAlert('success', '✓ ' + (data.message ?? 'Pembayaran berhasil disimpan!'));
                /* Reset seluruh form setelah 2.5 detik */
                setTimeout(() => {
                    fileInput.value   = '';
                    previewImg.src    = '#';
                    previewBox.style.display = 'none';
                    dropZone.style.display   = 'block';
                    sembunyikanAlert();
                    resetKeTahap1();
                }, 2500);
            } else {
                const pesan = data.message
                    ?? (data.errors ? Object.values(data.errors).flat().join(' ') : null)
                    ?? 'Terjadi kesalahan. Silakan coba lagi.';
                tampilkanAlert('error', pesan);
            }
        } catch (err) {
            tampilkanAlert('error', 'Server bermasalah. Coba lagi beberapa saat.');
            console.error('Simpan error:', err);
        } finally {
            setLoading(false);
        }
    }

    /* ── Helpers ──────────────────────────────────────────────────── */

    /** Buka kunci field nominal dan isi dengan nilai dari AI */
    function buka_nominalField(nilai) {
        inputNominal.readOnly = false;
        nominalWrapper.classList.remove('locked');
        if (nilai) {
            inputNominal.value = nilai;
            /* Animasi highlight singkat tanda AI yang mengisi */
            nominalWrapper.classList.add('ai-filled');
            nominalWrapper.addEventListener('animationend',
                () => nominalWrapper.classList.remove('ai-filled'),
                { once: true }
            );
        } else {
            inputNominal.placeholder = 'Isi manual di sini…';
            inputNominal.focus();
        }
        nominalHint.textContent = '— koreksi jika berbeda';
        nominalHint.style.color = 'var(--forest)';
    }

    /** Reset form & tombol sepenuhnya ke Tahap 1 */
    function resetKeTahap1() {
        tahap = 1;
        inputNominal.value       = '';
        inputNominal.readOnly    = true;
        inputNominal.placeholder = 'Otomatis dari AI…';
        nominalWrapper.classList.add('locked');
        nominalWrapper.classList.remove('ai-filled');
        nominalHint.textContent  = '— terisi otomatis setelah scan';
        nominalHint.style.color  = '';
        btnLabel.textContent     = 'Scan Struk dengan AI';
        btnSubmit.disabled       = false;
        spinner.style.display    = 'none';
    }

    /** Loading state — sadar tahap sehingga tidak menimpa label yang benar */
    function setLoading(isLoading) {
        btnSubmit.disabled    = isLoading;
        spinner.style.display = isLoading ? 'block' : 'none';

        if (isLoading) {
            btnLabel.textContent = tahap === 1 ? 'Memindai…' : 'Menyimpan…';
        } else {
            /* Tentukan label berdasarkan tahap aktif SETELAH loading selesai */
            btnLabel.textContent = tahap === 1 ? 'Scan Struk dengan AI' : 'Konfirmasi & Simpan';
        }
    }

    function tampilkanAlert(tipe, pesan) {
        alertBox.className   = `alert alert-${tipe}`;
        alertBox.textContent = pesan;
        alertBox.style.display = 'block';
    }

    function sembunyikanAlert() {
        alertBox.style.display = 'none';
        alertBox.textContent   = '';
    }

    /* ── Blokir karakter non-angka di input nominal ──────────────── */
    inputNominal.addEventListener('keydown', e => {
        if (!/[\d]/.test(e.key) &&
            !['Backspace','Delete','ArrowLeft','ArrowRight','Tab'].includes(e.key)) {
            e.preventDefault();
        }
    });
</script>

</body>
</html>