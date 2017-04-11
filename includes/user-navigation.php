<?php
$page = $_GET['s'];

if($page == 'profile'){
  $active_1 = 'active';
}
else if($page == 'inbox'){
  $active_2 = 'active';
}
else if($page == 'publish'){
  $active_3 = 'active';
}
else if($page == 'certified'){
  $active_4 = 'active';
}
if($page == 'publish-property'){
  $active_5 = 'active';
}
else if($page == 'mycertified'){
  $active_6 = 'active';
}

?>
          <ul class="profile__nav">
              <li class="<?php echo $active_1; ?>">
                <a href="index.php?s=profile">
                  <i class="fa fa-user"></i> Noticias
                </a>
              </li>
             <?php
              if(countMessages() <= 0){
                ?>
                <li class="<?php echo $active_2; ?>">
                 <a href="index.php?s=inbox">
                  <i class="fa fa-envelope-o"></i> Mensajes
                </a>
              </li>
            <?php
              }
              else {
             ?>
              <li class="<?php echo $active_2; ?>">
                 <a href="index.php?s=inbox">
                  <i class="fa fa-envelope-o"></i> Mensajes <span class="badge"><?php echo countMessages(); ?></span>
                </a>
              </li>
             <?php } ?>
              <li class="<?php echo $active_3; ?>">
                 <a href="index.php?s=publish">
                  <i class="fa fa-edit"></i> Publicar Deudor
                </a>
              </li>
              <li class="<?php echo $active_4; ?>">
                <a href="index.php?s=certified">
                  <i class="fa fa-edit"></i> Pedir Certificado
                </a>
              </li>
               <li class="<?php echo $active_5; ?>">
                <a href="index.php?s=publish-property">
                  <i class="fa fa-edit"></i> Publicar Propiedad
                </a>
              </li>
              
              <li class="<?php echo $active_6; ?>">
                <a href="index.php?s=mycertified">
                  <i class="fa fa-file-text-o"></i> Mis certificados
                </a>
              </li>
              <li>
                <a href="index.php?s=logout">
                  <i class="fa fa-sign-out"></i> Salir
                </a>
              </li>
             </ul>