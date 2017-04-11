<!-- CONTENT
    ================================================== -->
    <div class="container">
      <div class="row">
        <div class="col-sm-9">
          <h1 class="block-header alt">
            <span>Póngase en contacto con nosotros!</span>
          </h1>
          <p class="text-muted">
           Si tienes dudas, inquietudes, preguntas o simplemente quieres dejarnos tus comentarios o aportes, completa este formulario y te responderemos a la brevedad del caso; recuerda que tus observaciones son sumamente importantes para nosotros.
          </p> <br />
          <!-- Alert message -->
          <div class="alert" id="form_message" role="alert"></div>
          <!-- Please carefully read the README.txt file in order to setup
               the PHP contact form properly -->
         <form role="form" class="contact__form" id="form_sendemail">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="sr-only" for="email">Email address</label>
                  <input type="email" name="email" class="input-lg form-control" id="email" placeholder="E-mail" data-original-title="" title="">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="sr-only" for="name">Name</label>
                  <input type="text" name="name" class="input-lg form-control" id="name" placeholder="Nombre" data-original-title="" title="">
                  <span class="help-block"></span>
                </div>   
              </div>
            </div>
            <div class="form-group">
              <label class="sr-only" for="message">Message</label>
              <textarea name="message" class="input-lg form-control" rows="5" id="message" placeholder="Mensaje"></textarea>
              <span class="help-block"></span>
            </div>
            <!-- reCAPTCHA -->
            <div class="form-group" id="form-captcha">
              <div class="g-recaptcha" data-sitekey="6LeGURQUAAAAAIDv9Y9LkAMfcSM5ShBjhF6WTrim"></div>
              <span class="help-block"></span>
            </div>
            <!-- /reCAPTCHA -->
            <button type="submit" class="btn btn-lg btn-primary">Enviar Mensaje</button>
          </form>
        </div>
        <div class="col-sm-3">
          <h1 class="block-header alt">
            <span>Mantengase actualizado</span>
          </h1>
          <ul class="social-icons">
            <li class="facebook">
              <a href="#"><i class="fa fa-facebook"></i></a>
            </li>
            <li class="twitter">
              <a href="#"><i class="fa fa-twitter"></i></a>
            </li>
            <li class="google-plus">
              <a href="#"><i class="fa fa-google-plus"></i></a>
            </li>
            <li class="linkedin">
              <a href="#"><i class="fa fa-linkedin"></i></a>
            </li>
            <li class="rss">
              <a href="#"><i class="fa fa-rss"></i></a>
            </li>
          </ul>
          <h1 class="block-header alt">
            <span>Información de contacto</span>
          </h1>
          <p class="text-muted">
            E-mail: info@bilder.cl <br />
            Website: <a href="#">https://www.bilder.cl/</a>
          </p>
        </div>
      </div> <!-- / .row -->
    </div> <!-- / .container -->