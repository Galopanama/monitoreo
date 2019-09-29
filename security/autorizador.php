<?php
// Este fichero se encargará de permitir, o no, el acceso a la página en base al perfil del usuario y el acceso que exija cada página
// Vamos a comprobar si el usuario está logado o no
// The file will chech the user type of the user and allow the access to the pages if s/he has the permision to do so
// First we check if the user is logged
if (!isset($_SESSION['usuario_id']) || is_null($_SESSION['usuario_id']) || $_SESSION['usuario_id'] === ""){
    header('Location: ' . _WEB_PATH_ . '/security/login.php');
    exit;
}

if (!isset($perfiles_aceptados) || !is_array($perfiles_aceptados)){
    $perfiles_aceptados = array();
}

if (!in_array($_SESSION['tipo_de_usuario'], $perfiles_aceptados)){
    $_SESSION["error_message"] = "No tienes permiso para entrar a esta página";
    // Si no tiene acceso a la página, lo redirigimos
    // If the user has no access to the page, it will be redirected and an error message return to s/he
    header('Location: ' . _WEB_PATH_ . '/error.php');
    exit;
}