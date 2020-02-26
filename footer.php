<?php

// In this file there are the common action from Smarty. it will reduce the amount of code to write afterwards, as it will load all from this one file
// En esta 
$smarty->assign('_HEADER_EXTRA', $header);

$smarty->assign('_FOOTER_EXTRA', $footer);


// Generamos el menú
// Generate the menu from the left hand side of the display screen
require_once 'menu_izquierda.php';

// Generamos la barra de navegación superior
// Generate the search bar from the top part of the screen
$nav_sup = $smarty->fetch("navegacion.tpl");
$smarty->assign("_NAVEGACION_SUPERIOR", $nav_sup);

// Y ahora el contenido principal, que vendrá de cada una de las páginas en la variable $main
// The variable main is assigned here
$smarty->assign("_MAIN", $main);