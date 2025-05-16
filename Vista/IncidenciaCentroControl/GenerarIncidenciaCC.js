$(document).ready (function (){
    obtenerIncidencias();
    ObtenerEntidadesIncidencia();
    $("#SelectMotivoCancelacionhidden").val("");
    $("#SelectIncidenciaAceptacionhidden").val("");
});//termina ready



function revisarLimiteFotosGICC() {
    const fileInput = document.getElementById('Doc7');
    const maxFiles = 16;
    
    if (fileInput.files.length > maxFiles) {
      alert(`Solo puedes cargar un máximo de ${maxFiles} archivos.`);
      fileInput.value = '';  // Limpiar la selección si se excede el límite
    }
  }

$("#txtAreaTestigos1").keypress(function(e){
  if(e.which==13){
      event.preventDefault();
      swal("Alto","No puede realizar esta acción", "warning"); 
  }
});
$("#txtAreaTestigos2").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});
$("#txtAreaTestigos3").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});
$("#txtAreaTestigos4").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});
$("#txtAreaTestigos5").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});
$("#txtAreaTestigos6").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});
$("#txtAreaTestigos7").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});

$("#txtAreaPercataron").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});


$("#txtAreaRecopilacion1").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});
$("#txtAreaRecopilacion2").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});
$("#txtAreaRecopilacion3").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});
$("#txtAreaRecopilacion4").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});
$("#txtAreaRecopilacion5").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});
$("#txtAreaRecopilacion6").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});
$("#txtAreaRecopilacion7").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});

$("#txtAreaRecopilacion8").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});

$("#txtAreaRecopilacion9").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});

$("#txtAreaRecopilacion10").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});

$("#txtAreaTarea").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});


$("#txtResponsabilidad1").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});

$("#txtResponsabilidad2").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});

$("#txtAreaOrdenes1").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});

$("#txtAreaOrdenes2").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});

$("#txtAreaEvidencia1").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});

$("#txtAreaEvidencia2").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});

$("#txtAreaSupervision1").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});

$("#txtAreaSupervision2").keypress(function(e){
  if(e.which==13){
      swal("Alto","No puede realizar esta acción", "warning"); 
      event.preventDefault();
  }
});

var inputs = "input[maxlength], textarea[maxlength]";
  $(document).on('keyup', "[maxlength]", function (e) {
    var este = $(this),
      maxlength = este.attr('maxlength'),
      maxlengthint = parseInt(maxlength),
      textoActual = este.val(),
      currentCharacters = este.val().length;
      remainingCharacters = maxlengthint - currentCharacters,
      espan = este.prev('label').find('span');
      $("#span1").show();      
      // Detectamos si es IE9 y si hemos llegado al final, convertir el -1 en 0 - bug ie9 porq. no coge directamente el atributo 'maxlength' de HTML5
      if (document.addEventListener && !window.requestAnimationFrame) {
        if (remainingCharacters <= -1) {
          remainingCharacters = 0;            
        }
      }
      espan.html(remainingCharacters);
    });

$('#AgregarTextoSupervision').click(function() {
    var txtResponsabilidad = $("#conteoTxtSupervision").val();

    if(txtResponsabilidad=="1"){
       $("#txtAreaSupervision2").show();
       $("#conteoTxtSupervision").val(2);
       $("#eliminarTextoSupervision").show();
       $("#AgregarTextoSupervision").hide();
       $("#caracteresSP2").show();
    }
});

$('#eliminarTextoSupervision').click(function() {
    var txtResponsabilidad = $("#conteoTxtSupervision").val();
    if(txtResponsabilidad=="2"){
       $("#txtAreaSupervision2").hide();
       $("#txtAreaSupervision2").val("");
       $("#conteoTxtSupervision").val(1);
       $("#eliminarTextoSupervision").hide();
       $("#AgregarTextoSupervision").show();
       $("#caracteresSP2").hide();
    }
});

$('#AgregarTextoEvidencia').click(function() {
    var txtResponsabilidad = $("#conteoTxtEvidencia").val();

    if(txtResponsabilidad=="1"){
       $("#txtAreaEvidencia2").show();
       $("#conteoTxtEvidencia").val(2);
       $("#eliminarTextoEvidencia").show();
       $("#AgregarTextoEvidencia").hide();
       $("#caracteresE2").show();
    }
});

$('#eliminarTextoEvidencia').click(function() {
    var txtResponsabilidad = $("#conteoTxtEvidencia").val();

    if(txtResponsabilidad=="2"){
       $("#txtAreaEvidencia2").hide();
       $("#txtAreaEvidencia2").val("");
       $("#conteoTxtEvidencia").val(1);
       $("#eliminarTextoEvidencia").hide();
       $("#AgregarTextoEvidencia").show();
       $("#caracteresE2").hide();
    }
});

$('#AgregarTextoOrdenes').click(function() {
    var txtResponsabilidad = $("#conteoTxtOrdenes").val();

    if(txtResponsabilidad=="1"){
       $("#txtAreaOrdenes2").show();
       $("#conteoTxtOrdenes").val(2);
       $("#eliminarTextoOrdenes").show();
       $("#AgregarTextoOrdenes").hide();
       $("#caracteresO2").show();
    }
});

$('#eliminarTextoOrdenes').click(function() {
    var txtResponsabilidad = $("#conteoTxtOrdenes").val();

    if(txtResponsabilidad=="2"){
       $("#txtAreaOrdenes2").hide();
       $("#txtAreaOrdenes2").val("");
       $("#conteoTxtOrdenes").val(1);
       $("#eliminarTextoOrdenes").hide();
       $("#AgregarTextoOrdenes").show();
       $("#caracteresO2").hide();
    }
});

$('#AgregarTextoResponsabilidad').click(function() {
    var txtResponsabilidad = $("#conteoTxtResponsabilidad").val();

    if(txtResponsabilidad=="1"){
       $("#txtResponsabilidad2").show();
       $("#conteoTxtResponsabilidad").val(2);
       $("#eliminarTextoResponsabilidad").show();
       $("#AgregarTextoResponsabilidad").hide();
       $("#caracteresRP2").show();
    }
});

