<?php
error_reporting(0);

include "../config.php";
include "functions.php";

global $site_home;

$f 		= new Log;
$api 	= $_GET['api'];
$set 	= $_GET['set'];
$id		= $_GET['id'];

if(isset($api) && $api != '') {

$response = array("api" => $api, "success" => 0, "error" => 0);

if($api == 'login'){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$user = $f->getUserById($username, $password);
	if ($user != false) {
        $response["success"] = 1;
        $response["user_id"] = $user["user_id"];
        $response["info"]["user_be_id"] = $user["user_be_id"];
        $response["info"]["nama_pengguna"] = $user["nama_pengguna"];
        $response["info"]["email"] = $user["email"];
        $response["info"]["jabatan"] = $user["jabatan"];
        $response["info"]["nama_user"] = $user["nama_user"];
        $response["info"]["jenis_kelamin"] = $user["jenis_kelamin"];
        $response["info"]["alamat"] = $user["alamat"];
        $response["info"]["no_telp"] = $user["no_telp"];
        $response["info"]["area"] = $user["area"];
        $response["info"]["gambar"] = $user["gambar"];
        $response["info"]["status_account"] = $user["status_account"];
        echo json_encode($response);
	}else{
		$response["error"] = 1;
        $response["error_msg"] = "Incorrect email or password!";
        echo json_encode($response);
	}
}elseif($api == 'notif'){
	
	if($set == 'detail') $notif = $f->getNotifDetail($id);	
	else $notif = $f->getNotif();	
	
	if($notif != false){
    	$response["success"] = 1;
		foreach($notif as $kn => $kv){
			$notif_content[] = array('icon' => $kv['icon'], 'message' => $kv['message'], 'mid' => $kv['mid']);
		}
		$response["content_msg"] = $notif_content;
		echo json_encode($response);
	}else{
		$response["error"] = 1;
        $response["error_msg"] = "Not Found Notif!";
        echo json_encode($response);
	}
	
}elseif($api == 'info'){
	if($set == 'home'){
	$html = '
	<!DOCTYPE html>
	<head>
	<link rel="stylesheet" href="'.$site_home.'m/css/style.css" type="text/css" />
	<head>
	<body>
	<div class="main-content">
	<table width="100%" border="0" cellspacing="0" cellpadding="1">
	  <tbody>
	  <tr>
		<td colspan="2" align="left" valign="top"><p>Silahkan gunakan aplikasi ini untuk mengontrol data keluar maupun masuk sales dari masing masing branch.<br> Aplikasi ini bertujuan mempermudah pekerjaan dan meminimalisir kebocoran, baik yang disebabkan oleh banyaknya data yang harus diolah secara manual</p>
		</td>
	  </tr>
	  <tr>
		<td width="10%" align="left" valign="top"><img class="icon-front" src="'.$site_home.'ui/home/images/icon-graphic-traffic.png" width="47" height="47" alt="graphic traffic"></td>
		<td width="90%" align="left" valign="top">
		  <p><strong>Traffic Graphic</strong></p>
		<p>Mengetahui berapa besar data penjualan yang masuk maupun yang keluar dengan point ini akan membuat kinerja anda semakin baik dan anda tidak terlalu disibukkan dengan penumpukan data yang terjadi setiap kali penjualan itu terjadi.</p></td>
	  </tr>
	  <tr>
		<td width="10%" align="left" valign="top"><img class="icon-front" src="'.$site_home.'ui/home/images/icon-dollar.png" width="47" height="47" alt="dollar"></td>
		<td width="90%" align="left" valign="top">
		  <p><strong>Income Dollars</strong></p>
		<p>Mengetahui besarnya pemasukkan dan pengeluaran yang harus dibebankan, baik untuk instalasi, repair, recovery dan lain lain.</p></td>
	  </tr>
	  <tr>
		<td align="left" valign="top"><img class="icon-front" src="'.$site_home.'ui/home/images/icon-market.png" width="47" height="47" alt="market"></td>
		<td width="90%" align="left" valign="top">
		  <p><strong>Stock Market</strong></p>
		<p>Mengontrol persediaan barang/produk baik yang ada di pasar maupun yang ada digudang, dengan sistem ini memudahkan anda untuk menyediakan stok produk agar selalu ready untuk dipasarkan apabila stok reatailer sudah habis.</p></td>
	  </tr>
	</tbody></table>
	</div>
	</body>
	</html>';
	echo $html;		
		
	}elseif($set == 'what'){
		
	$html = '
	<!DOCTYPE html>
	<head>
	<link rel="stylesheet" href="'.$site_home.'m/css/style.css" type="text/css" />
	<head>
	<body>
	<div class="main-content">
	  <p>Ini adalah sebuah aplikasi monitoring sales data, yang diperuntukkan untuk memonitoring data penjualan sales yang terjadi.</p>
	  <p><strong>Tujuan pembuatan</strong></p>
	  <p><ol>
		<li>Meminimalisir kebocoran data</li>
		<li>Mempermudah pengorganisir</li>
		<li>Mempercepat proses penjualan</li>
		<li>Sebagai program tugas akhir</li>
	  </ol>
	  </p>
	  <p><strong>Versi aplikasi?</strong></p>
	  <p>Versi 1.0, saat ini aplikasi masih dalam tahap pengembangan, jadi masih banyak yang harus diperbaiki disana sini.</p>
	  <p><strong>Pengembang</strong></p>
	  <p>Aplikasi nativ android ini saya ciptakan sendiri dengan memanfaatkan sumber-sumber yang ada di internet</p>
	  <p><strong>Lisensi</strong></p>
	  <p>Semua hak cipta dilindungi dibawah lisensi <a href="http://cmsid.org">cmsid.org</a>, sebuah situs web cms opensource tahun 2012.</p>
	</div>
	</body>
	</html>';
	echo $html;		
		
	}else{
		echo "Data Request Is Empty";
	}
}else{
	echo "Invalid Request";
}
}else{
	echo "Access Denied";
}