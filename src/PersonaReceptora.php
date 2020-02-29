<?php

/**
 * LA clase PersonaReceptora pertenece al Modelo
 * Los atributos son privados y las funciones públicas para permitir la manipulacion de los valores pero no de la clase
 */


class PersonaReceptora implements \JsonSerializable{

    private $id_cedula_persona_receptora;
    private $poblacion_originaria;
    private $poblacion;
    private $datos_actualizados;

    public function __construct($id_cedula_persona_receptora,$poblacion_originaria,$poblacion, $datos_actualizados){

        $this->id_cedula_persona_receptora = $id_cedula_persona_receptora;
        $this->poblacion_originaria = $poblacion_originaria;
        $this->poblacion = $poblacion;
        $this->datos_actualizados = $datos_actualizados;
    }

    public function setId_cedula_persona_receptora ($id_cedula_persona_receptora){
        $this->id_cedula_persona_receptora= $id_cedula_persona_receptora;
    }

    public function getId_cedula_persona_receptora (){
        return $this->id_cedula_persona_receptora;
    }

    public function setPoblacion_originaria ($poblacion_originaria){
        $this->poblacion_originaria = $poblacion_originaria;
    }

    public function getPoblacion_originaria (){
        return $this->poblacion_originaria;
    }

    public function setPoblacion($poblacion){
        $this->poblacion = $poblacion;
    }

    public function getPoblacion(){
        return $this->poblacion;
    }    

    public function setDatosActualizados($datos_actualizados){
        $this->datos_actualizados = $datos_actualizados;
    }

    public function getDatosActualizados(){
        return $this->datos_actualizados;
    }

    /**
     * Este método devuelve todas las propiedades del objeto PersonaReceptora, tanto públicas como privadas como un objeto JSon
     * Resulta mas rapido y ligero para manipular
     */
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }
}

?>