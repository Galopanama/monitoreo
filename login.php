<?php

require_once ("DB.php");
require_once ("model/Usuario.php");


// TODO Cambiar a un prepared statement
$sql = "select * from usuarios where login = '" . $_POST["inputEmail"] . "' and activo = true";
$usuario = new Usuario();
$usuario->load($_POST["inputEmail"]); // Porque se utiliza el inputEmail para verificar el usuario??
$usuario->checkLogin($_POST["inputPassword"]);
 
$db = new DB();
$mysqli = $db->conecta();

$result = $mysqli->query($sql);

$usuario = $result->fetch_assoc();


if (password_verify($_POST["inputPassword"], $usuario["password"])) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}


$db->desconecta();

?>