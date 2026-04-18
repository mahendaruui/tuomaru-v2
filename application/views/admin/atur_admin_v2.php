<?php
$selfId = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()['id'] ?? 0;
?>

<section class="admin-page-section">
    <div class="section-head">
        <div>
            <p class="admin-eyebrow">Manajemen Akun</p>
            <h2 class="section-title">Atur Admin</h2>
        </div>
        <button type="button" class="action-btn" id="btnTambahAdmin">
            <i class="fas fa-plus"></i> Tambah Admin
        </button>
    </div>

    <!-- Flash message -->
    <?php if (!empty($admin_msg)) : ?>
        <?= $admin_msg ?>
    <?php endif; ?>

    <!-- Tabel admin -->
    <div class="v2-card">
        <?php if (empty($admins)) : ?>
            <div class="empty-state">
                <i class="fas fa-users-cog"></i>
                <p>Belum ada data admin.</p>
            </div>
        <?php else : ?>
            <div class="v2-card__toolbar">
                <span class="v2-card__count"><?= count($admins); ?> admin</span>
            </div>
            <div class="table-scroll">
                <table class="v2-table">
                    <thead>
                        <tr>
                            <th class="row-num-head">#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($admins as $a) :
                            $isSelf   = ($a['id'] == $selfId);
                            $roleLabel = '';
                            foreach ($roles as $r) {
                                if ($r['id'] == $a['role_id']) { $roleLabel = $r['role']; break; }
                            }
                        ?>
                        <tr>
                            <td class="row-num"><?= $no; ?></td>
                            <td>
                                <span class="admin-name-cell">
                                    <?= htmlspecialchars($a['name']); ?>
                                    <?php if ($isSelf) : ?><span class="self-badge">Anda</span><?php endif; ?>
                                </span>
                            </td>
                            <td class="text-muted-cell"><?= htmlspecialchars($a['email']); ?></td>
                            <td><span class="role-pill"><?= htmlspecialchars($roleLabel ?: '-'); ?></span></td>
                            <td>
                                <?php if ($a['is_active']) : ?>
                                    <span class="status-pill status-pill--active">Aktif</span>
                                <?php else : ?>
                                    <span class="status-pill status-pill--inactive">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-muted-cell"><?= date('d M Y', $a['date_created']); ?></td>
                            <td class="row-actions">
                                <button type="button"
                                    class="row-action row-action--warning btn-edit-admin"
                                    data-id="<?= $a['id']; ?>"
                                    data-name="<?= htmlspecialchars($a['name'], ENT_QUOTES); ?>"
                                    data-role="<?= $a['role_id']; ?>"
                                    title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button type="button"
                                    class="row-action row-action--info btn-reset-pass"
                                    data-id="<?= $a['id']; ?>"
                                    data-name="<?= htmlspecialchars($a['name'], ENT_QUOTES); ?>"
                                    title="Reset Password">
                                    <i class="fas fa-key"></i>
                                </button>
                                <?php if (!$isSelf) : ?>
                                    <a href="<?= base_url('admin/toggleAdmin/' . $a['id']); ?>"
                                       class="row-action <?= $a['is_active'] ? 'row-action--danger' : 'row-action--success'; ?>"
                                       title="<?= $a['is_active'] ? 'Nonaktifkan' : 'Aktifkan'; ?>"
                                       onclick="return confirm('<?= $a['is_active'] ? 'Nonaktifkan' : 'Aktifkan'; ?> admin <?= htmlspecialchars($a['name'], ENT_QUOTES); ?>?')">
                                        <i class="fas <?= $a['is_active'] ? 'fa-ban' : 'fa-check'; ?>"></i>
                                    </a>
                                    <a href="<?= base_url('admin/hapusAdmin/' . $a['id']); ?>"
                                       class="row-action row-action--danger"
                                       title="Hapus"
                                       onclick="return confirm('Hapus admin <?= htmlspecialchars($a['name'], ENT_QUOTES); ?>? Tindakan ini tidak dapat dibatalkan.')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php $no++; endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Modal: Tambah Admin -->
