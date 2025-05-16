$(document).ready(function() {
    CargarSelectorRegiones();
    CargarSelectUsuarios();//selector para clientes
});

function CargarSelectorRegiones(){
  $.ajax({
      type: "POST",
      url: "RelacionUsuarioRegion/ajax_getcatalogoRegiones.php",
      dataType: "json",
      success: function(response) {
        $("#SelRegion").empty().append('<option value="0">REGIONES</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#SelRegion').append('<option value="' + (response.datos[i].IdRegiones) + '">' + response.datos[i].DescripcionRegiones + '</option>');
          }
        }else{
          CargarMensajeRelacion("Error al cargar las regiones","error");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    }); 
}

function CargarSelectUsuarios(){
  $.ajax({
      type: "POST",
      url: "RelacionUsuarioRegion/ajax_getUsuariosGR.php",
      dataType: "json",
      success: function(response) {
        $("#SelUsuarioUSRcliente").empty().append('<option value="0">USUARIO</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#SelUsuarioUSRcliente').append('<option value="' + (response.datos[i].usuarioId) + '">' + response.datos[i].descripcion + '</option>');
          }
        }else{
          CargarMensajeRelacion("Error al cargar las regiones","error");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    }); 
}

$("#SelRegion").change(function(event){
  var region =$("#SelRegion").val();
  $("#SelUsuario").empty().append('<option value="0">USUARIO</option>');
  if(region!='0'){
    cargarLineasNegocioXregion(region);
  }else{
        $("#divListaUsuariosAsignados").hide();                
  }
});

$("#SelLineaNegocio").change(function(event){
  var region =$("#SelRegion").val();
  var lineaDeNegocio =$("#SelLineaNegocio").val();

  if(region!='0' && lineaDeNegocio!='0'){
     CargarUsuariosAsignadosARegion(region,lineaDeNegocio);
     CargarGerentesRegionales(region,lineaDeNegocio);
  }
  if(lineaDeNegocio==0){
    $("#SelUsuario").empty().append('<option value="0">USUARIO</option>');
  }
});

$("#SelUsuarioUSRcliente").change(function(event){
  var usuarioRUC =$("#SelUsuarioUSRcliente").val();
  $("#SelCliente").empty().append('<option value="0">CLIENTE</option>');
  $("#divListaClientesAsignados").hide();                

  if(usuarioRUC!='0'){
    cargarLineasNegocioXusr(usuarioRUC);
  }
});

$("#SelLineaNegocioC").change(function(event){
  var lineaNegocioElegida =$("#SelLineaNegocioC").val();
  var usuarioRUC =$("#SelUsuarioUSRcliente").val();

  if(lineaNegocioElegida!='0' && usuarioRUC!='0'){
    CargarClientes(lineaNegocioElegida,usuarioRUC);
    CargarClientesAsignadosAUsuario(lineaNegocioElegida,usuarioRUC);
  }else{
        $("#divListaClientesAsignados").hide();                
  }

  if(lineaNegocioElegida=='0'){
      $("#SelCliente").empty().append('<option value="0">CLIENTE</option>');
  }

});

function CargarGerentesRegionales(region,lineaDeNegocio){
  $.ajax({
      type: "POST",
      url: "RelacionUsuarioRegion/ajax_getGerentesRegionales.php",
      data: {region:region,lineaDeNegocio:lineaDeNegocio},
      dataType: "json",
      success: function(response) {
        $("#SelUsuario").empty().append('<option value="0">USUARIO</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#SelUsuario').append('<option value="' + (response.datos[i].usuarioId) + '">' + response.datos[i].descripcion + '</option>');
          }
        }else{
          CargarMensajeRelacion("Error al cargar usuarios","error");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    }); 
}  

