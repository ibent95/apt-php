<?php
$action = (isset($_GET['action'])) ? $_GET['action'] : NULL;
$id = (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL;
if ($action == NULL) {
	$_SESSION['message-type'] = "success";
	$_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";
	echo "<script>location.replace('?content=data_transaksi')</script>";
}
// if ($action == 'persetujuan') {
$transaksi = mysqli_fetch_array(getTransaksiJoinAllById($id), MYSQLI_BOTH);
$transaksiDetailAll = getDetailTransaksiJoinAllByIdTransaksi($transaksi['id_transaksi']);
$buktiPembayaran = (($action == 'konfirmasi_pembayaran')) ? mysqli_fetch_assoc(getBuktiPembayaranByIdTransaksi($id)) : NULL;
if (!empty($transaksi['longlat'])) {
	$longlat = explode(",", $transaksi['longlat']);
} else {
	$longlat[0] = 0;
	$longlat[1] = 0;
}
// }
$totalHarga = 0;
?>
<div class="breadcrumbs">
	<div class="col-sm-4">
		<div class="page-header float-left">
			<div class="page-title">
				<h1>Transaksi</h1>
			</div>
		</div>
	</div>
	<div class="col-sm-8">
		<div class="page-header float-right">
			<div class="page-title">
				<ol class="breadcrumb text-right">
					<li class=""><a href="javascript:void(0)">Home</a></li>
					<li class=""><a href="?content=data_transaksi">Transaksi</a></li>
					<li class="active">Rincian</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<!-- Container fluid  -->
<div class="content mt-3">
	<div class="col-md-12">

		<div class="card">

			<div class="card-header">
				<h4>Form Transaksi - Rincian</h4>
			</div>

			<div class="card-body">

				<?php if ($action == "persetujuan") : ?>
					<p class="text-dark">
						Tindak lanjut atau persetujuan untuk transaksi :
					</p>
				<?php endif ?>

				<div class="text-dark">
					<div class="row">
						<div class="col-md-5">

							<div class="form-group row">
								<label class="col-md-4 col-form-label">ID. Transaksi</label>
								<div class="col-md-8">
									<input class="form-control-plaintext" type="text" value=": <?php echo $transaksi[0]; ?>" disabled />
								</div>
							</div>

							<div class="form-group row">
								<label class="col-md-4 col-form-label">Tanggal Transaksi</label>
								<div class="col-md-8">
									<input class="form-control-plaintext" type="text" value=": <?php echo $transaksi['tgl_transaksi']; ?>" disabled />
								</div>
							</div>

							<div class="form-group row">
								<label class="col-md-4 col-form-label">Pelanggan</label>
								<div class="col-md-8">
									<input class="form-control-plaintext" type="text" value=": <?php echo $transaksi['nama_pelanggan']; ?>" disabled />
								</div>
							</div>

							<div class="form-group row">
								<label class="col-md-4 col-form-label">NIK</label>
								<div class="col-md-8">
									<input class="form-control-plaintext" type="text" value=": <?php echo $transaksi['nik']; ?>" disabled />
								</div>
							</div>

							<div class="form-group row">
								<label class="col-md-4 col-form-label">Identitas (KTP)</label>
								<div class="col-md-8">
									: <a href='<?= searchFile("$transaksi[foto_ktp]", "img", "short") ?>' target="_blank" rel="noopener noreferrer">
										<img class=" img-thumbnail" width='90dp' src='<?= searchFile("$transaksi[foto_ktp]", "img", "short") ?>' id="image_gallery">
									</a>
								</div>
							</div>
							<!-- 
							<div class="form-group row">
								<label class="col-md-4 col-form-label">Status Pembayaran</label>
								<div class="col-md-8">
									<div class="form-control-plaintext">
										: <?php //echo setBadges($transaksi['status_pembayaran']); 
											?>
									</div>
								</div>
							</div> -->

							<?php if (!empty($buktiPembayaran['bukti_pembayaran'])) : ?>
								<div class="form-group row">
									<label class="col-md-4 col-form-label">Bukti Pembayaran</label>
									<div class="col-md-8">
										<a href="<?= searchFile("$buktiPembayaran[bukti_pembayaran]", "img", "short") ?>" target="_blank" rel="noopener noreferrer">
											<img class=" img-thumbnail" width='90dp' src='<?= searchFile("$buktiPembayaran[bukti_pembayaran]", "img", "short"); ?>' id="image_gallery">
										</a>
									</div>
								</div>
							<?php endif ?>

						</div>

						<div class="col-md-7">
							<?php if ($transaksi['keterangan'] != null or $transaksi['keterangan'] != "") : ?>
								<div class="form-group row">
									<label class="col-md-3 col-form-label">Keterangan</label>
									<div class="col-md-9">
										<div class="form-control-plaintext">
											: <?php echo $transaksi['keterangan']; ?>
										</div>
									</div>
								</div>
							<?php endif ?>
							<div class="form-group row">
								<label class="col-md-3 col-form-label">Diantarkan</label>
								<div class="col-md-9">
									<div class="form-control-plaintext">
										: <?php echo setBadges($transaksi['diantarkan']); ?>
									</div>
								</div>
							</div>
							<?php if ($transaksi['diantarkan'] == 'ya') : ?>
								<div class="form-group row">
									<label class="col-md-3 col-form-label">Tanggal Pengantaran</label>
									<div class="col-md-9">
										<input class="form-control-plaintext" type="text" value=": <?php echo $transaksi['tgl_pengantaran']; ?>" disabled />
									</div>
								</div>

								<div class="form-group row" id="form-lokasi">
									<!-- style="display: none;" -->
									<label class="col-md-3 col-form-label">Alamat Pengantaran</label>
									<div class="col-md-9">
										<textarea class="form-control-plaintext" id="alamat" readonly>: <?php echo $transaksi[9]; ?></textarea>
									</div>
								</div>
							<?php endif ?>
						</div>
					</div>

					<form class="form-horizontal" <?php if ($action == 'persetujuan') : ?> action="?content=data_transaksi_persetujuan_proses&proses=edit" <?php else : ?> action="?content=data_transaksi_persetujuan_proses&proses=payment_confirm" <?php endif ?> method="POST" enctype="multipart/form-data">
						<?php if ($action == 'konfirmasi_pembayaran') : ?>
							<input type="hidden" name="id" value="<?php echo antiInjection($_GET['id']); ?>">

							<div class="form-group row">
								<label for="status_transaksi" class="col-md-3 control-label">Konfirmasi Pembayaran</label>
								<div class="col-md-5">
									<select class="form-control input-rounded input-focus" name="konfirmasi_admin" id="konfirmasi_admin">
										<option value="">-- Silahakan Pilih Status --</option>
										<option value="ya">Ya</option>
										<option value="tidak">Tidak</option>
									</select>
								</div>
							</div>
						<?php elseif ($action == 'persetujuan') : ?>
							<input type="hidden" name="id" value="<?php echo antiInjection($_GET['id']); ?>">

							<div class="form-group row">
								<label for="status_transaksi" class="col-md-3 control-label">Persetujuan</label>
								<div class="col-md-5">
									<select class="form-control input-rounded input-focus" name="status_transaksi" id="status_transaksi">
										<option value="">-- Silahakan Pilih Status --</option>
										<option value="proses">Proses</option>
										<option value="batal">Batal</option>
									</select>
								</div>
							</div>
						<?php endif ?>

						<?php if ($action != 'lihat') : ?>
							<div class="form-group pull-left">
								<div class="col-md-12">
									<input type="submit" class="btn btn-primary" name="simpan" value="Simpan" />
									<input type="reset" class="btn btn-danger" value="Reset" />
								</div>
							</div>
						<?php endif ?>

					</form>
				</div>
				<!-- End Card Body -->

			</div>
			<!-- End Card -->

		</div>
		<!-- End Row -->

	</div>

	<!-- <script async defer src='https://maps.googleapis.com/maps/api/js?key=AIzaSyB6bHo5JkixK-_Ct1TWEy4ZDdiuRqbwkpw&callback=initMap'>
</script> -->