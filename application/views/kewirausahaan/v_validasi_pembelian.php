  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-check-square"></i> Validasi Pembelian
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
                  <th>id_invoice</th>
                  <th>nama</th>
                  <th>tanggal_pembelian</th>
                  <th>struk_pembelian</th>
                  <th>action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($invoice as $i): ?>
                <tr>
                  <td><?php echo $i['id_invoice']; ?></td>
                  <td><?php echo $i['nama']; ?></td>
                  <td><?php echo $i['tanggal_pembelian']; ?></td>
                  <td><a href="<?php echo base_url()."uploads/konfirmasi_pembayaran/"; ?><?php echo $i['struk_pembelian']; ?>"><img src="<?php echo base_url()."uploads/konfirmasi_pembayaran/"; ?><?php echo $i['struk_pembelian']; ?>" alt="" width="150px" target="blank"></a></td>
                  <td>
                    <div class="col-md-12">
                      <div class="col-md-6">
                        <center><form action="<?php echo base_url()."Kewirausahaan/validasi_pembelian"; ?>" method="POST">
                          <button type="submit" class="btn btn-primary btn-xs" name="validasi" value="<?php echo $i['id_invoice']; ?>"><i class="fa fa-check-square"></i> Validasi Pembelian</button>
                        </form></center>
                      </div>
                      <div class="col-md-6">
                        <center><form action="<?php echo base_url()."Kewirausahaan/detail_pembelian"; ?>" method="POST">
                          <button type="submit" class="btn btn-primary btn-xs" name="detail" value="<?php echo $i['id_invoice']; ?>"><i class="fa fa-file-text"></i> Lihat Detail Pembelian</button>
                        </form></center>
                      </div>
                    </div>
                    <!-- <form action="<?php echo base_url()."Kewirausahaan/validasi_pembelian"; ?>" method="POST">
                      <button type="submit" class="btn btn-primary btn-xs" name="validasi" value="<?php echo $i['id_invoice']; ?>"><i class="fa fa-check-square"></i> Validasi Pembelian</button>
                    </form> -->
                  <!-- </td>
                  <td> -->
                    <!-- <form action="<?php echo base_url()."Kewirausahaan/detail_pembelian"; ?>" method="POST">
                      <button type="submit" class="btn btn-primary btn-xs" name="detail" value="<?php echo $i['id_invoice']; ?>"><i class="fa fa-file-text"></i> Lihat Detail Pembelian</button>
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
		<table border="1">
			<tr>
				<td>id_invoice</td>
				<td>nama</td>
				<td>tanggal_pembelian</td>
				<td>struk_pembelian</td>
				<td colspan="2">action</td>
			</tr>
			<?php foreach ($invoice as $i): ?>
			<tr>
				<td><?php echo $i['id_invoice']; ?></td>
				<td><?php echo $i['nama']; ?></td>
				<td><?php echo $i['tanggal_pembelian']; ?></td>
				<td><a href="<?php echo base_url()."uploads/konfirmasi_pembayaran/"; ?><?php echo $i['struk_pembelian']; ?>"><img src="<?php echo base_url()."uploads/konfirmasi_pembayaran/"; ?><?php echo $i['struk_pembelian']; ?>" alt="" width="150px" target="blank"></a></td>
				<td>
					<form action="<?php echo base_url()."Kewirausahaan/validasi_pembelian"; ?>" method="POST">
						<button type="submit" name="validasi" value="<?php echo $i['id_invoice']; ?>">Validasi Pembelian</button>
					</form>
				</td>
				<td>
					<form action="<?php echo base_url()."Kewirausahaan/detail_pembelian"; ?>" method="POST">
						<button type="submit" name="detail" value="<?php echo $i['id_invoice']; ?>">Lihat Detail Pembelian</button>
					</form>
				</td>
			</tr>
			<?php endforeach ?>
		</table>
	</body>
</html> -->