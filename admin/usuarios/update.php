<?php
require_once '../../config/config_admin.php';
require_once __DIR__ . '/../../src/Usuarios.php';

// Cargamos los estilos necesarios para mostrar el desplegable
$header = $smarty->fetch("header/add_usuario.tpl");

if (!empty($_POST['id_usuario'])){
    // Se han enviado datos
    // Vamos a comprobar primero si el usuario existe
    try {
        $usuario = Usuarios::getUsuarioById($_POST['id_usuario']);
    }
    catch (UsuarioNotFoundException $e) {
        $_SESSION['error'] = "El id de usuario proporcionado no existe";
        header('Location: ' . _WEB_PATH_ . '/admin/usuarios/index.php');
        exit;
    }

    // El usuario existe
    $errores = array();

    // Vamos a cambiar los datos comunes
    $usuario->setNombre($_POST['nombre']);
    $usuario->setApellidos($_POST['apellidos']);
    $usuario->setTelefono($_POST['telefono']);

    // Si el password tiene valor, es que ha cambiado, por tanto vamos a comprobarlo
    // Vamos a comprobar si las contraseñas coinciden
    if (!empty($_POST['password'])){
        if ($_POST['password'] !== $_POST['password_confirm']) {
            $errores['password'] = "Las contraseñas no coinciden";
        }
        else {
            $usuario->setPassword($_POST['password']);
        }
    }

    // Vamos a cambiar los datos específicos
    // Como se especifica en el issue_25, solo se aceptan ciertos datos
    switch($usuario->getTipo_de_usuario()){
        case 'subreceptor':
            $usuario->setUbicacion($_POST['ubicacion']);
            break;
        case 'tecnologo':
            $usuario->setNumero_de_registro($_POST['numero_de_registro']);
            $usuario->setId_cedula($_POST['id_cedula']);
            break;
        case 'promotor':
            $usuario->setId_cedula($_POST['id_cedula']);
            $usuario->setOrganizacion($_POST['organizacion']);
            break;
    }

    if (empty($errores)) {
        try {
            Usuarios::update($usuario);
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
            $_SESSION['exito_titulo'] = "Usuario modificado con éxito";
            $_SESSION['exito_mensaje'] = "Los datos del usuario han sido modificados correctamente";
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

    // Los datos que están disabled no se enviarán, por lo que los recuperamos del usuario
    $smarty->assign('login', $usuario->getLogin());
    $smarty->assign('tipo_de_usuario', $usuario->getTipo_de_usuario());
}
else if (!empty($_GET['id_usuario'])) {
    // La página mostrará los datos actuales del usuario
    // Vamos a comprobar primero si el usuario existe
    try {
        $usuario = Usuarios::getUsuarioById($_GET['id_usuario']);
    }
    catch (UsuarioNotFoundException $e) {
        $_SESSION['error'] = "El id de usuario proporcionado no existe";
        header('Location: ' . _WEB_PATH_ . '/admin/usuarios/index.php');
        exit;
    }
    
    // Vamos a mostrar los datos necesarios
    $smarty->assign('id_usuario', $usuario->getId());
    $smarty->assign('login', $usuario->getLogin());
    $smarty->assign('nombre', $usuario->getNombre());
    $smarty->assign('apellidos', $usuario->getApellidos());
    $smarty->assign('telefono', $usuario->getTelefono());
    $smarty->assign('tipo_de_usuario', $usuario->getTipo_de_usuario());

    // Dependiendo del tipo de usuario, asignaremos los datos específicos
    switch($usuario->getTipo_de_usuario()){
        case 'subreceptor':
            $smarty->assign('ubicacion', $usuario->getUbicacion());
            break;
        case 'tecnologo':
            $smarty->assign('numero_de_registro', $usuario->getNumero_de_registro());
            $smarty->assign('id_cedula', $usuario->getId_cedula());
            break;
        case 'promotor':
            $smarty->assign('id_cedula', $usuario->getId_cedula());
            $smarty->assign('organizacion', $usuario->getOrganizacion());
            $smarty->assign('id_subreceptor', $usuario->getId_subreceptor());
            // En el caso del promotor, mostraremos además el nombre completo del subreceptor, con la ubicación, igual que la llamada ajax
            try {
                $subreceptor = Usuarios::getUsuarioById($usuario->getId_subreceptor());
                $smarty->assign('search_subreceptor', $subreceptor->getNombre() . ' ' . $subreceptor->getApellidos() . ' (' . $subreceptor->getUbicacion() . ')');
            }
            catch (UsuarioNotFoundException $e){
                // Si el código llega aquí, algo grave ha pasado, porque tiene asignado un subreceptor que no existe. 
                // Esto conlleva que alguien ha borrado ese registro manualmente
                $_SESSION['error_message'] = "El promotor " . $usuario->getId() . " tiene asignado como subreceptor al usuario con id " . $usuario->getId_subreceptor() .
                    " pero en el sistema no consta ningún usuario con ese ID. Esto se debe probablemente a un borrado manual en la base de datos";
            }
            break;
    }
}
else {
    $_SESSION['error'] = "No se ha especificado un id de usuario válido";
    header('Location: ' . _WEB_PATH_ . '/admin/usuarios/index.php');
    exit;
}

// El título de la página será Añadir usuario (la misma plantilla se utiliza para modificar)
$smarty->assign('titulo', 'Editar usuario');

// Necesitamos cargar un array con los tipos de usuario válidos. Dicho array está en la clase Usuarios
$smarty->assign('tipos_de_usuario', Usuarios::tipos_usuario_permitidos);

// La variable main se utilizará en el archivo footer.php
$main = $smarty->fetch("paginas/usuarios/add_update.tpl");

// Esta página necesita un javascript especial
$footer = $smarty->fetch("footer/add_usuario.tpl");
require_once '../../footer.php';

$smarty->display('esqueleto_dashboard.html');