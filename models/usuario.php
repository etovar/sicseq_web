<?php
/* Helper con todas las funcciones de manejo de sesión
 * Rafael Reyna
 * */
include_once (dirname(__FILE__)."/modelo.php");

class Usuario extends Modelo
{
    public function getUsuarios($limit = false){
        $limitquery = "";
        if($limit){
            $limitquery = "LIMIT {$limit}";
        }
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM usuarios {$limitquery}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        return $result;
    }

    public function getUsuario($id){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM usuarios WHERE id_usuario = {$id}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->find($vista);
        $vista->Close();
        return $result;
    }

    public function getPersonalBydependencia($dependencia_id){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM usuarios  WHERE usuario_movil = 1 AND dependencia_id = {$dependencia_id} ORDER BY idpersonal ASC") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        return $result;
    }

    public function getPersonalContraloria(){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM usuarios  WHERE usuario_movil = 1 AND urol_id = 2 ORDER BY idpersonal ASC") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        return $result;
    }

    public function updateUsuario($id,$data){
        $result = $this->update("usuarios","id_usuario","$id",$data);
    }

    public function addUsuario($data){
        if($_SERVER['HTTP_HOST'] == 'contraloriasocial.test')
            $seq = "usuarios_id_usuario_seq";
        else
            $seq = "id_usuario_seq";
        $result = $this->insert("usuarios",$seq,"id_usuario",$data);
        return $result;
    }

    public function getAdmins($rol_id){
        $limitquery = "";
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM usuarios WHERE urol_id = {$rol_id} AND usuario_administrador = 1") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        return $result;
    }
}
