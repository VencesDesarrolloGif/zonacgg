// $(document).ready(function() {
    // $("#tablaFotosVehiculosApp").hide(); 
// });


$("#btnConsultarFotosVehiculosApp").click(function(event) {

    var FechaInicioFotosVehiculosApp =$("#FechaInicioFotosVehiculosApp").val();
    var FechaFinalFotosVehiculosApp =$("#FechaFinalFotosVehiculosApp").val();
    if(FechaInicioFotosVehiculosApp == ""){
        CargarMensajeFotoVehiculoApp("Debes ingresar la fecha INICIAL","error");
        $("#tablaFotosVehiculosApp").hide();
    }else if(FechaFinalFotosVehiculosApp == ""){
        CargarMensajeFotoVehiculoApp("Debes ingresar la fecha FINAL","error");
        $("#tablaFotosVehiculosApp").hide();
    }else if(FechaInicioFotosVehiculosApp>FechaFinalFotosVehiculosApp){
        CargarMensajeFotoVehiculoApp("La fecha inicial no puede ser mayor a la fecha final","error");
        $("#tablaFotosVehiculosApp").hide();
    }else{
        $("#tablaFotosVehiculosApp").hide();
        waitingDialog.show();
        fotosVehiculoAp = [];
        $.ajax({
            type: "POST",
            url: "RevistaFotosVehiculosApp/ajax_ConsultaFotosVehiculosApp.php",
            data: {"FechaInicio":FechaInicioFotosVehiculosApp,"FechaFinal":FechaFinalFotosVehiculosApp},
            dataType: "json",
            success: function(response) {
                if(response.status == "success") {
                   for (var i = 0; i < response.datos.length; i++) {
                        var record = response.datos[i];
                        fotosVehiculoAp.push(record);
                    }
                    loadDataIntableFotosVehiculosApp(fotosVehiculoAp);
                    waitingDialog.hide();
                    $("#tablaFotosVehiculosApp").show();
                }else{
                    var mensaje = response.message;
                    CargarMensajeFotoVehiculoApp(mensaje,"error");
                    waitingDialog.hide();
                }
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
                 waitingDialog.hide();
             }
         });
        }

});

 var tablaDeFotosVehiculosApp = null;

 function loadDataIntableFotosVehiculosApp(data) {
    if(tablaDeFotosVehiculosApp != null) {
        tablaDeFotosVehiculosApp.destroy();
    }
    tablaDeFotosVehiculosApp = $('#tablaFotosVehiculosApp').DataTable({
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
             "data": "NumeroEmpleado"
         }, 
         {   
             "data": "NombreEmpleado"
         }, 
         {   
             "data": "Placa"
         }, 
         {   
             "data": "Color"
         }, 
         {  
             "data": "Marca"
         },
         {   
             "data": "Modelo"
         },  
         {  
             "data": "Anio"
         },
         {  
             "data": "Cilindrada"
         },
         {  
             "data": "Fecha"
         },
         {  
             "data": "Ruta1"
         },
         {  
             "data": "Ruta2"
         },
         {  
             "data": "Ruta3"
         },
         {  
             "data": "Ruta4"
         },
          ],
         processing: true,
         dom: 'Bfrtip',
         buttons: {
            buttons: ['excel']
         }

        });
 } 

 function CargarMensajeFotoVehiculoApp(mensaje,Tipo){
  $('#MensajeFotosVehiculosApp1').fadeIn();
  msjerrorbaja="<div id='MensajeFotosVehiculosApp1' class='alert alert-"+Tipo+"'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#MensajeFotosVehiculosApp").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#MensajeFotosVehiculosApp1').delay(4000).fadeOut('slow'); 
}  

function btnAbrirFotoVehiculoApp(ruta){
    window.open("../../Gif_App_Asistencia/"+ruta+"");  
}