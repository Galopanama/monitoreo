<?php

require_once __DIR__ . '/../../config/config.php';
// Restringimos el acceso sólo a usuarios administradores
$perfiles_aceptados = array('tecnologo');
require_once __DIR__ . '/../../security/autorizador.php';
require_once __DIR__ . '/../../src/Pruebas.php';
require_once __DIR__ . '/../../src/PersonasReceptoras.php';

//$header = $smarty->fetch("header/.tpl");

if (!empty($_POST['id_persona_receptora_buscada'])) {
    // Se han enviado datos
    $errores = array();
    // Vamos a comprobar si los datos necesarios están
    if (empty($_POST['id_persona_receptora_buscada'])){
        $errores['id_persona_receptora_buscada'] = "Debe especificar la persona a la que va a realizar la prueba";
    }
    if (empty($errores)) {
        // Tenemos que tener en cuenta que si la persona no existe, hay que crearla antes de introducir los datos en la tabla entrevistas
        // ya que existe una clave ajena que afecta
        try {
            PersonasReceptoras::getPersonaReceptora($_POST['id_persona_receptora']);
            // TODO: ¿actualizar los datos?
        }
        catch (PersonaReceptoraNotFoundException $e) {
            // Si no existe, el identificador no lo obtenemos del campo id_persona_receptora, sino de id_persona_receptora_buscada
            $datos_persona_receptora = [
                'id_persona_receptora' => $_POST['id_persona_receptora_buscada']
            ];
            // Le pedimos al método que nos devuelva el objeto de la conexión, para poder hacer la transacción
            try {
                $db = PersonasReceptoras::add($datos_persona_receptora, true);
            }
            catch (ValidationException $e) {
                // Los mensajes de validación vienen como un array serializado en el mensaje de la excepción
                $errores = unserialize($e->getMessage());
            }
            catch (Exception $e) {
                $errores[] = $e->getMessage();
            }
        }
    }
}
    // Si no han ocurrido errores hasta ahora, procedemos a intentar añadir la entrevista
    if (empty($errores)){
        // Aunque en principio los nombres del formulario deberían de ser los mismos que los que espera la clase EntrevistaIndividual, 
        // vamos a crear un array con dichas claves
        $datos = [
            'id_tecnologo' => $_SESSION['usuario_id'],
            'id_persona_receptora' => $_POST['id_persona_receptora_buscada'], 
            'consejeria_pre_prueba' => $_POST['consejeria_pre_prueba']?true:false,
            'consejeria_post_prueba' => $_POST['consejeria_post_prueba']?true:false,
            'resultado_prueba' => $_POST['resultado_prueba']?true:false,
            'realizacion_prueba' => $_POST['realizacion_prueba']?true:false,
        ];
        try {
            Entrevistas::add($datos, $db);
        }
        catch (ValidationException $e) {
            // Los mensajes de validación vienen como un array serializado en el mensaje de la excepción
            $errores = unserialize($e->getMessage());
        }
        catch (Exception $e) {
            $errores[] = $e->getMessage();
        }
        if (empty($errores)){
        // No ha habido errores, redirigimos a la página del listado
            $_SESSION['exito_titulo'] = "Prueba añadida con éxito";
            $_SESSION['exito_mensaje'] = "La prueba ha sido dada de alta correctamente en el sistema";
            header('Location: ' . _WEB_PATH_ . '/user/prueba/index.php');
            exit;
        }
    }
    // Asignamos los errores si los hubiera (que si el código ha llegado aquí, los hay)
    $smarty->assign('errores', $errores);
    // Además, cargamos los datos que el usuario ya haya escrito
    foreach (array_keys($_POST) as $elem) {
        $smarty->assign($elem, $_POST[$elem]);
    }

// El título de la página será Añadir prueba (la misma plantilla se utiliza para modificar)
$smarty->assign('titulo', 'Añadir prueba');

// Necesitamos cargar un array con los tipos de usuario válidos. Dicho array está en la clase Usuarios
$smarty->assign('tipos_poblacion_permitidos', PersonasReceptoras::tipos_poblacion_permitidos);

// La variable main se utilizará en el archivo footer.php
$main = $smarty->fetch("paginas/prueba/add_prueba.tpl");

// Esta página necesita un javascript especial
$footer = $smarty->fetch("footer/add_prueba.tpl");

// Esta página necesita un javascript especial
require_once '../../footer.php';
$smarty->display('esqueleto_dashboard.html');

?>