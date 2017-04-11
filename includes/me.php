<?php
/**
* Facebook Access
* Author: evilnapsis
**/
ob_start();
session_start();
require('db/conectar.php');
require('includes/functions.php');

if(isset($_SESSION["fb_access_token"])){

require_once "fbsdk4-5.1.2/src/Facebook/autoload.php";
require_once "credentials.php";

$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.2',
  ]);

$accessToken = $_SESSION['fb_access_token'] ;

if(isset($accessToken)){
$fb->setDefaultAccessToken($accessToken);

try {
  $response = $fb->get('/me?locale=es_ES&fields=id,name,email');
  $userNode = $response->getGraphUser();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
// OBTENER FOTO DE PERFIL
$fotoPerfil = "http://graph.facebook.com/".$userNode->getProperty("id")."/picture?type=large";
$imagen = file_get_contents($fotoPerfil);
$nombre_foto = generarCodigo(18).'.jpg';
file_put_contents('img/profile/avatar/'.$nombre_foto, $imagen);
$email = $userNode->getProperty("email");
$nombre = $userNode->getProperty("name");
// INSERTAR Y CREAR SESSION
$pdo = new Conexion();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("SET CHARACTER SET utf8");
// PREGUNTAR SI EXISTE EL CORREO SI NO, NO O INSERTAMOS
$CHECK = $pdo->prepare("SELECT * FROM account WHERE email = ?");
$CHECK->execute(array($userNode->getProperty("email")));
$rows = $CHECK->fetch(PDO::FETCH_OBJ);
///////////////// SI EL CORREO NO EXISTE INSERTAMOS/////////////////////////
if(!$rows->id) {
$stm = $pdo->prepare("INSERT INTO account (nombres,email,photo) VALUES(?,?,?)");
$stm->execute(array($nombre,$email,$nombre_foto));
$insert_id = $pdo->lastInsertId();
$fecha = date("Y-m-d H:i:s");
$asunto = 'Su contraseña inicial';
$password_inicial=generaPass();
$tipo = 0;
$mensaje = '<h3 align="center">Bienvenido a bilder.cl</h3><p>Como es la primera vez que ha iniciado sesión bilder le ha asigando una contraseña generica con la finalidad de entrar con ella y su correo en cualquier momento.</p><p>Su contraseña es: '.$password_inicial.'</p>';
echo enviarMensaje($email,'noreply@bilder.cl',$fecha,$asunto,$mensaje,$tipo)

 ///////////////////////////
header('Location: index.php?s=profile');
}
else {
  // CREANDO LA SESSION
  $find = $pdo->prepare("SELECT * FROM account WHERE email = ?");
  $find->execute(array($userNode->getProperty("email")));
  $rw = $find->fetch(PDO::FETCH_OBJ);

    $_SESSION['email'] = $email;
    $_SESSION['id'] = $rw->id;

        header('Location: index.php?s=profile');
    }
  }
} else{
  header("Location: index.php?s=login");

}
ob_end_clean();
?>