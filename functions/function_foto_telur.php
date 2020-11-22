<?php
	
	function getFotoTelurAll() {
		global $koneksi;
		$sql = "SELECT * FROM `data_telur_foto`";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getFotoTelurById($id) {
		global $koneksi;
		$sql = "SELECT * FROM `data_telur_foto` WHERE `id_telur_foto` = '$id'";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getFotoTelurByIdTelur($idTelur) {
		global $koneksi;
		$sql = "SELECT * FROM `data_telur_foto` WHERE `id_telur` = '$idTelur'";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getFotoTelurByIdTransaksi($idTransaksi) {
		global $koneksi;
		$sql = "SELECT * FROM `data_telur_foto` WHERE `id_transaksi` = '$idTransaksi'";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

?>