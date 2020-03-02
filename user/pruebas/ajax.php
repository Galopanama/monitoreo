<?php
/**
 * Desde este fichero se accede a todas las pruebas
 * La informacion puede ser revisada por los subrecptores al igual que por los tecnologos
 */
require_once __DIR__ . '/../../config/config.php';

// Restringimos el acceso sólo a usuarios tecnologos y subreceptores
$perfiles_aceptados = array('tecnologo','subreceptor');
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
        echo json_encode(buscar_persona_receptora($_POST['key']));
    default:
        exit;
}
/**
 * Devuelve todas las pruebas del tecnologo
 */
function getAllPruebas() {
    try {
        $lista = Pruebas::getAllPruebas();
        // Vamos a editar la lista, y añadir los datos de la persona receptora y el nombre del tecnologo
        // El loop va a mostrar la informacion donde haya una instancia del objeto Prueba, mostrando sus atributos
        // Se incluyen informacion del tecnologo e informacion de la poblacion
        foreach($lista as $prueba) {
            $persona_receptora = PersonasReceptoras::getPersonaReceptora($prueba->getId_cedula_persona_receptora());
            $prueba->poblacion = $persona_receptora->getPoblacion();                        
            $prueba->poblacion_originaria = $persona_receptora->getPoblacion_originaria();  
            $tecnologo = Usuarios::getUsuarioById($prueba->getId_tecnologo());
            $prueba->nombre_tecnologo = $tecnologo->getNombre() . ' ' . $tecnologo->getApellidos();
        }
        return prepara_para_json($lista);
        
    }   // Si hubiera errores se capturan en esta sentencia y se notifican con un mensaje al usuario
    catch (Exception $e) {
        $array_response['error'] = 1;
        $array_response['errorMessage'] = $e->getMessage();
        return $array_response;
    }
}

/**
 * Busca una PERSONA RECEPTORA dada una cadena de búsqueda
 */
function buscar_persona_receptora($cadena) {
    $array_response['found'] = 1;
    $array_response['error'] = 0;
    try{
        $persona = PersonasReceptoras::getPersonaReceptora($cadena);
        $array_response['poblacion'] = $persona->getPoblacion();                        
        $array_response['poblacion_originaria'] = $persona->getPoblacion_originaria(); 
    }
    catch (PersonaReceptoraNotFoundException $e) {
        $array_response['found'] = 0;
    }
    catch (Exception $e){
        $array_response['error'] = 1;
        $array_response['errorMessage'] = $e->getMessage();
        $array_response['found'] = 0;
    }

    return $array_response;
}
// Desde aqui se preparan los datos que regresan de la peticion. Al volver en un array se tranforman a JSon
function prepara_para_json($array) {
    return array("data" => $array);
}
?>