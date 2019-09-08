<?php
require_once __DIR__ . '/../../config/config.php';
// Restringimos el acceso sólo a usuarios administradores
$perfiles_aceptados = array('promotor');
require_once __DIR__ . '/../../security/autorizador.php';
require_once __DIR__ . '/../../lib/DB.php';
require_once __DIR__ . '/../../src/Entrevistas.php';
require_once __DIR__ . '/../../src/PersonasReceptoras.php';

//$header = $smarty->fetch("header/.tpl");

if (!empty($_POST['id_persona_receptora_buscada'])) {
    // Se han enviado datos
    $errores = array();

    // Vamos a comprobar si los datos necesarios están
    if (empty($_POST['id_persona_receptora_buscada'])){
        $errores['id_persona_receptora_buscada'] = "Debe especificar la persona a la que va a realizar la entrevista";
    }

    if (!is_numeric($_POST['condones_entregados'])){
        $errores['condones_entregados'] = "Debe especificar el número de condones entregados, aunque sea 0";
    }

    if (!is_numeric($_POST['lubricantes_entregados'])){
        $errores['lubricantes_entregados'] = "Debe especificar el número de lubricantes entregados, aunque sea 0";
    }

    if (!is_numeric($_POST['materiales_educativos_entregados'])){
        $errores['materiales_educativos_entregados'] = "Debe especificar el número de materiales educativos entregados, aunque sea 0";
    }

    if (empty($errores)) {
        // Tenemos que tener en cuenta que si la persona no existe, hay que crearla antes de introducir los datos en la tabla entrevistas
        // ya que existe una clave ajena que afecta
        
        // Además, lo haremos dentro de una transacción
        $db = new Db();
        $mysqli = $db->conecta();
        $mysqli->autocommit(false);

        try {
            PersonasReceptoras::getPersonaReceptora($_POST['id_persona_receptora_buscada']);

            // TODO: ¿actualizar los datos?
        }
        catch (PersonaReceptoraNotFoundException $e) {
            // Si no existe, el identificador no lo obtenemos del campo id_persona_receptora, sino de id_persona_receptora_buscada
            $datos_persona_receptora = [
                'id_persona_receptora' => $_POST['id_persona_receptora_buscada'],
                'poblacion' => $_POST['poblacion'],
                'poblacion_originaria' => $_POST['poblacion_originaria']?true:false
            ];
            // Le pedimos al método que nos devuelva el objeto de la conexión, para poder hacer la transacción
            try {
                PersonasReceptoras::add($datos_persona_receptora, $db);
            }
            catch (ValidationException $e) {
                // Los mensajes de validación vienen como un array serializado en el mensaje de la excepción
                $errores = unserialize($e->getMessage());
            }
            catch (Exception $e) {
                $errores[] = $e->getMessage();
            }
        }

        // Si no han ocurrido errores hasta ahora, procedemos a intentar añadir la entrevista
        if (empty($errores)){
            // Aunque en principio los nombres del formulario deberían de ser los mismos que los que espera la clase EntrevistaIndividual, 
            // vamos a crear un array con dichas claves
            $datos = [
                'id_promotor' => $_SESSION['usuario_id'],
                'id_persona_receptora' => $_POST['id_persona_receptora_buscada'],
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
                $_SESSION['exito_titulo'] = "Entrevista añadida con éxito";
                $_SESSION['exito_mensaje'] = "La entrevista ha sido dada de alta correctamente en el sistema";
                header('Location: ' . _WEB_PATH_ . '/user/entrevistas/index.php');
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

// Necesitamos cargar un array con los tipos de usuario válidos. Dicho array está en la clase Usuarios
$smarty->assign('tipos_poblacion_permitidos', PersonasReceptoras::tipos_poblacion_permitidos);

// La variable main se utilizará en el archivo footer.php
$main = $smarty->fetch("paginas/entrevistas/add_individual.tpl");

// Esta página necesita un javascript especial
$footer = $smarty->fetch("footer/add_entrevista_individual.tpl");

// Esta página necesita un javascript especial
require_once '../../footer.php';

$smarty->display('esqueleto_dashboard.html');