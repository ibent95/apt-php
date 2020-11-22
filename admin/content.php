<?php 
	$content = (isset($_GET['content'])) ? $_GET['content'] : 'beranda' ;

	if (file_exists('contents/' . $content . '.php')) {
		include 'contents/' . $content . '.php' ;
	} else {
		include 'contents/404.php';
	}
	
 ?>