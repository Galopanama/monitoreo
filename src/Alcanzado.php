<?php
// The class Alcanzado belong to the Model.  
// It is a child of Entrevista and inherits all the atributes from it 
// The atributes are private and the functions public in order to allow the manipulation of the value of the instances and not the class
require_once 'Entrevista.php';



class Alcanzado extends Entrevista 
{
    private $total_condones;
    private $total_lubricantes;
    private $total_materiales_educativos;

    public function __construct(
        $id_promotor,
        $id_cedula_persona_receptora,
        $fecha,
        $condones_entregados,
        $lubricantes_entregados,
        $materiales_educativos_entregados,
        $total_condones,
        $total_lubricantes,
        $total_materiales_educativos
    ) {
        parent::__construct($id_promotor, $id_cedula_persona_receptora, $fecha, $condones_entregados, $lubricantes_entregados, $materiales_educativos_entregados);
        $this->total_condones = $total_condones;
        $this->total_lubricantes = $total_lubricantes;
        $this->total_materiales_educativos = $total_materiales_educativos;
    }

    public function setTotal_condones($total_condones){
        $this->total_condones = $total_condones;
    }

    public function getTotal_condones(){
        return $this->total_condones;
    }

    public function setTotal_lubricantes($total_lubricantes){
        $this->total_lubricantes = $total_lubricantes;
    }

    public function getLubricantes_entregados(){
        return $this->total_lubricantes;
    }
    
    public function setTotal_materiales_educativos($total_materiales_educativos){
        $this->total_materiales_educativos = $total_materiales_educativos;
    }

    public function getMateriales_educativos_entregados(){
        return $this->total_materiales_educativos;
    }

    /**
     * Este método devuelve todas las propiedades del objeto Entrevista, tanto públicas como privadas
     * The method json Serialize return all the attributes of the object class. It is needed to maniplate the infromation in a lighter and faster way
     */
    public function jsonSerialize()
    {
        $vars = array_merge(parent::jsonSerialize(), get_object_vars($this));

        return $vars;
    }

}