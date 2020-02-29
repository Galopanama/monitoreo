<?php

/**
 * Este fichero comprueba el nombre de acceso y la contraseña (login y password) 
 * de cualquier persona que quiera acceder a FOMODI
 */

require_once '../config/config.php';


// Comprobacion de validez del nombre y contraseña para validar el accesso
if($_POST['username'] || $_POST['password']){
    
    // Se llama al fichero de usurios ya que se manipularán valores de esta tabla al navegar FOMODI
    require_once '../src/Usuarios.php';
    try {
        // Primero se comprueba que el nombre (login) del usuario sea valido
        $usuario = Usuarios::getUsuarioByUsername($_POST['username'], true, true);
        
        // Despues se comprueba la contraseña (password). En caso de validarse se asignan 
        // el id y el tipo de usuario a las variables de SESSION, que servirán para hacer 
        // cumplir las restricciones de acceso a datos
        if (password_verify($_POST["password"], $usuario->getPassword())) {                 
            $_SESSION['usuario_id'] = $usuario->getId();                                    
            $_SESSION['tipo_de_usuario'] = $usuario->getTipo_de_usuario();
        }
        else {
            // En caso contrario, simplemente se informa del login incorrecto y se deniega el acceso
            $_SESSION['login_error'] = "Login incorrecto";
        }
    }
    catch (UsuarioNotFoundException $e) {
        // Si el usuario no existe. No mostraremos más información por seguridad
        $_SESSION['login_error'] = "Login incorrecto";
    }
    catch (Exception $e) {
        // Si el error esta en la base de datos, se informa del origen del fallo al usuario
        $_SESSION['login_error'] = "Error de BD";
    }
    
    // Si no han ocurrido errores durante el login se redirige al usuario
    // en relacion a su tipo, a una pagina de inicio (index)
    if(!isset($_SESSION['login_error'])){
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
if (isset($_SESSION['login_error'])){
    $smarty->assign('login_error', $_SESSION['login_error']);
    // Y borramos la variable
    unset($_SESSION['login_error']);
}

$smarty->display('login.html');