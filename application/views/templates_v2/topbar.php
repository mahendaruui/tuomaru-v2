<?php $currentDate = date('d M Y'); ?>

<header class="admin-topbar">
    <div>
        <button class="admin-menu-toggle" id="adminMenuToggle" type="button" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <p class="admin-eyebrow">Sistem Ujian Online</p>
        <h1 class="admin-page-title"><?= $title; ?></h1>
    </div>

    <div class="admin-topbar__actions">
        <div class="admin-date-pill">
            <i class="far fa-calendar-alt"></i>
            <span><?= $currentDate; ?></span>
        </div>

        <div class="dropdown">
            <button class="admin-user" type="button" id="userDropdownV2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="admin-user__meta">
                    <strong><?= $user['name']; ?></strong>
                    <small>Administrator</small>
                </span>
                <img class="admin-user__avatar" src="<?= base_url('assets/img/profile/') . $user['image']; ?>" alt="<?= $user['name']; ?>">
            </button>
            <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" aria-labelledby="userDropdownV2">
                <a class="dropdown-item" href="<?= base_url('user'); ?>">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-muted"></i>
                    My Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= base_url('auth/logout'); ?>" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-muted"></i>
                    Logout
                </a>
            </div>
        </div>
    </div>
</header>

<section class="admin-content-shell">