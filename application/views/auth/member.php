<!DOCTYPE html>
<html dir="ltr">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(); ?>/favicon.ico">
  <title><?php echo $title; ?></title>
  <!-- Custom CSS -->
  <link href="<?= base_url(); ?>vendor/matrix_admin/dist/css/style.min.css" rel="stylesheet">
</head>

<body>
  <div class="main-wrapper">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Login box.scss -->
    <!-- ============================================================== -->
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
      <div class="auth-box bg-dark border-secondary">
        <div id="loginform">
          <div class="text-center p-t-10 p-b-10">

            <img src="<?= base_url(); ?>assets/img/uuilogo.png" width="300px" alt="uuilogo" class="mb-3">
            <h4 class="text-light">Selamat Datang di Sistem Tes Ujian Masuk Universitas Ubudiyah Indonesia</h4>
          </div>
          <!-- Form -->
          <form class="form-horizontal m-t-10" id="loginform" action="<?php base_url(); ?>login/ceklogin" method="post">
            <div class="row p-b-10">
              <div class="col-12">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="ti-user"></i></span>
                  </div>
                  <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" required>
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text bg-warning text-white" id="basic-addon2"><i class="ti-pencil"></i></span>
                  </div>
                  <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required>
                </div>
              </div>
            </div>
            <div class="row border-top border-secondary">
              <div class="col-12">
                <div class="form-group">
                  <div class="p-t-10">
                    <!-- <button class="btn btn-info" id="to-recover" type="button"><i class="fa fa-lock m-r-5"></i> Lost password?</button> -->
                    <button class="btn btn-success float-right" type="submit">Login</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- ============================================================== -->
    <!-- Login box.scss -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper scss in scafholding.scss -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper scss in scafholding.scss -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right Sidebar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right Sidebar -->
    <!-- ============================================================== -->
  </div>
  <!-- ============================================================== -->
  <!-- All Required js -->
  <!-- ============================================================== -->
  <script src="<?= base_url(); ?>vendor/matrix_admin/assets/libs/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap tether Core JavaScript -->
  <script src="<?= base_url(); ?>vendor/matrix_admin/assets/libs/popper.js/dist/umd/popper.min.js"></script>
  <script src="<?= base_url(); ?>vendor/matrix_admin/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- ============================================================== -->
  <!-- This page plugin js -->
  <!-- ============================================================== -->
  <script>
    $('[data-toggle="tooltip"]').tooltip();
    $(".preloader").fadeOut();
    // ============================================================== 
    // Login and Recover Password 
    // ============================================================== 
    $('#to-recover').on("click", function() {
      $("#loginform").slideUp();
      $("#recoverform").fadeIn();
    });
    $('#to-login').click(function() {

      $("#recoverform").hide();
      $("#loginform").fadeIn();
    });
  </script>

</body>

</html>