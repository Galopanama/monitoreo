<?php
require_once __DIR__ . '/../../config/config.php';
// Restringimos el acceso sólo a usuarios 'promotor'
// Access only permited to the user 'promtor'
$perfiles_aceptados = array('promotor');
require_once __DIR__ . '/../../security/autorizador.php';
// Call the files from database
require_once __DIR__ . '/../../lib/DB.php';
// Call the files from the Model
require_once __DIR__ . '/../../src/Entrevistas.php';
require_once __DIR__ . '/../../src/PersonasReceptoras.php';

// To show 10 rows at the time
$numero_filas_mostrar = 10;
// Send the data if not empty row 
if (!empty($_POST['id_cedula_persona_receptora_buscada_1'])) {
    // Keep the errors in an array if found
    $errores = array(); 
    // Vamos a comprobar si los datos necesarios están
    // Check for the data to reach the minimum filled 
    if (empty($_POST['region_de_salud'])){
        $errores['region_de_salud'] = "Debe especificar la región de salud"; // error message to return if not filled. Explains error
    }

    if (empty($_POST['area'])){
        $errores['area'] = "Debe especificar el área"; // error message to return if not filled. Explains error
    } 

    $numero_filas_enviadas = 0;
    for ($i = 1; $i <= $numero_filas_mostrar; $i++) {
        // Pararemos de contar cuando la cedula esté vacía
        // Stops when the id not filled
        if (empty($_POST['id_cedula_persona_receptora_buscada_' . $i])){
            // Si la fila está vacía, paramos de validar
            $numero_filas_enviadas = $i - 1; //Como esta ya está vacía y el contador se ha incrementado, hay que restar uno
            break;                           //Deduct one from the number of row sent as the counter started with 1
        }
    
        if (!is_numeric($_POST['condones_entregados_' . $i])){
            $errores['condones_entregados'] = "Debe especificar el número de condones entregados, aunque sea 0"; // error message to return if not filled. Explains error
        }
    
        if (!is_numeric($_POST['lubricantes_entregados_' . $i])){
            $errores['lubricantes_entregados'] = "Debe especificar el número de lubricantes entregados, aunque sea 0"; // error message to return if not filled. Explains error
        }
    
        if (!is_numeric($_POST['materiales_educativos_entregados_' . $i])){
            $errores['materiales_educativos_entregados'] = "Debe especificar el número de materiales educativos entregados, aunque sea 0"; // error message to return if not filled. Explains error
        }
    }


    if (empty($errores)) {

        // Para hacer todo el proceso más eficiente, vamos a intentar validar o crear TODAS las personas receptoras antes de crear las entrevistas
        // Además, lo haremos dentro de una transacción
        // Call a new object of the database
        $db = new Db();
        $mysqli = $db->conecta();
        $mysqli->autocommit(false);
        // Create the instance person add start adding the information 
        for ($i = 1; $i <= $numero_filas_enviadas; $i++){
            // Tenemos que tener en cuenta que si la persona no existe, hay que crearla antes de introducir los datos en la tabla entrevistas
            // ya que existe una clave ajena que afecta
            try { // Check if the person already exixts already in the database
                PersonasReceptoras::getPersonaReceptora($_POST['id_cedula_persona_receptora_buscada_' . $i]);

                
            } // if not found the person, create one with the initial fields required for the system
            catch (PersonaReceptoraNotFoundException $e) {
                // Si no existe, el identificador no lo obtenemos del campo id_persona_receptora, sino de id_persona_receptora_buscada
                $datos_persona_receptora = [
                    'id_cedula_persona_receptora' => $_POST['id_cedula_persona_receptora_buscada_' . $i],
                    'poblacion' => $_POST['poblacion_' . $i],
                    'poblacion_originaria' => $_POST['poblacion_originaria_' . $i]?true:false
                ];
                // Le pedimos al método que nos devuelva el objeto de la conexión, para poder hacer la transacción
                // request for the transaction to add the new individual
                try {
                    PersonasReceptoras::add($datos_persona_receptora, $db);
                }
                catch (ValidationException $e) {
                    // Los mensajes de validación vienen como un array serializado en el mensaje de la excepción
                    // If errors in the process of validation the information, return the message from the serialized array
                    $errores = unserialize($e->getMessage());
                }   // return if any other errors found 
                catch (Exception $e) {
                    $errores[] = $e->getMessage();
                }
            }
        }
        

        // Si no han ocurrido errores hasta ahora, procedemos a intentar añadir las entrevistas
        // if there are no errors, we proceed to add the interviews
        if (empty($errores)){

            for ($i = 1; $i <= $numero_filas_enviadas; $i++){
                // Aunque en principio los nombres del formulario vamos a crear un array con dichas claves
                //  We create and associative array with the attributes of the group interview as keys
                $datos = [
                    'id_promotor' => $_SESSION['usuario_id'], 
                    'id_cedula_persona_receptora' => $_POST['id_cedula_persona_receptora_buscada_' . $i], 
                    'condones_entregados' => $_POST['condones_entregados_' . $i],
                    'lubricantes_entregados' => $_POST['lubricantes_entregados_' . $i],
                    'materiales_educativos_entregados' => $_POST['materiales_educativos_entregados_' . $i],
                    'region_de_salud' => $_POST['region_de_salud'],
                    'area' => $_POST['area'],
                    'estilos_autocuidado' => $_POST['estilos_autocuidado_' . $i]?true:false,
                    'ddhh_estigma_discriminacion' => $_POST['ddhh_estigma_discriminacion_' . $i]?true:false,
                    'uso_correcto_y_constantes_del_condon' => $_POST['uso_correcto_y_constantes_del_condon_' . $i]?true:false, 
                    'salud_sexual_e_ITS' => $_POST['salud_sexual_e_ITS_' . $i]?true:false,
                    'ofrecimiento_y_referencia_a_la_prueba_de_VIH' => $_POST['ofrecimiento_y_referencia_a_la_prueba_de_VIH_' . $i]?true:false,
                    'CLAM_y_otros_servicios' => $_POST['CLAM_y_otros_servicios_' . $i]?true:false,
                    'salud_anal' => $_POST['salud_anal_' . $i]?true:false, 
                    'hormonizacion' => $_POST['hormonizacion_' . $i]?true:false, 
                    'apoyo_y_orientacion_psicologico' => $_POST['apoyo_y_orientacion_psicologico_' . $i]?true:false,
                    'diversidad_sexual_identidad_expresion_de_genero' => $_POST['diversidad_sexual_identidad_expresion_de_genero_' . $i]?true:false,
                    'tuberculosis_y_coinfecciones' => $_POST['tuberculosis_y_coinfecciones_' . $i]?true:false, 
                    'infecciones_oportunistas' => $_POST['infecciones_oportunistas_' . $i]?true:false
                ];

                try {
                    Entrevistas::addGrupal($datos, $db);
                } 
                catch (ValidationException $e) {
                    // Los mensajes de validación vienen como un array serializado en el mensaje de la excepción
                    //If there are any errors, theye will be return with a message 
                    $errores = unserialize($e->getMessage());
                }   // any other errors will be catch here and return a general error message
                catch (Exception $e) {
                    $errores[] = $e->getMessage();
                }
            }

            if (empty($errores)){
                // Por último, si todo ha ido bien, hacemos el commit
                // commit if all has proceed without any errors
                $mysqli->commit();
                // No ha habido errores, redirigimos a la página del listado
                // print an success message and redirect the user to the group interview page.
                $_SESSION['exito_titulo'] = "Entrevista grupal añadida con éxito";
                $_SESSION['exito_mensaje'] = "La entrevista ha sido dada de alta correctamente en el sistema";
                header('Location: ' . _WEB_PATH_ . '/user/entrevistas/grupales.php');
                exit;
            }
        }
        // Si hay errores, el commit no se realizará
    }

    // Asignamos los errores si los hubiera (que si el código ha llegado aquí, los hay)
    // If the code has reach this point, there are errors
    $smarty->assign('errores', $errores);

    // Además, cargamos los datos que el usuario ya haya escrito
    // The values that the user inputed and were correct, will be return in the form, so he/she does not need to type again
    $valores = array();
    for ($i = 1; $i <= $numero_filas_enviadas; $i++){
        foreach (array_keys($_POST) as $elem) {
            $name = $elem;
            $posicion_guion = strrpos($elem, '_') + 1;
            // Tenemos que analizar si el elemento en cuestión termina en número o no, pues si termina en número es de una fila
            if (is_numeric($index = substr($elem, $posicion_guion))){
                if ($index == $i) { // Sólo tenemos que analizar aquellos elementos que tengan que ver con la fila en cuestión
                    // Si el elemento pertenece a una fila, lo pondremos en el array valores
                    $name = substr($elem, 0, strrpos($elem, '_'));
                    $valores[$i][$name] = $_POST[$elem];
                }                
            }
            else {
                // Si no, lo asignamos directamente
                $smarty->assign($name, $_POST[$elem]);
            }
        }
    }
    $smarty->assign('valores', $valores);
}

// El título de la página será Añadir usuario (la misma plantilla se utiliza para modificar)
// Name of the template is Añadir usuario
$smarty->assign('titulo', 'Añadir entrevista grupal');
$smarty->assign('numero_filas_mostrar', $numero_filas_mostrar);

// Necesitamos cargar un array con los tipos de usuario válidos. Dicho array está en la clase Usuarios
// Call for an array with the valid users that is in the class PersonasReceptoras
$smarty->assign('tipos_poblacion_permitidos', PersonasReceptoras::tipos_poblacion_permitidos);

// De igual forma, cargamos las regiones de salud
// We load the regiones de salud that are allowed
$smarty->assign('regiones_de_salud', Entrevistas::regiones_de_salud_permitidas);

// La variable main se utilizará en el archivo footer.php
// The visual part gets load 
$main = $smarty->fetch("paginas/entrevistas/add_grupal.tpl");

// Esta página necesita un javascript especial
// load a special javascripf for this page
$footer = $smarty->fetch("footer/add_entrevista_grupal.tpl");


require_once '../../footer.php';

$smarty->display('esqueleto_dashboard.html');