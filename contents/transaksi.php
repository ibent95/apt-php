<?php
	cekLogin('pelanggan');
	if (isset($_GET['proses']) and $_GET['proses'] == "ganti-password" and isset($_POST['currentPassword']) and isset($_POST['newPassword'])) {
		$proses = $_GET['proses'];
		// $result = ;
		if (changePassword($_POST['currentPassword'], $_POST['newPassword'], $_SESSION['id_pelanggan']) == TRUE) {
			echo "<script>window.location.replace('$csv::$URL_BASE/?content=profil'); </script>";
		} else {
			echo "<script>window.location.replace('$csv::$URL_BASE/?content=beranda'); </script>";
		}
	} elseif (isset($_GET['proses']) and $_GET['proses'] == "ganti_foto_profil") {
		if (changeFotoPelanggan($_SESSION['id'], $_FILES['url_foto'])) {
			echo "<script>window.location.replace('" . $csv::$URL_BASE . "/?content=profil'); </script>";
		} else {
			echo "<script>window.location.replace('" . $csv::$URL_BASE . "/?content=profil'); </script>";
		}
	}
	$pelanggan	= mysqli_fetch_array(getPelangganById($_SESSION['id']), MYSQLI_BOTH);
	$orPending	= getTransaksiSubJoinByIdPelanggan($_SESSION['id'], 'tunggu');
	$orProses	= getTransaksiSubJoinByIdPelanggan($_SESSION['id'], 'proses_batal');
	$orSelesai	= getTransaksiSubJoinByIdPelanggan($_SESSION['id'], 'selesai');
	$orBatal	= getTransaksiSubJoinByIdPelanggan($_SESSION['id'], 'batal');
	// Load Cart
	// $keranjang = NULL;
