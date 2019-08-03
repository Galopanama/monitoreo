<?php

class Usuario{

    private $id;
    private $login;
    private $nombre;
    private $apellidos;
    private $tipo_de_usuario;
    private $telefono;
    private $password;
    private $salt;

    protected function __construct($id,$login,$nombre,$apellidos = null ,$tipo_de_usuario,$telefono,$password,$salt){

        $this->id = $id;
        $this->login = $login;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->tipo_de_usuario = $tipo_de_usuario;
        $this->telefono = $telefono;
        $this->password = $password;
        $this->salt = $salt;

    }

    public function setId ($id){
        $this->id = $id;
    }

    public function getId ($id){
        return $this->id = $id;
    }

    public function setLogin ($login){
        $this->login = $login;
    }

    public function getLogin ($login){
        return $this->login = $login;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function getNombre($nombre){
        return $this->nombre = $nombre;
    }    

    public function setApellidos($apellidos){
        $this->apellidos = $apellidos;
    }

    public function getApellidos($apellidos){
        return $this->apellidos = $apellidos;
    }

    public function setTipo_de_usuario($tipo_de_usuario){
        $this->tipo_de_usuario = $tipo_de_usuario;
    }

    public function getTipo_de_usuario($tipo_de_usuario){
        return $this->tipo_de_usuario = $tipo_de_usuario;
    } 

    public function setTelefono($telefono){
        $this->telefono = $telefono;
    }

    public function getTelefono($telefono){
        return $this->telefono = $telefono;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getPassword($password){
        return $this->password = $password;
    }    

    public function setSalt($salt){
        $this->salt = $salt;
    }

    public function getSalt($salt){
        return $this->salt = $salt;
    }
}

class Administrador extends Usuario{

    private $administrador;

    protected function __construct($id,$login,$nombre,$apellidos,$tipo_de_usuario,$telefono,$password,$salt,$administrador){

        parent:: __construct($id,$login,$nombre,$apellidos,$tipo_de_usuario,$telefono,$password,$salt);
        $this->$administrador = $administrator;

    }

    public function setAdminstrador ($administrador){
        $this->$administrador = $administrator;
    }

    public function getAdminstrator ($administrador){
        return $this->$administrador = $administrator;
    }
}

class Subreceptor extends Usuario{

    private $ubicacion;

    protected function __construct($id,$login,$nombre,$apellidos,$tipo_de_usuario,$telefono,$password,$salt,$ubicacion){

        parent:: __construct($id,$login,$nombre,$apellidos,$tipo_de_usuario,$telefono,$password,$salt);
        $this->ubicacion = $ubicacion;

    }

    public function setUbicacion ($ubicacion){
        $this->ubicacion = $ubicacion;
    }

    public function getUbicacion ($ubicacion){
        return $this->ubicacion = $ubicacion;
    }
}

class Promotor extends Usuario{

    private $id_cedula;
    private $organizacion;

    protected function __construct($id,$login,$nombre,$apellidos,$tipo_de_usuario,$telefono,$password,$salt,$id_cedula,$organizacion){
    
        parent:: __construct($id,$login,$nombre,$apellidos,$tipo_de_usuario,$telefono,$password,$salt);
        $this->$id_cedula = $id_cedula; //* Ojear en el siguiente campo, porque se repite el nombre de la variable */
        $this->$organizacion = $organizacion;

    }

    public function setId_cedula ($id_cedula){
        $this->$id_cedula = $id_cedula;
    }

    public function getId_cedula ($id_cedula){
        return $this->$id_cedula = $id_cedula;
    }

    public function setOrganizacion ($organizacion){
        $this->$organizacion = $organizacion;
    }

    public function getOrganizacion ($organizacion){
        return $this->$organizacion = $organizacion;
    }
}

class Tecnologo extends Usuario{

    private $numero_de_registro;
    private $id_cedula;

    protected function __construct($id,$login,$nombre,$apellidos,$tipo_de_usuario,$telefono,$password,$salt,$numero_de_registro,$id_cedula){

        parent:: __construct($id,$login,$nombre,$apellidos,$tipo_de_usuario,$telefono,$password,$salt);
        $this->$numero_de_registro = $numero_de_registro;
        $this->$id_cedula = $id_cedula;  // se repite con el campo en la clase Promotor** propuesta de cambio para otro nombre 

    }

    public function setNumero_de_registro($numero_de_registro){
        $this->$numero_de_registro = $numero_de_registro;
    }

    public function getNumero_de_registro($numero_de_registro){
        return $this->$numero_de_registro = $numero_de_registro;
    }

    public function setId_cedula($id_cedula){
        $this->$id_cedula = $id_cedula;
    }

    public function getId_cedula ($id_cedula){
        return $this->$id_cedula = $id_cedula;
    }

} 

// Dependiendo del tipo de usuario hay que crear un nivel de acceso a la base de datos. Por lo tanto,
// tendria que ser desde este fichero o mas bien desde el fichero de acceso. 

?>