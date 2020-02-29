<?php
/**
 * La pagina inicial que el Adminstrador va a utilizar. Se conecta desde index.php
 * 
 * Desde aqui se muestra informacion sobre los Derechos Humanos (que puede variarse hacia otros contenidos 
 * mas relavantes) y se presenta el menu de la izquierda que guarda todas las funcionalidades para 
 * navegar por la plataforma.
 */
require_once __DIR__ . '/../config/config.php';

// Restringimos el acceso sólo a usuarios administradores
$perfiles_aceptados = array('administrador');
require_once __DIR__ . '/../security/autorizador.php';


// La variable main se utilizará en el archivo footer.php
$main = $smarty->fetch("paginas/index_admin.tpl");

require_once '../footer.php';

$smarty->display('esqueleto_dashboard.html');