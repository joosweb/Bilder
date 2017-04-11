<?php
require_once 'config.php';

$json = array();
$email = isset( $_POST['email'] ) ? $_POST['email'] : '';
$name = isset( $_POST['name'] ) ? $_POST['name'] : '';
$message = isset( $_POST['message'] ) ? $_POST['message'] : '';

if( !$name ) {
    $json['error']['name'] = 'Por favor ingresa tu nombre completo.';
}
if( !$message ) {
    $json['error']['message'] = 'Por favor ingrese su mensaje.';
}
if( !$email || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email ) ) {
    $json['error']['email'] = 'Por favor, introduzca su dirección de correo electrónico.';
}

// Checking reCaptcha
if ($_POST["g-recaptcha-response"]) {
	//
	$resp = file_get_contents( "https://www.google.com/recaptcha/api/siteverify?secret={$privatekey}&response={$_POST['g-recaptcha-response']}&remoteip={$_SERVER['REMOTE_ADDR']}" );
	$resp = json_decode( $resp );
	// Если капча не прошла проверку
	if( $resp->success == false ) {
		$json['error']['recaptcha'] = 'Código incorrecto. Por favor, inténtelo de nuevo.';
	}
	
//
} else {
    $json['error']['recaptcha'] = 'Prueba que no eres un robot.';
}


// If no errors
if( !isset( $json['error'] ) ) {
    // Email text
    $mail_message = "From: " . $name . "\r\n\r\n";
    $mail_message .= "E-mail: " . $email . "\r\n\r\n";
    $mail_message .= "Message:\r\n\r\n" . $message . "";
    // Email title
    $mail_headers  = "Content-type: text/plain; charset=utf-8\r\n";
    $mail_headers .= "From: {$mail_sender}\r\n";
    // Sending email
    mail( $to_email, $mail_subject, $mail_message, $mail_headers );
    $json['success'] = 'Su mensaje fue enviado exitosamente!';
}

echo json_encode( $json );
?>