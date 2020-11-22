<?php 
	require_once 'load_files.php';
	// print_r($_SESSION);
?>

<!DOCTYPE html>
<html>
	<head>

		<!-- Title -->
		<title>APT | Website</title>

		<!-- deklarasi pemanggilan file-file css  -->
		<meta charset="UTF-8">
		<meta name="description" content="Jasa service dan maintenance komputer Makassar...">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="author" content="PT. Fortinusa">

		<!-- Favicon -->
		<link rel="icon" href="assets/img/fortinusa.ico">

		<!-- Core Stylesheet -->
		<link rel="stylesheet" href="assets/frontend/style.css">

		<!-- Zebra Datepicker CSS -->
		<link rel="stylesheet" type="text/css" href="assets/lib/zebra-datepicker/zebra_datepicker.min.css"/>

		<!-- Sweetalert2 CSS -->
		<link rel="stylesheet" type="text/css" href="assets/lib/sweetalert2/css/sweetalert2.min.css"/>

		<link rel="stylesheet" type="text/css" href="assets/css/photoswipe.css"/>
		<link rel="stylesheet" type="text/css" href="assets/css/default-skin/default-skin.css"/>
	 </head>
	 <body>

	 	<!-- Preloader -->
		<div class="preloader d-flex align-items-center justify-content-center">
			<div class="preloader-circle"></div>
			<div class="preloader-img">
				<img src="assets/frontend/img/core-img/leaf.png" alt="">
			</div>
		</div>

	 	<?php include_once 'header.php'; ?>

	 	<?php include 'content.php'; ?>

	 	<?php include_once 'footer.php'; ?>

	 	<!-- deklarasi pemanggilan file-file JS -->

		<!-- jQuery-2.2.4 js -->
		<script src="assets/frontend/js/jquery/jquery-2.2.4.min.js"></script>

		<!-- All Plugins js -->
		<script src="assets/frontend/js/plugins/plugins.js"></script>
		<!-- Active js -->
		<script src="assets/frontend/js/active.js"></script>

		<!-- <script src="assets/lib/jquery/jquery-3.2.1.min.js"></script> -->
		<script src="assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!-- Zebra Datepicker JavaScript -->
		<script src="assets/lib/zebra-datepicker/zebra_datepicker.min.js"></script>

		<!-- Sweetalert2 JavaScript -->
		<script src="assets/lib/sweetalert2/js/sweetalert2.all.min.js"></script>

		<script src="assets/js/photoswipe.min.js"></script>
		<script src="assets/js/photoswipe-ui-default.min.js"></script>

		<!-- <script src="assets/frontend/js/main.js"></script> -->

		<script type="text/javascript">
			$('body').on('click', '#image_gallery', function(event) {
				// event.preventDefault();
				var pswpElement = document.querySelectorAll('.pswp')[0];

				var items = [];

				$(this).each(function() {
					items.push({
						src: $(this).attr('src'),
						w: 600,
						h: 600
					});
				});

				// define options (if needed)
				var options = {
					// history & focus options are disabled on CodePen
					history: false,
					focus: true,

					// getDoubleTapZoom: function(isMouseClick, item) {
					//     // isMouseClick          - true if mouse, false if double-tap
					//     // item                  - slide object that is zoomed, usually current
					//     // item.initialZoomLevel - initial scale ratio of image
					//     //                         e.g. if viewport is 700px and image is 1400px,
					//     //                              initialZoomLevel will be 0.5

					//     if(isMouseClick) {

					//         // is mouse click on image or zoom icon

					//         // zoom to original
					//         return 1;

					//         // e.g. for 1400px image:
					//         // 0.5 - zooms to 700px
					//         // 2   - zooms to 2800px

					//     } else {

					//         // is double-tap

					//         // zoom to original if initial zoom is less than 0.7x,
					//         // otherwise to 1.5x, to make sure that double-tap gesture always zooms image
					//         return item.initialZoomLevel < 0.7 ? 1 : 1.5;
					//     }
					// },

					showHideOpacity: true,
					bgOpacity: 1,
					showAnimationDuration: 500,
					hideAnimationDuration: 500

				};

				var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);

				gallery.init();
			});

			function confirm(message, url, id) {
				event.preventDefault();
				var msg = "";
				var id = id ? id : null;
				if (id !== null) {
					msg = "Apakah anda yakin ingin ";
					if (message == 'hapus') {
						msg += "menghapus data dengan ID " + id + "..?";
					} else if (message == 'selesai') {
						msg += "menyelesaikan data dengan ID : " + id;
					} else if (message == 'batal') {
						msg += "membatalkan data dengan ID : " + id;
					} else {
						msg += message + " data dengan ID : " + id;
					}
				} else {
					msg = message;
				}
				Swal.fire({
					title: 'Peringatan!',
					text: msg,
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					confirmButtonText: 'Ya',
					cancelButtonColor: '#d33',
					cancelButtonText: 'Batal'
				}).then((result) => {
					if (result.value) {
						window.location.replace(url);
						// $.ajax({
						//     method: "GET",
						//     url: url,
						//     data: {
						//         name: "John",
						//         location: "Boston"
						//     }
						// }).done(function( msg ) {
						//     alert( "Data Saved: " + msg );
						// });
					}
				});
			}
		</script>

	 </body>
</html>