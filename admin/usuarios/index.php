<?php
require_once '../../config/config_admin.php';

// En principio no se necesitan headers especiales para la página principal
//$header = $smarty->fetch("");

// La variable main se utilizará en el archivo footer.php
$main = $smarty->fetch("paginas/usuarios/index.tpl");

$footer = $smarty->fetch("footer/usuarios.tpl");

require_once '../../footer.php';

$smarty->display('esqueleto_dashboard.html');