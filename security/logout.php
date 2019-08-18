<?php
require_once '../config/config.php';

session_destroy();

header('Location: ' . _WEB_PATH_ . '/security/login.php');