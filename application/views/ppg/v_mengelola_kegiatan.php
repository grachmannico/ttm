<?php
function tanggal_indo($tanggal)
{
    $bulan = array(1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    );
    $split = explode('-', $tanggal);
    return $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];
}
?>
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
              <h3 class="box-title">Data Semua Kegiatan</h3><a href="<?php echo base_url()."PPG/tambah_kegiatan"; ?>" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Tambah Data Kegiatan</a>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <form action="<?php echo base_url()."PPG/mengelola_kegiatan"; ?>" method="POST">
                  Tampilkan Kegiatan: 
                  <select class="form-control" name="id_status_kegiatan">
                    <option value="" selected>Semua Kegiatan</option>
                    <option value="1">Promosi Kegiatan</option>
                    <option value="2">Kegiatan Sedang Berjalan</option>
                    <option value="3">Kegiatan Selesai Berjalan</option>
                  </select>
                  <button type="submit" class="btn btn-danger">Cari</button>
                </form>
                <br>
                <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><center>Nama Kegiatan</center></th>
                  <th><center>Status Kegiatan</center></th>
                  <th><center>Tanggal Kegiatan</center></th>
                  <th><center>Alamat</center></th>
                  <th><center>Action</center></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data_kegiatan as $dk): ?>
                <tr>
                  <td><?php echo $dk['nama_kegiatan']; ?></td>
                  <td><?php echo $dk['status_kegiatan']; ?></td>
                  <!-- <td><?php echo $dk['tanggal_kegiatan']; ?></td> -->
                  <?php if ($dk['tanggal_kegiatan_mulai'] == $dk['tanggal_kegiatan_berakhir']): ?>
                    <td><?php echo tanggal_indo($dk['tanggal_kegiatan_mulai']); ?></td>
                  <?php endif ?>
                  <?php if ($dk['tanggal_kegiatan_mulai'] != $dk['tanggal_kegiatan_berakhir']): ?>
                    <td><?php echo tanggal_indo($dk['tanggal_kegiatan_mulai']); ?> - <?php echo tanggal_indo($dk['tanggal_kegiatan_berakhir']); ?></td>
                  <?php endif ?>
                  <td><?php echo $dk['alamat']; ?></td>
                  <td>
                    <div class="col-md-12">
                      <div class="col-md-3">
                        <center><form action="<?php echo base_url() . "PPG/edit_kegiatan"; ?>" method="POST">
                          <button type="submit" class="btn btn-warning btn-xs" name="edit" value="<?php echo $dk['id_kegiatan']; ?>"><i class="fa fa-edit"></i> Edit</button>
                        </form></center>
                      </div>
                      <div class="col-md-3">
                        <center><form action="<?php echo base_url() . "PPG/hapus_kegiatan"; ?>" method="POST">
                          <button type="submit" class="btn btn-danger btn-xs" name="hapus" value="<?php echo $dk['id_kegiatan']; ?>" onclick="return checkDelete()"><i class="fa fa-trash"></i> Hapus</button>
                        </form></center>
                      </div>
                      <div class="col-md-3">
                        <center><form action="<?php echo base_url() . "PPG/detail_kegiatan"; ?>" method="POST">
                          <button type="submit" class="btn btn-primary btn-xs" name="kegiatan" value="<?php echo $dk['id_kegiatan']; ?>"><i class="fa fa-file-text"></i> Lihat Detail</button>
                        </form></center>
                      </div>
                      <div class="col-md-3">
                        <center><form action="<?php echo base_url() . "PPG/tambah_dokumentasi_kegiatan"; ?>" method="POST">
                          <button type="submit" class="btn btn-primary btn-xs" name="dokumentasi" value="<?php echo $dk['id_kegiatan']; ?>"><i class="fa fa-plus-square"></i> Dokumentasi</button>
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