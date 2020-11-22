<?php
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? $_GET['id'] : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";

        echo "<script>window.location.replace('?content=data_kategori')</script>";
    }
    if ($action == 'ubah') {
        $kategori = mysqli_fetch_assoc(
            getKategoriById($id)
        );
    }
?>
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Data Pengguna</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li class=""><a href="javascript:void(0)">Home</a></li>
                    <li class=""><a href="javascript:void(0)">Master</a></li>
                    <li class=""><a href="?content=data_kategori">Data Kategori</a></li>
                    <li class="active">Form Data Kategori</li>
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
                <h4>Form Data Kategori Barang</h4>
            </div>

            <div class="card-body">
                <?php getNotifikasi(); ?>
                <form
                    class=""
                    <?php if ($action == 'tambah') : ?>
                        action="?content=data_kategori_proses&proses=add"
                    <?php else: ?>
                        action="?content=data_kategori_proses&proses=edit"
                    <?php endif ?>
                    method="POST"
                    enctype="multipart/form-data"
                >

                    <?php if ($action == 'ubah'): ?>
                        <input type="hidden" name="id" value="<?php echo antiInjection($_GET['id']); ?>">
                    <?php endif ?>

                    <div class="form-group">
                        <label for="nama_kategori" class="control-label">Nama Kategori</label>
                        <input
                            type="text"
                            class="form-control input-rounded input-focus"
                            name="nama_kategori"
                            placeholder="Masukan Nama Kategori Barang..."
                            id="nama_kategori"
                            <?php if ($action == 'ubah') : ?>
                                value="<?php echo $kategori['nama_kategori']; ?>"
                            <?php endif ?>
                        />
                    </div>

                    <!-- <div class="form-group">
                        <label for="Gambar" class="control-label col-md-3">Gambar</label>
                        <div class="col-md-12">
                            <input
                                type="file"
                                class="form-control form-control-file input-rounded input-focus"
                                name="gambar"
                                accept="images/*"
                                placeholder="Masukan Gambar..."
                                id="gambar"
                                <?php //if ($action == 'ubah') : ?>
                                    value="<?php //echo $kategori['gambar']; ?>"
                                <?php //endif ?>
                            >
                        </div>
                    </div> -->

                    <!-- <?php //if (!empty($kategori['gambar'])) : ?>
                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-9">
                                <img class="img-thumbnail" width='90dp' src='<?php //echo searchFile($kategori["gambar"], "img", "short"); ?>' id="image_gallery">
                            </div>
                        </div>
                    <?php //endif ?> -->

                    <div class="form-group">
                        <label for="deskripsi" class="control-label">Deskripsi</label>
                        <textarea class="form-control input-focus deskripsi" name="deskripsi" id="deskripsi" cols="30" rows="10" placeholder="Deskripsi"><?php if ($action == 'ubah'): ?><?php echo $kategori['deskripsi']; ?><?php endif ?></textarea>
                    </div>

                    <div class="form-group pull-right">
                        <button type="submit" class="btn btn-primary" name="simpan">
                            <i class="fa fa-check"></i>
                            Simpan
                        </button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>

                </form>
            </div>
            <!-- End Card Body -->

        </div>
        <!-- End Card -->

    </div>
    <!-- End Coloumn -->
</div>