<?php
/**
 * Este fichero se llama cuando se cierra la sesion, de modo que todas las variables 
 * que se hayan manipulado serán destruidas.
 */

require_once '../config/config.php';

session_destroy();

header('Location: ' . _WEB_PATH_ . '/security/login.php');