$('#eliminarTextoResponsabilidad').click(function() {
    var txtResponsabilidad = $("#conteoTxtResponsabilidad").val();

    if(txtResponsabilidad=="2"){
       $("#txtResponsabilidad2").hide();
       $("#txtResponsabilidad2").val("");
       $("#conteoTxtResponsabilidad").val(1);
       $("#eliminarTextoResponsabilidad").hide();
       $("#AgregarTextoResponsabilidad").show();
       $("#caracteresRP2").hide();
    }
});


$('#agregarRecopilacion').click(function() {
    var parrafo = $("#conteoRecopilacion").val();

    if(parrafo=="1"){
       $("#txtAreaRecopilacion2").show();
       $("#conteoRecopilacion").val(2);
       $("#eliminarRecopilacion").show();
       $("#caracteresR2").show();
    }if(parrafo=="2"){
       $("#txtAreaRecopilacion3").show();
       $("#conteoRecopilacion").val(3);
       $("#caracteresR3").show();
    }if(parrafo=="3"){
       $("#txtAreaRecopilacion4").show();
       $("#conteoRecopilacion").val(4);
       $("#caracteresR4").show();
    }if(parrafo=="4"){
       $("#txtAreaRecopilacion5").show();
       $("#conteoRecopilacion").val(5);
       $("#caracteresR5").show();
    }if(parrafo=="5"){
       $("#txtAreaRecopilacion6").show();
       $("#conteoRecopilacion").val(6);
       $("#caracteresR6").show();
    }if(parrafo=="6"){
       $("#txtAreaRecopilacion7").show();
       $("#conteoRecopilacion").val(7);
       $("#caracteresR7").show();
    }if(parrafo=="7"){
       $("#txtAreaRecopilacion8").show();
       $("#conteoRecopilacion").val(8);
       $("#caracteresR8").show();
    }if(parrafo=="8"){
       $("#txtAreaRecopilacion9").show();
       $("#conteoRecopilacion").val(9);
       $("#caracteresR9").show();
    }if(parrafo=="9"){
       $("#txtAreaRecopilacion10").show();
       $("#conteoRecopilacion").val(10);
       $("#agregarRecopilacion").hide();
       $("#caracteresR10").show();
    }
});

$('#eliminarRecopilacion').click(function() {
    var parrafo = $("#conteoRecopilacion").val();

    if(parrafo=="10"){
       $("#txtAreaRecopilacion10").hide();
       $("#txtAreaRecopilacion10").val("");
       $("#conteoRecopilacion").val(9);
       $("#agregarRecopilacion").show();
       $("#caracteresR10").hide();
    }if(parrafo=="9"){
       $("#txtAreaRecopilacion9").hide();
       $("#txtAreaRecopilacion9").val("");
       $("#conteoRecopilacion").val(8);
       $("#caracteresR9").hide();
    }if(parrafo=="8"){
       $("#txtAreaRecopilacion8").hide();
       $("#txtAreaRecopilacion8").val("");
       $("#conteoRecopilacion").val(7);
       $("#caracteresR8").hide();
    }if(parrafo=="7"){
       $("#txtAreaRecopilacion7").hide();
       $("#txtAreaRecopilacion7").val("");
       $("#conteoRecopilacion").val(6);
       $("#caracteresR7").hide();
    }if(parrafo=="6"){
       $("#txtAreaRecopilacion6").hide();
       $("#txtAreaRecopilacion6").val("");
       $("#conteoRecopilacion").val(5);
       $("#caracteresR6").hide();
    }if(parrafo=="5"){
       $("#txtAreaRecopilacion5").hide();
       $("#txtAreaRecopilacion5").val("");
       $("#conteoRecopilacion").val(4);
       $("#caracteresR5").hide();
    }if(parrafo=="4"){
       $("#txtAreaRecopilacion4").hide();
       $("#txtAreaRecopilacion4").val("");
       $("#conteoRecopilacion").val(3);
       $("#caracteresR4").hide();
    }if(parrafo=="3"){
       $("#txtAreaRecopilacion3").hide();
       $("#txtAreaRecopilacion3").val("");
       $("#conteoRecopilacion").val(2);
       $("#caracteresR3").hide();
    }if(parrafo=="2"){
       $("#txtAreaRecopilacion2").hide();
       $("#txtAreaRecopilacion2").val("");
       $("#conteoRecopilacion").val(1);
       $("#eliminarRecopilacion").hide();
       $("#caracteresR2").hide();
    }
});


$('#agregarTestigo').click(function() {
    var noTestigos = $("#conteoTestigos").val();

    if(noTestigos=="1"){
       $("#txtAreaTestigos2").show();
       $("#conteoTestigos").val(2);
       $("#eliminarTestigo").show();
       $("#caracteresT2").show();
    }if(noTestigos=="2"){
       $("#txtAreaTestigos3").show();
       $("#conteoTestigos").val(3);
       $("#caracteresT3").show();
    }if(noTestigos=="3"){
       $("#txtAreaTestigos4").show();
       $("#conteoTestigos").val(4);
       $("#caracteresT4").show();
    }if(noTestigos=="4"){
       $("#txtAreaTestigos5").show();
       $("#conteoTestigos").val(5);
       $("#caracteresT5").show();
    }if(noTestigos=="5"){
       $("#txtAreaTestigos6").show();
       $("#conteoTestigos").val(6);
       $("#caracteresT6").show();
    }if(noTestigos=="6"){
       $("#txtAreaTestigos7").show();
       $("#conteoTestigos").val(7);
       $("#agregarTestigo").hide();
       $("#caracteresT7").show();
    }
});

$('#eliminarTestigo').click(function() {
    var noTestigos = $("#conteoTestigos").val();

    if(noTestigos=="7"){
       $("#txtAreaTestigos7").hide();
       $("#txtAreaTestigos7").val("");
       $("#conteoTestigos").val(6);
       $("#agregarTestigo").show();
       $("#caracteresT7").hide();
    }if(noTestigos=="6"){
       $("#txtAreaTestigos6").hide();
       $("#txtAreaTestigos6").val("");
       $("#conteoTestigos").val(5);
       $("#caracteresT6").hide();
    }if(noTestigos=="5"){
       $("#txtAreaTestigos5").hide();
       $("#txtAreaTestigos5").val("");
       $("#conteoTestigos").val(4);
       $("#caracteresT5").hide();
    }if(noTestigos=="4"){
       $("#txtAreaTestigos4").hide();
       $("#txtAreaTestigos4").val("");
       $("#conteoTestigos").val(3);
       $("#caracteresT4").hide();
    }if(noTestigos=="3"){
       $("#txtAreaTestigos3").hide();
       $("#txtAreaTestigos3").val("");
       $("#conteoTestigos").val(2);
       $("#caracteresT3").hide();
    }if(noTestigos=="2"){
       $("#txtAreaTestigos2").hide();
       $("#txtAreaTestigos2").val("");
       $("#conteoTestigos").val(1);
       $("#eliminarTestigo").hide();
       $("#caracteresT2").hide();
    }
});

