<?php
function tanggal_indo($tanggal)
{
    $bulan = array(1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    );
    $split = explode('-', $tanggal);
    return $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];
}
?>

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
          <div class="box box-widget widget-user">
            <div class="widget-user-header bg-black" style="background: url('<?php echo base_url() . "uploads/"; ?>bgcoba.png') center center;">
              <h3 class="widget-user-username" style="color: black;"><?php echo $data_relawan[0]['nama']; ?></h3>
              <h5 class="widget-user-desc" style="color: black;"><?php echo $data_relawan[0]['email']; ?></h5>
            </div>
            <div class="widget-user-image">
              <?php if ($data_relawan[0]['foto_profil'] == ""): ?>
                <img class="img-circle" src="<?php echo base_url() . "assets/"; ?>dist/img/user2-160x160.jpg" alt="User Avatar">
              <?php endif ?>
              <?php if ($data_relawan[0]['foto_profil'] != ""): ?>
                <img src="<?php echo base_url() . "uploads/foto_profil/"; ?><?php echo $data_relawan[0]['foto_profil']; ?>" alt="User Avatar" style="border-radius: 50%; height: 90px; width: 90px;">
              <?php endif ?>
            </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-6 border-right">
                  <div class="description-block">
                    <h5 class="description-header"><?php echo $data_relawan[0]['divisi']; ?></h5>
                    <span class="description-text"><?php echo $data_relawan[0]['pangkat_divisi']; ?></span>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="description-block">
                    <h5 class="description-header"><?php echo $total_gabung[0]['jumlah_gabung_kegiatan']; ?></h5>
                    <span class="description-text">Total Kontribusi</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
                <label for="exampleInputEmail1"><i class="fa fa-calendar-check-o"></i> Tanggal Lahir</label>
                <input type="text" class="form-control" value="<?php echo tanggal_indo($data_relawan[0]['tgl_lahir']); ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-shield"></i> Jabatan</label>
                <input type="text" class="form-control" value="<?php echo $data_relawan[0]['pangkat_divisi']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-users"></i> Divisi</label>
                <input type="text" class="form-control" value="<?php echo $data_relawan[0]['divisi']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-mobile-phone"></i> Nomor Handphone</label>
                <input type="text" class="form-control" value="<?php echo $data_relawan[0]['no_hp']; ?>" name="no_hp" data-inputmask="'mask': ['9999-9999-9999', '+99-999-9999-9999']" data-mask readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-home"></i> Alamat</label>
                <input type="text" class="form-control" value="<?php echo $data_relawan[0]['alamat']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-male"></i>/<i class="fa fa-female"></i> Jenis Kelamin</label>
                <input type="text" class="form-control" value="<?php echo $data_relawan[0]['jenis_kelamin']; ?>" readonly>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <?php if (!empty($jml_gabung) && !empty($jml_absen_sukses) && !empty($jml_semua_absen)) { ?>
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Statistik Data Relawan</h3>
            </div>
            <div class="box-body">
              <div class="col-md-12">
                <div class="info-box bg-red">
                  <span class="info-box-icon"><i class="fa fa-check-square"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">Persentase Kehadiran Relawan:</span>
                    <span class="info-box-number"><?php echo number_format((float)$kontribusi, 2, '.', ''); ?>%</span>

                    <div class="progress">
                      <div class="progress-bar" style="width: <?php echo $kontribusi; ?>%"></div>
                    </div>
                        <span class="progress-description">
                          Tercatat <?php echo $jml_absen_sukses; ?> kali hadir dari <?php echo $jml_semua_absen; ?> kegiatan yang diikuti
                        </span>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="info-box bg-red">
                  <span class="info-box-icon"><i class="fa fa-line-chart"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">Persentase Gabung Dalam Kegiatan:</span>
                    <span class="info-box-number"><?php echo number_format((float)$persentase_gabung_kegiatan, 2, '.', ''); ?>%</span>

                    <div class="progress">
                      <div class="progress-bar" style="width: <?php echo $persentase_gabung_kegiatan; ?>%"></div>
                    </div>
                        <span class="progress-description">
                          Dari seluruh kegiatan, relawan mengikuti <?php echo $jml_absen_sukses; ?> dari <?php echo $jml_kegiatan; ?> kegiatan
                        </span>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                Kesimpulan: <b><?php echo $status_relawan; ?></b><br>
                Kontribusi Relawan Selama Mengikuti Kegiatan: <b><?php echo $status_kontribusi ?></b>
                <hr>
                <?php if (!empty($jml_blm_absen)): ?>
                  <p class="label label-warning pull-right">Catatan: Ada <?php echo $jml_blm_absen; ?> kegiatan yang belum dilakukan absensi</p>
                <?php endif ?>
                <?php if ($sertifikat == "y"): ?>
                  <p class="label label-success pull-right">Relawan Berhak Mendapat Sertifikat Aktif Relawan</p>
                  <?php if (empty($cek_sertifikat)): ?>
                    <form action="<?php echo base_url()."Relawan/sertifikat_aktif_relawan"; ?>" method="POST">
                      <button type="submit" class="btn btn-success" name="sertifikat" value="<?php echo $data_relawan[0]['email']; ?>"><i class="fa fa-bookmark"></i> Keluarkan Sertifikat</button>
                    </form>
                  <?php endif ?>
                  <?php if (!empty($cek_sertifikat)): ?>
                    <button class="btn btn-success disabled"><i class="fa fa-bookmark"></i> Sertifikat Telah Diterbitkan</button>
                  <?php endif ?>
                <?php endif ?>
              </div>
            </div>
          </div>
          <?php } ?>
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Data Kontribusi Relawan</h3>
            </div>
            <div class="box-body">
              <!-- <div class="form-group">
                <label for="exampleInputEmail1">Total Kontribusi Relawan</label>
                <input type="email" class="form-control" value="<?php echo $total_gabung[0]['jumlah_gabung_kegiatan']; ?>" readonly>
              </div> -->
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