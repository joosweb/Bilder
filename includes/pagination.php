<?php

error_reporting(0);

    function time2str($ts) {
      if(!ctype_digit($ts)) {
          $ts = strtotime($ts);
      }
      $diff = time() - $ts;
      if($diff == 0) {
          return 'now';
      } elseif($diff > 0) {
          $day_diff = floor($diff / 86400);
          if($day_diff == 0) {
              if($diff < 60) return 'Justo Ahora';
              if($diff < 120) return 'Hace 1 minuto';
              if($diff < 3600) return floor($diff / 60) . ' minutos atras';
              if($diff < 7200) return 'Hace 1 hora';
              if($diff < 86400) return floor($diff / 3600) . ' horas atras';
          }
          if($day_diff == 1) { return 'Ayer'; }
          if($day_diff < 7) { return 'Hace '.$day_diff . ' dias atras'; }
          if($day_diff == 7) { return 'Hace '.$day_diff/7 . ' semana'; }
          if($day_diff < 31) { return 'Hace '.ceil($day_diff / 7) . ' semanas'; }
          if($day_diff < 60) { return 'mes pasado'; }
          return date('F Y', $ts);
      } else {
          $diff = abs($diff);
          $day_diff = floor($diff / 86400);
          if($day_diff == 0) {
              if($diff < 120) { return 'en un minuto'; }
              if($diff < 3600) { return 'en ' . floor($diff / 60) . ' minutos'; }
              if($diff < 7200) { return 'en una hora'; }
              if($diff < 86400) { return 'en ' . floor($diff / 3600) . ' Horas'; }
          }
          if($day_diff == 1) { return 'Mañana'; }
          if($day_diff < 4) { return date('l', $ts); }
          if($day_diff < 7 + (7 - date('w'))) { return 'proxima semana'; }
          if(ceil($day_diff / 7) < 4) { return 'en ' . ceil($day_diff / 7) . ' semanas'; }
          if(date('n', $ts) == date('n') + 1) { return 'proximo mes'; }
          return date('F Y', $ts);
      }
   }

  if($_GET['page']) {
    require('../db/conectar.php');
  }

        setlocale(LC_MONETARY, 'es_CL');
        $pdo = new Conexion();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("SET CHARACTER SET utf8");
        $stm = $pdo->prepare("SELECT * FROM c_publisheds WHERE status=1");
        $stm->execute();
        $num_total_registros = $stm->rowCount();

    $reload = 'index.php?s=classifieds';
    $adjacents  = 4; //brecha entre páginas después de varios adyacentes

 	if ($num_total_registros > 0) {
	//numero de registros por página
    $rowsPerPage = 10;

    //por defecto mostramos la página 1
    $pageNum = 1;

    // si $_GET['page'] esta definido, usamos este número de página
    if(isset($_GET['page'])) {
		  sleep(1);
    	$pageNum = $_GET['page'];
	   }
		
	//echo 'page'.$_GET['page'];

    //contando el desplazamiento
    $offset = ($pageNum - 1) * $rowsPerPage;
    $total_paginas = ceil($num_total_registros / $rowsPerPage);


    $stm2 = $pdo->prepare("SELECT * FROM c_publisheds WHERE status=1 ORDER BY fecha_publicacion DESC, visitas DESC  LIMIT $offset, $rowsPerPage");

    $stm2->execute();

    while ($row_services = $stm2->fetch(PDO::FETCH_OBJ)) {
    //$service = new Service($row_services['service_id']);

    if($_GET['page']) {
      $visitas = 0;
      $fp = fopen('../visitas/'.$row_services->id.'.txt',"r"); //no olvidar crear al archivo visitantes.txt y poner el path correcto
      while($ip2 = fgets($fp)){
          $visitas++;
          $ips .= $ip2;
          if($ip."\n" == $ip2)$existe = 1;
      }
      fclose($fp);
    }
    else {
      $visitas = 0;
      $fp = fopen('visitas/'.$row_services->id.'.txt',"r"); //no olvidar crear al archivo visitantes.txt y poner el path correcto
      while($ip2 = fgets($fp)){
          $visitas++;
          $ips .= $ip2;
          if($ip."\n" == $ip2)$existe = 1;
      }
      fclose($fp);
    }
    

		$descripcion_desformateada = strip_tags($row_services->descripcion);
        $arrayTexto = explode(' ',$descripcion_desformateada);
        $texto = '';
        $contador = 0;
        
		// Reconstruimos la cadena
         while(300 >= strlen($texto) + strlen($arrayTexto[$contador])){
        	$texto .= ' '.$arrayTexto[$contador];
            $contador++;
        }
        

        /// SACAR CONTEO DE VISITAS Y DAR ESTRELLAS

        if($visitas <= 0) {
          $img_rank = '<img src="img/ranking-visits/0.png" alt="" width="130" height="30">';
        }
        else if($visitas >= 0 AND $visitas <= 20) {
          $img_rank = '<img src="img/ranking-visits/0.5.png" alt="" width="130" height="30">';
        }
        else if($visitas >= 20 AND $visitas <= 40) {
          $img_rank = '<img src="img/ranking-visits/1.png" alt="" width="130" height="30">';
        }
        else if($visitas >= 40 AND $visitas <= 60) {
          $img_rank = '<img src="img/ranking-visits/1.5.png" alt="" width="130" height="30">';
        } 
        else if($visitas >= 60 AND $visitas <= 80) {
          $img_rank = '<img src="img/ranking-visits/2.0.png" alt="" width="130" height="30">';
        }
        else if($visitas >= 80 AND $visitas <= 100) {
          $img_rank = '<img src="img/ranking-visits/2.5.png" alt="" width="130" height="30">';
        }
        else if($visitas >= 100 AND $visitas <= 130) {
          $img_rank = '<img src="img/ranking-visits/3.0.png" alt="" width="130" height="30">';
        }
        else if($visitas >= 130 AND $visitas <= 160) {
          $img_rank = '<img src="img/ranking-visits/3.5.png" alt="" width="130" height="30">';
        }
        else if($visitas >= 160 AND $visitas <= 180) {
          $img_rank = '<img src="img/ranking-visits/4.0.png" alt="" width="130" height="30">';
        }
        else if($visitas >= 180 AND $visitas <= 200) {
          $img_rank = '<img src="img/ranking-visits/4.5.png" alt="" width="130" height="30">';
        }
        else {

          $img_rank = '<img src="img/ranking-visits/5.0.png" alt="" width="130" height="30">';
        }
        //////////////////////////////////////////
        $precio_formateado = number_format($row_services->precio, 0, '', '.');
         
        $p_desc = $texto.'...';
		
        			echo '<table class="table table-striped">
		                  <tr>
		                     <td width="10%">
                          <span class="label label-danger" style="margin-top:5px;"><small>'.time2str($row_services->fecha_publicacion).'</small></span>
                                  <a style="float:right;" href="#myModal" id="custId" data-toggle="modal" data-id="'.$row_services->id.'"><img src="img/clasificados/'.$row_services->img1.'" class="" alt="" width="100" height="100"></a>      
                               </td>
		                       <td width="10%">
		                        <ul class="nav">
		                          <li>'.$img_rank.'</li>		                         
		                          <li><small><cite title="Source Title"><i class="fa fa-map-marker"></i> '.$row_services->region.'</cite></small></li>
		                          <li style="text-decoration:line-through;"><i class="fa fa-map-marker"></i> '.$row_services->comuna.'</li>
		                        </ul>
		                       </td>
		                       <td>
		                       <p id="box">'.$row_services->titulo.'</p>
		                       <table class="table">
		                        <tr>
		                          <td width="5%">Dormitorios</td>
		                          <td width="5%">'.$row_services->dormitorios.'</td>
                                  <td width="5%">Superficie</td>
                                  <td width="5%">'.$row_services->superficie.'m²</td>
		                        </tr>
		                        <tr>
		                          <td width="5%">Baños</td>
		                          <td width="5%">'.$row_services->banos.'</td>
                                  <td width="5%">Estacionamientos</td>
                                <td width="5%">'.$row_services->estacionamiento.'</td>
		                        </tr>
		                       </table>
		                       </td>
		                       <td width="5%">
                              <span class="label label-info">Visto: '.$visitas.' veces</span></b>
                           <p>Precio: <strong><br>$ '.$precio_formateado.'</strong><br></p>
                           <a style="float:right;" href="#myModal" class="btn btn-success btn-sm" id="custId" data-toggle="modal" data-id="'.$row_services->id.'"><i class="fa fa-search-plus" aria-hidden="true"></i> Ver detalles</a>
                           </td>
		                  </tr>
		                </table>';
		}
	   
     function paginate($reload, $page, $tpages, $adjacents) {
          $prevlabel = "&lsaquo; Anterior";
          $nextlabel = "Siguiente &rsaquo;";
          $out = '<ul class="pagination pagination-large">';
          
          // previous label

          if($page==1) {
            $out.= "<li><span><a>$prevlabel</a></span></li>";
          } else if($page==2) {
            $out.= "<li><span><a class='paginate' data='".($page-1)."'>$prevlabel</a></span></li>";
          }else {
            $out.= "<li><span><a class='paginate' data='".($page-1)."'>$prevlabel</a></span></li>";

          }
          
          // first label
          if($page>($adjacents+1)) {
            $out.= "<li><a class='paginate' data='1'>1</a></li>";
          }
          // interval
          if($page>($adjacents+2)) {
            $out.= "<li><a>...</a></li>";
          }

          // pages

          $pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
          $pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
          for($i=$pmin; $i<=$pmax; $i++) {
            if($i==$page) {
              $out.= "<li class='active'><a>$i</a></li>";
            }else if($i==1) {
              $out.= "<li><a class='paginate' data='".$i."'>$i</a></li>";
            }else {
              $out.= "<li><a class='paginate' data='".$i."'>$i</a></li>";
            }
          }

          // interval

          if($page<($tpages-$adjacents-1)) {
            $out.= "<li><a>...</a></li>";
          }

          // last

          if($page<($tpages-$adjacents)) {
            $out.= "<li><a class='paginate' data='".$tpages."'>$tpages</a></li>";
          }

          // next

          if($page<$tpages) {
            $out.= "<li><span><a class='paginate' data='".($page+1)."'>$nextlabel</a></span></li>";
          }else {
            $out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
          }
          
          $out.= "</ul>";
          return $out;
        }


        echo paginate($reload, $pageNum, $total_paginas, $adjacents);
	
}
else {
    echo '<div class="alert alert-dismissible alert-warning">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <h4>No se encontraron resultados!</h4>
          <p>Prueba realizando una busqueda con diferentes filtros</p>
        </div>';
}
?>