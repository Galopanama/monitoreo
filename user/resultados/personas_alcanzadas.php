<?php
require_once __DIR__ . '/../../config/config.php';
// Restringimos el acceso sólo a usuarios subreceptores
// Access only permited to the user 'subreceptor'
$perfiles_aceptados = array ('subreceptor');
require_once __DIR__ . '/../../security/autorizador.php';

// Cargamos el estilo de la página
// Load the page's styles
$header = $smarty->fetch("header/personas_alcanzadas.tpl");

// Vamos a comprobar si hay mensajes en la sesión
// Check for session messages
if ($_SESSION['exito_mensaje']){
    // hay mensajes de exito. Los mostramos
    // Show if found
    $smarty->assign('exito_titulo', $_SESSION['exito_titulo']);
    $smarty->assign('exito_mensaje', $_SESSION['exito_mensaje']);

    // Y los borramos de la sesión para no mostrarlos de nuevo en futuras visitas a la página
    // The messages are deleted
    unset($_SESSION['exito_titulo']);
    unset($_SESSION['exito_mensaje']);
}

// De la misma manera vamos a ver si hay algún error
// Look for error
if ($_SESSION['error']){
    // hay mensajes de error. Los mostramos
    // Show if found
    $smarty->assign('error', $_SESSION['error']);

    // Y los borramos de la sesión para no mostrarlos de nuevo en futuras visitas a la página
    // Delete afterwards
    unset($_SESSION['error']);
}

// Rest of the View is called
$main = $smarty->fetch("paginas/resultados/personas_alcanzadas.tpl"); // que es html del formulario

$footer = $smarty->fetch("footer/personas_alcanzadas.tpl");  // que contiene funciones y bibliotecas de DatePicker


require_once '../../footer.php';

$smarty->display('esqueleto_dashboard.html');  