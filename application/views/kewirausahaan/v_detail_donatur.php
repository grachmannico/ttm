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
            <div class="widget-user-header bg-black" style="background: url('<?php echo base_url() . "uploads/dokumentasi/"; ?>Untitled.png') center center;">
              <h3 class="widget-user-username"><?php echo $profil_donatur[0]['nama']; ?></h3>
              <h5 class="widget-user-desc"><?php echo $profil_donatur[0]['email']; ?></h5>
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
                    <span class="description-text">Jumlah Transaksi Donasi</span>
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
        <div class="col-md-8 col-md-push-2">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Data Donasi yang dilakukan Donatur</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <!-- <label for="exampleInputEmail1">Detail Data Pembelian Barang <?php echo $detail_barang[0]['nama_barang']; ?>:</label> -->
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
                      <td><?php echo $d['tanggal_donasi']; ?></td>
                    </tr>
                    <?php endforeach?>
                    </tfoot>
                  </table>
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