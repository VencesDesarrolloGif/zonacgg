 $(document).ready(function() {
 //ConsultaEstatusMovimientoTarjetaDespensa();
 });

 function obtenerEjercciosParaConsulta(){
    $("#DivFehcaInicio").hide();
    $("#TableArchivoASignarTitulares").hide();
    $("#DivEjercicio").hide();
    waitingDialog.show();
    $.ajax({
        type: "POST",
        url: "EstatusMovimientoTarjetaDespensa/ajax_obtenerEjercciosParaConsulta.php",
        dataType: "json",
        success: function(response) {
         // console.log(response);
            var datos = response.datos;
            $('#selectEjercicioT').empty().append('<option value="0" selected="selected">Ejercicio</option>');
            $.each(datos, function(i) {
                $('#selectEjercicioT').append('<option value="' + response.datos[i].IdAnio+ '">' + response.datos[i].DescAnio + '</option>');
            }); 
            $("#DivEjercicio").show();
            waitingDialog.hide();     
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();     
        }
    }); 

 }

 $("#selectEjercicioT").change(function()
  {
    var EjercicioT =$("#selectEjercicioT").val();
    if(EjercicioT == "0" || EjercicioT == "" || EjercicioT == "null" || EjercicioT == "NULL" || EjercicioT == null){
        alert("Seleccione El Ejercicio A Consultar");
    }else{
        $("#TableArchivoASignarTitulares").hide();
        obtenerFehcaInicioCansultaTarj(EjercicioT);
    }
});

 function obtenerFehcaInicioCansultaTarj(EjercicioT){
    waitingDialog.show();
    $("#FechaFin").val("");
    $.ajax({
        type: "POST",
        url: "EstatusMovimientoTarjetaDespensa/ajax_obtenerFehcaInicioCansultaTarj.php",
        data: {"EjercicioT":EjercicioT},
        dataType: "json",
        success: function(response) {
         // console.log(response);
            var datos = response.datos;
            $('#selectFehcaInixioTarj').empty().append('<option value="0" selected="selected">Fecha</option>');
            $.each(datos, function(i) {
                $('#selectFehcaInixioTarj').append('<option value="' + response.datos[i].IdRango +"_"+ response.datos[i].FechaFinP+ '">' + response.datos[i].FechaInicioP + '</option>');
            }); 
            $("#DivFehcaInicio").show();
            waitingDialog.hide();     
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();     
        }
    }); 

 }

  $("#selectFehcaInixioTarj").change(function()
  {
    var FechaInicio= $('select[name="selectFehcaInixioTarj"] option:selected').text(); 
    var fehcaInixioTarj =$("#selectFehcaInixioTarj").val();
    var splitFecha = fehcaInixioTarj.split("_");
    var FechaFin = splitFecha[1];
    $("#FechaFin").val(FechaFin);
    if(fehcaInixioTarj == "0" || fehcaInixioTarj == "" || fehcaInixioTarj == "null" || fehcaInixioTarj == "NULL" || fehcaInixioTarj == null){
        alert("Seleccione La Fecha De Inicio Para Continuar");
    }else{
        ConsultaEstatusMovimientoTarjetaDespensa(FechaInicio,FechaFin);
    }
});

 function ConsultaEstatusMovimientoTarjetaDespensa(FechaInicio,FechaFin){ 
    waitingDialog.show();
    estatusTarjetaDespensa = [];
    $.ajax({
        type: "POST",
        url: "EstatusMovimientoTarjetaDespensa/ajax_EstatusMovimientoTarjetaDespensa.php",
        data: {"FechaInicio":FechaInicio,"FechaFin":FechaFin},
        dataType: "json",
        success: function(response) {
            if(response.status == "success") {
               for (var i = 0; i < response.datos.length; i++) {
                    var record = response.datos[i];
                    estatusTarjetaDespensa.push(record);
                }
                loadDataIntableEstatusMovimientoTarjetaDespensa(estatusTarjetaDespensa);
                $("#TableArchivoASignarTitulares").show();
                waitingDialog.hide();
            }else{
                var mensaje = response.message;
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }
 var tablaDeMovimientosTarjeta = null;

 function loadDataIntableEstatusMovimientoTarjetaDespensa(data) {
    if(tablaDeMovimientosTarjeta != null) {
        tablaDeMovimientosTarjeta.destroy();
    }
    tablaDeMovimientosTarjeta = $('#tablaestatusTarjetaDespensa').DataTable({
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
             "data": "NumeroEmpleadoInt"
         }, 
         {  
             "data": "LuegarEntrega"
         }, 
         {   
             "data": "NumeroEmpleado"
         }, 
         {   
             "data": "NombreEnTarjeta"
         }, 
         {   
             "data": "IutTarjeta"
         }, 
         {   
             "data": "NombreEmpleado"
         },
         {   
             "data": "ApellidoPaterno"
         },
         {   
             "data": "ApelliMaterno"
         },
         {   
             "data": "RfcEmpleado"
         },
         {   
             "data": "CurpEmpleado"
         },
         {   
             "data": "SeguroEmpleado"
         },
         {   
             "data": "TelefonoEmpleado"
         },
         {   "className": "dt-body-center",
             "data": "CorreoEmpleado"
         },
          ],
         processing: true,
         dom: 'Bfrtip',
         buttons: {
            buttons: ["excel"]
         }

        });
 }  