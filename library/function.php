<?php
if(!defined('_exec')) exit;

function getinfo_users( $param, $user_id = false, $be_id = false ){ 
	$user_log = esc_sql( $_SESSION['Log_User'] );
	
	if( $user_id &&  $be_id ) $add_query = "WHERE user_id='$user_id' AND  user_be_id='$be_id'";
	if( $user_id ) $add_query = "WHERE user_id='$user_id'";
	else $add_query = "WHERE nama_pengguna='$user_log'";
	
	if( check_login() )	{
		$mysql_query = mysql_query("SELECT * FROM users $add_query");
		$data = mysql_fetch_object( $mysql_query );	
		
		$param_default = array(
		'uid' 		=> 'user_id',
		'bid' 		=> 'user_be_id',
		'user' 		=> 'nama_pengguna',
		'sandi'		=> 'kata_sandi',
		'mail' 		=> 'email',
		'jabatan' 	=> 'jabatan',
		'nama' 		=> 'nama_user',
		'sex' 		=> 'jenis_kelamin',
		'alamat' 	=> 'alamat',
		'telp' 		=> 'no_telp',
		'area' 		=> 'area',
		'gambar' 	=> 'gambar',
		'status'	=> 'status_account');
		
		if( in_array($param, array_keys($param_default) ) )
		return $data->$param_default[$param];
		
	}else return false;
}

function show_on( $param ){
	$log_level = esc_sql( $_SESSION['Log_Level'] );
	$param_default = array('sales','be','as','administrator');
	if( check_level() && in_array($param,$param_default) ){
		if( $param == $log_level ) return true;
	}
}

function header_nav(){
	echo '<div class="nav-fix shadow-bottoms">';
	echo '<div class="nav-top">';
	echo '<div class="left">';
	echo '<ul class="mainMenu tiptip">';
    echo '<li class="topNavLink"><a href="./" class="tip" title="Home"><div class="icon menuHome"></div></a></li>';
	if( show_on( 'sales' ) ){
    echo '<li class="topNavLink"><a href="?q=sale" class="tip" title="Sale"><div class="icon menuSalers"></div><div class="icon menuSalesName">Jualanku</div></a></li>';
	}
	if( show_on( 'administrator' ) || show_on( 'be' ) ){
    echo '<li class="topNavLink"><a href="?q=retailer" class="tip" title="Retailer"><div class="icon menuRetailer"></div><div class="icon menuRetailerName">Retail</div></a>'.total_retailer().'</li>';
	}
	if(  show_on( 'sales' ) || show_on( 'be' ) || show_on( 'as' ) ){
    echo '<li class="topNavLink"><a href="?q=stok" class="tip" title="Stock Goods"><div class="icon menuStockGoods"></div><div class="icon menuStockGoodsName">Stok</div></a>';
	if( !show_on( 'sales' ) ) echo total_stok();
	echo '</li>';
	
	}
	if( show_on( 'sales' ) || show_on( 'be' ) || show_on( 'as' ) ){
    echo '<li class="topNavLink"><a href="?q=transaksi" class="tip" title="Transaksi Penjualan"><div class="icon menuSalers"></div><div class="icon menuSalersName">Transaksi</div></a>';
	
	//echo total_transaksi_retailer_by();
	
	echo '</li>';
	
	}
	/*
	if( show_on( 'as' )  ){
    echo '<li class="topNavLink"><a href="?q=prestasi" class="tip" title="Prestasi Penjualan"><div class="icon menuPrestasi"></div><div class="icon menuPrestasiName">Prestasi</div></a><span class="jTips">1</span></li>';
	}*/
	if( show_on( 'be' ) ){
    echo '<li class="topNavLink"><a href="?q=sales" class="tip" title="Sales"><div class="icon menuSales"></div><div class="icon menuSalesName">Sales</div></a>'.total_sales().'</li>';
	}
	if( show_on( 'administrator' ) ){
    echo '<li class="topNavLink"><a href="?q=member" class="tip" title="Sales"><div class="icon menuSales"></div><div class="icon menuSalesName">Member</div></a>'.total_member().'</li>';
	}
	
	echo '</ul>';
	echo '</div>';
	echo '<div class="right">';
	echo '<ul class="mainMenu tiptip">';
	
    echo '<li class="topNavLink"><a href="?q=profile" class="tip" title="Profileku"><img class="img" src="content/uploads/'.getinfo_users('gambar').'" alt=""><span class="headerTinymanName">' . upper_character_first( getinfo_users('nama') ). '</span></a></li>';
    echo '<li class="topNavLink"><a href="?q=logout" class="tip" title="Keluar dari aplikasi" onclick="return confirm(\'Benar ingin keluar dari system monitoring ini?\')"><div class="icon menuLogOut"></div></a></li>';
	
	echo '</ul>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
}

