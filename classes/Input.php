<?php
/**
 * Handels get and post data
 * (Input from client)
 */
class Input
{
	/**
	 * Checks if there is data to access via post or get.
	 * Defaults to post.
	 */	
	public static function exists($type = 'post'){
		switch ($type) {
			case 'post':
				return (!empty($_POST)) ? true : false;
				break;
			
			case 'get':
				return (!empty($_GET)) ? true : false;
				break;
			
			default:
				return false;
				break;
		}
	}
	
	/**
	 * checks if item exists
	 * if $lock is set to 'get' or 'post' will only check for that type.
	 */
	public static function has($item, $postfirst=true, $lock = 'no'){
		if($postfirst && $lock != 'get' || $lock == 'post'){
			if(isset($_POST[$item])) return true;
			elseif($lock=='no' && isset($_GET[$item])) return true;
		} elseif(!$postfirst && $lock != 'post' || $lock == 'get') {
			if(isset($_GET[$item])) return true;
			elseif($lock=='no' && isset($_POST[$item])) return true;
		}
		return false;
	}
	
	/**
	 * Retreaves item
	 * $default 	= will be returned if item is not found. (Defaults to '')
	 * $postfirst 	= if true check post first
	 * $lock 		= set to 'get' or 'post' will only check for that type.
	 */
	public static function get($item, $default = '', $postfirst=true, $lock = 'no'){
		if($postfirst && $lock != 'get' || $lock == 'post'){
			if(isset($_POST[$item])) return $_POST[$item];
			elseif($lock=='no' && isset($_GET[$item])) return $_GET[$item];
		} elseif(!$postfirst && $lock != 'post' || $lock == 'get') {
			if(isset($_GET[$item])) return $_GET[$item];
			elseif($lock=='no' && isset($_POST[$item])) return $_POST[$item];
		}
		return $default;
	}
}
?>