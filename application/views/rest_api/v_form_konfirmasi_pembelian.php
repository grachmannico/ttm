<html>
	<title></title>
	<body>
		<form action="<?php echo base_url()."REST_API/konfirmasi_pembelian"; ?>" method="POST" enctype="multipart/form-data">
			<input type="text" name="invoice" value="<?php echo $invoice; ?>"><br>
			Total Tagihan: <?php echo $total_tagihan[0]['total_tagihan'] ?><br>
			<input name="struk" size="20" type="file"><br>
			<button type="submit">Konfirmasi</button>
		</form>
	</body>
</html>