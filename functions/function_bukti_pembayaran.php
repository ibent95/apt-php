<?php

    function getBuktiPembayaranAll($order = 'DESC') {
        global $koneksi;
        $sql = "SELECT * FROM `data_riwayat_pembayaran` ORDER BY `id_riwayat_pembayaran` $order ";
        $data = mysqli_query($koneksi, $sql) or die($koneksi);
        return $data;
    }

    function getBuktiPembayaranById($id, $order = 'DESC') {
        global $koneksi;
        $sql = "SELECT * FROM `data_riwayat_pembayaran` WHERE `id_riwayat_pembayaran` = '$id' ORDER BY `id_riwayat_pembayaran` $order";
        $data = mysqli_query($koneksi, $sql) or die($koneksi);
        return $data;
    }

    function getBuktiPembayaranByIdTransaksi($idTransaksi, $metodePembayaran = NULL, $order = 'DESC') {
        global $koneksi;
        $sql = "SELECT * FROM `data_riwayat_pembayaran` WHERE `id_transaksi` = '$idTransaksi' ";
        if ($metodePembayaran != NULL) {
            $sql .= "AND `info_pembayaran` LIKE '%$metodePembayaran' ";
        }
        $sql .= "ORDER BY `id_riwayat_pembayaran` $order";
        $data = mysqli_query($koneksi, $sql) or die($koneksi);
        return $data;
    }

?>