<?php
// This page will redirect the user depending on their user type

require_once 'config/config.php';


switch ($_SESSION['tipo_de_usuario']){
    case 'administrador':
        header('Location: ' . _WEB_PATH_ . '/admin/index.php');
        break;
    default:
        header('Location: ' . _WEB_PATH_ . '/user/index.php');
        break;
}