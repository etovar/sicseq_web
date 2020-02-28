<?php

// Listado de obras para el rol de ejecutora
// Rafael Reyna
require_once("../../contraloriasocialDB.php");
require_once("../../helpers/sesiones.php");
require_once("../../models/obra.php");
require_once("../../models/usuario.php");
$sesion = new Sesion($contraloriasocialDB);
if (!$sesion->sesion_activa()) {
    echo '<script language="JavaScript">location.href="../../index.php";</script>';
    exit;
}

//proceso
$obraobj = new Obra($contraloriasocialDB);
//verificando el id
if (isset($_GET['obra_id']) && $_GET['obra_id']) {
    if (!is_numeric($_GET['obra_id'])) {
        $sesion->set_flash('Error', "El id de obra no existe, intente nuevamente o contacte con su administrador", "error");
        echo '<script language="JavaScript">location.href="./ejecutora_listado.php";</script>';
        exit;
    }

    $obra = $obraobj->getObra($_GET['obra_id']);
    if (!$obra) {
        $sesion->set_flash('Error', "El id de obra es incorrecto, intente nuevamente o contacte con su administrador", "error");
        echo '<script language="JavaScript">location.href="./ejecutora_listado.php";</script>';
        exit;
    }
} else {
    $sesion->set_flash('Error', "El id de obra es requerido, intente nuevamente o contacte con su administrador", "error");
    echo '<script language="JavaScript">location.href="./ejecutora_listado.php";</script>';
    exit;
}

//procesos
$usuarioobj = new Usuario($contraloriasocialDB);
$personal_array = $usuarioobj->getPersonalBydependencia($obra['ejecutora_id']);

//Llamando vista
require("../../views/obras/asignar.php");

