<?php foreach ($profilmember as $peserta) : ?>
  <div class="container">
    <div class="row">
      <div class="col-md-3 mt-4">
        <div class="card">
          <div class="el-card-item">
            <div class="el-card-avatar el-overlay-1 text-center"> <img class="img-thumbnail" src="https://sipenmaru.uui.ac.id/foto/<?= $peserta->foto ?>" alt="user" />
            </div>
            <div class="el-card-content text-center">
              <h4 class="m-b-0 mt-2"><?= strtoupper($peserta->nama); ?></h4>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="card-body">
          <h5 class="card-title"> My Profil </h5>
          <div class="accordion" id="accordionExample">
            <div class="card m-b-0">
              <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                  <a data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <i class="m-r-5 fa fa-id-badge" aria-hidden="true"></i>
                    <span>Identitas Saya</span>
                  </a>
                </h5>
              </div>
              <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                  <div class="list-style-none">
                    <div class="row">
                      <div class="col-4"><span class="h5">No Registrasi : </span></div>
                      <div class="col-8"><span class=" text-primary h5"><?= $peserta->no_ujian ?></span></div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-4"><span class="h5">NO Kependudukan : </span></div>
                      <div class="col-8"><span class=" text-primary "><?= $peserta->no_identitas ?></span></div>
                    </div>
                    <div class="row">
                      <div class="col-4"><span class="h5">Jenis Kelamin : </span></div>
                      <div class="col-8"><span class=" text-primary "><?= $peserta->jenkel ?></span></div>
                    </div>
                    <div class="row">
                      <div class="col-4"><span class="h5">Agama : </span></div>
                      <div class="col-8"><span class=" text-primary "><?= $peserta->agama ?></span></div>
                    </div>
                    <div class="row">
                      <div class="col-4"><span class="h5">Tempat, Tanggal Lahir : </span></div>
                      <div class="col-8"><span class=" text-primary "><?= $peserta->tempat ?>, <?= tgl_indo($peserta->tanggal) ?></span></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card m-b-0 border-top">
              <div class="card-header" id="headingTwo">
                <h5 class="mb-0">
                  <a class="collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <i class="m-r-5 fa fa-id-card" aria-hidden="true"></i>
                    <span>Keterangan Alamat</span>
                  </a>
                </h5>
              </div>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                  <div class="list-style-none">
                    <div class="row">
                      <div class="col-4"><span class="h5">Alamat : </span></div>
                      <div class="col-8"><span class=" text-primary "><?= $peserta->alamat ?>, <?= $peserta->alamat_kota ?>, <?= $peserta->alamat_prov ?> </span></div>
                    </div>
                    <div class="row">
                      <div class="col-4"><span class="h5">Telphone : </span></div>
                      <div class="col-8"><span class=" text-primary "><?= $peserta->hp ?> </span></div>
                    </div>
                    <div class="row">
                      <div class="col-4"><span class="h5">Email : </span></div>
                      <div class="col-8"><span class=" text-primary "><?= $peserta->email ?> </span></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>