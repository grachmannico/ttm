<html>
	<title></title>
	<body>
		<form action="<?php echo base_url()."REST_API/form_feedback"; ?>" method="POST">
			<table border="1">
				<tr>
					<td>nama_kegiatan</td>
					<td>email</td>
					<td>action</td>
				</tr>
				<?php foreach ($subscribe as $s): ?>
				<tr>
					<td><?php echo $s['nama_kegiatan'] ?></td>
					<td><input type="email" name="email" value="<?php echo $s['email']; ?>"></td>
					<td><button type="submit" name="id_kegiatan" value="<?php echo $s['id_kegiatan']; ?>">Beri Feedback</button></td>
				</tr>
				<?php endforeach ?>
			</table>
		</form>
		<hr>
		<form action="<?php echo base_url()."REST_API/lihat_feedback"; ?>" method="POST">
			<table border="1">
				<tr>
					<td>nama_kegiatan</td>
					<td>email</td>
					<td>action</td>
				</tr>
				<?php foreach ($subscribe as $s): ?>
				<tr>
					<td><?php echo $s['nama_kegiatan'] ?></td>
					<td><input type="email" name="email" value="<?php echo $s['email']; ?>"></td>
					<td><button type="submit" name="id_kegiatan" value="<?php echo $s['id_kegiatan']; ?>">Lihat Feedback</button></td>
				</tr>
				<?php endforeach ?>
			</table>
		</form>
	</body>
</html>