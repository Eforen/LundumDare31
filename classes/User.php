<?PHP
/**
* 
*/
class User
{
	private $_exists = false,
			$_id,
			$_ip,
			$_username,
			$_password,
			$_sessionName,
			$_isLoggedIn;
	
	function __construct($user = null)
	{
		//$this->_db = DB::getInstance();
		$_sessionName = Config::get('session/session_name');

		//echo '|'.$user.'|';
		if(!$user) {
			if(Session::exists($this->_sessionName)) {
				$user = Session::get($this->_sessionName);
				//echo $user;
				if($this->find($user)) {
					$this->_isLoggedIn = true;
				} else {
					// process logout
				}
			}
		} else{
			$this->find($user);
		}
	}

	public function create(IP $ip, $username, $pass){
		//updated
		if(!file_exists($GLOBALS['config']['root']['server']."/data/players/".strtolower($username).".player")){
			//open
			$myFile = $GLOBALS['config']['root']['server']."/data/players/".strtolower($username).".player";
			$f = fopen(addslashes(strtolower($_GET['u'])).".player", "w") or die("Server Error: Player File Corrupt!");
			fwrite($f, $ip->ip());
			$ip->setType("p");
			$ip->setValue(strtolower($username));
			fwrite($f, $username);
			fwrite($f, $pass);
			fclose($f);
			$ip->save();
		}
	}

	public function find($user = null){
		//Updated
		//echo "find".$GLOBALS['config']['root']['server']."/data/players/".strtolower($user).".player";
		if(file_exists($GLOBALS['config']['root']['server']."/data/players/".strtolower($user).".player")) {
			//echo "found";
			$lines = file("../data/players/".strtolower($user).".player");//file in to an array
			$this->_id=strtolower($user);
			$this->_username=$lines[1];
			$this->_password=$lines[2];
			$this->_ip=$lines[0];
			$this->_exists = true;
			return true;
		}
		return false;
	}
	
	public function login($username = null, $password = null){
		
		$user = $this->find($username);

		if(!$username && !$password && $this->exists()) {
			Session::put($this->_sessionName, $this->_id);
			//echo '|', $this->_sessionName, ' ', $this->data()->id, '|';
		} else{
			//echo "found2".$user->_ip;
			if($user && $this->_password === $password){
				Session::put($this->_sessionName, $this->_id);

				//echo "found np";
				return true;
			}
			
		}

		return false;
	}

	public function exists(){
		return !empty($this->_exists);
	}

	public function id(){
		return $this->_id;
	}

	public function username(){
		return $this->_username;
	}

	public function password(){
		return $this->_password;
	}

	public function ip(){
		return $this->_ip;
	}
	
	public static function nameUserSession(){
		return Config::get('login/remember/session_table', 'user_sessions');
	}

	public function logout() {
		if(Cookie::exists(Config::get('login/remember/cookie_name'))){
			//$this->_db->delete(self::nameUserSession(), ['user', '=', $this->_data->id]);
			Cookie::delete(Config::get('login/remember/cookie_name'));
		}

		Session::delete($this->session_name);
	}

	public function isLoggedIn(){
		return $this->_isLoggedIn;
	}

	public static function isLoggedInSoft(){
		return Session::exists(Config::get('session/session_name'));
	}

	public function hasPermission($key){
		//$group = $this->_db->get(Config::get('users/groups', 'user_groups'), ['id', '=', $this->data()->group]);

		//print_r($group);
		//if($group->count()){
		//	$permissions = json_decode($group->first()->perms, true);
		//	//print_r($permissions);
		//	if($permissions[$key] == true) return true;
		//}

		return false;
	}
}
?>