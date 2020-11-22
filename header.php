<?php
	$alamat     = getKonfigurasiUmum("office_address", "single")['nilai_konfigurasi'];
	$noTelp     = getKonfigurasiUmum("phone_number", "single")['nilai_konfigurasi'];
	$email      = getKonfigurasiUmum("official_email", "single")['nilai_konfigurasi'];
	$website    = getKonfigurasiUmum("official_website", "single")['nilai_konfigurasi'];
	$jamKerja   = getKonfigurasiUmum("open_hours", "single")['nilai_konfigurasi'];
?>
<!-- ##### Header Area Start ##### -->
<header class="header-area">
	<!-- ***** Top Header Area ***** -->
	<div class="top-header-area">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="top-header-content d-flex align-items-center justify-content-between">
						<!-- Top Header Content -->
						<div class="top-header-meta">
							<a href="mail:<?= $email ?>" data-toggle="tooltip" data-placement="bottom" title="<?= $email ?>">
								<i class="fa fa-envelope-o" aria-hidden="true"></i>
								<span>Email: <?= $email ?></span>
							</a>
							<a href="tel:+6282193035842" data-toggle="tooltip" data-placement="bottom" title="<?= $noTelp ?>">
								<i class="fa fa-phone" aria-hidden="true"></i>
								<span>Telepon: <?= $noTelp ?></span>
							</a>
						</div>
						<!-- Top Header Content -->
						<div class="top-header-meta d-flex">
							<!-- Language Dropdown -->
							<!-- <div class="language-dropdown">
								<div class="dropdown">
									<button class="btn btn-secondary dropdown-toggle mr-30" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Language</button>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
										<a class="dropdown-item" href="#">USA</a>
										<a class="dropdown-item" href="#">UK</a>
										<a class="dropdown-item" href="#">Bangla</a>
										<a class="dropdown-item" href="#">Hindi</a>
										<a class="dropdown-item" href="#">Spanish</a>
										<a class="dropdown-item" href="#">Latin</a>
									</div>
								</div>
							</div> -->
							<!-- Login -->
							<!-- <div class="login">
								<a href="#"><i class="fa fa-user" aria-hidden="true"></i> <span>Login</span></a>
							</div> -->
							<!-- Cart -->
							<!-- <div class="cart">
								<a href="#">
									<i class="fa fa-shopping-cart" aria-hidden="true"></i>
									<span>
										Cart
										<span class="cart-quantity">
											(1)
										</span>
									</span>
								</a>
							</div> -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ***** Navbar Area ***** -->
	<div class="alazea-main-menu">
		<div class="classy-nav-container breakpoint-off">
			<div class="container">
				<!-- Menu -->
				<nav class="classy-navbar justify-content-between" id="alazeaNav">
					<!-- Nav Brand -->
					<a href="<?= class_static_value::$URL_BASE ?>" class="nav-brand" style="font-size: 0px;">
						<img src="assets/img/logo.png" alt="Aplikasi Penjualan Telur">
					</a>
					<!-- Navbar Toggler -->
					<div class="classy-navbar-toggler">
						<span class="navbarToggler">
							<span></span>
							<span></span>
							<span></span>
						</span>
					</div>
					<!-- Menu -->
					<div class="classy-menu">
						<!-- Close Button -->
						<div class="classycloseIcon">
							<div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
						</div>
						<!-- Navbar Start -->
						<div class="classynav">
							<!-- <ul>
								<li><a href="index.html">Home</a></li>
								<li><a href="about.html">About</a></li>
								<li><a href="#">Pages</a>
									<ul class="dropdown">
										<li><a href="index.html">Home</a></li>
										<li><a href="about.html">About</a></li>
										<li><a href="shop.html">Shop</a>
											<ul class="dropdown">
												<li><a href="shop.html">Shop</a></li>
												<li><a href="shop-details.html">Shop Details</a></li>
												<li><a href="cart.html">Shopping Cart</a></li>
												<li>
													<a href="#">Checkout</a>
													<ul class="dropdown">
														<li><a href="shop.html">Shop</a></li>
														<li><a href="shop-details.html">Shop Details</a></li>
														<li><a href="cart.html">Shopping Cart</a></li>
														<li><a href="checkout.html">Checkout</a></li>
													</ul>
												</li>
											</ul>
										</li>
										<li><a href="portfolio.html">Portfolio</a>
											<ul class="dropdown">
												<li><a href="portfolio.html">Portfolio</a></li>
												<li><a href="single-portfolio.html">Portfolio Details</a></li>
											</ul>
										</li>
										<li><a href="blog.html">Blog</a>
											<ul class="dropdown">
												<li><a href="blog.html">Blog</a></li>
												<li><a href="single-post.html">Blog Details</a></li>
											</ul>
										</li>
										<li><a href="contact.html">Contact</a></li>
									</ul>
								</li>
								<li><a href="shop.html">Shop</a></li>
								<li><a href="portfolio.html">Portfolio</a></li>
								<li><a href="contact.html">Contact</a></li>
							</ul> -->
							<?php getMenuAll(); ?>
							<!-- Search Icon -->
							<div id="searchIcon">
								<i class="fa fa-search" aria-hidden="true"></i>
							</div>
						</div>
						<!-- Navbar End -->
					</div>
				</nav>
				<!-- Search Form -->
				<div class="search-form">
					<form action="#" method="get">
						<input type="search" name="search" id="search" placeholder="Type keywords &amp; press enter...">
						<button type="submit" class="d-none"></button>
					</form>
					<!-- Close Icon -->
					<div class="closeIcon"><i class="fa fa-times" aria-hidden="true"></i></div>
				</div>
			</div>
		</div>
	</div>
</header>
<!-- ##### Header Area End ##### -->