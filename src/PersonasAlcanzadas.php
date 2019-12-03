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

class PersonasReceptoras {
// Some constants have been declared in order to help the user to fill information correctly as well as to enforce certain conditions
    const regiones_de_salud_permitidas = array('Bocas_del_Toro','Chiriquí','Coclé','Colón','Herrera','Los_Santos','Panamá_Metro','Panamá_Oeste_1','Panamá_Oeste_2','San_Miguelito','Veraguas');
    const realizacion_prueba = array('no_se_realizó','se_realizó');
    const resultados_posibles = array('no_reactivo','reactivo');


    // El parametro fecha debe ser una fecha en el formato YYYY-MM-DD
    // the parameter fecha must be in the format YYYY-MM-DD

    // The function request the database 
    public static function getPersonasAlcanzadasByPoblacion (){  // No se que hacer con el parametro del id_subrecpetor

        $sql = "select count(A.id_cedula_persona_receptora) as Total_de_Personas_Alcanzadas, P.poblacion
                from " . Constantes::ALCANZADOS . "as A," . Constantes::PERSONA_RECEPTORA . "as P ";      // As there is a view created with that purpose 

        $sql .= " where A.id_cedula_persona_receptora = P.id_cedula_persona_receptora ";                   
    
        
        // Vamos a ordenar las más nuevas primero
        // The interviews gets ordered starting from the latest
        $sql .= " group by P.poblacion ";

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
            while ($poblacion = $result->fetch_all(MYSQLI_ASSOC)) {

                $array_PersonasAlcanzadas[] = $poblacion;
            }
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
        return $array_PersonasAlcanzadas;
    } 
 
    public static function getPersonasAlcanzadasByDate ($desde, $hasta = "now()"){

        $sql = " SELECT count(P.id_cedula_persona_receptora), P.poblacion
        FROM " . Constantes::ALCANZADOS . "as A," . Constantes::PERSONA_RECEPTORA . "as P ";      // As there is a view created with that purpose 

        // Se le especifica la condicion de que el id_cedula_persona_receptora debe estar en las dos tablas 
        $sql .= " WHERE A.id_cedula_persona_receptora = P.id_cedula_persona_receptora ";                   


        // Tambien que las fechas deberan estar entre los parametros que vamos a pasarle y se especifica que estara agrupado por poblacion
        // Time to pass the values of the dates as well as specify that the result will be group by poblacion
        $sql .= " AND A.fecha BETWEEN ? and ?, GROUP BY poblacion";

        // Abrimos la conexion de la base de datos
        // The connection to the database is open
        $db = new DB();

        // La siguiente llamada puede generar una excepción
        // The sentence gets prepared in the variable $mysqli
        $mysqli = $db->conecta();

        // Creamos un array donde vamos a guardar los resultados obtenidos. Mas adelantes e definen los campos que devuelve. 
        // We create an array where to store the results from the query further belong the fields are defined.
        $array_ByDate = array();

        // Preparaos la sentencia dentro de la variable $stmt
        // The sentence gets prepared in the variable $stmt
        if ($stmt = $mysqli->prepare($sql)) {

            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            // The parameter are associated to the attriute listed as well as the datatype is specified
            $stmt->bind_param('ss', $desde, $hasta);    

            // Ejecutamos la sentencia con los valores ya establecidos
            // The sentence get executed
            $stmt->execute();

            if ($stmt->errno) {
                throw new Exception("Error de conexión con la BD");
            }

            // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
            // Once requested the sentece, we would be able to manipulate the information in the object called $result
            $result = $stmt->get_result();

            while($segunFecha = $result->fetch_all(MYSQLI_ASSOC)) {
                
                $array_ByDate[] = $segunFecha;
            };

            // limpiamos los resultados de la memoria
            // The results from the memory gets deleted
            $result->free();
            // por último desconectamos de la base de datos
            // The connection with the database is closed
            $stmt->close();
            $mysqli->close();

            // Devolvemos el array                              // Aqui un return cuando en la linea 148 al 153... ya esta un while??
            // We return a array of entrevistas
            return $array_ByDate;
        }
        else {
            // por último desconectamos de la base de datos
            // The connection with the database is close and an error messaeg return to the user
            $mysqli->close();
            throw new Exception("Error de BD: " . $mysqli->error);
        }
}

