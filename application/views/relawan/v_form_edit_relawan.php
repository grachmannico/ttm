  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-edit"></i> Edit Relawan
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
              <h3 class="box-title">Form Edit Relawan</h3>
            </div>
            <form role="form" action="<?php echo base_url()."Relawan/edit_relawan"; ?>" method="POST">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-envelope"></i> Email Relawan</label>
                  <input type="email" class="form-control" value="<?php echo $data_relawan[0]['email']; ?>" name="email" readonly>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-user"></i> Nama Relawan</label>
                  <input type="text" class="form-control" value="<?php echo $data_relawan[0]['nama']; ?>" name="nama" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-lock"></i> Password</label>
                  <input type="password" class="form-control" value="<?php echo $data_relawan[0]['pass']; ?>" name="pass" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-calendar-check-o"></i> Tanggal Lahir</label>
                  <!-- <input type="text" class="form-control" placeholder="Tanggal kegiatan" name="tanggal_kegiatan" required> -->
                  <input type="text" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask id="datemask" value="<?php echo $data_relawan[0]['tgl_lahir']; ?>" name="tgl_lahir" required>
                </div>
                <div class="form-group">
                  <label><i class="fa fa-users"></i> Divisi</label>
                  <select class="form-control" name="id_divisi">
                    <?php if ($data_relawan[0]['id_divisi'] == 1): ?>
                      <option value="1" selected>Non-Divisi</option>
                      <option value="2">Hubungan Masyarakat</option>
                      <option value="3">Relawan</option>
                      <option value="4">Penelitian Pengembangan dan Gerakan</option>
                      <option value="5">Media dan Publikasi</option>
                      <option value="6">Kewirausahaan</option>
                    <?php endif ?>
                    <?php if ($data_relawan[0]['id_divisi'] == 2): ?>
                      <option value="1">Non-Divisi</option>
                      <option value="2" selected>Hubungan Masyarakat</option>
                      <option value="3">Relawan</option>
                      <option value="4">Penelitian Pengembangan dan Gerakan</option>
                      <option value="5">Media dan Publikasi</option>
                      <option value="6">Kewirausahaan</option>
                    <?php endif ?>
                    <?php if ($data_relawan[0]['id_divisi'] == 3): ?>
                      <option value="1">Non-Divisi</option>
                      <option value="2">Hubungan Masyarakat</option>
                      <option value="3" selected>Relawan</option>
                      <option value="4">Penelitian Pengembangan dan Gerakan</option>
                      <option value="5">Media dan Publikasi</option>
                      <option value="6">Kewirausahaan</option>
                    <?php endif ?>
                    <?php if ($data_relawan[0]['id_divisi'] == 4): ?>
                      <option value="1">Non-Divisi</option>
                      <option value="2">Hubungan Masyarakat</option>
                      <option value="3">Relawan</option>
                      <option value="4" selected>Penelitian Pengembangan dan Gerakan</option>
                      <option value="5">Media dan Publikasi</option>
                      <option value="6">Kewirausahaan</option>
                    <?php endif ?>
                    <?php if ($data_relawan[0]['id_divisi'] == 5): ?>
                      <option value="1">Non-Divisi</option>
                      <option value="2">Hubungan Masyarakat</option>
                      <option value="3">Relawan</option>
                      <option value="4">Penelitian Pengembangan dan Gerakan</option>
                      <option value="5" selected>Media dan Publikasi</option>
                      <option value="6">Kewirausahaan</option>
                    <?php endif ?>
                    <?php if ($data_relawan[0]['id_divisi'] == 6): ?>
                      <option value="1">Non-Divisi</option>
                      <option value="2">Hubungan Masyarakat</option>
                      <option value="3">Relawan</option>
                      <option value="4">Penelitian Pengembangan dan Gerakan</option>
                      <option value="5">Media dan Publikasi</option>
                      <option value="6" selected>Kewirausahaan</option>
                    <?php endif ?>
                  </select>
                </div>
                <div class="form-group">
                  <label><i class="fa fa-shield"></i> Jabatan</label>
                  <select class="form-control" name="id_pangkat_divisi">
                    <?php if ($data_relawan[0]['id_pangkat_divisi'] == 1): ?>
                      <option value="1" selected>Koordinator Umum</option>
                      <option value="2">Wakil Koordinator Umum</option>
                      <option value="3">Sekertaris</option>
                      <option value="4">Bendahara</option>
                      <option value="5">Ketua Divisi</option>
                      <option value="6">Volunteer</option>
                      <option value="7">Anggota Divisi</option>
                    <?php endif ?>
                    <?php if ($data_relawan[0]['id_pangkat_divisi'] == 2): ?>
                      <option value="1">Koordinator Umum</option>
                      <option value="2" selected>Wakil Koordinator Umum</option>
                      <option value="3">Sekertaris</option>
                      <option value="4">Bendahara</option>
                      <option value="5">Ketua Divisi</option>
                      <option value="6">Volunteer</option>
                      <option value="7">Anggota Divisi</option>
                    <?php endif ?>
                    <?php if ($data_relawan[0]['id_pangkat_divisi'] == 3): ?>
                      <option value="1">Koordinator Umum</option>
                      <option value="2">Wakil Koordinator Umum</option>
                      <option value="3" selected>Sekertaris</option>
                      <option value="4">Bendahara</option>
                      <option value="5">Ketua Divisi</option>
                      <option value="6">Volunteer</option>
                      <option value="7">Anggota Divisi</option>
                    <?php endif ?>
                    <?php if ($data_relawan[0]['id_pangkat_divisi'] == 4): ?>
                      <option value="1">Koordinator Umum</option>
                      <option value="2">Wakil Koordinator Umum</option>
                      <option value="3">Sekertaris</option>
                      <option value="4" selected>Bendahara</option>
                      <option value="5">Ketua Divisi</option>
                      <option value="6">Volunteer</option>
                      <option value="7">Anggota Divisi</option>
                    <?php endif ?>
                    <?php if ($data_relawan[0]['id_pangkat_divisi'] == 5): ?>
                      <option value="1">Koordinator Umum</option>
                      <option value="2">Wakil Koordinator Umum</option>
                      <option value="3">Sekertaris</option>
                      <option value="4">Bendahara</option>
                      <option value="5" selected>Ketua Divisi</option>
                      <option value="6">Volunteer</option>
                      <option value="7">Anggota Divisi</option>
                    <?php endif ?>
                    <?php if ($data_relawan[0]['id_pangkat_divisi'] == 6): ?>
                      <option value="1">Koordinator Umum</option>
                      <option value="2">Wakil Koordinator Umum</option>
                      <option value="3">Sekertaris</option>
                      <option value="4">Bendahara</option>
                      <option value="5">Ketua Divisi</option>
                      <option value="6" selected>Volunteer</option>
                      <option value="7">Anggota Divisi</option>
                    <?php endif ?>
                    <?php if ($data_relawan[0]['id_pangkat_divisi'] == 7): ?>
                      <option value="1">Koordinator Umum</option>
                      <option value="2">Wakil Koordinator Umum</option>
                      <option value="3">Sekertaris</option>
                      <option value="4">Bendahara</option>
                      <option value="5">Ketua Divisi</option>
                      <option value="6">Volunteer</option>
                      <option value="7" selected>Anggota Divisi</option>
                    <?php endif ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-mobile-phone"></i> Nomor Handphone</label>
                  <input type="text" class="form-control" value="<?php echo $data_relawan[0]['no_hp']; ?>" name="no_hp" data-inputmask="'mask': ['9999-9999-9999', '+99-999-9999-9999']" data-mask required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-home"></i> Alamat</label>
                  <input type="text" class="form-control" value="<?php echo $data_relawan[0]['alamat']; ?>" name="alamat" required>
                </div>
                <div class="form-group">
                  <label><i class="fa fa-male"></i>/<i class="fa fa-female"></i> Jenis Kelamin</label>
                  <?php if ($data_relawan[0]['id_jenis_kelamin'] == 1): ?>
                    <select class="form-control" name="jenis_kelamin">
                      <option value="1" selected>Laki-laki</option>
                      <option value="2">Perempuan</option>
                    </select>
                  <?php endif ?>
                  <?php if ($data_relawan[0]['id_jenis_kelamin'] == 2): ?>
                    <select class="form-control" name="jenis_kelamin">
                      <option value="1">Laki-laki</option>
                      <option value="2" selected>Perempuan</option>
                    </select>
                  <?php endif ?>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-edit"></i> <span>Edit Data Relawan</span></button>
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
		<form action="<?php echo base_url()."Relawan/edit_relawan"; ?>" method="POST">
			Email: <input type="email" name="email" value="<?php echo $data_relawan[0]['email']; ?>"><br>
			Nama: <input type="text" name="nama" value="<?php echo $data_relawan[0]['nama']; ?>"><br>
			Password: <input type="password" name="pass" value="<?php echo $data_relawan[0]['pass']; ?>"><br>
			Divisi: <select name="id_divisi">
			<?php if ($data_relawan[0]['id_divisi'] == 1): ?>
				<option value="1" selected>Non-Divisi</option>
				<option value="2">Hubungan Masyarakat</option>
				<option value="3">Relawan</option>
				<option value="4">Penelitian Pengembangan dan Gerakan</option>
				<option value="5">Media dan Publikasi</option>
				<option value="6">Kewirausahaan</option>
			<?php endif ?>
			<?php if ($data_relawan[0]['id_divisi'] == 2): ?>
				<option value="1">Non-Divisi</option>
				<option value="2" selected>Hubungan Masyarakat</option>
				<option value="3">Relawan</option>
				<option value="4">Penelitian Pengembangan dan Gerakan</option>
				<option value="5">Media dan Publikasi</option>
				<option value="6">Kewirausahaan</option>
			<?php endif ?>
			<?php if ($data_relawan[0]['id_divisi'] == 3): ?>
				<option value="1">Non-Divisi</option>
				<option value="2">Hubungan Masyarakat</option>
				<option value="3" selected>Relawan</option>
				<option value="4">Penelitian Pengembangan dan Gerakan</option>
				<option value="5">Media dan Publikasi</option>
				<option value="6">Kewirausahaan</option>
			<?php endif ?>
			<?php if ($data_relawan[0]['id_divisi'] == 4): ?>
				<option value="1">Non-Divisi</option>
				<option value="2">Hubungan Masyarakat</option>
				<option value="3">Relawan</option>
				<option value="4" selected>Penelitian Pengembangan dan Gerakan</option>
				<option value="5">Media dan Publikasi</option>
				<option value="6">Kewirausahaan</option>
			<?php endif ?>
			<?php if ($data_relawan[0]['id_divisi'] == 5): ?>
				<option value="1">Non-Divisi</option>
				<option value="2">Hubungan Masyarakat</option>
				<option value="3">Relawan</option>
				<option value="4">Penelitian Pengembangan dan Gerakan</option>
				<option value="5" selected>Media dan Publikasi</option>
				<option value="6">Kewirausahaan</option>
			<?php endif ?>
			<?php if ($data_relawan[0]['id_divisi'] == 6): ?>
				<option value="1">Non-Divisi</option>
				<option value="2">Hubungan Masyarakat</option>
				<option value="3">Relawan</option>
				<option value="4">Penelitian Pengembangan dan Gerakan</option>
				<option value="5">Media dan Publikasi</option>
				<option value="6" selected>Kewirausahaan</option>
			<?php endif ?>
			</select><br>

			Jabatan: <select name="id_pangkat_divisi">
			<?php if ($data_relawan[0]['id_pangkat_divisi'] == 1): ?>
				<option value="1" selected>Koordinator Umum</option>
				<option value="2">Wakil Koordinator Umum</option>
				<option value="3">Sekertaris</option>
				<option value="4">Bendahara</option>
				<option value="5">Ketua Divisi</option>
				<option value="6">Volunteer</option>
				<option value="7">Anggota Divisi</option>
			<?php endif ?>
			<?php if ($data_relawan[0]['id_pangkat_divisi'] == 2): ?>
				<option value="1">Koordinator Umum</option>
				<option value="2" selected>Wakil Koordinator Umum</option>
				<option value="3">Sekertaris</option>
				<option value="4">Bendahara</option>
				<option value="5">Ketua Divisi</option>
				<option value="6">Volunteer</option>
				<option value="7">Anggota Divisi</option>
			<?php endif ?>
			<?php if ($data_relawan[0]['id_pangkat_divisi'] == 3): ?>
				<option value="1">Koordinator Umum</option>
				<option value="2">Wakil Koordinator Umum</option>
				<option value="3" selected>Sekertaris</option>
				<option value="4">Bendahara</option>
				<option value="5">Ketua Divisi</option>
				<option value="6">Volunteer</option>
				<option value="7">Anggota Divisi</option>
			<?php endif ?>
			<?php if ($data_relawan[0]['id_pangkat_divisi'] == 4): ?>
				<option value="1">Koordinator Umum</option>
				<option value="2">Wakil Koordinator Umum</option>
				<option value="3">Sekertaris</option>
				<option value="4" selected>Bendahara</option>
				<option value="5">Ketua Divisi</option>
				<option value="6">Volunteer</option>
				<option value="7">Anggota Divisi</option>
			<?php endif ?>
			<?php if ($data_relawan[0]['id_pangkat_divisi'] == 5): ?>
				<option value="1">Koordinator Umum</option>
				<option value="2">Wakil Koordinator Umum</option>
				<option value="3">Sekertaris</option>
				<option value="4">Bendahara</option>
				<option value="5" selected>Ketua Divisi</option>
				<option value="6">Volunteer</option>
				<option value="7">Anggota Divisi</option>
			<?php endif ?>
			<?php if ($data_relawan[0]['id_pangkat_divisi'] == 6): ?>
				<option value="1">Koordinator Umum</option>
				<option value="2">Wakil Koordinator Umum</option>
				<option value="3">Sekertaris</option>
				<option value="4">Bendahara</option>
				<option value="5">Ketua Divisi</option>
				<option value="6" selected>Volunteer</option>
				<option value="7">Anggota Divisi</option>
			<?php endif ?>
			<?php if ($data_relawan[0]['id_pangkat_divisi'] == 7): ?>
				<option value="1">Koordinator Umum</option>
				<option value="2">Wakil Koordinator Umum</option>
				<option value="3">Sekertaris</option>
				<option value="4">Bendahara</option>
				<option value="5">Ketua Divisi</option>
				<option value="6">Volunteer</option>
				<option value="7" selected>Anggota Divisi</option>
			<?php endif ?>
			</select><br>
			<button type="submit">Edit Data Relawan</button>
		</form>
	</body>
</html> -->