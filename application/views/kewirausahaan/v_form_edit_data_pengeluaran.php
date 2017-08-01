  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-edit"></i> Edit Data LPJ
      </h1>
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol> -->
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-8 col-md-push-2">
          <form action="<?php echo base_url()."Kewirausahaan/kelola_laporan"; ?>" method="POST">
          <button type="submit" class="btn btn-danger" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>"><i class="fa fa-arrow-left"></i> Kembali Ke Halaman Kelola Data LPJ</button>
          </form>
          <br>
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Form Edit Data LPJ</h3>
            </div>
            <form role="form" action="<?php echo base_url()."Kewirausahaan/edit_data_pengeluaran"; ?>" method="POST" onsubmit="return check_form();">
              <input type="hidden" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-book"></i> Nama Dana Keluar</label>
                  <input type="text" class="form-control" value="<?php echo $data_dana_keluar[0]['nama_dana_keluar']; ?>" name="nama_dana_keluar" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-calendar-check-o"></i> Tanggal</label>
                  <!-- <input type="text" class="form-control" value="<?php echo $data_dana_keluar[0]['tanggal']; ?>" name="tanggal" required> -->
                  <input type="text" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask id="datemask" value="<?php echo $data_dana_keluar[0]['tanggal']; ?>" name="tanggal" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-money"></i> Nominal Dana Keluar</label>
                  <input type="text" class="form-control" value="<?php echo $data_dana_keluar[0]['nominal_dana_keluar']; ?>" name="nominal_dana_keluar" id="money" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-file-text"></i> Keterangan</label>
                  <textarea id="editor1" name="keterangan" rows="10" cols="80" required>
                  <?php echo $data_dana_keluar[0]['keterangan']; ?>
                  </textarea>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right" name="id_monitor_dana_kegiatan" value="<?php echo $data_dana_keluar[0]['id_monitor_dana_kegiatan']; ?>"><i class="fa fa-edit"></i> <span>Edit Data</span></button>
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
		<form action="<?php echo base_url()."Kewirausahaan/edit_data_pengeluaran"; ?>" method="POST">
			<input type="hidden" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>">
			nama_dana_keluar: <input type="text" name="nama_dana_keluar" value="<?php echo $data_dana_keluar[0]['nama_dana_keluar']; ?>"><br>
			tanggal: <input type="text" name="tanggal" value="<?php echo $data_dana_keluar[0]['tanggal']; ?>"><br>
			nominal_dana_keluar: <input type="text" name="nominal_dana_keluar" value="<?php echo $data_dana_keluar[0]['nominal_dana_keluar']; ?>" "><br>
			keterangan: <input type="text" name="keterangan" value="<?php echo $data_dana_keluar[0]['keterangan']; ?>"><br>
			<button type="submit" name="id_monitor_dana_kegiatan" value="<?php echo $data_dana_keluar[0]['id_monitor_dana_kegiatan']; ?>">Edit data</button>
		</form>
	</body>
</html> -->