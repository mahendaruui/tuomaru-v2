<nav class="navbar fixed-bottom navbar-dark bg-dark">
  <p class="text-light m-auto">Copyright@<?= date('Y') ?> | Student-UUI</p>
</nav>
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="<?= base_url() ?>/vendor/matrix_admin/assets/libs/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="<?= base_url() ?>/vendor/matrix_admin/assets/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="<?= base_url() ?>/vendor/matrix_admin/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>/vendor/matrix_admin/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
<script src="<?= base_url() ?>/vendor/matrix_admin/assets/extra-libs/sparkline/sparkline.js"></script>
<!--Wave Effects -->
<script src="<?= base_url() ?>/vendor/matrix_admin/dist/js/waves.js"></script>
<!--Menu sidebar -->
<script src="<?= base_url() ?>/vendor/matrix_admin/dist/js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="<?= base_url() ?>/vendor/matrix_admin/dist/js/custom.min.js"></script>
<!--This page JavaScript -->
<!-- <script src="<?= base_url() ?>/vendor/matrix_admin/dist/js/pages/dashboards/dashboard1.js"></script> -->
<!-- Charts js Files -->
<script src="<?= base_url() ?>/vendor/matrix_admin/assets/libs/flot/excanvas.js"></script>
<script src="<?= base_url() ?>/vendor/matrix_admin/assets/libs/flot/jquery.flot.js"></script>
<script src="<?= base_url() ?>/vendor/matrix_admin/assets/libs/flot/jquery.flot.pie.js"></script>
<script src="<?= base_url() ?>/vendor/matrix_admin/assets/libs/flot/jquery.flot.time.js"></script>
<script src="<?= base_url() ?>/vendor/matrix_admin/assets/libs/flot/jquery.flot.stack.js"></script>
<script src="<?= base_url() ?>/vendor/matrix_admin/assets/libs/flot/jquery.flot.crosshair.js"></script>
<script src="<?= base_url() ?>/vendor/matrix_admin/assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
<script src="<?= base_url() ?>/vendor/matrix_admin/dist/js/pages/chart/chart-page-init.js"></script>

<!-- this page js -->
<script src="<?= base_url() ?>/vendor/matrix_admin/assets/libs/jquery-steps/build/jquery.steps.min.js"></script>
<script src="<?= base_url() ?>/vendor/matrix_admin/assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- <script>
  // Basic Example with form
  var form = $("#example-form");
  form.validate({
    errorPlacement: function errorPlacement(error, element) {
      element.before(error);
    },
    rules: {
      confirm: {
        equalTo: "#password"
      }
    }
  });
  form.children("div").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    onStepChanging: function(event, currentIndex, newIndex) {
      form.validate().settings.ignore = ":disabled,:hidden";
      return form.valid();
    },
    onFinishing: function(event, currentIndex) {
      form.validate().settings.ignore = ":disabled";
      return form.valid();
    },
    onFinished: function(event, currentIndex) {
      alert("Submitted!")
      window.location.replace("<?= base_url('dashboard/liveTesAns') ?>");
    }
  });
</script> -->

</body>

</html>