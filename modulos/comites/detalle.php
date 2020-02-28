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

$obrasobj = new Obra($contraloriasocialDB);
$comitesobj = new Comite($contraloriasocialDB);
$usuarioobj = new Usuario($contraloriasocialDB);
if (isset($_GET['comite_id']) && $_GET['comite_id']) {
    $comite = $comitesobj->getComite($_GET['comite_id']);
    $listafotos = $comitesobj->getListaFotos($_GET['comite_id']);
    $documentofotos_integracion = $comitesobj->getDocumentosFotos($_GET['comite_id'],'integracion');
    $documentofotos_capacitacion = $comitesobj->getDocumentosFotos($_GET['comite_id'],'capacitacion');
    $evidenciafotos_integracion = $comitesobj->getEvidenciasFotos($_GET['comite_id'],'integracion');
    $evidenciafotos_capacitacion = $comitesobj->getEvidenciasFotos($_GET['comite_id'],'capacitacion');
    $evidenciafotos_general = $comitesobj->getEvidenciasFotos($_GET['comite_id'],'general');
} else {
    $comite = false;
}
$personal_array = array();

//Llamando vista
require("../../views/comites/detalle.php");
