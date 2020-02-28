<?php
// Listado de obras para el rol de ejecutora
// Rafael Reyna
require_once ("../../contraloriasocialDB.php");
require_once ("../../helpers/sesiones.php");
require_once ("../../models/obra.php");
require_once ("../../models/comite.php");
$sesion = new Sesion($contraloriasocialDB);
if(!$sesion->sesion_activa()){
    echo '<script language="JavaScript">location.href="../../index.php";</script>';
    exit;
}
//Procedminiento
if(isset($_GET['status']) && $_GET['status']){
    $statusjs = "'{$_GET['status']}'";
}
else{
    $statusjs = "false";
}

$obrasobj = new Obra($contraloriasocialDB);
$comitesobj = new Comite($contraloriasocialDB);
if(isset($_GET['obra_id']) && $_GET['obra_id']){
    $obra = $obrasobj->getObra($_GET['obra_id']);
    $comites = $comitesobj->getComitesByObra($_GET['obra_id']);
}
else{
    $obra = false;
    $comites = $comitesobj->getComites();
}

$usuarioobj = new Usuario($contraloriasocialDB);
$personal_array = array();

//Llamando vista
require("../../views/comites/contraloria_listado.php");
