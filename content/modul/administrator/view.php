<?php
if(!defined('_exec')) exit;

include "inc.php";

switch( $_GET['q'] ){
default:
case'retailer':

$retailer_id = esc_sql( $_GET['retailer_id'] );
$be_id = esc_sql( $_GET['be_id'] );

if( $_GET['goto'] == 'foto' || $_GET['goto'] == 'detail' ):

$query_retailer = mysql_query("SELECT * FROM `retailer` LEFT JOIN users ON (users.user_id=retailer.id_be) WHERE users.jabatan='be' AND retailer.id_retailer='$retailer_id' AND retailer.id_be != ''");
$row_retailer = mysql_fetch_object($query_retailer);
$total_row_retailer = mysql_num_rows($query_retailer); 

endif;

if( $_GET['act'] == 'del' ) del_retailer($retailer_id);

if( $_GET['goto'] == 'foto' ):
$global_title = 'Ubah Foto Profil';
$global_title_menu = '<div class="gd-menu2 right"><a href="?q=profile" class="button">&laquo; Back</a></div>';

if( isset($_POST['update']) ){
	$thumb = $_FILES['thumb'];
	insert_foto_retailer(array('gambar' => $row_retailer->gambar_retailer,'thumb'=>$thumb,'retailer_id' => $retailer_id));
}
?>
<form action="" method="post" enctype="multipart/form-data" name="form1">
<p><img src="content/uploads/retailer/<?php echo $row_retailer->gambar_retailer?>" width="160px"></p>
<p><input type="file" name="thumb"></p>
<p><input type="submit" name="update" id="update" value="Upload and Edit foto"></p>
</form>

<?php
elseif( $_GET['goto'] == 'detail' ):

$global_title = 'Detail Retailer';
$global_title_menu = '<div class="gd-menu2 right"><a href="?q=retailer" class="button" style="margin-right:5px;">&laquo; Back</a> <a href="?q=retailer&goto=edit&retailer_id='.$retailer_id.'" class="button left">Ubah Data</a><a href="?q=retailer&goto=foto&retailer_id='.$retailer_id.'" class="button middle">Ubah Foto</a><a href="?q=retailer&act=del&retailer_id='.$retailer_id.'" class="button right" style="margin-right:5px;">Hapus</a></div>';

if( $total_row_retailer < 1){
	redirect('?q=retailer');
}
?>
<div id="frame-width">
<table width="100%" border="0" cellspacing="2" cellpadding="1">
  <tr>
    <td colspan="3" align="center" valign="top" style="border-bottom:1px solid #ddd"><img src="content/uploads/retailer/<?php echo $row_retailer->gambar_retailer?>"  class="avatar3"/></td>
    </tr>
  <tr>
    <td width="18%" align="left" valign="top">Nama</td>
    <td width="1%" align="left" valign="top"><strong>:</strong></td>
    <td width="77%" align="left" valign="top"><?php echo $row_retailer->nama_retailer;?></td>
  </tr>
  <tr>
    <td width="18%" align="left" valign="top">Status</td>
    <td width="1%" align="left" valign="top"><strong>:</strong></td>
    <td width="77%" align="left" valign="top"><?php echo statusformat($row_retailer->status_retailer);?></td>
  </tr>
  <tr>
    <td width="18%" align="left" valign="top">BE Area</td>
    <td width="1%" align="left" valign="top"><strong>:</strong></td>
    <td width="77%" align="left" valign="top"><?php echo $row_retailer->nama_user;?></td>
  </tr>
  <tr>
    <td width="18%" align="left" valign="top">Area</td>
    <td width="1%" align="left" valign="top"><strong>:</strong></td>
    <td width="77%" align="left" valign="top"><?php echo $row_retailer->area;?></td>
  </tr>
  <tr>
    <td width="18%" align="left" valign="top">Alamat</td>
    <td width="1%" align="left" valign="top"><strong>:</strong></td>
    <td width="77%" align="left" valign="top"><?php echo $row_retailer->alamat_retailer;?></td>
  </tr>
</table>
</div>
<?php
elseif( $_GET['goto'] == 'add' ):
$global_title = 'Tambah Retailer';
$global_title_menu = '<div class="gd-menu2 right"><a href="?q=retailer" class="button">&laquo; Back</a></div>';

if( isset($_POST['simpan']) || isset($_POST['simpanaktif']) ){
	
	$name_retiler 		= esc_sql( $_POST['name_retiler'] );
	$alamat_retailer 	= esc_sql( $_POST['alamat_retailer'] );
	$be_id 				= esc_sql( $_POST['be_id'] );
	
	if( isset($_POST['simpanaktif']) ) $status_retailer = 1;
	else $status_retailer = 2;
	
	$data = compact('name_retiler','alamat_retailer','be_id','status_retailer');
	add_retailer($data);
	
}

?>
<br /><p>Silahkan tambahkan retailer baru pada form yang disediakan dibawah ini</p><br />
<form method="post" action="">
    <p>
    <label for="name_retiler">Nama Retailer *</label>
    <input type="text" name="name_retiler" style="width:99%;"/>
  </p>
    <p>
    <label for="alamat_retailer">Alamat Retailer *</label>
    <textarea name="alamat_retailer" style="width:99%;"/></textarea>
    </p>
    <p>
    <label for="be_id">Businnes Executive *</label>
    <?php echo area_select()?>
    </p>
  <p>
    <input type="submit" name="simpan" value="Simpan" class="on" /> or <input type="submit" name="simpanaktif" value="Simpan dan Aktifkan" /> <input type="reset" name="Reset" value="Bersihkan" />
    </p>
    <p>*( harus diisi</p>
</form>
<?php

elseif( $_GET['goto'] == 'edit' ):
$global_title = 'Ubah Retailer';
$global_title_menu = '<div class="gd-menu2 right"><a href="?q=retailer" class="button">&laquo; Back</a></div>';

if( isset($_POST['simpan']) ){
	
	$name_retiler 		= esc_sql( $_POST['name_retiler'] );
	$alamat_retailer 	= esc_sql( $_POST['alamat_retailer'] );
	$be_id 				= esc_sql( $_POST['be_id'] );
	$status_retailer	= esc_sql( $_POST['status_retailer'] );
	
	$data = compact('name_retiler','alamat_retailer','status_retailer','be_id');
	edit_retailer($data, $retailer_id);
	
}
$query_retailer = mysql_query("SELECT * FROM retailer WHERE id_retailer='$retailer_id'");
$row_retailer = mysql_fetch_object($query_retailer);
?>
<br /><p>Silahkan ubah retailer pada form yang disediakan dibawah ini</p><br />
<form method="post" action="">
    <p>
    <label for="name_retiler">Nama Retailer *</label>
    <input type="text" name="name_retiler" style="width:99%;" value="<?php echo $row_retailer->nama_retailer?>"/>
  </p>
    <p>
    <label for="alamat_retailer">Alamat Retailer *</label>
    <textarea name="alamat_retailer" style="width:99%;"/><?php echo $row_retailer->alamat_retailer?></textarea>
    </p>
    <p>
    <label for="be_id">Businnes Executive *</label>
    <?php echo area_select($be_id)?>
    </p>
    <p>
    <label for="status_retailer">Status Retailer *</label>
    <select name="status_retailer" style="width:100%;">
   	   <?php 
	   $status = $row_retailer->status_retailer;
	   if( $status == '1' ): ?>
       <option value="">--Pilih--</option> 
       <option value="1" selected="selected">Aktif</option>
       <option value="2">Tidak Aktif</option>
       <?php elseif( $status == '0' ): ?>
       <option value="">--Pilih--</option> 
       <option value="1">Aktif</option>
       <option value="2" selected="selected">Tidak Aktif</option>
       <?php else: ?>
       <option value="">--Pilih--</option> 
       <option value="1">Aktif</option>
       <option value="2">Tidak Aktif</option>
       <?php endif; ?>
    </select>
    </p>
  <p>
    <input type="submit" name="simpan" value="Simpan" class="on" /> <input type="reset" name="Reset" value="Bersihkan" />
    </p>
    <p>*( harus diisi</p>
</form>
<?php

else:
$global_title = 'Retailer';
$global_title_menu = '<div class="gd-menu2 right"><a href="?q=retailer&goto=add" class="button" style="margin-right:5px;">Tambah Retailer Baru</a></div>';
?>
<p>Berikut adalah daftar Retailer :</p><br />
<div id="frame-width">
<table width="100%" border="0" cellspacing="0" cellpadding="2" id="table-ui">
  <tr class="head">
    <td class="depan"  style="width: 1%; text-align:center">No</td>
    <td align="center" style="width: 35%; text-align:left">Nama</td>
    <td align="center" style="width: 35%; text-align:left">Businnes Executive</td>
    <td align="center" style="width: 15%;">Aksi</td>
  </tr>
<?php
$i = 1;
$warna = $total_qty = '';
$query_retailer = mysql_query("SELECT * FROM retailer LEFT JOIN users ON (users.user_id=retailer.id_be) WHERE users.jabatan='be' ORDER BY retailer.id_be ASC");
while( $row_retailer = mysql_fetch_object($query_retailer) ){

$warna  = empty ($warna) ? ' bgcolor="#f9fbff"' : '';
?>
  <tr class="isi"<?php echo $warna?>>
    <td class="depan" align="center"><?php echo $i?></td>
    <td align="left"><?php echo $row_retailer->nama_retailer?></td>
    <td align="left"><?php echo $row_retailer->nama_user?></td>
    <td align="center"><div class="action"><a href="?q=retailer&goto=detail&retailer_id=<?php echo $row_retailer->id_retailer?>&be_id=<?php echo $row_retailer->id_be?>" class="view">view</a> <a href="?q=retailer&goto=edit&retailer_id=<?php echo $row_retailer->id_retailer?>&be_id=<?php echo $row_retailer->id_be?>" class="edit">edit</a> <a href="?q=retailer&act=del&retailer_id=<?php echo $row_retailer->id_retailer?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="delete">delete</a></div></td>
  </tr>
<?php
$i++; 
}
?>
  <tr style="background:none">
    <td align="center" style="border-left:1px solid #ddd;border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px"><?php echo ($i-1)?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<?php
endif;
break;
case'member':

$uid = esc_sql( $_GET['user_id'] );

if( $_GET['act'] == 'del' ) del_member($uid);

if( $_GET['goto'] == 'add' ):

$global_title = 'Tambah member';
$global_title_menu = '<div class="gd-menu2 right"><a href="?q=member" class="button">&laquo; Back</a></div>';

if( isset($_POST['simpan']) || isset($_POST['simpanaktif']) ){
	
	$nama_pengguna 		= esc_sql( $_POST['nama_pengguna'] );
	$kata_sandi 		= esc_sql( $_POST['kata_sandi'] );
	$retry_kata_sandi 	= esc_sql( $_POST['retry_kata_sandi'] );
	$email 				= esc_sql( $_POST['email'] );
	$sex 				= esc_sql( $_POST['sex'] );
	$jabatan			= esc_sql( $_POST['jabatan'] );
	$area				= esc_sql( $_POST['area'] );
	$nick_name 			= esc_sql( $_POST['nick_name'] );
	$nohp 				= esc_sql( $_POST['nohp'] );
	$alamat 			= esc_sql( $_POST['alamat'] );
	
	if( isset($_POST['simpanaktif']) ) $status = 1;
	else $status = 0;
	
	$data = compact('nama_pengguna','kata_sandi','retry_kata_sandi','email','sex','jabatan','area','nick_name','nohp','alamat','status');
	add_member($data);
	
}

?>
<br /><p>Silahkan tambahkan member baru pada form yang disediakan dibawah ini</p><br />
<form method="post" action="">
<p>
    <label for="nama_pengguna">Nama Pengguna *</label>
    <input type="text" name="nama_pengguna" style="width:99%;" id="nama_pengguna" />
    </p>
<p>
    <label for="kata_sandi">Kata Sandi Pengguna *</label>
    <input type="text" name="kata_sandi" style="width:99%;" id="kata_sandi" />
  </p>
<p>
    <label for="retry_kata_sandi">Ulangi Kata Sandi Pengguna *</label>
    <input type="text" name="retry_kata_sandi" style="width:99%;" id="retry_kata_sandi" />
  </p>
  <p>
    <label for="email">Surat Elektronik / Email *</label>
    <input type="text" name="email" style="width:99%;"/>
    </p>
    <p>
    <label for="sex">Jenis Kelamin *</label>
    <select name="sex" style="width:100%;">
   <option value="">--Pilih--</option> <option value="l">Laki-laki</option><option value="p">Perempuan</option>
    </select>
    </p>
    <p>
    <label for="jabatan">Jabatan *</label>
    <select name="jabatan" style="width:100%;">
   <option value="">--Pilih--</option><option value="be">Businnes Executive</option><option value="as">Admin Support</option><option value="administrator">Administrator</option>
    </select>
    </p>
    <p>
    <label for="area">Area (isi jika jabatan Businnes Executive)</label>
    <input type="text" name="area" style="width:99%;"/>
  </p>
    <p>
    <label for="nick_name">Nama Panggilan</label>
    <input type="text" name="nick_name" style="width:99%;"/>
  </p>
    <p>
    <label for="nohp">No Handphone</label>
    <input type="text" name="nohp" style="width:99%;"/>
    </p>
    <p>
    <label for="alamat">Alamat</label>
    <textarea name="alamat" style="width:99%; height:50px"></textarea>
    </p>
  <p>
    <input type="submit" name="simpan" value="Simpan" class="on" /> or <input type="submit" name="simpanaktif" value="Simpan dan Aktifkan" /> <input type="reset" name="Reset" value="Bersihkan" />
    </p>
    <p>*( harus diisi</p>
</form>
<?php
elseif( $_GET['goto'] == 'edit' ):

$global_title = 'Ubah Member';
$global_title_menu = '<div class="gd-menu2 right"><a href="?q=member" class="button">&laquo; Back</a></div>';

if( isset($_POST['simpan']) || isset($_POST['simpanaktif']) ){
	
	$nama_pengguna 		= esc_sql( $_POST['nama_pengguna'] );
	$email 				= esc_sql( $_POST['email'] );
	$sex 				= esc_sql( $_POST['sex'] );
	$jabatan			= esc_sql( $_POST['jabatan'] );
	$area				= esc_sql( $_POST['area'] );
	$nick_name 			= esc_sql( $_POST['nick_name'] );
	$nohp 				= esc_sql( $_POST['nohp'] );
	$alamat 			= esc_sql( $_POST['alamat'] );
	$status 			= esc_sql( $_POST['status'] );
	
	$data = compact('nama_pengguna','email','sex','jabatan','area','nick_name','nohp','alamat','status');
	edit_member($data,$uid);
	
}

?>
<br /><p>Silahkan tambahkan sales baru pada form yang disediakan dibawah ini</p><br />
<form method="post" action="">
<p>
    <label for="nama_pengguna">Nama Pengguna *</label>
    <input type="text" name="nama_pengguna" style="width:99%;" id="nama_pengguna" value="<?php echo getinfo_users('user',$uid)?>"/>
    </p>
  <p>
    <label for="email">Surat Elektronik / Email *</label>
    <input type="text" name="email" style="width:99%;" value="<?php echo getinfo_users('mail',$uid)?>"/>
    </p>
    <p>
    <label for="sex">Jenis Kelamin *</label>
    <select name="sex" style="width:100%;">
   	   <?php 
	   $sex = getinfo_users('sex',$uid);
	   if( $sex == 'l' ): ?>
       <option value="">--Pilih--</option> 
       <option value="l" selected="selected">Laki-laki</option>
       <option value="p">Perempuan</option>
       <?php elseif( $sex == 'p' ): ?>
       <option value="">--Pilih--</option> 
       <option value="l">Laki-laki</option>
       <option value="p" selected="selected">Perempuan</option>
       <?php else: ?>
       <option value="">--Pilih--</option> 
       <option value="l">Laki-laki</option>
       <option value="p">Perempuan</option>
       <?php endif; ?>
    </select>
    </p>
    <p>
    <label for="status">Status Pengguna</label>
    <select name="status" style="width:100%;">
   	   <?php 
	   $status = getinfo_users('status',$uid);
	   if( $status == '1' ): ?>
       <option value="">--Pilih--</option> 
       <option value="1" selected="selected">Aktif</option>
       <option value="2">Tidak Aktif</option>
       <?php elseif( $status == '0' ): ?>
       <option value="">--Pilih--</option> 
       <option value="1">Aktif</option>
       <option value="2" selected="selected">Tidak Aktif</option>
       <?php else: ?>
       <option value="">--Pilih--</option> 
       <option value="1">Aktif</option>
       <option value="2">Tidak Aktif</option>
       <?php endif; ?>
    </select>
    </p>
    <p>
    <label for="jabatan">Jabatan</label>
    <select name="jabatan" style="width:100%;">
   	   <?php 
	   $jabatan = getinfo_users('jabatan',$uid);
	   if( $jabatan == 'be' ): ?>
       <option value="">--Pilih--</option> 
       <option value="be" selected="selected">Businnes Executive</option>
       <option value="as">Admin Support</option>
       <option value="administrator">Administrator</option>
	   <?php elseif( $jabatan == 'as' ): ?>
       <option value="">--Pilih--</option> 
       <option value="be">Businnes Executive</option>
       <option value="as" selected="selected">Admin Support</option>
       <option value="administrator">Administrator</option>
	   <?php elseif( $jabatan == 'administrator' ): ?>
       <option value="">--Pilih--</option> 
       <option value="be">Businnes Executive</option>
       <option value="as">Admin Support</option>
       <option value="administrator" selected="selected">Administrator</option>
       <?php else: ?>
       <option value="">--Pilih--</option> 
       <option value="be">Businnes Executive</option>
       <option value="as">Admin Support</option>
       <option value="administrator">Administrator</option>
       <?php endif; ?>
    </select>
    </p>
    <p>
    <label for="area">Area (isi jika jabatan Businnes Executive)</label>
    <input type="text" name="area" style="width:99%;" value="<?php echo getinfo_users('area',$uid)?>"/>
  </p>
    <p>
    <label for="nick_name">Nama Panggilan</label>
    <input type="text" name="nick_name" style="width:99%;" value="<?php echo getinfo_users('nama',$uid)?>"/>
  </p>
    <p>
    <label for="nohp">No Handphone</label>
    <input type="text" name="nohp" style="width:99%;" value="<?php echo getinfo_users('telp',$uid)?>"/>
    </p>
    <p>
    <label for="alamat">Alamat</label>
    <textarea name="alamat" style="width:99%; height:50px"><?php echo getinfo_users('alamat',$uid)?></textarea>
    </p>
  <p>
    <input type="submit" name="simpan" value="Update" class="on" /> <input type="reset" name="Reset" value="Bersihkan" />
    </p>
    <p>*( harus diisi</p>
</form>
<?php
elseif( $_GET['goto'] == 'detail' ):

$global_title = 'Detail Member';

$add_menu_detail_sales = '';

if( $_GET['detail'] == 'view' ){
$add_menu_detail_sales = '<a href="?q=transaksi" class="button" style="margin-right:5px;">Home Transaksi</a> <a href="?q=member&goto=detail&user_id='.$uid.'" class="button" style="margin-right:5px;">&laquo; Back</a>';
}

$global_title_menu = '<div class="gd-menu2 right"><a href="?q=member" class="button" style="margin-right:5px;">Home Member</a>'.$add_menu_detail_sales.'<a href="?q=member&goto=edit&user_id='.$uid.'" class="left button">Ubah</a> <a href="?q=member&act=del&user_id='.$uid.'" class="right button"  onclick="return confirm(\'Yakin ingin menghapus data ini?\')">Hapus</a></div>';

$query_user = mysql_query("SELECT * FROM `users` WHERE `user_id`=$uid");
$row_user= mysql_fetch_object($query_user);
$total_row_user = mysql_num_rows($query_user); 

if( $total_row_user < 1){
	redirect('?q=member');
}
?>
<div id="frame-width">
<table width="100%" border="0" cellspacing="2" cellpadding="1">
  <tr>
    <td width="4%" rowspan="6" align="left" valign="top"><img src="content/uploads/<?php echo $row_user->gambar?>"  class="avatar"/></td>
    <td width="18%" align="left" valign="top">Nama</td>
    <td width="1%" align="left" valign="top"><strong>:</strong></td>
    <td width="77%" align="left" valign="top"><?php echo $row_user->nama_user;?></td>
  </tr>
  <tr>
    <td width="18%" align="left" valign="top">Jenis Kelamin</td>
    <td width="1%" align="left" valign="top"><strong>:</strong></td>
    <td width="77%" align="left" valign="top"><?php echo sexformat($row_user->jenis_kelamin);?></td>
  </tr>
  <tr>
    <td width="18%" align="left" valign="top">Status</td>
    <td width="1%" align="left" valign="top"><strong>:</strong></td>
    <td width="77%" align="left" valign="top"><?php echo statusformat($row_user->status_account);?></td>
  </tr>
  <tr>
    <td width="18%" align="left" valign="top">Handphone</td>
    <td width="1%" align="left" valign="top"><strong>:</strong></td>
    <td width="77%" align="left" valign="top"><?php echo nohpformat($row_user->no_telp);?></td>
  </tr>
  <tr>
    <td align="left" valign="top">Email</td>
    <td align="left" valign="top"><strong>:</strong></td>
    <td align="left" valign="top"><?php echo $row_user->email;?></td>
  </tr>
  <tr>
    <td align="left" valign="top">Alamat</td>
    <td align="left" valign="top"><strong>:</strong></td>
    <td align="left" valign="top"><?php echo $row_user->alamat;?></td>
  </tr>
</table>
</div>
<br />
<?php
else:
$global_title = 'Daftar Member';
$global_title_menu = '<div class="gd-menu2 right"><a href="?q=member&goto=add" class="button" style="margin-right:5px;">Tambah Member Baru</a></div>';
?>
<p>Berikut adalah daftar Member :</p><br />
<div id="frame-width">
<table width="100%" border="0" cellspacing="0" cellpadding="2" id="table-ui">
  <tr class="head">
    <td class="depan"  style="width: 1%; text-align:center">No</td>
    <td align="center" style="width: 45%; text-align:left">Nama</td>
    <td align="center" style="width: 25%;">Jabatan</td>
    <td align="center" style="width: 15%;">Aksi</td>
  </tr>
<?php
$i = 1;
$warna = $total_qty = '';
$query_user = mysql_query("SELECT * FROM users WHERE jabatan != 'sales' ORDER BY user_id DESC");
while( $row_user = mysql_fetch_object($query_user) ){

$warna  = empty ($warna) ? ' bgcolor="#f9fbff"' : '';
?>
  <tr class="isi"<?php echo $warna?>>
    <td class="depan" align="center"><?php echo $i?></td>
    <td align="left"><?php echo $row_user->nama_user?></td>
    <td align="center"><?php echo $row_user->jabatan?></td>
    <td align="center"><div class="action"><a href="?q=member&goto=detail&user_id=<?php echo $row_user->user_id?>" class="view">detail</a> <a href="?q=member&goto=edit&user_id=<?php echo $row_user->user_id?>" class="edit">edit</a> <a href="?q=member&act=del&user_id=<?php echo $row_user->user_id?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="delete">delete</a></div></td>
  </tr>
<?php
$i++; 
}
?>
  <tr style="background:none">
    <td align="center" style="border-left:1px solid #ddd;border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px"><?php echo ($i-1)?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<?php
endif;
break;
}
?>