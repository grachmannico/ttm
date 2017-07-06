<html>
	<title></title>
	<body>
		<table border="1">
			<tr>
				<td>nama</td>
				<td>komentar</td>
				<td>rating</td>
				<td>jml_balasan</td>
				<td>action</td>
			</tr>
			<?php foreach ($feedback as $f): ?>
			<tr>
				<td><?php echo $f['nama']; ?></td>
				<td><?php echo $f['komentar']; ?></td>
				<td><?php echo $f['rating']; ?></td>
				<td><?php echo $f['jml_balasan']; ?></td>
				<td>
					<form action="<?php echo base_url()."REST_API/lihat_balasan_feedback"; ?>" method="POST">
						<button type="submit" name="id_feedback_kegiatan" value="<?php echo $f['id_feedback_kegiatan']; ?>">Lihat</button>
					</form>
				</td>
			</tr>
			<?php endforeach ?>
		</table>
	</body>
</html>