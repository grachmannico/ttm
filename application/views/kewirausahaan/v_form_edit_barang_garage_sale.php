  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-edit"></i> Edit Barang Garage Sale
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
              <h3 class="box-title">Form Edit Barang</h3>
            </div>
            <form role="form" action="<?php echo base_url()."Kewirausahaan/edit_barang_garage_sale"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return (Validate(this) && check_form());">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-cube"></i> Nama Barang</label>
                  <input type="text" class="form-control" value="<?php echo $barang[0]['nama_barang']; ?>" name="nama_barang" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-file-text"></i> Deskripsi</label>
                  <textarea id="editor1" name="deskripsi" rows="10" cols="80" required>
                  <?php echo $barang[0]['deskripsi']; ?>
                  </textarea>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-money"></i> Harga</label>
                  <input type="text" class="form-control" value="<?php echo $barang[0]['harga']; ?>" name="harga" id="money" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-cubes"></i> Stok</label>
                  <input type="text" class="form-control" value="<?php echo $barang[0]['stok_available']; ?>" name="stok_available" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-image"></i> Gambar Barang</label><br>
                   <?php if ($barang[0]['gambar_barang'] == ""): ?>
                    No Image<br>
                  <?php endif ?>
                  <?php if ($barang[0]['gambar_barang'] != ""): ?>
                    <img src="<?php echo base_url()."uploads/barang_garage_sale/"; ?><?php echo $barang[0]['gambar_barang']; ?>" alt="" height="300px">
                  <?php endif ?>
                  <!-- <input type="email" class="form-control" value="<?php echo $data_relawan[0]['email']; ?>" name="email" readonly> -->
                  <input name="gambar_barang" size="20" type="file">
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right" name="id_barang_garage_sale" value="<?php echo $barang[0]['id_barang_garage_sale']; ?>"><i class="fa fa-edit"></i> <span>Edit Barang</span></button>
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
		<form action="<?php echo base_url()."Kewirausahaan/edit_barang_garage_sale"; ?>" method="POST" enctype="multipart/form-data">
			nama_barang: <input type="text" name="nama_barang" value="<?php echo $barang[0]['nama_barang']; ?>"><br>
			deskripsi: <input type="text" name="deskripsi" value="<?php echo $barang[0]['deskripsi']; ?>"><br>
			harga: <input type="text" name="harga" value="<?php echo $barang[0]['harga']; ?>"><br>
			stok_available: <input type="text" name="stok_available" value="<?php echo $barang[0]['stok_available']; ?>"><br>
			gambar_barang: <input name="gambar_barang" size="20" type="file"><br>
			<button type="submit" name="id_barang_garage_sale" value="<?php echo $barang[0]['id_barang_garage_sale']; ?>">Edit Barang</button>
		</form>
	</body>
</html> -->