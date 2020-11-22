<?php

	// Biaya Tambahan
	function getBiayaTambahanAll() {
		global $koneksi;
		$sql = "SELECT * FROM `data_biaya_tambahan`";
		$data = mysqli_query($koneksi, $sql);
		return $data;
	}

	function getBiayaTambahanById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_biaya_tambahan` WHERE `id_biaya_tambahan` = '$id'");
        return $data;
	}

	function getBiayaTambahanByIdTransaksi($idTransaksi) {
		global $koneksi;
		$sql = "SELECT * FROM `data_biaya_tambahan` WHERE `id_transaksi` = '$idTransaksi'";
		$data = mysqli_query($koneksi, $sql);
		return $data;
	}

	// Biaya Kerusakan
	function getBiayaKerusakanAll() {
		global $koneksi;
		$sql = "SELECT * FROM `data_biaya_kerusakan`";
		$data = mysqli_query($koneksi, $sql);
		return $data;
	}

	function getBiayaKerusakanById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_biaya_kerusakan` WHERE `id_biaya_kerusakan` = '$id'");
        return $data;
	}

	function getBiayaKerusakanByIdTransaksi($idTransaksi) {
		global $koneksi;
		$sql = "SELECT * FROM `data_biaya_kerusakan` WHERE `id_transaksi` = '$idTransaksi'";
		$data = mysqli_query($koneksi, $sql);
		return $data;
	}

?>