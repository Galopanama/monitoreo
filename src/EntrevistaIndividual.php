<?php

require_once 'Entrevista.php';

class EntrevistaIndividual extends Entrevista
{

    private $uso_del_condon;
    private $uso_de_alcohol_y_drogas_ilicitas;
    private $informacion_clam;
    private $referencia_a_pruebas_de_vih;
    private $referencia_a_clinica_tb;

    public function __construct(
        $id_promotor,
        $id_persona_receptora,
        $fecha,
        $condones_entregados,
        $lubricantes_entregados,
        $materiales_educativos_entregados,
        $uso_del_condon,
        $uso_de_alcohol_y_drogas_ilicitas,
        $informacion_clam,
        $referencia_a_pruebas_de_vih,
        $referencia_a_clinica_tb
    ) {

        parent::__construct($id_promotor, $id_persona_receptora, $fecha, $condones_entregados, $lubricantes_entregados, $materiales_educativos_entregados);
        $this->uso_del_condon = $uso_del_condon;
        $this->uso_de_alcohol_y_drogas_ilicitas = $uso_de_alcohol_y_drogas_ilicitas;
        $this->informacion_clam = $informacion_clam;
        $this->referencia_a_pruebas_de_vih = $referencia_a_pruebas_de_vih;
        $this->referencia_a_clinica_tb = $referencia_a_clinica_tb;
    }

    public function setUso_del_condon($uso_del_condon)
    {
        $this->uso_del_condon = $uso_del_condon;
    }

    public function getUso_del_condon()
    {
        return $this->uso_del_condon;
    }

    public function setUso_de_alcohol_y_drogas_ilicitas($uso_de_alcohol_y_drogas_ilicitas)
    {
        $this->uso_de_alcohol_y_drogas_ilicitas = $uso_de_alcohol_y_drogas_ilicitas;
    }

    public function getUso_de_alcohol_y_drogas_ilicitas()
    {
        return $this->uso_de_alcohol_y_drogas_ilicitas;
    }

    public function setInformacion_clam($informacion_clam)
    {
        $this->informacion_clam = $informacion_clam;
    }

    public function getInformacion_clam()
    {
        return $this->informacion_clam;
    }

    public function setReferencia_a_pruebas_de_vih($referencia_a_pruebas_de_vih)
    {
        $this->referencia_a_pruebas_de_vih = $referencia_a_pruebas_de_vih;
    }

    public function getReferencia_a_pruebas_de_vih()
    {
        return $this->referencia_a_pruebas_de_vih;
    }

    public function setReferencia_a_clinica_tb($referencia_a_clinica_tb)
    {
        $this->referencia_a_clinica_tb = $referencia_a_clinica_tb;
    }

    public function getReferencia_a_clinica_tb()
    {
        return $this->referencia_a_clinica_tb;
    }

    /**
     * Este método devuelve todas las propiedades del objeto Entrevista, tanto públicas como privadas
     * Es necesario para poder utilizar el método json_encode (issue_17)
     */
    public function jsonSerialize()
    {
        $vars = array_merge(parent::jsonSerialize(), get_object_vars($this));

        return $vars;
    }
}
