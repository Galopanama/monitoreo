<?php
// The class PersonaReceptora belong to the Model.  
// The atributes are private and the functions public in order to allow the manipulation of the value of the instances and not the class

class PersonaReceptora implements \JsonSerializable{

    private $id_cedula;
    private $poblacion_originaria;
    private $poblacion;
    private $datos_actualizados;

    public function __construct($id_cedula,$poblacion_originaria,$poblacion, $datos_actualizados){

        $this->id_cedula = $id_cedula;
        $this->poblacion_originaria = $poblacion_originaria;
        $this->poblacion = $poblacion;
        $this->datos_actualizados = $datos_actualizados;
    }

    public function setId_cedula ($id_cedula){
        $this->id_cedula = $id_cedula;
    }

    public function getId_cedula (){
        return $this->id_cedula;
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
     * Este método devuelve todas las propiedades del objeto Usuario, tanto públicas como privadas
     * The method json Serialize return all the attributes of the object class. It is needed to maniplate the infromation in a lighter and faster way
     */
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }
}

?>