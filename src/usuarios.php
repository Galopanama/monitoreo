<?php

require_once __DIR__ . '/../lib/DB.php';
require_once __DIR__ . '/Usuario.php';
//TODO: cargar las clases de los distintos tipos de usuario existentes

class Usuarios {

    const MIN_TAM_LOGIN = 8;
    const MAX_TAM_LOGIN = 16;
    const MIN_TAM_PASSWORD = 8;
    const MAX_TAM_PASSWORD = 16;
    const tipos_usuario_permitidos = array('administrador', 'subreceptor', 'promotor', 'tecnologo');

    public static function getUsuarioByUsername($username = '', $activo = true) {
        // Escribimos la consulta básica para prepararla
        $sql = "select * from usuario where login = ? ";

        if ($activo) {
            $sql .= " AND estado = 'activo' ";
        }

        // Abrimos la conexion de la base de datos
        $db = new DB();
        try {
            $mysqli = $db->conecta();
        }
        catch (Exception $e) {
            // Si se produce un error al conectar con la base de datos, no tenemos otra que enviar a una página de error genérico
            $_SESSION["error_message"] = $e->getMessage();
            header('Location: ' . _WEB_PATH_ . '/error.php');
            exit;
        }
                    
        // Preparaos la sentencia anterior
        if ($stmt = $mysqli->prepare($sql)) {
            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            $stmt->bind_param('s', $username);

            // Ejecutamos la sentencia con los valores ya establecidos
            $stmt->execute();

            if ($stmt->errno) {
                throw new Exception("Error de conexión con la BD");
            }

            /*
            if($stmt->num_rows !== 1) {
                // La consulta ha devuelto 0 ó más de 1 resultado, por tanto el login introducido no era correcto o existe un problema con el usuario
                throw new UsuarioNotFoundException("El usuario con username $username no existe");
            }
            */
                        
            // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
            $result = $stmt->get_result();

            // Le pedimos al objeto de resultados que nos devuelva una fila (en este caso la unica) en forma de array asociativo
            $usuarios = $result->fetch_all(MYSQLI_ASSOC);
            
            // Cerramos la conexión
            $stmt->close();
            $db->desconecta();
            
            if(sizeof($usuarios) !== 1) {
                // La consulta ha devuelto 0 ó más de 1 resultado, por tanto el login introducido no era correcto o existe un problema con el usuario
                throw new UsuarioNotFoundException("El usuario con username $username no existe");
            }

            // Puesto que esta consulta sólo ha devuelto 1 usuario, obtenemos los datos de la primera posición del array
            $usuario = $usuarios[0];
            return new Usuario(
                $usuario['id_usuario'],
                $usuario['login'],
                $usuario['nombre'],
                $usuario['apellidos'],
                $usuario['tipo_de_usuario'],
                $usuario['telefono'],
                $usuario['password']
            );        
        }
        else {
            throw new Exception("Error de BD: " . $mysqli->error);
        }
    }

    public static function getAll($show_password = false, $activo = true) {
        // Escribimos la consulta básica para prepararla
        $sql = "select * from usuario ";

        if ($activo) {
            $sql .= " WHERE estado = 'activo' ";
        }

        // Abrimos la conexion de la base de datos
        $db = new DB();
        try {
            $mysqli = $db->conecta();
        }
        catch (Exception $e) {
            // Si se produce un error al conectar con la base de datos, no tenemos otra que enviar a una página de error genérico
            $_SESSION["error_message"] = $e->getMessage();
            header('Location: ' . _WEB_PATH_ . '/error.php');
            exit;
        }
                    
        // Creamos un array en el que guardaremos los usuarios
        $array_usuarios = array();

        if ($result = $mysqli->query($sql)) {
            
            // Le pedimos al objeto de resultados que nos devuelva una fila (en este caso la unica) en forma de array asociativo
            while ($usuario = $result->fetch_assoc()) {
                $array_usuarios[] = new Usuario(
                    $usuario['id_usuario'],
                    $usuario['login'],
                    $usuario['nombre'],
                    $usuario['apellidos'],
                    $usuario['tipo_de_usuario'],
                    $usuario['telefono'],
                    // Si no queremos mostrar el password, mandaremos una cadena vacía
                    $show_password?$usuario['password']:''
                );
            }

            // limpiamos los resultados de la memoria
            $result->free();
            // por último desconectamos de la base de datos
            $db->desconecta();

            // Devolvemos el array
            return $array_usuarios;
        }
        else {
            $db->desconecta();
            throw new Exception("Error de BD: " . $mysqli->error);
        }
    }

