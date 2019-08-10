<?php if(!defined('_exec')) exit;

include "inc.php";

switch( $_GET['q'] ){
default:
case'stok':
$produk_id = esc_sql( $_GET['produk_id'] );

if( $_GET['act'] == 'del' ) del_stok($produk_id);

if( $_GET['goto'] == 'add' ):

$global_title = 'Tambah Barang Baru';
$global_title_menu = '<div class="gd-menu2 right"><a href="?q=stok" class="button">&laquo; Back</a></div>';

if( isset($_POST['simpan']) ){
	$nama_barang 	= esc_sql( $_POST['nama_barang'] );
	$jumlah_stok 	= esc_sql( $_POST['jumlah_stok'] );
	$harga_satuan 	= esc_sql( $_POST['harga_satuan'] );
	
	$data = compact('nama_barang','jumlah_stok','harga_satuan');
	add_stok($data);
}
?>
<br /><p>Silahkan tambahkan stok baru pada form yang disediakan dibawah ini</p><br />
<form method="post" action="">
<p>
    <label for="nama_barang">Nama Barang *</label>
    <input type="text" name="nama_barang" style="width:99%;" id="nama_barang" />
    </p>
<p>
    <label for="jumlah_stok">Jumlah Stok *</label>
    <input type="text" name="jumlah_stok" style="width:99%;" id="jumlah_stok" />
    </p>
<p>
    <label for="harga_satuan">Harga Satuan *</label>
    <input type="text" name="harga_satuan" style="width:99%;" id="harga_satuan" />
    </p>
  <p>
    <input type="submit" name="simpan" value="Simpan" class="on" /> <input type="reset" name="Reset" value="Bersihkan" />
    </p>
    <p>*( harus diisi</p>
</form>
<?php
elseif( $_GET['goto'] == 'add-in' ):

$global_title = 'Tambah Barang Masuk';
$global_title_menu = '<div class="gd-menu2 right"><a href="?q=stok" class="button">&laquo; Back</a></div>';

if( isset($_POST['simpan']) ){
	$jumlah_stok 	= esc_sql( $_POST['jumlah_stok'] );
	$jumlah_stok_add 	= esc_sql( $_POST['jumlah_stok_add'] );
	
	$data = compact('jumlah_stok','jumlah_stok_add');
	edit_stok($data, $produk_id, true);
}
?>
<br /><p>Silahkan edit stok pada form yang disediakan dibawah ini</p><br />
<form method="post" action="">
  <p>
    <label for="produk'">Jenis Produk *</label>
    <select name="id_barang" onchange="redir(this)" style="width:100%;">
    <?php echo opt_produk($retailer_id,$produk_id)?>
    </select>
  </p> 
<p>
    <label for="jumlah_stok_exist">Jumlah Stok yang ada *</label>
    <input type="text" name="jumlah_stok_exist" style="width:99%;" id="jumlah_stok_exist" value="<?php echo get_product_id($produk_id,'stok')?>" disabled />    
    <input type="hidden" name="jumlah_stok" style="width:99%;" id="jumlah_stok" value="<?php echo get_product_id($produk_id,'stok')?>" />
    </p>
<p>
    <label for="jumlah_stok_add">Jumlah Stok Tambahan *</label>
    <input type="text" name="jumlah_stok_add" style="width:99%;" id="jumlah_stok_add" onkeyup="validasiAngka(this); stok_ditambah();" onblur="validasi_numstring(this);" />
    </p>
<p>
    <label for="jumlah_stok">Total Stok *</label>
    <input type="text" name="total_stok" style="width:99%;" id="total_stok" disabled="disabled" />
    </p>
  <p>
    <input type="submit" name="simpan" value="Simpan" class="on" /> <input type="reset" name="Reset" value="Bersihkan" />
    </p>
    <p>*( harus diisi</p>
</form>
<?php
elseif( $_GET['goto'] == 'edit' ):

$global_title = 'Ubah Barang';
$global_title_menu = '<div class="gd-menu2 right"><a href="?q=stok" class="button">&laquo; Back</a></div>';

if( isset($_POST['simpan']) ){
	$nama_barang 	= esc_sql( $_POST['nama_barang'] );
	$jumlah_stok 	= esc_sql( $_POST['jumlah_stok'] );
	$harga_satuan 	= esc_sql( $_POST['harga_satuan'] );
	
	$data = compact('nama_barang','jumlah_stok','harga_satuan');
	edit_stok($data, $produk_id);
}
?>
<br /><p>Silahkan tambahkan sales baru pada form yang disediakan dibawah ini</p><br />
<form method="post" action="">
<p>
    <label for="nama_barang">Nama Barang *</label>
    <input type="text" name="nama_barang" style="width:99%;" id="nama_barang" value="<?php echo stok_list('nama_barang',$produk_id)?>" />
    </p>
<p>
    <label for="jumlah_stok">Jumlah Stok *</label>
    <input type="text" name="jumlah_stok" style="width:99%;" id="jumlah_stok" value="<?php echo stok_list('jumlah_barang',$produk_id)?>" />
    </p>
<p>
    <label for="harga_satuan">Harga Satuan *</label>
    <input type="text" name="harga_satuan" style="width:99%;" id="harga_satuan" value="<?php echo stok_list('harga_satuan',$produk_id)?>" />
    </p>
  <p>
    <input type="submit" name="simpan" value="Simpan" class="on" /> <input type="reset" name="Reset" value="Bersihkan" />
    </p>
    <p>*( harus diisi</p>
</form>

<?php
else:
?>
<?php
$global_title = 'Stok Barang / Produk';
$global_title_menu = '<div class="gd-menu2 right"><a href="?q=sales&goto=add" class="button" style="margin-right:5px;">Tambah Barang Baru</a><a href="?q=sales&goto=add-in" class="button" style="margin-right:5px;">Tambah Stok Masuk</a></div>';
?>
<p>Berikut adalah stok produk yang ada :</p><br />
<div id="frame-width">
<table width="100%" border="0" cellspacing="0" cellpadding="2" id="table-ui">
  <tr class="head">
    <td class="depan"  style="width: 1%; text-align:center">No</td>
    <td align="center" style="width: 35%; text-align:left">Nama Produk</td>
    <td align="center" style="width: 12%;">Qty</td>
    <td align="center" style="width: 20%; text-align:right">Harga Satuan</td>
    <td align="center" style="width: 20%; text-align:right">Total</td>
    <td align="center" style="width: 15%; text-align:center">Aksi</td>
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
    <td align="center"><div class="action"><a href="?q=stok&goto=edit&produk_id=<?php echo $row_produk->no_barang?>" class="edit">edit</a> <a href="?q=stok&act=del&produk_id=<?php echo $row_produk->no_barang?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="delete">delete</a></div>
    </td>
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
    <td align="center"></td>
  </tr>
</table>
</div>
<?php
endif;
break;
case'transaksi':

if( $_GET['goto'] == 'print'):

elseif( $_GET['goto'] == 'detail'):
$global_title = 'Detail Transaksi';
$be_id = esc_sql( $_GET['be_id'] );
$user_id = esc_sql( $_GET['user_id'] );

if( $_GET['detail'] == 'be'):
$query_bulan_tahun = query_bulan_tahun();
$global_title_menu = '<div class="gd-menu2 right"><a href="?q=transaksi" class="button" style="margin-right:5px">&laquo;  </a> <a target="_blank" href="?print&be_id='.$be_id.$query_bulan_tahun.'" class="button">Cetak</a></div>';

$query_bulan_tahun = order_by_date('penjualan','date',true);

$query_user = mysql_query("SELECT * FROM `users` WHERE `user_id`='$be_id'");
$row_user= mysql_fetch_object($query_user);
$total_row_user = mysql_num_rows($query_user); 

if( $total_row_user < 1){
	redirect('?q=transaksi');
}
?>
<div id="frame-width">
<table width="100%" border="0" cellspacing="2" cellpadding="1">
  <tr>
    <td width="4%" rowspan="7" align="left" valign="top"><img src="content/uploads/<?php echo $row_user->gambar?>"  class="avatar2"/></td>
    <td width="18%" align="left" valign="top">Nama</td>
    <td width="1%" align="left" valign="top"><strong>:</strong></td>
    <td width="77%" align="left" valign="top"><?php echo $row_user->nama_user;?></td>
  </tr>
  <tr>
    <td align="left" valign="top">Area</td>
    <td align="left" valign="top"><strong>:</strong></td>
    <td align="left" valign="top"><?php echo $row_user->area;?></td>
  </tr>
</table>
</div>
<br />
<p>Berikut detail transaksi retailer penjualan sales :</p><br />
<div id="frame-width">
<table width="100%" border="0" cellspacing="0" cellpadding="2" id="table-ui">
  <tr class="head">
    <td class="depan"  style="width: 1%; text-align:center">No</td>
    <td align="center" style="width: 15%; text-align:left">Nama Sales</td>
    <td align="center" style="width: 75%; text-align:left">Retailer</td>
  </tr>
<?php
$i = 1;
$warna = $total_qty = '';
$query_transaksi = mysql_query("SELECT * FROM penjualan LEFT JOIN users ON(users.user_id=penjualan.id_users) WHERE users.user_be_id='$be_id' $query_bulan_tahun GROUP BY penjualan.id_users ORDER BY date DESC");

$total_row_penjualan = mysql_num_rows($query_transaksi); 

if( $total_row_penjualan < 1){
?>
  <tr class="isi">
    <td colspan="4" align="left" class="depan">Transaksi masih kosong</td>
  </tr>
<?php
}

while( $row_transaksi = mysql_fetch_object($query_transaksi) ){
?>
  <tr class="isi" style="background:none">
    <td class="depan" align="center"><?php echo $i?></td>
    <td align="left"><?php echo $row_transaksi->nama_user?></td>
    <td align="left" style="padding:0;">
<?php

$user_id = $row_transaksi->id_users;

$i = 1;
$warna = $total_qty2 = $all_total_uang2 = 0;

$query_retailer = mysql_query("SELECT * FROM `penjualan` LEFT JOIN users ON (users.user_id=penjualan.id_users) WHERE penjualan.id_users='$user_id' $query_bulan_tahun GROUP BY penjualan.id_retailer");

?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" id="table-ui">
  <tbody>
  <tr>
    <td class="depan" style="width: 1%; text-align:center; border-left:none; background:#f8f8f8"><strong>No</strong></td>
    <td align="center" style="width: 25%; text-align:left;border-right:none; background:#f8f8f8"><strong>Retailer</strong></td>
    <td align="center" style="width: 25%; text-align:left;border-left:1px solid #ddd; background:#f8f8f8"><strong>Produk</strong></td>
    <td align="center" style="width: 10%; background:#f8f8f8"><strong>Qty</strong></td>
    <td align="center" style="width: 20%; border-right:none; background:#f8f8f8"><strong>Total</strong></td>
  </tr>
  <?php
  while( $row_retailer = mysql_fetch_object($query_retailer) ){
	  
  $query_produk = mysql_query("SELECT * FROM `penjualan` LEFT JOIN users ON (users.user_id=penjualan.id_users) WHERE penjualan.id_users='$user_id' AND penjualan.id_retailer='$row_retailer->id_retailer' $query_bulan_tahun");
  $total_produk = mysql_num_rows($query_produk);
  $rowspan = $all_total_uang1 = $all_total_qty1 = '';
  if($total_produk > 0) $rowspan = ' rowspan="'.( $total_produk + 3 ).'"';
  ?>
  <tr class="isi">
    <td<?php echo $rowspan?> align="center" class="depan" style="border-left:none"><?php echo $i?></td>
    <td<?php echo $rowspan?> align="left" style="border-right:none"><strong><?php echo get_retailer_id($row_retailer->id_retailer,'nama')?></strong><br><?php echo get_retailer_id($row_retailer->id_retailer,'alamat')?></td>
    <td colspan="3" align="left" style="border-right:none">&nbsp;</td>
  </tr>
  <?php  
  while( $row_produk = mysql_fetch_object($query_produk) ){
	  $jumlah_terjual = $row_produk->jumlah_terjual;
	  $jumlah_harga_terjual = $jumlah_terjual * get_product_id($row_produk->id_barang,'harga');
  ?>
  <tr class="isi">
    <td align="left" style="border-left:1px solid #ddd;"><?php echo get_product_id($row_produk->id_barang,'nama')?></td>
    <td align="center"><?php echo noformat( $jumlah_terjual )?></td>
    <td align="center" style="border-right:none"><?php echo rp_show( $jumlah_harga_terjual ).' '.noformat( $jumlah_harga_terjual )?></td>
  </tr>
  <?php
	$all_total_qty1 = $all_total_qty1 + $jumlah_terjual;
	$all_total_uang1 = $all_total_uang1 + $jumlah_harga_terjual;
  }
  ?>
	    
    <tr style="background:none">
      <td align="left" style="border-right:1px solid #ddd;border-left:1px solid #ddd">&nbsp;</td>
      <td align="center" style="border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px; background:#FFC;"><?php echo noformat( $all_total_qty1 )?></td>
      <td align="center" style="border-right:none;border-bottom:1px solid #ddd; padding:3px; background:#FFC"><?php echo rp_show($all_total_uang1).' '.noformat( $all_total_uang1 );?></td>
    </tr>
    <tr style="background:none">
        <td colspan="3" align="left" style="border-bottom:1px solid #ddd;border-right:none;border-left:1px solid #ddd">&nbsp;</td>
    </tr>
    
  <?php
  $i++;
  $all_total_qty2 = $all_total_qty2 + $all_total_qty1;
  $all_total_uang2 = $all_total_uang2 + $all_total_uang1;
  }
  ?>
      <tr style="background:none">
        <td align="center" style="border-left:none;border-right:1px solid #ddd;border-bottom:none; padding:3px"><?php echo $i?></td>
        <td colspan="2" style="border-right:1px solid #ddd; border-bottom:none"></td>
        <td align="center" style="border-right:1px solid #ddd;border-bottom:none; padding:3px; background:#FF9"><?php echo $all_total_qty2?></td>
        <td align="center" style="border-right:none;border-bottom:none; padding:3px; background:#FF9"><?php echo rp_show($all_total_uang2).' '.noformat( $all_total_uang2 );?></td>
    </tr>
</tbody></table>

    </td>
  </tr>
<?php 
$i++;
$total_qty = $total_qty + total_penjualan_retailer( $row_transaksi->id_retailer );
}
?>
  <tr style="background:none">
    <td align="center" style="border-left:1px solid #ddd;border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px"><?php echo ($i-1)?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
</div>
<?php

elseif( $_GET['detail'] == 'sales'):
$query_bulan_tahun = order_by_date('penjualan','date',true);
$global_title_menu = '<div class="gd-menu2 right"><a href="?q=transaksi" class="button">&laquo; Kembali</a></div>';

$i = 1;
$total_qty2 = $all_total_uang2 = 0;

$query_retailer = mysql_query("SELECT * FROM `penjualan` LEFT JOIN users ON (users.user_id=penjualan.id_users) WHERE penjualan.id_users='$user_id' $query_bulan_tahun GROUP BY penjualan.id_retailer");

?>
<div id="frame-width">
<table width="100%" border="0" cellspacing="0" cellpadding="2" id="table-ui">
  <tbody>
  <tr class="head">
    <td class="depan" style="width: 1%; text-align:center">No</td>
    <td align="center" style="width: 25%; text-align:left;border-right:none">Retailer</td>
    <td align="center" style="width: 25%; text-align:left;border-left:1px solid #ddd;">Produk</td>
    <td align="center" style="width: 10%;">Qty</td>
    <td align="center" style="width: 20%;">Total</td>
  </tr>
  <?php
  while( $row_retailer = mysql_fetch_object($query_retailer) ){
	  
  $query_produk = mysql_query("SELECT * FROM `penjualan` LEFT JOIN users ON (users.user_id=penjualan.id_users) WHERE penjualan.id_users='$user_id' AND penjualan.id_retailer='$row_retailer->id_retailer' $query_bulan_tahun");
  $total_produk = mysql_num_rows($query_produk);
  
  $rowspan = $all_total_uang1 = $all_total_qty1 = '';
  if($total_produk > 0) $rowspan = ' rowspan="'.( $total_produk + 3 ).'"';
  ?>
  <tr class="isi"<?php echo $warna?>>
    <td<?php echo $rowspan?> align="center" class="depan"><?php echo $i?></td>
    <td<?php echo $rowspan?> align="left" style="border-right:none"><strong><?php echo get_retailer_id($row_retailer->id_retailer,'nama')?></strong><br><?php echo get_retailer_id($row_retailer->id_retailer,'alamat')?></td>
    <td colspan="3" align="left">&nbsp;</td>
  </tr>
  <?php  
  while( $row_produk = mysql_fetch_object($query_produk) ){
	  $jumlah_terjual = $row_produk->jumlah_terjual;
	  $jumlah_harga_terjual = $jumlah_terjual * get_product_id($row_produk->id_barang,'harga');
  ?>
  <tr class="isi">
    <td align="left" style="border-left:1px solid #ddd;"><?php echo get_product_id($row_produk->id_barang,'nama')?></td>
    <td align="center"><?php echo noformat( $jumlah_terjual )?></td>
    <td align="center"><?php echo rp_show( $jumlah_harga_terjual ).' '.noformat( $jumlah_harga_terjual )?></td>
  </tr>
  <?php
	$all_total_qty1 = $all_total_qty1 + $jumlah_terjual;
	$all_total_uang1 = $all_total_uang1 + $jumlah_harga_terjual;
  }
  ?>
	    
    <tr style="background:none">
      <td align="left" style="border-right:1px solid #ddd;border-left:1px solid #ddd">&nbsp;</td>
      <td align="center" style="border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px; background:#FFC"><?php echo noformat( $all_total_qty1 )?></td>
      <td align="center" style="border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px; background:#FFC"><?php echo rp_show($all_total_uang1).' '.noformat( $all_total_uang1 );?></td>
    </tr>
    <tr style="background:none">
        <td colspan="3" align="left" style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;border-left:1px solid #ddd">&nbsp;</td>
    </tr>
    
  <?php
  $i++;
  $all_total_qty2 = $all_total_qty2 + $all_total_qty1;
  $all_total_uang2 = $all_total_uang2 + $all_total_uang1;
  }
  ?>
      <tr style="background:none">
        <td align="center" style="border-left:1px solid #ddd;border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px"><?php echo $i?></td>
        <td colspan="2" style="border-right:1px solid #ddd;"></td>
        <td align="center" style="border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px; background:#FF9"><?php echo $all_total_qty2?></td>
        <td align="center" style="border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px; background:#FF9"><?php echo rp_show($all_total_uang2).' '.noformat( $all_total_uang2 );?></td>
    </tr>
</tbody></table>
</div>
<?php

endif;
else:

?>
<!--Show Dialog-->
<div id="redactor_modal_print"  class="redactor_modal" style="width: 350px; max-width:95%; height: auto;display: none; ">
<div id="redactor_modal_close">&times;</div>
<div id="redactor_modal_header">Opsi Laporan</div>
<div id="redactor_modal_inner">
<form method="get" action="./" enctype="multipart/form-data">
<input type="hidden" name="q" value="laporan" />
<input type="hidden" name="goto" value="report" />
<label>Area</label>
<?php echo area_select();?><br />
<label>Bulan/Tahun</label>
<?php echo year_month_select( 'penjualan', 'date', '?q=transaksi', false );?><br />
<input type="submit" name="buat" value="Buat Laporan" class="button on" />
</form>
</div>
</div>
<!--Show End Dialog-->
<?php
//halaman utama
$global_title = 'Transaksi';

$query_bulan_tahun = query_bulan_tahun();

if( $available_year == 1 ) $onclick = 'onclick="javascript:$(\'#redactor_modal_print\').showX()"';
else $onclick = 'onclick="return alert(\'Data belum tersedia/data masih kosong\')"';

$global_title_menu = '<div class="gd-menu2 right"><a href="javascript:void(0);" '.$onclick.' class="button">Buat Laporan</a></div>';

$order_by = 'Transaksi berdasakan ' . year_month_select( 'penjualan', 'date', '?q=transaksi' );
?>
<p>Berikut laporan transaksi penjualan:</p><br />
<div id="frame-width">
<table width="100%" border="0" cellspacing="0" cellpadding="2" id="table-ui">
  <tr style="background:none;">
    <td colspan="6" align="right"><?php echo $order_by?></td>
  </tr>
  <tr class="head">
    <td class="depan"  style="width: 1%; text-align:center">No</td>
    <td align="center" style="width: 25%; text-align:left;border-right:none">Area</td>
    <td align="center" style="width: 25%; text-align:left;border-left:1px solid #ddd;">Sales</td>
    <td align="center" style="width: 10%;">Qty</td>
    <td align="center" style="width: 20%;">Total</td>
    <td align="center" style="width: 5%;">Aksi</td>
  </tr>
<?php

$i = 1;
$warna = $total_qty2 = $all_total_uang2 = 0;
$query_users_be = mysql_query("SELECT * FROM users WHERE `jabatan`='be' ORDER BY `nama_pengguna` ASC");

while( $row_users_be = mysql_fetch_object($query_users_be) ){
$warna  = empty ($warna) ? ' bgcolor="#f9fbff"' : '';

$query_users_sales = mysql_query("SELECT * FROM users WHERE `jabatan`='sales' AND `user_be_id`='$row_users_be->user_id'");
$total_users_sales = mysql_num_rows($query_users_sales);
$rowspan = $all_total_uang1 = $all_total_qty1 = '';
if($total_users_sales > 0) $rowspan = ' rowspan="'.( $total_users_sales + 3 ).'"';
?>
  <tr class="isi">
    <td<?php echo $rowspan?> align="center" class="depan"><?php echo $i?></td>
    <td<?php echo $rowspan?> align="left" style="border-right:none"><strong><?php echo $row_users_be->area?></strong><br /><?php echo $row_users_be->nama_user?></td>
    <td colspan="3" align="left">&nbsp;</td>
    <td align="center"><div class="action"><a href="?q=transaksi&goto=detail&detail=be&be_id=<?php echo $row_users_be->user_id . $query_bulan_tahun?>" class="view">detail</a></div></td>
  </tr>
	<?php 
    while( $row_users_sales = mysql_fetch_object($query_users_sales) ){
		$total_qty_penjualan_by_sales = penjualan_by_sales( $row_users_sales->user_be_id, $row_users_sales->user_id );
		$total_harga_penjualan_by_sales = penjualan_by_sales( $row_users_sales->user_be_id, $row_users_sales->user_id,'harga' );
	?>
  <tr class="isi">
    <td align="left" style="border-left:1px solid #ddd;"><?php echo $row_users_sales->nama_user?></td>
    <td align="center"><?php echo noformat( $total_qty_penjualan_by_sales )?></td>
    <td align="center"><?php echo rp_show($total_harga_penjualan_by_sales).' '.noformat( $total_harga_penjualan_by_sales )?></td>
    <td align="center"><div class="action"><a href="?q=transaksi&goto=detail&detail=sales&be_id=<?php echo $row_users_sales->user_be_id?>&user_id=<?php echo $row_users_sales->user_id . $query_bulan_tahun?>" class="view">detail</a></div></td>
  </tr>
	<?php 
	$all_total_qty1 = $all_total_qty1 + $total_qty_penjualan_by_sales;
	$all_total_uang1 = $all_total_uang1 + $total_harga_penjualan_by_sales;
	}
	?>    
    <tr style="background:none">
      <td align="left" style="border-right:1px solid #ddd;border-left:1px solid #ddd">&nbsp;</td>
      <td align="center" style="border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px; background:#FFC"><?php echo noformat( $all_total_qty1 );?></td>
      <td align="center" style="border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px; background:#FFC"><?php echo rp_show($all_total_uang1).' '.noformat( $all_total_uang1 );?></td>
      <td align="center" style="border-right:1px solid #ddd;">&nbsp;</td>
    </tr>
    <tr style="background:none">
        <td colspan="4" align="left" style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;border-left:1px solid #ddd">&nbsp;</td>
    </tr>
    <?php
	$i++;
	$all_total_qty2 = $all_total_qty2 + $all_total_qty1;
	$all_total_uang2 = $all_total_uang2 + $all_total_uang1;
}
?>
  <tr style="background:none">
    <td align="center" style="border-left:1px solid #ddd;border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px"><?php echo ($i-1)?></td>
    <td colspan="2" style="border-right:1px solid #ddd;"></td>
    <td align="center" style="border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px; background:#FF9"><?php echo noformat( $all_total_qty2 );?></td>
    <td align="center" style="border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px; background:#FF9"><?php echo rp_show($all_total_uang2).' '.noformat( $all_total_uang2 );?></td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<?php
endif;
break;
case'laporan':

if( $_GET['goto'] == 'report'){
?>
<style type="text/css">
#body{ width:820px; }
div > div.nav-top { width:820px; }
</style>
<?php
}


if( $_GET['goto'] == 'report' ):
$be_id = esc_sql( $_GET['be_id'] );
$query_bulan_tahun = query_bulan_tahun();

$global_title = 'Laporan Penjualan';
$global_title_menu = '<div class="gd-menu2 right"><a target="_blank" href="?print&be_id='.$be_id.$query_bulan_tahun.'" class="button" style="margin-right:5px">Cetak laporan ini</a><a href="?q=transaksi" class="button">&laquo; Back</a></div>';
?>

<!--
<style type="text/css">
#body{ width:820px; }
div > div.nav-top { width:820px; }
</style>
-->
<?php

$query_bulan_tahun = order_by_date('penjualan','date',true);

$query_user = mysql_query("SELECT * FROM `users` WHERE `user_id`='$be_id'");
$row_user= mysql_fetch_object($query_user);
$total_row_user = mysql_num_rows($query_user); 

if( $total_row_user < 1){
	redirect('?q=transaksi');
}
?>
<div id="laporan-penjualan"><div class="laporan-penjualan-border">
<div class="laporan-penjualan-company">PT. HUTCHISON CP TELECOMMUNICATIONS</div>
<div class="laporan-penjualan-addr">Jl. RA. Kartini No.4E Bandar lampung</div>
<div class="laporan-penjualan-title">Laporan Penjualan</div>
</div></div>
<div id="frame-width">
<table width="100%" border="0" cellspacing="2" cellpadding="1">
  <tr>
    <td width="4%" rowspan="7" align="left" valign="top"><img src="content/uploads/<?php echo $row_user->gambar?>"  class="avatar2"/></td>
    <td width="7%" align="left" valign="top">Nama</td>
    <td width="1%" align="left" valign="top"><strong>:</strong></td>
    <td width="88%" align="left" valign="top"><?php echo $row_user->nama_user;?></td>
  </tr>
  <tr>
    <td align="left" valign="top">Area</td>
    <td align="left" valign="top"><strong>:</strong></td>
    <td align="left" valign="top"><?php echo $row_user->area;?></td>
  </tr>
</table>
</div>
<br />
<p>Berikut detail transaksi retailer penjualan sales :</p><br />
<div id="frame-width">
<table width="100%" border="0" cellspacing="0" cellpadding="2" id="table-ui">
  <tr class="head">
    <td class="depan"  style="width: 1%; text-align:center">No</td>
    <td align="center" style="width: 15%; text-align:left">Nama Sales</td>
    <td align="center" style="width: 75%; text-align:left">Retailer</td>
  </tr>
<?php
$i = 1;
$warna = $total_qty = '';
$query_transaksi = mysql_query("SELECT * FROM penjualan LEFT JOIN users ON(users.user_id=penjualan.id_users) WHERE users.user_be_id='$be_id' AND approv_be=1 $query_bulan_tahun GROUP BY penjualan.id_users ORDER BY date DESC");

$total_row_penjualan = mysql_num_rows($query_transaksi); 

if( $total_row_penjualan < 1){
?>
  <tr class="isi">
    <td colspan="4" align="left" class="depan">Transaksi masih kosong</td>
  </tr>
<?php
}

while( $row_transaksi = mysql_fetch_object($query_transaksi) ){
?>
  <tr class="isi" style="background:none">
    <td class="depan" align="center"><?php echo $i?></td>
    <td align="left"><?php echo $row_transaksi->nama_user?></td>
    <td align="left" style="padding:0;">
<?php

$user_id = $row_transaksi->id_users;

$i = 1;
$warna = $total_qty2 = $all_total_uang2 = 0;

$query_retailer = mysql_query("SELECT * FROM `penjualan` LEFT JOIN users ON (users.user_id=penjualan.id_users) WHERE penjualan.id_users='$user_id' AND approv_be=1 $query_bulan_tahun GROUP BY penjualan.id_retailer");

?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" id="table-ui">
  <tbody>
  <tr>
    <td class="depan" style="width: 1%; text-align:center; border-left:none; background:#f8f8f8"><strong>No</strong></td>
    <td align="center" style="width: 25%; text-align:left;border-right:none; background:#f8f8f8"><strong>Retailer</strong></td>
    <td align="center" style="width: 25%; text-align:left;border-left:1px solid #ddd; background:#f8f8f8"><strong>Produk</strong></td>
    <td align="center" style="width: 10%; background:#f8f8f8"><strong>Qty</strong></td>
    <td align="center" style="width: 20%; border-right:none; background:#f8f8f8"><strong>Total</strong></td>
  </tr>
  <?php
  while( $row_retailer = mysql_fetch_object($query_retailer) ){
	  
  $query_produk = mysql_query("SELECT * FROM `penjualan` LEFT JOIN users ON (users.user_id=penjualan.id_users) WHERE penjualan.id_users='$user_id' AND penjualan.id_retailer='$row_retailer->id_retailer' AND approv_be=1 $query_bulan_tahun");
  $total_produk = mysql_num_rows($query_produk);
  $rowspan = $all_total_uang1 = $all_total_qty1 = '';
  if($total_produk > 0) $rowspan = ' rowspan="'.( $total_produk + 3 ).'"';
  ?>
  <tr class="isi">
    <td<?php echo $rowspan?> align="center" class="depan" style="border-left:none"><?php echo $i?></td>
    <td<?php echo $rowspan?> align="left" style="border-right:none"><strong><?php echo get_retailer_id($row_retailer->id_retailer,'nama')?></strong><br><?php echo get_retailer_id($row_retailer->id_retailer,'alamat')?></td>
    <td colspan="3" align="left" style="border-right:none">&nbsp;</td>
  </tr>
  <?php  
  while( $row_produk = mysql_fetch_object($query_produk) ){
	  $jumlah_terjual = $row_produk->jumlah_terjual;
	  $jumlah_harga_terjual = $jumlah_terjual * get_product_id($row_produk->id_barang,'harga');
  ?>
  <tr class="isi">
    <td align="left" style="border-left:1px solid #ddd;"><?php echo get_product_id($row_produk->id_barang,'nama')?></td>
    <td align="center"><?php echo noformat( $jumlah_terjual )?></td>
    <td align="center" style="border-right:none"><?php echo rp_show( $jumlah_harga_terjual ).' '.noformat( $jumlah_harga_terjual )?></td>
  </tr>
  <?php
	$all_total_qty1 = $all_total_qty1 + $jumlah_terjual;
	$all_total_uang1 = $all_total_uang1 + $jumlah_harga_terjual;
  }
  ?>
	    
    <tr style="background:none">
      <td align="left" style="border-right:1px solid #ddd;border-left:1px solid #ddd">&nbsp;</td>
      <td align="center" style="border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px; background:#FFC;"><?php echo noformat( $all_total_qty1 )?></td>
      <td align="center" style="border-right:none;border-bottom:1px solid #ddd; padding:3px; background:#FFC"><?php echo rp_show($all_total_uang1).' '.noformat( $all_total_uang1 );?></td>
    </tr>
    <tr style="background:none">
        <td colspan="3" align="left" style="border-bottom:1px solid #ddd;border-right:none;border-left:1px solid #ddd">&nbsp;</td>
    </tr>
    
  <?php
  $i++;
  $all_total_qty2 = $all_total_qty2 + $all_total_qty1;
  $all_total_uang2 = $all_total_uang2 + $all_total_uang1;
  }
  ?>
      <tr style="background:none">
        <td align="center" style="border-left:none;border-right:1px solid #ddd;border-bottom:none; padding:3px"><?php echo $i?></td>
        <td colspan="2" style="border-right:1px solid #ddd; border-bottom:none"></td>
        <td align="center" style="border-right:1px solid #ddd;border-bottom:none; padding:3px; background:#FF9"><?php echo $all_total_qty2?></td>
        <td align="center" style="border-right:none;border-bottom:none; padding:3px; background:#FF9"><?php echo rp_show($all_total_uang2).' '.noformat( $all_total_uang2 );?></td>
    </tr>
</tbody></table>

    </td>
  </tr>
<?php 
$i++;
$total_qty = $total_qty + total_penjualan_retailer( $row_transaksi->id_retailer );
}
?>
  <tr style="background:none">
    <td align="center" style="border-left:1px solid #ddd;border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px"><?php echo ($i-1)?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
</div>
<div style="clear:both"></div>
<div align="right" style="padding-bottom:20px; padding-top:20px;">
<table width="27%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td>Bandar Lampung, <?php echo query_bulan_tahun_laporan()?></td>
  </tr>
  <tr>
    <td style="padding-top:10px; font-weight:bold;">Pimpinan</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>(....................................................)</td>
  </tr>
</table>
</div>

<?php
else:

endif;


break;
}