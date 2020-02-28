<?php
// Listado de obras para el rol de ejecutora
// Rafael Reyna
require_once("../../contraloriasocialDB.php");
require_once("../../helpers/sesiones.php");
require_once("../../models/obra.php");
require_once("../../models/comite.php");
$sesion = new Sesion($contraloriasocialDB);
if (!$sesion->sesion_activa()) {
    echo '<script language="JavaScript">location.href="../../index.php";</script>';
    exit;
}

$comitesobj = new Comite($contraloriasocialDB);
if (isset($_GET['listafoto_id']) && $_GET['listafoto_id']) {
    $check = $comitesobj->getListafoto($_GET['listafoto_id'],$sesion);
} else {

}

if (isset($_GET['documentofoto_integracion_id']) && $_GET['documentofoto_integracion_id']) {
    $check = $comitesobj->getDocumentofoto($_GET['documentofoto_integracion_id'],'integracion',$sesion);
} else {

}

if (isset($_GET['documentofoto_capacitacion_id']) && $_GET['documentofoto_capacitacion_id']) {
    $check = $comitesobj->getDocumentofoto($_GET['documentofoto_capacitacion_id'],'capacitacion',$sesion);
} else {

}

if (isset($_GET['evidenciafoto_integracion_id']) && $_GET['evidenciafoto_integracion_id']) {
    $check = $comitesobj->getEvidenciafoto($_GET['evidenciafoto_integracion_id'],'integracion',$sesion);
} else {

}

if (isset($_GET['evidenciafoto_capacitacion_id']) && $_GET['evidenciafoto_capacitacion_id']) {
    $check = $comitesobj->getEvidenciafoto($_GET['evidenciafoto_capacitacion_id'],'capacitacion',$sesion);
} else {

}

if (isset($_GET['evidenciafoto_general_id']) && $_GET['evidenciafoto_general_id']) {
    $check = $comitesobj->getEvidenciafoto($_GET['evidenciafoto_general_id'],'general',$sesion);
} else {

}


//Llamando vista
require("../../views/ajax/check.php");