function ObtenerEntidadesIncidencia(){
    $.ajax({
      type: "POST",
      url: "IncidenciaCentroControl/ajax_ObtenerentidadesIncidenciaCC.php",
      dataType: "json",
      success: function(response) {
         if (response.status == "success")
         {
            var datos = response.datos;
            $('#SelectEntidadIncidencia').empty().append('<option value="0">ENTIDAD</option>');
            $.each(datos, function(i) {
               $('#SelectEntidadIncidencia').append('<option value="' + response.datos[i].idEntidadFederativa + '">' + response.datos[i].nombreEntidadFederativa + '</option>');
            });
         }
      },error: function(jqXHR, textStatus, errorThrown){
         alert(jqXHR.responseText);
      }
   });
}
function obtenerIncidencias(){
    var cargado = $("#SelectIncidenciaAceptacionhidden").val();
    if(cargado!="1"){
        $.ajax({
           type: "POST",
           url: "IncidenciaCentroControl/ajax_ObtenerIncidenciasCC.php",
           dataType: "json",
           success: function(response) {
              if (response.status == "success")
              {
                 var datos = response.datos;
                 $('#SelectIncidenciaAceptacion').empty().append('<option value="0">INCIDENCIA</option>');
                 $.each(datos, function(i) {
                    $('#SelectIncidenciaAceptacion').append('<option value="' + response.datos[i].idTipoIncidenciaCC + '">' + response.datos[i].descripcionTipoIncidenciaCC + '</option>');
                 });
                $("#SelectIncidenciaAceptacionhidden").val(1);
              }
           },error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText);
           }
        });
    }
}
$('#SelectEntidadIncidencia').change(function() {
    var IdEntidad = $("#SelectEntidadIncidencia").val();
    if(IdEntidad!="0"){
        obtenerPuntoServicios(IdEntidad);
    }else{
        $("#SelectPuntoServicioIncidencia").empty();
        $("#ExistepuntoSi").prop("checked", false);
        $("#ExistepuntoNo").prop("checked", false);
        $("#divPuntosservicioCC").hide();
        $("#divPuntoServicioEscritoCC").hide();
        $("#inpdivPuntoServicioEscritoCC").val("");
    }
    
});
$('#SelectIncidenciaAceptacion').change(function() {
    $("#constraseniaFirmaParaReporteincidenciaEmpleadoHidden").val("");
    $("#NumEmpModalFirmaReporteincidenciaEmpleadohidden").val("");
    $("#NumEmpModalFirmaReporteincidenciaEmpleado").val("");
    $("#constraseniaFirmaParaReporteincidenciaEmpleado").val("");
    $('#SelectEspecificacionIncidencia').empty().append('<option value="0">ESPECIFICACIÓN</option>');
    var idSeleccion = $("#SelectIncidenciaAceptacion").val();

    if(idSeleccion!=0){
        cosnultarEspecificaciones(idSeleccion);
    }
});

function cosnultarEspecificaciones(idSeleccion){
    $.ajax({
        type: "POST",
        url: "IncidenciaCentroControl/ajax_ObtenerEspecificacionIncidencias.php",
        data:{"idSeleccion":idSeleccion},
        dataType: "json",
        success: function(response) {
            if(response.status == "success"){
              var datos = response.datos;
              $('#SelectEspecificacionIncidencia').empty().append('<option value="0">ESPECIFICACIÓN</option>');
              $.each(datos, function(i) {
                 $('#SelectEspecificacionIncidencia').append('<option value="' + response.datos[i].idEspecificacionIncidenciaCC + '">' + response.datos[i].descripcionEspecificacionIncidenciaCC + '</option>');
              });
             $("#SelectEspecificacionIncidenciahidden").val(1);
            }
        },error: function(jqXHR, textStatus, errorThrown){
           alert(jqXHR.responseText);
        }
    });
}
$('#inpNumeroGuardiaIncidencia').keypress(function(event){  
    var keycode = (event.keyCode ? event.keyCode : event.which);  
    if(keycode == '13'){  
       
       var NumeroEmpleado = $("#inpNumeroGuardiaIncidencia").val();       
       $("#inpNombreGuardiaIncidencia").val("");       
       $("#inpPuestoGuardiaIncidencia").val("");       
       $("#inpPuestoGuardiaIncidenciahidden").val("");       
       ObtenerEmpleadoPorIdCC(NumeroEmpleado,1);  
    }   
});

$('#inpNumeroAdministrativoIncidencia').keypress(function(event){  
    var keycode = (event.keyCode ? event.keyCode : event.which);  
    if(keycode == '13'){  
       var NumeroEmpleado = $("#inpNumeroAdministrativoIncidencia").val();       
       $("#inpNombreAdministrativoIncidencia").val("");       
       $("#inpPuestoAdministrativoIncidencia").val("");       
       $("#inpPuestoAdministrativoIncidenciahidden").val("");       
       ObtenerEmpleadoPorIdCC(NumeroEmpleado,2);  
    }   
});

function ObtenerEmpleadoPorIdCC(NumeroEmpleado,Accion){
    $.ajax({
       type: "POST",
       url: "IncidenciaCentroControl/ObtenerEmpleadoPorIdParaCC.php",
       data:{"NumeroEmpleado":NumeroEmpleado},
       dataType: "json",
       async: false,
       success: function(response) {
           if(response.status == "success") {
               var Existe = response.datos.length;
               if(Existe==0){
                   swal("Alto","Empleado NO Existe o Estructura Incorrecta Intente Nuevamente", "error"); 
               }else{
                    if(Accion=="1"){
                        $("#inpNombreGuardiaIncidencia").val(response.datos[0]["NombreEmp"]);       
                        $("#inpPuestoGuardiaIncidencia").val(response.datos[0]["Puesto"]);     
                        $("#inpPuestoGuardiaIncidenciahidden").val(response.datos[0]["Idpuesto"]);     
                    }else{
                        $("#inpNombreAdministrativoIncidencia").val(response.datos[0]["NombreEmp"]);       
                        $("#inpPuestoAdministrativoIncidencia").val(response.datos[0]["Puesto"]);     
                        $("#inpPuestoAdministrativoIncidenciahidden").val(response.datos[0]["Idpuesto"]);
                    }
               }
           }else{
               var mensaje = response.message;
               swal("Alto",mensaje, "error");   
           }
       },error: function(jqXHR, textStatus, errorThrown) {
           alert(jqXHR.responseText);
       }
    });
}

