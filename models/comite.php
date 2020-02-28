<?php
/* Helper con todas las funcciones de manejo de sesión
 * Rafael Reyna
 * */
include_once (dirname(__FILE__)."/modelo.php");
include_once (dirname(__FILE__)."/usuario.php");
include_once (dirname(__FILE__)."/obra.php");

class Comite extends Modelo
{
    public function getComites($limit = false){
        $limitquery = "";
        if($limit){
            $limitquery = "LIMIT {$limit}";
        }
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM comites {$limitquery}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        foreach ($result as &$comite){
            if(isset($comite['usuario_id']) && $comite['usuario_id']){
                $usuarioobj = new Usuario($this->contraloriasocialDB);
                $comite['usuario'] = $usuarioobj->getUsuario($comite['usuario_id']);
            }
            else{
                $comite['usuario'] = false;
            }
            if(isset($comite['obra_id']) && $comite['obra_id']){
                $obraobj = new Obra($this->contraloriasocialDB);
                $obra = $obraobj->getObra($comite['obra_id'],false);
                $comite['obra'] = $obra;
            }
            else{
                $comite['obra'] = false;
            }
        }
        return $result;
    }

    public function getComite($id){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM comites WHERE id_comite = {$id}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->find($vista);
        $vista->Close();
        if($result){ // anexando comités
            if(isset($result['usuario_id']) && $result['usuario_id']){
                $usuarioobj = new Usuario($this->contraloriasocialDB);
                $result['usuario'] = $usuarioobj->getUsuario($result['usuario_id']);
            }
            else{
                $result['usuario'] = false;
            }
            if(isset($result['obra_id']) && $result['obra_id']){
                $obraobj = new Obra($this->contraloriasocialDB);
                $obra = $obraobj->getObra($result['obra_id'],false);
                $result['obra'] = $obra;
            }
            else{
                $comite['obra'] = false;
            }
        }

        return $result;
    }

