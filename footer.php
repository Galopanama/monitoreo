<?php

// En este fichero, tal y como me recomendó Jose, voy a poner las acciones comunes de smarty
// Por ejemplo, la carga de los menús y la asignación del contenido principal (main) al sitio correcto

// En la mayoría de páginas necesitaremos la variable tipo de usuario para poder realizar cierto tipo de acciones
$smarty->assign('tipo_usuario', $_SESSION['tipo_de_usuario']);

$smarty->assign('_HEADER_EXTRA', $header);

$smarty->assign('_FOOTER_EXTRA', $footer);


// Generamos el menú
require_once 'menu_izquierda.php';

// Generamos la barra de navegación superior
$nav_sup = $smarty->fetch("navegacion.tpl");
$smarty->assign("_NAVEGACION_SUPERIOR", $nav_sup);

// Y ahora el contenido principal, que vendrá de cada una de las páginas en la variable $main
$smarty->assign("_MAIN", $main);