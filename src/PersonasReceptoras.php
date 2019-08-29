<?php

require_once __DIR__ . '/constantes.php'; // retocar las constantes y cambiarlas por los nombres de las variables privadas??
require_once __DIR__ . '/../lib/DB.php';
require_once __DIR__ . '/PersonaReceptora.php';


class PersonasReceptoras {

    public static function getPersonaReceptora ($id_persona_receptora){
        $sql = "SELECT * FROM " . Constantes::PERSONA_RECEPTORA;

        $sql .= " WHERE id_cedula = ? ";

        // Abrimos la conexion de la base de datos
        $db = new DB();
        $mysqli = $db->conecta();

        // Preparaos la sentencia anterior
        if ($stmt = $mysqli->prepare($sql)) {

            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            $stmt->bind_param('i', $id_persona_receptora);

            // Ejecutamos la sentencia con los valores ya establecidos
            $stmt->execute();

            // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
            $result = $stmt->get_result();

            // Le pedimos al objeto de resultados que nos devuelva una fila (en este caso la unica) en forma de array asociativo
            $personas = $result->fetch_all(MYSQLI_ASSOC);

            // Cerramos la conexión
            $stmt->close();
                
            if(sizeof($personas) !== 1) {
                // La consulta ha devuelto 0 ó más de 1 resultado, por tanto el login introducido no era correcto o existe un problema con el usuario
                throw new PersonaReceptoraNotFoundException("La persona buscada no se encuentra");
            }

            // Puesto que esta consulta sólo ha devuelto 1 entrevista, obtenemos los datos de la primera posición del array
            $persona = $personas[0];
            
            // Creamos el objeto con los valores que hemos obtenido de la base de datos ordenados segun requiere el constructor de PersonaReceptora
            return new PersonaReceptora(
                $persona['id_cedula'],
                $persona['poblacion_originaria'],
                $persona['poblacion'],
                $persona['datos_actualizados']
            );
        }
        else {
            throw new Exception("Error de BD: " . $mysqli->error);
        }
    }
}

class PersonaReceptoraNotFoundException extends Exception {}