<?php
/* Modelo de Dependencias
 * Rafael Reyna
 * */
include_once (dirname(__FILE__)."/modelo.php");

class Dependencia extends Modelo
{
    public function getDependencias($limit = false){
        $limitquery = "";
        if($limit){
            $limitquery = "LIMIT {$limit}";
        }
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM dependencias ORDER BY nombre ASC {$limitquery}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        return $result;
    }

    public function addDependencia($data){
        if($_SERVER['HTTP_HOST'] == 'contraloriasocial.test')
            $seq = "dependencias_id_depedencia_seq";
        else
            $seq = "id_dependencia_seq";

        $result = $this->insert("dependencias",$seq,"id_dependencia",$data);
        return $result;
    }

    public function getDependenciaByNombre($nombre){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM dependencias WHERE nombre = '{$nombre}'") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->find($vista);
        $vista->Close();
        return $result;
    }

    public function updateDependencia($id,$data){
        $result = $this->update("dependencias","id_dependencia","$id",$data);
    }
}

