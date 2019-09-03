<?php

// Para mi que este fichero no es necesario... Ya que tenemos una prueba individual en el fichero PruebaDelTecnologo.php 

require_once 'TecnologoRealizaPrueba.php';
require_once 'constantes.php';
require_once '../lib/DB.php';


class Prueba {

    public static function getResultadoUnaPrueba ($tecnologo, $id_persona_receptora, $fecha){
        $sql = "SELECT * FROM " . Constantes::PRUEBA;

        if ($_SESSION["tipo_de_usuario"] === "administrador") {
            $sql .= ", ". Constantes::TECNOLOGO; 
        }

        $sql .= "WHERE id_tecnologo = ? and " .
                "id_persona_receptora = ? and " .
                "fecha = ? ";

        if ($_SESSION["tipo_de_usuario"] === "tecnologo") {
            $sql .= "AND " . Constantes::TECNOLOGO . $_SESSION["id_usuario"];   // Esta linea permite ver la info que genera un tecnologo
                                                                                // de manera persona_receptora.
        }
        else if ($_SESSION["tipo_de_usuario"] === "subreceptor") {
            $sql .= " AND " . Constantes::TECNOLOGO . " AND id_subreceptor = " . $_SESSION["id_usuario"];   // mientras que esta rama permite acceder a la informacion
                                                                                                            // generada a partir de un unico subreceptor.
        }
    
        // Abrimos la conexion de la base de datos
        $db = new DB();
        $mysqli = $db->conecta();
    
        // Preparaos la sentencia anterior
        $mysqli->prepare($sql);
    
        //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
        $mysqli->bind_param('iss', $id_tecnologo, $id_persona_receptora, $fecha);
    
        // Ejecutamos la sentencia con los valores ya establecidos
        $mysqli->execute();
    
        // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
        $result = $mysqli->get_result();
    
        // Le pedimos al objeto de resultados que nos devuelva una fila (en este caso la unica) en forma de array asociativo
        $persona_receptora = $result->fetch_array(MYSQL_ASSOC); 
            
        // Creamos el objeto con los valores que hemos obtenido de la base de datos ordenados segun requiere el constructor de persona_receptora
        return new Prueba($persona_receptora['id_tecnologo'], $persona_receptora['id_cedula_persona_receptora'], $persona_receptora['fecha'], 
        $persona_receptora['consejeria_pre_prueba'], $persona_receptora['consejeria_post_prueba'], $persona_receptora['resultado_prueba'], 
        $persona_receptora['realizacion_prueba']);

    }
}

?>
