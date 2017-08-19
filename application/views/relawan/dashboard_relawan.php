  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Dashboard
        <small>Version 2.0</small>
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
              <h3><?php echo $jml_relawan[0]['jml_relawan']; ?></h3>

              <p>Jumlah Relawan Saat Ini</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="<?php echo base_url()."Relawan/mengelola_data_relawan"; ?>" class="btn btn-info btn-block">
              Lihat Seluruh Relawan <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $jml_absen[0]['jml_kegiatan']; ?></h3>

              <p>Form Absensi</p>
            </div>
            <div class="icon">
              <i class="fa fa-heart"></i>
            </div>
            <a href="<?php echo base_url()."Relawan/mengelola_absensi"; ?>" class="btn btn-info btn-block">
              Lihat From Absensi <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- <div class="clearfix visible-sm-block"></div> -->

        <div class="col-md-4">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $jml_volunteer[0]['jml_relawan']; ?></h3>

              <p>Volunteer</p>
            </div>
            <div class="icon">
              <i class="fa fa-user-plus"></i>
            </div>
            <form action="<?php echo base_url()."Relawan/mengelola_data_relawan"; ?>" method="POST">
              <button class="btn btn-info btn-block" name="divisi" value="1 and r.id_pangkat_divisi = 6">
                Lihat Volunteer <i class="fa fa-arrow-circle-right"></i>
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- <div class="row">
        <div class="col-md-4">
          <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="ion-ios-chatbubble-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Direct Messages</span>
              <span class="info-box-number">163,921</span>

              <div class="progress">
                <div class="progress-bar" style="width: 40%"></div>
              </div>
                  <span class="progress-description">
                    40% Increase in 30 Days
                  </span>
            </div>
          </div>
        </div>
      </div> -->
    </section>
  </div>


<!-- <html>
	<title></title>
	<body>
		<h3>Dashboard Divisi Relawan</h3>
		<a href="<?php echo base_url()."Relawan/mengelola_absensi"; ?>">Mengelola Absensi</a><br>
		<a href="<?php echo base_url()."Relawan/mengelola_data_relawan"; ?>">Mengelola Data Relawan</a><br>
	</body>
</html> -->