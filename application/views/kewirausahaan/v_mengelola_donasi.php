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
          <div class="box box-danger">
            <div class="box-header">
              <!-- <h3 class="box-title">Data Table With Full Features</h3> -->
            </div>
            <div class="box-body">
              <form action="<?php echo base_url()."Kewirausahaan/validasi_donasi"; ?>" method="POST">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nama Donatur</th>
                    <th>Nama Kegiatan</th>
                    <th>Nominal Donasi</th>
                    <th>Tanggal Donasi</th>
                    <th>Struk Donasi</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($transaksi_donasi as $t): ?>
                  <tr>
                    <td><?php echo $t['nama']; ?></td>
                    <td><?php echo $t['nama_kegiatan']; ?></td>
                    <td><?php echo $t['nominal_donasi']; ?></td>
                    <td><?php echo $t['tanggal_donasi']; ?></td>
                    <td><a href="<?php echo base_url()."uploads/konfirmasi_donasi/"; ?><?php echo $t['struk_donasi']; ?>" target="blank"><img src="<?php echo base_url()."uploads/konfirmasi_donasi/"; ?><?php echo $t['struk_donasi']; ?>" alt="" width="150px"></a></td>
                    <td><center><button type="submit" class="btn btn-primary btn-xs" name="id_donasi" value="<?php echo $t['id_donasi']; ?>"><i class="fa fa-check-square"></i> Konfirmasi Donasi</button></center></td>
                  </tr>
                  <?php endforeach?>
                  </tfoot>
                </table>
              </form>
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