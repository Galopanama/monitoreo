<?php
/**
 * La pagina inicial que todos los usuarios (excepto el Adminstrador que tiene otra especifica para su perfil) 
 * van a ver al conectarse es index.php
 * 
 * Desde aqui se muestra informacion sobre los Derechos Humanos (que puede variarse hacia otros contenidos 
 * mas relavantes) y se presenta el menu de la izquierda que guarda todas las funcionalidades para 
 * navegar por la plataforma.
 */
require_once __DIR__ . '/../config/config.php';

// Se restringe el acceso sólo a usuarios tipo 'promotor', 'subreceptor', 'tecnologo'
$perfiles_aceptados = array('promotor', 'subreceptor', 'tecnologo');
require_once __DIR__ . '/../security/autorizador.php';


// La variable main se utilizará en el archivo footer.php
$main = $smarty->fetch("paginas/index_usuarios.tpl");

require_once '../footer.php';

$smarty->display('esqueleto_dashboard.html');