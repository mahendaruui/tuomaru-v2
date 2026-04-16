<?php if (!empty($profilmember)) : ?>
  <?php $peserta = $profilmember[0]; ?>
  <?php
  $fotoPeserta = !empty($peserta->foto) ? base_url('foto/' . $peserta->foto) : '';
  $initialPeserta = strtoupper(substr(trim((string)$peserta->nama), 0, 1));
  ?>

  <section class="peserta-dashboard peserta-dashboard--profil">
    <div class="profil-shell">
      <div class="profil-identity">
        <?php if (!empty($fotoPeserta)) : ?>
          <img src="<?= $fotoPeserta; ?>" alt="Foto <?= htmlspecialchars($peserta->nama); ?>" class="profil-avatar">
        <?php else : ?>
          <div class="profil-avatar profil-avatar--placeholder"><?= $initialPeserta; ?></div>
        <?php endif; ?>

        <p class="peserta-eyebrow">Profil Peserta</p>
        <h2 class="profil-name"><?= strtoupper(htmlspecialchars($peserta->nama)); ?></h2>
        <p class="profil-subtitle">Nomor Registrasi: <?= htmlspecialchars($peserta->no_ujian); ?></p>
      </div>

      <div class="profil-content">
        <div class="profil-card">
          <h3>Identitas</h3>
          <dl class="profil-list">
            <div>
              <dt>No Registrasi</dt>
              <dd><?= htmlspecialchars($peserta->no_ujian); ?></dd>
            </div>
            <div>
              <dt>No Kependudukan</dt>
              <dd><?= htmlspecialchars($peserta->no_identitas ?: '-'); ?></dd>
            </div>
            <div>
              <dt>Jenis Kelamin</dt>
              <dd><?= htmlspecialchars($peserta->jenkel ?: '-'); ?></dd>
            </div>
            <div>
              <dt>Agama</dt>
              <dd><?= htmlspecialchars($peserta->agama ?: '-'); ?></dd>
            </div>
            <div>
              <dt>Tempat, Tanggal Lahir</dt>
              <dd><?= htmlspecialchars($peserta->tempat ?: '-'); ?>, <?= !empty($peserta->tanggal) ? tgl_indo($peserta->tanggal) : '-'; ?></dd>
            </div>
          </dl>
        </div>

        <div class="profil-card">
          <h3>Kontak dan Alamat</h3>
          <dl class="profil-list">
            <div>
              <dt>Alamat</dt>
              <dd><?= htmlspecialchars(trim(($peserta->alamat ?: '-') . ', ' . ($peserta->alamat_kota ?: '-') . ', ' . ($peserta->alamat_prov ?: '-'))); ?></dd>
            </div>
            <div>
              <dt>Telepon</dt>
              <dd><?= htmlspecialchars($peserta->hp ?: '-'); ?></dd>
            </div>
            <div>
              <dt>Email</dt>
              <dd><?= htmlspecialchars($peserta->email ?: '-'); ?></dd>
            </div>
          </dl>
        </div>
      </div>
    </div>
  </section>
<?php else : ?>
  <section class="peserta-dashboard peserta-dashboard--profil">
    <div class="exam-alert exam-alert--danger">Data profil tidak ditemukan. Silakan hubungi panitia.</div>
  </section>
<?php endif; ?>