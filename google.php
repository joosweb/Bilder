<?php
ob_start();
session_start(); //session start
require_once ('libraries/Google/autoload.php');
require('db/conectar.php');
require('includes/functions.php');
//Insert your cient ID and secret 
//You can get it from : https://console.developers.google.com/
$client_id = '256253303431-r32jjvlei2pnti846c58cvhnsgbc680i.apps.googleusercontent.com'; 
$client_secret = 'lbZd6d1VkMDIG5L-n-pECcNc';
$redirect_uri = 'https://www.bilder.cl/google.php';


//incase of logout request, just unset the session var
if (isset($_GET['logout'])) {
  unset($_SESSION['access_token']);
  session_unset();
  session_destroy();
  session_write_close();
  setcookie(session_name(),'',0,'/');
  header('Location: index.php?s=home');
}

/************************************************
  Make an API request on behalf of a user. In
  this case we need to have a valid OAuth 2.0
  token for the user, so we need to send them
  through a login flow. To do this we need some
  information from our API console project.
 ************************************************/
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");

/************************************************
  When we create the service here, we pass the
  client to it. The client then queries the service
  for the required scopes, and uses that when
  generating the authentication URL later.
 ************************************************/
$service = new Google_Service_Oauth2($client);

/************************************************
  If we have a code back from the OAuth 2.0 flow,
  we need to exchange that with the authenticate()
  function. We store the resultant access token
  bundle in the session, and redirect to ourself.
*/
  
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  exit;
}

/************************************************
  If we have an access token, we can make
  requests, else we generate an authentication URL.
 ************************************************/
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl = $client->createAuthUrl();
}


//Display user info or display login url as per the info we have.
echo '<div style="margin:20px">';
if (isset($authUrl)){ 
	//show login url
	header('Location: index.php?s=sign-in');
	
} else {

		$user = $service->userinfo->get(); //get user info 
		
		// OBTENER FOTO DE PERFIL
		$fotoPerfil = $user->picture;
		$imagen = file_get_contents($fotoPerfil);
		// GENERAR NUEVO NOMBRE DE LA FOTO
		$nombre_foto = generarCodigo(18).'.jpg';
		file_put_contents('img/profile/avatar/'.$nombre_foto, $imagen);
		// GUARDAR CORREO Y NOMBRE DESDE FACEBOOK API
		$email = $user->email;
		$nombre = $user->name;
		// INSERTAR Y CREAR SESSION
		$pdo = new Conexion();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->exec("SET CHARACTER SET utf8");
		// PREGUNTAR SI EXISTE EL CORREO SI NO, NO INSERTAMOS
		$CHECK = $pdo->prepare("SELECT * FROM account WHERE email = ?");
		$CHECK->execute(array($email));
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
?>

