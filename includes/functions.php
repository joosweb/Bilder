<?php

$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
/**
 * Description of Encrypter
 *
 * @author jose
 */
class Encrypter
{

    private static $Key = "BILWEED";

    public static function encrypt($string)
    {
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_URANDOM);
        mcrypt_generic_init($td, Encrypter::$Key, $iv);
        $encrypted_data_bin = mcrypt_generic($td, $string);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $encrypted_data_hex = bin2hex($iv) . bin2hex($encrypted_data_bin);
        return $encrypted_data_hex;
    }

    public static function decrypt($encrypted_data_hex)
    {
        $td                 = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        $iv_size_hex        = mcrypt_enc_get_iv_size($td) * 2;
        $iv                 = pack("H*", substr($encrypted_data_hex, 0, $iv_size_hex));
        $encrypted_data_bin = pack("H*", substr($encrypted_data_hex, $iv_size_hex));
        mcrypt_generic_init($td, Encrypter::$Key, $iv);
        $decrypted = mdecrypt_generic($td, $encrypted_data_bin);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $decrypted;
    }

}

function enviarMensaje($email,$de,$fecha,$asunto,$mensaje,$tipo) {
    $pdo = new Conexion();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET CHARACTER SET utf8");

    $stm = $pdo->prepare("INSERT INTO inbox (para,de,leido,fecha,asunto,texto,tipo) VALUES (?,?,?,?,?,?,?)");
    $stm->execute(array($email,$de,'',$fecha,$asunto,$mensaje,0));

    return true;
}

function generaPass() {
    //Se define una cadena de caractares. Te recomiendo que uses esta.
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    //Obtenemos la longitud de la cadena de caracteres
    $longitudCadena=strlen($cadena);
     
    //Se define la variable que va a contener la contraseña
    $pass = "";
    //Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
    $longitudPass=10;
     
    //Creamos la contraseña
    for($i=1 ; $i<=$longitudPass ; $i++){
        //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
        $pos=rand(0,$longitudCadena-1);
     
        //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
        $pass .= substr($cadena,$pos,1);
    }
    return $pass;
}

function redim($ruta1,$ruta2,$ancho,$alto)
    {
    # se obtene la dimension y tipo de imagen
    $datos=getimagesize ($ruta1);
    
    $ancho_orig = $datos[0]; # Anchura de la imagen original
    $alto_orig = $datos[1];    # Altura de la imagen original
    $tipo = $datos[2];
    
    if ($tipo==1){ # GIF
        if (function_exists("imagecreatefromgif"))
            $img = imagecreatefromgif($ruta1);
        else
            return false;
    }
    else if ($tipo==2){ # JPG
        if (function_exists("imagecreatefromjpeg"))
            $img = imagecreatefromjpeg($ruta1);
        else
            return false;
    }
    else if ($tipo==3){ # PNG
        if (function_exists("imagecreatefrompng"))
            $img = imagecreatefrompng($ruta1);
        else
            return false;
    }
    
    # Se calculan las nuevas dimensiones de la imagen
    if ($ancho_orig>$alto_orig)
        {
        $ancho_dest=$ancho;
        $alto_dest=($ancho_dest/$ancho_orig)*$alto_orig;
        }
    else
        {
        $alto_dest=$alto;
        $ancho_dest=($alto_dest/$alto_orig)*$ancho_orig;
        }

    // imagecreatetruecolor, solo estan en G.D. 2.0.1 con PHP 4.0.6+
    $img2=@imagecreatetruecolor($ancho_dest,$alto_dest) or $img2=imagecreate($ancho_dest,$alto_dest);

    // Redimensionar
    // imagecopyresampled, solo estan en G.D. 2.0.1 con PHP 4.0.6+
    @imagecopyresampled($img2,$img,0,0,0,0,$ancho_dest,$alto_dest,$ancho_orig,$alto_orig) or imagecopyresized($img2,$img,0,0,0,0,$ancho_dest,$alto_dest,$ancho_orig,$alto_orig);

    // Crear fichero nuevo, según extensión.
    if ($tipo==1) // GIF
        if (function_exists("imagegif"))
            imagegif($img2, $ruta2);
        else
            return false;

    if ($tipo==2) // JPG
        if (function_exists("imagejpeg"))
            imagejpeg($img2, $ruta2);
        else
            return false;

    if ($tipo==3)  // PNG
        if (function_exists("imagepng"))
            imagepng($img2, $ruta2);
        else
            return false;
    
    return true;
    }
    
