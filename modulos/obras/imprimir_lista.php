<?php
// Listado de obras para el rol de ejecutora
// Rafael Reyna
require_once ("../../contraloriasocialDB.php");
require_once ("../../helpers/sesiones.php");
require_once ("../../models/obra.php");

require_once ("../../lib/dompdf/dompdf_config.inc.php");

use Dompdf\Dompdf;

$sesion = new Sesion($contraloriasocialDB);
if(!$sesion->sesion_activa()){
    echo '<script language="JavaScript">location.href="../../index.php";</script>';
    exit;
}



//Procedminiento
$obraobj = new Obra($contraloriasocialDB);
if($sesion->usuario_adminsitrador_x_contraloriasocial) { // es admin
    if ($sesion->urol_id_x_contraloriasocial == 1) { // ejecutora
        $obras = $obraobj->getObrasByEjecutora($sesion->dependencia_id_x);
    } else { // contraloria
        $obras = $obraobj->getObras();
    }
}
else { //es usuario movil
    if ($sesion->urol_id_x_contraloriasocial == 1) { // ejecutora
        $obras = $obraobj->getObrasByAsignado($sesion->usuario_id);
    } else { // contraloria
        $obras = $obraobj->getObrasByAsignadoContraloria($sesion->usuario_id);
    }
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

