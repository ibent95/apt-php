<?php 
    $proses = $_GET['proses'];
	if ($proses == 'remove') {
		$id = (isset($_GET['id']) AND !empty($_GET['id'])) ? antiInjection($_GET['id']) : NULL ;
	} else {
		if ($proses == 'edit' OR $proses == 'set_currier') {
			$id = (isset($_POST['id']) AND !empty($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;
		}
		$tanggal_pesan = (isset($_POST['tanggal_pesan'])) ? antiInjection($_POST['tanggal_pesan']) : date("Y-m-d") ;
		$status_pemesanan = ($proses == 'edit') ? antiInjection($_POST['status_pemesanan']) : 'tunggu' ;
		$idKurir = (isset($_POST['id_kurir']) AND !empty($_POST['id_kurir'])) ? $_POST['id_kurir'] : NULL ;
	}
	switch ($proses) {
		case 'add':
			try {
				mysqli_query ($koneksi, "INSERT INTO `data_pemesanan` (`tanggal_pesan`, `id_pelanggan`, `id_kategori`, `tanggal_kerja`, `longlat`, `keluhan`, `id_teknisi`, `status_pemesanan`) VALUES ('$tanggal_pesan', '$id_pelanggan', '$id_kategori', '$tanggal_kerja', '$longlat', '$keluhan', '$id_teknisi', '$status_pemesanan')") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil ditambahkan";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data tidak berhasil ditambahkan";
			}
			break;
		case 'edit':
			try {
				mysqli_query($koneksi, "UPDATE `data_transaksi` SET `tanggal_pesan` = '$tanggal_pesan', `id_pelanggan` = '$id_pelanggan', `id_kategori` = '$id_kategori', `tanggal_kerja` = '$tanggal_kerja', `longlat` = '$longlat', `keluhan` = '$keluhan', `id_teknisi` = '$id_teknisi', `status_pemesanan` = '$status_pemesanan' WHERE `id_transaksi` = '$id' ") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil diubah";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data gagal diubah";
			}
			break;
		case 'set_currier':
			try {
				mysqli_query($koneksi, "UPDATE `data_transaksi` SET `id_kurir` = '$idKurir' WHERE `id_transaksi` = '$id' ") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil diubah";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data gagal diubah";
			}
			break;
		case 'remove':
			try {
				mysqli_query($koneksi, "DELETE FROM `data_transaksi` WHERE `id_transaksi` = '$id'") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil dihapus";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data gagal dihapus";
			}
			break;
		default:
			# code...
			break;
	}

	echo "<script>window.location.replace('?content=data_transaksi');</script>";
?>