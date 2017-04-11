<?php 
session_start();
error_reporting(0);
if($_SESSION['email']) { 
$dato = $_GET['run'];
$uri  = "http://chile.rutificador.com/get_generic_ajax/";
$headers = [
      'Cookie: csrftoken=ioAfP80sm4cafdC8qgT9OoeCFb53KXGh;',
      'Content-type: application/x-www-form-urlencoded; charset=UTF-8',
      ];
$data = [
      'csrfmiddlewaretoken' => 'ioAfP80sm4cafdC8qgT9OoeCFb53KXGh', 
      'entrada'             => $dato
      //'entrada' => '18765525-0'
      ];
$data = http_build_query($data);
$ch   = curl_init();
curl_setopt($ch, CURLOPT_URL, $uri);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch); #Enviamos una petición curl y el resultado lo almacenamos en '$response'
curl_close($ch); 
$data=json_decode(utf8_encode($response),true);
foreach ($data as $value){
foreach($value as $f){
$name =  $f['name'];
$rut = $f['rut'];
}
}  
$porciones = explode(" ", $name);
$nombres = $porciones[2].' '.$porciones[3];
$apellidos = $porciones[0].' '.$porciones[1];
$arr = array("nombres" => $nombres,"apellidos" => $apellidos, "rut" => "$rut");
echo json_encode($arr);
}
?>