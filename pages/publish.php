<?php
if (@!$_SESSION['email']) {
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
              <li class="active">Publicar Deudor</li>
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
          <div class="profile__body">
            <!-- Messages -->
            <h1 class="block-header alt">
              <span>Publica un deudor</span>
            </h1>
              <?php include 'includes/public.php';?>
            <div class="">
            <form  action="index.php?s=publish" name="form2" id="form2" enctype="multipart/form-data" method="POST">
              <div class="table-responsive">
              <table width="100%"  class="table ">
              <tbody>
                <tr>
                  <th colspan="4" class="active"><strong>Datos del deudor</strong></th>
                </tr>
                <tr>
                  <td>Dirección de propiedad:</td>
                  <td><input type="text" name="direccion_propiedad" value="<?php echo $_POST['direccion_propiedad']; ?>" class="form-control input-sm" required></td>
                  <td>Seleccione Region:</td>
                  <td> <select id="regiones" name="region" class="form-control" id="region" required></select></td>
                </tr>
                <tr>
                 <td>Seleccione comuna:</td>
                  <td><select id="comunas" name="ciudad" class="form-control" required></select></td>
                  <td>Motivo:</td>
                  <td>
                  <select name="motivo" id="motivo" class="form-control" required>
                  <option value="">Seleccione..</option>
                    <option value="Denuncia" selected="selected">Denuncia</option>
                  </select>
                  </td>
                </tr>
                <tr>
                   <td>Rut:</td>
                  <td><input type="text" id="rut" value="<?php echo $_POST['rut']; ?>" name="rut" class="input-rut form-control input-xs" required></td>
                  <td>Nombres:</td>
                  <td> <input type="text" id="nombres" value="<?php echo $_POST['nombres']; ?>" name="nombres" class="form-control input-xs"  required></td>
                </tr>
                <tr>
                   <td>Apellidos:</td>
                  <td><input type="text" id="apellidos" value="<?php echo $_POST['apellidos']; ?>" name="apellidos" class="form-control input-xs"  required></td>
                  <td>Fecha ocupacion de propiedad:</td>
                  <td><input class="form-control" placeholder="<?php echo $_POST['fecha_ocupacion']; ?>" id="fecha_ocupacion" name="fecha_ocupacion" type="text"/></td>
                </tr>
                <tr>
                   <td>Fecha de desalojo de propiedad :</td>
                  <td><input class="form-control" id="fecha_desalojo" placeholder="<?php echo $_POST['fecha_desalojo']; ?>" name="fecha_desalojo" type="text"/></td>
                  <td>Contaba con aval:</td>
                  <td>
                      <select name="aval" id="aval" class="form-control" required>
                      <option value="">Seleccione..</option>
                       <option value="Si">Si</option>
                      <option value="No">No</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>Nombre Aval:</td>
                  <td>
                     <input type="text" name="nombre_aval" value="<?php echo $_POST['nombre_aval']; ?>" class="form-control input-xs">
                  </td>
                  <td>Tiene cursada una denuncia:</td>
                  <td>
                     <select name="denuncia" id="denuncia" class="form-control" required>
                      <option value="">Seleccione..</option>
                      <option value="Si">Si</option>
                      <option value="No">No</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td colspan="4" class="active"><strong>Montos Deudas ( no obligatorios)</strong></td>
                </tr>
                <tr>
                   <td>Deuda de gastos comunes(Aprox):</td>
                  <td><input type="text" name="gastos_comunes" value="<?php echo $_POST['gastos_comunes']; ?>" class="form-control input-xs"></td>
                  <td>Numero de causa (Demanda civil):</td>
                  <td><input type="text" name="numero_causa" value="<?php echo $_POST['numero_causa']; ?>" class="form-control input-xs"></td>
                </tr>
                <tr>                 
                  <td>Daño a la propiedad:</td>
                  <td>
                    <select name="dano_propiedad" id="dano_propiedad" class="form-control" required>
                      <option value="">Seleccione..</option>
                      <option value="Si">Si</option>
                      <option value="No">No</option>
                    </select>
                  </td>
                  <td>Codigo Captcha: <img src="includes/captcha.php" width="73"/></td>
                  <td><input type="text" id="captcha" name="captcha" class="form-control input-xs" required  placeholder=""></td>
                </tr>
                <tr>
                  <td>Comentario Adicional (Opcional)</td>
                  <td colspan="3"><textarea name="comentario" placeholder="<?php echo $_POST['comentario']; ?>" id="" cols="30" rows="10" style="width: 669px; height: 185px;"></textarea></td>
                </tr>
                <tr>
                <td colspan="4" class="active"><strong>Subir archivos (Demandas,facturas,etc)</strong></td>
              </tr>
               <tr>
                <td colspan="4">
                <div id="adjuntos">                   
                 <input type="file" name="archivos[]" /><br />
                 </div>
                 <button type="button" class="btn btn-warning btn-xs" onClick="addCampo()">Subir otro archivo</button>
                 </td>
              </tr>
              <tr>
                <td colspan="2">
                  <button type="submit" style="width:100%;" name="Publicar" id="register-button" class="btn btn-lg btn-success">
               Publicar
              </button>
                </td>
              </tr>
              </tbody>
            </table>
            </div>
            </form>
            </div>
            </div>
              <!-- <form action="index.php?s=publish" name="form1" id="form1" enctype="multipart/form-data" method="POST">
              <div class="form-rut form-group">
                <label class="sr-only">RUN</label>
                <input type="text" id="rut" name="rut" class="input-rut form-control input-lg" placeholder="RUN | RUT" required>
              </div>
              <div class="form-group">
                <label class="sr-only">NOMBRES</label>
                <input type="text" id="nombres" name="nombres" class="form-control input-lg" placeholder="NOMBRES" required>
              </div>
              <div class="form-group">
                <label class="sr-only">APELLIDOS</label>
                <input type="text" id="apellidos" name="apellidos" class="form-control input-lg" placeholder="APELLIDOS" required>
              </div>
              <div class="form-group">
                <label class="sr-only">DEUDA TOTAL</label>
                <input type="number" id="deudatotal" name="deudatotal" class="form-control input-lg" placeholder="DEUDA TOTAL APROXIMADA" required>
              </div>
              <div class="form-group">
                   <select id="regiones" name="region" class="form-control" id="region"></select>
              </div>
              <div class="form-group">
                   <select id="comunas" name="ciudad" class="form-control" ></select>
              </div>
              <div class="form-group">
                   <img src="includes/captcha.php" width="73"/>
                   <input type="text" id="captcha" name="captcha" class="" required  placeholder="">
                </div>
              <div class="form-group">
                <dl>
                 <dt><label>Subir documentos:</label></dt>
                     
                 <dd><div id="adjuntos">
                   
                 <input type="file" name="archivos[]" /><br />
                 </div></dd>
                 <dt><button type="button" class="btn btn-warning" onClick="addCampo()">Subir otro archivo</button></dt>
                   </dl>
              </div>
              <button type="submit" name="Publicar" id="register-button" class="btn btn-lg btn-primary">
               Publicar
              </button>
            </form> <!- -->
          </div> <!-- / .profile__body -->
        </div>
      </div> <!-- / .row -->
    </div> <!-- / .container -->


