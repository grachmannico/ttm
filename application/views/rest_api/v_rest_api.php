<html>
	<head></head>
	<body>
		<form action="<?php echo base_url()."REST_API/auth"; ?>" method="POST">
			<input type="email" name="email" placeholder="email"><br>
			<input type="password" name="password" placeholder="password"><br>
			<button type="submit">Login</button>
		</form>
		<hr>
		<form action="<?php echo base_url()."REST_API/register"; ?>" method="POST">
			<input type="text" name="nama" placeholder="nama"><br>
			<input type="email" name="email" placeholder="email"><br>
			<input type="password" name="password" placeholder="password"><br>
			<button type="submit">Register</button>
		</form>
		<hr>
		<form action="<?php echo base_url()."REST_API/detail_kegiatan"; ?>" method="POST">
		<table border="1">
			<tr>
				<td>nama_kegiatan</td>
				<td>pesan_ajakan</td>
				<td>action</td>
			</tr>
			<?php foreach ($data_kegiatan as $dk): ?>
			<tr>
				<td><?php echo $dk['nama_kegiatan']; ?></td>
				<td><?php echo $dk['pesan_ajakan']; ?></td>
				<!-- <input type="hidden" name="id_kegiatan" value="<?php echo $dk[id_kegiatan]; ?>"> -->
				<td><button type="submit" name="id_kegiatan" value="<?php echo $dk['id_kegiatan']; ?>">Lihat Detail</button></td>
			</tr>
			<?php endforeach ?>
		</table>
		</form>
		<form action="<?php echo base_url()."REST_API/list_konfirmasi_donasi"; ?>" method="POST">
			<input type="email" name="email" placeholder="email"><br>
			<button type="submit">List Transaksi Donasi</button>
		</form>
		<form action="<?php echo base_url()."REST_API/list_kegiatan_diikuti"; ?>" method="POST">
			<input type="email" name="email" placeholder="email"><br>
			<button type="submit">Lihat feedback</button>
		</form>
		<form action="<?php echo base_url()."REST_API/lihat_garage_sale"; ?>" method="POST">
			<input type="email" name="email" placeholder="email"><br>
			<button type="submit" name="invoice" value="">Garage Sale</button>
		</form>
		<form action="<?php echo base_url()."REST_API/list_konfirmasi_pembayaran"; ?>" method="POST">
			<input type="email" name="email" placeholder="email"><br>
			<button type="submit" name="invoice" value="">List Pembayaran Garage Sale</button>
		</form>
		<form action="<?php echo base_url()."REST_API/monitor_dana"; ?>" method="POST">
			<input type="email" name="email" placeholder="email"><br>
			<button type="submit">Monitor Dana</button>
		</form>
		<form action="<?php echo base_url()."REST_API/send_notification"; ?>" method="POST">
			<input type="text" name="title" placeholder="title"><br>
			<input type="text" name="body" placeholder="body"><br>
			<button type="submit">SEND NOTIF</button>
		</form>
	</body>
</html>