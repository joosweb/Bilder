<?php
$user_id = $_SESSION['id'];
$pdo = new Conexion();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("SET CHARACTER SET utf8");
$stm = $pdo->prepare("SELECT * FROM c_publisheds WHERE account_id = ?");
$sql = $stm->execute(array($user_id));

$i=1;

$status = false;

$return = $return.'<table class="table table-bordered">
         	 <th class="active">#</th>
         	 <th class="active">Titulo</th>
         	 <th class="active">Región</th>
         	 <th class="active">Comuna</th>
         	 <th class="active">Precio</th>
         	 <th class="active">Estado</th>
         	 <th class="active">Acción</th>';

while($r = $stm->fetch(PDO::FETCH_OBJ)) {

	$status = $r->id;

	$p_e_c = Encrypter::encrypt($r->id);

	if($r->status == 1) {
		$estado = '<span class="label label-success">Aprobado</span>';
	}
	else {
		$estado = '<span class="label label-danger">Rechazado</span>';
	}

	$precio_formateado = number_format($r->precio, 0, '', '.'); 

	$return = $return.'<tr><td>'.$i++.'</td>';
	$return = $return.'<td><textarea disabled>'.$r->titulo.'</textarea></td>';
	$return = $return.'<td><span class="label label-danger">'.$r->region.'</span></td>';
	$return = $return.'<td><span class="label label-primary">'.$r->comuna.'</span></td>';
	$return = $return.'<td>$ '.$precio_formateado.'</td>';
	$return = $return.'<td>'.$estado.'</td>';
	$return = $return.'<td><a href="index.php?s=publications&a=edit&token='.$p_e_c.'" title="Editar"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></i></a> <a href="index.php?s=publications&a=delete&token='.$p_e_c.'" title="Eliminar"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></a></td>';
}

if($status) {
	echo  $return.'</table>';
}

else {
	echo '<div class="alert alert-dismissible alert-info">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  Sin anuncios.
</div>';
}
?>