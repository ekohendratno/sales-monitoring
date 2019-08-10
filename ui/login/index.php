<?php if(!defined('_exec')) exit; ?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
<title>Login | Aplikasi Sales Monitoring Data Berbasis Website</title>
<link rel="stylesheet" type="text/css" media="all" href="ui/login/css/forms.css" />
<link rel="stylesheet" type="text/css" media="all" href="ui/login/css/colors.css" />
<link rel="stylesheet" type="text/css" media="all" href="ui/login/css/drop-shadow.css" />
<link rel="stylesheet" type="text/css" media="screen and (min-width: 481px)" href="ui/login/css/desktop.css" />
<link rel="stylesheet" type="text/css" media="only screen and (max-width: 480px)" href="ui/login/css/phone.css" />
</head>
<body>

<?php if( !check_login() ){?>
<div id="ui-sign-in">
<h2>Selamat Datang di</h2>
<div class="welcome">Aplikasi Sales Monitoring Data Berbasis Website</div>

<div class="sign-in-box drop-shadow lifted">
<!--<div align="right" style="margin-top:10px; margin-right:10px;"><img src="ui/login/images/logo_tri.png"></div>-->
<?php
if( isset($_POST['SubmitLog']) &&  $_POST['login'] == 1){
	
	$user_log = esc_sql( $_POST['UserLog'] );
	$pass_log = esc_sql( $_POST['PassLog'] );
	
	$data = compact('user_log','pass_log');
	echo set_login($data);
}
?>

<form action="" method="post" class="sign-in-box-form">
<label for="UserLog">Nama Pengguna</label>
<input type="text" name="UserLog" class="width-full">
<label for="PassLog">Kata Sandi</label>
<input type="password" name="PassLog" class="width-full">
<input type="submit" name="SubmitLog" value="Sign in"><input type="hidden" name="login" value="1">
</form>
</div>
<div class="welcome-footer">
<?php
if( empty($global_footer) )
echo '&copy; <a href="http://cmsid.org/">Eko</a> 2012 | All Right Reserved';
else echo $global_footer;
?>
</div>
</div>
<?php 
}else{
	header("Location: index.php");
	exit();
}
?>

</body>
</html>