<?php
/**
 * Created by PhpStorm.
 * User: Eforen
 * Date: 12/7/14
 * Time: 11:16 AM
 */

class IP {
	private $_exists,
		$_ip,
		$_type,
		$_value;

	function __construct($ip = null)
	{
		//echo '|'.$user.'|';
		if(!$ip) {
			$user = new User();
			if($user->exists()) {
				$this->find($user->ip());
			}
		} else{
			$this->find($ip);
		}
	}

	public function getUnusedIP(){
		//updated
		if(file_exists(Config::get("data/ipmap"))) {
			unset($this->_ip);
			unset($this->_type);
			unset($this->_value);
			$lines = file(Config::get("data/ipmap"));//file in to an array
			$a = rand(1,255);
			$b = rand(1,255);
			$c = rand(1,255);
			$d = rand(1,254);
			$fa = $fb = $fc = $fd = true;
			for($ta=$a; $ta!=$a || $fa; $ta++){
				for($tb=$b; $tb!=$b || $fb; $tb++){
					for($tc=$c; $tc!=$c || $fc; $tc++){
						for($td=$d; $td!=$d || $fd; $td++){
							if($this->_checkIPinList($lines, $ta.".".$tb.".".$tc.".".$td)){
								$this->_ip = $ta.".".$tb.".".$tc.".".$td;
							}
						}
					}
				}
			}
		}
	}

	private function _checkIPinList($list, $check){
		foreach($list as $entry) if(split("|",$entry)[0]==$check) return true;
		return false;
	}

	public function find($ip = null){
		//Updated
		if(file_exists(Config::get("data/ipmap"))) {
			$lines = file(Config::get("data/ipmap"));//file in to an array
			foreach($lines as $entry){
				$es = split("|",$entry);
				if($es[0]==strtolower($ip)){
					$this->_ip = $es[0];
					$this->_type = $es[1];
					$this->_value = $es[2];
					return true;
				}
			}
		}
		return false;
	}

	public function login($username = null, $password = null){

		$user = $this->find($username);

		if(!$username && !$password && $this->exists()) {
			Session::put($this->_sessionName, $this->_id);
			//echo '|', $this->_sessionName, ' ', $this->data()->id, '|';
		} else{
			if($user && $this->_password === $password){
				Session::put($this->_sessionName, $this->_id);

				return true;
			}

		}

		return false;
	}

	public function exists(){
		return !empty($this->_type);
	}

	public function ip(){
		return $this->_ip;
	}

	public function type(){
		return $this->_type;
	}

	public function value(){
		return $this->_value;
	}

	public function setType($type){
		$this->_type = $type;
	}

	public function setValue($value){
		$this->_value = $value;
	}

	public function save(){
		$lines = array();
		if(file_exists(Config::get("data/ipmap"))) {
			$lines = file(Config::get("data/ipmap"));//file in to an array
		}
		$found = false;
		for($i = 0; $i< count($lines); $i++){
			if(strpos($lines[$i],$this->_ip)!==FALSE){
				$lines[$i]=$this->_ip."|".$this->_type."|".$this->_value;
				$found=true;
				break;
			}
		}
		if(!$found) $lines[count($lines)] = $this->_ip."|".$this->_type."|".$this->_value;
	}

	public static function sessionID(){
		return Config::get('game/ip/session_table', 'ip_sessions');
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