<?php
// Este fichero se encarga de añadir pruebas 
require_once __DIR__ . '/../../config/config.php';

// Restringimos el acceso sólo a usuarios tecnologo
$perfiles_aceptados = array('tecnologo');
require_once __DIR__ . '/../../security/autorizador.php';

// LLamamos al fichero que contiene el objeto DB referenta a la base de datos y que permite n¡interactiar con ella
require_once __DIR__ . '/../../lib/DB.php';

// Llamamos a lis ficheros del Controlador
require_once __DIR__ . '/../../src/Pruebas.php';
require_once __DIR__ . '/../../src/PersonasReceptoras.php';


//  Se envian los datos si la línea no esta vacía
if (!empty($_POST['id_cedula_persona_receptora_buscada'])) {
    
    // Si hay errores, se va a guarda en un array 
    $errores = array();

    // Comprobar si los datos necesarios están en el formulario antes de enviarlo
    // Comprobamos el numero de cédula y devolvemos mensaje para informar al usuario
    if (empty($_POST['id_cedula_persona_receptora_buscada'])){
        $errores['id_cedula_persona_receptora_buscada'] = "Debe especificar la persona a la que va a realizar la prueba";
    }
    if (empty($errores)) {
        // Tenemos que tener en cuenta que si la persona no existe
        // hay que crearla antes de introducir los datos de la prueba. 
        // ya que en la tabla entrevistas existe una clave ajena que 
        // condiciona la creacion de usuarios nuevos

        try {
            PersonasReceptoras::getPersonaReceptora($_POST['id_cedula_persona_receptora']);
        }
        catch (PersonaReceptoraNotFoundException $e) {
            // Si no existe, el identificador no lo obtenemos del campo id_persona_receptora, sino de id_persona_receptora_buscada

            $datos_persona_receptora = [
                'id_cedula_persona_receptora' => $_POST['id_cedula_persona_receptora_buscada'],
                'poblacion' => $_POST['poblacion'],
                'poblacion_originaria' => $_POST['poblacion_originaria']?true:false
            ];
            // Le pedimos al método que nos devuelva el objeto de la conexión, para poder hacer la transacción
            try {
                $db = PersonasReceptoras::add($datos_persona_receptora, true); 
            }
            catch (ValidationException $e) {
                // Los mensajes de validación vienen como un array serializado en el mensaje de la excepción 
                // en donde se informa del campo que se debería haber rellenado, pero no se hizo.
                $errores = unserialize($e->getMessage());
            }
            catch (Exception $e) {
                $errores[] = $e->getMessage();
            }
        }

        // Si no han ocurrido errores hasta ahora, procedemos a intentar añadir la entrevista
        if (empty($errores)){
            // Los nombres del formulario deberían de ser los mismos que los que espera la clase Prueba, 
            // por ello vamos a crear un array con dichas claves

            $datos = [
                'id_tecnologo' => $_SESSION['usuario_id'],
                'id_cedula_persona_receptora' => $_POST['id_cedula_persona_receptora_buscada'], 
                'realizacion_prueba' => $_POST['realizacion_prueba'],    
                'consejeria_pre_prueba' => $_POST['consejeria_pre_prueba']?true:false,
                'consejeria_post_prueba' => $_POST['consejeria_post_prueba']?true:false,
                'resultado_prueba' => $_POST['resultado_prueba']        
            ];
            try {
                Pruebas::add($datos);
            }
            catch (ValidationException $e) {
                // Los mensajes de validación vienen como un array serializado en el mensaje de la excepción
                $errores = unserialize($e->getMessage());
            }
            catch (Exception $e) {
                $errores[] = $e->getMessage();
            }
            if (empty($errores)){
            // No ha habido errores, se muestra un mensaje de exito 
            // y redirigimos a la página del listado donde se muestran las pruebas
                $_SESSION['exito_titulo'] = "Prueba añadida con éxito";
                $_SESSION['exito_mensaje'] = "La prueba ha sido dada de alta correctamente en el sistema";
                header('Location: ' . _WEB_PATH_ . '/user/pruebas/pruebas.php');
                exit;
            }
        }
        // Asignamos los errores si los hubiera (que si el código ha llegado aquí, los hay)
        $smarty->assign('errores', $errores);
        // Cargamos los datos que el usuario ya haya escrito y marcamos los campos donde falta informacion
        foreach (array_keys($_POST) as $elem) {
            $smarty->assign($elem, $_POST[$elem]);
        }
    }
}

// El título de la página será Añadir prueba 
$smarty->assign('titulo', 'Añadir prueba');

// Cargar un array con la informacion de la Usuarios que ya sabemos. Esta informacino se encuentra en la clase Usuarios
$smarty->assign('tipos_poblacion_permitidos', PersonasReceptoras::tipos_poblacion_permitidos);
$smarty->assign('resultados_posibles', Pruebas::resultados_posibles); 
$smarty->assign('realizacion_prueba', Pruebas::realizacion_prueba);


// Se carga el resto de la Vista
$main = $smarty->fetch("paginas/pruebas/add_prueba.tpl");

$footer = $smarty->fetch("footer/add_prueba.tpl");

require_once '../../footer.php';

$smarty->display('esqueleto_dashboard.html');

?>