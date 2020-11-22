<?php
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";

        echo "<script>location.replace('?content=pemesanan')</script>";
    }
    $kurirAll = getKurirAll();
    $longlat[0] = 0;
    $longlat[1] = 0;
    if ($action == 'ubah') {
        $transaksi = mysqli_fetch_array(
            getTransaksiById($id), 
            MYSQLI_BOTH
        );
        $transaksiDetailAll = getDetailTransaksiByIdTransaksi($transaksi['id']);
        if (!empty($transaksi['longlat'])) {
            $longlat = explode(",", $transaksi['longlat']);
        }
    }
?>
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Transaksi</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li class=""><a href="javascript:void(0)">Home</a></li>
                    <li class=""><a href="?content=data_transaksi">Transaksi</a></li>
                    <li class="active">Tambah Transaksi</li>
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
                <h4>Form Transaksi</h4>
            </div>

            <div class="card-body">
                <form 
                    class="form-horizontal" 
                    <?php if ($action == 'tambah'): ?>
                        action="?content=data_transaksi_proses&proses=add" 
                    <?php else: ?>
                        action="?content=data_transaksi_proses&proses=edit"
                    <?php endif ?> 
                    method="POST"
                    enctype="multipart/form-data"
                >
                    <?php if ($action == 'ubah'): ?>
                        <input type="hidden" name="id" value="<?php echo antiInjection($_GET['id']); ?>">
                    <?php endif ?>
                    
                    <div class="form-group">
                        <label for="id_kurir" class="col-md-3 control-label">Kurir</label>
                        <div class="col-md-12">
                            <select class="form-control" name="id_kurir" id="id_kurir">
                                <option value="">-- Silahakan Pilih Kurir --</option>
                                <?php foreach ($kurirAll as $data): ?>
                                    <option 
                                        value="<?php echo $data['id_kurir']; ?>"
                                        <?php if ($action == 'ubah'): ?>
                                            <?php if ($transaksi['id_kurir'] == $data['id_kurir']): ?>
                                                selected
                                            <?php endif ?>
                                        <?php endif ?>
                                    >
                                        <?php echo $data['nama_kurir']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <?php if ($action == 'ubah'): ?>
                        <div class="form-group">
                            <label for="status_pemesanan" class="col-md-3 control-label">Status Transaksi</label>
                            <div class="col-md-12">
                                <select class="form-control input-rounded input-focus" name="status_pemesanan" id="status_pemesanan">
                                    <option value="">-- Silahakan Pilih Status --</option>
                                    <option 
                                        value="tunggu"
                                        <?php if ($action == 'ubah'): ?>
                                            <?php if ($transaksi['status_pemesanan'] == 'tunggu'): ?>
                                                selected
                                            <?php endif ?>
                                        <?php endif ?>
                                    >
                                        Tunggu
                                    </option>
                                    <option 
                                        value="proses"
                                        <?php if ($action == 'ubah'): ?>
                                            <?php if ($transaksi['status_pemesanan'] == 'proses'): ?>
                                                selected
                                            <?php endif ?>
                                        <?php endif ?>
                                    >
                                        Proses
                                    </option>
                                    <option 
                                        value="batal"
                                        <?php if ($action == 'ubah'): ?>
                                            <?php if ($transaksi['status_pemesanan'] == 'batal'): ?>
                                                selected
                                            <?php endif ?>
                                        <?php endif ?>
                                    >
                                        Batal
                                    </option>
                                    <option 
                                        value="selesai"
                                        <?php if ($action == 'ubah'): ?>
                                            <?php if ($transaksi['status_pemesanan'] == 'selesai'): ?>
                                                selected
                                            <?php endif ?>
                                        <?php endif ?>
                                    >
                                        Selesai
                                    </option>
                                </select>
                            </div>
                        </div>
                    <?php endif ?>
                    
                    <div class="form-group pull-left">
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-primary" name="simpan"/>
                            <input type="reset" class="btn btn-danger"/>
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

<script async defer src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCS4nWrlFhpgaF-36KCGqDnUUj2PAlxi5c&callback=initMap'>
</script>

<!-- <script src="../assets/js/gmaps.min.js"></script> -->
        
<!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCS4nWrlFhpgaF-36KCGqDnUUj2PAlxi5c&callback=initMap"></script> -->