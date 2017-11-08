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
		<title>LPJ</title>
		<style type="text/css">
			p {
				text-align: justify;
			}
			th {
				vertical-align: top;
				padding: 2px 5px 2px 5px;
			}
			td {
				vertical-align: top;
				padding: 2px 5px 2px 5px;
			}
			.center {
				text-align: center;
			}
			.page-break {
				page-break-before: always;
			}
		</style>
	</head>
	<body>
		<center>
		<table>
			<tr>
				<!-- <td><img src="<?php echo base_url() . "/uploads/ttm_logo.png"; ?>" alt="" width="150px" height="150px"></td> -->
				<td><img src="<?php echo FCPATH . "/uploads/ttm_logo.png"; ?>" alt="" width="150px" height="150px"></td>
				<td>
					<center><h4>Laporan Pertanggung Jawaban Kegiatan Turun Tangan Malang</h4></center>
					<center>Turun Tangan Malang</center><br>
					<center>Tahun 2017</center>
				</td>
			</tr>
		</table>
		</center>
		<hr>
		<p>
			<?php if ($data_kegiatan[0]['tanggal_kegiatan_mulai'] == $data_kegiatan[0]['tanggal_kegiatan_berakhir']): ?>
				Dengan ini kami Komunitas Turun Tangan Malang menberikan dokumentasi lengkap berupa laporang pertanggung jawaban pelaksanaan kegiatan <b><?php echo $data_kegiatan[0]['nama_kegiatan']; ?></b>, yang telah dilaksanakan oleh Komunitas Turun Tangan Malang yang dilaksanakan pada <?php echo tanggal_indo($data_kegiatan[0]['tanggal_kegiatan_mulai']); ?>. Berikut merupakan detail mengenai laporan pertanggung jawaban yang kami buat.
			<?php endif ?>
			<?php if ($data_kegiatan[0]['tanggal_kegiatan_mulai'] != $data_kegiatan[0]['tanggal_kegiatan_berakhir']): ?>
				Dengan ini kami Komunitas Turun Tangan Malang menberikan dokumentasi lengkap berupa laporang pertanggung jawaban pelaksanaan kegiatan <b><?php echo $data_kegiatan[0]['nama_kegiatan']; ?></b>, yang telah dilaksanakan oleh Komunitas Turun Tangan Malang yang dilaksanakan pada <?php echo tanggal_indo($data_kegiatan[0]['tanggal_kegiatan_mulai']); ?> sampai tanggal <?php echo tanggal_indo($data_kegiatan[0]['tanggal_kegiatan_berakhir']); ?>. Berikut merupakan detail mengenai laporan pertanggung jawaban yang kami buat.
			<?php endif ?>
		</p>
		<br>
		<p>
			<h4>Deskripsi Kegiatan</h4>
		</p>
		<p>
			<?php echo $data_kegiatan[0]['deskripsi_kegiatan']; ?>
		</p>
		<table>
			<tr>
				<td>Tanggal Pelaksanaan Kegiatan</td>
				<td>:</td>
				<?php if ($data_kegiatan[0]['tanggal_kegiatan_mulai'] == $data_kegiatan[0]['tanggal_kegiatan_berakhir']): ?>
					<td><?php echo tanggal_indo($data_kegiatan[0]['tanggal_kegiatan_mulai']); ?></td>
				<?php endif ?>
				<?php if ($data_kegiatan[0]['tanggal_kegiatan_mulai'] != $data_kegiatan[0]['tanggal_kegiatan_berakhir']): ?>
					<td><?php echo tanggal_indo($data_kegiatan[0]['tanggal_kegiatan_mulai']); ?> - <?php echo tanggal_indo($data_kegiatan[0]['tanggal_kegiatan_berakhir']); ?></td>
				<?php endif ?>
			</tr>
			<tr>
				<td>Tempat Dilaksanakannya Kegiatan</td>
				<td>:</td>
				<td><?php echo $data_kegiatan[0]['alamat']; ?></td>
			</tr>
			<tr>
				<td>Jumlah Pemasukan Dana Kegiatan</td>
				<td>:</td>
				<td><?php echo "Rp. " . number_format($total_donasi[0]['total_dana'], 2, ",", "."); ?></td>
			</tr>
			<tr>
				<td>Jumlah Relawan Dalam Kegiatan</td>
				<td>:</td>
				<?php if (empty($jumlah_relawan)): ?>
					<td>0 orang</td>
				<?php endif ?>
				<?php if (!empty($jumlah_relawan)): ?>
					<td><?php echo $jumlah_relawan[0]['jumlah_relawan']; ?> orang</td>
				<?php endif ?>
			</tr>
		</table>
		<br>
		<p>
			<h4>Pengeluaran Dana</h4>
		</p>
		<p>
			Berikut merupakan detail pengeluaran dana dalam kegiatan.
		</p>
		<table border="1" style="border-collapse: collapse;">
			<tr>
				<th>No.</th>
				<th>Nama Dana Keluar</th>
				<th>Nominal Dana Keluar</th>
				<th>Tanggal</th>
				<th>Keterangan</th>
			</tr>
			<?php $i = 1;?>
			<?php foreach ($data_pengeluaran_dana as $d): ?>
			<tr>
				<td class="center"  width="10px"><?php echo $i . "."; ?></td>
				<td><?php echo $d['nama_dana_keluar']; ?></td>
				<td><?php echo "Rp. " . number_format($d['nominal_dana_keluar'], 2, ",", "."); ?></td>
				<td><?php echo tanggal_indo($d['tanggal']); ?></td>
				<td width="300px"><?php echo $d['keterangan']; ?></td>
			</tr>
			<?php $i++?>
			<?php endforeach?>
		</table>
		<br>
		<div class="page-break">
		<p>
			<h4>Dokumentasi Kegiatan</h4>
		</p>
		<?php foreach ($dokumentasi_kegiatan as $dk): ?>
		<table>
			<tr>
				<td><?php echo $dk['nama_dokumentasi']; ?> (<?php echo tanggal_indo($dk['tanggal']); ?>)</td>
			</tr>
			<tr>
				<td><img src="<?php echo FCPATH . "/uploads/dokumentasi/"; ?><?php echo $dk['gambar_dokumentasi']; ?>" alt="" style="max-width: 600px; max-height: 300px;"></td>
			</tr>
			<tr>
				<td>Deskripsi: <?php echo $dk['deskripsi']; ?></td>
			</tr>
		</table>
		<br>
		<?php endforeach?>
		</div>
	</body>
</html>