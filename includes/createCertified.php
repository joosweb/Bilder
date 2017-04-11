<?php
$pdo = new Conexion();
$hoy = date("Y-m-d H:i:s");
if (htmlentities($_GET['token']) && $_GET['status'] == 'approved') {
    // Nº DE DOCUMENTO
    $codigo = generarCodigo(15);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET CHARACTER SET utf8");
    $stm = $pdo->prepare("SELECT * FROM solicitude WHERE token = ? AND  account_id = ?");
    $stm->execute(array($_GET['token'], $_GET['external_id']));
    $r = $stm->fetch(PDO::FETCH_OBJ);
    $cadena_encriptada = Encrypter::encrypt($codigo);
    if ($r->status == 'Pagado') {
        echo '<div class="alert alert-dismissible alert-warning">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Atención!</strong> Esta solicitud ya fue procesada.</a>.
                          </div>';
    } else if ($r->id) {
        $stm2 = $pdo->prepare("UPDATE solicitude set status = 'Pagado', fecha_pago = '$hoy' WHERE account_id=? AND token = ?");

        $stm2->execute(array($_SESSION['id'], $_GET['token']));

        $query = $pdo->prepare("SELECT * FROM debtor WHERE rut = ? and estado=1");
        $query->execute(array($r->rut_solicitado));
        $fetch = $query->fetch(PDO::FETCH_OBJ);

        if (@$fetch->id) {
            ///////// INICIO DEL CERTIFICADO CON ANTECENDETES
            @$texto= '<p>Gracias por confiar en nosotros, a continuación se le adjunto el certificado que solicito con el RUN <b>' . $r->rut_solicitado . '</b>, este certificado tiene una vigencia de 30 días desde hoy ' . obtenerFechaEnLetra($hoy) . '.<br><hr><a href="index.php?s=inbox&document=' . $cadena_encriptada . '" class="btn btn-success btn-xs"><i class="fa fa-download" aria-hidden="true"></i> Descargar Certificado</a></p>'; 

                  /* con archivos  @$texto= '<p>Gracias por confiar en nosotros, a continuación se le adjunto el certificado que solicito con el RUN <b>' . $r->rut_solicitado . '</b>, este certificado tiene una vigencia de 30 días desde hoy ' . obtenerFechaEnLetra($hoy) . '.<br><hr><a href="index.php?s=inbox&document=' . $cadena_encriptada . '" class="btn btn-success btn-xs"><i class="fa fa-download" aria-hidden="true"></i> Descargar Certificado</a> <a href="index.php?s=inbox&archivo=' . $cadena_encriptada . '" class="btn btn-warning btn-xs"><i class="fa fa-download" aria-hidden="true"></i> Descargar Archivos Adjuntos</a></p>';
                  */

                    $fecha_expiracion  = date("Y-m-d H:i:s", strtotime("+1 month"));
                    $insert=$pdo->prepare("INSERT INTO certified_autorized (id_solicitud,expiracion,numero_seguridad) values (?,?,?)");
                    if ($insert->execute(array($r->id, $fecha_expiracion, $codigo))) {
                    $inbox_insert = $pdo->prepare("INSERT INTO inbox (para,de,leido,fecha,asunto,texto,tipo) VALUES (?,?,?,?,?,?,?)");
                    if ($inbox_insert->execute(array($_SESSION['email'], 'noreply@bilder.cl', '', $hoy, 'Certificado RUN Nº: ' . $r->rut_solicitado, $texto, 0))) {
                        echo '<div class="alert alert-dismissible alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Exito!</strong>  Los antecedentes del RUN <b>' . $r->rut_solicitado . '</b> fueron enviados a Mensajes, por favor revise su bandeja de entrada.</a>.
                                      </div>';
                            } else {
                                echo '<div class="alert alert-dismissible alert-danger">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>Error 401!</strong> Por favor contacto con un administrador.
                                      </div>';
                            }
                        } else {
                            echo '<div class="alert alert-dismissible alert-danger">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>Error 402!</strong> Por favor contacto con un administrador.
                                      </div>';
                        }
            ///////// FIN DEL CERTIFICADO CON ANTECENDETES

        } else {
            // ENVIAR CERTIFICADO SIN ANTECEDENTES

            @$texto= '<p>Gracias por confiar en nosotros, a continuación se le adjunto el certificado que solicito con el RUN <b>' . $r->rut_solicitado . '</b>, este certificado tiene una vigencia de 30 días desde hoy ' . obtenerFechaEnLetra($hoy) . '.<br><hr><a href="index.php?s=inbox&document=' . $cadena_encriptada . '" class="btn btn-success btn-xs"><i class="fa fa-download" aria-hidden="true"></i> Descargar Certificado</a></p>';
            $fecha_expiracion  = date("Y-m-d H:i:s", strtotime("+1 month"));
            $insert            = $pdo->prepare("INSERT INTO certified_autorized (id_solicitud,expiracion,numero_seguridad) values (?,?,?)");
            if ($insert->execute(array($r->id, $fecha_expiracion, $codigo))) {
                // INSERTA MENSAJE EN INBOX DB
                $inbox_insert = $pdo->prepare("INSERT INTO inbox (para,de,leido,fecha,asunto,texto,tipo) VALUES (?,?,?,?,?,?,?)");
                if ($inbox_insert->execute(array($_SESSION['email'], 'noreply@bilder.cl', '', $hoy, 'Certificado RUN Nº ' . $r->rut_solicitado, $texto, 0))) {
                    echo '<div class="alert alert-dismissible alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Exito!</strong>  Los antecedentes del RUN <b>' . $r->rut_solicitado . '</b> fueron enviados a Mensajes, por favor revise su bandeja de entrada.</a>.
                                      </div>';
                            } else {
                                echo '<div class="alert alert-dismissible alert-danger">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>Error 401!</strong> Por favor contacto con un administrador.
                                      </div>';
                            }
                        } else {
                            echo '<div class="alert alert-dismissible alert-danger">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>Error 402!</strong> Por favor contacto con un administrador.
                                      </div>';
                        }
                    }
                } else {
                    echo '<div class="alert alert-dismissible alert-warning">
                                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                                      <h4>Ha ocurrido un error!</h4>
                                      <p>Por favor contacto con un administrador.</p>
                                    </div>';
                }
            }
            else if(htmlentities($_GET['token']) && htmlentities($_GET['status']) == 'pending') {
                echo '<div class="alert alert-dismissible alert-info">
                                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                                      <h4>Pago pendiente!</h4>
                                      <p>El pago con tarjeta de crédito está en proceso de acreditación por favor guarda el siguiente ID <b>'.$_GET['collection_id'].'</b> correspondiente al numero de tu transacción.</p>
                                    </div>';
            }
            else if(htmlentities($_GET['token']) && htmlentities($_GET['status']) == 'failure') {
                echo '<div class="alert alert-dismissible alert-danger">
                                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                                      <h4>Error de pago!</h4>
                                      <p>El pago no fue procesado, por favor verifica tus datos en el formulario de pago.</p>
                                    </div>';
            }
            ?>
            <div class="table-responsive">
            <?php
            require_once "lib/mercadopago.php";
            $mp = new MP("2846039952303794", "2WxMYCUjdm9cjkoU5Zz0La83i3nxbNTf");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec("SET CHARACTER SET utf8");
            $stm = $pdo->prepare("SELECT * FROM solicitude WHERE account_id = ?");
            $stm->execute(array($_SESSION['id']));
            $i = 0;
            $datos = false;

            

            while ($r = $stm->fetch(PDO::FETCH_OBJ)) {
            $datos = $r->id;
            $i++;
            $preference_data = array(
                "items"     => array(
            array(
                "title"       => "Certificado de Deudas",
                "currency_id" => "CLP",
                "category_id" => "Category",
                "picture_url" => "https://www.mercadopago.com/org-img/MP3/home/logomp3.gif",
                "quantity"    => 1,
                "unit_price"  => 990,
            ),
        ),
        "back_urls" => array(
            "success" => "http://www.bilder.cl/index.php?s=mycertified&external_id=".$_SESSION['id']."&status=approved&token=" . $r->token,
            "failure" => "http://www.bilder.cl/index.php?s=mycertified&status=failure&token=" . $r->token,
            "pending" => "http://www.bilder.cl/index.php?s=mycertified&status=pending&token=" . $r->token,
        ),

    );

    $preference = $mp->create_preference($preference_data);
    $solicitud = Encrypter::encrypt($r->id);

    if ($r->status == 'Pagado') {
        $href = '<span class="label label-info"><i class="fa fa-check" aria-hidden="true"></i> Pedido Procesado con exito</span>';
    } else {
        $href = '<a href="' . @$preference['response']['init_point'] . '" class="btn btn-danger btn-xs" name="MP-Checkout" mp-mode="modal"><i class="fa fa-cc-visa" aria-hidden="true"></i> Pagar</a>';
    }

    @$return = $return . '<tr>';
    $return  = $return . '<td>' . $i . '</td>';
    $return  = $return . '<td>' . $r->rut_solicitado . '</td>';
    $return  = $return . '<td>' . $r->fecha_solicitud . '</td>';
    $return  = $return . '<td>' . $r->fecha_pago . '</td>';
    if ($r->status == 'Pagado') {
        $return = $return . '<td><span class="label label-success" width="100%"><i class="fa fa-check" aria-hidden="true"></i>
' . $r->status . '</span></td>';
    } else {
        $return = $return . '<td><span class="label label-warning" style="width:100px;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> ' . $r->status . '</span></td>';
    }
    $return = $return . '<td>' . $href . '</td>';
    $return = $return . '<td><a href="index.php?s=mycertified&action=delete&solicitude='.$solicitud.'" class="btn btn-danger btn-xs"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar
</a></td>';
    $return = $return . '</tr>';
}
if($datos == false) {
    echo '<div class="alert alert-dismissible alert-info">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  Usted no posee solicitudes de certificados.
        </div>';
} else {
    echo '<table class="table table-bordered table-striped">
            <tr>
              <th>#</th>
              <th>Rut Solicitud</th>
              <th>Fecha Solicitud</th>
              <th>Fecha de Pago</th>
              <th>Estado</th>
              <th>Estado Pago</th>
              <th>Acción</th>
            </tr>';

    echo $return;
}



?>