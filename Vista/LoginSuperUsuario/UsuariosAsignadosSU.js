$(ReadyUsuarioAsignadoSU()); 

function ReadyUsuarioAsignadoSU(){
    var UsuarioAMostrar1 = $("#UsuarioOtroFormulario").val();
    var UsuarioAMostrar= atob(UsuarioAMostrar1);
    CargarInformacionUsuarioLogeado(UsuarioAMostrar);
    swal("ALERTA","Recuerda solo tienes 5 minutos dentro de tu sesión de SUPER USUARIO hasta que ingresas a tu usuario normal en caso contrario se rompera la sesión","warning");
}
function CargarInformacionUsuarioLogeado(UsuarioAMostrar){
    $.ajax({
        type: "POST",
        url: "ajax_ObtenerUsuariosAsignadosAlSuperUsuario.php",
        data:{"UsuarioAMostrar":UsuarioAMostrar},
        dataType: "json",
        async: false,
        success: function(response) {
            console.log(response);
            if(response.status == "success") {
                var datos1 = response.datos;
                $('#divUsuariosAsignadosSU').html(""); 
                $('#divtitulosuperusuario').html("");
                var listaUsuariosTabla="<form id='checkUsuarios'>";
                listaUsuariosTabla+="<table class='table table-bordered' id='Exportar_a_Excel'><thead><th>Roles</th><th>Usuario</th><th>Contrasenia</th><th>Editar</th><th>Ingresar</th>";
                if (datos1.length > 0)
                {
                    listaUsuariosTabla+="<br/>";
                    listaUsuariosTabla+="<br/>";
                    for ( var i = 0; i < datos1.length; i++ )
                    {
                        var Usuario = datos1[i].Usuario;
                        var Rol = datos1[i].Rol;
                        var Contrasenia = datos1[i].Contrasenia;
                        if(i=="0"){
                            var Nombre = datos1[i].Nombre;
                            var NumeroE = datos1[i].NumeroE;
                            $("#NombreSuperUsuario").val(Nombre);
                            $("#NumeroSuperUsuario").val(NumeroE);
                        }
                        listaUsuariosTabla += "<tr><td>"+Rol+"</td><td>"+Usuario+"</td><td>"+Contrasenia+"</td>";
                        if(Rol=="Cliente"){
                            listaUsuariosTabla += "<td></td>";
                        }else{
                            listaUsuariosTabla += "<td><input type='checkbox' id="+Usuario+"  name="+Usuario+" value='" +Usuario+"' disabled Usuario='"+Usuario+"'</td>";
                        }
                        listaUsuariosTabla += "<td><button id='btnIngresar' type='button' class='btn btn-success' onclick=accederlogingif('"+Usuario+"');>Acceder</button></td>";
                    }
                    listaUsuariosTabla += "</tbody></table>";
                    listaUsuariosTabla+="<button id='btnCambiarContrasenia' style = 'display:none;' type='button' class='btn btn-warning' onclick='MostrarModalContrasenia();'>Ingresar Nueva Contraseña</button></form>";
                    $('#divUsuariosAsignadosSU').html(listaUsuariosTabla);
                    var Nombre4 =$("#NombreSuperUsuario").val();
                    var NumeroE4 =$("#NumeroSuperUsuario").val();
                    var titluo = "<h2 style = 'font-family:optima;'>BIENVENIDO </h2><h3 style = 'font-family:optima;'>"+Nombre4+" ESTOS SON TUS ROLES ASIGNADOS</h3><h4 style = 'font-family:optima;'>TU  NÚMERO DE EMPLEADO ES: "+NumeroE4+"</h4><h5 style = 'font-family:optima;'>Nota: En caso de que los datos sean incorrectos ponerte en contacto con el area de contrataciones</h5>";
                    $('#divtitulosuperusuario').html(titluo);
                    $("#divbotoneditar").show();
                }else{
                    $('#divUsuariosAsignadosSU').html("<div><h1>No se encontrarón usuarios asignados a tu número de empleado</h1></div>");
                    $("#divbotoneditar").hide(); 
                } 
            }else if (response.status == "error" && response.message == "No autorizado")
            {
                window.location.replace("http://38.110.58.228//zonacgg/Vista/LoginSuperUsuario/form_LoginSuperUsuario.php");
            }
        },error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
}

$("#btnEditarUsuarios").click(function(){
    for (i=0;i<document.form_usuariosSuper.elements.length;i++){
        if(document.form_usuariosSuper.elements[i].type == "checkbox")  
        {
            document.form_usuariosSuper.elements[i].disabled=false;
        }
    }
    $("#btnEditarUsuarios").hide();  
    $("#btnCambiarContrasenia").show(); 
});

function MostrarModalContrasenia(){
    var checkActulizar = $( "input[type=checkbox]:checked");
    if(checkActulizar.length <= "0"){
        swal("ERROR","Marca el cuadro de los usuarios que actualizarás su contraseña al seleccionar varios se actualizarán con la misma contraseña","error")
    }else{
        $("#NumEmpModalFirmaCambioContrasenia").val("");
        $("#constraseniaFirmaCambioContrasenia").val("");
        $("#ContraseniaCambioContrasenia").val("");
        $("#modalFirmaCambioContrasenia").modal();
    }
}

function RevisarFirmaCambioContrasenia(){
  var NumEmpModal = $("#NumEmpModalFirmaCambioContrasenia").val();
  var constraseniaFirma = $("#constraseniaFirmaCambioContrasenia").val();
  var CambioContrasenia = $("#ContraseniaCambioContrasenia").val();
  if(NumEmpModal==""){
    cargaerroresFirmaCambioContrasenia("El numero de empleado no puede estar vacio");
  }else if(constraseniaFirma==""){
    cargaerroresFirmaCambioContrasenia("Escriba la contraseña para continuar");
  }else if(CambioContrasenia==""){
    cargaerroresFirmaCambioContrasenia("Escriba la contraseña que se le asignara a los usuarios seleccionados");
  }else{
    $.ajax({
      type: "POST",
      url: "ajax_getFirmaSolicitadaSuperUsuario.php",
      data: {"NumEmpModal":NumEmpModal,"constraseniaFirma":constraseniaFirma},
      dataType: "json",
      async: false,
      success: function(response) {
        if (response.status == "success")
        {
          var RespuestaLargo = response["datos"].length;
          if(RespuestaLargo == "0"){
            cargaerroresFirmaCambioContrasenia("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro");
          }else{
            var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
            $("#NumEmpModalFirmaCambioContraseniahidden").val(NumEmpModal);
            $("#constraseniaFirmaCambioContraseniaHidden").val(contraseniaInsertadaCifrada);
            $("#modalFirmaCambioContrasenia").modal("hide");
            $("#NumEmpModalFirmaCambioContrasenia").val("");
            $("#constraseniaFirmaCambioContrasenia").val("");
            $("#ContraseniaCambioContrasenia").val("");
            ActualizarContraseniaDeUsuarios(CambioContrasenia);
          }
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
  }
}
function cancelarFirmaCambioContrasenia(){

  $("#modalFirmaCambioContrasenia").modal("hide");
  $("#NumEmpModalFirmaCambioContrasenia").val("");
  $("#constraseniaFirmaCambioContrasenia").val("");
  $("#constraseniaFirmaCambioContraseniaHidden").val("");
   for (i=0;i<document.form_usuariosSuper.elements.length;i++){
        if(document.form_usuariosSuper.elements[i].type == "checkbox")  
        {
            document.form_usuariosSuper.elements[i].disabled=true;
            document.form_usuariosSuper.elements[i].checked=0;
        }
    }
    $("#btnEditarUsuarios").show(); 
    $("#btnCambiarContrasenia").hide(); 
}
function cargaerroresFirmaCambioContrasenia(mensaje){
  $('#errormodalFirmaCambioContrasenia').fadeIn();
  msjerrorbaja="<div id='errormodalFirmaCambioContrasenia1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errormodalFirmaCambioContrasenia").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errormodalFirmaCambioContrasenia').delay(4000).fadeOut('slow'); 
}
function ActualizarContraseniaDeUsuarios(CambioContrasenia){
    var NumEmp = $("#NumEmpModalFirmaCambioContraseniahidden").val();
    var constrasenia = $("#constraseniaFirmaCambioContraseniaHidden").val();
    var usuariosParaGuardar = [];
    var checkActulizar = $( "input[type=checkbox]:checked");
    for (var i = 0; i < checkActulizar.length; i++)
    {
        if (checkActulizar[i].checked == true)
        {
            usuariosParaGuardar.push (checkActulizar[i].value);
        }
    }
    $.ajax({
        type: "POST",
        url: "ajax_ActualizarContraseniaDeUsuarios.php",
        data:{"usuariosParaGuardar":usuariosParaGuardar,"CambioContrasenia":CambioContrasenia,"NumEmp":NumEmp,"constrasenia":constrasenia},
        dataType: "json",
        async: false,
        success: function(response) {
            if(response.status == "success") {
                $("#modalFirmaCambioContrasenia").modal('hide');
                funcionInicialDeLogeo();
                $("#btnEditarUsuarios").show(); 
                swal("LISTO",response.message,"success");
            }else{
                var mensaje = response.message;
                swal("Alto",mensaje, "error");   
            }
        },error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
}

function accederlogingif(Usuario1){
    var Usuario = btoa(Usuario1);
    window.location.replace("http://38.110.58.228/zonacgg/Vista/form_login.php?rtyu="+Usuario+"");   
}

