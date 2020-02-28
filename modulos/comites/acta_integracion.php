<?php
// Listado de obras para el rol de ejecutora
// Rafael Reyna

require_once ("../../contraloriasocialDB.php");
require_once ("../../helpers/sesiones.php");
require_once ("../../models/obra.php");
require_once ("../../models/comite.php");
require_once ("../../models/usuario.php");
require_once ("../../lib/dompdf/dompdf_config.inc.php");

use Dompdf\Dompdf;

$sesion = new Sesion($contraloriasocialDB);
if(!$sesion->sesion_activa()){
    echo '<script language="JavaScript">location.href="../../index.php";</script>';
    exit;
}

//Procedminiento
$comitesobj = new Comite($contraloriasocialDB);
$comite = $comitesobj->getComite($_GET['comite_id']);

if(!is_file("../../storage/actas/acta_integracion_{$comite['id_comite']}.pdf")){
    $obrasobj = new Obra($contraloriasocialDB);
    $usuariosobj = new Usuario($contraloriasocialDB);

    $obra = $obrasobj->getObra($comite['obra_id']);
    $usuario = $usuariosobj->getUsuario($comite['usuario_id']);

    $generar = true;
    $integrantes = $comitesobj->GetIntegrantes($comite['id_comite'], 'integracion');
    $integracion = $comitesobj->GetIntegracion($comite['id_comite']);
    $testigos = $comitesobj->GetTestigos($comite['id_comite']);

    ob_start();
    include('../../formatos/acta_integracion.php');
    $html = ob_get_contents();
    ob_end_clean();

    $dompdf = new \DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper('US-letter');
    $dompdf->render();
//$dompdf->stream("formato_integracion.pdf", array("Attachment" => false));
    $output = $dompdf->output();
    file_put_contents("../../storage/actas/acta_integracion_{$comite['id_comite']}.pdf", $output);
}
header("Content-type:application/pdf");
readfile("../../storage/actas/acta_integracion_{$comite['id_comite']}.pdf");
