<section class="admin-page-section">
    <div class="section-head">
        <div>
            <p class="admin-eyebrow">Manajemen Akses</p>
            <h2 class="section-title">Role Pengguna</h2>
        </div>
        <button class="action-btn" data-toggle="modal" data-target="#newRoleModal">
            <i class="fas fa-plus"></i>
            Tambah Role
        </button>
    </div>

    <?php $msg = $this->session->userdata('role_msg'); if ($msg): $this->session->unset_userdata('role_msg'); ?>
        <?= $msg ?>
    <?php endif; ?>

    <?= form_error('role', '<div class="v2-alert v2-alert--danger"><i class="fas fa-exclamation-circle"></i>', '</div>'); ?>

    <div class="v2-card">
        <?php if (empty($role)): ?>
            <div class="empty-state">
                <i class="fas fa-shield-alt"></i>
                <p>Belum ada role yang ditambahkan.</p>
            </div>
        <?php else: ?>
            <table class="v2-table">
                <thead>
                    <tr>
                        <th style="width:56px">#</th>
                        <th>Nama Role</th>
                        <th style="width:180px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($role as $r): ?>
                    <tr>
                        <td class="row-num"><?= $i; ?></td>
                        <td>
                            <span class="role-pill"><?= htmlspecialchars($r['role']); ?></span>
                        </td>
                        <td>
                            <div class="row-actions">
                                <a href="<?= base_url('admin/roleaccess/') . $r['id']; ?>" class="row-action row-action--warning" title="Atur akses">
                                    <i class="fas fa-key"></i> Akses
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php $i++; endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</section>

<!-- Modal Tambah Role -->
<div class="v2-modal-overlay" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel" aria-hidden="true">
    <div class="v2-modal">
        <div class="v2-modal__head">
            <div>
                <p class="admin-eyebrow">Buat baru</p>
                <h3 id="newRoleModalLabel">Tambah Role</h3>
            </div>
            <button class="v2-modal__close" type="button" data-dismiss="modal" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="<?= base_url('admin/role'); ?>" method="post">
            <div class="v2-modal__body">
                <label class="v2-label" for="roleInput">Nama Role</label>
                <input class="v2-input" type="text" id="roleInput" name="role" placeholder="cth: Administrator, Staff...">
            </div>
            <div class="v2-modal__footer">
                <button class="v2-btn v2-btn--ghost" type="button" data-dismiss="modal">Batal</button>
                <button class="v2-btn v2-btn--primary" type="submit">
                    <i class="fas fa-plus"></i> Simpan Role
                </button>
            </div>
        </form>
    </div>
</div>
