<html>
	<title></title>
	<body>
		<form action="<?php echo base_url()."REST_API/kirim_feedback"; ?>" method="post">
			<input type="email" name="email" value="<?php echo $email; ?>"><br>
			<input type="text" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>"><br>
			<textarea name="komentar" id="" cols="30" rows="10"></textarea><br>
			<input type="number" name="rating" placeholder="rating"><br>
			<button type="submit">Kirim Feedback</button>
		</form>
	</body>
</html>