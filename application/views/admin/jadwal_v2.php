<?php
$nextGelombang = 1;
if (!empty($jadwaltes)) {
    foreach ($jadwaltes as $jadwalItem) {
        $nextGelombang = max($nextGelombang, ((int) $jadwalItem->gelombang) + 1);
    }
}
?>
<section class="admin-page-section">
    <div class="section-head">
        <div>
            <p class="admin-eyebrow">Pengaturan Ujian</p>
            <h2 class="section-title">Manajemen Tes</h2>
        </div>
        <button type="button" class="action-btn" data-toggle="modal" data-target="#newJadwalModal">
            <i class="fas fa-plus"></i>
            Tambah Jadwal
        </button>
    </div>

    <?php $__msg = $this->session->userdata('jadwal_msg'); if ($__msg) : $this->session->unset_userdata('jadwal_msg'); ?>
        <?= $__msg; ?>
    <?php endif; ?>

    <div class="v2-card">
        <?php if (empty($jadwaltes)) : ?>
            <div class="empty-state">
                <p class="empty-state__label">Belum ada jadwal tes yang dibuat.</p>
            </div>
        <?php else : ?>
            <div class="v2-card__toolbar">
                <span class="v2-card__count"><?= count($jadwaltes); ?> jadwal</span>
            </div>
            <div class="table-scroll">
                <table class="v2-table jadwal-table">
                    <thead>
                        <tr>
                            <th>Gelombang</th>
                            <th>Tanggal Tes</th>
                            <th>Waktu Tes</th>
                            <th>Status</th>
                            <th>Aksi</th>
                            <th>Atur Peserta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jadwaltes as $jd) : ?>
                        <tr>
                            <td>
                                <span class="gelombang-badge">Gelombang <?= htmlspecialchars($jd->gelombang); ?></span>
                            </td>
                            <td><?= htmlspecialchars(tgl_indo(date('Y-m-d', $jd->tgl_tes))); ?></td>
                            <td><span class="schedule-time"><?= htmlspecialchars(date('H:i', $jd->tgl_tes)); ?> WIB</span></td>
                            <td>
                                <span class="status-pill <?= ((string) $jd->active === '1') ? 'status-pill--active' : 'status-pill--inactive'; ?>">
                                    <i class="fas <?= ((string) $jd->active === '1') ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?>"></i>
                                    <?= ((string) $jd->active === '1') ? 'Aktif' : 'Non Aktif'; ?>
                                </span>
                            </td>
                            <td class="row-actions">
                                <a href="<?= base_url('admin/editjdw/' . $jd->id); ?>" class="row-action row-action--warning" title="Edit jadwal">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a href="<?= base_url('admin/hapusjdw/' . $jd->id); ?>" class="row-action row-action--danger" title="Hapus jadwal" onclick="return confirm('Apakah anda yakin menghapus Jadwal ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/aturpeserta/' . $jd->gelombang); ?>" class="row-action row-action--success" title="Atur peserta gelombang <?= htmlspecialchars($jd->gelombang); ?>">
                                    <i class="fas fa-users"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>

<div class="v2-modal-overlay" id="newJadwalModal" aria-hidden="true">
    <div class="v2-modal v2-modal--medium">
        <div class="v2-modal__head">
            <div>
                <p class="admin-eyebrow">Jadwal Baru</p>
                <h3>Tambah Jadwal Ujian</h3>
            </div>
            <button type="button" class="v2-modal__close" data-dismiss="modal" aria-label="Close">
                <span>&times;</span>
            </button>
        </div>
        <form action="<?= base_url('admin/tambahjadwal'); ?>" method="post">
            <div class="v2-modal__body">
                <div class="v2-form-grid v2-form-grid--2">
                    <div>
                        <label class="v2-label">Gelombang</label>
                        <input type="hidden" name="gelombang" value="<?= $nextGelombang; ?>">
                        <input type="text" class="v2-input" value="<?= $nextGelombang; ?>" disabled>
                    </div>
                    <div>
                        <label class="v2-label">Aktifkan Jadwal</label>
                        <label class="v2-toggle v2-toggle--field">
                            <input type="checkbox" class="v2-toggle__input" name="aktifkan" value="1">
                            <span class="v2-toggle__track">
                                <span class="v2-toggle__thumb"></span>
                            </span>
                        </label>
                    </div>
                    <div>
                        <label class="v2-label">Tanggal Tes</label>
                        <input type="date" class="v2-input" name="tglujian" required>
                    </div>
                    <div>
                        <label class="v2-label">Waktu Tes</label>
                        <input type="time" class="v2-input" name="wktujian" required>
                    </div>
                </div>
            </div>
            <div class="v2-modal__footer">
                <button type="button" class="v2-btn v2-btn--ghost" data-dismiss="modal">Batal</button>
                <button type="submit" class="v2-btn v2-btn--primary">Simpan Jadwal</button>
            </div>
        </form>
    </div>
</div>
