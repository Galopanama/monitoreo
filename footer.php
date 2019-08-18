<?php

// En este fichero, tal y como me recomendó Jose, voy a poner las acciones comunes de smarty
// Por ejemplo, la carga de los menús y 

// Generamos el menú
$menu_izq = $smarty->fetch("menu_izquierda.tpl");
$smarty->assign("_MENU_IZQUIERDA", $menu_izq);

// Generamos la barra de navegación superior
$nav_sup = $smarty->fetch("navegacion.tpl");
$smarty->assign("_NAVEGACION_SUPERIOR", $nav_sup);

// Y ahora el contenido principal, que vendrá de cada una de las páginas en la variable $main
$smarty->assign("_MAIN", $main);