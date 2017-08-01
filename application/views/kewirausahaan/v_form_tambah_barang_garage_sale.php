  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-plus-square"></i> Tambah Barang Garage Sale
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
              <h3 class="box-title">Form Tambah Barang</h3>
            </div>
            <form role="form" action="<?php echo base_url()."Kewirausahaan/tambah_barang_garage_sale"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return (Validate(this) && check_form());">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-cube"></i> Nama Barang</label>
                  <input type="text" class="form-control" placeholder="Nama Barang" name="nama_barang" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-file-text"></i> Deskripsi</label>
                  <textarea id="editor1" name="deskripsi" rows="10" cols="80" required>
                  
                  </textarea>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-money"></i> Harga</label>
                  <input type="text" class="form-control" placeholder="Harga" name="harga" id="money" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-cubes"></i> Stok</label>
                  <input type="text" class="form-control" placeholder="Stok" name="stok_available" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-image"></i> Gambar Barang</label>
                  <!-- <input type="email" class="form-control" value="<?php echo $data_relawan[0]['email']; ?>" name="email" readonly> -->
                  <input name="gambar_barang" size="20" type="file" required>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-plus-square"></i> <span>Tambah Barang</span></button>
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
		<form action="<?php echo base_url()."Kewirausahaan/tambah_barang_garage_sale"; ?>" method="POST" enctype="multipart/form-data">
			nama_barang: <input type="text" name="nama_barang" placeholder="nama_barang"><br>
			deskripsi: <input type="text" name="deskripsi" placeholder="deskripsi"><br>
			harga: <input type="text" name="harga" placeholder="harga"><br>
			stok_available: <input type="text" name="stok_available" placeholder="stok_available"><br>
			gambar_barang: <input name="gambar_barang" size="20" type="file"><br>
			<button type="submit">Tambah Barang</button>
		</form>
	</body>
</html> -->