$('#ExistepuntoSi').change(function() {
    if ($('#ExistepuntoSi').is(":checked")) {
        var IdEntidad = $("#SelectEntidadIncidencia").val();
        if(IdEntidad=="0"){
            $("#ExistepuntoSi").prop("checked", false);
            swal("Alto","Seleccione Una Entidad Federativa Para Continuar", "error");
        }else{
            $("#SelectPuntoServicioIncidencia").val(0);
            $("#divPuntosservicioCC").show();
            $("#ExistepuntoNo").prop("checked", false); 
        }
    }else{
        $("#divPuntosservicioCC").hide();
    }
    $("#divPuntoServicioEscritoCC").hide();
});

$('#ExistepuntoNo').change(function() {
    if ($('#ExistepuntoNo').is(":checked")) {
        var IdEntidad = $("#SelectEntidadIncidencia").val();
        if(IdEntidad=="0"){
            $("#ExistepuntoNo").prop("checked", false);
            swal("Alto","Seleccione Una Entidad Federativa Para Continuar", "error");
        }else{
            $("#divPuntoServicioEscritoCC").show();
            $("#ExistepuntoSi").prop("checked", false);
            $("#inpdivPuntoServicioEscritoCC").val(""); 
        }
    }else{
        $("#divPuntoServicioEscritoCC").hide();
    }
    $("#divPuntosservicioCC").hide();
});

function obtenerPuntoServicios(IdEntidad){
    $.ajax({
       type: "POST",
       url: "IncidenciaCentroControl/ajax_ObtenerPuntosServiciosCC.php",
       data:{"IdEntidad":IdEntidad},
       dataType: "json",
       success: function(response) {
          if (response.status == "success")
          {
             var datos = response.datos;
             $('#SelectPuntoServicioIncidencia').empty().append('<option value="0">PUNTOS</option>');
             $.each(datos, function(i) {
                $('#SelectPuntoServicioIncidencia').append('<option value="' + response.datos[i].idPuntoServicio + '">' + response.datos[i].puntoServicio + '</option>');
             });
          }
       },error: function(jqXHR, textStatus, errorThrown){
          alert(jqXHR.responseText);
       }
    });
}

$('#procedeSi').change(function() {
    if ($('#procedeSi').is(":checked")) {
        ObtneerLineasDeNegocio();
        $("#dviprocedeSi").show();
        $("#procedeNo").prop("checked", false);
        $("#divBtnIncidenciaCc").show();
    }else{
        $("#divChecksLineaNegocio").html("");
        removerSelectoresSup();
        $("#dviprocedeSi").hide();
        $("#divBtnIncidenciaCc").hide();
    }
      $("#dviprocedeNo").hide();
});

$('#procedeNo').change(function() {
    if ($('#procedeNo').is(":checked")) {
      $("#dviprocedeNo").show();
      $("#procedeSi").prop("checked", false); 
      $("#divChecksLineaNegocio").html("");
      removerSelectoresSup();
      obtenerMotivos();
      $("#divBtnIncidenciaCc").show();
    }else{
        $("#dviprocedeNo").hide();
        $("#divBtnIncidenciaCc").hide();
    }
      $("#dviprocedeSi").hide();
});

function removerSelectoresSup(){
    var largofor = $("#ChecksLineaNegociohidden").val();
    for (var i = 0; i <= largofor; i++) {
        $('#DivTablaSupervisoresLinea_'+i).remove("");
    }
}

function obtenerMotivos(){
    var cargado = $("#SelectMotivoCancelacionhidden").val();
    if(cargado!="1"){
        $.ajax({
           type: "POST",
           url: "IncidenciaCentroControl/ajax_ObtenerMotivosCancelacionCC.php",
           dataType: "json",
           success: function(response) {
              if (response.status == "success")
              {
                var datos = response.datos;
                $('#SelectMotivoCancelacion').empty().append('<option value="0">MOTIVO</option>');
                $.each(datos, function(i) {
                   $('#SelectMotivoCancelacion').append('<option value="' + response.datos[i].idCancelacionCC + '">' + response.datos[i].descripcionCancelacionCC + '</option>');
                });
                $("#SelectMotivoCancelacionhidden").val(1);
              }
           },error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText);
           }
        });
    }
}

