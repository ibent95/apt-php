<?php
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";

        echo "<script>location.replace('?content=pemesanan')</script>";
    }
    $telurAll = getTelurAll();
    $pelangganAll = getPelangganAll();
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
                    
                    <div class="form-group row">
                        <label for="tgl_transaksi" class="col-md-3 control-label">Tanggal Transaksi</label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" name="tgl_transaksi" 
                                <?php if ($action == 'ubah'): ?>
                                    value="<?php echo $transaksi['tgl_transaksi']; ?>"
                                <?php endif ?>
                                id="tgl_transaksi" placeholder="Tanggal Transaksi..." />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="id_pelanggan" class="col-md-3 control-label">Pelanggan</label>
                        <div class="col-md-4">
                            <select class="form-control input-rounded input-focus" name="id_pelanggan" id="id_pelanggan">
                                <option value="">-- Silahakan Pilih Pelanggan --</option>
                                <?php foreach ($pelangganAll as $data): ?>
                                    <option 
                                        value="<?php echo $data['id_pelanggan']; ?>"
                                        <?php if ($action == 'ubah'): ?>
                                            <?php if ($transaksi['id_pelanggan'] == $data['id_pelanggan']): ?>
                                                selected
                                            <?php endif ?>
                                        <?php endif ?>
                                    >
                                        <?php echo $data['nama_pelanggan']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nama_layanan" class="col-md-3 control-label">Telur</label>
                        <div class="col-md-4">
                            <select class="form-control input-rounded input-focus" name="id_telur" id="id_telur">
                                <option value="">-- Silahakan Pilih Telur --</option>
                                <?php foreach ($telurAll as $data): ?>
                                    <option 
                                        value="<?php echo $data['id_telur']; ?>"
                                        <?php if ($action == 'ubah'): ?>
                                            <?php if ($transaksi['id_telur'] == $data['id_telur']): ?>
                                                selected
                                            <?php endif ?>
                                        <?php endif ?>
                                    >
                                        <?php echo $data['nama_telur']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tanggal_kerja" class="col-md-3 control-label">No. HP</label>
                        <div class="col-md-4">
                            <input 
                                class="form-control input-rounded input-focus" 
                                type="text" 
                                name="no_hp" 
                                <?php if ($action == 'ubah'): ?>
                                    value="<?php echo $transaksi['no_hp']; ?>"
                                <?php endif ?>
                                id="no_hp" 
                                placeholder="No. HP yang bisa dihubungi..."
                            />
                        </div>
                    </div>
                    
                    <div class="form-group row" id="form-lokasi" > <!-- style="display: none;" -->
                        <label class="col-md-3 control-label">Alamat</label>
                        <div class="col-md-9">
                            <input 
                                type="text" 
                                class="form-control input-rounded input-focus" 
                                name="alamat" 
                                <?php if ($action == 'ubah'): ?>
                                    value="<?php echo $transaksi['alamat']; ?>"
                                <?php endif ?>  
                                id="alamat"
                            >
                            <input 
                                type="hidden" 
                                class="form-control input-rounded input-focus" 
                                name="longlat" 
                                <?php if ($action == 'ubah'): ?>
                                    value="<?php echo $transaksi['longlat']; ?>"
                                <?php endif ?>
                                id="longlat"
                            >
                            <!-- <br> --> 
                            <div id="map" style="width:100%; height:500px"></div>
                            <script>
                                // function initMap() {
                                //     var lat = <?php //echo $longlat[1]; ?>;
                                //     var lng = <?php //echo $longlat[0]; ?>;
                                //     var input = document.getElementById('longlat');
                                //     if (lat == 0 && lng == 0 || lat == null && lng == null) {
                                //         var myLatlng = {
                                //             lat: -5.147665, 
                                //             lng: 119.432732
                                //         };
                                //     } else {
                                //         console.log(lng);
                                //         console.log(lat);
                                //         var myLatlng = {
                                //             lat: lat, 
                                //             lng: lng
                                //         };
                                //     }
                                    
                                //     var map = new GMaps({
                                //         el: '#map',
                                //         center: myLatlng,
                                //         center_changed: function(e) {
                                //             var lat = map.getCenter().lat();
                                //             var lng = map.getCenter().lng();
                                //             marker.setPosition(map.getCenter());
                                //             input.value = lng + ',' + lat;
                                //         }
                                //     });

                                    // Untuk memperbarui lokasi pengguna (tidak secara spesifik)
                                    // GMaps.geolocate({
                                    //     success: function(position) {
                                    //         map.setCenter(position.coords.latitude, position.coords.longitude);
                                    //     },
                                    //     error: function(error) {
                                    //         alert('Geolocation failed: '+error.message);
                                    //     },
                                    //     not_supported: function() {
                                    //         alert("Your browser does not support geolocation");
                                    //     },
                                    //     always: function() {
                                    //         // alert("Done!");
                                    //     }
                                    // });
                                // 
                                function initMap() {
                                    var lat = <?php echo $longlat[1]; ?>;
                                    var lng = <?php echo $longlat[0]; ?>;
                                    var input = document.getElementById('longlat');
                                    if (lat == 0 && lng == 0 || lat == null && lng == null) {
                                        var myLatlng = { 
                                            lat: -5.147665, 
                                            lng: 119.432732
                                        };
                                    } else {
                                        console.log(lat);
                                        console.log(lng);
                                        var myLatlng = { 
                                            lat: lat, 
                                            lng: lng
                                        };
                                    }
                                    var map = new google.maps.Map(document.getElementById('map'), {
                                        zoom: 15,
                                        center: myLatlng
                                    });
                                    var marker = new google.maps.Marker({
                                        position: myLatlng,
                                        map: map,

                                        title: 'Click to zoom'
                                    });

                                    map.addListener('center_changed', function() {
                                        var lnglat = map.getCenter();
                                        var lat = lnglat.lat();
                                        var lng = lnglat.lng();
                                        marker.setPosition(map.getCenter());
                                        input.value = lng + ',' + lat;
                                    });
                                    marker.addListener('click', function() {
                                        map.setZoom(18);
                                        map.setCenter(marker.getPosition());
                                    });
                                }
                            </script>
                        </div>
                    </div>

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