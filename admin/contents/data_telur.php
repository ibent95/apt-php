<?php

if (isset($_GET['page'])) {
	$page = antiInjection($_GET['page']);
} else {
	$page = 1;
}

if (isset($_GET['record_count']) && !empty($_GET['record_count'])) {
	class_static_value::$record_count = $_GET['record_count'];
}

$telurAll = getTelurJoinKategoriLimitAll(NULL, $page, class_static_value::$record_count);

$pagination = new Zebra_Pagination();
$pagination->records(mysqli_num_rows(getTelurAll()));
$pagination->records_per_page(class_static_value::$record_count);

$inc = 1;
?>
<div class="breadcrumbs">
	<div class="col-sm-4">
		<div class="page-header float-left">
			<div class="page-title">
				<h1>Data Telur</h1>
			</div>
		</div>
	</div>
	<div class="col-sm-8">
		<div class="page-header float-right">
			<div class="page-title">
				<ol class="breadcrumb text-right">
					<li class=""><a href="javascript:void(0)">Home</a></li>
					<li class=""><a href="javascript:void(0)">Master</a></li>
					<li class="active">Data Telur</li>
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
				<h4>Daftar Telur</h4>
			</div>

			<div class="card-body">

				<?= getNotifikasi() ?>

				<div class="row">
					<div class="col-md-6">
						<p class="pull-left">
							<a class="btn btn-primary" href="?content=data_telur_form&action=tambah">
								<i class="fa fa-plus"></i>
								Tambah
							</a>
						</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<p class="mb-2">
							<!-- <div class="form-inline" id="record_form" >
									<div class="form-group form-group-md">
										<label class="control-label" for="record_per_page">Record per Page :&nbsp; </label>
										<select class="form-control" id="record_per_page" onchange="refreshPageForChangeRecordCount('<?php //echo $_GET['content'];
																																		?>');">
											<option
												value="3"
												<?php //if (class_static_value::$record_count == 3):
												?>
													selected
												<?php //endif
												?>
											>
												3
											</option>
											<option
												value="5"
												<?php //if (class_static_value::$record_count == 5):
												?>
													selected
												<?php //endif
												?>
											>
												5
											</option>
											<option
												value="10"
												<?php //if (class_static_value::$record_count == 10):
												?>
													selected
												<?php //endif
												?>
											>
												10
											</option>
											<option
												value="20"
												<?php //if (class_static_value::$record_count == 20):
												?>
													selected
												<?php //endif
												?>
											>
												20
											</option>
											<option
												value="50"
												<?php //if (class_static_value::$record_count == 50):
												?>
													selected
												<?php //endif
												?>
											>
												50
											</option>
											<option
												value="100"
												<?php //if (class_static_value::$record_count == 100):
												?>
													selected
												<?php //endif
												?>
											>
												100
											</option>
										</select>
									</div>
								</div> -->
						</p>
					</div>

					<div class="col-md-6">
						<p class="mb-auto">
						<div class="form-inline float-right" id="cari">
							<div class="form-group form-group-md mx-sm-2 mb-2">
								<label for="kata_kunci" class="control-label">Pencarian :&nbsp; </label>
								<input type="text" class="form-control" name="kata_kunci" id="kata_kunci" placeholder="Kata Kunci Pencarian" onchange="search(
												<?php echo $page; ?>,
												<?php echo class_static_value::$record_count; ?>,
												'<?php echo $_GET['content']; ?>',
												$('input#kata_kunci').val()
											);" />
							</div>
							<button class="btn btn-secondary mb-2" onclick="search(
											<?php echo $page; ?>,
											<?php echo class_static_value::$record_count; ?>,
											'<?php echo $_GET['content']; ?>',
											$('input#kata_kunci').val()
										);">
								Cari
							</button>
						</div>
						</p>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-hover table-bordered table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Nama Telur</th>
								<th>Kategori</th>
								<th class="text-right">Harga</th>
								<th>Persediaan (Stok)</th>
								<th>Discount (%)</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody id="data_list">
							<?php if (mysqli_num_rows($telurAll) == 0) : ?>
								<tr>
									<td colspan="6">
										<center>
											Tidak ada data..!
										</center>
									</td>
								</tr>
							<?php else : ?>
								<?php while ($data = mysqli_fetch_array($telurAll, MYSQLI_BOTH)) : ?>
									<tr>
										<td>
											<!-- <a>
													<img
														class="img-thumbnail rounded"
														src="<?php //echo searchFile($data['url_foto'], 'img', 'full');
																?>"
														alt="<?php //echo $data['nama_telur'];
																?>"
														style="height: 100px;"
													>
												</a> -->
											<?php echo $inc; ?>
										</td>
										<td>
											<?php echo $data['nama_telur']; ?>
										</td>

										<td>
											<?php echo $data['nama_kategori']; ?>
										</td>

										<td class="text-right">
											<?php echo format($data['harga_jual'], 'currency'); ?>
										</td>

										<td>
											<?php echo $data['persediaan']; ?>
										</td>

										<td class="text-right">
											<?php if ($data['diskon']) {
												echo $data['diskon'] . " %";
											} ?>
										</td>

										<td>
											<!-- <a
													class="btn btn-info btn-sm"
													href="?content=data_telur_discount_form&action=ubah&id=<?php //echo $data['id_telur'];
																											?>"
												>
													Discount
												</a> -->
											<button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_discount_item" data-id="<?php echo $data['id_telur']; ?>" data-content="<?php echo $content; ?>" id="btn_discount_item">
												<i class="fa fa-percent"></i>
												Discount
											</button>
											<a class="btn btn-warning btn-sm" href="?content=data_telur_masuk_form&action=tambah_persediaan&id=<?php echo $data['id_telur']; ?>">
												<i class="fa fa-download"></i>
												Masuk
											</a>
											<a class="btn btn-primary btn-sm" href="?content=data_telur_form&action=ubah&id=<?php echo $data['id_telur']; ?>">
												<i class="fa fa-edit"></i>
												Ubah
											</a>
											<a class="btn btn-danger btn-sm" href="?content=data_telur_proses&proses=remove&id=<?php echo $data['id_telur']; ?>" onclick="return confirm('Anda yakin ingin menghapus data ini..?');">
												<i class="fa fa-times"></i>
												Hapus
											</a>
										</td>
									</tr>
									<?php $inc++; ?>
								<?php endwhile ?>
							<?php endif ?>
						</tbody>
					</table>
				</div>

				<p>
					<?php $pagination->render(); ?>
				</p>

			</div>
			<!-- End Card Body -->
		</div>
		<!-- End Card -->

	</div>
	<!-- End Coloukategori -->