function upper_character_first($str){
    $str[0] = strtr($str,
    "abcdefghijklmnopqrstuvwxyz".
    "\x9C\x9A\xE0\xE1\xE2\xE3".
    "\xE4\xE5\xE6\xE7\xE8\xE9".
    "\xEA\xEB\xEC\xED\xEE\xEF".
    "\xF0\xF1\xF2\xF3\xF4\xF5".
    "\xF6\xF8\xF9\xFA\xFB\xFC".
    "\xFD\xFE\xFF",
    "ABCDEFGHIJKLMNOPQRSTUVWXYZ".
    "\x8C\x8A\xC0\xC1\xC2\xC3\xC4".
    "\xC5\xC6\xC7\xC8\xC9\xCA\xCB".
    "\xCC\xCD\xCE\xCF\xD0\xD1\xD2".
    "\xD3\xD4\xD5\xD6\xD8\xD9\xDA".
    "\xDB\xDC\xDD\xDE\x9F");
    return $str;
}

function dateformat($str,$time = false){
	$str = strtotime($str);
	if( $time ) return date("Y/m/d",$str);
	else  return date("Y/m/d H:i:s",$str);
}

function noformat($num){
	if((int)$num) 
	return number_format ($num, 0 , ',' , '.' );
}

function nohpformat($num){
	return "+62" . number_format ($num, null,null, '-' );
}

function sexformat($string){
	if( $string == 'l' )return 'Laki-laki';
	elseif( $string == 'p' )return 'Perempuan';
	else return 'unknow';
}

function statusformat($string){
	if( $string == '1' )return 'Aktif';
	elseif( $string == '0' )return 'Tidak Aktif';
	else return 'unknow';
}

function js_redirect() {
	return '<script language="javascript">function redir(mylist){ if (newurl=mylist.options[mylist.selectedIndex].value)document.location=newurl;}</script>'."\n";
}

function redirect($url=null){
	global $site_home;
	
	if( !empty($url) ) 
	{
		if(!preg_match("/^http/", $url)) $base_url = $site_home.$url;
		else $base_url = $url;
	}
	else $base_url = $site_home;
	
    if (!headers_sent()){ 
        header('Location: '.$base_url); exit;
    }else{ 
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$base_url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$base_url.'" />';
        echo '</noscript>'; exit;
    }
}

function redirect_html( $url, $time = 0.5 ){ 
	global $site_home;
		if( !empty($url) ) 
		{
			if(!preg_match("/^http/", $url)) $base_url = $site_home.$url;
			else $base_url = $url;
		}
		else $base_url = $site_home;
	
    return '<meta http-equiv="refresh" content="'.$time.';url='.$base_url.'" />';
}

function get_retailer_id( $id, $param ){
	
	$id = esc_sql( $id );
	$param = esc_sql( $param );
	
	if( check_login() )	{
		$mysql_query = mysql_query("SELECT * FROM retailer WHERE `id_retailer`='$id'");
		$data = mysql_fetch_object( $mysql_query );	
		
		$param_default = array(
		'id' 		=> 'id_retailer',
		'be' 		=> 'id_be',
		'nama' 		=> 'nama_retailer',
		'alamat' 	=> 'alamat_retailer',
		'status' 	=> 'status_retailer');
		
		if( in_array($param, array_keys($param_default) ) )
		return $data->$param_default[$param];
		
	}else return false;
}

function get_product_id( $id, $param ){
	
	$id = esc_sql( $id );
	$param = esc_sql( $param );
	
	if( check_login() )	{
		$mysql_query = mysql_query("SELECT * FROM barang WHERE `no_barang`='$id'");
		$data = mysql_fetch_object( $mysql_query );	
		
		$param_default = array(
		'no' 		=> 'no_barang',
		'nama' 		=> 'nama_barang',
		'harga' 	=> 'harga_satuan',
		'stok' 		=> 'jumlah_barang');
		
		if( in_array($param, array_keys($param_default) ) )
		return $data->$param_default[$param];
		
	}else return false;
}

function get_transaksi_id( $id_retailer, $id_barang, $param ){
	
	$id_retailer = esc_sql( $id_retailer );
	$id_barang = esc_sql( $id_barang );
	$param = esc_sql( $param );
	
	if( check_login() )	{
		$mysql_query = mysql_query("SELECT * FROM penjualan WHERE `id_retailer`='$id' AND `id_barang`='$id_barang'");
		$data = mysql_fetch_object( $mysql_query );	
		
		$param_default = array(
		'pid' 		=> 'id_penjualan',
		'bid' 		=> 'id_barang',
		'uid' 		=> 'id_users',
		'rid' 		=> 'id_retailer',
		'terjual' 	=> 'jumlah_terjual',
		'approv' 	=> 'disetujui_oleh',
		'date' 		=> 'date');
		
		if( in_array($param, array_keys($param_default) ) )
		return $data->$param_default[$param];
		
	}else return false;
}

