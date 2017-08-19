  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-user"></i> Kelola Data Relawan
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
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Data Relawan</a></li>
              <li><a href="#tab_2" data-toggle="tab">Data Statistik Relawan</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <div class="box box-danger">
                  <div class="box-header">
                    <h3 class="box-title">Semua Data Relawan</h3>
                  </div>
                  <div class="box-body">
                    <div class="table-responsive">
                      <form action="<?php echo base_url()."Relawan/mengelola_data_relawan"; ?>" method="POST">
                        Tampilkan Berdasarkan Divisi: 
                        <select class="form-control" name="divisi">
                          <option value="" selected>Semua Divisi</option>
                          <option value="1">Non-Divisi</option>
                          <option value="2">Hubungan Masyarakat</option>
                          <option value="3">Relawan</option>
                          <option value="4">Penelitian Pengembangan dan Gerakan</option>
                          <option value="5">Media dan Publikasi</option>
                          <option value="6">Kewirausahaan</option>
                        </select>
                        <button type="submit" class="btn btn-danger">Cari</button>
                      </form>
                      <br>
                      <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th><center>Nama</center></th>
                          <th><center>Email</center></th>
                          <th><center>Divisi</center></th>
                          <th><center>Action</center></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data_relawan as $dr): ?>
                        <tr>
                          <td><?php echo $dr['nama']; ?></td>
                          <td><?php echo $dr['email']; ?></td>
                          <td><?php echo $dr['divisi']; ?></td>
                          <td>
                            <div class="col-md-12">
                              <div class="col-md-4">
                                <center><form action="<?php echo base_url() . "Relawan/edit_relawan"; ?>" method="POST">
                                  <button type="submit" class="btn btn-warning btn-xs" name="edit" value="<?php echo $dr['email']; ?>"><i class="fa fa-edit"></i> Edit</button>
                                </form></center>
                              </div>
                              <div class="col-md-4">
                                <center><form action="<?php echo base_url() . "Relawan/hapus_relawan"; ?>" method="POST">
                                  <button type="submit" class="btn btn-danger btn-xs" name="hapus" value="<?php echo $dr['email']; ?>" onclick="return checkDelete()"><i class="fa fa-trash"></i> Hapus</button>
                                </form></center>
                              </div>
                              <div class="col-md-4">
                                <center><form action="<?php echo base_url() . "Relawan/detail_relawan"; ?>" method="POST">
                                  <button type="submit" class="btn btn-primary btn-xs" name="relawan" value="<?php echo $dr['email']; ?>"><i class="fa fa-file-text"></i> Lihat Detail</button>
                                </form></center>
                              </div>
                            </div>
                          </td>
                        </tr>
                        <?php endforeach?>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="tab_2">
                <div class="box box-danger">
                  <div class="box-header">
                    <h3 class="box-title">Data Statistik Semua Relawan</h3>
                  </div>
                  <div class="box-body">
                    <div class="table-responsive">
                      <table id="example2" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th><center>Ranking</center></th>
                          <th><center>Nama</center></th>
                          <th><center>Persentase Kemungkinan Gabung Kegaiatn</center></th>
                          <th><center>Persentase Kehadiran Dalam Kegiatan</center></th>
                          <th><center>Hasil Penilaian</center></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($rank as $r): ?>
                        <tr>
                          <td><?php echo $i; ?></td>
                          <td><?php echo $r['nama']; ?></td>
                          <td>
                            <div class="progress">
                                  <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="<?php echo $r['persentase_gabung_kegiatan']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $r['persentase_gabung_kegiatan']."%"; ?>">
                                    <span class="sr-only"><?php echo $r['persentase_gabung_kegiatan']."%"; ?> Complete (success)</span>
                                    <?php if ($r['persentase_gabung_kegiatan'] != 0): ?>
                                      <p><?php echo number_format((float)$r['persentase_gabung_kegiatan'], 2, '.', ''); ?></p>
                                    <?php endif ?>
                                    <?php if ($r['persentase_gabung_kegiatan'] == 0): ?>
                                      <p style="color: black;"><?php echo number_format((float)$r['persentase_gabung_kegiatan'], 2, '.', ''); ?></p>
                                    <?php endif ?>
                                  </div>
                                </div>
                          </td>
                          <td>
                            <div class="progress">
                                  <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="<?php echo $r['kontribusi']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $r['kontribusi']."%"; ?>">
                                    <span class="sr-only"><?php echo $r['kontribusi']."%"; ?> Complete (success)</span>
                                    <?php if ($r['kontribusi'] != 0): ?>
                                      <p><?php echo number_format((float)$r['kontribusi'], 2, '.', ''); ?></p>
                                    <?php endif ?>
                                    <?php if ($r['kontribusi'] == 0): ?>
                                      <p style="color: black;"><?php echo number_format((float)$r['kontribusi'], 2, '.', ''); ?></p>
                                    <?php endif ?>
                                  </div>
                                </div>
                          </td>
                          <td>
                            <div class="progress">
                                  <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="<?php echo $r['hasil']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $r['hasil']."%"; ?>">
                                    <span class="sr-only"><?php echo $r['hasil']."%"; ?> Complete (success)</span>
                                    <?php if ($r['hasil'] != 0): ?>
                                      <p><?php echo number_format((float)$r['hasil'], 2, '.', ''); ?></p>
                                    <?php endif ?>
                                    <?php if ($r['hasil'] == 0): ?>
                                      <p style="color: black;"><?php echo number_format((float)$r['hasil'], 2, '.', ''); ?></p>
                                    <?php endif ?>
                                  </div>
                                </div>
                          </td>
                        </tr>
                        <?php $i++; ?>
                        <?php endforeach?>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
                <h4>Keterangan:</h4>
                Penilaian berdasarkan pada persentase kemungkinan relawan bergabung dalam kegiatan dan persentase kehadiran relawan dalam kegiatan yang diikuti.<br> <b>Data statisktik relawan yang ditampilkan hanya relawan yang telah mengikuti dan hadir dalam kegiatan lebih dari 3 kali.</b>
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
    <a href="<?php echo base_url() . "Relawan/tambah_relawan"; ?>">Tambah Relawan</a><br>
    <table border="1">
      <tr>
        <td>nama</td>
        <td>email</td>
        <td>divisi</td>
        <td colspan="3">action</td>
      </tr>
      <?php foreach ($data_relawan as $dr): ?>
      <tr>
        <td><?php echo $dr['nama']; ?></td>
        <td><?php echo $dr['email']; ?></td>
        <td><?php echo $dr['divisi']; ?></td>
        <td>
          <form action="<?php echo base_url() . "Relawan/edit_relawan"; ?>" method="POST">
            <button type="submit" name="edit" value="<?php echo $dr['email']; ?>">Edit</button>
          </form>
        </td>
        <td>
          <form action="<?php echo base_url() . "Relawan/hapus_relawan"; ?>" method="POST">
            <button type="submit" name="hapus" value="<?php echo $dr['email']; ?>">Hapus</button>
          </form>
        </td>
        <td>
          <form action="<?php echo base_url() . "Relawan/detail_relawan"; ?>" method="POST">
            <button type="submit" name="relawan" value="<?php echo $dr['email']; ?>">Lihat Detail</button>
          </form>
        </td>
      </tr>
      <?php endforeach?>
    </table>
  </body>
</html> -->