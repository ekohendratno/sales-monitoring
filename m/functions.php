<?php

class Log{
	
	public function getUserById($username, $password){		
        $result = mysql_query("SELECT * FROM users WHERE nama_pengguna = '$username' AND jabatan='sales'") or die(mysql_error());
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);
            $encrypted_password = $result['kata_sandi'];
            $hash = md5($password);
            if ($encrypted_password == $hash) {
                return $result;
            }
        } else {
            return false;
        }
	}
	
	public function getNotif(){
		$data = array();
		for($i=1; $i<=25; $i++){
			$data[$i]['mid'] = $i;
			$data[$i]['icon'] = 'icon_list';
			$data[$i]['message'] = 'isi darai notifikasi yang disingkat dengan limit text 200 kharakter '.$i;
		}
		return $data;
	}
	
	public function getNotifDetail($id = null){
		$data = array();
		for($i=1; $i<=25; $i++){
			if( !empty($id) && $i == $id ){
				$data[$i]['mid'] = $i;
				$data[$i]['icon'] = 'icon_list';
				$data[$i]['message'] = "<p><b>Simplified user session management</b><br>This release includes several tools that simplify authentication and authorization, including a Fragment and a Button that manage login state automatically. Login state is cached in SharedPreferences by default. You can serialize sessions to support low memory scenarios; an optional Activity base class makes this automatic. The modular design handles details you don't care about while giving you more control when you need it.</p>
				<p><b>Better Facebook APIs support</b><br>You can now batch SDK requests for Facebook API calls, which translates to much faster access times for parallel API requests. Callbacks and listeners are factored in to better support MVC-style programming. Facebook JSON data can be manipulated with strongly-typed interfaces to reduce coding errors and simplify reading and writing to Facebook.</p>";
			}
		}
		return $data;
	}
}