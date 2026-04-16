    </section>

    <footer class="admin-footer">
        <div>
            <strong>SIPENMARU UUI</strong>
            <span>Panel administrasi penerimaan mahasiswa baru.</span>
        </div>
        <span>&copy; <?= date('Y'); ?> Universitas Ubudiyah Indonesia</span>
    </footer>
</main>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="logoutModalLabel">Akhiri sesi admin?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">Pilih logout untuk keluar dari panel admin SIPENMARU.</div>
            <div class="modal-footer border-0">
                <button class="btn btn-light" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-dark" href="<?= base_url('auth/logout'); ?>">Logout</a>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script>

<script>
    (function() {
        var app = document.getElementById('adminApp');
        var toggle = document.getElementById('adminMenuToggle');
        var backdrop = document.getElementById('adminBackdrop');

        // v2 modal toggle (data-toggle="modal" data-target="#id")
        document.addEventListener('click', function(e) {
            var trigger = e.target.closest('[data-toggle="modal"]');
            if (trigger) {
                e.preventDefault();
                var targetId = trigger.getAttribute('data-target');
                if (!targetId) return;
                var modal = document.querySelector(targetId);
                if (modal) { modal.classList.toggle('show'); }
            }
            var dismiss = e.target.closest('[data-dismiss="modal"]');
            if (dismiss) {
                var modal = dismiss.closest('.v2-modal-overlay');
                if (modal) modal.classList.remove('show');
            }
        });

        function toggleMenu() {
            if (!app) {
                return;
            }
            app.classList.toggle('sidebar-open');
        }

        if (toggle) {
            toggle.addEventListener('click', toggleMenu);
        }

        if (backdrop) {
            backdrop.addEventListener('click', toggleMenu);
        }

        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass('selected').html(fileName);
        });

        $('.form-check-input').on('click', function() {
            var menuId = $(this).data('menu');
            var roleId = $(this).data('role');

            $.ajax({
                url: "<?= base_url('admin/changeaccess'); ?>",
                type: 'post',
                data: {
                    menuId: menuId,
                    roleId: roleId
                },
                success: function() {
                    document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
                }
            });
        });
    })();
</script>

</body>

</html>