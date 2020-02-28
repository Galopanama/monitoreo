<?php
// Esta pagina va a direccionar al usuario dependiendo de su tipo 
// (Adminstrador por un lado y los demas por otro)

require_once 'config/config.php';


switch ($_SESSION['tipo_de_usuario']){
    case 'administrador':
        header('Location: ' . _WEB_PATH_ . '/admin/index.php');
        break;
    default:
        header('Location: ' . _WEB_PATH_ . '/user/index.php');
        break;
}