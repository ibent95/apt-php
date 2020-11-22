<?php
$page = (isset($_GET['page'])) ? antiInjection($_GET['page']) : 1;
if (isset($_GET['record_count']) && !empty($_GET['record_count'])) {
	class_static_value::$record_count = $_GET['record_count'];
}
$idKategori = (isset($_GET['id_kategori']) && !empty($_GET['id_kategori'])) ? $_GET['id_kategori'] : NULL;
$recordCount = 12;
$barangAll = getTelurJoinKategoriLimitAll($idKategori, $page, $recordCount);
$jumlahItemKeranjang = (isset($_SESSION['cart']) or !empty($_SESSION['cart'])) ? count($_SESSION['cart']) : 0;
$kategoriAll = getKategoriAll('ASC');
$dateNow = date('Y-m-d');
$pagination = new Zebra_Pagination();
$pagination->records(mysqli_num_rows(getTelurAll($idKategori)));
$pagination->records_per_page(12);
?>
<!-- ##### Breadcrumb Area Start ##### -->
<div class="breadcrumb-area">
	<!-- Top Breadcrumb Area -->
	<div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(assets/frontend/img/bg-img/24.jpg);">
		<h2>Produk</h2>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-12">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?= $csv::$URL_BASE ?>"><i class="fa fa-home"></i> Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">
							<i class="fa fa-first-order"></i>
							Produk
						</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<!-- ##### Breadcrumb Area End ##### -->

