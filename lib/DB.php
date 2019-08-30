<?php

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

    // Después de muchos errores, se decide eliminar el uso de desconecta()

}