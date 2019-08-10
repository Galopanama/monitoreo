<?php

require_once '../lib/DB.php';
require_once 'Usuario.php';
//TODO: cargar las clases de los distintos tipos de usuario existentes

class Usuarios {
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
}

class UsuarioNotFoundException extends Exception {}