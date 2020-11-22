<?php
	$alamat		= getKonfigurasiUmum("office_address", "single")['nilai_konfigurasi'];
	$noTelp		= getKonfigurasiUmum("phone_number", "single")['nilai_konfigurasi'];
	$email		= getKonfigurasiUmum("official_email", "single")['nilai_konfigurasi'];
	$website	= getKonfigurasiUmum("official_website", "single")['nilai_konfigurasi'];
	$jamKerja	= getKonfigurasiUmum("open_hours", "single")['nilai_konfigurasi'];
?>
<!-- ##### Breadcrumb Area Start ##### -->
<div class="breadcrumb-area">
	<!-- Top Breadcrumb Area -->
	<div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(assets/frontend/img/bg-img/24.jpg);">
		<h2>Kontak</h2>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-12">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="<?php echo $csv::$URL_BASE; ?>">
								<i class="fa fa-home"></i>
								Home
							</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							<i class="fa fa-user"></i>
							Kontak
						</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<!-- ##### Breadcrumb Area End ##### -->
<!-- ##### Contact Area Info Start ##### -->
<div class="contact-area-info section-padding-0-100">
	<div class="container">
		<div class="row align-items-center justify-content-between">
			<!-- Contact Thumbnail -->
			<div class="col-12 col-md-6">
				<div class="contact--thumbnail">
					<img src="assets/frontend/img/bg-img/25.jpg" alt="">
				</div>
			</div>
			<div class="col-12 col-md-5">
				<!-- Section Heading -->
				<div class="section-heading">
					<h2>Kontak Kami</h2>
					<p>Kami selalu mengembangkan layanan kami, untuk melayani anda lebih baik.</p>
				</div>
				<!-- Contact Information -->
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
<!-- ##### Contact Area Info End ##### -->
<!-- ##### Contact Area Start ##### -->
<section class="contact-area">
	<div class="container">
		<div class="row align-items-center justify-content-between">
			<div class="col-12 col-lg-5">
				<!-- Section Heading -->
				<div class="section-heading">
					<h2>Hubungi Kami</h2>
					<p>Kirim pesan anda, kami akan menghubungi anda nanti.</p>
				</div>
				<!-- Contact Form Area -->
				<div class="contact-form-area mb-100">
					<form action="#" method="post">
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group">
									<input type="text" class="form-control" id="contact-name" placeholder="Your Name">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<input type="email" class="form-control" id="contact-email" placeholder="Your Email">
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<input type="text" class="form-control" id="contact-subject" placeholder="Subject">
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<textarea class="form-control" name="message" id="message" cols="30" rows="10" placeholder="Message"></textarea>
								</div>
							</div>
							<div class="col-12">
								<button type="submit" class="btn alazea-btn mt-15">Send Message</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="col-12 col-lg-6">
				<!-- Google Maps -->
				<div class="map-area mb-100">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3973.706203317892!2d119.4434061661053!3d-5.150906107971895!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dbefd410140a1b3%3A0xa042cffff12f7cd3!2sPT.+Fortinusa!5e0!3m2!1sid!2sid!4v1542970206047" allowfullscreen></iframe>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- ##### Contact Area End ##### -->