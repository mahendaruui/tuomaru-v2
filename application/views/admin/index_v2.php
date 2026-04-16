<div class="admin-hero">
    <div class="admin-hero__copy">
        <p class="admin-eyebrow admin-eyebrow--light">SIPENMARU UUI</p>
        <h2>Panel admin generasi baru untuk monitoring ujian masuk.</h2>
        <p>
            Tampilan ini menjadi fondasi redesign admin: lebih tegas secara visual, lebih nyaman untuk data padat,
            dan siap diturunkan ke area peserta setelah shell baru stabil.
        </p>
    </div>
    <div class="admin-hero__meta">
        <div class="admin-hero-card">
            <span>Status Sistem</span>
            <strong>Aktif</strong>
            <small>Bank soal, peserta, dan jadwal dapat diakses dari panel ini.</small>
        </div>
        <div class="admin-hero-card admin-hero-card--accent">
            <span>Fokus Implementasi</span>
            <strong>Dashboard Pilot</strong>
            <small>Halaman ini dipakai untuk validasi fondasi visual sebelum rollout ke modul lain.</small>
        </div>
    </div>
</div>

<section class="metrics-grid">
    <article class="metric-card metric-card--primary">
        <div>
            <p>Total Peserta Ujian</p>
            <strong><?= (int) $jmlpesertaCount; ?></strong>
            <span>Peserta terdaftar pada sistem ujian</span>
        </div>
        <i class="fas fa-users"></i>
    </article>

    <article class="metric-card metric-card--success">
        <div>
            <p>Menyelesaikan Tes</p>
            <strong><?= (int) $jmlselesai; ?></strong>
            <span>Peserta yang sudah menuntaskan ujian</span>
        </div>
        <i class="fas fa-running"></i>
    </article>

    <article class="metric-card metric-card--info">
        <div>
            <p>Sisa Peserta Tes</p>
            <strong><?= (int) $jmlbelum; ?></strong>
            <span>Peserta yang belum mengikuti ujian</span>
        </div>
        <i class="fas fa-pause-circle"></i>
    </article>

    <article class="metric-card metric-card--warning">
        <div>
            <p>Jumlah Bank Soal</p>
            <strong><?= (int) $jmlsoal; ?></strong>
            <span>Total soal yang tersedia untuk sesi ujian</span>
        </div>
        <i class="fas fa-book-open"></i>
    </article>
</section>

<section class="admin-grid-2">
    <article class="surface-card surface-card--feature">
        <div class="surface-card__head">
            <div>
                <p class="surface-card__eyebrow">Ringkasan Sistem</p>
                <h3>Sistem Ujian Online SIPENMARU - UUI</h3>
            </div>
            <span class="surface-badge">Pilot V2</span>
        </div>
        <p class="surface-card__lead">
            Panel admin ini dipakai untuk pengelolaan peserta, bank soal, jadwal, dan akses menu. Versi baru menata ulang
            hirarki informasi agar modul yang padat tabel tetap lebih mudah dibaca di desktop maupun perangkat yang lebih kecil.
        </p>
        <div class="surface-checklist">
            <div><i class="fas fa-check-circle"></i><span>Fondasi visual baru tanpa mengganggu halaman admin lain</span></div>
            <div><i class="fas fa-check-circle"></i><span>Siap dipakai sebagai acuan redesign halaman peserta dan soal</span></div>
            <div><i class="fas fa-check-circle"></i><span>Mempertahankan dependency penting seperti Bootstrap modal dan DataTables</span></div>
        </div>
    </article>

    <article class="surface-card surface-card--panel">
        <div class="surface-card__head">
            <div>
                <p class="surface-card__eyebrow">Distribusi Peserta</p>
                <h3>Status pengerjaan ujian</h3>
            </div>
        </div>
        <?php
        $totalPeserta = max(1, (int) $jmlpesertaCount);
        $persenSelesai = min(100, round(((int) $jmlselesai / $totalPeserta) * 100));
        $persenBelum = min(100, round(((int) $jmlbelum / $totalPeserta) * 100));
        ?>
        <div class="progress-stat">
            <div>
                <span>Selesai</span>
                <strong><?= $persenSelesai; ?>%</strong>
            </div>
            <div class="progress-track"><span style="width: <?= $persenSelesai; ?>%"></span></div>
        </div>
        <div class="progress-stat">
            <div>
                <span>Belum ujian</span>
                <strong><?= $persenBelum; ?>%</strong>
            </div>
            <div class="progress-track progress-track--warm"><span style="width: <?= $persenBelum; ?>%"></span></div>
        </div>

        <div class="quick-stats">
            <div>
                <small>Total peserta</small>
                <strong><?= (int) $jmlpesertaCount; ?></strong>
            </div>
            <div>
                <small>Selesai</small>
                <strong><?= (int) $jmlselesai; ?></strong>
            </div>
            <div>
                <small>Belum</small>
                <strong><?= (int) $jmlbelum; ?></strong>
            </div>
        </div>
    </article>
</section>