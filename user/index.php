<?php
/**
 * The initial page that the all user will see is index. It displays the options of the left hand side menu from
 * where they can reach any other functionality of the application 
 */
require_once __DIR__ . '/../config/config.php';
// Restringimos el acceso sólo a usuarios 'promotor', 'subreceptor', 'tecnologo'
// Restricted acccess to users 'promotor', 'subreceptor', 'tecnologo'
$perfiles_aceptados = array('promotor', 'subreceptor', 'tecnologo');
require_once __DIR__ . '/../security/autorizador.php';


// La variable main se utilizará en el archivo footer.php
// the variable main is located in the file footer.php so it is called from here
$main = $smarty->fetch("paginas/index_usuarios.tpl");

require_once '../footer.php';

$smarty->display('esqueleto_dashboard.html');