<?php
if(@$_SESSION['email']) {
header('Location: index.php?s=profile');
}
?>
 <!-- CONTENT
    ================================================== -->
    <div class="container">
      <div class="row">
        <div class="col-sm-12 col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3">
          <!-- Sign In form -->
          <div class="profile__sign-in">
            <h1 class="block-header alt">
              <span>Inicie sesión en su cuenta</span>
            </h1>
            <div id="msg"></div>
            <form method="POST" action="" id="login-form">
              <div class="form-group">
                <label class="sr-only">Email</label>
                <input type="email" id="email" class="form-control input-lg" placeholder="E-mail" required>
              </div>
              <div class="form-group">
                <label class="sr-only">Contraseña</label>
                <input type="password" id="password" class="form-control input-lg" placeholder="contraseña" required>
              </div>
             <br />
              <button type="submit" id="Entrar" class="btn btn-lg btn-primary">
                Entrar
              </button>
              <hr>
              <?php echo '<a class="btn btn-block btn-social btn-facebook"  href="' . htmlspecialchars($loginUrl) . '"><i class="fa fa-facebook-official" aria-hidden="true"></i> Entrar con Facebook!</a>'; ?>
              <?php echo '<a class="btn btn-block btn-social btn-google"  href="' . $authUrl . '"><i class="fa fa-google" aria-hidden="true"></i> Entrar con Google!</a>'; ?>
            </form>
            <hr>
            <p>
              No estas registrado? <a href="index.php?s=sign-up">Crea una cuenta</a>.
            </p>
            <p>
              Perdiste tu contraseña? <a href="#lost-password__form" data-toggle="collapse" aria-expanded="false" aria-controls="lost-password__form" class="collapsed">
                Recuperala Aqui
              </a>.
            </p>
            <div class="collapse" id="lost-password__form">
              <p class="text-muted">
                Ingrese su dirección de correo electrónico a continuación y le enviaremos un enlace para restablecer su contraseña.
              </p>
              <!-- Lost password -->
              <form class="form-inline">
                <div class="form-group">
                  <label class="sr-only" for="lost-password__email">Email</label>
                  <input type="email" class="form-control" id="lost-password__email" placeholder="Enter email">
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
              </form>
            </div> <!-- / #lost-password__form -->
          </div> <!-- / .profile_sign-in -->
        </div>
      </div> <!-- / .row -->
    </div> <!-- / .container -->