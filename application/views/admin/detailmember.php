<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Peserta</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
  </div>
  <div class="row">
    <?php foreach ($detailmember as $member) : ?>
      <div class="col-xl-7 col-md-7 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="btn btn-info font-weight-bold text-dark text-uppercase mb-4">No.Reg | <?= $member->no_ujian; ?></div>
                <table>
                  <tr>
                    <td width="120px" class="mb-1 font-weight-bold text-gray-600">NIK :</td>
                    <td><?= $member->no_identitas; ?></td>
                  </tr>
                  <tr>
                    <td width="120px" class="mb-1 font-weight-bold text-gray-600">NAMA :</td>
                    <td><?= $member->nama; ?></td>
                  </tr>
                  <tr>
                    <td width="120px" class="mb-1 font-weight-bold text-gray-600">Jenis Kelamin :</td>
                    <td><?= $member->jenkel; ?></td>
                  </tr>

                  <?php
                  $tgl_lahir = date($member->tanggal); ?>

                  <!-- end tanggal indo -->
                  <tr>
                    <td width="120px" class="mb-1 font-weight-bold text-gray-600">TTL :</td>
                    <td><?= $member->tempat; ?>/<?= tgl_indo($tgl_lahir); ?></td>
                  </tr>
                  <tr>
                    <td width="120px" class="mb-1 font-weight-bold text-gray-600">Agama :</td>
                    <td><?= $member->agama; ?></td>
                  </tr>
                </table>
              </div>
              <div class="col-auto">
                <img class="img-thumbnail" width="150" height="200" src="<?= base_url('foto/' . $member->foto) ?>">
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-5 col-md-5 mb-4">
        <div class="card shadow mb-4">
          <!-- Card Header - Accordion -->
          <a href="" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Alamat Peserta</h6>
          </a>
          <!-- Card Content - Collapse -->
          <div class="collapse show" id="collapseCardExample">
            <div class="card-body">
              <table>
                <tr>
                  <td width="120px" class="mb-1 font-weight-bold text-gray-600">Alamat :</td>
                  <td><?= $member->alamat; ?></td>
                </tr>
                <tr>
                  <td width="120px" class="mb-1 font-weight-bold text-gray-600">Desa :</td>
                  <td><?= $member->alamat_desa; ?></td>
                </tr>
                <tr>
                  <td width="120px" class="mb-1 font-weight-bold text-gray-600">Kecamatan :</td>
                  <td><?= $member->alamat_kec; ?></td>
                </tr>
                <tr>
                  <td width="120px" class="mb-1 font-weight-bold text-gray-600">Kota :</td>
                  <td><?= $member->alamat_kota; ?></td>
                </tr>
                <tr>
                  <td width="120px" class="mb-1 font-weight-bold text-gray-600">Provinsi :</td>
                  <td><?= $member->alamat_prov; ?></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="row">
    <div class="col-xl-7 col-md-7 mb-4">
      <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
          <h6 class="m-0 font-weight-bold text-primary">Profil Detail</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id="collapseCardExample">
          <div class="card-body">
            <table>
              <tr>
                <td width="150px" class="mb-1 font-weight-bold text-gray-600">Asal Sekolah :</td>
                <td><?= $member->asal_sekolah; ?></td>
              </tr>
              <tr>
                <td width="150px" class="mb-1 font-weight-bold text-gray-600">No Telefon :</td>
                <td><?= $member->hp; ?></td>
              </tr>
              <tr>
                <td width="150px" class="mb-1 font-weight-bold text-gray-600">Alamat Email :</td>
                <td><?= $member->email; ?></td>
              </tr>
              <tr>
                <td width="150px" class="mb-1 font-weight-bold text-gray-600">Tanggal Daftar :</td>
                <?php
                $regdate = date($member->tgl_daftar);
                $tgldaftar = tgl_indo($regdate);
                ?>
                <td><?= $tgldaftar; ?></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>