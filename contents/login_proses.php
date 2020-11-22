<?php

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	$proses			= (isset($_GET['proses'])) ? antiInjection($_GET['proses']) : NULL ;
	$user			= (isset($_GET['user'])) ? antiInjection($_GET['user']) : NULL ;

	if ($proses == NULL | $user == NULL) {
		$_SESSION['message-type'] 		= "danger";
		$_SESSION['message-content'] 	= "Proses dan Jenis User belum ditentukan..!";
		echo "<script>window.history.go(-1);</script>";
	}
	if ($proses == 'remove') {
		$id			= antiInjection($_GET['id']);
	} else {
		if ($proses == 'register') {
			$nama_lengkap	= (isset($_POST['nama_lengkap'])) ? antiInjection($_POST['nama_lengkap']) : NULL;
			$no_hp			= (isset($_POST['no_hp'])) ? antiInjection($_POST['no_hp']) : NULL;
			$email			= (isset($_POST['email'])) ? antiInjection($_POST['email']) : NULL;
			$alamat			= (isset($_POST['alamat'])) ? antiInjection($_POST['alamat']) : NULL;
			$url_foto		= (isset($_FILES['url_foto'])) ? uploadFile($_FILES['url_foto'], "pelanggan", "img", "short") : NULL;
			$nik			= (isset($_POST['nik'])) ? antiInjection($_POST['nik']) : NULL;
			$url_foto_ktp	= (isset($_FILES['url_foto_ktp'])) ? uploadFile($_FILES['url_foto_ktp'], "ktp", "img", "short") : NULL;
			$status_akun	= "blokir";
		}

		$username	= ($_POST['username']) ? antiInjection($_POST['username']) : NULL ;
		$password	= ($_POST['password']) ? md5(antiInjection($_POST['password'])) : NULL ;
		$sql		= "";
	}
	$messages		= array();
	$redirect		= class_static_value::$URL_BASE;

	switch ($proses) {
		case 'login':
			if ($user == 'pelanggan') {
				$sql .= "SELECT * FROM `data_pelanggan` WHERE `username` = '$username' AND `password` = '$password' AND `status_akun` = 'aktif'";
			} elseif ($user == 'kurir') {
				$sql .= "SELECT * FROM `data_kurir` WHERE `username` = '$username' AND `password` = '$password' AND `status_akun` = 'aktif'";
			} elseif ($user == 'admin') {
				$sql .= "SELECT * FROM `data_pengguna` WHERE `username` = '$username' AND `password` = '$password' AND `status_akun` = 'aktif' AND `jenis_akun` = 'admin'";
			} elseif ($user == 'owner') {
				$sql .= "SELECT * FROM `data_pengguna` WHERE `username` = '$username' AND `password` = '$password' AND `status_akun` = 'aktif' AND `jenis_akun` = 'owner'";
			}

			try {
				$result = mysqli_query($koneksi, $sql) or die ($koneksi);
				if (mysqli_num_rows($result) == 0) {
					$_SESSION['message-type'] 		= "danger";
					$_SESSION['message-content'] 	= "Maaf, username atau password salah..!";
					echo "<script>window.history.go(-1);</script>";
				} elseif (mysqli_num_rows($result) == 1) {
					$data = mysqli_fetch_array($result, MYSQLI_BOTH);

					$_SESSION['no_hp'] 			= $data['no_hp'];
					$_SESSION['email'] 			= $data['email'];
					if ($user != "admin" OR $user != "owner") {
						$_SESSION['alamat'] 		= $data['alamat'];
					}
					$_SESSION['username'] 		= $data['username'];
					$_SESSION['password'] 		= $data['password'];
					$_SESSION['foto'] 			= $data['foto'];
					$_SESSION['foto_ktp'] 		= $data['foto_ktp'];

					if ($user == 'pelanggan') {
						$_SESSION['nama'] 		= $data['nama_pelanggan'];
						$_SESSION['id'] 		= $data['id_pelanggan'];
						$_SESSION['jenis_akun'] 	= 'pelanggan';
						$redirect = class_static_value::$URL_BASE;
					} elseif ($user == 'kurir') {
						$_SESSION['nama'] 		= $data['nama_kurir'];
						$_SESSION['id'] 		= $data['id_kurir'];
						$_SESSION['jenis_akun'] 	= 'kurir';
						$redirect = class_static_value::$URL_BASE . "/" . $_SESSION['jenis_akun'];
					} elseif ($user == 'admin' OR $user == 'owner') {
						$_SESSION['nama'] 		= $data['nama_pengguna'];
						$_SESSION['id'] 		= $data['id_pengguna'];
						$_SESSION['jenis_akun']	= (isset($data['jenis_akun'])) ? $data['jenis_akun'] : "admin" ;
						$redirect = class_static_value::$URL_BASE . "/" . $_SESSION['jenis_akun'];
					}

					$_SESSION['logged-in']		= TRUE;

					$_SESSION['message-type'] 		= "success";
					$_SESSION['message-content'] 	= "Anda berhasil login..!";
				}
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Maaf, username atau password salah..!";
			}
			break;
		case 'register':
			if ($user == "pelanggan" AND is_numeric($nik)) {
				if (mysqli_num_rows(mysqli_query($koneksi, "SELECT `email` FROM `data_pelanggan` WHERE `email` = '$email' OR `username` = '$username'")) == 0) {
					$token = generateToken();
					mysqli_query($koneksi, "INSERT INTO `data_pelanggan` (`nama_pelanggan`, `no_hp`, `email`, `alamat`, `username`, `password`, `foto`, `status_akun`, `user_token`, `nik`, `foto_ktp`) VALUES ('$nama_lengkap', '$no_hp', '$email', '$alamat', '$username', '$password', '$url_foto', '$status_akun', '$token', $nik, '$url_foto_ktp')") or die($koneksi);
					array_push($messages, array("success", "Pendaftaran berhasil dilakukan, silahkan lakukan verifikasi email untuk mengaktifkan akun anda..!"));
					$customer = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `data_pelanggan` WHERE `email` = '$email' AND `username` = '$username' AND `user_token` = '$token' "), MYSQLI_BOTH);
					sendEmail("aryan@stimednp.ac.id", $email, "Verifikasi akun Aplikasi Penjualan Telur Makassar.", "Anda telah mendaftar di Aplikasi Penjualan Telur Makassar. Untuk mengaktifkan akun anda sebagai Pelanggan [" . $nama_lengkap . "], silahkan akses link berikut <a href='" . class_static_value::$URL_BASE. "/?content=authentication_proses&proses=confirm_account&user_id=" . $customer['id_pelanggan'] . "&email=" . $customer['email'] . "&token=" . $token . "'>Klik disini</a>.", NULL);
					$_SESSION['message-type'] = "success";
					$_SESSION['message-content'] = "Pendaftaran berhasil dilakukan, silahkan akses email anda untuk mengkonfirmasi dan mengaktifkan akun..!";
				} else {
					$_SESSION['message-type'] = "danger";
					$_SESSION['message-content'] = "Pendaftaran tidak berhasil dilakukan, email atau username yang anda masukan sudah digunakan untuk akun lain. Silahkan gunakan email atau username lain..!";
					// array_push($messages, array("danger", "Pendaftaran tidak berhasil dilakukan, email yang anda masukan sudah digunakan untuk akun lain. Silahkan gunakan email lain..!"));
					$proses = 'back';
				}
			} elseif ($user == "pelanggan" AND !is_numeric($nik)) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "NIK tidak boleh berisi karakter lain selain nomor..!";
				$proses = 'back';
			} elseif ($user == "kurir") {
				mysqli_query($koneksi, "INSERT INTO `data_teknisi` (`nama_lengkap`, `no_hp`, `email`, `alamat`, `username`, `password`, `url_foto`, `status_akun`) VALUES ('$nama_lengkap', '$no_hp', '$email', '$alamat', '$username', '$password', '$url_foto', '$status_akun')") or die($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Anda berhasil mendaftar..!";
			} else {
				# code...
			}
			break;

		case 'logout':
			session_destroy();
			$_SESSION['message-content'] = 'Logout berhasil..!';
			$_SESSION['message-type'] = 'success ';
			break;
		default:
			# code...
			break;
	}

	if ($proses == 'add' OR $proses == 'edit') {
		echo "<script>window.history.go(-2);</script>";
	} elseif ($proses == 'back') {
		echo "<script>window.history.go(-1);</script>";
	} else {
		echo "<script>window.location.replace('$redirect');</script>";
	}

?>