<!-- ##### Blog Area Start ##### -->
<section class="alazea-blog-area ">

	<!-- Search Content -->
	<div class="container pb-3">
		<?= getNotifikasi() ?>
		<form class="form-inline">
			<select class="form-control mr-1" name="id_kategori" id="id_kategori">
				<?php if (mysqli_num_rows($kategoriAll) < 1) : ?>
					<option value="">Belum Ada Data Kategori Barang..!</option>
				<?php else : ?>
					<option value="">Kategori Barang</option>
					<?php foreach ($kategoriAll as $data) : ?>
						<option value="<?= $data['id_kategori'] ?>">
							<?= $data['nama_kategori'] ?>
						</option>
					<?php endforeach ?>
				<?php endif ?>
			</select>

			<input class="form-control mr-1" type="text" name="kata_kunci" id="kata_kunci" placeholder="Masukan Kata Kunci Pencarian">

			<button type="button" class="btn btn-default mr-1" onclick="search_barang();">
				<i class="fa fa-search"></i>
				Cari
			</button>
		</form>
	</div>
	<!-- Search Content End -->

	<!-- Main Content -->
	<div class="container">
		<div class="row">

			<!-- Main Content Left -->
			<div class="col-md-9">
				<div class="row" id="product">
					<?php if (mysqli_num_rows($barangAll) < 1) : ?>
						<div class="col-md-12 table-bordered">
							<h5 class="text-center font-italic pt-3">Tidak ada data..!</h5>
						</div>
					<?php else : ?>
						<?php while ($data = mysqli_fetch_array($barangAll, MYSQLI_BOTH)) : ?>
							<div class="col-md-4">
								<div class="single-best-receipe-area img-thumbnail mb-30">
									<a href="?content=produk_detail&id=<?= $data[0] ?>">
										<h6><?= $data['nama_telur'] ?></h6>
									</a>
									<img src="<?= searchFile(mysqli_fetch_assoc(getFotoTelurByIdTelur($data['id_telur'], 'ASC'))['url_foto'], "img", "short") ?>" alt="<?= $data['nama_telur'] ?>" style="height: 100%; width: 100%;">
									<div class="text-left font-weight-bold" style="font-size: 18px;">
										<table>
											<tbody>
												<tr>
													<td>Kategori</td>
													<td>&nbsp: <?= $data['nama_kategori'] ?></td>
												</tr>
												<tr>
													<td>Harga</td>
													<td>
														&nbsp:
														<?php
														$hargaJual = (($dateNow >= $data['tgl_awal_diskon']) and ($dateNow <= $data['tgl_akhir_diskon'])) ? getDiscountPrice($data['id_telur']) : $data['harga_jual'];
														?>
														<?php if (($dateNow >= $data['tgl_awal_diskon']) and ($dateNow <= $data['tgl_akhir_diskon'])) : ?>
															<span class="font-weight-light" style="text-decoration: line-through; font-size: 80%; "><?= format($data['harga_jual'], 'currency') ?></span>
															<span class="badge badge-pill badge-danger">Disc. <?= $data['diskon'] ?>%</span>
															<br>
														<?php endif ?>
														<?= format($hargaJual, 'currency') ?>
													</td>
												</tr>
												<tr>
													<td>Persediaan</td>
													<td>&nbsp: <?= $data['persediaan'] ?></td>
												</tr>
											</tbody>
										</table>
										<div class="row mt-2">
											<div class="col-md-6">
												<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal_chart_add" data-id="<?= $data[0] ?>" data-act="cart_add" id="cart-add" style="width: 100%;" <?php if ($data['persediaan'] < 1) : ?>disabled <?php endif ?>>
													<i class="fa fa-cart-plus"></i>
													Cart
												</button>
											</div>
											<div class="col-md-6">
												<button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal_chart_add" data-id="<?= $data[0] ?>" data-act="order_item" id="order-item" <?php if ($data['persediaan'] < 1) : ?>disabled <?php endif ?>>
													<i class="fa fa-handshake-o"></i>
													Order
												</button> <!-- href="?content=pemesanan&id=<?php //echo $barang[0]; 
																							?>" -->
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php endwhile ?>
					<?php endif ?>
				</div>

				<p class="text-center">
					<?php $pagination->render(); ?>
				</p>

			</div>
			<!-- Main Content Left End -->

			<!-- Main Content Right -->
			<div class="col-md-3 pb-3">

				<div class="list-group mb-4">
					<a class="list-group-item list-group-item-action bg-primary text-light">
						Keranjang Anda
					</a>
					<?php if ($jumlahItemKeranjang < 1) : ?>
						<a href="#" class="list-group-item disabled font-italic">
							Tidak ada data barang..!
						</a>
					<?php else : ?>
						<a href="<?= class_static_value::$URL_BASE ?>/?content=transaksi" class="list-group-item list-group-item-action">
							<?= $jumlahItemKeranjang ?> item dalam keranjang..!
						</a>
					<?php endif ?>
				</div>

				<div class="list-group">
					<a class="list-group-item list-group-item-action bg-primary text-light">
						Kategori
					</a>
					<?php if (mysqli_num_rows($kategoriAll) < 1) : ?>
						<a href="#" class="list-group-item disabled font-italic">
							Tidak ada data kategori..!
						</a>
					<?php else : ?>
						<?php foreach ($kategoriAll as $data) : ?>
							<a href="<?= class_static_value::$URL_BASE ?>/?content=produk&id_kategori=<?= $data['id_kategori'] ?>" class="list-group-item list-group-item-action">
								<?= $data['nama_kategori'] ?>
							</a>
						<?php endforeach ?>
					<?php endif ?>
				</div>
			</div>
			<!-- Main Content Right End -->

		</div>
	</div>
	<!-- Main Content End -->

	</div>
	<script>
		function search_barang() {
			var page = <?php echo $page; ?>;
			var record_count = <?php echo $recordCount; ?>;
			var kata_kunci = $('input#kata_kunci').val();
			var id_kategori = $('select#id_kategori').val();
			$.ajax({
				url: 'functions/function_responds.php/?content=search_barang',
				type: 'POST',
				data: {
					page: page,
					record_count: record_count,
					kata_kunci: kata_kunci,
					id_kategori: id_kategori
				},
				success: function(data) {
					$('div#product').html(data);
					// console.log(data);
				}
			});
		}
	</script>