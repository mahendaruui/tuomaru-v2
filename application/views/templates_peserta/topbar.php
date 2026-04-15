<?php if (!isset($disablebtn)) : ?>
  <li class="navbar navbar-expand-lg navbar navbar-dark bg-primary justify-content-between">
    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
      <img src="<?= base_url('assets/img/uuilogo.png'); ?>" width="150px" alt="Logo SIPENMARU UUI" class="img-fluid mb-2">
      <a class="navbar-brand" href="<?= base_url('dashboard') ?>" style="margin-top: 0; text-align: center;">Sistem Ujian Online Universitas Ubudiyah Indonesia</a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="form-inline">
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="<?= base_url('dashboard') ?>">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('dashboard/profil') ?>">My Profil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('login/logout') ?>">Logout</a>
          </li>

        </ul>
      </div>
    </div>
  </li>
<?php else : ?>
  <li class="navbar navbar-expand-lg navbar navbar-dark bg-primary justify-content-between">
    <a class="navbar-brand" href="<?= base_url('dashboard') ?>" onclick="return false;">Sistem Ujian Online | Universitas Ubudiyah Indonesia</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="form-inline">
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <!-- <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="<?= base_url('dashboard') ?>" onclick="return false;">Home</a>
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url('dashboard/profil') ?>" onclick="return false;">My Profil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url('login/logout') ?>" onclick="return false;">Logout</a>
            </li>
          </ul> -->

      </div>
    </div>
  </li>
<?php endif; ?>