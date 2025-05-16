<div class="containertableSueldos"  align="left" STYLE="background-color:white">
      <div id="msgerrorIncidencia" name="msgerrorIncidencia" > </div>

 <center>
    <br>
    <div align="center">
          <h2>HISTORIAL PETICIONES ESPECIALES</h2>
          <span class="add-on">Buscar por Día de Incidencia ->  </span>
          <span class="add-on">Del:</span>
          <input class="input-medium" id="FechaInicioBusquedaIncidencias" name="FechaInicioBusquedaIncidencias" type="date">
          <span class="add-on">Al:</span>
          <input class="input-medium" id="FechaFinBusquedaIncidencias" name="FechaFinBusquedaIncidencias" type="date">
           &nbsp<button style="margin-bottom: 0.5%" type="button" class="btn btn-primary" onclick="consultatblhistoricoincidencia();">Buscar</button>
    </div>
 </center>

    <table id="tableConsultaHistoricoIncidencias" name="tableConsultaHistoricoIncidencias" class="display editinplace" cellspacing="0" width="90%">
                <thead>
                    <tr>
                        <th style="text-align: center;background-color: #B0E76E">#Empleado</th>
                        <th style="text-align: center;background-color: #B0E76E">Nombre Del Empleado</th>
                        <th style="text-align: center;background-color: #B0E76E">Punto Servicio</th>
                        <th style="text-align: center;background-color: #B0E76E">#Supervisor</th>
                        <th style="text-align: center;background-color: #B0E76E">Nombre del Supervisor</th>
                        <th style="text-align: center;background-color: #B0E76E">Tipo de Incidencia</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha de la Incidencia</th>
                        <th style="text-align: center;background-color: #B0E76E">Registro de la Incidencia</th>
                        <th style="text-align: center;background-color: #B0E76E">Usuario</th>
                        <th style="text-align: center;background-color: #B0E76E">Comentario</th>
                        <th style="text-align: center;background-color: #B0E76E">Puesto </th>
                        <th style="text-align: center;background-color: #B0E76E">Rol Operativo</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha de Edición</th>
                        <th style="text-align: center;background-color: #B0E76E">Usuario que Editó</th>
                        <th style="text-align: center;background-color: #B0E76E">Accion Realizada DG</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha Acción DG</th>
                        <th style="text-align: center;background-color: #B0E76E">Acción Usuario</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha Accion Usuario</th>
                        <th style="text-align: center;background-color: #B0E76E">Usuario Accion</th>
                        
                     </tr>
                </thead>
                 <tfoot>
                    <tr>
                        <th style="text-align: center;background-color: #B0E76E">#Empleado</th>
                        <th style="text-align: center;background-color: #B0E76E">Nombre Del Empleado</th>
                        <th style="text-align: center;background-color: #B0E76E">Punto Servicio</th>
                        <th style="text-align: center;background-color: #B0E76E">#Supervisor</th>
                        <th style="text-align: center;background-color: #B0E76E">Nombre del Supervisor</th>
                        <th style="text-align: center;background-color: #B0E76E">Tipo de Incidencia</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha de la Incidencia</th>
                        <th style="text-align: center;background-color: #B0E76E">Registro de la Incidencia</th>
                        <th style="text-align: center;background-color: #B0E76E">Usuario</th>
                        <th style="text-align: center;background-color: #B0E76E">Comentario</th>
                        <th style="text-align: center;background-color: #B0E76E">Puesto </th>
                        <th style="text-align: center;background-color: #B0E76E">Rol Operativo</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha de Edición</th>
                        <th style="text-align: center;background-color: #B0E76E">Usuario que Editó</th>
                        <th style="text-align: center;background-color: #B0E76E">Accion Realizada DG</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha Acción DG</th>
                        <th style="text-align: center;background-color: #B0E76E">Acción Usuario</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha Accion Usuario</th>
                        <th style="text-align: center;background-color: #B0E76E">Usuario Accion</th>
                        
                    </tr>
                </tfoot>

                <tbody></tbody>
    </table>

    </div>
<script type="text/javascript">


var dataTableConsultarHistoricoIncidencias = [];
$(inicioHistIncEsp());  

