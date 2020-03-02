<?php
/**
 * Es la pagina inicial del Adminstrador que va a ver al conectarse a FOMODI es index.php
 * 
 * Desde aqui se muestra informacion sobre los Derechos Humanos (que puede variarse hacia otros contenidos 
 * mas relavantes) y se presenta el menu de la izquierda que guarda todas las funcionalidades para 
 * navegar por la plataforma.
 */

require_once __DIR__ . '/../../config/config.php';
// Restringimos el acceso sólo a usuarios administradores
$perfiles_aceptados = array('administrador');
require_once __DIR__ . '/../../security/autorizador.php';

// Cargamos el estilo de la página
$header = $smarty->fetch("header/usuarios.tpl");

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


// La Vista se carga desde los siguiente ficheros
// La variable main se utilizará en el archivo footer.php
$main = $smarty->fetch("paginas/usuarios/index.tpl");

$footer = $smarty->fetch("footer/usuarios.tpl");

require_once '../../footer.php';

$smarty->display('esqueleto_dashboard.html');

?>