<?php
/* Modelo de Dependencias
 * Rafael Reyna
 * */
include_once (dirname(__FILE__)."/modelo.php");

class Picasoobra extends Modelo
{
    public function getObras($transaccion_id, $limit = false){
        $limitquery = "";
        if($limit){
            $limitquery = "LIMIT {$limit}";
        }
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM picaso_obras WHERE transaccion_id = {$transaccion_id} ORDER BY numobra DESC {$limitquery}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        return $result;
    }

    public function getObrasByTransaccion($transaccion_id){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM picaso_obras  WHERE transaccion_id = {$transaccion_id} ") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        return $result;
    }

    public function addObra($data){
        if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST']== 'contraloriasocial.test')
            $seq = "picaso_obras_id_seq";
        else
            $seq = "picaso_obras_id_seq";

        $result = $this->insert("picaso_obras",$seq,"id",$data);
        return $result;
    }

    public function updateObra($id,$data){
        $result = $this->update("picaso_obras","id",$id,$data);
        return $result;
    }

}