function total_penjualan_retailer( $id, $user_id = false ){
	
	if($user_id) $uid = esc_sql( $user_id );
	else $uid = getinfo_users('uid');
	
	$data = array('id_retailer' => $id,'id_users' => $uid);	
	return total_penjualan_by($data, true);	
}

function total_penjualan_by( $data, $where = false ){
	
	if ( ! is_array( $data ) )
		return false;	
	
	$add_query = '';
	if( $where ) $add_query = 'WHERE '.implode_where( $data );
	
	$total = 0;
	$mysql_query = mysql_query("SELECT * FROM penjualan $add_query");
	while( $data = mysql_fetch_object( $mysql_query ) ){
		$total = $total + $data->jumlah_terjual;
	}
	
	return $total;
	
}
	
function implode_where( $where ){
	if ( ! is_array( $where ) )
		return false;
				
	$wheres = $field_types = array();
	foreach ( (array) $where as $field => $value) {
		
		if ( isset( $field_types[$field] ) )
			$form = $field_types[$field];
		else
			$form = esc_sql(  $value );
			
		$wheres[] = $field."='$form'";
	}
	return implode( ' AND ', $wheres );
}

function implode_insert( $data ){
	if ( ! is_array( $data ) )
		return false;
				
	$fields_key = array_keys( $data );
	$fields_value = array();
	
	foreach ( $data as $field => $value ) {
		$fields_value[] = esc_sql( $value );
	}
	
	$sql = "(`" . implode( '`,`', $fields_key ) . "`) VALUES ('" . implode( "','", $fields_value ) . "')";
	return $sql;
}

function implode_update($data,$where){
	if ( ! is_array( $data ) )
		return false;
		
	if ( ! is_array( $where ) )
		return false;
		
	$datas = $field_types = array();
	foreach ( (array) $data as $field => $value) {
		
		if ( isset( $field_types[$field] ) )
			$form = $field_types[$field];
		else
			$form = esc_sql(  $value );
			
		$datas[] = "`$field` = '{$form}'";
	}
	
	return "SET " . implode( ', ', $datas ) . ' WHERE ' . implode_where($where);
}

function tot_row_transaksi($add_query = ''){
	
	$query_penjualan = mysql_query("SELECT * FROM `penjualan` $add_query");
	$total = mysql_num_rows($query_penjualan);
	return $total;
}

function relasi_transaksi_users($bid,$type = false){
	
	if( show_on( 'sales' ) ) $add_query = "";
	elseif( show_on( 'be' ) ) $add_query = "AND `penjualan`.`approv_sales` = '1' AND `penjualan`.`approv_be` = '0'";
	elseif( show_on( 'as' ) ) $add_query = "AND `penjualan`.`approv_sales` = '0'";
	elseif( show_on( 'administrator' ) ) $add_query = "";
	else $add_query = "";
	
	if($type == 'w') $add_query = "WHERE users.user_be_id='$bid' $add_query";
	elseif($type == 'g') $add_query = "WHERE users.user_be_id='$bid' AND users.user_id !='$bid' $add_query GROUP BY users.user_id";
	else $add_query = '';
	
	
	$mysql_query = mysql_query("SELECT * FROM penjualan LEFT JOIN users ON(users.user_id=penjualan.id_users) $add_query");
	return $mysql_query;
}

function penjualan_by_sales($be_id,$sales_id, $param = 'qty'){
	$be_id = esc_sql( $be_id );
	$sales_id = esc_sql( $sales_id );
	
	
	$add_query = "";
	if( show_on('be') ) $add_query = "AND penjualan.approv_sales=1 AND penjualan.approv_be=0";
	elseif( show_on('as') ) $add_query = "AND penjualan.approv_be=1";
	
	$total_qty = $total_harga = 0;
	$add_query_order_date = order_by_date( 'penjualan', 'date', true );
	$query_penjualan = "SELECT * FROM `penjualan` LEFT JOIN users ON(users.user_id=penjualan.id_users) WHERE users.user_id='$sales_id' AND users.user_be_id='$be_id' $add_query $add_query_order_date";
	$query_penjualan = mysql_query( $query_penjualan );
	
	while( $row_penjualan = mysql_fetch_object($query_penjualan) ){
		$total_qty = $total_qty + $row_penjualan->jumlah_terjual;
		$total_harga = $total_harga + ($row_penjualan->jumlah_terjual * get_product_id($row_penjualan->id_barang,'harga'));
	}
		
	if( $param == 'qty' ) return $total_qty;
	elseif( $param == 'harga' ) return $total_harga;		
	
}

