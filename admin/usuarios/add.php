<?php
require_once '../../config/config_admin.php';
require_once __DIR__ . '/../../src/Usuarios.php';

// En principio no se necesitan headers especiales para la página principal
//$header = $smarty->fetch("");

// Necesitamos cargar un array con los tipos de usuario válidos. Dicho array está en la clase Usuarios
$smarty->assign('tipos_de_usuario', Usuarios::tipos_usuario_permitidos);

// La variable main se utilizará en el archivo footer.php
$main = $smarty->fetch("paginas/usuarios/add_update.html");

//$footer = $smarty->fetch("footer/usuarios.tpl");

require_once '../../footer.php';

$smarty->display('esqueleto_dashboard.html');