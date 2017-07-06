  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-edit"></i> Edit Donatur
      </h1>
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol> -->
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-8 col-md-push-2">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Form Edit Data Donatur</h3>
            </div>
            <form role="form" action="<?php echo base_url()."Kewirausahaan/edit_donatur"; ?>" method="POST">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-envelope"></i> Email</label>
                  <input type="email" class="form-control" value="<?php echo $data_donatur[0]['email']; ?>" name="email" readonly>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-user"></i> Nama</label>
                  <input type="text" class="form-control" value="<?php echo $data_donatur[0]['nama']; ?>" name="nama" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-lock"></i> Password</label>
                  <input type="password" class="form-control" value="<?php echo $data_donatur[0]['pass']; ?>" name="pass" required>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-edit"></i> <span>Edit Donatur</span></button>
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
		<form action="<?php echo base_url()."Kewirausahaan/edit_donatur"; ?>" method="POST">
			email: <input type="email" name="email" value="<?php echo $data_donatur[0]['email']; ?>"><br>
			nama: <input type="text" name="nama" value="<?php echo $data_donatur[0]['nama']; ?>"><br>
			password: <input type="password" name="pass" value="<?php echo $data_donatur[0]['pass']; ?>"><br>
			<button type="submit">Edit Donatur</button>
		</form>
	</body>
</html> -->