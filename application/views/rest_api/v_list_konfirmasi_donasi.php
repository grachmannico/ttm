<html>
	<title></title>
	<body>
		<form action="<?php echo base_url()."REST_API/form_konfirmasi_donasi"; ?>" method="POST">
			<table border="1">
				<tr>
					<td>nama_kegiatan</td>
					<td>nominal_donasi</td>
					<td>tanggal_donasi</td>
					<td>action</td>
				</tr>
				<?php foreach ($list_konfirmasi_donasi as $l): ?>
				<tr>
					<td><?php echo $l['nama_kegiatan']; ?></td>
					<td><?php echo $l['nominal_donasi']; ?></td>
					<td><?php echo $l['tanggal_donasi']; ?></td>
					<td><button type="submit" name="id_donasi" value="<?php echo $l['id_donasi']; ?>">Konfirmasi</button></td>
				</tr>
				<?php endforeach ?>
			</table>
		</form>
	</body>
</html>