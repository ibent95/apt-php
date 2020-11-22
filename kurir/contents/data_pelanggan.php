<?php
    if (isset($_GET['page'])) {
        $page = antiInjection($_GET['page']);
    } else {
        $page = 1;
    }

    if (isset($_GET['record_count']) && !empty($_GET['record_count'])) {
        class_static_value::$record_count = $_GET['record_count'];
    }

    $pelangganAll = getPelangganLimitAll($page, class_static_value::$record_count);

    $pagination = new Zebra_Pagination();
    $pagination->records(mysqli_num_rows(getPelangganAll()));
    $pagination->records_per_page(class_static_value::$record_count);
    $inc = 1;
?>
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Pelanggan</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li class=""><a href="javascript:void(0)">Home</a></li>
                    <li class=""><a href="javascript:void(0)">Data Master</a></li>
                    <li class=""><a href="?content=data_pelanggan">Data Pengguna</a></li>
                    <li class="active">Pelanggan</li>
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
                <h4>Daftar Pelanggan </h4>
            </div>

            <div class="card-body">

                <?php getNotifikasi(); ?>

                <div class="row">
                    <div class="col-md-6">
                        <p class="pull-left">
                            <a class="btn btn-primary" href="?content=data_pelanggan_form&action=tambah">
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
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Pelanggan</th>
                                <th>Alamat</th>
                                <th>No. Telepon</th>
                                <!-- <th>Jenis Akun</th> -->
                                <th>Status Akun</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="data_list">
                            <?php if (mysqli_num_rows($pelangganAll) == 0): ?>
                                <tr>
                                    <td colspan="6">
                                        <center>
                                            Tidak ada data..!
                                        </center>
                                    </td>
                                </tr>
                            <?php endif ?>
                            <?php if (mysqli_num_rows($pelangganAll) >= 1): ?>
                                <?php foreach ($pelangganAll as $data): ?>
                                    <tr>
                                        <td>
                                            <?php echo $inc; ?>
                                        </td>
                                        <td>
                                            <?php echo $data['nama_pelanggan']; ?>
                                        </td>
                                        <td>
                                            <?php echo $data['alamat']; ?>
                                        </td>
                                        <td>
                                            <?php echo $data['no_hp']; ?>
                                        </td>
                                        <!-- <td>
                                            <?php //echo $data['jenis_akun']; ?>
                                        </td> -->
                                        <td>
                                            <?php echo setBadges($data['status_akun']); ?>
                                        </td>
                                        <td>
                                            <a
                                                class="btn btn-dark btn-sm"
                                                href="?content=data_pelanggan_rincian&action=lihat&id=<?php echo $data['id_pelanggan']; ?>"
                                                id="detail_pelanggan"
                                            >
                                                <i class="fa fa-list"></i>
                                                Rincian
                                            </a>
                                            <a
                                                class="btn btn-primary btn-sm"
                                                href="?content=data_pelanggan_form&action=ubah&id=<?php echo $data['id_pelanggan']; ?>"
                                            >
                                                <i class="fa fa-edit"></i>
                                                Ubah
                                            </a>
                                            <a
                                                class="btn btn-danger btn-sm"
                                                href="?content=data_pelanggan_proses&proses=remove&id=<?php echo $data['id_pelanggan']; ?>"
                                                onclick="return confirm('Apakah anda yakin ingin menghapus data ini..?');"
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

                <p>
                    <?php $pagination->render(); ?>
                </p>

            </div>
            <!-- End Card Body -->

        </div>
        <!-- End Card -->



    </div>
    <!-- End Coloumn -->

</div>