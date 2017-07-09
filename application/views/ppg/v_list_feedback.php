  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-comments"></i> Feedback Kegiatan
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
              <li class="active"><a href="#tab_1" data-toggle="tab">Feedback Relawan</a></li>
              <li><a href="#tab_2" data-toggle="tab">Feedback Donatur</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <div class="box box-danger">
                  <div class="box-header">
                    <?php if (empty($feedback_relawan)): ?>
                      <h4>Feedback Kosong</h4>
                    <?php endif ?>
                    <?php if (!empty($feedback_relawan)): ?>
                      <h4>Feedback Relawan Yang Masuk Pada Kegiatan "<?php echo $feedback_relawan[0]['nama_kegiatan']; ?>"</h4>
                    <?php endif ?>
                  </div>
                  <div class="box-body">
                    <div class="table-responsive">
                      <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th><center>email</center></th>
                          <th><center>nama</center></th>
                          <th><center>komentar</center></th>
                          <th><center>rating</center></th>
                          <th><center>tanggal</center></th>
                          <th><center>action</center></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($feedback_relawan as $f): ?>
                        <tr>
                          <td><?php echo $f['email']; ?></td>
                          <td><?php echo $f['nama']; ?></td>
                          <td><?php echo $f['komentar']; ?></td>
                          <td><?php echo $f['rating']; ?></td>
                          <td><?php echo $f['tanggal']; ?></td>
                          <td>
                            <center><form action="<?php echo base_url()."PPG/balas_feedback_relawan"; ?>" method="POST">
                              <input type="hidden" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>">
                              <button type="sumbit" class="btn btn-primary btn-xs" name="balas" value="<?php echo $f['id_feedback_kegiatan']; ?>"><i class="fa fa-comments"></i> Balas Komentar</button>
                            </form></center>
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
                <div class="box box-danger">
                  <div class="box-header">
                    <?php if (empty($feedback_donatur)): ?>
                      <h4>Feedback Kosong</h4>
                    <?php endif ?>
                    <?php if (!empty($feedback_donatur)): ?>
                      <h4>Feedback Donatur Yang Masuk Pada Kegiatan "<?php echo $feedback_donatur[0]['nama_kegiatan']; ?>"</h4>
                    <?php endif ?>
                  </div>
                  <div class="box-body">
                    <div class="table-responsive">
                      <table id="example2" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th><center>email</center></th>
                          <th><center>nama</center></th>
                          <th><center>komentar</center></th>
                          <th><center>rating</center></th>
                          <th><center>tanggal</center></th>
                          <th><center>action</center></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($feedback_donatur as $f): ?>
                        <tr>
                          <td><?php echo $f['email']; ?></td>
                          <td><?php echo $f['nama']; ?></td>
                          <td><?php echo $f['komentar']; ?></td>
                          <td><?php echo $f['rating']; ?></td>
                          <td><?php echo $f['tanggal']; ?></td>
                          <td>
                            <center><form action="<?php echo base_url()."PPG/balas_feedback_donatur"; ?>" method="POST">
                              <input type="hidden" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>">
                              <button type="sumbit" class="btn btn-primary btn-xs" name="balas" value="<?php echo $f['id_feedback_kegiatan']; ?>"><i class="fa fa-comments"></i> Balas Komentar</button>
                            </form></center>
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
          </div>

          <!-- <div class="box">
            <div class="box-header">
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>email</th>
                  <th>nama</th>
                  <th>komentar</th>
                  <th>rating</th>
                  <th>action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($feedback as $f): ?>
                <tr>
                  <td><?php echo $f['email']; ?></td>
                  <td><?php echo $f['nama']; ?></td>
                  <td><?php echo $f['komentar']; ?></td>
                  <td><?php echo $f['rating']; ?></td>
                  <td>
                    <center><form action="<?php echo base_url()."PPG/balas_feedback"; ?>" method="POST">
                      <button type="sumbit" class="btn btn-primary btn-xs" name="balas" value="<?php echo $f['id_feedback_kegiatan']; ?>"><i class="fa fa-comments"></i> Balas Komentar</button>
                    </form></center>
                  </td>
                </tr>
                <?php endforeach?>
                </tfoot>
              </table>
            </div>
          </div> -->
        </div>
      </div>
    </section>
  </div>


<!-- <html>
	<title></title>
	<body>
		<table border="">
			<tr>
				<td>email</td>
				<td>nama</td>
				<td>komentar</td>
				<td>rating</td>
				<td colspan="2">action</td>
			</tr>
			<?php foreach ($feedback as $f): ?>
			<tr>
				<td><?php echo $f['email']; ?></td>
				<td><?php echo $f['nama']; ?></td>
				<td><?php echo $f['komentar']; ?></td>
				<td><?php echo $f['rating']; ?></td>
				<td>
					<form action="<?php echo base_url()."PPG/balas_feedback"; ?>" method="POST">
						<button type="sumbit" name="balas" value="<?php echo $f['id_feedback_kegiatan']; ?>">Balas Komentar</button>
					</form>
				</td>
				<td>
					<form action="<?php echo base_url()."PPG/lihat_balasan_feedback"; ?>">
						<button type="sumbit" name="lihat" value="<?php echo $f['id_feedback_kegiatan']; ?>">Lihat Komentar</button>
					</form>
				</td>
			</tr>
			<?php endforeach ?>
		</table>
	</body>
</html> -->