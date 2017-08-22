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
        Dashboard
        <small>Divisi Relawan</small>
      </h1>
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol> -->
    </section>

    
    <section class="content">
      <div class="row">
        
        <div class="col-md-3 col-md-push-1">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $jumlah_donatur[0]['jml_donatur']; ?></h3>

              <p>Donatur</p>
            </div>
            <div class="icon">
              <i class="fa fa-black-tie"></i>
            </div>
            <a href="<?php echo base_url()."Kewirausahaan/mengelola_donatur"; ?>" class="btn btn-info btn-block">
              Lihat Seluruh Relawan <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <div class="col-md-3 col-md-push-1">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $jumlah_donasi_masuk[0]['total_donasi']; ?></h3>

              <p>Donasi Yang Harus Dikonfirmasi</p>
            </div>
            <div class="icon">
              <i class="fa fa-heart"></i>
            </div>
            <a href="<?php echo base_url()."Kewirausahaan/mengelola_donasi"; ?>" class="btn btn-info btn-block">
              Lihat Detail Donasi <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <div class="col-md-3 col-md-push-1">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $jumlah_pembayaran[0]['jml_pembayaran']; ?></h3>

              <p>Pembayaran Yang Harus Dikonfirmasi</p>
            </div>
            <div class="icon">
              <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="<?php echo base_url()."Kewirausahaan/validasi_pembelian"; ?>" class="btn btn-info btn-block">
              Lihat Detail Pembayaran <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        

        <!-- <div class="clearfix visible-sm-block"></div> -->
      </div>

      <div class="row">
        <div class="col-md-9 col-md-push-1">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Donasi Yang Masuk</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th><center>Tanggal</center></th>
                    <th><center>Nama</center></th>
                    <th><center>Kegiatan</center></th>
                    <th><center>Nominal</center></th>
                  </tr>
                  </thead>
                  <tbody>  
                  <?php foreach ($transaksi_donasi_masuk as $t): ?>
                  <tr>
                    <td><?php echo tanggal_indo($t['tanggal_donasi']); ?></td>
                    <td><?php echo $t['nama']; ?></td>
                    <td><?php echo $t['nama_kegiatan']; ?></td>
                    <td><?php echo "Rp. " . number_format($t['nominal_donasi'], 2, ",", "."); ?></td>
                  </tr>
                  <?php endforeach ?>                
                  </tbody>
                </table>
              </div>
            </div>
            <div class="box-footer clearfix">
              <?php if (empty($transaksi_donasi_masuk)): ?>
              <p class="label label-danger pull-left">Tidak Ada Donasi Yang Masuk</p>
              <?php endif ?>
              <!-- <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a> -->
              <a href="<?php echo base_url()."Kewirausahaan/mengelola_donasi"; ?>" class="btn btn-sm btn-success btn-flat pull-right">Lihat Detail</a>
            </div>
          </div>
        </div>

        <!-- <div class="col-md-4">
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="ion ion-ios-heart-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Mentions</span>
              <span class="info-box-number">92,050</span>

              <div class="progress">
                <div class="progress-bar" style="width: 20%"></div>
              </div>
                  <span class="progress-description">
                    20% Increase in 30 Days
                  </span>
            </div>
          </div>
        </div> -->
      </div>
    </section>

  </div>


<!-- <html>
	<title></title>
	<body>
		<a href="<?php echo base_url()."Kewirausahaan/mengelola_garage_sale"; ?>">Mengelola Garage Sale</a><br>
		<a href="<?php echo base_url()."Kewirausahaan/mengelola_donasi"; ?>">Mengelola Donasi</a><br>
		<a href="<?php echo base_url()."Kewirausahaan/mengelola_donatur"; ?>">Mengelola Donatur</a><br>
		<a href="<?php echo base_url()."Kewirausahaan/mengelola_lpj"; ?>">Mengelola Laporan Pengeluaran Kegiatan</a>
	</body>
</html> -->