    public static function add($datos){
        // Vamos a comprobar primero que no existe un usuario con el login que se ha escrito
        try{
            Usuarios::getUsuarioByUsername($datos['login']);
            // Si el código ha llegado aquí, el usuario ya existía, ya que no ha entrado en el catch de la excepción
            // Lanzamos una nueva excepción indicando que el usuario existe
            throw new ValidationException(serialize(array("El login introducido ya existe")));
        }
        catch (UsuarioNotFoundException $e) {
            // El usuario no existe, por tanto, podemos crearlo
            // Escribimos la consulta básica para prepararla
            $sql = "insert into usuario (login, nombre, apellidos, tipo_de_usuario, estado, telefono, password, salt) 
                    values (?, ?, ?, ?, ?, ?, ?, '') "; // Salt ya no se utiliza, por lo que por ahora insertamos un espacio vacío

            // Abrimos la conexion de la base de datos
            $db = new DB();

            // No controlamos la excepción a propósito, ya que al ser una llamada ajax, si mandamos a una página de error el usuario no notará nada
            // Controlaremos la excepción en el php encargado de responder al ajax
            $mysqli = $db->conecta();

            // TODO: Realizar comprobaciones sobre los datos introducidos. Por ejemplo:
            // Campos vacíos
            // El password tiene longitud adecuada

            // Errores será un array donde se guardarán los errores de validación del formulario, para después poder mostrarlas al usuario
            $errores = array();

            if (strlen($datos['login']) < Usuarios::MIN_TAM_LOGIN || strlen($datos['login']) > Usuarios::MAX_TAM_LOGIN) {
                $errores[] = "Tamaño del campo login incorrecto. Debe ser entre " . Usuarios::MIN_TAM_LOGIN . ' y ' . Usuarios::MAX_TAM_LOGIN . ' caracteres.';
            }

            if (strlen($datos['password']) < Usuarios::MIN_TAM_PASSWORD || strlen($datos['password']) > Usuarios::MAX_TAM_PASSWORD) {
                $errores[] = "Tamaño del campo password incorrecto. Debe ser entre " . Usuarios::MIN_TAM_PASSWORD . ' y ' . Usuarios::MAX_TAM_PASSWORD . ' caracteres.';
            }

            if (!in_array($datos['tipo_de_usuario'], Usuarios::tipos_usuario_permitidos)){
                $errores[] = "El tipo de usuario debe ser uno de los permitidos";
            }

            // Ya hemos llegado al final de las validaciones. Si el array no está vacío, significa que han ocurrido errores, por tanto, lanzamos una excepción
            if (sizeof($errores) > 0){
                throw new ValidationException (serialize($errores));
            }
                        
            // Preparaos la sentencia anterior
            $activo = 'activo'; // En la preparación de sentencias se necesitan variables, no podemos escribir la palabra directamente
            if ($stmt = $mysqli->prepare($sql)) {
                //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
                $stmt->bind_param('sssssss', 
                    $datos['login'],
                    $datos['nombre'],
                    $datos['apellidos'],
                    $datos['tipo_de_usuario'],
                    $activo, 
                    $datos['telefono'],
                    password_hash($datos['password'],  PASSWORD_DEFAULT)
                );

                // Ejecutamos la sentencia con los valores ya establecidos
                if(!$stmt->execute()){
                    throw new Exception("Ocurrió un problema al introducir el usuario: " . $stmt->error);
                }
                
                // Cerramos la conexión
                $stmt->close();
                $db->desconecta();
                        
            }
            else {
                throw new Exception("Error de BD: " . $mysqli->error);
            }
        }
    }
}

class UsuarioNotFoundException extends Exception {}
class UsuarioAlreadyExistsException extends Exception {}
class ValidationException extends Exception {}