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
          <div class="box">
            <div class="box-header">
              <!-- <h3 class="box-title">Data Table With Full Features</h3> -->
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
                  <!-- </td>
                  <td> -->
                    <!-- <form action="<?php echo base_url()."PPG/lihat_balasan_feedback"; ?>" method="POST">
                      <button type="sumbit" name="lihat" value="<?php echo $f['id_feedback_kegiatan']; ?>">Lihat Komentar</button>
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