  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-list"></i> Daftar Absensi Relawan
        <small></small>
      </h1>
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol> -->
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Data Absensi Kegiatan "<?php echo $nama_kegiatan[0]['nama_kegiatan']; ?>"</h3>
            </div>
            <div class="box-body">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab">Data Relawan Belum Diabsen</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Data Relawan Hadir</a></li>
                  <li><a href="#tab_3" data-toggle="tab">Data Relawan Tidak Hadir</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                    <form action="<?php echo base_url() . "Relawan/absensi"; ?>" method="POST">
                      <input type="hidden" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>">
                      <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                          <thead>
                          <tr>
                            <th><center>Nama</center></th>
                            <th><center>Divisi</center></th>
                            <th><center>Status Absensi Relawan</center></th>
                            <th><center>Action</center></th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php foreach ($list_relawan as $lr): ?>
                          <tr>
                            <td><?php echo $lr['nama']; ?></td>
                            <td><?php echo $lr['divisi']; ?></td>
                            <td><?php echo $lr['status_absensi_relawan']; ?></td>
                            <td>
                              <div class="col-md-12">
                                <div class="col-md-6">
                                  <center><button type="submit" class="btn btn-primary btn-xs" name="hadir" value="<?php echo $lr['id_gabung_kegiatan']; ?>">Hadir</button></center>
                                </div>
                                <div class="col-md-6">
                                  <center><button type="submit" class="btn btn-danger btn-xs" name="tidak_hadir" value="<?php echo $lr['id_gabung_kegiatan']; ?>">Tidak Hadir</button></center>
                                </div>
                              </div>
                            </td>
                          </tr>
                          <?php endforeach?>
                          </tbody>
                        </table>
                      </div>
                    </form>
                  </div>
                  <div class="tab-pane" id="tab_2">
                    <table id="example2" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th><center>Nama</center></th>
                          <th><center>Divisi</center></th>
                          <th><center>Status Absensi Relawan</center></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($list_relawan_hadir as $lr): ?>
                        <tr>
                          <td><?php echo $lr['nama']; ?></td>
                          <td><?php echo $lr['divisi']; ?></td>
                          <td><?php echo $lr['status_absensi_relawan']; ?></td>
                        </tr>
                        <?php endforeach?>
                        </tbody>
                      </table>
                  </div>
                  <div class="tab-pane" id="tab_3">
                    <table id="example3" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th><center>Nama</center></th>
                          <th><center>Divisi</center></th>
                          <th><center>Status Absensi Relawan</center></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($list_relawan_tidak_hadir as $lr): ?>
                        <tr>
                          <td><?php echo $lr['nama']; ?></td>
                          <td><?php echo $lr['divisi']; ?></td>
                          <td><?php echo $lr['status_absensi_relawan']; ?></td>
                        </tr>
                      <?php endforeach?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


<!-- <html>
  <title></title>
  <body>
    <form action="<?php echo base_url() . "Relawan/absensi"; ?>" method="POST">
      <input type="text" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>">
      <table border="1">
        <tr>
          <td>nama</td>
          <td>divisi</td>
          <td>status_absensi_relawan</td>
          <td colspan="2">action</td>
        </tr>
        <?php foreach ($list_relawan as $lr): ?>
        <tr>
          <td><?php echo $lr['nama']; ?></td>
          <td><?php echo $lr['divisi']; ?></td>
          <td><?php echo $lr['status_absensi_relawan']; ?></td>
          <td><button type="submit" name="hadir" value="<?php echo $lr['id_gabung_kegiatan']; ?>">Hadir</button></td>
          <td><button type="submit" name="tidak_hadir" value="<?php echo $lr['id_gabung_kegiatan']; ?>">Tidak Hadir</button></td>
        </tr>
        <?php endforeach?>
      </table>
    </form>
  </body>
</html> -->