<?php
session_start();
/**
 * Created by PhpStorm.
 * User: Eforen
 * Date: 12/7/14
 * Time: 10:38 AM
 */

if(Input::exists("get")) {
	$validate = new Validate();
	$validation = $validate->check($_GET,
		[
			'u' =>
				[
					'required' => true,
					'min' => 2,
					'max' => 20,
					'unique' => [
						'table' => 'user_table',
						'field' => 'username'
					]
				],
			'p' =>
				[
					'required' => true,
					'min' => 6
				],
			'pa' =>
				[
					'required' => true,
					'matches' => 'password'
				]
		]);

	if($validation->Passed()){
		//echo 'Passed ', count($validation->errors());
		$user = new User();

		try {
			/*
			echo 'test|';
			print_r([
				'username' => Input::get('username'),
				'password' => Hash::make(Input::get('password')),
				'salt' => $salt,
				'firstname' => Input::get('name'),
				'joined' => date('Y-m-d H:i:s'),
				'group' => 1
				]);
			echo '|';
			*/
			$ip = new IP();
			if($ip->getUnusedIP()) {
				$user->create($ip, Input::get('u'),Input::get('p'));
				echo('OK|You have been registered and can now login.');
			} else {
				echo "NOPE| Could not find an IP Address";
			}
			//Redirect::to('index.php');
			//Redirect::map('home');
		} catch(Exception $e){
			die("NOPE");
		}
	} else{
		echo "NOPE\n";
		print_r($validation->errors());
	}
} else{
	echo 'NOPE';
}