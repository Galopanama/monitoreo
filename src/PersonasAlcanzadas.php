<?php
/**
 * The file is the controller that have all the functions that users can have to manipulate the object PersonaAlcanzada
 * All the files that can be required to help the manipulation have been added at the beginning 
 */

require_once __DIR__ . '/PersonaAlcanzada.php';
require_once __DIR__ . '/PersonasReceptoras.php';
require_once __DIR__ . '/Prueba.php';
require_once __DIR__ . '/Pruebas.php';
require_once __DIR__ . '/constantes.php'; 
require_once __DIR__ . '/../lib/DB.php';
require_once __DIR__ . '/Excepciones.php';

class PersonasAlcanzadas {
// Some constants have been declared in order to help the user to fill information correctly as well as to enforce certain conditions
    const regiones_de_salud_permitidas = array('Bocas_del_Toro','Chiriquí','Coclé','Colón','Herrera','Los_Santos','Panamá_Metro','Panamá_Oeste_1','Panamá_Oeste_2','San_Miguelito','Veraguas');
    const realizacion_prueba = array('no_se_realizó','se_realizó');
    const resultados_posibles = array('no_reactivo','reactivo');
    const FORMATO_FECHA_JAVASCRIPT = 'd/m/Y'; // Si el formato de fecha que se envía en el codigo javascript cambia, habría que modificar esta variable
    const FORMATO_FECHA_MYSQL = 'Y-m-d';

    // El parametro fecha debe ser una fecha en el formato YYYY-MM-DD
    // the parameter fecha must be in the format YYYY-MM-DD

