$(document).ready(function() {
   cargarRegistrosPatronales();

 });

function cargarRegistrosPatronales(){
    $.ajax({
            type: "POST",
            url: "EdicionPSEMAEBA/ajax_consultaRegistrosPatronales.php",
            dataType: "json",
            success: function(response) {
            //console.log(response.datos);
            $("#selectRegPatEdicionPS").empty(); 
            $('#selectRegPatEdicionPS').append('<option value="0">REGISTRO PATRONAL</option>');
        if(response.status == "success"){
           for(var i = 0; i < response.datos.length; i++){
               $('#selectRegPatEdicionPS').append('<option value="' + (response.datos[i].idcatalogoRegistrosPatronales) + '">' + response.datos[i].idcatalogoRegistrosPatronales + '</option>');
              }
          }else{
                alert("Error Al Cargar Las Entidades");
               }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }


$("#selectAnioDoEdit").change(function(){
  $("#btnguardarDocEditeditado").hide();
  $("#tablaDatosDocEdit").hide();
});

$("#selectMesDocEdit").change(function(){
  $("#btnguardarDocEditeditado").hide();
  $("#tablaDatosDocEdit").hide();
});


$("#selectDocEdicion").change(function(){

  var opcion=$("#selectDocEdicion").val();
  $("#selectRegPatEdicionPS").show();
  $("#divAnioEdit").show();
  $("#divMesEdit").show();
  $("#btnBuscarEdit").show();
  $("#btnguardarDocEditeditado").hide();
  $("#tablaDatosDocEdit").hide();
});

$("#btnBuscarEdit").click(function(){
  waitingDialog.show();
  var opcion=$("#selectDocEdicion").val();
  var anio= $("#selectAnioDoEdit").val();
  var mes= $("#selectMesDocEdit").val();
  var regPat= $("#selectRegPatEdicionPS").val();

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

  }else if (regPat=='0') {
        var mensaje= "elija un registro patronal";
        cargarmensajeSAT(mensaje,"error");
        waitingDialog.hide();
  }else{
        consultarDocumentosPSEMAEBA(opcion,anio,mes,regPat);
  }
});


function consultarDocumentosPSEMAEBA(opcion,anio,mes,regPat) {
 $("#divMsgEdicionPSEMAEBA").html("");
 $("#btnguardarDocEditAgregado").prop("disabled", true);
 var nombreCarpeta= regPat+mes+anio;  
 $.ajax({
  type: "POST",
  url: "EdicionPSEMAEBA/ajax_ConsultaDocEDIT.php",
  data: {opcion,anio,mes,regPat},
  dataType: "json",
  success: function(response) {
    if(response.status == "success") {
        var datos  = response.datos;
        if (datos.length=='' || datos.length==0 || datos.length=='NULL' || datos.length=='null' || datos.length==null) {

            if(opcion=='1') {
               var mensaje= "NO SE HA CARGADO PUNTO SUA EN EL REGISTRO PATRONAL, EJERCICIO Y MES ELEGIDOS, CARGUE EL DOCUMENTO POR FAVOR"
            }if(opcion=='2') {
               var mensaje= "NO SE HA CARGADO EMA EN EL REGISTRO PATRONAL, EJERCICIO Y MES ELEGIDOS, CARGUE EL DOCUMENTO POR FAVOR"
            }if(opcion=='3') {
               var mensaje= "NO SE HA CARGADO EBA EN EL REGISTRO PATRONAL, EJERCICIO Y MES ELEGIDOS, CARGUE EL DOCUMENTO POR FAVOR"
            }

            cargarmensajeSAT(mensaje,"warning");
            waitingDialog.hide();
        }else{
             $("#tablaDatosDocEdit").empty();
             $("#tablaDatosDocEdit").show();
             var tabla  = "<table id='tabla' class='table table-bordered'><thead><th>Documento</th><th>Editar</th><th>carga de Archivo</th></thead><tbody>";

            var idDocSAT=datos[0]["idDocumento"];
            var nombreDocSAT=datos[0]["nombreDocumento"];
              
              tabla += "<td><img   id='btncargarDocSAT'  title='Abrir'  style='width:35px' src='img/pdf.png' class='cursorImg' onclick='cargarDocSAT(\""+nombreDocSAT+"\",\""+opcion+"\",\""+nombreCarpeta+"\")'></td>";
              tabla += "<td><img   id='btneditarDocSAT'  title='editar' style='width:40%' src='img/lapizEdit.png' class='cursorImg' onclick='editarDocSAT()'></td>";
              tabla += "<td><input id='documentoCargadoEditEdit' type='file' class='btn-success'  name='documentoCargadoEditEdit[]' multiple='' disabled='true' /><input id='inpidDocSATHidden' type='hidden' value='\""+idDocSAT+"\"'></td>";
              $("#tablaDatosDocEdit").append(tabla);
              $("#btnguardarDocEditeditado").show();
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

function cargarDocSAT(nombreDocSAT,opcion,nombreCarpeta){

    if(opcion=='1'){
       window.open("uploads/documentosContabilidad/pagoSua/"+nombreCarpeta+"/PuntoSUA.zip");
    }if(opcion=='2'){
       window.open("uploads/DocumentosIDSEEMA/"+nombreDocSAT);
    }if(opcion=='3'){
       window.open("uploads/DocumentosIDSEEBA/"+nombreDocSAT);
    }
}

$("#btnguardarDocEditeditado").click(function(){
    
    var opcion=$("#selectDocEdicion").val();
    var anioDocSAT= $("#selectAnioDoEdit").val();
    var mesDocSAT= $("#selectMesDocEdit").val();
    var idDocumento=$("#inpidDocSATHidden").val();
    var regPat= $("#selectRegPatEdicionPS").val();
    var nombreCarpeta= regPat+mesDocSAT+anioDocSAT;

    var formData = new FormData($("#archivoEditadoEdit")[0]);
    var documentoCargadoEditado = $("#documentoCargadoEditEdit").val();

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
        formData.append('regPat',regPat);
        formData.append('nombreCarpeta',nombreCarpeta);

        $.ajax({
            type: "POST",
            url: 'EdicionPSEMAEBA/ajax_InsertDocPSEMAEBAedit.php',
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
                    waitingDialog.hide();
                }
            },error:function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText);
                waitingDialog.hide();
            }
        });
    }
});

function limpiarFormularios(){

   $("#selectDocEdicion").val(0);
   $("#selectAnioDoEdit").val(0);
   $("#selectMesDocEdit").val(0);
   $("#selectRegPatEdicionPS").val('0');
   $("#selectRegPatEdicionPS").hide();
   $("#documentoCargadoEditEdit").val('');
   $("#divAnioEdit").hide();
   $("#divMesEdit").hide();
   $("#btnBuscarEdit").hide();
   $("#btnguardarDocEditeditado").hide();
   $("#tablaDatosDocEdit").hide();
}

function cargarmensajeSAT(mensaje,status){
    $('#divMsgEdicionPSEMAEBA').fadeIn('slow');
    mensajeAmostrar="<div id='msgAlert' class='alert alert-"+status+"'>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#divMsgEdicionPSEMAEBA").html(mensajeAmostrar);
    $(document).scrollTop(0);
    $('#divMsgEdicionPSEMAEBA').delay(3000).fadeOut('slow');
}

function editarDocSAT() {
    $("#documentoCargadoEditEdit").prop("disabled", false);
    $("#btnguardarDocEditeditado").prop("disabled", false);
    $("#btnguardarDocEditeditado").show();
}