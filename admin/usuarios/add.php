<?php
/**
 * With this file new user are created. So the administrator, who is the only user with this permision
 * will introduce all the data of the new user. This information will be sent to the database and 
 * it will be stored in the table Ususarios
 */
require_once __DIR__ . '/../../config/config.php';
// Restringimos el acceso sólo a usuarios administradores
// Restrict the access only to user with the profile adminitrator
$perfiles_aceptados = array('administrador');
require_once __DIR__ . '/../../security/autorizador.php';
// The information from all the user gets load
require_once __DIR__ . '/../../src/Usuarios.php';

// Cargamos los estilos necesarios para mostrar el desplegable
// The header of the page get load
$header = $smarty->fetch("header/add_usuario.tpl");

if (!empty($_POST['login'])) {
    // Se han enviado datos
    // Send the information 
    $errores = array();

    // Vamos a comprobar si las contraseñas coinciden
    // Check if the information introduced in the field passwords is the same as the one in the confirmation of the password
    if ($_POST['password'] !== $_POST['password_confirm']){
        $errores['password'] = "Las contraseñas no coinciden";
    }

    if (empty($errores)) {
        // Aunque en principio los nombres del formulario deberían de ser los mismos que los que espera la clase Usuarios, 
        // vamos a crear un array con dichas claves
        // If there are no errors so far, the page will send all the fields to the database. The fields are the attributes of the 
        // model usuario and some of them will vary depending on the user type
        $datos = [
            'login' => $_POST['login'],
            'nombre' => $_POST['nombre'],
            'apellidos' => $_POST['apellidos'],
            'telefono' => $_POST['telefono'],
            'password' => $_POST['password'],
            'tipo_de_usuario' => $_POST['tipo_de_usuario'],
            'ubicacion' => $_POST['ubicacion'],
            'id_cedula' => $_POST['id_cedula'],
            'id_subreceptor' => $_POST['id_subreceptor'],
            'organizacion' => $_POST['organizacion'],
            'numero_de_registro' => $_POST['numero_de_registro']
        ];
        try {
            Usuarios::add($datos);      // if all the data is correct, the request is send using the method add from the Class Usuarios
        }
        catch (ValidationException $e) {
            // Los mensajes de validación vienen como un array serializado en el mensaje de la excepción
            // If there are any errors in the Validation of the fields in the class Usuario, it will be catch by this method
            $errores = unserialize($e->getMessage());
        }
        catch (Exception $e) {
            $errores[] = $e->getMessage();  // any other error should be catch here and stored in the variable $errores
        }

        if (empty($errores)){
            // No ha habido errores, redirigimos a la página del listado
            // If there are no errors, a success message will be shown and the administrador will be redirected to the page 
            // where all the usuarios are listed
            $_SESSION['exito_titulo'] = "Usuario creado con éxito";
            $_SESSION['exito_mensaje'] = "El usuario ha sido dado de alta correctamente en el sistema";
            header('Location: ' . _WEB_PATH_ . '/admin/usuarios/index.php');
            exit;
        }
    }

    // Asignamos los errores si los hubiera (que si el código ha llegado aquí, los hay)
    // the errors stored in the variable $errores will be assigned to the fields 
    $smarty->assign('errores', $errores);

    // Además, cargamos los datos que el usuario ya haya escrito
    // And in this line the errors will be shown as empty fields will the fields that have the information correctly filled will be 
    // showing the information as has been entered by the user
    foreach (array_keys($_POST) as $elem) {
        $smarty->assign($elem, $_POST[$elem]);
    }
}

// El título de la página será Añadir usuario
// The name of the page is Añadir usuario
$smarty->assign('titulo', 'Añadir nuevo usuario');

// Necesitamos cargar un array con los tipos de usuario válidos. Dicho array está en la clase Usuarios
// We load the usuarios permitidos from the class Usuarios
$smarty->assign('tipos_de_usuario', Usuarios::tipos_usuario_permitidos);

// La variable main se utilizará en el archivo footer.php
// the main body of the page gets load from here 
$main = $smarty->fetch("paginas/usuarios/add_update.tpl");

// Esta página necesita un javascript especial
// A special javascript get load here
$footer = $smarty->fetch("footer/add_usuario.tpl");
require_once '../../footer.php';

$smarty->display('esqueleto_dashboard.html');