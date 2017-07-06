  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-user"></i> Kelola Data Relawan
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
              <h3 class="box-title">Semua Data Relawan</h3>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Divisi</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data_relawan as $dr): ?>
                <tr>
                  <td><?php echo $dr['nama']; ?></td>
                  <td><?php echo $dr['email']; ?></td>
                  <td><?php echo $dr['divisi']; ?></td>
                  <td>
                    <div class="col-md-12">
                      <div class="col-md-4">
                        <center><form action="<?php echo base_url() . "Relawan/edit_relawan"; ?>" method="POST">
                          <button type="submit" class="btn btn-warning btn-xs" name="edit" value="<?php echo $dr['email']; ?>"><i class="fa fa-edit"></i> Edit</button>
                        </form></center>
                      </div>
                      <div class="col-md-4">
                        <center><form action="<?php echo base_url() . "Relawan/hapus_relawan"; ?>" method="POST">
                          <button type="submit" class="btn btn-danger btn-xs" name="hapus" value="<?php echo $dr['email']; ?>"><i class="fa fa-trash"></i> Hapus</button>
                        </form></center>
                      </div>
                      <div class="col-md-4">
                        <center><form action="<?php echo base_url() . "Relawan/detail_relawan"; ?>" method="POST">
                          <button type="submit" class="btn btn-primary btn-xs" name="relawan" value="<?php echo $dr['email']; ?>"><i class="fa fa-file-text"></i> Lihat Detail</button>
                        </form></center>
                      </div>
                    </div>
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
    <a href="<?php echo base_url() . "Relawan/tambah_relawan"; ?>">Tambah Relawan</a><br>
    <table border="1">
      <tr>
        <td>nama</td>
        <td>email</td>
        <td>divisi</td>
        <td colspan="3">action</td>
      </tr>
      <?php foreach ($data_relawan as $dr): ?>
      <tr>
        <td><?php echo $dr['nama']; ?></td>
        <td><?php echo $dr['email']; ?></td>
        <td><?php echo $dr['divisi']; ?></td>
        <td>
          <form action="<?php echo base_url() . "Relawan/edit_relawan"; ?>" method="POST">
            <button type="submit" name="edit" value="<?php echo $dr['email']; ?>">Edit</button>
          </form>
        </td>
        <td>
          <form action="<?php echo base_url() . "Relawan/hapus_relawan"; ?>" method="POST">
            <button type="submit" name="hapus" value="<?php echo $dr['email']; ?>">Hapus</button>
          </form>
        </td>
        <td>
          <form action="<?php echo base_url() . "Relawan/detail_relawan"; ?>" method="POST">
            <button type="submit" name="relawan" value="<?php echo $dr['email']; ?>">Lihat Detail</button>
          </form>
        </td>
      </tr>
      <?php endforeach?>
    </table>
  </body>
</html> -->