function MostrarDivPorOpcionSuperUsuario(opcion){
    if(opcion=="0"){
        limpiarCreacionSuperUsuario();
    }else if(opcion=="1"){
        limpiarBloquearSuperUsuario();
    }else{
        limpiarActivarSuperUsuario();
    }
}
// Funciones iniaiales Con El Link //////////////////////////
function limpiarCreacionSuperUsuario(){
    $("#divCrearSuperUsuario").show();
    $("#divBloquearSuperUsuario").hide();
    $("#divActivarSuperUsuario").hide();
    $("#divDatosBusqueda").hide();
    $("#inpNumeroEmpleado").val("");
    $("#NumeroSuperUsuario").val("");
    $("#NombreSuperUsuario").val("");
    $("#PuestoSuperUsuario").val("");
    $("#FechaSuperUsuario").val("");
    $("#UsuarioSuperUsuario").val("");
    $("#ContraseniaSuperUsuario").val("");
}

function limpiarBloquearSuperUsuario(){
    $("#divBloquearSuperUsuario").show();
    $("#divCrearSuperUsuario").hide();
    $("#divActivarSuperUsuario").hide();
    $("#divDatosBusquedaBloqueo").hide();
    $("#inpNumeroEmpleadoBloqueo").val("");
    $("#NumeroSuperUsuarioBloqueo").val("");
    $("#NombreSuperUsuarioBloqueo").val("");
    $("#PuestoSuperUsuarioBloqueo").val("");
    $("#FechaSuperUsuarioBloqueo").val("");
    $("#UsuarioSuperUsuarioBloqueo").val("");
    $("#ContraseniaSuperUsuarioBloqueo").val("");
    $("#btnBloquearSuperUsuario").hide();
}
function limpiarActivarSuperUsuario(){
    $("#divActivarSuperUsuario").show();
    $("#divBloquearSuperUsuario").hide();
    $("#divCrearSuperUsuario").hide();
    $("#divDatosBusquedaActivar").hide();
    $("#inpNumeroEmpleadoActivar").val("");
    $("#NumeroSuperUsuarioActivar").val("");
    $("#NombreSuperUsuarioActivar").val("");
    $("#PuestoSuperUsuarioActivar").val("");
    $("#FechaSuperUsuarioActivar").val("");
    $("#UsuarioSuperUsuarioActivar").val("");
    $("#ContraseniaSuperUsuarioActivar").val("");
    $("#btnActivarSuperUsuario").hide();

}
/////////////////////////////////////////////////////////////
////////////////////// Acciones Para La Creacion De un Super Usuario ///////////////////

