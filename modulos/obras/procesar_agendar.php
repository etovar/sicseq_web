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

if(!isset($_POST)){
    echo '<script language="JavaScript">location.href="./ejecutora_listado.php";</script>';
    exit;
}



//Procedminiento
$obraobj = new Obra($contraloriasocialDB);
$data = $_POST;
$data['status'] = 'agendada';

if(isset($data['agendada_hora']) && $data['agendada_hora']){
    $hora_array = explode(";",$data['agendada_hora']);
    $data['agendada_hora_inicio'] = date("H:i",$hora_array[0]);
    $data['agendada_hora_fin'] = date("H:i",$hora_array[1]);
    unset($data['agendada_hora']);
}
unset($data['obra_id']);

$obra = $obraobj->updateObra($_POST['obra_id'], $data);
//genherando comites
$comiteobj = new Comite($contraloriasocialDB);
$comites = $comiteobj->getComitesByObra($obra['id_obra']);
if(count($comites) == 0){ // no se han generado comites
    for($i = 1; $i <= $obra['no_comites']; $i++){
        $datacomite['num_comite'] = "{$obra['num_obra']}-" . str_pad($i, 3, '0', STR_PAD_LEFT);
        $datacomite['obra_id'] = $obra['id_obra'];
        $comiteobj->addComite($datacomite);
    }
}

//redireccion
$sesion->set_flash('Obra Agendada',"La obra se ha agendado correctamente", "success");
echo '<script language="JavaScript">location.href="./agendar.php?obra_id='.$_POST['obra_id'].'";</script>';

