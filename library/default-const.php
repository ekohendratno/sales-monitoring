<?php
if(!defined('_exec')) exit;

function set_gravatar( $mail,$s = 80,$d = 'mm', $r = 'g', $img = false, $atts = array() ){
	$url = 'http://www.gravatar.com/avatar/';
	$url.= md5( strtolower( trim( $mail ) ) );
	$url.= "?s=$s&d=$d&r=$r";
	
	if( $img ){
		$url = '<img src="' . $url . '"';
		foreach( $atts as $key => $val ){
			$url.= ' ' . $key . '="' . $val . '"';
		}
		$url.= '/>';
	}
	
	return $url;
}
/*
 * mengecek login user
 */
function check_login(){	
	
	$user_log = esc_sql( $_SESSION['Log_User'] );
	$lev_log = esc_sql( $_SESSION['Log_Level'] );
	
	if( isset($user_log) && !empty($lev_log) ){
		$mysql_query = mysql_query("SELECT * FROM users WHERE nama_pengguna='$user_log' AND jabatan='$lev_log' AND status_account='1'");
		$num = mysql_num_rows( $mysql_query );
		if( $num > 0 ) return true;
		else return false;
	}else return false;
}
/*
 * mengecek level user
 */
function check_level(){
	
	$user_log = esc_sql( $_SESSION['Log_User'] );
	$lev_log = esc_sql( $_SESSION['Log_Level'] );
	
	if( check_login() )	{
		$mysql_query = mysql_query("SELECT * FROM users WHERE nama_pengguna='$user_log' AND jabatan='$lev_log' AND status_account='1'");
		$data = mysql_fetch_object( $mysql_query );		
		return $data->jabatan;
	}else return false;
}
/*
 * mengeset login user
 */
function set_login($data){
	global $site_home;
	
	extract($data, EXTR_SKIP);
	
	$user_log = esc_sql( $user_log );
	$pass_log = esc_sql( $pass_log );
	
	$pass_log = md5( $pass_log );
	
	$mysql_query = mysql_query("SELECT * FROM users WHERE nama_pengguna='$user_log' AND kata_sandi='$pass_log' AND status_account='1'");
	$num = mysql_num_rows( $mysql_query );
	$data = mysql_fetch_object( $mysql_query );		
	
	if( $num > 0 && $user_log == $data->nama_pengguna ){
		
		$_SESSION['Log_User'] 	= $data->nama_pengguna;
		$_SESSION['Log_Level'] 	= $data->jabatan;
		
		header("Location: " . $site_home);
		exit();
		
	}else return "<div class=\"notif-box\"><div id=\"error\"><strong>Kesalahan :</strong> nama pengguna dan kata sandi tidak benar</div></div>";
	
}
/*
 * menghapus login user
 */
function destroy_login(){
	global $site_home;
		
	$_SESSION[ 'Log_User' ];
	$_SESSION[ 'Log_Level' ];
		
	session_destroy();
	
	header("Location: " . $site_home);
	exit();
}

function esc_sql( $string ){
	if( !empty( $string ) ){
		if (version_compare(phpversion(),"4.3.0", "<")) mysql_escape_string($string);
		else mysql_real_escape_string($string);
		return $string;
	}
}

function get_var( $param ){
	isset( $_GET[$param] );
}

function welcome_level( $upper = true ){
	$text_level = check_level();
	
	if( $text_level == 'sales') $text_level = 'Sales';
	elseif( $text_level == 'be') $text_level = 'Businnes Executive';
	elseif( $text_level == 'as') $text_level = 'Admin Support';
	elseif( $text_level == 'administrator') $text_level = 'Administrator';
	
	if( $upper ) return upper_character_first( $text_level );
	else return $text_level;
}
?>