<?php
/*
 * Este archivo será usado para las operaciones mínimas del archivo de configuración.
 */
session_start();

// Datos para Smarty
// ISSUE_21: para mantener la configuración correcta cuando se ejecuta en Windows y en Mac
// voy a definir un root_path dependiendo del sistema en el que esté
if ($_SERVER['SERVER_NAME'] === "monitoreo.test") {
    // monitoreo.test es el nombre del servidor cuando lo ejecuto en windows
    define ('_ROOT_PATH_', 'C:/WinNMP/WWW/Monitoreo/monitoreo');
}
else {
    define ('_ROOT_PATH_', '/Applications/nginxstack-1.14.2-3/nginx/html/monitoreo');
}
define ('_WEB_PATH_', 'http://' . $_SERVER['SERVER_NAME'] . '/monitoreo');

// Base de datos
define ('DB_HOST', 'localhost');
define ('DB_USER', 'root');
define ('DB_PASS', '');
define ('DB_NAME', 'monitoreo');

// Vamos a crear el objeto Smarty, pues se usará en todas las páginas
include_once _ROOT_PATH_ . '/lib/Smarty/mySmarty.php';
$smarty = new MySmarty();
$smarty->assign('_WEB_PATH_', _WEB_PATH_);

// En la mayoría de páginas necesitaremos la variable tipo de usuario para poder realizar cierto tipo de acciones
$smarty->assign('tipo_usuario', $_SESSION['tipo_de_usuario']);