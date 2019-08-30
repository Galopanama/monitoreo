<?php

require_once __DIR__ . '/Entrevista.php';
require_once __DIR__ . '/EntrevistaIndividual.php';
//require_once __DIR__ . '/EntrevistaGrupal.php';
require_once __DIR__ . '/constantes.php'; // retocar las constantes y cambiarlas por los nombres de las variables privadas??
require_once __DIR__ . '/../lib/DB.php';


class Entrevistas {

    /**
     * @param fecha Debe ser una fecha en el formato YYYY-MM-DD
     */
    public static function getEntrevistaIndividual ($id_promotor, $id_persona_receptora, $fecha){
        $sql = "SELECT * FROM " . Constantes::INDIVIDUAL;

        if ($_SESSION["tipo_de_usuario"] === "subreceptor") {
            $sql .= ", " . Constantes::PROMOTOR; 
        }

        $sql .= " WHERE id_promotor = ? and " .
                "id_persona_receptora = ? and " .
                "fecha = ? ";

        if ($_SESSION["tipo_de_usuario"] === "promotor") {
            $sql .= " AND id_promotor = " . $_SESSION["id_usuario"] . " ";
        }
        else if ($_SESSION["tipo_de_usuario"] === "subreceptor") {
            $sql .= " AND " . Constantes::PROMOTOR . ".id_usuario = " . Constantes::INDIVIDUAL . ".id_promotor
                    AND id_subreceptor = " . $_SESSION["id_usuario"] . " ";
        }   

        // Abrimos la conexion de la base de datos
        $db = new DB();
        $mysqli = $db->conecta();

        // Preparaos la sentencia anterior
        if ($stmt = $mysqli->prepare($sql)) {

            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            $stmt->bind_param('iss', $id_promotor, $id_persona_receptora, $fecha);

            // Ejecutamos la sentencia con los valores ya establecidos
            $stmt->execute();

            // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
            $result = $stmt->get_result();

            // Le pedimos al objeto de resultados que nos devuelva una fila (en este caso la unica) en forma de array asociativo
            $individuales = $result->fetch_all(MYSQLI_ASSOC);

            // Cerramos la conexión
            $stmt->close();
                
            if(sizeof($individuales) !== 1) {
                // La consulta ha devuelto 0 ó más de 1 resultado, por tanto el login introducido no era correcto o existe un problema con el usuario
                throw new EntrevistaIndividualNotFoundException("La entrevista buscada no se encuentra");
            }

            // Puesto que esta consulta sólo ha devuelto 1 entrevista, obtenemos los datos de la primera posición del array
            $individual = $individuales[0];
            
            // Creamos el objeto con los valores que hemos obtenido de la base de datos ordenados segun requiere el constructor de EntrevistaIndividual
            return new EntrevistaIndividual(
                $individual['id_promotor'], 
                $individual['id_persona_receptora'], 
                $individual['fecha'], 
                $individual['condones_entregados'], 
                $individual['lubricantes_entregados'], 
                $individual['materiales_educativos_entregados'], 
                $individual['uso_del_condon'], 
                $individual['uso_de_alcohol_y_drogas_ilicitas'], 
                $individual['informacion_clam'], 
                $individual['referencia_a_pruebas_de_vih'], 
                $individual['referencia_a_clinica_tb']
            );
        }
        else {
            throw new Exception("Error de BD: " . $mysqli->error);
        }
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

    public static function getAllEntrevistasIndividuales ($id_promotor = null, $id_subreceptor = null){
        $sql = "select * from " . Constantes::INDIVIDUAL . " e ";

        if (!is_null($id_promotor)) {
            $sql .= " where e.id_promotor = ?";
        }
        else if (!is_null($id_subreceptor)) {
            $sql .= ", " . Constantes::PROMOTOR . " p 
                where e.id_promotor = p.id_usuario
                and p.id_subreceptor = ? ";
        }

        // Vamos a ordenar las más nuevas primero
        $sql .= " order by e.fecha desc ";

        // Abrimos la conexion de la base de datos
        $db = new DB();
        // La siguiente llamada puede generar una excepción, que habrá que recoger en el método que la llame, o dejar que se propague
        $mysqli = $db->conecta();
        
                    
        // Creamos un array en el que guardaremos los usuarios
        $array_entrevistas = array();

        if ($stmt = $mysqli->prepare($sql)) {
            
            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            if (!is_null($id_promotor)) {
                $stmt->bind_param('i', $id_promotor);
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
            while ($entrevista = $result->fetch_array(MYSQLI_ASSOC)) {
                
                $date = new DateTime($entrevista['fecha']);
                
                $array_entrevistas[] = new EntrevistaIndividual(
                    $entrevista['id_promotor'],
                    $entrevista['id_persona_receptora'],
                    $date->format('d-m-Y'),
                    $entrevista['condones_entregados'],
                    $entrevista['lubricantes_entregados'],
                    $entrevista['materiales_educativos_entregados'],
                    $entrevista['uso_del_condon'],
                    $entrevista['uso_de_alcohol_y_drogas_ilicitas'],
                    $entrevista['informacion_CLAM'],
                    $entrevista['referencia_a_prueba_de_VIH'],
                    $entrevista['referencia_a_clinica_TB']
                );
            }

            // limpiamos los resultados de la memoria
            $result->free();
            // por último desconectamos de la base de datos
            $stmt->close();
            $mysqli->close();

            // Devolvemos el array
            return $array_entrevistas;
        }
        else {
            // por último desconectamos de la base de datos
            $mysqli->close();
            throw new Exception("Error de BD: " . $mysqli->error);
        }
    }

    public static function getCondones_entregados($condones_entregados) {
        
    }
}

class EntrevistaIndividualNotFoundException extends Exception {}