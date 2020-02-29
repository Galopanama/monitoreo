<?php
/**
 * Este fichero es parte del Controlador. Alberga todas las funciones que los usuarios pueden realizar 
 * para manipular la informacion del objeto Prueba
 * Todos los ficheros necesarios han sido añadidos y pueden verse a continuación
 */

require_once __DIR__ . '/Prueba.php';
require_once __DIR__ . '/constantes.php'; 
require_once __DIR__ . '/../lib/DB.php';
require_once __DIR__ . '/Excepciones.php';

class Pruebas {

// Declaramos algunas constantes que van a hacer mas facil la insercion de datos haciendo cumplir las condiciones descritas
    const realizacion_prueba = array('no_se_realizó','se_realizó');
    const resultados_posibles = array('no_reactivo','reactivo');
    
    /**
     * La funcion devuelve todas la pruebas que estas registradas en la base de datos
     */
    public static function getAllPruebas ($id_tecnologo = null, $id_subreceptor = null){  
        
        $sql = "select * from " . Constantes::PRUEBA . " p ";   
        // comenzamos la peticion desde la variable $sql. Se utiliza un alia para la tabla de pruebas "p"
        if (!is_null($id_tecnologo)) { 
            // El id del tecnologo es necesario para asegurarse que solo se muestran las pruebas que el propio Tecnologo subió
            $sql .= " where p.id_tecnologo = ?";
        }
        else if (!is_null($id_subreceptor)) {                   
            // Hay otro alias para referirnos a la tabla de tecnologos "t"
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
            
            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno desde el metodo bind_param
            if (!is_null($id_tecnologo)) {
                $stmt->bind_param('i', $id_tecnologo);
            }
            // El valor del subreceptor se asigna tambien utilizando el mismo metodo bind_param
            else if (!is_null($id_subreceptor)) {
                $stmt->bind_param('i', $id_subreceptor);
            }
            // Ejecutamos la sentencia con los valores ya establecidos
            $stmt->execute();
            if ($stmt->errno) {
                throw new Exception("Error de conexión con la BD"); 
                // Si hubiera algun error con la base de datos, se develovería un mensaje en este momento
            }
                                    
            // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
            // Su manipulacion resulta mas facil y efectiva
            $result = $stmt->get_result();
            // Le pedimos al objeto de resultados que nos devuelva una fila en forma de array asociativo con los siguientes datos
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
            $result->free();

            // por último desconectamos de la base de prueba$prueba
            $stmt->close();
            $mysqli->close();

            // Devolvemos el array
            return $array_pruebas;
        }
        else {

            // por último desconectamos de la base de prueba$prueba
            $mysqli->close();

            throw new Exception("Error de BD: " . $mysqli->error);
        }
    }

    /**
     * La funcion actua añadiendo nuevas pruebas
     */
    public static function add($prueba, $db = null){
        
        // Si el objeto db no es nulo, estamos en una transacción
        $transaccion = !is_null($db);

        // Vamos a comprobar si este método forma parte de una transacción, para crear si no nuestro propio objeto de conexión a DB
        if (!$transaccion){

            // Abrimos la conexion de la base de prueba$prueba
            $db = new DB();

            // Controlaremos la excepción en el php encargado de responder al ajax
            $mysqli = $db->conecta();
        }
        else {
            $mysqli = $db->getConexion();
        }

        // Errores será un array donde se guardarán los errores de validación del formulario, para después poder mostrarlas al usuario
        // Es MUY IMPORTANTE que las claves del array sean los nombres de los campos que venían en el formulario, para poder informar al usuario
        $errores = array();

        // Ya hemos llegado al final de las validaciones. Si el array no está vacío, significa que han ocurrido errores, por tanto, lanzamos una excepción
        // Si no hay errores, el resultado de la comparacion debería ser igual a 0 
        if (sizeof($errores) > 0){
            throw new ValidationException (serialize($errores)); 
            // La serializacion almacena los valores que tienen un error y los devuelve al usuario con un mensaje
        }

        $sql = "insert into " . Constantes::PRUEBA . " (id_tecnologo, id_cedula_persona_receptora, fecha, realizacion_prueba, `consejeria_pre-prueba`, `consejeria_post-prueba`, resultado_prueba) values (?, ?, now(), ?, ?, ?, ?)";
        // Se empieza a preprara la sentencia para añadir datos a la tabla de pruebas
        if ($stmt = $mysqli->prepare($sql)) {
            $fecha = "now()"; 
            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            $stmt->bind_param('issiis', 
                $prueba['id_tecnologo'],
                $prueba['id_cedula_persona_receptora'],
                $prueba['realizacion_prueba'],
                $prueba['consejeria_pre_prueba'],
                $prueba['consejeria_post_prueba'],
                $prueba['resultado_prueba']
                );


            // Ejecutamos la sentencia con los valores ya establecidos
            if(!$stmt->execute()){
                throw new Exception("Ocurrió un problema al introducir la prueba: " . $stmt->error);
                //  Si hubiera errores, se devolvería un mensaja al usuario 
            }
            
            if ($transaccion) {
                // Si estamos en una transacción, hay que terminarla aquí
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
    // Esta excepcion es una de esta clase
    class PruebaNotFoundException extends Exception {}

?>
