<?php

/**
 * La clase Entrevista pertenece al Modelo 
 * 
 * Los atributos son prívados y las funciones publicas para permitir la manipulacion de los valores pero no de la clase
 */


abstract class Entrevista implements \JsonSerializable{

    private $id_promotor;
    private $id_cedula_persona_receptora;
    private $fecha;
    private $condones_entregados;
    private $lubricantes_entregados;
    private $materiales_educativos_entregados;

    public function __construct($id_promotor,$id_cedula_persona_receptora,$fecha,$condones_entregados,$lubricantes_entregados,$materiales_educativos_entregados){

        $this->id_promotor = $id_promotor;
        $this->id_cedula_persona_receptora = $id_cedula_persona_receptora;
        $this->fecha = $fecha;
        $this->condones_entregados = $condones_entregados;
        $this->lubricantes_entregados = $lubricantes_entregados;
        $this->materiales_educativos_entregados = $materiales_educativos_entregados;

    }

    public function setId_promotor ($id_promotor){
        $this->id_promotor = $id_promotor;
    }

    public function getId_promotor (){
        return $this->id_promotor;
    }

    public function setid_cedula_persona_receptora ($id_cedula_persona_receptora){
        $this->id_cedula_persona_receptora = $id_cedula_persona_receptora;
    }

    public function getid_cedula_persona_receptora (){
        return $this->id_cedula_persona_receptora;
    }

    public function setFecha ($fecha){
        $this->fecha = $fecha;
    }

    public function getFecha (){
        return $this->fecha;
    }

    public function setCondones_entregados ($condones_entregados){
        $this->condones_entregados = $condones_entregados;
    }

    public function getCondones_entregados (){
        return $this->condones_entregados;
    }

    public function setLubricantes_entregados ($lubricantes_entregados){
        $this->lubricantes_entregados = $lubricantes_entregados;
    }

    public function getLubricantes_entregados (){
        return $this->lubricantes_entregados;
    }

    public function setMateriales_educativos_entregados($materiales_educativos_entregados){
        $this->materiales_educativos_entregados = $materiales_educativos_entregados;
    }

    public function getMateriales_educativos_entregados(){
        return $this->materiales_educativos_entregados;
    }

    /**
     * Este método devuelve todas las propiedades del objeto Entrevista, tanto públicas como privadas como un objeto JSon
     * Resulta mas rapido y ligero para manipular
     */

     public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }
}