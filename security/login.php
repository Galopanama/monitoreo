<?php
require_once '../config/config.php';

//Comprobamos si es sólo para mostrar la página o es para realizar el logado
if($_POST['username'] || $_POST['password']){
    //Realiza el login
    require_once '../src/Usuarios.php';
    try {
        $usuario = Usuarios::getUsuarioByUsername($_POST['username']);
        
        // Si el password es correcto
        if (password_verify($_POST["password"], $usuario->getPassword())) {
            // Pondremos en la sesión los datos necesarios
            $_SESSION['usuario_id'] = $usuario->getId();
            $_SESSION['tipo_de_usuario'] = $usuario->getTipo_de_usuario();
        }
        else {
            // Si no, simplemente informamos de login incorrecto
            $_SESSION['login_error'] = "Login incorrecto";
        }
    }
    catch (UsuarioNotFoundException $e) {
        // El usuario no existe. No mostraremos más información por seguridad
        $_SESSION['login_error'] = "Login incorrecto";
    }
    catch (Exception $e) {
        // TODO: Sería conveniente logar  $e->getMessage()
        $_SESSION['login_error'] = "Error de BD";
    }
    
    // Si no han ocurrido errores durante el login
    if(!isset($_SESSION['login_error'])){
        // Redirigir a cada usuario a su web correspondiente
        switch ($_SESSION['tipo_de_usuario']){
            case 'admin':
                header('Location: admin/index.php');
                break;
            default:
                header('Location: user/index.php');
                break;
        }
    }
}

// Si llega aquí, es que no se estaba realizando el login, o que este ha fallado
// En caso de que hubiese errores, los mostramos y los borramos
if (isset($_SESSION['login_error'])){
    $smarty->assign('login_error', $_SESSION['login_error']);
    // Y borramos la variable
    unset($_SESSION['login_error']);
}

$smarty->display('login.html');