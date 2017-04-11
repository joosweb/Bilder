<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
	function change(id) {
		if(id == 1) {
			var img1 = $('.tg-yw41 img').attr('rel');
			$('.img-big').html('<img src="'+img1+'" alt="" width="100%" height="300px">');
		}
		else if(id == 2) {
			var img2 = $('.tg-yw42 img').attr('rel');
			$('.img-big').html('<img src="'+img2+'" alt="" width="100%" height="300px">');
		}
		else if(id == 3) {
			var img3 = $('.tg-yw43 img').attr('rel');
			$('.img-big').html('<img src="'+img3+'" alt="" width="100%" height="300px">');
		}
		else {
			var img4 = $('.tg-yw44 img').attr('rel');
			$('.img-big').html('<img src="'+img4+'" alt="" width="100%" height="300px">');
		}
	}
	$('.img-big').html('<center><img src="img/loading/loading.gif" width="70px" height="70px"/></center>');
	setTimeout(function(){
  change(1);
}, 1000); /// CARGANDO LA PRIMERA IMAGEN POR DEFECTO
</script>
<script>
	$(document).ready(function() {
		$('#FormContact').submit(function(e) {
			e.preventDefault();

			var nombreF  = $('#nombreF').val();
			var email    = $('#email').val();
			var telefono = $('#telefono').val();
			var mensaje  = $('#mensaje').val();
			var publicID = $('#publicID').val();

			var data = 'nombreF=' + nombreF + '&emailForm=' + email + '&telefono=' + telefono + '&mensaje=' + mensaje + '&publicID=' + publicID;

			$.ajax({
            type: 'POST',
            url: 'includes/EnviarEmail.php',
            data: data,
            beforeSend: function() {
                $("#ButtonContact").html('<i class="fa fa-cloud-upload" aria-hidden="true"></i> Enviando <i class="fa fa-spinner fa-spin fa-lg fa-fw"></i>');
            },
            success: function(response) {
                if (response == 'ok') {
                    $('#msgContact').html('<div class="alert alert-dismissible alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><i class="fa fa-check-circle" aria-hidden="true"></i> Mensaje enviado.</div>');
                    $("#ButtonContact").html('Enviar');
                } else {
                    $('#msgContact').html(response);
                    $("#ButtonContact").html('Enviar');
                }
              }
            });
		});
	});
</script>
<?php
error_reporting(0);
require('../db/conectar.php');
$class_id = $_POST['classifieds_id'];
$pdo = new Conexion();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("SET CHARACTER SET utf8");
$stm = $pdo->prepare("SELECT * FROM c_publisheds WHERE id = ?");
$stm->execute(array($class_id));
$r = $stm->fetch(PDO::FETCH_OBJ);

// BUSCANDO DATOS DE LA PERSONA EN CUESTIÓN
$find = $pdo->prepare("SELECT * FROM account WHERE id=?");
$find->execute(array($r->account_id));
$rows = $find->fetch(PDO::FETCH_OBJ);
///////////////////

/// ACTUALIZAR VISITA

    $ip = $_SERVER['REMOTE_ADDR'];

    $existe = 0;
    $visitas = 0;
    $fp = fopen('../visitas/'.$r->id.'.txt',"r"); //no olvidar crear al archivo visitantes.txt y poner el path correcto
    while($ip2 = fgets($fp)){
        $visitas++;
        $ips .= $ip2;
        if($ip."\n" == $ip2)$existe = 1;
    }
    fclose($fp);
    if($existe == 0){
        $fp = fopen('../visitas/'.$r->id.'.txt','w+'); //no olvidar crear al archivo visitantes.txt y poner el path correcto
        fwrite($fp, $ip."\n".$ips);
        fclose($fp);
    }

?>
<div class="row">
<div class="col-md-8">
		<table class="table">
		  <tr>
		   <th class="img-big" colspan="4" rowspan="3"></th>
		  </tr>
		  <tr>
		  </tr>
		  <tr>
		  </tr>
		  <tr>
		    <td class="tg-yw41" width="20%"><img onClick='change(1)' rel="img/clasificados/<?php echo $r->img1; ?>" src="img/clasificados/thumbs/<?php echo $r->img1; ?>" alt="" width="100%" height="100px"></td>
		    <td class="tg-yw42" width="20%"><img onClick='change(2)' rel="img/clasificados/<?php echo $r->img2; ?>" src="img/clasificados/thumbs/<?php echo $r->img2; ?>" alt="" width="100%" height="100px"></td>
		    <td class="tg-yw43" width="20%"><img onClick='change(3)' rel="img/clasificados/<?php echo $r->img3; ?>" src="img/clasificados/thumbs/<?php echo $r->img3; ?>" alt="" width="100%" height="100px"></td>
		    <td class="tg-yw44" width="20%"><img onClick='change(4)' rel="img/clasificados/<?php echo $r->img4; ?>" src="img/clasificados/thumbs/<?php echo $r->img4; ?>" alt="" width="100%" height="100px"></td>
		  </tr>
		  <tr>
		    <td class="tg-yw4l" colspan="4" rowspan="3" width="50%">
		    	<div class="panel panel-default">
					  <div class="panel-body">
					    <p id="texto" style="text-align:justify !important;"><?php echo $r->descripcion; ?></p>
					  </div>
					</div>
		       </td>
		    </tr>
		  <tr>
		  </tr>
		  <tr>
		  </tr>
	</table>
</div>
<div class="col-md-4">
<table class="table" >
	<tr>
		<td width="10%"> <i class="fa fa-user-circle fa-3x" aria-hidden="true"></i></td>
		<td> <b style="font-size:16px;"><?php echo $r->nombre; ?></b> <br> <i class="fa fa-whatsapp" aria-hidden="true"></i> <span style="font-size:14px;"><?php echo $r->telefono; ?></span></td>
	</tr>
</table>
<div id="msgContact"></div>
<div class="panel panel-default">
<div class="panel-heading">Enviale un mensaje</div>
  <div class="panel-body"> 
    <form method="POST" id="FormContact" action="">
    	<div class="form-group">
		  <div class="input-group">
		  <div class="input-group-addon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></div>
		    <input type="hidden" id="publicID" value="<?php echo $class_id; ?>">
		    <input type="text" class="form-control" id="nombreF" placeholder="Tu nombre" required>
		  </div>
		  </div>
		  <div class="form-group">
		  <div class="input-group">
		  <div class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></div>
		    <input type="email" class="form-control" id="email" placeholder="Tu Email" required>
		  </div>
		  </div>
		  <div class="form-group">
		  <div class="input-group">
		  <div class="input-group-addon"><i class="fa fa-phone" aria-hidden="true"></i></div>
		    <input type="text" class="form-control" id="telefono" placeholder="Tu telefono" required>
		  </div>
		  </div>
		   <div class="form-group">
		    <textarea name="" class="form-control" id="mensaje" cols="30" rows="10" style="width: 100%;" placeholder="Mensaje" required></textarea>
		  </div>
		  <button type="submit" id="ButtonContact" class="btn btn-warning">Enviar</button>
		</form>
  </div>
</div>
</div>
</div>