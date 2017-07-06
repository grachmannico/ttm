<html>
	<title></title>
	<body>
		<form action="<?php echo base_url()."REST_API/hapus_barang"; ?>" method="POST">
			<input type="email" name="email" value="<?php echo $email; ?>"><br>
			<input type="text" name="invoice" value="<?php echo $invoice ?>"><br>
			<table border="1">
				<tr>
					<td>nama_barang</td>
					<td>harga</td>
					<td>qty</td>
					<td>Action</td>
				</tr>
				<?php foreach ($keranjang_belanja as $b): ?>
				<tr>
					<td><?php echo $b['nama_barang']; ?></td>
					<td><?php echo $b['harga']; ?></td>
					<td><?php echo $b['qty']; ?></td>
					<td><button type="sumbit" name="id_keranjang_belanja" value="<?php echo $b['id_keranjang_belanja']; ?>">Hapus Barang</button></td>
				</tr>
				<?php endforeach?>
			</table>
		</form>
		<br>
		<form action="<?php echo base_url()."REST_API/lihat_garage_sale"; ?>" method="POST">
			<input type="email" name="email" value="<?php echo $email; ?>"><br>
			<input type="text" name="invoice" value="<?php echo $invoice ?>"><br>
			<button type="submit">Tambah Barang</button>
		</form>
		<form action="<?php echo base_url()."REST_API/pembelian"; ?>" method="POST">
			<input type="email" name="email" value="<?php echo $email; ?>"><br>
			<input type="text" name="invoice" value="<?php echo $invoice ?>"><br>
			<button type="submit">Beli Barang</button>
		</form>
	</body>
</html>