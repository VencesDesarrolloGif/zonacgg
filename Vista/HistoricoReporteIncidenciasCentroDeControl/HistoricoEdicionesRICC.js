$('#btnconsultarHistoricoRICC').click(function() {

    var inicioFecha=$("#SelectInicioFecha").val();
    var finFecha=$("#SelectFinFecha").val();
    if(inicioFecha=='' || finFecha==''){
        swal("Alto", "SELECCIONE FECHAS VALIDAS","error");

    }else{
          ConsultaHistoricoEdicionestablaReporteIncidenciasCentroDeControl(inicioFecha,finFecha);
    }
});

function ConsultaHistoricoEdicionestablaReporteIncidenciasCentroDeControl(inicioFecha,finFecha){ 

    historicotablaEditReporteIncidenciasCentroDeControl = [];
    $.ajax({
        type: "POST",
        url: "HistoricoReporteIncidenciasCentroDeControl/ajax_ConsultaEdicionesReporteIncidenciasCentroDeControl.php",
        data:{inicioFecha,finFecha},
        dataType: "json",
        success: function(response) {
            if(response.status == "success") {
                $("#tablaEditReporteIncidenciasCentroDeControl").show();
               for (var i = 0; i < response.datos.length; i++) {
                    var record = response.datos[i];
                    historicotablaEditReporteIncidenciasCentroDeControl.push(record);
                }
                loadDataIntableHistoricoEdicionesRICC(historicotablaEditReporteIncidenciasCentroDeControl);
            }else{
                var mensaje = response.message;
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }
 var tablaDetablaEditReporteIncidenciasCentroDeControl = null;

 function loadDataIntableHistoricoEdicionesRICC(data) {
    if(tablaDetablaEditReporteIncidenciasCentroDeControl != null) {
        tablaDetablaEditReporteIncidenciasCentroDeControl.destroy();
    }
    tablaDetablaEditReporteIncidenciasCentroDeControl = $('#tablaEditReporteIncidenciasCentroDeControl').DataTable({
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
             "data": "idinciIdenciaCCEdit"
         },
         {  
             "data": "DescripcionTipoIncidencia"
         }, 
         {   
             "data": "NumeroSupervisor"
         }, 
         {   
             "data": "NombreSupervisor"
         }, 
         {   
             "data": "NumeroEmpleado"
         },
         {   
             "data": "NombreEmpelado"
         },  
         {   
             "data": "EntidadFederativa"
         },
         {   
             "data": "Punto"
         },
         {   
             "data": "EmpleadoEditRegIncidenciaCC"
         },
         {   
             "data": "FechaDeEdición"
         },
         {   
             "data": "descripcionEstatus"
         },
          ],
         processing: true,
         dom: 'Bfrtip',
         buttons: ['excel',{orientation:'landscape',extend:'pdf',pageSize:'LEGAL',title: 'HISTORICO EDICIONES REPORTE DE INCIDENCIAS'}]

        });
 }