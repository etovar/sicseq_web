<div class="printable-content">
    <div class="printable-area" id="printable-area">
        <table class="header-table" style="width: 100%;">
            <tr colspan="12" style="width: 100%;">
                <td colspan="12" style="width: 100%;">
                    <ion-img style="width: 25%; margin-top: 0em; margin-bottom: -3em; margin-right: 10em;" [src]="imageurl"></ion-img>INCLUIR DATOS DE LA<br>DEPENDENCIA EJECUTORA
                </td>
            </tr>
            <tr colspan="12" style="width: 100%;"><td colspan="12" style="width: 100%;"><br></td></tr>
            <tr colspan="12" style="width: 100%;">
                <td class="border-header" colspan="12" style="width: 100%;">
                    Acta de Integración de Comité de Contraloría Social
                </td>
            </tr>
        </table><br>
        <table class="detail-table" style="width: 100%;">
            <tr colspan="12" style="width: 100%;">
                <td class="detail-table-title" colspan="12" style="width: 100%;">
                    1. DATOS GENERALES DEL COMITÉ DE CONTRALORÍA SOCIAL
                </td>
            </tr>
            <tr colspan="12" style="width: 100%;">
                <td class="detail-table-body border" colspan="2" style="width: 15%;">
                    MUNICIPIO:
                </td>
                <td class="detail-table-body border" colspan="6" style="width: 40%;">
                    <?php echo $obra['mmunicipio']?>
                </td>
                <td class="detail-table-body border" colspan="1" style="width: 10%;">
                    FECHA:
                </td>
                <td class="detail-table-body border" colspan="3" style="width: 35%;">
                    <?php echo $comite['agenda_fecha']?>
                </td>
            </tr>
            <tr colspan="12" style="width: 100%;">
                <td class="detail-table-body border" colspan="2" style="width: 15%;">
                    LOCALIDAD:
                </td>
                <td class="detail-table-body border" colspan="6" style="width: 40%;">
                    <?php echo $obra['localidad']?>
                </td>
                <td class="detail-table-body border" colspan="1" style="width: 10%;">
                    PROGRAMA:
                </td>
                <td class="detail-table-body border" colspan="3" style="width: 35%;">
                    <?php echo $obra['programa']?>
                </td>
            </tr>
            <tr colspan="12" style="width: 100%;"><td colspan="12" style="width: 100%;"><br></td></tr>
        </table>
        <table class="detail-table" style="width: 100%;">
            <tr colspan="12" style="width: 100%;">
                <td class="detail-table-title" colspan="12" style="width: 100%;">
                    2. DATOS GENERALES DE LA OBRA Y/O APOYO
                </td>
            </tr>
            <tr colspan="12" style="width: 100%;">
                <td class="detail-table-body border" colspan="6" style="width: 50%;">
                    NOMBRE DE LA OBRA, APOYO Y/O SERVICIO:
                </td>
                <td class="detail-table-body border" colspan="6" style="width: 50%;">
                    <?php echo $obra['nombre_obra']?>
                </td>
            </tr>
            <tr colspan="12" style="width: 100%;">
                <td class="detail-table-body border" colspan="2" style="width: 15%;">
                    NO. DE OBRA:
                </td>
                <td class="detail-table-body border" colspan="5" style="width: 40%;">
                    <?php echo $obra['num_obra']?>
                </td>
                <td class="detail-table-body border" colspan="3" style="width: 25%;">
                    MONTO DE INVERSIÓN:
                </td>
                <td class="detail-table-body border" colspan="2" style="width: 20%;">
                    <?php echo $obra['monto_aprobado']?>
                </td>
            </tr>
            <tr colspan="12" style="width: 100%;">
                <td class="detail-table-body border" colspan="3" style="width: 28%;">
                    PERIODO DE EJECUCIÓN:
                </td>
                <td class="detail-table-body border" colspan="4" style="width: 27%;">
                    <?php echo $obra['inicio_obra']?> - <?php echo $obra['termino_obra']?>
                </td>
                <td class="detail-table-body border" colspan="2" style="width: 15%;">
                    FONDO:
                </td>
                <td class="detail-table-body border" colspan="3" style="width: 30%;">
                    <?php echo $obra['fondo']?>
                </td>
            </tr>
        </table>
        <table class="detail-table" style="width: 100%;">
            <tr colspan="12" style="width: 100%;"><td colspan="12" style="width: 100%;"><br></td></tr>
            <tr colspan="12" style="width: 100%;">
                <td class="detail-table-title"  colspan="12" style="width: 100%;">
                    3. INTEGRANTES DEL COMITÉ<br>
                    (Adjuntar la lista con nombre y firma de los integrantes asistentes a la constitución del Comité)
                </td>
            </tr>
            <?php foreach($integrantes as $integrante){?>
            <tr  colspan="12" style="width: 100%;" >
                <td  colspan="12" style="width: 100%;">
                    <table class="detail-integrantes" colspan="12" style="width: 100%;">
                        <tr class="detail-integrante-title" colspan="12" style="width: 100%;">
                            <td class="border" style="padding: 5px;" colspan="5" style="width: 55%;">
                                Integrante del Comité
                            </td>
                            <td class="border" colspan="2" style="width: 14%; text-align: center; padding: 5px;">
                                Genero
                            </td>
                            <td class="border" colspan="2" style="width: 15%; padding: 5px;">
                                Cargo
                            </td>
                            <td class="border" colspan="3" style="width: 16%; padding: 5px;">
                                Firma
                            </td>
                        </tr>
                        <tr colspan="12" style="width: 100%;">
                            <td class="detail-table-body border" colspan="1" style="width: 15%;">
                                Nombre:
                            </td>
                            <td class="detail-table-body border" colspan="4" style="width: 40%; text-align: center;">
                                <?php echo $integrante['nombre'] ?>
                            </td>
                            <td class="detail-integrante-title border" colspan="1" style="width: 7%; text-align: center;">
                                H
                            </td>
                            <td class="detail-integrante-title border" colspan="1" style="width: 7%; text-align: center;">
                                M
                            </td>
                            <td class="detail-table-body border" rowspan="2" colspan="2" style="width: 15%; text-align: center;">
                                <?php echo $integrante['cargo'] ?>
                            </td>
                            <td class="detail-table-body border" colspan="3" style="width: 16%; text-align: center;"  rowspan="3">
                                <img width="40%" *ngIf="item.firma !== null" style="transform:rotate(270deg);" [src]="item.firma"/> <br>
                            </td>
                        </tr>
                        <tr colspan="12" style="width: 100%;">
                            <td class="detail-table-body border" colspan="1" style="width: 10%;">
                                Domicilio:
                            </td>
                            <td class="detail-table-body border" colspan="2" style="width: 20%; text-align: center;">
                                <?php echo $integrante['domicilio'] ?>
                            </td>
                            <td class="detail-table-body border" colspan="1" style="width: 10%;">
                                Teléfono:<label style="font-size: 0.5em;">(opcional)</label>
                            </td>
                            <td class="detail-table-body border" colspan="1" style="width: 15%; font-size: 0.45em; text-align: center;">
                                <?php echo $integrante['telefono'] ?>
                            </td>
                            <td class="detail-table-body border" colspan="1" style="width: 7%; text-align: center;">
                                <label *ngIf="item.genero === 'H'" style="text-align: center;">X</label>

                            </td>
                            <td class="detail-table-body border" colspan="1" style="width: 7%; text-align: center;">
                                <?php echo $integrante['genero'] == 'M'?'X':''; ?>
                            </td>
                        </tr>
                        <tr colspan="12" style="width: 100%;">
                            <td class="detail-table-body border" colspan="2" style="width: 21%;">
                                Correo Electrónico:<label style="font-size: 0.5em;">(opcional)</label>
                            </td>
                            <td class="detail-table-body border" colspan="2" style="width: 21%; font-size: 0.45em; text-align: center;">
                                <?php echo $integrante['correo'] ?>
                            </td>
                            <td class="detail-table-body border" colspan="1" style="width: 9%;">
                                CURP:<label style="font-size: 0.5em;">(opcional)</label>
                            </td>
                            <td class="detail-table-body border" colspan="2" style="width: 18%; font-size: 0.45em; text-align: center;">
                                <?php echo $integrante['curp'] ?>
                            </td>
                            <td class="detail-table-body border" colspan="1" style="width: 7%;">
                                EDAD:
                            </td>
                            <td class="detail-table-body border" colspan="1" style="width: 8%; text-align: center;">
                                <?php echo $integrante['edad'] ?>
                            </td>
                        </tr>
                        <tr colspan="12" style="width: 100%;"><td colspan="12" style="width: 100%;"><br></td></tr>
                    </table>
                </td>
            </tr>
            <?php } ?>
            <tr class="detail-table-title" colspan="12" style="width: 100%; text-align: center; background-color: darkgrey;">
                <td class="border" colspan="8" style="width: 70%;">
                    Información Proporcionada la Comité
                </td>
                <td class="border" colspan="4" style="width: 30%;">
                    Firma por parte del representante del Comité
                </td>
            </tr>
            <tr class="detail-table-title" colspan="12" style="width: 100%;">
                <td colspan="8" style="width: 70%;" class="border" style="text-align: left;">
                    Los integrantes del comité recibimos la información general de la obra, apoyo o servicio
                </td>
                <td colspan="4" style="width: 30%;" class="border" style="text-align: center;">
                    <img width="22%" *ngIf="firmaPresidenteGrl !== null" style="transform:rotate(270deg); margin-top: -3%; margin-bottom: -5%;" [src]="firmaPresidenteGrl"/> <br>
                </td>
            </tr>
            <tr class="detail-table-title" colspan="12" style="width: 100%;">
                <td colspan="8" style="width: 70%;" class="border" style="text-align: left;">
                    Los integrantes de comités conocemos los mecanismos para interponer quejas y denuncias o Solicitudes de información
                </td>
                <td colspan="4" style="width: 30%;" class="border" style="text-align: center;">
                    <img width="22%" *ngIf="firmaPresidenteGrl !== null" style="transform:rotate(270deg); margin-top: -3%; margin-bottom: -5%;" [src]="firmaPresidenteGrl"/> <br>
                </td>
            </tr>
            <tr colspan="12" style="width: 100%;"><td colspan="12" style="width: 100%;"><br></td></tr>
            <tr colspan="12" style="width: 100%;">
                <td colspan="5" style="width: 46%;">
                    <table colspan="12" style="width: 100%;">
                        <tr colspan="12" style="width: 100%;">
                            <td colspan="12" style="width: 100%; border-right:none;border-left:none;border-bottom:none;border-left:none;border-top:none; text-align: center; font-weight: normal; font-size: 0.62em;">
                                <img width="30%" *ngIf="firmaEjecutoraGrl !== null" style="transform:rotate(270deg); margin: -10%" [src]="firmaEjecutoraGrl"/> <br>
                                <?php echo "{$usuario['nombres']} {$usuario['apellido_p']} {$usuario['apellido_m']}" ?> <br> <?php echo $usuario['cargo'] ?>
                            </td>
                        </tr>
                        <tr colspan="12" style="width: 100%;">
                            <td colspan="12" style="width: 100%; border-right:none;border-left:none;border-bottom:none;border-left:none; text-align: center; font-weight: normal; font-size: 0.62em; border-top-style: solid; border-top-color: black; border-top-width: 1px;">Nombre, Cargo y Firma del Representante de la Dependencia Ejecutora</td>
                        </tr>
                    </table>
                </td>
                <td colspan="1" style="width: 6%; border-right:none;border-left:none;border-bottom:none;border-top:none;">
                </td>
                <td colspan="5" style="width: 46%;">
                    <table>
                        <tr colspan="12" style="width: 100%;">
                            <td colspan="12" style="width: 100%; border-right:none;border-left:none;border-bottom:none;border-left:none;border-top:none; text-align: center; font-weight: normal; font-size: 0.62em;">
                                <img width="30%" *ngIf="firmaNormativaGrl !== null" style="transform:rotate(270deg); margin: -10%" [src]="firmaNormativaGrl"/> <br>
                                <?php echo $comite['representante_dependencia_normativa'] ?> <br> <?php echo $comite['cargo_dependencia_normativa'] ?>
                            </td>
                        </tr>
                        <tr colspan="12" style="width: 100%;">
                            <td colspan="12" style="width: 100%; border-right:none;border-left:none;border-bottom:none;border-left:none; text-align: center; font-weight: normal; font-size: 0.62em; border-top-style: solid; border-top-color: black; border-top-width: 1px;">Nombre, Cargo y Firma del Representante de la Dependencia Normativa</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr colspan="12" style="width: 100%;"><td colspan="12" style="width: 100%;"><br></td></tr>
            <tr colspan="12" style="width: 100%;"><td colspan="12" style="width: 100%;"><br></td></tr>
        </table>
        <table style="width: 50%; margin-left: 25%;">
            <tr style="width: 50%;">
                <td class="firmas" style="width: 50%;">
                    Nombre, Cargo y Firma del Representante del Órgano Estatal de Control
                </td>
            </tr>
        </table>
        <table class="footer-table" style="width: 100%;">
            <tr>
                <td class="ion-text-wrap" style="font-size: 0.35em; text-align: left;">
                    <br><br>La Secretaría de la Contraloría del Poder Ejecutivo del Estado de Querétaro, a través del Departamento de Contraloría Social de la Dirección de Prevención y Evaluación, con domicilio en calle Dr. Leopoldo Río de la Loza número 12, Col. Centro Histórico, C.P. 76000, Ciudad de Santiago de Querétaro, Querétaro; utilizará sus datos personales recabados en el  Acta de Integración de Comité de Contraloría Social, serán para fines estadísticos y de difusión institucional que contemplan (fotografías, videos, grabaciones o datos escritos).Para mayor información acerca del tratamiento y de los derechos que puede hacer valer, usted puede acceder al aviso de privacidad a través de la página de la Secretaría de la Contraloría del Poder Ejecutivo del  Estado de Querétaro: http: www2.queretaro.gob.mx/contraloría.
                </td>
            </tr>
        </table>
    </div>