function CargarClientes(lineaNegocioElegida,usuarioRUC){
  $.ajax({
      type: "POST",
      url: "RelacionUsuarioRegion/ajax_getClientes.php",
      data: {lineaNegocioElegida:lineaNegocioElegida,usuarioRUC:usuarioRUC},
      dataType: "json",
      success: function(response) {
        $("#SelCliente").empty().append('<option value="0">CLIENTE</option>');
        if (response.status == "success")
        {
          if(response.datos.length!=0){
             $("#SelCliente").append('<option value="TODOS">TODOS</option>');
          }
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#SelCliente').append('<option value="' + (response.datos[i].idCliente) + '">' + response.datos[i].razonSocial + '</option>');
          }
        }else{
          CargarMensajeRelacion("Error al cargar clientes","error");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    }); 
}  

$("#btnAsignarRegionAUsr").click(function(event){
    var region =$("#SelRegion").val();
    var usuario =$("#SelUsuario").val();
    var lineaNegocio =$("#SelLineaNegocio").val();//pendiente

    if(region ==0){
        swal("Alto", "Seleccione una región","error");
        return;
    }
    if(usuario==0){
        swal("Alto", "Seleccione un usuario","error");
        return;
    }

    if(lineaNegocio==0){
        swal("Alto", "Seleccione una linea de negocio","error");
        return;
    }
    $.ajax({
            type: "POST",
            url: "RelacionUsuarioRegion/ajaxAsignarUsuarioARegion.php",
            data: {region:region, usuario:usuario, lineaNegocio:lineaNegocio},
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;
                if(response.status=="success") {
                    CargarUsuariosAsignadosARegion(region,lineaNegocio);
                    CargarGerentesRegionales(region,lineaNegocio); 
                    // swal("Listo!", "Región Asignada Correctamente","success");
                }else if (response.status=="error"){
                    alert(mensaje);
                }
              },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
    });
});

$("#btnAsignarClienteAUsr").click(function(event){
    var usuarioC =$("#SelUsuarioUSRcliente").val();
    var cliente =$("#SelCliente").val();
    var lineaNegocio =$("#SelLineaNegocioC").val();//pendiente

    if(usuarioC ==0){
        swal("Alto", "Seleccione un usuario","error");
        return;
    }
    if(cliente==0){
        swal("Alto", "Seleccione un cliente","error");
        return;
    }

    if(lineaNegocio==0){
        swal("Alto", "Seleccione una linea de negocio","error");
        return;
    }

    $.ajax({
            type: "POST",
            url: "RelacionUsuarioRegion/ajaxAsignarClienteAusuario.php",
            data: {usuarioC:usuarioC, cliente:cliente, lineaNegocio:lineaNegocio},
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;
                if(response.status=="success") {
                    CargarClientesAsignadosAUsuario(lineaNegocio,usuarioC);
                    CargarClientes(lineaNegocio,usuarioC); 
                    // swal("Listo!", "Cliente Asignado Correctamente","success");
                }else if (response.status=="error"){
                    alert(mensaje);
                }
              },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
    });
});

