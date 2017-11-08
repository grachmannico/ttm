<?php
function tanggal_indo($tanggal)
{
    $bulan = array(1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    );
    $split = explode('-', $tanggal);
    return $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];
}
?>

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-black-tie"></i> Donatur
      </h1>
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol> -->
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-8 col-md-push-2">
          <div class="box box-widget widget-user">
            <div class="widget-user-header bg-black" style="background: url('<?php echo base_url() . "uploads/"; ?>bgcoba.png') center center;">
              <h3 class="widget-user-username" style="color: black;"><?php echo $profil_donatur[0]['nama']; ?></h3>
              <h5 class="widget-user-desc" style="color: black;"><?php echo $profil_donatur[0]['email']; ?></h5>
            </div>
            <div class="widget-user-image">
              <?php if ($profil_donatur[0]['foto_profil'] == ""): ?>
                <img class="img-circle" src="<?php echo base_url() . "assets/"; ?>dist/img/user2-160x160.jpg" alt="User Avatar">
              <?php endif ?>
              <?php if ($profil_donatur[0]['foto_profil'] != ""): ?>
                <img src="<?php echo base_url() . "uploads/foto_profil/"; ?><?php echo $profil_donatur[0]['foto_profil']; ?>" alt="User Avatar" style="border-radius: 50%; height: 90px; width: 90px;">
              <?php endif ?>
            </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-6 border-right">
                  <div class="description-block">
                    <?php if (empty($data_donatur)): ?>
                      <h5 class="description-header">0</h5>
                    <?php endif ?>
                    <?php if (!empty($data_donatur)): ?>
                      <h5 class="description-header"><?php echo $data_donatur[0]['total_donasi']; ?></h5>
                    <?php endif ?>
                    <span class="description-text">Jumlah Transaksi Donasi Valid</span>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="description-block">
                    <?php if (empty($data_jumlah_nominal_donasi_donatur)): ?>
                      <h5 class="description-header">0</h5>
                    <?php endif ?>
                    <?php if (!empty($data_jumlah_nominal_donasi_donatur)): ?>
                      <h5 class="description-header"><?php echo "Rp. " . number_format($data_jumlah_nominal_donasi_donatur[0]['jumlah_nominal_donasi'], 2, ",", "."); ?></h5>
                    <?php endif ?>
                    <span class="description-text">Jumlah Nominal Donasi</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Detail Data Donatur</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-envelope"></i> Email</label>
                <input type="text" class="form-control" value="<?php echo $data_donatur[0]['email']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-user"></i> Nama</label><br>
                <input type="text" class="form-control" value="<?php echo $data_donatur[0]['nama']; ?>" readonly>
              </div>
            </div>
          </div> -->
        </div>
        <div class="col-md-10 col-md-push-1">
          <!-- <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Data Donasi yang dilakukan Donatur</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Detail Data Pembelian Barang <?php echo $detail_barang[0]['nama_barang']; ?>:</label>
                <div class="table-responsive">
                  <form action="<?php echo base_url()."Kewirausahaan/detail_donatur"; ?>" method="POST">
                    Tampilkan Status Donasi: 
                    <select class="form-control" name="id_status_donasi">
                      <option value="3" selected>Transfes Valid</option>
                      <option value="1">Proses Transfer</option>
                      <option value="2">Konfirmasi Transfer</option>
                      <option value="4">Transfer Lewat Batas Waktu</option>
                      <option value="5">Transfer Tidak Valid</option>
                      <option value="">Tampilkan Semua</option>
                    </select>
                    <input type="hidden" name="donatur" value="<?php echo $profil_donatur[0]['email']; ?>">
                    <button type="submit" class="btn btn-danger">Cari</button>
                  </form>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>Nama kegiatan</th>
                      <th>Status Donasi</th>
                      <th>Nominal Donasi</th>
                      <th>Struk Donasi</th>
                      <th>Tanggal Donasi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data_donasi_donatur as $d): ?>
                    <tr>
                      <td><?php echo $d['nama_kegiatan']; ?></td>
                      <td><?php echo $d['status_donasi']; ?></td>
                      <td><?php echo "Rp. " . number_format($d['nominal_donasi'], 2, ",", "."); ?></td>
                      <td><a href="<?php echo base_url()."uploads/konfirmasi_donasi/" ?><?php echo $d['struk_donasi']; ?>" target="blank"><img src="<?php echo base_url()."uploads/konfirmasi_donasi/" ?><?php echo $d['struk_donasi']; ?>" alt="" width="150px"></a></td>
                      <td><?php echo tanggal_indo($d['tanggal_donasi']); ?></td>
                    </tr>
                    <?php endforeach?>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div> -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-exchange"></i> Data Transaksi Donasi Donatur</a></li>
              <li><a href="#tab_2" data-toggle="tab"><i class="fa fa-black-tie"></i> Profil Donatur</a></li>
              <?php if (empty($data_donatur[0]['total_donasi'])): ?>
                <!-- GONE -->
              <?php endif ?>
              <?php if ($data_donatur[0]['total_donasi'] >= 5): ?>
                <li><a href="#tab_3" data-toggle="tab"><i class="fa fa-bar-chart"></i> Stats Donatur</a></li>
              <?php endif ?>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <div class="box box-danger">
                  <div class="box-header with-border">
                    <h3 class="box-title">Data Donasi yang dilakukan Donatur</h3>
                  </div>
                  <div class="box-body">
                    <div class="form-group">
                      <!-- <label for="exampleInputEmail1">Detail Data Transaksi Donasi Donatur</label> -->
                      <div class="table-responsive">
                        <form action="<?php echo base_url()."Kewirausahaan/detail_donatur"; ?>" method="POST">
                          Tampilkan Status Donasi: 
                          <select class="form-control" name="id_status_donasi">
                            <option value="0" selected>Tampilkan Semua</option>
                            <option value="3">Transfes Valid</option>
                            <option value="1">Proses Transfer</option>
                            <option value="2">Konfirmasi Transfer</option>
                            <option value="4">Transfer Lewat Batas Waktu</option>
                            <option value="5">Transfer Tidak Valid</option>
                          </select>
                          <input type="hidden" name="donatur" value="<?php echo $profil_donatur[0]['email']; ?>">
                          <button type="submit" class="btn btn-danger">Cari</button>
                        </form>
                        <table id="example1" class="table table-bordered table-striped">
                          <thead>
                          <tr>
                            <th>Nama kegiatan</th>
                            <th>Status Donasi</th>
                            <th>Nominal Donasi</th>
                            <!-- <th>Struk Donasi</th> -->
                            <th>Tanggal Donasi</th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php foreach ($data_donasi_donatur as $d): ?>
                          <tr>
                            <td><?php echo $d['nama_kegiatan']; ?></td>
                            <td><?php echo $d['status_donasi']; ?></td>
                            <td><?php echo "Rp. " . number_format($d['nominal_donasi'], 2, ",", "."); ?></td>
                            <!-- <td><a href="<?php echo base_url()."uploads/konfirmasi_donasi/" ?><?php echo $d['struk_donasi']; ?>" target="blank"><img src="<?php echo base_url()."uploads/konfirmasi_donasi/" ?><?php echo $d['struk_donasi']; ?>" alt="" width="150px"></a></td> -->
                            <td><?php echo tanggal_indo($d['tanggal_donasi']); ?></td>
                          </tr>
                          <?php endforeach?>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="tab_2">
                <div class="box box-danger">
                  <div class="box-header with-border">
                    <h3 class="box-title">Detail Data Donatur</h3>
                  </div>
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-envelope"></i> Email</label>
                      <input type="email" class="form-control" value="<?php echo $profil_donatur[0]['email']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-user"></i> Nama</label>
                      <input type="text" class="form-control" value="<?php echo $profil_donatur[0]['nama']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-calendar-check-o"></i> Tanggal Lahir</label>
                      <input type="text" class="form-control" value="<?php echo tanggal_indo($profil_donatur[0]['tgl_lahir']); ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-mobile-phone"></i> Nomor Handphone</label>
                      <input type="text" class="form-control" value="<?php echo $profil_donatur[0]['no_hp']; ?>" data-inputmask="'mask': ['9999-9999-9999', '+99-999-9999-9999']" data-mask readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-home"></i> Alamat</label>
                      <input type="text" class="form-control" value="<?php echo $profil_donatur[0]['alamat']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-male"></i>/<i class="fa fa-female"></i> Jenis Kelamin</label>
                      <input type="text" class="form-control" value="<?php echo $profil_donatur[0]['jenis_kelamin']; ?>" readonly>
                    </div>
                  </div>
                </div>
              </div>
              
              
              <div class="tab-pane" id="tab_3">
                <div class="content">
                  <div class="col-md-6">
                    <div class="info-box bg-green">
                      <span class="info-box-icon"><i class="fa fa-black-tie"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">Status Donatur:</span>
                        <span class="info-box-number"><?php echo $status_donatur ?></span>

                        <div class="progress">
                          <div class="progress-bar" style="width: <?php echo $persentase_hasil; ?>%"></div>
                        </div>
                            <span class="progress-description">
                              <!-- Indeks Penilaian Donatur: <?php echo $persentase_hasil; ?>%  (<?php echo $hasil; ?> / 3) -->
                              Indeks Penilaian Donatur: <?php echo $hasil; ?> / 3
                            </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-box bg-green">
                      <span class="info-box-icon"><i class="fa fa-money"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">Nominal Uang Per Donasi:</span>
                        <span class="info-box-number"><?php echo "Rp. " . number_format($rata_rata_donasi, 2, ",", "."); ?></span>

                        <!-- <div class="progress">
                          <div class="progress-bar" style="width: <?php echo $persentase_hasil; ?>%"></div>
                        </div>
                            <span class="progress-description">
                              Indeks Penilaian Donatur: <?php echo $persentase_hasil; ?>%  (<?php echo $hasil; ?> / 3)
                            </span> -->
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-box bg-green">
                      <span class="info-box-icon"><i class="fa fa-line-chart"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">Persentase Transfer Donatur:</span>
                        <span class="info-box-number"><?php echo number_format((float)$persentase_transfer_valid, 2, '.', ''); ?>%</span>

                        <div class="progress">
                          <div class="progress-bar" style="width: <?php echo $persentase_transfer_valid; ?>%"></div>
                        </div>
                            <span class="progress-description">
                              <?php echo $jumlah_transfer_valid; ?> Transaksi Tervalidasi dari <?php echo $jumlah_transfer; ?> Transaksi
                            </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-box bg-green">
                      <span class="info-box-icon"><i class="fa fa-bar-chart"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">Kemungkinan Donasi Per Kegiatan:</span>
                        <span class="info-box-number"><?php echo number_format((float)$persentase_transfer_per_kegiatan, 2, '.', ''); ?>%</span>

                        <div class="progress">
                          <div class="progress-bar" style="width: <?php echo $persentase_transfer_per_kegiatan; ?>%"></div>
                        </div>
                            <span class="progress-description">
                              Kemungkinan: <?php echo number_format((float)$persentase_transfer_per_kegiatan / 100, 2, '.', ''); ?> kali per-satu kegiatan
                            </span>
                      </div>
                    </div>
                  </div>
                  
                  <br><hr>
                  <h4>Penjelasan:</h4> 
                  <!-- Status Donatur: <br>
                  <ul>
                    <li>Donatur Aktif, dimana Indeks Penilaian Donatur harus mempunyai nilai lebih dari 2.5</li>
                    <li>Donatur Potensial, dimana Indeks Penilaian Donatur harus mempunyai nilai lebih dari 2.0</li>
                    <li>Donatur, dimana Indeks Penilaian Donatur masih memiliki nilai kurang dari atau sama dengan dari 2.0</li>
                  </ul> -->

                  <b>Persentase Transfer Donatur</b> didapat dari <u>jumlah transaksi donasi yang tervalidasi per jumlah transaksi donasi yang dilakukan oleh donatur.</u><br>
                  <ul>
                    <li>
                      Jika "Persentase Transfer Donatur" mendapat hasil lebih dari atau sama dengan 80%, maka akan mendapat 3 poin.
                    </li>
                    <li>
                      Jika "Persentase Transfer Donatur" mendapat hasil lebih dari atau sama dengan 50%, maka akan mendapat 2 poin.
                    </li>
                    <li>
                      Jika "Persentase Transfer Donatur" mendapat hasil kurang dari 50%, maka akan mendapat 1 poin.
                    </li>
                  </ul>
                  <b>Kemungkinan Donasi Per Kegiatan</b> didapat dari <u>jumlah transaksi donasi yang dilakukan oleh donatur per jumlah semua kegiatan yang diadakan oleh komunitas pada tahun periode <?php echo date("Y"); ?>.</u>
                  <ul>
                    <li>
                      Jika "Kemungkinan Donasi Per Kegiatan" mendapat hasil lebih dari atau sama dengan 50%, maka akan mendapat 3 poin.
                    </li>
                    <li>
                      Jika "Kemungkinan Donasi Per Kegiatan" mendapat hasil lebih dari atau sama dengan 20%, maka akan mendapat 2 poin.
                    </li>
                    <li>
                      Jika "Kemungkinan Donasi Per Kegiatan" mendapat hasil kurang dari 20%, maka akan mendapat 1 poin.
                    </li>
                  </ul>
                  Setelah mendapatkan semua poin, maka akan dihitung untuk mengetahui <b>Status Donatur</b>.<br>
                  <u>Status Donatur didapat dari jumlah poin "Persentase Transfer Donatur" dan "Kemungkinan Donasi Per Kegiatan" yang kemudian dibagi 2.</u>
                  <ul>
                    <li>Donatur Aktif, dimana Indeks Penilaian Donatur harus mempunyai nilai lebih dari 2.5</li>
                    <li>Donatur Potensial, dimana Indeks Penilaian Donatur harus mempunyai nilai lebih dari 2</li>
                    <li>Donatur, dimana Indeks Penilaian Donatur masih memiliki nilai kurang dari atau sama dengan dari 2</li>
                  </ul>
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
    email: <?php echo $data_donatur[0]['email']; ?><br>
    nama: <?php echo $data_donatur[0]['nama']; ?>
    <hr>
    <table border="1">
      <tr>
        <td>nama_kegiatan</td>
        <td>status_donasi</td>
        <td>nominal_donasi</td>
        <td>struk_donasi</td>
        <td>tanggal_donasi</td>
      </tr>
      <?php foreach ($data_donasi_donatur as $d): ?>
      <tr>
        <td><?php echo $d['nama_kegiatan']; ?></td>
        <td><?php echo $d['status_donasi']; ?></td>
        <td><?php echo $d['nominal_donasi']; ?></td>
        <td><a href="<?php echo base_url()."uploads/konfirmasi_donasi/" ?><?php echo $d['struk_donasi']; ?>"><img src="<?php echo base_url()."uploads/konfirmasi_donasi/" ?><?php echo $d['struk_donasi']; ?>" alt="" width="150px"></a></td>
        <td><?php echo $d['tanggal_donasi']; ?></td>
      </tr>
      <?php endforeach ?>
    </table>
  </body>
</html> -->