  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-list-alt"></i> Data Kegiatan
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
              <h3 class="box-title">Detail Kegiatan</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-list-alt"></i> Nama Kegiatan</label>
                <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['nama_kegiatan']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-info"></i> Status Kegiatan</label>
                <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['status_kegiatan']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-comment"></i> Pesan Ajakan</label>
                <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['pesan_ajakan']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-file-text"></i> Deskripsi Kegiatan</label><br>
                <!-- <input type="text" class="form-control" value="<?php echo $data_relawan[0]['pangkat_divisi']; ?>" readonly> -->
                <?php echo $detail_kegiatan[0]['deskripsi_kegiatan']; ?>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-users"></i> Jumlah Relawan</label>
                <input type="text" class="form-control" value="<?php echo $jumlah_relawan[0]['jumlah_relawan']; ?> / <?php echo $detail_kegiatan[0]['minimal_relawan']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-heart"></i> Jumlah Donasi</label>
                <?php if (empty($jumlah_donasi)): ?>
                <input type="text" class="form-control" value="0 / <?php echo $detail_kegiatan[0]['minimal_donasi']; ?>" readonly>
                <?php endif ?>
                <?php if (!empty($jumlah_donasi)): ?>
                <input type="text" class="form-control" value="<?php echo $jumlah_donasi[0]['jumlah_donasi']; ?> / <?php echo $detail_kegiatan[0]['minimal_donasi']; ?>" readonly>
                <?php endif ?>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-calendar-check-o"></i> Tanggal Kegiatan</label>
                <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['tanggal_kegiatan']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-calendar-times-o"></i> Batas Akhir Pendaftaran</label>
                <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['batas_akhir_pendaftaran']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-compass"></i> Alamat</label>
                <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['alamat']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-map-marker"></i> Lat</label>
                <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['lat']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-map-marker"></i> Lng</label>
                <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['lng']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-image"></i> Banner Kegiatan</label><br>
                <!-- <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['lng']; ?>" readonly> -->
                <?php if ($detail_kegiatan[0]['banner'] == ""): ?>
                  No Image<br>
                <?php endif ?>
                <?php if ($detail_kegiatan[0]['banner'] != ""): ?>
                  <img src="<?php echo base_url()."uploads/gambar_kegiatan/"; ?><?php echo $detail_kegiatan[0]['banner']; ?>" alt="" width="500px">
                <?php endif ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Dokumentasi Kegiatan</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Gambar Kegiatan</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($dokumentasi as $d): ?>
                  <tr>
                    <td><img src="<?php echo base_url()."uploads/dokumentasi/"; ?><?php echo $d['gambar_kegiatan']; ?>" alt="" width="150px"></td>
                    <td><?php echo $d['deskripsi']; ?></td>
                    <td><?php echo $d['tanggal']; ?></td>
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
		nama kegiatan: <?php echo $detail_kegiatan[0]['nama_kegiatan']; ?><br>
		status kegiatan: <?php echo $detail_kegiatan[0]['status_kegiatan']; ?><br>
		pesan ajakan: <?php echo $detail_kegiatan[0]['pesan_ajakan']; ?><br>
		deskripsi kegiatan: <?php echo $detail_kegiatan[0]['deskripsi_kegiatan']; ?><br>
		jumlah relawan: <?php echo $jumlah_relawan[0]['jumlah_relawan']; ?> / <?php echo $detail_kegiatan[0]['minimal_relawan']; ?><br>
		jumlah donasi: 
		<?php if (empty($jumlah_donasi)): ?>
			0 / <?php echo $detail_kegiatan[0]['minimal_donasi']; ?><br>
		<?php endif ?>
		<?php if (!empty($jumlah_donasi)): ?>
			<?php echo $jumlah_donasi[0]['jumlah_donasi']; ?> / <?php echo $detail_kegiatan[0]['minimal_donasi']; ?><br>
		<?php endif ?>
		tanggal kegiatan: <?php echo $detail_kegiatan[0]['tanggal_kegiatan']; ?><br>
		batas akhir pendaftaran: <?php echo $detail_kegiatan[0]['batas_akhir_pendaftaran']; ?><br>
		alamat: <?php echo $detail_kegiatan[0]['alamat']; ?><br>
		lat: <?php echo $detail_kegiatan[0]['lat']; ?><br>
		lng: <?php echo $detail_kegiatan[0]['lng']; ?><br>
		<?php if ($detail_kegiatan[0]['banner'] == ""): ?>
			No Image<br>
		<?php endif ?>
		<?php if ($detail_kegiatan[0]['banner'] != ""): ?>
			<img src="<?php echo base_url()."uploads/gambar_kegiatan/"; ?><?php echo $detail_kegiatan[0]['banner']; ?>" alt="" height="30%">
		<?php endif ?>
		<hr>
		<table border="1">
			<tr>
				<td>gambar kegiatan</td>
				<td>deskripsi</td>
				<td>tanggal</td>
			</tr>
			<?php foreach ($dokumentasi as $d): ?>
			<tr>
				<td><img src="<?php echo base_url()."uploads/dokumentasi/"; ?><?php echo $d['gambar_kegiatan']; ?>" alt="" width="300px"></td>
				<td><?php echo $d['deskripsi']; ?></td>
				<td><?php echo $d['tanggal']; ?></td>
			</tr>
			<?php endforeach ?>
		</table>
	</body>
</html> -->