</div>
<!-- End Row -->

</div>

<div class="modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" id="modal_discount_item">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="pengguna_detail_label">Diskon Telur</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span class="fa fa-times"></span>
				</button>
			</div>
			<div class="modal-body clearfix">
				<form class="" action="" method="POST" id="form_discount_item">
					<div class="form-group">
						<label class="" for="percent">Persentase (%)</label>
						<input class="form-control input-rounded input-focus" type="number" min="0" name="diskon" aria-describedby="penrcent_help" placeholder="Masukan persentasi dari diskon telur..." id="percent" value="0" />
						<small id="percent_help" class="form-text text-muted">Persentase.</small>
						<input class="form-control input-rounded input-focus" type="number" min="0" id="total_harga" value="0" readonly />
						<small id="harga_help" class="form-text text-muted">Total Harga Sewa per Hari.</small>
					</div>
					<div class="form-group ">
						<label class="" for="tanggal_awal_diskon">Tanggal Awal</label>
						<input class="form-control input-focus" type="text" name="tanggal_awal_diskon" placeholder="Masukan tanggal awal diskon..." id="tanggal_awal_diskon" />
					</div>
					<div class="form-group ">
						<label class="" for="tanggal_awal_diskon">Tanggal Akhir</label>
						<input class="form-control input-focus" type="text" name="tanggal_akhir_diskon" placeholder="Masukan tanggal akhir diskon..." id="tanggal_akhir_diskon" />
					</div>
					<div class="form-group ">
						<label class="" for="tanggal_awal_diskon">Tipe Diskon</label>
						<select class="form-control input-focus" name="diskon_type" id="diskon_type">
							<option value="umum">Umum</option>
							<option value="tambahan">Tambahan</option>
						</select>
					</div>
					<div class="form-group ">
						<label class="" for="">Angka Kenaikan (per Jumlah Barang)</label>
						<input class="form-control input-focus" type="text" name="diskon_count_increase" placeholder="Masukan angka kenaikan per jumlah barang..." id="diskon_count_increase" min="0" value="0" />
					</div>
					<div class="form-group ">
						<label class="" for="">Angka Kenaikan (Persentase)</label>
						<input class="form-control input-focus" type="number" name="diskon_amount_increment" placeholder="Masukan angka kenaikan per persentase..." id="diskon_amount_increment" min="0" value="0" />
					</div>
					<div class="form-group ">
						<label class="" for="">Maksimal Angka Kenaikan (Persentase)</label>
						<input class="form-control input-focus" type="text" name="diskon_amount_increment_max" placeholder="Masukan maksimal angka kenaikan per persentase..." id="diskon_amount_increment_max" min="0" value="0" />
					</div>
					<div class="form-group text-right">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
			<!-- <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div> -->
		</div>
	</div>
</div>