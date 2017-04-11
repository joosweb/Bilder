<?php
if(@!$_SESSION['email']) { 
  header('Location: index.php?s=sign-in');
}
// TOKEN 
$token = md5(uniqid(microtime(), true));
?>
<style>
  .a link
</style>
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
              <li class="active">Mis certificados</li>
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
              <span>Mis Certificados </span> 
            </h1> 
            <span style="float:right; padding:9px; margin-top:-25px;"> <form class="form-inline">
            </form>
            </span>
            <?php
            if(htmlentities($_GET['action'])){
                $solicitude = htmlentities($_GET['solicitude']);
                if(BorrarSolicitud($solicitude)) {
                  echo '<div class="alert alert-dismissible alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong><i class="fa fa-check-square-o" aria-hidden="true"></i> La solicitud ha sido eliminada.</strong></a>.
                      </div>';
                }
              }
            ?>
            <?php include('includes/createCertified.php'); ?>
             <script type="text/javascript" src="//resources.mlstatic.com/mptools/render.js"></script>
            </table>
           </div> <!-- / .profile__body -->
        </div>
      </div> <!-- / .row -->
    </div> <!-- / .container -->
