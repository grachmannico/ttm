  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-black-tie"></i> Kelola Donatur
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
              <h3 class="box-title">Data Seluruh Donatur</h3>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th><center>Email</center></th>
                    <th><center>Nama</center></th>
                    <th><center>Total Transaksi Donasi</center></th>
                    <th><center>Action</center></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($donatur as $d): ?>
                  <tr>
                    <td><?php echo $d['email']; ?></td>
                    <td><?php echo $d['nama']; ?></td>
                    <td><?php echo $d['total_donasi']; ?></td>
                    <td>
                      <div class="col-md-12">
                        <div class="col-md-6">
                          <center><form action="<?php echo base_url()."Kewirausahaan/edit_donatur"; ?>" method="POST">
                            <button type="submit" class="btn btn-warning btn-xs" name="edit" value="<?php echo $d['email']; ?>"><i class="fa fa-edit"></i> Edit Donatur</button>
                          </form></center>
                        </div>
                        <div class="col-md-6">
                          <center><form action="<?php echo base_url()."Kewirausahaan/detail_donatur"; ?>" method="POST">
                            <button type="submit" class="btn btn-primary btn-xs" name="donatur" value="<?php echo $d['email']; ?>"><i class="fa fa-file-text"></i> Detail Donatur</button>
                          </form></center>
                        </div>
                      </div>
                      <!-- <center><form action="<?php echo base_url()."Kewirausahaan/edit_donatur"; ?>" method="POST">
                        <button type="submit"  class="btn btn-warning btn-xs" name="edit" value="<?php echo $d['email']; ?>"><i class="fa fa-edit"></i> Edit Donatur</button>
                      </form></center> -->
                    <!-- </td>
                    <td> -->
                      <!-- <center><form action="<?php echo base_url()."Kewirausahaan/detail_donatur"; ?>" method="POST">
                        <button type="submit" class="btn btn-primary btn-xs" name="donatur" value="<?php echo $d['email']; ?>"><i class="fa fa-file-text"> Detail Donatur</button>
                      </form></center> -->
                    </td>
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
		<table border="1">
			<tr>
				<td>email</td>
				<td>nama</td>
				<td>total_donasi</td>
				<td colspan="2">action</td>
			</tr>
			<?php foreach ($donatur as $d): ?>
			<tr>
				<td><?php echo $d['email']; ?></td>
				<td><?php echo $d['nama']; ?></td>
				<td><?php echo $d['total_donasi']; ?></td>
				<td>
					<form action="<?php echo base_url()."Kewirausahaan/edit_donatur"; ?>" method="POST">
						<button type="submit" name="edit" value="<?php echo $d['email']; ?>">Edit Donatur</button>
					</form>
				</td>
				<td>
					<form action="<?php echo base_url()."Kewirausahaan/detail_donatur"; ?>" method="POST">
						<button type="submit" name="donatur" value="<?php echo $d['email']; ?>">Detail Donatur</button>
					</form>
				</td>
			</tr>
			<?php endforeach ?>
		</table>
	</body>
</html> -->