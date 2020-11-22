<?php
	
	// // Kategori
	// function getKategoriAll($order = 'DESC') {
	// 	global $koneksi;
	// 	$data = mysqli_query($koneksi, "SELECT * FROM `data_kategori` ORDER BY `id_kategori` $order") or die($koneksi);
	// 	return $data;
	// }

	// function getKategoriLimitAll($page, $recordCount = 12) {
	// 	global $koneksi;
	// 	$limit = ($page * $recordCount) - $recordCount;
	// 	$offset= $recordCount;
	// 	$data = mysqli_query($koneksi, "SELECT * FROM `data_kategori` ORDER BY `id_kategori` DESC LIMIT $limit, $offset") or die($koneksi);
	// 	return $data;
	// }

	// function getKategoriById($id) {
	// 	global $koneksi;
	// 	$data = mysqli_query($koneksi, "SELECT * FROM `data_kategori` WHERE `id_kategori` = '$id'") or die($koneksi);
	// 	return $data;
	// }

	// Telur
	function getTelurAll($idKategori = NULL, $order = 'DESC') {
		global $koneksi;
		$sql = "SELECT * FROM `data_telur` ";
		if ($idKategori != NULL) {
			$sql .= "WHERE `id_kategori` = '$idKategori' ";
		}
		$sql .= "ORDER BY `id_telur` $order";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getTelurLimitAll($idKategori = NULL, $page = 1, $recordCount = 12, $order = 'DESC') {
		global $koneksi;
		$limit 	= ($page * $recordCount) - $recordCount;
		$offset	= $recordCount;
		$sql = "SELECT * FROM `data_telur` ";
		if ($idKategori != NULL) {
			$sql .= "WHERE `id_kategori` = '$idKategori' ";
		}
		$sql .= "ORDER BY `id_telur` $order LIMIT $limit, $offset";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getTelurJoinKategoriLimitAll($idKategori = NULL, $page = 1, $recordCount = 12, $order = 'DESC') {
		global $koneksi;
		$limit 	= ($page * $recordCount) - $recordCount;
		$offset	= $recordCount;
		$sql = "SELECT * FROM `data_telur` INNER JOIN `data_kategori` ON data_telur.id_kategori = data_kategori.id_kategori ";
		if ($idKategori != NULL) {
			$sql .= "WHERE data_telur.id_kategori = '$idKategori' ";
		}
		$sql .= "ORDER BY data_telur.id_telur $order LIMIT $limit, $offset";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getTelurJoinKategoriById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_telur` INNER JOIN `data_kategori` ON data_telur.id_kategori = data_kategori.id_kategori WHERE data_telur.id_telur = '$id'") or die($koneksi);
		return $data;
	}

	function getTelurById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_telur` WHERE `id_telur` = '$id'") or die($koneksi);
		return $data;
	}
	
	function getTelurByIdKategori($id, $order = 'DESC') {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_telur` WHERE `id_kategori` = '$id' ORDER BY `id_telur` $order") or die($koneksi);
		return $data;
	}
	
	function getTelurForKeranjangById($id) {
		global $koneksi;
		$dataArsipAll = mysqli_query($koneksi, "SELECT `id_telur`, `harga` FROM `data_telur` WHERE `id_telur` = '$id' AND `stok` NOT LIKE 0 ");
		return $dataArsipAll;
	}

	// ========================== MODEL ==========================

	// function searchKategoriByKeyWord($keyWord, $order = 'DESC') {
	// 	global $koneksi;
	// 	$sql = "SELECT * FROM `data_kategori` WHERE `id_kategori` LIKE '$keyWord%' OR `nama_kategori_telur` LIKE '$keyWord%'";
	// 	$sql .= ($keyWord == '' | $keyWord == NULL | empty($keyWord)) ? "ORDER BY data_kategori.id $order" : "" ;
	// 	$data = mysqli_query($koneksi, $sql) or die('Error, ' . mysqli_error($koneksi));
	// 	return $data;
	// }

	function searchTelurByKeyWord($keyWord, $order = 'DESC') {
		global $koneksi;
		$sql = "SELECT data_telur.id_telur, data_telur.nama_telur, data_kategori.nama_kategori, data_telur.harga FROM `data_telur` INNER JOIN `data_kategori` ON data_telur.id_kategori = data_kategori.id WHERE data_telur.id LIKE '%$keyWord%' OR data_telur.nama_telur LIKE '%$keyWord%' OR data_kategori.nama_kategori LIKE '%$keyWord%' OR data_telur.harga LIKE '%$keyWord%'";
		$sql .= ($keyWord == '' | $keyWord == NULL | empty($keyWord)) ? "ORDER BY data_telur.id_telur $order" : "" ;
		$data = mysqli_query($koneksi, $sql) or die('Error, ' . mysqli_error($koneksi));
		return $data;
	}

	function getSearchTelurAllLimit($kataKunci, $idKategori, $page, $recordCount = 12, $order = "DESC") {
		global $koneksi;
		$perPage = 3;
		$limit = ($page * $recordCount) - $recordCount;
		$offset = $recordCount;
		$cars = mysqli_query($koneksi, "SELECT * FROM `data_telur` INNER JOIN `data_kategori` ON data_telur.id_kategori = data_kategori.id_kategori WHERE (data_telur.nama_telur LIKE '$kataKunci%') AND data_telur.id_kategori LIKE '$idKategori%' ORDER BY data_telur.id_telur $order LIMIT $limit, $offset") or die(mysqli_error($koneksi));
		return $cars;
	}

	function getFilteredTelurAllLimit($idKategori = "", $harga1 = null, $harga2 = null, $harga3 = null, $harga4 = null, $page = 1, $recordCount = 12, $order = "DESC") {
		global $koneksi;
        $limit = ($page * $recordCount) - $recordCount;
		$offset = $recordCount;
		$sql = "SELECT * FROM `data_telur` INNER JOIN `data_kategori` ON data_telur.id_kategori = data_kategori.id_kategori WHERE (data_telur.id_kategori LIKE '%$idKategori') ";
		if ($harga1 != null or $harga2 != null or $harga3 != null or $harga4 != null) {
			$sql .= "AND ( ";
			$sql .= ($harga1 != null) ? "(data_telur.harga BETWEEN '" . explode('-', $harga1)[0] . "' AND '" . explode('-', $harga1)[1] . "000') " : "" ;
			$sql .= ($harga1 != null and $harga2 != null) ? " OR " : "" ;
			$sql .= ($harga2 != null) ? "(data_telur.harga BETWEEN '" . explode('-', $harga2)[0] . "000' AND '" . explode('-', $harga2)[1] . "000')" : "" ;
            $sql .= (($harga1 != null or $harga2 != null) and $harga3 != null) ? " OR " : "" ;
			$sql .= ($harga3 != null) ? "(data_telur.harga BETWEEN '" . explode('-', $harga3)[0] . "000' AND '" . explode('-', $harga3)[1] . "000')" : "" ;
            $sql .= (($harga1 != null or $harga2 != null or $harga3 != null) and $harga4 != null) ? " OR " : "" ;
			$sql .= ($harga4 != null) ? "(data_telur.harga BETWEEN '" . explode('-', $harga4)[0] . "000' AND '" . explode('-', $harga4)[1] . "000')" : "" ;
			$sql .= ") ";
		}
		$sql .= "ORDER BY data_telur.id_telur $order
			LIMIT $limit, $offset";
        $data = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
        return $data;
	}

	function getDiscountPrice($idTelur) {
		global $koneksi;
		$dateNow = date('Y-m-d');
		$sql = "SELECT * FROM `data_telur` WHERE `id_telur` = '$idTelur' AND '$dateNow' >= tgl_awal_diskon AND '$dateNow' <= tgl_akhir_diskon";
		$telur = mysqli_fetch_array(mysqli_query($koneksi, $sql), MYSQLI_BOTH);
		$price = $telur['harga_jual'] - ($telur['harga_jual'] * ($telur['diskon'] / 100)) ;
		return $price;
	}
?>