<?php
require_once __DIR__ . '/../../config/config.php';

// Restringimos el acceso sólo a usuarios promotores y subreceptores
$perfiles_aceptados = array('promotor', 'subreceptor');
require_once __DIR__ . '/../../security/autorizador.php';

// Cargamos el estilo de la página
$header = $smarty->fetch("header/entrevistas.tpl");

// Vamos a comprobar si hay mensajes en la sesión
if ($_SESSION['exito_mensaje']){

    // Se muestran los mensajes de exito si hubiera
    $smarty->assign('exito_titulo', $_SESSION['exito_titulo']);
    $smarty->assign('exito_mensaje', $_SESSION['exito_mensaje']);

    // Y los borramos de la sesión para no mostrarlos de nuevo en futuras visitas a la página
    unset($_SESSION['exito_titulo']);
    unset($_SESSION['exito_mensaje']);
}

// De la misma manera vamos a ver si hay algún error
if ($_SESSION['error']){

    // Se muestran los errores si hubiera
    $smarty->assign('error', $_SESSION['error']);

    // Y los borramos de la sesión para no mostrarlos de nuevo en futuras visitas a la página
    unset($_SESSION['error']);
}

// Se llama al resto de la parte visual correspondiente a la Vista
$main = $smarty->fetch("paginas/entrevistas/grupales.tpl");

$footer = $smarty->fetch("footer/entrevistasGrupales.tpl");

require_once '../../footer.php';

$smarty->display('esqueleto_dashboard.html');