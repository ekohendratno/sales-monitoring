<?php
error_reporting(0);

if (!defined("_exec")):
define('_exec', true);

session_name("Login");
session_start();

$_GET[q] = empty($_GET[q]) ? '' : $_GET[q];

$dir_name_file = dirname(__FILE__);
	
/** menentukan abs_path berdasarkan direktori file*/
if (DIRECTORY_SEPARATOR=='/') $absolute_path = $dir_name_file.'/'; 
else $absolute_path = str_replace('\\', '/',$dir_name_file).'/'; 
	  
if ( !defined( 'abs_path' ) ) define( 'abs_path',  $absolute_path );

/*
 * jika var $load_system tidak bernilai 
 * maka system akan di panggil
 */
if( !isset( $load_system ) ){	
	$load_system = true;
	
	include 'config.php';
	include 'library/default-const.php';
	include 'library/function.php';
	
	/*
	 * membuat waktu berdasarkan timezone
	 */
	if( function_exists("date_default_timezone_set") && 
		function_exists("date_default_timezone_get") )
		@date_default_timezone_set('UTC');
		@date_default_timezone_set($time_zone);
	/*
	 * mengecek login user
	 */
	if( !check_login() ) include 'ui/login/index.php';
	else{
	 	/*
		 * penghapusan akun dan keluar
		 */
	 	if( $_GET[q] == 'logout' ) destroy_login();
	 
	 	if( isset($_GET['print']) ){
			
			if( file_exists('content/modul/' .  check_level() . '/print.php') ){
				include 'content/modul/' .  check_level() . '/print.php';
			}else include 'content/404.php';
			
		}else{
	 	/*
		 * memulai membuat kontent
		 */
	 	ob_start();
		
		$level = check_level();
		
		if( isset($_GET[q]) && !empty($_GET[q]) ){
			
			if( $_GET[q] == 'profile' ): 
				include 'content/profile.php';	
			else:
				
			if( file_exists('content/modul/' .  $level . '/view.php') ){
				include 'content/modul/' .  $level . '/view.php';
			}else include 'content/404.php';
			
			endif;
			
		}else{
			if( $level == 'administrator' ) $level = '-' . $level;
			else $level = '';
			include "content/front$level.php";
		}
		
		$global_content = ob_get_contents();
		ob_end_clean();	 
	 	/*
		 * membuat ui index
		 */
		include 'ui/home/index.php';
		}
	
	}
}
endif;