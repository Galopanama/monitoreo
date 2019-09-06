<?php

require_once __DIR__ . 'Prueba.php';
require_once __DIR__ . 'constantes.php'; 
require_once __DIR__ . '../lib/DB.php';
require_once __DIR__ . '/Excepciones.php';

class Pruebas {

    public static function getAllPruebas ($id_tecnologo = null, $id_subreceptor = null){ // VOY POR AQUI 
        $sql = "select * from " . Constantes::PRUEBA . " p ";   // usamos el alias "p" para la tabla pruebas
        if (!is_null($id_tecnologo)) {
            $sql .= " where p.id_tecnologo = ?";
        }
        else if (!is_null($id_subreceptor)) {                   // usamos el alias "t" para la tabla tecnologos
            $sql .= ", " . Constantes::TECNOLOGO . " t          
                where p.id_tecnologo = t.id_usuario
                and t.id_subreceptor = ? ";
        }
        // Vamos a ordenar las más nuevas primero
        $sql .= " order by p.fecha desc ";
        // Abrimos la conexion de la base de datos
        $db = new DB();
        // La siguiente llamada puede generar una excepción, que habrá que recoger en el método que la llame, o dejar que se propague
        $mysqli = $db->conecta();
        
                    
        // Creamos un array en el que guardaremos los usuarios
        $array_pruebas = array();
        if ($stmt = $mysqli->prepare($sql)) {
            
            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            if (!is_null($id_tecnologo)) {
                $stmt->bind_param('i', $id_tecnologo);
            }
            else if (!is_null($id_subreceptor)) {
                $stmt->bind_param('i', $id_subreceptor);
            }
            // Ejecutamos la sentencia con los valores ya establecidos
            $stmt->execute();
            if ($stmt->errno) {
                throw new Exception("Error de conexión con la BD");
            }
                                    
            // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
            $result = $stmt->get_result();
            // Le pedimos al objeto de resultados que nos devuelva una fila en forma de array asociativo
            while ($prueba = $result->fetch_array(MYSQLI_ASSOC)) {
                
                $date = new DateTime($prueba['fecha']);
                
                $array_pruebas[] = new Prueba( // AQUI NO ESTOY SEGURO DE QUE ESTE NOMBRE DE OBJETO SEA CORRECTO
                    $prueba['id_promotor'],
                    $prueba['id_persona_receptora'],
                    $date->format('d-m-Y'),
                    $prueba['consejeria_pre_prueba'],
                    $prueba['consejeria_post_prueba'],
                    $prueba['resultado_prueba'],
                    $prueba['realizacion_prueba']
                );
            }
            // limpiamos los resultados de la memoria
            $result->free();
            // por último desconectamos de la base de datos
            $stmt->close();
            $mysqli->close();
            // Devolvemos el array
            return $array_pruebas;
        }
        else {
            // por último desconectamos de la base de datos
            $mysqli->close();
            throw new Exception("Error de BD: " . $mysqli->error);
        }
    }

}

?>
