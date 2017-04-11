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
    <div class="container">
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
              <span>Importante</span>
            </h1>
            <p class="text-muted">
                <ul>
                <li><strong>Sobre la disponibilidad del servicio</strong>: Los responsables de este sitio web se comprometen a hacer todo lo posible para tenerlo siempre disponible al público, sin embargo no nos hacemos responsables de problemas técnicos fuera de nuestro control que ocasionen fallas temporales.</li><br>
                  <li>Toda la información será verificada por los editores del sitio para garantizar su veracidad, oportunidad y exactitud antes y durante su publicación</li>
                </ul>
                <hr>
            <h4>Requisitos para notificar sobre un deudor de arriendo</h4>
            <p class="text-muted">
            <ul>
              <li>Contrato de arriendo</li>
              <li>Documentación sobre la deuda (facturas, depositos, luz, agua, etc)  que avale la demuestre vigente</li>
              <li>Otros (constancia o demandas <- estos datos son opcionales) </li>
            </ul>
           </p>
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