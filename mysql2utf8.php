<?php
/**SEE LICENSE


/**
 * Check if mysqli is installed
 */
if (!extension_loaded('mysqli')) {
	exit("install mysqli");
}


// define variables
$mysql_db = 'omp_master';
$mysql_password = 'password';
$mysql_user = 'user';
$mysql_host = 'localhost';

$conn = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_db);

/**
 * @param mysqli $conn
 */
function check_connection(mysqli $conn): void {
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
}


/**
 * @param string $mysql_db
 * @param mysqli $conn
 */
function convert_schema(string $mysql_db, mysqli $conn): void {
	$alter_database_charset_sql = "ALTER DATABASE " . $mysql_db . " CHARACTER SET utf8 COLLATE utf8_unicode_ci";
	mysqli_query($conn, $alter_database_charset_sql);
}


/**
 * @param mysqli $conn
 */
function convert_tables(mysqli $conn): void {
	$show_tables_result = mysqli_query($conn, "SHOW TABLES");
	$tables = mysqli_fetch_all($show_tables_result);

	foreach ($tables as $index => $table) {
		$alter_table_sql = "ALTER TABLE " . $table[0] . " CONVERT TO CHARACTER SET utf8  COLLATE utf8_unicode_ci";
		$alter_table_result = mysqli_query($conn, $alter_table_sql);
		var_dump($alter_table_result);

	}
}

/**
 * @param mysqli $conn
 * @param string $mysql_db
 */
function run(mysqli $conn, string $mysql_db): void {
	check_connection($conn);
	convert_schema($mysql_db, $conn);
	convert_tables($conn);
}


