<?php
/**
 * The initial page that the user adminitrador will see is index. It displays the options of the left hand side menu 
 * from where they can reach other functionalitites 
 */

require_once __DIR__ . '/../config/config.php';
// Restringimos el acceso sólo a usuarios administradores
// Restrict the access only to user with the profile adminitrator
$perfiles_aceptados = array('administrador');
require_once __DIR__ . '/../security/autorizador.php';


// La variable main se utilizará en el archivo footer.php
// The variable main is stored in footer.php, si we call then from there
$main = $smarty->fetch("paginas/index_admin.tpl");

require_once '../footer.php';

$smarty->display('esqueleto_dashboard.html');