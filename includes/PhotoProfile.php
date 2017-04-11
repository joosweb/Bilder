<?php
if(@$_SESSION['email']) { 
?>
<script>
	function Show() {
		$('#changeA').toggle('slow');
	}
</script>
<div class="panel panel-default">
  <div class="panel-body">
  <div id="msg"></div>
    <table class="table">
	<tr>
		<td align="center">
			<?php
				if (ObtenerFotoperfil($_SESSION['id']) == '') {
				   echo '<a href="#" onClick="Show()"><img src="img/profile/fpo_avatar.png" id="avatarDefault" alt="" width="40px" height="40px" class="img-rounded" ></a>';
				} else {
				   echo '<a href="#" onClick="Show()"><img src="img/profile/avatar/' . ObtenerFotoperfil($_SESSION['id']) . '" alt="" width="40px" height="40px" id="avatarDefault" class="img-rounded" ></a>';
				}
			 ?>
			
		</td>
		<td>
			<b> Email: </b> <?php echo $_SESSION['email']; ?> 
		</td>
		</tr>
		<tr id="changeA">
		<td colspan="2" class="well">
			<div>
				<form id="uploadForm" action="#" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<input type="file" class="" name="userImage" type="file" style="width:90%;">
						</div>
						<div class="form-group">
						<button type="submit" id="Submit" class="btn btn-success btn-sm"><i class="fa fa-picture-o" aria-hidden="true"> </i> Actualizar foto de perfil
						</button>
					</div>
				</form>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="2">
		<ul class="list-unstyled">
			<li><a href="index.php?s=profile" class="btn btn-default btn-sm menu"><i class="fa fa-microphone" aria-hidden="true"></i> Noticias</a></li>
			<?php if(countMessages() <= 0) {  ?>
			<li><a href="index.php?s=inbox" class="btn btn-default btn-sm menu" ><i class="fa fa-envelope-o" aria-hidden="true"></i> Mensajes</a></li>
			<?php } else   { ?>
			<li><a href="index.php?s=inbox" class="btn btn-default btn-sm menu" ><i class="fa fa-envelope-o" aria-hidden="true"></i> Mensajes <span class="badge"><?php echo countMessages(); ?></a></li>
			<?php } ?>
			<li><a href="index.php?s=publish" class="btn btn-default btn-sm menu" ><i class="fa fa-clipboard" aria-hidden="true"></i> Publicar Deudor</a></li>
			<li><a href="index.php?s=publish-property" class="btn btn-default btn-sm menu"> 
			<i class="fa fa-home" aria-hidden="true"></i> Publicar propiedad</a></li>
			<li><a href="index.php?s=certified" class="btn btn-default btn-sm menu"> <i class="fa fa-certificate" aria-hidden="true"></i> Solicitar Certificado</a></li>			
			<li><a href="index.php?s=mycertified" class="btn btn-default btn-sm menu"> <i class="fa fa-folder-open-o" aria-hidden="true"></i> Mis certificados</a></li>
			<li><a href="index.php?s=publications" class="btn btn-default btn-sm menu" ><i class="fa fa-bullhorn" aria-hidden="true"></i> Mis Anuncios</a></li>
			<li><a href="index.php?s=changePassword" class="btn btn-default btn-sm menu" > 
			<i class="fa fa-unlock-alt" aria-hidden="true"></i> Cambiar Contraseña</a></li>			
			<li><a href="index.php?s=logout" class="btn btn-default btn-sm menu"> <i class="fa fa-sign-out" aria-hidden="true"></i> Salir</a></li>
			</ul>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<ul class="social-icons social-icons_sm">
              <li class="facebook">
                <a href="#"><i class="fa fa-facebook"></i></a>
              </li>
              <li class="twitter">
                <a href="#"><i class="fa fa-twitter"></i></a>
              </li>
              <li class="google-plus">
                <a href="#"><i class="fa fa-google-plus"></i></a>
              </li>
            </ul>
		</td>
	</tr>
</table>
 </div>
</div>
</div>
<?php
}
?>

