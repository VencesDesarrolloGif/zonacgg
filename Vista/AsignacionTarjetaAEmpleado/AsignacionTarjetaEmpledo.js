function obtenerSucursalReporteTarjetaDes(){
    $("#divTableDatosMovimientosTarjetaAEmpleados").hide();
    $("#DivEjercicio").hide();
    waitingDialog.show();
    $.ajax({
        type: "POST",
        url: "AsignacionTarjetaAEmpleado/ajax_ObtenerSucursalesTarjetaDesp.php",
        dataType: "json",
        success: function(response) {
         // console.log(response);
            var datos = response.datos;
            $('#selectSucursalReporteTarjetaDes').empty().append('<option value="0" selected="selected">Sucursales</option>');
            $.each(datos, function(i) {
                $('#selectSucursalReporteTarjetaDes').append('<option value="' + response.datos[i].idSucursalI+ '">' + response.datos[i].nombreSucursal + '</option>');
            }); 
            $("#DivSucursalReporteTarjetaDes").show();
            $("#DivFehcaInicioReporteTarjetaDes").show();
            $("#InputFechaInicioReporteTarjetaDes").val("");
            $("#InputFechaFinReporteTarjetaDes").val("");
            waitingDialog.hide();     
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();     
        }
    }); 
}

 $("#selectSucursalReporteTarjetaDes").change(function()
  {
    var SucursalReporteTarjetaDes =$("#selectSucursalReporteTarjetaDes").val();
    var FechaInicioReporteTarjetaDes =$("#InputFechaInicioReporteTarjetaDes").val();
    var FechaFinReporteTarjetaDes =$("#InputFechaFinReporteTarjetaDes").val();
    if((SucursalReporteTarjetaDes == "0") && (FechaInicioReporteTarjetaDes=="" || FechaFinReporteTarjetaDes=="")){
        $("#divBotonBuscar").hide();
    }else{
        $("#divBotonBuscar").show();
    }
});

$("#InputFechaInicioReporteTarjetaDes").change(function()
  {
    var SucursalReporteTarjetaDes =$("#selectSucursalReporteTarjetaDes").val();
    var FechaInicioReporteTarjetaDes =$("#InputFechaInicioReporteTarjetaDes").val();
    var FechaFinReporteTarjetaDes =$("#InputFechaFinReporteTarjetaDes").val();
    if((SucursalReporteTarjetaDes == "0") && (FechaInicioReporteTarjetaDes=="" || FechaFinReporteTarjetaDes=="")){
        $("#divBotonBuscar").hide();
    }else{
        $("#divBotonBuscar").show();
    }
});

$("#InputFechaFinReporteTarjetaDes").change(function()
  {
    var SucursalReporteTarjetaDes =$("#selectSucursalReporteTarjetaDes").val();
    var FechaInicioReporteTarjetaDes =$("#InputFechaInicioReporteTarjetaDes").val();
    var FechaFinReporteTarjetaDes =$("#InputFechaFinReporteTarjetaDes").val();
    if((SucursalReporteTarjetaDes == "0") && (FechaInicioReporteTarjetaDes=="" || FechaFinReporteTarjetaDes=="")){
        $("#divBotonBuscar").hide();
    }else{
        $("#divBotonBuscar").show();
    }
});

