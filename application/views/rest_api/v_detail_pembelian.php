<html>
	<title></title>
	<body>
		<table border="1">
			<tr>
				<td>nama_barang</td>
				<td>harga</td>
				<td>qty</td>
			</tr>
			<?php foreach ($keranjang_belanja as $b): ?>
			<tr>
				<td><?php echo $b['nama_barang']; ?></td>
				<td><?php echo $b['harga']; ?></td>
				<td><?php echo $b['qty']; ?></td>
			</tr>
			<?php endforeach?>
		</table>
		<form action="<?php echo base_url()."REST_API/form_konfirmasi_pembelian"; ?>" method="POST">
			<button type="submit" name="invoice" value="<?php echo $invoice ?>">Konfirmasi Pembelian</button>
		</form>
	</body>
</html>