<?PHP
session_start();

$GLOBALS['config'] = 
	[
	'debug' => true,
	'root' => [
		'server' => '/home/ubersoft/public_html/ld',
		'fullweb' => 'http://ld.ubersoftech.com',
		'web' => '/'
		],
	'mysql' => 
		[
		'host' => '127.0.0.1', 
		'db' => 'nop', 
		'username' => 'nop', 
		'password' => 'nop'
		], 
	'login' => 
		[
		'remember' => 
			[
			'cookie_name' => 'hash',
			'cookie_expire' => 604800,
			'session_table' => 'user_sessions'
			],
		], 
	'session' => 
		[
		'session_name' => 'user',
		'token_name' => 'token'
		], 
	'redirect' => 
		[
		'map' => 
			[
			'home' => '/',
			'register' => '/register.php',
			'login' => '/simple/login.php',
			'logout' => '/simple/logout.php',
			'update' => '/simple/update.php',
			'changepass' => '/simple/changepassword.php'
			],
		'externlmap' => 
			[
			'google' => 'http://www.google.com'
			]
		], 
	'data' =>
		[
		'ipmap' => $GLOBALS['config']['root']['server']."/data/ipmap"
		]
	];

spl_autoload_register(function($class){
	require_once $GLOBALS['config']['root']['server'] . '/classes/' . $class . '.php';
});

require_once $GLOBALS['config']['root']['server'] . "/functions/sanitize.php";

//User::checkRememberMe();

$activeuser = new User();
?>