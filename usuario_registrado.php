<?php

if(isset($_SESSION[$usuario]) && !empty ($_SESSION[$usuario])){
    header('http://' . $_SERVER['SERVER_NAME'] . '/monitoreo');
}
else{ 
    echo 'Regístrate en la aplicación antes de acceder. Utiliza tú nombre de usuario y contraseña';
    header('Location: ' . _WEB_PATH_ . 'monitoreo/login.php');
}

?>
