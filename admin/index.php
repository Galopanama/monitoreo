<?php
// TODO: Cambiar a config_registrado
require_once '../config/config.php';

// En principio no se necesitan headers especiales para la página principal
//$header = $smarty->fetch("");

// La variable main se utilizará en el archivo footer.php
$main = $smarty->fetch("mains/example.tpl");

require_once 'footer.php';

$smarty->display('esqueleto_dashboard.html');