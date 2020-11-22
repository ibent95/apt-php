<?php 
    $proses = $_GET['proses'];
	if ($proses == 'remove') {
		$id = $_GET ['id'];
	} else {
		if ($proses == 'edit') {
			$id			= (isset($_POST['id'])) ? $_POST['id'] : NULL ;
		}
		$namaPelanggan	= (isset($_POST['nama_pelanggan'])) ? $_POST['nama_pelanggan'] : NULL ;
		$email			= (isset($_POST['email'])) ? $_POST['email'] : NULL ;
		$no_hp			= (isset($_POST['no_hp'])) ? $_POST['no_hp'] : NULL ;
		$username		= (isset($_POST['username'])) ? $_POST['username'] : NULL ;
		$password		= (isset($_POST['password'])) ? md5($_POST['password']) : NULL ;
		$alamat			= (isset($_POST['alamat'])) ? $_POST['alamat'] : NULL ;
		$foto			= (isset($_FILES['foto'])) ? uploadFile($_FILES['foto'], "pelanggan", "img", "short") : NULL ;
		$nik			= (isset($_POST['nik'])) ? $_POST['nik'] : NULL ;
		$fotoKTP		= (isset($_FILES['foto_ktp'])) ? uploadFile($_FILES['foto_ktp'], "ktp", "img", "short") : NULL ;
		// $jenisAkun		= (isset($_POST['jenis_akun'])) ? $_POST['jenis_akun'] : 'admin' ;
		$statusAkun 	= (isset($_POST['status_akun'])) ? $_POST['status_akun'] : 'aktif' ;
	}
    $messages   = array();
    $sql		= "";
	$redirect	= "?content=data_pelanggan";

	switch ($proses) {
		case 'add':
			try {
				if (is_numeric($nik)) {
					mysqli_query ($koneksi, "INSERT INTO `data_pelanggan` (`nama_pelanggan`, `email`, `no_hp`, `alamat`, `username`, `password`, `foto`, `nik`, `foto_ktp`, `status_akun`) VALUES ('$namaPelanggan', '$email', '$no_hp', '$alamat', '$username', '$password', '$foto', '$nik', '$fotoKTP', '$statusAkun')") or die ($koneksi);
					array_push($messages, array("success", "Data berhasil ditambahkan..!"));
				} else {
					array_push($messages, array("danger", "NIK tidak boleh berisi karakter lain selain nomor..!"));
					$proses = 'back';
				}
			} catch (Exception $e) {
				array_push($messages, array("danger", "Data gagal ditambahkan..!"));
			}
			break;
		case 'edit':
			try {
				if (is_numeric($nik)) {
					mysqli_query($koneksi, "UPDATE `data_pelanggan` SET `nama_pelanggan` = '$namaPelanggan', `email` = '$email', `no_hp` = '$no_hp', `alamat` = '$alamat', `username` = '$username', `nik` = '$nik', `status_akun` = '$statusAkun' WHERE `id_pelanggan` = '$id'") or die ($koneksi);
					if ($password != "" | $password != NULL | !empty($password)) {
						mysqli_query($koneksi, "UPDATE `data_pelanggan` SET `password` = '$password' WHERE `id_pelanggan` = '$id'") or die ($koneksi);
					}
					if ($foto != "" | $foto != NULL | !empty($foto)) {
						mysqli_query ($koneksi, "UPDATE `data_pelanggan` SET `foto` = '$foto' WHERE `id_pelanggan` = '$id'") or die ($koneksi);
					}
					if ($fotoKTP != "" | $fotoKTP != NULL | !empty($fotoKTP)) {
						mysqli_query ($koneksi, "UPDATE `data_pelanggan` SET `foto_ktp` = '$fotoKTP' WHERE `id_pelanggan` = '$id'") or die ($koneksi);
					}
					array_push($messages, array("success", "Data berhasil diubah..!"));
				} else {
					array_push($messages, array("danger", "NIK tidak boleh berisi karakter lain selain nomor..!"));
					$proses = 'back';
				}
			} catch (Exception $e) {
				array_push($messages, array("danger", "Data gagal diubah..!"));
			}
			break;
		case 'remove':
			try {
				mysqli_query($koneksi, "DELETE FROM `data_pelanggan` WHERE `id_pelanggan` = '$id'") or die ($koneksi);
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

	if ($proses == 'add' OR $proses == 'edit') {
		echo "<script>window.history.go(-2);</script>";
	} elseif ($proses == 'back') {
		echo "<script>window.history.go(-1);</script>";
	} else {
		echo "<script>window.location.replace('$redirect');</script>";
	}

?>