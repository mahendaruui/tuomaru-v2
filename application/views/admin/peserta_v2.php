<section class="admin-page-section">
    <div class="section-head">
        <div>
            <p class="admin-eyebrow">Manajemen Data</p>
            <h2 class="section-title">Data Peserta</h2>
        </div>
        <a href="<?= base_url('admin/downloadTemplatePeserta'); ?>" class="action-btn">
            <i class="fas fa-download"></i>
            Download Template
        </a>
    </div>

    <!-- Flash message import -->
    <?php $__msg = $this->session->userdata('import_msg'); if ($__msg) : $this->session->unset_userdata('import_msg'); ?>
        <?= $__msg ?>
    <?php endif; ?>

    <!-- Import card (collapsible) -->
    <div class="v2-card import-card" id="importCard">
        <button type="button" class="import-card__toggle" id="importToggle" aria-expanded="false" aria-controls="importBody">
            <span class="import-card__toggle-label">
                <i class="fas fa-file-upload"></i>
                Import Data Peserta (Excel / CSV)
            </span>
            <i class="fas fa-chevron-down import-card__chevron" id="importChevron"></i>
        </button>
        <div class="import-card__body" id="importBody" style="display:none;">
            <p class="import-hint">
                <i class="fas fa-info-circle"></i>
                Download template di atas &rarr; isi sheet <strong>Template Data</strong> &rarr;
                simpan &rarr; upload <strong>.xlsx / .xls / .csv</strong> di sini.<br>
                Password peserta dibuat otomatis <strong>5 karakter acak</strong> (huruf besar + angka).
            </p>
            <form action="<?= base_url('admin/importPeserta'); ?>" method="post" enctype="multipart/form-data">
                <div class="v2-file-input-group">
                    <label class="v2-file-label" for="file_csv">
                        <i class="fas fa-folder-open"></i>
                        <span id="fileLabel">Pilih file Excel atau CSV&hellip;</span>
                        <input type="file" id="file_csv" name="file_csv" accept=".xlsx,.xls,.csv" class="v2-file-hidden">
                    </label>
                    <button type="submit" class="v2-btn v2-btn--primary">
                        <i class="fas fa-upload"></i> Upload &amp; Import
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel peserta -->
    <div class="v2-card">
        <?php if (empty($pendaftar)) : ?>
            <div class="empty-state">
                <i class="fas fa-users fa-2x" style="color:var(--admin-muted); margin-bottom:12px; display:block;"></i>
                <p class="empty-state__label">Belum ada data peserta.</p>
            </div>
        <?php else : ?>
            <div class="v2-card__toolbar">
                <span class="v2-card__count"><?= count($pendaftar); ?> peserta</span>
            </div>
            <div class="table-scroll">
                <table class="v2-table" id="pesertaTable">
                    <thead>
                        <tr>
                            <th class="row-num-head">#</th>
                            <th>Nomor Ujian</th>
                            <th>Nama Peserta</th>
                            <th>Password</th>
                            <th>J/K</th>
                            <th>Asal Sekolah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($pendaftar as $p) : ?>
                        <tr>
                            <td class="row-num"><?= $no; ?></td>
                            <td><span class="ujian-badge"><?= htmlspecialchars($p->no_ujian); ?></span></td>
                            <td><?= htmlspecialchars($p->nama); ?></td>
                            <td><code class="pass-code"><?= htmlspecialchars($p->pass); ?></code></td>
                            <td>
                                <span class="gender-pill gender-pill--<?= strtolower($p->jenkel); ?>">
                                    <?= htmlspecialchars($p->jenkel); ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($p->asal_sekolah); ?></td>
                            <td class="row-actions">
                                <a href="<?= base_url('admin/detailmember/' . $p->id); ?>" class="row-action row-action--info" title="Detail">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </td>
                        </tr>
                        <?php $no++; endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
(function () {
    /* Import card toggle */
    var toggle  = document.getElementById('importToggle');
    var body    = document.getElementById('importBody');
    var chevron = document.getElementById('importChevron');

    if (toggle && body) {
        toggle.addEventListener('click', function () {
            var open = body.style.display !== 'none';
            body.style.display    = open ? 'none' : 'block';
            chevron.style.transform = open ? '' : 'rotate(180deg)';
            toggle.setAttribute('aria-expanded', String(!open));
        });
    }

    /* File input label */
    var fileInput = document.getElementById('file_csv');
    var fileLabel = document.getElementById('fileLabel');
    if (fileInput && fileLabel) {
        fileInput.addEventListener('change', function () {
            fileLabel.textContent = this.files.length ? this.files[0].name : 'Pilih file Excel atau CSV\u2026';
        });
    }
})();
</script>
