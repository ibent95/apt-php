<?php

	require_once 'load_files.php';

	include_once 'plugins/dompdf/autoload.inc.php';

	$dateNow						= date('Y-m-d');
	$id								= (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;

	$transaksi						= mysqli_fetch_array(getTransaksiJoinAllById($id), MYSQLI_BOTH);

	$transaksiDetailAll				= getDetailTransaksiJoinAllByIdTransaksi($transaksi['id_transaksi']);
	if (!empty($transaksi['longlat'])) {
		$longlat					= explode(",", $transaksi['longlat']);
	} else {
		$longlat[0]					= 0;
		$longlat[1]					= 0;
	}
	$riwayatPembayaran				= getBuktiPembayaranByIdTransaksi($transaksi['id_transaksi'], NULL, 'DESC');
	// $biayaTambahanAll = getBiayaTambahanByIdTransaksi($transaksi['id_transaksi']);
	$biayaKerusakanAll				= getBiayaKerusakanByIdTransaksi($transaksi['id_transaksi']);

	$biayaTambahanAll				= getBiayaTambahanByIdTransaksi($id);
	// $riwayatPembayaran				= getBuktiPembayaranByIdTransaksi($id, '', 'ASC');
	$sisaPembayaran					= 0;

	foreach ($transaksiDetailAll as $data) {
		$sisaPembayaran				+= $data['jumlah_harga'];
	}
	foreach ($biayaTambahanAll as $data) {
		$sisaPembayaran				+= $data['jumlah'];
	}
	foreach ($riwayatPembayaran as $data) {
		if ($data['konfirmasi_admin'] == 'ya' OR $data['konfirmasi_admin'] == 'belum') {
			$sisaPembayaran			-= $data['jumlah'];
		}
	}
	$transaksi['status_pembayaran']	= (mysqli_num_rows($riwayatPembayaran) !== 0 AND $sisaPembayaran === 0) ? "Lunas" : "Belum Lunas" ;
	if (!empty($transaksi['longlat'])) {
		$longlat					= explode(",", $transaksi['longlat']);
	} else {
		$longlat[0]					= 0;
		$longlat[1]					= 0;
	}
	$no								= 1;
	$totalHarga						= 0;
	$i								= 1;

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
		<title>Nota Transaksi</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<style>
			.text-center {
				text-align: center;
			}
			.text-right {
				text-align: right;
			}
			.text-left {
				text-align: left;
			}
			.font-weight-bold {
				font-weight: bold;
			}
			h1, h2, h3 {
				text-align: center;
			}
			div.cover {
				text-align: center;
				vertical-align: middle;
				margin: 40% 0% 60% 0%;
				padding: auto;
			}
			table.table {
				border-collapse: collapse;
				border: 2px solid black;
				font-size: 8pt;
				width: 100%;
			}
			table.table thead {
				border-bottom: 2px solid black;
			}
			table.table thead tr th {
				border: 2px solid black;
				padding: 1.5px 2px 1.5px 2px;
				background-color: #6d7878;
				color: white;
				height: 1px;
				font-size: 8pt;
				text-align: center;
			}
			table.table tbody tr td {
				border: 1px solid black;
				border-right: 2px solid black;
				padding: 6px;
			}
			table.table tr:nth-child(even) {
				background-color: #f2f2f2;
			}
			div.page-brake {
				page-break-before: always;
				/* page-break-after: always; */
			}
		</style>
	</head>
	<body>
		<p class="text-dark">
			<h2 class="text-center">Nota Transaksi</h2>
		</p>
		<div class="">
			<table>
				<tbody>
					<tr>
						<td>No. Transaksi</td>
						<td>:</td>
						<td><?php echo $transaksi['no_transaksi']; ?></td>
					</tr>
					<tr>
						<td>Tanggal</td>
						<td>:</td>
						<td><?php echo $transaksi['tgl_transaksi']; ?></td>
					</tr>
					<tr>
						<td>Nama Pelanggan</td>
						<td>:</td>
						<td><?php echo $transaksi['nama_pelanggan']; ?></td>
					</tr>
					<tr>
						<td>No. Telp</td>
						<td>:</td>
						<td><?php echo $transaksi['no_telp']; ?></td>
					</tr>
					<tr>
						<td>Datang ke Lokasi</td>
						<td>:</td>
						<td><?php echo $transaksi['diantarkan']; ?></td>
					</tr>
					<!-- <?php //if ($transaksi['keluhan'] != null OR $transaksi['keluhan'] != '') : ?>
						<tr>
							<td>Keluhan</td>
							<td>:</td>
							<td><?php //echo $transaksi['keluhan']; ?></td>
						</tr>
					<?php //endif ?> -->
					<?php if ($transaksi['diantarkan'] != 'tidak') : ?>
						<tr>
							<td>Tanggal Kerja</td>
							<td>:</td>
							<td><?php echo $transaksi['tgl_pengantaran']; ?></td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td>:</td>
							<td><?php echo $transaksi['alamat']; ?></td>
						</tr>
					<?php endif ?>
				</tbody>
			</table>
		</div>
		<label for="table" class="">Data Pembelian</label>
		<!-- <div class="table-responsive"> -->
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>Nama Barang</th>
						<th>Harga</th>
					</tr>
				</thead>
				<tbody>
					<?php if (mysqli_num_rows($transaksiDetailAll) == 0 AND mysqli_num_rows($diagnosisHardware) == 0 AND mysqli_num_rows($diagnosisSparepart) == 0 AND mysqli_num_rows($biayaTambahanAll) == 0) : ?>
						<tr>
							<td colspan="2" style="text-align: center;">
								<?php if ($transaksi['status_transaksi'] == 'selesai' OR $transaksi['status_transaksi'] == 'batal') : ?>
									Tidak
								<?php elseif ($transaksi['status_transaksi'] == 'tunggu' OR $transaksi['status_transaksi'] == 'proses') : ?>
									Belum
								<?php endif ?>
								ada Pengerjaan..!
							</td>
						</tr>
					<?php else : ?>
						<?php if (mysqli_num_rows($transaksiDetailAll) > 0) : ?>
							<tr>
								<td class="text-left font-weight-bold" colspan="2">
									&nbsp;&nbsp; Software
								</td>
							</tr>
							<?php foreach ($transaksiDetailAll as $data): ?>
								<tr>
									<td>
										<?php
											echo $no . ". " . $data['nama_telur'];
											$no++;
										?>
									</td>
									<td class="text-right">
										<?php
											echo format($data['jumlah_harga'], 'currency');
											$totalHarga = $totalHarga + $data['jumlah_harga'];
										?>

									</td>
								</tr>
							<?php endforeach ?>
						<?php endif ?>
						<?php if (mysqli_num_rows($biayaTambahanAll) > 0) : ?>
							<tr>
								<td class="text-left font-weight-bold" colspan="2">
									&nbsp;&nbsp;  Biaya Tambahan
								</td>
							</tr>
							<?php foreach ($biayaTambahanAll as $data): ?>
								<tr>
									<td>
										<?php
											echo $no . ". " . $data['keterangan'];
											$no++;
										?>
									</td>
									<td class="text-right">
										<?php
											echo format($data['jumlah'], 'currency');
											$totalHarga = $totalHarga + $data['jumlah'];
										?>
									</td>
								</tr>
							<?php endforeach ?>
						<?php endif ?>
					<?php endif ?>
					<tr style="font-weight: bold;">
						<td style="text-align: right;">
							<?php if ($transaksi['status_transaksi'] == 'selesai') : ?>
								Total Harga
							<?php else : ?>
								Total Estimasi
							<?php endif ?>
						</td>
						<td class="font-weight-bold text-right">
							<?php echo format($totalHarga, 'currency'); ?>
						</td>
					</tr>
					<!-- Riwayat Pembayaran -->
					<?php if (mysqli_num_rows($riwayatPembayaran) > 0) : ?>

						<tr style="font-weight: bold;">
							<td style="text-align: left;" colspan="2">
								&nbsp;&nbsp; Riwayat Pembayaran
							</td>
						</tr>
						<?php foreach ($riwayatPembayaran as $pembayaran): ?>
							<?php if ($pembayaran['konfirmasi_admin'] == 'ya' OR $pembayaran['konfirmasi_admin'] == 'belum'): ?>
								<tr>
									<td>
										<?php
											echo $no . ". ";
											$no++;
										?>
										Pembayaran <?php echo $pembayaran['info_pembayaran']; ?> tanggal <?php echo format($pembayaran['tgl_pembayaran'], "date"); ?>

									</td>
									<td class="text-right">
										<?php
											echo format($pembayaran['jumlah'], "currency");
											$totalHarga = $totalHarga - $pembayaran['jumlah'];
										?>
									</td>
								</tr>
							<?php endif ?>
						<?php endforeach ?>
					<?php endif ?>
					<tr>
						<td class="text-right font-weight-bold">
							<?php //if ($transaksi['status_transaksi'] == 'proses' AND $transaksi['teknisi_check'] == 'selesai') : ?>
								Sisa Pembayaran
							<?php //else : ?>
								<!-- Total Estimasi -->
							<?php //endif ?>
						</td>
						<td class="font-weight-bold text-right">
							<?php echo format($totalHarga, 'currency'); ?>
						</td>
					</tr>
				</tbody>
			</table>
		<!-- </div> -->
	</body>
</html>
<?php
	$html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
	ob_end_clean();

	// (Optional) Setup the paper size and orientation
	// $dompdf->setPaper('A4', 'potrait');
	$dompdf->setPaper(array(0, 0, 550, 600));

	$dompdf->loadHtml(utf8_encode($html));

	// Render the HTML as PDF
	$dompdf->render();

	// Output the generated PDF to Browser
	$dompdf->stream("Nota_" . $transaksi['no_transaksi'] . "_" . $dateNow . ".pdf", array("Attachment" => 0));

	// exit(0);
?>