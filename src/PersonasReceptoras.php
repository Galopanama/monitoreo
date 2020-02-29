<?php
/**
 * El fichero es parte del Controlador y tiene todas la funciones para manipular el objeto de Persona Recptora
 * 
 * Todos los ficheros que se pueden necesitar estan en la sigueintes lineas
 */

require_once __DIR__ . '/constantes.php'; 
require_once __DIR__ . '/../lib/DB.php';
require_once __DIR__ . '/PersonaReceptora.php';
require_once __DIR__ . '/Excepciones.php';


class PersonasReceptoras {
    // Las constantes han sido declaradas a fin de ayudar con la introduccion de datos y las condiones que estos deben tener
    const MIN_TAM_CEDULA = 7;
    const MAX_TAM_CEDULA = 10;
    const tipos_poblacion_permitidos = array('HSH','TSF','TRANS');

    /**
     * La funcion devuleve la informacion de la Persona Receptora
     */

    public static function getPersonaReceptora ($id_cedula_persona_receptora){
        // Aqui comienza la peticion
        $sql = "select * from " . Constantes::PERSONA_RECEPTORA;

        $sql .= " where id_cedula_persona_receptora = ? ";

        // Abrimos la conexion de la base de datos
        $db = new DB();
        $mysqli = $db->conecta();

        // Preparaos la sentencia anterior
        if ($stmt = $mysqli->prepare($sql)) {

            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            $stmt->bind_param('s', $id_cedula_persona_receptora);

            // Ejecutamos la sentencia con los valores ya establecidos
            $stmt->execute();

            // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
            $result = $stmt->get_result();

            // Le pedimos al objeto de resultados que nos devuelva una fila (en este caso la unica) en forma de array asociativo
            $personas = $result->fetch_all(MYSQLI_ASSOC);

            // Cerramos la conexión
            $stmt->close();
                
            if(sizeof($personas) !== 1) {
                // La consulta ha devuelto 0 ó más de 1 resultado, por tanto el login introducido no era correcto o existe un problema con el usuario
                throw new PersonaReceptoraNotFoundException("La persona buscada no se encuentra");
            }

            // Puesto que esta consulta sólo ha devuelto 1 entrevista, obtenemos los datos de la primera posición del array
            $persona = $personas[0];
            
            // Creamos el objeto con los valores que hemos obtenido de la base de datos ordenados segun requiere el constructor de PersonaReceptora
            return new PersonaReceptora(
                $persona['id_cedula_persona_receptora'],
                $persona['poblacion_originaria'],
                $persona['poblacion'],
                $persona['datos_actualizados']
            );
        }
        else {
            throw new Exception("Error de BD: " . $mysqli->error);
        }
    }

    /**
     * La funcion sirve para introducir datos de nuevas Personas Receptoras
     */
    public static function add($datos, $db = null){
        // La transaccion es verdadera para devolver un nuevo objeto de manera contraria, no sucede nada
        $transaccion = !is_null($db);

        // Vamos a comprobar primero que no existe una persona con el mismo id (cédula)
        try{
            PersonasReceptoras::getPersonaReceptora($datos['id_cedula_persona_receptora']);
            // Si el código ha llegado aquí, la persona receptora ya existía, ya que no ha entrado en el catch de la excepción
            // Lanzamos una nueva excepción indicando que la persona receptora existe
            throw new ValidationException(serialize(array("id_cedula_persona_receptora" => "La persona receptora ya existe")));
        }
        catch (PersonaReceptoraNotFoundException $e) {
            // La persona receptora no existe, por tanto, podemos crearlo
            // Escribimos la consulta básica para prepararla
            $sql = "insert into persona_receptora (id_cedula_persona_receptora, poblacion_originaria, poblacion) values (?, ?, ?) ";

            if ($transaccion){
                // Si estamos en medio de una transacción, continuamos con el objeto ya abierto
                $mysqli = $db->getConexion();
            }
            else {
                // Abrimos la conexion de la base de datos
                $db = new DB();

                // No controlamos la excepción a propósito, ya que al ser una llamada ajax
                $mysqli = $db->conecta();
            }

            // Realizar comprobaciones sobre los datos introducidos. Campos vacios entre otros casos
            
            // Errores será un array donde se guardarán los errores de validación del formulario, para después poder mostrarlas al usuario
            // Es MUY IMPORTANTE que las claves del array sean los nombres de los campos que venían en el formulario, para poder informar al usuario
            // posteriormente de cuales han sido los campos en los que se ha fallado
            $errores = array();

            if (strlen($datos['id_cedula_persona_receptora']) < PersonasReceptoras::MIN_TAM_CEDULA || strlen($datos['id_cedula_persona_receptora']) > PersonasReceptoras::MAX_TAM_CEDULA) {
                $errores['id_cedula_persona_receptora'] = "Tamaño del campo cédula de la persona receptora incorrecto. Debe ser entre " . PersonasReceptoras::MIN_TAM_CEDULA . ' y ' . PersonasReceptoras::MAX_TAM_CEDULA . ' caracteres.';
            }
            //Se deberia considerar buscar un algoritmo que compruebe si las cedulas son validas (como una mejora al codigo actual)

            if (!in_array($datos['poblacion'], PersonasReceptoras::tipos_poblacion_permitidos)){
                $errores['poblacion'] = "Seleccione una población correcta";
            }
            //  Comprobar que el tipo de poblacion esta entre los permitidos 

            // Ya hemos llegado al final de las validaciones. Si el array no está vacío, significa que han ocurrido errores, por tanto, lanzamos una excepción
            if (sizeof($errores) > 0){
                throw new ValidationException (serialize($errores));
            }

            // Preparamos la sentencia anterior
            if ($stmt = $mysqli->prepare($sql)) {
                $poblacion_originaria = $datos['poblacion_originaria']?1:0;
                //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
                $stmt->bind_param('sis', 
                    $datos['id_cedula_persona_receptora'],
                    $poblacion_originaria,
                    $datos['poblacion']
                );

                // Ejecutamos la sentencia con los valores ya establecidos
                if(!$stmt->execute()){
                    throw new Exception("Ocurrió un problema al introducir la persona receptora: " . $stmt->error);
                }

                if (!$transaccion) {
                    // Si no estamos en una transacción, cerramos la conexión
                    $stmt->close();
                    $mysqli->close();
                }
                        
            }
            else {
                throw new Exception("Error de BD: " . $mysqli->error);
            }
        }
    }
}
    // Esta excepcion es unica de la clase PersonasRecptoras
class PersonaReceptoraNotFoundException extends Exception {}