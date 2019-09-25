<?php


class Usuario implements \JsonSerializable{

    private $id;
    private $login;
    private $nombre;
    private $apellidos;
    private $tipo_de_usuario;
    private $telefono;
    private $password;
    private $activo;

    public function __construct($id,$login,$nombre,$apellidos ,$tipo_de_usuario,$telefono,$password='',$activo=true){

        $this->id = $id;
        $this->login = $login;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->tipo_de_usuario = $tipo_de_usuario;
        $this->telefono = $telefono;
        $this->password = $password;
        $this->activo = $activo;
    }

    public function setId ($id){
        $this->id = $id;
    }

    public function getId (){
        return $this->id;
    }

    public function setLogin ($login){
        $this->login = $login;
    }

    public function getLogin (){
        return $this->login;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function getNombre(){
        return $this->nombre;
    }    

    public function setApellidos($apellidos){
        $this->apellidos = $apellidos;
    }

    public function getApellidos(){
        return $this->apellidos;
    }

    public function setTipo_de_usuario($tipo_de_usuario){
        $this->tipo_de_usuario = $tipo_de_usuario;
    }

    public function getTipo_de_usuario(){
        return $this->tipo_de_usuario;
    } 

    public function setTelefono($telefono){
        $this->telefono = $telefono;
    }

    public function getTelefono(){
        return $this->telefono;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getPassword(){
        return $this->password;
    }    

    public function setSalt($salt){
        $this->salt = $salt;
    }

    public function getSalt(){
        return $this->salt;
    }

    public function setActivo($activo){
        $this->activo = $activo;
    }

    public function getActivo(){
        return $this->activo;
    } 

    /**
     * Este método devuelve todas las propiedades del objeto Usuario, tanto públicas como privadas
     * Es necesario para poder utilizar el método json_encode (issue_17)
     */
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }
}

class Subreceptor extends Usuario{

    private $ubicacion;

    public function __construct($id,$login,$nombre,$apellidos,$tipo_de_usuario,$telefono,$password,$activo,$ubicacion){

        parent::__construct($id,$login,$nombre,$apellidos,$tipo_de_usuario,$telefono,$password,$activo);
        $this->ubicacion = $ubicacion;

    }

    public function setUbicacion ($ubicacion){
        $this->ubicacion = $ubicacion;
    }

    public function getUbicacion (){
        return $this->ubicacion;
    }

    /**
     * Este método devuelve todas las propiedades del objeto Usuario, tanto públicas como privadas
     * Es necesario para poder utilizar el método json_encode (issue_17)
     */
    public function jsonSerialize()
    {
        $vars = array_merge(parent::jsonSerialize(), get_object_vars($this));

        return $vars;
    }
}

class Promotor extends Usuario{

    private $id_cedula;
    private $organizacion;
    private $id_subreceptor;

    public function __construct($id,$login,$nombre,$apellidos,$tipo_de_usuario,$telefono,$password,$activo,$id_cedula,$organizacion,$id_subreceptor){
    
        parent::__construct($id,$login,$nombre,$apellidos,$tipo_de_usuario,$telefono,$password,$activo);
        $this->id_cedula = $id_cedula; 
        $this->organizacion = $organizacion;
        $this->id_subreceptor = $id_subreceptor;

    }

    public function setId_cedula ($id_cedula){
        $this->id_cedula = $id_cedula;
    }

    public function getId_cedula (){
        return $this->id_cedula;
    }

    public function setOrganizacion ($organizacion){
        $this->organizacion = $organizacion;
    }

    public function getOrganizacion (){
        return $this->organizacion;
    }

    public function getId_subreceptor() {
        return $this->id_subreceptor;
    }

    public function setId_subreceptor($id_subreceptor) {
        $this->id_subreceptor = $id_subreceptor;
    }

    /**
     * Este método devuelve todas las propiedades del objeto Usuario, tanto públicas como privadas
     * Es necesario para poder utilizar el método json_encode (issue_17)
     */
    public function jsonSerialize()
    {
        $vars = array_merge(parent::jsonSerialize(), get_object_vars($this));

        return $vars;
    }
}

class Tecnologo extends Usuario{

    private $numero_de_registro;
    private $id_cedula;

    public function __construct($id,$login,$nombre,$apellidos,$tipo_de_usuario,$telefono,$password,$activo,$numero_de_registro,$id_cedula){

        parent:: __construct($id,$login,$nombre,$apellidos,$tipo_de_usuario,$telefono,$password,$activo);
        $this->numero_de_registro = $numero_de_registro;
        $this->id_cedula = $id_cedula;   

    }

    public function setNumero_de_registro($numero_de_registro){
        $this->numero_de_registro = $numero_de_registro;
    }

    public function getNumero_de_registro(){
        return $this->numero_de_registro;
    }

    public function setId_cedula($id_cedula){
        $this->id_cedula = $id_cedula;
    }

    public function getId_cedula(){
        return $this->id_cedula;
    }

    /**
     * Este método devuelve todas las propiedades del objeto Usuario, tanto públicas como privadas
     * Es necesario para poder utilizar el método json_encode (issue_17)
     */
    public function jsonSerialize()
    {
        $vars = array_merge(parent::jsonSerialize(), get_object_vars($this));

        return $vars;
    }

} 


?>