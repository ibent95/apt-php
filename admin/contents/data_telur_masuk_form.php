<?php
	$action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
	$id = (isset($_GET['id'])) ? $_GET['id'] : NULL ;
	if ($action == NULL) {
		$_SESSION['message-type'] = "danger";
		$_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";
		echo "<script>window.location.replace('?content=data_barang')</script>";
	}
	if ($action == 'tambah_persediaan') {
		$barang = mysqli_fetch_assoc(getTelurById($id));
		$fotoBarangAll = getFotoTelurByIdTelur($id);
		$fotoBarang1 = NULL;
		$fotoBarang2 = NULL;
		$fotoBarang3 = NULL;
		$fotoBarang4 = NULL;
		if (mysqli_num_rows($fotoBarangAll) >= 1 AND mysqli_num_rows($fotoBarangAll) <= 4) {
			$i = 1;
			while ($data = mysqli_fetch_assoc($fotoBarangAll)) {
				if ($i == 1) {
					$fotoBarang1 = $data;
				} elseif ($i == 2) {
					$fotoBarang2 = $data;
				} elseif ($i == 3) {
					$fotoBarang3 = $data;
				} elseif ($i == 4) {
					$fotoBarang4 = $data;
				}
				$i++;
			}
		}
	}
	// $merkAll = getMerkAll('ASC');
	$kategoriAll = getKategoriAll('ASC');
?>
<div class="breadcrumbs">
	<div class="col-sm-4">
		<div class="page-header float-left">
			<div class="page-title">
				<h1>Data Telur - Masuk</h1>
			</div>
		</div>
	</div>
	<div class="col-sm-8">
		<div class="page-header float-right">
			<div class="page-title">
				<ol class="breadcrumb text-right">
					<li class=""><a href="javascript:void(0)">Home</a></li>
					<li class=""><a href="javascript:void(0)">Master</a></li>
					<li class=""><a href="?content=data_telur">Data Telur</a></li>
					<li class="active">Tambah Persediaan Data Telur</li>
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
				<h4>Form Data Telur Masuk</h4>
			</div>

			<div class="card-body">
				<?= getNotifikasi() ?>
				<form class=""
					<?php if ($action == 'tambah_persediaan') : ?>
						action="?content=data_telur_proses&proses=add_stok"
					<?php else : ?>
						action="?content=data_telur_proses&proses=edit"
					<?php endif ?>
					method="POST" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md">
							<!-- <p>Data Barang</p> -->
							<?php if ($action == 'tambah_persediaan') : ?>
								<input type="hidden" name="id" value="<?= antiInjection($_GET['id']) ?>">
							<?php endif ?>

							<div class="form-group">
								<label for="nama_telur" class="control-label">Nama Telur</label>
								<input type="text" class="form-control-plaintext input-rounded input-focus" name="nama_telur" placeholder="Masukan Nama..." id="nama_telur" <?php if ($action == 'tambah_persediaan') : ?> readonly value="<?= $barang['nama_telur'] ?>" <?php endif ?> />
							</div>

							<div class="form-group">
								<label for="id_kategori" class="control-label">Kategori Telur</label>
								<input type="text" class="form-control-plaintext input-rounded input-focus" name="nama_telur" placeholder="Masukan Nama..." id="nama_telur" <?php if ($action == 'tambah_persediaan') : ?> readonly <?php foreach ($kategoriAll as $data) : ?> <?php if ($barang['id_kategori'] == $data['id_kategori']) : ?> value="<?= $data['nama_kategori'] ?>" <?php endif ?> <?php endforeach ?> <?php endif ?> />
							</div>

							<div class="form-group">
								<label for="harga_jual" class="control-label">Harga Jual (Rp)</label>
								<input type="number" min="0" class="form-control-plaintext input-rounded input-focus" name="harga_jual" placeholder="Masukan Harga Jual..." id="harga_jual" <?php if ($action == 'tambah_persediaan') : ?>readonly value="<?= $barang['harga_jual'] ?>" <?php endif ?> />
							</div>

							<?php if ($action == 'tambah_persediaan'): ?>

								<div class="form-group">
									<label for="persediaan" class="control-label">Persediaan</label>
									<input type="number" class="form-control-plaintext input-rounded input-focus" name="persediaan" min="1" placeholder="Masukan Persediaan..." <?php if ($action == 'tambah_persediaan') : ?> readonly value="<?= $barang['persediaan'] ?>" <?php endif ?> />
								</div>

							<?php endif ?>

						</div>
						<div class="col-md-6">
							<!-- <p>Data Barang Masuk</p> -->

							<?php if ($action == 'tambah_persediaan'): ?>
								
								<div class="form-group">
									<label for="harga_sewa" class="control-label">Kuantitas</label>
									<input type="number" min="0" class="form-control input-rounded input-focus" name="kuantitas" placeholder="Jumlah Telur Masuk (per Rak)..." id="kuantitas" />
								</div>

								<div class="form-group">
									<label for="harga_beli" class="control-label">Harga Beli (Rp)</label>
									<input type="number" min="0" step="1000" class="form-control input-rounded input-focus" name="harga_beli" placeholder="Masukan Harga Beli (Keseluruhan)..." id="harga_beli" />
								</div>

							<?php endif ?>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<button type="submit" class="btn btn-primary" name="simpan">
									<i class="fa fa-check"></i>
									Simpan
								</button>
								<button type="reset" class="btn btn-danger">Reset</button>
							</div>
						</div>
					</div>

				</form>
			</div>
			<!-- End Card Body -->

		</div>
		<!-- End Card -->

	</div>
		<!-- End Coloumn -->
</div>