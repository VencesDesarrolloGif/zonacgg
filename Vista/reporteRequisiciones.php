<form class="form-horizontal"  method="post" id="form_consultaRequisiciones" name='form_consultaRequisiciones' action="ficheroExportGeneral.php" target="_blank">
<div class="containerRequisiciones" class="containerRequisiciones" >
    <h4>Consulta Requisiciones</h4>
    <br><br>
    <select id="selTipoBusqueda" name="selTipoBusqueda" class="selectpicker"  class="input-large" data-size="9">
        <option VALUE="0" selected>GENERAL</option>
        <option VALUE="1">ACTIVAS</option>
        <option VALUE="2">BAJAS</option>
    </select>
    <br>
    <br>
    <button type='button' class='btn btn-info' id='btnGenerarReportePersonalActivo' name='btnGenerarReportePersonalActivo' onclick='styleTableRequisicionesFromVentas();'>Generar Reporte <span class='glyphicon glyphicon-refresh' ></span></button> 
        <br>
        <br>
        <section>
            <table id="tableRequisicionesFromVentas" class="display nowrap" cellspacing="20" width="80%" style="display: none;">
                <thead>
                    <tr>
                        <th>Id Requisicion</th>
                        <th>Id Punto Servicio</th>
                        <th>Punto Servicio</th>
                        <th>Linea De Negocio</th>
                        <th>Num. Centro Costo</th>
                        <th>Fecha Inicio Servicio</th>
                        <th>Fecha Termino Servicio</th>
                        <th>Estatus punto servicio</th>
                        <th>Entidad</th>
                        <th>Cliente</th>
                        <th>Numero Eelementos</th>
                        <th>Puesto</th>
                        <th>Turno</th>                        
                        <th>Rol operativo</th> 
                        <th>Fecha Inicio</th>
                        <th>Fecha Termino</th>
                        <th>Estatus Plantilla</th>
                        <th>Sueldo</th>
                        </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                       <th>Id Requisicion</th>
                        <th>Id Punto Servicio</th>
                        <th>Punto Servicio</th>
                        <th>Linea De Negocio</th>
                        <th>Num. Centro Costo</th>
                        <th>Fecha Inicio Servicio</th>
                        <th>Fecha Termino Servicio</th>
                        <th>Estatus punto servicio</th>
                        <th>Entidad</th>
                        <th>Cliente</th>
                        <th>Numero Eelementos</th>
                        <th>Puesto</th>
                        <th>Turno</th> 
                        <th>Rol operativo</th>                        
                        <th>Fecha Inicio</th>
                        <th>Fecha Termino</th>
                        <th>Estatus Plantilla</th>
                        <th>Sueldo</th>
                    </tr>
                </tfoot>
            </table>
        </section>
</div>
</form>
<script type="text/javascript">

function generarReporteGeneral2(){
    window.open('exportConsultaGeneral.php',"width=600,height=600,scrollbars=no");
}

function generarReporteGeneral3(){
    window.open('consultaGeneralOp.php',"width=600,height=600,scrollbars=no");
}
    
function descargarReporte(){	
    $("#datos_a_enviarReporte").val( $("<div>").append( $("#reporteGeneralExport").eq(0).clone()).html());
    $("#form_consultaGeneral").submit();
}

var tableRequsicionesFromVentas = null;

function styleTableRequisicionesFromVentas(){

    $("#tableRequisicionesFromVentas").show();
    var tipoBusquedaPlantilla=$("#selTipoBusqueda").val();

    if(tableRequsicionesFromVentas != null){
       tableRequsicionesFromVentas.destroy ();
    }

    tableRequsicionesFromVentas = $('#tableRequisicionesFromVentas').DataTable( {
    ajax: {
            url: 'ajax_getRequisicionesFromVentas.php',
            data:{ "tipoBusquedaPlantilla": tipoBusquedaPlantilla},
            type: 'POST'
          }
            ,"columns": [
            { "data": "servicioPlantillaId"}
            ,{ "data":"puntoServicioPlantillaId"}
            ,{ "data":"puntoServicio" }
            ,{ "data":"descripcionLineaNegocio"}
            ,{ "data":"numeroCentroCosto" }
            ,{ "data":"fechaInicioServicio"}
            ,{ "data":"fechaTerminoServicio"}
            ,{ "data":"esatusPunto"}
            ,{ "data": "nombreEntidadFederativa"}
            ,{ "data": "razonSocial"}
            ,{ "data": "numeroElementos"}
            ,{ "data": "descripcionPuesto"}
            ,{ "data": "descripcionTurno"} 
            ,{ "data": "rolOperativoPlantilla"} 
            ,{ "data": "fechaInicio"}
            ,{ "data": "fechaTerminoPlantilla"}
            ,{ "data": "estatusPlantilla"}   
            ,{ "data": "sueldo"}             
        ]
        ,dom: 'Bfrtip',
        buttons: [
            'copy', 'excel'
        ]
    } );
}
</script>