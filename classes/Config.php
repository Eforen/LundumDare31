<?PHP
class Config {
	public static function get($path = null, $default = false){
		if($path) {
			$config = $GLOBALS['config'];
			$path = explode('/', $path);

			foreach ($path as $bit) {
				if(isset($config[$bit]))
					$config = $config[$bit];
				else return $default;
			}

			return $config;
		}
		return $default;
	}
}
?>