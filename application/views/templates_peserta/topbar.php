<?php
$segment2 = $this->uri->segment(2);
$isDashboard = empty($segment2);
$isProfil = $segment2 === 'profil';
?>

<header class="peserta-topbar-wrap">
  <nav class="navbar navbar-expand-lg peserta-topbar">
    <a class="peserta-brand" href="<?= base_url('dashboard') ?>">
      <img src="<?= base_url('assets/img/uuilogo.png'); ?>" alt="Logo Universitas Ubudiyah Indonesia" class="peserta-brand__logo">
      <span class="peserta-brand__text">
        <strong>Sistem Ujian Online</strong>
        <small>Universitas Ubudiyah Indonesia</small>
      </span>
    </a>

    <button class="navbar-toggler peserta-toggler" type="button" data-toggle="collapse" data-target="#pesertaMainNav" aria-controls="pesertaMainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="pesertaMainNav">
      <ul class="navbar-nav ml-auto peserta-menu">
        <?php if (!isset($disablebtn)) : ?>
          <li class="nav-item">
            <a class="nav-link <?= $isDashboard ? 'is-active' : ''; ?>" href="<?= base_url('dashboard') ?>">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $isProfil ? 'is-active' : ''; ?>" href="<?= base_url('dashboard/profil') ?>">Profil Saya</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link--logout" href="<?= base_url('login/logout') ?>">Logout</a>
          </li>
        <?php else : ?>
          <li class="nav-item">
            <span class="peserta-session-badge">Sesi ujian sedang berlangsung</span>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>
</header>