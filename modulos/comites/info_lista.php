<p style="text-align: center"><img style="width:100px;" src="../../imagenes/logo_pe.png"/></p>
<br/>
<table class="datatable" width="100%" cellspacing="0">
    <thead>
    <tr>
        <th >No. de Comite</th>
        <th >Fecha de Integración</th>
        <th >Asignado a </th>
        <th >Método</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(isset($comites)){
        foreach($comites as $comite){
            //set_time_limit(20);
            echo "<tr>";
            echo "<td>{$comite['num_comite']}</td>";
            echo "<td>{$comite['fecha_integracion']}</td>";
            if($comite['usuario']){
                echo "<td>{$comite['usuario']['nombres']} {$comite['usuario']['apellido_p']} {$comite['usuario']['apellido_m']}</td>";
            }
            else{
                echo "<td></td>";
            }
            echo "<td>{$comite['metodo']}</td>";
            echo "<td>{$comite['status']}</td>";
            echo "</tr>";
        }
    }
    ?>
    </tbody>
</table>

<style>
    *{
        font-family: Arial, Helvetica;
    }
    .datatable{
        width: 100%;
    }
    td, th{
        font-size: 10px;
        padding: 5px;
    }
    th{
        text-align: left;
        background-color: #2C5595;
        color: #FFFFFF;
        padding: 10px;
    }
    td{
        border-color: #AAAAAA;
        border-style: solid;
        border-width: 1px;
    }
</style>
