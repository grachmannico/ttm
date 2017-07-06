  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-list-alt"></i> Kelola Kegiatan
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
              <h3 class="box-title">Data Semua Kegiatan</h3>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nama Kegiatan</th>
                  <th>Status Kegiatan</th>
                  <th>Tanggal Kegiatan</th>
                  <th>Alamat</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data_kegiatan as $dk): ?>
                <tr>
                  <td><?php echo $dk['nama_kegiatan']; ?></td>
                  <td><?php echo $dk['status_kegiatan']; ?></td>
                  <td><?php echo $dk['tanggal_kegiatan']; ?></td>
                  <td><?php echo $dk['alamat']; ?></td>
                  <td>
                    <div class="col-md-12">
                      <div class="col-md-4">
                        <center><form action="<?php echo base_url() . "PPG/edit_kegiatan"; ?>" method="POST">
                          <button type="submit" class="btn btn-warning btn-xs" name="edit" value="<?php echo $dk['id_kegiatan']; ?>"><i class="fa fa-edit"></i> Edit</button>
                        </form></center>
                      </div>
                      <div class="col-md-4">
                        <center><form action="<?php echo base_url() . "PPG/hapus_kegiatan"; ?>" method="POST">
                          <button type="submit" class="btn btn-danger btn-xs" name="hapus" value="<?php echo $dk['id_kegiatan']; ?>"><i class="fa fa-trash"></i> Hapus</button>
                        </form></center>
                      </div>
                      <div class="col-md-4">
                        <center><form action="<?php echo base_url() . "PPG/detail_kegiatan"; ?>" method="POST">
                          <button type="submit" class="btn btn-primary btn-xs" name="kegiatan" value="<?php echo $dk['id_kegiatan']; ?>"><i class="fa fa-file-text"></i> Lihat Detail</button>
                        </form></center>
                      </div>
                    </div>
                    <!-- <form action="<?php echo base_url() . "PPG/edit_kegiatan"; ?>" method="POST">
                      <button type="submit" name="edit" value="<?php echo $dk['id_kegiatan']; ?>">Edit</button>
                    </form> -->
                  <!-- </td>
                  <td> -->
                    <!-- <form action="<?php echo base_url() . "PPG/hapus_kegiatan"; ?>" method="POST">
                      <button type="submit" name="hapus" value="<?php echo $dk['id_kegiatan']; ?>">Hapus</button>
                    </form> -->
                  <!-- </td>
                  <td> -->
                    <!-- <form action="<?php echo base_url() . "PPG/detail_kegiatan"; ?>" method="POST">
                      <button type="submit" name="kegiatan" value="<?php echo $dk['id_kegiatan']; ?>">Lihat Detail</button>
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
      </div>
    </section>
  </div>


<!-- <html>
  <title></title>
  <body>
    <a href="<?php echo base_url() . "PPG/tambah_kegiatan"; ?>">Tambah Kegiatan</a>
    <table border="1">
      <tr>
        <td>nama_kegiatan</td>
        <td>status_kegiatan</td>
        <td>tanggal_kegiatan</td>
        <td>alamat</td>
        <td colspan="3">action</td>
      </tr>
      <?php foreach ($data_kegiatan as $dk): ?>
      <tr>
        <td><?php echo $dk['nama_kegiatan']; ?></td>
        <td><?php echo $dk['status_kegiatan']; ?></td>
        <td><?php echo $dk['tanggal_kegiatan']; ?></td>
        <td><?php echo $dk['alamat']; ?></td>
        <td>
          <form action="<?php echo base_url() . "PPG/edit_kegiatan"; ?>" method="POST">
            <button type="submit" name="edit" value="<?php echo $dk['id_kegiatan']; ?>">Edit</button>
          </form>
        </td>
        <td>
          <form action="<?php echo base_url() . "PPG/hapus_kegiatan"; ?>" method="POST">
            <button type="submit" name="hapus" value="<?php echo $dk['id_kegiatan']; ?>">Hapus</button>
          </form>
        </td>
        <td>
          <form action="<?php echo base_url() . "PPG/detail_kegiatan"; ?>" method="POST">
            <button type="submit" name="kegiatan" value="<?php echo $dk['id_kegiatan']; ?>">Lihat Detail</button>
          </form>
        </td>
      </tr>
      <?php endforeach?>
    </table>
  </body>
</html> -->