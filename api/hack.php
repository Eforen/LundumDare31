<?php
include_once("../core/init.php");
/**
 * Created by PhpStorm.
 * User: Eforen
 * Date: 12/7/14
 * Time: 4:27 PM
 */

$m=rand(-4000, 5000);
$u=new User();
if($u->exists()){
	if($u->money()+$m>0)$u->setMoney($u->money()+$m);
	else $u->setMoney(0);
	$u->save();
	echo "OK|".$m,"|",$u->money();
}else{
	echo "NOPE";
}