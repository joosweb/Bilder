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
              <li class="active">Mis anuncios</li>
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
              <span>Mis Anuncios </span> 
            </h1>
            <?php
            if(isset($_POST['Actualizar']) == 'Actualizar') {

               $token = $_POST['id_publicacion'];
               $p_e_c = Encrypter::decrypt($token);
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
               $ancho_nuevo      =640;
               $alto_nuevo       =480;
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

              $codigo = generarCodigo(10);

                $pdo = new Conexion();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->exec("SET CHARACTER SET utf8");
                 if($status == '') {

                  if($total <= 0) {
                      $query = 'UPDATE c_publisheds set nombre=? , titulo=?, region=?, comuna=?, precio=?, descripcion=?, tipo_inmueble=?, superficie=?, dormitorios=?, banos=?, estacionamiento=?, telefono=? WHERE id=?';
                       $stm = $pdo->prepare($query);
                      $stm->execute(array($nombre,$titulo,$region,$comuna,$precio,$descripcion,$tipo_inmueble,$superficie,$dormitorios,$banos,$estacionamiento,$telefono,$p_e_c));

                      echo '<div class="alert alert-dismissible alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Exito!</strong> Su publicación ha sido editada satisfactoriamente.</a>.
                      </div>';
                  }

                  else {
                    $query = 'UPDATE c_publisheds set nombre=? , titulo=?, region=?, comuna=?, precio=?, descripcion=?, tipo_inmueble=?, superficie=?, dormitorios=?, banos=?, estacionamiento=?, telefono=?, img1=?, img2=?, img3=?, img4=? WHERE id=?';
                     $stm = $pdo->prepare($query);
                    $stm->execute(array($nombre,$titulo,$region,$comuna,$precio,$descripcion,$tipo_inmueble,$superficie,$dormitorios,$banos,$estacionamiento,$telefono,$img[0],$img[1],$img[2],$img[3],$p_e_c));

                    echo '<div class="alert alert-dismissible alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Exito!</strong> Su publicación ha sido editada satisfactoriamente.</a>.
                      </div>';
                    }
                  }
                }

              else {

            	if($_GET['a'] == 'edit') {

            		  $pdo = new Conexion();
                  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  $pdo->exec("SET CHARACTER SET utf8");
                  $stm = $pdo->prepare("SELECT * FROM c_publisheds WHERE id = ?");
                  $p_e_c = Encrypter::decrypt($_GET['token']);
                  $stm->execute(array($p_e_c));
                  $row = $stm->fetch(PDO::FETCH_OBJ);

              ?>
              <script>
              $(document).ready(function(){
                 $("#tipo_inmueble option[value='<?php echo $row->tipo_inmueble; ?>']").attr("selected",true);
                  $("#regiones option[value='<?php echo $row->region; ?>']").attr("selected",true).change();
                  $("#comunas option[value='<?php echo $row->comuna; ?>']").attr("selected",true).change();
              });               
              </script>
              <div class="row" style="padding:10px;">
              <form action="index.php?s=publications" id="publishEd"  method="POST" enctype="multipart/form-data">
              <div class="col-md-3" style="padding:2px;">
              <input type="hidden" name="id_publicacion" value="<?php echo $_GET['token']; ?>">
              <input type="text" value="<?php echo $row->nombre; ?>" name="nombre" id="nombre" placeholder="Tu nombre" class="form-control">
              </div>
              <div class="col-md-3" style="padding:2px;">
              <input type="text" value="<?php echo $row->titulo; ?>" name="titulo" id="titutlo" placeholder="Titulo de la publicación" class="form-control">
              </div>
              <div class="col-md-3" style="padding:2px;">
              <input type="text" value="<?php echo $row->superficie; ?>" name="superficie" id="superficie" placeholder="Superficie" class="form-control">
              </div>
              <div class="col-md-3" style="padding:2px;">
              <select name="tipo_inmueble" id="tipo_inmueble" class="form-control btn-primary">
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
              <select id="regiones" name="region"   class="form-control btn-primary" id="region"></select>
              </div>
              <div class="col-md-3" style="padding:2px;">
                <select  id="comunas" name="comuna" class="form-control btn-primary" ></select>
              </div>
              <div class="col-md-3" style="padding:2px;">
              <input type="text" value="<?php echo $row->dormitorios; ?>" name="dormitorios" id="dormitorios" placeholder="Dormitorios" class="form-control">
              </div>
              <div class="col-md-3" style="padding:2px;">
               <input type="text" value="<?php echo $row->banos; ?>" name="banos" placeholder="Baños" id="banos" class="form-control">
              </div>
              <div class="col-md-3" style="padding:2px;">
               <input type="text" value="<?php echo $row->estacionamiento; ?>" name="estacionamiento" id="estacionamiento" placeholder="Estacionamientos" class="form-control">
              </div>
              <div class="col-md-3" style="padding:2px;">
              <input type="text" value="<?php echo $row->precio; ?>" name="precio" id="precio" placeholder="Precio" class="form-control">
              </div>
              <div class="col-md-3" style="padding:2px;">
              <input type="text" value="<?php echo $row->telefono; ?>" name="telefono" id="telefono" placeholder="Telefono" class="form-control">
              </div>
               <div class="col-md-6" id="summerCol" style="padding:2px;">
                <textarea name="descripcion"  id="summernote" cols="30" rows="10"><?php echo $row->descripcion; ?></textarea>
                </div>
              <div class="col-md-6" style="padding:2px;">
               <input type="file" name="img[]" placeholder="Imagen 4" style="width:100%; padding:5px;">
               <input type="file" name="img[]" placeholder="Imagen 4" style="width:100%; padding:5px;">
               <input type="file" name="img[]" placeholder="Imagen 4" style="width:100%; padding:5px;">
               <input type="file" name="img[]" placeholder="Imagen 4" style="width:100%; padding:5px;">
               </div>
              
              <div class="col-md-12" style="padding:2px;">
              <input type="submit" class="btn btn-success btn-lg" name="Actualizar" value="Actualizar">
              </div>
              
          </div>
          </form>

              <?php
              }
            	else if($_GET['a'] == 'delete') {

            		$token = $_GET['token'];

            		if(BorrarPublicacion($token)) {
            			echo '<div class="alert alert-dismissible alert-success">
							  <button type="button" class="close" data-dismiss="alert">&times;</button>
							  <strong>Eliminado!</strong> Su publicación ha sido eliminada satisfactoriamente</a>.
							</div>';
            		}
            		else {
            			echo '<div class="alert alert-dismissible alert-danger">
							  <button type="button" class="close" data-dismiss="alert">&times;</button>
							  <strong>Error!</strong> Por favor contacte con un administrador, o intente nuevamente</a>.
							</div>';
            		}
            	}
              else {
            ?>
           <div class="table-responsive">       
         	 <?php include('includes/my-publications.php'); ?>         	
          	</div>
          <?php } }?>
           </div> <!-- / .profile__body -->
        </div>
      </div> <!-- / .row -->
    </div> <!-- / .container -->
    <script type="text/javascript">
          $(document).ready(function() {
          $('#summernote').summernote({
                  height: 300,                 // set editor height
                  minHeight: null,             // set minimum height of editor
                  maxHeight: null,             // set maximum height of editor
                  focus: false                 // set focus to editable area after initializing summernote
              });
        });
 </script>