function total_transaksi_retailer__by_sales($ret = false){
	
	$uid = getinfo_users('uid');
	
	if( show_on( 'sales' ) ) $add_query = "AND `approv_sales` = '0'";
	else $add_query = "";
	
	$total_retailer_all = tot_row_transaksi("WHERE `id_users`='$uid' $add_query");
	$total_retailer = tot_row_transaksi("WHERE `id_users`='$uid' $add_query GROUP BY `id_retailer`");
	
	$total = ($total_retailer_all/$total_retailer);
	
	if( $ret ) return $total; 
	elseif($total != 0) return '<span class="jTips">'.$total_retailer_all.'/'.$total_retailer.'</span>'; 
	
}

function total_transaksi_retailer__by_be($ret = false){	
	$bid = getinfo_users('uid');	
	/*
	 * total transaksi sales by bid
	 */
	$mysql_query_w = relasi_transaksi_users($bid,'w');
	$total_transaksi_w = mysql_num_rows( $mysql_query_w );	
	/*
	 * total transaksi sales by bed = bid and uid not same bid and grup by uid
	 */
	$mysql_query_g = relasi_transaksi_users($bid,'g');
	$total_transaksi_g = mysql_num_rows( $mysql_query_g );
	
	$total = ($total_transaksi_w/$total_transaksi_g);
	
	if( $ret ) return $total; 
	elseif($total != 0) return '<span class="jTips">'.$total_transaksi_w.'/'.$total_transaksi_g.'</span>';
}

function relasi_penjualan_users($add_query = ''){
	return mysql_query("SELECT * FROM `penjualan` LEFT JOIN users ON(`users`.`user_id`=`penjualan`.`id_users`) $add_query");
}

function total_transaksi_retailer__by_as($ret = false){
	$query_bulan_tahun = order_by_date('penjualan','date',false);
	$query_users_be = mysql_query("SELECT * FROM `penjualan` LEFT JOIN users ON(`users`.`user_id`=`penjualan`.`id_users`) GROUP BY user_be_id");
	$query_users_be = relasi_penjualan_users('GROUP BY user_be_id');
	$query_users_sales = relasi_penjualan_users();
	
	$total_be = mysql_num_rows($query_users_be);
	$total_sales = mysql_num_rows($query_users_sales);
	
	if( $ret ) return $total; 
	elseif($total_be != 0) return '<span class="jTips">'.$total_sales.'/'.$total_be.'</span>';
}

function total_transaksi_retailer__by_administrator(){
	return total_transaksi_retailer__by_be();
}

function total_transaksi_retailer_by(){
	if( show_on( 'sales' ) ) return total_transaksi_retailer__by_sales();
	elseif( show_on( 'be' ) ) return total_transaksi_retailer__by_be();
	elseif( show_on( 'as' ) ) return total_transaksi_retailer__by_as();
	elseif( show_on( 'administrator' ) ) return total_transaksi_retailer__by_administrator();
	else return 'unknow';
}


function total_stok(){
	$total_qty = '';
	$query_produk = mysql_query("SELECT * FROM `barang`");
	$total = mysql_num_rows($query_produk);
	while( $row_produk = mysql_fetch_object($query_produk) ){
		$total_qty = $total_qty + $row_produk->jumlah_barang;
	}
	$total = noformat( $total_qty ) . '/' .$total;
	return '<span class="jTips">'.$total.'</span>';
}

function total_sales(){
	$bid = getinfo_users('uid');
	$jabatan = getinfo_users('jabatan');
	
	if($jabatan == 'be') $add_query = "WHERE `user_be_id`='$bid'";
	elseif($jabatan == 'administrator') $add_query = "WHERE `user_be_id`=0";
	else $add_query = '';
		
	$mysql_query = mysql_query("SELECT * FROM users $add_query");
	$total = mysql_num_rows($mysql_query);
	
	return '<span class="jTips">'.$total.'</span>';
}

function total_member(){
		
	$mysql_query = mysql_query("SELECT * FROM users WHERE jabatan != 'sales'");
	$total = mysql_num_rows($mysql_query);
	
	return '<span class="jTips">'.$total.'</span>';
}

function total_retailer(){
	
		$add_query = "WHERE id_be != ''";
	if( show_on( 'be' ) )
		$add_query = "WHERE id_be != '' AND id_be = '".getinfo_users('uid')."'";
		
	$mysql_query = mysql_query("SELECT * FROM retailer $add_query");
	$total = mysql_num_rows($mysql_query);
	
	return '<span class="jTips">'.$total.'</span>';
}

function check_username($nama){
	$nama = esc_sql($nama);
	
	$mysql_query = mysql_query("SELECT * FROM users WHERE nama_pengguna='$nama'");
	$num = mysql_num_rows( $mysql_query );
	return $num;
}

function valid_username($string){
	return !preg_match("/[^a-zA-Z0-9_-]/", $string);
}

function valid_email($string){	
	$pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$";
	
	if( eregi($pattern, $string) ) return true;
	else return false;
}

