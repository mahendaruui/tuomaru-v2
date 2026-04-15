<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manajemen Hasil Tes</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i></a>
  </div>

  <div class="row">
    <div class="col-md-8">
      <?php echo $this->session->flashdata("msg"); ?>
    </div>
  </div>

  <!--<div class="row mb-4">-->
  <!--  <div class="col-md-6">-->
  <!--    <a href="<?= base_url('admin/hasiltes') ?>" class="btn btn-danger"> <i class="fas fa-fw fa-sync"></i> Update Data</a>-->
  <!--  </div>-->
  <!--</div>-->
  
  <div class="row">
  
  <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Lulusan 2018</div>
                            
                                <div class="h5 mb-0 font-weight-bold text-gray-800"> <?= ($jmls2018); ?> Orang</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Lulusan 2019</div>
                            
                                <div class="h5 mb-0 font-weight-bold text-gray-800"> <?= ($jmls2019); ?> Orang</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Lulusan 2020</div>
                            
                                <div class="h5 mb-0 font-weight-bold text-gray-800"> <?= ($jmls2020); ?> Orang</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
</div>
        
          <div class="row">
  
  <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Tidak Lulus 2018</div>
                            
                                <div class="h5 mb-0 font-weight-bold text-gray-800"> <?= ($jmtls2018); ?> Orang</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Tidak Lulus 2019</div>
                            
                                <div class="h5 mb-0 font-weight-bold text-gray-800"> <?= ($jmtls2019); ?> Orang</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Tidak Lulus 2020</div>
                            
                                <div class="h5 mb-0 font-weight-bold text-gray-800"> <?= ($jmtls2020); ?> Orang</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
</div>
        

  <div class="row">
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="text-primary font-weight-bold m-0">Hasil Peserta Tes</h6>
        </div>
        <?php if (isset($nilaitessiswa)) : ?>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr align="center">
                    <th>No.</th>
                    <th>No Registrasi</th>
                    <th>Nama</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Tahun</th><>
                    <!-- <th>Detail Jawaban</th> -->
                    <th>Set Kelulusan</th>
                  </tr>
                </thead>
                <tbody>
            <?php $i = 1; ?>
                    <?php foreach ($nilaitessiswa2 as $lp) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $lp['no_ujian']; ?></td>
                            <td><?= $lp['nama']; ?></td>
                            <td><?= $lp['jalur']; ?></td>
                            <td><?= $lp['prodi']; ?></td>
                            <td><?= $lp['tahun']; ?></td>
                            <?php if ($lp['status'] == 'Y') :  ?>
                                <td>Lulus</td>
                            <?php else : ?>
                                <td>Tidak Lulus</td>
                            <?php endif; ?>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>



</div>