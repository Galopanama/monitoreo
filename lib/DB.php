<?php

class DB {
    private $conexion;

    public function conecta () {
        $this->conexion = new mysqli('127.0.0.1', 'root', 'Panama2019', 'monitoreo_y_evaluacion');
        if ($this->conexion->connect_errno) {
            echo "fallo al cargar";
        }
        return $this->conexion;
    }

    public function desconecta() {
        $this->conexion->close();
    }
}