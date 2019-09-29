<?php
/**
 * The file is the controller that have all the functions that users can have to manipulate the object Persona Receptora
 * All the files that can be required to help the manipulation have been added at the beginning 
 */

require_once __DIR__ . '/constantes.php'; 
require_once __DIR__ . '/../lib/DB.php';
require_once __DIR__ . '/PersonaReceptora.php';
require_once __DIR__ . '/Excepciones.php';


class PersonasReceptoras {
// Some constants have been declared in order to help the user to fill infromation correctly as well as to enforce certain conditions
    const MIN_TAM_CEDULA = 7;
    const MAX_TAM_CEDULA = 10;
    const tipos_poblacion_permitidos = array('HSH','TSF','TRANS');

    // the function retrieve the data from the class PersonaReceptora 
    public static function getPersonaReceptora ($id_persona_receptora){
        // The basic query starts here
        $sql = "select * from " . Constantes::PERSONA_RECEPTORA;

        $sql .= " where id_cedula = ? ";

        // Abrimos la conexion de la base de datos
         // The connection to the database is open
        $db = new DB();
        $mysqli = $db->conecta();

        // Preparaos la sentencia anterior
        // The sentence gets prepared in the variable $stmt
        if ($stmt = $mysqli->prepare($sql)) {

            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            // the value of username is asigned with the datatype that they are using the method bind_param
            $stmt->bind_param('i', $id_persona_receptora);

            // Ejecutamos la sentencia con los valores ya establecidos
            // The request gets executed
            $stmt->execute();

            // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
            // Once that the resquest is done, we get an object with the information. It is easier to manupulate
            $result = $stmt->get_result();

            // Le pedimos al objeto de resultados que nos devuelva una fila (en este caso la unica) en forma de array asociativo
            // to display the results of the object, we ask to print them in a single line
            $personas = $result->fetch_all(MYSQLI_ASSOC);

            // Cerramos la conexión
            // We disconnect the connection from the database
            $stmt->close();
                
            if(sizeof($personas) !== 1) {
                // La consulta ha devuelto 0 ó más de 1 resultado, por tanto el login introducido no era correcto o existe un problema con el usuario
                // If there size is 0 or more than 1 there is an error with the login of with the interview requested. The user gets informed with an error message
                throw new PersonaReceptoraNotFoundException("La persona buscada no se encuentra");
            }

            // Puesto que esta consulta sólo ha devuelto 1 entrevista, obtenemos los datos de la primera posición del array
            // if the size 1, the object indivudual would display the only entrevista individual that the user has requested and it is in the first position so position 0
            $persona = $personas[0];
            
            // Creamos el objeto con los valores que hemos obtenido de la base de datos ordenados segun requiere el constructor de PersonaReceptora
            // A new object is created with the attributes listed below
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

    // the function is used to introduce new Personas Receptoras in the database
    public static function add($datos, $db = null){
        // the transaction is true in order to return a new object otherwise nothing happen
        $transaccion = !is_null($db);

        // Vamos a comprobar primero que no existe una persona con el mismo id (cédula)
        // Check that there is no user with the id number
        try{
            PersonasReceptoras::getPersonaReceptora($datos['id_persona_receptora']);
            // Si el código ha llegado aquí, la persona receptora ya existía, ya que no ha entrado en el catch de la excepción
            // Lanzamos una nueva excepción indicando que la persona receptora existe
            // If there is a user witht the smae 'id', means that there is a person created already, therefore I can't be created a new user with this id
            // id is a unique field in the database that is one of the limitations impose. Also id is a unique number in the real life, so it can not be two people with the same id 
            throw new ValidationException(serialize(array("id_persona_receptora" => "La persona receptora ya existe")));
        }
        catch (PersonaReceptoraNotFoundException $e) {
            // La persona receptora no existe, por tanto, podemos crearlo
            // Escribimos la consulta básica para prepararla
            // If the person does not exist, we can proceed to create the instance of the class.
            // Start the basic query
            $sql = "insert into persona_receptora (id_cedula, poblacion_originaria, poblacion) values (?, ?, ?) ";

            if ($transaccion){
                // Si estamos en medio de una transacción, continuamos con el objeto ya abierto
                // If we are in the middle of the a transaction, we continue with the object 
                $mysqli = $db->getConexion();
            }
            else {
                // Abrimos la conexion de la base de datos
                // Open the connection with the database
                $db = new DB();

                // No controlamos la excepción a propósito, ya que al ser una llamada ajax
                // // The sentence gets prepared in the variable $mysqli
                $mysqli = $db->conecta();
            }

            // Realizar comprobaciones sobre los datos introducidos. Campos vacios entre otros casos
            // Check for the basic considitions that are necessary to have in the attributes
            
            // Errores será un array donde se guardarán los errores de validación del formulario, para después poder mostrarlas al usuario
            // Es MUY IMPORTANTE que las claves del array sean los nombres de los campos que venían en el formulario, para poder informar al usuario
            // posteriormente de cuales han sido los campos en los que se ha fallado
            // We create the arrau $errores to store any errors found in an array and afterwards will be returned to the user so he can know where is the error
            $errores = array();

            if (strlen($datos['id_persona_receptora']) < PersonasReceptoras::MIN_TAM_CEDULA || strlen($datos['id_persona_receptora']) > PersonasReceptoras::MAX_TAM_CEDULA) {
                $errores['id_persona_receptora'] = "Tamaño del campo cédula de la persona receptora incorrecto. Debe ser entre " . PersonasReceptoras::MIN_TAM_CEDULA . ' y ' . PersonasReceptoras::MAX_TAM_CEDULA . ' caracteres.';
            }
            //comprobar que la cédula es válida - buscar u algoritmo que valide la cedula. Los hay que comprueban el DNI
            // Chech that id_cedula is valid

            if (!in_array($datos['poblacion'], PersonasReceptoras::tipos_poblacion_permitidos)){
                $errores['poblacion'] = "Seleccione una población correcta";
            }
            // Chech that tipo de poblacion is among these that are allowed

            // Ya hemos llegado al final de las validaciones. Si el array no está vacío, significa que han ocurrido errores, por tanto, lanzamos una excepción
            // If there are erros at this point the they will return to the user with a message indicating what to change 
            if (sizeof($errores) > 0){
                throw new ValidationException (serialize($errores));
            }

            // Preparamos la sentencia anterior
            // Preapare the previous sentece
            if ($stmt = $mysqli->prepare($sql)) {
                $poblacion_originaria = $datos['poblacion_originaria']?1:0;
                //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
                // Join the parameters with the attributes. The datatype has been specify too
                $stmt->bind_param('sis', 
                    $datos['id_persona_receptora'],
                    $poblacion_originaria,
                    $datos['poblacion']
                );

                // Ejecutamos la sentencia con los valores ya establecidos
                // Execute the sentence sql to the database. If not succeed it will return an error message
                if(!$stmt->execute()){
                    throw new Exception("Ocurrió un problema al introducir la persona receptora: " . $stmt->error);
                }

                if (!$transaccion) {
                    // Si no estamos en una transacción, cerramos la conexión
                    // If not in a transaction, the connection gets close
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
    // this exception is unique of this class
class PersonaReceptoraNotFoundException extends Exception {}