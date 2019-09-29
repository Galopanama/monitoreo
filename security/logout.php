<?php
// This file will be called when the user close the session. That way all the variables of the session will be destroyed
require_once '../config/config.php';

session_destroy();

header('Location: ' . _WEB_PATH_ . '/security/login.php');