<?php
session_start();
error_reporting(0);

require ('../db/conectar.php');

$secret = '6LeGURQUAAAAABfwjOtjz7tQKTMwQz-OO796u60F';
$captcha = $_POST['captcha'];
//
$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$captcha);

$responseData = json_decode($verifyResponse);
// Если капча не прошла проверк     

@$nombres   = $_POST['nombres'];
@$apellidos = $_POST['apellidos'];
@$email     = $_POST['email'];
@$passw     = $_POST['password'];

if($responseData->success == false ) {
    echo 'ErrorCode';
}
else {
try {

    $pdo = new Conexion();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET CHARACTER SET utf8");

    $stm2 = $pdo->prepare("SELECT id FROM account WHERE email = ?");
    $stm2->execute(array($email));
    $r = $stm2->fetch(PDO::FETCH_OBJ);

    if (@$r->id) {
        echo 'emailexist';
    } else if ($nombres == '' or $apellidos == '' or $email == '' or $passw == '') {
        echo 'vacios';
    } else {

        $stm = $pdo->prepare("INSERT INTO account (nombres,apellidos,email,password) VALUES(?,?,?,PASSWORD(?))");

        if ($stm->execute(array($nombres, $apellidos, $email, $passw))) {

            $fetch = $pdo->prepare("SELECT id,email FROM account WHERE email = ? and password = PASSWORD(?)");
            $fetch->execute(array($email,$passw));
            $rows = $fetch->fetch(PDO::FETCH_OBJ);

            /// recoger el id creado para poder generar el id session
            $_SESSION['email'] = $rows->email;
            $_SESSION['id'] = $rows->id;

            echo 'ok';

        } else {

            echo 'false';

        }
    }

} catch (Exception $e) {
    die($e->getMessage());
}
}