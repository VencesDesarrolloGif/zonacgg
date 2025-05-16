$("#selectMovimiento").change(function(){
  var tipoSeleccion=$("#selectMovimiento").val();

  if(tipoSeleccion=='1'){//Agregar
     waitingDialog.show();
     $("#divTablaAgregarSucursal").show();
     $("#divTablaDarDeBajaSucursal").hide();
     $("#divTablaActivarSucursal").hide();
     cargarEntidadSucursal();
  }else if (tipoSeleccion=='2'){//Dar de baja
        waitingDialog.show();
        $("#divTablaDarDeBajaSucursal").show();
        $("#divTablaAgregarSucursal").hide();
        $("#divTablaActivarSucursal").hide();
        cargarEntidadSucursalAeliminar();
  }else if (tipoSeleccion=='3'){//ACTIVAR
        waitingDialog.show();
        $("#divTablaActivarSucursal").show();
        $("#divTablaDarDeBajaSucursal").hide();
        $("#divTablaAgregarSucursal").hide();
        cargarEntidadSucursalACTIVAR();
  }else if(tipoSeleccion=='0'){//externa
          $("#divTablaDarDeBajaSucursal").hide();
          $("#divTablaAgregarSucursal").hide();
          $("#divTablaActivarSucursal").hide();
          limpiarCampos();
  }
});

function cargarEntidadSucursal(){

    $.ajax({            
        type:"POST",
        url: "sucursalesInternas/ajax_consultaEntidades.php",
        dataType: "json",
        success: function(response) {
          var datos = response.datos;
          var Largodatos = response.datos.length;
          $('#entidadAPertenecer').empty().append('<option value="0" selected="selected">ENTIDAD</option>');
          $.each(datos, function(i){
              $('#entidadAPertenecer').append('<option value="' + response.datos[i].idEntidadFederativa+'">' + response.datos[i].nombreEntidadFederativa + '</option>');
          });
          waitingDialog.hide();     
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();     
        }
    }); 
}

$("#btnAgregarSucursal").click(function(){

  var entidad=$("#entidadAPertenecer").val();
  var sucursalNueva=$("#nombreSucursalAgregar").val();
  sucursalNuevaMayusculas = sucursalNueva.toUpperCase();

  if(entidad=='0'){//Agregar
    var mensaje="Seleccione la entidad a la que pertenecerá esta sucursal";
    cargarmensajeSucursal(mensaje,"error");
  }else if (sucursalNuevaMayusculas==''){//externa
    var mensaje="Escriba el nombre de la nueva sucursal";
    cargarmensajeSucursal(mensaje,"error");
  }

  $.ajax({            
      type:"POST",
      url: "sucursalesInternas/ajax_consultaSucursal.php",
      data:{'sucursalNueva': sucursalNuevaMayusculas},
      dataType: "json",
      success: function(response) {
        if(response.datos[0]["totalSucursal"]=="0"){
            insertarSucursal(entidad,sucursalNuevaMayusculas);
        }else{
            waitingDialog.hide(); 
            var mensaje="Ya hay una sucursal existente con este nombre";
            cargarmensajeSucursal(mensaje,"error");
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
          waitingDialog.hide();     
      }
  });
});

function insertarSucursal(entidad,sucursalNueva){

    $.ajax({            
          type:"POST",
          url: "sucursalesInternas/ajax_InsertarSucursal.php",
          data: {"entidad": entidad,"sucursalNueva": sucursalNueva},
          dataType: "json",
          success: function(response){
            var mensaje=response.mensaje;
            if(response.status=="success"){
               waitingDialog.hide();
               cargarmensajeSucursal(mensaje,"success");
               $("#divTablaAgregarSucursal").modal("hide");
               limpiarCampos();
            }else if(response.status=="error"){
                waitingDialog.hide();
                cargarmensajeSucursal(mensaje,"error");  
            }                 
          },
          error: function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText);
                waitingDialog.hide(); 
          }
    });
}

function cargarmensajeSucursal(mensaje,status){
  $('#divMensajeSucursales').fadeIn('slow');
  mensajeErrorP="<div id='msgAlert' class='alert alert-"+status+"'>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
  $("#divMensajeSucursales").html(mensajeErrorP);
  $(document).scrollTop(0);
  $('#divMensajeSucursales').delay(3000).fadeOut('slow');
}

function limpiarCampos(){
  $("#entidadAPertenecer").val(0);      
  $("#nombreSucursalAgregar").val("");
  $("#entidadQuePertenece").val(0);
  $("#sucursalAEliminar").val(0);
  $("#sucursalAEliminar").val("");
  $("#entidadPerteneciente").val(0);
  $("#sucursalActivar").val(0);
  $("#sucursalActivar").val("");
}

///////////////ELIMINAR SUCURSAL////////////////////

function cargarEntidadSucursalAeliminar(){

    $.ajax({            
      type:"POST",
      url: "sucursalesInternas/ajax_consultaEntidades.php",
      dataType: "json",
      success: function(response) {
        var datos = response.datos;
        var Largodatos = response.datos.length;
        $('#entidadQuePertenece').empty().append('<option value="0" selected="selected">ENTIDAD</option>');
        $.each(datos, function(i){
            $('#entidadQuePertenece').append('<option value="' + response.datos[i].idEntidadFederativa+'">' + response.datos[i].nombreEntidadFederativa + '</option>');
        });
        waitingDialog.hide();     
      },
      error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
          waitingDialog.hide();     
      }
    }); 
}

