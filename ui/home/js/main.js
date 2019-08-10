(function($) {
	
validasiAngka = function (field) {
	var Char;
	var sudahkoma = false;
	var belakangkoma = 2;
	var k = 1;
	Char = "";
	for (i = 0; i < (field.value.length); i++) {
		if (isNaN(field.value.charAt(i)) && field.value.charAt(i) != '.' && field.value.charAt(i) != ',') {
			break;
		} else {
			if (sudahkoma == true) {
				if (field.value.charAt(i) == '.' || k > belakangkoma) {
					break;
				}
				k++;
			}
			if (field.value.charAt(i) == ',') {
				sudahkoma = true;
			}
			Char = Char + field.value.charAt(i);
		}
	}
	field.value = Char;
}

validasi_float = function (num) {
	numfloat = parseFloat(num);
	if (isNaN(numfloat)) {
		numfloat = 0.00;
	}
	return numfloat;
}

sale_dipesan = function(){
	jumlah_stok_produk = document.getElementById('jumlah_stok_produk').value;
	jumlah_barang_dipesan = document.getElementById('jumlah_barang_dipesan').value;
	harga_barang = document.getElementById('harga_barang').value;
	total_harga_barang = document.getElementById('total_harga_barang').value;
	
	sisa_stok_produk = eval(jumlah_stok_produk)-eval(jumlah_barang_dipesan);
	
	if( sisa_stok_produk >=0 ){
		mssp = sisa_stok_produk;
		total_harga_barang = eval(harga_barang)*eval(jumlah_barang_dipesan);
		document.getElementById('total_harga_barang').value = $.jsMadani.toIndonesianNumber(total_harga_barang);
	}else{	
		mssp = "Maaf barang yang dipesan habis / melebihi stok yang ada";
		sisa_stok_produk = 0;
		alert(""+mssp+"");
	}
	
	document.getElementById('sisa_stok_produk').value = mssp;
	document.getElementById('sisa_stok_produk_after').value = sisa_stok_produk;
}

stok_ditambah = function(){
	jumlah_stok_exist = document.getElementById('jumlah_stok_exist').value;
	jumlah_stok_add = document.getElementById('jumlah_stok_add').value;
	
	total_jumlah_stok_add = eval(jumlah_stok_exist)+eval(jumlah_stok_add);
	document.getElementById('total_stok').value = total_jumlah_stok_add;
}

	
})(jQuery);