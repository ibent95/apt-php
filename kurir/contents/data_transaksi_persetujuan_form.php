<?php
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "success";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";
        echo "<script>location.replace('?content=data_transaksi')</script>";
    }
    // if ($action == 'persetujuan') {
    $transaksi = mysqli_fetch_array(getTransaksiJoinAllById($id), MYSQLI_BOTH);
    $transaksiDetailAll = getDetailTransaksiJoinAllByIdTransaksi($transaksi['id_transaksi']);
    if (!empty($transaksi['longlat'])) {
        $longlat = explode(",", $transaksi['longlat']);
    } else {
        $longlat[0] = 0;
        $longlat[1] = 0;
    }
    $pembayaran = mysqli_fetch_array(getBuktiPembayaranByIdTransaksi($transaksi['id_transaksi'], NULL, 'DESC'), MYSQLI_BOTH);
    $biayaTambahanAll = getBiayaTambahanByIdTransaksi($transaksi['id_transaksi']);
    $biayaKerusakanAll = getBiayaKerusakanByIdTransaksi($transaksi['id_transaksi']);
    $totalHarga = 0;
    // }
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
                    <li class="active">Approval</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Container fluid  -->
<div class="content mt-3">
    <div class="col-md-12">
        <div class="card text-dark">

            <div class="card-header">
                <button class="btn btn-default text-dark" onclick="window.history.go(-1);" role="button" data-toggle="button" aria-pressed="false" autocomplete="off">
                        <i class="fa fa-arrow-left"></i>
                        Kembali
                    </button>
            </div>

            <div class="card-body">
                <div class="card-title"><h4><?php if ($action == "persetujuan") echo "Form Persetujuan "; ?></h4></div>
                <?php if ($action == "persetujuan") : ?>
                    <p class="text-dark">Tindak lanjut atau persetujuan untuk transaksi : </p>
                <?php endif ?>

                <div class="text-dark">
                    <div class="row">
                        <div class="col-md-5">

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">ID\NO Transaksi</label>
                                <div class="col-md-8">
                                    <input class="form-control-plaintext" type="text" value=": <?= $transaksi['id_transaksi'] . " \ " . $transaksi['no_transaksi'] ?>" disabled/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">Tanggal Transaksi</label>
                                <div class="col-md-8">
                                    <input class="form-control-plaintext" type="text" value=": <?php echo $transaksi['tgl_transaksi']; ?>" disabled />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">Pelanggan</label>
                                <div class="col-md-8">
                                    <input class="form-control-plaintext" type="text" value=": <?php echo $transaksi['nama_pelanggan']; ?>" disabled />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">Status Pembayaran</label>
                                <div class="col-md-8">
                                    <div class="form-control-plaintext">
                                        : <?php echo setBadges($pembayaran['info_pembayaran']); ?>
                                    </div>
                                </div>
                            </div>

                            <?php 
                                if (!empty($pembayaran['bukti_pembayaran'])) : 
                            ?>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">Bukti Pembayaran</label>
                                    <div class="col-md-8">
                                        <img class=" img-thumbnail" width='90dp' src='<?php echo searchFile("$pembayaran[bukti_pembayaran]", "img", "short"); ?>' id="image_gallery">
                                    </div>
                                </div>
                            <?php endif ?>
                            
                        </div>
                        
                        <div class="col-md-7">
                            <?php if ($transaksi['keterangan'] != null or $transaksi['keterangan'] != "") : ?>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Keterangan</label>
                                    <div class="col-md-9">
                                        <div class="form-control-plaintext">
                                            : <?php echo $transaksi['keterangan']; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Diantarkan</label>
                                <div class="col-md-9">
                                    <div class="form-control-plaintext">
                                        : <?php echo setBadges($transaksi['diantarkan']); ?>
                                    </div>
                                </div>
                            </div>
                            <?php if ($transaksi['diantarkan'] == 'ya'): ?>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Tanggal Pengantaran</label>
                                    <div class="col-md-9">
                                        <input 
                                            class="form-control-plaintext" 
                                            type="text" 
                                            value=": <?php echo $transaksi['tgl_pengantaran']; ?>"
                                            disabled
                                        />
                                    </div>
                                </div>

                                <div class="form-group row" id="form-lokasi" > <!-- style="display: none;" -->
                                    <label class="col-md-3 col-form-label">Alamat Pengantaran</label>
                                    <div class="col-md-9">
                                        <textarea 
                                            class="form-control-plaintext" 
                                            id="alamat" 
                                            cols="30" 
                                            rows="2"
                                        >: <?php echo $transaksi['alamat']; ?></textarea>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>

                    <!-- Data Belanjaan -->
                    <div class="row">
                        <div class="col-md-12">
                            <label for="table" class="">Data Belanjaan :</label>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>ID Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Harga Satuan (Rp)</th>
                                            <th>Kuantitas</th>
                                            <th>Jumlah Harga (Rp)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $inc = 1; ?>
                                        <?php foreach ($transaksiDetailAll as $data2) : ?>
                                            <tr>
                                                <td>
                                                    <?= $inc ?>
                                                </td>
                                                <td>
                                                    <?php echo $data2['id_telur']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $data2['nama_telur']; ?>
                                                </td>
                                                <td class="text-right">
                                                    <?php echo format($data2['harga_jual'], 'currency'); ?>
                                                </td>
                                                <td class="text-right">
                                                    <?php echo $data2['kuantitas']; ?>
                                                </td>
                                                <td class="text-right">
                                                    <?php 
                                                        echo format($data2['jumlah_harga'], 'currency'); 
                                                        $totalHarga += $data2['jumlah_harga'];
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php $inc++; ?>
                                        <?php endforeach ?>
                                        <?php if (mysqli_num_rows($biayaTambahanAll) > 0): ?>
                                            <?php foreach ($biayaTambahanAll as $data) : ?>
                                                <tr><td colspan="6">&nbsp Biaya Tambahan</td></tr>
                                                <tr>
                                                    <td><?= $inc ?></td>
                                                    <td colspan="4">
                                                        <?php echo $data['keterangan']; ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <?php echo format($data['jumlah'], 'currency'); ?>
                                                        <?php $totalHarga += $data['jumlah']; ?>
                                                    </td>
                                                </tr>
                                                <?php $inc++; ?>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="text-right font-weight-bold">
                                            <td colspan="5">Total Harga (Rp)</td>
                                            <td>
                                                <?php echo format($totalHarga, 'currency'); ?>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!-- Data Belanjaan End -->

                    <!-- Data Kerusakan -->
                    <div class="row">
                        <div class="col-md-12">
                            <label for="table" class="">
                                Data Kerusakan Barang 
                                <?php if ($action != 'lihat') : ?>
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_form_biaya_kerusakan" 
                                        <?php echo "data-id_transaksi=\"" . $id . "\""; ?> 
                                        <?php echo "data-action=\"tambah\""; ?> 
                                    id="tambah_biaya_kerusakan">
                                        <i class="fa fa-plus"></i>
                                        Tambah
                                    </button>
                                <?php endif ?>
                            :
                            </label>
                            <div class="table-responsive">
                                <!-- <p><?php //print_r(array_keys($_SESSION["damage_cost"])); ?></p> -->
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>Keterangan</th>
                                            <th>Jumlah Harga (Rp)</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $inc = 1; ?>
                                        <?php foreach ($biayaKerusakanAll as $data2) : ?>
                                            <tr>
                                                <td><?= $inc ?></td>
                                                <td>
                                                    <?php echo $data2['keterangan']; ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        echo format($data2['jumlah'], 'currency'); 
                                                        $totalHarga += $data2['jumlah'];
                                                    ?>
                                                </td>
                                                <td class="text-right">
                                                    <?php if ($action != 'lihat') : ?>
                                                        <button
                                                            class="btn btn-warning btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#modal_form_biaya_kerusakan"
                                                            <?php echo "data-id_biaya_kerusakan=\"" . $data2['id_biaya_kerusakan'] . "\""; ?>
                                                            <?php echo "data-id_transaksi=\"" . $id . "\""; ?>
                                                            <?php echo "data-action=\"ubah\""; ?>
                                                            id="ubah_biaya_kerusakan"
                                                        >
                                                            <i class="fa fa-edit"></i>
                                                            Ubah
                                                        </button>
                                                        <a class="btn btn-danger btn-sm" href="?content=data_transaksi_persetujuan_proses&proses=remove_biaya_kerusakan&id=<?= $data2['id_biaya_kerusakan'] ?>" onclick="return confirm('Anda yakin ingin menghapus data ini..?');">
                                                            <i class="fa fa-times"></i>
                                                            Hapus
                                                        </a>
                                                    <?php endif ?>
                                                </td>
                                            </tr>
                                            <?php $inc++; ?>
                                        <?php endforeach ?>
                                        <?php if (isset($_SESSION['damage_cost'])) : ?>
                                            <?php
                                                $array = array_keys($_SESSION["damage_cost"]);
                                                for ($i = 0; $i <= end($array); $i++) :
                                            ?>
                                                <?php if (isset($_SESSION["damage_cost"][$i])) : ?>
                                                    <tr>
                                                        <td><?= $inc ?></td>
                                                        <td>
                                                            <?php echo $_SESSION["damage_cost"][$i]['keterangan']; ?>
                                                        </td>
                                                        <td class="text-right">
                                                            <?php 
                                                                echo format($_SESSION["damage_cost"][$i]['jumlah'], 'currency'); 
                                                                $totalHarga -= $_SESSION["damage_cost"][$i]['jumlah'];
                                                            ?>

                                                        </td>
                                                        <td>
                                                            <button
                                                                class="btn btn-warning btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#modal_form_damage_cost" 
                                                                <?php echo "data-id_array=\"" . $i ."\""; ?>
                                                                <?php echo "data-id_transaksi=\"" . $id . "\""; ?>
                                                                <?php echo "data-action=\"ubah\""; ?>
                                                                id="ubah_biaya_kerusakan"
                                                            >
                                                                <i class="fa fa-edit"></i>
                                                                Ubah
                                                            </button>
                                                            <a class="btn btn-danger btn-sm" href="?content=data_transaksi_persetujuan_proses&proses=remove_damage_cost&id=<?= $i ?>" onclick="return confirm('Anda yakin ingin menghapus data ini..?');">
                                                                <i class="fa fa-times"></i>
                                                                Hapus
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php $inc++ ?>
                                                <?php endif ?>
                                            <?php endfor ?>
                                        <?php endif ?>
                                        <!-- End Biaya Tambahan -->
                                    </tbody>
                                    <tfoot>
                                        <tr class="text-right font-weight-bold">
                                            <td colspan="2">Total Harga (Rp)</td>
                                            <td>
                                                <?php echo format($totalHarga, 'currency'); ?>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            
                        </div>
                    </div>

                </div>

                <form 
                    class="form-horizontal" 
                    <?php if ($action == 'tambah'): ?>
                        action="?content=data_transaksi_persetujuan_proses&proses=add" 
                    <?php else: ?>
                        action="?content=data_transaksi_persetujuan_proses&proses=edit"
                    <?php endif ?>
                    method="POST"
                    enctype="multipart/form-data"
                >
                    <?php if ($action != 'lihat'): ?>
                        <input type="hidden" name="id_transaksi" value="<?= antiInjection($_GET['id']) ?>">
                        <input type="hidden" name="total_harga" value="<?= $totalHarga ?>">
                        <div class="form-group row">
                            <label for="kurir_check" class="col-md-2 control-label">Kurir Check</label>
                            <div class="col-md-5">
                                <select class="form-control input-rounded input-focus" name="kurir_check" id="kurir_check">
                                    <option value="">-- Silahakan Pilih Status --</option>
                                    <option value="belum"
                                        <?php if ($action == 'persetujuan' AND $transaksi['kurir_check'] == 'belum') : ?>
                                            selected
                                        <?php endif ?>
                                    >
                                        Belum
                                    </option>
                                    <option value="sudah"
                                        <?php //if ($action == 'persetujuan' AND $transaksi['kurir_check'] == 'sudah') : ?> 
                                            selected
                                        <?php //endif ?>
                                    >
                                        Sudah
                                    </option>
                                    <option value="selesai"
                                        <?php if ($action == 'persetujuan' AND $transaksi['kurir_check'] == 'selesai') : ?>
                                            selected
                                        <?php endif ?>
                                    >
                                        Selesai
                                    </option>
                                </select>
                            </div>
                        </div>
                    <?php endif ?>
                    
                    <?php if ($action != 'lihat'): ?>
                        <div class="form-group row text-right">
                            <div class="offset-md-2 col-md-10">
                                <input type="submit" class="btn btn-primary" name="simpan"/>
                                <input type="reset" class="btn btn-danger"/>
                            </div>
                        </div>
                    <?php endif ?>

                </form>
            </div>
            <!-- End Card Body -->

        </div>
        <!-- End Card -->

    </div>
    <!-- End Coloumn -->

</div>

<script async defer src='https://maps.googleapis.com/maps/api/js?key=AIzaSyB6bHo5JkixK-_Ct1TWEy4ZDdiuRqbwkpw&callback=initMap'>
</script>