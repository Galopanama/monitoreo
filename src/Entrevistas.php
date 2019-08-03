<?php

require_once 'Entrevista.php';
require_once '../lib/DB.php';

class Entrevistas {

    private $nombre_tabla_ent_ind = "promotor_realiza_entrevista_individual";

    public static function getEntrevistaIndividual ($id_promotor, $id_persona_receptora, $fecha){
        $sql = "select * from $nombre_tabla_ent_ind where " .
            "id_promotor = ? and " .
            "id_persona_receptora = ? and " .
            "fecha = ?";

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
        $a = $result->fetch_array(MYSQL_ASSOC);
        
        // Creamos el objeto con los valores que hemos obtenido de la base de datos ordenados segun requiere el constructor de EntrevistaIndividual
        return new EntrevisaIndividual($a['id_promotor'], $a[''])

        return Entrevista::get($id);
    }

    public static function getAll (){}

    public static function getCondones_entregados($condones_entregados) 
}


?>