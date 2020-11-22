<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
    $proses 				= (isset($_GET['proses'])) ? antiInjection($_GET['proses']) : NULL ;
    $role 					= (isset($_GET['role'])) ? antiInjection($_GET['role']) : NULL ;
	if ($proses == NULL | $user == NULL) {
		$_SESSION['message-type'] 		= "danger";
		$_SESSION['message-content'] 	= "Proses dan Jenis User belum ditentukan..!";
		echo "
			<script>
				window.location.replace('login.php');
			</script>
		";
	}
	if ($proses == 'confirm_account') {
		$idPelanggan = (isset($_GET['user_id']) AND !empty($_GET['user_id'])) ? $_GET['user_id'] : NULL ;
		$email = (isset($_GET['email']) AND !empty($_GET['email'])) ? $_GET['email'] : NULL ;
		$token = (isset($_GET['token']) AND !empty($_GET['token'])) ? antiInjection($_GET['token']) : NULL ;
		$statusAkun = "aktif";
	} else {
		if ($proses == 'unnamed') {
			$variable 	= (isset($_POST['variable'])) ? antiInjection($_POST['variable']) : NULL;
		}
		$variable 	= (isset($_POST['variable'])) ? antiInjection($_POST['variable']) : NULL;
		$sql 				= "";
	}
    $messages   = array();
    $sql		= "";
	$redirect = class_static_value::$URL_BASE;

	switch ($proses) {
		case 'confirm_account':
			try {
				$account = mysqli_query($koneksi, "SELECT * FROM `data_pelanggan` WHERE `id_pelanggan` = '$idPelanggan' AND `email` = '$email' AND `user_token` = '$token'");
				if (mysqli_num_rows($account) == 1) {
					mysqli_query($koneksi, "UPDATE `data_pelanggan` SET `status_akun` = '$statusAkun' WHERE `id_pelanggan` = '$idPelanggan' AND `email` = '$email' AND `user_token` = '$token'");
					array_push($messages, array("success", "Konfirmasi akun berhasil..!"));
				} else {
					array_push($messages, array("danger", "Maaf, terjadi kesalahan dalam pembuatan akun. Mohon hubungi pihak administrator untuk menyelesaikan masalah ini atau buat akun baru..!"));
					$redirect .= "/?content=konfirmasi_akun_gagal";
				}
			} catch (Exception $e) {
				array_push($messages, array("danger", "Konfirmasi akun gagal..!"));
				$redirect .= "/?content=konfirmasi_akun_gagal";
			}
			break;
		default:
			# code...
			break;
	}

	if (!empty($messages)) {
		saveNotifikasi($messages);
	}

	echo "
		<script>
			window.location.replace('$redirect');
		</script>
	";
?>