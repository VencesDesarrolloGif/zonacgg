<center><h3>ESTATUS PETICIONES DE ASISTENCIA EN MERMA</h3> 
    <br>
    <img width="50px" title='Obtener todas las peticiones de merma ' src='img/ActualizarEjecutar.jpg' class='cursorImg' onclick='consultaEstatusPeticionesAsistenciaMerma(2);'><br>
    <div class="input-prepend" id="divEjercicio">
        <h4 >POR EJERCICIO</h4>
        <span class="add-on">Fecha Inicial</span>
        <input class="input-prepend" id="fechaMermaInicio" name="fechaMermaInicio" type="date">

        <span class="add-on">Fecha Final</span>
        <input class="input-prepend" id="fechaMermaFin" name="fechaMermaFin" type="date"><br><br>
        <button type="button" class="btn btn-primary" onclick="consultaEstatusPeticionesAsistenciaMerma(1);">BUSCAR</button><br>
    </div>
</center>
<section>
    <table id="tablaEstatusPeticionesMerma"  class="records_list table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="display: none;">
        <thead>
            <tr>
                <th style="text-align: center;background-color: #B0E76E">Número Empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Nombre Empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Tipo Incidencia</th>
                <th style="text-align: center;background-color: #B0E76E">Punto Servicio</th>       
                <th style="text-align: center;background-color: #B0E76E">Plantilla Servicio</th>
                <th style="text-align: center;background-color: #B0E76E">Tipo Periodo</th>
                <th style="text-align: center;background-color: #B0E76E">Entidad Federativa</th> 
                <th style="text-align: center;background-color: #B0E76E">Linea Negocio</th> 
                <th style="text-align: center;background-color: #B0E76E">Fecha De Asistencia</th> 
                <th style="text-align: center;background-color: #B0E76E">Tipo De turno</th> 
                <th style="text-align: center;background-color: #B0E76E">Número Supervisor</th> 
                <th style="text-align: center;background-color: #B0E76E">Nombre Supervisor</th> 
                <th style="text-align: center;background-color: #B0E76E">Comentario Supervisor</th>
                <th style="text-align: center;background-color: #B0E76E">Comentario</th> 
                <th style="text-align: center;background-color: #B0E76E">Estatus</th> 
            </tr>
        </thead>
   </table>
</section>

<script type="text/javascript"> //empieza lo de js

// $(inicioEstatusPeticionesAsistMerma());  

// function inicioEstatusPeticionesAsistMerma(){
//      consultaEstatusPeticionesAsistenciaMerma(0);
// }

 function consultaEstatusPeticionesAsistenciaMerma(CasoBusqueda) { 
    var fechaMermaInicio = $("#fechaMermaInicio").val();
    var fechaMermaFin = $("#fechaMermaFin").val();
    var bandera=0;
    if(CasoBusqueda=="2" && fechaMermaInicio!="" && fechaMermaFin!=""){
        CasoBusqueda=1;
    }else if(CasoBusqueda=="2"){
        CasoBusqueda=0;
        $("#fechaMermaInicio").val("");
        $("#fechaMermaFin").val("");
    }
    if(CasoBusqueda=="1"){
        if(fechaMermaInicio==""){
          alert("Ingrese La Fecha Inicial");
        }else if(fechaMermaFin== ""){
          alert("Ingrese La Fecha Final");
        }else if (fechaMermaInicio>fechaMermaFin){
          alert("La Fecha Inicial No puede Ser Mayor Que La Fecha Final");
        }else{
            bandera=1;
        }
    }else{bandera=1;}
    if(bandera=="1"){
        waitingDialog.show();
        tablaEstatusPeticonesAsisMerma = [];
        $.ajax({
            type: "POST",
            data: {"CasoBusqueda" : CasoBusqueda,"fechaMermaInicio" : fechaMermaInicio,"fechaMermaFin" : fechaMermaFin},
            url: "ajax_consultaEstatusPeticionesAsistenciaParaMerma.php",
            dataType: "json", 
            async: false,
            success: function(response) {
                if (response.status == "success") {
                     for (var i = 0; i < response.datos.length; i++) {
                         var record = response.datos[i];
                         tablaEstatusPeticonesAsisMerma.push(record);
                     }
                     loadDataIntableEstatusPeticionMer(tablaEstatusPeticonesAsisMerma);
                     $("#tablaEstatusPeticionesMerma").show();
                     waitingDialog.hide();
                 } else {
                     var mensaje = response.message;
                     waitingDialog.hide();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
                waitingDialog.hide();
            }
        });
    }
 }

 var tablaEstatusPeticionMerma = null;

 function loadDataIntableEstatusPeticionMer(data) {
     if (tablaEstatusPeticionMerma != null) {
         tablaEstatusPeticionMerma.destroy();
     }
     tablaEstatusPeticionMerma = $('#tablaEstatusPeticionesMerma').DataTable({
         "language": {
             "emptyTable": "No hay registro disponible",
             "info": "Del _START_ al _END_ de _TOTAL_",
             "infoEmpty": "Mostrando 0 registros de un total de 0.",
             "infoFiltered": "(filtrados de un total de _MAX_ registros)",
             "infoPostFix": "(actualizados)",
             "lengthMenu": "Mostrar _MENU_ registros",
             "loadingRecords": "Cargando....",
             "processing": "Procesando....",
             "search": "Buscar:",
             "searchPlaceholder": "Dato para buscar",
             "zeroRecords": "no se han encontrado coincidencias",
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
         {  
             "data": "idEmpleado"
         },
         {  
             "data": "NombreEmpleado"
         },
         {  
             "data": "IncidenciaFinal"
         },
         {  
             "data": "PuntoServicio"
         },
         {  
             "data": "idPlantillaServicioM"
         }, 
         {  
             "data": "tipoPeriodo"
         },
         {  
             "data": "EntidadF"
         },
         {  
             "data": "LineaNegocio"
         },
         {  
             "data": "FechaDelRegistro"
         },
         {  
             "data": "tipoIncidenciaPeticionM"
         },
         {  
             "data": "idSupervisor"
         },
         {  
             "data": "NombreSupervisor"
         },
         {  
             "data": "ComentarioSupervisor"
         },
         {  
             "data": "ComentarioDecline"
         },
         {  
             "data": "EstatusPeticion"
         }, ],
         processing: true,
         dom: 'Bfrtip',

          buttons: {
        buttons: ['excel']
    }
         
     });
 }

 

 </script>