$("#BuscarMovimientosTjDespensa").click(function(){
    $("#divTableDatosMovimientosTarjetaAEmpleados").hide();
    var SucursalReporteTarjetaDes =$("#selectSucursalReporteTarjetaDes").val();
    var FechaInicioReporteTarjetaDes =$("#InputFechaInicioReporteTarjetaDes").val();
    var FechaFinReporteTarjetaDes =$("#InputFechaFinReporteTarjetaDes").val();
    var Bandera = 0;
    if((SucursalReporteTarjetaDes!="0") && (FechaInicioReporteTarjetaDes =="" || FechaFinReporteTarjetaDes =="")){
        alert("Busqueda Por SUCURSAL");
        Bandera="1";
    }else if((SucursalReporteTarjetaDes!="0") && (FechaInicioReporteTarjetaDes !="" || FechaFinReporteTarjetaDes !="")){
        alert("Busqueda Por SUCURSAL Y FECHAS");
        Bandera="2";
    }else if((SucursalReporteTarjetaDes=="0") && (FechaInicioReporteTarjetaDes !="" || FechaFinReporteTarjetaDes !="")){
        alert("Busqueda Por FECHAS");
        Bandera="3";
    }else{
        alert("Seleccione Algun Criterio De Busqueda");
        Bandera="0";
    }
    if(Bandera!="0"){
        if(Bandera != "1"){
            if(FechaInicioReporteTarjetaDes > FechaFinReporteTarjetaDes){
                alert("La Fecha Fin No Puede Ser Mayor Que La Fecha De Inicio");
            }else{
                ConsultaMovimientoEntregaTarjetaDespensa(Bandera);
            }
        }else{
            ConsultaMovimientoEntregaTarjetaDespensa(Bandera);
        }
    }

});

 function ConsultaMovimientoEntregaTarjetaDespensa(Bandera){ 
    var SucursalReporteTarjetaDes =$("#selectSucursalReporteTarjetaDes").val();
    var FechaInicioReporteTarjetaDes =$("#InputFechaInicioReporteTarjetaDes").val();
    var FechaFinReporteTarjetaDes =$("#InputFechaFinReporteTarjetaDes").val();
    waitingDialog.show();
    estatusTarjetaDespensaEntregaEmpleado = [];
    $.ajax({
        type: "POST",
        url: "AsignacionTarjetaAEmpleado/ajax_MovimientosEntregaDeTarjetaDespensaAEmpelados.php",
        data: {"Bandera":Bandera,"SucursalReporteTarjetaDes":SucursalReporteTarjetaDes,"FechaInicioReporteTarjetaDes":FechaInicioReporteTarjetaDes,"FechaFinReporteTarjetaDes":FechaFinReporteTarjetaDes},
        dataType: "json",
        success: function(response) {
            if(response.status == "success") {
               for (var i = 0; i < response.datos.length; i++) {
                    var record = response.datos[i];
                    estatusTarjetaDespensaEntregaEmpleado.push(record);
                }
                loadDataIntableMovimientoEntregaEmpleadoTarjetaDespensa(estatusTarjetaDespensaEntregaEmpleado);
                $("#divTableDatosMovimientosTarjetaAEmpleados").show();
                waitingDialog.hide();
            }else{
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
 var tablaDeMovimientosTarjetaEntregaEmpleado = null;

 function loadDataIntableMovimientoEntregaEmpleadoTarjetaDespensa(data) {
    if(tablaDeMovimientosTarjetaEntregaEmpleado != null) {
        tablaDeMovimientosTarjetaEntregaEmpleado.destroy();
    }
    tablaDeMovimientosTarjetaEntregaEmpleado = $('#TableDatosMovimientosTarjetaAEmpleados').DataTable({
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
             "data": "Sucursal"
         }, 
         {  
             "data": "idIutTarjeta"
         }, 
         {   
             "data": "NumeroEmpleado"
         }, 
         {   
             "data": "NombreEmpleado"
         }, 
         {   
             "data": "NumeroAsigno"
         }, 
         {   
             "data": "NombreAsigno"
         },
         {   
             "data": "ContraseniaFirmaAsignoAlElemento"
         },
         {   
             "data": "FechaASignacionEmpleado"
         },
         {   
             "data": "usuarioQueAsignoAlElemento"
         },
         {   
             "data": "EstatusTarjeta"
         },
          ],
         processing: true,
         dom: 'Bfrtip',
         buttons: {
            buttons: ["excel"]
         }

        });
 }  