<html>
	<title></title>
	<body>
		<form action="<?php echo base_url()."REST_API/monitor_dana"; ?>" method="POST">
			<table border="1">
				<tr>
					<td>nama_kegiatan</td>
					<td>banner</td>
					<td>action</td>
				</tr>
				<?php foreach ($subs_kegiatan as $s): ?>
				<tr>
					<td><?php echo $s['nama_kegiatan']; ?></td>
					<td><?php echo $s['banner']; ?></td>
					<td><button type="submit" name="id_kegiatan" value="<?php echo $s['id_kegiatan']; ?>">Monitor Dana</button></td>
				</tr>
				<?php endforeach ?>
			</table>
		</form>
	</body>
</html>