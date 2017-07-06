<html>
	<title></title>
	<body>
		<form action="<?php echo base_url()."REST_API/detail_barang"; ?>" method="POST">
			<input type="email" name="email" value="<?php echo $email; ?>"><br>
			<input type="text" name="invoice" value="<?php echo $invoice ?>"><br>
			<table border="1">
				<tr>
					<td>nama_barang</td>
					<td>harga</td>
					<td>gambar_barang</td>
					<td>action</td>
				</tr>
				<?php foreach ($barang as $b): ?>
				<tr>
					<td><?php echo $b['nama_barang']; ?></td>
					<td><?php echo $b['harga']; ?></td>
					<td><?php echo $b['gambar_barang']; ?></td>
					<td><button type="submit" name="id_barang_garage_sale" value="<?php echo $b['id_barang_garage_sale']; ?>">Lihat Detail</button></td>
				</tr>
				<?php endforeach ?>
			</table>
		</form>
		<form action="<?php echo base_url()."REST_API/keranjang_belanja"; ?>" method="POST">
			<input type="email" name="email" value="<?php echo $email; ?>"><br>
			<input type="text" name="invoice" value="<?php echo $invoice ?>"><br>
			<button type="submit">Lihat Keranjang Belanja</button>
		</form>
	</body>
</html>