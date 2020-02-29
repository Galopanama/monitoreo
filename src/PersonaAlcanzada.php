<?php

/**
 * La clase PersoanAlcnazada pertenece al Modelo
 * Es una clase hija de PersonaReceptora, por lo que hereda todos los atributos de esta, añadiendo algunos propios
 * Los atributos son prívados y las funciones publicas para permitir la manipulacion de los valores pero no de la clase
 * 
 * Se llama a la Clase Entrevista para traer todos sus atributos y métodos
 */ 

require_once __DIR__ . '/PersonaReceptora.php';

class PersonaAlcanzada extends PersonaReceptora{
    
    private $fecha_alcanzado;
    private $region_de_salud;

    public function __construct(
        $id_cedula_persona_receptora, 
        $fecha_alcanzado,                           
        $region_de_salud,                           
        $poblacion_originaria,                       
        $poblacion,                                 
        $datos_actualizados)
    {
    
        parent::__construct($id_cedula_persona_receptora, $poblacion_originaria, $poblacion, $datos_actualizados);     
        $this->fecha_alcanzado = $fecha_alcanzado;
        $this->region_de_salud = $region_de_salud;

    }

    public function setFecha_alcanzado($fecha_alcanzado){
        $this->fecha_alcanzado = $fecha_alcanzado;
    }

    public function getFecha_alcanzado(){
        return $this->fecha_alcanzado;
    }
    
    public function setRegion_de_salud($region_de_salud){
        $this->region_de_salud = $region_de_salud;
    }

    public function getRegion_de_salud(){
        return $this->region_de_salud;
    }

    /**
     * Este método devuelve todas las propiedades del objeto PersonaAlcanzada, tanto públicas como privadas como un objeto JSon
     * Resulta mas rapido y ligero para manipular
     */

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

}