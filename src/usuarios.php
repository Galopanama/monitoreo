<?php
/**
 * The file is the controller that have all the functions that users can have to manipulate the object Usuarios
 * All the files that can be required to help the manipulation have been added at the beginning 
 */
require_once __DIR__ . '/../lib/DB.php';
require_once __DIR__ . '/Usuario.php';
require_once __DIR__ . '/Excepciones.php';

class Usuarios {
// Some constants have been declared in order to help the user to fill information correctly as well as to enforce certain conditions
    const MIN_TAM_LOGIN = 8;
    const MAX_TAM_LOGIN = 16;
    const MIN_TAM_PASSWORD = 8;
    const MAX_TAM_PASSWORD = 16;
    const tipos_usuario_permitidos = array('administrador', 'subreceptor', 'promotor', 'tecnologo');

    /**
     * Devuelve un objeto Usuario (o un subtipo del mismo), cuyo login coincida con $username. Si no, lanza una excepción UsuarioNotFoundException
     * return an object Usuario with the username value equal to $username. If not, it would return an Exception 
     */
    public static function getUsuarioByUsername($username = '', $activo = true, $show_password = false) {
        // Escribimos la consulta básica para prepararla
        // The basic query starts here
        $sql = "select * from usuario where login = ? ";

        if ($activo) {
            $sql .= " AND estado = 'activo' ";
        }// the status of the user gets included

        // Abrimos la conexion de la base de datos
        // The connection to the database is open
        $db = new DB();

        // La siguiente llamada puede generar una excepción, que habrá que recoger en el método que la llame, o dejar que se propague
        // The sentence gets prepared in the variable $mysqli
        $mysqli = $db->conecta();
                    
        // Preparaos la sentencia anterior
        // The sentence gets prepared in the variable $stmt
        if ($stmt = $mysqli->prepare($sql)) {
            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            // the value of username is asigned with the datatype that they are using the method bind_param
            $stmt->bind_param('s', $username);

            // Ejecutamos la sentencia con los valores ya establecidos
            // The request gets process
            $stmt->execute();

            if ($stmt->errno) {
                throw new Exception("Error de conexión con la BD");
            }
                        
            // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
            // Once that the resquest is done, we get an object with the information. It is easier to manupulate
            $result = $stmt->get_result();

            // Le pedimos al objeto de resultados que nos devuelva una fila (en este caso la unica) en forma de array asociativo
            // to display the results of the object, we ask to print them in a single line
            $usuarios = $result->fetch_all(MYSQLI_ASSOC);
            
            // Cerramos la conexión
            // We disconnect the connection from the database
            $stmt->close();
            
            if(sizeof($usuarios) !== 1) {
                // La consulta ha devuelto 0 ó más de 1 resultado, por tanto el login introducido no era correcto o existe un problema con el usuario
                // If there size is 0 or more than 1 there is an error with the login of with the interview requested. The user gets informed with an error message
                throw new UsuarioNotFoundException("El usuario con username $username no existe");
            }

            // Puesto que esta consulta sólo ha devuelto 1 usuario, obtenemos los datos de la primera posición del array
            // if the size 1, the object indivudual would display the only entrevista individual that the user has requested and it is in the first position so position 0
            $usuario = $usuarios[0];

            // Si no queremos mostrar el password, mandaremos una cadena vacía
            // If we don't want to show their password, we send an empty array
            $usuario['password'] = $show_password?$usuario['password']:'';

            // Llamamos a un método que nos devolverá un objeto de tipo Usuario, Tecnologo, Promotor o Subreceptor, dependiendo del tipo
            // Call the method that will return the type of user that it is
            return Usuarios::getUsuarioTipado($usuario);
        }
        else {
            throw new Exception("Error de BD: " . $mysqli->error);
        }
    }

