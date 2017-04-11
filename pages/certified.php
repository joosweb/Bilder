<?php
if(@!$_SESSION['email']) { 
  header('Location: index.php?s=sign-in');
}
// TOKEN 
$token = md5(uniqid(microtime(), true));
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
              <li class="active">Obten un certificado</li>
            </ol>
          </div>
        </div> <!-- / .row -->
      </div> <!-- / .container -->
    </div>
   <!-- CONTENT
    ================================================== -->
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
           </nav>
           <div class="profile__body">
            <!-- Messages -->
            <h1 class="block-header alt">
            <span>Solicitar un certificado</span>
            </h1>          
            <?php include('includes/solicitudes.php'); ?>
              <div class="row ">
                <div class="col-sm-6">
                  <div class="form-group">
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <form action="index.php?s=certified" id="certified-request" class="form-inline" name="certified-request"   method="POST">
                    <div class="form-group"> 
                    <label for="">RUN: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>     
                   <input type="text" id="rut" class="form-control" name="rut" required  placeholder="RUN">
                   </div>                   
                   <div class="form-group" style="margin-top:5px;"> 
                   <img src="includes/captcha.php" width="66" />
                   <input type="text" id="captcha" name="captcha" class="form-control" required  placeholder="CODIGO">
                   </div>
                  </div>
                </div>
              </div>
              <div class="checkbox">
                <input type="checkbox" name="condiciones" value="1" id="profile-sign-in__remember">
                <label for="profile-sign-in__remember">
                 Acepto los <a href="index.php?s=terms-services">Term. del servicio</a> y las<a href="index.php?s=politics"> Politicas de privacidad</a>
                </label>
              </div><hr>
              <input type="submit" class="btn btn-success btn-sm" name="Solicitar" value="Solicitar">
            </form>
            </div>
          </div>     
         </div> <!-- / .profile__body -->
        </div>
      </div> <!-- / .row -->
    </div> <!-- / .container -->