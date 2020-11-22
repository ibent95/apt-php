<?php
	// $layananAll = getKategoriAll('ASC');
?>
<!-- ##### Hero Area Start ##### -->
<section class="hero-area">
	<div class="hero-post-slides owl-carousel">
		<!-- Single Hero Post -->
		<div class="single-hero-post bg-overlay">
			<!-- Post Image -->
			<div class="slide-img bg-img" style="background-image: url(assets/frontend/img/bg-img/01.jpg);"></div>
			<div class="container" style="margin-top:11%;">
				<div class="row h-100 align-items-center">
					<div class="col-12">
						<!-- Post Content -->
						<div class="hero-slides-content text-center">
							<h2>Aplikasi Penjualan Telur Makassar</h2>
							<p>Mudah, cepat dan berkualitas.</p>
							<div class="welcome-btn-group">
								<a href="?content=produk" class="btn alazea-btn mr-30">PESAN SEKARANG</a>
								<a href="#" class="btn alazea-btn active">HUBUNGI KAMI</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Single Hero Post -->
		<div class="single-hero-post bg-overlay">
			<!-- Post Image -->
			<div class="slide-img bg-img" style="background-image: url(assets/frontend/img/bg-img/02.jpg);"></div>
			<div class="container" style="margin-top:11%;">
				<div class="row h-100 align-items-center">
					<div class="col-12">
						<!-- Post Content -->
						<div class="hero-slides-content text-center">
							<h2>Aplikasi Penjualan Telur Makassar</h2>
							<p>Mudah, cepat dan berkualitas.</p>
							<div class="welcome-btn-group">
								<a href="?content=produk" class="btn alazea-btn mr-30">PESAN SEKARANG</a>
								<a href="#" class="btn alazea-btn active">HUBUNGI KAMI</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- ##### Hero Area End ##### -->
<?= getNotifikasi() ?>
<!-- ##### Service Area Start ##### -->
<section class="our-services-area section-padding-100-0">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<!-- Section Heading -->
				<div class="section-heading text-center">
					<h2>KATEGORI LAYANAN KAMI</h2>
					<p>Kami menyediakan layanan perbaikan perangkat terbaik untuk anda.</p>
				</div>
			</div>
		</div>
		<div class="row">
			<?php if (isset($layananAll)): ?>
				<?php foreach ($layananAll as $layanan) : ?>
					<!-- Single Service Area -->
					<div class="col-4 mb-100">
						<div class="single-service-area d-flex align-items-top wow fadeInUp" data-wow-delay="100ms">
							<!-- Icon -->
							<div class="service-icon mr-30">
								<img src="assets/frontend/img/core-img/s1.png" alt="">
							</div>
							<!-- Content -->
							<div class="service-content">
								<h5><?= $layanan['nama_kategori_layanan'] ?></h5>
								<p><?= htmlspecialchars_decode($layanan['deskripsi']) ?></p>
							</div>
						</div>
					</div>
				<?php endforeach ?>
			<?php endif ?>
			<!-- <div class="col-12 col-lg-6">
				<div class="alazea-video-area bg-overlay mb-100">
					<img src="assets/frontend/img/bg-img/23.jpg" alt="">
					<a href="http://www.youtube.com/watch?v=7HKoqNJtMTQ" class="video-icon">
						<i class="fa fa-play" aria-hidden="true"></i>
					</a>
				</div>
			</div> -->
		</div>
	</div>
</section>
<!-- ##### Service Area End ##### -->

<!-- ##### Contact Area Start ##### -->
<section class="contact-area bg-gray section-padding-100-0">
	<div class="container">
		<div class="row align-items-center justify-content-between">
			<div class="col-12 col-lg-5">
				<!-- Section Heading -->
				<div class="section-heading">
					<h2>HUBUNGI KAMI</h2>
					<p>Kirim pesan anda, kami akan menghubungi anda nanti.</p>
				</div>
				<!-- Contact Form Area -->
				<div class="contact-form-area mb-100">
					<form action="#" method="post">
						<div class="row">
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" id="contact-name" placeholder="Your Name">
								</div>
							</div>
							<div class="col-12 col-sm-6">
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
					<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3973.7062033677303!2d119.4434062!3d-5.1509061!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dbefd410140a1b3%3A0xa042cffff12f7cd3!2sPT.+Fortinusa!5e0!3m2!1sen!2sid!4v1542971846541" allowfullscreen></iframe>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- ##### Contact Area End ##### -->