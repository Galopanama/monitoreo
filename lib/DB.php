<?php
/**
 * El objeto DB ha sido creado con el objetivo de manipular la informacion almacenada en la Base de datos
 * con mayor flexibilidad. Cada vez que un usuario empieza una sesion, se crea un objeto desde donde se
 * manipulará la informacion de manera más facil.
 * Contiene dos funciones por lo tanto. Una es la creacion de una conexion, que funciona como el constructor de clase
 * La otra funcion (getConexion) permitirá la interaccion con la base de datos
 */
class DB {
    private $conexion;

    public function conecta () {
        if (!isset($this->conexion)){
            // Abrimos la conexión con los parámetros de la base de datos que hay en config.php
            $this->conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // Si se ha producido un error conectando lanzamos una excepción
            if ($this->conexion->connect_errno) {
                throw new Exception("Fallo de BD: " . $this->conexion->connect_error);
            }
        }

        // Si todo ha ido bien, devolvemos el objeto de la conexión
        return $this->conexion;
    }

    public function getConexion() {
        return $this->conexion;
    }

}