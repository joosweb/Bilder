<?php
ob_start();
session_start();
error_reporting(0);
require ('db/conectar.php');
require ('includes/functions.php');
require ('includes/generarPDF.php');
require_once ('libraries/Google/autoload.php');
require_once "fbsdk4-5.1.2/src/Facebook/autoload.php";
require_once "credentials.php";
$fb = new Facebook\Facebook([
  'app_id' => $app_id, // Replace {app-id} with your app id
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.2'
  ]);
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // permisos
$loginUrl = $helper->getLoginUrl($login_url, $permissions);
//Insert your cient ID and secret 
//You can get it from : https://console.developers.google.com/
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");
$service = new Google_Service_Oauth2($client);
$authUrl = $client->createAuthUrl();
?>
<!DOCTYPE html>
<html lang="es">
  <head class="html_boxed">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Bilder recopila información de deudores de arriendos en chile, en bilder puedes pedir un informe de deudas de arriendos con solo 2 clicks.">
    <meta name="author" content="">
    <meta name="keywords" content="ARRENDAR, CERTIFICADO, DEUDAS, CASAS, DEPARTAMENTOS, TERRENOS">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/assets/favicon/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/assets/favicon/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/assets/favicon/manifest.json">
    <link rel="mask-icon" href="/assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
    <meta http-equiv="Cache-Control" content="no-store" />
    <meta http-equiv="Cache-Control" content="no-cache" />  
    <meta http-equiv="expires" content="Fri, 18 Jul 2014 1:00:00 GMT" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>Bilder | Arrienda con seguridad </title>
    <!-- CSS Plugins -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" >
    <!-- CSS Global -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="assets/css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/summernote.css">
    <link rel="stylesheet" href="assets/css/bootstrap-social.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600italic,600,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="assets/js/wfobject.js"></script>
    <script type="text/javascript" src="scripts/upload.js"></script>
    <script type="text/javascript" src="scripts/Rutificador.js"></script>
    <script type="text/javascript" src="scripts/clasifieds-ajax.js"></script>
    <script type="text/javascript" src="assets/js/summernote.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <!-- Isolated Version of Bootstrap, not needed if your site already uses Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css" />
    <!-- Bootstrap Date-Picker Plugin -->
  </head>
  <body>
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.8&appId=607228309460552";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
  </script>
    <!-- NAVIGATION
    ================================================== -->
    <!-- Navbar -->
    <nav class="navbar navbar-default">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar_main" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php?s=home"><img src="logo_body.png" alt="Logo" width="60"></a>
          </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar_main">
          <ul class="nav navbar-nav navbar-left">
            <li><a href="index.php?s=home">Inicio</a></li>
            <li><a href="index.php?s=services">servicios</a></li>
            <li><a href="index.php?s=vision">vision</a></li>
            <li><a href="index.php?s=politics">politicas</a></li>
            <li><a href="index.php?s=classifieds">Clasificados</a></li>
            <li><a href="index.php?s=contact">contacto</a></li>
          </ul>
          <?php if (@!$_SESSION['email']) {?>
          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="index.php?s=sign-in"><i class="fa fa-lock"></i> <span class="hidden-md">Iniciar sesión</span></a>
            </li>
            <li>
              <a href="index.php?s=sign-up"><i class="fa fa-user"></i> <span class="hidden-md">Registro</span></a>
            </li>
          </ul>
            <?php } else {?>
              <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="index.php?s=profile"><i class="fa fa-lock"></i> <span class="hidden-md">Panel de Usuario</span></a>
            </li>
            <li>
              <a href="index.php?s=logout"><i class="fa fa-user"></i> <span class="hidden-md">Salir</span></a>
            </li>
          </ul>
            <?php
            }
            ?>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container -->
    </nav>
    <!--- NAVEGACION -->
    <?php
    $page = @htmlentities($_GET['s']);
    switch ($page) {
        case 'classifieds':
            if (file_exists('pages/classifieds.php')) {
                include 'pages/classifieds.php';
            } else {
                include 'pages/404.html';
            }
            # code...
            break;
        case 'home':
            if (file_exists('pages/home.php')) {
                include 'pages/home.php';
            } else {
                include 'pages/404.html';
            }
            # code...
            break;
        case 'contact':
            if (file_exists('pages/contact.php')) {
                include 'pages/contact.php';
            } else {
                include 'pages/404.html';
            }
            # code...
            break;
        case 'sign-in':
            if (file_exists('pages/sign-in.php')) {
                include 'pages/sign-in.php';
            } else {
                include 'pages/404.html';
            }
            # code...
            break;
        case 'logout':
            if (file_exists('pages/logout.php')) {
                include 'pages/logout.php';
            } else {
                include 'pages/404.html';
            }
            # code...
            break;
        case 'sign-up':
            if (file_exists('pages/sign-up.php')) {
                include 'pages/sign-up.php';
            } else {
                include 'pages/404.html';
            }
            # code...
            break;
        case 'profile':
            if (file_exists('pages/profile.php')) {
                include 'pages/profile.php';
            } else {
                include 'pages/404.html';
            }
            # code...
            break;
        case 'inbox':
            if (file_exists('pages/inbox.php')) {
                include 'pages/inbox.php';
            } else {
                include 'pages/404.html';
            }
            # code...
            break;
        case 'publish':
            if (file_exists('pages/publish.php')) {
                include 'pages/publish.php';
            } else {
                include 'pages/404.html';
            }
            # code...
            break;
        case 'certified':
            if (file_exists('pages/certified.php')) {
                include 'pages/certified.php';
            } else {
                include 'pages/404.html';
            }
            # code...
            break;
        case 'services':
            if (file_exists('pages/services.php')) {
                include 'pages/services.php';
            } else {
                include 'pages/404.html';
            }
            # code...
            break;
        case 'vision':
            if (file_exists('pages/vision.php')) {
                include 'pages/vision.php';
            } else {
                include 'pages/404.html';
            }
            # code...
            break;
        case 'validar':
            if (file_exists('pages/validar.php')) {
                include 'pages/validar.php';
            } else {
                include 'pages/404.html';
            }
            # code...
            break;
         case 'publish-property':
            if (file_exists('pages/publish-property.php')) {
                include 'pages/publish-property.php';
            } else {
                include 'pages/404.html';
            }
            # code...
            break;
        case 'publications':
            if (file_exists('pages/my-publications.php')) {
                include 'pages/my-publications.php';
            } else {
                include 'pages/404.html';
            }
            # code...
            break;
        case 'mycertified':
            if (file_exists('pages/mycertified.php')) {
                include 'pages/mycertified.php';
            } else {
                include 'pages/404.html';
            }
            # code...
            break;
        case 'changePassword':
            if (file_exists('pages/changePassword.php')) {
                include 'pages/changePassword.php';
            } else {
                include 'pages/404.html';
            }
            # code...
            break;
        case 'terms-services':
            if (file_exists('pages/terms-services.php')) {
                include 'pages/terms-services.php';
            } else {
                include 'pages/404.html';
            }
            # code...
            break;
        case 'politics':
            if (file_exists('pages/politics.php')) {
                include 'pages/politics.php';
            } else {
                include 'pages/404.html';
            }
            # code...
            break;
        default:
            if (file_exists('pages/home.php')) {
                include 'pages/home.php';
            } else {
                include 'pages/404.html';
            }
            break;
        }
    ?>
    <!--- NAVEGACION -->
    <!-- FOOTER
    ================================================== -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-4">
            <div class="footer__col">
              <h3 class="footer__header">Bilder.cl</h3>
              <p>
               Siguenos en las redes sociales.
              </p>
              <ul class="footer__social">
                <li>
                  <a href="#"><i class="fa fa-facebook"></i></a>
                </li>
                <li>
                  <a href="#"><i class="fa fa-twitter"></i></a>
                </li>
                <li>
                  <a href="#"><i class="fa fa-google-plus"></i></a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-xs-6 col-sm-2">
            <div class="footer__col">
              <h3 class="footer__header">
              Legal
              </h3>
              <ul class="footer__content">
                <li><a href="index.php?s=terms-services">Terminos de servicio</a></li>
                <li><a href="index.php?s=politics">Politicas de privacidad</a></li>
              </ul>
            </div>
          </div>
          <div class="col-xs-6 col-sm-2">
            <div class="footer__col">
              <h3 class="footer__header">
                Mapa del sitio
              </h3>
              <ul class="footer__content">
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Servicios</a></li>
                <li><a href="#">Visión</a></li>
                <li><a href="#">Politicas</a></li>
                <li><a href="#">Preguntas frecuentes</a></li>
                <li><a href="#">Contacto</a></li>
              </ul>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="footer__col">
              <h3 class="footer__header">Suscribite</h3>
              <p>
                Ingrese su e-mail a continuación para suscribirse a nuestro boletín gratuito.
              </p>
              <p>
              </p>
              <form class="form-inline footer__form">
                <div class="form-group">
                  <label class="sr-only">Ingresa tu email</label>
                  <input type="email" class="form-control" placeholder="Ingrese su email">
                </div>
                <button type="submit" class="btn btn-primary">
                  OK
                </button>
              </form>
            </div>
          </div>
        </div> <!-- / .row -->
        <hr class="footer__hr" />
        <div class="row">
          <div class="col-sm-6">
            <p>
              Bilder.cl 2017. Todos los derechos reservados.
            </p>
          </div>
        </div> <!-- / .row -->
      </div> <!-- / .container -->
    </footer>
    <!-- JavaScript
    ================================================== -->
      <!-- JS Plugins -->
    <script type="text/javascript" src="scripts/validaRut.js"></script>
    <script type="text/javascript">
        $(function() {
          $("#rut").rut({formatOn: 'keyup', 
          validateOn: 'keyup'
          }).on('rutInvalido', 
          function(){
              $(".form-rut").addClass("has-danger")
              $(".input-rut").addClass("form-control-danger")  
          }).on('rutValido', 
          function(){ 
              $(".form-rut").removeClass("has-danger")
              $(".form-rut").addClass("has-success")
              $(".input-rut").removeClass("form-control-danger")
              $(".input-rut").addClass("form-control-success")
              rut.setCustomValidity('')
          });
        });
              $('#nom').on('input', function() {
                  var value = $(this).val();
                  if(value.length >= 5){
                      $(".form-nom").removeClass("has-danger")
                      $(".form-nom").addClass("has-success")
                      $(".input-nom").removeClass("form-control-danger")
                      $(".input-nom").addClass("form-control-success")
                      nom.setCustomValidity('')
                  }
                  if(value.length >= 0 && value.length < 5){
                      nom.setCustomValidity("El Nombre debe tener mas de 5 caracteres");
                      $(".form-nom").addClass("has-danger")
                      $(".input-nom").addClass("form-control-danger")    
                  }
          });
      </script>
    <script type="text/javascript" src="scripts/register.js"></script>
    <script type="text/javascript" src="scripts/login.js"></script>
    <!-- JS Custom -->
    <script src="assets/js/custom.js"></script>
    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.es.js"></script>
    <script type="text/javascript">
     $('#fecha_ocupacion').datetimepicker({
          format: 'YYYY-MM-DD'       
      });   
     $('#fecha_desalojo').datetimepicker({
          format: 'YYYY-MM-DD'       
      });    
   </script>
    <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-91330851-1', 'auto');
    ga('send', 'pageview');
  </script>
  </body>
</html>
<?php
ob_end_flush();
?>