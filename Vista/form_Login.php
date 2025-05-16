<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Iniciar Sesion</title>
  <link rel="icon" type="image/jpg" href="img/NuevoCirculoGrupoGif.jpg" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Le styles -->
  <link href="css/bootstrap.css" rel="stylesheet">
  <style type="text/css">
    
  </style>
  <link href="css/bootstrap-responsive.css" rel="stylesheet">
  <link href="css/login.css" rel="stylesheet">
  <link href="css/animate-custom.css" rel="stylesheet">
  <script type="text/javascript" src="js/jquery-2.1.1.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script src="js/bootstrap-waitingfor.js" type="text/javascript"></script> 
  <script type="text/javascript" language="javascript" src="../vista/css-Bootstrap-V4.1.3/js/sweetalert.min.js"></script> 

</head>
<body >

<div class="errorMsg">
<?php
// Mostrar un mensaje de error. En caso de que haya.
echo (isset ($errorMsg) ? $errorMsg : "");
?>
</div> 
        <div class="container" id="login-block" align="center">

                  
             <div class="login-box clearfix animated flipInY"> 
                <div class="login-logo">
                  <img src="img/LogoGrupoGif.png" alt="Company Logo" />
                </div> 
                <hr/>
                <div class="login-form">
                  <div class="alert alert-error hide">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>Error!</h4>
                   Your Error Message goes here
                  </div>
                  <form action='login.php' method='POST' id="form_usuariologin" name="form_usuariologin">
                    <input type="text" readonly id="usuario" name="usuario" placeholder="Usuario" value="<?php $usuario = $_GET['rtyu']; echo$usuario;?>" required/> 
                   <input type="password" id="pass" name="pass" placeholder="Contraseña" required/> 
                  <input type="submit" value="Entrar" class="btn btn-red">
                  <!--<a href='javascript:olvideContrasenia();'>Olvide mi contraseña</a><br> -->
                  <a href="http://38.110.58.228//zonacgg/Vista/form_activacionCuentaUsuario.php">Activar Cuenta</a>
                  <!-- <input type="Button" value="desarrollo" class="btn btn-red"> -->
                    <div style="width: 50%;">
                </div>
              </form> 


                
                </div>                
             </div>

            <div class="modal fade" tabindex="-1" role="dialog" name="modalConfirmacionCorreo" id="modalConfirmacionCorreo" aria-hidden="true" data-backdrop="static">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <div id="divMsgCorreoRestauracion" name="divMsgCorreoRestauracion"></div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Restauración de contraseña</h4>
                  </div>
                  <div class="modal-body">
                    <p>Por seguridad se enviará por correo electrónico el proceso de restauración de contraseña.</p>
                    <p>A continuación ingrese el correo electrónico registrado en su contratación:</p>

                    <input id="txtCorreoRestauracion" name="txtCorreoRestauracion" type="text"  class="input-large-email" placeholder="correo electrónico">
                  </div>
                  <div class="modal-footer">
                    
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="verificarCorreo();">Enviar</button>

                                      </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
      </div>
</html>
</body>
<script type="text/javascript">


$(inicioForm_login());  

function inicioForm_login(){ 
  $( "#txtCorreoRestauracion" ).focus();
  var usuario1 = $("#usuario").val();
  var aa = usuario1.split('/');
  if(aa[0] !="<br "){
    var usuario= atob(usuario1);
    $("#usuario").val(usuario);
    if(usuario.length > 11){
      window.location.replace("http://38.110.58.228//zonagif/Vista/LoginSuperUsuario/form_LoginSuperUsuario.php");
      swal("ERROR","No haz iniciado session por favor ingresa de la manera correcta", "error");
    }
  }else{
    window.location.replace("http://38.110.58.228//zonagif/Vista/LoginSuperUsuario/form_LoginSuperUsuario.php");
  }
}

function olvideContrasenia(){
  $("#modalConfirmacionCorreo").modal();
  $("#txtCorreoRestauracion").val("");

}

function verificarCorreo(){
  var correo=$("#txtCorreoRestauracion").val();
  waitingDialog.show();
       $.ajax({
            type: "POST",
            url: "ajax_verificacionCorreoRestauracion.php",
            data : {"correo":correo},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    $("#txtCorreoRestauracion").val("");
                    var mensaje = response.message;
                    waitingDialog.hide(); 
                    $("#modalConfirmacionCorreo").modal("hide"); 
                    alert(mensaje);           
                }else{
                  waitingDialog.hide();  
                  var mensaje=response.message;
                  var msg="<div id='msgAlert' class='alert alert-error'><strong>"+mensaje+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                  $("#divMsgCorreoRestauracion").html(msg);
                  $('#msgAlert').delay(3000).fadeOut('slow');
                  $("#txtCorreoRestauracion").val("");
                }
            },
            error : function (jqXHR, textStatus, errorThrown)
            {
                alert(jqXHR.responseText);
            }
        });
}


</script>


