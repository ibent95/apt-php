<?php 
	$content = (isset($_GET['content'])) ? $_GET['content'] : 'beranda' ;

	if (file_exists('contents/' . $content . '.php')) {
		include 'contents/' . $content . '.php' ;
	} else {
		include 'contents/404.php';
	}

    if ($content == "data_transaksi_persetujuan_form") {
        include "contents/components/modal_form_biaya_kerusakan.php";
        include "contents/components/modal_form_damage_cost.php";
    }
	
 ?>