<?php 
	$proses = $_GET['proses'];
	if ($proses == 'remove' OR $proses == 'finish' OR $proses == 'cancel') {
		$id 				= antiInjection($_GET ['id']);
	} else {
		if ($proses == 'edit') {
			$id 			= antiInjection($_POST['id']);
		}
		$tanggal_pesan 		= (isset($_POST['tanggal_pesan'])) ? antiInjection($_POST['tanggal_pesan']) : date("Y-m-d") ;
		$id_pelanggan 		= (isset($_POST['id_pelanggan'])) ? antiInjection($_POST['id_pelanggan']) : NULL ;
		$id_kategori 		= (isset($_POST['id_kategori'])) ? antiInjection($_POST['id_kategori']) : NULL ;
		$tanggal_kerja 		= (isset($_POST['tanggal_kerja'])) ? antiInjection($_POST['tanggal_kerja']) : NULL ;
		$longlat 			= (isset($_POST['longlat'])) ? antiInjection($_POST['longlat']) : NULL ;
		$keluhan 			= (isset($_POST['keluhan'])) ? antiInjection($_POST['keluhan']) : NULL ;
		$id_kurir 		= ($proses == 'edit') ? antiInjection($_POST['id_kurir']) : 0 ;
		$status_transaksi 	= ($proses == 'edit') ? antiInjection($_POST['status_transaksi']) : 'tunggu' ;
	}
	$messages 					= array();
	$sql						= "";
	$redirect					= "";

	switch ($proses) {
		case 'add':
			try {
				mysqli_query ($koneksi, "INSERT INTO `data_transaksi` (`tanggal_pesan`, `id_pelanggan`, `id_kategori`, `tanggal_kerja`, `longlat`, `keluhan`, `id_kurir`, `status_transaksi`) VALUES ('$tanggal_pesan', '$id_pelanggan', '$id_kategori', '$tanggal_kerja', '$longlat', '$keluhan', '$id_kurir', '$status_transaksi')") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil ditambahkan";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data tidak berhasil ditambahkan";
			}
			break;
		case 'edit':
			try {
				mysqli_query($koneksi, "UPDATE `data_transaksi` SET `tanggal_pesan` = '$tanggal_pesan', `id_pelanggan` = '$id_pelanggan', `id_kategori` = '$id_kategori', `tanggal_kerja` = '$tanggal_kerja', `longlat` = '$longlat', `keluhan` = '$keluhan', `id_kurir` = '$id_kurir', `status_transaksi` = '$status_transaksi' WHERE `id` = '$id' ") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil diubah";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data gagal diubah";
			}
			break;
		case 'remove':
			try {
				mysqli_query($koneksi, "DELETE FROM `data_transaksi` WHERE `id` = '$id'") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil dihapus";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data gagal dihapus";
			}
			break;
		case 'finish' :
			try {
				$transaksi = mysqli_fetch_assoc(getTransaksiById($id));
				mysqli_query($koneksi, "UPDATE `data_transaksi` SET `status_transaksi` = 'selesai' WHERE `id_transaksi` = '$id'") or die($koneksi);
				$kuantitasAll = mysqli_query($koneksi, "SELECT `kuantitas` FROM `data_transaksi_detail` WHERE `id_transaksi` = '$transaksi[id_transaksi]'");
				$totalKuantitas = 0;
				foreach ($kuantitasAll as $data) {
					$totalKuantitas += $data['kuantitas'];
				}
				$sql = "INSERT INTO `data_laporan_arus_kas`(`jenis_transaksi`, `id_no_transaksi`, `tgl_transaksi`, `keterangan`, `kuantitas`, `harga`) VALUES ('masuk', '$transaksi[no_transaksi]', '$transaksi[tgl_transaksi]', 'Penjualan tanggal $transaksi[tgl_transaksi]', '$totalKuantitas', '$transaksi[total_harga]')";
				mysqli_query($koneksi, $sql) or die($koneksi);
				array_push($messages, array("success", "Transaksi berhasil diselesaikan..!"));
				$transaction = mysqli_fetch_array(getTransaksiById($id), MYSQLI_BOTH);
				$customer = mysqli_fetch_array(getPelangganById($transaction['id_pelanggan']), MYSQLI_BOTH);
				$kurir = mysqli_fetch_array(getKurirById($transaction['id_kurir']), MYSQLI_BOTH);
				// Kirim email
				// sendEmail("ibnu.tuharea@stimednp.ac.id", $customer["email"], "kurir_finish_workmanship", array("id_kurir" => $kurir['id_kurir'], "nama_kurir" => $kurir['nama_lengkap'], "no_transaksi" => $transaction['no_transaksi'], "link" => class_static_value::$URL_BASE . "/?content=profil"), NULL);
				// Kirim email
				// sendEmail("ibnu.tuharea@stimednp.ac.id", "ibnu.tuharea@stimednp.ac.id", "kurir_finish_workmanship", array("id_kurir" => $kurir['id_kurir'], "nama_kurir" => $kurir['nama_lengkap'], "no_transaksi" => $transaction['no_transaksi'], "link" => class_static_value::$URL_BASE . "/?content=transaksi"), NULL);
			} catch (Exception $e) {
				array_push($messages, array( "danger", "Transaksi gagal diselesaikan..!"));
			}
			break;
		case 'decline':
			try {
				$transaksi = mysqli_fetch_array(getTransaksiById($id), MYSQLI_BOTH);
				$kurir = mysqli_fetch_array(getKurirById($transaksi['id_kurir']), MYSQLI_BOTH);
				mysqli_query($koneksi, "UPDATE `data_transaksi` SET `id_kurir` = '0', `nama_kurir` = NULL, `status_transaksi` = 'tunggu' WHERE `id_transaksi` = '$id'") or die ($koneksi);
				// sendEmail('ibnu.tuharea@stimednp.ac.id', 'ibnu.tuharea@stimednp.ac.id', "Transaksi Perbaikan " . $transaksi['no_transaksi'] . " ditolak oleh Kurir " . $kurir['nama_lengkap'], "Kurir [" . $kurir['id_kurir'] . "] " . $kurir['nama_lengkap'] . " saat ini tidak bisa menangani dan menolak Transaksi Perbaikan " . $transaksi['no_transaksi'] . ". Silahkan tentukan Kurir lain yang bisa menangani transaksi tersebut. <a href='" . class_static_value::$URL_BASE . "/admin/?content=transaksi_persetujuan&action=pilih_kurir&id=" . $transaksi['id_transaksi'] . "'>Klik disini.</a>", NUll);
				array_push($messages, array("success", "Transaksi berhasil dibatalkan..!"));
			} catch (Exception $e) {
				array_push($messages, array( "danger", "Transaksi gagal dibatalkan..!"));
			}
			break;
		case 'cancel':
			try {
				mysqli_query($koneksi, "UPDATE `data_transaksi` SET `status_transaksi` = 'batal' WHERE `id_transaksi` = '$id'") or die($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Transaksi berhasil dibatalkan..!";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Transaksi gagal dibatalkan..!";
			}
			break;
		default:
			# code...
			break;
	}

	if (!empty($messages)) {
		saveNotifikasi($messages);
	}

	echo "<script>window.location.replace('?content=data_transaksi');</script>";
?>