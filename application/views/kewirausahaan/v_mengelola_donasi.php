  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-heart"></i> Kelola Donasi
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
              <li class="active"><a href="#tab_1" data-toggle="tab">Konfirmasi Donasi Yang Masuk</a></li>
              <li><a href="#tab_2" data-toggle="tab">Donasi Yang Akan Masuk</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <div class="box box-danger">
                  <div class="box-header">
                    <h3 class="box-title">Data Donasi Yang Masuk</h3>
                  </div>
                  <div class="box-body">
                    
                      <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                          <thead>
                          <tr>
                            <th><center>Nama Donatur</center></th>
                            <th><center>Nama Kegiatan</center></th>
                            <th><center>Nominal Donasi</center></th>
                            <th><center>Tanggal Donasi</center></th>
                            <th><center>Struk Donasi</center></th>
                            <th><center>Action</center></th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php foreach ($transaksi_donasi_masuk as $t): ?>
                          <tr>
                            <td><?php echo $t['nama']; ?></td>
                            <td><?php echo $t['nama_kegiatan']; ?></td>
                            <td><?php echo "Rp. " . number_format($t['nominal_donasi'], 2, ",", "."); ?></td>
                            <td><?php echo $t['tanggal_donasi']; ?></td>
                            <td><a href="<?php echo base_url()."uploads/konfirmasi_donasi/"; ?><?php echo $t['struk_donasi']; ?>" target="blank"><img src="<?php echo base_url()."uploads/konfirmasi_donasi/"; ?><?php echo $t['struk_donasi']; ?>" alt="" width="150px"></a></td>
                            <td>
                              <div class="col-md-6">
                                <form action="<?php echo base_url()."Kewirausahaan/validasi_donasi"; ?>" method="POST">
                                  <input type="hidden" name="status" value="valid">
                                  <center><button type="submit" class="btn btn-primary btn-xs" name="id_donasi" value="<?php echo $t['id_donasi']; ?>" onclick="return isValid()"><i class="fa fa-check-square"></i> Validasi Donasi</button></center>
                                </form>
                              </div>
                              <div class="col-md-6">
                                <form action="<?php echo base_url()."Kewirausahaan/validasi_donasi"; ?>" method="POST">
                                  <input type="hidden" name="status" value="tidak valid">
                                  <center><button type="submit" class="btn btn-danger btn-xs" name="id_donasi" value="<?php echo $t['id_donasi']; ?>" onclick="return isNotValid()"><i class="fa fa-minus-square"></i> Donasi Tidak Valid</button></center>
                                </form>
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
                    <h3 class="box-title">Data Donasi Yang Masih Dalam Proses Transfer Oleh Donatur</h3>
                  </div>
                  <div class="box-body">
                    <table id="example2" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th><center>Nama Donatur</center></th>
                          <th><center>Nama Kegiatan</center></th>
                          <th><center>Nominal Donasi</center></th>
                          <th><center>Tanggal Donasi</center></th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php foreach ($transaksi_donasi_akan_masuk as $t): ?>
                        <tr>
                          <td><?php echo $t['nama']; ?></td>
                          <td><?php echo $t['nama_kegiatan']; ?></td>
                          <td><?php echo "Rp. " . number_format($t['nominal_donasi'], 2, ",", "."); ?></td>
                          <td><?php echo $t['tanggal_donasi']; ?></td>
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
      </div>
    </section>
  </div>


<!-- <html>
	<title></title>
	<body>
		<form action="<?php echo base_url()."Kewirausahaan/validasi_donasi"; ?>" method="POST">
			<table border="1">
				<tr>
					<td>nama_donatur</td>
					<td>nama_kegiatan</td>
					<td>nominal_donasi</td>
					<td>tanggal_donasi</td>
					<td>struk_donasi</td>
					<td>action</td>
				</tr>
				<?php foreach ($transaksi_donasi as $t): ?>
				<tr>
					<td><?php echo $t['nama']; ?></td>
					<td><?php echo $t['nama_kegiatan']; ?></td>
					<td><?php echo $t['nominal_donasi']; ?></td>
					<td><?php echo $t['tanggal_donasi']; ?></td>
					<td><a href="<?php echo base_url()."uploads/konfirmasi_donasi/"; ?><?php echo $t['struk_donasi']; ?>" target="blank"><img src="<?php echo base_url()."uploads/konfirmasi_donasi/"; ?><?php echo $t['struk_donasi']; ?>" alt="" width="150px"></a></td>
					<td><button type="submit" name="id_donasi" value="<?php echo $t['id_donasi']; ?>">Konfirmasi Donasi</button></td>
				</tr>
				<?php endforeach ?>
			</table>
		</form>
	</body>
</html> -->