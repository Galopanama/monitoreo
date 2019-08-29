<?php

require_once '../../config/config_admin.php';
require_once __DIR__ . '/../../src/Entrevistas.php';
require_once __DIR__ . '/../../src/PersonasReceptoras.php';

/*$listaEntrevistas = Entrevistas::getAllEntrevistasIndividuales();

print_r($listaEntrevistas);*/

//echo Datetime::createFromFormat('d/m/Y', '23/7/2019')->format('Y-m-d');

try {
    $entrevista = Entrevistas::getEntrevistaIndividual(35, "123456", Datetime::createFromFormat('d/m/Y', '29/8/2019')->format('Y-m-d'));
    $persona_receptora = PersonasReceptoras::getPersonaReceptora($entrevista->getId_persona_receptora());
}
catch (EntrevistaIndividualNotFoundException $e) {
    echo "no se encuentra";
}
catch (Exception $e){
    echo "otro error";
}

print_r($entrevista);
echo "<hr>";
print_r($persona_receptora);