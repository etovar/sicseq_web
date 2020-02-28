<?php
// Listado de obras para el rol de ejecutora
// Rafael Reyna
require_once ("../../contraloriasocialDB.php");
require_once ("../../helpers/sesiones.php");
require_once ("../../models/obra.php");
require_once ("../../lib/PHPExcel.php");

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
        $obras = $obraobj->getObrasByAsignado($sesion->usuario_id,false);
    } else { // contraloria
        $obras = $obraobj->getObrasByAsignadoContraloria($sesion->usuario_id, false);
    }
    foreach($obras as &$obra){
        unset($obra['normatividad']);
    }
}


$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);

if(count($obras) > 0){
    $encabezados = array_keys($obras[0]);
    //generando encabezados
    $apuntadorColumnas = resetearApuntadorColumnas();
    $apuntadorFilas = resetearApuntadorFilas();
    foreach($encabezados as $encabezado){
        if(is_string($encabezado)){
            $objPHPExcel->getActiveSheet()->SetCellValue($apuntadorColumnas.$apuntadorFilas, $encabezado);
            $apuntadorColumnas++;
        }
    }
    $apuntadorFilas++;

    foreach($obras as $obra){
        $apuntadorColumnas = resetearApuntadorColumnas();
        foreach($obra as $campo=>$valor){
            if(is_string($campo)){
                $objPHPExcel->getActiveSheet()->SetCellValue($apuntadorColumnas.$apuntadorFilas, $valor);
                $apuntadorColumnas++;
            }
        }
        $apuntadorFilas++;
    }
}

$objWriter = new PHPExcel_Writer_CSV($objPHPExcel);
//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="obras.csv"');
$objWriter->save('php://output');

function resetearApuntadorColumnas(){
    return "A";
}

function resetearApuntadorFilas(){
    return "1";
}
