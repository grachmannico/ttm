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
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-black-tie"></i> Data Donatur</a></li>
              <li><a href="#tab_2" data-toggle="tab"><i class="fa fa-star"></i> Data Donatur Potensial</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
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
                          <th><center>Total Transaksi Donasi Valid</center></th>
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
              <div class="tab-pane" id="tab_2">
                <div class="col-md-12">
                    <div class="box box-danger">
                      <div class="box-header">
                        <h3 class="box-title">Data Donatur Potensial</h3>
                      </div>
                      <div class="box-body">
                        <div class="table-responsive">
                          <table id="example2" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th><center>No</center></th>
                              <th><center>Nama</center></th>
                              <th><center>Hasil Penilaian</center></th>
                              <th><center>Action</center></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($rank as $t): ?>
                            <tr>
                              <td><?php echo $i ?></td>
                              <td><?php echo $t['nama']; ?></td>
                              <td>
                                <div class="progress">
                                  <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="<?php echo $t['persentase_hasil']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $t['persentase_hasil']."%"; ?>">
                                    <span class="sr-only"><?php echo $t['persentase_hasil']."%"; ?> Complete (success)</span>
                                    <?php if ($t['persentase_hasil'] != 0): ?>
                                      <p><?php echo number_format((float)$t['persentase_hasil'], 2, '.', ''); ?></p>
                                    <?php endif ?>
                                    <?php if ($t['persentase_hasil'] == 0): ?>
                                      <p style="color: black;"><?php echo number_format((float)$t['persentase_hasil'], 2, '.', ''); ?></p>
                                    <?php endif ?>
                                  </div>
                                </div>
                              </td>
                              <td>
                                <form action="<?php echo base_url()."Kewirausahaan/detail_donatur"; ?>" method="POST">
                                  <center><button type="submit" class="btn btn-primary btn-xs" name="donatur" value="<?php echo $t['email']; ?>"><i class="fa fa-black-tie"></i> Detail Donatur</button></center>
                                </form>
                              </td>
                            </tr>
                            <?php $i++; ?>
                            <?php endforeach ?>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                    </div>
                </div>
                <h4>Keterangan:</h4>
                Penilaian berdasarkan pada persentase transfer donasi yang valid dan persentase kemungkinan donatur berdonasi setiap ada kegiatan yang diadakan. Data Donatur yang ditampilkan hanya donatur yang telah melakukan transaksi donasi minimal 5 kali.
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