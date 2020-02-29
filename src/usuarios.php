<?php

/**
 * EL fichero tiene todas las funciones que el Administrador tiene para manipular el objeto Usuario
 * Los ficheros que pueden ser necesitados en las diversas manipulaciones han sido llamados al principio
 */

require_once __DIR__ . '/../lib/DB.php';
require_once __DIR__ . '/Usuario.php';
require_once __DIR__ . '/Excepciones.php';

class Usuarios {
    // Declaramos algunas constantes que van a hacer mas facil la insercion de datos haciendo cumplir las condiciones descritas
    const MIN_TAM_LOGIN = 8;
    const MAX_TAM_LOGIN = 16;
    const MIN_TAM_PASSWORD = 8;
    const MAX_TAM_PASSWORD = 16;
    const tipos_usuario_permitidos = array('administrador', 'subreceptor', 'promotor', 'tecnologo');

    /**
     * Devuelve un objeto Usuario (o un subtipo del mismo), cuyo login coincida con $username. Si no, lanza una excepción UsuarioNotFoundException
     */
    public static function getUsuarioByUsername($username = '', $activo = true, $show_password = false) {
        // Escribimos la consulta básica para prepararla
        $sql = "select * from usuario where login = ? ";

        if ($activo) {
            $sql .= " AND estado = 'activo' ";
        }// se añade el status del usuario

        // Abrimos la conexion de la base de datos
        $db = new DB();

        // La siguiente llamada puede generar una excepción, que habrá que recoger en el método que la llame, o dejar que se propague
        // la conexion se prepara en la variable $mysqli
        $mysqli = $db->conecta();
                    
        // Preparaos la sentencia dentro de la variable $stmt
        if ($stmt = $mysqli->prepare($sql)) {
            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno a traves del metodo bind_param
            $stmt->bind_param('s', $username);

            // Ejecutamos la sentencia con los valores ya establecidos
            $stmt->execute();

            if ($stmt->errno) {
                // si hay errores en la conexion a la BD, deben recogerse aqui
                throw new Exception("Error de conexión con la BD");
            }
                        
            // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
            // haciendose mas facil la manipulacion de los resultados desde un objeto
            $result = $stmt->get_result();

            // Le pedimos al objeto de resultados que nos devuelva una fila (en este caso la unica) en forma de array asociativo
            $usuarios = $result->fetch_all(MYSQLI_ASSOC);
            
            // Cerramos la conexión
            $stmt->close();
            
            if(sizeof($usuarios) !== 1) {
                // Si la consulta ha devuelto 0 ó más de 1 resultado, por tanto el login introducido no era correcto o existe un problema con el usuario
                // El usuario recibiría un mensaje informandole de que hubo un error y que dicho usuario no existe
                throw new UsuarioNotFoundException("El usuario con username $username no existe");
            }

            // Puesto que esta consulta sólo ha devuelto 1 usuario, obtenemos los datos de la primera posición del array
            $usuario = $usuarios[0];

            // Si no queremos mostrar el password, mandaremos una cadena vacía
            $usuario['password'] = $show_password?$usuario['password']:'';

            // Llamamos a un método que nos devolverá un objeto de tipo Usuario, Tecnologo, Promotor o Subreceptor, dependiendo del tipo
            return Usuarios::getUsuarioTipado($usuario);
        }
        else {
            throw new Exception("Error de BD: " . $mysqli->error);
        }
    }

