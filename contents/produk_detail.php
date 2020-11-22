<?php
    $id = (isset($_GET['id'])) ? $_GET['id'] : NULL ;
    if ($id == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Anda belum memilih barang..!";
        echo "<script>location.replace('?content=produk')</script>";
    }
    $barang = mysqli_fetch_array(
        getTelurJoinKategoriById($id),
        MYSQLI_BOTH
    );
    $kategoriAll = getKategoriAll('ASC');
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
                        <li class="breadcrumb-item"><a href="<?php echo $csv::$URL_BASE; ?>"><i class="fa fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <i class="fa fa-first-order"></i>
                            Transaksi
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

    <!-- Back Content -->
    <div class="container pb-3">
        <p>
            <button class="btn btn-dark" id="kembali" onclick="window.history.go(-1);">
                <i class="fa fa-arrow-left"></i>
                Kembali
            </button>
        </p>
    </div>
    <!-- Back Content End -->

    <!-- Main Content -->
    <div class="container pb-3">
        <div class="row">

            <!-- Main Content Right -->
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-5">
                        <img class="img-thumbnail float-right" src="<?= searchFile(mysqli_fetch_assoc(getFotoTelurByIdTelur($barang['id_telur'], 'ASC'))['url_foto'], "img", "short") ?>" alt="" style="height: 350px;" id="image_gallery">
                    </div>
                    <div class="col-md-7">
                        <p>
                            <form class="font-weight-bold" style="font-size: 18px;">
                                <div class="form-group row">
                                    <label for="nama_barang" class="col-sm-4 col-form-label">
                                        Nama Barang
                                    </label>
                                    <div class="col-sm-8">
                                        <label class="col-form-label" id="nama_barang">
                                            &nbsp: <?= $barang['nama_telur'] ?>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="nama_kategori" class="col-sm-4 col-form-label">
                                        Kategori
                                    </label>
                                    <div class="col-sm-8">
                                        <label class="col-form-label" id="nama_kategori">
                                            &nbsp: <?= $barang['nama_kategori'] ?>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="harga" class="col-sm-4 col-form-label">
                                        Harga
                                    </label>
                                    <div class="col-sm-8">
                                        <label class="col-form-label" id="harga">
                                            &nbsp: <?= format($barang['harga_jual'], 'currency'); ?>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="persediaan" class="col-sm-4 col-form-label">
                                        Persediaan
                                    </label>
                                    <div class="col-sm-8">
                                        <label class="col-form-label" id="persediaan">
                                            &nbsp: <?= $barang['persediaan'] ?>
                                        </label>
                                    </div>
                                </div>
                            </form>
                            <div class="py-2">
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_chart_add" data-id="<?php echo $barang[0]; ?>" data-act="cart_add" id="cart-add" <?php if ($barang['persediaan'] < 1) : ?>disabled <?php endif ?>>
                                    <i class="fa fa-cart-plus"></i>
                                    Masukan ke Keranjang
                                </button>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_chart_add" data-id="<?php echo $barang[0]; ?>" data-act="order_item" id="order-item" <?php if ($barang['persediaan'] < 1) : ?>disabled <?php endif ?>>
                                    <i class="fa fa-handshake-o"></i>
                                    Order
                                </button> <!-- href="?content=pemesanan&id=<?php //echo $barang[0]; ?>" -->
                            </div>
                        </p>
                    </div>
                </div>
            </div>
            <!-- Main Content Left End -->

            <!-- Main Content Right -->
            <div class="col-md-3">
                <div class="list-group">
                    <a class="list-group-item list-group-item-action bg-primary text-light">
                       Kategori
                    </a>
                    <?php if (mysqli_num_rows($kategoriAll) < 1) : ?>
                        <p>Belum Ada Data Kategori Barang..!</p>
                    <?php else : ?>
                        <?php foreach ($kategoriAll AS $data) : ?>
                            <a
                                href="<?= class_static_value::$URL_BASE ?>/?content=produk&id_kategori=<?= $data['id_kategori'] ?>"
                                class="list-group-item list-group-item-action"
                            >
                                <?= $data['nama_kategori'] ?>
                            </a>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            </div>
            <!-- Main Content Right End -->

        </div>
    </div>
</div>