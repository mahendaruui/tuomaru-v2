<?php
$initial   = strtoupper(substr($user['name'] ?? 'A', 0, 1));
$avatarSrc = base_url('assets/img/profile/') . htmlspecialchars($user['image'] ?: 'default.jpg');
?>

<section class="admin-page-section">

    <!-- Hero profil -->
    <div class="profil-hero">
        <div class="profil-avatar-wrap">
            <img src="<?= $avatarSrc ?>"
                 alt="<?= htmlspecialchars($user['name']); ?>"
                 class="profil-avatar"
                 id="avatarPreview"
                 onerror="this.style.display='none';document.getElementById('avatarFallback').style.display='flex';">
            <div class="profil-avatar profil-avatar--fallback" id="avatarFallback" style="display:none;"><?= $initial ?></div>
            <label for="avatarInput" class="profil-avatar-edit" title="Ganti foto">
                <i class="fas fa-camera"></i>
            </label>
        </div>
        <div class="profil-hero__meta">
            <h2 class="profil-hero__name"><?= htmlspecialchars($user['name']); ?></h2>
            <span class="profil-hero__role">Administrator</span>
            <p class="profil-hero__email"><i class="fas fa-envelope"></i> <?= htmlspecialchars($user['email']); ?></p>
            <p class="profil-hero__since"><i class="far fa-calendar-alt"></i> Bergabung <?= date('d F Y', (int)$user['date_created']); ?></p>
        </div>
        <form id="avatarForm" action="<?= base_url('admin/profilUpdate'); ?>" method="post" enctype="multipart/form-data" style="display:none;">
            <input type="hidden" name="name" value="<?= htmlspecialchars($user['name']); ?>">
            <input type="file" id="avatarInput" name="image" accept="image/*">
        </form>
    </div>

    <!-- Flash messages -->
    <?php $profilMsg = $this->session->userdata('profil_msg'); if ($profilMsg) : $this->session->unset_userdata('profil_msg'); ?>
        <?= $profilMsg ?>
    <?php endif; ?>
    <?php $passMsg = $this->session->userdata('pass_msg'); if ($passMsg) : $this->session->unset_userdata('pass_msg'); ?>
        <?= $passMsg ?>
    <?php endif; ?>

    <!-- Form row -->
    <div class="profil-form-row">

        <!-- Edit nama -->
        <div class="v2-card profil-card">
            <div class="profil-card__head">
                <p class="admin-eyebrow">Informasi Akun</p>
                <h3>Edit Profil</h3>
            </div>
            <form action="<?= base_url('admin/profilUpdate'); ?>" method="post" enctype="multipart/form-data">
                <input type="file" name="image" style="display:none;">
                <div class="profil-field">
                    <label class="v2-label" for="prof_name">Nama Lengkap</label>
                    <input type="text" id="prof_name" name="name" class="v2-input"
                        value="<?= htmlspecialchars($user['name']); ?>" required>
                </div>
                <div class="profil-field">
                    <label class="v2-label">Email</label>
                    <input type="text" class="v2-input" value="<?= htmlspecialchars($user['email']); ?>" disabled>
                    <small class="profil-hint">Email tidak dapat diubah.</small>
                </div>
                <div class="profil-card__foot">
                    <button type="submit" class="v2-btn v2-btn--primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Ganti password -->
        <div class="v2-card profil-card">
            <div class="profil-card__head">
                <p class="admin-eyebrow">Keamanan</p>
                <h3>Ganti Password</h3>
            </div>
            <form action="<?= base_url('admin/profilPassword'); ?>" method="post">
                <div class="profil-field">
                    <label class="v2-label" for="current_password">Password Saat Ini</label>
                    <input type="password" id="current_password" name="current_password" class="v2-input" placeholder="Masukkan password lama" required>
                </div>
                <div class="profil-field">
                    <label class="v2-label" for="new_password1">Password Baru</label>
                    <input type="password" id="new_password1" name="new_password1" class="v2-input" placeholder="Minimal 6 karakter" required>
                </div>
                <div class="profil-field">
                    <label class="v2-label" for="new_password2">Konfirmasi Password Baru</label>
                    <input type="password" id="new_password2" name="new_password2" class="v2-input" placeholder="Ulangi password baru" required>
                </div>
                <div class="profil-card__foot">
                    <button type="submit" class="v2-btn v2-btn--primary">
                        <i class="fas fa-lock"></i> Ubah Password
                    </button>
                </div>
            </form>
        </div>

    </div>

</section>

<script>
(function () {
    var input = document.getElementById('avatarInput');
    var form  = document.getElementById('avatarForm');
    if (input && form) {
        input.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var preview = document.getElementById('avatarPreview');
                    var fb = document.getElementById('avatarFallback');
                    if (preview) { preview.src = e.target.result; preview.style.display = 'block'; }
                    if (fb) fb.style.display = 'none';
                };
                reader.readAsDataURL(this.files[0]);
                form.submit();
            }
        });
    }
})();
</script>
