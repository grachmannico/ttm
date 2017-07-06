<html>
	<title></title>
	<body>
		<table border="1">
			<tr>
				<td>invoice</td>
				<td>tanggal_pembelian</td>
				<td>total_tagihan</td>
				<td colspan="2">action</td>
			</tr>
			<?php foreach ($list_pembelian as $l): ?>
			<tr>
				<td><?php echo $l['id_invoice']; ?></td>
				<td><?php echo $l['tanggal_pembelian']; ?></td>
				<td><?php echo $l['total_tagihan']; ?></td>
				<td>
					<form action="<?php echo base_url()."REST_API/detail_pembelian"; ?>" method="POST">
						<button type="submit" name="invoice" value="<?php echo $l['id_invoice']; ?>">Detail Pembelian</button>
					</form>
				</td>
				<td>
					<form action="<?php echo base_url()."REST_API/form_konfirmasi_pembelian"; ?>" method="POST">
						<button type="submit" name="invoice" value="<?php echo $l['id_invoice']; ?>">Konfirmasi Pembelian</button>
					</form>
				</td>
			</tr>
			<?php endforeach ?>
		</table>
	</body>
</html>