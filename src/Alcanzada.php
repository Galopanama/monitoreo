<?php
// The class Alcanzada belong to the Model.  
// The atributes are private and the functions public in order to allow the manipulation of the value of the instances and not the class


class Alcanzada implements \JsonSerializable{
    private $id_cedula_persona_receptora;
    private $fecha;
    private $region_de_salud;

    public function __construct($id_cedula_persona_receptora, $fecha, $region_de_salud){
    
        $this->id_cedula_persona_receptora = $id_cedula_persona_receptora;
        $this->fecha = $fecha;
        $this->region_de_salud = $region_de_salud;

    }

    public function setId_cedula_persona_receptora($id_cedula_persona_receptora){
        $this->id_cedula_persona_receptora = $id_cedula_persona_receptora;
    }

    public function getId_cedula_persona_receptora(){
        return $this->id_cedula_persona_receptora;
    }

    public function setFecha($fecha){
        $this->fecha = $fecha;
    }

    public function getFecha(){
        return $this->fecha;
    }
    
    public function setRegion_de_salud($region_de_salud){
        $this->region_de_salud = $region_de_salud;
    }

    public function getRegion_de_salud(){
        return $this->region_de_salud;
    }

    /**
     * Este método devuelve todas las propiedades del objeto Alcanzada, tanto públicas como privadas
     * The method json Serialize return all the attributes of the object class. It is needed to maniplate the information in a lighter and faster way
     */
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

}