function send_transaksi_data(){
	
	if( show_on( 'sales' ) ) {
		
		if( $_GET['orderby'] == 'all' ){
			$order_query = "";
		}elseif( $_GET['orderby'] == 'month' ){
			$order_query = "AND month(`date`) = '".date('m')."' AND year(`date`) = '".date('Y')."'";
		}else{
			$order_query = "AND day(`date`) = '".date('d')."' AND month(`date`) = '".date('m')."' AND year(`date`) = '".date('Y')."'";
		}
		
		$add_query_where = "WHERE `id_users`='".getinfo_users('uid')."' AND `approv_sales`='0' $order_query";
		$add_query_update = "SET `approv_sales` = '1'";
	}elseif( show_on( 'be' ) ) {
		$add_query_where = "LEFT JOIN users ON(users.user_id=penjualan.id_users) WHERE users.user_be_id='".getinfo_users('uid')."' AND penjualan.approv_sales='1'";
		$add_query_update = "SET `approv_sales` = '1',`approv_be` = '1'";
	}elseif( show_on( 'as' ) ) {
		$add_query_where = "";
		$add_query_update = "";
	}elseif( show_on( 'administrator' ) ) {
		$add_query_where = "";
		$add_query_update = "";
	}else {
		$add_query_where = "";
		$add_query_update = "";
	}
	$run_update = '';
	$query_transaksi = mysql_query("SELECT * FROM `penjualan` $add_query_where");
	while( $row_transaksi = mysql_fetch_object($query_transaksi) ){
		$run_update.= mysql_query("UPDATE `penjualan` ".$add_query_update." WHERE `id_penjualan` = '".$row_transaksi->id_penjualan."'");
	}
	if( $run_update ){
	 	echo '<div id="success"><strong>Success :</strong> Data berhasil terkirim dan kami segera memprosess</div><br>';
		echo redirect_html('?q=transaksi',2);
	}
}

function total_harga_penjualan_by_sales($id){
	$total_uang = 0;
	$query_produk = mysql_query("SELECT * FROM `penjualan` LEFT JOIN `barang` ON(`barang`.`no_barang` = `penjualan`.`id_barang`) WHERE  `penjualan`.`id_users`='$id' AND `approv_sales` = '1' AND `approv_be` = '1'");
	while( $row_produk = mysql_fetch_object($query_produk) ){
		$total_uang = $total_uang + $row_produk->harga_satuan * $row_produk->jumlah_terjual;
	}
	return $total_uang;
}

function rp_show($string){	
	if( !empty($string) ) return 'Rp.';
	else return '-';
}

function _month_select( $link, $js = true ){
	
	$month_select = (int) esc_sql( $_GET['bulan'] );
	$year_select = (int) esc_sql( $_GET['tahun'] );
	
	if( empty($month_select) ) $month_select = date('m');
	if( empty($year_select) ) $year_select = date('Y');	
	
	if( !empty($year_select) ) $link = $link . '&tahun=' . $year_select;
	
	$bulan_array = array('01' => '1','02' => '2','03' => '3','04' => '4','05' => '5','06' => '6','07' => '7','08' => '8','09' => '9','10' => '10','11' => '11','12' => '12');
	
	if( $js ) { $option = js_redirect();
		$onchange = 'onchange="redir(this)"';
	}else $option = $onchange = '';
	
	$option.= '<select name="bulan" '.$onchange.'>';
	
	if( count( $bulan_array ) == 0 )
		$option.='<option value="">NaN</option>';
	else
		$option.='<option value="">Pilih</option>';
	
	foreach($bulan_array as $key => $val){		
		
		$selected = '';
		if( $val == $month_select ) $selected = 'selected="selected"';
		
		if( $js ) $value = $link .'&bulan='. $val;
		else $value = $val;
		
		$option.='<option value="' . $value . '" '.$selected.'>' . convert_bln( $key ) . '</option>';
	}
	$option.= '</select>';
	return $option;
}

function _years_select( $table, $name_field_date, $link, $js = true ){	
	global $available_year;
	
	$month_select = esc_sql( $_GET['bulan'] );
	$year_select = esc_sql( $_GET['tahun'] );
	
	$add_query = '';
	if( show_on('be') ) $add_query = "WHERE approv_sales=1 AND approv_be=0";
	elseif( show_on('as') ) $add_query = "WHERE approv_be=1";
	
	if( empty($month_select) ) $month_select = date('m');
	if( empty($year_select) ) $year_select = date('Y');	
	
	if( !empty($month_select) ) $link = $link . '&bulan=' . $month_select;
	
	if( $js ) {
		$option = js_redirect();
		$onchange = 'onchange="redir(this)"';
	}else $option = $onchange = '';
	
	$option.= '<select name="tahun" '.$onchange.'>';
	
	$query_select = "SELECT date_format( `$name_field_date` , '%Y' ) AS `date_time` FROM `$table` $add_query GROUP BY `date_time` DESC";
	$query_select = mysql_query( $query_select );
	
	if( mysql_num_rows( $query_select ) == 0 ){
		$available_year = 0;
		$option.='<option value="">NaN</option>';
	}else{
		$available_year = 1;
		$option.='<option value="">Pilih</option>';
	}
	
	while( $row_select = mysql_fetch_object($query_select) ){
		
		$selected = '';
		if( $row_select->date_time == $year_select ) $selected = 'selected="selected"';
		
		if( $js ) $value = $link .'&tahun='. $row_select->date_time;
		else $value = $row_select->date_time;
		
		$option.='<option value="' . $value . '" '.$selected.'>' . $row_select->date_time . '</option>';
	}
	$option.= '</select>';
	
	return $option;
}