    /**
     * Devuelve un objeto Usuario (o un subtipo del mismo), cuyo identificador coincida con $id. Si no, lanza una excepción UsuarioNotFoundException
     * En este caso, se busca por defecto el usuario, esté activo o no
     * Retunr a user by the id and if not foud it will send and exception of UsuarioNotFoundException
     */
    public static function getUsuarioById($id, $activo = false, $show_password = false) {
        // Escribimos la consulta básica para prepararla
        // The basic query starts here
        $sql = "select * from usuario where id_usuario = ? ";

        if ($activo) {
            $sql .= " AND estado = 'activo' ";
        }// the status of the user gets included

        // Abrimos la conexion de la base de datos
        // The connection to the database is open
        $db = new DB();

        // La siguiente llamada puede generar una excepción, que habrá que recoger en el método que la llame, o dejar que se propague
        // The sentence gets prepared in the variable $mysqli
        $mysqli = $db->conecta();
                    
        // Preparaos la sentencia anterior
        // The sentence gets prepared in the variable $stmt
        if ($stmt = $mysqli->prepare($sql)) {
            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            // the value of id is asigned with the datatype that they are using the method bind_param
            $stmt->bind_param('i', $id);

            // Ejecutamos la sentencia con los valores ya establecidos
            // The request gets process
            $stmt->execute();

            if ($stmt->errno) {
                throw new Exception("Error de conexión con la BD");
            }
                        
            // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
            // Once that the resquest is done, we get an object with the information. It is easier to manupulate
            $result = $stmt->get_result();

            // Le pedimos al objeto de resultados que nos devuelva una fila (en este caso la unica) en forma de array asociativo
            // to display the results of the object, we ask to print them in a single line
            $usuarios = $result->fetch_all(MYSQLI_ASSOC);
            
            // Cerramos la conexión
            // We disconnect the connection from the database
            $stmt->close();
            
            if(sizeof($usuarios) !== 1) {
                // La consulta ha devuelto 0 ó más de 1 resultado, por tanto el login introducido no era correcto o existe un problema con el usuario
                // If there size is 0 or more than 1 there is an error with the login of with the itreview requested. The user gets informed with an error message
                throw new UsuarioNotFoundException("El usuario con id $id no existe");
            }

            // Puesto que esta consulta sólo ha devuelto 1 usuario, obtenemos los datos de la primera posición del array
            // if the size 1, the object indivudual would display the only entrevista individual that the user has requested and it is in the first position so position 0
            $usuario = $usuarios[0];

            // Si no queremos mostrar el password, mandaremos una cadena vacía
            // If we don't want to show their password, we send an empty array
            $usuario['password'] = $show_password?$usuario['password']:'';

            // Llamamos a un método que nos devolverá un objeto de tipo Usuario, Tecnologo, Promotor o Subreceptor, dependiendo del tipo
            // Call the method that will return the type of user that it is
            return Usuarios::getUsuarioTipado($usuario);
        }
        else {
            throw new Exception("Error de BD: " . $mysqli->error);
        }
    }

    public static function getAll($show_password = false, $activo = false) {
        // Escribimos la consulta básica para prepararla
        // The basic query starts here
        $sql = "select * from usuario ";

        if ($activo) {
            $sql .= " WHERE estado = 'activo' ";
        }// the status of the user gets included

        // Abrimos la conexion de la base de datos
        // The connection to the database is open
        $db = new DB();

        // La siguiente llamada puede generar una excepción, que habrá que recoger en el método que la llame, o dejar que se propague
        // The sentence gets prepared in the variable $mysqli
        $mysqli = $db->conecta();
        
                    
        // Creamos un array en el que guardaremos los usuarios
        // The users are stored in an array
        $array_usuarios = array();

        if ($result = $mysqli->query($sql)) {
            
            // Le pedimos al objeto de resultados que nos devuelva una fila (en este caso la unica) en forma de array asociativo
            // We ask the object to return the object the result in a single line
            while ($usuario = $result->fetch_assoc()) {
                // Si no queremos mostrar el password, mandaremos una cadena vacía
                // If we don't want to show their password, we send an empty array
                $usuario['password'] = $show_password?$usuario['password']:'';
                
                // Llamamos a un método que nos devolverá un objeto de tipo Usuario, Tecnologo, Promotor o Subreceptor, dependiendo del tipo
                // Call the method that will return the type of user that it is
                $array_usuarios[] = Usuarios::getUsuarioTipado($usuario);
            }

            // limpiamos los resultados de la memoria
            // Clean the results from the memory
            $result->free();
            // por último desconectamos de la base de datos
            // Disconnect from the database
            $mysqli->close();

            // Devolvemos el array
            // return the array_usuarios
            return $array_usuarios;
        }
        else {
            // por último desconectamos de la base de datos
            // Disconnect from the database
            $mysqli->close();
            throw new Exception("Error de BD: " . $mysqli->error);
        }
    }

