<?php
// the file will add pruebas

require_once __DIR__ . '/../../config/config.php';
// Restringimos el acceso sólo a usuarios tecnologo
$perfiles_aceptados = array('tecnologo');
require_once __DIR__ . '/../../security/autorizador.php';
// Call the files from the Controller
require_once __DIR__ . '/../../src/Pruebas.php';
require_once __DIR__ . '/../../src/PersonasReceptoras.php';


// Send the data if not empty row
if (!empty($_POST['id_cedula_persona_receptora_buscada'])) {
    // Se han enviado datos
     // Keep the errors in an array if found
    $errores = array();
    // Vamos a comprobar si los datos necesarios están
     // Check if the following fields are filled. They are necesary to submit the form
    if (empty($_POST['id_cedula_persona_receptora_buscada'])){
        $errores['id_cedula_persona_receptora_buscada'] = "Debe especificar la persona a la que va a realizar la prueba";
    }
    if (empty($errores)) {
        // Tenemos que tener en cuenta que si la persona no existe, hay que crearla antes de introducir los datos en la tabla entrevistas
        // ya que existe una clave ajena que afecta
        // If the person has not been found, we preocced to create the person. 
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
            // Create an object of connection in order to introduce the data and create the instace of the class
            try {
                $db = PersonasReceptoras::add($datos_persona_receptora, true); 
            }
            catch (ValidationException $e) {
                // Los mensajes de validación vienen como un array serializado en el mensaje de la excepción
                // A message of error will be generated if there is an obligatory atribute that is not been filled 
                $errores = unserialize($e->getMessage());
            }
            catch (Exception $e) {
                $errores[] = $e->getMessage();
            }
        }

        // Si no han ocurrido errores hasta ahora, procedemos a intentar añadir la entrevista
        // If there are no errors so far, the object is created with the atributes below
        if (empty($errores)){
            // Aunque en principio los nombres del formulario deberían de ser los mismos que los que espera la clase Prueba, 
            // vamos a crear un array con dichas claves

            $datos = [
                'id_tecnologo' => $_SESSION['usuario_id'],
                'id_cedula_persona_receptora' => $_POST['id_cedula_persona_receptora_buscada'], 
                'realizacion_prueba' => $_POST['realizacion_prueba'],    // DUDA SOBRE LOS VALORES true:false en realizacion prueba y resultado_prueba
                'consejeria_pre_prueba' => $_POST['consejeria_pre_prueba']?true:false,
                'consejeria_post_prueba' => $_POST['consejeria_post_prueba']?true:false,
                'resultado_prueba' => $_POST['resultado_prueba']        // son correctos o no? si no lo son, cual seria el valor correcto??
            ];
            try {
                Pruebas::add($datos);
            }
            catch (ValidationException $e) {
                // Los mensajes de validación vienen como un array serializado en el mensaje de la excepción
                 // A message of error will be generated if there is an obligatory atribute that is not been filled
                $errores = unserialize($e->getMessage());
            }
            catch (Exception $e) {
                $errores[] = $e->getMessage();
            }
            if (empty($errores)){
            // No ha habido errores, redirigimos a la página del listado
            // If there has not been errors, a message of succeed will be display and the user will be redirected to the page where all the pruebas are listed
                $_SESSION['exito_titulo'] = "Prueba añadida con éxito";
                $_SESSION['exito_mensaje'] = "La prueba ha sido dada de alta correctamente en el sistema";
                header('Location: ' . _WEB_PATH_ . '/user/pruebas/pruebas.php');
                exit;
            }
        }
        // Asignamos los errores si los hubiera (que si el código ha llegado aquí, los hay)
        // if the code reach this part of the code, there is an error
        $smarty->assign('errores', $errores);
        // Además, cargamos los datos que el usuario ya haya escrito
        // the form is returnd to the user with the infromation missing in the fields that were wrongly filled
        foreach (array_keys($_POST) as $elem) {
            $smarty->assign($elem, $_POST[$elem]);
        }
    }
}

// El título de la página será Añadir prueba 
// The page has assigned a name as Annadir prueba 
$smarty->assign('titulo', 'Añadir prueba');

// Necesitamos cargar un array con los tipos de usuario válidos. Dicho array está en la clase Usuarios
// Load the arrays with the information that is prefilled in order to make it easier to the user to fill the form and reduce erros in the data
$smarty->assign('tipos_poblacion_permitidos', PersonasReceptoras::tipos_poblacion_permitidos);
$smarty->assign('resultados_posibles', Pruebas::resultados_posibles); 
$smarty->assign('realizacion_prueba', Pruebas::realizacion_prueba);

// La variable main se utilizará en el archivo footer.php
// The view is load
$main = $smarty->fetch("paginas/pruebas/add_prueba.tpl");

// Esta página necesita un javascript especial
$footer = $smarty->fetch("footer/add_prueba.tpl");

// Esta página necesita un javascript especial
require_once '../../footer.php';
$smarty->display('esqueleto_dashboard.html');

?>