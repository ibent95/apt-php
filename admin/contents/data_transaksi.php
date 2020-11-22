<?php
	if (isset($_GET['page'])) {
		$page = antiInjection($_GET['page']);
	} else {
		$page = 1;
	}

	if (isset($_GET['record_count']) && !empty($_GET['record_count'])) {
		class_static_value::$record_count = $_GET['record_count'];
	}

	$pemesananAll = getTransaksiSubJoinLimitAll($page, class_static_value::$record_count, 'tunggu');

	$pagination = new Zebra_Pagination();
	$pagination->records(mysqli_num_rows(getTransaksiSubJoinAll('tunggu')));
	$pagination->records_per_page(class_static_value::$record_count);
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
					<li class="active">Transaksi</li>
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
				<h4>Daftar Transaksi</h4>
			</div>
			
			<div class="card-body">

				<?= getNotifikasi() ?>

				<div class="row">
					<div class="col-md-6">
						<p>
							<a class="btn btn-primary float-left" href="?content=data_transaksi_form&action=tambah">
								<i class="fa fa-plus-square"></i>
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
									<select class="form-control" id="record_per_page" onchange="refreshPageForChangeRecordCount('<?php //echo $_GET['content']; ?>');">
										<option 
											value="3" 
											<?php //if (class_static_value::$record_count == 3): ?>
												selected
											<?php //endif ?>
										>
											3
										</option>
										<option 
											value="5" 
											<?php //if (class_static_value::$record_count == 5): ?>
												selected
											<?php //endif ?>
										>
											5
										</option>
										<option 
											value="10" 
											<?php //if (class_static_value::$record_count == 10): ?>
												selected
											<?php //endif ?>
										>
											10
										</option>
										<option 
											value="20" 
											<?php //if (class_static_value::$record_count == 20): ?>
												selected
											<?php //endif ?>
										>
											20
										</option>
										<option 
											value="50" 
											<?php //if (class_static_value::$record_count == 50): ?>
												selected
											<?php //endif ?>
										>
											50
										</option>
										<option 
											value="100" 
											<?php //if (class_static_value::$record_count == 100): ?>
												selected
											<?php //endif ?>
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
									<input type="text" class="form-control" name="kata_kunci" id="kata_kunci" placeholder="Kata Kunci Pencarian" onchange="search(<?php echo $page; ?>, <?php echo $_SESSION['record-count']; ?>, '<?php echo $_GET['content']; ?>', $('input#kata_kunci').val());"/>
								</div>
								<button class="btn btn-secondary mb-2" onclick="search(<?php echo $page; ?>, <?php echo $_SESSION['record-count']; ?>, '<?php echo $_GET['content']; ?>', $('input#kata_kunci').val());">
									Cari
								</button>
							</div>
						</p>
					</div>
				</div>

				<div class="table-responsive">
					<table class="table table-hover table-striped table-bordered">
						<thead>
							<tr>
								<th>NO</th>
								<th>Tanggal Pemesanan</th>
								<th>Nama Pelanggan</th>
								<th>Diantarkan</th>
								<th>Info Pembayaran</th>
								<th>Status Transaksi</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody id="data_list">
							<?php if (mysqli_num_rows($pemesananAll) <= 0): ?>
								<tr><td colspan="6"><p class="text-center">Tidak ada data..!</p></td></tr>
							<?php else: ?>
								<?php $inc = 1; ?>
								<?php while ($data = mysqli_fetch_array($pemesananAll, MYSQLI_BOTH)) : ?>
									<tr>
										<td><?= $inc ?></td>
										<td><?= $data['tgl_transaksi'] ?></td>
										<td><?= $data['nama_pelanggan'] ?></td>
										<td><?= setBadges($data['diantarkan']) ?></td>
										<td><?= setBadges($data['info_pembayaran']) ?></td>
										<td><?= setBadges($data['status_transaksi']) ?></td>
										<td>
											<?php $pembayaran = mysqli_fetch_array(getBuktiPembayaranByIdTransaksi($data['id_transaksi'], NULL, 'DESC'), MYSQLI_BOTH); ?>
											<?php if ($data['status_transaksi'] == 'tunggu'  AND $pembayaran['konfirmasi_admin'] == NULL) : ?>
												<a class="btn btn-success btn-sm" href="?content=data_transaksi_persetujuan_form&action=persetujuan&id=<?= $data[0] ?>" style="margin-bottom: 10px;">
													<i class="fa fa-check-square-o"></i>
													Persetujuan
												</a>
											<?php endif ?>
											<?php if ($data['status_transaksi'] == 'proses' AND $pembayaran['info_pembayaran'] == 'transfer' AND $pembayaran['konfirmasi_admin'] == 'belum') : ?>
												<a class="btn btn-danger btn-sm" href="?content=data_transaksi_persetujuan_form&action=konfirmasi_pembayaran&id=<?= $data[0] ?>" style="margin-bottom: 10px;">
													<i class="fa fa-check-square-o"></i>
													Konfirmasi Pembayaran
												</a>
											<?php endif ?>
											<?php if (($pembayaran['info_pembayaran'] == 'ditempat' AND $data['id_kurir'] < 1) OR ($pembayaran['info_pembayaran'] == 'transfer' AND $pembayaran['konfirmasi_admin'] == 'ya')) :  ?>
												<a class="btn btn-primary btn-sm" href="?content=data_transaksi_kurir_form&action=persetujuan&id=<?= $data[0] ?>" style="margin-bottom: 10px;">
													<i class="fa fa-user-plus"></i>
													Tentukan Kurir
												</a>
											<?php endif ?>
											<a class="btn btn-dark btn-sm" href="?content=data_transaksi_persetujuan_form&action=lihat&id=<?= $data[0] ?>" style="margin-bottom: 10px;">
												<i class="fa fa-list"></i>
												Rincian
											</a>
											<a class="btn btn-info btn-sm" href="?content=data_transaksi_persetujuan_form&action=ubah&id=<?php echo $data[0]; ?>" style="margin-bottom: 10px;">
												<i class="fa fa-edit"></i>
												Ubah
											</a>
											<a class="btn btn-danger btn-sm" href="?content=data_transaksi_proses&proses=remove&id=<?php echo $data[0]; ?>" onclick="return confirm('Anda yakin ingin menghapus data ini..?');" style="margin-bottom: 10px;">
												<i class="fa fa-times"></i>
												Hapus
											</a>
										</td>
									</tr>
									<?php $inc++ ?>
								<?php endwhile ?>
							<?php endif ?>
						</tbody>
					</table>
				</div>
				
				<p>
					<?php $pagination->render();?>
				</p>
				

			</div>
			<!-- End Card Body -->
			
		</div>
		<!-- End Card -->

	</div>
	<!-- End Coloumn -->
</div>