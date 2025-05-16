function cancelarFirmaBajaPF(){
  $("#modalFirmaElectronicaProcesoFirma").modal("hide");
  $("#NumEmpModalPF").val("");
  $("#constraseniaFirmaPF").val("");
}

function cargaerroresFirmaInternaPF(mensaje){
  $('#errorModalFirmaInternaPF1').fadeIn();
  msjerrorbaja="<div id='errorModalFirmaInternaPF1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errorModalFirmaInternaPF").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errorModalFirmaInternaPF1').delay(4000).fadeOut('slow'); 
}  

function RevisarFirmaInternaPF(){//firma de almacen
  var NumEmpModalBaja  =$("#NumEmpModalPF").val();
  var constraseniaFirma=$("#constraseniaFirmaPF").val();
 
 if(NumEmpModalBaja==""){
   cargaerroresFirmaInternaPF("El numero de empleado no puede estar vacio");
  }else if(constraseniaFirma==""){
     cargaerroresFirmaInternaPF("Escriba la contraseña para continuar");
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
             cargaerroresFirmaInternaPF("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingresó en el registro");
            }else{
              var nombre = response.datos["0"].nombreEmpleado + " " + response.datos["0"].apellidoPaterno + " " + response.datos["0"].apellidoMaterno;
              var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
              var tipopuestoemp = $("#tipopuestoemp").val()
              $("#FirmaInternaPFhidden").val(contraseniaInsertadaCifrada);
              $("#modalFirmaElectronicaProcesoFirma").modal("hide");
              cargarDocumento();
            }
      }{
        $("#NumEmpModalPF").val("");
        $("#constraseniaFirmaPF").val("");
        $("#modalFirmaElectronicaProcesoFirma").modal("hide");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
  }
}

