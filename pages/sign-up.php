 <?php
if(@$_SESSION['email']) {
header('Location: index.php?s=profile');
}
?>
 <!-- Header -->
    <div class="page-topbar">
      <div class="container">
        <div class="row">
          <div class="col-sm-4">

            <h3>Registrarse</h3>
            
          </div>
          <div class="col-sm-8 hidden-xs">
            
            <ol class="breadcrumb">
              <li><a href="index.php?s=home">Inicio</a></li>
              <li class="active">Registrarse</li>
            </ol>

          </div>
        </div> <!-- / .row -->
      </div> <!-- / .container -->
    </div>
    <!-- CONTENT
    ================================================== -->
    <div class="container">
      <div class="row">
        <div class="col-sm-12 col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3">

          <!-- Sign In form -->
          <div class="profile__sign-in">
            <h1 class="block-header alt">
              <span>Crea una cuenta nueva</span>
            </h1>
            <div id="msg-error-register"></div>
            <form action="" name="register-form" id="register-form"  method="POST">
              <div class="form-group">
                <label class="sr-only">Nombres</label>
                <input type="text" id="nombres" class="form-control input-lg" placeholder="Nombres" required>
              </div>
              <div class="form-group">
                <label class="sr-only">Apellidos</label>
                <input type="text" id="apellidos" class="form-control input-lg" placeholder="Apellidos" required>
              </div>
              <div class="form-group">
                <label class="sr-only">E-mail</label>
                <input type="email" id="email" class="form-control input-lg" placeholder="E-mail" required>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="sr-only">Contraseña</label>
                    <input type="password" id="password" class="form-control input-lg" placeholder="Contraseña" required>
                  </div>
                </div>
                 </div>
                <!-- reCAPTCHA -->
                  <div class="form-group" id="form-captcha">
                    <div class="g-recaptcha" data-sitekey="6LeGURQUAAAAAIDv9Y9LkAMfcSM5ShBjhF6WTrim"></div>
                    <span class="help-block"></span>
                  </div>
                  <!-- /reCAPTCHA --> 
                  <div class="checkbox">
                <input type="checkbox" id="profile-sign-in__remember">
                <label for="profile-sign-in__remember">
                 Estoy de acuerdo con los <a href="index.php?s=terms-services">Term. del servicio</a> y las<a href="index.php?s=politics"> Politicas de privacidad</a>
                </label>
              </div><br />
              <button type="submit" id="register-button" class="btn btn-lg btn-primary">
               Registrarme
              </button>
               <hr>
              <?php echo '<a class="btn btn-block btn-social btn-facebook"  href="' . htmlspecialchars($loginUrl) . '"><i class="fa fa-facebook-official" aria-hidden="true"></i> Registrarme con Facebook!</a>'; ?>
               <?php echo '<a class="btn btn-block btn-social btn-google"  href="' . $authUrl . '"><i class="fa fa-google" aria-hidden="true"></i> Registrarme con Google!</a>'; ?>
            </form>
            <hr>

            <p>
             Ya estas registrado? <a href="index.php?s=sign-in">Inicia sesión en tu cuenta.</a>.
            </p>

          </div> <!-- / .profile_sign-in -->
          
        </div>
      </div> <!-- / .row -->
    </div> <!-- / .container -->
