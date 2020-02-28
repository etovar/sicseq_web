<?php
/* Helper con todas las funcciones de manejo de sesión
 * Rafael Reyna
 * */
include_once (dirname(__FILE__)."/modelo.php");
include_once (dirname(__FILE__)."/comite.php");
include_once (dirname(__FILE__)."/fondo.php");

class Obra extends Modelo
{
    public function getObras($limit = false){
        $limitquery = "";
        if($limit){
            $limitquery = "LIMIT {$limit}";
        }
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM obras ORDER BY num_obra DESC {$limitquery}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        return $result;
    }

    public function getObrasByAsignado($asignado_id, $conComites = true){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT obra_id FROM comites  WHERE usuario_id = {$asignado_id} GROUP BY obra_id") or die($this->contraloriasocialDB->ErrorMsg());
        $obra_ids = $this->select($vista);
        $vista->Close();
        $obras = array();
        foreach($obra_ids as $obra_id){
            $obra = $this->getObra($obra_id['obra_id'],$conComites);
            $obra['normatividad'] = $this->getNormatividad($obra['id_obra']);
            $obras[] = $obra;
        }
        return $obras;
    }

    public function getObrasByAsignadoContraloria($asignado_id,$conComites = true){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT obra_id FROM comites  WHERE contraloria_usuario_id = {$asignado_id} GROUP BY obra_id") or die($this->contraloriasocialDB->ErrorMsg());
        $obra_ids = $this->select($vista);
        $vista->Close();
        $obras = array();
        foreach($obra_ids as $obra_id){
            $obra = $this->getObra($obra_id['obra_id'],$conComites);
            $obra['normatividad'] = $this->getNormatividad($obra['id_obra']);
            $obras[] = $obra;
        }
        return $obras;
    }

    public function getObra($id,$conComites = true){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM obras WHERE id_obra = {$id}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->find($vista);
        $vista->Close();
        if($conComites){
            if($result){ // anexando comités
                $comiteobj = new Comite($this->contraloriasocialDB);
                $result['comites'] = $comiteobj->getComitesByObra($result['id_obra']);
            }
            else{
                $result['comites'] = array();
            }
        }
        return $result;
    }

    public function getObraByNombre($nombre){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM obras WHERE nombre_obra = '{$nombre}'") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->find($vista);
        $vista->Close();
        return $result;
    }

    public function getObraByNumero($numero){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM obras WHERE num_obra = '{$numero}' ORDER BY num_obra DESC") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->find($vista);
        $vista->Close();
        return $result;
    }

    public function buscarObrasByNumero($numero){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM obras WHERE num_obra LIKE '%{$numero}%' ORDER BY num_obra DESC") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        return $result;
    }

    public function getObrasByEjecutora($ejecutora_id){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM obras  WHERE ejecutora_id = {$ejecutora_id} ORDER BY num_obra DESC") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        return $result;
    }

    public function updateObra($id,$data){
        $result = $this->update("obras","id_obra",$id,$data);
        return $result;
    }

    public function addObra($data){
        if($_SERVER['HTTP_HOST'] == 'contraloriasocial.test')
            $seq = "obras_1_id_obra_seq";
        else
            $seq = "id_obra_seq";

        $result = $this->insert("obras",$seq,"id_obra",$data);
        return $result;
    }

    public function getNormatividad($obra_id){
        $obra = $this->getObra($obra_id);
        $fondoobj = new Fondo($this->contraloriasocialDB);
        $fondo = $fondoobj->findByFondo($obra['fondo']);
        if($fondo){
            return $fondo['norma_cs_aplica'];
        }
        else{
            return false;
        }
    }

}