function countMessages()
{

    $pdo = new Conexion();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET CHARACTER SET utf8");

    $stm = $pdo->prepare("SELECT * FROM inbox WHERE para=? and leido=''");
    $stm->execute(array($_SESSION['email']));
    $count = $stm->rowCount();

    return $count;

}

function BorrarPublicacion($token) {

    $id_desencryptada = Encrypter::decrypt($token);

    $pdo = new Conexion();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET CHARACTER SET utf8");

    $stm2 = $pdo->prepare("SELECT * FROM c_publisheds WHERE id=? LIMIT 1");
    $stm2->execute(array($id_desencryptada));
    $rows = $stm2->fetch(PDO::FETCH_OBJ);

    $images = array($rows->img1, $rows->img2, $rows->img3, $rows->img4);
    
    $stm = $pdo->prepare("DELETE FROM c_publisheds WHERE id=? LIMIT 1");
    $stm->execute(array($id_desencryptada));

    unlink('visitas/'.$rows->id.'.txt');
    
    for ($i=0; $i < 4; $i++) { 
         unlink('img/clasificados/'.$images[$i]);
         unlink('img/clasificados/thumbs/'.$images[$i]);
    }

    return true;

}

function td($id) {

    $id_desencryptada =  Encrypter::decrypt($id);

    $pdo = new Conexion();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET CHARACTER SET utf8");
    $stm = $pdo->prepare("SELECT *  FROM c_publisheds WHERE id=?");
    $stm->execute(array($id_desencryptada));
    $row = $stm->fetch(PDO::FETCH_OBJ);
    return $row;
}

function BorrarSolicitud($id) {
    $id_solicitud =  Encrypter::decrypt($id);
    $pdo = new Conexion();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET CHARACTER SET utf8");
    $stm = $pdo->prepare("DELETE FROM solicitude WHERE id=? LIMIT 1");
    $execute = $stm->execute(array($id_solicitud));

    if($execute) {
        return true;
    }
    else {
        return false;
    }

}



function ObtenerFotoperfil($id)
{

    $pdo = new Conexion();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET CHARACTER SET utf8");

    $stm = $pdo->prepare("SELECT photo FROM account WHERE id=?");
    $stm->execute(array($id));
    $row = $stm->fetch(PDO::FETCH_OBJ);

    return $row->photo;

}

function obtenerFechaEnLetra($fecha)
{

    $dia = conocerDiaSemanaFecha($fecha);

    $num = date("j", strtotime($fecha));

    $anno = date("Y", strtotime($fecha));

    $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');

    $mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];

    return $dia . ', ' . $num . ' de ' . $mes . ' del ' . $anno;

}

function conocerDiaSemanaFecha($fecha)
{

    $dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');

    $dia = $dias[date('w', strtotime($fecha))];

    return $dia;

}

function generarCodigo($longitud)
{
    $key     = '';
    $pattern = '1234567890';
    $max     = strlen($pattern) - 1;
    for ($i = 0; $i < $longitud; $i++) {
        $key .= $pattern{mt_rand(0, $max)};
    }

    return $key;
}


function valida_rut($r)
{
    $r=strtoupper(ereg_replace('\.|,|-','',$r));
    $sub_rut=substr($r,0,strlen($r)-1);
    $sub_dv=substr($r,-1);
    $x=2;
    $s=0;
    for ( $i=strlen($sub_rut)-1;$i>=0;$i-- )
    {
        if ( $x >7 )
        {
            $x=2;
        }
        $s += $sub_rut[$i]*$x;
        $x++;
    }
    $dv=11-($s%11);
    if ( $dv==10 )
    {
        $dv='K';
    }
    if ( $dv==11 )
    {
        $dv='0';
    }
    if ( $dv==$sub_dv )
    {
        return true;
    }
    else
    {
        return false;
    }
}
