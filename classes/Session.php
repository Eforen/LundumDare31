<?php
/**
* 
*/
class Session
{
	public static function exists($name) {
		return isset($_SESSION[$name]);
	}

	public static function put($name, $value) {
		return $_SESSION[$name]= $value;
	}

	public static function get($name){
		return $_SESSION[$name];
	}

	public static function delete($name) {
		unset($_SESSION[$name]);
	}

	/**
	 * Sets a flash msg.
	 * 
	 * Will overwrite any current msg with $name with $string.
	 * Will set if not exists already
	 */
	public static function setflash($name, $string = ''){
		$flash = self::get(self::nameflash());
		if(!is_array($flash)) $flash = array();
		$flash[$name] = $string;
		self::put(self::nameflash(), $flash);
	}

	/**
	 * Gets a flash msg.
	 * 
	 * Will will delete and return msg with $name.
	 * If not exist will return $default
	 */
	public static function getflash($name, $default = ''){
		$flash = self::get(self::nameflash());
		if(!isset($flash[$name])) return $default;

		$r = $flash[$name];
		unset($flash[$name]);
		self::put(self::nameflash(), $flash);
		return $r;
	}

	/**
	 * Returns true if flash has msg with name $name.
	 */
	public static function hasflash($name){
		return isset(self::get(self::nameflash())[$name]);
	}

	/**
	 * Helps get flash storage name by only getting it in one place
	 * incase changes are needed it only needs to be made once 
	 * instead of all over the source code.
	 *
	 * This is also configurable with the key path 'session/flash'
	 */
	private static function nameflash(){
		return Config::get('session/flash', 'flash');
	}
}
?>