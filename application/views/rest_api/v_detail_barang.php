<html>
	<title></title>
	<body>
		<form action="<?php echo base_url()."REST_API/beli_barang"; ?>" method="POST">
			<input type="email" name="email" value="<?php echo $email; ?>"><br>
			<input type="text" name="invoice" value="<?php echo $invoice ?>"><br>
			<input type="text" name="id_barang_garage_sale" value="<?php echo $barang[0]['id_barang_garage_sale'] ?>"><br>
			Nama Barang: <?php echo $barang[0]['nama_barang']; ?><br>
			Harga: <?php echo $barang[0]['harga']; ?><br>
			Deskripsi: <?php echo $barang[0]['deskripsi']; ?><br>
			Gambar: <?php echo $barang[0]['gambar_barang']; ?><br>
			Stok: <?php echo $barang[0]['stok_terpesan']; ?><br>
			Beli: <input type="number" name="qty"><br>
			<button type="submit">Beli</button>
		</form>
	</body>
</html>