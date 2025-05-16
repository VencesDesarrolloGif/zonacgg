$("#fechaInicioHisMov").focus(function (){
   $("#opcionconsultahidden").val("1");
   $("#NumEmpleadoCosHistoMov").val(""); 
});

$("#fechaFinHisMov").focus(function (){
    $("#opcionconsultahidden").val("1");
    $("#NumEmpleadoCosHistoMov").val("");
});

$("#NumEmpleadoCosHistoMov").focus(function (){
    $("#opcionconsultahidden").val("2");
    $("#fechaInicioHisMov").val(""); 
    $("#fechaFinHisMov").val(""); 
});
function ConsultaHistoricoMovimientosFiniquitoPago11(){
    var fechaInicioHisMov = $("#fechaInicioHisMov").val();
    var fechaFinHisMov = $("#fechaFinHisMov").val();
    var NumEmpleadoCosHistoMov = $("#NumEmpleadoCosHistoMov").val();
    var opcion = $("#opcionconsultahidden").val();

    if(fechaInicioHisMov == "" && fechaFinHisMov == "" && NumEmpleadoCosHistoMov == ""){
        // swal("Alto","Ingresa el rango de fechas o el número de empleado que desea buscar","");
        swal.fire({ icon: 'warning', title: 'Alto', text: 'Ingresa el rango de fechas o el número de empleado que desea buscar' });
    }else if(fechaInicioHisMov>fechaFinHisMov){
        // swal("Alto","La fecha de inicio no puede ser mayor a la fecha fin","");
        swal.fire({ icon: 'warning', title: 'Alto', text: 'La fecha de inicio no puede ser mayor a la fecha fin' });
    }else if(fechaInicioHisMov == "" && fechaFinHisMov == "" && NumEmpleadoCosHistoMov == ""){
        // swal("Alto","Ingresa el rango de fechas o el número de empleado que desea buscar","");
        swal.fire({ icon: 'warning', title: 'Alto', text: 'Ingresa el rango de fechas o el número de empleado que desea buscar' });
    }else{
        listaTable  ="<table class='table table-hover' ><thead><th>Departamento</th><th>Nomenclatura</th><th>Color</th></thead><tbody>";
        listaTable += "<tr><td>GENERADO</td><td>S/N</td><td  style='color: rgb(15,195,235);'>AZUL</td></tr><tr><td>LIDER DE UNIDAD</td><td>LU</td><td  style='color: rgb(255,0,0);'>ROJO</td></tr><tr>";
        listaTable += "<tr><td>FINANZAS</td><td>FI</td><td style='color: rgb(255,155,0);'>NARANJA</td></tr>";
        listaTable += "<tr><td>TERMINADO</td><td>S/N</td><td style='color: rgb(4,139,20);'>VERDE</td></tr>";
        listaTable += "</tbody></table>";
        $('#tablanomeclaturaAA').html(listaTable);
        waitingDialog.show();
        historicoMovFiniPago = [];
        $.ajax({
            type: "POST",
            url: "HistoricoMovimientosFiniquitosPago/ajax_ConsultaHistoricoMovimientosFiniquitoPago.php",
            data: {"fechaInicioHisMov":fechaInicioHisMov,"fechaFinHisMov":fechaFinHisMov,"NumEmpleadoCosHistoMov":NumEmpleadoCosHistoMov,"opcion":opcion}, 
            dataType: "json",
            async: false,
            success: function(response) {
                if(response.status == "success") {
                   for (var i = 0; i < response.datos.length; i++) {
                        var record = response.datos[i];
                        historicoMovFiniPago.push(record);
                    }
                    loadDataIntableHisotricoMovimientosFiniPago(historicoMovFiniPago);
                    $("#tablaHistoricoMovimientosFiniquitoPago").show();
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
}
 var tablaDeHistoricoFiniquitosEnPago = null;

 function loadDataIntableHisotricoMovimientosFiniPago(data) {
    if(tablaDeHistoricoFiniquitosEnPago != null) {
        tablaDeHistoricoFiniquitosEnPago.destroy();
    }
    tablaDeHistoricoFiniquitosEnPago = $('#tablaHistoricoMovimientosFiniquitoPago').DataTable({
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
             "data": "nombreEntidadFederativa"
         },
         {   
             "data": "FechaBaja"
         },
         {   
             "data": "NumerodminBaja"
         },
         {   
             "data": "NombreAdminBaja"
         },
         {   
             "data": "EstatusAnterior"
         },
         {   
             "data": "EstatusActual"
         },
         {   
             "data": "fechamovimiento"
         },
         {   
             "data": "docComprovante"
         },
         {   
             "data": "edicionDocComprovante"
         },
         {   
             "data": "fechaEditDocComprobante"
         },
          ],
         processing: true,
         dom: 'Bfrtip',
         buttons: {
         buttons: ['excel',{orientation:'landscape',extend:'pdf',pageSize:'LEGAL'}]

         }

        });
 } 

function abrirPdfcomprobanteFinanzas(nombreDoc){
    window.open("uploads/comprobantesPagoFiniquitos/"+nombreDoc);

}

function abrirModalFirma(idFiniquito,nameDocComprobante,NumeroEmpleado,NombreEmpleado){
    $("#modalFirmaElectronicaEditHistorico").modal();
    $("#idFiniquitoEdit").val(idFiniquito);
    $("#nameDocumentEdit").val(nameDocComprobante);
    $("#NumeroEmpleadoEdit").val(NumeroEmpleado);
    $("#NombreEmpleadoEdit").val(NombreEmpleado);
}

function consultarUsuario(){

    $.ajax({
            type: "POST",
            url: "HistoricoMovimientosFiniquitosPago/ajax_consultaUsr.php",
            dataType: "json",
            success: function(response) {
                var rol=response.rol;
                if (rol=='Finanzas' || rol=='Tesoreria'){
                    abrirModalEdicion();
                }else{
                    swal.fire({ icon: 'error', title: 'Alto', text: 'No cuentas con los permisos para editar este documento' });
                }
                
            },error: function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText);
            }
        });
}

function abrirModalEdicion(){
// alert("entre");
    $("#ModalEditPdfComprobantePago").modal();
}

$("#btnCancelarComprobanteEdit").click(function(){
    $("#idFiniquitoEdit").val(""); 
    $("#nameDocumentEdit").val(""); 
    $("#NumeroEmpleadoEdit").val("");
    $("#NombreEmpleadoEdit").val("");
    $('#ModalEditPdfComprobantePago').modal('hide');
});

$("#btnGuardarComprobanteEdit").click(function(){
    
    var idFiniquito = $("#idFiniquitoEdit").val(); 
    var nameDocumentEdit = $("#nameDocumentEdit").val(); 
    var NumEmpModalFirmaEdit = $("#NumEmpModalFirmaEdit").val(); 
    var constraseniaFirmaEdit = $("#constraseniaFirmaEditHidden").val();

    var archivoEditComprobantePago = $("#archivoEditComprobantePago").val();
    var formData = new FormData($("#formEditComprobantePago")[0]);
    formData.append('nameDocumentEdit', nameDocumentEdit);
    formData.append('idFiniquito', idFiniquito);
    formData.append('NumEmpModalFirmaEdit', NumEmpModalFirmaEdit);
    formData.append('constraseniaFirmaEdit', constraseniaFirmaEdit);

    if(archivoEditComprobantePago!=""){
        $.ajax({
            type: "POST",
            url: "HistoricoMovimientosFiniquitosPago/ajax_CargarArchivoEditComprobantePago.php",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            async:false, 
            success: function(response) {
                var mensaje=response.message;
                if (response.status=="success"){
                    $("#archivoEditComprobantePago").val("");
                    swal.fire({ icon: 'success', title: 'Listo', text: 'Edición realizada con éxito' });
                    ConsultaHistoricoMovimientosFiniquitoPago11();
                    $("#idFiniquitoEdit").val(""); 
                    $("#nameDocumentEdit").val(""); 
                    $("#NumeroEmpleadoEdit").val("");
                    $("#NombreEmpleadoEdit").val("");
                    $('#ModalEditPdfComprobantePago').modal('hide');
                }else if(response.status=="error"){
                    swal.fire({ icon: 'error', title: 'Alto', text: mensaje });
                }
            },error: function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText);
            }
        });
    }else{
        swal.fire({ icon: 'error', title: 'Alto', text: 'Error Selecciona un archivo para cargar' });
    }
});