<div class="v2-modal-overlay" id="modalTambah">
    <div class="v2-modal">
        <div class="v2-modal__head">
            <div>
                <p class="admin-eyebrow">Akun Baru</p>
                <h3>Tambah Admin</h3>
            </div>
            <button type="button" class="v2-modal__close" id="closeTambah"><i class="fas fa-times"></i></button>
        </div>
        <form action="<?= base_url('admin/tambahAdmin'); ?>" method="post">
            <div class="v2-modal__body">
                <div class="v2-field">
                    <label class="v2-label" for="add_name">Nama Lengkap</label>
                    <input type="text" id="add_name" name="name" class="v2-input" placeholder="Nama admin" required>
                </div>
                <div class="v2-field">
                    <label class="v2-label" for="add_email">Email</label>
                    <input type="email" id="add_email" name="email" class="v2-input" placeholder="email@domain.com" required>
                </div>
                <div class="v2-field">
                    <label class="v2-label" for="add_password">Password</label>
                    <input type="password" id="add_password" name="password" class="v2-input" placeholder="Minimal 6 karakter" required>
                </div>
                <div class="v2-field">
                    <label class="v2-label" for="add_role">Role</label>
                    <select id="add_role" name="role_id" class="v2-input">
                        <?php foreach ($roles as $r) : ?>
                            <option value="<?= $r['id']; ?>"><?= htmlspecialchars($r['role']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="v2-modal__footer">
                <button type="button" class="v2-btn v2-btn--ghost" id="cancelTambah">Batal</button>
                <button type="submit" class="v2-btn v2-btn--primary"><i class="fas fa-plus"></i> Tambah</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Admin -->
<div class="v2-modal-overlay" id="modalEdit">
    <div class="v2-modal">
        <div class="v2-modal__head">
            <div>
                <p class="admin-eyebrow">Edit Data</p>
                <h3>Edit Admin</h3>
            </div>
            <button type="button" class="v2-modal__close" id="closeEdit"><i class="fas fa-times"></i></button>
        </div>
        <form action="<?= base_url('admin/editAdmin'); ?>" method="post">
            <input type="hidden" name="id" id="edit_id">
            <div class="v2-modal__body">
                <div class="v2-field">
                    <label class="v2-label" for="edit_name">Nama Lengkap</label>
                    <input type="text" id="edit_name" name="name" class="v2-input" required>
                </div>
                <div class="v2-field">
                    <label class="v2-label" for="edit_role">Role</label>
                    <select id="edit_role" name="role_id" class="v2-input">
                        <?php foreach ($roles as $r) : ?>
                            <option value="<?= $r['id']; ?>"><?= htmlspecialchars($r['role']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="v2-modal__footer">
                <button type="button" class="v2-btn v2-btn--ghost" id="cancelEdit">Batal</button>
                <button type="submit" class="v2-btn v2-btn--primary"><i class="fas fa-save"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Reset Password -->
<div class="v2-modal-overlay" id="modalReset">
    <div class="v2-modal">
        <div class="v2-modal__head">
            <div>
                <p class="admin-eyebrow">Keamanan</p>
                <h3>Reset Password</h3>
            </div>
            <button type="button" class="v2-modal__close" id="closeReset"><i class="fas fa-times"></i></button>
        </div>
        <form action="<?= base_url('admin/resetPasswordAdmin'); ?>" method="post">
            <input type="hidden" name="id" id="reset_id">
            <div class="v2-modal__body">
                <p id="resetAdminName" class="mb-3" style="color:var(--admin-muted); font-size:0.9rem;"></p>
                <div class="v2-field">
                    <label class="v2-label" for="reset_password">Password Baru</label>
                    <input type="password" id="reset_password" name="password" class="v2-input" placeholder="Minimal 6 karakter" required>
                </div>
            </div>
            <div class="v2-modal__footer">
                <button type="button" class="v2-btn v2-btn--ghost" id="cancelReset">Batal</button>
                <button type="submit" class="v2-btn v2-btn--primary"><i class="fas fa-key"></i> Reset</button>
            </div>
        </form>
    </div>
</div>

<script>
(function () {
    function openModal(id) { document.getElementById(id).classList.add('show'); }
    function closeModal(id) { document.getElementById(id).classList.remove('show'); }

    // Tambah
    document.getElementById('btnTambahAdmin').addEventListener('click', function () { openModal('modalTambah'); });
    document.getElementById('closeTambah').addEventListener('click', function () { closeModal('modalTambah'); });
    document.getElementById('cancelTambah').addEventListener('click', function () { closeModal('modalTambah'); });

    // Edit
    document.querySelectorAll('.btn-edit-admin').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('edit_id').value   = this.dataset.id;
            document.getElementById('edit_name').value = this.dataset.name;
            var sel = document.getElementById('edit_role');
            for (var i = 0; i < sel.options.length; i++) {
                sel.options[i].selected = (sel.options[i].value == this.dataset.role);
            }
            openModal('modalEdit');
        });
    });
    document.getElementById('closeEdit').addEventListener('click', function () { closeModal('modalEdit'); });
    document.getElementById('cancelEdit').addEventListener('click', function () { closeModal('modalEdit'); });

    // Reset password
    document.querySelectorAll('.btn-reset-pass').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('reset_id').value = this.dataset.id;
            document.getElementById('resetAdminName').textContent = 'Reset password untuk: ' + this.dataset.name;
            document.getElementById('reset_password').value = '';
            openModal('modalReset');
        });
    });
    document.getElementById('closeReset').addEventListener('click', function () { closeModal('modalReset'); });
    document.getElementById('cancelReset').addEventListener('click', function () { closeModal('modalReset'); });

    // Tutup modal saat klik overlay
    ['modalTambah', 'modalEdit', 'modalReset'].forEach(function (id) {
        document.getElementById(id).addEventListener('click', function (e) {
            if (e.target === this) closeModal(id);
        });
    });
})();
</script>
