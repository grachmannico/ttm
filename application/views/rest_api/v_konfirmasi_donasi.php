<html>
	<title></title>
	<body>
		<form action="<?php echo base_url()."REST_API/konfirmasi_donasi"; ?>" method="POST" enctype="multipart/form-data">
			<input type="text" name="id_donasi" value="<?php echo $konfirmasi_donasi[0]['id_donasi']; ?>"><br>
			<input name="struk" size="20" type="file"><br>
			<button type="submit">Konfirmasi</button>
		</form>
	</body>
</html>