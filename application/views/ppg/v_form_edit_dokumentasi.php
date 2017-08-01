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
          <form action="<?php echo base_url()."PPG/tambah_dokumentasi_kegiatan"; ?>" method="POST">
            <button type="submit" class="btn btn-danger" name="dokumentasi" value="<?php echo $dokumentasi[0]['id_kegiatan']; ?>"><i class="fa fa-arrow-left"></i> Kembali Ke Halaman Dokumentasi Kegiatan</button>
          </form>
          <br>
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Form Edit Dokumentasi Kegiatan</h3>
            </div>
            <form role="form" action="<?php echo base_url()."PPG/edit_dokumentasi_kegiatan"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return (Validate(this) && check_form());">
              <input type="hidden" name="id_kegiatan" value="<?php echo $dokumentasi[0]['id_kegiatan']; ?>">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-file-text"></i> Nama Dokumentasi</label>
                  <input type="text" class="form-control" name="nama_dokumentasi" value="<?php echo $dokumentasi[0]['nama_dokumentasi']; ?>" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-image"></i> Gambar Kegitan</label><br>
                  <img src="<?php echo base_url()."uploads/dokumentasi/"; ?><?php echo $dokumentasi[0]['gambar_dokumentasi']; ?>" alt="" width="300px"><br>
                  <!-- <input type="email" class="form-control" placeholder="Email Relawan" name="email" required> -->
                  <input name="gambar" size="20" type="file">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-file-text"></i> Deskripsi</label>
                  <textarea id="editor1" name="deskripsi" rows="10" cols="80" required>
                  <?php echo $dokumentasi[0]['deskripsi']; ?>
                  </textarea>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-calendar-check-o"></i> Tanggal</label>
                  <input type="text" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask id="datemask" value="<?php echo $dokumentasi[0]['tanggal']; ?>" name="tanggal" required>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right" name="id_dokumentasi" value="<?php echo $dokumentasi[0]['id_dokumentasi']; ?>"><i class="fa fa-edit"></i> <span>Edit Dokumentasi</span></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>


<!-- <html>
	<title></title>
	<body>
		<form action="<?php echo base_url()."PPG/edit_dokumentasi_kegiatan"; ?>" method="POST" enctype="multipart/form-data">
			<input type="text" name="id_kegiatan" value="<?php echo $dokumentasi[0]['id_kegiatan']; ?>"><br>
			<img src="<?php echo base_url()."uploads/dokumentasi/"; ?><?php echo $dokumentasi[0]['gambar_kegiatan']; ?>" alt="" width="300px"><br>
			gambar kegitan: <input name="gambar" size="20" type="file"><br>
			deskripsi: <textarea name="deskripsi" id="" cols="30" rows="10"><?php echo $dokumentasi[0]['deskripsi']; ?></textarea><br>
			tanggal: <input type="text" name="tanggal" value="<?php echo $dokumentasi[0]['tanggal']; ?>"><br>
			<button type="submit" name="id_gambar_kegiatan" value="<?php echo $dokumentasi[0]['id_gambar_kegiatan']; ?>">Edit Dokumentasi</button>
		</form>
	</body>
</html> -->