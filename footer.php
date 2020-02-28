<?php

// En este fichero se crean las acciones comunes de Smarty (se asignan las variables) 

// Reduce la cantida de codigo y se encuentra todo agrupado en un solo fichero
$smarty->assign('_HEADER_EXTRA', $header);

$smarty->assign('_FOOTER_EXTRA', $footer);

// Generamos el menú de la izquierda y lo llamamos
require_once 'menu_izquierda.php';

// Generamos la barra de navegación de la parte superior de la pantalla
$nav_sup = $smarty->fetch("navegacion.tpl");
$smarty->assign("_NAVEGACION_SUPERIOR", $nav_sup);

// Y el contenido principal, que vendrá de cada una de las páginas en la variable $main
$smarty->assign("_MAIN", $main);