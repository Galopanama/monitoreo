<?php
session_start();

require_once 'config/config.php';

// Obtenemos el mensaje y lo eliminamos para futuros usos
$smarty->assign("error_message", $_SESSION["error_message"]);
unset($_SESSION["error_message"]);

$smarty->display("error.html");