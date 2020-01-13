<?php
// The class Alcanzada belong to the Model.  
// The atributes are private and the functions public in order to allow the manipulation of the value of the instances and not the class
require_once __DIR__ . '/PersonaReceptora.php';

class PersonaAlcanzada extends PersonaReceptora{
    
    private $fecha_alcanzado;
    private $region_de_salud;

    public function __construct(
        $id_cedula_persona_receptora, 
        $fecha_alcanzado,                           // Parece que tengo que poner todos los argumentos que vienen 
        $region_de_salud,                           // de la clase padre. Aunque realmente yo no los necesito
        $poblacion_originaria,                      // hay alguna forma para no ponerlos todos 
        $poblacion,                                 // ...o mas bien la herencia tiene que hacerse aqui solo(linea 20)
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
     * Este método devuelve todas las propiedades del objeto Alcanzada, tanto públicas como privadas
     * The method json Serialize return all the attributes of the object class. It is needed to maniplate the information in a lighter and faster way
     */
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

}