function inicioHistIncEsp(){
    <?php if ($usuario["rol"] == "Direccion General"): ?>
        gettblhistoricoIncidenciasEspeciales();
    <?php endif;?>
}


        function gettblhistoricoIncidenciasEspeciales(){
          var accion="1";
          var fechainicio ="";
          var fechafin ="";
        $.ajax ({
            type: "POST"
            ,url: "ajax_gettblhistoricoincidencias.php"
            ,data:{"fechainicio":fechainicio,"fechafin":fechafin,"accion":accion}
            ,dataType: "json"
            ,async: false
            ,success: function (response)
            {
              dataTableConsultarHistoricoIncidencias = [];
              if (response.status == "success")
                {
                    for (var i = 0; i < response.data.length; i++)
                    {
                        var record = response.data [i];
                        dataTableConsultarHistoricoIncidencias.push(record);
                    }
                  loadDataInTableConsultaHistoricoIncidencias(dataTableConsultarHistoricoIncidencias);
                }
            }
            ,error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText);
            }
        });
    }

    function loadDataInTableConsultaHistoricoIncidencias (data)
    {
     var tableConsultaHistoricoIncidencias = null;

        if (tableConsultaHistoricoIncidencias != null)
        {
            tableConsultaHistoricoIncidencias.destroy ();
            tableConsultaHistoricoIncidencias = null;
        }
        if (data.length == 0)
        {
            //alert ("No hay datos para cargar");
        }
        tableConsultaHistoricoIncidencias = $('#tableConsultaHistoricoIncidencias').DataTable( {
               "language": {
             "emptyTable": "No hay regidtro disponibles",
             "info": "Del _START_ al _END_ de _TOTAL_",
             "infoEmpty": "Mostrando 0 registros de un total de 0.",
             "infoFiltered": "(filtrados de un total de _MAX_ registros)",
             "infoPostFix": "(actualizados)",
             "lengthMenu": "Mostrar _MENU_ registros",
             "loadingRecords": "Cargando....",
             "processing": "Procesando....",
             "search": "Buscar:",
             "searchPlaceholder": "Dato para buscar",
             "zeroRecords": "No se han encontrado coincidencias",
             "paginate": {
                 "first": "Primera",
                 "last": "Ultima",
                 "next": "Siguiente",
                 "previous": "Anterior"
             },
             "aria": {
                 "sortAscending": "Ordenación ascendente",
                 "sortDescending": "Ordenación descendente"
             }
         },
        data: data,
        destroy: true,
        "columns": [
            {"data": "NumeroEmpleadoincidencia"}
            ,{"data": "NombreEmpleadoIncidencia" }
            ,{"data": "PuntoServicioIncidencia" }
            ,{"data": "NumeroSupervisorIncidencia" }
            ,{"data": "NombreSupervisorIncidencia" }
            ,{"data": "descripcionIncidenciaEspecial"}
            ,{"data": "DiaDeLaIncidencia"}
            ,{"data": "FechaRegistroIncidencia" }
            ,{"data": "UsuarioCaptura"}
            ,{"data": "ComentarioIncidencia"}
            ,{"data": "descripcionPuesto"}
            ,{"data": "RolOperativo"}
            ,{"data": "FechaEdicionIncidencia"}
            ,{"data": "UsuarioEdicionIncidencia" }
            ,{"data": "AccionPeticionDG"}
            ,{"data": "FechaAccionDG"}
            ,{"data": "AccionUsuario"}
            ,{"data": "FechaAccionUsuario"}
            ,{"data": "UsuarioAccion"}
       ]
        //,serverSide: true
        ,processing: true
        ,dom: 'Bfrtip'
        ,buttons: ['copy', 'excel']

    } );

}


 function consultatblhistoricoincidencia(){
var fechainicio=$("#FechaInicioBusquedaIncidencias").val();
var fechafin=$("#FechaFinBusquedaIncidencias").val();
var accion = "2";
 $.ajax ({
            type: "POST"
            ,url: "ajax_gettblhistoricoincidencias.php"
            ,data:{"fechainicio":fechainicio,"fechafin":fechafin,"accion":accion}
            ,dataType: "json"
            ,async: false
            ,success: function (response)

            { dataTableConsultarHistoricoIncidencias = [];
                $("#msgerrorIncidencia").html("");
                var mensaje =response.error; 
                
                if (response.status == "error")
                {
                  $('#msgerrorIncideciasEspeciales').fadeIn('slow');
                  Msgerrorfechainiciobusqueda = "<div id='msgerrorIncideciasEspeciales' class='alert alert-error'><strong>"+mensaje+"</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#msgerrorIncidencia").html(Msgerrorfechainiciobusqueda);
                    $('#msgerrorIncideciasEspeciales').delay(3000).fadeOut('slow');
                }else{//llamara a la tabla que
                    for (var i = 0; i < response.data.length; i++)
                    {
                        var record = response.data [i];
                        dataTableConsultarHistoricoIncidencias.push (record);
                    }
                        loadDataInTableConsultaHistoricoIncidencias(dataTableConsultarHistoricoIncidencias);
                    }
            }
            ,error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText);
            }
        });
}



</script>

