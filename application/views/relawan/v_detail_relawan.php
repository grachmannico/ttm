  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Profil Relawan
      </h1>
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol> -->
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Detail Data Relawan</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-envelope"></i> Email Relawan</label>
                <input type="email" class="form-control" value="<?php echo $data_relawan[0]['email']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-user"></i> Nama Relawan</label>
                <input type="text" class="form-control" value="<?php echo $data_relawan[0]['nama']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-lock"></i> Password</label>
                <input type="password" class="form-control" value="<?php echo $data_relawan[0]['pass']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-shield"></i> Jabatan</label>
                <input type="text" class="form-control" value="<?php echo $data_relawan[0]['pangkat_divisi']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-users"></i> Divisi</label>
                <input type="text" class="form-control" value="<?php echo $data_relawan[0]['divisi']; ?>" readonly>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Data Kontribusi Relawan</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Total Kontribusi Relawan</label>
                <input type="email" class="form-control" value="<?php echo $total_gabung[0]['jumlah_gabung_kegiatan']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Detail Kontribusi Relawan:</label>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nama Kegiatan</th>
                    <th>Status Kegiatan</th>
                    <th>Status Absensi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($detail_data as $d): ?>
                  <tr>
                    <td><?php echo $d['nama_kegiatan']; ?></td>
                    <td><?php echo $d['status_kegiatan']; ?></td>
                    <td><?php echo $d['status_absensi_relawan']; ?></td>
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
		Email: <?php echo $data_relawan[0]['email']; ?><br>
		Nama: <?php echo $data_relawan[0]['nama']; ?><br>
		Password: <?php echo $data_relawan[0]['pass']; ?><br>
		Jabatan: <?php echo $data_relawan[0]['pangkat_divisi']; ?><br>
		Divisi: <?php echo $data_relawan[0]['divisi']; ?>
		<hr>
		Total Kontribusi Relawan: <?php echo $total_gabung[0]['jumlah_gabung_kegiatan']; ?><br>
		Detail Kontribusi Relawan:
		<table border="1">
			<tr>
				<td>nama_kegiatan</td>
				<td>status_kegiatan</td>
				<td>status_absensi_relawan</td>
			</tr>
			<?php foreach ($detail_data as $d): ?>
			<tr>
				<td><?php echo $d['nama_kegiatan']; ?></td>
				<td><?php echo $d['status_kegiatan']; ?></td>
				<td><?php echo $d['status_absensi_relawan']; ?></td>
			</tr>
			<?php endforeach ?>
		</table>
	</body>
</html> -->