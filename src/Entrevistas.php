<?php

require_once __DIR__ . '/Entrevista.php';
require_once __DIR__ . '/EntrevistaIndividual.php';
//require_once __DIR__ . '/EntrevistaGrupal.php';
require_once __DIR__ . '/constantes.php'; // retocar las constantes y cambiarlas por los nombres de las variables privadas??
require_once __DIR__ . '/../lib/DB.php';
require_once __DIR__ . '/Excepciones.php';


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

    public static function getAllEntrevistasIndividuales ($id_promotor = null){
        $sql = "select * from " . Constantes::INDIVIDUAL;

        if (!is_null($id_promotor)) {
            $sql .= " where id_promotor = ?";
        }

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

            // Ejecutamos la sentencia con los valores ya establecidos
            $stmt->execute();

            if ($stmt->errno) {
                throw new Exception("Error de conexión con la BD");
            }
                                    
            // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
            $result = $stmt->get_result();

            // Le pedimos al objeto de resultados que nos devuelva una fila en forma de array asociativo
            while ($entrevista = $result->fetch_array(MYSQLI_ASSOC)) {
                
                $array_entrevistas[] = new EntrevistaIndividual(
                    $entrevista['id_promotor'],
                    $entrevista['id_persona_receptora'],
                    $entrevista['fecha'],
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
            $db->desconecta();

            // Devolvemos el array
            return $array_entrevistas;
        }
        else {
            $db->desconecta();
            throw new Exception("Error de BD: " . $mysqli->error);
        }
    }

    public static function getCondones_entregados($condones_entregados) {
        
    }

    public static function add($datos, $db = null){
        
        // Si el objeto mysqli no es nulo, estamos en una transacción
        $transaccion = !is_null($db);

        // Vamos a comprobar si este método forma parte de una transacción, para crear si no nuestro propio objeto de conexión a DB
        if (!$transaccion){
            // Abrimos la conexion de la base de datos
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

        if (!is_numeric($datos['condones_entregados']) || $datos['condones_entregados'] < 0) {
            $errores['condones_entregados'] = 'El número de condones entregados debe ser 0 o más';
        }

        if (!is_numeric($datos['lubricantes_entregados']) || $datos['lubricantes_entregados'] < 0) {
            $errores['lubricantes_entregados'] = 'El número de lubricantes entregados debe ser 0 o más';
        }

        if (!is_numeric($datos['materiales_educativos_entregados']) || $datos['materiales_educativos_entregados'] < 0) {
            $errores['materiales_educativos_entregados'] = 'El número de materiales educativos entregados debe ser 0 o más';
        }

        // Ya hemos llegado al final de las validaciones. Si el array no está vacío, significa que han ocurrido errores, por tanto, lanzamos una excepción
        if (sizeof($errores) > 0){
            throw new ValidationException (serialize($errores));
        }

        $sql = "insert into " . Constantes::INDIVIDUAL . " (id_promotor, id_persona_receptora, fecha, condones_entregados, lubricantes_entregados, ".
            "materiales_educativos_entregados, uso_del_condon, uso_de_alcohol_y_drogas_ilicitas, informacion_CLAM, referencia_a_prueba_de_VIH, referencia_a_clinica_TB) " .
            " values (?, ?, now(), ?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparamos la sentencia anterior
        if ($stmt = $mysqli->prepare($sql)) {
            $fecha = "now()"; // Como ya sabemos, bind_param no permite cadenas o números directamente si no es con variables
            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            $stmt->bind_param('isiiiiiiii', 
                $datos['id_promotor'],
                $datos['id_persona_receptora'],
                $datos['condones_entregados'],
                $datos['lubricantes_entregados'],
                $datos['materiales_educativos_entregados'],
                $datos['uso_del_condon'],
                $datos['uso_de_alcohol_y_drogas_ilicitas'],
                $datos['informacion_CLAM'],
                $datos['referencia_a_prueba_de_VIH'],
                $datos['referencia_a_clinica_TB']
            );


            // Ejecutamos la sentencia con los valores ya establecidos
            if(!$stmt->execute()){
                throw new Exception("Ocurrió un problema al introducir la entrevista individual: " . $stmt->error);
            }

            
            if ($transaccion) {
                // Si estamos en una transacción, hay que terminarla aquí
                $mysqli->commit();
            }

            $stmt->close();
            $db->desconecta();
        }
        else {
            throw new Exception("Error de BD: " . $mysqli->error);
        }
        
    }
}

class EntrevistaIndividualNotFoundException extends Exception {}