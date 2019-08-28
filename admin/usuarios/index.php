<?php
require_once '../../config/config_admin.php';

// En principio no se necesitan headers especiales para la página principal
//$header = $smarty->fetch("");

// Vamos a comprobar si hay mensajes en la sesión
if ($_SESSION['exito_mensaje']){
    // hay mensajes de exito. Los mostramos
    $smarty->assign('exito_titulo', $_SESSION['exito_titulo']);
    $smarty->assign('exito_mensaje', $_SESSION['exito_mensaje']);

    // Y los borramos de la sesión para no mostrarlos de nuevo en futuras visitas a la página
    unset($_SESSION['exito_titulo']);
    unset($_SESSION['exito_mensaje']);
}

// La variable main se utilizará en el archivo footer.php
$main = $smarty->fetch("paginas/usuarios/index.tpl");

$footer = $smarty->fetch("footer/usuarios.tpl");

require_once '../../footer.php';

$smarty->display('esqueleto_dashboard.html');