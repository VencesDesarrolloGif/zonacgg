$("#selectAnioDocSAT").change(function(){
  $("#btnguardarDocSATeditado").hide();
  $("#divDocAgregadosSAT").hide();
  $("#tablaDatosDocSAT").hide();
});

$("#selectMesDocSAT").change(function(){
  $("#btnguardarDocSATeditado").hide();
  $("#divDocAgregadosSAT").hide();
  $("#tablaDatosDocSAT").hide();
});


$("#selectMovimientoSat").change(function(){

  var opcion=$("#selectMovimientoSat").val();
  $("#divAnio").show();
  $("#divMes").show();
  $("#btnBuscar").show();
  $("#divDocAgregadosSAT").hide();
  $("#btnguardarDocSATeditado").hide();
  $("#tablaDatosDocSAT").hide();
});

$("#btnBuscar").click(function(){
  waitingDialog.show();
  var opcion=$("#selectMovimientoSat").val();
  var anio= $("#selectAnioDocSAT").val();
  var mes= $("#selectMesDocSAT").val();

  if (opcion=='0') {
    var mensaje= "elija el tipo de documento";
        cargarmensajeSAT(mensaje,"error");
        waitingDialog.hide();
  }
  else if (anio=='0') {
        var mensaje= "elija un ejercicio";
        cargarmensajeSAT(mensaje,"error");
        waitingDialog.hide();

  }else if (mes=='0') {
        var mensaje= "elija un mes";
        cargarmensajeSAT(mensaje,"error");
        waitingDialog.hide();
  }else{
        traerDeclaracionISR(opcion,anio,mes);
  }
});


function traerDeclaracionISR(opcion,anio,mes) {
 $("#msgSAT").html("");
 $("#btneditarDocSAT").prop("disabled", false);
 $("#btnguardarDocSATAgregado").prop("disabled", true);
 $("#btnagregarDocSAT").prop('disabled', false);

 $.ajax({
  type: "POST",
  url: "SAT/ajax_ConsultaDocSAT.php",
  data: {opcion,anio,mes},
  dataType: "json",
  success: function(response) {
    if(response.status == "success") {
        var datos  = response.datos;
        if (datos.length=='' || datos.length==0 || datos.length=='NULL' || datos.length=='null' || datos.length==null) {
            $("#divDocAgregadosSAT").show();

            if(opcion=='1') {
               var mensaje= "NO SE HA CARGADO DECLARACION DE ISR EN EL EJERCICIO Y MES ELEGIDOS, CARGUE EL DOCUMENTO POR FAVOR"
            }if(opcion=='2') {
               var mensaje= "NO SE HA CARGADO DECLARACION DE IVA EN EL EJERCICIO Y MES ELEGIDOS, CARGUE EL DOCUMENTO POR FAVOR"
            }if(opcion=='3') {
               var mensaje= "NO SE HA CARGADO PAGO ISR EN EL EJERCICIO Y MES ELEGIDOS, CARGUE EL DOCUMENTO POR FAVOR"
            }if(opcion=='4') {
               var mensaje= "NO SE HA CARGADO PAGO IVA EN EL EJERCICIO Y MES ELEGIDOS, CARGUE EL DOCUMENTO POR FAVOR"
            }if(opcion=='5') {
               var mensaje= "NO SE HA CARGADO OPINION SAT EN EL EJERCICIO Y MES ELEGIDOS, CARGUE EL DOCUMENTO POR FAVOR"
            }if(opcion=='6') {
               var mensaje= "NO SE HA CARGADO CONSTANCIA DE SITUACIÓN FISCAL EN EL EJERCICIO Y MES ELEGIDOS, CARGUE EL DOCUMENTO POR FAVOR"
            }if(opcion=='7') {
               var mensaje= "NO SE HA CARGADO AFFIDAVIT EN EL EJERCICIO Y MES ELEGIDOS, CARGUE EL DOCUMENTO POR FAVOR"
            }

            cargarmensajeSAT(mensaje,"warning");
            waitingDialog.hide();
        }else{
             $("#tablaDatosDocSAT").empty();
             $("#tablaDatosDocSAT").show();
             var tabla  = "<table id='tabla' class='table table-bordered'><thead><th>PDF</th><th>Editar</th><th>Eliminar</th><th>carga de Archivo</th></thead><tbody>";

            var idDocSAT=datos[0]["idDocumento"];
            var nombreDocSAT=datos[0]["nombreDocumento"];
              
              tabla += "<td><img   id='btncargarDocSAT'  title='Abrir'    style='width:60%' src='img/hojaDatos.png' class='cursorImg' onclick='cargarDocSAT(\""+nombreDocSAT+"\",\""+opcion+"\")'></td>";
              tabla += "<td><img   id='btneditarDocSAT'  title='editar'   style='width:40%' src='img/lapizEdit.png' class='cursorImg' onclick='editarDocSAT()'></td>";
              tabla += "<td><img   id='btneliminarDocSAT'title='Eliminar' style='width:60%' src='img/eliminar.png'  class='cursorImg' onclick='eliminarDocSat(\""+nombreDocSAT+"\")'></td>";
              tabla += "<td><input id='documentoCargadoSATEdit' type='file' class='btn-success'  name='documentoCargadoSATEdit[]' multiple='' disabled='true' /><input id='inpidDocSATHidden' type='hidden' value='\""+idDocSAT+"\"'></td>";
              $("#tablaDatosDocSAT").append(tabla);
              $("#btnguardarDocSATeditado").show();
              waitingDialog.hide();
       }
    }else{
          var mensaje= response.mensaje;
          cargarmensajeSAT(mensaje,"error");
         }
 },
 error: function(jqXHR, textStatus, errorThrown) {
     alert(jqXHR.responseText);
      }
 });
}

