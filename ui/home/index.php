<?php if(!defined('_exec')) exit;

$welcome_level = welcome_level();
	
if( strtolower($welcome_level) == 'administrator' ) $welcome_level = "Administrator";
elseif( strtolower($welcome_level) == 'as' ) $welcome_level = "Admin Support";
elseif( strtolower($welcome_level) == 'be' ) $welcome_level = "Businnes Executive";
elseif( strtolower($welcome_level) == 'sales' ) $welcome_level = "Sales";

?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
<link href="ui/home/css/tiptip.css" rel="stylesheet" />
<link href="ui/home/css/media.css" rel="stylesheet" />
<link href="ui/home/css/table.css" rel="stylesheet" />
<link href="ui/home/css/forms.css" rel="stylesheet" />
<link href="ui/home/css/colors.css" rel="stylesheet" />
<link href="ui/home/css/css3-buttons.css" rel="stylesheet" />
<link href="ui/home/css/dialog.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="ui/home/css/nav.css" />
<link rel="stylesheet" type="text/css" media="only screen and (max-width: 320px)"href="ui/home/css/phone-nav-menu.css"/>
<link rel="stylesheet" type="text/css" media="only screen and (min-width: 321px)"href="ui/home/css/desktop-nav-menu.css"/>
<link rel="stylesheet" type="text/css" media="only screen and (max-width: 320px)" href="ui/home/css/phone-320.css" />
<link rel="stylesheet" type="text/css" media="only screen and (max-width: 480px)" href="ui/home/css/phone-480.css" />
<link rel="stylesheet" type="text/css" media="only screen and (max-width: 620px)" href="ui/home/css/tablet.css" />
<link rel="stylesheet" type="text/css" media="screen and (min-width: 621px)" href="ui/home/css/desktop.css" />

<script src="ui/home/js/jquery.js"></script>
<script src="ui/home/js/jquery.tiptip.js"></script>
<script src="ui/home/js/jquery.jclock.js"></script>
<script src="ui/home/js/script.js"></script>
<script src="ui/home/js/jsMadani.js"></script>
<script src="ui/home/js/main.js"></script>
<script src="ui/home/js/dialog.js"></script>

<title><?php echo $welcome_level?></title>
</head>
<div id="redactor_modal_overlay" style="display: none;"></div>
<div id="loading"></div>
<?php header_nav()?>
<div id="body">

<div class="gd full">
<div class="gd-header">
<?php
if( empty($global_title) ) echo 'Selamat datang "'.$welcome_level.'"';
else echo $global_title;

if( !empty($global_title_menu) ) echo $global_title_menu;
?>
</div>
<div class="gd-content">
<?php echo $global_content;?>
</div>
<div class="gd-footer">
<div class="left">
<?php
if( empty($global_footer) )
echo '&copy; <a href="http://cmsid.org/">Eko Azza</a> 2012 | All Right Reserved';
else echo $global_footer;
?>
</div>
<div class="right"><span id="jclock"><?php echo date("Y/d/m H:i:s")?></span></div>
<!--
<div style="font-size:12px; padding:5px; text-align:center;">
<script type="text/javascript">
document.write(screen.width+'x'+screen.height);
</script>
</div>
-->
</div>
</div>

</div>
</body>
</html>