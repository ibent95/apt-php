<?php
    cekLogin('pelanggan');
    $action = (isset($_GET['action']) AND !empty($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id']) AND !empty($_GET['id'])) ? $_GET['id'] : $_SESSION['id'] ;
    $pelanggan = mysqli_fetch_array(
        getPelangganById($id),
        MYSQLI_BOTH
    )
?>
<!-- ##### Breadcrumb Area Start ##### -->
<div class="breadcrumb-area">
	<!-- Top Breadcrumb Area -->
	<div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(assets/frontend/img/bg-img/24.jpg);">
		<h2>Pemesanan</h2>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-12">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
                            <a href="<?php echo $csv::$URL_BASE; ?>">
                                <i class="fa fa-home"></i>
                                Home
                            </a>
                        </li>
						<li class="breadcrumb-item">
                            <a href="<?php echo $csv::$URL_BASE; ?>?content=profil">
                                <i class="fa fa-user"></i>
                                Profil
                            </a>
                        </li>
						<li class="breadcrumb-item active" aria-current="page">Form Profil</li>
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
        <?php
            getNotifikasi();
        ?>
        <div class="row">
            <div class="col-md-12">
                <h2>Form Profil [<?php echo $_SESSION['username']; ?>]</h2>
				<p class="pb-10">
					<!-- Silahkan pilih jenis layanan kami. -->
				</p>
                <p>
                    <a class="btn btn-dark btn-sm" href="?content=profil" role="button">
                        <i class="fa fa-arrow-left text-light"></i>
                        Kembali
                    </a>
                </p>
                <form
                    class="form-horizontal"
                    <?php if ($action == 'tambah') : ?>
                        action="?content=profil_proses&proses=add"
                    <?php elseif ($action == 'ubah')  : ?>
                        action="?content=profil_proses&proses=edit"
                    <?php endif ?>
                    method="POST"
                    enctype="multipart/form-data"
                >

                    <div class="form-group row">
                        <label for="nama_pelanggan" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Pelanggan..." value="<?php echo $_SESSION['nama_lengkap']; ?>" required />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="no_telp" class="col-sm-2 col-form-label">No. HP</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="No. Telp / HP" value="<?php echo $_SESSION['no_hp']; ?>" required />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="total_harga" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat..." value="<?php echo $_SESSION['alamat']; ?>" required />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="total_harga" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email..." value="<?php echo $_SESSION['email']; ?>" required />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="total_harga" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="username" id="username" placeholder="Username..." value="<?php echo $_SESSION['username']; ?>" required />
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="offset-md-2 col-sm-10">
                            <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
<!-- ##### Blog Area End ##### -->