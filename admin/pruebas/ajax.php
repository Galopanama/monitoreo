<?php
/**
 * Desde este fichero se accede a todas las pruebas
 * La informacion puede ser revisada por el administrador
 */
require_once __DIR__ . '/../../config/config.php';

// Restringimos el acceso sólo a usuarios administradores
$perfiles_aceptados = array('administrador');
require_once __DIR__ . '/../../security/autorizador.php';

// Llamamos a los ficheros del Modelo
require_once __DIR__ . '/../../src/Pruebas.php';
require_once __DIR__ . '/../../src/PersonasReceptoras.php';
require_once __DIR__ . '/../../src/Usuarios.php';

// Solo los usuarios con permiso podran recuperar esta informacion
// La informacion se devuelve en un objeto JSon
switch($_GET['funcion']){
    case "getAllPruebas":
        echo json_encode(getAllPruebas());
        exit;
    case "buscar":
        echo json_encode(buscar_subreceptor($_GET['key']));
    default:
        exit;
}


/**
 * Devuelve todas las pruebas
 */
function getAllPruebas() {
    try {
        $lista = Pruebas::getAllPruebas();

        // Vamos a editar la lista, y añadir los datos de la persona receptora y el nombre del tecnologo 
        foreach($lista as $prueba) {
            $persona_receptora = PersonasReceptoras::getPersonaReceptora($prueba->getId_cedula_persona_receptora());
            $tecnologo = Usuarios::getUsuarioById($prueba->getId_tecnologo());
            $prueba->nombre_tecnologo = $tecnologo->getNombre() . ' ' . $tecnologo->getApellidos();
        }

        return prepara_para_json($lista);
    }  
    catch (Exception $e) {
        $array_response['error'] = 1;
        $array_response['errorMessage'] = $e->getMessage();
        return $array_response;
    }
}


/**
 * Busca un usuario SUBRECEPTOR dada una cadena de búsqueda
 */
function buscar_subreceptor ($cadena) {
    try{
        $lista = array();

        // Solo necesitamos el nombre (completo) y el id
        foreach(Usuarios::buscaUsuarioSubreceptor($cadena) as $subreceptor){
            $lista[] = [
                "nombre" => $subreceptor->getNombre() . ' ' . $subreceptor->getApellidos() . ' (' . $subreceptor->getUbicacion() . ')',
                "id" => $subreceptor->getId()
            ];
        }

        return $lista;
    }
    catch (Exception $e){
        $array_response['error'] = 1;
        $array_response['errorMessage'] = $e->getMessage();
        return $array_response;
    }
}
// Desde aqui se preparan los datos que regresan de la peticion. Al volver en un array se tranforman a JSon
function prepara_para_json($array) {
    return array("data" => $array);
}