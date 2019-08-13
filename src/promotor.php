<?php

require_once ("usuarios.php");


class Promotor extends Usuario{

    private $id_cedula;
    private $organizacion;

    public function __construct($id,$login,$nombre,$apellidos,$tipo_de_usuario,$telefono,$password,$salt,$id_cedula,$organizacion){
    
        parent:: __construct($id,$login,$nombre,$apellidos,$tipo_de_usuario,$telefono,$password,$salt);
        $this->$id_cedula = $id_cedula; 
        $this->$organizacion = $organizacion;

    }

    public function setId_cedula ($id_cedula){
        $this->$id_cedula = $id_cedula;
    }

    public function getId_cedula (){
        return $this->$id_cedula;
    }

    public function setOrganizacion ($organizacion){
        $this->$organizacion = $organizacion;
    }

    public function getOrganizacion (){
        return $this->$organizacion;
    }
}

?>