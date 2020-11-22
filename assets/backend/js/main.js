$.noConflict();

jQuery(document).ready(function($) {

	"use strict";

	[].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {
		new SelectFx(el);
	} );

	jQuery('.selectpicker').selectpicker;


	$('#menuToggle').on('click', function(event) {
		$('body').toggleClass('open');
	});

	$('.search-trigger').on('click', function(event) {
		event.preventDefault();
		event.stopPropagation();
		$('.search-trigger').parent('.header-left').addClass('open');
	});

	$('.search-close').on('click', function(event) {
		event.preventDefault();
		event.stopPropagation();
		$('.search-trigger').parent('.header-left').removeClass('open');
	});

	// $('.user-area> a').on('click', function(event) {
	// 	event.preventDefault();
	// 	event.stopPropagation();
	// 	$('.user-menu').parent().removeClass('open');
	// 	$('.user-menu').parent().toggleClass('open');
	// });

	// window.setTimeout(function () {
		$('input#tanggal, input#tanggal_pesan, input#tanggal_transaksi, input#tanggal_kerja, input#tanggal_awal, input#tanggal_akhir, #tanggal_awal_diskon, #tanggal_akhir_diskon').Zebra_DatePicker();
	// }, 100);
	$('#tanggal_awal_diskon, #tanggal_akhir_diskon').Zebra_DatePicker({
		// default_position: 'below',
		// show_icon: false,
		// icon_margin: true,
		// icon_position: 'left',
		// open_icon_only: true,
		// inside: false
	});

	var idTelur = 0;

	$('body').on('click', 'button#btn_discount_item', function(event) {
		event.preventDefault();
		var id = $(this).data('id');
		idTelur = id;
		var discount = 0;
		var totalHarga = 0;
		var tglAwal = null;
		var tglAkhir = null;

		// Ubah nilai dari atribut form 'form_discount_item'
		$('form#form_discount_item').attr('action', '?content=data_telur_proses&proses=edit_discount&id=' + id);

		// Persentase Diskon
		$.ajax({
			url: '../functions/function_responds.php?content=get_diskon_barang',
			type: 'POST',
			dataType: 'html',
			data: {
				id: id,
				filter: 'diskon'
			},
		}).done(function(data) { $('input#percent').val(parseInt(data)); discount = parseInt(data); });

		// Total Harga
		$.ajax({
			url: '../functions/function_responds.php?content=get_diskon_barang',
			type: 'POST',
			dataType: 'html',
			data: {
				id: id,
				filter: 'harga_jual'
			},
		}).done(function(data) {
			$('input#total_harga').val(parseInt(updateTotalHargaFromDiscount(data, discount)));
			// console.log('data : ' + data);
			// console.log('discount : ' + discount);
		});

		// Tanggal Awal Diskon
		$.ajax({
			url: '../functions/function_responds.php?content=get_diskon_barang',
			type: 'POST',
			dataType: 'html',
			data: {
				id: id,
				filter: 'tgl_awal_diskon'
			},
		}).done(function(data) { $('input#tanggal_awal_diskon').val(data); });

		// Tanggal Akhir Diskon
		$.ajax({
			url: '../functions/function_responds.php?content=get_diskon_barang',
			type: 'POST',
			dataType: 'html',
			data: {
				id: id,
				filter: 'tgl_akhir_diskon'
			},
		}).done(function(data) { $('input#tanggal_akhir_diskon').val(data); });
	});

	$('body').on('click keypress', 'input#percent', function(event) {
		event.preventDefault();
		var discount = $(this).val();
		var totalHarga = 0;
		$.ajax('../functions/function_responds.php?content=get_diskon_barang', {
			type: 'POST',
			dataType: 'html',
			data: {
				id: idTelur,
				filter: 'harga_jual'
			},
		}).done(function(data) {
			totalHarga = parseInt(updateTotalHargaFromDiscount(data, discount));
			$('input#total_harga').val(totalHarga);
			// console.log("success");
			// console.log('data : ' + data);
			// console.log('discount : ' + discount);
		}).fail(function() { console.log("error"); });
	});

	$('#modal_form_biaya_kerusakan').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget);
		var id_biaya_kerusakan = button.data('id_biaya_kerusakan');
		var id_transaksi = button.data('id_transaksi');
		var action = button.data('action');
		var modal = $(this);
		if (action == 'ubah') {
			// Get ID Biaya Tambahan
			modal.find('input#id_biaya_kerusakan').val(id_biaya_kerusakan);
			// Get Keterangan
			$.ajax({
				url: '../functions/function_responds.php?content=get_data_biaya_kerusakan',
				type: 'POST',
				dataType: 'html',
				data: {
					id_biaya_kerusakan: id_biaya_kerusakan,
					id_transaksi: id_transaksi,
					filter: 'keterangan'
				},
			}).done(function(data) {
				modal.find('input#keterangan').val(data);
				// console.log("Success Keterangan.");
			}).fail(function() {
				// console.log("Error Keterangan.");
			});
			// Get Jumlah
			$.ajax({
				url: '../functions/function_responds.php?content=get_data_biaya_kerusakan',
				type: 'POST',
				dataType: 'html',
				data: {
					id_biaya_kerusakan: id_biaya_kerusakan,
					id_transaksi: id_transaksi,
					filter: 'jumlah'
				},
			}).done(function(data) {
				modal.find('input#jumlah').val(parseInt(data));
				// console.log("Success Jumlah.");
			}).fail(function() {
				// console.log("Error Jumlah.");
			});
			modal.find('form#form_biaya_kerusakan').attr("action", "?content=data_transaksi_persetujuan_proses&proses=edit_biaya_kerusakan");
			modal.find('input#id_transaksi').val(parseInt(id_transaksi));
		} else {
			modal.find('input#id_biaya_kerusakan').val('');
			modal.find('input#keterangan').val('');
			modal.find('input#jumlah').val('');
			modal.find('form#form_biaya_kerusakan').attr("action", "?content=data_transaksi_persetujuan_proses&proses=add_damage_cost");
			modal.find('input#id_transaksi').val(parseInt(id_transaksi));
		}
	});

	$('#modal_form_damage_cost').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget);
		var id_array = button.data('id_array');
		var id_transaksi = button.data('id_transaksi');
		var action = button.data('action');
		var modal = $(this);
		if (action == 'ubah') {
			// Get ID Biaya Tambahan
			modal.find('input#id_transaksi').val(id_transaksi);
			modal.find('input#id_array').val(id_array);
			// Get Keterangan
			$.ajax({
				url: '../functions/function_responds.php?content=get_data_damage_cost',
				type: 'POST',
				dataType: 'html',
				data: {
					id_array: id_array,
					id_transaksi: id_transaksi,
					filter: 'keterangan'
				},
			}).done(function(data) {
				modal.find('input#keterangan').val(data);
				// console.log("Success Keterangan.");
			}).fail(function() {
				// console.log("Error Keterangan.");
			});
			// Get Jumlah
			$.ajax({
				url: '../functions/function_responds.php?content=get_data_damage_cost',
				type: 'POST',
				dataType: 'html',
				data: {
					id_array: id_array,
					id_transaksi: id_transaksi,
					filter: 'jumlah'
				},
			}).done(function(data) {
				modal.find('input#jumlah').val(parseInt(data));
				// console.log("Success Jumlah.");
			}).fail(function() {
				// console.log("Error Jumlah.");
			});
			modal.find('form#form_biaya_kerusakan').attr("action", "?content=data_transaksi_persetujuan_proses&proses=edit_damage_cost&id_transaksi=" + id_transaksi);
		} else {
			modal.find('input#id_biaya_kerusakan').val('');
			modal.find('input#keterangan').val('');
			modal.find('input#jumlah').val('');
			modal.find('form#form_biaya_kerusakan').attr("action", "?content=data_transaksi_persetujuan_proses&proses=add_damage_cost&id_transaksi=" + id_transaksi);
		}
	});

});

function updateTotalHargaFromDiscount(totalHarga, discount) {
	var totalHarga = (totalHarga) ? parseInt(totalHarga) : 0 ;
	var discount = (totalHarga) ? parseInt(discount) : 0 ;
	var result = 0;
	if (totalHarga > 0 && discount > 0) {
		result = (totalHarga * discount) / 100;
	}
	return result;
}