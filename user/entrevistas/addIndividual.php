<?php
// Desde este fichero se añaden las entrevistas individuales

require_once __DIR__ . '/../../config/config.php';

// Restringimos el acceso sólo a usuarios promotor
$perfiles_aceptados = array('promotor');
require_once __DIR__ . '/../../security/autorizador.php';

// LLamamos al fichero que contiene el objeto DB referenta a la base de datos y que permite n¡interactiar con ella
require_once __DIR__ . '/../../lib/DB.php';

// LLamamos a los ficheros del Controlador
require_once __DIR__ . '/../../src/Entrevistas.php';
require_once __DIR__ . '/../../src/PersonasReceptoras.php';


//  Se envian los datos si la línea no esta vacía
if (!empty($_POST['id_cedula_persona_receptora_buscada'])) {            

    // Si hay errores, se va a guarda en un array 
    $errores = array();

    // Comprobar si los datos necesarios están en el formulario antes de enviarlo
    // Comprobamos el numero de cédula y devolvemos mensaje para informar al usuario
    if (empty($_POST['id_cedula_persona_receptora_buscada'])){
        $errores['id_cedula_persona_receptora_buscada'] = "Debe especificar la persona a la que va a realizar la entrevista"; // error message to return if not filled. Explains error
    }   
    // Comprobamos la region de salud 
    if (empty($_POST['region_de_salud'])){
        $errores['region_de_salud'] = "Debe especificar la región de salud"; // Mensaje que explica el error
    }
    // Comprobamos el area
    if (empty($_POST['area'])){
        $errores['area'] = "Debe especificar el área"; 
    } 
    // Comprobamos el numero de condones
    if (!is_numeric($_POST['condones_entregados'])){
        $errores['condones_entregados'] = "Debe especificar el número de condones entregados, aunque sea 0"; 
    }   
    // Comprobamos el numero de lubricantes
    if (!is_numeric($_POST['lubricantes_entregados'])){
        $errores['lubricantes_entregados'] = "Debe especificar el número de lubricantes entregados, aunque sea 0"; 
    }   
    // Comprobamos el numero de materiales educativos
    if (!is_numeric($_POST['materiales_educativos_entregados'])){
        $errores['materiales_educativos_entregados'] = "Debe especificar el número de materiales educativos entregados, aunque sea 0";
    }   

    if (empty($errores)) {
        // Tenemos que tener en cuenta que si la persona no existe, 
        // hay que crearla antes de introducir los datos en la tabla entrevistas
        // ya que existe una clave ajena que afecta
        
        // Lo haremos dentro de una transacción
        // Comienza la conexion con la Base de Datos
        $db = new Db();
        $mysqli = $db->conecta();
        $mysqli->autocommit(false);

        // Comprobamos si la persona existe
        try {   
            PersonasReceptoras::getPersonaReceptora($_POST['id_cedula_persona_receptora_buscada']);
            
        }      
        // Si la persona no existe en la base de datos, vamos a crearla con los datos que estan en el formulario
        catch (PersonaReceptoraNotFoundException $e) {
            // Si no existe, el identificador no lo obtenemos del campo id_cedula_persona_receptora, sino de id_cedula_persona_receptora_buscada
            $datos_persona_receptora = [
                'id_cedula_persona_receptora' => $_POST['id_cedula_persona_receptora_buscada'],
                'poblacion' => $_POST['poblacion'],
                'poblacion_originaria' => $_POST['poblacion_originaria']?true:false
            ];
            // Le pedimos al método que nos devuelva el objeto de la conexión, para poder hacer la transacción
            
            //Hay una peticion a la base de datos para realizar la conexion 
            try {
                PersonasReceptoras::add($datos_persona_receptora, $db);
            }
            catch (ValidationException $e) {
                // Los mensajes de validación vienen como un array serializado en el mensaje de la excepción
                $errores = unserialize($e->getMessage());
            }
            catch (Exception $e) {
                $errores[] = $e->getMessage();
            }   // Si hay otros errores, se atraparan aquí
        }

        // Si no han ocurrido errores hasta ahora, procedemos a intentar añadir la entrevista
        if (empty($errores)){
            // Los nombres del formulario deberían de ser los mismos que los que espera la clase EntrevistaIndividual
            // por eso, vamos a crear un array con dichas claves
            $datos = [
                'id_promotor' => $_SESSION['usuario_id'],
                'id_cedula_persona_receptora' => $_POST['id_cedula_persona_receptora_buscada'],
                'region_de_salud' => $_POST['region_de_salud'],
                'area' => $_POST['area'],
                'condones_entregados' => $_POST['condones_entregados'],
                'lubricantes_entregados' => $_POST['lubricantes_entregados'],
                'materiales_educativos_entregados' => $_POST['materiales_educativos_entregados'],
                'uso_del_condon' => $_POST['uso_del_condon']?true:false,
                'uso_de_alcohol_y_drogas_ilicitas' => $_POST['uso_de_alcohol_y_drogas_ilicitas']?true:false,
                'informacion_CLAM' => $_POST['informacion_CLAM']?true:false,
                'referencia_a_prueba_de_VIH' => $_POST['referencia_a_prueba_de_VIH']?true:false,
                'referencia_a_clinica_TB' => $_POST['referencia_a_clinica_TB']?true:false
            ];
            try {
                Entrevistas::addIndividual($datos, $db);
            }   // Se crea la conexion con la Base de datos
            catch (ValidationException $e) {
                // Si hay errores con la instancia de la clase EntrevistaIndividual, nos devuelve un mensaje desde esta linea 
                $errores = unserialize($e->getMessage());
            }   // Atrapará cualquier otro error
            catch (Exception $e) {
                $errores[] = $e->getMessage();
            }

            if (empty($errores)){
                // Si no hay errores se devolvera un mensaje de exito
                // y se direcciona al usuario a la pagina donde se muestra la lista de resultados
                $_SESSION['exito_titulo'] = "Entrevista añadida con éxito";
                $_SESSION['exito_mensaje'] = "La entrevista ha sido dada de alta correctamente en el sistema";
                header('Location: ' . _WEB_PATH_ . '/user/entrevistas/individuales.php');
                exit;
            }
        }
    

        // Por último, hacemos commit
        $mysqli->autocommit(false);
    }

    // Asignamos los errores si los hubiera (que si el código ha llegado aquí, los hay)
    $smarty->assign('errores', $errores);


    // Además, cargamos los datos que el usuario ya haya escrito
    foreach (array_keys($_POST) as $elem) {
        $smarty->assign($elem, $_POST[$elem]);
    }

}

// El título de la página será Añadir usuario (la misma plantilla se utiliza para modificar)
$smarty->assign('titulo', 'Añadir entrevista individual');

// Necesitamos cargar un array con los 'tipos_de_poblacion_permitidos' (Trans,TSF,HSH) 
// Dicho array está en la clase Usuarios
$smarty->assign('tipos_poblacion_permitidos', PersonasReceptoras::tipos_poblacion_permitidos);

// De igual forma, cargamos las regiones de salud
$smarty->assign('regiones_de_salud', Entrevistas::regiones_de_salud_permitidas);

// Se carga el resto de la Vista
$main = $smarty->fetch("paginas/entrevistas/add_individual.tpl");

$footer = $smarty->fetch("footer/add_entrevista_individual.tpl");

require_once '../../footer.php';

$smarty->display('esqueleto_dashboard.html');