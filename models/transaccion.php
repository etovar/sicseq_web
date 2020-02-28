<?php
/* Modelo de Dependencias
 * Rafael Reyna
 * */
include_once (dirname(__FILE__)."/modelo.php");

class Transaccion extends Modelo
{
    public function getTransacciones($limit = false){
        $limitquery = "";
        if($limit){
            $limitquery = "LIMIT {$limit}";
        }
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM transacciones ORDER BY fecha_c DESC {$limitquery}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        return $result;
    }

    public function addTransacción($data){
        if($_SERVER['HTTP_HOST'] == 'contraloriasocial.test')
            $seq = "picaso_transacciones_id_seq";
        else
            $seq = "picaso_transacciones_id_seq";

        $result = $this->insert("picaso_transacciones",$seq,"id",$data);
        return $result;
    }

    public function updateTransaccion($id,$data){
        $result = $this->update("picaso_transacciones","id",$id,$data);
        return $result;
    }

}

