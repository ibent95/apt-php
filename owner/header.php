<aside id="left-panel" class="left-panel">
	<nav class="navbar navbar-expand-sm navbar-default">

		<div class="navbar-header">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
				<i class="fa fa-bars"></i>
			</button>
			<a class="navbar-brand" href="./">
				<img src="../assets/backend/images/logo.png" alt="Logo">
			</a>
			<a class="navbar-brand hidden" href="./">
				<img src="../assets/backend/images/logo2.png" alt="Logo">
			</a>
		</div>

		<div id="main-menu" class="main-menu collapse navbar-collapse">
			<ul class="nav navbar-nav">

				<li class="active">
					<a href="<?= class_static_value::$URL_BASE ?>/owner"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
				</li>

				<h3 class="menu-title">Laporan</h3><!-- /.menu-title -->

				<li class="active">
					<a href="?content=data_laporan_arus_kas"> 
						<i class="menu-icon fa fa-bell"></i>
						Arus Kas (Cash Flow)
					</a>
				</li>

			</ul>
		</div><!-- /.navbar-collapse -->
	</nav>
</aside><!-- /#left-panel -->

<!-- Left Panel -->

<!-- Right Panel -->

<div id="right-panel" class="right-panel">

<!-- Header-->
<header id="header" class="header">

	<div class="header-menu">

		<div class="col-sm-7">
			<a id="menuToggle" class="menutoggle pull-left"><i class="fa fa-tasks"></i></a>
			<div class="header-left">
				<button class="search-trigger"><i class="fa fa-search"></i></button>
				<div class="form-inline">
					<form class="search-form">
						<input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
						<button class="search-close" type="submit"><i class="fa fa-close"></i></button>
					</form>
				</div>

			</div>
		</div>

		<div class="col-sm-5">
			<div class="user-area dropdown float-right">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<img class="user-avatar rounded-circle" src="../assets/backend/images/admin.jpg" alt="User Avatar">
				</a>

				<div class="user-menu dropdown-menu">
					<a class="nav-link" href="#"><i class="fa fa-user"></i> My Profile</a>

					<a class="nav-link" href="../index.php?content=login_proses&proses=logout"><i class="fa fa-power-off"></i> Logout</a>
				</div>
			</div>

		</div>
	</div>

</header>