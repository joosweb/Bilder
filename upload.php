<?php
error_reporting(0);
session_start();
if($_SESSION['email'] and $_SESSION['id']) {
require 'db/conectar.php';
require 'includes/functions.php';
$pdo = new Conexion();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("SET CHARACTER SET utf8");
$stm2 = $pdo->prepare("SELECT * FROM account WHERE email = ?");
$stm2->execute(array($_SESSION['email']));
$r                = $stm2->fetch(PDO::FETCH_OBJ);
$fecha_expiracion = date("Y-m-d", strtotime("+1 day"));
$hoy              = date("Y-m-d");
$today            = strtotime($hoy);
$exp              = strtotime($r->change_photo);
$borrarFoto       = $r->photo;
$allowed          =  array('gif','png' ,'jpg','jpeg','JPEG','JPG','PNG','GIF');
$filename         = $_FILES['userImage']['name'];
$ancho_nuevo      =50;
$alto_nuevo       =90;
$ext = pathinfo($filename, PATHINFO_EXTENSION);
if(in_array($ext,$allowed) ) {
if($_FILES['userImage']['size'] < 50000000) {
if ($r->change_photo == '0000-00-00' or $today >= $exp) {
    if (is_array($_FILES)) {
        if (is_uploaded_file($_FILES['userImage']['tmp_name'])) {
            $str               = $_FILES['userImage']['name'];
            $extension_archivo = end(explode(".", $str));
            $sourcePath        = $_FILES['userImage']['tmp_name'];
            $name_image        = generarCodigo(18) . '.' . $extension_archivo;
            $targetPath        = "img/profile/avatar/" . $name_image;
            if (redim ($sourcePath,$targetPath,$ancho_nuevo,$alto_nuevo)) {
                $update = $pdo->prepare("UPDATE account set photo = ?, change_photo = ? WHERE email = ? LIMIT 1");
                $update->execute(array($name_image, $fecha_expiracion, $_SESSION['email']));
                unlink('img/profile/avatar/' . $borrarFoto . '');
                ?>
<img src="<?php echo $targetPath; ?>" width="60px" height="60px" class="img-rounded" />
<?php
}
        }
    }
} else {
    echo false;
}
}
else {
    echo 'SIZE';
}
}
else {
    echo 'type';
}
}
?>