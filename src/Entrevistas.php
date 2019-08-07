<?php

require_once 'Entrevista.php';
require_once 'EntrevistaIndividual.php';
require_once 'EntrevistaGrupal.php';
require_once 'Constantes.php'; // retocar las constantes y cambiarlas por los nombres de las variables privadas??
require_once '../lib/DB.php';


class Entrevistas {

    private $nombre_tabla_ent_grup = "promotor_realiza_actividad_grupal_con_personal_receptoras";    
    private $nombre_tabla_ent_ind = "promotor_realiza_entrevista_individual";
    private $nombre_tabla_subreceptor = "subreceptor";
    private $nombre_tabla_promotor = "promotor"; // se puede guardar todo en una fichero de configuracion
                                                // y las variables quedan juntas. Añadir un require_once para importarlo

    public static function getEntrevistaIndividual ($id_promotor, $id_persona_receptora, $fecha){
        $sql = "SELECT * FROM $nombre_tabla_ent_ind ";

        if ($_SESSION["tipo_de_usuario"] === "subreceptor") {
            $sql .= ", $nombre_tabla_promotor "; 
        }

        $sql .= "WHERE id_promotor = ? and " .
                "id_persona_receptora = ? and " .
                "fecha = ? ";

        if ($_SESSION["tipo_de_usuario"] === "promotor") {
            $sql .= "AND id_promotor = " . $_SESSION["id_usuario"] . " ";
        }
        else if ($_SESSION["tipo_de_usuario"] === "subreceptor") {
            $sql .= " AND $nombre_tabla_promotor.id_usuario = $nombre_tabla_ent_ind.id_promotor
                    AND id_subreceptor = " . $_SESSION["id_usuario"] . " ";
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
        $individual = $result->fetch_array(MYSQL_ASSOC); 
        
        // Creamos el objeto con los valores que hemos obtenido de la base de datos ordenados segun requiere el constructor de EntrevistaIndividual
        return new EntrevisaIndividual($individual['id_promotor'], $inndividual['id_persona_receptora'], $individual['fecha'], 
        $individual['condones_entregados'], $individual['lubricantes_entregados'], $individual['materiales_educativos_entregados'], 
        $individual['uso_del_condon'], $individual['uso_de_alcohol_y_drogas_ilicitas'], $individual['informacion_clam'], 
        $individual['referencia_a_pruebas_de_vih'], $individual['referencia_a_clinica_tb']);
    }

    public static function getEntrevistaGrupal($id_promotor, $id_persona_receptora, $fecha){
        $sql = "SELECT * FROM $nombre_tabla_ent_grup ";
    
        if ($_SESSION["tipo_de_usuario"] === "subreceptor") {
            $sql .= ", $nombre_tabla_promotor ";
        }

        $sql .= "WHERE id_promotor = ? and " .
                "id_persona_receptora = ? and " .
                "fecha = ? ";

        if ($_SESSION["tipo_de_usuario"] === "promotor") {
            $sql .= "AND id_promotor = " . $_SESSION["id_usuario"] . " ";
        }
        else if ($_SESSION["tipo_de_usuario"] === "subreceptor") {
            $sql .= " AND $nombre_tabla_promotor.id_usuario = $nombre_tabla_ent_grup.id_promotor
                    AND id_subreceptor = " . $_SESSION["id_usuario"] . " ";
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
        $grupal = $result->fetch_array(MYSQL_ASSOC); 
                            
        // Creamos el objeto con los valores que hemos obtenido de la base de datos ordenados segun requiere el constructor de EntrevistaGrupal
        return new EntrevisaGrupal($grupal['id_promotor'], $grupal['id_persona_receptora'], $grupal['fecha'], 
        $grupal['condones_entregados'], $grupal['lubricantes_entregados'], $grupal['materiales_educativos_entregados'], 
        $grupal['region_de_salud'], $grupal['area'], $grupal['estilos_de_autocuidado'], $grupal['ddhh_estigma_discriminacion'], 
        $grupal['uso_correcto_y_constantes_del_condon'], $grupal['salud_sexual_e_its'], $grupal['ofrecimiento_y_referencia_a_la_prueba_de_vih'], 
        $grupal['clam_y_otros_servicios'], $grupal['salud_anal'], $grupal['hormonizacion'], $grupal['apoyo_y_orientacion_psicologica'], 
        $grupal['diversidad_sexual_identidad_expresion_de_genero'], $grupal['tuberculosis_y_coinfecciones'],$grupal['infecciones_oportunistas']);
    }

    public static function getAll (){}

    public static function getCondones_entregados($condones_entregados) 
}


?>