function cargarDocSAT(nombreDocSAT,opcion){
    if(opcion=='1'){
       window.open("uploads/DeclaracionISR/"+nombreDocSAT);
    }if(opcion=='2'){
       window.open("uploads/DeclaracionIVA/"+nombreDocSAT);
    }if(opcion=='3'){
       window.open("uploads/PagosISR/"+nombreDocSAT);
    }if(opcion=='4'){
       window.open("uploads/PagosIVA/"+nombreDocSAT);
    }if(opcion=='5'){
       window.open("uploads/OpinionSAT/"+nombreDocSAT);
    }if(opcion=='6'){
       window.open("uploads/ConstanciaDeSituacionFiscal/"+nombreDocSAT);
    }if(opcion=='7'){
       window.open("uploads/AFFIDAVIT/"+nombreDocSAT);
    }

}

$("#btnagregarDocSAT").click(function(){

    $("#documentoCargadoSAT").prop("disabled", false);
    $("#btnguardarDocSATAgregado").prop("disabled", false);
});

$("#btnguardarDocSATAgregado").click(function(){

    waitingDialog.show();
    var opcion=$("#selectMovimientoSat").val();
    var anioDocSAT= $("#selectAnioDocSAT").val();
    var mesDocSAT= $("#selectMesDocSAT").val();
    var formData = new FormData($("#archivoAddSAT")[0]);
    var documentoCargadoSAT = $("#documentoCargadoSAT").val();

    if(documentoCargadoSAT == ""){
        var mensaje= "CARGUE UN DOCUMENTO PDF"
        cargarmensajeSAT(mensaje,"error");
        waitingDialog.hide();
        return;
    }else if(anioDocSAT == ""){
             var mensaje= "SELECCIONE EL EJERCICIO"
             cargarmensajeSAT(mensaje,"error");
             waitingDialog.hide();
             return;
    }else if(mesDocSAT == ""){
             var mensaje= "SELECCIONE EL AÑO"
             cargarmensajeSAT(mensaje,"error");
             waitingDialog.hide();
             return;
    }
    formData.append('opcion',opcion);
    formData.append('anioDocSAT',anioDocSAT);
    formData.append('mesDocSAT',mesDocSAT);

    $.ajax({
        type: "POST",
        url: 'SAT/ajax_InsertDocSAT.php',
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        async:false, 
        success: function(response){
            var mensaje= response.mensaje;
            if(response.status=="success") {
               cargarmensajeSAT(mensaje,"success");
               limpiarFormularios();
               waitingDialog.hide();
            }else{
                cargarmensajeSAT(mensaje,"error");
            }
        },error:function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
            waitingDialog.hide();
        }
    });
});


