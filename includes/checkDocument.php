<?php
error_reporting(0);
require('../db/conectar.php');
require('../includes/functions.php');
$Ndocument = $_POST['documento'];
if(empty($Ndocument)) {
	echo 'vacios';
	exit();
}
$pdo = new Conexion();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("SET CHARACTER SET utf8");
$stm = $pdo->prepare("SELECT * FROM solicitude INNER JOIN certified_autorized ON certified_autorized.id_solicitud=solicitude.id WHERE certified_autorized.numero_seguridad=?");
$stm->execute(array($Ndocument));
$row = $stm->fetch(PDO::FETCH_OBJ);
$exp_date=$row->expiracion;
$todays_date = date("Y-m-d");
$today = strtotime($todays_date);
$expiration_date = strtotime($exp_date);
if(!$row->id) {
	echo 'Noexiste';
	exit();
}
if ($expiration_date >= $today) {

	$stm2 = $pdo->prepare("SELECT * FROM debtor WHERE rut = ? AND estado=1");
	$stm2->execute(array($row->rut_solicitado));
	$rows = $stm2->fetch(PDO::FETCH_OBJ);

	if($rows->id) {
		echo '<table width="100%" class="table profile__inbox">
			  <tbody>
			    <tr>
			      <td width="18%">Dirección de propiedad:</td>
			      <td width="82%">'.$rows->direccion_propiedad.'</td>
			    </tr>
			    <tr>
			      <td>Región:</td>
			      <td>'.$rows->region.'</td>
			    </tr>
			    <tr>
			      <td>Comuna:</td>
			      <td>'.$rows->comuna.'</td>
			    </tr>
			    <tr>
			      <td>Motivo</td>
			      <td>'.$rows->motivo.'</td>
			    </tr>
			    <tr>
			      <td>Rut</td>
			      <td>'.$rows->rut.'</td>
			    </tr>
			    <tr>
			      <td>Nombres</td>
			      <td>'.$rows->nombre.'</td>
			    </tr>
			    <tr>
			      <td>Apellidos</td>
			      <td>'.$rows->apellidos.'</td>
			    </tr>
			    <tr>
			      <td>Fecha de ocupación</td>
			      <td>'.$rows->fecha_ocupacion.'</td>
			    </tr>
			    <tr>
			      <td>Fecha de desalojo</td>
			      <td>'.$rows->fecha_desalojo.'</td>
			    </tr>
			    <tr>
			      <td>Contaba con Aval</td>
			      <td>'.$rows->contaba_aval.'</td>
			    </tr>
			    <tr>
			      <td>Nombre Aval</td>
			      <td>'.$rows->nombres_aval.'</td>
			    </tr>
			    <tr>
			      <td>Denuncia Cursada</td>
			      <td>'.$rows->denuncia_cursada.'</td>
			    </tr>
			    <tr>
			      <td>Numero de causa</td>
			     <td>'.$rows->numero_causa.'</td>
			    </tr>
			    <tr>
			      <td>Gastos Comunes</td>
			      <td>$ '.number_format($rows->gastos_comunes, 0, '', '.').'</td>
			    </tr>
			    <tr>
			      <td>Daños a la propiedad</td>
			      <td>'.$rows->dano_propiedad.'</td>
			    </tr>
			    <tr>
			      <td>Comentario</td>
			      <td>'.$rows->comentario.'</td>
			    </tr>
			  </tbody>
			</table>';
	}
	else
	{
		echo '<div class="alert alert-dismissible alert-success">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			  <strong><i class="fa fa-check-circle-o" aria-hidden="true"></i>
 				Certificado Vigente! <hr></strong> <i class="fa fa-check-circle-o" aria-hidden="true"></i> Esta persona no posee historial de arriendos.
			  <hr> <i class="fa fa-check-circle-o" aria-hidden="true"></i> Este certificado vence el <strong>'.obtenerFechaEnLetra($row->expiracion).'</strong></a>.
			</div>';
	}

	
}
else {
	echo 'caducado';
}

?>