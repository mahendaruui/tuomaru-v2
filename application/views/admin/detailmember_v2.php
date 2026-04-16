<?php if (!empty($detailmember)) : ?>
<?php $member = $detailmember[0]; ?>
<?php
$birthDate = !empty($member->tanggal) ? tgl_indo($member->tanggal) : '-';
$registerDate = !empty($member->tgl_daftar) ? tgl_indo($member->tgl_daftar) : '-';
$fullBirth = trim((string) $member->tempat) !== '' ? $member->tempat . ' / ' . $birthDate : $birthDate;
$genderClass = strtolower((string) $member->jenkel) === 'p' ? 'gender-pill--p' : 'gender-pill--l';
$photoPath = !empty($member->foto) ? base_url('foto/' . $member->foto) : null;
$initial = strtoupper(substr(trim((string) $member->nama), 0, 1));
?>
<section class="admin-page-section">
    <div class="section-head">
        <div>
            <p class="admin-eyebrow">Profil Peserta</p>
            <h2 class="section-title">Detail Peserta</h2>
        </div>
        <a href="<?= base_url('admin/viewpeserta'); ?>" class="action-btn action-btn--ghost">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Peserta
        </a>
    </div>

    <div class="detail-layout">
        <div class="detail-hero-card">
            <div class="detail-hero-card__header">
                <span class="ujian-badge">No. Ujian <?= htmlspecialchars($member->no_ujian); ?></span>
                <span class="gender-pill <?= $genderClass; ?>"><?= htmlspecialchars($member->jenkel ?: '-'); ?></span>
            </div>

            <div class="detail-profile">
                <div class="detail-profile__media">
                    <?php if ($photoPath) : ?>
                        <img src="<?= $photoPath; ?>" alt="<?= htmlspecialchars($member->nama); ?>" class="detail-profile__image">
                    <?php else : ?>
                        <div class="detail-profile__placeholder"><?= $initial ?: '?'; ?></div>
                    <?php endif; ?>
                </div>

                <div class="detail-profile__body">
                    <h3 class="detail-profile__name"><?= htmlspecialchars($member->nama); ?></h3>
                    <p class="detail-profile__school"><?= htmlspecialchars($member->asal_sekolah ?: '-'); ?></p>

                    <div class="detail-summary-grid">
                        <div class="detail-stat">
                            <span class="detail-stat__label">NIK</span>
                            <strong class="detail-stat__value"><?= htmlspecialchars($member->no_identitas ?: '-'); ?></strong>
                        </div>
                        <div class="detail-stat">
                            <span class="detail-stat__label">TTL</span>
                            <strong class="detail-stat__value"><?= htmlspecialchars($fullBirth); ?></strong>
                        </div>
                        <div class="detail-stat">
                            <span class="detail-stat__label">Agama</span>
                            <strong class="detail-stat__value"><?= htmlspecialchars($member->agama ?: '-'); ?></strong>
                        </div>
                        <div class="detail-stat">
                            <span class="detail-stat__label">Terdaftar</span>
                            <strong class="detail-stat__value"><?= htmlspecialchars($registerDate); ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="detail-side-stack">
            <div class="v2-card detail-panel">
                <div class="detail-panel__head">
                    <h3>Kontak</h3>
                </div>
                <div class="detail-list">
                    <div class="detail-list__row">
                        <span>Email</span>
                        <strong><?= htmlspecialchars($member->email ?: '-'); ?></strong>
                    </div>
                    <div class="detail-list__row">
                        <span>No. Telepon</span>
                        <strong><?= htmlspecialchars($member->hp ?: '-'); ?></strong>
                    </div>
                    <div class="detail-list__row">
                        <span>Password</span>
                        <strong><span class="pass-code"><?= htmlspecialchars($member->pass ?: '-'); ?></span></strong>
                    </div>
                </div>
            </div>

            <div class="v2-card detail-panel">
                <div class="detail-panel__head">
                    <h3>Alamat</h3>
                </div>
                <div class="detail-list">
                    <div class="detail-list__row">
                        <span>Alamat</span>
                        <strong><?= htmlspecialchars($member->alamat ?: '-'); ?></strong>
                    </div>
                    <div class="detail-list__row">
                        <span>Desa</span>
                        <strong><?= htmlspecialchars($member->alamat_desa ?: '-'); ?></strong>
                    </div>
                    <div class="detail-list__row">
                        <span>Kecamatan</span>
                        <strong><?= htmlspecialchars($member->alamat_kec ?: '-'); ?></strong>
                    </div>
                    <div class="detail-list__row">
                        <span>Kota</span>
                        <strong><?= htmlspecialchars($member->alamat_kota ?: '-'); ?></strong>
                    </div>
                    <div class="detail-list__row">
                        <span>Provinsi</span>
                        <strong><?= htmlspecialchars($member->alamat_prov ?: '-'); ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php else : ?>
<section class="admin-page-section">
    <div class="v2-card">
        <div class="empty-state">
            <p class="empty-state__label">Data peserta tidak ditemukan.</p>
            <a href="<?= base_url('admin/viewpeserta'); ?>" class="v2-btn v2-btn--primary">Kembali ke daftar peserta</a>
        </div>
    </div>
</section>
<?php endif; ?>