function CargarUsuariosAsignadosARegion(region,lineaNegocio){
    waitingDialog.show();
    $.ajax({
        type: "POST",
        url: "RelacionUsuarioRegion/ajax_getUsuariosAsignadosXRegion.php",
        data: {"region":region,"lineaNegocio":lineaNegocio},
        dataType: "json",
        async: false,
        success: function(response) {
            if(response.status == "success") {
                $("#listaUsuariosAsignados").html ("");
                var usuariosXregion = "";
               for (var i = 0; i < response.datos.length; i++) {
                    var idRelacion = response.datos[i].idIncrementUR;
                    var usuario = response.datos[i].usuario;
                    usuariosXregion += "<li class='class'>" + usuario + "";
                    usuariosXregion +="<span class='input-group-addon cursorImg' onclick='eliminarUsuarioAsignadoAregion("+idRelacion+");' >X</span></li>";
                }
                waitingDialog.hide();
                $("#listaUsuariosAsignados").html(usuariosXregion);
                $("#divListaUsuariosAsignados").show();                
            }else{
                $("#divListaUsuariosAsignados").hide();                
                var mensaje = response.message;
                CargarMensajeRelacion(mensaje,"error");
                waitingDialog.hide();
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
             waitingDialog.hide();
             $("#divListaUsuariosAsignados").hide();                
         }
    });
    // $(document).scrollTop(0);
}

function CargarClientesAsignadosAUsuario(lineaNegocioElegida,usuarioRUC){
    waitingDialog.show();
    $.ajax({
        type: "POST",
        url: "RelacionUsuarioRegion/ajax_getClientesAsignadosXUsuario.php",
        data: {"lineaNegocioElegida":lineaNegocioElegida,"usuarioRUC":usuarioRUC},
        dataType: "json",
        async: false,
        success: function(response) {
            if(response.status == "success") {
                $("#listaClientesAsignados").html ("");
                var clientesXusuario = "";
               for (var i = 0; i < response.datos.length; i++) {
                    var idRelacionCliente = response.datos[i].idIncrementUC;
                    var razonSocial = response.datos[i].razonSocial;
                    clientesXusuario += "<li class='class' style='height: 50px;'>" + razonSocial + "";
                    clientesXusuario +="<span class='input-group-addon style='height: 50px;' cursorImg' onclick='eliminarClienteAsignadoAusr("+idRelacionCliente+");' >X</span></li>";
                }
                waitingDialog.hide();
                $("#listaClientesAsignados").html(clientesXusuario);
                $("#divListaClientesAsignados").show();                
            }else{
                $("#divListaClientesAsignados").hide();                
                var mensaje = response.message;
                CargarMensajeRelacion(mensaje,"error");
                waitingDialog.hide();
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
             waitingDialog.hide();
             $("#divListaClientesAsignados").hide();                
         }
    });
    // $(document).scrollTop(0);
}

function eliminarUsuarioAsignadoAregion(idRelacion){
    
    var region =$("#SelRegion").val();
    var lineaDeNegocio =$("#SelLineaNegocio").val();

    $.ajax({
        type: "POST",
        url: "RelacionUsuarioRegion/ajax_eliminarUsuarioAsignado.php",
        data: {"idRelacion":idRelacion},
        dataType: "json",
        async: false,
        success: function(response) {
            if(response.status == "success") {
               CargarUsuariosAsignadosARegion(region,lineaDeNegocio);
               CargarGerentesRegionales(region,lineaDeNegocio);
            }else{
                CargarMensajeRelacion(mensaje,"error");    
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
}

function eliminarClienteAsignadoAusr(idRelacionCliente){
    
    var usuario =$("#SelUsuarioUSRcliente").val();
    var lineaDeNegocio =$("#SelLineaNegocioC").val();
    
    $.ajax({
        type: "POST",
        url: "RelacionUsuarioRegion/ajax_eliminarClienteAsignado.php",
        data: {"idRelacionCliente":idRelacionCliente},
        dataType: "json",
        async: false,
        success: function(response) {
            if(response.status == "success") {
               CargarClientesAsignadosAUsuario(lineaDeNegocio,usuario);
               CargarClientes(lineaDeNegocio,usuario);
            }else{
                CargarMensajeRelacion(mensaje,"error");    
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
}

function CargarMensajeRelacion(mensaje,Tipo){
    $('#mensajeRelacion').fadeIn();
    msjerrorbaja="<div id='mensajeRelacion' class='alert alert-"+Tipo+"'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
    $("#divMensajeRelacion").html(msjerrorbaja);
    $(document).scrollTop(0);
    $('#mensajeRelacion').delay(4000).fadeOut('slow'); 
}

// LINEAS DE NEGOCIO

function cargarLineasNegocioXregion(region){
  $.ajax({
      type: "POST",
      url: "RelacionUsuarioRegion/ajax_getLineasDeNegocioXRegion.php",
      data: {region:region},
      dataType: "json",
      success: function(response) {
        $("#SelLineaNegocio").empty().append('<option value="0">LINEA DE NEGOCIO</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#SelLineaNegocio').append('<option value="' + (response.datos[i].idLineaNegI) + '">' + response.datos[i].descripcionLineaNegocio + '</option>');
          }
        }else{
          CargarMensajeRelacion("Error al cargar usuarios","error");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    }); 
} 

function cargarLineasNegocioXusr(usr){
  $.ajax({
      type: "POST",
      url: "RelacionUsuarioRegion/ajax_getLineasDeNegocioXusr.php",
      data: {usr:usr},
      dataType: "json",
      success: function(response) {
        $("#SelLineaNegocioC").empty().append('<option value="0">LINEA DE NEGOCIO</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#SelLineaNegocioC').append('<option value="' + (response.datos[i].idLineaNegocioRUR) + '">' + response.datos[i].descripcionLineaNegocio + '</option>');
          }
        }else{
          CargarMensajeRelacion("Error al cargar usuarios","error");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    }); 
} 