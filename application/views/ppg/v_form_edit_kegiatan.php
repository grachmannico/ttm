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
        <i class="fa fa-edit"></i> Edit Kegiatan
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
              <h3 class="box-title">Form Edit Kegiatan</h3>
            </div>
            <form role="form" action="<?php echo base_url()."PPG/edit_kegiatan"; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-list-alt"></i> Nama Kegiatan</label>
                  <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['nama_kegiatan']; ?>" name="nama_kegiatan" required>
                </div>
                <div class="form-group">
                  <label><i class="fa fa-info"></i> Status Kegiatan</label>
                  <select class="form-control" name="id_status_kegiatan">
                    <?php if ($detail_kegiatan[0]['id_status_kegiatan'] == 1): ?>
                      <option value="1" selected>Promosi Kegiatan</option>
                      <option value="2">Kegiatan Sedang Berjalan</option>
                      <option value="3">Kegiatan Selesai Berjalan</option>
                    <?php endif ?>
                    <?php if ($detail_kegiatan[0]['id_status_kegiatan'] == 2): ?>
                      <option value="1">Promosi Kegiatan</option>
                      <option value="2" selected>Kegiatan Sedang Berjalan</option>
                      <option value="3">Kegiatan Selesai Berjalan</option>
                    <?php endif ?>
                    <?php if ($detail_kegiatan[0]['id_status_kegiatan'] == 3): ?>
                      <option value="1">Promosi Kegiatan</option>
                      <option value="2">Kegiatan Sedang Berjalan</option>
                      <option value="3" selected>Kegiatan Selesai Berjalan</option>
                    <?php endif ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-comment"></i> Pesan Ajakan</label>
                  <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['pesan_ajakan']; ?>" name="pesan_ajakan" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-file-text"></i> Deskripsi</label>
                  <textarea id="editor1" name="deskripsi_kegiatan" rows="10" cols="80" required>
                  <?php echo $detail_kegiatan[0]['deskripsi_kegiatan']; ?>
                  </textarea>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-users"></i> Minimal Relawan</label>
                  <input type="number" class="form-control" value="<?php echo $detail_kegiatan[0]['minimal_relawan']; ?>" name="minimal_relawan" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-heart"></i> Minimal Donasi</label>
                  <input type="number" class="form-control" value="<?php echo $detail_kegiatan[0]['minimal_donasi']; ?>" name="minimal_donasi" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-calendar-check-o"></i> Tanggal kegiatan</label>
                  <!-- <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['tanggal_kegiatan']; ?>" name="tanggal_kegiatan" required> -->
                  <input type="text" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask id="datemask" value="<?php echo $detail_kegiatan[0]['tanggal_kegiatan']; ?>" name="tanggal_kegiatan" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-calendar-times-o"></i> Batas Akhir Pendaftaran</label>
                  <!-- <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['batas_akhir_pendaftaran']; ?>" name="batas_akhir_pendaftaran" required> -->
                  <input type="text" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask id="datemask2" value="<?php echo $detail_kegiatan[0]['batas_akhir_pendaftaran']; ?>" name="batas_akhir_pendaftaran" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-compass"></i> Alamat</label>
                  <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['alamat']; ?>" name="alamat" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-map"></i> Cari Lokasi</label>
                  <input type="text" id="cari" class="form-control" placeholder="Cari Alamat atau Tempat"/>
                  <?php echo $d['map']['html'];?>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1"><i class="fa fa-map-marker"></i> Lat</label>
                    <input type="text" id="lat" class="form-control" placeholder="Latitude" value="<?=$d['lat'];?>" name="lat" readonly/>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1"><i class="fa fa-map-marker"></i> Lng</label>
                    <input type="text" id="lng" class="form-control" placeholder="Longitude" value="<?=$d['lng'];?>" name="lng" readonly/>
                  </div>
                </div>
                <!-- <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-map-marker"></i> Lat</label>
                  <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['lat']; ?>" name="lat" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-map-marker"></i> Lng</label>
                  <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['lng']; ?>" name="lng" required>
                </div> -->
                <div class="form-group">
                  <label for="exampleInputEmail1"><i class="fa fa-image"></i> Banner Kegiatan</label><br>
                  <!-- <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['lng']; ?>" name="lng" required> -->
                  <?php if ($detail_kegiatan[0]['banner'] == ""): ?>
                    No Image<br>
                  <?php endif ?>
                  <?php if ($detail_kegiatan[0]['banner'] != ""): ?>
                    <img src="<?php echo base_url()."uploads/gambar_kegiatan/"; ?><?php echo $detail_kegiatan[0]['banner']; ?>" alt="" height="300px">
                  <?php endif ?>
                  <input name="banner" size="20" type="file">
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right" name="id_kegiatan" value="<?php echo $detail_kegiatan[0]['id_kegiatan']; ?>"><i class="fa fa-edit"></i> <span>Edit Kegiatan</span></button>
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
		<form action="<?php echo base_url()."PPG/edit_kegiatan"; ?>" method="POST" enctype="multipart/form-data">
			nama kegiatan: <input type="text" name="nama_kegiatan" value="<?php echo $detail_kegiatan[0]['nama_kegiatan']; ?>"><br>
			status kegiatan: <select name="id_status_kegiatan">
			<?php if ($detail_kegiatan[0]['id_status_kegiatan'] == 1): ?>
				<option value="1" selected>Promosi Kegiatan</option>
				<option value="2">Kegiatan Sedang Berjalan</option>
				<option value="3">Kegiatan Selesai Berjalan</option>
			<?php endif ?>
			<?php if ($detail_kegiatan[0]['id_status_kegiatan'] == 2): ?>
				<option value="1">Promosi Kegiatan</option>
				<option value="2" selected>Kegiatan Sedang Berjalan</option>
				<option value="3">Kegiatan Selesai Berjalan</option>
			<?php endif ?>
			<?php if ($detail_kegiatan[0]['id_status_kegiatan'] == 3): ?>
				<option value="1">Promosi Kegiatan</option>
				<option value="2">Kegiatan Sedang Berjalan</option>
				<option value="3" selected>Kegiatan Selesai Berjalan</option>
			<?php endif ?>
			</select><br>
			pesan ajakan: <input type="text" name="pesan_ajakan" value="<?php echo $detail_kegiatan[0]['pesan_ajakan']; ?>"><br>
			deskripsi kegiatan: <textarea name="deskripsi_kegiatan" id="" cols="30" rows="10"><?php echo $detail_kegiatan[0]['deskripsi_kegiatan']; ?></textarea><br>
			minimal relawan: <input type="text" name="minimal_relawan" value="<?php echo $detail_kegiatan[0]['minimal_relawan']; ?>"><br>
			minimal donasi: <input type="text" name="minimal_donasi" value="<?php echo $detail_kegiatan[0]['minimal_donasi']; ?>"><br>
			tanggal kegiatan: <input type="text" name="tanggal_kegiatan" value="<?php echo $detail_kegiatan[0]['tanggal_kegiatan']; ?>"><br>
			batas akhir pendaftaran: <input type="text" name="batas_akhir_pendaftaran" value="<?php echo $detail_kegiatan[0]['batas_akhir_pendaftaran']; ?>"><br>
			alamat: <input type="text" name="alamat" value="<?php echo $detail_kegiatan[0]['alamat']; ?>"><br>
			lat: <input type="text" name="lat" value="<?php echo $detail_kegiatan[0]['lat']; ?>"><br>
			lng: <input type="text" name="lng" value="<?php echo $detail_kegiatan[0]['lng']; ?>"><br>
			<?php if ($detail_kegiatan[0]['banner'] == ""): ?>
				No Image<br>
			<?php endif ?>
			<?php if ($detail_kegiatan[0]['banner'] != ""): ?>
				<img src="<?php echo base_url()."uploads/gambar_kegiatan/"; ?><?php echo $detail_kegiatan[0]['banner']; ?>" alt="" height="30%">
			<?php endif ?>
			<input name="banner" size="20" type="file"><br>
			<button type="submit" name="id_kegiatan" value="<?php echo $detail_kegiatan[0]['id_kegiatan']; ?>">Edit Kegiatan</button>
		</form>
	</body>
</html> -->