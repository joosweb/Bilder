<?php
if(@$_SESSION['email']) { 
try {
    $pdo = new Conexion();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET CHARACTER SET utf8");
    $stm2 = $pdo->prepare("SELECT * FROM inbox WHERE para = ?");
    $stm2->execute(array($_SESSION['email'])); 

    while ($row = $stm2->fetch(PDO::FETCH_OBJ)) {

        $cadena_encriptada = Encrypter::encrypt($row->ID);

        if ($row->leido == '') {
            $classStrong = '<strong>' . $row->de . '</strong>';
            $class = 'success';
        } else {
            $classStrong = $row->de;
            $class = '';
        }
        {
            $letras = substr($row->asunto, 0, 120);

            @$RETURN = $RETURN . '<table class="table profile__inbox">
			                <tbody>
			                  <tr class="'.$class.'">
			                  <td style="width:5%;">
			                  	<input type="checkbox" name="hobbies[]" />
			                  </td>
			                    <td style="width:26%;">
			                      <div class="profile-inbox__img">
			                        <a href="index.php?s=inbox&msg=' . $cadena_encriptada . '">
			                        '.$classStrong.'
			                      </a>
			                      </div>
			                      </td>
			                      
			                     <td>
			                      <a href="index.php?s=inbox&msg=' . $cadena_encriptada . '">
			                     ' . $letras . '
			                      </a>
			                    </td>
			                    <td align="right">
								'.$row->fecha.'
			                    </td>
			                  </tr>
			                  <tr>
			                  </tr>
			                </tbody>
			              </table>';
        }
    }
    if (@$RETURN) {
        echo @$RETURN;
    } else {
        echo '<div class="alert alert-dismissible alert-info">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <h4>Sin mensajes!</h4>
						  <p> Por el momento no posee mensajes en su bandeja de entrada.</p>
						  </div>';
    }

} catch (Exception $e) {
    die($e->getMessage());
}
}
