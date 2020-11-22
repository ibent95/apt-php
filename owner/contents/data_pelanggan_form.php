<?php 
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? $_GET['id'] : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";

        echo "<script>window.location.replace('?content=data_pelanggan')</script>";
    }
    if ($action == 'ubah') {
        $pelanggan = mysqli_fetch_assoc(getPelangganById($id));
    }
?>
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Data Pelanggan</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li class=""><a href="javascript:void(0)">Home</a></li>
                    <li class=""><a href="javascript:void(0)">Master</a></li>
                    <li class=""><a href="javascript:void(0)">Data Pengguna</a></li>
                    <li class=""><a href="?content=data_pelanggan">Pelanggan</a></li>
                    <li class="active">Tambah Data Pelanggan</li>
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
                <h4>Form Data Pelanggan</h4>
            </div>
            
            <div class="card-body">
                
                <?php getNotifikasi(); ?>
                
                <form 
                    class="" 
                    <?php if ($action == 'ubah'): ?>
                        action="?content=data_pelanggan_proses&proses=edit" 
                    <?php else: ?>
                        action="?content=data_pelanggan_proses&proses=add"
                    <?php endif ?>
                    method="POST"
                    enctype="multipart/form-data"
                >
                    <?php if ($action == 'ubah'): ?>
                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                    <?php endif ?>

                    <div class="form-group">
                        <label for="nama_pelanggan" class="control-label">Nama Pelanggan</label>
                        <input 
                            type="text" 
                            class="form-control input-rounded input-focus" 
                            name="nama_pelanggan" 
                            placeholder="Masukan Nama Pelanggan..." 
                            id="nama_pelanggan"
                            <?php if ($action == 'ubah'): ?>
                                value="<?php echo $pelanggan['nama_pelanggan']; ?>"
                            <?php endif ?>
                        >
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="email" class="control-label">Email</label>
                            <input 
                                type="email" 
                                class="form-control input-rounded input-focus" 
                                name="email" 
                                placeholder="Masukan Email..." 
                                id="email"
                                <?php if ($action == 'ubah'): ?>
                                    value="<?php echo $pelanggan['email']; ?>"
                                <?php endif ?>
                            >
                        </div>
                        <div class="col-md-6">
                            <label for="no_hp" class="control-label">No. Telepon</label>
                            <input 
                                type="text" 
                                class="form-control input-rounded input-focus" 
                                name="no_hp" 
                                maxlength="13" 
                                placeholder="Masukan No. Telepon..." 
                                id="no_hp"
                                <?php if ($action == 'ubah'): ?>
                                    value="<?php echo $pelanggan['no_hp']; ?>"
                                <?php endif ?>
                            >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="alamat" class="control-label">Alamat</label>
                        <input 
                            type="text" 
                            class="form-control input-rounded input-focus" 
                            name="alamat" 
                            placeholder="Masukan Alamat..." 
                            id="alamat"
                            <?php if ($action == 'ubah'): ?>
                                value="<?php echo $pelanggan['alamat']; ?>"
                            <?php endif ?>
                        >
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="alamat" class="control-label">Username</label>
                            <input 
                                type="text" 
                                class="form-control input-rounded input-focus" 
                                name="username" 
                                placeholder="Masukan Username..." 
                                id="username"
                                <?php if ($action == 'ubah'): ?>
                                    value="<?php echo $pelanggan['username']; ?>"
                                <?php endif ?>
                            >
                        </div>
                        <?php if ($action == 'tambah'): ?>
                            <div class="col-md-6">
                                <label for="password" class="control-label">Password</label>
                                    <input 
                                        type="password" 
                                        class="form-control input-rounded input-focus" 
                                        name="password" 
                                        placeholder="Masukan Password..." 
                                        id="password"
                                        <?php if ($action == 'ubah'): ?>
                                            value="<?php echo $pelanggan['password']; ?>"
                                        <?php endif ?>
                                    />
                            </div>
                        <?php endif ?>
                    </div>

                    <!-- <div class="form-group">
                        <label for="jenis_akun" class="control-label col-md-3">Jenis Akun</label>
                        <div class="col-md-5">
                            <select class="form-control input-rounded input-focus" name="jenis_akun" id="jenis_akun">
                                <option value="">-- Silahkan Pilih Jenis Akun --</option>
                                <option 
                                    value="admin"
                                    <?php //if ($action == 'ubah' && $pelanggan['jenis_akun'] == 'admin'): ?>
                                        selected
                                    <?php //endif ?>
                                >
                                    Administrator
                                </option>
                                <option 
                                    value="teknisi"
                                    <?php // if ($action == 'ubah' && $pelanggan['jenis_akun'] == 'teknisi'): ?>
                                        selected
                                    <?php // endif ?>
                                >
                                    Teknisi
                                </option>
                                <option 
                                    value="pimpinan"
                                    <?php //if ($action == 'ubah' && $pelanggan['jenis_akun'] == 'pimpinan'): ?>
                                        selected
                                    <?php //endif ?>
                                >
                                    Pimpinan
                                </option>
                                <option 
                                    value="pelanggan"
                                    <?php // if ($action == 'ubah' && $pelanggan['jenis_akun'] == 'pelanggan'): ?>
                                        selected
                                    <?php // endif ?>
                                >
                                    Pelanggan
                                </option>
                            </select>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <label for="foto" class="control-label">
                            Foto
                        </label>
                        <input 
                            type="file" 
                            class="form-control input-rounded input-focus" 
                            name="foto" 
                            accept="images/*"
                            id="foto"
                            <?php if ($action == 'ubah'): ?>
                                value="<?php echo $pelanggan['foto']; ?>"
                            <?php endif ?>
                        />
                    </div>

                    <?php 
                        if (!empty($pelanggan['foto'])): 
                    ?>
                        <div class="form-group">
                            <div class="">
                                <img class="img-thumbnail" width='90dp' src='<?php echo searchFile($pelanggan["foto"], "img", "short"); ?>' id="image_gallery" />
                            </div>
                        </div>
                    <?php endif ?>

                    <div class="form-group row">
                        <div class="col-md-5">
                            <label for="status_akun" class="control-label">Status Akun</label>
                            <select class="form-control input-rounded input-focus" name="status_akun" id="status_akun">
                                <option value="">-- Silahkan Pilih Status Akun --</option>
                                <option 
                                    value="aktif"
                                    <?php if ($action == 'ubah' && $pelanggan['status_akun'] == 'aktif'): ?>
                                        selected
                                    <?php endif ?>
                                >
                                    Aktif
                                </option>
                                <option 
                                    value="non_aktif"
                                    <?php if ($action == 'ubah' && $pelanggan['status_akun'] == 'non_aktif'): ?>
                                        selected
                                    <?php endif ?>
                                >
                                    Non Aktif
                                </option>
                                <option 
                                    value="blokir"
                                    <?php if ($action == 'ubah' && $pelanggan['status_akun'] == 'blokir'): ?>
                                        selected
                                    <?php endif ?>
                                >
                                    Blokir
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group pull-left">
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

</div>