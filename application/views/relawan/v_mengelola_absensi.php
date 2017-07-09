  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-check-square"></i> Kelola Absensi
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
              <h3 class="box-title">Data Kegiatan untuk dilakukan Absensi</h3>
            </div>
            <div class="box-body">
              <form action="<?php echo base_url() . "Relawan/list_relawan"; ?>" method="POST">
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th><center>Nama Kegiatan</center></th>
                      <th><center>Jumlah Relawan</center></th>
                      <th><center>Action</center></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data_kegiatan as $dk): ?>
                    <tr>
                      <td><?php echo $dk['nama_kegiatan']; ?></td>
                      <td><?php echo $dk['jumlah_relawan']; ?></td>
                      <td><center><button type="submit" class="btn btn-primary btn-xs" name="id_kegiatan" value="<?php echo $dk['id_kegiatan']; ?>"><i class="fa fa-check-square"></i> Lakukan Absensi</button></center></td>
                    </tr>
                    <?php endforeach?>
                    </tfoot>
                  </table>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<!-- <html>
  <title></title>
  <body>
    <form action="<?php echo base_url() . "Relawan/list_relawan"; ?>" method="POST">
      <table border="1">
        <tr>
          <td>nama_kegiatan</td>
          <td>jumlah_relawan</td>
          <td>action</td>
        </tr>
        <?php foreach ($data_kegiatan as $dk): ?>
        <tr>
          <td><?php echo $dk['nama_kegiatan']; ?></td>
          <td><?php echo $dk['jumlah_relawan']; ?></td>
          <td><button type="submit" name="id_kegiatan" value="<?php echo $dk['id_kegiatan']; ?>">Lakukan Absensi</button></td>
        </tr>
        <?php endforeach?>
      </table>
    </form>
  </body>
</html> -->