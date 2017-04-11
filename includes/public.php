<?php if (isset($_POST['Publicar']) == 'Publicar') {

    // RECOPILAR DATOS
    $direccion_propiedad = $_POST['direccion_propiedad'];
    $region = $_POST['region'];
    $ciudad = $_POST['ciudad'];
    $motivo = $_POST['motivo'];
    $Run = $_POST['rut'];    
    $nombres = $_POST['nombres'];
    $apellidos  = $_POST['apellidos'];    
    $fecha_ocupacion = $_POST['fecha_ocupacion'];
    $fecha_desalojo = $_POST['fecha_desalojo'];
    $aval = $_POST['aval'];
    $nombre_aval = $_POST['nombre_aval'];  
    $denuncia = $_POST['denuncia'];
    $gastos_comunes = $_POST['gastos_comunes']; 
    $numero_causa = $_POST['numero_causa'];  
    $dano_propiedad = $_POST['dano_propiedad']; 
    $comentario = $_POST['comentario'];  

    // CARPETA GENERAL SEGUN EL RUT

    $carpeta = 'files/' . $Run;

    // CARPETA SEGUN EL PUBLICADOS

    $carpeta_publicador = 'files/' . $Run . '/' . crc32($_SESSION['email']);

    //Preguntamos si nuetro arreglo 'archivos' fue definido
    if (isset($_FILES["archivos"])) {
        //de se asi, para procesar los archivos subidos al servidor solo debemos recorrerlo
        //obtenemos la cantidad de elementos que tiene el arreglo archivos
        $tot = count($_FILES["archivos"]["name"]);
        // INSERCION DE DATOS EN TABLA DEUDORES

        $carpeta_usuario = crc32($_SESSION['email']);
        $id_account      = $_SESSION['id'];
        $pdo             = new Conexion();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("SET CHARACTER SET utf8");
        $stm2 = $pdo->prepare("INSERT INTO debtor (direccion_propiedad,region,comuna,motivo,rut,nombres,apellidos,fecha_ocupacion,fecha_desalojo,contaba_aval,nombres_aval,denuncia_cursada,gastos_comunes,numero_causa,dano_propiedad,comentario,account_id,carpeta,estado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $status_init = 0;

        if(valida_rut($Run)) {
        if ($_POST['captcha'] == $_SESSION['cap_code']) {
    if (empty($direccion_propiedad) or empty($region) or empty($ciudad) or empty($motivo) or empty($Run) or empty($nombres) or empty($apellidos)) {

                echo '<div class="alert alert-dismissible alert-warning">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          <h4>Atención!</h4>
                          <p>Debe llenar todos los campos del formulario.</p>
                        </div>';

            } else if ($stm2->execute(array($direccion_propiedad,$region,$ciudad,$motivo,$Run,$nombres,$apellidos,$fecha_ocupacion,$fecha_desalojo,$aval,$nombre_aval,$denuncia,$gastos_comunes,$numero_causa,$dano_propiedad,$comentario,$id_account,$carpeta_usuario, $status_init))) {

                // CREAR DIRECTORIO DE RUN SI NO EXISTE
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777, true);
                }

                // CREAR DIRECTORIO DEL PUBLICADOR CON HASH CRC32

                if (!file_exists($carpeta_publicador)) {
                    mkdir($carpeta_publicador, 0777, true);
                }

                //este for recorre el arreglo
                for ($i = 0; $i < $tot; $i++) {
                    //con el indice $i, poemos obtener la propiedad que desemos de cada archivo
                    //para trabajar con este

                    $tmp_name = $_FILES["archivos"]["tmp_name"][$i];
                    $name     = $_FILES["archivos"]["name"][$i];
                    $ext = end(explode(".", $_FILES["archivos"]["name"][$i]));
                    $nombre_final = generarCodigo(8);
                    move_uploaded_file($tmp_name, "$carpeta_publicador/$nombre_final.".$ext);
                }

                echo '<div class="alert alert-dismissible alert-success">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                            Su publicacion ha sido subida y esta pendiente su aprobación pronto recibira un mensaje en su bandeja de entrada con el resultado de la evaluación, recuerde que debemos serciorarnos que todos los datos sean verdaderos, lo cual puede tomar hasta maximo 24 hrs.
                        </div>';

            }
        } else {
            echo '<div class="alert alert-dismissible alert-danger">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                 El codigo de seguridad es incorrecto.
                              </div>';
        }
    }
    else {
        echo '<div class="alert alert-dismissible alert-danger">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                 El rut ingresado no es valido, por favor intente nuevamente.
                              </div>';
    }
  }
}