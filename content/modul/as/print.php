<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="ui/home/css/style.css" rel="stylesheet" />
<link href="ui/home/css/table.css" rel="stylesheet" />
<title>Print</title>
</head>

<body>

<script language=javascript>
function printWindow() {
	bV = parseInt(navigator.appVersion);
	if (bV >= 4) window.print();
}
printWindow();
</script>

<style type="text/css">
#print-body{
	width:860px;
	margin:10px auto;
	padding:5px;
	background:#fff;
}
</style>

<div id="print-body">

<?php $be_id = esc_sql( $_GET['be_id'] );?>

<style type="text/css">
#body{ width:820px; }
div > div.nav-top { width:820px; }
</style>
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
<br />
<p>Berikut detail transaksi retailer penjualan sales :</p><br />
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
</div>

</body>
</html>