function year_month_select($table, $name_field_date, $link, $js = true ){	
	global $available_year;
	return _month_select(  $link, $js ) .' / '. _years_select( $table,  $name_field_date,  $link, $js );
}

function order_by_date( $table, $field_date, $and = false ){	
	//order_by_date( 8, null, true );	
	
	$month_select = (int) esc_sql( $_GET['bulan'] );
	$year_select = (int) esc_sql( $_GET['tahun'] );
	
	$bulan = (int) esc_sql( $month_select );
	$tahun = (int) esc_sql( $year_select );

	if( empty($bulan) ) $bulan = date('m');
	if( empty($tahun) ) $tahun = date('Y');	
	
	if( !empty($and) ) $and = "AND ";
	else $and = '';
	
	$bulan = convert_bln2($bulan);
	
	if( !empty($month_select) && empty($month_select) ) $query = "month(`$table`.`$field_date`) = '$bulan'";
	elseif( empty($year_select) && !empty($year_select) ) $query = "year(`$table`.`$field_date`) = '$tahun'";
	elseif( !empty($month_select) && !empty($year_select) ) $query = "month(`$table`.`$field_date`) = '$bulan' AND year(`$table`.`$field_date`) = '$tahun'";
	else $query = "month(`$table`.`$field_date`) = '$bulan' AND year(`$table`.`$field_date`) = '$tahun'";
	
	return $and . $query;
}

function query_bulan_tahun( $get_method = true ){
	
	$bulan = $tahun = '';
	if( $get_method ){
		$month_select = (int) esc_sql( $_GET['bulan'] );
		$year_select = (int) esc_sql( $_GET['tahun'] );
		
		$bulan = (int) esc_sql( $month_select );
		$tahun = (int) esc_sql( $year_select );
	}

	if( empty($bulan) ) $bulan = date('m');
	if( empty($tahun) ) $tahun = date('Y');	
	
	$bulan = convert_bln2( $bulan, true );
	
	return "&bulan=$bulan&tahun=$tahun";
}

function query_bulan_tahun_today(){	
	return query_bulan_tahun( false );
}

function query_bulan_tahun_laporan( $get_method = true ){
	
	$hari = $bulan = $tahun = '';
	if( $get_method ){
		$day_select = (int) esc_sql( $_GET['hari'] );
		$month_select = (int) esc_sql( $_GET['bulan'] );
		$year_select = (int) esc_sql( $_GET['tahun'] );
		
		$hari = (int) esc_sql( $day_select );
		$bulan = (int) esc_sql( $month_select );
		$tahun = (int) esc_sql( $year_select );
	}

	if( empty($hari) ) $hari = date('d');
	if( empty($bulan) ) $bulan = date('m');
	if( empty($tahun) ) $tahun = date('Y');	
	
	$bulan = convert_bln3( $bulan );
	
	return $hari.' '.$bulan.' '.$tahun;
}

function convert_bln($param){
	$bln 	= array(
	'01' 	=> 'Januari',
	'02' 	=> 'Februari',
	'03' 	=> 'Maret',
	'04' 	=> 'April',
	'05' 	=> 'Mei',
	'06' 	=> 'Juni',
	'07' 	=> 'Juli',
	'08' 	=> 'Agustus',
	'09' 	=> 'September',
	'10' 	=> 'Oktober',
	'11' 	=> 'Nopember',
	'12' 	=> 'Desember'
	);
	return $bln[$param];
}

function convert_bln2( $param, $key = false ){
	$bulan_array = array('01' => '1','02' => '2','03' => '3','04' => '4','05' => '5','06' => '6','07' => '7','08' => '8','09' => '9','10' => '10','11' => '11','12' => '12');
	foreach($bulan_array as $key => $val){	
		if( $key ) if( $key == $param ) return $val; 
		else if( $val == $param ) return $key; 
	}
}

