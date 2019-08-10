<?php

$mysql_host	= 'mysql1.000webhost.com';
$mysql_user = 'a7689700_sm';
$mysql_pass	= 'azza1234';
$mysql_db	= 'a7689700_sm';

$site_home	= 'http://sm.net63.net/';
$time_zone 	= 'Asia/Jakarta';

$connection = mysql_connect( $mysql_host,$mysql_user,$mysql_pass ) or die('Maaf koneksi keserver gagal');
if( $connection )
mysql_select_db( $mysql_db ) or die('Maaf database tidak ditemukan');