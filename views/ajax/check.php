<div class="container">
    <?php if($check['lat'] && $check['lon']) {?>
        <div class="mapouter">
            <div class="gmap_canvas">
                <iframe width="570" height="300" id="gmap_canvas" src="https://maps.google.com/maps?q=<?php echo $check['lat']; ?>,<?php echo $check['lon']; ?>&t=&z=14&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
            </div>
            <style>.mapouter{position:relative;text-align:right;height:300px;width:570px;}.gmap_canvas {overflow:hidden;background:none!important;height:300px;width:570px;}</style>
        </div>
        <hr/>
        <h4>UBICACION</h4>
        <p><strong>Latitud:</strong> <?php echo $check['lat']?></p>
        <p><strong>Longitud:</strong> <?php echo $check['lon']?></p>
        <hr/>
    <?php } else {?>
        <h4>UBICACION</h4>
        <p style="color: #333;" class="alert alert-warning"><i class="fa fa-warning"></i> No se pudieron recolectar datos de geolocalización para este check</p>
    <?php } ?>
    <h4>FECHA</h4>
    <p><strong>Fecha de captura:</strong> <?php echo gmdate('d-m-Y \a \l\a\s H:i:s',$check['fecha_captura']/1000)?></p>
    <hr/>
    <h4>IMAGEN</h4>
    <p><img class="image-preview" src="<?php echo $check['url']?>"/></p>
    <p style="text-align: center"><a  href="<?php echo $check['url']?>" target="_blank" class="btn btn-primary"><i class="fa fa-img"></i> Ver imagen completa</a></p>
</div>
