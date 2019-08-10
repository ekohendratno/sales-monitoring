<?php
if(!defined('_exec')) exit;

function add_stok($data){
	$data = validasi_add_stok($data);
	
	if( !is_array($data) )
		return false;
	
	extract($data, EXTR_SKIP);
	
	$nama_barang 	= esc_sql( $nama_barang );
	$jumlah_barang 	= esc_sql( $jumlah_stok );
	$harga_satuan 	= esc_sql( $harga_satuan );
	
	$data = compact('nama_barang','harga_satuan','jumlah_barang');
	insert_stok($data);	

}

function validasi_add_stok($data){
	extract($data, EXTR_SKIP);
	
	$error = array();
	if( empty($nama_barang) ) $error[]= 'Nama Barang kosong';
	if( empty($jumlah_stok) ) $error[]= 'Jumlah Stok kosong';
	if( empty($harga_satuan) ) $error[]= 'harga Satuan kosong';
	
	if( $error ){
		foreach($error as $message) echo '<div id="error"><strong>Error :</strong> '.$message.'</div>';
		return false;
	}else return $data;
}

function insert_stok($data){
	$add_query = implode_insert($data);
	
	$query_users = mysql_query("INSERT INTO `barang` $add_query");
	
	if($query_users){
		echo '<div id="success"><strong>Success :</strong> Save stok berhasil</div><br>';
		echo redirect_html('?q=stok&goto=add');
	}
}

function del_stok($produk_id){	
	return mysql_query("DELETE FROM barang WHERE `no_barang`='$produk_id'");
}

function stok_list($field, $produk_id){
	$query_stok = mysql_query("SELECT * FROM barang WHERE `no_barang`='$produk_id'");
	$data_stok = mysql_fetch_array( $query_stok );
	
	if( !empty($field) )
	return $data_stok[$field];
}

function edit_stok($data, $produk_id, $type = false){
	
	if( $type ){
		
		if( !is_array($data) )
			return false;
		
		extract($data, EXTR_SKIP);
		
		$jumlah_barang 		= esc_sql( $jumlah_stok );
		$jumlah_stok_add 	= esc_sql( $jumlah_stok_add );
		$jumlah_barang 		= $jumlah_barang+$jumlah_stok_add;
	
		$no_barang			= esc_sql( $produk_id );	
		update_stok(compact('jumlah_barang'),compact('no_barang'));
	}else{
		$data = validasi_edit_stok($data);
		
		if( !is_array($data) )
			return false;
		
		extract($data, EXTR_SKIP);
		
		$nama_barang 	= esc_sql( $nama_barang );
		$jumlah_barang 	= esc_sql( $jumlah_stok );
		$harga_satuan 	= esc_sql( $harga_satuan );
		
		$no_barang		= esc_sql( $produk_id );	
		
		$data = compact('nama_barang','jumlah_barang','harga_satuan');
		update_stok($data,compact('no_barang'));
	}

}

function validasi_edit_stok($data){
	extract($data, EXTR_SKIP);
	
	$error = array();
	if( empty($nama_barang) ) $error[]= 'Nama barang kosong';
	if( empty($jumlah_stok) ) $error[]= 'Stok barang kosong';
	if( empty($harga_satuan) ) $error[]= 'Harga satuan kosong';
	
	if( $error ){
		foreach($error as $message) echo '<div id="error"><strong>Error :</strong> '.$message.'</div>';
		return false;
	}else return $data;
}

function update_stok($data, $where){
	extract($where, EXTR_SKIP);
	
	$add_query = implode_update($data,$where);
	
	$query_users = mysql_query("UPDATE `barang` $add_query");
	
	if($query_users){
		echo '<div id="success"><strong>Success :</strong> Save stok berhasil</div><br>';
		echo redirect_html('?q=stok&goto=edit&produk_id='.$no_barang.'');
	}
	
}

function opt_produk($retailer_id,$produk_id){
	$barang_list = js_redirect();
	$barang_list.= '<option value="">--- Pilih ---</option>';
	$query_barang = mysql_query("SELECT * FROM barang ORDER BY nama_barang ASC");
	while( $row_barang = mysql_fetch_object($query_barang) ){
		
		$selected='';
		if($produk_id == $row_barang->no_barang) $selected='selected="selected"';	
		$barang_list .= '<option value="?q=sales&goto=add-in&produk_id='.$row_barang->no_barang.'" '.$selected.'>'.$row_barang->nama_barang.'</option>';
	}
	
	return $barang_list;
}