<?php
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";

        echo "<script>location.replace('?content=data_transaksi')</script>";
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
                    <li class="active">Pilih Kurir</li>
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
                <h4>Form Transaksi - Pilih Kurir</h4>
            </div>

            <div class="card-body">
                <form 
                    class="form-horizontal" 
                    <?php if ($action == 'tambah'): ?>
                        action="?content=data_transaksi_proses&proses=add" 
                    <?php else: ?>
                        action="?content=data_transaksi_proses&proses=set_currier"
                    <?php endif ?> 
                    method="POST"
                    enctype="multipart/form-data"
                >
                    <?php if ($action == 'ubah' OR $action == 'persetujuan'): ?>
                        <input type="hidden" name="id" value="<?php echo antiInjection($_GET['id']); ?>">
                    <?php endif ?>
                    
                    <div class="form-group row">
                        <label for="id_kurir" class="col-md-1 control-label">Kurir</label>
                        <div class="col-md-4">
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
                    
                    <div class="form-group row">
                        <div class="offset-md-1 col-md-11 pull-left">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="reset" class="btn btn-danger">Reset</button>
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