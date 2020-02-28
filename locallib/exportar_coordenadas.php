<?php
require_once("../contraloriasocialDB.php");
require_once("../models/obra.php");

$obraobj = new Obra($contraloriasocialDB);
$obras = $obraobj->getObras();

foreach($obras as $obra){
    if($obra['picaso_croquis']){
        echo "UPDATE obras set lat = {$obra['lat']}, lon = {$obra['lon']}, zoom = {$obra['zoom']}, picaso_croquis = '".str_replace('\u00','',$obra['picaso_croquis'])."' WHERE num_obra = '{$obra['num_obra']}';";
    }
}
