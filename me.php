<?php
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
// GENERAR NUEVO NOMBRE DE LA FOTO
$nombre_foto = generarCodigo(18).'.jpg';
file_put_contents('img/profile/avatar/'.$nombre_foto, $imagen);
// GUARDAR CORREO Y NOMBRE DESDE FACEBOOK API
$email = $userNode->getProperty("email");
$nombre = $userNode->getProperty("name");
// INSERTAR Y CREAR SESSION
$pdo = new Conexion();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("SET CHARACTER SET utf8");
// PREGUNTAR SI EXISTE EL CORREO SI NO, NO INSERTAMOS
$CHECK = $pdo->prepare("SELECT * FROM account WHERE email = ?");
$CHECK->execute(array($userNode->getProperty("email")));
$rows = $CHECK->fetch(PDO::FETCH_OBJ);
// GENERAR CONTRASEÑA 
$password_inicial=generaPass();
///////////////// SI EL CORREO NO EXISTE INSERTAMOS/////////////////////////
if(!$rows->id) {
$stm = $pdo->prepare("INSERT INTO account (nombres,email,password,photo) VALUES(?,?,PASSWORD(?),?)");
$stm->execute(array($nombre,$email,$password_inicial,$nombre_foto));
$insert_id = $pdo->lastInsertId();
$fecha = date("Y-m-d H:i:s");
$asunto = 'Bienvenido a bilder';
$mensaje = '<td valign="top">
          <table style="border-radius:4px;border:1px #dceaf5 solid" cellspacing="0" cellpadding="0" border="0" align="center"><tbody><tr><td colspan="3" height="6"></td></tr><tr style="line-height:0px"><td style="font-size:0px" width="100%" height="1" align="center"><img style="max-height:50px;width:50px" alt="" src="https://www.bilder.cl/logobilderapp.png"></td></tr><tr><td><table style="line-height:25px" cellspacing="0" cellpadding="0" border="0" align="center"><tbody><tr><td colspan="3" height="30"></td></tr><tr><td width="36"></td>
          <td style="color:#444444;border-collapse:collapse;font-size:11pt;font-family:proxima_nova,"Open Sans","Lucida Grande","Segoe UI",Arial,Verdana,"Lucida Sans Unicode",Tahoma,"Sans Serif";max-width:454px" width="454" valign="top" align="left"><p>Hola, <strong>'.$nombre.'</strong>:<br><br>
            <p style="text-align:justify;">Tu cuenta está casi lista. como es primera vez que inicias sesión bilder te ha asignado una contraseña inicial, con la que podrás en cualquier momento entrar en esta plataforma con el correo correspondiente a este registro.</p>
            </p>
            <p>Tu contraseña inicial es: 
            </p>
            <center><div style="border-radius:3px;font-size:15px;color:white;border:1px #1373b5 solid;text-decoration:none;padding:14px 7px 14px 7px;width:200px;max-width:200px;margin:6px auto;display:block;background-color:#E95C36;text-align:center">'.$password_inicial.'</div></center>
            <br>
            <br>
          ¡Te damos la bienvenida a Bilder!<br>
          - El equipo de Bilder</td>
          <td width="36"></td>
          </tr><tr><td colspan="3" height="36"></td></tr></tbody></table></td></tr></tbody></table><table cellspacing="0" cellpadding="0" border="0" align="center"><tbody><tr><td height="10"></td></tr><tr><td style="padding:0;border-collapse:collapse"><table cellspacing="0" cellpadding="0" border="0" align="center"><tbody><tr style="color:#a8b9c6;font-size:11px;font-family:proxima_nova,"Open Sans","Lucida Grande","Segoe UI",Arial,Verdana,"Lucida Sans Unicode",Tahoma,"Sans Serif""><td width="400" align="left"></td>
          <td width="128" align="right">© 2017 Bilder</td>
          </tr></tbody></table></td></tr></tbody></table></td>';
$tipo = 0;
echo enviarMensaje($email,'noreply@bilder.cl',$fecha,$asunto,$mensaje,$tipo);
// CREANDO LA SESSION
 $_SESSION['email'] = $email;
 $_SESSION['id'] = $insert_id;
 ///////////////////////////
header('Location: index.php?s=profile');
}
else {
  // CREANDO LA SESSION
  $find = $pdo->prepare("SELECT * FROM account WHERE email = ?");
  $find->execute(array($email));
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