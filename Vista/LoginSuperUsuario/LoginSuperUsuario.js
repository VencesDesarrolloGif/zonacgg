$(document).ready (function ()
{
    $("#btnAccederSuperUsuario").show();

});//termina ready

$("#btnAccederSuperUsuario").click(function(){
    verificarSuperUsuario();

});
$(document).keyup(function(event) {
    if (event.which === 13) {
        verificarSuperUsuario();
    }
});
function verificarSuperUsuario(){
    var usuario = $("#usuarioSuperUsuario").val();
    var pass = $("#passSuperUsuario").val();
    $("#btnAccederSuperUsuario").hide();
    if(usuario==""){
        swal("Alto","Ingrese El Super Usuario Para Poder Continuar", "error");  
        $("#btnAccederSuperUsuario").show();
    }else if(pass==""){
        swal("Alto","Ingrese La Contraseña Del Super Usuario Para Poder Continuar", "error"); 
        $("#btnAccederSuperUsuario").show(); 
    }else{
        $("#btnAccederSuperUsuario").hide();
        $.ajax({
            type: "POST",
            url: "ajax_VerifiacerSuperUsuario.php",
            data:{"usuario":usuario,"pass":pass},
            dataType: "json",
            async: false,
            success: function(response) {
                if(response.status == "success") {
                    if(response.datos.length=="0"){
                        swal("ERROR","El usuario y/o contraseña ingresados son incorrectos por favor verifiquelos e intente nuevamente", "error");
                        $("#btnAccederSuperUsuario").show();
                    }else{
                        if(response.datos[0].EstatusSuperU=="0"){
                            swal("ERROR","El usuario se encuentra bloquedo comuniquese al area de contrataciones", "error");
                            $("#btnAccederSuperUsuario").show();
                        }else{
                            var usuario1 = btoa(usuario);
                            window.location.replace("http://38.110.58.228/zonacgg/Vista/LoginSuperUsuario/form_VistaUsuariosAsignadosAdministrativso.php?aes="+usuario1+"");
                        }
                    }
                }else{
                    var mensaje = response.message;
                    alert(mensaje);  
                }
            },error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
    }
}