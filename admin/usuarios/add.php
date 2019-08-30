<?php
require_once __DIR__ . '/../../config/config.php';
// Restringimos el acceso sólo a usuarios administradores
$perfiles_aceptados = array('administrador');
require_once __DIR__ . '/../../security/autorizador.php';
require_once __DIR__ . '/../../src/Usuarios.php';

// Cargamos los estilos necesarios para mostrar el desplegable
$header = $smarty->fetch("header/add_usuario.tpl");

if (!empty($_POST['login'])) {
    // Se han enviado datos
    $errores = array();

    // Vamos a comprobar si las contraseñas coinciden
    if ($_POST['password'] !== $_POST['password_confirm']){
        $errores['password'] = "Las contraseñas no coinciden";
    }

    if (empty($errores)) {
        // Aunque en principio los nombres del formulario deberían de ser los mismos que los que espera la clase Usuarios, 
        // vamos a crear un array con dichas claves
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
            Usuarios::add($datos);
        }
        catch (ValidationException $e) {
            // Los mensajes de validación vienen como un array serializado en el mensaje de la excepción
            $errores = unserialize($e->getMessage());
        }
        catch (Exception $e) {
            $errores[] = $e->getMessage();
        }

        if (empty($errores)){
            // No ha habido errores, redirigimos a la página del listado
            $_SESSION['exito_titulo'] = "Usuario creado con éxito";
            $_SESSION['exito_mensaje'] = "El usuario ha sido dado de alta correctamente en el sistema";
            header('Location: ' . _WEB_PATH_ . '/admin/usuarios/index.php');
            exit;
        }
    }

    // Asignamos los errores si los hubiera (que si el código ha llegado aquí, los hay)
    $smarty->assign('errores', $errores);

    // Además, cargamos los datos que el usuario ya haya escrito
    foreach (array_keys($_POST) as $elem) {
        $smarty->assign($elem, $_POST[$elem]);
    }
}

// El título de la página será Añadir usuario (la misma plantilla se utiliza para modificar)
$smarty->assign('titulo', 'Añadir nuevo usuario');

// Necesitamos cargar un array con los tipos de usuario válidos. Dicho array está en la clase Usuarios
$smarty->assign('tipos_de_usuario', Usuarios::tipos_usuario_permitidos);

// La variable main se utilizará en el archivo footer.php
$main = $smarty->fetch("paginas/usuarios/add_update.tpl");

// Esta página necesita un javascript especial
$footer = $smarty->fetch("footer/add_usuario.tpl");
require_once '../../footer.php';

$smarty->display('esqueleto_dashboard.html');