function ObtneerLineasDeNegocio(){  
    $.ajax({
       type: "POST",
       url: "IncidenciaCentroControl/ajax_ObtenerLineasNegocioCC.php",
       dataType: "json",
       async:false,
       success: function(response) {
          if (response.status == "success")
          {
            var datos = response.datos;
            $("#ChecksLineaNegociohidden").val(datos.length);
            var checks="";
            $.each(datos, function(i) {
                var b = response.datos[i].descripcionLineaNegocio;
                checks +='<input class="input-xlarge" id="InputLineaSup_'+response.datos[i].idLineaNegocio+'" type="hidden"  value="'+b+'">';
                checks +='<label class="control-label label">'+response.datos[i].descripcionLineaNegocio +'</label>';
                checks += '<input id='+response.datos[i].idLineaNegocio+' name='+response.datos[i].idLineaNegocio+' type="checkbox" style="transform: scale(1.5);" onclick="ObtenerSupervisores('+response.datos[i].idLineaNegocio+');">';
                
            });
            $('#divChecksLineaNegocio').html(checks); 
          }
       },error: function(jqXHR, textStatus, errorThrown){
          alert(jqXHR.responseText);
       }
    });  
}
function ObtenerSupervisores(idLineaNegocio) {
    if($('#'+idLineaNegocio).is(":checked")) {
        var TablaSup="";
        var vv = $("#InputLineaSup_"+idLineaNegocio).val();    
        TablaSup +="<div id='DivTablaSupervisoresLinea_"+idLineaNegocio+"'"; 
        TablaSup +="<label class='control-label label' >"+vv+"</label><br><label class='control-label label'>Supervisor</label>";
        TablaSup += "<select id='SupervisorDinamico_"+idLineaNegocio+"' name='SupervisorDinamico_"+idLineaNegocio+"' onchange='AgregarSupervisores("+idLineaNegocio+");'></select>";
        TablaSup +="<br><table id='tabla_"+idLineaNegocio+"' class='table table-bordered'><thead><th>N° SUPERVISOR</th><th>NOMBRE SUPERVISOR</th></thead><tbody></tbody></table>";        
        TablaSup +="</div>";
        $('#divSupervisores').append(TablaSup);   
         $.ajax({
            type: "POST",
            url: "IncidenciaCentroControl/ajax_ObtenerListaSupervisoresXLinea.php",
            data:{"idLineaNegocio":idLineaNegocio},
            dataType: "json",
            async :false,
            success: function(response) {
                if (response.status == "success")
                {
                    var datos = response.datos;
                    $('#SupervisorDinamico_'+idLineaNegocio).empty().append('<option value="0">SUPERVISOR</option>');
                    $.each(datos, function(i) {
                        $("#SupervisorDinamico_"+idLineaNegocio).append('<option value="'+response.datos[i].entidadFederativaId+'-'+response.datos[i].empleadoConsecutivoId+'-'+response.datos[i].empleadoCategoriaId+'">'+response.datos[i].nombreEmpleado+' '+response.datos[i].apellidoPaterno+' '+response.datos[i].apellidoMaterno+'</option>');
                    });
                }
            },error: function(jqXHR, textStatus, errorThrown){
               alert(jqXHR.responseText);
            }
        });   
    }else{
        $('#DivTablaSupervisoresLinea_'+idLineaNegocio).remove(""); 
    }
}
function AgregarSupervisores(idLineaNegocio){ 
    var IdSupervisor = $("#SupervisorDinamico_"+idLineaNegocio).val();
    var NombreSupervisor = $("#SupervisorDinamico_"+idLineaNegocio+" option:selected" ).text();
    var b = $("#tabla_"+idLineaNegocio+" tr").length;
    var e="0";
    if(b>1){
        var c = $("#tabla_"+idLineaNegocio+" td").length;
        for (var j = 0; j < c; j++) {
            var nuevoSup = $("#tabla_"+idLineaNegocio).find("td:eq("+j+")").text();
            var explodeNuevoSup = nuevoSup.split(' ');
            if(explodeNuevoSup[2]==IdSupervisor){
                e="1";
                j=c;
            }
        }
    }
    if(e=="0"){
        var table = document.getElementById("tabla_"+idLineaNegocio);    
        var row = table.insertRow(b);
        var numeorEmp = row.insertCell(0);
        var nombreEmp = row.insertCell(1);
        for (var i = 0; i < b; i++) {
            numeorEmp.innerHTML = " <td > " + (IdSupervisor) + " </td>";
            nombreEmp.innerHTML = " <td > " + (NombreSupervisor) + " </td>";
        }
    }else{
        swal("error","Este Supervisor Ya Esta Seleccionado","error");
    }
    
}

$('#guardarIncidenciaCC').click(function() {
    ValidarYGuardarDatosReporteIncidenciaCC();
});

