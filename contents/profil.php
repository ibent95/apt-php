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
    $pelanggan  = mysqli_fetch_array(getPelangganById($_SESSION['id']), MYSQLI_BOTH);
    $orPending  = getTransaksiSubJoinByIdPelanggan($_SESSION['id'], 'tunggu');
    $orProses   = getTransaksiSubJoinByIdPelanggan($_SESSION['id'], 'proses_batal');
    $orSelesai  = getTransaksiSubJoinByIdPelanggan($_SESSION['id'], 'selesai');
    $orBatal    = getTransaksiSubJoinByIdPelanggan($_SESSION['id'], 'batal');
?>
<!-- ##### Breadcrumb Area Start ##### -->
<div class="breadcrumb-area">
	<!-- Top Breadcrumb Area -->
	<div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(assets/frontend/img/bg-img/24.jpg);">
		<h2>Profil [<?= $_SESSION['username'] ?>]</h2>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-12">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo $csv::$URL_BASE; ?>"><i class="fa fa-home"></i> Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">
                            <i class="fa fa-user"></i>
                            Profil
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
        <?php getNotifikasi(); ?>
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
                        <div class="row">
                            <div class="col-md-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="text-left">Foto</div>
                                    <div class="text-right">
                                        <button
                                            type="button"
                                            class="btn btn-link btn-sm mt-0 pt-0"
                                            data-toggle="modal"
                                            data-target="#modal_change_profil_picture"
                                            style="border-top: 0;"
                                        >
                                            Ganti
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </div>
                                </div>
                                <img class="img-thumbnail img-responsive" src="<?php echo searchFile($_SESSION["foto"], "img", "short"); ?>">
                            </div>

                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>
                                            Nama : <?php echo $pelanggan['nama_pelanggan']; ?>
                                            <a
                                                class="btn btn-link btn-sm ml-5"
                                                href="?content=profil_form&action=ubah"
                                            >
                                                <i class="fa fa-edit"></i>
                                                Ubah Data Profil
                                            </a>
                                            <br>
                                            No. Telepon : <?php echo $pelanggan['no_hp']; ?> <br>
                                            Alamat : <?php echo $pelanggan['alamat']; ?> <br><br>
                                            <!-- Button trigger modal -->
                                            <button
                                                type="button"
                                                class="btn btn-blue btn-md"
                                                data-toggle="modal"
                                                data-target="#modal_change_password">
                                                <!-- <i class="fa fa-5x fa-pencil-square-o"></i> -->
                                                <i class="fa fa-edit"></i>
                                                Ubah Password
                                            </button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ##### Blog Area End ##### -->