  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-book"></i> Dokumentasi Kegiatan
      </h1>
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol> -->
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-8 col-md-push-2">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Form Tambah Dokumentasi Kegiatan</h3>
            </div>
            <form role="form" action="<?php echo base_url()."PPG/tambah_dokumentasi_kegiatan"; ?>" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-image"></i> Gambar Kegitan</label>
                  <!-- <input type="email" class="form-control" placeholder="Email Relawan" name="email" required> -->
                  <input name="gambar" size="20" type="file" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-file-text"></i> Deskripsi</label>
                  <textarea id="editor1" name="deskripsi" rows="10" cols="80" required>
                  
                  </textarea>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-calendar-check-o"></i> Tanggal</label>
                  <input type="text" class="form-control" placeholder="Tanggal" name="tanggal" required>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-plus-square"></i> <span>Tambah Dokumentasi</span></button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-8 col-md-push-2">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Dokumentasi</h3>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>gambar kegiatan</th>
                  <th>deskripsi</th>
                  <th>tanggal</th>
                  <th>action</th>
                </tr>
                </thead>
                <tbody>
                  <?php foreach ($dokumentasi as $d): ?>
                  <tr>
                    <td><img src="<?php echo base_url()."uploads/dokumentasi/"; ?><?php echo $d['gambar_kegiatan']; ?>" alt="" width="300px"></td>
                    <td><?php echo $d['deskripsi']; ?></td>
                    <td><?php echo $d['tanggal']; ?></td>
                    <td>
                      <form action="<?php echo base_url()."PPG/edit_dokumentasi_kegiatan"; ?>" method="POST">
                        <button type="submit" name="edit" value="<?php echo $d['id_gambar_kegiatan']; ?>">Edit</button>
                      </form>
                    <!-- </td>
                    <td> -->
                      <form action="<?php echo base_url()."PPG/hapus_dokumentasi_kegiatan"; ?>" method="POST">
                        <input type="hidden" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>">
                        <button type="submit" name="hapus" value="<?php echo $d['id_gambar_kegiatan']; ?>">Hapus</button>
                      </form>
                    </td>
                  </tr>
                  <?php endforeach?>
                </tbody>
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
		<form action="<?php echo base_url()."PPG/tambah_dokumentasi_kegiatan"; ?>" method="POST" enctype="multipart/form-data">
			<input type="text" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>"><br>
			gambar kegitan: <input name="gambar" size="20" type="file"><br>
			deskripsi: <textarea name="deskripsi" id="" cols="30" rows="10"></textarea><br>
			tanggal: <input type="text" name="tanggal" placeholder="tanggal"><br>
			<button type="submit">Tambah Dokumentasi</button>
		</form>
		<hr>
		<table border="1">
			<tr>
				<td>gambar kegiatan</td>
				<td>deskripsi</td>
				<td>tanggal</td>
				<td colspan="2">action</td>
			</tr>
			<?php foreach ($dokumentasi as $d): ?>
			<tr>
				<td><img src="<?php echo base_url()."uploads/dokumentasi/"; ?><?php echo $d['gambar_kegiatan']; ?>" alt="" width="300px"></td>
				<td><?php echo $d['deskripsi']; ?></td>
				<td><?php echo $d['tanggal']; ?></td>
				<td>
					<form action="<?php echo base_url()."PPG/edit_dokumentasi_kegiatan"; ?>" method="POST">
						<button type="submit" name="edit" value="<?php echo $d['id_gambar_kegiatan']; ?>">Edit</button>
					</form>
				</td>
				<td>
					<form action="<?php echo base_url()."PPG/hapus_dokumentasi_kegiatan"; ?>" method="POST">
						<input type="hidden" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>">
						<button type="submit" name="hapus" value="<?php echo $d['id_gambar_kegiatan']; ?>">Hapus</button>
					</form>
				</td>
			</tr>
			<?php endforeach ?>
		</table>
	</body>
</html> -->