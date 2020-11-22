<?php
	cekLogin('pelanggan');
	$action = (isset($_GET['action']) and !empty($_GET['action'])) ? $_GET['action'] : NULL;
	$id = (isset($_GET['id']) and !empty($_GET['id'])) ? $_GET['id'] : NULL;
	if (!isset($_SESSION['cart']) or empty($_SESSION['cart'])) {
		$_SESSION['message-type'] = "danger";
		$_SESSION['message-content'] = "Anda belum memilih barang..!";
		echo "<script>window.location.replace('?content=produk')</script>";
	}
	if ($action == NULL) {
		$_SESSION['message-type'] = "danger";
		$_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";
		echo "<script>window.location.replace('?content=produk')</script>";
	}
	if ($id != NULL) {
		// addBarangToKeranjang($id);
	}
	$inc = 0;
	$total_harga = 0;
	$hargaPengantaran = getKonfigurasiUmum("biaya_administrasi", "single");
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
						<li class="breadcrumb-item"><a href="<?= $csv::$URL_BASE ?>"><i class="fa fa-home fa-fw"></i> Home</a></li>
						<li class="breadcrumb-item"><a href="<?= $csv::$URL_BASE ?>/?content=transaksi"><i class="fa fa-first-order fa-fw"></i> Transaksi</a></li>
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
		<div class="row">
			<div class="col-md-12">
				<p>
					<a class="btn btn-dark btn-sm" href="?content=transaksi" role="button">
						<i class="fa fa-arrow-left"></i>
						Kembali
					</a>
				</p>
				<div class="table-responsive">
					<p>
						<h3>Data Barang :</h3>
					</p>
					<table class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<th>NO</th>
								<th>Nama Produk / Harga Satuan (per Rak)</th>
								<th>Kuantitas</th>
								<th>Total Harga</th>
							</tr>
						</thead>
						<tbody>
							<?php if (isset($_SESSION['cart'])) : ?>
								<?php $inc = 1; ?>
								<!-- <?php //print_r(array_keys($_SESSION["cart"])); 
										?> -->
								<?php foreach ($_SESSION["cart"] as $item) : ?>
									<tr>
										<td>
											<?= $inc; ?>
										</td>
										<td class="">
											<?= $item['nama_telur'] . " / [" . format($item['harga_jual'], "currency") . "]" ?>
										</td>
										<td class="text-right">
											<?php echo $item['kuantitas']; ?>
										</td>
										<td class="text-right">
											<?= format($item['jumlah_harga'], "currency") ?>
											<?php $total_harga += $item['jumlah_harga']; ?>
										</td>
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
				<p>
					<h3>Form Pemesanan :</h3>
				</p>
				<form class="form-horizontal" action="?content=transaksi_proses&proses=add" method="POST">

					<div class="form-group row">
						<label for="nama_pelanggan" class="col-sm-2 col-form-label">Nama Pelanggan</label>
						<div class="col-sm-10">
							<input type="hidden" name="id_pelanggan" id="id_pelanggan" value="<?= $_SESSION['id'] ?>" />
							<input type="text" class="form-control-plaintext" name="nama_pelanggan" id="nama_pelanggan" placeholder="Nama Pelanggan..." value="<?= $_SESSION['nama'] ?>" readonly required />
						</div>
					</div>

					<div class="form-group row">
						<label for="no_telp" class="col-sm-2 col-form-label">No. Telp</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="No. Telp / HP" value="<?= $_SESSION['no_hp'] ?>" required />
						</div>
					</div>

					<div class="form-group row">
						<label for="total_harga" class="col-sm-2 col-form-label">Total Harga (Rp)</label>
						<div class="col-sm-10">
							<input type="text" class="form-control-plaintext" name="total_harga" id="total_harga" placeholder="Total Harga" value="<?= $total_harga ?>" readonly required />
						</div>
					</div>

					<div class="form-group row">
						<label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="keterangan" id="keterangan" cols="10" maxchar="255"></textarea>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-sm-2">Diantarkan</div>
						<div class="col-sm-10">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="diantarkan" value="ya" id="diantarkan" />
								<label class="form-check-label" for="diantarkan">
									Ya... (Biaya tambahan sebesar <?= format($hargaPengantaran['nilai_konfigurasi'], "currency") ?> akan dikenakan apabila barang diantarkan)
								</label>
							</div>
						</div>
					</div>

					<div id="form-pengantaran" style="display: none;">
						<style>
							/* button.Zebra_DatePicker_Icon {
								margin-top: 8%;
							}*/
						</style>
						<div class="form-group row">
							<label for="tanggal_pengantaran" class="col-sm-2 col-form-label">Tanggal Pengantaran</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="tanggal_pengantaran" id="tanggal_pengantaran" placeholder="Tanggal Pengantaran..." style="width: 230px;" />
							</div>
						</div>
						<div class="form-group row">
							<label for="alamat" class="col-sm-2 col-form-label">Alamat Pengantaran</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat Pengantaran..." />
							</div>
						</div>

						<div class="form-group row">
							<label for="alamat" class="col-sm-2 col-form-label">Map</label>
							<div class="col-sm-10">
								<input type="hidden" class="form-control" name="longlat" id="longlat" placeholder="Lokasi..." />
								<div id="map" style="width:100%; height:500px"></div>
								<script>
									function initMap() {
										var lngs = 0;
										var lats = 0;
										var inputAddress = document.getElementById('alamat');
										var input = document.getElementById('longlat');
										var myLatlng = (lngs == 0 && lats == 0) ? {
											lat: -5.147665,
											lng: 119.432732
										} : {
											lat: lats,
											lng: lngs
										};
										var map = new google.maps.Map(document.getElementById('map'), {
											zoom: 14,
											center: myLatlng
										});

										map.addListener('center_changed', function() {
											// 3 seconds after the center of the map has changed, pan back to the marker.
											var lnglat = map.getCenter();
											var lat = lnglat.lat();
											var lng = lnglat.lng();
											marker.setPosition(map.getCenter());
											document.getElementById('longlat').value = lng + ',' + lat;
										});

										var searchBox = new google.maps.places.Autocomplete(inputAddress, {
											componentRestrictions: {
												country: 'id' // ['us', 'pr', 'vi', 'gu', 'mp']
											}
										});

										searchBox.addListener('place_changed', function() { // places_changed
											var place = searchBox.getPlace();

											// For each place, get the icon, name and location.
											var bounds = new google.maps.LatLngBounds();

											// places.forEach(function(place) {
											if (!place.geometry) {
												console.log("Returned place contains no geometry");
												return;
											}

											// Create a marker for each place.
											marker.setPosition(place.geometry.location);

											if (place.geometry.viewport) {
												// Only geocodes have viewport.
												bounds.union(place.geometry.viewport);
											} else {
												bounds.extend(place.geometry.location);
											}
											// });
											map.fitBounds(bounds);
											// map.setCenter(marker.getPosition());
										});

										var marker = new google.maps.Marker({
											position: myLatlng,
											map: map,
											animation: google.maps.Animation.DROP,
											title: 'Click to zoom'
										});

										marker.addListener('click', function() {
											map.setZoom(18);
											map.setCenter(marker.getPosition());
											var info = (searchBox.getPlace()) ? searchBox.getPlace()['adr_address'] : "Alamat Belum dimasukan..!";
											infoWindow.setContent("<div style='text-align: center;'>" + info + "</div>");
											infoWindow.open(map, marker)
										});

										var infoWindow = new google.maps.InfoWindow();

										// var distance = google.maps.geometry.spherical.computeDistanceBetween(dest, marker.position);
									}
								</script>
							</div>
						</div>
					</div>

					<div class="form-group row text-right">
						<div class="offset-md-2 col-sm-10">
							<button type="submit" name="checkout" class="btn btn-primary">
								Lanjutkan
								<i class="fa fa-arrow-right"></i>
							</button>
						</div>
					</div>

				</form>
				<script async defer src='https://maps.googleapis.com/maps/api/js?key=AIzaSyB6bHo5JkixK-_Ct1TWEy4ZDdiuRqbwkpw&libraries=places&callback=initMap'></script>
				<script>
					function akumulasiHargaPengantaran(event = "+") {
						var totalHargaOld = parseInt($('input#total_harga').val());
						var totalHargaNew = (event == "+") ? totalHargaOld + <?= $hargaPengantaran['nilai_konfigurasi'] ?> : totalHargaOld - <?= $hargaPengantaran['nilai_konfigurasi'] ?>;
						// console.log(hasil);
						$('input#total_harga').val(totalHargaNew);
					}
				</script>
			</div>
		</div>
	</div>
</section>