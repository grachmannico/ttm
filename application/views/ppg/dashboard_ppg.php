<?php echo $d['map']['js'];?>

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Dashboard
        <small>Divisi Penelitian Pengembangan dan Gerakan</small>
      </h1>
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol> -->
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-4">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $akan[0]['jml_kegiatan']; ?></h3>

              <p>Kegiatan Yang Akan Dilaksanakan</p>
            </div>
            <div class="icon">
              <i class="fa fa-hourglass-1"></i>
            </div>
            <form action="<?php echo base_url()."PPG/mengelola_kegiatan"; ?>" method="POST">
              <button class="btn btn-info btn-block" name="id_status_kegiatan" value="1">
                Lihat Kegiatan <i class="fa fa-arrow-circle-right"></i>
              </button>
            </form>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $sedang[0]['jml_kegiatan']; ?></h3>

              <p>Kegiatan Yang Sedang Dilaksanakan</p>
            </div>
            <div class="icon">
              <i class="fa fa-hourglass-2"></i>
            </div>
            <form action="<?php echo base_url()."PPG/mengelola_kegiatan"; ?>" method="POST">
              <button class="btn btn-info btn-block" name="id_status_kegiatan" value="2">
                Lihat Kegiatan <i class="fa fa-arrow-circle-right"></i>
              </button>
            </form>
          </div>
        </div>

        <!-- <div class="clearfix visible-sm-block"></div> -->

        <div class="col-md-4">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $selesai[0]['jml_kegiatan']; ?></h3>

              <p>Kegiatan Yang Selesai Dilaksanakan</p>
            </div>
            <div class="icon">
              <i class="fa fa-hourglass-3"></i>
            </div>
            <form action="<?php echo base_url()."PPG/mengelola_kegiatan"; ?>" method="POST">
              <button class="btn btn-info btn-block" name="id_status_kegiatan" value="3">
                Lihat Kegiatan <i class="fa fa-arrow-circle-right"></i>
              </button>
            </form>
          </div>
        </div>
      </div>

      <div class="row">

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
        <div class="col-md-10 col-md-push-1">
          <div class="callout callout-success">
            <h4><i class="fa fa-map"></i> Kegiatan Turun Tangan Malang</h4>
            <p>Lokasi/Tempat Dilaksanakannya Kegiatan Turun Tangan Malang</p>
          </div>
          <?php echo $d['map']['html'];?>
        </div>
      </div>
    </section>
  </div>


<!-- <html>
	<title></title>
	<body>
		<a href="<?php echo base_url()."PPG/mengelola_kegiatan"; ?>">Mengelola Kegiatan</a><br>
		<a href="<?php echo base_url()."PPG/mengelola_feedback"; ?>">Mengelola Feedback</a>
	</body>
</html> -->