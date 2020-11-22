<?php
    
    include_once '../functions/class_static_value.php';
    $csv = new class_static_value();

	include_once '../functions/koneksi.php';
	include_once '../functions/function_umum.php';
	include_once '../functions/function_pelanggan.php';
	include_once '../functions/function_barang.php';
	include_once '../functions/function_pemesanan.php';
    
    include_once '../plugins/dompdf/autoload.inc.php';

	$tanggal_awal   = (!empty($_POST['tanggal_awal'])) ? $_POST['tanggal_awal'] : date("Y-m-d") ;
	$tanggal_akhir  = (!empty($_POST['tanggal_akhir'])) ? $_POST['tanggal_akhir'] : date("Y-m-d") ;
	$id_kategori    = (!empty($_POST['id_kategori'])) ? $_POST['id_kategori'] : "" ;
	$id_barang      = (!empty($_POST['id_barang'])) ? $_POST['id_barang'] : "" ;

    $sql = " 
        SELECT * 
        FROM `data_pemesanan` 
        INNER JOIN `data_pemesanan_detail`
        ON data_pemesanan.id = data_pemesanan_detail.id_pemesanan 
        INNER JOIN `data_barang`
        ON data_pemesanan_detail.id_barang = data_barang.id
        INNER JOIN `data_barang_kategori`
        ON data_barang.id_kategori = data_barang_kategori.id 
        WHERE ((data_pemesanan.tanggal >= '$tanggal_awal 00:00:00') AND (data_pemesanan.tanggal <= '$tanggal_akhir 23:59:00'))
        AND (data_barang.id_kategori LIKE '%$id_kategori') 
        AND (data_pemesanan_detail.id_barang LIKE '%$id_barang')
        ORDER BY data_pemesanan.id ASC
    ";

    $pemesananAll = mysqli_query($koneksi, $sql) or die($koneksi);

	$i = 1;

	// reference the Dompdf namespace
	use Dompdf\Dompdf;

	// instantiate and use the dompdf class
	$dompdf = new Dompdf();

	ob_start(); 
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Laporan Transaksi Tanggal <?php echo format(date('Y-m-d'), 'date'); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" media="screen" href="../assets/lib/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="../assets/backend/css/style.css" />
    </head>
    <body>
        <p class="text-dark">
            <h2 class="text-center">Laporan Transaksi Tanggal <?php echo format(date('Y-m-d'), 'date'); ?></h2>
        </p>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>ID Pemesanan</th>
                    <th>Tanggal</th>
                    <th>Nama Pelanggan</th>
                    <th>Total Harga</th>
                    <th>Diantarkan</th>
                    <th>Status Pemesanan</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($pemesanan = mysqli_fetch_array($pemesananAll, MYSQLI_BOTH)) : ?>
                    <tr>
                        <th><?php echo $i; ?></th>
                        <th><?php echo $pemesanan[0]; ?></th>
                        <th><?php echo $pemesanan['tanggal']; ?></th>
                        <th><?php echo $pemesanan[3]; ?></th>
                        <th><?php echo format($pemesanan['total_harga'], 'currency'); ?></th>
                        <th><?php echo setBadges($pemesanan['diantarkan']); ?></th>
                        <th><?php echo setBadges($pemesanan['status_pemesanan']); ?></th>
                    </tr>
                    <?php $i++; ?>
                <?php endwhile ?>
            </tbody>
        </table>
    </body>
</html>

<?php 
	
	$html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
	ob_end_clean();
	
	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper('A4', 'landscape');
	// $dompdf->setPaper(array(0, 0, 550, 300));
	
	$dompdf->loadHtml(utf8_encode($html));
	
	// Render the HTML as PDF
	$dompdf->render();

	// Output the generated PDF to Browser
	$dompdf->stream("Laporan_Transaksi_" . date('Y-m-d') . ".pdf", array("Attachment" => 0));

	// exit(0);
?>