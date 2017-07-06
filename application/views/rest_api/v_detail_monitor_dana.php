<html>
	<title></title>
	<body>
		<table border="1">
		<tr>
			<td>nama_dana_keluar</td>
			<td>tanggal</td>
			<td>nominal_dana_keluar</td>
			<td>keterangan</td>
		</tr>
		<?php foreach ($lpj as $l): ?>
		<tr>
			<td><?php echo $l['nama_dana_keluar']; ?></td>
			<td><?php echo $l['tanggal']; ?></td>
			<td><?php echo $l['nominal_dana_keluar']; ?></td>
			<td><?php echo $l['keterangan']; ?></td>
		</tr>
		<?php endforeach ?>
		</table>
	</body>
</html>