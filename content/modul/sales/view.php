<?php
if(!defined('_exec')) exit;

include "inc.php";

switch( $_GET['q'] ){
default:
case'sale':
$global_title = 'Jualan';
$retailer_id = esc_sql( $_GET['retailer_id'] );
$produk_id = esc_sql( $_GET['produk_id'] );

if( isset( $_POST['simpan'] ) ){
	$jumlah_terjual = esc_sql( $_POST['jumlah_barang'] );
	$sisa_stok_produk = esc_sql( $_POST['sisa_stok_produk'] );
	
	$data = compact('retailer_id','produk_id','jumlah_terjual','sisa_stok_produk');
	echo save_penjualan_sales_valid($data);
}

?>
<form method="post" action="">
  <p>
    <label for="nr">Nama Retailer *</label>
    <select name="id_retailer" id="nr" onchange="redir(this)" style="width:100%;">
    <?php echo opt_retailer($retailer_id)?>
    </select>
  <?php 
  if( !empty($retailer_id) ):
  ?>
    <label for="alamat">Alamat</label>
    <textarea name="alamat" id="alamat" style="width:99%; height:50px" disabled><?php echo get_retailer_id($retailer_id,'alamat')?></textarea>
  </p>
  <p>
    <label for="produk'">Jenis Produk *</label>
    <select name="id_barang" onchange="redir(this)" style="width:100%;">
    <?php echo opt_produk($retailer_id,$produk_id)?>
    </select>
  </p>  
  <?php 
  if( !empty($produk_id) ):
  ?>
    <p>
    <label for="harga_barang">Harga Produk (Rp.)</label>
    <input type="text" name="harga_barang" id="harga_barang" style="width:99%;" value="<?php echo get_product_id($produk_id,'harga')?>" disabled />
    </p>
    <p>
    <label for="stok_barang">Stok Produk</label>
    <input type="text" name="stok_barang" style="width:99%;" id="jumlah_stok_produk" value="<?php echo get_product_id($produk_id,'stok')?>" disabled />
    </p>
    <p>
    <label for="jumlah_barang">Jumlah yang dipesan *</label>
    <input type="text" name="jumlah_barang" style="width:99%;" id="jumlah_barang_dipesan" onkeyup="validasiAngka(this); sale_dipesan();" onblur="validasi_numstring(this);"  />
    </p>
    <p>
    <label for="sisa_stok_produk">Sisa Stok Produk</label>
    <input type="text" name="sisa_stok_produk" style="width:99%;" id="sisa_stok_produk" disabled />
    <input type="hidden" name="sisa_stok_produk" style="width:99%;" id="sisa_stok_produk_after" />
    </p>
    <p>
    <label for="total_harga_barang">Jumlah uang yang harus dibayar (Rp.)</label>
    <input type="text" name="total_harga_barang" style="width:99%;" id="total_harga_barang" disabled />
    </p>
    <p>
    <input type="submit" name="simpan" value="Simpan" />
    </p>
  <?php endif;endif;?>
    <p>*( bisa di ubah atau diisi</p>
</form>

<?php
break;
case'transaksi':

if( $_GET['goto'] == 'send' ):

send_transaksi_data();

elseif( $_GET['goto'] == 'detail' ):

$retailer_id = esc_sql( $_GET['retailer_id'] );
$produk_id = esc_sql( $_GET['produk_id'] );
$transaksi_id = esc_sql( $_GET['transaksi_id'] );

$global_title = 'Detail Transaksi';
$global_title_menu = '<div class="gd-menu2 right"><a href="?q=transaksi" class="button">Home</a></div>';

if( $_GET['act'] == 'del' ) del_transaksi_by_produk($retailer_id, $produk_id, $transaksi_id);

if( $_GET['orderby'] == 'all' ){
	$order_query = "";
}elseif( $_GET['orderby'] == 'month' ){
	$order_query = "AND month(`penjualan`.`date`) = '".date('m')."' AND year(`penjualan`.`date`) = '".date('Y')."'";
}else{
	$order_query = "AND day(`penjualan`.`date`) = '".date('d')."' AND month(`penjualan`.`date`) = '".date('m')."' AND year(`penjualan`.`date`) = '".date('Y')."'";
}

$query_transaksi = mysql_query("SELECT * FROM `penjualan` WHERE id_users='".getinfo_users('uid')."' AND `id_retailer`='$retailer_id' $order_query");
$row_transaksi = mysql_fetch_object($query_transaksi);
$total_row_penjualan = mysql_num_rows($query_transaksi); 

if( $total_row_penjualan < 1){
	redirect('?q=transaksi');
}
?>
<div id="frame-width">
<table width="100%" border="0" cellspacing="2" cellpadding="1">
  <tr>
    <td width="12%" align="left" valign="top">Nama</td>
    <td width="1%" align="left" valign="top"><strong>:</strong></td>
    <td width="87%" align="left" valign="top"><?php echo get_retailer_id( $row_transaksi->id_retailer,'nama' );?></td>
  </tr>
  <tr>
    <td align="left" valign="top">Alamat</td>
    <td align="left" valign="top"><strong>:</strong></td>
    <td align="left" valign="top"><?php echo get_retailer_id( $row_transaksi->id_retailer,'alamat' );?></td>
  </tr>
</table>
</div>
<br />
<p>Berikut detail transaksi produk yang terjadi :</p><br />
<div id="frame-width">
<table width="100%" border="0" cellspacing="0" cellpadding="2" id="table-ui">
  <tr class="head">
    <td class="depan"  style="width: 1%; text-align:center">No</td>
    <td align="center" style="width: 55%; text-align:left">Nama Produk</td>
    <td align="center" style="width: 8%;">Qty</td>
    <td align="center" style="width: 20%;">Waktu</td>
    <td align="center" style="width: 20%;">Total</td>
    <td align="center" style="width: 8%;">Aksi</td>
  </tr>
<?php
$i = 1;
$warna = $total_qty =  $total_uang = '';
$query_produk = mysql_query("SELECT * FROM `penjualan` LEFT JOIN `barang` ON(`barang`.`no_barang` = `penjualan`.`id_barang`) WHERE `penjualan`.`id_retailer`=".$retailer_id." AND `penjualan`.`id_users`=".getinfo_users('uid')." AND `approv_sales` = '0' $order_query ORDER BY `penjualan`.`date` DESC");

$total_row_produk = mysql_num_rows($query_produk); 

if( $total_row_produk < 1){
?>
  <tr class="isi">
    <td colspan="6" align="left" class="depan">Barang masih kosong</td>
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
    <td align="center"><?php echo dateformat( $row_produk->date )?></td>
    <td align="center">Rp. <?php echo noformat( $row_produk->harga_satuan * $row_produk->jumlah_terjual )?></td>
    <td align="center"><div class="action"><a href="?q=transaksi&goto=detail&retailer_id=<?php echo $retailer_id?>&act=del&produk_id=<?php echo $row_produk->id_barang?>&transaksi_id=<?php echo $row_produk->id_penjualan?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="delete">delete</a></div></td>
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
    <td align="center" style="border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px">Rp. <?php echo noformat( $total_uang );?></td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<?php
else:
$global_title = 'Transaksi';

if( $_GET['orderby'] == 'all' ){
	$word_orderby = 'Semua';
	$link_orderby = '&orderby=all';
	$order_query = "GROUP BY `id_retailer` ORDER BY date DESC";
}elseif( $_GET['orderby'] == 'month' ){
	$word_orderby = 'Bulan ini';
	$link_orderby = '&orderby=month';
	$order_query = "AND month(date) = '".date('m')."' AND year(date) = '".date('Y')."' GROUP BY `id_retailer` ORDER BY date DESC";
}else{
	$word_orderby = 'Hari ini';
	$link_orderby = '&orderby=today';
	$order_query = "AND day(date) = '".date('d')."' AND month(date) = '".date('m')."' AND year(date) = '".date('Y')."' GROUP BY `id_retailer` ORDER BY date DESC";
}

if( total_transaksi_retailer__by_sales(true) == 0 ){
	$notif = 'href="?q=transaksi" class="button" onclick="return alert(\'Maaf tidak ada data transaksi untuk dikirim\')"';
}else{
	$notif = 'href="?q=transaksi&goto=send'.$link_orderby.'" class="button" onclick="return confirm(\'Yakin ingin mengirim data transaksi hari ini?\n\nPastikan data sudah periksa dan benar, jika sudah silahkan tekan OK untuk mengirim data\')"';
}


$global_title_menu = '<div class="gd-menu2 right"><a href="?q=transaksi&orderby=today" class="button left">Hari ini</a><a href="?q=transaksi&orderby=month" class="button middle">Bulan ini</a><a href="?q=transaksi&orderby=all" class="button right">Semua</a><a '.$notif.' style="margin-left:5px;">Kirim Transaksi '.$word_orderby.'</a></div>';

$retailer_id = esc_sql( $_GET['retailer_id'] );
if( $_GET['act'] == 'del' ) del_transaksi_by_retailer($retailer_id);

?>
<p>Berikut detail transaksi retailer penjualan anda :</p><br />
<div id="frame-width">
<table width="100%" border="0" cellspacing="0" cellpadding="2" id="table-ui">
  <tr class="head">
    <td width="4%" class="depan"  style="width: 1%; text-align:center">No</td>
    <td width="57%" align="center" style="width: 35%; text-align:left">Nama Retailer</td>
    <td width="9%" align="center" style="width: 9%;">Qty</td>
    <td width="14%" align="center" style="width: 20%;">Total</td>
    <td width="14%" align="center" style="width: 15%;">Waktu</td>
    <td width="20%" align="center" style="width: 20px">Aksi</td>
  </tr>
<?php
$i = 1;
$warna = $total_qty = '';
$query_transaksi = mysql_query("SELECT * FROM `penjualan` WHERE `id_users`='".getinfo_users('uid')."' AND `approv_sales` = '0' $order_query");

$total_row_penjualan = mysql_num_rows($query_transaksi); 

if( $total_row_penjualan < 1){
?>
  <tr class="isi">
    <td colspan="6" align="left" class="depan">Transaksi masih kosong</td>
  </tr>
<?php
}

$tatal_bayar_retailer = 0;
while( $row_transaksi = mysql_fetch_object($query_transaksi) ){

$warna  = empty ($warna) ? ' bgcolor="#f9fbff"' : '';

$tatal_bayar_qty = (total_penjualan_retailer( $row_transaksi->id_retailer ) * get_product_id($row_transaksi->id_barang,'harga'));
?>
  <tr class="isi"<?php echo $warna?>>
    <td class="depan" align="center"><?php echo $i?></td>
    <td align="left"><?php echo get_retailer_id( $row_transaksi->id_retailer,'nama' )?></td>
    <td align="center"><?php echo total_penjualan_retailer( $row_transaksi->id_retailer )?></td>
    <td align="right"><?php echo noformat( $tatal_bayar_qty )?></td>
    <td align="center"><?php echo dateformat( $row_transaksi->date, true )?></td>
    <td align="center"><div class="action"><a href="?q=transaksi&goto=detail&retailer_id=<?php echo $row_transaksi->id_retailer . $link_orderby?>" class="view">detail</a> <a href="?q=transaksi&act=del&retailer_id=<?php echo $row_transaksi->id_retailer?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="delete">delete</a></div>
    </td>
  </tr>
<?php 
$i++;
$tatal_bayar_retailer = $tatal_bayar_retailer + $tatal_bayar_qty;
$total_qty = $total_qty + total_penjualan_retailer( $row_transaksi->id_retailer );
}
?>
  <tr style="background:none">
    <td align="center" style="border-left:1px solid #ddd;border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px"><?php echo ($i-1)?></td>
    <td style="border-right:1px solid #ddd;">&nbsp;</td>
    <td align="center" style="border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px"><?php echo noformat( $total_qty );?></td>
    <td align="right" style="border-right:1px solid #ddd;border-bottom:1px solid #ddd; padding:3px; padding-right:8px;">Rp. <?php echo noformat( $tatal_bayar_retailer );?></td>
    <td colspan="2">&nbsp;</td>
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
    <td align="center" style="width: 25%; text-align:right">Harga Satuan</td>
  </tr>
<?php
$i = 1;
$warna = '';
$query_produk = mysql_query("SELECT * FROM `barang` ORDER BY nama_barang ASC");
while( $row_produk = mysql_fetch_object($query_produk) ){

$warna  = empty ($warna) ? ' bgcolor="#f9fbff"' : '';
?>
  <tr class="isi"<?php echo $warna?>>
    <td class="depan" align="center"><?php echo $i?></td>
    <td align="left"><?php echo $row_produk->nama_barang?></td>
    <td align="right"><?php echo noformat( $row_produk->harga_satuan  )?></td>
  </tr>
<?php
$i++; 
}
?>
</table>
</div>
<?php
break;
}
?>