    /**
     * Devuelve un objeto Usuario (o un subtipo del mismo), cuyo identificador coincida con $id. Si no, lanza una excepción UsuarioNotFoundException
     * En este caso, se busca por defecto el usuario, esté activo o no
     */
    public static function getUsuarioById($id, $activo = false, $show_password = false) {
        // Escribimos la consulta básica para prepararla
        $sql = "select * from usuario where id_usuario = ? ";

        if ($activo) {
            $sql .= " AND estado = 'activo' ";
        }// Se incluye el estatus del usuario

        // Abrimos la conexion de la base de datos
        $db = new DB();

        // La siguiente llamada puede generar una excepción, que habrá que recoger en el método que la llame, o dejar que se propague
        $mysqli = $db->conecta();
                    
        // Preparaos la sentencia anterior
        if ($stmt = $mysqli->prepare($sql)) {
            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno a traves de bind_param
            $stmt->bind_param('i', $id);

            // Ejecutamos la sentencia con los valores ya establecidos
            $stmt->execute();

            if ($stmt->errno) {
                throw new Exception("Error de conexión con la BD");
            }
                        
            // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
            $result = $stmt->get_result();

            // Le pedimos al objeto de resultados que nos devuelva una fila (en este caso la unica) en forma de array asociativo
            $usuarios = $result->fetch_all(MYSQLI_ASSOC);
            
            // Cerramos la conexión
            $stmt->close();
            
            if(sizeof($usuarios) !== 1) {
                // La consulta ha devuelto 0 ó más de 1 resultado, por tanto el login introducido no era correcto o existe un problema con el usuario
                throw new UsuarioNotFoundException("El usuario con id $id no existe");
            }

            // Puesto que esta consulta sólo ha devuelto 1 usuario, obtenemos los datos de la primera posición del array
            $usuario = $usuarios[0];

            // Si no queremos mostrar el password, mandaremos una cadena vacía
            $usuario['password'] = $show_password?$usuario['password']:'';

            // Llamamos a un método que nos devolverá un objeto de tipo Usuario, Tecnologo, Promotor o Subreceptor, dependiendo del tipo
            return Usuarios::getUsuarioTipado($usuario);
        }
        else {
            throw new Exception("Error de BD: " . $mysqli->error);
        }
    }

    /**
     * La funcion devuelve todos los usuarios registrados
     */
    public static function getAll($show_password = false, $activo = false) {
        // Escribimos la consulta básica para prepararla
        $sql = "select * from usuario ";

        if ($activo) {
            $sql .= " WHERE estado = 'activo' ";
        }// Se incluye en status del usuario

        // Abrimos la conexion de la base de datos
        $db = new DB();

        // La siguiente llamada puede generar una excepción, que habrá que recoger en el método que la llame, o dejar que se propague
        $mysqli = $db->conecta();
        
                    
        // Creamos un array en el que guardaremos los usuarios
        $array_usuarios = array();

        if ($result = $mysqli->query($sql)) {
            
            // Le pedimos al objeto de resultados que nos devuelva una fila (en este caso la unica) en forma de array asociativo
            while ($usuario = $result->fetch_assoc()) {
                // Si no queremos mostrar el password, mandaremos una cadena vacía
                $usuario['password'] = $show_password?$usuario['password']:'';
                
                // Llamamos a un método que nos devolverá un objeto de tipo Usuario, Tecnologo, Promotor o Subreceptor, dependiendo del tipo
                $array_usuarios[] = Usuarios::getUsuarioTipado($usuario);
            }

            // limpiamos los resultados de la memoria
            $result->free();
            // por último desconectamos de la base de datos
            $mysqli->close();

            // Devolvemos el array
            return $array_usuarios;
        }
        else {
            // por último desconectamos de la base de datos
            $mysqli->close();
            throw new Exception("Error de BD: " . $mysqli->error);
        }
    }

    /**
     * La funcion buscará a los subrecptores al tiempo que introducimos caracteres en el formulario
     * Si existen, casi con toda seguridad estos aparecerán en la pantalla antes de acabar de teclear el nombre completo
     */
    public static function buscaUsuarioSubreceptor($cadena, $show_password = false, $activo = true) {
        // Cadena debe llevar los % para poder compararse con parte de los nombres
        $cadena = "%$cadena%";

        // Escribimos la consulta básica para prepararla
        $sql = "select * from usuario u, subreceptor s ";
        // Se puede realizar la busqueda por nombre, login, apellidos o ubicación
        $sql .= " WHERE u.id_usuario = s.id_subreceptor 
                  AND (
                      u.login like ? OR
                      u.nombre like ? OR
                      u.apellidos like ? OR
                      s.ubicacion like ?
                  )";

        if ($activo) {
            $sql .= " AND u.estado = 'activo' ";
        }// Se añade el parametro del status


        // Abrimos la conexion de la base de datos
        $db = new DB();

        // La siguiente llamada puede generar una excepción, que habrá que recoger en el método que la llame, o dejar que se propague
        $mysqli = $db->conecta();
        
        // Creamos un array en el que guardaremos los usuarios
        $array_usuarios = array();

        // Se preprara la sentencia en la variable $stmt
        if ($stmt = $mysqli->prepare($sql)) {
            
            //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
            $stmt->bind_param('ssss', $cadena, $cadena, $cadena, $cadena);

            // Ejecutamos la sentencia con los valores ya establecidos
            $stmt->execute();

            if ($stmt->errno) {
                throw new Exception("Error de conexión con la BD");
            }
                                    
            // Una vez ejecutada la consulta, obtenemos un objeto que tendra todos los resultados que la consulta haya obtenido
            $result = $stmt->get_result();

            // Le pedimos al objeto de resultados que nos devuelva una fila en forma de array asociativo
            while ($usuario = $result->fetch_array(MYSQLI_ASSOC)) {
                
                // Si no queremos mostrar el password, mandaremos una cadena vacía
                $usuario['password'] = $show_password?$usuario['password']:'';
                
                // Llamamos a un método que nos devolverá un objeto de tipo Usuario, Tecnologo, Promotor o Subreceptor, dependiendo del tipo
                $array_usuarios[] = Usuarios::getUsuarioTipado($usuario);
            }

            // limpiamos los resultados de la memoria
            $result->free();
            // por último desconectamos de la base de datos

            $stmt->close();
            $mysqli->close();
            // Devolvemos el array
            return $array_usuarios;
        }
        else {
            // por último desconectamos de la base de datos
            $mysqli->close();
            throw new Exception("Error de BD: " . $mysqli->error);
        }
    }

