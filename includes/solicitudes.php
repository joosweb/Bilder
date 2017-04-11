 <?php
if (htmlentities(@$_POST['Solicitar'] == 'Solicitar')) {
    $run = $_POST['rut'];
    if ($_POST['captcha'] == $_SESSION['cap_code']) {
        if (isset($_POST['condiciones']) && $_POST['condiciones'] == '1') {
            if (valida_rut($run)) {

                $pdo = new Conexion();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->exec("SET CHARACTER SET utf8");

                $stmm = $pdo->prepare("SELECT * FROM solicitude WHERE rut_solicitado = ? and account_id = ?");

                $hoy        = date("Y-m-d H:i:s");
                $fecha_pago = '0000-00-00 00:00:00';
                $captcha    = $_POST['captcha'];
                $stmm->execute(array($run,$_SESSION['id']));

                while($r = $stmm->fetch(PDO::FETCH_OBJ)) {
                    $array[] = $r->status;
                }

                $id = $_SESSION['id'];

                $stm2 = $pdo->prepare("INSERT INTO solicitude (token,account_id,rut_solicitado,fecha_solicitud,fecha_pago) VALUES (?,?,?,?,?)");

                if (in_array('Pendiente', $array)) {
                    echo '<div class="alert alert-dismissible alert-danger">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                 Ya solicitaste un certificado con este rut, solo puedes solicitar 1 certificado por rut a la vez.
                              </div>';
                } else {
                    if ($stm2->execute(array($token, $id, $run, $hoy, $fecha_pago))) {

                        echo '<div class="alert alert-dismissible alert-success">
                                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                                      <strong>Solicitud procesada satisfactoriamente!</strong><br><hr> Ahora seras derivado a <strong>Mis Certificados</strong> donde deberas pagar para poder recibir el certificado en cuestion, espera unos segundos...
                                    </div>';

                        $url      = "index.php?s=mycertified"; //here you set the url
                        $time_out = 5; //here you set how many seconds to untill refresh
                        header("refresh: $time_out; url=$url");

                    } else {

                        echo '<div class="alert alert-dismissible alert-danger">
                                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                                          <strong>Error!</strong> Por favor contacta con un administrador.
                                        </div>';
                    }
                }
            } else {
                echo '<div class="alert alert-dismissible alert-danger">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> El rut ingresado no es valido.
                              </div>';
            }
        } else {
            echo '<div class="alert alert-dismissible alert-danger">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                 Debes aceptar los terminos y politicas de privacidad.
                              </div>';
        }
    } else {
        echo '<div class="alert alert-dismissible alert-danger">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                 El codigo de seguridad es incorrecto.
                              </div>';
    }
}
?>