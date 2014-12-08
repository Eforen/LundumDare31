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
			$_money,
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
		//echo "starting";
		$u = new User($username);
		if($u->exists()) return false;
		if(!file_exists($GLOBALS['config']['root']['server']."/data/players/".strtolower($username).".player")){
			//echo "starting2";
			//open
			$myFile = $GLOBALS['config']['root']['server']."/data/players/".strtolower($username).".player";
			$f = fopen($myFile, "w") or die("Server Error: Player File Corrupt!");
			fwrite($f, $ip->ip()."\n");
			$ip->setType("p");
			$ip->setValue(strtolower($username));
			fwrite($f, $username."\n");
			fwrite($f, $pass."\n");
			fwrite($f, "0");
			fflush($f);
			fclose($f);
			$ip->save();
			//echo "starting3";
			return true;
		}
		return false;
	}

	public function find($user = null){
		//Updated
		//echo "find".$GLOBALS['config']['root']['server']."/data/players/".strtolower($user).".player";
		if(file_exists($GLOBALS['config']['root']['server']."/data/players/".strtolower($user).".player")) {
			//echo "found";
			$lines = file("../data/players/".strtolower($user).".player");//file in to an array
			$this->_id=strtolower($user);
			$this->_username=trim($lines[1]);
			$this->_password=trim($lines[2]);
			$this->_ip=trim($lines[0]);
			$this->_money = trim($lines[3]);
			$this->_exists = true;
			return true;
		}
		return false;
	}
	
	public function login($username = null, $password = null){
		
		$user = $this->find($username);
		//echo "<pre>",$username,":",$password,"\n";
		//print_r($this);
		//echo "</pre>";
		if(!$username && !$password && $this->exists()) {
			Session::put($this->_sessionName, $this->_id);
			//echo '|', $this->_sessionName, ' ', $this->data()->id, '|';
		} else{
			//echo "found2|".$this->_ip,"|",(trim($this->_password) === trim($password))?"wtf1":"wtf2","|";
			if($user && (trim($this->_password) === trim($password))){
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

	public function money(){
		return $this->_ip;
	}

	public function setMoney(){
		return $this->_money;
	}

	public function save(){
		if(!file_exists($GLOBALS['config']['root']['server']."/data/players/".strtolower($username).".player")){
			//open
			$myFile = $GLOBALS['config']['root']['server']."/data/players/".strtolower($username).".player";
			$f = fopen(addslashes(strtolower($_GET['u'])).".player", "w") or die("Server Error: Player File Corrupt!");
			fwrite($f, $this->_ip."\n");
			fwrite($f, $this->_username."\n");
			fwrite($f, $this->_password."\n");
			fwrite($f, $this->_money."\n");
			fclose($f);
			$ip->save();
		}
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