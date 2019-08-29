<?php
// Este fichero debe actuar igual que config_registrado (de hecho debe hacer en parte lo mismo por lo que delegamos esa parte en el)
require_once __DIR__ . '/config_registrado.php';

// Pero ademas, debe comprobar que el usuario que entra sea administrador
if($_SESSION['tipo_de_usuario'] !== "administrador"){
    // Devolvemos al usuario que no es administrador a su página inicial
    header('Location: ' . _WEB_PATH_ . '/user/index.php');
    exit;
}