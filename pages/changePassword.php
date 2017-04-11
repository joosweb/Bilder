<?php
if(@!$_SESSION['email']) { 
  header('Location: index.php?s=sign-in');
}
?>
   <!-- Header -->
    <div class="page-topbar">
      <div class="container">
        <div class="row">
          <div class="col-sm-4">
            <h3>Panel de Usuario</h3>   
          </div>
          <div class="col-sm-8 hidden-xs">   
            <ol class="breadcrumb">
              <li><a href="index.php?s=home">Inicio</a></li>
              <li class="active">Guia</li>
            </ol>
          </div>
        </div> <!-- / .row -->
      </div> <!-- / .container -->
    </div>
    <div class="container-fluid">
    <?php if(@$_GET['msg'] == 'welcome') { ?>
      <div class="alert alert-dismissible alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Felicidades!</strong> Te has registrado satisfactoriamente te invitamos a conocer tu panel de usuario, donde podras tanto subir deudores como pedir certificados.
      </div>
    </div>
    <?php
    }
  ?>
<!-- CONTENT ================================================== -->
    <div class="container">
      <div class="row">
        <div class="col-sm-3">
          <div class="profile__aside">
            <div class="profile__img">
              <?php include('includes/PhotoProfile.php'); ?>
            <!-- / <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#profile__message">
              <i class="fa fa-envelope-o"></i> Send message
            </a>
            -->
          </div> <!-- / .profile__aside -->
        </div>
        <div class="col-sm-9">
         <!-- Profile nav -->
          <nav class="clearfix">
          <div class="table-responsive">
           </nav>
          <div class="profile__body">
            <h1 class="block-header alt">
              <span>Cambiar Contraseña</span>
            </h1>
            <div id="msg-changeP"></div>
            <div class="panel panel-default">
              <div class="panel-body">
                <form action="index.php?s=changePassword" method="POST" id="formCpassword">
                <div class="form-group">
                  <label for="exampleInputEmail1">Actual Contraseña</label>
                  <input type="password" class="form-control" id="password" placeholder="Actual contraseña">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Nueva Contraseña</label>
                  <input type="password" class="form-control" id="Npassword" placeholder="Nueva contraseña">
                </div>                
                <div class="form-group">
                  <label for="exampleInputPassword1">Confirmar Nueva Contraseña</label>
                  <input type="password" class="form-control" id="RNpassword" placeholder="Repetir nueva contraseña">
                </div> 
                 <!-- reCAPTCHA -->
                  <div class="form-group" id="form-captcha">
                    <div class="g-recaptcha" data-sitekey="6LeGURQUAAAAAIDv9Y9LkAMfcSM5ShBjhF6WTrim"></div>
                    <span class="help-block"></span>
                  </div>
                  <!-- /reCAPTCHA -->               
                <button type="submit" class="btn btn-default" id="CambiarContrasena">Cambiar Contraeña</button>
              </form>
              </div>
            </div>
           </div> <!-- / .profile__body -->
        </div>
      </div> <!-- / .row -->
    </div> <!-- / .container -->
    