$("#btnCancelarFirmaEdit").click(function(){
    $("#NumEmpModalFirmaEdit").val(""); 
    $("#constraseniaFirmaEdit").val(""); 
    $('#modalFirmaElectronicaEditHistorico').modal('hide');
});

$("#btnFirmarEdit").click(function(){
    RevisarFirmaInternaEditComprobantePago();
});


function RevisarFirmaInternaEditComprobantePago(){//firma de almacen
  var NumEmpModalBaja  =$("#NumEmpModalFirmaEdit").val();
  var constraseniaFirma=$("#constraseniaFirmaEdit").val();
 
 if(NumEmpModalBaja==""){
   cargaerroresFirmaInternaEdit("El numero de empleado no puede estar vacio");
  }else if(constraseniaFirma==""){
     cargaerroresFirmaInternaEdit("Escriba la contraseña para continuar");
  }else{
    $.ajax({
      type: "POST",
      url: "ajax_getFirmaSolicitada.php",
      data: {"NumEmpModalBaja":NumEmpModalBaja,"constraseniaFirma":constraseniaFirma},
      dataType: "json",
      success: function(response) {
      if(response.status == "success"){
          var RespuestaLargo = response["datos"].length;
          if(RespuestaLargo == "0"){
             cargaerroresFirmaInternaEdit("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingresó en el registro");
            }else{
              // var nombre = response.datos["0"].nombreEmpleado + " " + response.datos["0"].apellidoPaterno + " " + response.datos["0"].apellidoMaterno;
              var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
              $("#constraseniaFirmaEditHidden").val(contraseniaInsertadaCifrada);
              $("#modalFirmaElectronicaEditHistorico").modal("hide");
              consultarUsuario();
            }//else
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
  }
}

function cargaerroresFirmaInternaEdit(mensaje){
  $('#errorModalFirmaEditHistorico1').fadeIn();
  msjerrorbaja="<div id='errorModalFirmaEditHistorico1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errorModalFirmaEditHistorico").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errorModalFirmaEditHistorico1').delay(4000).fadeOut('slow'); 
} 