    public static function buscaUsuarioSubreceptor($cadena, $show_password = false, $activo = true) {
        // Cadena debe llevar los % para poder compararse con parte de los nombres
        // we check the users by name. Using the % symbol we are looking in both side of the string for the letter to match 
        $cadena = "%$cadena%";

        // Escribimos la consulta básica para prepararla
        // We write the basic query
        $sql = "select * from usuario u, subreceptor s ";
        // the continuos are added
        $sql .= " WHERE u.id_usuario = s.id_subreceptor 
                  AND (
                      u.login like ? OR
                      u.nombre like ? OR
                      u.apellidos like ? OR
                      s.ubicacion like ?
                  )";

        if ($activo) {
            $sql .= " AND u.estado = 'activo' ";
        }// the status of the user gets included


        // Abrimos la conexion de la base de datos
        // We open the connection to the database
        $db = new DB();
        // La siguiente llamada puede generar una excepción, que habrá que recoger en el método que la llame, o dejar que se propague
        // The sentence gets prepared in the variable $mysqli
        $mysqli = $db->conecta();
        
        // Creamos un array en el que guardaremos los usuarios
        // The users are stored in an array
        $array_usuarios = array();

        // The sentence gets prepared in the variable $stmt
        if ($stmt = $mysqli->prepare($sql)) {
            
            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            // the value of the sentence are asigned with the datatype that they are using the method bind_param
            $stmt->bind_param('ssss', $cadena, $cadena, $cadena, $cadena);

            // Ejecutamos la sentencia con los valores ya establecidos
            // The request gets process
            $stmt->execute();

            if ($stmt->errno) {
                throw new Exception("Error de conexión con la BD");
            }
                                    
            // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
            // Once that the resquest is done, we get an object with the information. It is easier to manupulate
            $result = $stmt->get_result();

            // Le pedimos al objeto de resultados que nos devuelva una fila en forma de array asociativo
            // to display the results of the object, we ask to print them in a single line
            while ($usuario = $result->fetch_array(MYSQLI_ASSOC)) {
                
                // Si no queremos mostrar el password, mandaremos una cadena vacía
                // If we don't want to show their password, we send an empty array
                $usuario['password'] = $show_password?$usuario['password']:'';
                
                // Llamamos a un método que nos devolverá un objeto de tipo Usuario, Tecnologo, Promotor o Subreceptor, dependiendo del tipo
                // Call the method that will return the type of user that it is
                $array_usuarios[] = Usuarios::getUsuarioTipado($usuario);
            }

            // limpiamos los resultados de la memoria
            // Clean the results from the memory
            $result->free();
            // por último desconectamos de la base de datos

            $stmt->close();
            $mysqli->close();
            // Devolvemos el array
            // Return the array_usuarios
            return $array_usuarios;
        }
        else {
            // por último desconectamos de la base de datos
            // Disconnect from the database
            $mysqli->close();
            throw new Exception("Error de BD: " . $mysqli->error);
        }
    }

