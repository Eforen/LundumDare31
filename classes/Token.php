<?PHP
/**
* 
*/
class Token
{
	public static function generate($key = 'default') {
		return Session::put(self::nameToken($key), md5(uniqid()));
	}

	public static function nameToken($key = 'default'){
		return Config::get('session/token_name', 'token').$key;
	}

	private static $validToken;

	public static function check($token, $key = 'default'){
		$tokenName = self::nameToken($key);
		//echo $tokenName, '|', $token, "|", self::$validToken ;

		if(self::$validToken == $token){
			return true;
		}

		if(Session::exists($tokenName) && $token === Session::get($tokenName)){
			Session::delete($tokenName);
			self::$validToken = Session::get($tokenName);
			return true;
		}

		return false;
	}
}
?>