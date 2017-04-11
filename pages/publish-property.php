<?php
if (@!$_SESSION['email']) {
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
              <li class="active">Publica tu propiedad</li>
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
              <?php include 'includes/PhotoProfile.php';?>
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
            <span>Publica tu propiedad</span>
            </h1>
            <div class="row">
            <?php 
            if(isset($_POST['Publicar']) == 'Publicar') {
            // POST FORMLULARIO
             $nombre = $_POST['nombre'];
             $titulo = $_POST['titulo'];
             $superficie = $_POST['superficie'];
             $tipo_inmueble = $_POST['tipo_inmueble'];
             $region = $_POST['region'];
             $comuna = $_POST['comuna'];
             $dormitorios = $_POST['dormitorios'];
             $banos = $_POST['banos'];
             $estacionamiento = $_POST['estacionamiento'];
             $precio = $_POST['precio'];
             $descripcion = $_POST['descripcion'];
             $telefono = $_POST['telefono'];
             $estado = 1;
             $visitas = 0;
             $ancho_nuevo =800;
             $alto_nuevo =600;
             $tot = count($_FILES["img"]["name"]);
             $hoy = date("Y-m-d H:i:s");
             $allowed = array('gif','png','jpg','jpeg','JPEG','JPG','PNG','GIF');
              // END POST FORMULARIO
              for ($i=0; $i < $tot; $i++) { 
               $filename  = $_FILES['img']['name'][$i];
               $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if(in_array($ext,$allowed) ) {
                    if (is_uploaded_file($_FILES['img']['tmp_name'][$i])) {
                    $tmp_name = $_FILES["img"]["tmp_name"][$i];
                    $name         = $_FILES["img"]["name"][$i];
                    $ext          = end(explode(".", $_FILES["img"]["name"][$i]));
                    $nombre_final = generarCodigo(12);
                    // ANCHO DEL PREVIEW DE LA IMAGEN
                    $ancho_nuevo_small = 150;
                    $largo_nuevo_small = 150;
                    redim ($tmp_name,"img/clasificados/".$nombre_final.".".$ext,$ancho_nuevo,$alto_nuevo);
                    redim ($tmp_name,"img/clasificados/thumbs/".$nombre_final.".".$ext,$ancho_nuevo_small,$largo_nuevo_small);
                    $img[] = $nombre_final.'.'.$ext;
                    }
                 }
              }

              $total = count($img);

              for ($e=0; $e < $total; $e++) { 
                 if(file_exists('img/clasificados/'.$img[$e])) {
                    $status = true;
                 }
                 else {                  
                    $status = false;
                 }
              }

              $codigo = generarCodigo(10);

              if($status) {
                $pdo = new Conexion();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->exec("SET CHARACTER SET utf8");
                $stm2 = $pdo->prepare("INSERT INTO c_publisheds (nombre,titulo,account_id,fecha_publicacion,region,comuna,precio,descripcion,tipo_inmueble,superficie,dormitorios,banos,estacionamiento,telefono,codigo,status,visitas,img1,img2,img3,img4) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                if($stm2->execute(array($nombre,$titulo,$_SESSION['id'],$hoy,$region,$comuna,$precio,$descripcion,$tipo_inmueble,$superficie,$dormitorios,$banos,$estacionamiento,$telefono,$codigo,$estado,$visitas,$img[0],$img[1],$img[2],$img[3]))) {
                  
                 echo '<div class="alert alert-dismissible alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Exito!</strong> Su publicación ha sido enviada, se revisara que cumpla las reglas de bilder y sera subida en los proximos minutos.</a>.
                      </div>';
                }

              }
              else {
                echo '<div class="alert alert-dismissible alert-danger">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>Ocurrio un error!</strong> Por favor contacta con un administrador, o intenta nuevamente.
                    </div>';

              }

            }
            ?>
            <form action="index.php?s=publish-property" id="publishPr"  method="POST" enctype="multipart/form-data">
              <div class="col-md-3" style="padding:2px;">
              <input type="text" name="nombre" id="nombre" placeholder="Tu nombre" class="form-control">
              </div>
              <div class="col-md-3" style="padding:2px;">
              <input type="text" name="titulo" id="titutlo" placeholder="Titulo de la publicación" class="form-control">
              </div>
              <div class="col-md-3" style="padding:2px;">
              <input type="text" name="superficie" id="superficie" placeholder="Superficie" class="form-control">
              </div>
              <div class="col-md-3" style="padding:2px;">
              <select name="tipo_inmueble" id="tipo_inmueble" class="form-control">
                      <option value="">Seleccione Tipo</option>
                      <option value="0">Departamento</option>
                      <option value="1">Casa</option>
                      <option value="2">Oficina</option>
                      <option value="3">Comercial e industrial</option>
                      <option value="4">Terreno</option>
                      <option value="5">Estacionamiento, bodega u otro</option>
                      <option value="6">Pieza</option>
                    </select>
              </div>
              <div class="col-md-3" style="padding:2px;">
              <select id="regiones" name="region"   class="form-control" id="region"></select>
              </div>
              <div class="col-md-3" style="padding:2px;">
                <select  id="comunas" name="comuna" class="form-control" ></select>
              </div>
              <div class="col-md-3" style="padding:2px;">
              <input type="text" name="dormitorios" id="dormitorios" placeholder="Dormitorios" class="form-control">
              </div>
              <div class="col-md-3" style="padding:2px;">
               <input type="text" name="banos" placeholder="Baños" id="banos" class="form-control">
              </div>
              <div class="col-md-3" style="padding:2px;">
               <input type="text" name="estacionamiento" id="estacionamiento" placeholder="Estacionamientos" class="form-control">
              </div>
              <div class="col-md-3" style="padding:2px;">
              <input type="text" name="precio" id="precio" placeholder="Precio" class="form-control">
              </div>
              <div class="col-md-3" style="padding:2px;">
              <input type="text" name="telefono" id="telefono" placeholder="Telefono" class="form-control">
              </div>
               <div class="col-md-6" id="summerCol" style="padding:2px;">
                <textarea name="descripcion"  id="summernote" cols="30" rows="10"></textarea>
              </div>
              <div class="col-md-6" style="padding:2px;">
               <input type="file" name="img[]" placeholder="Imagen 4" style="width:100%; padding:5px;">
               <input type="file" name="img[]" placeholder="Imagen 4" style="width:100%; padding:5px;">
               <input type="file" name="img[]" placeholder="Imagen 4" style="width:100%; padding:5px;">
               <input type="file" name="img[]" placeholder="Imagen 4" style="width:100%; padding:5px;">
               </div>              
              <div class="col-md-12" style="padding:2px;">
              <input type="submit" class="btn btn-success btn-lg" name="Publicar" value="Publicar">
              </div>              
          </div>
          </form>
      </div> <!-- / .row -->
    </div> <!-- / .container -->
    <script type="text/javascript">
    $.validator.setDefaults( {
      submitHandler: function () {
        $('#publishPr').ajaxSubmit();
      }
    } );

    $( document ).ready( function () {
      $( "#publishPr" ).validate( {
        rules: {
          nombre: "required",
          titulo: "required",
          superficie: "required",
          dormitorios: "required",
          banos: "required",
          estacionamiento: "required",
          precio: "required",
          telefono: "required",
          nombre: {
            required: true,
            minlength: 4
          },
          titulo: {
            required: true,
            minlength: 7
          },
          superficie: {
            required: true,
            minlength: 1
          },
          dormitorios: {
            required: true,
            minlength: 1
          },
          banos: {
            required: true,
            minlength: 1
          },
          estacionamiento: {
            required: true,
            minlength: 1
          },
          precio: {
            required: true,
            minlength: 1
          },
          telefono: {
            required: true,
            minlength: 1
          },

          agree: "required"
        },
        messages: {
          firstname: "Please enter your firstname",
          titulo: "Debe ingresar un titulo",
          firstname: {
            required: "Please enter a username",
            minlength: "Your username must consist of at least 2 characters"
          },
          email: "Please enter a valid email address",
          agree: "Please accept our policy"
        },
        errorElement: "em",
        errorPlacement: function ( error, element ) {
          // Add the `help-block` class to the error element
          error.addClass( "help-block" );
        },
        highlight: function ( element, errorClass, validClass ) {
          $( element ).parents( ".col-md-3" ).addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
          $( element ).parents( ".col-md-3" ).addClass( "has-success" ).removeClass( "has-error" );
        }
      } );

      
    } );
  </script>
 <script type="text/javascript">
          $(document).ready(function() {
          $('#summernote').summernote({
                  height: 200,                 // set editor height
                  minHeight: null,             // set minimum height of editor
                  maxHeight: null,             // set maximum height of editor
                  focus: true                 // set focus to editable area after initializing summernote
              });
        });
 </script>
