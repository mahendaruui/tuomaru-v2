<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Atur Peserta <span class="badge badge-info"> Gelombang <?= $gel; ?></span></h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Peserta terdaftar pada Gel. <?= $gel ?></h6>
        </div>
        <div class="card-body">
          <form action="<?= base_url(); ?>Admin/hapusset/" method="post">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Nomor Ujian</th>
                    <th>Password</th>
                    <th width="20%">Nama Peserta</th>
                    <th>Jenis Kelamin</th>
                    <th>Asal Sekolah</th>
                    <th align="center">Hapus All <input type="checkbox" id="selectall" /></th>
                  </tr>
                </thead>
                <tbody>
                  <input type="text" name="sesigel" value="<?= $gel ?>" hidden>
                  <?php
                  $no = 1;
                  foreach ($pesertates as $peserta) :
                    if ($peserta->sesi == $gel) :
                  ?>
                      <tr class="font-weight-light">
                        <td><?= $no; ?></td>
                        <td><?= $peserta->no_ujian; ?></td>
                        <td><?= $peserta->pass; ?></td>
                        <td><?= $peserta->nama; ?></td>
                        <td><?= $peserta->jenkel; ?></td>
                        <td><?= $peserta->asal_sekolah; ?></td>
                        <td align="center">
                          <input type="checkbox" class="case" name="gel[]" value="<?= $peserta->id . '' . $gel; ?>" />
                        </td>
                      </tr>
                  <?php
                    endif;
                    $no++;
                  endforeach; ?>
                </tbody>
              </table>
            </div>
            <button class="btn btn-danger" type="submit" onclick="return confirm('Apakah anda yakin menghapus peserta ini?')">Hapus</button>
          </form>
        </div>
      </div>
    </div>
  </div>


  <div class="row">
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">List Pendaftar Sipenmaru (belum terdaftar peserta Ujian) <span class="badge badge-info"> <?php echo $ket; ?></span></h6>
        </div>
        <div class="card-body">
          <form action="<?= base_url(); ?>Admin/setpeserta/" method="post">
            <div class="table-responsive">
              <table class="table table-bordered" id="datatable2" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Nomor Ujian</th>
                    <th>Password</th>
                    <th width="20%">Nama Peserta</th>
                    <th>Jenis Kelamin</th>
                    <th>Asal Sekolah</th>
                    <th align="center">Select All <input type="checkbox" id="selectall2" /></th>
                  </tr>
                </thead>
                <tbody>
                  <input type="text" name="sesigel" value="<?= $gel ?>" hidden>
                  <?php
                  $no = 1;
                  foreach ($pesetasaja as $peserta) :
                    if ($peserta->geltes == 0 or $peserta->geltes == NULL) :
                  ?>
                      <tr class="font-weight-light">
                        <td><?= $no; ?></td>
                        <td><?= $peserta->no_ujian; ?></td>
                        <td><?= $peserta->pass; ?></td>
                        <td><?= $peserta->nama; ?></td>
                        <td><?= $peserta->jenkel; ?></td>
                        <td><?= $peserta->asal_sekolah; ?></td>
                        <td align="center">
                          <input type="checkbox" class="case2" name="gel[]" value="<?= $peserta->id; ?>" />
                        </td>
                      </tr>
                  <?php
                    endif;
                    $no++;
                  endforeach; ?>
                </tbody>
              </table>
            </div>
            <button class="btn btn-primary" type="submit">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    oTable = $('#datatable').dataTable({
      "bJQueryUI": true,
      "sPaginationType": "full_numbers"
    });

    oTable = $('#datatable2').dataTable({
      "bJQueryUI": true,
      "sPaginationType": "full_numbers"
    });

    $("#selectall").click(function() {
      var checkAll = $("#selectall").prop('checked');
      if (checkAll) {
        $(".case").prop("checked", true);
      } else {
        $(".case").prop("checked", false);
      }
    });

    $("#selectall2").click(function() {
      var checkAll = $("#selectall2").prop('checked');
      if (checkAll) {
        $(".case2").prop("checked", true);
      } else {
        $(".case2").prop("checked", false);
      }
    });

    $(".case").click(function() {
      if ($(".case").length == $(".case:checked").length) {
        $("#selectall").prop("checked", true);
      } else {
        $("#selectall").prop("checked", false);
      }

    });
  });
</script>