    public static function getAlcanzadosByRegionDeSalud (){

        $sql = " SELECT count(P.id_cedula_persona_receptora), P.poblacion, A.region_de_salud
        FROM " . Constantes::ALCANZADOS . "as A," . Constantes::PERSONA_RECEPTORA . "as P ";    

        // Se le especifica la condicion de que el id_cedula_persona_receptora debe estar en las dos tablas 
        // The first condition is that id_cedula_persona_receptora have to be in both tables
        $sql .= " WHERE A.id_cedula_persona_receptora = P.id_cedula_persona_receptora ";                   


        // Tambien que las fechas deberan estar entre los parametros que vamos a pasarle y se especifica que estara agrupado por poblacion
        // Time to pass the values of the dates as well as specify that the result will be group by poblacion
        $sql .= " GROUP BY region_de_salud ";

        // Abrimos la conexion de la base de datos
        // The connection to the database is open
        $db = new DB();

        // La siguiente llamada puede generar una excepción
        // The sentence gets prepared in the variable $mysqli
        $mysqli = $db->conecta();



        // Y SI RESULTA QUE DESDE AQUI EN ADELANTE NO HACE FALTA CASI NADA??



        // Creamos un array donde vamos a guardar los resultados obtenidos. Mas adelantes e definen los campos que devuelve. 
        // We create an array where to store the results from the query further belong the fields are defined.
        $array_ByRegion_de_Salud = array("Personas_Alcanzadas","Poblacion");

        // Preparaos la sentencia dentro de la variable $stmt
        // The sentence gets prepared in the variable $stmt
        if ($stmt = $mysqli->prepare($sql)) {

            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            // The parameter are associated to the attriute listed as well as the datatype is specified
            $stmt->bind_param('ii', $desde, $hasta = now());    // deafult value para el tiempo es now()... hace falta consultar si es posible declararlo asi.

            // Ejecutamos la sentencia con los valores ya establecidos
            // The sentence get executed
            $stmt->execute();

            if ($stmt->errno) {
                throw new Exception("Error de conexión con la BD");
            }

            // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
            // Once requested the sentece, we would be able to manipulate the information in the object called $result
            $result = $stmt->get_result();

            while($array_ByDate = $result->fetch_all(MYSQLI_ASSOC)) {
                
                $array_ByDate[] = (
                    Personas_Alcanzadas('id_cedula_persona_receptora'), 
                    Poblacion('poblacion'),
                ); 
            };

            // limpiamos los resultados de la memoria
            // The results from the memory gets deleted
            $result->free();
            // por último desconectamos de la base de datos
            // The connection with the database is closed
            $stmt->close();
            $mysqli->close();

            // Devolvemos el array                              // Aqui un return cuando en la linea 148 al 153... ya esta un while??
            // We return a array of entrevistas
            return $array_ByDate;
        }

        else {
            // por último desconectamos de la base de datos
            // The connection with the database is close and an error messaeg return to the user
            $mysqli->close();
            throw new Exception("Error de BD: " . $mysqli->error);
        }
    }

    public static function getAllAlcanzados ($id_promotor, $id_cedula_persona_receptora, $fecha){

        

        else {
            // por último desconectamos de la base de datos
            // The connection with the database is close and an error messaeg return to the user
            $mysqli->close();
            throw new Exception("Error de BD: " . $mysqli->error);
        }
    }


/** public static function getAlcanzadosByPruebaRealizada ($id_promotor, $id_cedula_persona_receptora, $fecha)
 * 
 *  public static function getAlcanzadosByPromotor ($id_promotor, $id_cedula_persona_receptora, $fecha)
 * 
 * 
*/

}