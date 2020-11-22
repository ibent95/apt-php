<?php
	include '../load_files.php';
	include_once '../plugins/dompdf/autoload.inc.php';

	$tanggal_awal   = (isset($_POST['tanggal_awal']) AND !empty($_POST['tanggal_awal'])) ? $_POST['tanggal_awal'] : "1978-01-01" ;
	$tanggal_akhir  = (isset($_POST['tanggal_akhir']) AND !empty($_POST['tanggal_akhir'])) ? $_POST['tanggal_akhir'] : date("Y-m-d") ;
	// $nama_kategori	= (isset($_POST['nama_kategori']) AND !empty($_POST['nama_kategori'])) ? $_POST['nama_kategori'] : "" ;
	// $id_barang      = (isset($_POST['id_barang']) AND !empty($_POST['id_barang'])) ? $_POST['id_barang'] : "" ;

	$sql = "SELECT * FROM `data_laporan_arus_kas` WHERE (`tgl_transaksi` >= '$tanggal_awal 00:00:00') AND (`tgl_transaksi` <= '$tanggal_akhir 23:59:00') ORDER BY `tgl_transaksi` ASC";
	$transaksiAll = mysqli_query($koneksi, $sql) or die($koneksi);
	$totalKuantitasMasuk = 0;
	$totalKuantitasKeluar = 0;
	$totalMasuk = 0;
	$totalKeluar = 0;
	$totalUntungRugi = 0;

	$i = 1;

	// reference the Dompdf namespace
	use Dompdf\Dompdf;

	// instantiate and use the dompdf class
	$dompdf = new Dompdf();

	ob_start(); 
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Laporan Arus Kas Tanggal <?= format(date('Y-m-d'), 'date') ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" media="screen" href="../assets/lib/bootstrap/css/bootstrap.min.css" />
		<!-- <link rel="stylesheet" type="text/css" media="screen" href="../assets/backend/css/style.css" />	 -->
	</head>
	<body>
		<p class="text-dark">
			<h2 class="text-center">Laporan Arus Kas Tanggal <?= format(date('Y-m-d'), 'date') ?></h2>
			<?php if ($tanggal_awal == "1978-01-01" AND $tanggal_akhir == date("Y-m-d")) : ?>
				<table> <tbody>
						<tr> <td>Dari Keseluruhan Data</td> </tr>
				</tbody> </table>
			<?php elseif ($tanggal_awal === "1978-01-01" AND $tanggal_akhir !== date("Y-m-d")) : ?>
				<table> <tbody>
					<tr> <td>Sampai tanggal</td> <td>:</td> <td><?= $tanggal_akhir ?></td> </tr>
				</tbody> </table>
			<?php else : ?>
				<table> <tbody>
					<tr> <td>Dari tanggal</td> <td>:</td> <td><?= $tanggal_awal ?></td> </tr>
					<tr> <td>Sampai tanggal</td> <td>:</td> <td><?= $tanggal_akhir ?></td> </tr>
				</tbody> </table>
			<?php endif ?>
		</p>
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr class="text-center">
					<th class="font-weight-bold">No.</th>
					<th class="font-weight-bold">Tanggal</th>
					<th class="font-weight-bold">ID/No. Transaksi</th>
					<th class="font-weight-bold">Keterangan</th>
					<th class="font-weight-bold">Kuantitas (per Rak)</th>
					<th class="font-weight-bold text-right">Harga</th>
				</tr>
			</thead>
			<tbody>
				<?php if (mysqli_num_rows($transaksiAll) < 1) : ?>
					<tr class="font-weight-bold text-center"><td colspan="6">Maaf, data belum ada..!</td></tr>
				<?php else : ?>
					<?php $inc = $i; ?>
					<tr class="font-weight-bold text-left"><td colspan="6">Pemasukan</td></tr>
					<?php while ($transaksi = mysqli_fetch_array($transaksiAll, MYSQLI_BOTH)) : ?>
						<?php if ($transaksi['jenis_transaksi'] == 'masuk') : ?>
							<tr>
								<td><?= $inc ?></td>
								<td><?= $transaksi['tgl_transaksi'] ?></td>
								<td><?= $transaksi['id_no_transaksi'] ?></td>
								<td><?= $transaksi['keterangan'] ?></td>
								<td><?= $transaksi['kuantitas'] ?></td>
								<td class="text-right"><?= format($transaksi['harga'], 'currency') ?></td>
							</tr>
							<?php $totalKuantitasMasuk += (int) $transaksi['kuantitas'] ; $totalMasuk += (int) $transaksi['harga']; $inc++; ?>
						<?php endif ?>
					<?php endwhile ?>
					<tr class="font-weight-bold text-right"><td colspan="4">Total Pemasukan</td><td><?= $totalKuantitasMasuk ?></td><td><?= format($totalMasuk, 'currency') ?></td></tr>

					<tr class="font-weight-bold text-left"><td colspan="6">Pengeluaran</td></tr>
					<?php foreach ($transaksiAll as $transaksi) : ?>
						<?php if ($transaksi['jenis_transaksi'] == 'keluar') : ?>
							<tr>
								<td><?= $inc ?></td>
								<td><?= $transaksi['tgl_transaksi'] ?></td>
								<td><?= $transaksi['id_no_transaksi'] ?></td>
								<td><?= $transaksi['keterangan'] ?></td>
								<td><?= $transaksi['kuantitas'] ?></td>
								<td class="text-right"><?= format($transaksi['harga'], 'currency') ?></td>
							</tr>
							<?php $totalKuantitasKeluar += (int) $transaksi['kuantitas']; $totalKeluar += (int) $transaksi['harga']; $inc++; ?>
						<?php endif ?>
					<?php endforeach ?>
					<tr class="font-weight-bold text-right"><td colspan="4">Total Pengeluaran</td><td><?= $totalKuantitasMasuk ?></td><td><?= format($totalKeluar, 'currency'); ?></td></tr>

					<?php $totalUntungRugi = $totalMasuk - $totalKeluar; ?>
				<?php endif ?>
			</tbody>
			<tfoot>
				<tr class="font-weight-bold text-right"><td colspan="5">Total Keuntungan / Kerugian (Total Pemasukan - Total Pengeluaran)</td><td><?= format($totalUntungRugi, 'currency'); ?></td></tr>
			</tfoot>
		</table>
	</body>
</html>
<?php
	$html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
	ob_end_clean();

	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper('A4', 'landscape');
	// $dompdf->setPaper(array(0, 0, 550, 300));

	$dompdf->loadHtml(utf8_encode($html));

	// Render the HTML as PDF
	$dompdf->render();

	// Output the generated PDF to Browser
	$dompdf->stream("Laporan_Arus_Kas_" . date('Y-m-d') . ".pdf", array("Attachment" => 0));

	// exit(0);
?>