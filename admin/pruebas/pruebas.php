<?php
require_once __DIR__ . '/../../config/config.php';
// Restringimos el acceso sólo a usuarios administradores
// it is only permited the access to the user 'administrador'
$perfiles_aceptados = array('administrador');
require_once __DIR__ . '/../../security/autorizador.php';

// Cargamos el estilo de la página
// The style of the page gets load
$header = $smarty->fetch("header/pruebas.tpl");

// Vamos a comprobar si hay mensajes en la sesión
// Check for messages in the session
if ($_SESSION['exito_mensaje']){
    // hay mensajes de exito. Los mostramos
    // If there are success messages, they get load
    $smarty->assign('exito_titulo', $_SESSION['exito_titulo']);
    $smarty->assign('exito_mensaje', $_SESSION['exito_mensaje']);

    // Y los borramos de la sesión para no mostrarlos de nuevo en futuras visitas a la página
    // The success messages are deleted 
    unset($_SESSION['exito_titulo']);
    unset($_SESSION['exito_mensaje']);
}

// De la misma manera vamos a ver si hay algún error
// check if there are error messages 
if ($_SESSION['error']){
    // hay mensajes de error. Los mostramos
    // If there are some, we display them
    $smarty->assign('error', $_SESSION['error']);

    // Y los borramos de la sesión para no mostrarlos de nuevo en futuras visitas a la página
    // Error messages get deleted 
    unset($_SESSION['error']);
}

// La variable main se utilizará en el archivo footer.php
// The view is loaded, starting by the main body of the page and the the footer
$main = $smarty->fetch("paginas/pruebas/pruebas.tpl");

$footer = $smarty->fetch("footer/pruebas.tpl");

require_once '../../footer.php';

$smarty->display('esqueleto_dashboard.html');