<?php
require_once 'config.php';

// Vamos a comprobar si el usuario está logado o no
if (!isset($_SESSION['usuario_id']) || is_null($_SESSION['usuario_id']) || $_SESSION['usuario_id'] === ""){
    header('Location: ' . _WEB_PATH_ . '/security/login.php');
}