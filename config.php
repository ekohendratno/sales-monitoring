<?php

$mysql_host	= 'localhost';
$mysql_user = 'root';
$mysql_pass	= '';
$mysql_db	= 'private_sales_monitoring';

$site_home	= 'http://localhost/private2/sales-monitoring/';
$time_zone 	= 'Asia/Jakarta';

$connection = mysql_connect( $mysql_host,$mysql_user,$mysql_pass ) or die('Maaf koneksi keserver gagal');
if( $connection )
mysql_select_db( $mysql_db ) or die('Maaf database tidak ditemukan');