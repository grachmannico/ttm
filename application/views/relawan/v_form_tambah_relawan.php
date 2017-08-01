  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-user-plus"></i> Tambah Relawan
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
              <h3 class="box-title">Form Tambah Relawan</h3>
            </div>
            <form role="form" action="<?php echo base_url()."Relawan/tambah_relawan"; ?>" method="POST">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-envelope"></i> Email Relawan</label>
                  <input type="email" class="form-control" placeholder="Email Relawan" name="email" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-user"></i> Nama Relawan</label>
                  <input type="text" class="form-control" placeholder="Nama Relawan" name="nama" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-lock"></i> Password</label>
                  <input type="password" class="form-control" placeholder="Password" name="pass" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-calendar-check-o"></i> Tanggal Lahir</label>
                  <!-- <input type="text" class="form-control" placeholder="Tanggal kegiatan" name="tanggal_kegiatan" required> -->
                  <input type="text" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask id="datemask" placeholder="Tanggal Lahir" name="tgl_lahir" required>
                </div>
                <div class="form-group">
                  <label><i class="fa fa-users"></i> Divisi</label>
                  <select class="form-control" name="id_divisi">
                    <option value="1" selected>Non-Divisi</option>
                    <option value="2">Hubungan Masyarakat</option>
                    <option value="3">Relawan</option>
                    <option value="4">Penelitian Pengembangan dan Gerakan</option>
                    <option value="5">Media dan Publikasi</option>
                    <option value="6">Kewirausahaan</option>
                  </select>
                </div>
                <div class="form-group">
                  <label><i class="fa fa-shield"></i> Jabatan</label>
                  <select class="form-control" name="id_pangkat_divisi">
                    <option value="1" selected>Koordinator Umum</option>
                    <option value="2">Wakil Koordinator Umum</option>
                    <option value="3">Sekertaris</option>
                    <option value="4">Bendahara</option>
                    <option value="5">Ketua Divisi</option>
                    <option value="6">Volunteer</option>
                    <option value="7">Anggota Divisi</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-mobile-phone"></i> Nomor Handphone</label>
                  <input type="text" class="form-control" placeholder="Nomor Handphone" name="no_hp" data-inputmask="'mask': ['9999-9999-9999', '+99-999-9999-9999']" data-mask required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-home"></i> Alamat</label>
                  <input type="text" class="form-control" placeholder="Alamat" name="alamat" required>
                </div>
                <div class="form-group">
                  <label><i class="fa fa-male"></i>/<i class="fa fa-female"></i> Jenis Kelamin</label>
                  <select class="form-control" name="jenis_kelamin">
                    <option value="1" selected>Laki-laki</option>
                    <option value="2">Perempuan</option>
                  </select>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-user-plus"></i> <span>Tambah Data Relawan</span></button>
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
		<form action="<?php echo base_url()."Relawan/tambah_relawan"; ?>" method="POST">
			Email: <input type="email" name="email" placeholder="email"><br>
			Nama: <input type="text" name="nama" placeholder="nama"><br>
			Password: <input type="password" name="pass" placeholder="password"><br>
			Divisi: <select name="id_divisi">
				<option value="1" selected>Non-Divisi</option>
				<option value="2">Hubungan Masyarakat</option>
				<option value="3">Relawan</option>
				<option value="4">Penelitian Pengembangan dan Gerakan</option>
				<option value="5">Media dan Publikasi</option>
				<option value="6">Kewirausahaan</option>
			</select><br>
			Jabatan: <select name="id_pangkat_divisi">
				<option value="1" selected>Koordinator Umum</option>
				<option value="2">Wakil Koordinator Umum</option>
				<option value="3">Sekertaris</option>
				<option value="4">Bendahara</option>
				<option value="5">Ketua Divisi</option>
				<option value="6">Volunteer</option>
				<option value="7">Anggota Divisi</option>
			</select><br>
			<button type="submit">Tambah Data Relawan</button>
		</form>
	</body>
</html> -->