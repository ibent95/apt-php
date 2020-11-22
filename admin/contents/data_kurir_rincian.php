<?php 
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? $_GET['id'] : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";

        echo "<script>window.location.replace('?content=data_kurir')</script>";
    }
    $kurir = mysqli_fetch_array(getKurirById($id), MYSQLI_BOTH);
?>
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Kurir</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li class=""><a href="javascript:void(0)">Home</a></li>
                    <li class=""><a href="?content=data_kurir">Kurir</a></li>
                    <li class="active">Rincian</li>
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
                <h4>Kurir - Rincian</h4>
            </div>

            <div class="card-body">

                <?= getNotifikasi() ?>

                    <form class="form-horizontal row">
                        <div class="col-md-7">
                            <!-- <div class="form-group row">
                                <label for="nip" class="col-md-3 control-label text-right">NIP</label>
                                <div class="col-md-9">
                                    <input 
                                        type="text" 
                                        class="form-control-plaintext" 
                                        name="nip" 
                                        id="nip"
                                        value="<?php //echo $kurir['nip']; ?>"
                                    >
                                </div>
                            </div> -->

                            <div class="form-group row">
                                <label for="nama_kurir" class="col-md-3 control-label text-right">Nama Kurir</label>
                                <div class="col-md-9">
                                    <input 
                                        type="text" 
                                        class="form-control-plaintext" 
                                        name="nama_kurir" 
                                        id="nama_kurir"
                                        value="<?php echo $kurir['nama_kurir']; ?>"
                                        readonly
                                    >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="control-label col-md-3 text-right">Email</label>
                                <div class="col-md-6">
                                    <input 
                                        class="form-control-plaintext" 
                                        name="email" 
                                        id="email"
                                        value="<?php echo $kurir['email']; ?>"
                                        readonly
                                    >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="control-label col-md-3 text-right">No. Telepon</label>
                                <div class="col-md-9">
                                    <input 
                                        type="text" 
                                        class="form-control-plaintext" 
                                        name="telepon" 
                                        maxlength="13" 
                                        id="telepon"
                                        value="<?php echo $kurir['no_hp']; ?>"
                                        readonly
                                    >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="alamat" class="control-label col-md-3 text-right">Alamat</label>
                                <div class="col-md-9">
                                    <input 
                                        type="text" 
                                        class="form-control-plaintext" 
                                        name="alamat" 
                                        id="alamat"
                                        value="<?php echo $kurir['alamat']; ?>"
                                        readonly
                                    >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="username" class="control-label col-md-3 text-right">Username</label>
                                <div class="col-md-9">
                                    <input 
                                        type="text" 
                                        class="form-control-plaintext" 
                                        name="username" 
                                        id="username"
                                        value="<?php echo $kurir['username']; ?>"
                                        readonly
                                    >
                                </div>
                            </div>

                            <!-- <div class="form-group row">
                                <label for="agama" class="control-label col-md-3 text-right">Agama</label>
                                <div class="col-md-9">
                                    <input class="form-control-plaintext" name="agama" id="agama" value="<?php //if ($kurir['agama'] == 'islam') : ?>Islam<?php //elseif ($kurir['agama'] == 'kristen') : ?>Kristen<?php //elseif ($kurir['agama'] == 'katolik') : ?>Katolik<?php //elseif ($kurir['agama'] == 'hindu') : ?>Hindu<?php //elseif ($kurir['agama'] == 'budha') : ?>Budha<?php //endif ?>">
                                </div>
                            </div> -->

                            <!-- <div class="form-group row">
                                <label for="alamat" class="control-label col-md-3 text-right">Alamat</label>
                                <div class="col-md-9">
                                    <input 
                                        type="text" 
                                        class="form-control-plaintext" 
                                        name="alamat" 
                                        id="alamat"
                                        value="<?php //echo $kurir['alamat']; ?>"
                                    >
                                </div>
                            </div> -->

                            <!-- <div class="form-group row">
                                <label for="jenis_pegawai" class="control-label col-md-3 text-right">Jenis Akun</label>
                                <div class="col-md-9">
                                    <input 
                                        class="form-control-plaintext" 
                                        name="jenis_pegawai" 
                                        id="jenis_pegawai" 
                                        value="<?php //if ($kurir['jenis_akun'] == 'admin') : ?>Administrator<?php //elseif ($kurir['jenis_akun'] == 'honorer') : ?>Honorer<?php //endif ?>"
                                        readonly
                                    >
                                </div>
                            </div> -->

                            <!-- <div class="form-group row">
                                <label for="id_jabatan" class="control-label col-md-3 text-right">Jabatan</label>
                                <div class="col-md-9">
                                    <input 
                                        class="form-control-plaintext" 
                                        name="id_jabatan" 
                                        id="id_jabatan"
                                        value="<?php //foreach ($jabatanAll as $data) : ?><?php //if ($kurir['id_jabatan'] == $data['id']) : ?><?php //echo $data['nama_jabatan']; ?><?php //endif ?><?php //endforeach ?>"
                                    >
                                </div>
                            </div> -->

                            <div class="form-group row">
                                <label for="status_akun" class="control-label col-md-3 text-right">Status Akun</label>
                                <div class="col-md-9">
                                    <input 
                                        class="form-control-plaintext" 
                                        name="status_akun" 
                                        id="status_akun" 
                                        value="<?php if ($kurir['status_akun'] == 'aktif') : ?>Aktif<?php elseif ($kurir['status_akun'] == 'blokir') : ?>Non Aktif<?php endif ?>"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <!-- Foto Fix -->
                            <div class="form-group row">
                                <label for="foto" class="control-label col-md-3 text-right">
                                    Foto
                                </label>
                                <div class="col-md-9">
                                    <?php if (!empty($kurir['foto'])) : ?>
                                        <div class="form-group">
                                            <img class="img-thumbnail" src='<?php echo searchFile($kurir['foto'], "img", "short"); ?>' id="image_gallery" />
                                        </div>
                                    <?php endif ?> 
                                </div>
                            </div>
                        </div>

                        <!-- <div class="form-group pull-left">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-primary" name="simpan" value="Simpan" />
                                <input type="reset" class="btn btn-danger" value="Reset" />
                            </div>
                        </div> -->

                    </form>
                </div>
                <!-- End Card Body -->

            </div>
            <!-- End Card -->

        </div>
        <!-- End Coloumn -->

    </div>
    <!-- End Row -->

</div>