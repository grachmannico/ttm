  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-book"></i> Kelola LPJ Kegiatan "<?php echo $nama_kegiatan[0]['nama_kegiatan']; ?>"
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
            <div class="box-header with-border">
              <h3 class="box-title">Tambah Data LPJ</h3>
            </div>
            <form role="form" action="<?php echo base_url()."Kewirausahaan/tambah_data_pengeluaran"; ?>" method="POST">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-book"></i> Nama Dana Keluar</label>
                  <input type="text" class="form-control" placeholder="Nama Dana Keluar" name="nama_dana_keluar" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-calendar-check-o"></i> Tanggal</label>
                  <!-- <input type="text" class="form-control" placeholder="Tanggal" name="tanggal" required> -->
                  <input type="text" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask id="datemask" placeholder="Tanggal" name="tanggal" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-money"></i> Nominal Dana Keluar</label>
                  <input type="text" class="form-control" placeholder="Nominal Dana Keluar" name="nominal_dana_keluar" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-file-text"></i> Keterangan</label>
                  <textarea id="editor1" name="keterangan" rows="10" cols="80" required>
                  
                  </textarea>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>"><i class="fa fa-plus-square"></i> <span>Tambah Data</span></button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-12">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Laporan Pengeluaran Dana</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <!-- <label for="exampleInputEmail1">Detail Data Pembelian Barang <?php echo $detail_barang[0]['nama_barang']; ?>:</label> -->
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nama Dana Keluar</th>
                    <th>Tanggal</th>
                    <th>Nominal Dana Keluar</th>
                    <th>Keterangan</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($dana_keluar as $d): ?>
                  <tr>
                    <td><?php echo $d['nama_dana_keluar']; ?></td>
                    <td><?php echo $d['tanggal']; ?></td>
                    <td><?php echo $d['nominal_dana_keluar']; ?></td>
                    <td><?php echo $d['keterangan']; ?></td>
                    <td>
                      <div class="col-md-12">
                        <div class="col-md-6">
                          <center><form action="<?php echo base_url()."Kewirausahaan/edit_data_pengeluaran"; ?>" method="POST">
                            <input type="hidden" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>">
                            <button type="submit" class="btn btn-warning btn-xs" name="edit" value="<?php echo $d['id_monitor_dana_kegiatan']; ?>"><i class="fa fa-edit"></i> Edit</button>
                          </form></center>
                        </div>
                        <div class="col-md-6">
                          <center><form action="<?php echo base_url()."Kewirausahaan/hapus_data_pengeluaran"; ?>" method="POST">
                            <input type="hidden" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>">
                            <button type="submit" class="btn btn-danger btn-xs" name="hapus" value="<?php echo $d['id_monitor_dana_kegiatan']; ?>"><i class="fa fa-trash"></i> Hapus</button>
                          </form></center>
                        </div>
                      </div>
                      <!-- <form action="<?php echo base_url()."Kewirausahaan/edit_data_pengeluaran"; ?>" method="POST">
                        <input type="hidden" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>">
                        <button type="submit" name="edit" value="<?php echo $d['id_monitor_dana_kegiatan']; ?>">Edit</button>
                      </form> -->
                    <!-- </td>
                    <td> -->
                      <!-- <form action="<?php echo base_url()."Kewirausahaan/hapus_data_pengeluaran"; ?>" method="POST">
                        <input type="hidden" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>">
                        <button type="submit" name="hapus" value="<?php echo $d['id_monitor_dana_kegiatan']; ?>">Hapus</button>
                      </form> -->
                    </td>
                  </tr>
                  <?php endforeach?>
                  </tfoot>
                </table>
              </div>
            </div>
            <!-- <div class="box-footer">
              <h4 class="pull-left">Total Tagihan: <?php echo $tagihan[0]['total_tagihan']; ?></h4>
              <form action="<?php echo base_url()."Kewirausahaan/validasi_pembelian"; ?>" method="POST">
                <button type="submit" class="btn btn-primary pull-right" name="validasi" value="<?php echo $invoice[0]['id_invoice']; ?>"><i class="fa fa-plus"></i> <span>Validasi Pembelian</span></button>
              </form>
            </div> -->
          </div>
        </div>
        <div class="col-md-12">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Donasi yang Masuk</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <!-- <label for="exampleInputEmail1">Detail Data Pembelian Barang <?php echo $detail_barang[0]['nama_barang']; ?>:</label> -->
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>nama</th>
                    <th>nominal_donasi</th>
                    <th>tanggal_donasi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($dana_masuk as $d): ?>
                  <tr>
                    <td><?php echo $d['nama']; ?></td>
                    <td><?php echo $d['nominal_donasi']; ?></td>
                    <td><?php echo $d['tanggal_donasi']; ?></td>
                  </tr>
                  <?php endforeach?>
                  </tfoot>
                </table>
              </div>
            </div>
            <div class="box-footer">
              <h4 class="pull-left">Total Donasi: <?php echo $total_dana[0]['total_dana']; ?></h4>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


<!-- <html>
	<title></title>
	<body>
		<form action="<?php echo base_url()."Kewirausahaan/tambah_data_pengeluaran"; ?>" method="POST">
			nama_dana_keluar: <input type="text" name="nama_dana_keluar" placeholder="nama_dana_keluar"><br>
			tanggal: <input type="text" name="tanggal" placeholder="tanggal"><br>
			nominal_dana_keluar: <input type="text" name="nominal_dana_keluar" placeholder="nominal_dana_keluar"><br>
			keterangan: <input type="text" name="keterangan" placeholder="keterangan"><br>
			<button type="submit" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>">Tambah data</button>
		</form>
		<hr>
		<table border="1">
			<tr>
				<td>nama_dana_keluar</td>
				<td>tanggal</td>
				<td>nominal_dana_keluar</td>
				<td>keterangan</td>
				<td colspan="2">action</td>
			</tr>
			<?php foreach ($dana_keluar as $d): ?>
			<tr>
				<td><?php echo $d['nama_dana_keluar']; ?></td>
				<td><?php echo $d['tanggal']; ?></td>
				<td><?php echo $d['nominal_dana_keluar']; ?></td>
				<td><?php echo $d['keterangan']; ?></td>
				<td>
					<form action="<?php echo base_url()."Kewirausahaan/edit_data_pengeluaran"; ?>" method="POST">
						<input type="hidden" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>">
						<button type="submit" name="edit" value="<?php echo $d['id_monitor_dana_kegiatan']; ?>">Edit</button>
					</form>
				</td>
				<td>
					<form action="<?php echo base_url()."Kewirausahaan/hapus_data_pengeluaran"; ?>" method="POST">
						<input type="hidden" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>">
						<button type="submit" name="hapus" value="<?php echo $d['id_monitor_dana_kegiatan']; ?>">Hapus</button>
					</form>
				</td>
			</tr>
			<?php endforeach ?>
		</table>
		<hr>
		Total Donasi: <?php echo $total_dana[0]['total_dana']; ?><br>
		<table border="1">
			<tr>
				<td>nama</td>
				<td>nominal_donasi</td>
				<td>tanggal_donasi</td>
			</tr>
			<?php foreach ($dana_masuk as $d): ?>
			<tr>
				<td><?php echo $d['nama']; ?></td>
				<td><?php echo $d['nominal_donasi']; ?></td>
				<td><?php echo $d['tanggal_donasi']; ?></td>
			</tr>
			<?php endforeach ?>
		</table>
	</body>
</html> -->