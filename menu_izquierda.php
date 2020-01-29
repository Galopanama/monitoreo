<?php
// All the assignatino to generate the menu from the left hand side are define here
// En esta pagina realizaremos todas las asignaciones y controles necesarios para generar el menú de la izquierda

$menu_izq = $smarty->fetch("menu_izquierda.tpl");

$smarty->assign("_MENU_IZQUIERDA", $menu_izq);