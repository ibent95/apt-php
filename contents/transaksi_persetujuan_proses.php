<?php
	$proses             = (isset($_GET['proses'])) ? $_GET['proses'] : NULL ;
	if ($proses == NULL) {
		$_SESSION['message-type'] = "danger";
		$_SESSION['message-content'] = "Proses belum ditentukan..!";
		echo "<script>window.history.go(-1)</script>";
	}
	if ($proses == 'remove') {
		$id 			= antiInjection($_GET['id']);
	} else {
		// if ($proses == 'edit') {
			$id 				= (isset($_POST['id'])) ? antiInjection($_POST['id']) : antiInjection($_GET['id']);
		// }
		// $noTransaksi    		= (isset($_POST['noTransaksi'])) ? antiInjection($_POST['noTransaksi']) : antiInjection($_GET['noTransaksi']);
		// $idPelanggan    		= (isset($_POST['id_pelanggan'])) ? $_POST['id_pelanggan'] : NULL;
		// $namaPelanggan  		= (isset($_POST['nama_pelanggan'])) ? $_POST['nama_pelanggan'] : NULL;
		// $keluhan				= (isset($_POST['keluhan']) AND !empty($_POST['keluhan'])) ? antiInjection($_POST['keluhan']) : NULL;
		$rating = (isset($_POST['rating'])) ? $_POST['rating'] : NULL ;
		$ulasan = (isset($_POST['ulasan'])) ? $_POST['ulasan'] : NULL ;
		// $idKurir				= "";
		// $namaKurir			= "";
		// $statusTransaksi    	= "tunggu";
		// $kurirCheck			= "belum";
		// $persetujuanPelanggan	= "belum";
		// $pengerjaanKe			= "0";

		// $softwareIdAll 			= (isset($_POST['softwareId'])) ? $_POST['softwareId'] : NULL ;
		// $hardwareIdAll 			= (isset($_POST['hardwareId'])) ? $_POST['hardwareId'] : NULL ;
		// $sparepartIdAll 		= (isset($_POST['sparepartId'])) ? $_POST['sparepartId'] : NULL ;

		// $fotoKerusakan 			= (isset($_FILES['foto_kerusakan'])) ? uploadFile($_FILES['foto_kerusakan'], 'foto_kerusakan', 'img', 'full') : NULL ;
		$totalHarga             = 0;
	}
	$messages = array();
	$sql		= "";
	$redirect	= "";

	switch ($proses) {
		case 'setuju':
			try {
				// Data Transaksi Detail
				$sql = "UPDATE `data_transaksi_detail` SET `persetujuan_pelanggan` = 'ya' WHERE `id_transaksi` = '$id' AND `persetujuan_pelanggan` = 'belum'";
				mysqli_query($koneksi, $sql) or die($koneksi);
				// Data Transaksi
				$pengerjaanKe = mysqli_fetch_array(getDetailTransaksiByIdTransaksi($id), MYSQLI_BOTH)['pengerjaan_ke'];
				mysqli_query($koneksi, "UPDATE `data_transaksi` SET `pengerjaan_ke` = '$pengerjaanKe' WHERE `id_transaksi` = '$id'") or die($koneksi);
				array_push($messages, array("success", "Anda telah menyetujui pengerjaan..!"));
				$redirect = "?content=profil";
				$transaction = mysqli_fetch_array(getTransaksiById($id), MYSQLI_BOTH);
				$kurir = mysqli_fetch_array(getKurirById($transaction['id_kurir']), MYSQLI_BOTH);
				// Kirim email
				// sendEmail("ibnu.tuharea@stimednp.ac.id", $kurir["email"], "customer_workmanship_agreed", array("pengerjaan_ke" => $pengerjaanKe, "id_transaksi" => $transaction['id_pemesanna'], "no_transaksi" => $transaction['no_transaksi'], "link" => class_static_value::$URL_BASE . "/kurir/?content=transaksi"), NULL);
				mysqli_query($koneksi, "INSERT INTO `data_notifikasi` (`tipe_notifikasi`, `info_notifikasi`, `isi_notifikasi`, `tujuan`) VALUES ('info', 'Pengerjaan disetujui!', 'Pengerjaan baru telah disetujui..!', 'kurir')") or die($koneksi);
			} catch (Exception $e) {
				array_push($messages, array("danger", "Persetujuan gagal dilakukan, silahkan coba lagi..!"));
			}
			break;
		case 'tidak_setuju':
			try {
				// Data Transaksi Detail
				$sql = "UPDATE `data_transaksi_detail` SET `persetujuan_pelanggan` = 'tidak' WHERE `id_transaksi` = '$id' AND `persetujuan_pelanggan` = 'belum'";
				mysqli_query($koneksi, $sql) or die($koneksi);
				array_push($messages, array("success", "Pengerjaan berhasil ditolak..!"));
				$redirect = "?content=profil";
				$transaction = mysqli_fetch_array(getTransaksiById($id), MYSQLI_BOTH);
				$kurir = mysqli_fetch_array(getKurirById($transaction['id_kurir']), MYSQLI_BOTH);
				// Kirim email
				sendEmail("ibnu.tuharea@stimednp.ac.id", $kurir["email"], "customer_workmanship_disagreed", array("pengerjaan_ke" => $pengerjaanKe, "id_transaksi" => $transaction['id_transaksi'], "no_transaksi" => $transaction['no_transaksi'], "link" => class_static_value::$URL_BASE . "/kurir/?content=transaksi"), NULL);
				mysqli_query($koneksi, "INSERT INTO `data_notifikasi` (`tipe_notifikasi`, `info_notifikasi`, `isi_notifikasi`, `tujuan`) VALUES ('warning', 'Pengerjaan tidak disetujui!', 'Pengerjaan baru tidak disetujui..!', 'kurir')") or die($koneksi);
			} catch (Exception $e) {
				array_push($messages, array("danger", "Penolakan pengerjaan tidak berhasil dilakukan, silahkan coba lagi..!"));
			}
			break;
		case 'batal':
			try {
				// Data Transaksi
				$sql = "UPDATE `data_transaksi` SET `status_transaksi` = 'batal' WHERE `id_transaksi` = '$id'";
				mysqli_query($koneksi, $sql) or die($koneksi);
				$sql = "UPDATE `data_transaksi_detail` SET `persetujuan_pelanggan` = 'tidak' WHERE `id_transaksi` = '$id' AND `persetujuan_pelanggan` = 'belum'";
				mysqli_query($koneksi, $sql) or die($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Silahkan tunggu konfirmasi dari Administrator..!";
				$sparepart = mysqli_query($koneksi, "SELECT `id_transaksi_detail` FROM `data_transaksi_detail` WHERE `id_transaksi` = '$id' AND `jenis_pengerjaan` = 'sparepart' AND `persetujuan_pelanggan` = 'ya'");
				$redirect = (mysqli_num_rows($sparepart) > 0) ? "?content=pembayaran_lunas_form&action=tambah&noTransaksi=" . mysqli_fetch_assoc(getTransaksiById($id))['no_transaksi'] : "?content=profil";
				$transaction = mysqli_fetch_array(getTransaksiById($id), MYSQLI_BOTH);
				$customer = mysqli_fetch_array(getPelangganById($transaction['id_pelanggan']), MYSQLI_BOTH);
				$kurir = mysqli_fetch_array(getKurirById($transaction['id_kurir']), MYSQLI_BOTH);
				// Kirim email
				sendEmail("ibnu.tuharea@stimednp.ac.id", "ibnu.tuharea@stimednp.ac.id", "customer_cancel_transaction", array("id_pelanggan" => $transaction['id_pelanggan'], "nama_pelanggan" => $customer['nama_lengkap'], "id_transaksi" => $transaction['id_transaksi'], "no_transaksi" => $transaction['no_transaksi'], "link" => class_static_value::$URL_BASE . "/admin/?content=transaksi_riwayat_batal&id=" . $transaction['id_transaksi']), NULL);
				sendEmail("ibnu.tuharea@stimednp.ac.id", $kurir["email"], "customer_cancel_transaction", array("id_pelanggan" => $transaction['id_transaksi'], "nama_pelanggan" => $customer['nama_lengkap'], "id_transaksi" => $transaction['id_transaksi'], "no_transaksi" => $transaction['no_transaksi'], "link" => class_static_value::$URL_BASE . "/kurir/?content=transaksi_riwayat_batal&id=" . $transaction['id_transaksi']), NULL);
				mysqli_query($koneksi, "INSERT INTO `data_notifikasi` (`tipe_notifikasi`, `info_notifikasi`, `isi_notifikasi`, `tujuan`) VALUES ('danger', 'Transaksi Batal!', 'Transaksi telah dibatalkan..!', 'administrator'), ('danger', 'Transaksi Batal!', 'Transaksi telah dibatalkan..!', 'kurir');") or die($koneksi);
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Transaksi tidak berhasil dilakukan, silahkan coba lagi..!";
			}
			break;
		case 'finish':
			try {
				// Data Transaksi
				$transaction = mysqli_fetch_array(getTransaksiById($id), MYSQLI_BOTH);
				$sql = "UPDATE`data_transaksi` SET `status_transaksi` = 'selesai' WHERE `id_transaksi` = '$id'";
				mysqli_query($koneksi, $sql) or die($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Transaksi telah selesai..!";
				$redirect = "?content=rating_form&id=" . $id ;
				$kuantitasAll = mysqli_query($koneksi, "SELECT `kuantitas` FROM `data_transaksi_detail` WHERE `id_transaksi` = '$transaction[id_transaksi]'");
				$totalKuantitas = 0;
				foreach ($kuantitasAll as $data) {
					$totalKuantitas += $data['kuantitas'];
				}
				$sql = "INSERT INTO `data_laporan_arus_kas`(`jenis_transaksi`, `id_no_transaksi`, `tgl_transaksi`, `keterangan`, `kuantitas`, `harga`) VALUES ('masuk', '$transaction[no_transaksi]', '$transaction[tgl_transaksi]', 'Penjualan tanggal $transaction[tgl_transaksi]', '$totalKuantitas', '$transaction[total_harga]')";
				mysqli_query($koneksi, $sql) or die($koneksi);
				array_push($messages, array("success", "Transaksi berhasil diselesaikan..!"));
				// Kirim email
				$customer = mysqli_fetch_array(getPelangganById($transaction['id_pelanggan']), MYSQLI_BOTH);
				$kurir = mysqli_fetch_array(getKurirById($transaction['id_kurir']), MYSQLI_BOTH);
				// sendEmail("aryan@stimednp.ac.id", $kurir["email"], "customer_finish_transaction", array("id_pelanggan" => $customer['id_pelanggan'], "nama_pelanggan" => $customer['nama_pelanggan'], "no_transaksi" => $transaction['no_transaksi']), NULL);
				// sendEmail("aryan@stimednp.ac.id", "ibnu.tuharea@stimednp.ac.id", "customer_finish_transaction", array("id_pelanggan" => $customer['id_pelanggan'], "nama_pelanggan" => $customer['nama_pelanggan'], "no_transaksi" => $transaction['no_transaksi']), NULL);
				// mysqli_query($koneksi, "INSERT INTO `data_notifikasi` (`tipe_notifikasi`, `info_notifikasi`, `isi_notifikasi`, `tujuan`) VALUES ('success', 'Transaksi Selesai!', 'Transaksi telah selesai..!', 'administrator'), ('success', 'Transaksi Selesai!', 'Transaksi telah selesai..!', 'kurir');") or die($koneksi);
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Transaksi tidak berhasil dilakukan, silahkan coba lagi..!";
			}
			break;
		case 'add_rating':
			try {
				$id = (isset($_GET['id'])) ? $_GET['id'] : NULL ;
				$sql = "UPDATE `data_transaksi` SET `rating` = '$rating', `ulasan` = '$ulasan' WHERE `id_transaksi` = '$id'";
				mysqli_query($koneksi, $sql) or die($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Transaksi telah selesai..!";
				$redirect = "?content=transaksi" ;
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Transaksi tidak berhasil dilakukan, silahkan coba lagi..!";
			}
			break;
		default:
			# code...
			break;
	}

	if (!empty($messages)) {
		saveNotifikasi($messages);
	}

	echo "<script> window.location.replace('$redirect'); </script>";
?>