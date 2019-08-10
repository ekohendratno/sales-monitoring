<?php
if(!defined('_exec')) exit;

include "inc.php";

switch( $_GET['q'] ){
default:
case'retailer':

if( $_GET['goto'] == 'detail' ):
$global_title = 'Detail Retailer';
$global_title_menu = '<div class="gd-menu2 right"><a href="?q=retailer" class="button" style="margin-right:5px;">&laquo; Back</a></div>';

$retailer_id = esc_sql( $_GET['retailer_id'] );

	$add_query = "WHERE `id_retailer`='$retailer_id' AND id_be != ''";
if( show_on( 'be' ) )
	$add_query = "WHERE `id_retailer`='$retailer_id' AND id_be != '' AND id_be = '".getinfo_users('uid')."'";

$query_retailer = mysql_query("SELECT * FROM `retailer` $add_query");
$row_retailer = mysql_fetch_object($query_retailer);
$total_row_retailer = mysql_num_rows($query_retailer); 

if( $total_row_retailer < 1){
	redirect('?q=retailer');
}
?>
<div id="frame-width">
<table width="100%" border="0" cellspacing="2" cellpadding="1">
  <tr>
    <td colspan="3" align="center" valign="top" style="border-bottom:1px solid #ddd;"><img src="content/uploads/retailer/<?php echo $row_retailer->gambar_retailer?>"  class="avatar3"/></td>
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
    <td width="18%" align="left" valign="top">Alamat</td>
    <td width="1%" align="left" valign="top"><strong>:</strong></td>
    <td width="77%" align="left" valign="top"><?php echo $row_retailer->alamat_retailer;?></td>
  </tr>
</table>
</div>
<?php
else:
$global_title = 'Retailer';
?>
<p>Berikut adalah daftar Retailer :</p><br />
<div id="frame-width">
<table width="100%" border="0" cellspacing="0" cellpadding="2" id="table-ui">
  <tr class="head">
    <td class="depan"  style="width: 1%; text-align:center">No</td>
    <td align="center" style="width: 35%; text-align:left">Nama</td>
    <td align="center" style="width: 45%; text-align:left">Alamat</td>
    <td align="center" style="width: 5%;">Aksi</td>
  </tr>
<?php
$i = 1;
$warna = $total_qty = '';
	
	$add_query = "WHERE id_be != ''";
if( show_on( 'be' ) )
	$add_query = "WHERE id_be != '' AND id_be = '".getinfo_users('uid')."'";
	
$query_retailer = mysql_query("SELECT * FROM retailer $add_query");
while( $row_retailer = mysql_fetch_object($query_retailer) ){

$warna  = empty ($warna) ? ' bgcolor="#f9fbff"' : '';
?>
  <tr class="isi"<?php echo $warna?>>
    <td class="depan" align="center"><?php echo $i?></td>
    <td align="left"><?php echo $row_retailer->nama_retailer?></td>
    <td align="left"><?php echo $row_retailer->alamat_retailer?></td>
    <td align="center"><div class="action"><a href="?q=retailer&goto=detail&retailer_id=<?php echo $row_retailer->id_retailer?>" class="view">detail</a></div></td>
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
case'stok':
$global_title = 'Stok Barang / Produk';
?>
<p>Berikut adalah stok produk yang ada :</p><br />
<div id="frame-width">
<table width="100%" border="0" cellspacing="0" cellpadding="2" id="table-ui">
  <tr class="head">
    <td class="depan"  style="width: 1%; text-align:center">No</td>
    <td align="center" style="width: 45%; text-align:left">Nama Produk</td>
    <td align="center" style="width: 8%;">Qty</td>
    <td align="center" style="width: 25%; text-align:right">Harga Satuan</td>
    <td align="center" style="width: 25%; text-align:right">Total</td>
  </tr>
<?php
$i = 1;
$warna = $total_qty =  $total_uang_satuan =   $total_uang_all = '';
$query_produk = mysql_query("SELECT * FROM `barang` ORDER BY nama_barang ASC");
while( $row_produk = mysql_fetch_object($query_produk) ){

$warna  = empty ($warna) ? ' bgcolor="#f9fbff"' : '';
?>
  <tr class="isi"<?php echo $warna?>>
    <td class="depan" align="center"><?php echo $i?></td>
    <td align="left"><?php echo $row_produk->nama_barang?></td>
    <td align="center"><?php echo $row_produk->jumlah_barang?></td>
    <td align="right"><?php echo noformat( $row_produk->harga_satuan  )?></td>
    <td align="right"><?php echo noformat( $row_produk->harga_satuan * $row_produk->jumlah_barang )?></td>
  </tr>
<?php
$i++; 
$total_qty = $total_qty + $row_produk->jumlah_barang;
$total_uang_satuan = $total_uang_satuan + $row_produk->harga_satuan;
$total_uang_all = $total_uang_all + $row_produk->harga_satuan * $row_produk->jumlah_barang;
}
?>
  <tr style="background:none">
    <td align="center" style="border-left:1px solid #ddd;border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px"><?php echo ($i-1)?></td>
    <td style="border-right:1px solid #ddd;"></td>
    <td align="center" style="border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px"><?php echo noformat( $total_qty );?></td>
    <td align="right" style="border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px; padding-right:8px;">Rp. <?php echo noformat( $total_uang_satuan );?></td>
    <td align="right" style="border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px; padding-right:8px;">Rp. <?php echo noformat( $total_uang_all );?></td>
  </tr>
</table>
</div>
<?php
break;
case'sales':

$uid = esc_sql( $_GET['user_id'] );
$retailer_id = esc_sql( $_GET['retailer_id'] );

if( $_GET['act'] == 'del' ) del_sales($uid);

if( $_GET['goto'] == 'add' ):

$global_title = 'Tambah Sales';

if( isset($_POST['simpan']) || isset($_POST['simpanaktif']) ){
	
	$nama_pengguna 		= esc_sql( $_POST['nama_pengguna'] );
	$kata_sandi 		= esc_sql( $_POST['kata_sandi'] );
	$retry_kata_sandi 	= esc_sql( $_POST['retry_kata_sandi'] );
	$email 				= esc_sql( $_POST['email'] );
	$sex 				= esc_sql( $_POST['sex'] );
	$nick_name 			= esc_sql( $_POST['nick_name'] );
	$nohp 				= esc_sql( $_POST['nohp'] );
	$alamat 			= esc_sql( $_POST['alamat'] );
	
	if( isset($_POST['simpanaktif']) ) $status = 1;
	else $status = 0;
	
	$data = compact('nama_pengguna','kata_sandi','retry_kata_sandi','email','sex','nick_name','nohp','alamat','status');
	add_sales($data);
	
}

?>
<br /><p>Silahkan tambahkan sales baru pada form yang disediakan dibawah ini</p><br />
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

$global_title = 'Ubah Sales';
$global_title_menu = '<div class="gd-menu2 right"><a href="?q=sales" class="button">&laquo; Back</a></div>';

$bid = getinfo_users('uid');

if( isset($_POST['simpan']) || isset($_POST['simpanaktif']) ){
	
	$nama_pengguna 		= esc_sql( $_POST['nama_pengguna'] );
	$email 				= esc_sql( $_POST['email'] );
	$sex 				= esc_sql( $_POST['sex'] );
	$nick_name 			= esc_sql( $_POST['nick_name'] );
	$nohp 				= esc_sql( $_POST['nohp'] );
	$alamat 			= esc_sql( $_POST['alamat'] );
	$status 			= esc_sql( $_POST['status'] );
	
	$data = compact('nama_pengguna','email','sex','nick_name','nohp','alamat','status');
	edit_sales($data,$uid);
	
}

?>
<br /><p>Silahkan tambahkan sales baru pada form yang disediakan dibawah ini</p><br />
<form method="post" action="">
<p>
    <label for="nama_pengguna">Nama Pengguna *</label>
    <input type="text" name="nama_pengguna" style="width:99%;" id="nama_pengguna" value="<?php echo getinfo_users('user',$uid,$bid)?>"/>
    </p>
  <p>
    <label for="email">Surat Elektronik / Email *</label>
    <input type="text" name="email" style="width:99%;" value="<?php echo getinfo_users('mail',$uid,$bid)?>"/>
    </p>
    <p>
    <label for="sex">Jenis Kelamin *</label>
    <select name="sex" style="width:100%;">
   	   <?php 
	   $sex = getinfo_users('sex',$uid,$bid);
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
	   $status = getinfo_users('status',$uid,$bid);
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
    <label for="nick_name">Nama Panggilan</label>
    <input type="text" name="nick_name" style="width:99%;" value="<?php echo getinfo_users('user',$uid,$bid)?>"/>
  </p>
    <p>
    <label for="nohp">No Handphone</label>
    <input type="text" name="nohp" style="width:99%;" value="<?php echo getinfo_users('telp',$uid,$bid)?>"/>
    </p>
    <p>
    <label for="alamat">Alamat</label>
    <textarea name="alamat" style="width:99%; height:50px"><?php echo getinfo_users('alamat',$uid,$bid)?></textarea>
    </p>
  <p>
    <input type="submit" name="simpan" value="Update" class="on" /> <input type="reset" name="Reset" value="Bersihkan" />
    </p>
    <p>*( harus diisi</p>
</form>
<?php
elseif( $_GET['goto'] == 'detail' ):

$bid = getinfo_users('uid');

$global_title = 'Detail Sales';

$add_menu_detail_sales = '';

if( $_GET['detail'] == 'view' ){
$add_menu_detail_sales = '<a href="?q=transaksi" class="button" style="margin-right:5px;">Home Transaksi</a> <a href="?q=sales&goto=detail&user_id='.$uid.'" class="button" style="margin-right:5px;">&laquo; Back</a>';
}

$global_title_menu = '<div class="gd-menu2 right"><a href="?q=sales" class="button" style="margin-right:5px;">Home Sales</a>'.$add_menu_detail_sales.'<a href="?q=sales&goto=edit&user_id='.$uid.'" class="left button">Ubah</a> <a href="?q=sales&act=del&user_id='.$uid.'" class="right button"  onclick="return confirm(\'Yakin ingin menghapus data ini?\')">Hapus</a></div>';

$query_user = mysql_query("SELECT * FROM `users` WHERE `user_id`=$uid AND `user_be_id`=$bid");
$row_user= mysql_fetch_object($query_user);
$total_row_user = mysql_num_rows($query_user); 

if( $total_row_user < 1){
	redirect('?q=sales');
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
if( $_GET['detail'] == 'view' ):
$order_bulan_tahun = order_by_date('penjualan','date',true);
?>
<p>Berikut detail transaksi produk yang terjadi :</p><br />
<div id="frame-width">
<table width="100%" border="0" cellspacing="0" cellpadding="2" id="table-ui">
  <tr class="head">
    <td class="depan"  style="width: 1%; text-align:center">No</td>
    <td align="center" style="width: 55%; text-align:left">Nama Produk</td>
    <td align="center" style="width: 8%;">Qty</td>
    <td align="center" style="width: 20%;">Waktu</td>
    <td align="center" style="width: 20%; text-align:right">Total</td>
  </tr>
<?php
$i = 1;
$warna = $total_qty =  $total_uang = '';
$query_produk = mysql_query("SELECT * FROM `penjualan` LEFT JOIN `barang` ON(`barang`.`no_barang` = `penjualan`.`id_barang`) WHERE `penjualan`.`id_retailer`=".$retailer_id." AND `penjualan`.`id_users`='$uid' $order_bulan_tahun ORDER BY `penjualan`.`date` DESC");

$total_row_produk = mysql_num_rows($query_produk); 

if( $total_row_produk < 1){
?>
  <tr class="isi">
    <td colspan="5" align="left" class="depan">Barang masih kosong</td>
  </tr>
<?php
}

while( $row_produk = mysql_fetch_object($query_produk) ){

$warna  = empty ($warna) ? ' bgcolor="#f9fbff"' : '';
?>
  <tr class="isi"<?php echo $warna?>>
    <td class="depan" align="center"><?php echo $i?></td>
    <td align="left"><?php echo $row_produk->nama_barang?></td>
    <td align="center"><?php echo $row_produk->jumlah_terjual?></td>
    <td align="center"><?php echo dateformat( $row_produk->date,true )?></td>
    <td align="right">Rp. <?php echo noformat( $row_produk->harga_satuan * $row_produk->jumlah_terjual )?></td>
  </tr>
<?php
$i++; 
$total_qty = $total_qty + $row_produk->jumlah_terjual;
$total_uang = $total_uang + $row_produk->harga_satuan * $row_produk->jumlah_terjual;
}
?>
  <tr style="background:none">
    <td align="center" style="border-left:1px solid #ddd;border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px"><?php echo ($i-1)?></td>
    <td style="border-right:1px solid #ddd;"></td>
    <td align="center" style="border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px"><?php echo noformat( $total_qty );?></td>
    <td style="border-right:1px solid #ddd;">&nbsp;</td>
    <td align="right" style="border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px; padding-right:8px;">Rp. <?php echo noformat( $total_uang );?></td>
  </tr>
</table>
</div>
<?php
else:
?>
<p>Berikut detail transaksi retailer penjualan sales :</p><br />
<div id="frame-width">
<table width="100%" border="0" cellspacing="0" cellpadding="2" id="table-ui">
  <tr class="head">
    <td width="4%" class="depan"  style="width: 1%; text-align:center">No</td>
    <td width="57%" align="center" style="width: 50%; text-align:left">Nama Retailer</td>
    <td width="9%" align="center" style="width: 9%;">Qty</td>
    <td width="14%" align="center" style="width: 20%;">Waktu</td>
    <td width="20%" align="center" style="width: 30px">Aksi</td>
  </tr>
<?php
$i = 1;
$warna = $total_qty = '';
$query_transaksi = mysql_query("SELECT * FROM `penjualan` WHERE id_users='$uid' GROUP BY `id_retailer` ORDER BY date DESC");

$total_row_penjualan = mysql_num_rows($query_transaksi); 

if( $total_row_penjualan < 1){
?>
  <tr class="isi">
    <td colspan="5" align="left" class="depan">Transaksi masih kosong</td>
  </tr>
<?php
}

while( $row_transaksi = mysql_fetch_object($query_transaksi) ){

$warna  = empty ($warna) ? ' bgcolor="#f9fbff"' : '';
?>
  <tr class="isi"<?php echo $warna?>>
    <td class="depan" align="center"><?php echo $i?></td>
    <td align="left"><?php echo get_retailer_id( $row_transaksi->id_retailer,'nama' )?></td>
    <td align="center"><?php echo total_penjualan_retailer( $row_transaksi->id_retailer, $uid )?></td>
    <td align="center"><?php echo dateformat( $row_transaksi->date,true )?></td>
    <td align="center"><div class="action"><a href="?q=sales&goto=detail&user_id=<?php echo $row_transaksi->id_users?>&detail=view&retailer_id=<?php echo $row_transaksi->id_retailer?>" class="view">detail</a></div>
    </td>
  </tr>
<?php 
$i++;
$total_qty = $total_qty + total_penjualan_retailer( $row_transaksi->id_retailer, $uid );
}
?>
  <tr style="background:none">
    <td align="center" style="border-left:1px solid #ddd;border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px"><?php echo ($i-1)?></td>
    <td style="border-right:1px solid #ddd;">&nbsp;</td>
    <td align="center"style="border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px"><?php echo noformat( $total_qty );?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
</div>
<?php
endif;
else:
$global_title = 'Daftar Sales';
$global_title_menu = '<div class="gd-menu2 right"><a href="?q=sales&goto=add" class="button" style="margin-right:5px;">Tambah Sales Baru</a></div>';
?>
<p>Berikut adalah daftar sales Anda :</p><br />
<div id="frame-width">
<table width="100%" border="0" cellspacing="0" cellpadding="2" id="table-ui">
  <tr class="head">
    <td class="depan"  style="width: 1%; text-align:center">No</td>
    <td align="center" style="width: 45%; text-align:left">Nama Sales</td>
    <td align="center" style="width: 25%;">Handphone</td>
    <td align="center" style="width: 15%;">Aksi</td>
  </tr>
<?php
$i = 1;
$warna = $total_qty = '';
$query_user = mysql_query("SELECT * FROM users WHERE `user_be_id`='".getinfo_users('uid')."' ORDER BY nama_user ASC");
while( $row_user = mysql_fetch_object($query_user) ){

$warna  = empty ($warna) ? ' bgcolor="#f9fbff"' : '';
?>
  <tr class="isi"<?php echo $warna?>>
    <td class="depan" align="center"><?php echo $i?></td>
    <td align="left"><?php echo $row_user->nama_user?></td>
    <td align="center"><?php echo nohpformat($row_user->no_telp)?></td>
    <td align="center"><div class="action"><a href="?q=sales&goto=detail&user_id=<?php echo $row_user->user_id?>" class="view">detail</a> <a href="?q=sales&goto=edit&user_id=<?php echo $row_user->user_id?>" class="edit">edit</a> <a href="?q=sales&act=del&user_id=<?php echo $row_user->user_id?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="delete">delete</a></div></td>
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
case'transaksi':

if( $_GET['goto'] == 'send' ): send_transaksi_data();
else:

$global_title = 'Transaksi';

if( total_transaksi_retailer__by_be(true) == 0 ){
	$notif = 'href="?q=transaksi" class="button" onclick="return alert(\'Maaf tidak ada data transaksi untuk dikirim\')"';
}else{
	$notif = 'href="?q=transaksi&goto=send" class="button" onclick="return confirm(\'Yakin ingin mengirim data transaksi hari ini?\n\nPastikan data sudah periksa dan benar, jika sudah silahkan tekan OK untuk mengirim data\')"';
}

$global_title_menu = '<div class="gd-menu2 right"><a '.$notif.' style="margin-right:5px;">Pemeriksaan Selesai</a></div>';

$bid = getinfo_users('uid');
$query_bulan_tahun = query_bulan_tahun();
$order_bulan_tahun = order_by_date('penjualan','date',true);
$order_by = 'Transaksi berdasakan ' . year_month_select( 'penjualan', 'date', '?q=transaksi' );
?>
<p>Berikut detail transaksi retailer penjualan sales :</p><br />
<div id="frame-width">
<table width="100%" border="0" cellspacing="0" cellpadding="2" id="table-ui">
  <tr style="background:none;">
    <td colspan="6" align="right"><?php echo $order_by?></td>
  </tr>
  <tr class="head">
    <td width="4%" class="depan"  style="width: 1%; text-align:center">No</td>
    <td width="57%" align="center" style="width: 50%; text-align:left">Nama Sales</td>
    <td width="57%" align="center" style="width: 50%; text-align:left">Nama Retailer</td>
    <td width="14%" align="center" style="width: 20%;">Waktu</td>
    <td width="20%" align="center" style="width: 30px">Aksi</td>
  </tr>
<?php
$i = 1;
$warna = $total_qty = '';
$query_transaksi = mysql_query("SELECT * FROM penjualan LEFT JOIN users ON(users.user_id=penjualan.id_users) WHERE users.user_be_id='$bid' AND penjualan.approv_sales=1 AND penjualan.approv_be=0 $order_bulan_tahun ORDER BY date DESC");

$total_row_penjualan = mysql_num_rows($query_transaksi); 

if( $total_row_penjualan < 1){
?>
  <tr class="isi">
    <td colspan="6" align="left" class="depan">Transaksi masih kosong</td>
  </tr>
<?php
}

while( $row_transaksi = mysql_fetch_object($query_transaksi) ){

$warna  = empty ($warna) ? ' bgcolor="#f9fbff"' : '';
?>
  <tr class="isi"<?php echo $warna?>>
    <td class="depan" align="center"><?php echo $i?></td>
    <td align="left"><?php echo $row_transaksi->nama_user?></td>
    <td align="left"><?php echo get_retailer_id( $row_transaksi->id_retailer,'nama' )?></td>
    <td align="center"><?php echo dateformat( $row_transaksi->date )?></td>
    <td align="center"><div class="action"><a href="?q=sales&goto=detail&user_id=<?php echo $row_transaksi->id_users?>&detail=view&retailer_id=<?php echo $row_transaksi->id_retailer.$query_bulan_tahun;?>" class="view">detail</a></div>
    </td>
  </tr>
<?php 
$i++;
$total_qty = $total_qty + total_penjualan_retailer( $row_transaksi->id_retailer );
}
?>
  <tr style="background:none">
    <td align="center" style="border-left:1px solid #ddd;border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px"><?php echo ($i-1)?></td>
    <td colspan="4">&nbsp;</td>
  </tr>
</table>
</div>
<?php
endif;
break;
}