    /**
     * La funcion sirve para añadir usuarios 
     */
    public static function add($datos){
        // Vamos a comprobar primero que no existe un usuario con el login que se ha escrito
        try{
            Usuarios::getUsuarioByUsername($datos['login']);
            // Si el código ha llegado aquí, el usuario ya existía, ya que no ha entrado en el catch de la excepción
            // Lanzamos una nueva excepción indicando que el usuario existe
            throw new ValidationException(serialize(array("login" => "El login introducido ya existe")));
        }
        catch (UsuarioNotFoundException $e) {
            // El usuario no existe, por tanto, podemos crearlo
            // Escribimos la consulta básica para prepararla
            $sql = "insert into usuario (login, nombre, apellidos, tipo_de_usuario, estado, telefono, password) 
                    values (?, ?, ?, ?, ?, ?, ?) "; 
            // Abrimos la conexion de la base de datos
            $db = new DB();

            // No controlamos la excepción a propósito, ya que al ser una llamada ajax
            $mysqli = $db->conecta();

            // Comprobaciones sobre los datos introducidos. Por ejemplo:Campos vacíos, El password tiene longitud adecuada

            // Errores será un array donde se guardarán los errores de validación del formulario, para después poder mostrarlas al usuario
            // Es FUNDAMENTAL que las claves del array sean los nombres de los campos que venían en el formulario, para poder informar al usuario
            // posteriormente de cuales han sido los campos en los que se ha fallado
            $errores = array();

            if (strlen($datos['login']) < Usuarios::MIN_TAM_LOGIN || strlen($datos['login']) > Usuarios::MAX_TAM_LOGIN) {
                $errores['login'] = "Tamaño del campo login incorrecto. Debe ser entre " . Usuarios::MIN_TAM_LOGIN . ' y ' . Usuarios::MAX_TAM_LOGIN . ' caracteres.';
            }   // El tamaño maximo del nombre de acceso

            if (strlen($datos['password']) < Usuarios::MIN_TAM_PASSWORD || strlen($datos['password']) > Usuarios::MAX_TAM_PASSWORD) {
                $errores['password'] = "Tamaño del campo password incorrecto. Debe ser entre " . Usuarios::MIN_TAM_PASSWORD . ' y ' . Usuarios::MAX_TAM_PASSWORD . ' caracteres.';
            }   // El tamaño del password

            if (!in_array($datos['tipo_de_usuario'], Usuarios::tipos_usuario_permitidos)){
                $errores['tipo_de_usuario'] = "El tipo de usuario debe ser uno de los permitidos";
            }   // El tipo de usuario no permitido

            // Ya hemos llegado al final de las validaciones. Si el array no está vacío, significa que han ocurrido errores, por tanto, lanzamos una excepción
            if (sizeof($errores) > 0){
                throw new ValidationException (serialize($errores));
            }

            // Preparaos la sentencia anterior
            $activo = 'activo'; 
            if ($stmt = $mysqli->prepare($sql)) {
                //Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
                $stmt->bind_param('sssssss', 
                    $datos['login'],
                    $datos['nombre'],
                    $datos['apellidos'],
                    $datos['tipo_de_usuario'],
                    $activo, 
                    $datos['telefono'],
                    password_hash($datos['password'],  PASSWORD_DEFAULT) // metodo de PHP para encriptar el password
                );

                // La inserción de usuarios debe ejecutarse en una transacción, ya que si no podemos encontrar que 
                // el usuario se añadió a la tabla de usuarios pero no a la de promotor, tecnologo...
                $mysqli->autocommit(false);

                // Ejecutamos la sentencia con los valores ya establecidos
                if(!$stmt->execute()){
                    throw new Exception("Ocurrió un problema al introducir el usuario: " . $stmt->error);
                }

                $id_usuario = $mysqli->insert_id;

                // Ahora, si el usuario es tecnologo, promotor o subreceptor, vamos a incluir la fila en la tabla correspondiente
                switch ($datos['tipo_de_usuario']) {
                    case "subreceptor":
                        $sql2 = "insert into subreceptor (id_subreceptor, ubicacion) values (?, ?)";
                        if($stmt2 = $mysqli->prepare($sql2)){
                            // Esta consulta necesita el id que se acaba de insertar (autogenerado por mysql) y la ubicacion
                            $stmt2->bind_param('is', 
                                $id_usuario,
                                $datos['ubicacion']
                            );

                            if(!$stmt2->execute()){
                                throw new Exception("Ocurrió un problema al introducir el usuario: " . $stmt2->error);
                            }// Ejecutar los valores de la sentencia. En caso de no ser correcta, se recibirá un mensaje de error 
                        }
                        else {
                            throw new Exception("Error de BD: " . $mysqli->error);
                        }
                        break;
                    case "promotor":

                        // Como los promotores dependen de un usuario subreceptor vamos primero a comprobar que el usuario existe, está activo y es subreceptor
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
                        // Prepara la sentencia
                        $sql2 = "insert into tecnologo (id_tecnologo, numero_de_registro) values (?, ?)";
                        if($stmt2 = $mysqli->prepare($sql2)){
                            // Esta consulta necesita el id que se acaba de insertar (autogenerado por mysql) el numero de registro 
                            $stmt2->bind_param('ii', 
                                $id_usuario,
                                $datos['numero_de_registro']
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
                $mysqli->commit();
                
                // por último desconectamos de la base de datos
                $stmt->close();
                $mysqli->close();
                        
            }
            else {
                throw new Exception("Error de BD: " . $mysqli->error);
            }
        }
    }

    /**
     * La funcion sirve para actualizar datos del usuario
     */
    public static function update($usuario) {
        // Vamos a comprobar primero que el usuario ya existía
        try{
            // El parámetro activo debe estar a false, en caso contrario, 
            // si el usuario se va a "activar" (por lo que estaría desactivado) no se encontraría y fallaría
            Usuarios::getUsuarioByUsername($usuario->getLogin(), false);

            // El usuario existe, por tanto, podemos modificarlo
            // Escribimos la consulta básica para prepararla
            // Hay que tener en cuenta que ni el login ni el tipo de usuario se podrán cambiar, y que si el password llega vacío, no se modificará
            $sql = "update usuario 
                    set nombre = ?, 
                    apellidos = ?,
                    estado = ?, 
                    telefono = ? ";

            //Si el password viene con algún valor, lo actualizaremos
            if(!empty($usuario->getPassword())){
                $sql .= ", password = ? ";
            }

            $sql .= " where id_usuario = ?";

            // Abrimos la conexion de la base de datos
            $db = new DB();

            // No controlamos la excepción a propósito, porque es una llamada ajax
            $mysqli = $db->conecta();

            // Errores será un array donde se guardarán los errores de validación del formulario, para después poder mostrarlas al usuario
            // Es MUY IMPORTANTE que las claves del array sean los nombres de los campos que venían en el formulario, para poder informar al usuario
            // posteriormente de cuales han sido los campos en los que se ha fallado
            $errores = array();

            // Si quiere cambiar el password, este debe ser válido
            if (!empty($usuario->getPassword()) && (strlen($usuario->getPassword()) < Usuarios::MIN_TAM_PASSWORD || strlen($usuario->getPassword()) > Usuarios::MAX_TAM_PASSWORD)) {
                $errores['password'] = "Tamaño del campo password incorrecto. Debe ser entre " . Usuarios::MIN_TAM_PASSWORD . ' y ' . Usuarios::MAX_TAM_PASSWORD . ' caracteres.';
            }

            // Ya hemos llegado al final de las validaciones. 
            // Si el array no está vacío, significa que han ocurrido errores, por tanto, lanzamos una excepción
            if (sizeof($errores) > 0){
                throw new ValidationException (serialize($errores));
            }

            // Preparaos la sentencia anterior
            $activo = $usuario->getActivo() ? "activo" : "no activo"; 

            if ($stmt = $mysqli->prepare($sql)) {
                // Enlazamos los parametros con los valores pasados, indicando ademas el tipo de cada uno
                // Tendremos en cuenta si hay que cambiar el password o no
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
                $mysqli->autocommit(false);

                // Ejecutamos la sentencia con los valores ya establecidos
                if(!$stmt->execute()){
                    throw new Exception("Ocurrió un problema al introducir el usuario: " . $stmt->error);
                }

                // Ahora, si el usuario es tecnologo, promotor o subreceptor, vamos a incluir la fila en la tabla correspondiente
                switch ($usuario->getTipo_de_usuario()) {
                    case "subreceptor":
                        // Prepara la sentnecia para actualizar al subrecpetor 
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
                        
                        // Prepara la sentnecia para actualizar al Promotor
                        $sql2 = "update promotor 
                                 set id_cedula = ?, 
                                 organizacion = ?
                                 where id_usuario = ?";
                                 
                        if($stmt2 = $mysqli->prepare($sql2)){

                            // Esta consulta necesita el id que se acaba de insertar (autogenerado por mysql),
                            // el subreceptor con el que trabaja, su cedula y la organizacion
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
                    // Prepara la sentnecia para actualizar al Tecnologo
                        $sql2 = "update tecnologo 
                                 set numero_de_registro = ?, 
                                 where id_tecnologo = ?";
                        if($stmt2 = $mysqli->prepare($sql2)){
                            // Esta consulta necesita el id que se acaba de insertar (autogenerado por mysql), 
                            // el numero de registro y id
                            $stmt2->bind_param('ii', 
                                $usuario->getNumero_de_registro(),
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
                $mysqli->commit();
                
                // por último desconectamos de la base de datos
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
    /**
     * La funcion devuelve a los usuarios segun su tipo
     */
    private static function getUsuarioTipado($usuario) {

        // Si el estado es activo, activo valdrá true, en caso contrario false. Esto se hace así para simplificar 
        $usuario['activo'] = $usuario['estado'] === 'activo'?true:false;
        
        switch ($usuario["tipo_de_usuario"]){
            case "subreceptor":
                // Vamos a realizar otra consulta a la base de datos para traernos los tipos de datos específicos de este usuario
                $sql = "select * from subreceptor where id_subreceptor = " . $usuario['id_usuario'];
                // Abrimos la conexion de la base de datos
                $db = new DB();

                // La siguiente llamada puede generar una excepción
                $mysqli = $db->conecta();

                // La petición devolverá a los subrecpetores 
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
                }// En caso de no ser así, devolverá un mensaje informando del fallo
                
                break;
            case "promotor":
                // Vamos a realizar otra consulta a la base de datos para traernos los tipos de datos específicos de este usuario
                $sql = "select * from promotor where id_usuario = " . $usuario['id_usuario'];
                // Abrimos la conexion de la base de datos
                $db = new DB();

                // La siguiente llamada puede generar una excepción
                $mysqli = $db->conecta();

                // La petición devolverá a los promotores 
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
                }   // En caso de no ser así, devolverá un mensaje informando del fallo

                break;
            case "tecnologo":
                // Vamos a realizar otra consulta a la base de datos para traernos los tipos de datos específicos de este usuario
                $sql = "select * from tecnologo where id_tecnologo = " . $usuario['id_usuario'];
                // Abrimos la conexion de la base de datos
                $db = new DB();

                // La siguiente llamada puede generar una excepción
                $mysqli = $db->conecta();

                // La petición devuelve a los tecnologos 
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
                    );
                }
                else {
                    throw new Exception("Error de BD: " . $mysqli->error);
                }   // En caso de no ser así, devolverá un mensaje informando del fallo

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
    // Este excepcion es unica de esta clase 
class UsuarioNotFoundException extends Exception {}