$("#btnguardarDocSATeditado").click(function(){
    
    var opcion=$("#selectMovimientoSat").val();
    var anioDocSAT= $("#selectAnioDocSAT").val();
    var mesDocSAT= $("#selectMesDocSAT").val();
    var idDocumento=$("#inpidDocSATHidden").val();

    var formData = new FormData($("#archivoEditadoSAT")[0]);
    var documentoCargadoEditado = $("#documentoCargadoSATEdit").val();

    if(documentoCargadoEditado == ""){
        var mensaje= "CARGUE UN DOCUMENTO PDF"
        cargarmensajeSAT(mensaje,"error");
        waitingDialog.hide();
    }else{
    
        waitingDialog.show();
        formData.append('opcion',opcion);
        formData.append('anioDocSAT',anioDocSAT);
        formData.append('mesDocSAT',mesDocSAT);
        formData.append('idDocumento',idDocumento);

        $.ajax({
            type: "POST",
            url: 'SAT/ajax_InsertDocSATEdit.php',
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            async:false, 
            success: function(response){
                var mensaje= response.mensaje;
                if(response.status=="success"){
                   cargarmensajeSAT(mensaje,"success");
                   limpiarFormularios();
                   waitingDialog.hide();
                }else{
                    cargarmensajeSAT(mensaje,"error");
                }
            },error:function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText);
                waitingDialog.hide();
            }
        });
    }
});

function eliminarDocSat(nombreDocSAT){

    var opcion=$("#selectMovimientoSat").val();
    var idDocumento=$("#inpidDocSATHidden").val();
    $.ajax({
        type: "POST",
        url: 'SAT/ajax_EliminarDocSAT.php',
        data: {"idDocumento":idDocumento,"opcion":opcion,"nombreDocSAT":nombreDocSAT},
        dataType: "json",
        async:false, 
        success: function(response){ 
            var mensaje= response.mensaje;
            if(response.status=="success"){
               cargarmensajeSAT(mensaje,"success");
               limpiarFormularios();
               waitingDialog.hide();
            }else{
                cargarmensajeSAT(mensaje,"error");
            }
        },error:function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText);
                waitingDialog.hide();
            }
    });
}

function limpiarFormularios(){

   $("#selectMovimientoSat").val(0);
   $("#selectAnioDocSAT").val(0);
   $("#selectMesDocSAT").val(0);
   $("#documentoCargadoSAT").val('');
   $("#documentoCargadoSATEdit").val('');
   $("#divAnio").hide();
   $("#divMes").hide();
   $("#btnBuscar").hide();
   $("#divDocAgregadosSAT").hide();
   $("#btnguardarDocSATeditado").hide();
   $("#tablaDatosDocSAT").hide();

}

function cargarmensajeSAT(mensaje,status){
    $('#msgSAT').fadeIn('slow');
    mensajeAmostrar="<div id='msgAlert' class='alert alert-"+status+"'>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#msgSAT").html(mensajeAmostrar);
    $(document).scrollTop(0);
    $('#msgSAT').delay(3000).fadeOut('slow');
}

function editarDocSAT() {
    $("#documentoCargadoSATEdit").prop("disabled", false);
    $("#btnguardarDocSATeditado").prop("disabled", false);
    $("#btnguardarDocSATeditado").show();
}