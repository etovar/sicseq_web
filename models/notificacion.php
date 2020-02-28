<?php
/* Helper con todas las funcciones de manejo de sesión
 * Rafael Reyna
 * */
include_once (dirname(__FILE__)."/modelo.php");
include_once (dirname(__FILE__)."/usuario.php");

class Notificacion extends Modelo
{
    public function getNotificaciones($user_id, $obra_id = null, $limit = null){
        $limitquery = "";
        $obraquery = "";
        if($limit){
            $limitquery = "LIMIT {$limit}";
        }
        if($obra_id){
            $obraquery = "AND obra_id = {$obra_id}";
        }
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM notificaciones WHERE user_id = {$user_id} AND status <> 'Atendida' {$obraquery} ORDER BY prioridad, vencimiento DESC {$limitquery}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        return $result;
    }

    public function getNotificacionesAdmin($user_id, $rol, $dependencia_id = null){
        if($rol == 1){
            $dependencia_query = "AND dependencia_id = {$dependencia_id}";
        }
        else{
            $dependencia_query = "";
        }

        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM notificaciones WHERE status <> 'Atendida' AND user_id = {$user_id} OR (rol = {$rol} AND user_id is null {$dependencia_query}) ORDER BY prioridad ASC, fecha DESC, tipo DESC") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        return $result;
    }

    public function getAccionesAdmin($user_id, $rol, $dependencia_id = null){
        if($rol == 1){
            $dependencia_query = "AND dependencia_id = {$dependencia_id}";
        }
        else{
            $dependencia_query = "";
        }

        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM notificaciones WHERE tipo = 'Accion' AND status <> 'Atendida' AND (user_id = {$user_id} OR (rol = {$rol} AND user_id is null {$dependencia_query})) ORDER BY prioridad ASC, fecha DESC, tipo DESC") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        return $result;
    }

    public function getAvisosAdmin($user_id, $rol, $dependencia_id = null){
        if($rol == 1){
            $dependencia_query = "AND dependencia_id = {$dependencia_id}";
        }
        else{
            $dependencia_query = "";
        }

        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM notificaciones WHERE tipo = 'Aviso' AND status <> 'Atendida' AND (user_id = {$user_id} OR (rol = {$rol} AND user_id is null {$dependencia_query})) ORDER BY prioridad ASC, fecha DESC, tipo DESC") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        return $result;
    }

    public function getAvisos($user_id, $obra_id = null, $limit = null){
        $limitquery = "";
        $obraquery = "";
        if($limit){
            $limitquery = "LIMIT {$limit}";
        }
        if($obra_id){
            $obraquery = "AND obra_id = {$obra_id}";
        }
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM notificaciones WHERE tipo = 'Aviso' AND status <> 'Atendida' AND user_id = {$user_id} {$obraquery} ORDER BY prioridad, vencimiento DESC {$limitquery}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        return $result;
    }

    public function getAcciones($user_id, $obra_id = null, $limit = null){
        $limitquery = "";
        $obraquery = "";
        if($limit){
            $limitquery = "LIMIT {$limit}";
        }
        if($obra_id){
            $obraquery = "AND obra_id = {$obra_id}";
        }
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM notificaciones WHERE tipo = 'Accion' AND status <> 'Atendida' AND user_id = {$user_id} {$obraquery} ORDER BY prioridad, vencimiento DESC {$limitquery}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        return $result;
    }

    public function getNotificacion($id){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM notificaciones WHERE id = {$id}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->find($vista);
        $vista->Close();
        return $result;
    }


    public function updateNotificacion($id,$data){
        $result = $this->update("notificaciones","id",$id,$data);
        return $result;
    }

    public function addNotificacion($data){
        if($_SERVER['HTTP_HOST'] == 'contraloriasocial.test')
            $seq = "notificaciones_id_seq";
        else
            $seq = "id_notificacion_seq";

        $result = $this->insert("notificaciones",$seq,"id",$data);
        return $result;
    }

    public function enviarNotificacionAdmin($rol_id, $data, $email = false){
        $userobj = new Usuario($this->contraloriasocialDB);
        $usuarios = $userobj->getAdmins($rol_id);
        foreach($usuarios as $usuario){
            $data['user_id'] = $usuario['id_usuario'];
            $notificacion = $this->addNotificacion($data);
            if($email){
                //$notificacion->sendEmail();
            }
        }
    }

}
