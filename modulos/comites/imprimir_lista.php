<?php
// Listado de obras para el rol de ejecutora
// Rafael Reyna
require_once ("../../contraloriasocialDB.php");
require_once ("../../helpers/sesiones.php");
require_once ("../../models/comite.php");

require_once ("../../lib/dompdf/dompdf_config.inc.php");

use Dompdf\Dompdf;

$sesion = new Sesion($contraloriasocialDB);
if(!$sesion->sesion_activa()){
    echo '<script language="JavaScript">location.href="../../index.php";</script>';
    exit;
}



//Procedminiento
$comitesobj = new Comite($contraloriasocialDB);
if($sesion->urol_id_x_contraloriasocial == 1){
    $comites = $comitesobj->getComitesByEjecutora($sesion->dependencia_id_x);
}
else{
    $comites = $comitesobj->getComites();
}

ob_start();
include('./info_lista.php');
$html = ob_get_contents();
ob_end_clean();

$dompdf = new \DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper('US-letter', 'landscape');
$dompdf->render();
$dompdf->stream("lista_obras.pdf", array("Attachment" => false));

