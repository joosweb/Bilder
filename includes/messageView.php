<?php
if(@$_SESSION['email']) { 
$GET_ID = $_GET['msg'];

$pdo = new Conexion();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("SET CHARACTER SET utf8");

$cadena_encriptada = Encrypter::decrypt($GET_ID);

$link = $pdo->prepare("SELECT * FROM inbox WHERE ID = ?");
$link->execute(array($cadena_encriptada));
$row = $link->fetch(PDO::FETCH_OBJ);

$update = $pdo->prepare("UPDATE inbox set leido = 'Si' WHERE ID=?");
$update->execute(array($cadena_encriptada));

?>

<div id="politics">
     <div id=""><strong>Bilder.cl </strong>| De: <?php echo $row->de; ?></div><hr>
     <?php echo $row->texto; ?>
     </div>
</div>
<?php
}
?>