<?php
/**
 * From this file the administrador will communicate with the server to update the infromation from the usuarios
 */
require_once __DIR__ . '/../../config/config.php';
// Restringimos el acceso sólo a usuarios administradores
// Restrict the access only to user with the profile adminitrator
$perfiles_aceptados = array('administrador');
require_once __DIR__ . '/../../security/autorizador.php';
// The information from all the user gets load
require_once __DIR__ . '/../../src/Usuarios.php';

// Cargamos los estilos necesarios para mostrar el desplegable
// The bottom to add users gets load from here 
$header = $smarty->fetch("header/add_usuario.tpl");

if (!empty($_POST['id_usuario'])){
    // Vamos a comprobar primero si el usuario existe
    // Chech if the user already exist by asking the class if the id already exist
    try {
        $usuario = Usuarios::getUsuarioById($_POST['id_usuario']);
    }
    catch (UsuarioNotFoundException $e) {
        // If the id does not exist the administrador gets redirected to the page with the list of all the users
        $_SESSION['error'] = "El id de usuario proporcionado no existe";
        header('Location: ' . _WEB_PATH_ . '/admin/usuarios/index.php');
        exit;
    }

    // El usuario existe
    // The variable errors capture all the errors and store them in a array 
    $errores = array();

    // Vamos a cambiar los datos comunes
    // The main fields of data get loaded
    $usuario->setNombre($_POST['nombre']);
    $usuario->setApellidos($_POST['apellidos']);
    $usuario->setTelefono($_POST['telefono']);

    // Si el password tiene valor, es que ha cambiado, por tanto vamos a comprobarlo
    // Vamos a comprobar si las contraseñas coinciden
    // If the password want to be changed, the new one gets compared with the one introduced in the field password confirm
    // If it is not the same, an error message will be generated and return to the administrador
    if (!empty($_POST['password'])){
        if ($_POST['password'] !== $_POST['password_confirm']) {
            $errores['password'] = "Las contraseñas no coinciden";
        }
        else {
            $usuario->setPassword($_POST['password']);
        }
    }

    // Vamos a cambiar los datos específicos
    // Here the specific fields of data will be modified. As each type of user has a different set of attributes, there are 
    // three different options depending on which type is. 
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
            // If there are no errors so far, we will update the data in the calling the method from the class Usuarios
        }
        catch (ValidationException $e) {
            // Los mensajes de validación vienen como un array serializado en el mensaje de la excepción
            // If there any errors will be catch here and return to the user to be fixed
            $errores = unserialize($e->getMessage());
        }
        catch (Exception $e) {
            $errores[] = $e->getMessage();
        }

        if (empty($errores)){
            // No ha habido errores, redirigimos a la página del listado
            // If there are no errors, the administrador will be redirected to the intial list with all the usuarios
            $_SESSION['exito_titulo'] = "Usuario modificado con éxito";
            $_SESSION['exito_mensaje'] = "Los datos del usuario han sido modificados correctamente";
            header('Location: ' . _WEB_PATH_ . '/admin/usuarios/index.php');
            exit;
        }
    }

    // Asignamos los errores si los hubiera (que si el código ha llegado aquí, los hay)
    // If there are any errors, they will be assigned here
    $smarty->assign('errores', $errores);

    // Además, cargamos los datos que el usuario ya haya escrito
    // The infroamtion that is correct will return and the one that is not, will be sent back with an empty field and a message
    foreach (array_keys($_POST) as $elem) {
        $smarty->assign($elem, $_POST[$elem]);
    }

    // Los datos que están disabled no se enviarán, por lo que los recuperamos del usuario
    // // There are certain field of information that are disable and and can't be altered
    $smarty->assign('login', $usuario->getLogin());
    $smarty->assign('tipo_de_usuario', $usuario->getTipo_de_usuario());
}
else if (!empty($_GET['id_usuario'])) {
    // La página mostrará los datos actuales del usuario
    // the information of the user will be display
    try {
        $usuario = Usuarios::getUsuarioById($_GET['id_usuario']);
    }
    catch (UsuarioNotFoundException $e) {
        $_SESSION['error'] = "El id de usuario proporcionado no existe";
        header('Location: ' . _WEB_PATH_ . '/admin/usuarios/index.php');
        exit;
    }
    
    // Vamos a mostrar los datos necesarios
    // The information about the user will be display in a list. So only certain field will be visible.
    $smarty->assign('id_usuario', $usuario->getId());
    $smarty->assign('login', $usuario->getLogin());
    $smarty->assign('nombre', $usuario->getNombre());
    $smarty->assign('apellidos', $usuario->getApellidos());
    $smarty->assign('telefono', $usuario->getTelefono());
    $smarty->assign('tipo_de_usuario', $usuario->getTipo_de_usuario());

    // Dependiendo del tipo de usuario, asignaremos los datos específicos
    // The specific attributes of the user will be specified here
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
            // If there user is a promotor, the name of the subreceptor and location will be shown too 
            try {
                $subreceptor = Usuarios::getUsuarioById($usuario->getId_subreceptor());
                $smarty->assign('search_subreceptor', $subreceptor->getNombre() . ' ' . $subreceptor->getApellidos() . ' (' . $subreceptor->getUbicacion() . ')');
            }
            catch (UsuarioNotFoundException $e){
                // Si el código llega aquí, algo grave ha pasado, porque tiene asignado un subreceptor que no existe. Esto conlleva que alguien ha borrado ese registro manualmente
                // If the code reach here means that someone has deleted the name of the user as it can't be found but there is an subreceptor that has been alocated to that id
                $_SESSION['error_message'] = "El promotor " . $usuario->getId() . " tiene asignado como subreceptor al usuario con id " . $usuario->getId_subreceptor() .
                    " pero en el sistema no consta ningún usuario con ese ID. Esto se debe probablemente a un borrado manual en la base de datos";
            }
            break;
    }
}
else {      // If the id of the user is not write the code will return and mesage to inform about it
    $_SESSION['error'] = "No se ha especificado un id de usuario válido";
    header('Location: ' . _WEB_PATH_ . '/admin/usuarios/index.php');
    exit;
}

// El título de la página será Añadir usuario 
// The template that is used get assigned here with the name 'Editar usuario'
$smarty->assign('titulo', 'Editar usuario');

// Necesitamos cargar un array con los tipos de usuario válidos. Dicho array está en la clase Usuarios
// An array with the types of users that are valid get loaded here
$smarty->assign('tipos_de_usuario', Usuarios::tipos_usuario_permitidos);

// La variable main se utilizará en el archivo footer.php
// The variabel main call the views from here
$main = $smarty->fetch("paginas/usuarios/add_update.tpl");

// Esta página necesita un javascript especial
// A special javascript gets load here
$footer = $smarty->fetch("footer/add_usuario.tpl");
require_once '../../footer.php';

$smarty->display('esqueleto_dashboard.html');