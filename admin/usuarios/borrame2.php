<?php
require_once __DIR__ . '/../../config/config_admin.php';
require_once __DIR__ . '/../../src/Usuarios.php';

$datos = array(
    'nombre' => "Gonza",
    'apellidos' => "Panameño",
    'login' => "riquitan11",
    'telefono' => "234343",
    'password' => "Panama2019",
    'tipo_de_usuario' => "promotor",
    'id_subreceptor' => 6,
    'id_cedula' => '123asdf7',
    'organizacion' => 'Panama City Organization');

try{
    $
    Usuarios::update($datos);
}
catch (ValidationException $e){
    echo "Error de validación: ";
    $errores = unserialize($e->getMessage());

    foreach ($errores as $error){
        echo "<br>" . $error;
    }
    exit;
}
catch (Exception $e){
    echo "Error: " . $e->getMessage();
    exit;
}

echo "Usuario introducido con éxito";