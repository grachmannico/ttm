<html>
	<title></title>
	<body>
		<table>
			<tr>
				<td>email</td>
				<td>komentar</td>
			</tr>
			<?php foreach ($balasan as $b): ?>
			<tr>
				<td><?php echo $b['email']; ?></td>
				<td><?php echo $b['komentar']; ?></td>
			</tr>
			<?php endforeach ?>
		</table>
		<hr>
		<form action="<?php echo base_url()."REST_API/kirim_balasan_feedback"; ?>" method="POST">
			<input type="text" name="id_feedback_kegiatan" value="<?php echo $balasan[0]['id_feedback_kegiatan']; ?>"><br>
			<input type="email" name="email" placeholder="email"><br>
			<input type="text" name="komentar" placeholder="komentar"><br>
			<button type="submit">Kirim</button>
		</form>
	</body>
</html>