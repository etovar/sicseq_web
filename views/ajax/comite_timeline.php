<div class="row">
    <div class="col-md-12">
        <ul class="list-unstyled timeline">

            <li>
                <div class="block">
                    <div class="block_content">
                        <div class="byline">
                            <span><?php echo $comite['obra']['inicio_obra']?></span>
                        </div>
                        <h2 class="title">
                            <a>Inicio de Obra</a>
                        </h2>
                        <p><?php echo $comite['obra']['nombre_obra']?></p>

                        <br/>
                        <h2 class="title">
                            <a>Primera Sesión</a>
                        </h2>
                        <div class="byline">
                            <span><?php echo $comite['agenda_fecha']?></span>
                        </div>
                        <?php
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

                        if(isset($comite['contraloria_usuario_id']) && $comite['contraloria_usuario_id']){
                            $usuarioobj = new Usuario($contraloriasocialDB);
                            $usuario = $usuarioobj->getUsuario($comite['contraloria_usuario_id']);
                            echo "<p class='text-info'><i class='fa fa-user'></i> Asignado CS: {$usuario['nombres']} {$usuario['apellido_p']} {$usuario['apellido_m']}</p>";
                        }
                        else{
                            echo "<p><i class='fa fa-user-times'></i> Sin asignar </p>";
                        }

                        if(isset($comite['representante_dependencia_normativa']) && $comite['representante_dependencia_normativa']){
                            echo "<p class='text-info'><i class='fa fa-user'></i> Representante D. N. {$comite['representante_dependencia_normativa']}</p>";
                        }
                        else{
                            echo "<p><i class='fa fa-user-times'></i> Sin responsable de la dependencia Normativa</p>";
                        }
                        ?>
                        <br/>
                    </div>
                </div>
            </li>

            <li>
                <div class="block">
                    <div class="tags">
                        <a  data-toggle="title" title="Integración" class="tag">
                            <span>Integreación</span>
                        </a>
                    </div>
                    <div class="block_content">
                        <h2 class="title">
                            <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                        </h2>
                        <div class="byline">
                            <span>13 hours ago</span> by <a>Jane Smith</a>
                        </div>
                        <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                        </p>
                    </div>
                </div>
            </li>

        </ul>
    </div>
</div>