</div>
<style>
    ion-content {
        background-color: #c0c0ff;
    }
    .printable-content {
        font-size: 17px;
        overflow-x: scroll;
        overflow-y: scroll;
        background-color: #ffffff;
    }
    .printable-area {
        width: 595px;
        height: 842px;
    }

    .title {
        color: #708395;
    }
    .font {
        color: #708395;
    }
    .font-boton {
        font-size: 0.5em;
    }
    .font-title-primary {
        color: #708395;
        font-size: 1.32em;
    }
    .ngx-datatable {
        color: #708395;
    }
    .datatable-body {
        position: relative;
        z-index: 10;
        background-color: white;
        display: block;
        border-radius: 5px;
    }
    .datatable-header {
        display: block;
        background-color: white;
        overflow: hidden;
        border-radius: 5px;
    }
    .datatable-body-cell {
        overflow-x: hidden;
        vertical-align: top;
        display: inline-block;
        border-style: solid;
        border-width: .03em;
        text-align: center;
        border-color: #708395;
    }
    datatable-header-cell {
        border-style: solid;
        border-width: .03em;
        border-color: #708395;
        font-weight: bold;
        padding-left: 5px;
    }
    .icono {
        font-size: 2.25em;
    }


    .printable-content {
        width: 98%;
        margin: 0 auto;
        text-align: center;
        overflow-y: scroll;
        overflow-x: scroll;
    }
    .printable-area {
        width: 98%;
        margin: 0 auto;
        text-align: center;
    }
    .header-table {
        text-align: center;
        font-weight: bold;
        font-size: 0.8em;
    }
    .border-header {
        border-style: solid;
        border-width: 1px;
        border-color: black;
        padding: 0.5em;
        font-size: 0.75em;
    }
    .header-table {
        margin: 0 auto;
        text-align: center;
    }
    table .detail-table-title {
        text-align: left;
    }
    .detail-table-title {
        font-weight: bold;
        font-size: 0.6em;
        text-align: left;
    }
    .detail-table-body {
        text-align: left;
        font-weight: normal;
        font-size: 0.55em;
    }
    .detail-table-body {
        text-align: left;
        font-weight: normal;
        font-size: 0.55em;
    }
    .border {
        border-style: solid;
        border-width: 1px;
        border-color: black;
    }
    .detail-integrante-title {
        background-color: darkgrey;
        font-weight: bold;
        font-size: 0.58em;
        text-align: center;
    }
    .firmas {
        text-align: center;
        font-weight: normal;
        font-size: 0.62em;
        border-top-style: solid;
        border-top-color: black;
        border-top-width: 1px;
    }
    .firmas {
        text-align: center;
        font-weight: normal;
        font-size: 0.62em;
        border-top-style: solid;
        border-top-color: black;
        border-top-width: 1px;
    }
    tr, th, td, table{
        border-spacing:0px;
    }
</style>
