<?php
/*
 * Este archivo será usado para las operaciones mínimas del archivo de configuración.
 * This file has been created to be reuse and reduce the amount of code needed to start the connections
 * The connection for the database has been done to two different computers   
 */
session_start();

// Datos para Smarty
// ISSUE_21: para mantener la configuración correcta cuando se ejecuta en Windows y en Mac
// voy a definir un root_path dependiendo del sistema en el que esté
 

// The details to start the connection to the database 
// Depending on the cumputer in which I am working I will define a different rootpath 
if ($_SERVER['SERVER_NAME'] === "monitoreo.test") {
    // monitoreo.test es el nombre del servidor cuando lo ejecuto en windows
    define ('_ROOT_PATH_', 'C:/WinNMP/WWW/Monitoreo/monitoreo');
    // Base de datos
    define ('DB_HOST', 'localhost');
    define ('DB_USER', 'root');
    define ('DB_PASS', '');
    define ('DB_NAME', 'monitoreo');
}
else {
    define ('_ROOT_PATH_', '/Applications/nginxstack-1.14.2-3/nginx/html/monitoreo');
    // Base de datos
    define ('DB_HOST', '127.0.0.1');
    define ('DB_USER', 'root');
    define ('DB_PASS', 'Panama2019');
    define ('DB_NAME', 'monitoreo');
}
define ('_WEB_PATH_', 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/monitoreo');



// Vamos a crear el objeto Smarty, pues se usará en todas las páginas
// An object Smarty has been created and it loads the templates, configuration, compilers and cache
include_once _ROOT_PATH_ . '/lib/Smarty/Smarty.class.php';
$smarty = new Smarty();
$smarty->setTemplateDir(_ROOT_PATH_ . '/tpl/');
$smarty->setCompileDir(_ROOT_PATH_ . '/tpl/smarty/templates_c/');
$smarty->setConfigDir(_ROOT_PATH_ . '/tpl/smarty/configs/');
$smarty->setCacheDir(_ROOT_PATH_ . '/tpl/smarty/cache/');
$smarty->assign('_WEB_PATH_', _WEB_PATH_);

// En la mayoría de páginas necesitaremos la variable tipo de usuario para poder realizar cierto tipo de acciones
// When the connection starts, the variable type of user is needed to allow access to certain pages
$smarty->assign('tipo_usuario', $_SESSION['tipo_de_usuario']);