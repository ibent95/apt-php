<?php
	cekLogin("pelanggan");

	$idTransaksi 	= (isset($_GET['noTransaksi'])) ? $_GET['noTransaksi'] : NULL ;
	$transaksi  = mysqli_fetch_array(getTransaksiByNoTransaksi($idTransaksi), MYSQLI_BOTH);
	$cek = mysqli_query($koneksi, "SELECT `konfirmasi_admin`, `bukti_pembayaran` FROM `data_riwayat_pembayaran` WHERE `id_transaksi` = '$transaksi[id_transaksi]' AND `konfirmasi_admin` = 'ya' AND `bukti_pembayaran` NOT LIKE NULL") ;
	if (mysqli_num_rows($cek) >= 1) {
		$_SESSION['type-pesan'] = "danger";
		$_SESSION['pesan']      = "Bukti pembayaran telah dikirim, silahkan tunggu informasi dari pihak penjual..!";
		echo "<script>window.location.href = '?content=profil'</script>";
	}
	$detailTransaksi = getDetailTransaksiByIdTransaksi($transaksi['id_transaksi']);
	$biayaTambahanAll = getBiayaTambahanByIdTransaksi($transaksi['id_transaksi']);
	$totalHarga = 0;
	foreach ($detailTransaksi as $detail) {
		$totalHarga += $detail['jumlah_harga'];
	}
	if (mysqli_num_rows($biayaTambahanAll) > 0) {
		foreach ($biayaTambahanAll as $tambahan) {
			$totalHarga += $tambahan['jumlah'];
		}
	}
	$noRekening = mysqli_fetch_array(getKonfigurasiUmum("no_rek_transaksi", "multiple"), MYSQLI_BOTH);
?>
<!-- ##### Breadcrumb Area Start ##### -->
<div class="breadcrumb-area">
	<!-- Top Breadcrumb Area -->
	<div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(assets/frontend/img/bg-img/24.jpg);">
		<h2>Pembayaran</h2>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-12">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo $csv::$URL_BASE; ?>"><i class="fa fa-home fa-fw"></i> Home</a></li>
						<li class="breadcrumb-item"><a href="<?php echo $csv::$URL_BASE; ?>/?content=transaksi"><i class="fa fa-first-order fa-fw"></i> Transaksi</a></li>
						<li class="breadcrumb-item active" aria-current="page">
							<i class="fa fa-list fa-fw"></i>
							Transaksi Form
						</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<!-- ##### Breadcrumb Area End ##### -->
<!-- ##### Blog Area Start ##### -->
<section class="alazea-blog-area section-padding-0-100">
	<div class="container">
		<?= getNotifikasi() ?>
		<div class="form-horizontal">
			<div class="form-group row">
				<label class="col-md-3 col-form-label">Nama Pelanggan</label>
				<div class="col-md-9">
					<label class="col-form-label">
						: <?php echo $_SESSION['nama']; ?>
					</label>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-3 col-form-label">No. Transaksi</label>
				<div class="col-md-9">
					<label class="col-form-label">
						: <?php echo $transaksi['no_transaksi']; ?>
					</label>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-md-3 col-form-label">Total Harga</label>
				<div class="col-md-9">
					<label class="col-form-label">
						: <?= format($totalHarga, 'currency') ?>
					</label>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-md-3 col-form-label">Metode Pembayaran</label>
				<div class="col-md-9">
					<label class="col-form-label">
						: 
					</label>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-9">
				<form class="form-horizontal" action="?content=pembayaran_proses&proses=add" method="POST" role="form" id="konfirmasi-form" enctype="multipart/form-data">

					<input type="hidden" name="id" value="<?= $transaksi['id_transaksi'] ?>" />

					<input type="hidden" name="total_harga" value="<?= $totalHarga ?>" />

					<input type="hidden" name="metode_pembayaran" value="transfer" />

					<div class="form-group row">
						<label class="col-md-3 col-form-label">Bukti Pembayaran</label>
						<div class="col-md-9">
							<input class="form-control form-control-sm" type="file" name="bukti_pembayaran" id="bukti_pembayaran" role="button" required />
						</div>
					</div>

					<div class="form-group row">
						<div class="offset-md-3 col-md-9">
							<button class="btn btn-success" type="submit" name="checkout" role="button">Upload</button>
							<button class="btn btn-default" type="button" role="button" onclick="window.location.href='?content=profil'">Keluar</button>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-3">
				<div class="card text-white bg-warning mb-5" style="width: 18rem;">
					<div class="card-header">
						Info Transfer
					</div>
					<div class="card-body text-dark bg-light">
						<div class="form">
							<div class="form-group">
								<label class="col-md-12 col-form-label">Info Bank : </label>
								<div class="col-md-12">
									<?= $noRekening['keterangan'] ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-12 col-form-label">No. Rek : </label>
								<div class="col-md-12">
									<?= $noRekening['nilai_konfigurasi'] ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>