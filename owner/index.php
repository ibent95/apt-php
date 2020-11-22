<?php 
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	if (!isset($_SESSION['record-count'])) {
		$_SESSION['record-count'] = 10;
	}

	if (!isset($_SESSION['jenis_akun'])) {
		echo "<script> window.location.replace('../login.php'); </script>";
	}

	require_once '../load_files.php';

	cekLogin('owner');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Owner</title>
		<!-- deklarasi pemanggilan file-file css  -->

		<link rel="apple-touch-icon" href="apple-icon.png">
		<link rel="shortcut icon" href="../assets/backend/images/favicon.ico">

		<link rel="stylesheet" href="../assets/lib/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="../assets/lib/icons/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="../assets/lib/icons/themify-icons/themify-icons.css">
		<link rel="stylesheet" href="../assets/lib/icons/flag-icon-css/flag-icon.min.css">
		<link rel="stylesheet" href="../assets/lib/selectFX/css/cs-skin-elastic.css">
		<link rel="stylesheet" href="../assets/lib/zebra-datepicker/zebra_datepicker.min.css">
		<!-- <link rel="stylesheet" href="../assets/lib/jqvmap/dist/jqvmap.min.css"> -->
		<link rel="stylesheet" href="../assets/backend/css/style.css">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
	</head>
	<body>

		<?php include_once 'header.php'; ?>

		<?php include 'content.php'; ?>

		<?php include_once 'footer.php'; ?>

		<!-- deklarasi pemanggilan file-file JS -->


		<script src="../assets/lib/jquery/jquery.min.js"></script>
		<script src="../assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="../assets/lib/zebra-datepicker/zebra_datepicker.min.js"></script>
		<script src="../assets/backend/js/main.js"></script>
<!-- 
		<script src="../assets/lib/chart/chart-js/Chart.bundle.js"></script>
		<script src="../assets/backend/js/dashboard.js"></script>
		<script src="../assets/backend/js/widgets.js"></script>
		<script src="../assets/lib/jqvmap/dist/jquery.vmap.min.js"></script>
		<script src="../assets/lib/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
		<script src="../assets/lib/jqvmap/dist/maps/jquery.vmap.world.js"></script> -->
		<script>
			(function($) {
				"use strict";

				jQuery('#vmap').vectorMap({
					map: 'world_en',
					backgroundColor: null,
					color: '#ffffff',
					hoverOpacity: 0.7,
					selectedColor: '#1de9b6',
					enableZoom: true,
					showTooltip: true,
					values: sample_data,
					scaleColors: ['#1de9b6', '#03a9f5'],
					normalizeFunction: 'polynomial'
				});
			})(jQuery);
		</script>

	</body>
</html>