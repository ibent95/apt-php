<?php

	if (isset($_GET['record_count']) && !empty($_GET['record_count'])) {
		class_static_value::$record_count = $_GET['record_count'];
	}

	$kategoriAll = mysqli_query($koneksi, "SELECT DISTINCT(`nama_kategori`) FROM `data_laporan_arus_kas` ORDER BY `tgl_transaksi` ASC");
	// $kategoriAll = getKategoriAll('ASC');

?>
<div class="breadcrumbs">
	<div class="col-sm-4">
		<div class="page-header float-left">
			<div class="page-title">
				<h1>Laporan Arus Kas (Cash Flow)</h1>
			</div>
		</div>
	</div>
	<div class="col-sm-8">
		<div class="page-header float-right">
			<div class="page-title">
				<ol class="breadcrumb text-right">
					<li class=""><a href="javascript:void(0)">Home</a></li>
					<li class="active">Laporan Arus Kas</li>
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

				<form action="laporan_arus_kas.php" method="POST" target="_blank">
					<div class="form-group row">
						<div class="col-md-3">
							<label class="col-form-label" for="">Tanggal Awal</label>
							<input type="text" name="tanggal_awal" id="tanggal_awal" class="form-control input-rounded input-focus" placeholder="Pilih Tanggal Awal...">
						</div>
						<div class="col-md-3">
							<label class="col-form-label" for="">Tanggal Akhir</label>
							<input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control input-rounded input-focus" placeholder="Pilih Tanggal Akhir...">
						</div>
						<!-- <div class="col-md-3">
							<label class="col-form-label" for="">Kategori</label>
							<select class="form-control input-rounded input-focus form-control-lg" name="nama_kategori" id="nama_kategori">
								<option value="">-- Silahakan Pilih Kategori --</option>
								<?php // foreach ($kategoriAll as $data): ?>
									<option value="<? // $data['nama_kategori'] ?>">
										<? // $data['nama_kategori'] ?>
									</option>
								<?php // endforeach ?>
							</select>
						</div> -->
						<!-- <div class="col-md-3">
							<label class="col-form-label" for="">Kategori</label>
							<select class="form-control input-rounded input-focus form-control-lg" name="id_barang" id="id_barang">
								<option value="">-- Silahakan Pilih Kategori Terlebih Dahulu --</option>
							</select>
						</div> -->
					</div>
					<div class="form-group row">
						<div class="col-md-4">
							<button type="submit" class="btn btn-primary">
								<i class="fa fa-print"></i>
								Cetak
							</button>
							<!-- <button type="reset" class="btn btn-default">Reset</button>     -->
						</div>
					</div>

				</form>

			</div>
			<!-- End Card Body -->
			
		</div>
		<!-- End Card -->

	</div>
	<!-- End Row -->

</div>