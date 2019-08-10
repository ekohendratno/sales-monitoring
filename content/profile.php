<?php
if(!defined('_exec')) exit;

$uid = getinfo_users('uid');

$query_user = mysql_query("SELECT * FROM `users` WHERE `user_id`='$uid'");
$row_user= mysql_fetch_object($query_user);
$total_row_user = mysql_num_rows($query_user); 

if( $_GET['goto'] == 'edit' ):
$global_title = 'Edit Profile';
$global_title_menu = '<div class="gd-menu2 right"><a href="?q=profile" class="button">&laquo; Back</a></div>';

if( isset($_POST['simpan']) || isset($_POST['simpanaktif']) ){
	
	$email 				= esc_sql( $_POST['email'] );
	$sex 				= esc_sql( $_POST['sex'] );
	$nick_name 			= esc_sql( $_POST['nick_name'] );
	$nohp 				= esc_sql( $_POST['nohp'] );
	$alamat 			= esc_sql( $_POST['alamat'] );
	
	$data = compact('email','sex','nick_name','nohp','alamat');
	edit_profile($data,$uid);
	
}
?>
<br /><p>Silahkan lengkapi data profil pada form yang disediakan dibawah ini</p><br />
<form method="post" action="">
<p>
    <label for="nama_pengguna">Nama Pengguna</label>
    <input type="text" name="nama_pengguna" style="width:99%;" id="nama_pengguna" value="<?php echo getinfo_users('user',$uid)?>" disabled="disabled"/>
    </p>
<p>
    <label for="jabatan">Jabatan</label>
    <input type="text" name="jabatan" style="width:99%;" id="jabatan" value="<?php echo convert_jabatan(getinfo_users('jabatan',$uid))?>" disabled="disabled"/>
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
elseif( $_GET['goto'] == 'password' ):
$global_title = 'Ubah Kata Sandi';
$global_title_menu = '<div class="gd-menu2 right"><a href="?q=profile" class="button">&laquo; Back</a></div>';

if( isset($_POST['simpan']) ){
	$old_password = esc_sql( $_POST['old_password'] );
	$new_password = esc_sql( $_POST['new_password'] );
	$retry_new_password = esc_sql( $_POST['retry_new_password'] );
	
	$data = compact('old_password','new_password','retry_new_password');
	edit_password($data,$uid);
}
?>
<br /><p>Silahkan kata sandi profil pada form yang disediakan dibawah ini</p><br />
<form method="post" action="">
<p>
    <label for="old_password">Kata Sandi Lama</label>
    <input type="password" name="old_password" style="width:99%;" id="old_password"/>
    </p>
<p>
    <label for="new_password">Kata Sandi Baru</label>
    <input type="password" name="new_password" style="width:99%;" id="new_password"/>
    </p>
<p>
    <label for="retry_new_password">Ulangi Kata Sandi Baru</label>
    <input type="password" name="retry_new_password" style="width:99%;" id="retry_new_password"/>
    </p>
  <p>
    <input type="submit" name="simpan" value="Update" class="on" /> <input type="reset" name="Reset" value="Bersihkan" />
    </p>
    <p>*( harus diisi</p>
</form>
<?php
elseif( $_GET['goto'] == 'foto' ):
$global_title = 'Ubah Foto Profil';
$global_title_menu = '<div class="gd-menu2 right"><a href="?q=profile" class="button">&laquo; Back</a></div>';

if( isset($_POST['update']) ){
	$thumb = $_FILES['thumb'];
	insert_foto(array('gambar' => $row_user->gambar,'thumb'=>$thumb,'user_id' => $row_user->user_id));
}
?>
<form action="" method="post" enctype="multipart/form-data" name="form1">
<p><img src="content/uploads/<?php echo $row_user->gambar?>" width="120px"></p>
<p><input type="file" name="thumb"></p>
<p><input type="submit" name="update" id="update" value="Upload and Edit foto"></p>
</form>

<?php
else:
$global_title = 'Profile Data';
$global_title_menu = '<div class="gd-menu2 right"><a href="./" class="button" style="margin-right:5px;">Home</a><a href="?q=profile&goto=edit" class="left button">Ubah</a><a href="?q=profile&goto=foto" class="middle button">Foto Profil</a> <a href="?q=profile&goto=password" class="right button">Kata Sandi</a></div>';

if( $total_row_user < 1){
	redirect();
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
<?php
endif;
?>