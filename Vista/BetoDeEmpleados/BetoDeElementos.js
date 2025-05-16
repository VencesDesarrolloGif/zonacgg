  function ConsultaElementosParaVetar(){ 
    var fechaInici = $("#fechaInicioDiasVetoEmpleado").val();  
    var fechaTermino = $("#fechaTerminoDisasVetoEmpleado").val();
    var bandera = "0";
    if(fechaInici=="" || fechaTermino==""){
        bandera = "0";
    }else if(fechaInici > fechaTermino){
        bandera = "";
        swal("Alto", "La fecha incio no puede ser mayor que la fecha fin", "error");   
    }else{
        bandera = "1";
    }
    if(bandera != ""){
        waitingDialog.show();
        elementosParaVetar = [];
        $.ajax({
            type: "POST",
            url: "BetoDeEmpleados/ajax_ConsultaElementosParaVetar.php",
            data:{"fechaInici":fechaInici,"fechaTermino":fechaTermino,"bandera":bandera},
            dataType: "json",
            async: false,
            success: function(response) {
                if(response.status == "success") {
                   for (var i = 0; i < response.datos.length; i++) {
                        var record = response.datos[i];
                        elementosParaVetar.push(record);
                    }
                    loadDataIntableElementosParaVetar(elementosParaVetar);
                    $("#tablaAccionBetar").show();
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
    }else{
        $("#tablaAccionBetar").hide();
    }
 }
 var tablaDePeticionesElementosParaVetar = null;

 function loadDataIntableElementosParaVetar(data) {
    if(tablaDePeticionesElementosParaVetar != null) {
        tablaDePeticionesElementosParaVetar.destroy();
    }
    tablaDePeticionesElementosParaVetar = $('#tablaAccionBetar').DataTable({
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
             "data": "EntidadDeTrabajo"
         },
         {   
             "data": "PuntosServicio"
         },
         {   
             "data": "NumeroSupervisor"
         },
         {   
             "data": "NombreSupervisor"
         }, 
         {   
             "data": "FechaIngreso"
         }, 
         {   
             "data": "FechaBaja"
         }, 
         {   "className": "dt-body-right",
             "data": "accion"
         },
          ],
         processing: true,
         dom: 'Bfrtip',
         buttons: {
            buttons: []
         }

        });
 } 

function BetarElemento(numeroEmpleado,nombreEmpelado){
    var re = /%/gi;

    var NombrEmpelado1 = nombreEmpelado.replace(re,' ');
    $("#ModalBetarElemento").modal();
    LimpiarModalBetoDeempleados();
    $("#NumeroEmpleadoModalBeto").val(numeroEmpleado);
    $("#NombrEmpeladoModalBeto").val(NombrEmpelado1);
}

 function LimpiarModalBetoDeempleados(){
    $("#ComentarioVetoElemento").val("");
    $("#checkSiVeto").prop('checked','');
    $("#checkNoVeto").prop('checked','');
    $("#archivoVetoEmpleado").val("");
    $("#ComentarioArchivoVetoElemento").val(""); 
    $("#inpComentarioNoArchivo").hide(); 
    $("#divArchivoVeto").hide();
 } 

$("#checkSiVeto").click(function(){
    $("#checkNoVeto").prop('checked','');
    $("#archivoVetoEmpleado").val("");
    $("#divArchivoVeto").show();
    $("#ComentarioArchivoVetoElemento").val("");
    $("#inpComentarioNoArchivo").hide(); 
});

$("#checkNoVeto").click(function(){
    $("#checkSiVeto").prop('checked','');
    $("#archivoVetoEmpleado").val("");
    $("#divArchivoVeto").hide();
    $("#inpComentarioNoArchivo").show(); 
    $("#ComentarioArchivoVetoElemento").val("");
});

$("#btnVetarElemento").click(function(){
    var NumeroEmpleado = $("#NumeroEmpleadoModalBeto").val();
    var NombrEmpelado = $("#NombrEmpeladoModalBeto").val();
    var ComentarioVeto = $("#ComentarioVetoElemento").val();
    var checkSiVeto = $("#checkSiVeto").val();
    var checkNoVeto = $("#checkNoVeto").val();
    var archivoVeto = $("#archivoVetoEmpleado").val();
    var ComentarioArchivo = $("#ComentarioArchivoVetoElemento").val();
    var Condicion = "0";
    if($('#checkSiVeto').is(":checked")){
        Condicion = "1";
    }
    if($('#checkNoVeto').is(":checked")){
        Condicion = "2";
    }
    if(ComentarioVeto  == ""){
        CargarErrorModalRechazo("Indica El Motivo Por EL Cual Este Empleado Será Vetado");
    }else if(Condicion == "0"){
        CargarErrorModalRechazo("Selecciona Si Se Anexará Un Archivo");
    }else if(Condicion == "1" && archivoVeto==""){
        CargarErrorModalRechazo("Selecciona El Archivo A Guardar");
    }else if(Condicion == "2" && ComentarioArchivo==""){
        CargarErrorModalRechazo("Indica El Motivo Por El Cual No Se Anexará El Archivo");
    }else{
        var formData = new FormData($("#formArchivoVetoEmpleado")[0]);
        formData.append('NumeroEmpleado', NumeroEmpleado);
        formData.append('NombrEmpelado', NombrEmpelado);
        formData.append('ComentarioVeto', ComentarioVeto);
        formData.append('archivoVeto', archivoVeto);
        formData.append('ComentarioArchivo', ComentarioArchivo);
        formData.append('Condicion', Condicion);   
        $.ajax({            
            type: "POST",
            url: "BetoDeEmpleados/ajax_uploadVetoElementos.php",
            data:formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            success:function(response){ 
                var msj=response.message;
                if(response.status=='success'){   
                   $("#ModalBetarElemento").modal("hide");
                   ConsultaElementosParaVetar();
                   swal("Listo", "El Empleado Con Numero "+NumeroEmpleado+" Ha Sido Vetado Y No Podra Reingresar", "success");
                }else{
                    swal("Alto", msj, "error");            
                }
            },error:function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText); 
            }
        });
    }
});
$("#btnCancelarVeto").click(function(){
    $("#ModalBetarElemento").modal("hide");
});

function CargarErrorModalRechazo(mensaje){
    $('#errorModalBetarElemento').fadeIn();
    msjerrorbaja="<div id='errorModalBetarElemento1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
    $("#errorModalBetarElemento").html(msjerrorbaja);
    $(document).scrollTop(0);
    $('#errorModalBetarElemento').delay(4000).fadeOut('slow'); 
}  

