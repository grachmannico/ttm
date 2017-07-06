  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-cubes"></i> Kelola Barang Garage Sale
        <small></small>
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
            <div class="box-header">
              <!-- <h3 class="box-title">Data Table With Full Features</h3> -->
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nama Barang</th>
                  <th>Deskripsi</th>
                  <th>Harga</th>
                  <th>Stok Available</th>
                  <th>Stok Terpesan</th>
                  <!-- <th>Gambar Barang</th> -->
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($barang as $b): ?>
                <tr>
                  <td><?php echo $b['nama_barang']; ?></td>
                  <td><?php echo $b['deskripsi']; ?></td>
                  <td><?php echo $b['harga']; ?></td>
                  <td><?php echo $b['stok_available']; ?></td>
                  <td><?php echo $b['stok_terpesan']; ?></td>
                  <!-- <td><?php echo $b['gambar_barang']; ?></td> -->
                  <td>
                    <div class="col-md-12">
                      <div class="col-md-4">
                        <center><form action="<?php echo base_url()."Kewirausahaan/edit_barang_garage_sale"; ?>" method="POST">
                          <button type="submit" class="btn btn-warning btn-xs" name="edit" value="<?php echo $b['id_barang_garage_sale']; ?>"><i class="fa fa-edit"></i> Edit Barang</button>
                        </form></center>
                      </div>
                      <div class="col-md-4">
                        <center><form action="<?php echo base_url()."Kewirausahaan/hapus_barang_garage_sale"; ?>" method="POST">
                          <button type="submit" class="btn btn-danger btn-xs" name="hapus" value="<?php echo $b['id_barang_garage_sale']; ?>"><i class="fa fa-trash"></i> Hapus Barang</button>
                        </form></center>
                      </div>
                      <div class="col-md-4">
                        <center><form action="<?php echo base_url()."Kewirausahaan/detail_barang_garage_sale"; ?>" method="POST">
                          <button type="submit" class="btn btn-primary btn-xs" name="barang" value="<?php echo $b['id_barang_garage_sale']; ?>"><i class="fa fa-file-text"></i> Lihat Detail Barang</button>
                        </form></center>
                      </div>
                    </div>
                    <!-- <form action="<?php echo base_url()."Kewirausahaan/edit_barang_garage_sale"; ?>" method="POST">
                      <button type="submit" name="edit" value="<?php echo $b['id_barang_garage_sale']; ?>">Edit Barang</button>
                    </form> -->
                  <!-- </td>
                  <td> -->
                    <!-- <form action="<?php echo base_url()."Kewirausahaan/hapus_barang_garage_sale"; ?>" method="POST">
                      <button type="submit" name="hapus" value="<?php echo $b['id_barang_garage_sale']; ?>">Hapus Barang</button>
                    </form> -->
                  <!-- </td>
                  <td> -->
                    <!-- <form action="<?php echo base_url()."Kewirausahaan/detail_barang_garage_sale"; ?>" method="POST">
                      <button type="submit" name="barang" value="<?php echo $b['id_barang_garage_sale']; ?>">Lihat Detail Barang</button>
                    </form> -->
                  </td>
                </tr>
                <?php endforeach?>
                </tfoot>
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
		<a href="<?php echo base_url()."Kewirausahaan/tambah_barang_garage_sale"; ?>">Tambah Barang Garage Sale</a>
		<a href="<?php echo base_url()."Kewirausahaan/validasi_pembelian"; ?>">Validasi Pembelian</a>
		<table border="1">
			<tr>
				<td>nama_barang</td>
				<td>deskripsi</td>
				<td>harga</td>
				<td>stok_available</td>
				<td>stok_terpesan</td>
				<td>gambar_barang</td>
				<td colspan="3">action</td>
			</tr>
			<?php foreach ($barang as $b): ?>
			<tr>
				<td><?php echo $b['nama_barang']; ?></td>
				<td><?php echo $b['deskripsi']; ?></td>
				<td><?php echo $b['harga']; ?></td>
				<td><?php echo $b['stok_available']; ?></td>
				<td><?php echo $b['stok_terpesan']; ?></td>
				<td><?php echo $b['gambar_barang']; ?></td>
				<td>
					<form action="<?php echo base_url()."Kewirausahaan/edit_barang_garage_sale"; ?>" method="POST">
						<button type="submit" name="edit" value="<?php echo $b['id_barang_garage_sale']; ?>">Edit Barang</button>
					</form>
				</td>
				<td>
					<form action="<?php echo base_url()."Kewirausahaan/hapus_barang_garage_sale"; ?>" method="POST">
						<button type="submit" name="hapus" value="<?php echo $b['id_barang_garage_sale']; ?>">Hapus Barang</button>
					</form>
				</td>
				<td>
					<form action="<?php echo base_url()."Kewirausahaan/detail_barang_garage_sale"; ?>" method="POST">
						<button type="submit" name="barang" value="<?php echo $b['id_barang_garage_sale']; ?>">Lihat Detail Barang</button>
					</form>
				</td>
			</tr>
			<?php endforeach ?>
		</table>
	</body>
</html> -->