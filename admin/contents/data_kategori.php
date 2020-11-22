<?php

    if (isset($_GET['page'])) {
        $page = antiInjection($_GET['page']);
    } else {
        $page = 1;
    }

    if (isset($_GET['record_count']) && !empty($_GET['record_count'])) {
        class_static_value::$record_count = $_GET['record_count'];
    }

    $kategoriAll = getKategoriLimitAll($page, class_static_value::$record_count);

    $pagination = new Zebra_Pagination();
    $pagination->records(mysqli_num_rows(getKategoriAll()));
    $pagination->records_per_page(class_static_value::$record_count);

    $inc = 1;
?>
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Data Kategori</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li class=""><a href="javascript:void(0)">Home</a></li>
                    <li class=""><a href="javascript:void(0)">Master</a></li>
                    <li class="active">Data Kategori</li>
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
                <h4>Daftar Kategori Barang</h4>
            </div>

            <div class="card-body">

                <?php getNotifikasi(); ?>

                <div class="row">
                    <div class="col-md-6">
                        <p class="pull-left">
                            <a class="btn btn-primary" href="?content=data_kategori_form&action=tambah">
                                Tambah Data
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
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="kata_kunci"
                                        id="kata_kunci"
                                        placeholder="Kata Kunci Pencarian"
                                        onchange="search(
                                            <?php echo $page; ?>,
                                            <?php echo class_static_value::$record_count; ?>,
                                            '<?php echo $_GET['content']; ?>',
                                            $('input#kata_kunci').val()
                                        );"
                                    />
                                </div>
                                <button
                                    class="btn btn-secondary mb-2"
                                    onclick="search(
                                        <?php echo $page; ?>,
                                        <?php echo class_static_value::$record_count; ?>,
                                        '<?php echo $_GET['content']; ?>',
                                        $('input#kata_kunci').val()
                                    );"
                                >
                                    Cari
                                </button>
                            </div>
                        </p>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" style="">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Kategori</th>
                                <!-- <th>Gambar</th> -->
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="data_list">
                            <?php if (mysqli_num_rows($kategoriAll) == 0): ?>
                                <tr>
                                    <td colspan="4">
                                        <center>
                                            Tidak ada data..!
                                        </center>
                                    </td>
                                </tr>
                            <?php endif ?>
                            <?php if (mysqli_num_rows($kategoriAll) >= 1): ?>
                                <?php foreach ($kategoriAll as $data): ?>
                                    <tr>
                                        <!-- <td>
                                            <a>
                                                <img
                                                    class="img-thumbnail rounded"
                                                    src="<?php //echo searchFile($data["gambar"], "img", "short"); ?>"
                                                    alt="<?php //echo $data['nama_kategori']; ?>"
                                                    style="height: 100px;"
                                                >
                                            </a>
                                        </td> -->
                                        <td>
                                            <?php echo $inc; ?>
                                        </td>
                                        <td>
                                            <?php echo $data['nama_kategori']; ?>
                                        </td>
                                        <td class="text-justify">
                                            <?php
                                                if ($data['deskripsi']) {
                                                    echo htmlspecialchars_decode(substr($data['deskripsi'], 0, 75) . "...");
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <a
                                                class="btn btn-primary btn-sm"
                                                href="?content=data_kategori_form&action=ubah&id=<?php echo $data['id_kategori']; ?>"
                                                style="width: none;"
                                            >
                                                <i class="fa fa-edit"></i>
                                                Ubah
                                            </a>
                                            <a
                                                class="btn btn-danger btn-sm"
                                                href="?content=data_kategori_proses&proses=remove&id=<?php echo $data['id_kategori']; ?>"
                                                style="width: none;"
                                                onclick="return confirm('Anda yakin ingin menghapus data ini..?');"
                                            >
                                                <i class="fa fa-times"></i>
                                                Hapus
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $inc++; ?>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>

                <p><?php $pagination->render(); ?></p>

            </div>
            <!-- End Card Body -->
        </div>
        <!-- End Card -->

    </div>
    <!-- End Coloukategori -->
</div>