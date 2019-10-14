<?php
// The class Alcanzado belong to the Model.  
// It is a child of Entrevista and inherits all the atributes from it 
// The atributes are private and the functions public in order to allow the manipulation of the value of the instances and not the class
require_once 'Entrevista.php';

class Alcanzado extends Entrevista
{
    private $condones_recibidos;
    private $lubricantes_recibidos;
    private $materiales_educativos_recibidos;

    public function __construct(
        $id_promotor,
        $id_persona_receptora,
        $fecha,
        $condones_entregados,
        $lubricantes_entregados,
        $materiales_educativos_entregados,
        $condones_recibidos,
        $lubricantes_recibidos,
        $materiales_educativos_recibidos
    ) {

        parent::__construct($id_promotor, $id_persona_receptora, $fecha, $condones_entregados, $lubricantes_entregados, $materiales_educativos_entregados);
        $this->condones_recibidos = $condones_recibidos;
        $this->lubricantes_recibidos = $lubricantes_recibidos;
        $this->materiales_educativos_recibidos = $materiales_educativos_recibidos;
    }

    public function setCondones_recibidos($condones_recibidos)
    {
        $this->condones_recibidos = parent::$condones_entregados;
    }

    public function getCondones_recibidos()
    {
        if ($this->condones_recibidos >= 40)
            return $this->condones_recibidos;
        else
            return "Faltan" . 40 - $this->condones_recibidos . " condones para alcanzar el minimo";
    }

    public function setLubricantes_recibidos($lubricantes_recibidos)
    {
        $this->lubricantes_recibidos = parent::$lubricantes_entregados; 
    }

    public function getLubricantes_entregados()
    {
        if ($this->lubricantes_recibidos >= 40)
            return $this->lubricantes_recibidos;
        else
            return "Faltan" . 40 - $this->lubricantes_recibidos . " lubrincantes para alcanzar el minimo";
    }
    

    public function setMateriales_educativos_recibidos($materiales_educativos_recibidos)
    {
        $this->$materiales_educativos_recibidos = parent::$materiales_educativos_entregados;
    }

    public function getMateriales_educativos_entregados()
    {
        if ($this->materiales_educativos_recibidos >= 40)
            return $this->materiales_educativos_recibidos;
        else
            return "Faltan" . 40 - $this->materiales_educativos_recibidos . " materiales educativos para alcanzar el minimo";
    }


    /**
     * Este método devuelve todas las propiedades del objeto Alcanzados, tanto públicas como privadas
     * The method json Serialize return all the attributes of the object class. It is needed to maniplate the infromation in a lighter and faster way
     */

    public function jsonSerialize()
    {
        $vars = array_merge(parent::jsonSerialize(), get_object_vars($this));

        return $vars;
    }
}
