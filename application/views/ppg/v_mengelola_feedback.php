  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-comments"></i> Feedback Kegiatan
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
              <h3 class="box-title">Data Feedback Kegiatan</h3>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th><center>Nama Kegiatan</center></th>
                    <th><center>Tanggal Kegiatan</center></th>
                    <th><center>Rating Relawan</center></th>
                    <th><center>Rating Donatur</center></th>
                    <th><center>Action</center></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($data_kegiatan as $dk): ?>
                  <tr>
                    <td><?php echo $dk['nama_kegiatan']; ?></td>
                    <td><?php echo $dk['tanggal_kegiatan']; ?></td>
                    <td><?php echo (double) $dk['rating_relawan']; ?></td>
                    <td><?php echo (double) $dk['rating_donatur']; ?></td>
                    <td>
                      <center><form action="<?php echo base_url()."PPG/feedback_kegiatan"; ?>" method="POST">
                        <button type="submit" class="btn btn-primary btn-xs" name="id_kegiatan" value="<?php echo $dk['id_kegiatan']; ?>"><i class="fa fa-comments"></i> Lihat Feedback</button>
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
      </div>
    </section>
  </div>


<!-- <html>
	<title></title>
	<body>
		<a href="<?php echo base_url()."PPG/tambah_kegiatan"; ?>">Tambah Kegiatan</a>
		<table border="1">
			<tr>
				<td>nama_kegiatan</td>
				<td>tanggal_kegiatan</td>
				<td>alamat</td>
				<td>action</td>
			</tr>
			<?php foreach ($data_kegiatan as $dk): ?>
			<tr>
				<td><?php echo $dk['nama_kegiatan']; ?></td>
				<td><?php echo $dk['tanggal_kegiatan']; ?></td>
				<td><?php echo $dk['alamat']; ?></td>
				<td>
					<form action="<?php echo base_url()."PPG/feedback_kegiatan"; ?>" method="POST">
						<button type="submit" name="id_kegiatan" value="<?php echo $dk['id_kegiatan']; ?>">Lihat Feedback</button>
					</form>
				</td>
			</tr>
			<?php endforeach ?>
		</table>
	</body>
</html> -->