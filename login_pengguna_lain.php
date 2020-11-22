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
		<div class="sufee-login d-flex align-content-center flex-wrap">
			<div class="container">
				<div class="login-content">
					<div class="login-logo">
						<a href="index.html">
							<img class="align-content" src="assets/backend/images/logo.png" alt="">
						</a>
					</div>
					<div class="login-form">
						<?= getNotifikasi() ?>
						<!-- Nav tabs -->
						<ul class="nav nav-tabs nav-justified customtab" role="tablist">
							<li class="nav-item"> 
								<a class="nav-link active" data-toggle="tab" href="#admin" role="tab">
									<span class="hidden-sm-up">
										<i class="ti-home"></i>
									</span> 
									<span class="hidden-xs-down">
										Administrator
									</span>
								</a> 
							</li>
							<li class="nav-item"> 
								<a class="nav-link" data-toggle="tab" href="#owner" role="tab">
									<span class="hidden-sm-up">
										<i class="ti-home"></i>
									</span> 
									<span class="hidden-xs-down">
										Owner
									</span>
								</a> 
							</li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content">
							<div class="tab-pane p-20 active" id="admin" role="tabpanel">
								<form action="index.php?content=login_proses&proses=login&user=admin" method="POST">
									<div class="form-group">
										<label>Username Admin</label>
										<input type="text" name="username" class="form-control" placeholder="Username">
									</div>
									<div class="form-group">
										<label>Password</label>
										<input type="password" name="password" class="form-control" placeholder="Password">
									</div>
									<!-- <div class="checkbox">
										<label>
												<input type="checkbox"> Remember Me
											</label>
										<label class="pull-right">
												<a href="#">Forgotten Password?</a>
											</label>

									</div> -->
									<button type="submit" class="btn btn-success btn-flat m-b-15 m-t-15">Masuk</button>
									<div class="register-link m-t-15 text-center">
										<p class="mt-3">
											Pelanggan atau Kurir..? <a href="login.php"> Masuk di sini..!</a>
										</p>
									</div>
								</form>
							</div>

							<div class="tab-pane p-20 " id="owner" role="tabpanel">
								<form action="index.php?content=login_proses&proses=login&user=owner" method="POST">
									<div class="form-group">
										<label>Username Owner</label>
										<input type="text" name="username" class="form-control" placeholder="Username">
									</div>
									<div class="form-group">
										<label>Password</label>
										<input type="password" name="password" class="form-control" placeholder="Password">
									</div>
									<!-- <div class="checkbox">
										<label>
												<input type="checkbox"> Remember Me
											</label>
										<label class="pull-right">
												<a href="#">Forgotten Password?</a>
											</label>

									</div> -->
									<button type="submit" class="btn btn-success btn-flat m-b-15 m-t-15">Masuk</button>
									<div class="register-link m-t-15 text-center">
										<p class="mt-3">
											Pelanggan atau Kurir..? <a href="login.php"> Masuk di sini..!</a>
										</p>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="text-center mt-3">
						<a href="<?= $csv::$URL_BASE ?>\?content=beranda" class="btn btn-primary btn-lg">
							<i class="fas fa-arrow-left fa-fw"></i>
							Kembali
						</a>
					</div>
				</div>
			</div>
		</div>

		<script src="assets/lib/jquery/jquery.min.js"></script>
		<script src="assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="assets/backend/js/main.js"></script>

	</body>

</html>