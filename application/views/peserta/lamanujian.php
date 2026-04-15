<script src="<?= base_url() ?>/assets/js/jqueryqore.js"></script>
<script src="<?= base_url() ?>/assets/js/jquery.countdown.js"></script>
<?php foreach ($peserta as $p) : ?>

  <div class="container">
    <div class="card-body">
      <h4 class="card-title">Halaman Ujian Online</h4>
      <h2 class="mt-2 mx-auto text-center alert alert-primary">Semoga Sukses, <Span class="font-bold"><?= strtoupper($p->nama); ?>!</Span></h2>

      <hr>
      <div class="alert alert-warning">
        <div class="h3 text-center mb-3">
          <h4>Perhatian: Kerjakan soal dengan memilih salah satu jawaban pada pilihan jawaban yang telah disediakan.</h4>
          <h4>Waktu anda 2 Jam dari jadwal yang telah ditentukan</h4>
          <br>
          <div id="tesmundur" class="text-center"></div>
        </div>
      </div>
    </div>
    <hr>
    <!-- area soal -->
    <div class="card">
      <div class="card-body wizard-content">
        <h4 class="card-title alert alert-warning">Pilih jawaban yang anda anggap benar! </h4>
        <form id="example-form" action="<?= base_url('dashboard/liveTesAns') ?>" class="m-t-40" method="post">
          <div>
            <?php $no = 1; ?>
            <?php foreach ($datatesoke as $s) : ?>
              <!-- <h5></h5> -->
              <section class="mb-3" style="border: 1px solid #ccc; padding: 10px;">
                <label>Pertanyaan : <?= $no ?></label>
                <p><?php echo $s->soal; ?></p>
                <input type="text" name="idsoal" hidden value="<?= $s->id ?>">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <input type="radio" value="<?= $s->id ?>-A" name="jwb[<?= $s->id ?>]" <?= ($s->jwb == "A" ? 'checked="checked"' : ''); ?> />
                    </div>
                  </div>
                  <input type="text" class="form-control" aria-label="Text input with radio button" disabled placeholder="A. <?php echo $s->opsi_a; ?>">
                </div>

                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <input type="radio" value="<?= $s->id ?>-B" name="jwb[<?= $s->id ?>]" <?= ($s->jwb == "B" ? 'checked="checked"' : ''); ?> />
                    </div>
                  </div>
                  <input type="text" class="form-control" aria-label="Text input with radio button" disabled placeholder="B. <?php echo $s->opsi_b; ?>">
                </div>

                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <input type="radio" value="<?= $s->id ?>-C" name="jwb[<?= $s->id ?>]" <?= ($s->jwb == "C" ? 'checked="checked"' : ''); ?> />
                    </div>
                  </div>
                  <input type="text" class="form-control" aria-label="Text input with radio button" disabled placeholder="C. <?php echo $s->opsi_c; ?>">
                </div>

                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <input type="radio" value="<?= $s->id ?>-D" name="jwb[<?= $s->id ?>]" <?= ($s->jwb == "D" ? 'checked="checked"' : ''); ?> />
                    </div>
                  </div>
                  <input type="text" class="form-control" aria-label="Text input with radio button" disabled placeholder="D. <?php echo $s->opsi_d; ?>">
                </div>

                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <input type="radio" value="<?= $s->id ?>-E" name="jwb[<?= $s->id ?>]" <?= ($s->jwb == "E" ? 'checked="checked"' : ''); ?> />
                    </div>
                  </div>
                  <input type="text" class="form-control" aria-label="Text input with radio button" disabled placeholder="E. <?php echo $s->opsi_e; ?>">
                </div>
              </section>
              <?php $no++; ?>
            <?php endforeach; ?>
          </div>
          <div class="text-center mt-4 mb-4">
            <a href="<?= base_url('dashboard/selesai') ?>" class="btn btn-lg btn-success" onclick="return confirm('Apakah Anda yakin ingin menyelesaikan ujian? Pastikan semua jawaban sudah terisi.')">
              <i class="fas fa-check-circle mr-2"></i> Selesaikan Ujian
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>

<?php endforeach; ?>

<!-- this page js -->
<script src="<?= base_url() ?>/vendor/matrix_admin/assets/libs/jquery-steps/build/jquery.steps.min.js"></script>
<script src="<?= base_url() ?>/vendor/matrix_admin/assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>

<script>
  var hitung = '<?= $wktmundurtes ?>';
  $('#tesmundur').countdown(hitung)
    .on('update.countdown', function(event) {
      var format = '%H:%M:%S';
      if (event.offset.totalDays > 0) {
        format = '%-d day%!d ' + format;
      }
      if (event.offset.weeks > 0) {
        format = '%-w week%!w ' + format;
      }
      $(this).html(event.strftime(format));
    })
    .on('finish.countdown', function(event) {
      $("#btnstart").append(`<form action="<?= base_url('dashboard/lamanUjian') ?>"><button class="btn btn-lg btn-block btn-primary" id="ts-success">Start!</button></form>`);
      $(".ket").html('');
      $(".ket").append(`<h4 class="text-danger">Klik tombol 'Start' untuk memulai ujian</h4>`);
      $("#clock").remove();
      window.location.replace("<?= base_url('dashboard/selesai') ?>");

    });
</script>

<script>
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
    headerTag: "h5",
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
      alert("Terima kasih!!");
      window.location.replace("<?= base_url('dashboard/selesai') ?>");
    }
  });
</script>

<script>
  $(document).ready(function() {
    $('input[type="radio"]').click(function() {
      let strJawab = $(this).val()
      let idSoal = strJawab.split("-")
      console.log(idSoal[0]);
      console.log(idSoal[1]);
      $.ajax({
        url: "<?= base_url() ?>Dashboard/livetesans",
        method: "POST",
        dataType: "html",
        // cache: false,
        data: {
          idsoal: idSoal[0],
          jawaban: idSoal[1]
        },
        error: function(data) {
          // alert('something is wrong')
        },
        success: function(data) {
          // alert('data masuk')
        }
      });
    });

  });
</script>