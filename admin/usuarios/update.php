<?php
/**
 * Este fichero gestiona la actualizacion de Usuarios por parte de Administrador
 * Los metodos y funciones que se pueden ejecutar, ademas de los ficheros que se necesitan para su ejecución correcta 
 * 
 */
require_once __DIR__ . '/../../config/config.php';

// Restringimos el acceso sólo a usuarios administradores
$perfiles_aceptados = array('administrador');
require_once __DIR__ . '/../../security/autorizador.php';

// Desde este fichero cargamos toda la informacion de los usuarios
require_once __DIR__ . '/../../src/Usuario.php';



// Cargamos los estilos necesarios para mostrar el desplegable
$header = $smarty->fetch("header/add_usuario.tpl");

if (!empty($_POST['id_usuario'])){
    // Se comprueba primero si el usuario existe
    try {
        $usuario = Usuarios::getUsuarioById($_POST['id_usuario']);
    }
    catch (UsuarioNotFoundException $e) {
        // En caso de no existir, el Administrador queda redireccionado a la pagina donde esta la lista de Usuarios
        $_SESSION['error'] = "El id de usuario proporcionado no existe";
        header('Location: ' . _WEB_PATH_ . '/admin/usuarios/index.php');
        exit;
    }

    // Cuando el usuario existe
    $errores = array();

    // Vamos a cambiar los datos comunes Y lo que quiere el administrador es cambiar/actualizar algunos de los datos
    $usuario->setNombre($_POST['nombre']);
    $usuario->setApellidos($_POST['apellidos']);
    $usuario->setTelefono($_POST['telefono']);

    // Si en campo del password tiene se introduce un valor, este cambiará al nuevo valor.
    // Razon por la que se van a comprobar si las contraseñas coinciden
    if (!empty($_POST['password'])){
        if ($_POST['password'] !== $_POST['password_confirm']) {
            $errores['password'] = "Las contraseñas no coinciden";
        }
        else {
            $usuario->setPassword($_POST['password']);
        }
    }

    // Vamos a cambiar los datos específicos de cada tipo de Usuario
    switch($usuario->getTipo_de_usuario()){
        case 'subreceptor':
            $usuario->setUbicacion($_POST['ubicacion']);
            break;
        case 'tecnologo':
            $usuario->setNumero_de_registro($_POST['numero_de_registro']);
            break;
        case 'promotor':
            $usuario->setId_cedula($_POST['id_cedula']);
            $usuario->setOrganizacion($_POST['organizacion']);
            break;
    }

    if (empty($errores)) {
        try {
            Usuarios::update($usuario);
            // si en esta punto no se han encontrado errores, los cambios e introducen en la Base de datos
        }
        catch (ValidationException $e) {
            // Los mensajes de validación vienen un array serializado en el mensaje de la excepción
            // y mostraran si se ha introducido algun campo erroneo de informacion.
            $errores = unserialize($e->getMessage());
        }
        catch (Exception $e) {
            $errores[] = $e->getMessage();
        }

        if (empty($errores)){
            // No ha habido errores, redirigimos a la página del listado inicial de usuarios
            $_SESSION['exito_titulo'] = "Usuario modificado con éxito";
            $_SESSION['exito_mensaje'] = "Los datos del usuario han sido modificados correctamente";
            header('Location: ' . _WEB_PATH_ . '/admin/usuarios/index.php');
            exit;
        }
    }

    // Asignamos los errores si los hubiera (pues si el codgio llega aquí, los hay)
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
    try {
        $usuario = Usuarios::getUsuarioById($_GET['id_usuario']);
    }
    catch (UsuarioNotFoundException $e) {
        $_SESSION['error'] = "El id de usuario proporcionado no existe";
        header('Location: ' . _WEB_PATH_ . '/admin/usuarios/index.php');
        exit;
    }
    
    // Se muestran los datos necesarios
    $smarty->assign('id_usuario', $usuario->getId());
    $smarty->assign('login', $usuario->getLogin());
    $smarty->assign('nombre', $usuario->getNombre());
    $smarty->assign('apellidos', $usuario->getApellidos());
    $smarty->assign('telefono', $usuario->getTelefono());
    $smarty->assign('tipo_de_usuario', $usuario->getTipo_de_usuario());

    // Y como dependiendo del tipo de usuario, asignaremos los datos específicos
    // aqui se especifican los  artibutos que son de cada tipo.
    switch($usuario->getTipo_de_usuario()){
        case 'subreceptor':
            $smarty->assign('ubicacion', $usuario->getUbicacion());
            break;
        case 'tecnologo':
            $smarty->assign('numero_de_registro', $usuario->getNumero_de_registro());
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
                // Si el código llega aquí, algo grave ha pasado, porque tiene asignado un subreceptor que no existe. Esto conlleva que alguien ha borrado ese registro manualmente
                $_SESSION['error_message'] = "El promotor " . $usuario->getId() . " tiene asignado como subreceptor al usuario con id " . $usuario->getId_subreceptor() .
                    " pero en el sistema no consta ningún usuario con ese ID. Esto se debe probablemente a un borrado manual en la base de datos";
            }
            break;
    }
}
else {      
    // Si el id del usuario no esta escrito, se mostrará un mensaje para informar sobre tal anomalia
    $_SESSION['error'] = "No se ha especificado un id de usuario válido";
    header('Location: ' . _WEB_PATH_ . '/admin/usuarios/index.php');
    exit;
}


// La vista se carga desde los ficheros que vienen a continuacion

// El título de la página será Añadir usuario 
$smarty->assign('titulo', 'Editar usuario');

// Necesitamos cargar un array con los tipos de usuario válidos. Dicho array está en la clase Usuarios
$smarty->assign('tipos_de_usuario', Usuarios::tipos_usuario_permitidos);

// La variable main se utilizará en el archivo footer.php
$main = $smarty->fetch("paginas/usuarios/add_update.tpl");

// Esta página necesita un javascript especial
$footer = $smarty->fetch("footer/add_usuario.tpl");
require_once '../../footer.php';

$smarty->display('esqueleto_dashboard.html');