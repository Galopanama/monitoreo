<?php
// Fichero en proceso de construccion. Se idea desde una posible visualizacion de las pruebas
// y los resultados que se obtiene en ellas. No esta terminada

require_once __DIR__ . '/../../config/config.php';
// Restringimos el acceso sólo a usuarios subreceptores

$perfiles_aceptados = array ('subreceptor');
require_once __DIR__ . '/../../security/autorizador.php';

// Cargamos el estilo de la página

$header = $smarty->fetch("header/pruebas_realizadas.tpl");

// Vamos a comprobar si hay mensajes en la sesión

if ($_SESSION['exito_mensaje']){
    // Se muestran los mensajes de exito si hubiera
    $smarty->assign('exito_titulo', $_SESSION['exito_titulo']);
    $smarty->assign('exito_mensaje', $_SESSION['exito_mensaje']);

    // Y los borramos de la sesión para no mostrarlos de nuevo en futuras visitas a la página
    unset($_SESSION['exito_titulo']);
    unset($_SESSION['exito_mensaje']);
}

// De la misma manera vamos a comprobar si hay algún error
if ($_SESSION['error']){
    // Se muestran los errores si hubiera
    $smarty->assign('error', $_SESSION['error']);

    // Y los borramos de la sesión para no mostrarlos de nuevo en futuras visitas a la página
    unset($_SESSION['error']);
}

// Se llama al resto de la parte visual correspondiente a la Vista
$main = $smarty->fetch("paginas/resultados/pruebas_realizadas.tpl");

$footer = $smarty->fetch("footer/pruebas_realizadas.tpl"); 

require_once '../../footer.php';

$smarty->display('esqueleto_dashboard.html');