function ConsultaFiniquitosEnGestion(){ 
    waitingDialog.show();
    firmaFiniquito = [];
    $.ajax({
        type: "POST",
        url: "EstatusDePagoFiniquito/ajax_ConsultaFiniquitosEnGestion.php",
        dataType: "json",
        async: false,
        success: function(response) {
            if(response.status == "success") {
               for (var i = 0; i < response.datos.length; i++) {
                    var record = response.datos[i];
                    firmaFiniquito.push(record);
                }
                loadDataIntableFirmaFiniquitos(firmaFiniquito);
                $("#tablaGetionFiniquitos").show();
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
 var tablaDeGestiosFiniquito = null;

 function loadDataIntableFirmaFiniquitos(data) {
    if(tablaDeGestiosFiniquito != null) {
        tablaDeGestiosFiniquito.destroy();
    }
    tablaDeGestiosFiniquito = $('#tablaGetionFiniquitos').DataTable({
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
             "data": "abrirPdf"
         },
         {   
             "data": "checkvarios"
         },
         {   
             "data": "cargarArchivo"
         },
          ],
         processing: true,
         dom: 'Bfrtip',
         buttons: {
            buttons: []
         }

        });
 } 
function abrirPdfFiniquitoLider(numempleado, fechabaja, fechaalta) {
    window.open("../Nominas/finiquitos/generadordocfiniquito.php?numempleado=" + numempleado + "&" + "fechabaja=" + fechabaja + "&" + "fechaalta=" + fechaalta);
 }

 function abrirModalCargarArchivoGestionFiniquito(numempleado, idFiniquito,fechaBaja, fechaAlta,estatusActual) {
    $("#NumeroEmpleadoModalCargarArchivoGestionFini").val(numempleado); 
    $("#idFiniHidden").val(idFiniquito); 
    $("#fechaAltahidden").val(fechaAlta); 
    $("#fechaBajaHidden").val(fechaBaja); 
    $("#estatusActual").val(estatusActual); 
    $("#archivoGestionFini").val("");
    $("#ModalCargarArchivoGestionFini").modal(); 

 }

 $("#btnDescargaMultipleFiniquitosEnGestion").click(function(){
    var finiquitosSeleccionados = $( "input[type=checkbox]:checked");
    var LargofiniquitosSeleccionados = finiquitosSeleccionados.length; 
    if(LargofiniquitosSeleccionados < 2 ){
        // swal("Alto","Debes Seleccionar mas de un finiquito para usar esta opcion","waiting")
        swal.fire({ icon: 'waiting', title: 'Alto', text: 'Debes Seleccionar mas de un finiquito para usar esta opcion"'});

    }else{
            console.log(finiquitosSeleccionados);
        for (var i = 0; i < LargofiniquitosSeleccionados; i++)
        {
            var numeroEmpleado = $("#"+finiquitosSeleccionados[i].value).attr("numeroempleado");
            var empleadoFechaBaja = $("#"+finiquitosSeleccionados[i].value).attr("empleadoFechaBaja");
            var empleadoFechaAlta = $("#"+finiquitosSeleccionados[i].value).attr("empleadoFechaAlta");
            abrirPdfFiniquitoLider(numeroEmpleado, empleadoFechaBaja, empleadoFechaAlta);
            $("#"+finiquitosSeleccionados[i].value).prop("checked", false);  
        }
    }

});

$("#btnCargarGestionFini").click(function(){
    var archivoGestionFini = $("#archivoGestionFini").val();
    if(archivoGestionFini!=""){
        $("#ModalCargarArchivoGestionFini").modal("hide");
        $("#modalFirmaElectronicaProcesoFirma").modal();
    }else{
        swal.fire({ icon: 'error', title: 'Alto', text: 'Error Selecciona un archivo para cargar"'});
    }
});

function cargarDocumento(){
    var numempleado = $("#NumeroEmpleadoModalCargarArchivoGestionFini").val(); 
    var idFiniquito = $("#idFiniHidden").val(); 
    var fechaAlta = $("#fechaAltahidden").val(); 
    var fechaBaja = $("#fechaBajaHidden").val();
    var estatusActual = $("#estatusActual").val(); 

    var noEmp = $("#NumEmpModalPF").val(); 
    var firmaEmp = $("#FirmaInternaPFhidden").val(); 

    var formData = new FormData($("#formArchivoGestionFini")[0]);
    // alert(archivoGestionFini);
    formData.append('numempleado', numempleado);
    formData.append('idFiniquito', idFiniquito);
    formData.append('fechaAlta', fechaAlta);
    formData.append('fechaBaja', fechaBaja);
    formData.append('noEmp', noEmp);
    formData.append('firmaEmp', firmaEmp);

    // if(archivoGestionFini!=""){
        $.ajax({
            type: "POST",
            url: "EstatusDePagoFiniquito/ajax_CargarArchivoFiniquitoFirmado.php",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            async:false, 
            success: function(response) {
                console.log(response);
                var mensaje=response.message;
                if (response.status=="success"){
                    insertarHistoricoMovimientoFiniquitoPagoProcesoDeFirma(idFiniquito,estatusActual,3);
                    $("#NumeroEmpleadoModalCargarArchivoGestionFini").val(""); 
                    $("#idFiniHidden").val(""); 
                    $("#fechaAltahidden").val(""); 
                    $("#fechaBajaHidden").val("");
                    $("#archivoGestionFini").val("");
                    $('#ModalCargarArchivoGestionFini').modal('hide');
                    swal.fire({ icon: 'success', title: 'Listo', text: 'Solicitud enviada y finiquito cargado correctamente'});
                }else if(response.status=="error"){
                    swal.fire({ icon: 'error', title: 'Alto', text: 'Error al cargar comprobacio'});
                                    }
            },error: function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText);
            }
        });
    // }else{
        // swal.fire({ icon: 'error', title: 'Alto', text: 'Error Selecciona un archivo para cargar"'});
    // }

}

$("#btnCancelarGestionFini").click(function(){
    $("#NumeroEmpleadoModalCargarArchivoGestionFini").val(""); 
    $("#idFiniHidden").val(""); 
    $("#fechaAltahidden").val(""); 
    $("#fechaBajaHidden").val("");
    $("#archivoGestionFini").val("");
    $('#ModalCargarArchivoGestionFini').modal('hide');
});

 function insertarHistoricoMovimientoFiniquitoPagoProcesoDeFirma(idFiniquito,estatusActual,estatusNuevo) { 

    $.ajax({
        type: "POST",
        url: "EstatusDePagoFiniquito/ajax_insertarHistoricoMovimientoFiniquitoPago.php",
        data: {"idFiniquito":idFiniquito,"estatusActual":estatusActual,"estatusNuevo":estatusNuevo}, 
        dataType: "json",
        async: false,
        success: function(response) {
            var mensaje=response.message;
            if (response.status=="success"){
                ConsultaFiniquitosEnGestion();
            }else if(response.status=="error"){
                swal.fire({ icon: 'error', title: 'Alto', text: 'Error al procesar el retorno a proceso de validacion del finiquito"'});
            }
        },error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
        }
    }); 
 }