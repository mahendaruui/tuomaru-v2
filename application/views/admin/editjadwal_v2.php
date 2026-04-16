<?php $jadwal = !empty($datajadwal) ? $datajadwal[0] : null; ?>
<?php if ($jadwal) : ?>
<section class="admin-page-section">
    <div class="section-head">
        <div>
            <p class="admin-eyebrow">Manajemen Tes</p>
            <h2 class="section-title">Edit Jadwal</h2>
        </div>
        <a href="<?= base_url('admin/jadwal'); ?>" class="action-btn action-btn--ghost">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Jadwal
        </a>
    </div>

    <div class="v2-card soal-form-card">
        <form action="<?= base_url('atursoal/updatejadwal'); ?>" method="POST">
            <input type="hidden" name="idjdw" value="<?= (int) $jadwal->id; ?>">
            <div class="v2-form-grid v2-form-grid--2">
                <div class="field-block">
                    <label class="v2-label">Gelombang</label>
                    <input type="text" class="v2-input" value="<?= htmlspecialchars($jadwal->gelombang); ?>" disabled>
                </div>

                <div class="field-block">
                    <label class="v2-label">Status Jadwal</label>
                    <label class="v2-toggle v2-toggle--field">
                        <input type="checkbox" class="v2-toggle__input" name="aktifkan" <?= ((string) $jadwal->active === '1') ? 'checked' : ''; ?>>
                        <span class="v2-toggle__track">
                            <span class="v2-toggle__thumb"></span>
                        </span>
                    </label>
                </div>

                <div class="field-block">
                    <label class="v2-label" for="tglujian">Tanggal Tes</label>
                    <input type="date" class="v2-input" id="tglujian" name="tglujian" value="<?= htmlspecialchars(date('Y-m-d', $jadwal->tgl_tes)); ?>" required>
                </div>

                <div class="field-block">
                    <label class="v2-label" for="wktujian">Waktu Tes</label>
                    <input type="time" class="v2-input" id="wktujian" name="wktujian" value="<?= htmlspecialchars(date('H:i', $jadwal->tgl_tes)); ?>" required>
                </div>
            </div>

            <div class="soal-form-actions" style="margin-top: 24px;">
                <button type="submit" class="v2-btn v2-btn--primary">Update Jadwal</button>
            </div>
        </form>
    </div>
</section>
<?php else : ?>
<section class="admin-page-section">
    <div class="v2-card">
        <div class="empty-state">
            <p class="empty-state__label">Data jadwal tidak ditemukan.</p>
            <a href="<?= base_url('admin/jadwal'); ?>" class="v2-btn v2-btn--primary">Kembali ke jadwal</a>
        </div>
    </div>
</section>
<?php endif; ?>
