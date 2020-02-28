<p style="text-align: center"><img style="width:100px;" src="../../imagenes/logo_pe.png"/></p>
<br/>
<table class="datatable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th style="width: 100px;">No. de Obra</th>
            <th style="width: 100px;">Dependencia</th>
            <th ">Obra</th>
            <th style="width: 100px;">Inicio de Obra</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if(isset($obras)){
            foreach($obras as $obra){
                //set_time_limit(20);
                echo "<tr>";
                echo "<td>{$obra['num_obra']}</td>";
                echo "<td>{$obra['ejecutora']}</td>";
                echo "<td>{$obra['nombre_obra']}</td>";
                echo "<td>{$obra['inicio_contrato']}</td>";
                echo "<td>{$obra['status']}</td>";
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
