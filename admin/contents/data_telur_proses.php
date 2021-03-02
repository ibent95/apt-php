<?php
    $proses 			= $_GET['proses'];
	if ($proses == 'remove') {
		$id 			= (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL;
	} else {
		if ($proses == 'edit') {
			$id 		= (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL;
			$idFoto1 	= (isset($_POST['id_foto1'])) ? antiInjection($_POST['id_foto1']) : NULL;
			$idFoto2 	= (isset($_POST['id_foto2'])) ? antiInjection($_POST['id_foto2']) : NULL;
			$idFoto3 	= (isset($_POST['id_foto3'])) ? antiInjection($_POST['id_foto3']) : NULL;
			$idFoto4 	= (isset($_POST['id_foto4'])) ? antiInjection($_POST['id_foto4']) : NULL;
		} elseif ($proses == 'edit_discount') {
			$id 		= (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL;
			$diskon 	= (isset($_POST['diskon'])) ? $_POST['diskon'] : NULL;
			$tglAwal 	= (isset($_POST['tanggal_awal_diskon'])) ? $_POST['tanggal_awal_diskon'] : NULL;
			$tglAkhir 	= (isset($_POST['tanggal_akhir_diskon'])) ? $_POST['tanggal_akhir_diskon'] : NULL;
		} elseif ($proses == 'add_stok') {
			$id 		= (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL;
		}
		$namaTelur 		= (isset($_POST['nama_telur'])) ? $_POST['nama_telur'] : NULL;
		$idKategori 		= (isset($_POST['id_kategori'])) ? antiInjection($_POST['id_kategori']) : NULL;
		$hargaJual			= (isset($_POST['harga_jual'])) ? antiInjection($_POST['harga_jual']) : 0 ;
		// $dendaHilang		= (isset($_POST['denda_hilang'])) ? antiInjection($_POST['denda_hilang']) : 0 ;
		if ($proses == 'add' OR $proses == 'add_stok') {
			$persediaan		= (isset($_POST['kuantitas'])) ? antiInjection($_POST['kuantitas']) : 0 ;
		} elseif ($proses == 'edit') {
			$persediaan		= (isset($_POST['persediaan'])) ? antiInjection($_POST['persediaan']) : 0 ;
		}
		$hargaBeli			= (isset($_POST['harga_beli'])) ? antiInjection($_POST['harga_beli']) : 0 ;

		$foto1 				= (isset($_FILES['foto1']) AND !empty($_FILES['foto1'])) ? uploadFile($_FILES['foto1'], "telur", "img", "short") : NULL ;
		$foto2 				= (isset($_FILES['foto2']) AND !empty($_FILES['foto2'])) ? uploadFile($_FILES['foto2'], "telur", "img", "short") : NULL ;
		$foto3 				= (isset($_FILES['foto3']) AND !empty($_FILES['foto3'])) ? uploadFile($_FILES['foto3'], "telur", "img", "short") : NULL ;
		$foto4 				= (isset($_FILES['foto4']) AND !empty($_FILES['foto4'])) ? uploadFile($_FILES['foto4'], "telur", "img", "short") : NULL ;
		$deskripsi			= (isset($_POST['deskripsi'])) ? $_POST['deskripsi'] : NULL;
	}
    $messages   		= array();
    $sql				= "";
	$redirect 			= '?content=data_telur';

	switch ($proses) {
		case 'add':
			try {
				$nameCount = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`nama_telur`) AS `count` FROM `data_telur` WHERE `nama_telur` = '$namaTelur'"))['count'];
				if ($nameCount == 0) {
					// Data Telur
					mysqli_query ($koneksi, "INSERT INTO `data_telur` (`id_kategori`, `nama_telur`, `harga_jual`, `persediaan`, `deskripsi`) VALUES ('$idKategori', '$namaTelur', '$hargaJual', '$persediaan', '$deskripsi')") or die ($koneksi);
					$id = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `id_telur` FROM `data_telur` WHERE `nama_telur` = '$namaTelur' AND `id_kategori` = '$idKategori' AND `harga_jual` = '$hargaJual' AND `persediaan` = '$persediaan' AND `deskripsi` = '$deskripsi'"))['id_telur'];
					// Foto Telur
					if ($foto1 != NULL | $foto1 != "" | !empty($foto1)) {
						mysqli_query($koneksi, "INSERT INTO `data_telur_foto` (`id_telur`, `url_foto`) VALUES ('$id', '$foto1')") or die ($koneksi);
					}
					if ($foto2 != NULL | $foto2 != "" | !empty($foto2)) {
						mysqli_query($koneksi, "INSERT INTO `data_telur_foto` (`id_telur`, `url_foto`) VALUES ('$id', '$foto2')") or die ($koneksi);
					}
					if ($foto3 != NULL | $foto3 != "" | !empty($foto3)) {
						mysqli_query($koneksi, "INSERT INTO `data_telur_foto` (`id_telur`, `url_foto`) VALUES ('$id', '$foto3')") or die ($koneksi);
					}
					if ($foto4 != NULL | $foto4 != "" | !empty($foto4)) {
						mysqli_query($koneksi, "INSERT INTO `data_telur_foto` (`id_telur`, `url_foto`) VALUES ('$id', '$foto4')") or die ($koneksi);
					}
					// Data Telur Masuk
					mysqli_query ($koneksi, "INSERT INTO `data_telur_masuk` (`tanggal`, `id_telur`, `jumlah`, `harga_beli`) VALUES ('" . date('Y-m-d') . "', '$id', '$persediaan', '$hargaBeli')") or die ($koneksi);
					$transaksiKeluar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `data_telur_masuk` WHERE `tanggal` LIKE '" . date('Y-m-d') . "%' AND `id_telur` = '$id' AND `jumlah` = '$persediaan' AND `harga_beli` = '$hargaBeli' "));
					mysqli_query($koneksi, "INSERT INTO `data_laporan_arus_kas`(`jenis_transaksi`, `id_no_transaksi`, `tgl_transaksi`, `keterangan`, `kuantitas`, `harga`) VALUES ('keluar', '$transaksiKeluar[id_telur_masuk]', '$transaksiKeluar[tanggal]', 'Pembelian tanggal $transaksiKeluar[tanggal]', '$transaksiKeluar[jumlah]', '$transaksiKeluar[harga_beli]')") or die ($koneksi);
					array_push($messages, array("success", "Data berhasil ditambahkan..!"));
				} else {
					$_SESSION['message-type'] = "danger";
					$_SESSION['message-content'] = "Data yang dimasukan sudah ada. Silahkan cari yang lain...";
					echo "<script>window.history.go(-1);</script>";
					break;
				}
			} catch (Exception $e) {
				array_push($messages, array("danger", "Data gagal ditambahkan..!"));
			}
			break;
		case 'edit':
			try {
				$nameCount = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`nama_telur`) AS `count` FROM `data_telur` WHERE `nama_telur` = '$namaTelur' AND `id_telur` NOT LIKE '$id';"))['count'];
				if ($nameCount == 0) {
					mysqli_query($koneksi, "UPDATE `data_telur` SET `id_kategori` = '$idKategori', `nama_telur` = '$namaTelur', `harga_jual` = '$hargaJual', `persediaan` = '$persediaan', `deskripsi` = '$deskripsi' WHERE `id_telur` = '$id';") or die ($koneksi);
					if ($foto1 != NULL OR $foto1 != "" OR !empty($foto1)) {
						$checkCountImage = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`id_telur`) AS `count` FROM `data_telur_foto` WHERE `id_foto` = '$idFoto1'"))['count'];
						if ($checkCountImage == 1) {
							mysqli_query($koneksi, "UPDATE `data_telur_foto` SET `id_telur` = '$id', `url_foto` = '$foto1' WHERE `id_foto` = '$idFoto1'") or die ($koneksi);
						} else {
							mysqli_query($koneksi, "INSERT INTO `data_telur_foto` (`id_telur`, `url_foto`) VALUES ('$id', '$foto1')") or die ($koneksi);
						}
					}
					// echo $foto1;
					if ($foto2 != NULL OR $foto2 != "" OR !empty($foto2)) {
						$checkCountImage = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`id_telur`) AS `count` FROM `data_telur_foto` WHERE `id_foto` = '$idFoto2'"))['count'];
						if ($checkCountImage == 1) {
							mysqli_query($koneksi, "UPDATE `data_telur_foto` SET `id_telur` = '$id', `url_foto` = '$foto2' WHERE `id_foto` = '$idFoto2'") or die ($koneksi);
						} else {
							mysqli_query($koneksi, "INSERT INTO `data_telur_foto` (`id_telur`, `url_foto`) VALUES ('$id', '$foto2')") or die ($koneksi);
						}
					}
					if ($foto3 != NULL OR $foto3 != "" OR !empty($foto3)) {
						$checkCountImage = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`id_telur`) AS `count` FROM `data_telur_foto` WHERE `id_foto` = '$idFoto3'"))['count'];
						if ($checkCountImage == 1) {
							mysqli_query($koneksi, "UPDATE `data_telur_foto` SET `id_telur` = '$id', `url_foto` = '$foto3' WHERE `id_foto` = '$idFoto3'") or die ($koneksi);
						} else {
							mysqli_query($koneksi, "INSERT INTO `data_telur_foto` (`id_telur`, `url_foto`) VALUES ('$id', '$foto3')") or die ($koneksi);
						}
					}
					if ($foto4 != NULL OR $foto4 != "" OR !empty($foto4)) {
						$checkCountImage = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`id_telur`) AS `count` FROM `data_telur_foto` WHERE `id_foto` = '$idFoto4'"))['count'];
						if ($checkCountImage == 1) {
							mysqli_query($koneksi, "UPDATE `data_telur_foto` SET `id_telur` = '$id', `url_foto` = '$foto4' WHERE `id_foto` = '$idFoto4'") or die ($koneksi);
						} else {
							mysqli_query($koneksi, "INSERT INTO `data_telur_foto` (`id_telur`, `url_foto`) VALUES ('$id', '$foto4')") or die ($koneksi);
						}
					}
					array_push($messages, array("success", "Data berhasil diubah..!"));
				} else {
					$_SESSION['message-type'] = "danger";
					$_SESSION['message-content'] = "Data yang dimasukan sudah ada. Silahkan cari yang lain...";
					echo "<script>window.history.go(-1);</script>";
					break;
				}
			} catch (Exception $e) {
				array_push($messages, array("danger", "Data gagal diubah..!"));
			}
			break;
		case 'add_stok':
			try {
				$stok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `persediaan` FROM `data_telur` WHERE `id_telur` = '$id';"))['persediaan'];
				$stok += $persediaan;
				// Data Telur Masuk
				mysqli_query($koneksi, "INSERT INTO `data_telur_masuk` (`tanggal`, `id_telur`, `jumlah`, `harga_beli`) VALUES ('" . date('Y-m-d') . "', '$id', '$persediaan', '$hargaBeli')") or die ($koneksi);
				$transaksiKeluar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `data_telur_masuk` WHERE `tanggal` = '" . date('Y-m-d') . "%' AND `id_telur` = '$id' AND `jumlah` = '$persediaan' AND `harga_beli` = '$hargaBeli' "));
				mysqli_query($koneksi, "INSERT INTO `data_laporan_arus_kas`(`jenis_transaksi`, `id_no_transaksi`, `tgl_transaksi`, `keterangan`, `kuantitas`, `harga`) VALUES ('keluar', '$transaksiKeluar[id_telur_masuk]', '$transaksiKeluar[tanggal]', 'Pembelian tanggal $transaksiKeluar[tanggal]', '$transaksiKeluar[jumlah]', '$transaksiKeluar[harga_beli]')") or die ($koneksi);
				// Data Telur
				mysqli_query($koneksi, "UPDATE `data_telur` SET `persediaan` = '$stok' WHERE `id_telur` = '$id';") or die ($koneksi);
				array_push($messages, array("success", "Data berhasil diubah..!"));
			} catch (Exception $e) {
				array_push($messages, array("danger", "Data gagal diubah..!"));
			}
			break;
		case 'edit_discount':
			try {
				$diskon_type = (isset($_POST['diskon_type'])) ? $_POST['diskon_type'] : 'umum';
				$diskon_count_increase = (isset($_POST['diskon_count_increase'])) ? $_POST['diskon_count_increase'] : 'umum';
				$diskon_amount_increment = (isset($_POST['diskon_amount_increment'])) ? $_POST['diskon_amount_increment'] : 'umum';
				$diskon_amount_increment_max = (isset($_POST['diskon_amount_increment_max'])) ? $_POST['diskon_amount_increment_max'] : 'umum';
				mysqli_query($koneksi, "UPDATE `data_telur` SET `diskon` = '$diskon', `tgl_awal_diskon` = '$tglAwal', `tgl_akhir_diskon` = '$tglAkhir', `diskon_type` = '$diskon_type', `diskon_count_increase` = '$diskon_count_increase', `diskon_amount_increment` = '$diskon_amount_increment', `diskon_amount_increment_max` = '$diskon_amount_increment_max' WHERE `id_telur` = '$id';") or die ($koneksi);
				array_push($messages, array("success", "Data berhasil diubah..!"));
			} catch (Exception $e) {
				array_push($messages, array("danger", "Data gagal diubah..!"));
			}
			$redirect = '?content=data_telur';
			break;
		case 'remove':
			try {
				mysqli_query($koneksi, "DELETE FROM `data_telur` WHERE `id_telur` = '$id'") or die ($koneksi);
				mysqli_query($koneksi, "DELETE FROM `data_telur_foto` WHERE `id_telur` = '$id'") or die ($koneksi);
				array_push($messages, array("success", "Data berhasil dihapus..!"));
			} catch (Exception $e) {
				array_push($messages, array("danger", "Data gagal dihapus..!"));
			}
			break;
		default:
			# code...
			break;
	}

	if (!empty($messages)) {
		saveNotifikasi($messages);
	}

	if ($proses == 'remove' OR $proses == 'edit_discount') {
		echo "<script>window.location.replace('$redirect');</script>";
	// } elseif ($proses == 'edit_discount') {
	// 	echo "<script>window.history.go(-1);;</script>";
	} else {
		echo "<script>window.history.go(-2);</script>";
	}

?>