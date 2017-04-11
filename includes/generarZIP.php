<?php
if(@$_SESSION['email']) { 
@$cadena_encriptada   = $_GET['archivo'];
$cadena_desencryptada = Encrypter::decrypt($cadena_encriptada);
$pdo                  = new Conexion();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("SET CHARACTER SET utf8");
$stm5 = $pdo->prepare("SELECT * FROM solicitude INNER JOIN certified_autorized ON certified_autorized.id_solicitud=solicitude.id WHERE certified_autorized.numero_seguridad=?");
$stm5->execute(array($cadena_desencryptada));
$rowss           = $stm5->fetch(PDO::FETCH_OBJ);
$exp_date       = $rowss->expiracion;
$todays_date     = date("Y-m-d");
$today           = strtotime($todays_date);
$expiration_date = strtotime($exp_date);

$query = $pdo->prepare("SELECT * FROM debtors WHERE run = ? and status=1");
$query->execute(array($rowss->rut_solicitado));
$fetch = $query->fetch(PDO::FETCH_OBJ);

$name_archive = Encrypter::encrypt($rowss->carpeta);

if($fetch->id) {
	if ($expiration_date >= $today) {
    // Creamos un instancia de la clase ZipArchive
    $zip = new ZipArchive();
    // Creamos y abrimos un archivo zip temporal
    $zip->open($name_archive . '.zip', ZipArchive::CREATE); // Añadimos un directorio
    $dir = 'Documentos';
    $zip->addEmptyDir($dir);

    /// GUARDAR CARPETAS A RECORRER 
	$query2 = $pdo->prepare("SELECT * FROM debtors WHERE run = ? and status=1");
	$query2->execute(array($rowss->rut_solicitado));
	$count = $query2->rowCount();
	while ($fetch2 = $query2->fetch(PDO::FETCH_OBJ)) {
		$carpeta[] = $fetch2->carpeta;
	}

	for ($e=0; $e < $count; $e++) { 
		 $directorio = opendir('files/' . $rowss->rut_solicitado . '/' . $carpeta[$e] . '/' . $archivo . ''); //ruta actual

		 while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
	    {
	        if (!is_dir($archivo)) //verificamos si es o no un directorio
	        {	
	        	for ($i=0; $i < $count; $i++) { 
                    $extension = end(explode(".", $archivo));
                    $name_final = generarCodigo(12).'.'.$extension;
	        		$zip->addFile('files/' . $rowss->rut_solicitado . '/' . $carpeta[$i] . '/' . $archivo . '', $dir . '/' .$name_final.'');
	        	}         
	        }
	    }
	}
    
    // Añadimos un archivo en la raid del zip.

    // Una vez añadido los archivos deseados cerramos el zip.
    $zip->close();
    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($name_archive . '.zip')) . ' GMT');
    header('Content-Type: application/force-download');
    header('Content-Disposition: inline; filename=' . $name_archive . '.zip');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($name_archive . '.zip'));
    header('Connection: close');
    ob_end_clean();
    flush();
    readfile($name_archive . '.zip');
    ignore_user_abort(true);
    unlink($name_archive . '.zip');
    die();
	} else {
    echo '<hr><div class="alert alert-dismissible alert-danger">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Este archivo a expirado con la fecha <b>' . $exp_date . '</b>.</strong>  Puedes solicitar uno nuevo <a href="index.php?s=certified">Aqui</a>.
                          </div>';
}
}
}
?>
