<?php
require_once __DIR__ . '/../config/config.php';
// Restringimos el acceso sólo a usuarios administradores
$perfiles_aceptados = array('promotor', 'subreceptor', 'tecnologo');
require_once __DIR__ . '/../security/autorizador.php';

// En principio no se necesitan headers especiales para la página principal
//$header = $smarty->fetch("");

// La variable main se utilizará en el archivo footer.php
$main = $smarty->fetch("mains/example.tpl");

require_once __DIR__ . '../footer.php';

$smarty->display('esqueleto_dashboard.html');