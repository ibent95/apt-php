<?php 
	$content =  (isset($_GET['content'])) ? $_GET['content'] : 'beranda' ;

	if (file_exists('contents/' . $content . '.php')) {
		include 'contents/' . $content . '.php' ;
	} else {
		include 'contents/404.php';
	}
	
    if ($content == "produk" OR $content == "produk_detail") {
        include "contents/components/modal_cart_add.php";
    }
    
    if ($content == "transaksi" OR $content == "transaksi_form") {
        include "contents/components/modal_cart_edit.php";
    }

    if ($content == "profil") {
        include "contents/components/modal_change_password.php";
        include "contents/components/modal_change_profil_picture.php";
    }
 ?>