    public static function add($datos){
        // Vamos a comprobar primero que no existe un usuario con el login que se ha escrito
        // First we are going to check if the user exist
        try{
            Usuarios::getUsuarioByUsername($datos['login']);
            // Si el código ha llegado aquí, el usuario ya existía, ya que no ha entrado en el catch de la excepción
            // Lanzamos una nueva excepción indicando que el usuario existe
            // If the user exist a message is retunr to the user, informing about it. Because there can not be two users with the same name
            throw new ValidationException(serialize(array("login" => "El login introducido ya existe")));
        }
        catch (UsuarioNotFoundException $e) {
            // El usuario no existe, por tanto, podemos crearlo
            // Escribimos la consulta básica para prepararla
            // If the user does not exist, we can create a new one
            $sql = "insert into usuario (login, nombre, apellidos, tipo_de_usuario, estado, telefono, password) 
                    values (?, ?, ?, ?, ?, ?, ?) "; 
            // Abrimos la conexion de la base de datos
            // open the connection to the database
            $db = new DB();

            // No controlamos la excepción a propósito, ya que al ser una llamada ajax
            // The sentence gets prepared in the variable $mysqli
            $mysqli = $db->conecta();

            // Comprobaciones sobre los datos introducidos. Por ejemplo:Campos vacíos, El password tiene longitud adecuada
            // check for the correctness of the data that have been introduced

            // Errores será un array donde se guardarán los errores de validación del formulario, para después poder mostrarlas al usuario
            // Es MUY IMPORTANTE que las claves del array sean los nombres de los campos que venían en el formulario, para poder informar al usuario
            // posteriormente de cuales han sido los campos en los que se ha fallado
            // We create the arrau $errores to store any errors found in an array and afterwards will be returned to the user so he can know where is the error
            $errores = array();

            if (strlen($datos['login']) < Usuarios::MIN_TAM_LOGIN || strlen($datos['login']) > Usuarios::MAX_TAM_LOGIN) {
                $errores['login'] = "Tamaño del campo login incorrecto. Debe ser entre " . Usuarios::MIN_TAM_LOGIN . ' y ' . Usuarios::MAX_TAM_LOGIN . ' caracteres.';
            }   // size of the login

            if (strlen($datos['password']) < Usuarios::MIN_TAM_PASSWORD || strlen($datos['password']) > Usuarios::MAX_TAM_PASSWORD) {
                $errores['password'] = "Tamaño del campo password incorrecto. Debe ser entre " . Usuarios::MIN_TAM_PASSWORD . ' y ' . Usuarios::MAX_TAM_PASSWORD . ' caracteres.';
            }   // size of the password

            if (!in_array($datos['tipo_de_usuario'], Usuarios::tipos_usuario_permitidos)){
                $errores['tipo_de_usuario'] = "El tipo de usuario debe ser uno de los permitidos";
            }   // user type not permited

            // Ya hemos llegado al final de las validaciones. Si el array no está vacío, significa que han ocurrido errores, por tanto, lanzamos una excepción
            // If the size of the array $errores is bigger than 1 means that there are errors to be corrected
            if (sizeof($errores) > 0){
                throw new ValidationException (serialize($errores));
            }

            // Preparaos la sentencia anterior
            // Prepare the previous sentence
            $activo = 'activo'; 
            if ($stmt = $mysqli->prepare($sql)) {
                //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
                // Link the parameters with the values 
                $stmt->bind_param('sssssss', 
                    $datos['login'],
                    $datos['nombre'],
                    $datos['apellidos'],
                    $datos['tipo_de_usuario'],
                    $activo, 
                    $datos['telefono'],
                    password_hash($datos['password'],  PASSWORD_DEFAULT) // metodo de PHP
                );

                // La inserción de usuarios debe ejecutarse en una transacción, ya que si no podemos encontrar que el usuario se añadió a la tabla de usuarios pero no a la de promotor, tecnologo...
                // The insercion of an user must happen in a transaction
                $mysqli->autocommit(false);

                // Ejecutamos la sentencia con los valores ya establecidos
                // Execute the values of the sentence. If not successfully the user will received an error message
                if(!$stmt->execute()){
                    throw new Exception("Ocurrió un problema al introducir el usuario: " . $stmt->error);
                }

                $id_usuario = $mysqli->insert_id;

                // Ahora, si el usuario es tecnologo, promotor o subreceptor, vamos a incluir la fila en la tabla correspondiente
                // Depending on the type of user, we are going to introduce the specific attributes for each of them
                switch ($datos['tipo_de_usuario']) {
                    case "subreceptor":
                        $sql2 = "insert into subreceptor (id_subreceptor, ubicacion) values (?, ?)";
                        if($stmt2 = $mysqli->prepare($sql2)){
                            // Esta consulta necesita el id que se acaba de insertar (autogenerado por mysql) y la ubicacion
                            // We need the id of the and location for the subreceptor
                            $stmt2->bind_param('is', 
                                $id_usuario,
                                $datos['ubicacion']
                            );

                            if(!$stmt2->execute()){
                                throw new Exception("Ocurrió un problema al introducir el usuario: " . $stmt2->error);
                            }// Execute the values of the sentence. If not successfully the user will received an error message
                        }
                        else {
                            throw new Exception("Error de BD: " . $mysqli->error);
                        }
                        break;
                    case "promotor":

                        // Como los promotores dependen de un usuario subreceptor vamos primero a comprobar que el usuario existe, está activo y es subreceptor
                        // As the promotor depend on the subreceptor, firstly we check for the subrecpetor if exist and if it is active  
                        try {
                            $subreceptor = Usuarios::getUsuarioById($datos['id_subreceptor'], true);
                            if (!$subreceptor instanceof Subreceptor) {
                                throw new ValidationException(serialize(array('id_subreceptor' => "El usuario subreceptor " . $datos['id_subreceptor'] . " no existe")));
                            }
                        }
                        catch (UsuarioNotFoundException $e) {
                            throw new ValidationException(serialize(array('id_subreceptor' => "El usuario subreceptor " . $datos['id_subreceptor'] . " no existe")));
                        }
                        // Proceed to insert the promotor
                        $sql2 = "insert into promotor (id_usuario, id_subreceptor, id_cedula, organizacion) values (?, ?, ?, ?)";
                        if($stmt2 = $mysqli->prepare($sql2)){
                            // Esta consulta necesita el id que se acaba de insertar (autogenerado por mysql), el subreceptor con el que trabaja, su cedula y la organizacion
                            $stmt2->bind_param('iiss', 
                                $id_usuario,
                                $datos['id_subreceptor'],
                                $datos['id_cedula'],
                                $datos['organizacion']
                            );

                            if(!$stmt2->execute()){
                                throw new Exception("Ocurrió un problema al introducir el usuario: " . $stmt2->error);
                            }
                        }
                        else {
                            throw new Exception("Error de BD: " . $mysqli->error);
                        }
                        break;
                    case "tecnologo":
                        // prepare the sentence
                        $sql2 = "insert into tecnologo (id_tecnologo, numero_de_registro, id_cedula) values (?, ?, ?)";
                        if($stmt2 = $mysqli->prepare($sql2)){
                            // Esta consulta necesita el id que se acaba de insertar (autogenerado por mysql), el numero de registro y su cedula
                            // Associate the values introduce with the variables 
                            $stmt2->bind_param('iis', 
                                $id_usuario,
                                $datos['numero_de_registro'],
                                $datos['id_cedula']
                            );

                            if(!$stmt2->execute()){
                                throw new Exception("Ocurrió un problema al introducir el usuario: " . $stmt2->error);
                            }
                        }
                        else {
                            throw new Exception("Error de BD: " . $mysqli->error);
                        }
                        break;
                }

                // Si todo ha salido bien, ejecutamos la transacción
                // if all happen correctly, the transaction will execute
                $mysqli->commit();
                
                // por último desconectamos de la base de datos
                // Disconnect the database
                $stmt->close();
                $mysqli->close();
                        
            }
            else {
                throw new Exception("Error de BD: " . $mysqli->error);
            }
        }
    }
    // update infromation from the user 
    public static function update($usuario) {
        // Vamos a comprobar primero que el usuario ya existía
        // Chech if the user exist 
        try{
            // El parámetro activo debe estar a false, en caso contrario, si el usuario se va a "activar" (por lo que estaría desactivado) no se encontraría y fallaría
            Usuarios::getUsuarioByUsername($usuario->getLogin(), false);

            // El usuario existe, por tanto, podemos modificarlo
            // Escribimos la consulta básica para prepararla
            // Hay que tener en cuenta que ni el login ni el tipo de usuario se podrán cambiar, y que si el password llega vacío, no se modificará
            // the sentence starts. The fields of login and type of user will not be able to change. The password should come empty of would be modify
            $sql = "update usuario 
                    set nombre = ?, 
                    apellidos = ?,
                    estado = ?, 
                    telefono = ? ";

            //Si el password viene con algún valor, lo actualizaremos
            // if the field of the password bring a value, it will be updated
            if(!empty($usuario->getPassword())){
                $sql .= ", password = ? ";
            }

            $sql .= " where id_usuario = ?";

            // Abrimos la conexion de la base de datos
            // open the connection to the database
            $db = new DB();

            // No controlamos la excepción a propósito, ya que al ser una llamada ajax
            // The sentence gets prepared in the variable $mysqli
            $mysqli = $db->conecta();

            // TODO: Realizar comprobaciones sobre los datos introducidos. Por ejemplo: Campos vacíos, el password tiene longitud adecuada
            // check for the correctness of the data that have been introduced

            // Errores será un array donde se guardarán los errores de validación del formulario, para después poder mostrarlas al usuario
            // Es MUY IMPORTANTE que las claves del array sean los nombres de los campos que venían en el formulario, para poder informar al usuario
            // posteriormente de cuales han sido los campos en los que se ha fallado
            // We create the arrau $errores to store any errors found in an array and afterwards will be returned to the user so he can know where is the error
            $errores = array();

            // Si quiere cambiar el password, este debe ser válido
            // if the password change, it should be valid 
            if (!empty($usuario->getPassword()) && (strlen($usuario->getPassword()) < Usuarios::MIN_TAM_PASSWORD || strlen($usuario->getPassword()) > Usuarios::MAX_TAM_PASSWORD)) {
                $errores['password'] = "Tamaño del campo password incorrecto. Debe ser entre " . Usuarios::MIN_TAM_PASSWORD . ' y ' . Usuarios::MAX_TAM_PASSWORD . ' caracteres.';
            }

            // Ya hemos llegado al final de las validaciones. Si el array no está vacío, significa que han ocurrido errores, por tanto, lanzamos una excepción
            // If the size of the array $errores is bigger than 1 means that there are errors to be corrected
            if (sizeof($errores) > 0){
                throw new ValidationException (serialize($errores));
            }

            // Preparaos la sentencia anterior
            // Prepare the previous sentence
            $activo = $usuario->getActivo() ? "activo" : "no activo"; 

            if ($stmt = $mysqli->prepare($sql)) {
                //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
                // Tendremos en cuenta si hay que cambiar el password o no
                // Link the parameters with the values 
                // iF the password needs to be changed, will be different the sentence to execute
                if(!empty($usuario->getPassword())){
                    $stmt->bind_param("sssssi", 
                        $usuario->getNombre(),
                        $usuario->getApellidos(),
                        $activo,
                        $usuario->getTelefono(),
                        password_hash($usuario->getPassword(),  PASSWORD_DEFAULT),
                        $usuario->getId()
                    );
                }
                else {
                    $stmt->bind_param("ssssi", 
                        $usuario->getNombre(),
                        $usuario->getApellidos(),
                        $activo,
                        $usuario->getTelefono(),
                        $usuario->getId()
                    );
                }                

                // La inserción o modificación de usuarios debe ejecutarse en una transacción, ya que si no podemos encontrar que el usuario se añadió a la tabla de usuarios pero no a la de promotor, tecnologo...
                // The insercion of an user must happen in a transaction
                $mysqli->autocommit(false);

                // Ejecutamos la sentencia con los valores ya establecidos
                // Execute the values of the sentence. If not successfully the user will received an error message
                if(!$stmt->execute()){
                    throw new Exception("Ocurrió un problema al introducir el usuario: " . $stmt->error);
                }

                // Ahora, si el usuario es tecnologo, promotor o subreceptor, vamos a incluir la fila en la tabla correspondiente
                // Depending on the type of user, we are going to introduce the specific attributes for each of them
                switch ($usuario->getTipo_de_usuario()) {
                    case "subreceptor":
                        // Prepare the statement to Update subreceptor
                        $sql2 = "update subreceptor 
                                 set ubicacion = ?
                                 where id_subreceptor = ?";

                        if($stmt2 = $mysqli->prepare($sql2)){
                            $stmt2->bind_param('si', 
                                $usuario->getUbicacion(),
                                $usuario->getId()
                            );

                            if(!$stmt2->execute()){
                                throw new Exception("Ocurrió un problema al modificar el usuario: " . $stmt2->error);
                            }
                        }
                        else {
                            throw new Exception("Error de BD: " . $mysqli->error);
                        }
                        break;
                    case "promotor":
                        // Aquí no comprobaremos el subreceptor, ya que es un campo que no se permite actualizar
                        // we do not check the subreceptor has it is a field that can be updated
                        // Prepare the statement to Update promotor
                        $sql2 = "update promotor 
                                 set id_cedula = ?, 
                                 organizacion = ?
                                 where id_usuario = ?";
                                 
                        if($stmt2 = $mysqli->prepare($sql2)){

                            // Esta consulta necesita el id que se acaba de insertar (autogenerado por mysql), el subreceptor con el que trabaja, su cedula y la organizacion
                            $stmt2->bind_param('ssi', 
                                $usuario->getId_cedula(),
                                $usuario->getOrganizacion(),
                                $usuario->getId()
                            );

                            if(!$stmt2->execute()){
                                throw new Exception("Ocurrió un problema al modificar el usuario: " . $stmt2->error);
                            }
                        }
                        else {
                            throw new Exception("Error de BD: " . $mysqli->error);
                        }
                        break;
                    case "tecnologo":
                    // Prepare the statement to Update tecnologo
                        $sql2 = "update tecnologo 
                                 set numero_de_registro = ?, 
                                 id_cedula = ?
                                 where id_tecnologo = ?";
                        if($stmt2 = $mysqli->prepare($sql2)){
                            // Esta consulta necesita el id que se acaba de insertar (autogenerado por mysql), el numero de registro y su cedula
                            $stmt2->bind_param('isi', 
                                $usuario->getNumero_de_registro(),
                                $usuario->getId_cedula(),
                                $usuario->getId()
                            );

                            if(!$stmt2->execute()){
                                throw new Exception("Ocurrió un problema al modificar el usuario: " . $stmt2->error);
                            }
                        }
                        else {
                            throw new Exception("Error de BD: " . $mysqli->error);
                        }
                        break;
                }

                // Si todo ha salido bien, ejecutamos la transacción
                // If all work well, the transaction will be executed
                $mysqli->commit();
                
                // por último desconectamos de la base de datos
                // disconnect the database
                $stmt->close();
                $mysqli->close();
                        
            }
            else {
                throw new Exception("Error de BD: " . $mysqli->error);
            }

        }
        catch (UsuarioNotFoundException $e) {
            
        }
    }
    // the function will return the users by their type
    private static function getUsuarioTipado($usuario) {

        // Si el estado es activo, activo valdrá true, en caso contrario false. Esto se hace así para simplificar 
        // Activo will be assign to true and false the opposite
        $usuario['activo'] = $usuario['estado'] === 'activo'?true:false;
        
        switch ($usuario["tipo_de_usuario"]){
            case "subreceptor":
                // Vamos a realizar otra consulta a la base de datos para traernos los tipos de datos específicos de este usuario
                // We query the database the infromation about the type of user 
                $sql = "select * from subreceptor where id_subreceptor = " . $usuario['id_usuario'];
                // Abrimos la conexion de la base de datos
                // we open the conexion to the database
                $db = new DB();

                // La siguiente llamada puede generar una excepción
                // The sentence gets prepared in the variable $mysqli
                $mysqli = $db->conecta();

                // the query will return the subreceotres 
                if ($result = $mysqli->query($sql)) {
                    $subreceptor = $result->fetch_assoc();
                    return new Subreceptor(
                        $usuario['id_usuario'],
                        $usuario['login'],
                        $usuario['nombre'],
                        $usuario['apellidos'],
                        $usuario['tipo_de_usuario'],
                        $usuario['telefono'],
                        $usuario['password'],
                        $usuario['activo'],
                        $subreceptor['ubicacion']
                    );
                }
                else {
                    throw new Exception("Error de BD: " . $mysqli->error);
                }// if not, and exception will be sent back to the user
                
                break;
            case "promotor":
                // Vamos a realizar otra consulta a la base de datos para traernos los tipos de datos específicos de este usuario
                // We query the database the infromation about the type of user 
                $sql = "select * from promotor where id_usuario = " . $usuario['id_usuario'];
                // Abrimos la conexion de la base de datos
                // we open the conexion to the database
                $db = new DB();

                // La siguiente llamada puede generar una excepción
                // The sentence gets prepared in the variable $mysqli
                $mysqli = $db->conecta();

                // the query will return the promotores 
                if ($result = $mysqli->query($sql)) {
                    $promotor = $result->fetch_assoc();
                    return new Promotor(
                        $usuario['id_usuario'],
                        $usuario['login'],
                        $usuario['nombre'],
                        $usuario['apellidos'],
                        $usuario['tipo_de_usuario'],
                        $usuario['telefono'],
                        $usuario['password'],
                        $usuario['activo'],
                        $promotor['id_cedula'],
                        $promotor['organizacion'],
                        $promotor['id_subreceptor']
                    );
                }
                else {
                    throw new Exception("Error de BD: " . $sql);
                }   // if not, and exception will be sent back to the user

                break;
            case "tecnologo":
                // Vamos a realizar otra consulta a la base de datos para traernos los tipos de datos específicos de este usuario
                // We query the database the infromation about the type of user 
                $sql = "select * from tecnologo where id_tecnologo = " . $usuario['id_usuario'];
                // Abrimos la conexion de la base de datos
                // we open the conexion to the database
                $db = new DB();

                // La siguiente llamada puede generar una excepción
                // The sentence gets prepared in the variable $mysqli
                $mysqli = $db->conecta();

                // the query will return the tecnologos 
                if ($result = $mysqli->query($sql)) {
                    $tecnologo = $result->fetch_assoc();
                    return new Tecnologo(
                        $usuario['id_usuario'],
                        $usuario['login'],
                        $usuario['nombre'],
                        $usuario['apellidos'],
                        $usuario['tipo_de_usuario'],
                        $usuario['telefono'],
                        $usuario['password'],
                        $usuario['activo'],
                        $tecnologo['numero_de_registro']
                        //$tecnologo['id_cedula']
                    );
                }
                else {
                    throw new Exception("Error de BD: " . $mysqli->error);
                }// if not, and exception will be sent back to the user

                break;
            default:
                return new Usuario(
                    $usuario['id_usuario'],
                    $usuario['login'],
                    $usuario['nombre'],
                    $usuario['apellidos'],
                    $usuario['tipo_de_usuario'],
                    $usuario['telefono'],
                    $usuario['password'],
                    $usuario['activo']
                ); 
                break;
        }
    }
}
    // this exception is unique of this class
class UsuarioNotFoundException extends Exception {}
