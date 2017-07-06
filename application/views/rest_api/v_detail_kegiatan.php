<html>
	<title></title>
	<body>
		nama_kegiatan: <?php echo $data_detail_kegiatan['nama_kegiatan']; ?><br>
		pesan_ajakan: <?php echo $data_detail_kegiatan['pesan_ajakan']; ?><br>
		deskripsi_kegiatan: <?php echo $data_detail_kegiatan['deskripsi_kegiatan']; ?><br>
		relawan: <?php echo $data_detail_kegiatan['jumlah_relawan']; ?>/<?php echo $data_detail_kegiatan['minimal_relawan']; ?><br>
		donasi: <?php echo $data_detail_kegiatan['jumlah_donasi']; ?>/<?php echo $data_detail_kegiatan['minimal_donasi']; ?><br>
		tanggal_kegiatan: <?php echo $data_detail_kegiatan['tanggal_kegiatan']; ?><br>
		batas_akhir_pendaftaran: <?php echo $data_detail_kegiatan['batas_akhir_pendaftaran']; ?><br>
		alamat: <?php echo $data_detail_kegiatan['alamat']; ?><br>
		posisi: <?php echo $data_detail_kegiatan['lat']; ?>/<?php echo $data_detail_kegiatan['lng']; ?><br>
		banner: <?php echo $data_detail_kegiatan['banner']; ?>
	</body>
	<hr>
	<form action="<?php echo base_url()."REST_API/gabung_kegiatan"; ?>" method="POST">
		<input type="email" name="email" placeholder="email"><br>
		<button type="submit" name="gabung" value="<?php echo $data_detail_kegiatan['id_kegiatan']; ?>">Gabung Kegiatan</button>
	</form>
	<hr>
	<form action="<?php echo base_url()."REST_API/donasi"; ?>" method="POST">
		<input type="email" name="email" placeholder="email"><br>
		<input type="number" name="nominal_donasi" placeholder="nominal donasi"><br>
		<button type="submit" name="donasi" value="<?php echo $data_detail_kegiatan['id_kegiatan']; ?>">Donasi</button>
	</form>
</html>