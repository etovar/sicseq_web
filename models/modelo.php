<?php
/* Helper con todas las funcciones de manejo de sesión
 * Rafael Reyna
 * */

class Modelo
{
    protected $contraloriasocialDB;

    function __construct($contraloriasocialDB)
    {
        $this->contraloriasocialDB = $contraloriasocialDB;
    }

    public function select($vista){
        $result = array();
        while(!$vista->EOF) {
                $result[] = $vista->fields;
            $vista->MoveNext();
        }
        return $result;
        $vista->Close();
    }

    public function find($vista){
        if($vista->RecordCount() > 0) {
            $result = $vista->fields;
        }
        else{
            $result = false;
        }
        return $result;
        $vista->Close();
    }

    public function insert($tabla, $seq, $id, $data){
        $campos = array();
        $valores = array();
        foreach($data as $campo => $valor){
            $campos[] = $campo;
            if(is_string($valor)){
                $valor = "'{$valor}'";
            }
            if(is_null($valor)){
                $valor = "null";
            }
            $valores[] = $valor;
        }
        $insertquery = "INSERT INTO {$tabla} (". implode(',',$campos) .") VALUES (". implode(',',$valores) .")";
        $insert=$this->contraloriasocialDB->execute($insertquery) or die($this->contraloriasocialDB->ErrorMsg());
        $insert->close();
        $lastid=$this->contraloriasocialDB->SelectLimit("SELECT currval('$seq') as lastid;") or die($this->contraloriasocialDB->ErrorMsg());
        $result=$this->contraloriasocialDB->SelectLimit("SELECT * from {$tabla} WHERE {$id} = ".$lastid->fields('lastid')) or die($this->contraloriasocialDB->ErrorMsg());
        return $result->fields;
    }

    public function update($tabla, $id, $id_value, $data){
        $set = array();
        foreach($data as $campo => $valor){
            if(is_string($valor)){
                $valor = "'{$valor}'";
            }
            $set[] = "$campo = $valor";
        }
        $insertquery = "UPDATE {$tabla} SET ". implode(', ',$set) . "WHERE {$id} = $id_value";
        $update=$this->contraloriasocialDB->execute($insertquery) or die($this->contraloriasocialDB->ErrorMsg());
        $update->close();
        $result=$this->contraloriasocialDB->SelectLimit("SELECT * FROM {$tabla} WHERE {$id} = {$id_value}") or die($this->contraloriasocialDB->ErrorMsg());
        return $result->fields;
    }

    public function delete($tabla, $id, $id_value){
        $result=$this->contraloriasocialDB->SelectLimit("SELECT * FROM {$tabla} WHERE {$id} = {$id_value}") or die($this->contraloriasocialDB->ErrorMsg());

        $insertquery = "DELETE FROM {$tabla} WHERE {$id} = $id_value";
        $delete=$this->contraloriasocialDB->execute($insertquery) or die($this->contraloriasocialDB->ErrorMsg());
        $delete->close();

        return $result->fields;
    }
}

