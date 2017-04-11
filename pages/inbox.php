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
              <li class="active">Mensajes</li>
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
              <span>Mensajes recientes</span>
            </h1>
            <?php 
                if($_GET['archivo']){
                  include('includes/generarZIP.php');
                }
            ?>
            <?php 
             @$cadena_encriptada = $_GET['document'];
             if($cadena_encriptada != '') { 
             $pdo = new Conexion();
             $cadena_desencryptada = Encrypter::decrypt($cadena_encriptada);
             $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             $pdo->exec("SET CHARACTER SET utf8"); 
             $stm6= $pdo->prepare("SELECT * FROM solicitude INNER JOIN certified_autorized ON certified_autorized.id_solicitud=solicitude.id WHERE certified_autorized.numero_seguridad=?");
             $stm6->execute(array($cadena_desencryptada));
             $resul = $stm6->fetch(PDO::FETCH_OBJ);
             @$exp_date = $resul->expiracion;
             $todays_date = date("Y-m-d");
             $today = strtotime($todays_date);
             $expiration_date = strtotime($exp_date);
             if ($today > $expiration_date) { 
                echo '<hr><div class="alert alert-dismissible alert-danger">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Este certificado ya ha expirado con la fecha <b>'.$exp_date.'</b>.</strong>  Puedes solicitar uno nuevo <a href="index.php?s=certified">Aqui</a>.
                          </div>';
              } 
             }
            ?>
            <div class="table-responsive">
              <?php
                if(htmlentities(@$_GET['msg'])) {
                      include('includes/messageView.php');
                }
                else 
                {
                  include('includes/myinbox.php');
                }
              ?>
            </div> <!-- / .table-responsive -->
          </div> <!-- / .profile__body -->
        </div>
      </div> <!-- / .row -->
    </div> <!-- / .container -->


    <!-- MESSAGE
    ================================================== -->
    <div class="modal fade" id="profile__message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">New message</h4>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label class="sr-only">Subject</label>
                <input type="text" class="form-control" placeholder="Subject">
              </div>
              <div class="form-group">
                <label class="sr-only">Message</label>
                <textarea rows="5" class="form-control" placeholder="Message"></textarea>
              </div>
              <button type="button" class="btn btn-primary">Send message</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </form>
          </div>
        </div> <!-- / .modal-content -->
      </div> <!-- / .moda-dialog -->
    </div> <!-- / .modal -->