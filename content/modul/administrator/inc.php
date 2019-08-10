<?php
if(!defined('_exec')) exit;

function del_member($uid){	
	return mysql_query("DELETE FROM users WHERE `user_id`=$uid");
}

function add_member($data){
	$data = validasi_add_member($data);
	
	if( !is_array($data) )
		return false;
	
	extract($data, EXTR_SKIP);
	
	$nama_pengguna 		= esc_sql( $nama_pengguna );
	$kata_sandi 		= esc_sql( $kata_sandi );
	$email 				= esc_sql( $email );
	
	$nama_user 			= esc_sql( $nick_name );
	if( empty($nama_user) ) $nama_user = $nama_pengguna;
	
	$jenis_kelamin		= esc_sql( $sex );
	$alamat 			= esc_sql( $alamat );
	$no_telp			= esc_sql( $nohp );
	$status_account		= esc_sql( $status );	
	$jabatan			= esc_sql( $jabatan );
	
	$area				= esc_sql( $area );
	
	if( empty($area) && $jabatan != 'be' ) $area = '';

	if(!empty($kata_sandi) )
	$kata_sandi 		= md5( $kata_sandi );
	
	$data = compact('nama_pengguna','kata_sandi','email','jabatan','area','nama_user','jenis_kelamin','alamat','no_telp','status_account');
	insert_member($data);	

}



function validasi_add_member($data){
	extract($data, EXTR_SKIP);
	
	$error = array();
	if( empty($nama_pengguna) ) $error[]= 'Nama Pengguna kosong';
	elseif(!valid_username($nama_pengguna) ) $error[]= 'Nama Pengguna tidak valid';
	elseif( check_username($nama_pengguna) ) $error[]= 'Nama Pengguna sudah digunakan';
	
	if( empty($kata_sandi) || empty($retry_kata_sandi) ) $error[]= 'Kata Sandi Pengguna atau Ulangi Kata Sandi Pengguna kosong';
	elseif($kata_sandi != $retry_kata_sandi) $error[]= 'Kata Sandi Pengguna tidak cocok';
	
	if( empty($email) ) $error[]= 'Email Pengguna kosong';
	elseif(!valid_email($email) ) $error[]= 'Email Pengguna tidak valid';
	
	if( empty($sex) ) $error[]= 'Jenis Kelamin belum dipilih';
	if( empty($jabatan) ) $error[]= 'Jabatan belum dipilih';
	
	if(!empty($area) && $jabatan == 'be' ){
		$cek_area = cheking_member( $area );
		
		if( !$cek_area ) $error[]= 'Area terpakai, silahkan ganti area lain';
	}elseif( empty($area) && $jabatan == 'be' ) $error[]= 'Area kosong';
	
	if( $error ){
		foreach($error as $message) echo '<div id="error"><strong>Error :</strong> '.$message.'</div>';
		return false;
	}else return $data;
}

function insert_member($data){
	$add_query = implode_insert($data);
	
	$query_users = mysql_query("INSERT INTO `users` $add_query");
	
	if($query_users){
		echo '<div id="success"><strong>Success :</strong> Save member berhasil</div><br>';
		echo redirect_html('?q=member&goto=add');
	}
}

function cheking_member($area){
	
	$area = strtolower($area);
	$retval = false;
	
	$sql = mysql_query( "SELECT * FROM `users` WHERE jabatan = 'be' " );
	while( $data = mysql_fetch_object($sql) ){
		if( $area != strtolower($data->area) ) $retval = true;
	}
	
	return $retval;
	
}

function edit_member($data,$uid){
	$data = validasi_edit_member($data);
	
	if( !is_array($data) )
		return false;
	
	extract($data, EXTR_SKIP);
	
	$nama_pengguna 		= esc_sql( $nama_pengguna );
	$email 				= esc_sql( $email );
	$nama_user 			= esc_sql( $nick_name );
	$jenis_kelamin		= esc_sql( $sex );
	$jabatan			= esc_sql( $jabatan );
	$alamat 			= esc_sql( $alamat );
	$no_telp			= esc_sql( $nohp );
	$user_id			= esc_sql( $uid );	
	
	if( $status == 1 ) $status = 1;
	elseif( $status == 2 ) $status = 0;
	
	$status_account		= esc_sql( $status );	
	$area				= esc_sql( $area );
	
	if( empty($area) && $jabatan != 'be' ) $area = '';
	
	$data = compact('nama_pengguna','email','nama_user','jenis_kelamin','jabatan','area','alamat','no_telp','status_account');
	update_member($data,compact('user_id'));	

}

function validasi_edit_member($data){
	extract($data, EXTR_SKIP);
	
	$error = array();
	if( empty($nama_pengguna) ) $error[]= 'Nama Pengguna kosong';
	elseif(!valid_username($nama_pengguna) ) $error[]= 'Nama Pengguna tidak valid';
	
	if( empty($email) ) $error[]= 'Email Pengguna kosong';
	elseif(!valid_email($email) ) $error[]= 'Email Pengguna tidak valid';
	
	if( empty($sex) ) $error[]= 'Jenis Kelamin belum dipilih';
	if( empty($jabatan) ) $error[]= 'Jabatan belum dipilih';
	if( empty($status) ) $error[]= 'Status Pengguna belum dipilih';
	
	if( $error ){
		foreach($error as $message) echo '<div id="error"><strong>Error :</strong> '.$message.'</div>';
		return false;
	}else return $data;
}

