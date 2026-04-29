<section class="admin-page-section">
    <div class="section-head">
        <div>
            <p class="admin-eyebrow">Manajemen Tes</p>
            <h2 class="section-title">Atur Peserta</h2>
        </div>
        <div class="section-head__actions">
            <span class="gelombang-badge">Gelombang <?= htmlspecialchars($gel); ?></span>
            <a href="<?= base_url('admin/downloadPesertaGelombang/' . urlencode($gel)); ?>" class="action-btn action-btn--success-soft">
                <i class="fas fa-file-excel"></i>
                Download Excel
            </a>
            <a href="<?= base_url('admin/jadwal'); ?>" class="action-btn action-btn--ghost">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Jadwal
            </a>
        </div>
    </div>

    <?php $__msg = $this->session->userdata('aturpeserta_msg'); if ($__msg) : $this->session->unset_userdata('aturpeserta_msg'); ?>
        <?= $__msg; ?>
    <?php endif; ?>

    <div class="assign-summary">
        <div class="detail-stat">
            <span class="detail-stat__label">Gelombang Aktif</span>
            <strong class="detail-stat__value">Gelombang <?= htmlspecialchars($gel); ?></strong>
        </div>
        <div class="detail-stat">
            <span class="detail-stat__label">Tanggal Tes</span>
            <strong class="detail-stat__value"><?= !empty($jadwalInfo) ? htmlspecialchars(tgl_indo(date('Y-m-d', $jadwalInfo->tgl_tes))) : '-'; ?></strong>
        </div>
        <div class="detail-stat">
            <span class="detail-stat__label">Waktu Tes</span>
            <strong class="detail-stat__value"><?= !empty($jadwalInfo) ? htmlspecialchars(date('H:i', $jadwalInfo->tgl_tes) . ' WIB') : '-'; ?></strong>
        </div>
        <div class="detail-stat">
            <span class="detail-stat__label">Peserta Terpasang</span>
            <strong class="detail-stat__value"><?= count($pesertates ?? []); ?> peserta</strong>
        </div>
    </div>

    <div class="assign-grid">
        <div class="v2-card assign-card">
            <div class="assign-card__head">
                <div>
                    <p class="admin-eyebrow">Sudah Dijadwalkan</p>
                    <h3>Peserta Gelombang <?= htmlspecialchars($gel); ?></h3>
                </div>
                <span class="v2-card__count"><?= count($pesertates ?? []); ?> peserta</span>
            </div>

            <?php if (empty($pesertates)) : ?>
                <div class="empty-state">
                    <p class="empty-state__label">Belum ada peserta di gelombang ini.</p>
                </div>
            <?php else : ?>
                <form action="<?= base_url('admin/hapusset'); ?>" method="post" id="assignedForm">
                    <input type="hidden" name="sesigel" value="<?= htmlspecialchars($gel); ?>">
                    <div class="assign-bulkbar">
                        <label class="bulk-check">
                            <input type="checkbox" data-check-all="assigned">
                            <span>Pilih semua</span>
                        </label>
                        <button class="v2-btn v2-btn--danger" type="submit" onclick="return confirm('Apakah anda yakin menghapus peserta ini dari gelombang?')">
                            <i class="fas fa-user-minus"></i>
                            Hapus dari Gelombang
                        </button>
                    </div>
                    <div class="table-scroll">
                        <table class="v2-table assign-table">
                            <thead>
                                <tr>
                                    <th class="row-num-head">#</th>
                                    <th>No. Ujian</th>
                                    <th>Password</th>
                                    <th>Nama</th>
                                    <th>J/K</th>
                                    <th>Asal Sekolah</th>
                                    <th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($pesertates as $peserta) : ?>
                                <tr>
                                    <td class="row-num"><?= $no; ?></td>
                                    <td><span class="ujian-badge"><?= htmlspecialchars($peserta->no_ujian); ?></span></td>
                                    <td><span class="pass-code"><?= htmlspecialchars($peserta->pass); ?></span></td>
                                    <td><?= htmlspecialchars($peserta->nama); ?></td>
                                    <td><span class="gender-pill gender-pill--<?= strtolower((string) $peserta->jenkel) === 'p' ? 'p' : 'l'; ?>"><?= htmlspecialchars($peserta->jenkel ?: '-'); ?></span></td>
                                    <td><?= htmlspecialchars($peserta->asal_sekolah); ?></td>
                                    <td>
                                        <label class="table-check">
                                            <input type="checkbox" name="gel[]" value="<?= (int) $peserta->id; ?>" data-check-item="assigned">
                                            <span></span>
                                        </label>
                                    </td>
                                </tr>
                                <?php $no++; endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            <?php endif; ?>
        </div>

        <div class="v2-card assign-card">
            <div class="assign-card__head">
                <div>
                    <p class="admin-eyebrow">Belum Dijadwalkan</p>
                    <h3>Peserta Hasil Import</h3>
                </div>
                <span class="v2-card__count"><?= count($pesetasaja ?? []); ?> peserta</span>
            </div>

            <?php if (empty($pesetasaja)) : ?>
                <div class="empty-state">
                    <p class="empty-state__label">Tidak ada pendaftar yang siap dipasangkan.</p>
                </div>
            <?php else : ?>
                <form action="<?= base_url('admin/setpeserta'); ?>" method="post" id="availableForm">
                    <input type="hidden" name="sesigel" value="<?= htmlspecialchars($gel); ?>">
                    <div class="assign-bulkbar">
                        <label class="bulk-check">
                            <input type="checkbox" data-check-all="available">
                            <span>Pilih semua</span>
                        </label>
                        <button class="v2-btn v2-btn--primary" type="submit">
                            <i class="fas fa-user-plus"></i>
                            Tambahkan ke Gelombang
                        </button>
                    </div>
                    <div class="table-scroll">
                        <table class="v2-table assign-table">
                            <thead>
                                <tr>
                                    <th class="row-num-head">#</th>
                                    <th>No. Ujian</th>
                                    <th>Password</th>
                                    <th>Nama</th>
                                    <th>J/K</th>
                                    <th>Asal Sekolah</th>
                                    <th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($pesetasaja as $peserta) : ?>
                                <tr>
                                    <td class="row-num"><?= $no; ?></td>
                                    <td><span class="ujian-badge"><?= htmlspecialchars($peserta->no_ujian); ?></span></td>
                                    <td><span class="pass-code"><?= htmlspecialchars($peserta->pass); ?></span></td>
                                    <td><?= htmlspecialchars($peserta->nama); ?></td>
                                    <td><span class="gender-pill gender-pill--<?= strtolower((string) $peserta->jenkel) === 'p' ? 'p' : 'l'; ?>"><?= htmlspecialchars($peserta->jenkel ?: '-'); ?></span></td>
                                    <td><?= htmlspecialchars($peserta->asal_sekolah); ?></td>
                                    <td>
                                        <label class="table-check">
                                            <input type="checkbox" name="gel[]" value="<?= (int) $peserta->id; ?>" data-check-item="available">
                                            <span></span>
                                        </label>
                                    </td>
                                </tr>
                                <?php $no++; endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
(function () {
    function syncMaster(group) {
        var items = Array.prototype.slice.call(document.querySelectorAll('[data-check-item="' + group + '"]'));
        var master = document.querySelector('[data-check-all="' + group + '"]');
        if (!master || items.length === 0) {
            return;
        }
        var checked = items.filter(function (item) { return item.checked; }).length;
        master.checked = checked > 0 && checked === items.length;
        master.indeterminate = checked > 0 && checked < items.length;
    }

    document.querySelectorAll('[data-check-all]').forEach(function (master) {
        master.addEventListener('change', function () {
            var group = this.getAttribute('data-check-all');
            document.querySelectorAll('[data-check-item="' + group + '"]').forEach(function (item) {
                item.checked = master.checked;
            });
            syncMaster(group);
        });
    });

    document.querySelectorAll('[data-check-item]').forEach(function (item) {
        item.addEventListener('change', function () {
            syncMaster(this.getAttribute('data-check-item'));
        });
    });
})();
</script>
