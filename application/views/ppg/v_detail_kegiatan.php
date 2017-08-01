<?php echo $d['map']['js'];?>

<script>
update_address(<?=$d['lat'];?>,<?=$d['lng'];?>); //Set terlebih dahulu alamat lokasi pusat
function showmap()
{           
  var place = placesAutocomplete.getPlace(); //Inisialkan auto complete atau pencarian
  if (!place.geometry) //Jika hasil tidak ada
  {
    return; //Abaikan
  }
  var lat = place.geometry.location.lat(), // Ambil Posisi Latitude Auto Complete
  lng = place.geometry.location.lng(); // Ambil Posisi Longitude Auto Complete
  document.getElementById('lat').value=lat; //Set Latitude pada input lat
  document.getElementById('lng').value=lng; //Set Longitude pada input lng
  var map = new google.maps.Map(document.getElementById('map-canvas'), { //Refresh alamat
      center: {lat: lat, lng: lng},
      zoom: 17
    });
    placesAutocomplete.bindTo('bounds', map); //Render Map Auto Complete
    
    //Tambah penandaan pada alamat
    var marker = new google.maps.Marker({
      map: map,
      draggable: true,
    title: "Drag Untuk mencari posisi",
      anchorPoint: new google.maps.Point(0, -29)
    });
    
  if (place.geometry.viewport) {
        map.fitBounds(place.geometry.viewport);
      } else {
        map.setCenter(place.geometry.location);
        map.setZoom(17);
  }
    marker.setPosition(place.geometry.location);    
    marker_0 = createMarker_map(marker);
    
    var alamat=document.getElementById('cari');
      google.maps.event.addListener(marker_0, "dragend", function(event) {
        document.getElementById('lat').value = event.latLng.lat();
          document.getElementById('lng').value = event.latLng.lng();
          update_address(event.latLng.lat(),event.latLng.lng());          
      });
}

//Fungsi mendapatkan alamat disaat drag marker
function update_address(lat,lng)
{
  var geocoder = new google.maps.Geocoder;
  var latlng={lat: parseFloat(lat), lng: parseFloat(lng)};
  geocoder.geocode({'location': latlng}, function(results, status) {
    if (status === google.maps.GeocoderStatus.OK) {
      if (results[1]) {         
        document.getElementById('cari').value=results[0].formatted_address;
      } else {
        window.alert('Tidak ada hasil pencarian');
      }
    } else {
      window.alert('Geocoder error: ' + status);
    }
  });
}
</script>

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-list-alt"></i> Data Kegiatan
      </h1>
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol> -->
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-10 col-md-push-1">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Detail Kegiatan</a></li>
              <li><a href="#tab_2" data-toggle="tab">Dokumentasi Kegiatan</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <div class="box box-danger">
                  <div class="box-header with-border">
                    <h3 class="box-title">Detail Kegiatan</h3>
                  </div>
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-list-alt"></i> Nama Kegiatan</label>
                      <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['nama_kegiatan']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-info"></i> Status Kegiatan</label>
                      <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['status_kegiatan']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-comment"></i> Pesan Ajakan</label>
                      <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['pesan_ajakan']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-file-text"></i> Deskripsi Kegiatan</label><br>
                      <?php echo $detail_kegiatan[0]['deskripsi_kegiatan']; ?>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-users"></i> Jumlah Relawan</label>
                      <input type="text" class="form-control" value="<?php echo $jumlah_relawan[0]['jumlah_relawan']; ?> / <?php echo $detail_kegiatan[0]['minimal_relawan']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-heart"></i> Jumlah Donasi</label>
                      <?php if (empty($jumlah_donasi)): ?>
                      <input type="text" class="form-control" value="0 / <?php echo $detail_kegiatan[0]['minimal_donasi']; ?>" readonly>
                      <?php endif ?>
                      <?php if (!empty($jumlah_donasi)): ?>
                      <input type="text" class="form-control" value="<?php echo $jumlah_donasi[0]['jumlah_donasi']; ?> / <?php echo $detail_kegiatan[0]['minimal_donasi']; ?>" readonly>
                      <?php endif ?>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-calendar-check-o"></i> Tanggal Kegiatan</label>
                      <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['tanggal_kegiatan']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-calendar-times-o"></i> Batas Akhir Pendaftaran</label>
                      <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['batas_akhir_pendaftaran']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-compass"></i> Alamat</label>
                      <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['alamat']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-map"></i> Lokasi</label>
                      <?php echo $d['map']['html'];?>
                    </div>
                    <!-- <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-map-marker"></i> Lat</label>
                      <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['lat']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-map-marker"></i> Lng</label>
                      <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['lng']; ?>" readonly>
                    </div> -->
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-image"></i> Banner Kegiatan</label><br>
                      <?php if ($detail_kegiatan[0]['banner'] == ""): ?>
                        No Image<br>
                      <?php endif ?>
                      <?php if ($detail_kegiatan[0]['banner'] != ""): ?>
                        <img src="<?php echo base_url()."uploads/gambar_kegiatan/"; ?><?php echo $detail_kegiatan[0]['banner']; ?>" alt="" width="500px">
                      <?php endif ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="tab_2">
                <div class="box box-danger">
                  <div class="box-header with-border">
                    <h3 class="box-title">Dokumentasi Kegiatan</h3>
                  </div>
                  <div class="box-body">
                    <div class="form-group">
                      
                      <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Gambar Kegiatan</th>
                          <th>Deskripsi</th>
                          <th>Tanggal</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($dokumentasi as $d): ?>
                        <tr>
                          <td><img src="<?php echo base_url()."uploads/dokumentasi/"; ?><?php echo $d['gambar_dokumentasi']; ?>" alt="" width="150px"></td>
                          <td><?php echo $d['deskripsi']; ?></td>
                          <td><?php echo $d['tanggal']; ?></td>
                        </tr>
                        <?php endforeach?>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- <div class="col-md-6">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Detail Kegiatan</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-list-alt"></i> Nama Kegiatan</label>
                <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['nama_kegiatan']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-info"></i> Status Kegiatan</label>
                <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['status_kegiatan']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-comment"></i> Pesan Ajakan</label>
                <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['pesan_ajakan']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-file-text"></i> Deskripsi Kegiatan</label><br>
                <?php echo $detail_kegiatan[0]['deskripsi_kegiatan']; ?>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-users"></i> Jumlah Relawan</label>
                <input type="text" class="form-control" value="<?php echo $jumlah_relawan[0]['jumlah_relawan']; ?> / <?php echo $detail_kegiatan[0]['minimal_relawan']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-heart"></i> Jumlah Donasi</label>
                <?php if (empty($jumlah_donasi)): ?>
                <input type="text" class="form-control" value="0 / <?php echo $detail_kegiatan[0]['minimal_donasi']; ?>" readonly>
                <?php endif ?>
                <?php if (!empty($jumlah_donasi)): ?>
                <input type="text" class="form-control" value="<?php echo $jumlah_donasi[0]['jumlah_donasi']; ?> / <?php echo $detail_kegiatan[0]['minimal_donasi']; ?>" readonly>
                <?php endif ?>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-calendar-check-o"></i> Tanggal Kegiatan</label>
                <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['tanggal_kegiatan']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-calendar-times-o"></i> Batas Akhir Pendaftaran</label>
                <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['batas_akhir_pendaftaran']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-compass"></i> Alamat</label>
                <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['alamat']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-map-marker"></i> Lat</label>
                <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['lat']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-map-marker"></i> Lng</label>
                <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['lng']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1"><i class="fa fa-image"></i> Banner Kegiatan</label><br>
                <?php if ($detail_kegiatan[0]['banner'] == ""): ?>
                  No Image<br>
                <?php endif ?>
                <?php if ($detail_kegiatan[0]['banner'] != ""): ?>
                  <img src="<?php echo base_url()."uploads/gambar_kegiatan/"; ?><?php echo $detail_kegiatan[0]['banner']; ?>" alt="" width="500px">
                <?php endif ?>
              </div>
            </div>
          </div>
        </div> -->
        <!-- <div class="col-md-6">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Dokumentasi Kegiatan</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Gambar Kegiatan</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($dokumentasi as $d): ?>
                  <tr>
                    <td><img src="<?php echo base_url()."uploads/dokumentasi/"; ?><?php echo $d['gambar_kegiatan']; ?>" alt="" width="150px"></td>
                    <td><?php echo $d['deskripsi']; ?></td>
                    <td><?php echo $d['tanggal']; ?></td>
                  </tr>
                  <?php endforeach?>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div> -->
      </div>
    </section>
  </div>


