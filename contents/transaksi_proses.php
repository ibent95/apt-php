<?php
	$proses             = (isset($_GET['proses'])) ? $_GET['proses'] : NULL ;
	if ($proses == NULL) {
		$_SESSION['message-type'] = "danger";
		$_SESSION['message-content'] = "Proses belum ditentukan..!";
		echo "<script>window.history.go(-1)</script>";
	}
	if ($proses == 'finish' OR $proses == 'batal') {
		$id 			= antiInjection($_GET['id']);
	} else {
		// if ($proses == 'edit') {
			// $id 		= (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL;
		// }
		$id             = NULL;
		$noTransaksi    = getCode("TR-");
		$now            = new DateTime();
		$now->format('Y-m-d H:i:s');
		$tglTransaksi   = date("Y-m-d H:i:s");
		$idPelanggan    = (isset($_POST['id_pelanggan'])) ? $_POST['id_pelanggan'] : NULL ;
		$noTelp         = (isset($_POST['no_telp'])) ? $_POST['no_telp'] : NULL ;
		$totalHarga     = (isset($_POST['total_harga'])) ? $_POST['total_harga'] : NULL ;
		$tglPengantaran = (isset($_POST['tanggal_pengantaran'])) ? $_POST['tanggal_pengantaran'] : NULL ;
		$diantarkan     = (isset($_POST['diantarkan'])) ? $_POST['diantarkan'] : "tidak";
		$tglPengantaran = (isset($_POST['tanggal_pengantaran']) OR !empty($_POST['tanggal_pengantaran'])) ? $_POST['tanggal_pengantaran'] : "";
		$alamat         = (isset($_POST['alamat'])) ? $_POST['alamat'] : "";
		$longlat        = (isset($_POST['longlat'])) ? $_POST['longlat'] : "";
		$status         = "tunggu";
		$keterangan     = (isset($_POST['keterangan'])) ? $_POST['keterangan'] : NULL ;
	}
	$sql                = "";
	$redirect           = "";

	switch ($proses) {
		case 'add':
			if (isset($_POST['checkout'])) {

				try {
					// Transaksi
					echo $sql = "INSERT INTO `data_transaksi`(`no_transaksi`, `tgl_transaksi`, `id_pelanggan`, `no_telp`, `keterangan`, `status_transaksi`, `diantarkan`, `tgl_pengantaran`, `alamat`, `longlat`) VALUES ('$noTransaksi', '$tglTransaksi', '$idPelanggan', '$noTelp', '$keterangan', '$status', '$diantarkan', '$tglPengantaran', '$alamat', '$longlat')";
					mysqli_query($koneksi, $sql) or die($koneksi);

					$transaksi = mysqli_fetch_array(getTransaksiByNoTransaksi($noTransaksi), MYSQLI_BOTH);

					// Transaksi Detail
					foreach ($_SESSION["cart"] as $item) {
						$barang = mysqli_fetch_array(getTelurById($item['id_telur']), MYSQLI_BOTH);
						if ($item['kuantitas'] <= $barang['persediaan']) {
							mysqli_query($koneksi, "INSERT INTO `data_transaksi_detail` (`id_transaksi`, `id_telur`, `harga_satuan`, `kuantitas`, `jumlah_harga`) VALUES ('$transaksi[id_transaksi]', '$item[id_telur]', '$item[harga_jual]', '$item[kuantitas]', '$item[jumlah_harga]')") or die($koneksi);
						} else {
							$_SESSION['message-type'] = "danger";
							$_SESSION['message-content'] = "Maaf, jumlah barang ($item[nama_barang]) yang anda masukan melebihi persediaan yang ada..!";
							echo "<script>window.history.go(-1)</script>";
						}
						$stokAkhir = $barang['persediaan'] - $item['kuantitas'];
						mysqli_query($koneksi, "UPDATE `data_telur` SET `persediaan` = '$stokAkhir' WHERE `id_telur` = '$item[id_telur]'") or die($koneksi);
					}
					unset($_SESSION["cart"]);

					// Biaya Administrasi
					if ($diantarkan == 'ya') {
						$hargaPengantaran = getKonfigurasiUmum("biaya_administrasi", "single")['nilai_konfigurasi'];
						$sql = "INSERT INTO `data_biaya_tambahan`(`id_transaksi`, `keterangan`, `jumlah`) VALUES ('$transaksi[id_transaksi]', 'Biaya Administrasi.', '$hargaPengantaran')";
						mysqli_query($koneksi, $sql) or die($koneksi);
					}

					$_SESSION['message-type'] = "success";
					$_SESSION['message-content'] = "Transaksi berhasil dilakukan, silahkan tunggu konfirmasi dari pihak toko..!";
					// $redirect = "?content=pembayaran_form&action=tambah&id=$transaksi[id_transaksi]";
					// $redirect = "?content=daftar_barang";
					$redirect = "?content=transaksi";
				} catch (Exception $e) {
					$_SESSION['message-type'] = "danger";
					$_SESSION['message-content'] = "Transaksi tidak berhasil dilakukan, silahkan coba lagi..!";
					$redirect = "?content=beranda";
				}
			}
			break;

		case 'finish':
			try {
				$sql = "UPDATE `data_transaksi` SET `status_transaksi`  = 'selesai' WHERE `id_transaksi`    = '$idTransaksi'";
				$transaksi = mysqli_fetch_assoc(getTransaksiById($idTransaksi));
				mysqli_query($koneksi, $sql) or die($koneksi);
				$kuantitasAll = mysqli_query($koneksi, "SELECT `kuantitas` FROM `data_transaksi_detail` WHERE `id_transaksi` = '$transaksi[id_transaksi]'");
				$totalKuantitas = 0;
				foreach ($kuantitasAll as $data) {
					$totalKuantitas += $data['kuantitas'];
				}
				mysqli_query($koneksi, "INSERT INTO `data_laporan_arus_kas`(`jenis_transaksi`, `id_no_transaksi`, `tgl_transaksi`, `keterangan`, `kuantitas`, `harga`) VALUES ('masuk', '$transaksi[no_transaksi]', '$transaksi[tgl_transaksi]', 'Penjualan tanggal $transaksi[tgl_transaksi]', '$totalKuantitas', '$transaksi[total_harga]')") or die($koneksi);
				array_push($messages, array("success", "Transaksi berhasil diselesaikan..!"));
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Transaksi berhasil dilakukan, silahkan tunggu konfirmasi dari pihak toko..!";
				$redirect = "?content=transaksi";
				// $redirect = "?content=daftar_barang";
				// $redirect = "?content=pemayaran";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Transaksi tidak berhasil dilakukan, silahkan coba lagi..!";
				$redirect = "?content=beranda";
			}
			break;

		case 'batal':
			try {
				// Data Transaksi
				$sql = "UPDATE `data_transaksi` SET `status_transaksi` = 'batal' WHERE `id_transaksi` = '$id'";
				mysqli_query($koneksi, $sql) or die($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Silahkan tunggu konfirmasi dari Administrator..!";
				$redirect = "?content=transaksi" ;
				// $transaction = mysqli_fetch_array(getTransaksiById($id), MYSQLI_BOTH);
				// $customer = mysqli_fetch_array(getPelangganById($transaction['id_pelanggan']), MYSQLI_BOTH);
				// $kurir = mysqli_fetch_array(getKurirById($transaction['id_kurir']), MYSQLI_BOTH);
				// // Kirim email
				// sendEmail("ibnu.tuharea@stimednp.ac.id", "ibnu.tuharea@stimednp.ac.id", "customer_cancel_transaction", array("id_pelanggan" => $transaction['id_pelanggan'], "nama_pelanggan" => $customer['nama_lengkap'], "id_transaksi" => $transaction['id_transaksi'], "no_transaksi" => $transaction['no_transaksi'], "link" => class_static_value::$URL_BASE . "/admin/?content=transaksi_riwayat_batal&id=" . $transaction['id_transaksi']), NULL);
				// sendEmail("ibnu.tuharea@stimednp.ac.id", $kurir["email"], "customer_cancel_transaction", array("id_pelanggan" => $transaction['id_transaksi'], "nama_pelanggan" => $customer['nama_lengkap'], "id_transaksi" => $transaction['id_transaksi'], "no_transaksi" => $transaction['no_transaksi'], "link" => class_static_value::$URL_BASE . "/kurir/?content=transaksi_riwayat_batal&id=" . $transaction['id_transaksi']), NULL);
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Transaksi tidak berhasil dilakukan, silahkan coba lagi..!";
			}
			break;
		default:
			# code...
			break;
	}

	echo "<script> window.location.replace('$redirect'); </script>";
?>
