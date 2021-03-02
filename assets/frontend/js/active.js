$(document).ready(function() {
	'use strict';

	var browserWindow = $(window);

	// :: 1.0 Preloader Active Code
	browserWindow.on('load', function() {
		$('.preloader').fadeOut('slow', function() {
			$(this).remove();
		});
	});

	// :: 2.0 Nav Active Code
	if ($.fn.classyNav) {
		$('#alazeaNav').classyNav();
	}

	// :: 3.0 Search Active Code
	$('#searchIcon').on('click', function() {
		$('.search-form').toggleClass('active');
	});
	$('.closeIcon').on('click', function() {
		$('.search-form').removeClass('active');
	});

	// :: 4.0 Sliders Active Code
	if ($.fn.owlCarousel) {
		var welcomeSlide = $('.hero-post-slides');
		var testiSlides = $('.testimonials-slides');
		var portfolioSlides = $('.portfolio-slides');

		welcomeSlide.owlCarousel({
			items: 1,
			margin: 0,
			loop: true,
			nav: false,
			dots: false,
			autoplay: true,
			center: true,
			autoplayTimeout: 5000,
			smartSpeed: 1000
		});

		testiSlides.owlCarousel({
			items: 1,
			margin: 0,
			loop: true,
			nav: false,
			dots: true,
			autoplay: true,
			autoplayTimeout: 5000,
			smartSpeed: 700,
			animateIn: 'fadeIn',
			animateOut: 'fadeOut'
		});

		portfolioSlides.owlCarousel({
			items: 2,
			margin: 30,
			loop: true,
			nav: true,
			navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
			dots: true,
			autoplay: false,
			autoplayTimeout: 5000,
			smartSpeed: 700,
			center: true
		});
	}

	// :: 5.0 Masonary Gallery Active Code
	if ($.fn.imagesLoaded) {
		$('.alazea-portfolio').imagesLoaded(function() {
			// filter items on button click
			$('.portfolio-filter').on('click', 'button', function() {
				var filterValue = $(this).attr('data-filter');
				$grid.isotope({
					filter: filterValue
				});
			});
			// init Isotope
			var $grid = $('.alazea-portfolio').isotope({
				itemSelector: '.single_portfolio_item',
				percentPosition: true,
				masonry: {
					columnWidth: '.single_portfolio_item'
				}
			});
		});
	}

	// :: 6.0 magnificPopup Active Code
	if ($.fn.magnificPopup) {
		$('.portfolio-img, .product-img').magnificPopup({
			gallery: {
				enabled: true
			},
			type: 'image'
		});
		$('.video-icon').magnificPopup({
			type: 'iframe'
		});
	}

	// :: 7.0 Barfiller Active Code
	if ($.fn.barfiller) {
		$('#bar1').barfiller({
			tooltip: true,
			duration: 1000,
			barColor: '#22a7f0',
			animateOnResize: true
		});
		$('#bar2').barfiller({
			tooltip: true,
			duration: 1000,
			barColor: '#22a7f0',
			animateOnResize: true
		});
		$('#bar3').barfiller({
			tooltip: true,
			duration: 1000,
			barColor: '#22a7f0',
			animateOnResize: true
		});
		$('#bar4').barfiller({
			tooltip: true,
			duration: 1000,
			barColor: '#22a7f0',
			animateOnResize: true
		});
	}

	// :: 8.0 ScrollUp Active Code
	if ($.fn.scrollUp) {
		browserWindow.scrollUp({
			scrollSpeed: 1500,
			scrollText: '<i class="fa fa-angle-up"></i>'
		});
	}

	// :: 9.0 CounterUp Active Code
	if ($.fn.counterUp) {
		$('.counter').counterUp({
			delay: 10,
			time: 2000
		});
	}

	// :: 10.0 Sticky Active Code
	if ($.fn.sticky) {
		$(".alazea-main-menu").sticky({
			topSpacing: 0
		});
	}

	// :: 11.0 Tooltip Active Code
	if ($.fn.tooltip) {
		$('[data-toggle="tooltip"]').tooltip()
	}

	// :: 12.0 Price Range Active Code
	$('.slider-range-price').each(function() {
		var min = jQuery(this).data('min');
		var max = jQuery(this).data('max');
		var unit = jQuery(this).data('unit');
		var value_min = jQuery(this).data('value-min');
		var value_max = jQuery(this).data('value-max');
		var label_result = jQuery(this).data('label-result');
		var t = $(this);
		$(this).slider({
			range: true,
			min: min,
			max: max,
			values: [value_min, value_max],
			slide: function(event, ui) {
				var result = label_result + " " + unit + ui.values[0] + ' - ' + unit + ui.values[1];
				console.log(t);
				t.closest('.slider-range').find('.range-price').html(result);
			}
		});
	})

	// :: 13.0 prevent default a click
	$('a[href="#"]').on('click', function($) {
		$.preventDefault();
	});

	// :: 14.0 wow Active Code
	if (browserWindow.width() > 767) {
		new WOW().init();
	}

});