function convert_bln3($param){
	$bln 	= array(
	'1' 	=> 'Januari',
	'2' 	=> 'Februari',
	'3' 	=> 'Maret',
	'4' 	=> 'April',
	'5' 	=> 'Mei',
	'6' 	=> 'Juni',
	'7' 	=> 'Juli',
	'8' 	=> 'Agustus',
	'9' 	=> 'September',
	'10' 	=> 'Oktober',
	'11' 	=> 'Nopember',
	'12' 	=> 'Desember'
	);
	return $bln[$param];
}

function area_select($be_id){
	$option = '<select name="be_id" style="width:100%;">';
	
	$query_select = "SELECT * FROM users WHERE `user_be_id`='0' AND `area`!='0' AND `jabatan`='be' GROUP BY area ORDER BY area";
	$query_select = mysql_query( $query_select );
	
	while( $row_select = mysql_fetch_object($query_select) ){	
		$selected = '';
		if( $be_id == $row_select->user_id ) $selected = 'selected="selected"';
		$option.='<option value="' . $row_select->user_id . '" '.$selected.'>' . $row_select->area . ' - '. $row_select->nama_user .'</option>';
	}
	$option.= '</select>';
	return $option;
}

function convert_jabatan( $string ){
	if( strtolower($string) == 'administrator' ) $string = "Administrator";
	elseif( strtolower($string) == 'as' ) $string = "Admin Support";
	elseif( strtolower($string) == 'be' ) $string = "Businnes Executive";
	elseif( strtolower($string) == 'sales' ) $string = "Sales";
	
	return $string;
}

function edit_profile($data,$uid){
	$data = validasi_edit_profile($data);
	
	if( !is_array($data) )
		return false;
	
	extract($data, EXTR_SKIP);
	
	$email 				= esc_sql( $email );
	$nama_user 			= esc_sql( $nick_name );
	$jenis_kelamin		= esc_sql( $sex );
	$alamat 			= esc_sql( $alamat );
	$no_telp			= esc_sql( $nohp );
	$user_id			= esc_sql( $uid );	
	
	$data = compact('email','nama_user','jenis_kelamin','alamat','no_telp');
	update_profile($data,compact('user_id'));	

}

function validasi_edit_profile($data){
	extract($data, EXTR_SKIP);
	
	$error = array();
	
	if( empty($email) ) $error[]= 'Email Pengguna kosong';
	elseif(!valid_email($email) ) $error[]= 'Email Pengguna tidak valid';
	
	if( empty($sex) ) $error[]= 'Jenis Kelamin belum dipilih';
	
	if( $error ){
		foreach($error as $message) echo '<div id="error"><strong>Error :</strong> '.$message.'</div>';
		return false;
	}else return $data;
}

function update_profile($data, $where){
	extract($where, EXTR_SKIP);
	
	$add_query = implode_update($data,$where);
	
	$query_users = mysql_query("UPDATE `users` $add_query");
	
	if($query_users){
		echo '<div id="success"><strong>Success :</strong> Save member berhasil</div><br>';
		echo redirect_html('?q=profile');
	}
	
}

function edit_password($data, $uid){
	extract($data, EXTR_SKIP);
	
	$old_password = esc_sql( $old_password );
	$new_password = esc_sql( $new_password );
	$retry_new_password = esc_sql( $retry_new_password );
	$user_id = esc_sql( $uid );
	
	$old_password_hash = md5($old_password);
	$sandi = getinfo_users('sandi',$uid);
	
	if( empty($old_password) ) $error[]= 'Sandi lama kosong';
	else{
		if( $old_password_hash != $sandi ) $error[]= 'Sandi lama tidak cocok';
	}
	
	if( empty($new_password) ) $error[]= 'Kata sandi baru kosong';
	if( empty($retry_new_password) ) $error[]= 'Ulangi kata sandi kosong';
	
	if( !empty($new_password) && !empty($retry_new_password)
	&& $new_password != $retry_new_password ) $error[]= 'Sandi baru tidak sama';
	
	if( $error ){
		foreach($error as $message) echo '<div id="error"><strong>Error :</strong> '.$message.'</div>';
		return false;
	}else{
		update_password( array('kata_sandi' => md5($new_password) ),compact('user_id'));	
	}
	
}

function update_password($data, $where){	
	$add_query = implode_update($data, $where);
	
	$query_users = mysql_query("UPDATE `users` $add_query");
	
	if($query_users){
		echo '<div id="success"><strong>Success :</strong> Save kata sandi berhasil</div><br>';
		echo redirect_html('?q=profile',1);
	}
}

function insert_foto($data){
	extract($data, EXTR_SKIP);
	
	if(!empty($thumb['name'])):
		$thumb	= hash_image( $thumb );
		
		upload_img_post($thumb);
		
		del_img_post($gambar);
		$thumb 		= esc_sql($thumb['name']);
	else:
		$thumb		= esc_sql($gambar);
	endif;
		  
	mysql_query("UPDATE `users` SET `gambar` = '$thumb' WHERE `user_id` = $user_id");
	echo redirect_html('?q=profile&goto=foto');
}