    public function getComitesByAsignado($asignado_id){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM comites  WHERE usuario_id = {$asignado_id} ORDER BY num_comite") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        foreach ($result as &$comite){
            if(isset($comite['usuario_id']) && $comite['usuario_id']){
                $usuarioobj = new Usuario($this->contraloriasocialDB);
                $comite['usuario'] = $usuarioobj->getUsuario($comite['usuario_id']);
            }
            else{
                $comite['usuario'] = false;
            }
            if(isset($comite['obra_id']) && $comite['obra_id']){
                $obraobj = new Obra($this->contraloriasocialDB);
                $obra = $obraobj->getObra($comite['obra_id'],false);
                $comite['obra'] = $obra;
            }
            else{
                $comite['obra'] = false;
            }
        }
        return $result;
    }

    public function getComitesByObra($obra_id){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM comites  WHERE obra_id = {$obra_id} ORDER BY num_comite") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        foreach ($result as &$comite){
            if(isset($comite['usuario_id']) && $comite['usuario_id']){
                $usuarioobj = new Usuario($this->contraloriasocialDB);
                $comite['usuario'] = $usuarioobj->getUsuario($comite['usuario_id']);
            }
            else{
                $comite['usuario'] = false;
            }
            if(isset($comite['obra_id']) && $comite['obra_id']){
                $obraobj = new Obra($this->contraloriasocialDB);
                $obra = $obraobj->getObra($obra_id,false);
                $comite['obra'] = $obra;
            }
            else{
                $comite['obra'] = false;
            }
        }
        return $result;
    }

    public function getComitesByEjecutora($ejecutora_id){
        $obrasobj = new Obra($this->contraloriasocialDB);
        $obras = $obrasobj->getObrasByEjecutora($ejecutora_id);
        $result = array();
        foreach ($obras as $obra){
            $comites = $this->getComitesByObra($obra['id_obra']);
            foreach($comites as $comite){
                if(isset($comite['usuario_id']) && $comite['usuario_id']){
                    $usuarioobj = new Usuario($this->contraloriasocialDB);
                    $comite['usuario'] = $usuarioobj->getUsuario($comite['usuario_id']);
                }
                else{
                    $comite['usuario'] = false;
                }
                if(isset($comite['obra_id']) && $comite['obra_id']){
                    $comite['obra'] = $obra;
                }
                else{
                    $comite['obra'] = false;
                }

                $result[] = $comite;
            }
        }
        return $result;
    }

    public function updateComite($id,$data){
        $result = $this->update("comites","id_comite","$id",$data);
        return $result;
    }

    public function addComite($data){
        if($_SERVER['HTTP_HOST'] == 'contraloriasocial.test')
            $seq = "comites_id_comite_seq";
        else
            $seq = "id_comite_seq";
        $result = $this->insert("comites",$seq,"id_comite",$data);
        return $result;
    }

    public function getNumComiteSiguiente($obra_id){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT num_comite FROM comites  WHERE obra_id = {$obra_id} ORDER BY num_comite") or die($this->contraloriasocialDB->ErrorMsg());
        $nums_comite = $this->select($vista);
        $vista->Close();
        $ultimo_num = end($nums_comite);
        $ultimo_num = $ultimo_num['num_comite'];
        $ultimo_consecutivo = explode('-',$ultimo_num);
        $ultimo_consecutivo = end($ultimo_consecutivo);
        $siguiente_consecutivo = intval($ultimo_consecutivo) + 1;
        $siguiente_consecutivo = str_pad($siguiente_consecutivo,3,'0',STR_PAD_LEFT);
        return $siguiente_consecutivo;
    }

    public function deleteComite($id){
        $result = $this->delete("comites","id_comite",$id);
        return $result;
    }

    public function getEventosContraloria(){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM comites  WHERE (agenda_confirmada = 1 AND agenda_fecha IS NOT NULL ) ORDER BY num_comite") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        foreach ($result as &$comite){
            if(isset($comite['usuario_id']) && $comite['usuario_id']){
                $usuarioobj = new Usuario($this->contraloriasocialDB);
                $comite['usuario'] = $usuarioobj->getUsuario($comite['usuario_id']);
            }
            else{
                $comite['usuario'] = false;
            }
            if(isset($comite['obra_id']) && $comite['obra_id']){
                $obraobj = new Obra($this->contraloriasocialDB);
                $obra = $obraobj->getObra($comite['obra_id'],false);
                $comite['obra'] = $obra;
            }
            else{
                $comite['obra'] = false;
            }
        }
        return $result;
    }

    public function getEventosByEjecutora($ejecutora_id){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT comites.* FROM comites,obras  WHERE comites.obra_id = obras.id_obra AND  obras.ejecutora_id = {$ejecutora_id} AND agenda_fecha IS NOT NULL ORDER BY num_comite") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        foreach ($result as &$comite){
            if(isset($comite['usuario_id']) && $comite['usuario_id']){
                $usuarioobj = new Usuario($this->contraloriasocialDB);
                $comite['usuario'] = $usuarioobj->getUsuario($comite['usuario_id']);
            }
            else{
                $comite['usuario'] = false;
            }
            if(isset($comite['obra_id']) && $comite['obra_id']){
                $obraobj = new Obra($this->contraloriasocialDB);
                $obra = $obraobj->getObra($comite['obra_id'],false);
                $comite['obra'] = $obra;
            }
            else{
                $comite['obra'] = false;
            }
        }
        return $result;
    }

    public function getEventos(){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM comites  WHERE agenda_fecha IS NOT NULL ORDER BY num_comite") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        foreach ($result as &$comite){
            if(isset($comite['usuario_id']) && $comite['usuario_id']){
                $usuarioobj = new Usuario($this->contraloriasocialDB);
                $comite['usuario'] = $usuarioobj->getUsuario($comite['usuario_id']);
            }
            else{
                $comite['usuario'] = false;
            }
            if(isset($comite['obra_id']) && $comite['obra_id']){
                $obraobj = new Obra($this->contraloriasocialDB);
                $obra = $obraobj->getObra($comite['obra_id'],false);
                $comite['obra'] = $obra;
            }
            else{
                $comite['obra'] = false;
            }
        }
        return $result;
    }

    public function getEventosByUser($user_id, $rol_id = 1){
        $usuarioquery = "";
        if($rol_id == 1){
            $usuarioquery = "AND usuario_id = {$user_id}";
        }
        else{
            $usuarioquery = "AND contraloria_usuario_id = {$user_id}";
        }
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM comites  WHERE agenda_fecha IS NOT NULL {$usuarioquery} ORDER BY num_comite") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        foreach ($result as &$comite){
            if(isset($comite['usuario_id']) && $comite['usuario_id']){
                $usuarioobj = new Usuario($this->contraloriasocialDB);
                $comite['usuario'] = $usuarioobj->getUsuario($comite['usuario_id']);
            }
            else{
                $comite['usuario'] = false;
            }
            if(isset($comite['obra_id']) && $comite['obra_id']){
                $obraobj = new Obra($this->contraloriasocialDB);
                $obra = $obraobj->getObra($comite['obra_id'],false);
                $comite['obra'] = $obra;
            }
            else{
                $comite['obra'] = false;
            }
        }
        return $result;
    }

    public function getNormatividad($comite_id){
        $comite = $this->getComite($comite_id);
        $obraobj = new Obra($this->contraloriasocialDB);
        $obra = $obraobj->getObra($comite['obra_id']);
        $fondoobj = new Fondo($this->contraloriasocialDB);
        if(isset($obra['fondo']) && $obra['fondo']){
            $fondo = $fondoobj->findByFondo($obra['fondo']);
            if($fondo){
                return $fondo['norma_cs_aplica'];
            }
            else{
                return false;
            }
        }
        else{
            return "";
        }
    }

    public function getListaFotos($comite_id){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM comite_lista_asistencia  WHERE id_comite = {$comite_id}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        return $result;
    }

    public function getDocumentosFotos($comite_id, $tipo){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM comite_foto_{$tipo}  WHERE id_comite = {$comite_id}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        return $result;
    }

    public function getEvidenciasFotos($comite_id, $tipo){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM comite_evidencia_{$tipo}  WHERE id_comite = {$comite_id}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        return $result;
    }

    public function getListafoto($id, $sesion = false){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM comite_lista_asistencia WHERE id = {$id}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->find($vista);
        $vista->Close();

        if($sesion){
            //generando imagen fisica
            $base64Image = $result['imagen'];
            $data = explode(',', $base64Image);
            $imageData = base64_decode($data[1]);
            $fecha = date_create();
            $nombre = "../../storage/fotos/lista_{$result['id']}_"./*date_timestamp_get($fecha).*/".jpg";
            $imageput = file_put_contents($nombre,$imageData);
            $result['url'] = $sesion->baseurl."/storage/fotos/".$nombre;
        }
        return $result;
    }

    public function getDocumentofoto($id, $tipo, $sesion = false){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM comite_foto_{$tipo} WHERE id = {$id}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->find($vista);
        $vista->Close();

        if($sesion){
            //generando imagen fisica
            $base64Image = $result['imagen'];
            $data = explode(',', $base64Image);
            $imageData = base64_decode($data[1]);
            $fecha = date_create();
            $nombre = "../../storage/fotos/documento_{$tipo}_{$result['id']}_"./*date_timestamp_get($fecha).*/".jpg";
            $imageput = file_put_contents($nombre,$imageData);
            $result['url'] = $sesion->baseurl."/storage/fotos/".$nombre;
        }
        return $result;
    }

    public function getEvidenciafoto($id, $tipo, $sesion = false){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM comite_evidencia_{$tipo} WHERE id = {$id}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->find($vista);
        $vista->Close();

        if($sesion){
            //generando imagen fisica
            $base64Image = $result['imagen'];
            $data = explode(',', $base64Image);
            $imageData = base64_decode($data[1]);
            $fecha = date_create();
            $nombre = "../../storage/fotos/evidencia_{$tipo}_{$result['id']}_"./*date_timestamp_get($fecha).*/".jpg";
            $imageput = file_put_contents($nombre,$imageData);
            $result['url'] = $sesion->baseurl."/storage/fotos/".$nombre;
        }
        return $result;
    }

    public function subirDocumento($comite_id, $documento, $tipo){
        $fileTmpPath = $documento['tmp_name'];
        $fileName = $documento['name'];
        $fileSize = $documento['size'];
        $fileType = $documento['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $nombre = "{$tipo}_{$comite_id}" . '.' . $fileExtension;
        $allowedfileExtensions = array('pdf', 'PDF');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // directory in which the uploaded file will be moved
            $uploadFileDir = '../../storage/documentos/';
            $dest_path = $uploadFileDir . $nombre;
            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                $respuesta = true;
            }
            else {
                $respuesta = false;
            }
        }
        else{
            $respuesta = false;
        }
        return $respuesta;
    }

    public function GetIntegrantes($comite_id, $tipo){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM comite_integrante_integracion  WHERE id_comite = {$comite_id}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        return $result;
    }

    public function GetIntegracion($comite_id){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM comite_integracion  WHERE id_comite = {$comite_id}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->find($vista);
        $vista->Close();
        return $result;
    }

    public function GetTestigos($comite_id){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM comite_testigo_integracion  WHERE id_comite = {$comite_id}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->select($vista);
        $vista->Close();
        return $result;
    }

    public function getIntegrantefoto($id, $tipo, $sesion = false){
        $vista=$this->contraloriasocialDB->SelectLimit("SELECT * FROM comite_integrante_{$tipo} WHERE id = {$id}") or die($this->contraloriasocialDB->ErrorMsg());
        $result = $this->find($vista);
        $vista->Close();

        if($sesion){
            //generando imagen fisica
            $base64Image = $result['firma'];
            $data = explode(',', $base64Image);
            $imageData = base64_decode($data[1]);
            $fecha = date_create();
            $nombre = "../../storage/firmas/integrante_{$tipo}_{$result['id']}"./*date_timestamp_get($fecha).*/".png";
            $imageput = file_put_contents($nombre,$imageData);
            $result['url'] = "../../storage/firmas/".$nombre;
        }
        return $result;
    }

}
