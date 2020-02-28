<?php
// Script de sincronización de obras de picaso
// Rafael Reyna
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
require_once ("../../contraloriasocialDB.php");
require_once ("../../helpers/sesiones.php");
require_once ("../../models/transaccion.php");
require_once ("../../models/obra.php");
require_once ("../../models/dependencia.php");
require_once ("../../models/picasoobra.php");
require_once ("../../models/fondo.php");
require_once ("../../helpers/funciones_varias.php");
//revisando la sesión solo en caso de que el script se dispare desde una interfaz de usuario
$sesion = new Sesion($contraloriasocialDB);

//Incluyendo configuracion de web service
include_once ('./config.php');

//Inicializando objetos de modelos
$transaccionobj = new Transaccion($contraloriasocialDB);;
$picasoobraobj = new Picasoobra($contraloriasocialDB);;
$obraobj = new Obra($contraloriasocialDB);
$dependenciaobj = new Dependencia($contraloriasocialDB);
$fondosobj = new Fondo($contraloriasocialDB);

$total_errores = 0;
$errores = array();

//Inicializando la trnasacción
$data_transaccion['status'] = 'INICIADA';
if($sesion->sesion_activa()){
    $data_transaccion['usuario'] = "{$sesion->nombres_x} {$sesion->apellido_p_x} {$sesion->apellido_m_x}";
}
$transaccion = $transaccionobj->addTransacción($data_transaccion);
echo "Transaccion {$transaccion['id']} iniciada... <br/>\n";
ob_flush();

//Consumiendo el web service
$url = $config_picaso['base_url'] . "unicoPicaso/obtenerTodo";
echo "Llamando web service {$url} en archivo<br/>\n";
ob_flush();

$transaccion = $transaccionobj->updateTransaccion($transaccion['id'], array('status'=>'PROCESANDO_WS'));
ini_set('default_socket_timeout', 50000);
//LLAMADA AL API REST
$context = stream_context_create(array(
    'http' => array(
        'timeout' => 50000,
        //'header'  => "Authorization: Basic " . base64_encode("{$config_picaso['username']}:{$config_picaso['password']}")
    )
));

set_time_limit(50000);
//$data = file_get_contents($url, false, $context);
$data = file_get_contents("json/picaso_obras.json", false, $context);
$data_php = json_decode($data);

if($data_php->estatus == "success"){
    echo "Registros encontrados: ".count($data_php->datos)."<br/>\n";
    $transaccion = $transaccionobj->updateTransaccion($transaccion['id'], array('total_registros'=>count($data_php->datos)));
}


//Vaciando el contenido en la tabla temporal
echo "Vaciando en tabla temporal picaso_obras<br/>\n";
ob_flush();
$transaccion = $transaccionobj->updateTransaccion($transaccion['id'], array('status'=>'VACIANDO_DATOS'));
$registros_insertados_picaso = 0;
foreach($data_php->datos as $obra_picaso){
    set_time_limit(3);
    $num_obra_segmentos = explode('-',$obra_picaso->numObra);
    $year_obra = $num_obra_segmentos[0];
    if($year_obra > "2019"){
        $obra_data = array();
        foreach ($obra_picaso as $dato=>$valor){
            $dato = quitar_acentos($dato);
            $dato = strtolower($dato);
            $obra_data[$dato] = $valor;
        }
        $obra_data['transaccion_id'] = $transaccion['id'];
        $obra_tabla = $picasoobraobj->addObra($obra_data);
        $registros_insertados_picaso ++;
        $transaccion = $transaccionobj->updateTransaccion($transaccion['id'], array('total_copiados'=>$registros_insertados_picaso));
    }
}

echo "Registros vaciados: {$registros_insertados_picaso}<br/>\n";
$transaccion = $transaccionobj->updateTransaccion($transaccion['id'], array('total_copiados'=>$registros_insertados_picaso));
ob_flush();


//agregando información geográfica
echo "Agregando información Geográfica<br/>\n";
ob_flush();
$transaccion = $transaccionobj->updateTransaccion($transaccion['id'], array('status'=>'INFO_GEOGRAFICA'));
$obraspicaso = $picasoobraobj->getObrasByTransaccion($transaccion['id']);
$obras_geo = 0;
foreach($obraspicaso as $obra){
    try {
        set_time_limit(1000);
        if(!isset($obra['picaso_croquis']) || !$obra['picaso_croquis']){
            $urlgeo = $config_picaso['base_url'] ."croquis/obtenerCroquisPorNumeroObra?numeroObra=".$obra['numobra'];
            $data = file_get_contents($urlgeo, false, $context);
            $data_php = json_decode($data);
            //$dataupdate['picaso_croquis'] = json_encode($data_php->datos);
            $geodatos = str_replace('@','"',$data_php->datos->ubicacion);
            $geodatos = json_decode($geodatos);
            if($geodatos && isset($geodatos->centro)){
                $dataupdate['lat'] = $geodatos->centro->lat;
                $dataupdate['lon'] = $geodatos->centro->lng;
                $dataupdate['zoom'] = $geodatos->zoom;
                $picasoobraobj->updateObra($obra['id'],$dataupdate);
                $obras_geo++;
                $transaccion = $transaccionobj->updateTransaccion($transaccion['id'], array('total_geograficos'=>$obras_geo));
            }
        }
    }
    catch (Exception $exception){
        //manejar errores
        $total_errores ++;
        $errores[] = array();
    }
}
echo "Registros con informacion geografica: {$obras_geo}<br/>\n";
$transaccion = $transaccionobj->updateTransaccion($transaccion['id'], array('total_geograficos'=>$obras_geo));
ob_flush();

