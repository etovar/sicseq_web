<p style="text-align: right">
    <a target="_blank" href="./resumen.php?obra_id=<?php echo $obra['id_obra'];?>"><i class="fa fa-download"></i> Descargar Resumen del Expediente</a>
</p>
<div class="container">
    <h4><?php echo $obra['num_obra']?></h4>
    <h5><?php echo $obra['nombre_obra']?></h5>
    <p><strong>Tipo de proyecto:</strong> <?php echo $obra['tipo_proyecto']?></p>
    <hr/>
    <?php
        if($obra['localidad'] == "ALCANCE ESTATAL" || $obra['localidad'] == "ALCANCE REGIONAL"){
            $busqueda = "estado de queretaro, Mexico";
            $zoom = '8';
        }
        else{
            $busqueda = "{$obra['localidad']}, {$obra['mmunicipio']}, Querétaro";
            $zoom = '13';
        }
        $busqueda = urlencode($busqueda);
    ?>
    <?php if($obra['picaso_croquis']){?>
        <div class="mapouter"><div class="gmap_canvas"><iframe width="570" height="300" id="gmap_canvas" src="https://maps.google.com/maps?q=<?php echo $obra['lat']; ?>,<?php echo $obra['lon']; ?>&t=&z=<?php echo $obra['zoom'];?>&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div><style>.mapouter{position:relative;text-align:right;height:300px;width:570px;}.gmap_canvas {overflow:hidden;background:none!important;height:300px;width:570px;}</style></div>
    <?php }else{ ?>
        <div class="mapouter"><div class="gmap_canvas"><iframe width="570" height="300" id="gmap_canvas" src="https://maps.google.com/maps?q=<?php echo $busqueda; ?>t=&z=<?php echo $zoom;?>&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div><style>.mapouter{position:relative;text-align:right;height:300px;width:570px;}.gmap_canvas {overflow:hidden;background:none!important;height:300px;width:570px;}</style></div>
        <p class="alert alert-warning" style="color:#222"><i class="fa fa-warning"></i> Esta obra no cuenta con datos de ubicación geográfica, el mapa es un estimado basado en la localidad y municipio de la obra.</p>
    <?php } ?>
    <br/>
    <h4>1. IDENTIFICACIÓN</h4>
    <p><strong>Dependencia Promotora:</strong> <?php echo $obra['normativa']?></p>
    <p><strong>Dependencia Ejecutora:</strong> <?php echo $obra['ejecutora']?></p>
    <p><strong>Denominación de la obra, apoyo y/o servicio:</strong> <?php echo $obra['nombre_obra']?></p>
    <hr/>


    <h4>2. UBICACIÓN DE LA OBRA, APOYO Y/O SERVICIOS</h4>
    <p><strong>Localidad:</strong> <?php echo $obra['localidad']?></p>
    <p><strong>Municipio:</strong> <?php echo $obra['mmunicipio']?></p>
    <hr/>

    <h4>3. ORIGEN DE LOS RECURSOS</h4>
    <p><strong>Fecha de aprobación:</strong> <?php //echo $obra['inicio_obra']?></p>
    <p><strong>Número de oficio o equivalente:</strong> <?php echo $obra['no_oficio']?></p>
    <p><strong>Número de Obra:</strong> <?php echo $obra['num_obra']?></p>
    <p><strong>Fondo:</strong> <?php echo $obra['fondo']?></p>
    <p><strong>Programa:</strong> </p>
    <hr/>

    <h4>4. EJECUCIÓN DE LA OBRA, APOYO Y/O SERVICIO</h4>
    <p><strong>Modalidad de Ejecución:</strong> <?php echo $obra['modalidad_ejecucion']?></p>
    <p><strong>Contratista:</strong> <?php echo $obra['contratista']?></p>
    <p><strong>Fecha de inicio según contrato:</strong> <?php echo $obra['inicio_obra']?></p>
    <p><strong>Fecha de término según contrato:</strong> <?php echo $obra['termino_obra']?></p>
    <p><strong>Características generales de la obra, apoyo y/o servicio:</strong> </p>
    <br/>
    <p><strong>Costo total aprobado:</strong> $<?php echo number_format($obra['monto_aprobado'],2)?></p>
    <p><strong>Costo total contratado:</strong> $<?php echo number_format($obra['monto_contratado'],2)?></p>
    <p><strong>Costo total ejercido:</strong> $<?php echo number_format($obra['monto_ejercido'],2)?></p>
    <table class="table table-bordered table-condensed">
        <thead>
        <th>Tipo de Fuente</th>
        <th>Fuente</th>
        <th>Importe</th>
        <th>Pporcentaje de aportación</th>
        </thead>
        <tbody>
        <?php if($obra['ff_federal']){?>
            <tr>
                <td>FEDERAL</td>
                <td><?php echo $obra['ff_federal']?></td>
                <td>$<?php echo number_format($obra['importe_federal'],2)?></td>
                <td><?php echo $obra['aportacion_federal']?>%</td>
            </tr>
        <?php } ?>
        <?php if($obra['ff_estatal']){?>
            <tr>
                <td>ESTATAL</td>
                <td><?php echo $obra['ff_estatal']?></td>
                <td>$<?php echo number_format($obra['importe_esatal'],2)?></td>
                <td><?php echo $obra['aportacion_estatal']?>%</td>
            </tr>
        <?php } ?>
        <?php if($obra['ff_municipal']){?>
            <tr>
                <td>MUNICIPAL</td>
                <td><?php echo $obra['ff_municipal']?></td>
                <td>$<?php echo number_format($obra['importe_municipal'],2)?></td>
                <td><?php echo $obra['aportacion_municipal']?>%</td>
            </tr>
        <?php } ?>
        <?php if($obra['ff_otros']){?>
            <tr>
                <td>OTROS</td>
                <td><?php echo $obra['ff_otros']?></td>
                <td>$<?php echo number_format($obra['imprte_otros'],2)?></td>
                <td><?php echo $obra['aportacion_otros']?>%</td>
            </tr>
        <?php } ?>
        <?php if($obra['ff_recursos_propios']){?>
            <tr>
                <td>PROPIOS</td>
                <td><?php echo $obra['ff_recursos_propios']?></td>
                <td>$<?php echo number_format($obra['importe_recursos_propios'],2)?></td>
                <td><?php echo $obra['aportacion_recursos_propios']?>0%</td>
            </tr>
        <?php } ?>

        </tbody>
    </table>
    <hr/>

    <h4>5. METAS Y BENEFICIARIOS</h4>
    <p><strong>Descripción de metas contratadas:</strong> </p>
    <p><strong>Cantidad de metas contratadas:</strong> <?php echo $obra['cantidad_metas']?></p>
    <p><strong>Unidad de metas contratadas:</strong> <?php echo $obra['unidad_metas']?></p>
    <p><strong>Cantidad de beneficiarios:</strong> </p>

</div>
