<?php
require_once __DIR__ . '/../../config/config_admin.php';
require_once __DIR__ . '/../../src/Usuarios.php';

/*$datos = array(
    'nombre' => "Gonza",
    'apellidos' => "Panameño",
    'login' => "riquitan3",
    'telefono' => "234343",
    'password' => "Panama2019",
    'tipo_de_usuario' => "tecnologo",
    'numero_de_registro' => 23432,
    'id_cedula' => '123asdf');
*/

/*
$datos = array(
    'nombre' => "Gonza",
    'apellidos' => "Panameño",
    'login' => "riquitan4",
    'telefono' => "234343",
    'password' => "Panama2019",
    'tipo_de_usuario' => "subreceptor",
    'ubicacion' => 'Sevilla');
*/

$datos = array(
    'nombre' => "Gonza",
    'apellidos' => "Panameño",
    'login' => "riquitan9",
    'telefono' => "234343",
    'password' => "Panama2019",
    'tipo_de_usuario' => "promotor",
    'id_subreceptor' => 6,
    'id_cedula' => '123asdf6',
    'organizacion' => 'Panama City Organization');

try{
    Usuarios::add($datos);
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