<?php

require_once ("usuarios.php");


class Administrador extends Usuario{

    private $administrador;

    public function __construct($id,$login,$nombre,$apellidos,$tipo_de_usuario,$telefono,$password,$salt,$administrador){

        parent:: __construct($id,$login,$nombre,$apellidos,$tipo_de_usuario,$telefono,$password,$salt);
        $this->$administrador = $administrator;

    }

    public function setAdminstrador ($administrador){
        $this->$administrador = $administrator;
    }

    public function getAdminstrator (){
        return $this->$administrador;
    }
}

?>