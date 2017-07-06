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
        <div class="col-md-4">
          <div class="box box-danger">
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
          </div>
        </div>
        <div class="col-md-8">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Data Donasi yang dilakukan Donatur</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <!-- <label for="exampleInputEmail1">Detail Data Pembelian Barang <?php echo $detail_barang[0]['nama_barang']; ?>:</label> -->
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <td>Nama kegiatan</td>
                    <td>Status Donasi</td>
                    <td>Nominal Donasi</td>
                    <td>Struk Donasi</td>
                    <td>Tanggal Donasi</td>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($data_donasi_donatur as $d): ?>
                  <tr>
                    <td><?php echo $d['nama_kegiatan']; ?></td>
                    <td><?php echo $d['status_donasi']; ?></td>
                    <td><?php echo $d['nominal_donasi']; ?></td>
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