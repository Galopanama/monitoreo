<?php
/**
 * The file is the controller that have all the functions that users can have to manipulate the object Entrevista
 * All the files that can be required to help the manipulation have been added at the beginning 
 */

require_once __DIR__ . '/Prueba.php';
require_once __DIR__ . '/constantes.php'; 
require_once __DIR__ . '/../lib/DB.php';
require_once __DIR__ . '/Excepciones.php';

class Pruebas {
// Some constants have been declared in order to help the user to fill infromation correctly as well as to enforce certain conditions
    const realizacion_prueba = array('no_se_realizó','se_realizó');
    const resultados_posibles = array('no_reactivo','reactivo');
    // The function return all the pruebas
    public static function getAllPruebas ($id_tecnologo = null, $id_subreceptor = null){  
        
        $sql = "select * from " . Constantes::PRUEBA . " p ";   // A query to the sql is declared in the variable sql. An aliase has been used    (usamos el alias "p" para la tabla pruebas)
        
        if (!is_null($id_tecnologo)) {                          // The id of tecnologo is required to enforce that s/he only access to the pruebas that s/he has load
            $sql .= " where p.id_tecnologo = ?";
        }
        else if (!is_null($id_subreceptor)) {                   // There is another aliase .t (usamos el alias "t" para la tabla tecnologos)
            $sql .= ", " . Constantes::TECNOLOGO . " t          
                where p.id_tecnologo = t.id_usuario
                and t.id_subreceptor = ? ";
        }
        // Vamos a ordenar las más nuevas primero
        // The latest are shown first
        $sql .= " order by p.fecha desc ";
        // Abrimos la conexion de la base de prueba$prueba
        // The connection with the object DB gets open
        $db = new DB();
        // La siguiente llamada puede generar una excepción, que habrá que recoger en el método que la llame, o dejar que se propague
        $mysqli = $db->conecta();
        
                    
        // Creamos un array en el que guardaremos los usuarios
        // the infromation from the user, gets stored in a array
        $array_pruebas = array();
        if ($stmt = $mysqli->prepare($sql)) {
            
            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            // the value of the tecnologo is asigned with the datatype that they are using the method bind_param
            if (!is_null($id_tecnologo)) {
                $stmt->bind_param('i', $id_tecnologo);
            }
            // the value of the subreceptor is asigned with the datatype that they are using the method bind_param
            else if (!is_null($id_subreceptor)) {
                $stmt->bind_param('i', $id_subreceptor);
            }
            // Ejecutamos la sentencia con los valores ya establecidos
            // The request gets process
            $stmt->execute();
            if ($stmt->errno) {
                throw new Exception("Error de conexión con la BD"); // if there is an error. the message is return to the user
            }
                                    
            // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
            // Once that the resquest is done, we get an object with the information. It is easier to manupulate
            $result = $stmt->get_result();
            // Le pedimos al objeto de resultados que nos devuelva una fila en forma de array asociativo
            // to display the results of the object, we ask to print them one in each line
            while ($prueba = $result->fetch_array(MYSQLI_ASSOC)) {
                
                $date = new DateTime($prueba['fecha']);
                
                $array_pruebas[] = new Prueba( 
                    $prueba['id_tecnologo'],
                    $prueba['id_cedula_persona_receptora'],
                    $date->format('d-m-Y'),
                    $prueba['consejeria_pre-prueba'],
                    $prueba['consejeria_post-prueba'],
                    $prueba['resultado_prueba'],
                    $prueba['realizacion_prueba']
                );
            }
            // limpiamos los resultados de la memoria
            // the values are deleted from the memory
            $result->free();
            // por último desconectamos de la base de prueba$prueba
            // We disconnect the connection from the database
            $stmt->close();
            $mysqli->close();
            // Devolvemos el array
            // the array gets return
            return $array_pruebas;
        }
        else {
            // por último desconectamos de la base de prueba$prueba
            // the database is disconnected
            $mysqli->close();
            throw new Exception("Error de BD: " . $mysqli->error);
        }
    }
    // the function add will be use to add new pruebas 
    public static function add($prueba, $db = null){
        
        // Si el objeto db no es nulo, estamos en una transacción
        // if the db object is not null, we are in a transaction
        $transaccion = !is_null($db);

        // Vamos a comprobar si este método forma parte de una transacción, para crear si no nuestro propio objeto de conexión a DB
        // If the variable transaction is empty, we create a new connection to the database
        if (!$transaccion){
            // Abrimos la conexion de la base de prueba$prueba
            // the connection is open
            $db = new DB();

            // Controlaremos la excepción en el php encargado de responder al ajax
            // if there is any problem with the connection it will be detected by the ajax
            $mysqli = $db->conecta();
        }
        else {
            $mysqli = $db->getConexion();
        }

        // Errores será un array donde se guardarán los errores de validación del formulario, para después poder mostrarlas al usuario
        // Es MUY IMPORTANTE que las claves del array sean los nombres de los campos que venían en el formulario, para poder informar al usuario
        // We store the errors in a variable in return it to the user associated to the attribute in which the information was not correct
        $errores = array();

        // Ya hemos llegado al final de las validaciones. Si el array no está vacío, significa que han ocurrido errores, por tanto, lanzamos una excepción
        // if there are no errors, the result of the comparartion should be equal to 0
        if (sizeof($errores) > 0){
            throw new ValidationException (serialize($errores)); // serialize stores the values that have an error and retunr if to the user with a message
        }

        $sql = "insert into " . Constantes::PRUEBA . " (id_tecnologo, id_cedula_persona_receptora, fecha, realizacion_prueba, `consejeria_pre-prueba`, `consejeria_post-prueba`, resultado_prueba) values (?, ?, now(), ?, ?, ?, ?)";
        // the query to add information to the table prueba gets prepared
        if ($stmt = $mysqli->prepare($sql)) {
            $fecha = "now()"; 
            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            // the information gets assigned to the name of the attributes of the class that are in the database and with the specification of their datatype
            $stmt->bind_param('issiis', 
                $prueba['id_tecnologo'],
                $prueba['id_cedula_persona_receptora'],
                $prueba['realizacion_prueba'],
                $prueba['consejeria_pre_prueba'],
                $prueba['consejeria_post_prueba'],
                $prueba['resultado_prueba']
                );


            // Ejecutamos la sentencia con los valores ya establecidos
            // The query to add the prueba gets executed
            if(!$stmt->execute()){
                throw new Exception("Ocurrió un problema al introducir la prueba: " . $stmt->error);// if there are any errors, a message will be retunred to the user
            }
            
            if ($transaccion) {
                // Si estamos en una transacción, hay que terminarla aquí
                // The transaction need to be close here
                $mysqli->commit();
            }

            $stmt->close();
            $mysqli->close();
        }
        else {
            throw new Exception("Error de BD: " . $mysqli->error);
        }
        
    }
}
    // this exception is unique of this class
    class PruebaNotFoundException extends Exception {}

?>
