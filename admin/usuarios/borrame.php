<?php
require_once __DIR__ . '/../../config/config_admin.php';
require_once __DIR__ . '/../../src/Usuarios.php';

try{
    $usuario = Usuarios::buscaUsuarioSubreceptor("pa");

    print_r($usuario);
}
catch (Exception $e){
    echo "Error: " . $e->getMessage();
    exit;
}

echo "Usuario introducido con éxito";