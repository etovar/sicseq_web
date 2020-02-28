<?php
try{
    require_once (dirname(__FILE__)."/../contraloriasocialDB.php");
    include(dirname(__FILE__).'/../models/obra.php');
    include(dirname(__FILE__).'/../models/dependencia.php');
    $obraobj = new Obra($contraloriasocialDB);
    $dependenciaobj = new Dependencia($contraloriasocialDB);
    $obras = $obraobj->getObras();
    echo "<h4>Migrando...</h4>";
    $dependencias = array();
    foreach($obras as $obra){
        $dependencia_nombre = $obra['ejecutora'];
        $dependencia = $dependenciaobj->getDependenciaByNombre($dependencia_nombre);
        if($dependencia){
            $data['ejecutora_id'] = $dependencia['id_dependencia'];
            $obraobj->updateObra($obra["id_obra"],$data);
            echo "<p>Update Obra {$obra['nombre_obra']} --> Ejecutora_id: {$dependencia['id_dependencia']}</p>";
        }
    }
}
catch(ErrorException $e){
    echo $e->getMessage();
}
// rutina para asignar las ejecutoras en base al id de ejecutora
