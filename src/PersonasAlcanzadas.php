<?php
/**
 * El fichero es parte del Controlador y tiene todas la funciones para manipular el objeto de PersonaAlcanzada
 * 
 * Todos los ficheros que se pueden necesitar estan en la sigueintes lineas
 */

require_once __DIR__ . '/PersonaAlcanzada.php';
require_once __DIR__ . '/PersonasReceptoras.php';
require_once __DIR__ . '/Prueba.php';
require_once __DIR__ . '/Pruebas.php';
require_once __DIR__ . '/constantes.php'; 
require_once __DIR__ . '/../lib/DB.php';
require_once __DIR__ . '/Excepciones.php';

class PersonasAlcanzadas {
    // Las constantes han sido declaradas a fin de ayudar con la introduccion de datos y las condiones que estos deben tener
    const regiones_de_salud_permitidas = array('Bocas_del_Toro','Chiriquí','Coclé','Colón','Herrera','Los_Santos','Panamá_Metro','Panamá_Oeste_1','Panamá_Oeste_2','San_Miguelito','Veraguas');
    const realizacion_prueba = array('no_se_realizó','se_realizó');
    const resultados_posibles = array('no_reactivo','reactivo');
    const FORMATO_FECHA_JAVASCRIPT = 'd/m/Y'; // Si el formato de fecha que se envía en el codigo javascript cambia, habría que modificar esta variable
    const FORMATO_FECHA_MYSQL = 'Y-m-d'; // https://code.i-harness.com/es/q/99ed8b (Para ver los timezone)

    // El parametro fecha debe ser una fecha en el formato YYYY-MM-DD

    /**
     * Esta funcion devuelve a las personas Alcanzadas segun el filtro de unos parametros que realizamos
     */
    public static function getPersonasAlcanzadasFiltradas ($filtros){ 

        // se emplean varios alias para realizar la peticion a la base de datos a fin de simplificar su escritura
        $sql = "select A.region_de_salud, P.poblacion, count(A.id_cedula_persona_receptora) as Total_de_Personas_Alcanzadas
                from " . Constantes::ALCANZADOS . " as A," . Constantes::PERSONA_RECEPTORA . " as P ";      

        $sql .= " where A.id_cedula_persona_receptora = P.id_cedula_persona_receptora ";                   
        
        // Filtramos por poblacion
        if (sizeof($filtros['poblacion']) >= 0) {
            $sql .= " and P.poblacion in ('" . implode("','", $filtros['poblacion']) . "')";
        }
        
        // Filtramos por Fechas 

        // Lo primero que haremos será validar las fechas
        if (($fecha_desde = DateTime::createFromFormat(PersonasAlcanzadas::FORMATO_FECHA_JAVASCRIPT, $filtros['fecha']['desde'])) 
            && ($fecha_hasta = DateTime::createFromFormat(PersonasAlcanzadas::FORMATO_FECHA_JAVASCRIPT, $filtros['fecha']['hasta'])) ){
            // Las fechas llegan y son válidas, por tanto las ponemos
            $sql .= " and (A.fecha_alcanzado BETWEEN '" . $fecha_desde->format(PersonasAlcanzadas::FORMATO_FECHA_MYSQL) . 
                "' AND '" . $fecha_hasta->format(PersonasAlcanzadas::FORMATO_FECHA_MYSQL) . "') ";
        }


        // Filtramos por Regiones de Salud
        if (sizeof($filtros['regiones']) > 0) {
            $sql .= "and A.region_de_salud in ('" . implode("','", $filtros['regiones']) . "')";
        }

        // ordenados por Poblaciones clave
        $sql .= " group by P.poblacion, A.region_de_salud ";

        // Abrimos la conexion de la base de datos
        $db = new DB();

        // La siguiente llamada puede generar una excepción
        $mysqli = $db->conecta();

        // Creamos un array en el que guardaremos las personas alcanzadas
        $array_PersonasAlcanzadas = array();
        
        if ($result = $mysqli->query($sql)) {

        // Le pedimos al objeto de resultados que nos devuelva una fila en forma de array asociativo
            $array_PersonasAlcanzadas = $result->fetch_all(MYSQLI_ASSOC);

        }
        else {
            // por último desconectamos de la base de datos
            $mysqli->close();
            throw new Exception("Error de BD: " . $mysqli->error);
        }
        // limpiamos los resultados de la memoria
        $result->free();

        // por último desconectamos de la base de datos
        $mysqli->close();

        // Devolvemos el array $array_PersonasAlcanzadas
        return $array_PersonasAlcanzadas;
    } 

};