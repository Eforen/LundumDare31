<?php
include_once("../core/init.php");
/**
 * Created by PhpStorm.
 * User: Eforen
 * Date: 12/7/14
 * Time: 10:38 AM
 */


if(Input::exists("get")) {
	$validate = new Validate();
	$validation = $validate->check($_GET, [
		'u' => ['required' => true],
		'p' => ['required' => true]
	]);
	if($validation->passed()) {
		// log user in
		$user = new User();
		$login = $user->login(Input::get('u'), Input::get('p'));
		echo "Debug: ", Input::get('u') , "|", Input::get('p');

		if($login){
			die("OK|".$user->ip().":".$user->username());
		} else {
			die("NOPE");
		}
	} else{
		die("NOPE");
	}
}
die("ERROR|Can't Read Data");