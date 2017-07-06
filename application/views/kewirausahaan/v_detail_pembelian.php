  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-shopping-cart"></i> Pembelian Barang
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
              <h3 class="box-title">Data Pembelian Barang</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-credit-card"></i> ID Invoice</label>
                <input type="text" class="form-control" value="<?php echo $invoice[0]['id_invoice']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-user"></i> Nama</label>
                <input type="text" class="form-control" value="<?php echo $invoice[0]['nama']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-calendar-check-o"></i> Tanggal Pembelian</label>
                <input type="text" class="form-control" value="<?php echo $invoice[0]['tanggal_pembelian']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-sticky-note"></i> Struk Pembelian</label><br>
                <a href="<?php echo base_url()."uploads/konfirmasi_pembayaran/"; ?><?php echo $invoice[0]['struk_pembelian']; ?>" target="blank"><img src="<?php echo base_url()."uploads/konfirmasi_pembayaran/"; ?><?php echo $invoice[0]['struk_pembelian']; ?>" alt="" width="150px" target="blank"></a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Barang yang dibeli</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <!-- <label for="exampleInputEmail1">Detail Data Pembelian Barang <?php echo $detail_barang[0]['nama_barang']; ?>:</label> -->
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Harga (per-satuan)</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($pembelian as $p): ?>
                  <tr>
                    <td><?php echo $p['nama_barang']; ?></td>
                    <td><?php echo $p['qty']; ?></td>
                    <td><?php echo $p['harga']; ?></td>
                  </tr>
                  <?php endforeach?>
                  </tfoot>
                </table>
              </div>
            </div>
            <div class="box-footer">
              <h4 class="pull-left">Total Tagihan: <?php echo $tagihan[0]['total_tagihan']; ?></h4>
              <form action="<?php echo base_url()."Kewirausahaan/validasi_pembelian"; ?>" method="POST">
                <button type="submit" class="btn btn-primary pull-right" name="validasi" value="<?php echo $invoice[0]['id_invoice']; ?>"><i class="fa fa-check-square"></i> <span>Validasi Pembelian</span></button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


<!-- <html>
	<title></title>
	<body>
		nama: <?php echo $invoice[0]['nama']; ?><br>
		tanggal_pembelian: <?php echo $invoice[0]['tanggal_pembelian']; ?><br>
		struk_pembelian: <br><a href="<?php echo base_url()."uploads/konfirmasi_pembayaran/"; ?><?php echo $invoice[0]['struk_pembelian']; ?>"><img src="<?php echo base_url()."uploads/konfirmasi_pembayaran/"; ?><?php echo $invoice[0]['struk_pembelian']; ?>" alt="" width="150px" target="blank"></a>
		<hr>
		<table border="1">
			<tr>
				<td>nama_barang</td>
				<td>qty</td>
				<td>harga (per-satuan)</td>
			</tr>
			<?php foreach ($pembelian as $p): ?>
			<tr>
				<td><?php echo $p['nama_barang']; ?></td>
				<td><?php echo $p['qty']; ?></td>
				<td><?php echo $p['harga']; ?></td>
			</tr>
			<?php endforeach ?>
		</table>
		Total Tagihan: <?php echo $tagihan[0]['total_tagihan']; ?>
		<form action="<?php echo base_url()."Kewirausahaan/validasi_pembelian"; ?>" method="POST">
			<button type="submit" name="validasi" value="<?php echo $invoice[0]['id_invoice']; ?>">Validasi Pembelian</button>
		</form>
	</body>
</html> -->