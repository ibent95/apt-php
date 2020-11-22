<?php
    $alamat     = getKonfigurasiUmum("office_address", "single")['nilai_konfigurasi'];
    $noTelp     = getKonfigurasiUmum("phone_number", "single")['nilai_konfigurasi'];
    $email      = getKonfigurasiUmum("official_email", "single")['nilai_konfigurasi'];
    $website    = getKonfigurasiUmum("official_website", "single")['nilai_konfigurasi'];
    $jamKerja   = getKonfigurasiUmum("open_hours", "single")['nilai_konfigurasi'];
?>
<!-- ##### Footer Area Start ##### -->
<footer class="footer-area bg-img" style="background-image: url(assets/frontend/img/bg-img/3.jpg);">
	<!-- Main Footer Area -->
	<div class="main-footer-area">
		<div class="container">
			<div class="row">

				<!-- Single Footer Widget -->
				<div class="col-12 col-sm-6 col-lg-4">
					<div class="single-footer-widget">
						<div class="footer-logo mb-30">
							<a href="#"><img src="assets/img/logo.png" alt=""></a>
						</div>
						<p>Aplikasi Penjualan Telur.</p>
						<div class="social-info">
							<a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
							<a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
							<!-- <a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
							<a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
							<a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a> -->
						</div>
					</div>
				</div>

				<!-- Single Footer Widget -->
				<div class="col-12 col-sm-6 col-lg-4">
					<!-- <div class="single-footer-widget">
						<div class="widget-title">
							<h5>QUICK LINK</h5>
						</div>
						<nav class="widget-nav">
							<ul>
								<li><a href="#">Purchase</a></li>
								<li><a href="#">FAQs</a></li>
								<li><a href="#">Payment</a></li>
								<li><a href="#">News</a></li>
								<li><a href="#">Return</a></li>
								<li><a href="#">Advertise</a></li>
								<li><a href="#">Shipping</a></li>
								<li><a href="#">Career</a></li>
								<li><a href="#">Orders</a></li>
								<li><a href="#">Policities</a></li>
							</ul>
						</nav>
					</div> -->
				</div>

				<!-- Single Footer Widget -->
				<div class="col-12 col-sm-6 col-lg-4">
					<div class="single-footer-widget">
						<div class="widget-title">
							<h5>KONTAK</h5>
						</div>

						<div class="contact-information">
							<p>
								<span>
									<i class="fa fa-home fa-fw"></i>
									Alamat :
								</span> 
								<?= $alamat ?>
							</p>
							<p>
								<span>
									<i class="fa fa-phone fa-fw"></i>
									No. Telp :
								</span> 
								<?= $noTelp ?>
							</p>
							<p>
								<span>
									<i class="fa fa-envelope fa-fw"></i>
									Email :
								</span> 
								<?= $email ?>
							</p>
							<p>
								<span>
									<i class="fa fa-globe fa-fw"></i>
									Situs Resmi :
								</span> 
								<?= $website ?>
							</p>
							<p>
								<span>
									<i class="fa fa-clock-o fa-fw"></i>
									Jam Kerja :
								</span> 
								<?= $jamKerja ?>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Footer Bottom Area -->
	<div class="footer-bottom-area">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="border-line"></div>
				</div>
				<!-- Copywrite Text -->
				<div class="col-12 col-md-6">
					<div class="copywrite-text">
						<p>
							&copy; 
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
							Copyright &copy;
							<script>
								document.write(new Date().getFullYear());
							</script>
							All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						</p>
					</div>
				</div>
				<!-- Footer Nav -->
				<!-- <div class="col-12 col-md-6">
					<div class="footer-nav">
						<nav>
							<ul>
								<li><a href="#">Home</a></li>
								<li><a href="#">About</a></li>
								<li><a href="#">Service</a></li>
								<li><a href="#">Portfolio</a></li>
								<li><a href="#">Blog</a></li>
								<li><a href="#">Contact</a></li>
							</ul>
						</nav>
					</div>
				</div> -->
			</div>
		</div>
	</div>
</footer>
<!-- ##### Footer Area End ##### -->