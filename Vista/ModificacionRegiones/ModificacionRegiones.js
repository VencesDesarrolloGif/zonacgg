$(document).ready(function() {
    $("#listaEntidadesAsignadas").html ("");
    $("#listaEntidadesPorAsignar").html ("");
    $("#divListaentidadesAsignadasLineal").hide();
    $("#divListaentidadesPorAsignadasLineal").hide();
    CargarRegiones();
    CargarLineaDeNegocioParaRegiones();
    CargaRegionesAtuales();
    CargaRegioneInactivas();
});
//************************************** Inicia Agregar O Eliminar Entidades A Region ****************************************//
function CargarRegiones(){
    $.ajax({
      type: "POST",
      url: "ModificacionRegiones/ajax_getcatalogoRegiones.php",
      dataType: "json",
      async: false,
      success: function(response) {
        $("#SelectRegiones").empty().append('<option value="0">REGIONES</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#SelectRegiones').append('<option value="' + (response.datos[i].IdRegiones) + '">' + response.datos[i].DescripcionRegiones + '</option>');
          }
        }else{
          CargarMensajeRegionesEdicion("Error al cargar las regiones","error");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    }); 
}  
function CargarLineaDeNegocioParaRegiones(){
    $.ajax({
      type: "POST",
      url: "ModificacionRegiones/ajax_getLineaNegocioPAraRegiones.php",
      dataType: "json",
      async: false,
      success: function(response) {
        $("#SelectLineaNegocioRegion").empty().append('<option value="0">LINEA NEGOCIO</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#SelectLineaNegocioRegion').append('<option value="' + (response.datos[i].idLineaNegocio) + '">' + response.datos[i].descripcionLineaNegocio + '</option>');
          }
        }else{
          CargarMensajeRegionesEdicion("Error al cargar las lineas de negocio","error");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    }); 
}  
$("#SelectRegiones").change(function(event) {
    $("#listaEntidadesAsignadas").html ("");
    $("#listaEntidadesPorAsignar").html ("");
    $("#divListaentidadesAsignadasLineal").hide();
    $("#divListaentidadesPorAsignadasLineal").hide();
});

$("#SelectLineaNegocioRegion").change(function(event) {
    $("#listaEntidadesAsignadas").html ("");
    $("#listaEntidadesPorAsignar").html ("");
    $("#divListaentidadesAsignadasLineal").hide();
    $("#divListaentidadesPorAsignadasLineal").hide();
});

$("#btnObtenerREgionesYEntidades").click(function(event) {
    var SelectRegiones =$("#SelectRegiones").val();
    var SelectLineaNegocioRegion =$("#SelectLineaNegocioRegion").val();
    if(SelectRegiones == "" || SelectRegiones == "0" || SelectRegiones == 0){
        CargarMensajeRegionesEdicion("Debes seleccionar la region a buscar","error");
        $("#divListaentidadesAsignadasLineal").hide();
        $("#divListaentidadesPorAsignadasLineal").hide();
    }else if(SelectLineaNegocioRegion == "" || SelectLineaNegocioRegion == "0" || SelectLineaNegocioRegion == 0){
        CargarMensajeRegionesEdicion("Debes seleccionar la linea de negocio de la region","error");
        $("#divListaentidadesAsignadasLineal").hide();
        $("#divListaentidadesPorAsignadasLineal").hide();
    }else{
        $("#divListaentidadesAsignadasLineal").hide();
        $("#divListaentidadesPorAsignadasLineal").hide();
        ObtenerEntidades(SelectRegiones,SelectLineaNegocioRegion)
    }
});

