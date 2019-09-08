<?php

require_once __DIR__ . '/constantes.php'; // retocar las constantes y cambiarlas por los nombres de las variables privadas??
require_once __DIR__ . '/../lib/DB.php';
require_once __DIR__ . '/PersonaReceptora.php';
require_once __DIR__ . '/Excepciones.php';


class PersonasReceptoras {

    const MIN_TAM_CEDULA = 7;
    const MAX_TAM_CEDULA = 10;
    const tipos_poblacion_permitidos = array('HSH','TSF','TRANS');

    public static function getPersonaReceptora ($id_persona_receptora){
        $sql = "SELECT * FROM " . Constantes::PERSONA_RECEPTORA;

        $sql .= " WHERE id_cedula = ? ";

        // Abrimos la conexion de la base de datos
        $db = new DB();
        $mysqli = $db->conecta();

        // Preparaos la sentencia anterior
        if ($stmt = $mysqli->prepare($sql)) {

            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            $stmt->bind_param('i', $id_persona_receptora);

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
                $persona['id_cedula'],
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
     * @return mysqli Si transaccion está a true. No devuelve nada en caso contrario
     */
    public static function add($datos, $db = null){
        $transaccion = !is_null($db);

        // Vamos a comprobar primero que no existe una persona con el mismo id (cédula)
        try{
            PersonasReceptoras::getPersonaReceptora($datos['id_persona_receptora']);
            // Si el código ha llegado aquí, la persona receptora ya existía, ya que no ha entrado en el catch de la excepción
            // Lanzamos una nueva excepción indicando que la persona receptora existe
            throw new ValidationException(serialize(array("id_persona_receptora" => "La persona receptora ya existe")));
        }
        catch (PersonaReceptoraNotFoundException $e) {
            // La persona receptora no existe, por tanto, podemos crearlo
            // Escribimos la consulta básica para prepararla
            $sql = "insert into persona_receptora (id_cedula, poblacion_originaria, poblacion) values (?, ?, ?) ";

            if ($transaccion){
                // Si estamos en medio de una transacción, continuamos con el objeto ya abierto
                $mysqli = $db->getConexion();
            }
            else {
                // Abrimos la conexion de la base de datos
                $db = new DB();

                // No controlamos la excepción a propósito, ya que al ser una llamada ajax, si mandamos a una página de error el usuario no notará nada
                // Controlaremos la excepción en el php encargado de responder al ajax
                $mysqli = $db->conecta();
            }

            // TODO: Realizar comprobaciones sobre los datos introducidos. Por ejemplo:
            // Campos vacíos
            
            // Errores será un array donde se guardarán los errores de validación del formulario, para después poder mostrarlas al usuario
            // Es MUY IMPORTANTE que las claves del array sean los nombres de los campos que venían en el formulario, para poder informar al usuario
            // posteriormente de cuales han sido los campos en los que se ha fallado
            $errores = array();

            if (strlen($datos['id_persona_receptora']) < PersonasReceptoras::MIN_TAM_CEDULA || strlen($datos['id_persona_receptora']) > PersonasReceptoras::MAX_TAM_CEDULA) {
                $errores['id_persona_receptora'] = "Tamaño del campo cédula de la persona receptora incorrecto. Debe ser entre " . PersonasReceptoras::MIN_TAM_CEDULA . ' y ' . PersonasReceptoras::MAX_TAM_CEDULA . ' caracteres.';
            }
            // TODO: comprobar que la cédula es válida

            if (!in_array($datos['poblacion'], PersonasReceptoras::tipos_poblacion_permitidos)){
                $errores['poblacion'] = "Seleccione una población correcta";
            }

            // Ya hemos llegado al final de las validaciones. Si el array no está vacío, significa que han ocurrido errores, por tanto, lanzamos una excepción
            if (sizeof($errores) > 0){
                throw new ValidationException (serialize($errores));
            }

            // Preparamos la sentencia anterior
            if ($stmt = $mysqli->prepare($sql)) {
                $poblacion_originaria = $datos['poblacion_originaria']?1:0;
                //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
                $stmt->bind_param('sis', 
                    $datos['id_persona_receptora'],
                    $poblacion_originaria,
                    $datos['poblacion']
                );

                // Ejecutamos la sentencia con los valores ya establecidos
                if(!$stmt->execute()){
                    throw new Exception("Ocurrió un problema al introducir  la persona receptora: " . $stmt->error);
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

class PersonaReceptoraNotFoundException extends Exception {}