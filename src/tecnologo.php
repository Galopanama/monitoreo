<?php

require_once ("usuarios.php");


class Tecnologo extends Usuario{

    private $numero_de_registro;
    private $id_cedula;
    
    public function __construct($id,$login,$nombre,$apellidos,$tipo_de_usuario,$telefono,$password,$salt,$numero_de_registro,$id_cedula){
    
        parent:: __construct($id,$login,$nombre,$apellidos,$tipo_de_usuario,$telefono,$password,$salt);
        $this->$numero_de_registro = $numero_de_registro;
        $this->$id_cedula = $id_cedula; 
    
    }
    
    public function setNumero_de_registro($numero_de_registro){
        $this->$numero_de_registro = $numero_de_registro;
    }
    
    public function getNumero_de_registro(){
        return $this->$numero_de_registro;
    }
    
    public function setId_cedula($id_cedula){
        $this->$id_cedula = $id_cedula;
    }
    
    public function getId_cedula (){
        return $this->$id_cedula;
    }
    
} 

?>
