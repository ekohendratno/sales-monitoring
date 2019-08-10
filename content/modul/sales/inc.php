<?php
if(!defined('_exec')) exit;

function save_penjualan_sales($data){
	extract($data, EXTR_SKIP);
	
	update_stok_produk($sisa_stok,$id_barang);
	
	$sql = mysql_query("INSERT INTO penjualan (`id_retailer`,`id_barang`,`id_users`,`jumlah_terjual`,`date`) VALUES('$id_retailer','$id_barang','$id_users','$jumlah_terjual','$date')");
	
	return $sql;
	
}

function save_penjualan_sales_valid($data){
	extract($data, EXTR_SKIP);
	
	
	$id_retailer 	= esc_sql( $retailer_id );
	$id_barang 		= esc_sql( $produk_id );
	$jumlah_terjual = esc_sql( $jumlah_terjual );
	$sisa_stok 		= esc_sql( $sisa_stok_produk );
	
	$id_users 		= getinfo_users('uid');
	$date 			= date("Y-m-d H:i:s");
	
	if( empty($jumlah_terjual) ){
		 $r = '<div id="error"><strong>Error :</strong> Jumlah yang dipesan kosong</div><br>';		
	}else{
		$data = compact('id_retailer','id_barang','jumlah_terjual','sisa_stok','id_users','date');
		$save = save_penjualan_sales($data);
		
		if($save) {
			$r = '<div id="success"><strong>Success :</strong> Save penjualan sales berhasil</div><br>';
			echo redirect_html('?q=sale');
		}
	}
	
	return $r;
}

function opt_retailer($retailer_id){
	$bid = getinfo_users('bid');
	$retailer_list = js_redirect();
	$retailer_list.= '<option value="">--- Pilih ---</option>';
	$query_retailer = mysql_query("SELECT * FROM retailer WHERE id_be='$bid' AND status_retailer='1' ORDER BY nama_retailer ASC");
	while( $row_retailer = mysql_fetch_object($query_retailer) ){
		
		$selected='';
		if($retailer_id == $row_retailer->id_retailer) $selected='selected="selected"';	
		$retailer_list .= '<option value="?q=sale&retailer_id='.$row_retailer->id_retailer.'" '.$selected.'>'.$row_retailer->nama_retailer.'</option>';
	}
	
	return $retailer_list;
}

function opt_produk($retailer_id,$produk_id){
	$barang_list = js_redirect();
	$barang_list.= '<option value="">--- Pilih ---</option>';
	$query_barang = mysql_query("SELECT * FROM barang ORDER BY nama_barang ASC");
	while( $row_barang = mysql_fetch_object($query_barang) ){
		
		$selected='';
		if($produk_id==$row_barang->no_barang) $selected='selected="selected"';	
		$barang_list .= '<option value="?q=sale&retailer_id='.$retailer_id.'&produk_id='.$row_barang->no_barang.'" '.$selected.'>'.$row_barang->nama_barang.'</option>';
	}
	
	return $barang_list;
}

function del_transaksi_by_retailer($id_retailer){
	
	$query_penjualan = mysql_query("SELECT * FROM `penjualan` WHERE `id_retailer`='$id_retailer' AND `id_users`='".getinfo_users('uid')."'");
	while($row = mysql_fetch_object($query_penjualan) ){
			
		$total_stok_temp = get_stok_transaksi_by_produk_on_transaksi($row->id_retailer,$row->id_barang,$row->id_penjualan);
		$total_stok_temp = $total_stok_temp + get_product_id($row->id_barang,'stok');
		
		update_stok_produk($total_stok_temp,$row->id_barang);
		del_transaksi_pernjualan($row->id_penjualan,$row->id_retailer,$row->id_barang);
	}
}

function del_transaksi_by_produk($id_retailer,$id_barang,$id_transaksi){
	$total_stok_temp = get_stok_transaksi_by_produk_on_transaksi($id_retailer,$id_barang,$id_transaksi);
	$total_stok_temp = $total_stok_temp + get_product_id($id_barang,'stok');
	
	update_stok_produk($total_stok_temp,$id_barang);	
	del_transaksi_pernjualan($id_transaksi,$id_retailer,$id_barang);
}

function del_transaksi_pernjualan($id_transaksi,$id_retailer,$id_barang){
	mysql_query("DELETE FROM penjualan WHERE `id_penjualan`='$id_transaksi' AND `id_retailer`='$id_retailer' AND `id_barang`='$id_barang' AND `id_users`='".getinfo_users('uid')."'");
}

function get_stok_transaksi_by_produk_on_transaksi($id_retailer, $id_barang,$id_transaksi){
	
	$query_penjualan = mysql_query("SELECT * FROM `penjualan` WHERE `id_penjualan`='$id_transaksi' AND `id_retailer`='$id_retailer' AND `id_barang`='$id_barang' AND `id_users`='".getinfo_users('uid')."'");
	$row = mysql_fetch_object($query_penjualan);
		
	return $row->jumlah_terjual;
	
}

function update_stok_produk($jumlah,$no_barang){
		
	$no_barang = esc_sql($no_barang);
	$jumlah = (int) esc_sql($jumlah);
	mysql_query("UPDATE `barang` SET `jumlah_barang` = '$jumlah' WHERE `no_barang` = '$no_barang'");
}