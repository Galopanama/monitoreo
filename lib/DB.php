<?php
// The object DB has been created to manipulate the information stored in the Database with more flexiblity 
// Each time that the user starts a session, it will created and object and infromation will be manipulated from there. 
// There are two functions, one create the connection, that works like the construct of the class
// While the other function (getConexion) is a getter and will allow the interaction to the database
class DB {
    private $conexion;

    public function conecta () {
        if (!isset($this->conexion)){
            // Abrimos la conexión con los parámetros de la base de datos que hay en config.php
            // The connection with the database is requested with the data that is in the file config.php 
            $this->conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // Si se ha producido un error conectando lanzamos una excepción
            // If there are any errors with the connection a message will inform the user about it with a message
            if ($this->conexion->connect_errno) {
                throw new Exception("Fallo de BD: " . $this->conexion->connect_error);
            }
        }

        // Si todo ha ido bien, devolvemos el objeto de la conexión
        // If everythign went well, thee conection will be return
        return $this->conexion;
    }

    public function getConexion() {
        return $this->conexion;
    }

}