$("#btnConsultarPendientesCRP").click(function(){
      consultarPendientesCRP(); 
});

 function consultarPendientesCRP(){ 
    waitingDialog.show();
    tablapendientesCRP = [];
    $.ajax({
        type: "POST",
        url: "pendientesCambioRP/ajax_ConsultaPendientesCRP.php",
        data:{},
        dataType: "json",
        success: function(response) {
            console.log(response);
            if(response.status == "success") {
                waitingDialog.hide();
                $("#tablaPendientesCRP").show();
                var largo = response.datos.length;

                for(var i = 0; i < largo; i++){
                    var record = response.datos[i];
                    tablapendientesCRP.push(record);
                }
                loadDataIntablePendientesCRP(tablapendientesCRP);
            }else{
                waitingDialog.hide();
                var mensaje = response.message;
                cargarmensajePendientesCRP(mensaje, "error");
                $("#tablaPendientesCRP").hide();
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
                waitingDialog.hide();
                alert(jqXHR.responseText);
                $("#tablaPendientesCRP").hide();
         }
     });
 }
 var tablaDeDetalleCobertura = null;

 function loadDataIntablePendientesCRP(data) {
    if(tablaDeDetalleCobertura != null) {
        tablaDeDetalleCobertura.destroy();
    }

    var titulo = "Pendientes Cambio RP";
    tablaDeDetalleCobertura = $('#tablaPendientesCRP').DataTable({
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
             "data": "numeroEmpleado"
         }, 
         {   
             "data": "nombreEmpleado"
         }, 
         {   
             "data": "registroPatronal"
         }, 
         {   
             "data": "rpParaActualizar"
         }, 
         {   
             "data": "puntoServicio"
         },
         {   
             "data": "nombreEntidadFederativa"
         },
         {   
             "data": "cambiarRP"
         },
         {   
             "data": "rechazarCRP"
         },
          ],
         processing: true,
         dom: 'Bfrtip',
         buttons: ['excel',{orientation:'landscape',extend:'pdf',title: titulo ,pageSize:'LEGAL'}]
        });
 }


function cancelarCRP(entidad,consecutivo,categoria){

    $.ajax({
        type: "POST",
        url: "pendientesCambioRP/ajax_RechazarCRP.php",
        data:{entidad,consecutivo,categoria},
        dataType: "json",
        success: function(response) {
            if(response.status == "success") {
                waitingDialog.hide();
                var mensaje = response.message;
                cargarmensajePendientesCRP(mensaje, "success");
                consultarPendientesCRP();
            }else{
                waitingDialog.hide();
                var mensaje = response.message;
                cargarmensajePendientesCRP(mensaje, "error");
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
                waitingDialog.hide();
                alert(jqXHR.responseText);
                $("#tablaPendientesCRP").hide();
         }
     });
}

function consultarRegistrosPatronales(entidadFederativaEmp,empleadoConsecutivoEmp,empleadoCategoriaEmp,registroPatronalEmp,numeroEmpleado,rpParaActualizarEmp,nombreEmpleado){

    nombreEmpleado = nombreEmpleado.replace(/-/gi," ");

    $.ajax({
            type: "POST",
            url: "pendientesCambioRP/ajax_ConsultaRegistrosPatronales.php",
            dataType: "json",
            success: function(response) {
            $("#selectRPmodal").empty(); 
            $('#selectRPmodal').append('<option value="0">REGISTRO PATRONAL</option>');
        if(response.status == "success"){
           for(var i = 0; i < response.datos.length; i++){

               var registroCatalogo= response.datos[i]["idcatalogoRegistrosPatronales"];

               if(registroPatronalEmp==registroCatalogo){
                     $('#selectRPmodal').append('<option value="' + (registroCatalogo) + '" selected>' + registroCatalogo + '</option>');
               }else{
                     $('#selectRPmodal').append('<option value="' + (registroCatalogo) + '">' + registroCatalogo + '</option>');
               }
              }

            $('#noEmpModal').val(numeroEmpleado);
            $('#nombreEmpModal').val(nombreEmpleado);
            $('#registroPSugeridoModal').val(rpParaActualizarEmp);
            $('#modalCRP').modal();
          }else{
                alert("Error Al Cargar Las Entidades");
               }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
}

function actualizarRP(){

    var noEmpCompleto=$('#noEmpModal').val();
    var registroPatronalElegido=$('#selectRPmodal').val();

    $.ajax({
            type: "POST",
            url: "pendientesCambioRP/ajax_ActualizarRP.php",
            data:{noEmpCompleto,registroPatronalElegido},
            dataType: "json",
            success: function(response) {
            if(response.status == "success"){
               $('#modalCRP').modal('hide');
               var mensaje = response.message;
               cargarmensajePendientesCRP(mensaje, "success");
               consultarPendientesCRP();
            }else{
                  alert("Error Al Cargar Las Entidades");
            }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });

}

function cargarmensajePendientesCRP(mensaje,status){
  $('#msgCRP').fadeIn('slow');
  mensajeAmostrar="<div id='msgAlert' class='alert alert-"+status+"'>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
  $("#msgCRP").html(mensajeAmostrar);
  $(document).scrollTop(0);
  $('#msgCRP').delay(3000).fadeOut('slow');
}