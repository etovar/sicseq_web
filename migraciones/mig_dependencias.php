<?php
// rutina para importar las dependencias de la tabla de obras
include('../models/obra.php');
include('../models/dependencia.php');
require_once ("../contraloriasocialDB.php");
$obraobj = new Obra($contraloriasocialDB);
$dependenciaobj = new Dependencia($contraloriasocialDB);
$obras = $obraobj->getObras();


$dependencias = [];
foreach($obras as $obra){
    $dependencias[$obra['ejecutora']] = $obra['ejecutora'];
}

echo "<p>Dependencias encontradas: ".count($dependencias)."</p>";

foreach ($dependencias as $dependencia){
    $data['nombre'] = $dependencia;
    $dependenciadatabase = $dependenciaobj->insert($data);
    echo "<p>Insertando: {$dependenciadatabase['nombre']}</p>";
}