$("#entidadQuePertenece").change(function(){
  waitingDialog.show();

  var entidadElegida=$("#entidadQuePertenece").val();
  $('#sucursalAEliminar').empty();
    $.ajax({            
      type:"POST",
      url: "sucursalesInternas/ajax_consultaSucursales.php",
      data:{'entidad': entidadElegida},
      dataType: "json",
      success: function(response) {
        var datos = response.datos;
        var Largodatos = response.datos.length;
        if(Largodatos!=0 && Largodatos!=null && Largodatos!='NULL' && Largodatos!='null'){
            $('#sucursalAEliminar').empty().append('<option value="0" selected="selected">SUCURSAL</option>');
            $.each(datos, function(i){
                $('#sucursalAEliminar').append('<option value="' + response.datos[i].idSucursalI+'">' + response.datos[i].nombreSucursal + '</option>');
            });
            waitingDialog.hide();     
        }else if(Largodatos=='0'){
            $('#sucursalAEliminar').empty().append('<option value="0" selected="selected">SUCURSAL</option>');
            var mensaje="La entidad seleccionada no cuenta con sucursales activas";
            cargarmensajeSucursal(mensaje,"error");
            waitingDialog.hide();
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
          waitingDialog.hide();     
      }
    });
  
});


$("#btnEliminarSucursal").click(function(){
  waitingDialog.show();
  var sucursalAEliminar=$("#sucursalAEliminar").val();

  if(sucursalAEliminar=='0'){
    waitingDialog.hide();
    var mensaje="Seleccione una sucursal";
    cargarmensajeSucursal(mensaje,"error");
    return;
  }

    $.ajax({            
      type:"POST",
      url: "sucursalesInternas/ajax_EliminarSucursal.php",
      data:{'sucursal': sucursalAEliminar},
      dataType: "json",
      success: function(response) {
       var mensaje=response.mensaje;
            if(response.status=="success"){
               waitingDialog.hide();
               cargarmensajeSucursal(mensaje,"success");
               $("#divTablaDarDeBajaSucursal").modal("hide");
               limpiarCampos();
               $('#sucursalAEliminar').empty().append('<option value="0" selected="selected">SUCURSAL</option>');
            }else if(response.status=="error"){
                waitingDialog.hide();
                cargarmensajeSucursal(mensaje,"error");  
            } 
      },
      error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
          waitingDialog.hide();     
      }
    });
});

///////////////ACTIVAR SUCURSAL////////////////////

function cargarEntidadSucursalACTIVAR(){

    $.ajax({            
      type:"POST",
      url: "sucursalesInternas/ajax_consultaEntidades.php",
      dataType: "json",
      success: function(response) {
        var datos = response.datos;
        var Largodatos = response.datos.length;
        $('#entidadPerteneciente').empty().append('<option value="0" selected="selected">ENTIDAD</option>');
        $.each(datos, function(i){
            $('#entidadPerteneciente').append('<option value="' + response.datos[i].idEntidadFederativa+'">' + response.datos[i].nombreEntidadFederativa + '</option>');
        });
        waitingDialog.hide();     
      },
      error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
          waitingDialog.hide();     
      }
    }); 
}

$("#entidadPerteneciente").change(function(){
  waitingDialog.show();
  var entidadElegida=$("#entidadPerteneciente").val();
  $('#sucursalActivar').empty();
    $.ajax({            
      type:"POST",
      url: "sucursalesInternas/ajax_consultaSucursalesInactivas.php",
      data:{'entidad': entidadElegida},
      dataType: "json",
      success: function(response) {
        var datos = response.datos;
        var Largodatos = response.datos.length;
        if(Largodatos!=0 && Largodatos!=null && Largodatos!='NULL' && Largodatos!='null'){
            $('#sucursalActivar').empty().append('<option value="0" selected="selected">SUCURSAL</option>');
            $.each(datos, function(i){
                $('#sucursalActivar').append('<option value="' + response.datos[i].idSucursalI+'">' + response.datos[i].nombreSucursal + '</option>');
            });
            waitingDialog.hide();     
        }else if(Largodatos==0){
            $('#sucursalActivar').empty().append('<option value="0" selected="selected">SUCURSAL</option>');
            var mensaje="La entidad seleccionada no cuenta con sucursales Inactivas";
            cargarmensajeSucursal(mensaje,"error");
            waitingDialog.hide();
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
          waitingDialog.hide();     
      }
    });
  
});


$("#btnActivarSucursal").click(function(){
  waitingDialog.show();
  var sucursalActivar=$("#sucursalActivar").val();

  if(sucursalActivar=='0') {
    var mensaje="Seleccione una sucursal";
    cargarmensajeSucursal(mensaje,"error");
    waitingDialog.hide();
    return;
  }

    $.ajax({            
      type:"POST",
      url: "sucursalesInternas/ajax_ActivarSucursal.php",
      data:{'sucursal': sucursalActivar},
      dataType: "json",
      success: function(response) {
       var mensaje=response.mensaje;
            if(response.status=="success"){
               waitingDialog.hide();
               $('#sucursalActivar').empty().append('<option value="0" selected="selected">SUCURSAL</option>');
               cargarmensajeSucursal(mensaje,"success");
               $("#divTablaActivarSucursal").modal("hide");
               limpiarCampos();
            }else if(response.status=="error"){
                waitingDialog.hide();
                cargarmensajeSucursal(mensaje,"error");  
            } 
      },
      error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
          waitingDialog.hide();     
      }
    });
  
});