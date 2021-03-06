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

<?php echo $d['map']['js'];?>

<!-- <script>
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
</script> -->

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
              <!-- <?php if ($detail_kegiatan[0]['id_status_kegiatan'] == 3) { ?>
                <li class="active"><a href="#tab_3" data-toggle="tab">Stats Kegiatan</a></li>
                <li><a href="#tab_1" data-toggle="tab">Detail Data Kegiatan</a></li>
                <li><a href="#tab_2" data-toggle="tab">Dokumentasi Kegiatan</a></li>
              <?php } else { ?>
                <li class="active"><a href="#tab_1" data-toggle="tab">Detail Data Kegiatan</a></li>
                <li><a href="#tab_2" data-toggle="tab">Dokumentasi Kegiatan</a></li>
              <?php } ?> -->
              <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-list-alt"></i> Detail Data Kegiatan</a></li>
              <li><a href="#tab_2" data-toggle="tab"><i class="fa fa-book"></i> Dokumentasi Kegiatan</a></li>
              <li><a href="#tab_3" data-toggle="tab"><i class="fa fa-bar-chart"></i> Stats Kegiatan</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <div class="box box-danger">
                  <div class="box-header with-border">
                    <h3 class="box-title">Detail Kegiatan</h3>
                  </div>
                  <div class="box-body">
                    <div class="form-group">
                      <h3><?php echo $detail_kegiatan[0]['nama_kegiatan']; ?></h3>
                      <p><i>"<?php echo $detail_kegiatan[0]['pesan_ajakan']; ?>"</i></p>
                      <p class="pull-right">
                        Kegiatan dilaksanakan pada tanggal 
                        <u>
                        <?php if ($detail_kegiatan[0]['tanggal_kegiatan_mulai'] == $detail_kegiatan[0]['tanggal_kegiatan_berakhir']): ?>
                          <?php echo tanggal_indo($detail_kegiatan[0]['tanggal_kegiatan_mulai']); ?>
                        <?php endif ?>
                        <?php if ($detail_kegiatan[0]['tanggal_kegiatan_mulai'] != $detail_kegiatan[0]['tanggal_kegiatan_berakhir']): ?>
                          <?php echo tanggal_indo($detail_kegiatan[0]['tanggal_kegiatan_mulai']). " sampai " .tanggal_indo($detail_kegiatan[0]['tanggal_kegiatan_berakhir']); ?>
                        <?php endif ?>
                        </u>
                      </p>
                      <p class="label bg-green"><?php echo $detail_kegiatan[0]['status_kegiatan']; ?></p>
                    </div>
                    <?php
                      $total_relawan = ($jumlah_relawan[0]['jumlah_relawan'] / $detail_kegiatan[0]['minimal_relawan']) * 100;
                    ?>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1"><i class="fa fa-users"></i> Jumlah Relawan</label> <label class="badge bg-red pull-right"><?php echo number_format((float)$total_relawan, 2, '.', ''); ?>%</label>
                        <p><?php echo $jumlah_relawan[0]['jumlah_relawan']; ?> relawan dari <?php echo $detail_kegiatan[0]['minimal_relawan']; ?> relawan yang dibutuhkan</p>
                        <div class="progress">
                          <div class="progress-bar progress-bar-red" role="progressbar" aria-valuenow="<?php echo $total_relawan; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $total_relawan . "%"; ?>">
                            <span class="sr-only"><?php echo $total_relawan."%"; ?> Complete (success)</span>
                            <!-- <p style="color: black;"><?php echo number_format((float)$total_relawan, 2, '.', ''); ?>%</p> -->
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php
                      if (!empty($jumlah_donasi)) {
                        $total_donasi = ($jumlah_donasi[0]['jumlah_donasi'] / $detail_kegiatan[0]['minimal_donasi']) * 100;
                      } elseif (empty($jumlah_donasi)) {
                        $total_donasi = (0 / $detail_kegiatan[0]['minimal_donasi']) * 100;
                      }
                    ?>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1"><i class="fa fa-heart"></i> Jumlah Donasi</label>
                        <?php if (!empty($jumlah_donasi)): ?>
                          <label class="badge bg-green pull-right"><?php echo number_format((float)$total_donasi, 2, '.', ''); ?>%</label>
                        <?php endif ?>
                        <?php if (empty($jumlah_donasi)): ?>
                          <label class="badge bg-green pull-right"><?php echo number_format(0, 2, '.', ''); ?>%</label>
                        <?php endif ?>
                        <?php if (!empty($jumlah_donasi)): ?>
                          <p><?php echo "Rp. " . number_format($jumlah_donasi[0]['jumlah_donasi'], 2, ",", "."); ?> dari <?php echo "Rp. " . number_format($detail_kegiatan[0]['minimal_donasi'], 2, ",", "."); ?></p>
                        <?php endif ?>
                        <?php if (empty($jumlah_donasi)): ?>
                          <p><?php echo "Rp. " . number_format(0, 2, ",", "."); ?> dari <?php echo "Rp. " . number_format($detail_kegiatan[0]['minimal_donasi'], 2, ",", "."); ?></p>
                        <?php endif ?>
                        <div class="progress">
                          <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="<?php echo $total_donasi; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $total_donasi . "%"; ?>">
                            <span class="sr-only"><?php echo $total_donasi."%"; ?> Complete (success)</span>
                            <!-- <p style="color: black;"><?php echo number_format((float)$total_donasi, 2, '.', ''); ?>%</p> -->
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-map"></i> Lokasi Kegiatan</label>
                      <br>
                      <?php echo $detail_kegiatan[0]['alamat']; ?>
                      <br>
                      <?php echo $d['map']['html'];?>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-file-text"></i> Deskripsi Kegiatan</label><br>
                      <?php echo $detail_kegiatan[0]['deskripsi_kegiatan']; ?>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-image"></i> Banner Kegiatan</label><br>
                      <?php if ($detail_kegiatan[0]['banner'] == ""): ?>
                        No Image<br>
                      <?php endif ?>
                      <?php if ($detail_kegiatan[0]['banner'] != ""): ?>
                        <center><img src="<?php echo base_url()."uploads/gambar_kegiatan/"; ?><?php echo $detail_kegiatan[0]['banner']; ?>" alt="" width="500px"></center>
                      <?php endif ?>
                    </div>
                    <!-- <div class="form-group">
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
                      <input type="text" class="form-control" value="<?php echo $jumlah_relawan[0]['jumlah_relawan']; ?> dari <?php echo $detail_kegiatan[0]['minimal_relawan']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-heart"></i> Jumlah Donasi</label>
                      <?php if (empty($jumlah_donasi)): ?>
                      <input type="text" class="form-control" value="Rp. 0,00 / <?php echo "Rp. " . number_format($detail_kegiatan[0]['minimal_donasi'], 2, ",", "."); ?>" readonly>
                      <?php endif ?>
                      <?php if (!empty($jumlah_donasi)): ?>
                      <input type="text" class="form-control" value="<?php echo "Rp. " . number_format($jumlah_donasi[0]['jumlah_donasi'], 2, ",", "."); ?> terkumpul dari <?php echo "Rp. " . number_format($detail_kegiatan[0]['minimal_donasi'], 2, ",", "."); ?>" readonly>
                      <?php endif ?>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-calendar-check-o"></i> Tanggal Kegiatan</label>
                      <?php if ($detail_kegiatan[0]['tanggal_kegiatan_mulai'] == $detail_kegiatan[0]['tanggal_kegiatan_berakhir']): ?>
                        <input type="text" class="form-control" value="<?php echo tanggal_indo($detail_kegiatan[0]['tanggal_kegiatan_mulai']); ?>" readonly>
                      <?php endif ?>
                      <?php if ($detail_kegiatan[0]['tanggal_kegiatan_mulai'] != $detail_kegiatan[0]['tanggal_kegiatan_berakhir']): ?>
                        <input type="text" class="form-control" value="<?php echo tanggal_indo($detail_kegiatan[0]['tanggal_kegiatan_mulai']). " - " .tanggal_indo($detail_kegiatan[0]['tanggal_kegiatan_berakhir']); ?>" readonly>
                      <?php endif ?>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-calendar-times-o"></i> Batas Akhir Pendaftaran</label>
                      <input type="text" class="form-control" value="<?php echo tanggal_indo($detail_kegiatan[0]['batas_akhir_pendaftaran']); ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-compass"></i> Alamat</label>
                      <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['alamat']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-map"></i> Lokasi</label>
                      <?php echo $d['map']['html'];?>
                    </div> -->
                    <!-- <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-map-marker"></i> Lat</label>
                      <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['lat']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-map-marker"></i> Lng</label>
                      <input type="text" class="form-control" value="<?php echo $detail_kegiatan[0]['lng']; ?>" readonly>
                    </div> -->
                    <!-- <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-image"></i> Banner Kegiatan</label><br>
                      <?php if ($detail_kegiatan[0]['banner'] == ""): ?>
                        No Image<br>
                      <?php endif ?>
                      <?php if ($detail_kegiatan[0]['banner'] != ""): ?>
                        <img src="<?php echo base_url()."uploads/gambar_kegiatan/"; ?><?php echo $detail_kegiatan[0]['banner']; ?>" alt="" width="500px">
                      <?php endif ?>
                    </div> -->
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
                          <th>Tanggal</th>
                          <th>Gambar Kegiatan</th>
                          <th>Deskripsi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($dokumentasi as $d): ?>
                        <tr>
                          <td><?php echo tanggal_indo($d['tanggal']); ?></td>
                          <td><a href="<?php echo base_url()."uploads/dokumentasi/"; ?><?php echo $d['gambar_dokumentasi']; ?>" target="_blank"><img src="<?php echo base_url()."uploads/dokumentasi/"; ?><?php echo $d['gambar_dokumentasi']; ?>" alt="" width="100%"></a></td>
                          <td><?php echo $d['deskripsi']; ?></td>
                        </tr>
                        <?php endforeach?>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <?php if ($detail_kegiatan[0]['id_status_kegiatan'] == 3 && $hasil_rating_relawan != 0 && $hasil_rating_donatur != 0) { ?>
              <div class="tab-pane" id="tab_3">
              <center><h3>Informasi Kegiatan: <?php echo $detail_kegiatan[0]['nama_kegiatan']; ?></h3></center>
                <div class="content">
                  <div class="col-md-12">
                    <div class="info-box bg-red">
                      <span class="info-box-icon"><i class="fa fa-line-chart"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">Kontribusi Relawan:</span>
                        <span class="info-box-number"><?php echo number_format((float)$persentase_gabung_relawan, 2, '.', ''); ?>%</span>

                        <div class="progress">
                          <div class="progress-bar" style="width: <?php echo $persentase_gabung_relawan; ?>%"></div>
                        </div>
                            <span class="progress-description">
                              <?php echo $jml_relawan; ?> orang yang bergabung dari <?php echo $detail_kegiatan[0]['minimal_relawan']; ?> orang yang dibutuhkan
                            </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-box bg-red">
                      <span class="info-box-icon"><i class="fa fa-check-square"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">Persentase Kehadiran Relawan:</span>
                        <span class="info-box-number"><?php echo number_format((float)$persentase_kehadiran, 2, '.', ''); ?>%</span>

                        <div class="progress">
                          <div class="progress-bar" style="width: <?php echo $persentase_kehadiran; ?>%"></div>
                        </div>
                            <span class="progress-description">
                              <?php echo $jml_relawan_hadir; ?> orang hadir dari <?php echo $jml_relawan; ?> orang yang bergabung
                            </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-box bg-red">
                      <span class="info-box-icon"><i class="fa fa-heart"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">Hasil Penggalangan Dana:</span>
                        <span class="info-box-number"><?php echo number_format((float)$persentase_donasi, 2, '.', ''); ?>%</span>

                        <div class="progress">
                          <div class="progress-bar" style="width: <?php echo $persentase_donasi; ?>%"></div>
                        </div>
                            <span class="progress-description">
                              <?php if (empty($jumlah_donasi)): ?>
                                Terkumpul <?php echo "Rp. " . number_format(0, 2, ",", "."); ?> dari <?php echo "Rp. " . number_format($detail_kegiatan[0]['minimal_donasi'], 2, ",", "."); ?>
                              <?php endif ?>
                              <?php if (!empty($jumlah_donasi)): ?>
                                Terkumpul <?php echo "Rp. " . number_format($jumlah_donasi[0]['jumlah_donasi'], 2, ",", "."); ?> dari <?php echo "Rp. " . number_format($detail_kegiatan[0]['minimal_donasi'], 2, ",", "."); ?>
                              <?php endif ?>
                            </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-box bg-red">
                      <span class="info-box-icon"><i class="fa fa-users"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">Hasil Feedback Relawan:</span>
                        <span class="info-box-number"><?php echo number_format((float)$hasil_rating_relawan, 2, '.', ''); ?> / 5</span>

                        <div class="progress">
                          <div class="progress-bar" style="width: <?php echo $persentase_rating_relawan; ?>%"></div>
                        </div>
                            <span class="progress-description">
                              <?php echo number_format((float)$persentase_rating_relawan, 2, '.', ''); ?> % relawan memberi respon positif
                            </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-box bg-red">
                      <span class="info-box-icon"><i class="fa fa-black-tie"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">Hasil Feedback Donatur:</span>
                        <span class="info-box-number"><?php echo number_format((float)$hasil_rating_donatur, 2, '.', ''); ?> / 5</span>

                        <div class="progress">
                          <div class="progress-bar" style="width: <?php echo $persentase_rating_donatur; ?>%"></div>
                        </div>
                            <span class="progress-description">
                              <?php echo number_format((float)$persentase_rating_donatur, 2, '.', ''); ?> % donatur memberi respon positif
                            </span>
                      </div>
                    </div>
                  </div>
                  <br><hr>
                  <?php echo $hasil_analisis; ?>
                  <hr>
                  <?php echo $kesimpulan; ?>
                </div>
              </div>
              <?php } else { ?>
              <div class="tab-pane" id="tab_3">
              <center><h3>Informasi Kegiatan: <?php echo $detail_kegiatan[0]['nama_kegiatan']; ?></h3></center>
                <div class="content">
                  <center>
                    <h4>Belum Bisa Ditampilkan.</h4><hr>
                    <p>Informasi Kegiatan Hanya Dapat Ditampilkan Ketika Status Kegiatan Berstatus <b>"Kegiatan Selesai Berjalan"</b> dan <b>Telah Mendapatkan <i>Feedback</i> Dari Para Relawan Dan Donatur</b>.</p>
                  </center>
                </div>
              </div>
              <?php } ?>
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