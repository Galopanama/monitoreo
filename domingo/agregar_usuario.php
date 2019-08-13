<?php

require_once '../config/config.php';

$contenido_principal=$smarty->fetch("agregar_usuario.html");
$smarty->assign("contenido_principal",$contenido_principal);

$smarty->display("main.html");



?>