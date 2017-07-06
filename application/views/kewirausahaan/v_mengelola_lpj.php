  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-book"></i> Kelola LPJ
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
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nama Kegiatan</th>
                  <th>Status Kegiatan</th>
                  <th>Tanggal Kegiatan</th>
                  <th>Alamat</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data_kegiatan as $dk): ?>
                <tr>
                  <td><?php echo $dk['nama_kegiatan']; ?></td>
                  <td><?php echo $dk['status_kegiatan']; ?></td>
                  <td><?php echo $dk['tanggal_kegiatan']; ?></td>
                  <td><?php echo $dk['alamat']; ?></td>
                  <td>
                    <center><form action="<?php echo base_url()."Kewirausahaan/kelola_laporan"; ?>" method="POST">
                      <button type="submit" class="btn btn-primary btn-xs" name="id_kegiatan" value="<?php echo $dk['id_kegiatan']; ?>"><i class="fa fa-book"></i> Kelola Laporan</button>
                    </form></center>
                  </td>
                </tr>
                <?php endforeach?>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


<!-- <html>
	<title></title>
	<body>
		<table border="1">
			<tr>
				<td>nama_kegiatan</td>
				<td>status_kegiatan</td>
				<td>tanggal_kegiatan</td>
				<td>alamat</td>
				<td colspan="1">action</td>
			</tr>
			<?php foreach ($data_kegiatan as $dk): ?>
			<tr>
				<td><?php echo $dk['nama_kegiatan']; ?></td>
				<td><?php echo $dk['status_kegiatan']; ?></td>
				<td><?php echo $dk['tanggal_kegiatan']; ?></td>
				<td><?php echo $dk['alamat']; ?></td>
				<td>
					<form action="<?php echo base_url()."Kewirausahaan/kelola_laporan"; ?>" method="POST">
						<button type="submit" name="id_kegiatan" value="<?php echo $dk['id_kegiatan']; ?>">Kelola Laporan</button>
					</form>
				</td>
			</tr>
			<?php endforeach ?>
		</table>
	</body>
</html> -->