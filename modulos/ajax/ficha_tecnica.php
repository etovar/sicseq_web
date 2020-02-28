<?php
// Listado de obras para el rol de ejecutora
// Rafael Reyna
require_once ("../../contraloriasocialDB.php");
require_once ("../../helpers/sesiones.php");
require_once ("../../models/obra.php");


$sesion = new Sesion($contraloriasocialDB);
if(!$sesion->sesion_activa()){
    echo '<script language="JavaScript">location.href="../../index.php";</script>';
    exit;
}
//Procedminiento
if(isset($_GET['obra_id']) && $_GET['obra_id']){
    $obraobj = new Obra($contraloriasocialDB);
    $obra = $obraobj->getObra($_GET['obra_id']);
}else{
    $obra = false;
}


//Llamando vista
require("../../views/ajax/ficha_tecnica.php");
