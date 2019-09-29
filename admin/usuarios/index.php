<?php

require_once __DIR__ . '/../../config/config.php';
// Restringimos el acceso sólo a usuarios administradores
// it is only permited the access to the user 'administrador'
$perfiles_aceptados = array('administrador');
require_once __DIR__ . '/../../security/autorizador.php';

// Cargamos el estilo de la página
// The information about the styles of the page gets load from here
$header = $smarty->fetch("header/usuarios.tpl");

// Vamos a comprobar si hay mensajes en la sesión
// It checks if there are any messages in the session
if ($_SESSION['exito_mensaje']){

    // hay mensajes de exito. Los mostramos
    // If there are any success messages, we load them
    $smarty->assign('exito_titulo', $_SESSION['exito_titulo']);
    $smarty->assign('exito_mensaje', $_SESSION['exito_mensaje']);

    // Y los borramos de la sesión para no mostrarlos de nuevo en futuras visitas a la página
    // success message gets deleted
    unset($_SESSION['exito_titulo']);
    unset($_SESSION['exito_mensaje']);
}

// De la misma manera vamos a ver si hay algún error
// check if there are any error messages
if ($_SESSION['error']){

    // hay mensajes de error. Los mostramos
    //If there are any error message they get load
    $smarty->assign('error', $_SESSION['error']);

    // Y los borramos de la sesión para no mostrarlos de nuevo en futuras visitas a la página
    // Error messages gets deleted
    unset($_SESSION['error']);
}

// La variable main se utilizará en el archivo footer.php
// The variable main gets sored in the the file footer.php
// it loads the variable and the rest of the visualisation of the page
$main = $smarty->fetch("paginas/usuarios/index.tpl");

$footer = $smarty->fetch("footer/usuarios.tpl");

require_once '../../footer.php';

$smarty->display('esqueleto_dashboard.html');

?>