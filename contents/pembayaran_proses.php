<?php
	$proses             = (isset($_GET['proses'])) ? $_GET['proses'] : NULL ;
	if ($proses == NULL) {
		$_SESSION['message-type'] = "success";
		$_SESSION['message-content'] = "Proses belum ditentukan..!";
		echo "<script>window.history.go(-1)</script>";
	}
	if ($proses == 'remove') {
		$id 				= antiInjection($_GET['id']);
	} else {
		// if ($proses == 'edit') {
		$id 				= (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL;
		// }
		$totalHarga			= (isset($_POST['total_harga'])) ? antiInjection($_POST['total_harga']) : 0;
		$metodePembayaran	= (isset($_POST['metode_pembayaran'])) ? $_POST['metode_pembayaran'] : "ditempat" ;
		$buktiPembayaran	= (isset($_FILES['bukti_pembayaran']) AND ($_FILES['bukti_pembayaran'] != NULL OR !empty($_FILES['bukti_pembayaran']))) ? uploadFile($_FILES['bukti_pembayaran'], "bukti_pembayaran", "img", "short") : NULL;
	}
	$sql                = "";
	$redirect           = "";
	switch ($proses) {
		case 'add':
			try {
				if ($metodePembayaran == "ditempat") {
					mysqli_query($koneksi, "INSERT INTO `data_riwayat_pembayaran` (`id_transaksi`, `jumlah`, `info_pembayaran`) VALUES ('$id', '$totalHarga', '$metodePembayaran')") or die(mysqli_error($koneksi));
				} elseif ($metodePembayaran == "transfer") {
					mysqli_query($koneksi, "UPDATE `data_riwayat_pembayaran` SET `bukti_pembayaran` = '$buktiPembayaran' WHERE `id_transaksi` = '$id' AND `info_pembayaran` = 'transfer'") or die(mysqli_error($koneksi));
				}
				$_SESSION['type-pesan'] = "success";
				$_SESSION['pesan'] = "Upload bukti pembayaran berhasil, silahkan tunggu konfirmasi dari pihak Rental..!";
			} catch (Exception $e) {
				$_SESSION['type-pesan'] = "danger";
				$_SESSION['pesan'] = "Upload bukti pembayaran tidak berhasil, silahkan coba lagi..!";
			}
			$redirect = "?content=transaksi";
			break;
		case 'add_method':
			try {
				if ($metodePembayaran == "ditempat") {
					mysqli_query($koneksi, "INSERT INTO `data_riwayat_pembayaran` (`id_transaksi`, `jumlah`, `info_pembayaran`, `konfirmasi_admin`) VALUES ('$id', '$totalHarga', '$metodePembayaran', 'ya')") or die(mysqli_error($koneksi));
				} elseif ($metodePembayaran == "transfer") {
					mysqli_query($koneksi, "INSERT INTO `data_riwayat_pembayaran` (`id_transaksi`, `jumlah`, `info_pembayaran`) VALUES ('$id', '$totalHarga', '$metodePembayaran')") or die(mysqli_error($koneksi));
				}
				$_SESSION['type-pesan'] = "success";
				$_SESSION['pesan'] = "Upload bukti pembayaran berhasil, silahkan tunggu konfirmasi dari pihak Rental..!";
			} catch (Exception $e) {
				$_SESSION['type-pesan'] = "danger";
				$_SESSION['pesan'] = "Upload bukti pembayaran tidak berhasil, silahkan coba lagi..!";
			}
			$redirect = "?content=transaksi";
			break;
		default:
			# code...
			break;
	}
	echo "<script> window.location.replace('$redirect'); </script>";
?>