function ValidarYGuardarDatosReporteIncidenciaCC(){
    var bandera  = "1";
    var NumEmpFirma = $("#NumEmpModalFirmaReporteincidenciaEmpleadohidden").val();
    var constraseniaFirma = $("#constraseniaFirmaParaReporteincidenciaEmpleadoHidden").val();
    var noTestigos = $("#conteoTestigos").val();
    var noTextorec = $("#conteoRecopilacion").val();

    var noTxtRespons= $("#conteoTxtResponsabilidad").val();
    var noTxtOrdenes= $("#conteoTxtOrdenes").val();
    var noTxtEviden = $("#conteoTxtEvidencia").val();
    var noTxtSup    = $("#conteoTxtSupervision").val();
    var especificacion = $("#SelectEspecificacionIncidencia").val();

    if (especificacion==0){
       swal("ESPERA","Seleccione especificación de incidencia","warning"); 
       return;
    }

    if(NumEmpFirma =="" || constraseniaFirma==""){
        $("#modalFirmaReporteincidenciaCC").modal();
    }else{
    
    var IncidenciaAceptacion = $("#SelectIncidenciaAceptacion").val();

    var NumeroGuardiaIncidencia = $("#inpNumeroGuardiaIncidencia").val();
    var NumeroAdministrativoIncidencia = $("#inpNumeroAdministrativoIncidencia").val();
    var EntidadIncidencia = $("#SelectEntidadIncidencia").val();
    var FechaIncidencia = $("#inpFechaIncidencia").val();
    var PuntoServicioIncidencia = $("#SelectPuntoServicioIncidencia").val();
    var PuntoServicioEscritoCC = $("#inpdivPuntoServicioEscritoCC").val();  
    var Testigos = $("#txtAreaTestigos").val();
    var Percataron = $("#txtAreaPercataron").val();
    var Recopilacion = $("#txtAreaRecopilacion").val();
    var Tarea = $("#txtAreaTarea").val();
    var Responsabilidad = $("#txtResponsabilidad").val();
    var Ordenes = $("#txtAreaOrdenes").val();
    var Evidencia = $("#txtAreaEvidencia").val();
    var Supervision = $("#txtAreaSupervision").val();
    var DocIneRobo = $("#DocIneRobo").val();
    var DocTicketRobo = $("#DocTicketRobo").val();
    var DocCotizacionRobo = $("#DocCotizacionRobo").val();
    var DocFichaRobo = $("#DocFichaRobo").val();
    var DocFacturaRobo = $("#DocFacturaRobo").val();
    var DocPapeletaRobo = $("#DocPapeletaRobo").val();
    var DocEvidenciaRobo = $("#DocEvidenciaRobo").val();
    var DocIneDaños = $("#DocIneDaños").val();
    var DocCotizacionDaños = $("#DocCotizacionDaños").val();
    var DocFichaDaños = $("#DocFichaDaños").val();
    var DocDictamenDaños = $("#DocDictamenDaños").val();
    var DocFacturaDaños = $("#DocFacturaDaños").val();
    var DocPapeletaDaños = $("#DocPapeletaDaños").val();
    var DocEvidenciaDaños = $("#DocEvidenciaDaños").val();
    var DocTicketRecuperaciones = $("#DocTicketRecuperaciones").val();
    var DocReconocimientoRecuperaciones = $("#DocReconocimientoRecuperaciones").val();
    var DocEvidenciaRecuperaciones = $("#DocEvidenciaRecuperaciones").val();
    var DocIneFaltas = $("#DocIneFaltas").val();
    var DocActaFaltas = $("#DocActaFaltas").val();
    var DocEvidenciaFaltas = $("#DocEvidenciaFaltas").val();
    var DocIneSiniestros = $("#DocIneSiniestros").val();
    var DocCotizacionSiniestros = $("#DocCotizacionSiniestros").val();
    var DocFichaSiniestros = $("#DocFichaSiniestros").val();
    var DocDictamenSiniestros = $("#DocDictamenSiniestros").val();
    var DocDenunciaSiniestros = $("#DocDenunciaSiniestros").val();
    var DocTicketSiniestros = $("#DocTicketSiniestros").val();
    var DocPapeletaSiniestros = $("#DocPapeletaSiniestros").val();
    var DocEvidenciaSiniestros = $("#DocEvidenciaSiniestros").val();

    var procedeSiCC = document.getElementById("procedeSi").checked;
    var ExistepuntoNo = document.getElementById("ExistepuntoNo").checked;
    var existepuntoSi = document.getElementById("ExistepuntoSi").checked;
    var NombreGuardiaIncidencia = $("#inpNombreGuardiaIncidencia").val();
    var NombreAdministrativoIncidencia = $("#inpNombreAdministrativoIncidencia").val();
    
    if(IncidenciaAceptacion == "0" || IncidenciaAceptacion == ""){
        swal("ESPERA","Seleccione El Tipo De Incidencia Del Reporte A Generar","warning");    
    }else if(NumeroGuardiaIncidencia==""){
        swal("ESPERA","Indique El Número Del Empleado por El Cúal Se Va A Generar El Reporte","warning");            
    }else if(NumeroGuardiaIncidencia!="" && NombreGuardiaIncidencia==""){
        swal("ESPERA","Indique CORRECTAMENTE El Número Del Empleado por El Cúal Se Va A Generar El Reporte (PRESIONE ENTER AL TERMINAR DE DIGITARLO)","warning");            
    }else if(NumeroAdministrativoIncidencia == ""){
        swal("ESPERA","Indique El Numero Del Administrativo Que Esta Generando El Reporte","warning");            
    }else if(NumeroAdministrativoIncidencia != "" && NombreAdministrativoIncidencia==""){
        swal("ESPERA","Indique CORRECTAMENTE El Numero Del Administrativo Que Esta Generando El Reporte (PRESIONE ENTER AL TERMINAR DE DIGITARLO)","warning");            
    }else if(EntidadIncidencia == "0" || EntidadIncidencia == ""){
        swal("ESPERA","Seleccione La Entidad Donde Ocurrio La Incidencia","warning");            
    }else if(FechaIncidencia == ""){
        swal("ESPERA","La Fecha DeCuando Ocurrio La Incidencia","warning");            
    }else if(existepuntoSi === false && ExistepuntoNo === false){
        swal("ESPERA","Seleccione Si Existe El Punto De Servicio Donde Ocurrio La Incidencia","warning");            
    }else if(existepuntoSi === true && PuntoServicioIncidencia =="0"){
        swal("ESPERA","Seleccione El Punto De Servicio Donde Ocurrio La Incidencia","warning");            
    }else if(ExistepuntoNo === true && PuntoServicioEscritoCC == ""){
        swal("ESPERA","Inidque El Punto De Servicio Donde Ocurrio La Incidencia","warning");            
    }else {
        if($('#procedeSi').is(":checked")) {
            var totalChecksLinea = $("#ChecksLineaNegociohidden").val();
            var lineas = new Array();
            for (var i = 1; i <= totalChecksLinea; i++) {
                if($('#'+i+'').is(":checked")) {
                    lineas[i-1]=[i];
                }
            }    
            if(lineas > "0"){       
                for (var j = 0; j < lineas.length; j++) {
                    var largoTablaIngresada = $("#tabla_"+lineas[j]+" td").length;
                    if(largoTablaIngresada!="0"){
                        var lineaN = lineas[j];
                        var l =0;
                        for (var k = 0; k < largoTablaIngresada; k++) {
                            var datosTabla = $("#tabla_"+lineas[j]).find("td:eq("+k+")").text();
                            var datoDepurado = datosTabla.slice(2,-1);// ya que el dato trae dos espacios en blanco al incio y uno al final
                            lineas[j][k+1] = datoDepurado;
                            lineas[j][k+1] = datoDepurado;
                        }
                    }else{
                        bandera="2";
                    }
                }
            }else{
                bandera="3";
            }
        }else if($('#procedeNo').is(":checked")) {
            var MotivoCancelacion = $("#SelectMotivoCancelacion").val();
            if(MotivoCancelacion == "0" || MotivoCancelacion == ""){
                swal("ESPERA","Seleccione El Motivo Por El Cual El Reporte No Procederá","warning");   
                bandera="0"; 
            }
        }
        if(bandera =="1"){
            
            var formData = new FormData($("#formDocReposrteIncCC")[0]);
            
            for (var g = 1; g <= noTestigos; g++) {
                formData.append('testigo'+g, $("#txtAreaTestigos"+g).val());
            }

            for (var h = 1; h <= noTextorec; h++) {
                formData.append('recopilacion'+h, $("#txtAreaRecopilacion"+h).val());
            }

            for (var l = 1; l <= noTxtRespons; l++) {
                formData.append('responsabilidad'+l, $("#txtResponsabilidad"+l).val());
            }
           for (var m = 1; m <= noTxtOrdenes; m++) {
                formData.append('ordenes'+m, $("#txtAreaOrdenes"+m).val());
            }
            for (var n = 1; n <= noTxtEviden; n++) {
                formData.append('evidencia'+n, $("#txtAreaEvidencia"+n).val());
            }
            for (var o = 1; o <= noTxtSup; o++) {
                formData.append('supervision'+o, $("#txtAreaSupervision"+o).val());
            }

            formData.append('noTestigos', noTestigos);
            formData.append('noTextorec', noTextorec);

            formData.append('noTxtRespons', noTxtRespons);
            formData.append('noTxtOrdenes', noTxtOrdenes);
            formData.append('noTxtEviden', noTxtEviden);
            formData.append('noTxtSup', noTxtSup);

            formData.append('lineas', lineas);
            formData.append('IncidenciaAceptacion', IncidenciaAceptacion);
            formData.append('NumeroGuardiaIncidencia', NumeroGuardiaIncidencia);
            formData.append('NumeroAdministrativoIncidencia', NumeroAdministrativoIncidencia);
            formData.append('EntidadIncidencia', EntidadIncidencia);
            formData.append('FechaIncidencia', FechaIncidencia);
            formData.append('PuntoServicioIncidencia', PuntoServicioIncidencia);
            formData.append('PuntoServicioEscritoCC', PuntoServicioEscritoCC);
            formData.append('Testigos', Testigos);
            formData.append('Percataron', Percataron);
            formData.append('Recopilacion', Recopilacion);
            formData.append('Tarea', Tarea);
            formData.append('Responsabilidad', Responsabilidad);
            formData.append('Ordenes', Ordenes);
            formData.append('Evidencia', Evidencia);
            formData.append('Supervision', Supervision);
            formData.append('NumEmpFirma', NumEmpFirma);
            formData.append('constraseniaFirma', constraseniaFirma);
            formData.append('MotivoCancelacion', MotivoCancelacion);
            formData.append('existepuntoSi', existepuntoSi);
            formData.append('procedeSiCC', procedeSiCC);
            formData.append('especificacion', especificacion);

            $.ajax({
            type: "POST",
            url: "IncidenciaCentroControl/ajax_GuardarDatosReporteIncidenciaCC.php",
            data:formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status == "success"){
                    swal("GRACIAS","Se ha registrado con exito el reporte de incidencia", "success");  
                    $("#formDocReposrteIncCC")[0].reset();
                    $('#SelectEspecificacionIncidencia').empty().append('<option value="0">ESPECIFICACIÓN</option>'); 
                    LimpiarFormularioReporteIncidenciaCC();
                }else if (response.status == "error"){
                    var mensaje = response.message;
                    swal("Alto",mensaje, "error");   
                }
            },error: function(jqXHR, textStatus, errorThrown){
               alert(jqXHR.responseText);
            }
        });   
        }else if(bandera =="2"){
            swal("ESPERA","Seleccione los supervisores de las lineas de negocio seleccionadas que podrán ver el reporte generado","warning");   
        }else if(bandera =="3"){
            swal("ESPERA","Seleccione una linea de negocio a la que se mandará su reporte","warning");;   
        }else {
            swal("ERROR","Error Al procedar Los Datos Favor De Revisar Los Datos Ingresados !!","error");   
        }
    }
  }
}
function LimpiarFormularioReporteIncidenciaCC(){
    $("#SelectIncidenciaAceptacion").val(0);
    $("#inpNumeroGuardiaIncidencia").val("");
    $("#inpNombreGuardiaIncidencia").val("");
    $("#inpPuestoGuardiaIncidencia").val("");
    $("#inpPuestoGuardiaIncidenciahidden").val("");
    $("#inpNumeroAdministrativoIncidencia").val("");
    $("#inpNombreAdministrativoIncidencia").val("");
    $("#inpPuestoAdministrativoIncidencia").val("");
    $("#inpPuestoAdministrativoIncidenciahidden").val("");
    $("#SelectEntidadIncidencia").val(0);
    $("#inpFechaIncidencia").val("");
    $("#ExistepuntoSi").prop("checked", false); 
    $("#SelectPuntoServicioIncidencia").val(0);
    $("#ExistepuntoNo").prop("checked", false);
    $("#inpdivPuntoServicioEscritoCC").val("");
    $("#txtAreaTestigos").val("");
    $("#txtAreaPercataron").val("");
    $("#txtAreaRecopilacion").val("");
    $("#txtAreaTarea").val("");
    $("#txtResponsabilidad").val("");
    $("#txtAreaOrdenes").val("");
    $("#txtAreaEvidencia").val("");
    $("#txtAreaSupervision").val("");
    $("#DocIneRobo").val("");
    $("#DocTicketRobo").val("");
    $("#DocCotizacionRobo").val("");
    $("#DocFichaRobo").val("");
    $("#DocFacturaRobo").val("");
    $("#DocPapeletaRobo").val("");
    $("#DocEvidenciaRobo").val("");
    $("#DocIneDaños").val("");
    $("#DocCotizacionDaños").val("");
    $("#DocFichaDaños").val("");
    $("#DocDictamenDaños").val("");
    $("#DocFacturaDaños").val("");
    $("#DocPapeletaDaños").val("");
    $("#DocEvidenciaDaños").val("");
    $("#DocTicketRecuperaciones").val("");
    $("#DocReconocimientoRecuperaciones").val("");
    $("#DocEvidenciaRecuperaciones").val("");
    $("#DocIneFaltas").val("");
    $("#DocActaFaltas").val("");
    $("#DocEvidenciaFaltas").val("");
    $("#DocIneSiniestros").val("");
    $("#DocCotizacionSiniestros").val("");
    $("#DocFichaSiniestros").val("");
    $("#DocDictamenSiniestros").val("");
    $("#DocDenunciaSiniestros").val("");
    $("#DocTicketSiniestros").val("");
    $("#DocPapeletaSiniestros").val("");
    $("#DocEvidenciaSiniestros").val("");

    $("#txtAreaTestigos1").val("");
    $("#txtAreaTestigos2").val("");
    $("#txtAreaTestigos2").hide();
    $("#caracteresT2").hide();
    $("#txtAreaTestigos3").val("");
    $("#txtAreaTestigos3").hide();
    $("#caracteresT3").hide();
    $("#txtAreaTestigos4").val("");
    $("#txtAreaTestigos4").hide();
    $("#caracteresT4").hide();
    $("#txtAreaTestigos5").val("");
    $("#txtAreaTestigos5").hide();
    $("#caracteresT5").hide();
    $("#txtAreaTestigos6").val("");
    $("#txtAreaTestigos6").hide();
    $("#caracteresT6").hide();
    $("#txtAreaTestigos7").val("");
    $("#txtAreaTestigos7").hide();
    $("#caracteresT7").hide();
    $("#eliminarTestigo").hide();

    $("#txtAreaPercataron").val("");

    $("#txtAreaRecopilacion1").val("");
    $("#txtAreaRecopilacion2").val("");
    $("#txtAreaRecopilacion2").hide();
    $("#caracteresR2").hide();
    $("#txtAreaRecopilacion3").val("");
    $("#txtAreaRecopilacion3").hide();
    $("#caracteresR3").hide();
    $("#txtAreaRecopilacion4").val("");
    $("#txtAreaRecopilacion4").hide();
    $("#caracteresR4").hide();
    $("#txtAreaRecopilacion5").val("");
    $("#txtAreaRecopilacion5").hide();
    $("#caracteresR5").hide();
    $("#txtAreaRecopilacion6").val("");
    $("#txtAreaRecopilacion6").hide();
    $("#caracteresR6").hide();
    $("#txtAreaRecopilacion7").val("");
    $("#txtAreaRecopilacion7").hide();
    $("#caracteresR7").hide();
    $("#txtAreaRecopilacion8").val("");
    $("#txtAreaRecopilacion8").hide();
    $("#caracteresR8").hide();
    $("#txtAreaRecopilacion9").val("");
    $("#txtAreaRecopilacion9").hide();
    $("#caracteresR9").hide();
    $("#txtAreaRecopilacion10").val("");
    $("#txtAreaRecopilacion10").hide();
    $("#caracteresR10").hide();
    $("#eliminarRecopilacion").hide();

    $("#txtAreaTarea").val("");

    $("#txtResponsabilidad1").val("");
    $("#txtResponsabilidad2").val("");
    $("#txtResponsabilidad2").hide();
    $("#caracteresRP2").hide();
    $("#eliminarTextoResponsabilidad").hide();

    $("#txtAreaOrdenes1").val("");
    $("#txtAreaOrdenes2").val("");
    $("#txtAreaOrdenes2").hide();
    $("#caracteresO2").hide();
    $("#eliminarTextoOrdenes").hide();

    $("#txtAreaEvidencia1").val("");
    $("#txtAreaEvidencia2").val("");
    $("#txtAreaEvidencia2").hide();
    $("#caracteresE2").hide();
    $("#eliminarTextoEvidencia").hide();

    $("#txtAreaSupervision1").val("");
    $("#txtAreaSupervision2").val("");
    $("#txtAreaSupervision2").hide();
    $("#caracteresSP2").hide();
    $("#eliminarTextoSupervision").hide();

    $("#span1").hide();
    $("#span2").hide();
    $("#span3").hide();
    $("#span4").hide();
    $("#span5").hide();
    $("#span6").hide();
    $("#span7").hide();
    $("#span8").hide();
    $("#span9").hide();
    $("#span10").hide();
    $("#span11").hide();
    $("#span12").hide();
    $("#span13").hide();
    $("#span14").hide();
    $("#span15").hide();
    $("#span16").hide();
    $("#span17").hide();
    $("#span18").hide();
    $("#span19").hide();

    $("#span20").hide();
    $("#span21").hide();
    $("#span22").hide();
    $("#span23").hide();
    $("#span24").hide();
    $("#span25").hide();
    $("#span26").hide();
    $("#span27").hide();

    $("#agregarTestigo").show();
    $("#agregarRecopilacion").show();
    $("#AgregarTextoResponsabilidad").show();
    $("#AgregarTextoOrdenes").show();
    $("#AgregarTextoEvidencia").show();
    $("#AgregarTextoSupervision").show();

    $("#procedeNo").prop("checked", false);
    $("#procedeSi").prop("checked", false); 
    removerSelectoresSup();
    $("#dviprocedeNo").hide();
    $("#dviprocedeSi").hide();
    $("#divChecksLineaNegocio").html("");
    $("#divBtnIncidenciaCc").hide();

}
////////////////////Se agrega firma interna para un mejor control de incidencias ////////////////////////

