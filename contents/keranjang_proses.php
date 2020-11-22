<?php 
    $proses = $_GET['proses'];
    if ($proses == 'remove') {
            $idTelur 	= antiInjection($_GET['id_telur']);
    } else {
        // if ($proses == 'edit') {
        $idTelur        = (isset($_POST['id_telur'])) ? antiInjection($_POST['id_telur']) : NULL;
        // }
        $nama_telur     = (isset($_POST['nama_telur'])) ? antiInjection($_POST['nama_telur']) : NULL;
        $harga          = (isset($_POST['harga_jual'])) ? antiInjection($_POST['harga_jual']) : NULL;
        $kuantitas      = (isset($_POST['kuantitas'])) ? antiInjection($_POST['kuantitas']) : NULL;
        $jumlah_harga   = (isset($_POST['jumlah_harga'])) ? antiInjection($_POST['jumlah_harga']) : NULL;
    }
    $redirect = (isset($_GET['go'])) ? "?content=" . $_GET['go'] . "&action=tambah" : "?content=transaksi" ;
    switch ($proses) {
        case "add":
            try {
                if (!empty($_POST["kuantitas"])) {
                    $barang = mysqli_fetch_array(getTelurById($idTelur), MYSQLI_BOTH);
                    if ($kuantitas <= $barang['persediaan']) {
                        $itemArray = array(
                            array(
                                'id_telur' 	=> $barang["id_telur"],
                                'nama_telur' 	=> $barang["nama_telur"],
                                'harga_jual' 	=> $barang["harga_jual"],
                                'kuantitas'	=> $kuantitas,
                                'jumlah_harga'	=> $jumlah_harga
                            )
                        );
                        if (!empty($_SESSION["cart"])) {
                            // if (in_array($barang["id_telur"], array_keys($_SESSION["cart"]))) {
                            $res = false;
                            for ($i=0; $i <= end(array_keys($_SESSION["cart"])); $i++) {
                                // echo $k['id_telur'];
                                if ($barang["id_telur"] === $_SESSION["cart"][$i]["id_telur"]) {
                                    if (empty($_SESSION["cart"][$i]["kuantitas"])) {
                                        $_SESSION["cart"][$i]["kuantitas"] = 0;
                                    }
                                    if (empty($_SESSION["cart"][$i]["jumlah_harga"])) {
                                        $_SESSION["cart"][$i]["jumlah_harga"] = 0;
                                    }
                                    $_SESSION["cart"][$i]["kuantitas"] += $_POST["kuantitas"];
                                    $_SESSION["cart"][$i]["jumlah_harga"] += $_POST["jumlah_harga"];
                                    $res = true;
                                }
                            }
                            if ($res == false) {
                                $_SESSION["cart"] = array_merge($_SESSION["cart"], $itemArray);
                            }
                        } else {
                            $_SESSION["cart"] = $itemArray;
                        }
                        $_SESSION['message-type'] = 'success';
                        $_SESSION['message-content'] = 'Data telah masuk dalam keranjang..!';
                    } else {
                        $_SESSION['message-type'] = "danger";
                        $_SESSION['message-content'] = "Maaf, jumlah barang yang anda masukan melebihi persediaan yang ada..!";
                        $redirect = "?content=produk";
                    }
                }
            } catch (Exception $e) {
                $_SESSION['message-type'] = "danger";
                $_SESSION['message-content'] = "Data tidak berhasil ditambahkan";
            }
            // $redirect = "?content=transaksi";
            break;
        case "remove":
            try {
                if (!empty($_SESSION["cart"])) {
                    for ($i=0; $i <= end(array_keys($_SESSION["cart"])); $i++) {
                        // for ($j=0; $j < count($_SESSION["cart"][$i]); $j++) {
                            // if (count($_SESSION["cart"]) == 1) {
                            //     unset($_SESSION["cart"]);
                            // } else {
                                if ($idTelur == $_SESSION["cart"][$i]["id_telur"]) {
                                    unset($_SESSION["cart"][$i]);
                                }
                                if (empty($_SESSION["cart"])) {
                                    unset($_SESSION["cart"]);
                                }
                            // }
                        // }
                    }
                }
                $_SESSION['message-type'] = 'success';
                $_SESSION['message-content'] = 'Data berhasil dihapus..!';
            } catch (Exception $e) {
                $_SESSION['message-type'] = "danger";
                $_SESSION['message-content'] = "Data gagal dihapus";
            }
            // $redirect = "?content=transaksi";
            break;
        case "clear":
            unset($_SESSION["cart"]);
            // $redirect = "?content=transaksi";
            break;
        case "cart_update_item":
            try {
                if (!empty($_SESSION["cart"])) {
                    for ($i=0; $i <= end(array_keys($_SESSION["cart"])); $i++) {
                        // for ($j=0; $j < count($_SESSION["cart"][$i]); $j++) {
                            if ($idTelur == $_SESSION["cart"][$i]["id_telur"]) {
                                // unset($_SESSION["cart"][$i]);
                                $_SESSION["cart"][$i]["kuantitas"] 	= $_POST["kuantitas"];
                                $_SESSION["cart"][$i]["jumlah_harga"] 	= $_POST["jumlah_harga"];
                            }
                            if (empty($_SESSION["cart"])) {
                                unset($_SESSION["cart"]);
                            }
                        // }
                    }
                }
                $_SESSION['message-type'] = 'success';
                $_SESSION['message-content'] = 'Data berhasil diubah..!';
            } catch (Exception $e) {
                $_SESSION['message-type'] = "danger";
                $_SESSION['message-content'] = "Data gagal diubah";
            }
            // $redirect = "?content=transaksi";
            break;
        default:
            # code...
            break;
    }
    echo "<script>window.location.replace('$redirect');</script>";
?>