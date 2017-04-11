<?php
session_start();
error_reporting(0);
require('../db/conectar.php');
///////////// 
$secret = '6LeGURQUAAAAABfwjOtjz7tQKTMwQz-OO796u60F';
$captcha = $_POST['captcha'];
//
$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$captcha);

$responseData = json_decode($verifyResponse);
// Если капча не прошла проверк		


$old_password = $_POST['oldpass'];
$new_password = $_POST['newpass'];
$rnew_password = $_POST['rnewpass'];
$id_account = $_SESSION['id'];

if(empty($old_password) OR empty($new_password)){
	echo 'PassEmpty';
	exit();
}

if($rnew_password != $new_password) {
	echo 'equalToFalse';
	exit();
}

if($responseData->success == false ) {
	echo 'ErrorCode';
}
else {
$pdo = new Conexion();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("SET CHARACTER SET utf8");
$stm = $pdo->prepare("SELECT * FROM account WHERE id=? and password = PASSWORD(?)");
$stm->execute(array($id_account,$old_password));
$row = $stm->fetch(PDO::FETCH_OBJ);

if($row->id) {

		$stm2 = $pdo->prepare("UPDATE account set password = PASSWORD(?) WHERE id=? LIMIT 1");
		if($stm2->execute(array($rnew_password,$id_account))) {
			echo 'ok';
		}
		else {
			echo 'error';
		}
	}
	else
	{
		echo 'Pfalse';
	}
 }
?>