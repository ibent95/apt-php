<?php

	/**
	* Inisialisasi Nilai bertipe Static
	*/
	class class_static_value {

		public static $record_count 	= 10;
		public static $URL_BASE 		= "http://localhost/apt";
		public static $HOSTNAME 		= "http://localhost/apt";
		public static $DB_HOSTNAME		= "127.0.0.1";
		public static $DB_USERNAME		= "root";
		public static $DB_PASSWORD		= "";
		public static $DB_NAME 			= "db_apt";

		function __construct() {
			define("record_count", self::$record_count);
			define("URL_BASE", self::$URL_BASE);
			define("HOSTNAME", self::$HOSTNAME);
			define("DB_HOSTNAME", self::$DB_HOSTNAME);
			define("DB_USERNAME", self::$DB_USERNAME);
			define("DB_PASSWORD", self::$DB_PASSWORD);
			define("DB_NAME", self::$DB_NAME);
		}

		function setRecordCount($record_count) {
			self::$record_count = $record_count;
		}

		function getRecordCount() {
			return self::$record_count;
		}
	}

	class item {
		var $id;
		var $nama_barang;
		var $harga;
		var $kuantitas;
		var $jumlah_harga;
	}
?>