?>
<!-- ##### Breadcrumb Area Start ##### -->
<div class="breadcrumb-area">
	<!-- Top Breadcrumb Area -->
	<div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(assets/frontend/img/bg-img/24.jpg);">
		<h2>Transaksi</h2>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-12">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?= $csv::$URL_BASE ?>"><i class="fa fa-home"></i> Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">
							<i class="fa fa-first-order"></i>
							Transaksi
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
				<!-- Section Heading -->
				<!-- <div class="section-heading text-center">
					<h2>Profil</h2>
					<p>The breaking news about Gardening &amp; House plants</p>
					<p><?php //echo generateToken(); ?></p>
				</div> -->
				<div class="row">
					<div class="col-md-12">

						<!-- Keranjang -->
						<div id="keranjang">
							<p>
								<h3>Keranjang</h3>
							</p>
							<div class="row">
								<div class="col-md-12">

									<div class="table-responsive">
										<table class="table table-bordered table-hover table-striped">
											<thead>
												<tr>
													<th>NO</th>
													<th>Nama Produk / Harga Satuan (per Rak)</th>
													<th>Kuantitas</th>
													<th>Total Harga</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php if (isset($_SESSION['cart'])) : ?>
													<?php $inc = 1; ?>  
													<!-- <?php //print_r(array_keys($_SESSION["cart"])); ?> -->
													<?php foreach ($_SESSION["cart"] as $item) : ?>
														<tr>
															<td> <?= $inc ; ?> </td>
															<td class=""> <?= $item['nama_telur'] . " / [" . format($item['harga_jual'], "currency") . "]" ?> </td>
															<td class="text-right"> <?php echo $item['kuantitas']; ?> </td>
															<td class="text-right"> <?php echo format($item['jumlah_harga'], "currency"); ?> </td>
															<td>
																<?php $maxKuantitas = mysqli_fetch_array(getTelurById($item['id_telur']), MYSQLI_BOTH)['persediaan']; ?>
																<!-- style="background-color: purple;" -->
																<button
																	type="button"
																	class="btn btn-success btn-sm"
																	data-toggle="modal"
																	data-target="#modal_chart_update_item"
																	data-id_telur="<?php echo $item['id_telur']; ?>"
																	data-nama_telur="<?php echo $item['nama_telur']; ?>"
																	data-harga_jual="<?php echo $item['harga_jual']; ?>"
																	data-kuantitas="<?php echo $item['kuantitas']; ?>"
																	data-maxkuantitas="<?php echo $maxKuantitas; ?>"
																	data-jh="<?php echo $item['jumlah_harga']; ?>"
																	data-act="cart_update_item"
																	id="cart-add"

																>
																	<i class="fa fa-pencil"></i>
																	Ubah
																</button>
																<a class="btn btn-danger btn-sm" href="?content=keranjang_proses&proses=remove&id_telur=<?php echo $item['id_telur']; ?>">
																	<i class="fa fa-times"></i>
																	Hapus
																</a>
															</td>
														</tr>
														<?php $inc++; ?>
													<?php endforeach ?>
												<?php else : ?>
													<tr>
														<td colspan="5">
															<p class="text-center">
																Data barang belum ada, anda belum memilih barang..! Silahkan kembali untuk memilih barang..! <br>
																<a class="btn btn-dark btn-sm" href="?content=produk" role="button">
																	<i class="fa fa-arrow-left"></i>
																	Kembali
																</a>
															</p>
														</td>
													</tr>
												<?php endif ?>
											</tbody>
										</table>
									</div>

									<?php if (isset($_SESSION['cart'])) : ?>
									<p class="text-right">
										<a class="btn btn-danger btn-sm" href="?content=keranjang_proses&proses=clear" role="button">
											<i class="fa fa-eraser"></i>
											Bersihkan
										</a>
										<a class="btn btn-primary btn-sm" href="?content=transaksi_form&action=tambah" role="button">
											Lanjutkan
											<i class="fa fa-arrow-right"></i>
										</a>
									</p>
									<?php endif ?>
								</div>
							</div>
						</div>
						<!-- Keranjang End -->

						<!-- Riwayat Transaksi -->
						<div id="riwayat_transaksi">
							<p>
								<h3>Riwayat Transaksi</h3>
							</p>
							<div class="row">
								<div class="col-md-12">
									<ul class="nav nav-tabs nav-fill" id="nav-tab" role="tablist" id="product-details-tab">
										<li class="nav-item">
											<a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="nav-home" aria-selected="true">
												Pending
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="nav-menu1-tab" data-toggle="tab" href="#menu1" role="tab" aria-controls="menu1" aria-selected="false">
												Proses
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="nav-menu2-tab" data-toggle="tab" href="#menu2" role="tab" aria-controls="menu2" aria-selected="false">
												Selesai
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="nav-menu3-tab" data-toggle="tab" href="#menu3" role="tab" aria-controls="menu3" aria-selected="false">
												Batal
											</a>
										</li>
									</ul>

									<div class="tab-content" id="nav-tabContent">
	<!-- Tab Pending -->
	<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-home-tab">
		<div class="description_area">
			<br>

			<p align="justify">
				Untuk transaksi yang telah disetujui oleh pelanggan, harap segera melakukan pembayaran dan mengirim bukti pembayarabn maksimal 5 jam setelah melakukan transaksi. Apabila tidak melakukan pengiriman bukti pembayaran dalam rentang waktu yang telah disebutkan, maka transaksi akan dibatalkan.
			</p>

			<div class="table-responsive">
				<table class="table table-striped table-hover table-bordered">
					<thead>
						<tr>
							<th>No.</th> <th>Tanggal</th> <th>Total Harga</th> <th>Datang ke Lokasi</th> <th>Status Transaksi</th> <th>Aksi</th>
						</tr>
					</thead>

					<tbody>
						<?php while ($order = mysqli_fetch_array($orPending, MYSQLI_BOTH)) : ?>
							<?php
								$persetujuanPelanggan = 'belum';
								foreach (getDetailTransaksiByIdTransaksi($order['id_transaksi'], '', '', '', 'ASC') as $data) {
									// $persetujuanPelanggan = $data['persetujuan_pelanggan'];
								}
							?>
							<tr>
								<td><?php echo $order['no_transaksi']; ?></td>
								<td><?php echo $order['tgl_transaksi']; ?></td>
								<td><?php echo format(getTotalHargaTransaksi($order['id_transaksi']), "currency"); ?></td>
								<td><?php echo setBadges($order['diantarkan']); ?></td>
								<td><?php echo setBadges($order['status_transaksi']); ?></td>
								<td>
									
									<button type="button" class="btn btn-danger btn-block btn-sm mb-2" onclick="confirm('Apakah anda yakin ingin membatalkan transaksi ini..?', '<?php echo "?content=transaksi_proses&proses=batal&id=" . $order['id_transaksi']; ?>');">
										<i class="fa fa-times"></i>
										Batal
									</button>
									<a class="btn btn-dark btn-block btn-sm mb-2" href="?content=transaksi_detail&action=lihat&id=<?php echo $order['id_transaksi']; ?>"
									>
										<i class="fa fa-list text-light"></i>
										Details
									</a>
								</td>
							</tr>
						<?php endwhile ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Tab Proses -->
	<div class="tab-pane fade" id="menu1" role="tabpanel" aria-labelledby="nav-menu1-tab">
		<div class="description_area">
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>No.</th> <th>Tanggal Transaksi</th> <th>Total Harga</th> <th>Diantarkan</th> <th>Status Transaksi</th> <th>Nota</th>
						</tr>
					</thead>
					<tbody>
						<?php while ($order = mysqli_fetch_array($orProses, MYSQLI_BOTH)) : ?>
							<?php if (($order['status_transaksi'] == 'proses') OR ($order['status_transaksi'] == 'batal' AND mysqli_num_rows(getBuktiPembayaranByIdTransaksi($order['id_transaksi'], 'lunas')) > 0) AND (getSisaPembayaranTransaksi($order['id_transaksi']) > 0)) : ?>
								<tr>
									<td><?php echo $order['no_transaksi']; ?></td>
									<td><?php echo $order['tgl_transaksi']; ?></td>
									<td><?php echo format(getTotalHargaTransaksi($order['id_transaksi']), 'currency'); ?></td>
									<td><?php echo setBadges($order['diantarkan']); ?></td>
									<td><?php echo setBadges($order['status_transaksi']); ?>
										<?php
											$pembayaran = mysqli_num_rows(getBuktiPembayaranByIdTransaksi($order['id_transaksi'], ''));
											$pembayaran = 0;
											$cekPembayaran = getBuktiPembayaranByIdTransaksi($order[0]);
											if (mysqli_num_rows($cekPembayaran) != 0) {
												foreach ($cekPembayaran as $data) {
													if ($data['konfirmasi_admin'] == 'ya' OR $data['konfirmasi_admin'] == 'belum') {
														$pembayaran += (int)$data['jumlah'];
													}
												}
											}
											if ($order['status_transaksi'] == 'tunggu' and $pembayaran == 0 and $order['kurir_check'] == "sudah") :
										?>
											<?php
												$unique = str_replace('-', '', $order['id_transaksi']);
												$date = new DateTime($order['tanggal_pesan']);
												$date->add(new DateInterval('PT5H'));
												$expiration = $date->format('Y-m-d H:i:s');
												// echo $expiration;
											?>
											<p id="countDown-<?php echo $unique; ?>"></p>
											<script type="text/javascript">
												// Display the countdown timer in an element
												// Set the date we're counting down to
												var countDownDate_<?php echo $unique; ?> = new Date("<?php echo $expiration; ?>").getTime();
												var distance_<?php echo $unique; ?>;
												// Update the count down every 1 second
												var x_<?php echo $unique; ?> = setInterval(function() {

													// Get todays date and time
													var now_<?php echo $unique; ?> = new Date().getTime();

													// Find the distance between now an the count down date
													distance_<?php echo $unique; ?> = countDownDate_<?php echo $unique; ?> - now_<?php echo $unique; ?>;

													// Time calculations for days, hours, minutes and seconds
													var days_<?php echo $unique; ?> = Math.floor(distance_<?php echo $unique; ?> / (1000 * 60 * 60 * 24));
													var hours_<?php echo $unique; ?> = Math.floor((distance_<?php echo $unique; ?> % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
													var minutes_<?php echo $unique; ?> = Math.floor((distance_<?php echo $unique; ?> % (1000 * 60 * 60)) / (1000 * 60));
													var seconds_<?php echo $unique; ?> = Math.floor((distance_<?php echo $unique; ?> % (1000 * 60)) / 1000);

													// Display the result in the element with id="demo"
													document.getElementById("countDown-<?php echo $unique; ?>").innerHTML =
															days_<?php echo $unique; ?> + " Hari " +
															hours_<?php echo $unique; ?> + " Jam " +
															minutes_<?php echo $unique; ?> + " Menit " +
															seconds_<?php echo $unique; ?> + " Detik ";
													// console.log(distance);
													// If the count down is finished, write some text
													if (distance_<?php echo $unique; ?> <= 0) {
														clearInterval(x_<?php echo $unique; ?>)     ;
														document.getElementById("countDown-<?php echo $unique; ?>").innerHTML = "Proccessing...";
														$.ajax({
															url: 'functions/function_responds.php?content=set_status_transaksi',
															type: 'POST',
															dataType: 'html',
															async: false,
															data: {
																id: '<?php echo $order['id_transaksi']; ?>',
																status_transaksi : 'batal'
															},
														}).done(function() {
															console.log("success");
															window.location.replace('?content=profil');
														}).fail(function() {
															console.log("error");
														}).always(function() {
															console.log("complete");
														});
													}
												}, 1000);
												// console.log(distance);
											</script>
										<?php endif ?>
									</td>
									<td>
										<?php
											$totalHarga = (int) getTotalHargaTransaksi($order['id_transaksi']);
											$pembayaran = 0;
											$cekPembayaran = mysqli_fetch_assoc(getBuktiPembayaranByIdTransaksi($order[0]));
											if ($cekPembayaran['konfirmasi_admin'] == 'ya' OR $cekPembayaran['konfirmasi_admin'] == 'belum') {
												$pembayaran += (int) $cekPembayaran['jumlah'];
											}
											$sisaPembayaran = $totalHarga - $pembayaran;
										?>

										<?php if ($cekPembayaran == NULL AND $pembayaran == 0 AND $order['kurir_check'] == "belum" AND $sisaPembayaran >= 0) : ?>
											<a class="btn btn-warning btn-block btn-sm mb-2" href="?content=pembayaran_method_form&action=tambah&id=<?php echo $order['id_transaksi']; ?>" >
												<i class="fa fa-upload"></i>
												Pilih Metode Pembayaran
											</a>
										<?php endif ?>
										<?php if (($cekPembayaran['bukti_pembayaran'] == '' AND $cekPembayaran['info_pembayaran'] == 'transfer') AND ($cekPembayaran['konfirmasi_admin'] == 'belum') ) : ?>
											<a class="btn btn-warning btn-sm mb-2" href="?content=pembayaran_form&action=tambah&noTransaksi=<?= $order['no_transaksi'] ?>">
												<i class="fa fa-upload"></i>
												Upload Bukti Pembayaran
											</a>
										<?php elseif ((($cekPembayaran['bukti_pembayaran'] != '' AND $cekPembayaran['info_pembayaran'] == 'transfer') OR ($cekPembayaran['bukti_pembayaran'] == '' AND $cekPembayaran['info_pembayaran'] == 'ditempat')) AND ($cekPembayaran['konfirmasi_admin'] == 'ya') AND ($order['kurir_check'] == 'sudah')) : ?>
											<button type="button" class="btn btn-success btn-sm mb-2" onclick="confirm('Apakah anda yakin perangkat telah kembali..?', '<?php echo "?content=transaksi_persetujuan_proses&proses=finish&id=" . $order['id_transaksi']; ?>');">
												<i class="fa fa-check-square-o"></i>
												Selesai
											</button>
										<?php endif ?>
										<form action="<?php echo $csv::$URL_BASE; ?>/nota.php" method="POST" target="_blank">
											<input type="hidden" name="id" value="<?php echo $order[0]; ?>">
											<button type="submit" class="btn btn-primary btn-sm mb-2">
												<i class="fa fa-print"></i>
												Nota
											</button>
											<?php if ($pembayaran == 0) : ?>
												<button type="button" class="btn btn-danger btn-sm mb-2" onclick="confirm('Apakah anda yakin ingin membatalkan transaksi ini..?', '<?php echo "?content=transaksi_persetujuan_proses&proses=batal&id=" . $order['id_transaksi']; ?>');">
													<i class="fa fa-times"></i>
													Batal
												</button>
											<?php endif ?>
											<a class="btn btn-dark btn-sm mb-2" href="?content=transaksi_detail&id=<?php echo $order[0]; ?>">
												<i class="fa fa-list text-light"></i>
												Details
											</a>
										</form>
									</td>
								</tr>
							<?php endif ?>
						<?php endwhile ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Tab Selesai -->
	<div class="tab-pane fade" id="menu2" role="tabpanel" aria-labelledby="nav-menu2-tab">
		<div class="description_area">
			<!-- <br> -->
			<!-- <p align="justify">
			</p> -->
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>No.</th> <th>Tanggal Transaksi</th> <th>Total Harga</th> <th>Diantarkan</th> <th>Status Transaksi</th> <th>Rating dari Pelanggan</th> <th>Aksi </th>
						</tr>
					</thead>

					<tbody>
						<?php while ($order = mysqli_fetch_array($orSelesai, MYSQLI_BOTH)) : ?>
							<?php
								$persetujuanPelanggan = 'belum';
								foreach (getDetailTransaksiByIdTransaksi($order['id_transaksi'], '', '', '', 'ASC') as $data) {
									// $persetujuanPelanggan = $data['persetujuan_pelanggan'];
								}
							?>
							<tr>
								<td><?php echo $order['no_transaksi']; ?></td>
								<td><?php echo $order['tgl_transaksi']; ?></td>
								<td><?php echo format(getTotalHargaTransaksi($order['id_transaksi']), 'currency'); ?></td>
								<td><?php echo setBadges($order['diantarkan']); ?></td>
								<td><?php echo setBadges($order['status_transaksi']); ?></td>
								<td><div id="ratingTemplate"><?php echo $rating = (isset($order['rating']) AND (!empty($order['rating']) OR $order['rating'] != NULL)) ? showRating($order['rating'], 20) : showRating(0, 20) ; ?></div></td>
								<td>
									<?php if ($order['status_transaksi'] == 'selesai') : ?>
										<form action="<?php echo $csv::$URL_BASE; ?>/nota.php" method="POST" target="_blank">
											<input type="hidden" name="id" value="<?php echo $order[0]; ?>">
											<button type="submit" class="btn btn-warning btn-sm mb-2" target="_blank"
											>
												<i class="fa fa-print"></i>
												Nota
											</button>
											<!-- onclick="redirectTo('nota_lunas', <?php //echo $order['id_transaksi']; ?>)"  -->
											<?php if (!isset($order['rating']) OR $order['rating'] == 0) : ?>
												<a
													role="button"
													class="btn btn-info btn-sm mb-2"
													href="?content=rating_form&id=<?php echo $order['id_transaksi']; ?>"
												>
													<i class="fa fa-star"></i>
													Beri Rating & Ulasan
												</a>
											<?php endif ?>
											<a
												class="btn btn-dark btn-sm mb-2"
												href="?content=transaksi_detail&action=lihat&id=<?php echo $order[0]; ?>"
											>
												<i class="fa fa-list"></i>
												Details
											</a>
										</form>
									<?php endif ?>
								</td>
							</tr>
						<?php endwhile ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Tab Batal -->
	<div class="tab-pane fade" id="menu3" role="tabpanel" aria-labelledby="nav-menu3-tab">
		<div class="description_area">
			<!-- <br> -->
			<!-- <p align="justify">
			</p> -->
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>No.</th>
							<th>Tanggal Transaksi</th>
							<th>Total Harga</th>
							<th>Datang ke Lokasi</th>
							<th>Status Transaksi</th>
							<th>Rating dari Pelanggan</th>
							<th>Rincian</th>
						</tr>
					</thead>
					<tbody>
						<?php while ($order = mysqli_fetch_array($orBatal, MYSQLI_BOTH)) : ?>
							<?php //if (getSisaPembayaranTransaksi($order['id_transaksi']) > 0) : ?>
								<tr>
									<td><?php echo $order['no_transaksi']; ?></td>
									<td><?php echo $order['tgl_transaksi']; ?></td>
									<td><?php echo format(getTotalHargaTransaksi($order['id_transaksi']), 'currency'); ?></td>
									<td><?php echo setBadges($order['diantarkan']); ?></td>
									<td><?php echo setBadges($order['status_transaksi']); ?></td>
									<td><div id="ratingTemplate"><?php echo $rating = (isset($order['rating']) AND (!empty($order['rating']) OR $order['rating'] != NULL)) ? showRating($order['rating'], 20) : showRating(0, 20) ; ?></div></td>
									<td>
										<?php if (!isset($order['rating']) OR $order['rating'] == 0) : ?>
											<a
												role="button"
												class="btn btn-info btn-sm mb-2"
												href="?content=rating_form&id=<?php echo $order['id_transaksi']; ?>"
											>
												<i class="fa fa-star"></i>
												Beri Rating & Ulasan
											</a>
										<?php endif ?>
										<a
											class="btn btn-dark btn-sm mb-2"
											href="?content=transaksi_detail&action=lihat&id=<?php echo $order['id_transaksi']; ?>"
										>
											<i class="fa fa-list"></i>
											Details
										</a>
									</td>
								</tr>
							<?php //endif ?>
						<?php endwhile ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Riwayat Transaksi End -->

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- ##### Blog Area End ##### -->