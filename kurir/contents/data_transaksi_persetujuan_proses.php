<?php 
	$proses = $_GET['proses'];
	if ($proses == 'remove') {
		$id = antiInjection($_GET['id']);
	} else {
		if ($proses == 'edit') {
			$id = (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;
		} elseif ($proses == 'remove_damage_cost' OR $proses == 'remove_biaya_kerusakan') {
			$id = antiInjection($_GET['id']);
		}
		$idTransaksi 			= (isset($_POST['id_transaksi'])) ? $_POST['id_transaksi'] : NULL ;
		$idKurir 				= (($proses == 'edit') AND (isset($_POST['id_kurir']) AND !empty($_POST['id_kurir']))) ? antiInjection($_POST['id_kurir']) : 0 ;
		$kurirCheck 			= (($proses == 'edit') AND (isset($_POST['kurir_check']) AND !empty($_POST['kurir_check']))) ? antiInjection($_POST['kurir_check']) : 'tunggu' ;
		$keterangan				= (isset($_POST['keterangan'])) ? $_POST['keterangan'] : NULL ;
		$jumlah					= (isset($_POST['jumlah'])) ? $_POST['jumlah'] : NULL ;
	}
	$messages 					= array();
	$sql						= "";
	$redirect					= "";

	switch ($proses) {
		case 'add':
			try {
				mysqli_query ($koneksi, "INSERT INTO `data_transaksi` (`id_kurir`, `status_transaksi`) VALUES ( '$idKurir', '$status')") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil ditambahkan";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data tidak berhasil ditambahkan";
			}
			break;
		case 'edit':
			try {
				$totalHarga = (isset($_POST['total_harga']) AND !empty($_POST['total_harga'])) ? $_POST['total_harga'] : 0 ;
				if (!empty($_SESSION["damage_cost"])) {
					$array = array_keys($_SESSION["damage_cost"]);
					for ($i = 0; $i <= end($array); $i++) {
						if (isset($_SESSION["damage_cost"][$i])) {
							mysqli_query($koneksi, "INSERT INTO `data_biaya_kerusakan` (`id_transaksi`, `keterangan`, `jumlah`) VALUES ('" . $_SESSION['damage_cost'][$i]['id_transaksi'] . "', '" . $_SESSION['damage_cost'][$i]['keterangan'] . "', '" . $_SESSION['damage_cost'][$i]['jumlah'] . "')") or die($koneksi);
							$totalHarga += $_SESSION['damage_cost'][$i]['jumlah'];
						}
					}
					unset($_SESSION["damage_cost"]);
				}
				mysqli_query($koneksi, "UPDATE `data_transaksi` SET `kurir_check` = '$kurirCheck', `total_harga` = '$totalHarga' WHERE `id_transaksi` = '$idTransaksi' ") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil diubah";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data gagal diubah";
			}
			$redirect = "?content=data_transaksi" ;
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
		case 'add_damage_cost':
			try {
				if ($idTransaksi !== NULL AND $keterangan !== NULL AND $jumlah !== NULL) {
					$itemArray = array(
						'id_transaksi'	=> $idTransaksi,
						'keterangan'	=> $keterangan,
						'jumlah'		=> $jumlah
					);
					// print_r($itemArray);
					if (isset($_SESSION['damage_cost']) AND !empty($_SESSION['damage_cost'])) {
						// print_r($itemArray);
						array_push($_SESSION['damage_cost'], $itemArray);
					} else {
						// print_r($itemArray);
						$_SESSION['damage_cost'] = array($itemArray);
					}
				}
				array_push(
					$messages,
					array("success", "Data berhasil ditambahkan.")
				);
			} catch (Exception $e) {
				array_push(
					$messages,
					array("danger", "Data gagal ditambahkan.")
				);
			}
			$redirect = "?content=data_transaksi_persetujuan_form&action=persetujuan&id=" . $idTransaksi ;
			break;
		case 'edit_biaya_kerusakan':
			try {
				if ($id !== null and $idTransaksi !== null and $keterangan !== null and $jumlah !== null) {
					mysqli_query($koneksi, "UPDATE `data_biaya_kerusakan` SET  `keterangan` = '$keterangan', `jumlah` = '$jumlah' WHERE `id_biaya_kerusakan` = '$id' AND `id_transaksi` = '$idTransaksi'") or die($koneksi);
				}
				array_push( $messages, array("success", "Data berhasil diubah.") );
			} catch (Exception $e) {
				array_push( $messages, array("danger", "Data gagal diubah.") );
			}
			$redirect = "?content=data_transaksi_persetujuan_form&action=ubah&id=" . $idTransaksi ;
			break;
		case 'edit_damage_cost':
			try {
				$idArray = (isset($_POST['id_array'])) ? antiInjection($_POST['id_array']) : NULL ;
				if ($idArray !== NULL AND $idTransaksi !== NULL AND $keterangan !== NULL AND $jumlah !== NULL) {
					if (!empty($_SESSION["damage_cost"])) {
						$array = array_keys($_SESSION["damage_cost"]);
						for ($i = 0; $i <= end($array); $i++) {
							if (isset($_SESSION["damage_cost"][$i])) {
								if ($idArray == $i) {
									$_SESSION["damage_cost"][$i]['keterangan']	= $keterangan;
									$_SESSION["damage_cost"][$i]['jumlah']		= $jumlah;
								}
							}
						}
					}
				}
				array_push(
					$messages,
					array("success", "Data berhasil diubah.")
				);
			} catch (Exception $e) {
				array_push(
					$messages,
					array("danger", "Data gagal diubah.")
				);
			}
			$redirect = "?content=data_transaksi_persetujuan_form&action=persetujuan&id=" . $idTransaksi ;
			break;
		case 'remove_biaya_kerusakan':
			try {
				$idTransaksi = mysqli_fetch_array(getBiayaKerusakanById($id), MYSQLI_BOTH)['id_transaksi'];
				mysqli_query($koneksi, "DELETE FROM `data_biaya_kerusakan` WHERE `id_biaya_kerusakan` = '$id' AND `id_transaksi` = '$idTransaksi'") or die($koneksi);
				array_push( $messages, array("success", "Data berhasil dihapus.") );
			} catch (Exception $e) {
				array_push( $messages, array("danger", "Data gagal dihapus.") );
			}
			$redirect = "?content=data_transaksi_persetujuan_form&action=persetujuan&id=" . $idTransaksi ;
			break;
		case 'remove_damage_cost':
			try {
				$idTransaksi = NULL;
				if (!empty($_SESSION["damage_cost"])) {
					$array = array_keys($_SESSION["damage_cost"]);
					for ($i = 0; $i <= end($array); $i++) {
						if (isset($_SESSION["damage_cost"][$i])) {
							if ($id == $i) {
								$idTransaksi = $_SESSION["damage_cost"][$i]['id_transaksi'];
								unset($_SESSION["damage_cost"][$i]);
							}
							if (empty($_SESSION["damage_cost"])) {
								unset($_SESSION["damage_cost"]);
							}
						}
					}
				}
				array_push(
					$messages,
					array("success", "Data berhasil dihapus.")
				);
			} catch (Exception $e) {
				array_push(
					$messages,
					array("danger", "Data gagal dihapus.")
				);
			}
			$redirect = "?content=data_transaksi_persetujuan_form&action=persetujuan&id=" . $idTransaksi ;
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