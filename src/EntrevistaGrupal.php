<?php
// The class EntrevistaGrupal belong to the Model.  
// It is a child of Entrevista and inherits all the atributes from it 
// The atributes are private and the functions public in order to allow the manipulation of the value of the instances and not the class
require_once 'Entrevista.php';

class EntrevistaGrupal extends Entrevista {

    private $region_de_salud;
    private $area;
    private $estilos_de_autocuidado;
    private $ddhh_estigma_discriminacion;
    private $uso_correcto_y_constantes_del_condon;
    private $salud_sexual_e_its;
    private $ofrecimiento_y_referencia_a_la_prueba_de_vih;
    private $clam_y_otros_servicios;
    private $salud_anal;
    private $hormonizacion;
    private $apoyo_y_orientacion_psicologica;
    private $diversidad_sexual_identidad_expresion_de_genero;
    private $tuberculosis_y_coinfecciones;
    private $infecciones_oportunistas;

    public function __construct ($id_promotor,$id_cedula_persona_receptora,$fecha,$condones_entregados,$lubricantes_entregados,$materiales_educativos_entregados,
    $region_de_salud,$area,$estilos_de_autocuidado,$ddhh_estigma_discriminacion,$uso_correcto_y_constantes_del_condon,
    $salud_sexual_e_its,$ofrecimiento_y_referencia_a_la_prueba_de_vih,$clam_y_otros_servicios,$salud_anal,$hormonizacion,$apoyo_y_orientacion_psicologica,
    $diversidad_sexual_identidad_expresion_de_genero,$tuberculosis_y_coinfecciones,$infecciones_oportunistas){

        parent::__construct ($id_promotor,$id_cedula_persona_receptora,$fecha,$condones_entregados,$lubricantes_entregados,$materiales_educativos_entregados);
        $this->region_de_salud = $region_de_salud;
        $this->area = $area;
        $this->estilos_de_autocuidado = $estilos_de_autocuidado;
        $this->ddhh_estigma_discriminacion = $ddhh_estigma_discriminacion;
        $this->uso_correcto_y_constantes_del_condon = $uso_correcto_y_constantes_del_condon;
        $this->salud_sexual_e_its = $salud_sexual_e_its;
        $this->ofrecimiento_y_referencia_a_la_prueba_de_vih = $ofrecimiento_y_referencia_a_la_prueba_de_vih;
        $this->clam_y_otros_servicios = $clam_y_otros_servicios;
        $this->salud_anal = $salud_anal;
        $this->hormonizacion = $hormonizacion;
        $this->apoyo_y_orientacion_psicologica = $apoyo_y_orientacion_psicologica;
        $this->diversidad_sexual_identidad_expresion_de_genero = $diversidad_sexual_identidad_expresion_de_genero;
        $this->tuberculosis_y_coinfecciones = $tuberculosis_y_coinfecciones;
        $this->infecciones_oportunistas = $infecciones_oportunistas;

    }

    public function setRegion_de_salud($region_de_salud){
        $this->region_de_salud = $region_de_salud;
    }

    public function getRegion_de_salud(){
        return $this->region_de_salud;
    }

    public function setArea($area){
        $this->area = $area;
    }

    public function getArea(){
        return $this->area;
    }

    public function setEstilos_de_autocuidado($estilos_de_autocuidado){
        $this->estilos_de_autocuidado = $estilos_de_autocuidado;
    }

    public function getEstilos_de_autocuidado(){
        return $this->estilos_de_autocuidado;
    }

    public function setDdhh_estigma_discriminacion($ddhh_estigma_discriminacion){
        $this->ddhh_estigma_discriminacion = $ddhh_estigma_discriminacion;
    }

    public function getDdhh_estigma_discriminacion (){
        return $this->ddhh_estigma_discriminacion;
    }

    public function setUso_correcto_y_constantes_del_condon ($uso_correcto_y_constantes_del_condon){
        $this->uso_correcto_y_constantes_del_condon = $uso_correcto_y_constantes_del_condon;
    }

    public function getUso_correcto_y_constantes_del_condon (){
        return $this->uso_correcto_y_constantes_del_condon;
    }

    public function setSalud_sexual_e_its ($salud_sexual_e_its){
        $this->salud_sexual_e_its = $salud_sexual_e_its;
    }

    public function getSalud_sexual_e_its (){
        return $this->salud_sexual_e_its;
    }

    public function setOfrecimiento_y_referencia_a_la_prueba_de_vih ($ofrecimiento_y_referencia_a_la_prueba_de_vih){
        $this->ofrecimiento_y_referencia_a_la_prueba_de_vih = $ofrecimiento_y_referencia_a_la_prueba_de_vih;
    }

    public function getOfrecimiento_y_referencia_a_la_prueba_de_vih (){
        return $this->ofrecimiento_y_referencia_a_la_prueba_de_vih;
    }

    public function setClam_y_otros_servicios ($clam_y_otros_servicios){
        $this->clam_y_otros_servicios = $clam_y_otros_servicios;
    }

    public function getClam_y_otros_servicios (){
        return $this->clam_y_otros_servicios;
    }

    public function setSalud_anal ($salud_anal){
        $this->salud_anal = $salud_anal;
    }

    public function getSalud_anal (){
        return $this->salud_anal;
    }

    public function setHormonizacion ($hormonizacion){
        $this->hormonizacion = $hormonizacion;
    }

    public function getHormonizacion (){
        return $this->hormonizacion;
    }

    public function setApoyo_y_orientacion_psicologica ($apoyo_y_orientacion_psicologica){
        $this->apoyo_y_orientacion_psicologica = $apoyo_y_orientacion_psicologica;
    }   

    public function getApoyo_y_orientacion_psicologica (){
        return $this->apoyo_y_orientacion_psicologica;
    }   
    
    public function setDiversidad_sexual_identidad_expresion_de_genero ($diversidad_sexual_identidad_expresion_de_genero){
        $this->diversidad_sexual_identidad_expresion_de_genero = $diversidad_sexual_identidad_expresion_de_genero;
    }

    public function getDiversidad_sexual_identidad_expresion_de_genero (){
        return $this->diversidad_sexual_identidad_expresion_de_genero;
    }

    public function setTuberculosis_y_coinfecciones ($tuberculosis_y_coinfecciones){
        $this->tuberculosis_y_coinfecciones = $tuberculosis_y_coinfecciones;
    }

    public function getTuberculosis_y_coinfecciones (){
        return $this->tuberculosis_y_coinfecciones;
    }

    public function setInfecciones_oportunistas ($infecciones_oportunistas){
        $this->infecciones_oportunistas = $infecciones_oportunistas;
    }

    public function getInfecciones_oportunistas (){
        return $this->infecciones_oportunistas;
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