function upload_img_post($thumb){	
	
		$image_allaw	= array(
		'image/png' 		=> '.png',
		'image/x-png' 		=> '.png',
		'image/gif' 		=> '.gif',
		'image/jpeg' 		=> '.jpg',
		'image/pjpeg' 		=> '.jpg');

		if(!empty($thumb['name'])):
			
		$myfile 	 = $thumb; //image name
		$uploadDir 	 = abs_path . 'content/uploads/'; //directory upload file
			
		if ( in_array($thumb['type'], array_keys($image_allaw)) ):
			
		$path 	 = $uploadDir.$thumb['name']; // dir & name path image for upload
		$type 	 = $image_allaw[$thumb['type']]; //type image is allow
		$width   = 120; // size for resize image
		$height  = 120; // size for resize image
		$quality = 120; // quality 120%
			
		$data_resize = compact('path','type','width','height','quality');
		
		//resize if file is image allaw function
		uploader( compact('myfile','uploadDir') );
		resize_image($data_resize);
		
		endif;
		endif;
}

function resize_image($data, $resized = false){
		extract($data, EXTR_SKIP);
		
		if( file_exists($path) )
		{
			
			if($type=='.jpg' || $type=='.jpeg') $im_src = imagecreatefromjpeg($path);
			elseif($type=='.gif') $im_src = imagecreatefromgif($path);
			elseif($type=='.png') $im_src = imagecreatefrompng($path);
			else return false;
			
		if( !$resized ){
			
			if(!list($w, $h) = getimagesize($path)) return "Tipe gambar tidak mendukung!";
			
			if($w < $width or $h < $height) return "Gambar terlalu kecil!";
			$ratio = max($width/$w, $height/$h);
			$h = $height / $ratio;
			$x = ($w - $width / $ratio) / 2;
			$w = $width / $ratio;
						
			$im = imagecreatetruecolor($width,$height);
			imagecopyresampled($im, $im_src, 0, 0, $x, 0, $width, $height, $w, $h);
			
		}else{
			
			$src_width 	= imagesx($im_src);
			$src_height = imagesy($im_src);
			
			if($src_width < $resize || $src_height < $resize ){
				$dst_width = $src_width;
			}
			else $dst_width = $resize;
			
			$dst_height = ($dst_width/$src_width)*$src_height;			
			$im = imagecreatetruecolor($dst_width,$dst_height);
			imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
			
		}
			
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
			header('Cache-Control: no-store, no-cache, must-revalidate'); 
			header('Cache-Control: post-check=0, pre-check=0', FALSE); 
			header('Pragma: no-cache');
			
			if($type=='.jpg' || $type=='.jpeg') imagejpeg($im,$path,$quality);
			elseif($type=='.gif') imagegif($im,$path);
			elseif($type=='.png') imagepng($im,$path);
			else return false;
			  
			imagedestroy($im_src);
			imagedestroy($im);
		}
}

function uploader($data){
		extract($data, EXTR_SKIP);
		
		$myfile_name = $myfile['name'];
		$myfile_temp = $myfile['tmp_name'];
		$uploadFile  = $uploadDir . basename($myfile_name);
		
        if (move_uploaded_file($myfile_temp, $uploadFile)) {
            echo '<div id="success">File successfully uploaded!</div>';
        } else {
			$msg = array();
            switch ($myfile['error']) {
                case 1:
                    $msg[]= 'The file is bigger than this PHP installation allows';
                    break;
                case 2:
                    $msg[]= 'The file is bigger than this form allows';
                    break;
                case 3:
                    $msg[]= 'Only part of the file was uploaded';
                    break;
                case 4:
                    $msg[]= 'No file was uploaded';
                    break;
                default:
                    $msg[]= 'unknown error';
            }
			if( is_array($msg))	{
			foreach($msg as $val){
				echo '<div id="error">'.$val.' </div>';
			}
		}}
}

function hash_image($thumb){
	
	$image_allaw	= array(
		'image/png' 		=> '.png',
		'image/x-png' 		=> '.png',
		'image/gif' 		=> '.gif',
		'image/jpeg' 		=> '.jpg',
		'image/pjpeg' 		=> '.jpg');

	if ( in_array($thumb['type'],array_keys($image_allaw)) ):
	
	$finame = $thumb['name'];
	$finame = str_replace(' ', '_', $finame);
	$finame = str_replace('@', '', $finame);
	
	$thumb['name']	 	= date('Ymdhis').'@'.getinfo_users('user').'@'.$finame;
	$thumb['type']	 	= $thumb['type'];
	$thumb['tmp_name']	= $thumb['tmp_name'];
	
	return $thumb;
	endif;
	
}

function del_img_post($file){
		
	$path = abs_path . 'content/uploads/';
	if( !empty($file) && file_exists($path.$file) )
		unlink( $path . $file );
}