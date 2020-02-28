<div class="row">
    <div class="col-md-6">
        <?php
        echo " <p>{$comite['obra']['ejecutora']}</p>
        <h3>{$comite['num_comite']}</h3>                                                
        <p title='{$comite['obra']['nombre_obra']}' style='white-space: nowrap;overflow: hidden;text-overflow: ellipsis;'>{$comite['obra']['nombre_obra']}</p>";
        $normatividad = $comitesobj->getNormatividad($comite['id_comite']);
        echo "<p>Normatividad: {$normatividad}</p>";

        if(isset($comite['agenda_fecha']) ){
            echo "<p class='text-info'><i class='fa fa-calendar-check-o'></i> {$comite['agenda_fecha']} - de {$comite['agenda_hora_inicio']} a {$comite['agenda_hora_fin']}</p>";
            echo "<p class='text-info'><i class='fa fa-map-marker'></i> {$comite['agenda_lugar']}</p>";
        }
        else{
            echo "<p><i class='fa fa-calendar-times-o'></i> Sin agendar</p>";
        }

        if(isset($comite['usuario_id']) && $comite['usuario_id']){
            $usuarioobj = new Usuario($contraloriasocialDB);
            $usuario = $usuarioobj->getUsuario($comite['usuario_id']);
            echo "<p class='text-info'><i class='fa fa-user'></i> Asignado a {$usuario['nombres']} {$usuario['apellido_p']} {$usuario['apellido_m']}</p>";
        }
        else{
            echo "<p><i class='fa fa-user-times'></i> Sin asignar</p>";
        }

        if(isset($comite['representante_dependencia_normativa']) && $comite['representante_dependencia_normativa']){
            echo "<p class='text-info'><i class='fa fa-user'></i> Representante D. N. {$comite['representante_dependencia_normativa']}</p>";
        }
        else{
            echo "<p><i class='fa fa-user-times'></i> Sin responsable de la dependencia Normativa</p>";
        }

        if(isset($comite['metodo']) && $comite['metodo']){
            echo "<p class='text-info'><i class='fa fa-pencil'></i> Método {$comite['metodo']}</p>";
        }
        else{
            echo "<p><i class='fa fa-pencil'></i> Sin método definido</p>";
        }
        ?>
    </div>
    <div class="col-md-6">
        <div class="mapouter"><div class="gmap_canvas"><iframe width="270" height="300" id="gmap_canvas" src="https://maps.google.com/maps?q=<?php echo $comite['agenda_lugar']; ?>t=&z=14&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div><style>.mapouter{position:relative;text-align:right;height:300px;width:570px;}.gmap_canvas {overflow:hidden;background:none!important;height:300px;width:270px;}</style></div>
    </div>
</div>

