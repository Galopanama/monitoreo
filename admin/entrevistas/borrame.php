<?php
require_once '../../config/config_admin.php';
require_once __DIR__ . '/../../src/Entrevistas.php';
require_once __DIR__ . '/../../src/PersonasReceptoras.php';


$db = null;
$id_pesona_receptora = '1234570';

try {
    PersonasReceptoras::getPersonaReceptora($id_pesona_receptora);

    // TODO: ¿actualizar los datos?
}
catch (PersonaReceptoraNotFoundException $e) {
    $datos_persona_receptora = [
        'id_persona_receptora' => $id_pesona_receptora,
        'poblacion' => 'HSH',
        'poblacion_originaria' => false
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
if (empty($errores)){
    $datos = [
        'id_promotor' => 32,
        'id_persona_receptora' => $id_pesona_receptora,
        'condones_entregados' => 1,
        'lubricantes_entregados' => 0,
        'materiales_educativos_entregados' => 10,
        'uso_del_condon' => false,
        'uso_de_alcohol_y_drogas_ilicitas' => false,
        'informacion_CLAM' => true,
        'referencia_a_prueba_de_VIH' => false,
        'referencia_a_clinica_TB' => false
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
}


if (!empty($errores)){
    foreach($errores as $error){
        echo "<br>" . $error;
    }
}
else {
    echo "Entrevista introducido con éxito";
}