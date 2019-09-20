<?php

require_once __DIR__ . '/Prueba.php';
require_once __DIR__ . '/constantes.php'; 
require_once __DIR__ . '/../lib/DB.php';
require_once __DIR__ . '/Excepciones.php';

class Pruebas {

    const realizacion_prueba = array('no_se_realizó','se_realizó');
    const resultados_posibles = array('no_reactivo','reactivo');

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
        // Abrimos la conexion de la base de prueba$prueba
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
                    $prueba['id_tecnologo'],
                    $prueba['id_cedula_persona_receptora'],
                    $date->format('d-m-Y'),
                    $prueba['realizacion_prueba'],
                    $prueba['consejeria_pre-prueba'],
                    $prueba['consejeria_post-prueba'],
                    $prueba['resultado_prueba']
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

    public static function add($prueba, $db = null){
        
        // Si el objeto db no es nulo, estamos en una transacción
        $transaccion = !is_null($db);

        // Vamos a comprobar si este método forma parte de una transacción, para crear si no nuestro propio objeto de conexión a DB
        if (!$transaccion){
            // Abrimos la conexion de la base de prueba$prueba
            $db = new DB();

            // No controlamos la excepción a propósito, ya que al ser una llamada ajax, si mandamos a una página de error el usuario no notará nada
            // Controlaremos la excepción en el php encargado de responder al ajax
            $mysqli = $db->conecta();
        }
        else {
            $mysqli = $db->getConexion();
        }

        // Errores será un array donde se guardarán los errores de validación del formulario, para después poder mostrarlas al usuario
        // Es MUY IMPORTANTE que las claves del array sean los nombres de los campos que venían en el formulario, para poder informar al usuario
        // posteriormente de cuales han sido los campos en los que se ha fallado
        $errores = array();

        // Ya hemos llegado al final de las validaciones. Si el array no está vacío, significa que han ocurrido errores, por tanto, lanzamos una excepción
        if (sizeof($errores) > 0){
            throw new ValidationException (serialize($errores));
        }

        $sql = "insert into " . Constantes::PRUEBA . " (id_tecnologo, id_cedula_persona_receptora, fecha,  (?, ?, now(), ?, ?, ?, ?)";

        // Preparamos la sentencia anterior
        if ($stmt = $mysqli->prepare($sql)) {
            $fecha = "now()"; // Como ya sabemos, bind_param no permite cadenas o números directamente si no es con variables
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

    class PruebaNotFoundException extends Exception {}

?>