<!-- <html>
	<title></title>
	<body>
		nama kegiatan: <?php echo $detail_kegiatan[0]['nama_kegiatan']; ?><br>
		status kegiatan: <?php echo $detail_kegiatan[0]['status_kegiatan']; ?><br>
		pesan ajakan: <?php echo $detail_kegiatan[0]['pesan_ajakan']; ?><br>
		deskripsi kegiatan: <?php echo $detail_kegiatan[0]['deskripsi_kegiatan']; ?><br>
		jumlah relawan: <?php echo $jumlah_relawan[0]['jumlah_relawan']; ?> / <?php echo $detail_kegiatan[0]['minimal_relawan']; ?><br>
		jumlah donasi: 
		<?php if (empty($jumlah_donasi)): ?>
			0 / <?php echo $detail_kegiatan[0]['minimal_donasi']; ?><br>
		<?php endif ?>
		<?php if (!empty($jumlah_donasi)): ?>
			<?php echo $jumlah_donasi[0]['jumlah_donasi']; ?> / <?php echo $detail_kegiatan[0]['minimal_donasi']; ?><br>
		<?php endif ?>
		tanggal kegiatan: <?php echo $detail_kegiatan[0]['tanggal_kegiatan']; ?><br>
		batas akhir pendaftaran: <?php echo $detail_kegiatan[0]['batas_akhir_pendaftaran']; ?><br>
		alamat: <?php echo $detail_kegiatan[0]['alamat']; ?><br>
		lat: <?php echo $detail_kegiatan[0]['lat']; ?><br>
		lng: <?php echo $detail_kegiatan[0]['lng']; ?><br>
		<?php if ($detail_kegiatan[0]['banner'] == ""): ?>
			No Image<br>
		<?php endif ?>
		<?php if ($detail_kegiatan[0]['banner'] != ""): ?>
			<img src="<?php echo base_url()."uploads/gambar_kegiatan/"; ?><?php echo $detail_kegiatan[0]['banner']; ?>" alt="" height="30%">
		<?php endif ?>
		<hr>
		<table border="1">
			<tr>
				<td>gambar kegiatan</td>
				<td>deskripsi</td>
				<td>tanggal</td>
			</tr>
			<?php foreach ($dokumentasi as $d): ?>
			<tr>
				<td><img src="<?php echo base_url()."uploads/dokumentasi/"; ?><?php echo $d['gambar_kegiatan']; ?>" alt="" width="300px"></td>
				<td><?php echo $d['deskripsi']; ?></td>
				<td><?php echo $d['tanggal']; ?></td>
			</tr>
			<?php endforeach ?>
		</table>
	</body>
</html> -->