    // The function request the database 
    public static function getPersonasAlcanzadasFiltradas ($filtros){ //porque aqui se llama filtros y en el JS se llama filtro??

        $sql = "select A.region_de_salud, count(A.id_cedula_persona_receptora) as Total_de_Personas_Alcanzadas
                from " . Constantes::ALCANZADOS . " as A," . Constantes::PERSONA_RECEPTORA . " as P ";      // As there is a view created with that purpose 

        $sql .= " where A.id_cedula_persona_receptora = P.id_cedula_persona_receptora ";                   
        
        // Filtramos por poblacion
        if (sizeof($filtros['poblacion']) >= 0) {
            $sql .= " and P.poblacion in ('" . implode("','", $filtros['poblacion']) . "')";
        }
        
        // // Fechas 
        // Lo primero que haremos será validar las fechas
        if (($fecha_desde = DateTime::createFromFormat(PersonasAlcanzadas::FORMATO_FECHA_JAVASCRIPT, $filtros['fecha']['desde'])) 
            && ($fecha_hasta = DateTime::createFromFormat(PersonasAlcanzadas::FORMATO_FECHA_JAVASCRIPT, $filtros['fecha']['hasta'])) ){
            // Las fechas llegan y son válidas, por tanto las ponemos
            $sql .= " and (A.fecha_alcanzado BETWEEN '" . $fecha_desde->format(PersonasAlcanzadas::FORMATO_FECHA_MYSQL) . 
                "' AND '" . $fecha_hasta->format(PersonasAlcanzadas::FORMATO_FECHA_MYSQL) . "') ";
        }


        // Regiones
        if (sizeof($filtros['regiones']) > 0) {
            $sql .= "and A.region_de_salud in ('" . implode("','", $filtros['regiones']) . "')";
        }

        // ordenados por poblaciones clave
        $sql .= " group by P.poblacion, A.region_de_salud ";

        // Abrimos la conexion de la base de datos
        // The connection to the database is open
        $db = new DB();

        // La siguiente llamada puede generar una excepción
        // The sentence gets prepared in the variable $mysqli
        $mysqli = $db->conecta();

        // Creamos un array en el que guardaremos las personas alcanzadas
        // The users get stored in an array
        $array_PersonasAlcanzadas = array();
        
        if ($result = $mysqli->query($sql)) {

        // Le pedimos al objeto de resultados que nos devuelva una fila en forma de array asociativo
        // We request the object to return the information in one line for each person
            $array_PersonasAlcanzadas = $result->fetch_all(MYSQLI_ASSOC);

        }
        else {
            // por último desconectamos de la base de datos
            // The connection with the database is close and an error messaeg return to the user
            $mysqli->close();
            throw new Exception("Error de BD: " . $mysqli->error);
        }
        // limpiamos los resultados de la memoria
        // The results from the memory gets deleted
        $result->free();
        // por último desconectamos de la base de datos
        // The connection with the database is closed
        $mysqli->close();

        // Devolvemos el array
        // We return a array of entrevistas
        //return $array_PersonasAlcanzadas;
        return $array_PersonasAlcanzadas;
    } 


//     public static function getPersonasAlcanzadasPorFecha ($desde, $hasta = "now()"){

//         $sql = " SELECT count(P.id_cedula_persona_receptora), P.poblacion
//         FROM " . Constantes::ALCANZADOS . "as A," . Constantes::PERSONA_RECEPTORA . "as P ";      // As there is a view created with that purpose 

//         // Se le especifica la condicion de que el id_cedula_persona_receptora debe estar en las dos tablas 
//         $sql .= " WHERE A.id_cedula_persona_receptora = P.id_cedula_persona_receptora ";                   


//         // Tambien que las fechas deberan estar entre los parametros que vamos a pasarle y se especifica que estara agrupado por poblacion
//         // Time to pass the values of the dates as well as specify that the result will be group by poblacion
//         $sql .= " AND A.fecha BETWEEN ? and ?, GROUP BY poblacion";

//         // Abrimos la conexion de la base de datos
//         // The connection to the database is open
//         $db = new DB();

//         // La siguiente llamada puede generar una excepción
//         // The sentence gets prepared in the variable $mysqli
//         $mysqli = $db->conecta();

//         // Creamos un array donde vamos a guardar los resultados obtenidos. Mas adelantes e definen los campos que devuelve. 
//         // We create an array where to store the results from the query further belong the fields are defined.
//         $array_ByDate = array();

//         // Preparaos la sentencia dentro de la variable $stmt
//         // The sentence gets prepared in the variable $stmt
//         if ($stmt = $mysqli->prepare($sql)) {

//             //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
//             // The parameter are associated to the attriute listed as well as the datatype is specified
//             $stmt->bind_param('ss', $desde, $hasta);    

//             // Ejecutamos la sentencia con los valores ya establecidos
//             // The sentence get executed
//             $stmt->execute();

//             if ($stmt->errno) {
//                 throw new Exception("Error de conexión con la BD");
//             }

//             // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
//             // Once requested the sentece, we would be able to manipulate the information in the object called $result
//             $result = $stmt->get_result();

//             while($segunFecha = $result->fetch_all(MYSQLI_ASSOC)) {
                
//                 $array_ByDate[] = $segunFecha;
//             };

//             // limpiamos los resultados de la memoria
//             // The results from the memory gets deleted
//             $result->free();
//             // por último desconectamos de la base de datos
//             // The connection with the database is closed
//             $stmt->close();
//             $mysqli->close();

//             // Devolvemos el array                              // Aqui un return cuando en la linea 148 al 153... ya esta un while??
//             // We return a array of entrevistas
//             return $array_ByDate;
//         }
//         else {
//             // por último desconectamos de la base de datos
//             // The connection with the database is close and an error messaeg return to the user
//             $mysqli->close();
//             throw new Exception("Error de BD: " . $mysqli->error);
//         }
// }

//     public static function getPersonasAlcanzadasPorRegionDeSalud ($seleccion){

//         $sql = " SELECT count(P.id_cedula_persona_receptora), P.poblacion, A.region_de_salud
//         FROM " . Constantes::ALCANZADOS . "as A," . Constantes::PERSONA_RECEPTORA . "as P ";    

//         // Se le especifica la condicion de que el id_cedula_persona_receptora debe estar en las dos tablas 
//         // The first condition is that id_cedula_persona_receptora have to be in both tables
//         $sql .= " WHERE A.id_cedula_persona_receptora = P.id_cedula_persona_receptora ";                   


//         // Tambien que las fechas deberan estar entre los parametros que vamos a pasarle y se especifica que estara agrupado por poblacion
//         // Time to pass the values of the dates as well as specify that the result will be group by poblacion
//         $sql .= " GROUP BY region_de_salud ";

//         // Abrimos la conexion de la base de datos
//         // The connection to the database is open
//         $db = new DB();

//         // La siguiente llamada puede generar una excepción
//         // The sentence gets prepared in the variable $mysqli
//         $mysqli = $db->conecta();

//         // Creamos un array en el que guardaremos las personas alcanzadas
//         // The users get stored in an array
//         $array_PersonasAlcanzadasPorRegionDeSalud = array("Personas_Alcanzadas","Poblacion","region_de_salud"); // pongo el nombre de los campos que tendra el array
        

//         if ($result = $mysqli->query($sql)) {

//         // Le pedimos al objeto de resultados que nos devuelva una fila en forma de array asociativo
//         // We request the object to return the information in one line for each person
//             while ($region_de_salud = $result->fetch_all(MYSQLI_ASSOC)) {

//                 $array_PersonasAlcanzadasPorRegionDeSalud[] = $region_de_salud;
//             }
//         }
//         else {
//             // por último desconectamos de la base de datos
//             // The connection with the database is close and an error messaeg return to the user
//             $mysqli->close();
//             throw new Exception("Error de BD: " . $mysqli->error);
//         }
//         // limpiamos los resultados de la memoria
//         // The results from the memory gets deleted
//         $result->free();
//         // por último desconectamos de la base de datos
//         // The connection with the database is closed
//         $mysqli->close();

//         // Devolvemos el array
//         // We return a array of entrevistas
//         return $array_PersonasAlcanzadasPorRegionDeSalud;

//     }

//             // FALTA AJUSTAR LAS DOS FUNCIONES CON LOS PARAMETROS PROPIOS //
//     public static function getPersonasAlcanzadasFechaYRegionDeSalud (){
//     }    
//     public static function getAlcanzadosConPruebaRealizada($realizacion_prueba, $resultado_prueba){

//         $sql = " SELECT count(P.id_cedula_persona_receptora), P.region_de_salud, P.realizacion_prueba, P.resultado_prueba
//         FROM " . Constantes::ALCANZADOS . "as A," . Constantes::PRUEBA . "as P ";    

//         // Se le especifica la condicion de que el id_cedula_persona_receptora debe estar en las dos tablas 
//         // The first condition is that id_cedula_persona_receptora have to be in both tables
//         $sql .= " WHERE A.id_cedula_persona_receptora = P.id_cedula_persona_receptora ";                   


//         // Tambien que las fechas deberan estar entre los parametros que vamos a pasarle y se especifica que estara agrupado por poblacion
//         // Time to pass the values of the dates as well as specify that the result will be group by poblacion
//         $sql .= " GROUP BY region_de_salud ";

//         // Abrimos la conexion de la base de datos
//         // The connection to the database is open
//         $db = new DB();

//         // La siguiente llamada puede generar una excepción
//         // The sentence gets prepared in the variable $mysqli
//         $mysqli = $db->conecta();
//     }


};