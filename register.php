<?php
	include_once 'functions/class_static_value.php';
	$csv = new class_static_value();
	include_once 'functions/function_umum.php';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Sufee Admin - HTML5 Admin Template</title>
		<meta name="description" content="Sufee Admin - HTML5 Admin Template">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="apple-touch-icon" href="apple-icon.png">
		<link rel="shortcut icon" href="favicon.ico">

		<link rel="stylesheet" href="assets/lib/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/lib/icons/fontawesome/css/all.min.css">
		<link rel="stylesheet" href="assets/lib/icons/themify-icons/themify-icons.css">
		<link rel="stylesheet" href="assets/lib/icons/flag-icon-css/flag-icon.min.css">
		<link rel="stylesheet" href="assets/lib/selectFX/css/cs-skin-elastic.css">

		<link rel="stylesheet" href="assets/backend/css/style.css">

		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
	</head>

	<body class="bg-dark">

		<!-- Main wrapper  -->
		<div id="main-wrapper">
			<div class="unix-login">
				<div class="container-fluid">
					<div class="row justify-content-center">
						<div class="col-lg-4">
							<div class="login-content card">
								<div class="login-form">
									<h4 style="margin-bottom: 1%;">Register</h4>

									<?= getNotifikasi() ?>

									<!-- Nav tabs -->
									<ul class="nav nav-tabs nav-justified customtab" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#pelanggan" role="tab">
												<span class="hidden-sm-up">
													<i class="ti-home"></i>
												</span>
												<span class="hidden-xs-down">
													Pelanggan
												</span>
											</a>
										</li>
									</ul>
									<!-- Tab panes -->
									<div class="tab-content">
										<div class="tab-pane p-20 active" id="pelanggan" role="tabpanel">
											<form action="index.php?content=login_proses&proses=register&user=pelanggan" method="POST" enctype="multipart/form-data" role="form" id="register-form">
												<div class="form-group">
													<label>Nama Lengkap</label>
													<input type="text" class="form-control" name="nama_lengkap" placeholder="Nama Lengkap..." required>
												</div>

												<div class="form-group">
													<label>No. HP</label>
													<input type="text" class="form-control" name="no_hp" placeholder="No. HP..." required>
												</div>

												<div class="form-group">
													<label>Email</label>
													<input type="email" class="form-control" name="email" placeholder="Email..." required>
												</div>

												<div class="form-group">
													<label>Alamat</label>
													<input type="text" class="form-control" name="alamat" placeholder="Alamat...">
												</div>

												<div class="form-group">
													<label>User Name</label>
													<input type="text" class="form-control" name="username" placeholder="User Name" required>
												</div>

												<div class="form-group">
													<label>Password</label>
													<input type="password" class="form-control" name="password" placeholder="Password" required>
												</div>

												<div class="form-group">
													<label>Foto Profil</label>
													<input type="file" class="form-control" name="url_foto" placeholder="Foto Profil">
												</div>

												<div class="form-group">
													<label>NIK</label>
													<input type="text" class="form-control" name="nik" placeholder="NIK" required>
												</div>

												<div class="form-group">
													<label>Foto KTP</label>
													<input type="file" class="form-control" name="url_foto_ktp" placeholder="Foto KTP" required>
												</div>

												<button type="submit" name="register" class="btn btn-primary btn-flat m-b-10 m-t-10">Register</button>

												<div class="register-link m-t-15 text-center">
													<p>
														Sudah punya akun ?
														<a href="login.php"> Sign in</a>
													</p>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>

							<center>
								<a class="btn btn-primary" href="<?php echo class_static_value::$URL_BASE; ?>">
									<i class="fas fa-arrow-left"></i>
									Kembali
								</a>
							</center>

						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Wrapper -->

		<script src="assets/lib/jquery/jquery.min.js"></script>
		<script src="assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="assets/backend/js/main.js"></script>

	</body>

</html>