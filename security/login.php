<?php
// This file will check the login name and password of anybody who wants to access to FOMODI
require_once '../config/config.php';

//Comprobamos si es sólo para mostrar la página o es para realizar el logado
// Check the username and password
if($_POST['username'] || $_POST['password']){
    
    //Realiza el login
    // The usuarios from the database needs to be called as the informationstored there will be used to compared with the one introduced by the user
    require_once '../src/Usuarios.php';
    try {
        $usuario = Usuarios::getUsuarioByUsername($_POST['username'], true, true);
        // Initially the user name gets checked
        

        // If the password is veryfied and is correct, the data will be assigned to the variable SESSION
        if (password_verify($_POST["password"], $usuario->getPassword())) {                 
            $_SESSION['usuario_id'] = $usuario->getId();                                    
            $_SESSION['tipo_de_usuario'] = $usuario->getTipo_de_usuario();
        }
        else {
            // Si no, simplemente informamos de login incorrecto
            // If not, the user will be inform
            $_SESSION['login_error'] = "Login incorrecto";
        }
    }
    catch (UsuarioNotFoundException $e) {
        // El usuario no existe. No mostraremos más información por seguridad
        // If the user does not exist, no extra information will be show as a security messure
        $_SESSION['login_error'] = "Login incorrecto";
    }
    catch (Exception $e) {
        // If the error is related to the database, the user will be informed
        $_SESSION['login_error'] = "Error de BD";
    }
    
    // Si no han ocurrido errores durante el login
    // If there are no errors, it will be check the type of user and redirect consequently to the user type and its privilige
    if(!isset($_SESSION['login_error'])){
        // Redirigir a cada usuario a su web correspondiente
        switch ($_SESSION['tipo_de_usuario']){
            case 'administrador':
                header('Location: ' . _WEB_PATH_ . '/admin/index.php');
                break;
            default:
                header('Location: ' . _WEB_PATH_ . '/user/index.php');
                break;
        }
    }
}

// Si llega aquí, es que no se estaba realizando el login, o que este ha fallado
// En caso de que hubiese errores, los mostramos y los borramos
// If there has been any errors they will be shown and the variable SESSION will be deleted afterwards
if (isset($_SESSION['login_error'])){
    $smarty->assign('login_error', $_SESSION['login_error']);
    // Y borramos la variable
    unset($_SESSION['login_error']);
}

$smarty->display('login.html');