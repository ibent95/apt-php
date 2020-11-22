<?php
	$id = (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL ;
	// if ($id == NULL) {
	// 	$_SESSION['message-type'] 		= "danger";
    //     $_SESSION['message-content'] 	= "Anda belum memilih kategori..!";
    //     echo "<script>location.replace('?content=pemesanan')</script>";
	// }
	// $transaksi = mysqli_fetch_array(
	// 	getTransaksiJoinById($id),
	// 	MYSQLI_BOTH
	// );
	// $detailTransaksiAll = getDetailTransaksiByIdTransaksi($id, 'ASC');
	// $biayaTambahan      = getDetailTransaksiByIdTransaksi($id, 'biaya_tambahan', '', 'ya', 'ASC');
	// $riwayatPembayaran  = getBuktiPembayaranByIdTransaksi($id, '', 'ASC');
	// $sisaPembayaran     = 0;
	// foreach ($detailTransaksiAll as $data) { $sisaPembayaran += $data['harga']; }
	// foreach ($biayaTambahan as $data) { $sisaPembayaran += $data['harga_biaya_tambahan']; }
	// foreach ($riwayatPembayaran as $data) { $sisaPembayaran -= $data['jumlah']; }
	// $pemesanan['status_pembayaran'] = (mysqli_num_rows($riwayatPembayaran) !== 0 AND $sisaPembayaran === 0) ? "Lunas" : "Belum Lunas" ;
	// if (!empty($pemesanan['longlat'])) {
	// 	$longlat = explode(",", $pemesanan['longlat']);
	// } else {
	// 	$longlat[0] = 0;
	// 	$longlat[1] = 0;
	// }
    // $no         = 1;
    // $totalHarga = 0;
?>
<!-- ##### Breadcrumb Area Start ##### -->
<div class="breadcrumb-area">
	<!-- Top Breadcrumb Area -->
	<div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(assets/frontend/img/bg-img/24.jpg);">
		<h2>Form Rating & Ulasan</h2>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-12">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo $csv::$URL_BASE; ?>"><i class="fa fa-home"></i> Home</a></li>
						<li class="breadcrumb-item">
							<a href="<?php echo $csv::$URL_BASE; ?>/?content=perbaikan">
								<!-- <i class="fa fa-home"></i> -->
								Perbaikan
							</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Form Rating & Ulasan</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<!-- ##### Breadcrumb Area End ##### -->

<!-- Start feature Area -->
<div class="checkout_area mb-100">
	<div class="container">
		<?= getNotifikasi() ?>
		<div class="row justify-content-between">
			<div class="col-md-12">
				<div class=" clearfix">
					<!-- Content -->
					<div class="section-heading">
						<h2>Form Rating & Ulasan</h2>
						<p>Terima kasih telah menggunakan layanan kami. Kami akan sangat terbantu apabila anda mengisi form rating dan ulasan di bawah ini, untuk pengembangan bisnis kami.</p>
					</div>
					<form action="?content=transaksi_persetujuan_proses&proses=add_rating&id=<?php echo $id; ?>" method="POST">
						<div class="form-group">
							<label for="inputRating">Rating</label>
							<input type="hidden" class="form-control" name="rating" placeholder="Rating" id="inputRating" value="1">
							<p style="color: black;">
								<span onmouseover="starmark(this);" onclick="starmark(this);" id="1one" style="font-size:40px;cursor:pointer;"  class="fa fa-star star-checked"></span>
								<span onmouseover="starmark(this);" onclick="starmark(this);" id="2one"  style="font-size:40px;cursor:pointer;" class="fa fa-star "></span>
								<span onmouseover="starmark(this);" onclick="starmark(this);" id="3one"  style="font-size:40px;cursor:pointer;" class="fa fa-star "></span>
								<span onmouseover="starmark(this);" onclick="starmark(this);" id="4one"  style="font-size:40px;cursor:pointer;" class="fa fa-star"></span>
								<span onmouseover="starmark(this);" onclick="starmark(this);" id="5one"  style="font-size:40px;cursor:pointer;" class="fa fa-star"></span>
							</p>
						</div>
						<div class="form-group">
							<label for="inputUlasan">Ulasan</label>
							<textarea class="form-control" name="ulasan" placeholder="Ulasan" rows="3" id="inputUlasan"></textarea>
						</div>
						<div class="form-group text-right">
							<button class="btn btn-default text-dark" onclick="window.location.replace('?content=profil');" role="button" data-toggle="button" aria-pressed="false" autocomplete="off">
                                <i class="fa fa-arrow-left"></i>
                                Kembali
                            </button>
							<button type="submit" class="btn btn-primary" name="simpan">
								Lanjutkan
								<i class="fa fa-arrow-right"></i>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End feature Area -->

<script>
	// Ratings Script
	var count = 0;

	function starmark(item) {
		// console.log(item);
		count = item.id[0];
		sessionStorage.starRating = count;
		var subid = item.id.substring(1);
		for (var i = 0; i < 5; i++) {
			if (i < count) {
				document.getElementById((i + 1) + subid).style.color = "orange";
			} else {
				document.getElementById((i + 1) + subid).style.color = "black";
			}
		}
		document.getElementById("inputRating").value = count;
	}
</script>