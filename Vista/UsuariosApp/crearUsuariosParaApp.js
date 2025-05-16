$("#btnComenzarUsrApp").click(function () 
{
    $("#btnComenzarUsrApp").hide();
    $("#divFirmaInternaUseraApp").show();
    $("#btnContinuarUsrApp").show();
    $("#btnCancelarApp").show();
    accionesinciaiales();
});


$("#btnContinuarUsrApp").click(function () 
{
    var NumeroEmpleadoFirma = $("#NumeroEmpleadoApp").val();
    var contraseniaFirma = $("#contraseniaApp").val();
    if(NumeroEmpleadoFirma==""){
        swal("Alto","Debes ingresar el 'Numero Empleado'","error");
    }else if(contraseniaFirma==""){
        swal("Alto","Debes ingresar la 'Contraseña Interna'","error");
    }else{
        $.ajax({
            type: "POST",
            url: "UsuariosApp/ajax_ConsultarFirmaInterna.php",
            data: {NumeroEmpleadoFirma,contraseniaFirma},
            dataType: "json",
            success: function(response) {
                var mensaje = response.message;
                if(response.status == "success") {
                    if(response.opcion==0) {
                        swal("Alto","El número de empleado "+NumeroEmpleadoFirma+" no cuenta con una firma interna, debe dirigirse a la pestaña cerrar sesión en el apartado Firma ELectronica Interna","error");
                    }else if(response.opcion==1){
                        $("#NombreEmpAppHidden").val(response.datos[0].nombreEmpleado);
                        $("#ApellidoPAppHidden").val(response.datos[0].apellidoPaterno);
                        $("#ApelledoMAppHidden").val(response.datos[0].apellidoMaterno);
                        $("#idEntidaAppdHideen").val(response.datos[0].idEntidadTrabajo);
                        $("#NumeroEmpleadoApp").prop('readonly',true);
                        $("#contraseniaApp").prop('readonly',true);
                        $("#divUsuarioApp").show();
                        $("#UsuarioNuevoApp").val("");
                        $("#contraseniaUsuarioNuevoApp").val("");
                        $("#btnContinuarUsrApp").hide();
                        $("#btnGuardarUsuario").show();
                    }else if(response.opcion==2){
                        swal("Alto","La contraseña ingresada para "+NumeroEmpleadoFirma+" es incorrecta (Recuera que el sistema identifica entre mayusculas y minusculas)","error");
                    }else if(response.opcion==3){
                        $("#divMensajeUsuarioCreadoApp").show();
                        $("#btnContinuarUsrApp").hide();
                        $("#NumeroEmpleadoApp").prop('readonly',true);
                        $("#contraseniaApp").prop('readonly',true);
                    }else if(response.opcion==4){
                        swal("Alto","El emplado que desea registrar se encuentra dado de baja","error");
                        $("#btnContinuarUsrApp").hide();
                        $("#NumeroEmpleadoApp").prop('readonly',true);
                        $("#contraseniaApp").prop('readonly',true);
                    }else if(response.opcion==5){
                        $("#inpUserActual").val(response.usuarioApp);
                        $("#inpContraseniaNueva").val("");
                        $("#divMensajeUsuarioCreadoContraseniaBloqueadaApp").show();
                        $("#btnContinuarUsrApp").hide();
                        $("#NumeroEmpleadoApp").prop('readonly',true);
                        $("#contraseniaApp").prop('readonly',true);
                    }
                }else{  
                    // mensajeJornadasAdmin("error",mensaje);
                }
            },error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
    }
});


$("#btnCancelarApp").click(function () 
{   $("#divMensajeUsuarioCreadoContraseniaBloqueadaApp").hide();
    $("#btnComenzarUsrApp").show();
    $("#divFirmaInternaUseraApp").hide();
    $("#btnContinuarUsrApp").hide();
    $("#btnCancelarApp").hide();
    accionesinciaiales();

});


function accionesinciaiales(){
    $("#NumeroEmpleadoApp").val("");
    $("#NumeroEmpleadoApp").prop('readonly',false);
    $("#contraseniaApp").val("");
    $("#contraseniaApp").prop('readonly',false);
    $("#divUsuarioApp").hide();
    $("#UsuarioNuevoApp").val("");
    $("#contraseniaUsuarioNuevoApp").val("");
    $("#btnGuardarUsuario").hide();
    $("#divMensajeUsuarioCreadoApp").hide();
    $("#divMensajeUsuarioCreadoContraseniaBloqueadaApp").hide();
    
}

$("#btnActualizarContraseniaApp").click(function () 
{

    var UsuarioNuevo = $("#inpUserActual").val();
    var contraseniaUsuario = $("#inpContraseniaNueva").val();
    var a = "a";
    InsertarActualizarUsuarioApp(a,a,a,UsuarioNuevo,contraseniaUsuario,a,a,a,a,2)

});

$("#btnGuardarUsuario").click(function () 
{
    var numeroEmpleado = $("#NumeroEmpleadoApp").val();
    var numeroEmpleadoSplit = numeroEmpleado.split('-');
    var entidadEmp = numeroEmpleadoSplit[0];
    var ConsecutivoEmp = numeroEmpleadoSplit[1];
    var CategoriaEmp = numeroEmpleadoSplit[2];
    var UsuarioNuevo = $("#UsuarioNuevoApp").val();
    var contraseniaUsuario = $("#contraseniaUsuarioNuevoApp").val();
    var NombreEmpApp = $("#NombreEmpAppHidden").val();
    var ApellidoPApp = $("#ApellidoPAppHidden").val();
    var ApelledoMApp = $("#ApelledoMAppHidden").val();
    var idEntidaAppd = $("#idEntidaAppdHideen").val();
    InsertarActualizarUsuarioApp(entidadEmp,ConsecutivoEmp,CategoriaEmp,UsuarioNuevo,contraseniaUsuario,NombreEmpApp,ApellidoPApp,ApelledoMApp,idEntidaAppd,1)

});

function InsertarActualizarUsuarioApp(entidadEmp,ConsecutivoEmp,CategoriaEmp,UsuarioNuevo,contraseniaUsuario,NombreEmpApp,ApellidoPApp,ApelledoMApp,idEntidaAppd,opcion){
    $.ajax({
        type: "POST",
        url: "UsuariosApp/ajax_InsertarUsuarioApp.php",
        data: {entidadEmp,ConsecutivoEmp,CategoriaEmp,UsuarioNuevo,contraseniaUsuario,NombreEmpApp,ApellidoPApp,ApelledoMApp,idEntidaAppd,opcion},
        dataType: "json",
        async: false,
        success: function(response) {
            var mensaje = response.message;
            if(response.status == "success") {
                swal("Excelente",mensaje,"success");
                $("#btnComenzarUsrApp").show();
                $("#divFirmaInternaUseraApp").hide();
                $("#btnContinuarUsrApp").hide();
                $("#btnCancelarApp").hide();
                accionesinciaiales();
            }else{  
                swal("Alto",mensaje,"error");
            }
        },error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
}