$('#inpNumeroEmpleado').keypress(function(event){  
    var keycode = (event.keyCode ? event.keyCode : event.which);  
    if(keycode == '13'){  
       consultaEmpleadoParaCrearSuperUsuario();  
       $("#inpNumeroEmpleado").val("");       
    }   
});
function consultaEmpleadoParaCrearSuperUsuario(){
    var NumeroEmpleado = $("#inpNumeroEmpleado").val();
    $.ajax({
        type: "POST",
        url: "SuperUsuario/ajax_ConsultaEmpleadoParaCrearSuperUsuario.php",
        data:{"NumeroEmpleado":NumeroEmpleado},
        dataType: "json",
        async: false,
        success: function(response) {
            if(response.status == "success") {
                if(response.datos.length=="0"){
                    swal("Alto","El Número De Empleado Ingresado No Existe Por Favor Verifiquelo E Intente Nuevamente", "error");
                    limpiarCreacionSuperUsuario();
                }else{
                    var idSuperUsuario = response.datos[0]["idSuperUsuario"];
                    var SuperUsuario = response.datos[0]["Usuario"];
                    if(idSuperUsuario===0){// Se Utiliza SIN Como palabra clave para saber si ya tiene registro previamente
                        swal("Alto","Este empleado ya cuenta con un SUPER USUARIO registrado previamente el usuario es :"+SuperUsuario+" en caso de estar bloqueado reactivelo", "error"); 
                        limpiarCreacionSuperUsuario(); 
                    }else{
                        $("#NumeroSuperUsuario").val(response.datos[0]["NumeroEmpleado"]);
                        $("#NombreSuperUsuario").val(response.datos[0]["NombreEmpleado"]);
                        $("#PuestoSuperUsuario").val(response.datos[0]["Puesto"]);
                        $("#FechaSuperUsuario").val(response.datos[0]["FechaIngreso"]);
                        $("#divDatosBusqueda").show();
                    }
                }
                
            }else{
                var mensaje = response.message;
                alert(mensaje);
                swal("Alto",mensaje, "error");   
            }
        },error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
}
$("#btnCrearSuperUsuario").click(function(){
    var usuario1 = $("#UsuarioSuperUsuario").val();
    var Contrasenia = $("#ContraseniaSuperUsuario").val();
    var NumeroSuperUsuario = $("#NumeroSuperUsuario").val();
    if(usuario1==""){
        swal("Alto","Ingresa Un Usuario Maximo 10 Caracteres Para Continuar", "error");  
    }else if(Contrasenia==""){
        swal("Alto","Ingresa Una Contraseña Para Continuar", "error");  
    }else{
        var Usuario = usuario1.toLowerCase()
        $.ajax({
            type: "POST",
            url: "SuperUsuario/ajax_VerificarrUsuarioCreacionSuperUsuario.php",
            data:{"Usuario":Usuario,"NumeroSuperUsuario":NumeroSuperUsuario},
            dataType: "json",
            async: false,
            success: function(response) {
                if(response.status == "success") {
                    var idSuperUsuario = response.datos[0]["idSuperUsuario"];
                    if(idSuperUsuario==0){
                        RegistrarSuperUsuario(Usuario,Contrasenia);
                    }else{
                        swal("Alto","Este (Usuario o Número De Empleado) ya se encuentra registrado en la base de datos favor de ingresar uno distinto", "error"); 
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
});
function RegistrarSuperUsuario(Usuario,Contrasenia){
    var NumeroE = $("#NumeroSuperUsuario").val();
    $.ajax({
            type: "POST",
            url: "SuperUsuario/ajax_RegistrarSuperUsuario.php",
            data:{"Usuario":Usuario,"Contrasenia":Contrasenia,"NumeroE":NumeroE},
            dataType: "json",
            async: false,
            success: function(response) {
                if(response.status == "success") {
                    swal("GRACIAS","El registro del SUPER USUARIO ha sido exitoso", "success");  
                    limpiarCreacionSuperUsuario();
                }else{
                    var mensaje = response.message;
                    swal("Alto",mensaje, "error");   
                }
            },error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
}
////////////////////////////////////////////////////////////////////////////////////////
/////////// Acciones creadas para el link de bloquear Super usuario //////////////////////////////////////////

$('#inpNumeroEmpleadoBloqueo').keypress(function(event){  
    var keycode = (event.keyCode ? event.keyCode : event.which);  
    if(keycode == '13'){  
       consultaEmpleadoParaBloquearSuperUsuario();  
       $("#inpNumeroEmpleadoBloqueo").val("");       
    }   
});
function consultaEmpleadoParaBloquearSuperUsuario(){
    var NumeroEmpleado = $("#inpNumeroEmpleadoBloqueo").val();
    $.ajax({
        type: "POST",
        url: "SuperUsuario/ajax_ConsultaEmpleadoParaCrearSuperUsuario.php",
        data:{"NumeroEmpleado":NumeroEmpleado},
        dataType: "json",
        async: false,
        success: function(response) {
            if(response.status == "success") {
                if(response.datos.length=="0"){
                    swal("Alto","El Número De Empleado Ingresado No Existe Por Favor Verifiquelo E Intente Nuevamente", "error");
                    limpiarBloquearSuperUsuario();
                }else{
                    var idSuperUsuario = response.datos[0]["idSuperUsuario"];
                    var EstatusSuper = response.datos[0]["EstatusSuperU"];
                    if(idSuperUsuario==="0"){// Se Utiliza SIN Como palabra clave para saber si ya tiene registro previamente
                        swal("Alto","Este empleado NO cuenta con un SUPER USUARIO registrado previamente ingrese uno nuevo", "error");  
                        limpiarBloquearSuperUsuario();
                    }else{
                        if(EstatusSuper=="0"){
                            swal("Alto","El SUPER USUARIO de este empleado ya se encuentra bloqueado", "error");  
                            limpiarBloquearSuperUsuario();
                        }else{
                            $("#NumeroSuperUsuarioBloqueo").val(response.datos[0]["NumeroEmpleado"]);
                            $("#NombreSuperUsuarioBloqueo").val(response.datos[0]["NombreEmpleado"]);
                            $("#PuestoSuperUsuarioBloqueo").val(response.datos[0]["Puesto"]);
                            $("#FechaSuperUsuarioBloqueo").val(response.datos[0]["FechaIngreso"]);
                            $("#UsuarioSuperUsuarioBloqueo").val(response.datos[0]["Usuario"]);
                            $("#ContraseniaSuperUsuarioBloqueo").val(response.datos[0]["Contrasenia"]);
                            $("#divDatosBusquedaBloqueo").show();
                            $("#btnBloquearSuperUsuario").show();
                        }
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

$("#btnBloquearSuperUsuario").click(function(){
    var usuario = $("#UsuarioSuperUsuarioBloqueo").val();
    var NumeroEmpleadoBLoqueo = $("#NumeroSuperUsuarioBloqueo").val();
    $.ajax({
        type: "POST",
        url: "SuperUsuario/ajax_BloquearSuperUsuario.php",
        data:{"usuario":usuario,"NumeroEmpleadoBLoqueo":NumeroEmpleadoBLoqueo},
        dataType: "json",
        async: false,
        success: function(response) {
            if(response.status == "success") {
                swal("LISTO","El bloqueo del SUPER USUARIO ha sido exitoso", "success");  
                limpiarBloquearSuperUsuario()
            }else{
                var mensaje = response.message;
                swal("Alto",mensaje, "error");   
            }
        },error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
});

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////// Acciones creadas para el link de Activar Super usuario //////////////////////////////////////////////
$('#inpNumeroEmpleadoActivar').keypress(function(event){  
    var keycode = (event.keyCode ? event.keyCode : event.which);  
    if(keycode == '13'){  
       consultaEmpleadoParaActivarSuperUsuario();  
       $("#inpNumeroEmpleadoActivar").val("");       
    }   
});

function consultaEmpleadoParaActivarSuperUsuario(){
    var NumeroEmpleado = $("#inpNumeroEmpleadoActivar").val();
    $.ajax({
        type: "POST",
        url: "SuperUsuario/ajax_ConsultaEmpleadoParaCrearSuperUsuario.php",
        data:{"NumeroEmpleado":NumeroEmpleado},
        dataType: "json",
        async: false,
        success: function(response) {
            if(response.status == "success") {
                if(response.datos.length=="0"){
                    swal("Alto","El Número De Empleado Ingresado No Existe Por Favor Verifiquelo E Intente Nuevamente", "error");
                    limpiarActivarSuperUsuario();
                }else{
                    var idSuperUsuario = response.datos[0]["idSuperUsuario"];
                    var EstatusSuper = response.datos[0]["EstatusSuperU"];
                    if(idSuperUsuario==="0"){// Se Utiliza 0 Como palabra clave para saber si ya tiene registro previamente
                        swal("Alto","Este empleado NO cuenta con un SUPER USUARIO registrado previamente ingrese uno nuevo", "error");  
                        limpiarActivarSuperUsuario();
                    }else{
                        if(EstatusSuper!="0"){
                            swal("Alto","El SUPER USUARIO de este empleado NO se encuentra bloqueado", "error");  
                            limpiarActivarSuperUsuario();
                        }else{
                            $("#NumeroSuperUsuarioActivar").val(response.datos[0]["NumeroEmpleado"]);
                            $("#NombreSuperUsuarioActivar").val(response.datos[0]["NombreEmpleado"]);
                            $("#PuestoSuperUsuarioActivar").val(response.datos[0]["Puesto"]);
                            $("#FechaSuperUsuarioActivar").val(response.datos[0]["FechaIngreso"]);
                            $("#UsuarioSuperUsuarioActivar").val(response.datos[0]["Usuario"]);
                            $("#ContraseniaSuperUsuarioActivar").val("");
                            $("#divDatosBusquedaActivar").show();
                            $("#btnActivarSuperUsuario").show();
                        }
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
$("#btnActivarSuperUsuario").click(function(){
    var usuario = $("#UsuarioSuperUsuarioActivar").val();
    var NumeroEmpleadoBLoqueo = $("#NumeroSuperUsuarioActivar").val();
    var contrasenia = $("#ContraseniaSuperUsuarioActivar").val();
    if(contrasenia==""){
        swal("Alto","Ingrese La Nueva Contraseña Para El Usuario: "+usuario+" Para Poder Continuar", "error");  
    }else{
        $.ajax({
            type: "POST",
            url: "SuperUsuario/ajax_ActivarSuperUsuario.php",
            data:{"usuario":usuario,"NumeroEmpleadoBLoqueo":NumeroEmpleadoBLoqueo,"contrasenia":contrasenia},
            dataType: "json",
            async: false,
            success: function(response) {
                if(response.status == "success") {
                    swal("LISTO","La Activación del SUPER USUARIO ha sido exitosa", "success");  
                    limpiarActivarSuperUsuario()
                }else{
                    var mensaje = response.message;
                    swal("Alto",mensaje, "error");   
                }
            },error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
    }
    
});
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////