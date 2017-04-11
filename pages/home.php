<script type="text/javascript">
  function toogle() {
    $('.showcase').toggle('slow');
  }
</script>
<?php include('includes/modals.php'); ?>
    <!-- Showcase -->
    <div class="showcase">
      <div id="showcase-carousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#showcase-carousel" data-slide-to="0" class="active"></li>
          <li data-target="#showcase-carousel" data-slide-to="1"></li>
          <li data-target="#showcase-carousel" data-slide-to="2"></li>
          <li data-target="#showcase-carousel" data-slide-to="3"></li>
        </ol>
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
          <!-- Item 1 -->
          <div class="item item_1 active">
            <div class="container">
              <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                  <div class="table_centered">
                    <div class="table_centered__cell">
                      <!-- Add animation classes to the active slide only -->
                      <h1 class="animateDown" data-animation="animateDown">
                        Planeas arrendar tu propiedad?
                      </h1>
                      <p class="lead delay_1 animateUp" data-animation="animateUp">
                       Obten aqui un informe de tu arrendatario por solo <br> $ 990 pesos.
                      </p>
                      <a href="index.php?s=certified" class="btn btn-lg btn-primary delay_2 animateUp" data-animation="animateUp">
                        Solicitar informe!
                      </a> <br><br>
                      <div class="fb-like" data-href="https://www.facebook.com/ArriendosBilder/?fref=ts" data-layout="button" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>                     
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Item 2 -->
          <div class="item item_2">
            <div class="container">
              <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                  <div class="table_centered">
                    <div class="table_centered__cell">
                      <h2 class="animateDown" data-animation="animateDown">
                       Tu seguridad esta primero.
                      </h2>
                      <p class="lead delay_1" data-animation="animateUp">
                       Encriptación de hasta 256 con los niveles de seguridad más altos posibles para nuestros clientes.
                      </p>                     
                      <a style="margin-top:-5px;" href="#" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#certificados" class="btn btn-lg btn-glass delay_2" data-animation="animateUp" >
                        Ver más
                      </a>
                      <br><br>
                      <div class="fb-like" data-href="https://www.facebook.com/ArriendosBilder/?fref=ts" data-layout="button" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Item 4 -->
          <div class="item item_3">
            <div class="container">
              <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                  <div class="table_centered">
                    <div class="table_centered__cell">
                      
                      <h2 data-animation="animateDown">
                       Notificanos sobre un deudor en 2 simples pasos.
                      </h2>
                      <p class="lead delay_1" data-animation="animateUp">
                        Ingresa a tu panel de usuario y sube los datos necesarios.
                      </p>
                      <a href="index.php?s=publish" class="btn btn-lg btn-primary delay_2" data-animation="animateUp">
                         Notificar un deudor!
                      </a>
                      <br><br>
                      <div class="fb-like" data-href="https://www.facebook.com/ArriendosBilder/?fref=ts" data-layout="button" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
           <!-- Item 3 -->
          <div class="item item_4">
            <div class="container">
              <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                  <div class="table_centered">
                    <div class="table_centered__cell">
                      
                      <h2 data-animation="animateDown">
                       Arrienda con nosotros.
                      </h2>
                      <p class="lead delay_1" data-animation="animateUp">
                        Ingresa a tu panel de usuario y publica tu propiedad 100% gratis.
                      </p>
                      <a href="index.php?s=publish-property" class="btn btn-lg btn-primary delay_2" data-animation="animateUp">
                         Publicar mi propiedad!
                      </a>
                      <br><br>
                      <div class="fb-like" data-href="https://www.facebook.com/ArriendosBilder/?fref=ts" data-layout="button" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                   </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> <!-- / .carousel-inner -->
        <!-- Controls -->
        <a class="carousel__control carousel__control_left" href="#showcase-carousel" role="button" data-slide="prev">
          <img src="assets/img/arrow_left.svg" alt="Left">  
        </a>
        <a class="carousel__control carousel__control_right" href="#showcase-carousel" role="button" data-slide="next">
          <img src="assets/img/arrow_right.svg" alt="Right">  
        </a>
        </div> <!-- / .carousel -->
         </div> <!-- / .showcase -->
    <!-- WELCOME MESSAGE 
    ================================================== -->
    <div class="container">
      <div class="row">
        <div class="col-sm-7 col-md-7 col-lg-8">
          <h2 class="block-header">
            <span>Bienvenido a Bilder.cl</span>
          </h2>
          <div class="row">
            <div class="col-xs-12">
              <img src="assets/img/welcome.jpg" class="img-responsive img-article pull-left" alt="Bienvenido">
              <p id="justificado">
               Bilder es una empresa que recopila información sobre deudores de arriendos en chile, esto con la finalidad de poder entregar información decisiva para el arrendador.
              </p>
              <p id="justificado2">
                Bilder pretende mejorar considerablemente el arriendo satisfactorio de sus propiedades con una simple petición que es un certificado de deudas vigentes, es decir obtendras un certificado limpio sin antecedentes o en el segundo caso obtendras informacion sobre anteriores arriendos con deudas de la persona en cuestión.
              </p>
            </div>
          </div> <!-- / .row -->
          <div class="info-board info-board-primary">
            <h4>Información importante</h4>
            <p id="justificado3">
              El certificado tiene una vigencia de 30 dias, dado que estos datos podrian cambiar dentro de ese periodo de tiempo, cabe mencionar que el certificado entregado no puede ser usado mas que para fines de arriendos de propiedades, esto quiere decir que los datos entregados en bilder no pueden ser publicados en otras paginas, blogs, redes sociales, etc. <br><br> 
              Los certificados cuentan con Nº identificador unico el cual puede ser validado en la siguiente direccion <a href="#">Validar Certificado</a> con el fin de acreditar los certificados emitidos en bilder.cl.<br><br>
              Te recomentamos leer las politicas de privacidad <a href="index.php?s=politics">Politicas de privacidad</a>.
              
            </p>
          </div>
        </div>
        <div class="col-sm-5 col-md-5 col-lg-4">
         <div style="margin-top:26px;" class="fb-page" data-href="https://www.facebook.com/Bilder-398636967156660/" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/Bilder-398636967156660/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Bilder-398636967156660/">Bilder</a></blockquote></div>
        </div>
      </div> <!-- / .row -->
    </div> <!-- / .container -->