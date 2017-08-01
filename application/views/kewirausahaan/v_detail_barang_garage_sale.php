  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-cubes"></i> Barang Garage Sale
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
              <h3 class="box-title">Detail Barang</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-cube"></i> Nama Barang</label>
                <input type="text" class="form-control" value="<?php echo $detail_barang[0]['nama_barang']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-file-text"></i> Deskripsi</label><br>
                <!-- <input type="text" class="form-control" value="<?php echo $data_relawan[0]['nama']; ?>" readonly> -->
                <?php echo $detail_barang[0]['deskripsi']; ?>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-money"></i> Harga</label>
                <input type="text" class="form-control" value="<?php echo "Rp. " . number_format($detail_barang[0]['harga'], 2, ",", "."); ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-cubes"></i> Stok yang Tersedia</label>
                <input type="text" class="form-control" value="<?php echo $detail_barang[0]['stok_available']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-image"></i> Gambar Barang</label><br>
                <!-- <input type="text" class="form-control" value="<?php echo $data_relawan[0]['divisi']; ?>" readonly> -->
                <?php if ($detail_barang[0]['gambar_barang'] != ""): ?>
                <img src="<?php echo base_url()."uploads/barang_garage_sale/"; ?><?php echo $detail_barang[0]['gambar_barang']; ?>" alt="" width="300px">
                <?php endif ?>
                <?php if ($detail_barang[0]['gambar_barang'] == ""): ?>
                No Image
                <?php endif ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Data Pembeli Barang</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Detail Data Pembelian Barang <?php echo $detail_barang[0]['nama_barang']; ?>:</label>
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Qty</th>
                      <th>Status pembelian</th>
                      <th>Tanggal Pembelian</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data_pembelian as $d): ?>
                    <tr>
                      <td><?php echo $d['nama']; ?></td>
                      <td><?php echo $d['qty']; ?></td>
                      <td><?php echo $d['status_pembelian']; ?></td>
                      <td><?php echo $d['tanggal_pembelian']; ?></td>
                    </tr>
                    <?php endforeach?>
                    </tfoot>
                  </table>
                </div>
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
		nama_barang: <?php echo $detail_barang[0]['nama_barang']; ?><br>
		deskripsi: <?php echo $detail_barang[0]['deskripsi']; ?><br>
		harga: <?php echo $detail_barang[0]['harga']; ?><br>
		stok_available: <?php echo $detail_barang[0]['stok_available']; ?><br>
		<?php if ($detail_barang[0]['gambar_barang'] != ""): ?>
		gambar_barang: <br><img src="<?php echo base_url()."uploads/barang_garage_sale/"; ?><?php echo $detail_barang[0]['gambar_barang']; ?>" alt="" width="150px">
		<?php endif ?>
		<?php if ($detail_barang[0]['gambar_barang'] == ""): ?>
		gambar_barang: No Image
		<?php endif ?>
		<hr>
		Pembeli barang<br>
		<table border="1">
			<tr>
				<td>nama</td>
				<td>qty</td>
				<td>status_pembelian</td>
				<td>tanggal_pembelian</td>
			</tr>
			<?php foreach ($data_pembelian as $d): ?>
			<tr>
				<td><?php echo $d['nama']; ?></td>
				<td><?php echo $d['qty']; ?></td>
				<td><?php echo $d['status_pembelian']; ?></td>
				<td><?php echo $d['tanggal_pembelian']; ?></td>
			</tr>
			<?php endforeach ?>
		</table>
	</body>
</html> -->