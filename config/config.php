<?php
/*
 * Este archivo será usado para las operaciones mínimas del archivo de configuración.
 */
session_start();

// Datos para Smarty
define ('_ROOT_PATH_', '/Applications/nginxstack-1.14.2-3/nginx/html/monitoreo');
define ('_WEB_PATH_', 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/monitoreo');

// Base de datos
define ('DB_HOST', 'localhost');
define ('DB_USER', 'root');
define ('DB_PASS', '');
define ('DB_NAME', 'monitoreo');

// Vamos a crear el objeto Smarty, pues se usará en todas las páginas
include_once _ROOT_PATH_ . '/lib/Smarty/mySmarty.php';
$smarty = new MySmarty();
$smarty->assign('_WEB_PATH_', _WEB_PATH_);