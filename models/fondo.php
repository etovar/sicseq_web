<?php
/* Modelo de Dependencias
 * Rafael Reyna
 * */
include_once (dirname(__FILE__)."/modelo.php");

class Fondo extends Modelo
{
    public function getFondos($limit = false){
        $limitquery = "";
        if($limit){
            $limitquery = "LIMIT {$limit}";
        }
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM fondos ORDER BY fondo ASC {$limitquery}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        return $result;
    }

    public function findByFondo($fondo){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM fondos WHERE fondo = '{$fondo}'") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->find($vista);
        $vista->Close();
        return $result;
    }

    public function addFondo($data){
        if($_SERVER['HTTP_HOST'] == 'contraloriasocial.test')
            $seq = "fondos_id_seq";
        else
            $seq = "fondos_id_seq";

        $result = $this->insert("fondos",$seq,"id",$data);
        return $result;
    }

    public function actualizarFondo($fondo){
        $fondo_datos = $this->findByFondo($fondo);
        if(!$fondo_datos){
            $data['fondo'] = $fondo;
            $fondo_datos = $this->addFondo($data);
        }
        return $fondo_datos;
    }


}

