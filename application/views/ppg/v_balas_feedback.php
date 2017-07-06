  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-comments"></i> Feedback
        <small></small>
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
              <h3 class="box-title">Balasan Feedback</h3>
            </div>
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <tr>
                  <td>Nama</td>
                  <td><?php echo $feedback[0]['nama']; ?> (<?php echo $feedback[0]['email']; ?>)</td>
                </tr>
                <tr>
                  <td>Komentar</td>
                  <td><?php echo $feedback[0]['komentar']; ?></td>
                </tr>
              </table>
              <hr>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>email</th>
                  <th>nama</th>
                  <th>komentar</th>
                </tr>
                </thead>
                <tbody>
                  <?php foreach ($balas_feedback as $b): ?>
                  <tr>
                    <td><?php echo $b['email']; ?></td>
                    <td><?php echo $b['nama']; ?></td>
                    <td><?php echo $b['komentar']; ?></td>
                  </tr>
                  <?php endforeach?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div  class="col-md-6">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Balas Feedback</h3>
            </div>
            <form role="form" action="<?php echo base_url()."PPG/balas_feedback"; ?>" method="POST">
              <input type="hidden" name="id_feedback_kegiatan" value="<?php echo $id_feedback_kegiatan ?>">
              <input type="hidden" name="email" value="<?php echo $email; ?>">
              <input type="hidden" name="nama" value="<?php echo $nama; ?>">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-comments"></i> Balas Feedback</label>
                  <textarea id="editor1" name="komentar" rows="10" cols="80">
                  
                  </textarea>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-comments"></i> <span>Balas Feedback</span></button>
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
		<table border="1">
			<tr>
				<td>email</td>
				<td>nama</td>
				<td>komentar</td>
			</tr>
			<tr>
				<td><?php echo $feedback[0]['email'] ?></td>
				<td><?php echo $feedback[0]['nama'] ?></td>
				<td><?php echo $feedback[0]['komentar']; ?></td>
			</tr>
			<?php foreach ($balas_feedback as $b): ?>
			<tr>
				<td><?php echo $b['nama']; ?></td>
				<td><?php echo $b['nama']; ?></td>
				<td><?php echo $b['komentar']; ?></td>
			</tr>
			<?php endforeach ?>
		</table>
		<hr>
		<form action="<?php echo base_url()."PPG/balas_feedback"; ?>" method="POST">
			<input type="text" name="id_feedback_kegiatan" value="<?php echo $id_feedback_kegiatan ?>"><br>
			<input type="text" name="email" value="<?php echo $email; ?>"><br>
			<input type="text" name="nama" value="<?php echo $nama; ?>"><br>
			<textarea name="komentar" id="" cols="30" rows="10"></textarea><br>
			<button type="submit">Balas Feedback</button>
		</form>
	</body>
</html> -->