function update_member($data, $where){
	extract($where, EXTR_SKIP);
	
	$add_query = implode_update($data,$where);
	
	$query_users = mysql_query("UPDATE `users` $add_query");
	
	if($query_users){
		echo '<div id="success"><strong>Success :</strong> Save member berhasil</div><br>';
		echo redirect_html('?q=member&goto=detail&user_id='.$user_id.'');
	}
	
}

function del_retailer($retailer_id){	
	return mysql_query("DELETE FROM retailer WHERE `id_retailer`=$retailer_id");
}

function add_retailer($data){
	$data = validasi_add_retailer($data);
	
	if( !is_array($data) )
		return false;
	
	extract($data, EXTR_SKIP);
	
	$id_be		 		= esc_sql( $be_id );
	$nama_retailer 		= esc_sql( $name_retiler );
	$alamat_retailer 	= esc_sql( $alamat_retailer );
	$status_retailer	= esc_sql( $status_retailer );	
	
	if( $status_retailer == 1 ) $status_retailer = 1;
	elseif( $status_retailer == 2 ) $status_retailer = 0;
	
	$data = compact('id_be','nama_retailer','alamat_retailer','status_retailer');
	insert_retailer($data);	

}

function validasi_add_retailer($data){
	extract($data, EXTR_SKIP);
	
	$error = array();
	if( empty($name_retiler) ) $error[]= 'Nama Retailer kosong';
	if( empty($alamat_retailer) ) $error[]= 'Alamat Retailer kosong';	
	if( empty($be_id) ) $error[]= 'Businnes Executive belum dipilih';
	if( empty($status_retailer) ) $error[]= 'Status retailer belum dipilih';
	
	if( $error ){
		foreach($error as $message) echo '<div id="error"><strong>Error :</strong> '.$message.'</div>';
		return false;
	}else return $data;
}

function insert_retailer($data){
	$add_query = implode_insert($data);
	
	$query_users = mysql_query("INSERT INTO `retailer` $add_query");
	
	if($query_users){
		echo '<div id="success"><strong>Success :</strong> Save retailer berhasil</div><br>';
		echo redirect_html('?q=retailer');
	}
}

function edit_retailer($data,$uid){
	$data = validasi_add_retailer($data);
	
	if( !is_array($data) )
		return false;
	
	extract($data, EXTR_SKIP);
	
	$id_be		 		= esc_sql( $be_id );
	$nama_retailer 		= esc_sql( $name_retiler );
	$alamat_retailer 	= esc_sql( $alamat_retailer );
	$status_retailer 	= esc_sql( $status_retailer );
	$id_retailer		= esc_sql( $uid );	
	
	if( $status_retailer == 1 ) $status_retailer = 1;
	elseif( $status_retailer == 2 ) $status_retailer = 0;
	
	$data = compact('id_be','nama_retailer','alamat_retailer','status_retailer');
	update_retailer($data,compact('id_retailer'));	

}

function update_retailer($data, $where){
	extract($where, EXTR_SKIP);
	
	$add_query = implode_update($data,$where);
	
	$query_users = mysql_query("UPDATE `retailer` $add_query");
	
	if($query_users){
		echo '<div id="success"><strong>Success :</strong> Save retailer berhasil</div><br>';
		echo redirect_html('?q=retailer');
	}
	
}

function insert_foto_retailer($data){
	extract($data, EXTR_SKIP);
	
	if(!empty($thumb['name'])):
		$thumb	= hash_image( $thumb );
		
		upload_img_post_retailer($thumb);
		
		del_img_post_retailer($gambar);
		$thumb 		= esc_sql($thumb['name']);
	else:
		$thumb		= esc_sql($gambar);
	endif;
		  
	mysql_query("UPDATE `retailer` SET `gambar_retailer` = '$thumb' WHERE `id_retailer` = $retailer_id");
	echo redirect_html('?q=retailer&goto=detail&retailer_id='.$retailer_id);
}

function upload_img_post_retailer($thumb){	
	
		$image_allaw	= array(
		'image/png' 		=> '.png',
		'image/x-png' 		=> '.png',
		'image/gif' 		=> '.gif',
		'image/jpeg' 		=> '.jpg',
		'image/pjpeg' 		=> '.jpg');

		if(!empty($thumb['name'])):
			
		$myfile 	 = $thumb; //image name
		$uploadDir 	 = abs_path . 'content/uploads/retailer/'; //directory upload file
			
		if ( in_array($thumb['type'], array_keys($image_allaw)) ):
			
		$path 	 = $uploadDir.$thumb['name']; // dir & name path image for upload
		$type 	 = $image_allaw[$thumb['type']]; //type image is allow
		$resize  = 260; // size for resize image
		$quality = 120; // quality 120%
			
		$data_resize = compact('path','type','resize','quality');
		
		//resize if file is image allaw function
		uploader( compact('myfile','uploadDir') );
		resize_image($data_resize, true);
		
		endif;
		endif;
}

function del_img_post_retailer($file){
		
	$path = abs_path . 'content/uploads/retailer/';
	if( !empty($file) && file_exists($path.$file) )
		unlink( $path . $file );
}
