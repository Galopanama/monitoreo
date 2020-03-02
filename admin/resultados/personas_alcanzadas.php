<?php
/**
 * Desde este fichero se van a manejar las respuesta de la base de datos y la visualizacion de mensajes 
 * para con el usuario Adminstrador
 */
require_once __DIR__ . '/../../config/config.php';

// Restringimos el acceso sólo a usuarios administrador
$perfiles_aceptados = array ('administrador');
require_once __DIR__ . '/../../security/autorizador.php';

// Cargamos el estilo de la página
$header = $smarty->fetch("header/personas_alcanzadas.tpl");

// Vamos a comprobar si hay mensajes en la sesión
if ($_SESSION['exito_mensaje']){

    // hay mensajes de exito. Los mostramos
    $smarty->assign('exito_titulo', $_SESSION['exito_titulo']);
    $smarty->assign('exito_mensaje', $_SESSION['exito_mensaje']);

    // Y los borramos de la sesión para no mostrarlos de nuevo en futuras visitas a la página
    unset($_SESSION['exito_titulo']);
    unset($_SESSION['exito_mensaje']);
}

// De la misma manera vamos a ver si hay algún error
if ($_SESSION['error']){
    // hay mensajes de error. Los mostramos
    $smarty->assign('error', $_SESSION['error']);

    // Y los borramos de la sesión para no mostrarlos de nuevo en futuras visitas a la página
    unset($_SESSION['error']);
}

// Se llama al resto de la Vista 
$main = $smarty->fetch("paginas/resultados/personas_alcanzadas.tpl"); 

$footer = $smarty->fetch("footer/personas_alcanzadas.tpl");  

require_once '../../footer.php';

$smarty->display('esqueleto_dashboard.html');  