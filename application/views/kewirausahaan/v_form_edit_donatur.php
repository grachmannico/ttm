  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-edit"></i> Edit Donatur
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
              <h3 class="box-title">Form Edit Data Donatur</h3>
            </div>
            <form role="form" action="<?php echo base_url()."Kewirausahaan/edit_donatur"; ?>" method="POST">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-envelope"></i> Email</label>
                  <input type="email" class="form-control" value="<?php echo $data_donatur[0]['email']; ?>" name="email" readonly>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-user"></i> Nama</label>
                  <input type="text" class="form-control" value="<?php echo $data_donatur[0]['nama']; ?>" name="nama" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-lock"></i> Password</label>
                  <input type="password" class="form-control" value="<?php echo $data_donatur[0]['pass']; ?>" name="pass" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-calendar-check-o"></i> Tanggal Lahir</label>
                  <!-- <input type="text" class="form-control" placeholder="Tanggal kegiatan" name="tanggal_kegiatan" required> -->
                  <input type="text" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask id="datemask" value="<?php echo $data_donatur[0]['tgl_lahir']; ?>" name="tgl_lahir" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-mobile-phone"></i> Nomor Handphone</label>
                  <input type="text" class="form-control" value="<?php echo $data_donatur[0]['no_hp']; ?>" name="no_hp" data-inputmask="'mask': ['9999-9999-9999', '+99-999-9999-9999']" data-mask required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-home"></i> Alamat</label>
                  <input type="text" class="form-control" value="<?php echo $data_donatur[0]['alamat']; ?>" name="alamat" required>
                </div>
                <div class="form-group">
                  <label><i class="fa fa-male"></i>/<i class="fa fa-female"></i> Jenis Kelamin</label>
                  <?php if ($data_donatur[0]['id_jenis_kelamin'] == 1): ?>
                    <select class="form-control" name="jenis_kelamin">
                      <option value="1" selected>Laki-laki</option>
                      <option value="2">Perempuan</option>
                    </select>
                  <?php endif ?>
                  <?php if ($data_donatur[0]['id_jenis_kelamin'] == 2): ?>
                    <select class="form-control" name="jenis_kelamin">
                      <option value="1">Laki-laki</option>
                      <option value="2" selected>Perempuan</option>
                    </select>
                  <?php endif ?>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-edit"></i> <span>Edit Donatur</span></button>
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
		<form action="<?php echo base_url()."Kewirausahaan/edit_donatur"; ?>" method="POST">
			email: <input type="email" name="email" value="<?php echo $data_donatur[0]['email']; ?>"><br>
			nama: <input type="text" name="nama" value="<?php echo $data_donatur[0]['nama']; ?>"><br>
			password: <input type="password" name="pass" value="<?php echo $data_donatur[0]['pass']; ?>"><br>
			<button type="submit">Edit Donatur</button>
		</form>
	</body>
</html> -->