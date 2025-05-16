$(consultarSolicitudVehicularREADY());  

function btnVehiculoBaja(){
    Swal.fire({
        icon: 'warning',
        title: 'REACTIVA EL VEHICULO',
        text: 'Activalo en: Movimientos>consultar vehiculo>ingresa la placa>Reingresar vehiculo'
    });
};

function btnVehiculoNuevo(){
    Swal.fire({
        icon: 'warning',
        title: 'REGISTRA EL VEHICULO',
        text: 'Registralo en: Movimientos>Registrar vehiculo'
    });
};

$("#btnConsultarSolicitudesVehiculoSup").click(function(event){
    consultarSolicitudVehiculo();
});

function consultarSolicitudVehicularREADY(){
    solicitudesVehiculos = [];
    $.ajax({
            type: "POST",
            url: "solicitudPV/ajax_ConteoSolicitudes.php",
            dataType: "json",
            success: function(response) {
                if(response.status == "success") {
                    console.log(response);
                    var totalSolicitudes=response[0]["totalSolicitudes"];
                        if (totalSolicitudes!="0"){
                            var registrarVehicul= response[0]['registrarVehiculo'];
                            var activarVehiculo = response[0]['activarVehiculo'];  
                            var asignacionListo = response[0]['asignacionListo'];  
                            var vehiculoAsignado= response[0]['vehiculoAsignado']; 
                            Swal.fire({
                                icon: 'warning',
                                title: 'Tienes solicitudes pendientes',
                                html: '<div style="text-align: center;">' + 
                                      'Registrar vehiculo :' + registrarVehicul + '<br>' + 
                                      'Reactivar vehiculo :' + activarVehiculo + '<br>' +
                                      'Reasignar vehiculo:' + vehiculoAsignado + '<br>' +
                                      'Listo para Asignar  :' + asignacionListo +
                                      '</div>'
                            });



                        }
                }else{

                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
                 waitingDialog.hide();
            }
    });
}

function consultarSolicitudVehiculo(){
    solicitudesVehiculos = [];
    $.ajax({
            type: "POST",
            url: "solicitudPV/ajax_ConsultaSolicitudes.php",
            dataType: "json",
            success: function(response) {
                if(response.status == "success") {
                    var count=response.datos.length;
                   for (var i = 0; i < response.datos.length; i++){
                        var numeroEmpleado = response.datos[i]["NumeroEmpleado"];
                        // alert(numeroEmpleado);
                        if (numeroEmpleado=="SIN INFORMACIÓN"){
                            $("#msjSinSolicitudesPendientes").show();
                            $("#tablaSolicitudVehicular").hide();
                            if(tablaSolicitudesV != null) {
                               tablaSolicitudesV.destroy();
                            }
                            return;
                        }
                        var record = response.datos[i];
                        solicitudesVehiculos.push(record);
                    }
                    $("#tablaSolicitudVehicular").show();
                    loadDataIntableFotosVehiculosApp(solicitudesVehiculos);
                    waitingDialog.hide();
                    $("#tablaSolicitudVehicular").show();
                    $("#msjSinSolicitudesPendientes").hide();
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

 var tablaSolicitudesV = null;

 function loadDataIntableFotosVehiculosApp(data) {
    if(tablaSolicitudesV != null) {
        tablaSolicitudesV.destroy();
    }
    tablaSolicitudesV = $('#tablaSolicitudVehicular').DataTable({
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
             "data": "supervisor"
         }, 
         {   
             "data": "placaSolicitudSup"
         },
         {   
             "data": "kmSolicitudSup"
         }, 
         {   
             "data": "fechaSolicitudVehiculo"
         }, 
         {  
             "data": "imgFrontal"
         },
         {  
             "data": "imgDerecha"
         },
         {  
             "data": "imgIzquierda"
         },
         {  
             "data": "imgTrasera"
         },
         {   
             "data": "informacion"
         },  
         {  "classname": "dt-center",
             "data": "accion"
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

function btnAbrirFotoSolicitudVehiculo(ruta){
    window.open("uploads/"+ruta+"");  
}

function preguntaReasignación(idSolicitudVehiculo,tipoAsignacion,idvehiculo,placaSolicitudSup,entidadEmpleadoUsuario,consecutivoEmpleadoUsuario,categoriaEmpleadoUsuario,idEntidadTrabajo,empleadoEstatusId,descripcionPuesto,numlicencia,kmSolicitudSup){

    Swal.fire({
      title: '¿Estás seguro de querer reasignar el vehículo?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sí',
      cancelButtonText: 'No',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        btnConfirmarSolicitudVehiculo(idSolicitudVehiculo,tipoAsignacion,idvehiculo,placaSolicitudSup,entidadEmpleadoUsuario,consecutivoEmpleadoUsuario,categoriaEmpleadoUsuario,idEntidadTrabajo,empleadoEstatusId,descripcionPuesto,numlicencia,kmSolicitudSup);
      }else if (result.isDismissed) {
            Swal.close(); 
      }
    });

}

function btnConfirmarSolicitudVehiculo(idSolicitudVehiculo,tipoAsignacion,idvehiculo,placaSolicitudSup,entidadEmpleadoUsuario,consecutivoEmpleadoUsuario,categoriaEmpleadoUsuario,idEntidadTrabajo,empleadoEstatusId,descripcionPuesto,numlicencia,kmSolicitudSup){

    $.ajax({
            type: "POST",
            url: "solicitudPV/ajax_ActualizarSolicitud.php",
            data:{idSolicitudVehiculo,tipoAsignacion,idvehiculo,placaSolicitudSup,entidadEmpleadoUsuario,consecutivoEmpleadoUsuario,categoriaEmpleadoUsuario,idEntidadTrabajo,empleadoEstatusId,descripcionPuesto,numlicencia,kmSolicitudSup},
            dataType: "json",
            success: function(response) {
                if(response.status == "success") {
                    Swal.fire({
                      icon: 'success',
                      title: '¡Éxito!',
                      text: 'Solicitud generada con éxito',
                    });
                    consultarSolicitudVehiculo();
                }
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
                 waitingDialog.hide();
             }
    });
}