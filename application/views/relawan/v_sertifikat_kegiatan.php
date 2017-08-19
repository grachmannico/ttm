<?php
function tanggal_indo($tanggal)
{
    $bulan = array(1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    );
    $split = explode('-', $tanggal);
    return $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];
}
?>

<html>
	<head>
		<style type="text/css">
			body {
				background-image: url(<?php echo FCPATH . "/uploads/s_kegiatan.png"; ?>);
				background-size: 100%;
				background-repeat: no-repeat;
				width: 100%;
				height: 100%;
			}
			.full_width {
				margin: auto;
				width: 100%;
				margin-top: 150px;
			}
			.tr_width {
				width: 50%;
			}
		</style>
	</head>
	<body width="100%" height="100%">
		<br><br><br><br><br><br><br><br><br><br>
		<center><h1 style="color: #106173;"><?php echo $data_relawan[0]['nama']; ?></h1></center>
		<br>
		<center><h1 style="color: #106173;"><?php echo $data_kegiatan[0]['nama_kegiatan'] ?></h1></center>
		<?php if ($data_relawan[0]['id_pangkat_divisi'] == 6): ?>
			<center><h2 style="color: #4a4a4a;">Sebagai Volunteer</h2></center>
		<?php endif ?>
		<?php if ($data_relawan[0]['id_pangkat_divisi'] != 6): ?>
			<center><h2 style="color: #4a4a4a;">Sebagai Relawan</h2></center>
		<?php endif ?>
		<?php if ($data_kegiatan[0]['tanggal_kegiatan_mulai'] == $data_kegiatan[0]['tanggal_kegiatan_berakhir']): ?>
			<center><p style="color: #4a4a4a;">Yang Diselenggarakan Pada Tanggal <?php echo tanggal_indo($data_kegiatan[0]['tanggal_kegiatan_mulai']); ?></p></center>
		<?php endif ?>
		<?php if ($data_kegiatan[0]['tanggal_kegiatan_mulai'] != $data_kegiatan[0]['tanggal_kegiatan_berakhir']): ?>
			<center><p style="color: #4a4a4a;">Yang Diselenggarakan Pada Tanggal <?php echo tanggal_indo($data_kegiatan[0]['tanggal_kegiatan_mulai']); ?> - <?php echo tanggal_indo($data_kegiatan[0]['tanggal_kegiatan_berakhir']); ?></p></center>
		<?php endif ?>
		<table style="margin-top: 110px;">
			<tr>
				<td width="475px" style="color: #4a4a4a;"><center><?php echo $ketua[0]['nama']; ?></center></td>
				<td width="630px" style="color: #4a4a4a;"><center><?php echo $wakil[0]['nama']; ?></center></td>
			</tr>
			<tr>
				<td width="475px" style="color: #4a4a4a;"><center><?php echo $ketua[0]['pangkat_divisi']; ?></center></td>
				<td width="630px" style="color: #4a4a4a;"><center><?php echo $wakil[0]['pangkat_divisi']; ?></center></td>
			</tr>
		</table>
	</body>
</html>