echo "Sincronizando<br/>\n";
ob_flush();
//$transaccion['id'] = 42;
//$transaccion = $transaccionobj->updateTransaccion($transaccion['id'], array('status'=>'SINCRONIZANDO'));
$transaccion = $transaccionobj->updateTransaccion($transaccion['id'], array('status'=>'SINCRONIZANDO'));
$altas = 0;
$modificaciones = 0;
$obras_compactadas = array();

//Recorremos todas las obras y las agrupamos en base a su numero de obra para detectar las obras repetidas
$obraspicaso = $picasoobraobj->getObrasByTransaccion($transaccion['id']);
foreach($obraspicaso as $obra_picaso){
    if(isset($obra_picaso['numobra']) && $obra_picaso['numobra']){
        $obras_compactadas[$obra_picaso['numobra']][] = $obra_picaso;
    }
}
foreach($obras_compactadas as $obra_picaso_compacta){
    try{
        set_time_limit(10);
        $obra_picaso = $obra_picaso_compacta[0];
        //Información para sobreescribir o insertat
        if(isset($obra_picaso['numobra']) && $obra_picaso['numobra']){
            $data_obra_sicseq['num_obra'] = isset($obra_picaso['numobra'])?$obra_picaso['numobra']:'';
            $data_obra_sicseq['nombre_obra'] = isset($obra_picaso['nombreobra'])?$obra_picaso['nombreobra']:'';
            $data_obra_sicseq['mmunicipio'] = isset($obra_picaso['municipio'])?$obra_picaso['municipio']:'';
            $data_obra_sicseq['localidad'] = isset($obra_picaso['localidad'])?$obra_picaso['localidad']:'';
            $data_obra_sicseq['tipo_proyecto'] = isset($obra_picaso['tipo'])?$obra_picaso['tipo']:'';
            $data_obra_sicseq['ejecutora'] = isset($obra_picaso['ejecutor'])?$obra_picaso['ejecutor']:'';
            $data_obra_sicseq['normativa'] = isset($obra_picaso['promotor'])?$obra_picaso['promotor']:'';
            $data_obra_sicseq['clasificador_plan_estatal'] = isset($obra_picaso['clasifplan'])?$obra_picaso['clasifplan']:'';
            $data_obra_sicseq['cantidad_metas'] = isset($obra_picaso['cantmetas'])?$obra_picaso['cantmetas']:'';
            $data_obra_sicseq['unidad_metas'] = isset($obra_picaso['metas'])?$obra_picaso['metas']:'';
            $data_obra_sicseq['contratista'] = isset($obra_picaso['contratista'])?$obra_picaso['contratista']:'';
            $data_obra_sicseq['inicio_obra'] = isset($obra_picaso['fechainiciocontrato'])?$obra_picaso['fechainiciocontrato']:'';
            $data_obra_sicseq['termino_obra'] = isset($obra_picaso['fechaterminocontrato'])?$obra_picaso['fechaterminocontrato']:'';
            $data_obra_sicseq['status_obra'] = isset($obra_picaso['edoproyecto'])?$obra_picaso['edoproyecto']:'';
            $data_obra_sicseq['avance'] = isset($obra_picaso['avancefisico'])?$obra_picaso['avancefisico']:'';
            $data_obra_sicseq['monto_aprobado'] = isset($obra_picaso['aprobado'])?$obra_picaso['aprobado']:'';
            $data_obra_sicseq['monto_ejercido'] = isset($obra_picaso['ejercido'])?$obra_picaso['ejercido']:'';

            $data_obra_sicseq['fondo'] = isset($obra_picaso['fondo'])?$obra_picaso['fondo']:'';
            //actualizando catalogo fondo
            $fondosobj->actualizarFondo($data_obra_sicseq['fondo']);

            $data_obra_sicseq['lat'] = isset($obra_picaso['lat'])?$obra_picaso['lat']:'';
            $data_obra_sicseq['lon'] = isset($obra_picaso['lon'])?$obra_picaso['lon']:'';
            $data_obra_sicseq['zoom'] = isset($obra_picaso['zoom'])?$obra_picaso['zoom']:0;
            $data_obra_sicseq['picaso_croquis'] = isset($obra_picaso['picaso_croquis'])?$obra_picaso['picaso_croquis']:'';
            $data_obra_sicseq['no_oficio'] = isset($obra_picaso['nooficaprob'])?$obra_picaso['nooficaprob']:'';
            $data_obra_sicseq['modalidad_ejecucion'] = isset($obra_picaso['modalidad'])?$obra_picaso['modalidad']:'';
            $data_obra_sicseq['caracteristicas_obra'] = '';
            $data_obra_sicseq['cantidad_beneficiarios'] = isset($obra_picaso['cantbenef'])?$obra_picaso['cantbenef']:0;
            $data_obra_sicseq['descripcion_metas'] = '';
            $data_obra_sicseq['temp_borrado'] = 0;

            $ejecutora = $dependenciaobj->getDependenciaByNombre($obra_picaso['ejecutor']);
            $data_obra_sicseq['ejecutora_id'] = $ejecutora['id_dependencia'];

            //fuentes de financiamiento estatl federal, etc
            $data_obra_sicseq['ff_federal'] = '';
            $data_obra_sicseq['importe_federal'] = 0;
            $data_obra_sicseq['aportacion_federal'] = 0;
            $data_obra_sicseq['ff_estatal'] = '';
            $data_obra_sicseq['importe_esatal'] = 0;
            $data_obra_sicseq['aportacion_estatal'] = 0;
            $data_obra_sicseq['ff_municipal'] = '';
            $data_obra_sicseq['importe_municipal'] = 0;
            $data_obra_sicseq['aportacion_municipal'] = 0;
            $data_obra_sicseq['ff_otros'] = '';
            $data_obra_sicseq['imprte_otros'] = 0;
            $data_obra_sicseq['aportacion_otros'] = 0;

            foreach($obra_picaso_compacta as $registro_ff){
                if(isset($registro_ff['montofed']) && $registro_ff['montofed']){
                    $data_obra_sicseq['importe_federal'] += $registro_ff['montofed'];
                    $data_obra_sicseq['aportacion_federal'] += $registro_ff['fed'];
                    $data_obra_sicseq['ff_federal'] = $registro_ff['ff'];
                }

                if(isset($registro_ff['montoest']) && $registro_ff['montoest']){
                    $data_obra_sicseq['importe_esatal'] += $registro_ff['montoest'];
                    $data_obra_sicseq['aportacion_estatal'] += $registro_ff['est'];
                    $data_obra_sicseq['ff_estatal'] = $registro_ff['ff'];
                }

                if(isset($registro_ff['montompal']) && $registro_ff['montompal']){
                    $data_obra_sicseq['importe_municipal'] += $registro_ff['montompal'];
                    $data_obra_sicseq['aportacion_municipal'] += $registro_ff['mapl'];
                    $data_obra_sicseq['ff_municipal'] = $registro_ff['ff'];
                }

                if(isset($registro_ff['montootro']) && $registro_ff['montootro']){
                    $data_obra_sicseq['imprte_otros'] += $registro_ff['montootro'];
                    $data_obra_sicseq['aportacion_otros'] += $registro_ff['otro'];
                    $data_obra_sicseq['ff_otros'] = $registro_ff['ff'];
                }
            }

            $obra_sistema = $obraobj->getObraByNumero($obra_picaso['numobra']);
            if($obra_sistema){ // la obra existe, actualización
                $obra_modificada = $obraobj->updateObra($obra_sistema['id_obra'], $data_obra_sicseq);
                $modificaciones ++;
                $transaccion = $transaccionobj->updateTransaccion($transaccion['id'], array('total_actualizaciones'=>$modificaciones));
            }
            else{ // la obra no existe alta
                $data_obra_sicseq['status'] = 'nueva';
                $nueva_obra = $obraobj->addObra($data_obra_sicseq);
                $altas ++;
                $transaccion = $transaccionobj->updateTransaccion($transaccion['id'], array('total_altas'=>$altas));
            }


        }
    }
    catch(Exception $exception){
        echo "--> ERROR {$exception->getMessage()} - Linea {$exception->getLine()} <br/>\n";
    }
}

echo "--> Transacción {$transaccion['id']} Finalizada!!!<br/>\n";
echo " - Altas: {$altas}<br/>\n";
echo " - Modificaciones: {$modificaciones}<br/>\n";
ob_flush();
$transaccion = $transaccionobj->updateTransaccion($transaccion['id'],
    array(
        'status'=>'FINALIZADA',
        'total_altas'=>$altas,
        'total_actualizaciones'=>$modificaciones
    )
);
