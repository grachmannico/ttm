<html>
	<head>
		<style type="text/css">
			body {
				background-image: url(<?php echo FCPATH . "/uploads/s_relawan.png"; ?>);
				background-size: 100%;
				background-repeat: no-repeat;
				width: 100%;
				height: 100%;
			}
		</style>
	</head>
	<body width="100%" height="100%">
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		<center><h1 style="color: #e72549;"><?php echo $data_relawan[0]['nama']; ?></h1></center>
		<center><h4 style="margin-top: 120px;color: #e72549;">Periode <?php echo $tahun; ?></h4></center>
		<table style="margin-top: 55px;">
			<tr>
				<td width="550px" style="color: #e72549;"><center><?php echo $ketua[0]['nama']; ?></center></td>
				<td width="380px" style="color: #e72549;"><center><?php echo $wakil[0]['nama']; ?></center></td>
			</tr>
			<tr>
				<td width="550px" style="color: #e72549;"><center><?php echo $ketua[0]['pangkat_divisi']; ?></center></td>
				<td width="380px" style="color: #e72549;"><center><?php echo $wakil[0]['pangkat_divisi']; ?></center></td>
			</tr>
		</table>
	</body>
</html>