<?php

// En esta pagina realizaremos todas las asignaciones y contorles necesarios para generar el menú de la izquierda
$menu_izq = $smarty->fetch("menu_izquierda.tpl");
$smarty->assign("_MENU_IZQUIERDA", $menu_izq);