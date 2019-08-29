<?php

require_once ("usuarios.php");


class Subreceptor extends Usuario{

    private $ubicacion;

    public function __construct($id,$login,$nombre,$apellidos,$tipo_de_usuario,$telefono,$password,$salt,$ubicacion){

        parent:: __construct($id,$login,$nombre,$apellidos,$tipo_de_usuario,$telefono,$password,$salt);
        $this->ubicacion = $ubicacion;

    }

    public function setUbicacion ($ubicacion){
        $this->ubicacion = $ubicacion;
    }

    public function getUbicacion (){
        return $this->ubicacion;
    }
}

?>