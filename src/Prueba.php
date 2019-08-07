<?php

require_once 'TecnologoRealizaPrueba.php';
require_once 'constantes.php';


class Prueba {

    private $registro_de_prueba = 'tecnologo_realiza_prueba_vih_a_persona_receptora';
    private $tecnologo = 'tecnologo';
    private $subrecptor = 'subreceptor';
    private $tec_colabora_sub ='tecnologo_colabora_con_subreceptor';

    public static function getResultadosDeLaPrueba ($tecnologo, $id_persona_receptora, $fecha){
        $sql = "SELECT * FROM $registro_de_prueba ";

        if ($_SESSION["tipo_de_usuario"] === "subreceptor") {
            $sql .= ", $tec_colabora_sub "; 
        }

        $sql .= "WHERE id_tecnologo = ? and " .
                "id_persona_receptora = ? and " .
                "fecha = ? ";

        if ($_SESSION["tipo_de_usuario"] === "tecnologo") {
            $sql .= "AND id_tecnologo = " . $_SESSION["id_usuario"] . " "; // Esta linea permite ver la info que genera un tecnologo
                                                                            // de manera persona_receptora.
        }
        else if ($_SESSION["tipo_de_usuario"] === "subreceptor") {
            $sql .= " AND $tec_colabora_sub.id_tecnologo = $registro_de_prueba.id_tecnologo
                    AND id_subreceptor = " . $_SESSION["id_usuario"] . " ";// mientras que esta rama permite acceder a la informacion
                                                                            // generada a partir de un unico subreceptor.
        }
    
        // Abrimos la conexion de la base de datos
        $db = new DB();
        $mysqli = $db->conecta();
    
        // Preparaos la sentencia anterior
        $mysqli->prepare($sql);
    
        //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
        $mysqli->bind_param('iss', $id_promotor, $id_persona_receptora, $fecha);
    
        // Ejecutamos la sentencia con los valores ya establecidos
        $mysqli->execute();
    
        // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
        $result = $mysqli->get_result();
    
        // Le pedimos al objeto de resultados que nos devuelva una fila (en este caso la unica) en forma de array asociativo
        $persona_receptora = $result->fetch_array(MYSQL_ASSOC); 
            
        // Creamos el objeto con los valores que hemos obtenido de la base de datos ordenados segun requiere el constructor de EntrevistaIndividual
        return new Prueba($persona_receptora['id_tecnologo'], $inndividual['id_cedula_persona_receptora'], $persona_receptora['fecha'], 
        $persona_receptora['consejeria_pre_prueba'], $persona_receptora['consejeria_post_prueba'], $persona_receptora['resultado_prueba'], 
        $persona_receptora['realizacion_prueba']);

    }
}

?>