<?php
	$action = (isset($_GET['action'])) ? $_GET['action'] : NULL;
	$id = (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL;
	if ($id == NULL) {
		$_SESSION['message-type'] = "danger";
		$_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";
		echo "<script>window.location.replace('?content=transaksi')</script>";
	}
	// if ($action == 'persetujuan') {
	$transaksi = mysqli_fetch_array(getTransaksiJoinAllById($id), MYSQLI_BOTH);
	$transaksiDetailAll = getDetailTransaksiJoinAllByIdTransaksi($transaksi['id_transaksi']);
	if (!empty($transaksi['longlat'])) {
		$longlat = explode(",", $transaksi['longlat']);
	} else {
		$longlat[0] = 0;
		$longlat[1] = 0;
	}
	$pembayaran = mysqli_fetch_array(getBuktiPembayaranByIdTransaksi($transaksi['id_transaksi'], NULL, 'DESC'), MYSQLI_BOTH);
	$biayaTambahanAll = getBiayaTambahanByIdTransaksi($transaksi['id_transaksi']);
	$biayaKerusakanAll = getBiayaKerusakanByIdTransaksi($transaksi['id_transaksi']);
	$totalHarga = 0;
	$inc = 1;
	// }
?>
<!-- ##### Breadcrumb Area Start ##### -->
<div class="breadcrumb-area">
	<!-- Top Breadcrumb Area -->
	<div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(assets/frontend/img/bg-img/24.jpg);">
		<h2>Transaksi Detail</h2>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-12">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?= $csv::$URL_BASE ?>"><i class="fa fa-home fa-fw"></i> Home</a></li>
						<li class="breadcrumb-item"><a href="<?= $csv::$URL_BASE ?>/?content=transaksi"><i class="fa fa-first-order fa-fw"></i> Transaksi</a></li>
						<li class="breadcrumb-item active" aria-current="page">
							<i class="fa fa-list fa-fw"></i>
							Transaksi Detail
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
		<div class="row">
			<div class="col-md-12">
				<div class="text-dark">
					<p class="">
						<button class="btn btn-default text-dark" onclick="window.history.go(-1);" role="button" data-toggle="button" aria-pressed="false" autocomplete="off">
							<i class="fa fa-arrow-left"></i>
							Kembali
						</button>
					</p>
					<div class="card-title">
						<h4><?php if ($action == "persetujuan") echo "Form Persetujuan "; ?></h4>
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
										<label class="col-md-4 col-form-label">NO. Transaksi</label>
										<div class="col-md-8">
											<input class="form-control-plaintext" type="text" value=": <?= $transaksi['no_transaksi'] ?>" disabled />
										</div>
									</div>

									<div class="form-group row">
										<label class="col-md-4 col-form-label">Tanggal Transaksi</label>
										<div class="col-md-8">
											<input class="form-control-plaintext" type="text" value=": <?= $transaksi['tgl_transaksi'] ?>" disabled />
										</div>
									</div>

									<div class="form-group row">
										<label class="col-md-4 col-form-label">Pelanggan</label>
										<div class="col-md-8">
											<input class="form-control-plaintext" type="text" value=": <?= $transaksi['nama_pelanggan'] ?>" disabled />
										</div>
									</div>

									<div class="form-group row">
										<label class="col-md-4 col-form-label">Info Pembayaran</label>
										<div class="col-md-8">
											<div class="form-control-plaintext text-uppercase">
												: <?= setBadges($pembayaran['info_pembayaran']) ?>
											</div>
										</div>
									</div>

									<?php
									if (!empty($transaksi['bukti_pembayaran'])) :
										?>
										<div class="form-group row">
											<label class="col-md-4 col-form-label">Bukti Pembayaran</label>
											<div class="col-md-8">
												<img class=" img-thumbnail" width='90dp' src='<?= searchFile("$transaksi[bukti_pembayaran]", "img", "short") ?>' id="image_gallery">
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
													: <?= $transaksi['keterangan'] ?>
												</div>
											</div>
										</div>
									<?php endif ?>
									<div class="form-group row">
										<label class="col-md-3 col-form-label">Diantarkan</label>
										<div class="col-md-9">
											<div class="form-control-plaintext">
												: <?= setBadges($transaksi['diantarkan']) ?>
											</div>
										</div>
									</div>
									<?php if ($transaksi['diantarkan'] == 'ya') : ?>
										<div class="form-group row">
											<label class="col-md-3 col-form-label">Tanggal Pengantaran</label>
											<div class="col-md-9">
												<input class="form-control-plaintext" type="text" value=": <?= $transaksi['tgl_pengantaran'] ?>" disabled />
											</div>
										</div>

										<div class="form-group row" id="form-lokasi">
											<!-- style="display: none;" -->
											<label class="col-md-3 col-form-label">Alamat Pengantaran</label>
											<div class="col-md-9">
												<textarea class="form-control-plaintext" id="alamat" cols="30" rows="1">: <?= $transaksi['alamat'] ?></textarea>
											</div>
										</div>
									<?php endif ?>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<label for="table" class="">Data Belanjaan</label>
									<div class="table-responsive">
										<table class="table table-bordered table-hover">
											<thead>
												<tr>
													<th>NO</th>
													<th>ID Barang</th>
													<th>Nama Barang</th>
													<th>Harga Satuan (Rp)</th>
													<th>Kuantitas</th>
													<th>Jumlah Harga (Rp)</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($transaksiDetailAll as $data2) : ?>
													<tr>
														<td><?= $inc ?></td>
														<td>
															<?= $data2['id_telur']; ?>
														</td>
														<td>
															<?= $data2['nama_telur']; ?>
														</td>
														<td class="text-right">
															<?= format($data2['harga_jual'], 'currency'); ?>
														</td>
														<td>
															<?= $data2['kuantitas']; ?>
														</td>
														<td class="text-right">
															<?php 
																echo format($data2['jumlah_harga'], 'currency');
																$totalHarga += $data2['jumlah_harga'];
															?>
														</td>
													</tr>
													<?php $inc++; ?>
												<?php endforeach ?>
											</tbody>
											<tfoot>
												<tr class="text-right font-weight-bold">
													<td colspan="5">Total Harga (Rp)</td>
													<td>
														<?= format($totalHarga, 'currency'); ?>
													</td>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>

							<?php if (mysqli_num_rows($biayaTambahanAll) > 0) : ?>
								<div class="row">
									<div class="col-md-12">
										<label for="table" class="">Data Biaya Tambahan</label>
										<div class="table-responsive">
											<table class="table table-bordered table-hover">
												<thead>
													<tr>
														<th>NO</th>
														<th>Keterangan</th>
														<th>Jumlah (Rp)</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($biayaTambahanAll as $tambahan) : ?>
														<tr>
															<td><?= $inc ?></td>
															<td><?= $tambahan['keterangan'] ?></td>
															<td class="text-right">
																<?php
																	echo format($tambahan['jumlah'], 'currency');
																	$totalHarga += $tambahan['jumlah'];
																?>
															</td>
														</tr>
														<?php $inc++; ?>
													<?php endforeach ?>
												</tbody>
												<tfoot>
													<tr class="text-right font-weight-bold">
														<td colspan="2">Total Harga (Rp)</td>
														<td>
															<?= format($totalHarga, 'currency') ?>
														</td>
													</tr>
												</tfoot>
											</table>
										</div>
									</div>
								</div>
							<?php endif ?>

							<?php if (mysqli_num_rows($biayaKerusakanAll) > 0) : ?>
								<div class="row">
									<div class="col-md-12">
										<label for="table" class="">Data Biaya Kerusakan</label>
										<div class="table-responsive">
											<table class="table table-bordered table-hover">
												<thead>
													<tr>
														<th>NO</th>
														<th>Keterangan</th>
														<th>Jumlah (Rp)</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($biayaKerusakanAll as $kerusakan) : ?>
														<tr>
															<td><?= $inc ?></td>
															<td>
																<?= $kerusakan['keterangan'] ?>
															</td>
															<td class="text-right">
																<?php
																	echo format($kerusakan['jumlah'], 'currency');
																	$totalHarga -= $kerusakan['jumlah'];
																?>
															</td>
														</tr>
														<?php $inc++; ?>
													<?php endforeach ?>
												</tbody>
												<tfoot>
													<tr class="text-right font-weight-bold">
														<td colspan="2">Total Harga (Rp)</td>
														<td>
															<?= format($totalHarga, 'currency'); ?>
														</td>
													</tr>
												</tfoot>
											</table>
										</div>
									</div>
								</div>
							<?php endif ?>
						</div>
					</div>
				</div>
				<!-- End Card Body -->
			</div>
		</div>
	</div>
</section>