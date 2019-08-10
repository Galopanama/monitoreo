<?php

class DB {
    private $conexion;

    public function conecta () {
        $this->conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conexion->connect_errno) {
            throw new Exception("Fallo de BD: " . $this->conexion->connect_error);
        }
        return $this->conexion;
    }

    public function desconecta() {
        $this->conexion->close();
    }
}