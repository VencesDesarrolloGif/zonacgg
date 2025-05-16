<?php

?>


<div class="containerTableRequisiciones"  align="left" STYLE="background-color:white">

        <?php if ($usuario["rol"] == "Contrataciones" || $usuario["rol"] =="Lider Unidad"): ?>
            <center>
            <button type="button" class="btn btn-warning" onclick="showPlantillasIncompletas();">Plantillas Incompletas</button>
            <button type="button" class="btn btn-success" onclick="showPlantillasCompletas();">Plantillas Completas</button>
            <button type="button" class="btn btn-danger" onclick="showPlantillasExcedidas();">Plantillas Excedidas</button>
            
            </center>
            <br>
            <br>
        <?php endif; ?>

        <section>

            

            <table id="tableRequisiciones" class="display" cellspacing="0" width="90%">
                <thead>
                    <tr>
                        <th>Puesto</th>
                        <th>Tipo rol</th>                        
                        <th>IdPunto</th>
                        <th>Punto Servicio</th>
                        <th>Cliente</th>
                        <th>Comentarios</th>                        
                        <th>Entidad Fed.</th> 
                        <th>Direccion</th> 
                        <th>Fecha de inico</th>
                        <th># elementos solicitados</th>
                        <th># elementos asignados</th>
                        <th># elementos contratados </th>
                        <th>Diferencia </th>

                        
                        </tr>
                </thead>
                 <tfoot>
                    <tr>
                        <th>Puesto</th>
                        <th>Tipo rol</th>                        
                        <th>IdPunto</th>
                        <th>Punto Servicio</th>
                        <th>Cliente</th>
                        <th>Comentarios</th>                        
                        <th>Entidad Fed.</th> 
                        <th>Direccion</th> 
                        <th>Fecha de inico</th>
                        <th># elementos solicitados</th>
                        <th># elementos asignados</th>
                        <th># elementos contratados </th>
                        <th>Diferencia </th>
                        
                        </tr>
                </tfoot>

                <tbody></tbody>

            </table>
         
            
        </section>
        
</div>


<script type="text/javascript">
    var tableRequisiciones = null;	
    var dataTableRequisicionesIncompletas = [];
    var dataTableRequisicionesCompletas = [];
    var dataTableRequisicionesExcedidas = [];

    <?php if ($usuario["rol"] == "Contrataciones" || $usuario["rol"] =="Lider Unidad"): ?>
	function styleTableRequisiciones(){

        $.ajax ({
            type: "POST"
            ,url: "ajax_getPlantillas.php"
            ,dataType: "json"
            ,async: false
            ,success: function (response)
            {
                if (response.status == "success")
                {
                    for (var i = 0; i < response.data.length; i++)
                    {
                        var record = response.data [i];

                        if (record.ElementosSolicitados > record.ElementosAsignados)
                        {
                            dataTableRequisicionesIncompletas.push (record);
                        }
                        
                        else if(record.ElementosAsignados > record.ElementosSolicitados)
                        {
                            dataTableRequisicionesExcedidas.push( record);
                        }

                        else if(record.ElementosAsignados === record.ElementosSolicitados)
                        {
                            dataTableRequisicionesCompletas.push( record);
                        }
                    }

                    loadDataInTable (dataTableRequisicionesIncompletas);
                }
            }
            ,error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText); 
            }
        });
    }
    <?php endif; ?>


    function loadDataInTable (data)
    {
        if (tableRequisiciones != null)
        {
            tableRequisiciones.destroy ();
            tableRequisiciones = null;
        }

        if (data.length == 0)
        {
            alert ("No hay datos para cargar");
        }

        tableRequisiciones = $('#tableRequisiciones').DataTable( {
        data: data,
        destroy: true,
        "columns": [
            { "data": "descripcionPuesto"}
            ,{ "data": "descripcionTurno" }            
            ,{ "data": "idPuntoServicio" }
            ,{ "data": "puntoServicio" }
            ,{ "data": "razonSocial" }
            ,{ "data": "comentarioRequisicion" }
            ,{ "data": "nombreEntidadFederativa" }
            ,{ "data": "direccionPuntoServicio" }
            ,{ "data": "fechaInicio" }
            ,{ "data": "ElementosSolicitados" }
            ,{ "data": "ElementosAsignados" }
            ,{ "data": "ElementosEnPuntoServicio" }
            ,{ "data": "diferencia" }
       ],
       "dom":"Bfrtip",
             "buttons":[                   
              
                     {
                        extend:    'excelHtml5',
                        text:      '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: 'Excel'
                    }
                    
                ]
     

    } );

}


    <?php if($usuario["rol"] == "Ventas"): ?>
	function cargarPlantillasExcedidas(){
        $.ajax ({
            type: "POST"
            ,url: "ajax_obtenerRequisicionesRhTable.php"
            ,dataType: "json"
            ,async: false
            ,success: function (response)
            {
                if (response.status == "success")
                {
                    for (var i = 0; i < response.data.length; i++)
                    {
                        var record = response.data [i];

                        if (record.ElementosAsignados > record.ElementosSolicitados)
                        {
                            dataTableRequisicionesExcedidas.push (record);
                        }
                    }

                    loadDataInTable (dataTableRequisicionesExcedidas);
                }
            }
            ,error : function (response)
            {
                alert ("ocurrio un error plantillas exedidas");
            }
        });
    }
    <?php endif; ?>

$(inicioConsultaReq());  

function inicioConsultaReq(){
    <?php if ($usuario ["rol"] == "Contrataciones" || $usuario["rol"] =="Lider Unidad"): ?>
        styleTableRequisiciones();
    <?php elseif ($usuario ["rol"] == "Ventas"): ?> 
        cargarPlantillasExcedidas (); 
    <?php endif; ?>
}

<?php if($usuario["rol"] == "Contrataciones" || $usuario["rol"] =="Lider Unidad"): ?>
    function showPlantillasIncompletas ()
    {
        loadDataInTable (dataTableRequisicionesIncompletas);
    }


    function showPlantillasCompletas ()
    {
        loadDataInTable (dataTableRequisicionesCompletas);
    }


    function showPlantillasExcedidas ()
    {
        loadDataInTable (dataTableRequisicionesExcedidas);
    }
<?php endif; ?>
</script>
