<?php
/**
 * The file is the controller that have all the functions that users can have to manipulate the object Entrevista
 * All the files that can be required to help the manipulation have been added at the beginning 
 */
require_once __DIR__ . '/Entrevista.php';
require_once __DIR__ . '/EntrevistaIndividual.php';
require_once __DIR__ . '/EntrevistaGrupal.php';
require_once __DIR__ . '/Alcanzado.php';
require_once __DIR__ . '/constantes.php'; 
require_once __DIR__ . '/../lib/DB.php';
require_once __DIR__ . '/Excepciones.php';


class Entrevistas {
// Some constants have been declared in order to help the user to fill information correctly as well as to enforce certain conditions
    const regiones_de_salud_permitidas = array('Bocas_del_Toro','Chiriquí','Coclé','Colón','Herrera','Los_Santos','Panamá_Metro','Panamá_Oeste_1','Panamá_Oeste_2','San_Miguelito','Veraguas');

    
    // El parametro fecha debe ser una fecha en el formato YYYY-MM-DD
    // the parameter fecha must be in the format YYYY-MM-DD

    // The function request the database one Entrevista Individual  
    public static function getEntrevistaIndividual ($id_promotor, $id_cedula_persona_receptora, $fecha){
        $sql = "select * from " . Constantes::INDIVIDUAL; 

        if ($_SESSION["tipo_de_usuario"] === "subreceptor") {
            $sql .= ", " . Constantes::PROMOTOR; // The id of subreceptor is required to enforce that only show entrevistas of certain promotores associated to them 
        }

        $sql .= " where id_promotor = ? and " .
                "id_cedula_persona_receptora = ? and " .
                "fecha = ? ";

        if ($_SESSION["tipo_de_usuario"] === "promotor") {   // The id of promotor is required to enforce that only show entrevistas loaded by herself/himself
            $sql .= " and id_promotor = " . $_SESSION["id_usuario"] . " ";
        }
        else if ($_SESSION["tipo_de_usuario"] === "subreceptor") {
            $sql .= " and " . Constantes::PROMOTOR . ".id_usuario = " . Constantes::INDIVIDUAL . ".id_promotor
                    and id_subreceptor = " . $_SESSION["id_usuario"] . " ";
        }   

        // Abrimos la conexion de la base de datos
        // The connection to the database is open
        $db = new DB();
        $mysqli = $db->conecta();

        // Preparaos la sentencia anterior
        // The sentence gets prepared in the variable $stmt
        if ($stmt = $mysqli->prepare($sql)) {

            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            // The parameter are associated to the attriute listed as well as the datatype is specified
            $stmt->bind_param('iss', $id_promotor, $id_cedula_persona_receptora, $fecha);

            // Ejecutamos la sentencia con los valores ya establecidos
            // The sentence get executed
            $stmt->execute();

            // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
            // Once requested the sentece, we would be able to manipulate the information in the object called $result
            $result = $stmt->get_result();

            // Le pedimos al objeto de resultados que nos devuelva una fila (en este caso la unica) en forma de array asociativo
            // We request the object to return the information in one line per entrevista
            $individuales = $result->fetch_all(MYSQLI_ASSOC);

            // Cerramos la conexión
            // The connection gets close
            $stmt->close();
                
            if(sizeof($individuales) !== 1) {
                // If there size is 0 or more than 1 there is an error with the login of with the itreview requested. The user gets informed with an error message
                // La consulta ha devuelto 0 ó más de 1 resultado, por tanto el login introducido no era correcto o existe un problema con el usuario
                throw new EntrevistaIndividualNotFoundException("La entrevista buscada no se encuentra");
            }

            // Puesto que esta consulta sólo ha devuelto 1 entrevista, obtenemos los datos de la primera posición del array
            // if the size 1, the object indivudual would display the only entrevista individual that the user has requested 
            $individual = $individuales[0];
            
            // Creamos el objeto con los valores que hemos obtenido de la base de datos ordenados segun requiere el constructor de EntrevistaIndividual
            // The object created from the database has the following attributes. The named with the same name as the attributes of the table Entrevistas
            return new EntrevistaIndividual(
                $individual['id_promotor'], 
                $individual['id_cedula_persona_receptora'], 
                $individual['fecha'], 
                $individual['region_de_salud'],
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
    // the function request the databse information about the Entrevistas Grupales 
    public static function getEntrevistaGrupal($id_promotor, $id_cedula_persona_receptora, $fecha){
        $sql = "select * from " . Constantes::GRUPAL ;  // The query is declared in a variable called $sql
    
        // If the subreceptor is who query for the information we need to include it here
        if ($_SESSION["tipo_de_usuario"] === "subreceptor") {
            $sql .= ", " . Constantes::PROMOTOR ;       
        }

        $sql .= "where id_promotor = ? and " .
                "id_cedula_persona_receptora = ? and " .
                "fecha = ? ";
        // The id of promotor is required to enforce that only show entrevistas loaded by herself/himself
        if ($_SESSION["tipo_de_usuario"] === "promotor") {  
            $sql .= "and id_promotor = " . $_SESSION["id_usuario"] . " ";
        }
        else if ($_SESSION["tipo_de_usuario"] === "subreceptor") {             
            $sql .= " and " . Constantes::PROMOTOR . ".id_usuario  = " . Constantes::GRUPAL . ".id_promotor
                    and id_subreceptor = " . $_SESSION["id_usuario"] . " ";
        }
        
        // Abrimos la conexion de la base de datos
        // The connection to the database is open
        $db = new DB();
        $mysqli = $db->conecta();
                    
        // Preparaos la sentencia anterior
        // The sentence gets prepared in the variable $mysqli
        $mysqli->prepare($sql);
                    
        //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
        // The parameter are associated to the attriute listed as well as the datatype is specified
        $mysqli->bind_param('iss', $id_promotor, $id_cedula_persona_receptora, $fecha);
                    
        // Ejecutamos la sentencia con los valores ya establecidos
        // The sentence get executed
        $mysqli->execute();
                    
        // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
        // Once requested the sentece, we would be able to manipulate the information in the object called $result
        $result = $mysqli->get_result();
                    
        // Le pedimos al objeto de resultados que nos devuelva una fila (en este caso la unica) en forma de array asociativo
        // We request the object to return the information in one line per entrevista
        $grupal = $result->fetch_array(MYSQL_ASSOC); 
                            
        // Creamos el objeto con los valores que hemos obtenido de la base de datos ordenados segun requiere el constructor de EntrevistaGrupal
        // The object created from the database has the following attributes. The named with the same name as the attributes of the table EntrevistasGrupal
        return new EntrevistaGrupal(
            $grupal['id_promotor'], 
            $grupal['id_cedula_persona_receptora'], 
            $grupal['fecha'], 
            $grupal['condones_entregados'], 
            $grupal['lubricantes_entregados'], 
            $grupal['materiales_educativos_entregados'], 
            $grupal['region_de_salud'], 
            $grupal['area'], 
            $grupal['estilos_de_autocuidado'],
            $grupal['ddhh_estigma_discriminacion'], 
            $grupal['uso_correcto_y_constantes_del_condon'], 
            $grupal['salud_sexual_e_its'], 
            $grupal['ofrecimiento_y_referencia_a_la_prueba_de_vih'], 
            $grupal['clam_y_otros_servicios'], 
            $grupal['salud_anal'], 
            $grupal['hormonizacion'], 
            $grupal['apoyo_y_orientacion_psicologica'], 
            $grupal['diversidad_sexual_identidad_expresion_de_genero'], 
            $grupal['tuberculosis_y_coinfecciones'],
            $grupal['infecciones_oportunistas']);
    }
    // The function request the database all Entrevistas Individuales  
    public static function getAllEntrevistasIndividuales ($id_promotor = null, $id_subreceptor = null){
        $sql = "select * from " . Constantes::INDIVIDUAL . " e ";   // The query is declared in a variable called $sql
    
        // The id_promotor gets set
        if (!is_null($id_promotor)) {
            $sql .= " where e.id_promotor = ?";
        }
        // The id_subreceptor get set
        else if (!is_null($id_subreceptor)) {
            $sql .= ", " . Constantes::PROMOTOR . " p 
                where e.id_promotor = p.id_usuario
                and p.id_subreceptor = ? ";
        }

        // Vamos a ordenar las más nuevas primero
        // The interviews gets ordered starting from the latest
        $sql .= " order by e.fecha desc ";

        // Abrimos la conexion de la base de datos
        // The connection to the database is open
        $db = new DB();

        // La siguiente llamada puede generar una excepción
        // The sentence gets prepared in the variable $mysqli
        $mysqli = $db->conecta();
        
                    
        // Creamos un array en el que guardaremos los usuarios
        // The users get stored in an array
        $array_entrevistas = array();

        // The sentence gets prepared in the variable $stmt
        if ($stmt = $mysqli->prepare($sql)) {
            
            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            // The parameter is associated to the attribute as well as the datatype is specified
            if (!is_null($id_promotor)) {
                $stmt->bind_param('i', $id_promotor);
            }
            // The parameter is associated to the attribute as well as the datatype is specified
            else if (!is_null($id_subreceptor)) {
                $stmt->bind_param('i', $id_subreceptor);
            }

            // Ejecutamos la sentencia con los valores ya establecidos
            // The sentence get executed
            $stmt->execute();

            if ($stmt->errno) {
                throw new Exception("Error de conexión con la BD");
            }
                                    
            // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
             // Once requested the sentece, we would be able to manipulate the information in the object called $result
            $result = $stmt->get_result();

            // Le pedimos al objeto de resultados que nos devuelva una fila en forma de array asociativo
            // We request the object to return the information in one line per entrevista
            while ($entrevista = $result->fetch_array(MYSQLI_ASSOC)) {
                
                $date = new DateTime($entrevista['fecha']);
                
                $array_entrevistas[] = new EntrevistaIndividual(
                    $entrevista['id_promotor'],
                    $entrevista['id_cedula_persona_receptora'],
                    $date->format('d-m-Y'),
                    $entrevista['region_de_salud'],
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
            // The results from the memory gets deleted
            $result->free();
            // por último desconectamos de la base de datos
            // The connection with the database is closed
            $stmt->close();
            $mysqli->close();

            // Devolvemos el array
            // We return a array of entrevistas
            return $array_entrevistas;
        }
        else {
            // por último desconectamos de la base de datos
            // The connection with the database is close and an error messaeg return to the user
            $mysqli->close();
            throw new Exception("Error de BD: " . $mysqli->error);
        }
    }
    // The function request the database all Entrevistas Grupales 
    public static function getAllEntrevistasGrupales ($id_promotor = null, $id_subreceptor = null){
        $sql = "select * from " . Constantes::GRUPAL . " e ";   // The query is declared in a variable called $sql

        // The id_promotor gets set
        if (!is_null($id_promotor)) {
            $sql .= " where e.id_promotor = ?";
        }
        // The id_subreceptor get set
        else if (!is_null($id_subreceptor)) {
            $sql .= ", " . Constantes::PROMOTOR . " p 
                where e.id_promotor = p.id_usuario
                and p.id_subreceptor = ? ";
        }

        // Vamos a ordenar las más nuevas primero
        // The interviews gets ordered starting from the latest
        $sql .= " order by e.fecha desc ";

        // Abrimos la conexion de la base de datos
        // The connection to the database is open
        $db = new DB();

        // La siguiente llamada puede generar una excepción
        // The sentence gets prepared in the variable $mysqli
        $mysqli = $db->conecta();
        
                    
        // Creamos un array en el que guardaremos los usuarios
        // The users get stored in an array
        $array_entrevistas = array();

        // The sentence gets prepared in the variable $stmt
        if ($stmt = $mysqli->prepare($sql)) {
            
            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            // The parameter is associated to the attribute as well as the datatype is specified
            if (!is_null($id_promotor)) {
                $stmt->bind_param('i', $id_promotor);
            }
            // The parameter is associated to the attribute as well as the datatype is specified
            else if (!is_null($id_subreceptor)) {
                $stmt->bind_param('i', $id_subreceptor);
            }

            // Ejecutamos la sentencia con los valores ya establecidos
            // The sentence get executed
            $stmt->execute();

            if ($stmt->errno) {
                throw new Exception("Error de conexión con la BD");
            }
                                    
            // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
            // Once requested the sentece, we would be able to manipulate the information in the object called $result
            $result = $stmt->get_result();

            // Le pedimos al objeto de resultados que nos devuelva una fila en forma de array asociativo
            // We request the object to return the information in one line per entrevista
            while ($entrevista = $result->fetch_array(MYSQLI_ASSOC)) {
                
                $date = new DateTime($entrevista['fecha']);
                
                $array_entrevistas[] = new EntrevistaGrupal(
                    $entrevista['id_promotor'],
                    $entrevista['id_cedula_persona_receptora'],
                    $date->format('d-m-Y'),
                    $entrevista['condones_entregados'],
                    $entrevista['lubricantes_entregados'],
                    $entrevista['materiales_educativos_entregados'],
                    $entrevista['region_de_salud'],
                    $entrevista['area'],
                    $entrevista['estilos_autocuidado'],
                    $entrevista['ddhh_estigma_discriminacion'],
                    $entrevista['uso_correcto_y_constantes_del_condon'],
                    $entrevista['salud_sexual_e_ITS'],
                    $entrevista['ofrecimiento_y_referencia_a_la_prueba_de_VIH'],
                    $entrevista['CLAM_y_otros_servicios'],
                    $entrevista['salud_anal'],
                    $entrevista['hormonizacion'],
                    $entrevista['apoyo_y_orientacion_psicologico'],
                    $entrevista['diversidad_sexual_identidad_expresion_de_genero'],
                    $entrevista['tuberculosis_y_coinfecciones'],
                    $entrevista['infecciones_oportunistas']
                );
            }

            // limpiamos los resultados de la memoria
            // The results from the memory gets deleted
            $result->free();
            // por último desconectamos de la base de datos
            // We request the object to return the information in one line per entrevista
            $stmt->close();
            $mysqli->close();

            // Devolvemos el array
            // We return a array of entrevistas
            return $array_entrevistas;
        }
        else {
            // por último desconectamos de la base de datos
            // The connection with the database is close and an error messaeg return to the user
            $mysqli->close();
            throw new Exception("Error de BD: " . $mysqli->error);
        }
    }
    // The function request the database all Alcanzados
    public static function getAlcanzado ($id_subreceptor){

        $sql = "select * from " . Constantes::ALCANZADOS ;// As there is a view created with that purpose 

        if ($_SESSION["tipo_de_usuario"] === "subreceptor") {
            $sql .= " where id_subreceptor = ? ";
        }
        

        // Abrimos la conexion de la base de datos
        // The connection to the database is open
        $db = new DB();
        $mysqli = $db->conecta();

        // Preparaos la sentencia anterior
        // The sentence gets prepared in the variable $stmt
        if ($stmt = $mysqli->prepare($sql)) {

            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            // The parameter are associated to the attriute listed as well as the datatype is specified
            $stmt->bind_param('i', $id_subreceptor);

            // Ejecutamos la sentencia con los valores ya establecidos
            // The sentence get executed
            $stmt->execute();

            // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
            // Once requested the sentece, we would be able to manipulate the information in the object called $result
            $result = $stmt->get_result();

            // Le pedimos al objeto de resultados que nos devuelva una fila (en este caso la unica) en forma de array asociativo
            // We request the object to return the information in one line per entrevista
            $alcanzados = $result->fetch_all(MYSQLI_ASSOC);

            // Cerramos la conexión
            // The connection gets close
            $stmt->close();
                
            if(sizeof($alcanzados) !== 1) {
                // If there size is 0 or more than 1 there is an error with the login of with the itreview requested. The user gets informed with an error message
                // La consulta ha devuelto 0 ó más de 1 resultado, por tanto el login introducido no era correcto o existe un problema con el usuario
                throw new AlcanzadoNotFoundException("La persona no ha sido alcanzada aún");
            }

            // Puesto que esta consulta sólo ha devuelto 1 entrevista, obtenemos los datos de la primera posición del array
            // if the size 1, the object indivudual would display the only entrevista individual that the user has requested 
            $alcanzado = $alcanzados[0];
            
            // Creamos el objeto con los valores que hemos obtenido de la base de datos ordenados segun requiere el constructor de Alcanzado
            // The object created from the database has the following attributes. The named with the same name as the attributes of the table Entrevistas
            return new Alcanzado_por_Subreceptor(
                $alcanzado['id_promotor'], 
                $alcanzado['id_cedula_persona_receptora'],
                $alcanzado['fecha'],
                $alcanzado['condones_entregados'],
                $alcanzado['lubricantes_entregados'],
                $alcanzado['materiales_educativos_entregados'], 
                $alcanzado['total_condones'], 
                $alcanzado['total_lubricantes'], 
                $alcanzado['total_materiales_educativos']
            );
        }
    }
    // This function will be use to add Individual Interviews
    public static function addIndividual($datos, $db = null){
        
        // Si el objeto db no es nulo, estamos en una transacción
        // If the object $db is not null, means that we are in a transaction
        $transaccion = !is_null($db);

        // Vamos a comprobar si este método forma parte de una transacción, para crear si no nuestro propio objeto de conexión a DB
        // Check if there is a transaction active, if not create the obejct DB to query the database
        if (!$transaccion){
            // Abrimos la conexion de la base de datos
            // the connection is open
            $db = new DB();

            // No controlamos la excepción a propósito, ya que al ser una llamada ajax
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

        if (!in_array($datos['region_de_salud'], Entrevistas::regiones_de_salud_permitidas)){
            $errores['region_de_salud'] = "Seleccione una región de salud correcta";
        }

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
        // if there are no errors, the result of the comparartion should be equal to 0
        if (sizeof($errores) > 0){
            throw new ValidationException (serialize($errores));// serialize stores the values that have an error and retunr if to the user with a message
        }

        $sql = "insert into " . Constantes::INDIVIDUAL . " (
            id_promotor, 
            id_cedula_persona_receptora, 
            fecha, 
            region_de_salud, 
            condones_entregados, 
            lubricantes_entregados, 
            materiales_educativos_entregados, 
            uso_del_condon, 
            uso_de_alcohol_y_drogas_ilicitas, 
            informacion_CLAM, 
            referencia_a_prueba_de_VIH, 
            referencia_a_clinica_TB) " .
            " values (?, ?, now(), ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparamos la sentencia anterior
        // the query to add information to the table entrevistaIndividual gets prepared
        if ($stmt = $mysqli->prepare($sql)) {
            $fecha = "now()";//Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            // the information gets assigned to the name of the attributes of the class that are in the database and with the specification of their datatype
            $stmt->bind_param('issiiiiiiii', 
                $datos['id_promotor'],
                $datos['id_cedula_persona_receptora'],
                $datos['region_de_salud'],
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
             // The query to add the individual gets executed
            if(!$stmt->execute()){
                throw new Exception("Ocurrió un problema al introducir la entrevista individual: " . $stmt->error);
            }

            
            if ($transaccion) {
                // Si estamos en una transacción, hay que terminarla aquí
                // The transaction need to be close here
                $mysqli->commit();
            }
            $stmt->close();
            $mysqli->close();
            // llamar a un metodo nuevo que se va a llamar compruebaAlcanzados()
        }
        else {
            throw new Exception("Error de BD: " . $mysqli->error);
        }
        
    }
    // This function will be use to add Group Interviews
    public static function addGrupal($datos, $db = null){
        
        // Si el objeto db no es nulo, estamos en una transacción
        // If the object $db is not null, means that we are in a transaction
        $transaccion = !is_null($db);

        // Vamos a comprobar si este método forma parte de una transacción, para crear si no nuestro propio objeto de conexión a DB
        // Check if there is a transaction active, if not create the obejct DB to query the database
        if (!$transaccion){
            // Abrimos la conexion de la base de datos
            // the connection is open
            $db = new DB();

            // No controlamos la excepción a propósito, ya que al ser una llamada ajax
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

        if (!in_array($datos['region_de_salud'], Entrevistas::regiones_de_salud_permitidas)){
            $errores['region_de_salud'] = "Seleccione una región de salud correcta";
        }

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
        // if there are no errors, the result of the comparartion should be equal to 0, else there will be an error message returning to the user informing about the error
        if (sizeof($errores) > 0){
            throw new ValidationException (serialize($errores));
        }
        $sql = "insert into " . Constantes::GRUPAL . " (
                id_promotor, 
                id_cedula_persona_receptora, 
                fecha, 
                condones_entregados, 
                lubricantes_entregados,
                materiales_educativos_entregados, 
                region_de_salud, 
                area, 
                estilos_autocuidado, 
                ddhh_estigma_discriminacion, 
                uso_correcto_y_constantes_del_condon, 
                salud_sexual_e_ITS, 
                ofrecimiento_y_referencia_a_la_prueba_de_VIH, 
                CLAM_y_otros_servicios, 
                salud_anal, 
                hormonizacion, 
                apoyo_y_orientacion_psicologico, 
                diversidad_sexual_identidad_expresion_de_genero, 
                tuberculosis_y_coinfecciones, 
                infecciones_oportunistas) " .
            " values (?, ?, now(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ";
        // the query to add information to the table prueba gets prepared
        // Preparamos la sentencia anterior

        if ($stmt = $mysqli->prepare($sql)) {
            $fecha = "now()"; //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            // the information gets assigned to the name of the attributes of the class that are in the database and with the specification of their datatype
            $stmt->bind_param('isiiissiiiiiiiiiiii', 
                $datos['id_promotor'],
                $datos['id_cedula_persona_receptora'],
                $datos['condones_entregados'],
                $datos['lubricantes_entregados'],
                $datos['materiales_educativos_entregados'],
                $datos['region_de_salud'],
                $datos['area'],
                $datos['estilos_autocuidado'],
                $datos['ddhh_estigma_discriminacion'],
                $datos['uso_correcto_y_constantes_del_condon'],
                $datos['salud_sexual_e_ITS'],
                $datos['ofrecimiento_y_referencia_a_la_prueba_de_VIH'],
                $datos['CLAM_y_otros_servicios'],
                $datos['salud_anal'],
                $datos['hormonizacion'],
                $datos['apoyo_y_orientacion_psicologico'],
                $datos['diversidad_sexual_identidad_expresion_de_genero'],
                $datos['tuberculosis_y_coinfecciones'],
                $datos['infecciones_oportunistas']
            );


            // Ejecutamos la sentencia con los valores ya establecidos
            // The query to add the prueba gets executed
            if(!$stmt->execute()){
                throw new Exception("Ocurrió un problema al introducir la entrevista grupal: " . $stmt->error);
            }
            // The transaction need to be close here
            if (!$transaccion) {
                $stmt->close();
                $mysqli->close();
            }            
        }
        else {
            throw new Exception("Error de BD: " . $mysqli->error);
        }
        
    }
}
    // this exception is unique of this class
class EntrevistaIndividualNotFoundException extends Exception {}