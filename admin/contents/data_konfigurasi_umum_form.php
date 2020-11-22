<?php
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";

        echo "<script>location.replace('?content=data_konfigurasi_umum')</script>";
    }
    if ($action == 'ubah') {
        $konfigurasiUmum = mysqli_fetch_assoc(
            getKonfigurasiUmumById($id)
        );
    }
?>
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Data Konfigurasi</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li class=""><a href="javascript:void(0)">Home</a></li>
                    <li class=""><a href="javascript:void(0)">Data Konfigurasi</a></li>
                    <li class=""><a href="?content=data_konfigurasi_umum">Umum</a></li>
                    <li class="active">Tambah Data Konfigurasi Umum</li>
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
                <h4>Form Data Konfigurasi Umum</h4>
            </div>

            <div class="card-body">
                <form
                    class="form-horizontal"
                    <?php if ($action == 'tambah'): ?>
                        action="?content=data_konfigurasi_umum_proses&proses=add"
                    <?php else: ?>
                        action="?content=data_konfigurasi_umum_proses&proses=edit"
                    <?php endif ?>
                    method="POST"
                >
                    <?php if ($action == 'ubah'): ?>
                        <input type="hidden" name="id" value="<?php echo antiInjection($_GET['id']); ?>">
                    <?php endif ?>

                    <div class="form-group">
                        <label for="nama_konfigurasi" class="control-label">Nama Konfigurasi</label>
                        <input
                            type="text"
                            class="form-control input-rounded input-focus"
                            name="nama_konfigurasi"
                            placeholder="Masukan Nama Konfigurasi..."
                            id="nama_konfigurasi"
                            <?php if ($action == 'ubah'): ?>
                                value="<?php echo $konfigurasiUmum['nama_konfigurasi']; ?>"
                            <?php endif ?>
                        />
                    </div>

                    <!-- Select -->
                    <div class="form-group">
                       <label for="nilai_konfigurasi" class="control-label">Nilai Konfigurasi</label>
                        <input
                            type="text"
                            class="form-control input-rounded input-focus"
                            name="nilai_konfigurasi"
                            placeholder="Masukan Nilai Konfigurasi..."
                            id="nilai_konfigurasi"
                            <?php if ($action == 'ubah') : ?>
                                value="<?php echo $konfigurasiUmum['nilai_konfigurasi']; ?>"
                            <?php endif ?>
                        />
                    </div>

                    <div class="form-group">
                        <label for="keterangan" class="control-label">Keterangan</label>
                        <textarea class="form-control input-focus" name="keterangan" id="keterangan" rows="3" placeholder="Keterangan..."><?php if ($action == 'ubah') : ?><?php echo $konfigurasiUmum['keterangan']; ?><?php endif ?></textarea>
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