function ObtenerEntidades(SelectRegiones,SelectLineaNegocioRegion){
    waitingDialog.show();
    $.ajax({
        type: "POST",
        url: "ModificacionRegiones/ajax_obtenerEntidadesPorRegion.php",
        data: {"SelectRegiones":SelectRegiones,"SelectLineaNegocioRegion":SelectLineaNegocioRegion},
        dataType: "json",
        async: false,
        success: function(response) {
            if(response.status == "success") {
                $("#listaEntidadesAsignadas").html ("");
                var EntidadesReg = "";
               for (var i = 0; i < response.datos.length; i++) {
                    var idEntidadI = response.datos[i].idEntidadI;
                    var nombreEntidadFederativa = response.datos[i].nombreEntidadFederativa;
                    EntidadesReg += "<li class='class'>" + nombreEntidadFederativa + "";
                    EntidadesReg +="<span class='input-group-addon cursorImg' onclick='eliminarAgregarEntidadDeRegion("+idEntidadI+" ,1);' >x</span></li>";
                }
                waitingDialog.hide();
                $("#listaEntidadesAsignadas").html(EntidadesReg);
                $("#divListaentidadesAsignadasLineal").show();                
            }else{
                $("#divListaentidadesAsignadasLineal").hide();                
                var mensaje = response.message;
                CargarMensajeRegionesEdicion(mensaje,"error");
                waitingDialog.hide();
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
             waitingDialog.hide();
             $("#divListaentidadesAsignadasLineal").hide();                
         }
    });
    $.ajax({
        type: "POST",
        url: "ModificacionRegiones/ajax_obtenerEntidadesPorRegionParaAsignar.php",
        data: {"SelectRegiones":SelectRegiones,"SelectLineaNegocioRegion":SelectLineaNegocioRegion},
        dataType: "json",
        async: false,
        success: function(response) {
            if(response.status == "success") {
                $("#listaEntidadesPorAsignar").html ("");
                var EntidadesReg = "";
               for (var i = 0; i < response.datos.length; i++) {
                    var idEntidadI = response.datos[i].idEntidadFederativa;
                    var nombreEntidadFederativa = response.datos[i].nombreEntidadFederativa;
                    EntidadesReg += "<li class='class'>" + nombreEntidadFederativa + "";
                    EntidadesReg +='<span class="input-group-addon cursorImg" onclick="eliminarAgregarEntidadDeRegion('+idEntidadI+' ,2);" >+</span></li>';
                }
                waitingDialog.hide();
                $("#listaEntidadesPorAsignar").html(EntidadesReg);
                $("#divListaentidadesPorAsignadasLineal").show();
            }else{
                $("#divListaentidadesPorAsignadasLineal").hide();
                var mensaje = response.message;
                CargarMensajeRegionesEdicion(mensaje,"error");
                waitingDialog.hide();
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
             waitingDialog.hide();
             $("#divListaentidadesPorAsignadasLineal").hide();
         }
    });
    $(document).scrollTop(0);
}
function eliminarAgregarEntidadDeRegion(entidad1,opcion){
    if(entidad1 < 10){
        var entidad = "0"+entidad1; 
    }else{
        var entidad = entidad1; 
    }
    var SelectRegiones =$("#SelectRegiones").val();
    var textoRegion= $('select[name="SelectRegiones"] option:selected').text();
    var SelectLineaNegocioRegion =$("#SelectLineaNegocioRegion").val();
    $.ajax({
        type: "POST",
        url: "ModificacionRegiones/ajax_AgregarEliminarEntidadRegion.php",
        data: {"SelectRegiones":SelectRegiones,"SelectLineaNegocioRegion":SelectLineaNegocioRegion,"entidad":entidad,"opcion":opcion,"textoRegion":textoRegion},
        dataType: "json",
        async: false,
        success: function(response) {
            if(response.status == "success") {
               ObtenerEntidades(SelectRegiones,SelectLineaNegocioRegion);
            }else{
                CargarMensajeRegionesEdicion(mensaje,"error");    
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
    });
}
//************************************** Termina Agregar O Eliminar Entidades A Region ****************************************//
function CargarMensajeRegionesEdicion(mensaje,Tipo){
  $('#MensajeRegionesEdicion1').fadeIn();
  msjerrorbaja="<div id='MensajeRegionesEdicion1' class='alert alert-"+Tipo+"'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#MensajeRegionesEdicion").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#MensajeRegionesEdicion1').delay(4000).fadeOut('slow'); 
}
//************************************** Inicia Agregar O Eliminar Una Region **************************************************//
function CargaRegionesAtuales(){
    $.ajax({
        type: "POST",
        url: "ModificacionRegiones/ajax_getcatalogoRegiones.php",
        dataType: "json",
        async: false,
        success: function(response) {
            if(response.status == "success") {
                $("#listaRegionesExistentes").html ("");
                var regionesR = "";
               for (var i = 0; i < response.datos.length; i++) {
                    var IdRegiones = response.datos[i].IdRegiones;
                    var DescripcionRegiones = response.datos[i].DescripcionRegiones;
                    regionesR += "<li class='class'>" + DescripcionRegiones + "";
                    regionesR +='<span class="input-group-addon cursorImg" onclick="validarRegion('+IdRegiones+');" >x</span></li>';
                }
                waitingDialog.hide();
                $("#listaRegionesExistentes").html(regionesR);
                $("#divListaRegionesGrl").show();
            }else{
                $("#divListaRegionesGrl").hide();
                var mensaje = response.message;
                CargarMensajeRegionesEdicion(mensaje,"error");
                waitingDialog.hide();
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
             waitingDialog.hide();
             $("#divListaRegionesGrl").hide();
         }
    });
}

function CargaRegioneInactivas(){
    $.ajax({
        type: "POST",
        url: "ModificacionRegiones/ajax_getRegionesActuales.php",
        dataType: "json",
        async: false,
        success: function(response) {
            if(response.status == "success") {
                $("#listaRegionesInactivas").html ("");
                var regionesInactivasR = "";
               for (var i = 0; i < response.datos.length; i++) {
                    var IdRegiones = response.datos[i].IdRegiones;
                    var DescripcionRegiones = response.datos[i].DescripcionRegiones;
                    regionesInactivasR += "<li class='class'>" + DescripcionRegiones + "";
                    regionesInactivasR +='<span class="input-group-addon cursorImg" onclick="eliminarAgregarRegion('+IdRegiones+',3);" >+</span></li>';
                }
                waitingDialog.hide();
                $("#listaRegionesInactivas").html(regionesInactivasR);
                $("#divListaRegionesGrlInactiva").show();
            }else{
                $("#divListaRegionesGrlInactiva").hide();
                var mensaje = response.message;
                CargarMensajeRegionesEdicion(mensaje,"error");
                waitingDialog.hide();
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
             waitingDialog.hide();
             $("#divListaRegionesGrlInactiva").hide();
         }
    });
}
function validarRegion(idRegion){
    $.ajax({
        type: "POST",
        url: "ModificacionRegiones/ajax_getEntidadesEnRegionEspecifica.php",
        data: {"idRegion":idRegion},
        dataType: "json",
        async: false,
        success: function(response) {
            var largoentidades = response.datos.length;
            if(largoentidades == "0"){
                eliminarAgregarRegion(idRegion,"2");
            }else{
                swal("Error","La region que intenta eliminar cuenta con "+ largoentidades + " entidades asignadas debe quitar la asignacion para continuar","error");
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
        }
    });
}
$("#btnGuardarRegion").click(function(event) {
    
    var inpNewRegion =$("#inpNewRegion").val();
    if(inpNewRegion == ""){
        CargarMensajeRegionesEdicion("Debes ingresar la nueva region","error");
    }else{
        eliminarAgregarRegion(inpNewRegion,"1");
    }
});
function eliminarAgregarRegion(idRegion,opcion){
    $.ajax({
        type: "POST",
        url: "ModificacionRegiones/ajax_AgregarEliminarRegion.php",
        data: {"idRegion":idRegion,"opcion":opcion},
        dataType: "json",
        async: false,
        success: function(response) {
            if(response.status == "success") {
                $("#listaEntidadesAsignadas").html ("");
                $("#listaEntidadesPorAsignar").html ("");
                $("#divListaentidadesAsignadasLineal").hide();
                $("#divListaentidadesPorAsignadasLineal").hide();
                CargarRegiones();
                CargaRegionesAtuales();
                CargaRegioneInactivas();
                $('#SelectLineaNegocioRegion').val(0);
            }else{
                CargarMensajeRegionesEdicion(mensaje,"error");    
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
    });
}


//************************************** Termina Agregar O Eliminar Una Region **************************************************//
