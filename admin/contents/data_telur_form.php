<?php
	$action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
	$id = (isset($_GET['id'])) ? $_GET['id'] : NULL ;
	if ($action == NULL) {
		$_SESSION['message-type'] = "danger";
		$_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";
		echo "<script>window.location.replace('?content=data_barang')</script>";
	}
	if ($action == 'ubah') {
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
					<li class=""><a href="?content=data_telur">Data Telur</a></li>
					<li class="active">Tambah Data Telur</li>
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
				<h4>Form Data Barang</h4>
			</div>

			<div class="card-body">
				<?= getNotifikasi() ?>
				<form
					class=""
					<?php if ($action == 'tambah') : ?>
						action="?content=data_telur_proses&proses=add"
					<?php else : ?>
						action="?content=data_telur_proses&proses=edit"
					<?php endif ?>
					method="POST"
					enctype="multipart/form-data"
				>
					<div class="row">
						<div class="col-md">
							<!-- <p>Data Barang</p> -->
							<?php if ($action == 'ubah') : ?>
								<input type="hidden" name="id" value="<?php echo antiInjection($_GET['id']); ?>">
							<?php endif ?>

							<div class="form-group">
								<label for="nama_telur" class="control-label">Nama Telur</label>
								<input
									type="text"
									class="form-control input-rounded input-focus"
									name="nama_telur"
									placeholder="Masukan Nama..."
									id="nama_telur"
									<?php if ($action == 'ubah') : ?>
										value="<?php echo $barang['nama_telur']; ?>"
									<?php endif ?>
								/>
							</div>

							<div class="form-group">
								<label for="id_kategori" class="control-label">Kategori Telur</label>
								<select class="form-control input-rounded input-focus" name="id_kategori" id="id_kategori">
									<option value="">-- Silahakan Pilih Kategori Telur --</option>
									<?php foreach ($kategoriAll as $data) : ?>
										<option
											value="<?php echo $data['id_kategori']; ?>"
											<?php if ($action == 'ubah' AND ($barang['id_kategori'] == $data['id_kategori'])) : ?>
												selected
											<?php endif ?>
										>
											<?php echo $data['nama_kategori']; ?>
										</option>
									<?php endforeach ?>
								</select>
							</div>

							<div class="form-group">
								<label for="harga_jual" class="control-label">Harga Jual (Rp)</label>
								<input type="number" min="0" class="form-control input-rounded input-focus" name="harga_jual" placeholder="Masukan Harga Jual..." id="harga_jual" <?php if ($action == 'ubah') : ?>value="<?= $barang['harga_jual'] ?>"<?php endif ?> />
							</div>

							<?php if ($action == 'ubah'): ?>

								<div class="form-group">
									<label for="persediaan" class="control-label">Persediaan</label>
									<input 
										type="number" 
										class="form-control input-rounded input-focus" 
										name="persediaan" 
										min="1" 
										placeholder="Masukan Persediaan..."
										<?php if ($action == 'ubah') : ?>
											value="<?php echo $barang['persediaan']; ?>"
										<?php endif ?>
									/>
								</div>

							<?php endif ?>

						</div>
						<div class="col-md-6">
							<!-- <p>Data Barang Masuk</p> -->

							<?php if ($action == 'tambah'): ?>
								
								<div class="form-group">
									<label for="harga_sewa" class="control-label">Kuantitas</label>
									<input
										type="number"
										min="0"
										class="form-control input-rounded input-focus"
										name="kuantitas"
										placeholder="Jumlah Telur Masuk (per Rak)..."
										id="kuantitas"
									/>
								</div>

								<div class="form-group">
									<label for="harga_beli" class="control-label">Harga Beli (Rp)</label>
									<input
										type="number"
										min="0"
										step="1000"
										class="form-control input-rounded input-focus"
										name="harga_beli"
										placeholder="Masukan Harga Beli (Keseluruhan)..."
										id="harga_beli"
									/>
								</div>

							<?php endif ?>

							<div class="form-group">
								<label for="foto1" class="control-label">Foto</label>
								<div class="row">
									<div class="col-md-3">
										<input
											type="file"
											class=""
											name="foto1"
											accept="images/*"
											placeholder="Masukan Gambar 1..."
											id="foto1"
											<?php if ($action == 'ubah') : ?>
												value="<?php echo $fotoBarang1['url_foto']; ?>"
											<?php endif ?>
										>
										<?php if ($action == 'ubah' AND ($fotoBarang1['url_foto'] != NULL OR !empty($fotoBarang1['url_foto']))) : ?>
											<input type="hidden" name="id_foto1" value="<?php echo $fotoBarang1['id_foto']; ?>">
											<div class="row col-md-12">
												<img class="img-thumbnail mt-2" height='auto' src='<?php echo searchFile($fotoBarang1["url_foto"], "img", "short"); ?>' id="image_gallery">
											</div>
										<?php endif ?>
									</div>
									<div class="col-md-3">
										<input type="file" class="" name="foto2" accept="images/*" placeholder="Masukan Gambar 2..." id="foto2"
											<?php if ($action == 'ubah') : ?>
												value="<?php echo $fotoBarang2['url_foto']; ?>"
											<?php endif ?>
										>
										<?php if ($action == 'ubah' AND ($fotoBarang2['url_foto'] != NULL OR !empty($fotoBarang2['url_foto']))) : ?>
											<input type="hidden" name="id_foto2" value="<?php echo $fotoBarang2['id_foto']; ?>">
											<div class="row col-md-12">
												<img class="img-thumbnail mt-2" height='90dp' src='<?php echo searchFile($fotoBarang2["url_foto"], "img", "short"); ?>' id="image_gallery">
											</div>
										<?php endif ?>
									</div>
									<div class="col-md-3">
										<input
											type="file"
											class=""
											name="foto3"
											accept="images/*"
											placeholder="Masukan Gambar..."
											id="foto3"
											<?php if ($action == 'ubah') : ?>
												value="<?php echo $fotoBarang3['url_foto']; ?>"
											<?php endif ?>
										>
										<?php if ($action == 'ubah' AND ($fotoBarang3['url_foto'] != NULL OR !empty($fotoBarang3['url_foto']))) : ?>
											<input type="hidden" name="id_foto3" value="<?php echo $fotoBarang3['id_foto']; ?>">
											<div class="row col-md-12">
												<img class="img-thumbnail mt-2" width='90dp' src='<?php echo searchFile($fotoBarang3["url_foto"], "img", "short"); ?>' id="image_gallery">
											</div>
										<?php endif ?>
									</div>
									<div class="col-md-3">
										<input
											type="file"
											class=""
											name="foto4"
											accept="images/*"
											placeholder="Masukan Gambar 4..."
											id="foto4"
											<?php if ($action == 'ubah') : ?>
												value="<?php echo $fotoBarang4['url_foto']; ?>"
											<?php endif ?>
										>
										<?php if ($action == 'ubah' AND ($fotoBarang4['url_foto'] != NULL OR !empty($fotoBarang4['url_foto']))) : ?>
											<input type="hidden" name="id_foto4" value="<?php echo $fotoBarang4['id_foto']; ?>">
											<div class="row col-md-12">
												<img class="img-thumbnail mt-2" width='90dp' src='<?php echo searchFile($fotoBarang4["url_foto"], "img", "short"); ?>' id="image_gallery">
											</div>
										<?php endif ?>
									</div>
								</div>
							</div>

							<!-- <div class="form-group">
								<label for="harga_beli" class="control-label col-md-3">Harga Beli (Rp)</label>
								<div class="col-md-12">
									<input 
										type="number" 
										class="form-control input-rounded input-focus" 
										name="harga_beli" 
										min="1" 
										value="0" 
										placeholder="Masukan Harga Beli..."
									/>
								</div>
							</div> -->

							<script src="../assets/lib/editor/ckeditor/ckeditor.js"></script>
							<div class="form-group">
								<label for="deskripsi" class="control-label">Deskripsi</label>
								<textarea 
									class="form-control input-focus" 
									name="deskripsi" 
									id="deskripsi"
									placeholder="Masukan Deskripsi Barang..."
								><?php if ($action == 'ubah') echo $barang['deskripsi']; ?></textarea>
							</div>
							<script> CKEDITOR.replace('deskripsi', { height: 340 }); </script>
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