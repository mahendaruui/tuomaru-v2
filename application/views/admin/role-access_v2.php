<section class="admin-page-section">
    <div class="section-head">
        <div>
            <p class="admin-eyebrow">Manajemen Akses</p>
            <h2 class="section-title">Hak Akses Menu</h2>
        </div>
        <a class="action-btn action-btn--ghost" href="<?= base_url('admin/role'); ?>">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Role
        </a>
    </div>

    <div class="role-access-meta">
        <div class="role-badge-lg">
            <i class="fas fa-shield-alt"></i>
            <span><?= htmlspecialchars($role['role']); ?></span>
        </div>
        <p class="role-access-hint">Centang menu yang boleh diakses oleh role ini. Perubahan langsung disimpan otomatis.</p>
    </div>

    <div class="v2-card">
        <div class="access-grid-head">
            <span>Menu</span>
            <span>Akses</span>
        </div>
        <?php $i = 1; foreach ($menu as $m) : ?>
        <div class="access-row">
            <div class="access-row__meta">
                <span class="access-row__num"><?= $i; ?></span>
                <span class="access-row__name"><?= htmlspecialchars($m['menu']); ?></span>
            </div>
            <label class="v2-toggle">
                <input type="checkbox"
                    class="v2-toggle__input access-checkbox"
                    <?= check_access($role['id'], $m['id']); ?>
                    data-role="<?= $role['id']; ?>"
                    data-menu="<?= $m['id']; ?>">
                <span class="v2-toggle__track">
                    <span class="v2-toggle__thumb"></span>
                </span>
            </label>
        </div>
        <?php $i++; endforeach; ?>
    </div>

    <div class="access-status" id="accessStatus"></div>
</section>

<script>
(function () {
    var baseUrl = '<?= base_url('admin/changeaccess'); ?>';

    document.querySelectorAll('.access-checkbox').forEach(function (cb) {
        cb.addEventListener('change', function () {
            var menuId = this.getAttribute('data-menu');
            var roleId = this.getAttribute('data-role');
            var status = document.getElementById('accessStatus');

            var xhr = new XMLHttpRequest();
            xhr.open('POST', baseUrl, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (status) {
                    status.className = 'access-status access-status--show access-status--ok';
                    status.textContent = 'Akses berhasil diperbarui.';
                    setTimeout(function () { status.className = 'access-status'; }, 2200);
                }
            };
            xhr.onerror = function () {
                if (status) {
                    status.className = 'access-status access-status--show access-status--err';
                    status.textContent = 'Gagal menyimpan perubahan.';
                    setTimeout(function () { status.className = 'access-status'; }, 2200);
                }
            };
            xhr.send('menuId=' + encodeURIComponent(menuId) + '&roleId=' + encodeURIComponent(roleId));
        });
    });
})();
</script>
