<?php

// The class Prueba belong to the Model.  
// The atributes are private and the functions public in order to allow the manipulation of the value of the instances and not the class

class Prueba implements \JsonSerializable{

    private $id_tecnologo;
    private $id_cedula_persona_receptora;
    private $fecha;
    private $realizacion_prueba;
    private $consejeria_pre_prueba;
    private $consejeria_post_prueba;
    private $resultado_prueba;
    

    public function __construct($id_tecnologo,$id_cedula_persona_receptora,$fecha,$consejeria_pre_prueba,$consejeria_post_prueba,
    $resultado_prueba,$realizacion_prueba){

        $this->id_tecnologo = $id_tecnologo;
        $this->id_cedula_persona_receptora = $id_cedula_persona_receptora;
        $this->fecha = $fecha;
        $this->realizacion_prueba = $realizacion_prueba;
        $this->consejeria_pre_prueba = $consejeria_pre_prueba;
        $this->consejeria_post_prueba = $consejeria_post_prueba;
        $this->resultado_prueba = $resultado_prueba;

    } 

    public function setId_tecnologo ($id_tecnologo){
        $this->id_tecnologo = $id_tecnologo;
    }

    public function getId_tecnologo (){
        return $this->id_tecnologo; 
    }

    public function setId_cedula_persona_receptora ($id_cedula_persona_receptora){
        $this->id_cedula_persona_receptora = $id_cedula_persona_receptora;
    }

    public function getId_cedula_persona_receptora (){
        return $this->id_cedula_persona_receptora;
    }

    public function setFecha ($fecha){
        $this->fecha = $fecha;
    }

    public function getFecha (){
        return $this->fecha;
    }

    public function setRealizacion_prueba ($realizacion_prueba) {
        $this->realizacion_prueba = $realizacion_prueba;
    }  

    public function getRealizacion_prueba () {
        return $this->realizacion_prueba;
    }
    public function setConsejeria_pre_prueba ($consejeria_pre_prueba){
        $this->consejeria_pre_prueba = $consejeria_pre_prueba;
    }

    public function getConsejeria_pre_prueba (){
        return $this->consejeria_pre_prueba;
    }

    public function setConsejeria_post_prueba ($consejeria_post_prueba){
        $this->consejeria_post_prueba = $consejeria_post_prueba;
    }

    public function getConsejeria_post_prueba (){
        return $this->consejeria_post_prueba;
    }

    public function setResultado_prueba ($resultado_prueba) {
        $this->resultado_prueba = $resultado_prueba;
    }

    public function getResultado_prueba () {
        return $this->resultado_prueba;
    }

    /**
     * Este método devuelve todas las propiedades del objeto Prueba
     * The method json Serialize return all the attributes of the object class. It is needed to maniplate the infromation in a lighter and faster way
     */
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }
}

?>