// My Settings
$(document).ready(function() {
	var diskon = 0;
	var diskon_type = 'umum';
	var diskon_count_increase = 0;
	var diskon_amount_increment = 0;
	var diskon_amount_increment_max = 0;
	$('form input:not([type="submit"])').keydown(function (e) {
		if (e.keyCode == 13) {
			var inputs = $(this).parents("form").eq(0).find(":input");
			if (inputs[inputs.index(this) + 1] != null) {
				inputs[inputs.index(this) + 1].focus();
			}
			e.preventDefault();
			return false;
		}
	});

	$('#modal_chart_add').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget);
		var id = button.data('id');
		var proses = button.data('act');
		var modal = $(this);
		// console.log(proses);

		diskon_type = 'umum';
		diskon_count_increase = 0;
		diskon_amount_increment = 0;
		diskon_amount_increment_max = 0;

		if (proses === "cart_add") {
			modal.find(".modal-body form#item").attr("action", "?content=keranjang_proses&proses=add");
		} else if (proses === "order_item") {
			modal.find(".modal-body form#item").attr("action", "?content=keranjang_proses&proses=add&go=transaksi_form");
		} else {
		}
		// Clear form
		modal.find('.modal-body input#id_telur').val("");
		modal.find('.modal-body input#nama_telur').val("");
		modal.find('.modal-body input#harga_jual').val("");
		modal.find('.modal-body input#kuantitas').val("1");
		modal.find('.modal-body input#jumlah_harga').val("");

		// Input Data in form
		modal.find('.modal-body input#id_telur').val(id);
		$.ajax({
			type: "GET",
			url: "functions/function_responds.php?content=modal_cart_barang",
			data: {
				id: id,
				data: "nama_telur"
			},
			dataType: "html",
			success: function(response) {
				// console.log(response);
				modal.find('.modal-body input#nama_telur').val(response);
			}
		});
		$.ajax({
			type: "GET",
			url: "functions/function_responds.php?content=modal_cart_barang",
			data: {
				id: id,
				data: "harga_jual"
			},
			dataType: "html",
			success: function(response) {
				// console.log(response);
				modal.find('.modal-body input#harga_jual').val(parseInt(response));
				modal.find('.modal-body input#jumlah_harga').val(parseInt(response));
			}
		});
		$.ajax({
			type: "GET",
			url: "functions/function_responds.php?content=modal_cart_barang",
			data: {
				id: id,
				data: "persediaan"
			},
			dataType: "html",
			success: function(response) {
				// console.log(response);
				modal.find('.modal-body input#kuantitas').attr("max", parseInt(response));
			}
		});
		$.ajax({
			type: "GET",
			url: "functions/function_responds.php?content=get_diskon_barang_all",
			data: { id: id, },
			dataType: "html",
			success: function (response) {
				//modal.find('.modal-body input#kuantitas').attr("max", parseInt(response));
				var result = JSON.parse(response);
				diskon = result.diskon;
				diskon_type = result.diskon_type;
				diskon_count_increase = result.diskon_count_increase;
				diskon_amount_increment = result.diskon_amount_increment;
				diskon_amount_increment_max = result.diskon_amount_increment_max;
			}
		});
		// modal.find('.modal-title').text('New message to ' + recipient);
	});

	$('#modal_chart_update_item').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var id = button.data('id_telur');
		var nama = button.data('nama_telur');
		var harga = button.data('harga_jual');
		var kuantitas = button.data('kuantitas');
		var maxKuantitas = button.data('maxkuantitas');
		var jumlahHarga = button.data('jh');
		// console.log(parseInt(button.data('jh')));
		var proses = button.data('act');
		var modal = $(this);
		console.log(proses);
		if (proses === "cart_add") {
			modal.find(".modal-body form#item").attr("action", "?content=keranjang_proses&proses=add");
		} else if (proses === "order_item") {
			modal.find(".modal-body form#item").attr("action", "?content=keranjang_proses&proses=add&go=transaksi_form");
		} else {
			modal.find(".modal-body form#item").attr("action", "?content=keranjang_proses&proses=cart_update_item");
		}

		diskon_type = 'umum';
		diskon_count_increase = 0;
		diskon_amount_increment = 0;
		diskon_amount_increment_max = 0;

		$.ajax({
			type: "GET",
			url: "functions/function_responds.php?content=get_diskon_barang_all",
			data: { id: id, },
			dataType: "html",
			success: function (response) {
				//modal.find('.modal-body input#kuantitas').attr("max", parseInt(response));
				var result = JSON.parse(response);
				diskon = result.diskon;
				diskon_type = result.diskon_type;
				diskon_count_increase = result.diskon_count_increase;
				diskon_amount_increment = result.diskon_amount_increment;
				diskon_amount_increment_max = result.diskon_amount_increment_max;
			}
		});

		modal.find('.modal-body input#id_telur').val(id);
		modal.find('.modal-body input#nama_telur').val(nama);
		modal.find('.modal-body input#harga_jual').val(parseInt(harga));
		modal.find('.modal-body input#kuantitas').val(parseInt(kuantitas));
		modal.find('.modal-body input#kuantitas').attr("max", parseInt(maxKuantitas));
		modal.find('.modal-body input#jumlah_harga').val(parseInt(jumlahHarga));

	});

	$('body').on('change click', 'input#kuantitas', function(event) {
		var harga = parseInt($('input#harga_jual').val());
		var kuantitas = parseInt($(this).val());
		var jumlah_harga = 0;

		if (diskon_type === 'tambahan') {
			for (var i = 1; i <= kuantitas; i++) {
				if (dis % 2 == 0) {
					console.log('i', i);
				}
			}
			//harga = (kuantitas) ? 0 : 0 ;
		}
		jumlah_harga = kuantitas * harga;

		$('input#jumlah_harga').val(parseInt(jumlah_harga));
	});

	$('#tanggal, #tanggal_pesan, #tanggal_kerja, #tanggal_awal, #tanggal_akhir, #tanggal_pengantaran').Zebra_DatePicker();

	$('input#tanggal').Zebra_DatePicker({
		onOpen: function() {
			var dateRaw = new Date();
			var dateNow = new Date(dateRaw.getFullYear(), dateRaw.getMonth(), dateRaw.getDate(), dateRaw.getHours(), dateRaw.getMinutes(), 0, 0);
			$(this).data('Zebra_DatePicker').set_date(dateNow);
		}
	});

	$('body').on('change load', 'input#diantarkan', function() {
		if ($(this).is(":checked")) {
			$('div#form-pengantaran').show(250);
			akumulasiHargaPengantaran("+");
		} else {
			$('div#form-pengantaran').hide(250);
			akumulasiHargaPengantaran("-");
		}
	});

	if ($('input#diantarkan').is(":checked")) {
		$('div#form-pengantaran').show(250);
		akumulasiHargaPengantaran("+");
	}

	$('body').on('change load', 'input#syarat_ketentuan', function() {
		if ($(this).is(":checked")) {
			$('#modal_syarat_ketentuan').modal('show');
		}
		// else {
		//     $('div#form-lanjutan').hide(250);
		//     // akumulasiHargaPengantaran("-");
		// }
	});

	if ($('input#syarat_ketentuan').is(":checked")) {
		$('#modal_syarat_ketentuan').modal('show');
	}

});