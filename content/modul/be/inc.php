<?php
if(!defined('_exec')) exit;

function add_sales($data){
	$data = validasi_add_sales($data);
	
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
	
	$user_be_id			= getinfo_users('uid');
	$jabatan			= 'sales';
	
	$kata_sandi 		= md5( $kata_sandi );
	
	$data = compact('user_be_id','nama_pengguna','kata_sandi','email','jabatan','nama_user','jenis_kelamin','alamat','no_telp','status_account');
	insert_sales($data);	

}

function insert_sales($data){
	$add_query = implode_insert($data);
	
	$query_users = mysql_query("INSERT INTO `users` $add_query");
	
	if($query_users){
		echo '<div id="success"><strong>Success :</strong> Save sales berhasil</div><br>';
		echo redirect_html('?q=sales&goto=add');
	}
}

function validasi_add_sales($data){
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
	
	if( $error ){
		foreach($error as $message) echo '<div id="error"><strong>Error :</strong> '.$message.'</div>';
		return false;
	}else return $data;
}

function edit_sales($data,$uid){
	$data = validasi_edit_sales($data);
	
	if( !is_array($data) )
		return false;
	
	extract($data, EXTR_SKIP);
	
	$nama_pengguna 		= esc_sql( $nama_pengguna );
	$email 				= esc_sql( $email );
	$nama_user 			= esc_sql( $nick_name );
	$jenis_kelamin		= esc_sql( $sex );
	$alamat 			= esc_sql( $alamat );
	$no_telp			= esc_sql( $nohp );
	
	$user_be_id			= getinfo_users('uid');
	$user_id			= esc_sql( $uid );	
	
	if( $status == 1 ) $status = 1;
	elseif( $status == 2 ) $status = 0;
	
	$status_account		= esc_sql( $status );
	
	$data = compact('nama_pengguna','email','nama_user','jenis_kelamin','alamat','no_telp','status_account');
	update_sales($data,compact('user_be_id','user_id'));	

}

function validasi_edit_sales($data){
	extract($data, EXTR_SKIP);
	
	$error = array();
	if( empty($nama_pengguna) ) $error[]= 'Nama Pengguna kosong';
	elseif(!valid_username($nama_pengguna) ) $error[]= 'Nama Pengguna tidak valid';
	
	if( empty($email) ) $error[]= 'Email Pengguna kosong';
	elseif(!valid_email($email) ) $error[]= 'Email Pengguna tidak valid';
	
	if( empty($sex) ) $error[]= 'Jenis Kelamin belum dipilih';
	if( empty($status) ) $error[]= 'Status Pengguna belum dipilih';
	
	if( $error ){
		foreach($error as $message) echo '<div id="error"><strong>Error :</strong> '.$message.'</div>';
		return false;
	}else return $data;
}

function update_sales($data, $where){
	extract($where, EXTR_SKIP);
	
	$add_query = implode_update($data,$where);
	
	$query_users = mysql_query("UPDATE `users` $add_query");
	
	if($query_users){
		echo '<div id="success"><strong>Success :</strong> Save sales berhasil</div><br>';
		echo redirect_html('?q=sales&goto=detail&user_id='.$user_id.'');
	}
	
}

function del_sales($uid){
	$user_be_id			= getinfo_users('uid');
	
	return mysql_query("DELETE FROM users WHERE `user_be_id`='$user_be_id' AND `user_id`=$uid");
}