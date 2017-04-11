<?php
session_start();
require('../db/conectar.php');

@$email = $_POST['email'];
@$passw = $_POST['password'];
	

        try{

            $pdo = new Conexion();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec("SET CHARACTER SET utf8");   

            $stm    = $pdo->prepare("SELECT * FROM account WHERE email = ? and password = PASSWORD(?) ");
            $stm->execute(array($email,$passw));
            $r = $stm->fetch(PDO::FETCH_OBJ);

            if($r){

            	$_SESSION['email'] = $r->email;
            	$_SESSION['id'] = $r->id;


            	echo 'ok';

            } else{

               echo 'false';

            }

        }catch (Exception $e){
            die($e->getMessage());
        }
?>