function RevisarFirmaInternaParaReingresoEmpleado(){
   var NumEmpModalBaja = $("#NumEmpModalFirmaReporteincidenciaEmpleado").val();
   var constraseniaFirma = $("#constraseniaFirmaParaReporteincidenciaEmpleado").val();
   if(NumEmpModalBaja==""){
      cargaerroresFirmaInternaReporteIncidenciaCC("El numero de empleado no puede estar vacio");
   }else if(constraseniaFirma==""){
      cargaerroresFirmaInternaReporteIncidenciaCC("Escriba la contraseña para continuar");
   }else{
      $.ajax({
         type: "POST",
         url: "ConsultaEmpleado/ajax_getFirmaSolicitada.php",
         data: {"NumEmpModalBaja":NumEmpModalBaja,"constraseniaFirma":constraseniaFirma},
         dataType: "json",
         success: function(response) {
            if (response.status == "success")
            {
               var RespuestaLargo = response["datos"].length;
               if(RespuestaLargo == "0"){
                  cargaerroresFirmaInternaReporteIncidenciaCC("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro");
               }else{
                  var contraseniaInsertadaCifrada = response.datos["0"].ContraseniaFirma;
                  $("#constraseniaFirmaParaReporteincidenciaEmpleadoHidden").val(contraseniaInsertadaCifrada);
                  $("#NumEmpModalFirmaReporteincidenciaEmpleadohidden").val(NumEmpModalBaja);
                  $("#modalFirmaReporteincidenciaCC").modal("hide");
                  $("#NumEmpModalFirmaReporteincidenciaEmpleado").val("");
                  $("#constraseniaFirmaParaReporteincidenciaEmpleado").val("");
                  ValidarYGuardarDatosReporteIncidenciaCC();
               }
           }
         },
         error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
         }
      });
   }
}

function cargaerroresFirmaInternaReporteIncidenciaCC(mensaje){
  $('#errormodalFirmaReporteincidenciaCC').fadeIn();
  msjerrorbaja="<div id='errormodalFirmaReporteincidenciaCC1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errormodalFirmaReporteincidenciaCC").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errormodalFirmaReporteincidenciaCC').delay(4000).fadeOut('slow'); 
}

function cancelarFirmaParaReingresoEmpleado(){

  $("#modalFirmaReporteincidenciaCC").modal("hide");
  $("#NumEmpModalFirmaReporteincidenciaEmpleado").val("");
  $("#constraseniaFirmaParaReporteincidenciaEmpleado").val("");
}



//////////////////////////////////////////////////////////////////////////////////////////////
