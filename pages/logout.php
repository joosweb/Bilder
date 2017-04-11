<?php
session_start();
session_unset();
session_destroy();
session_write_close();
unset($_SESSION['access_token']);
setcookie(session_name(),'',0,'/');
header('Location: index.php?s=home');
?>
