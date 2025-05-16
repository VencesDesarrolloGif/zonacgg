<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Iniciar Sesion</title>
    <link rel="icon" type="image/jpg" href="../img/NuevoCirculoGrupoGif.jpg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <style type="text/css"></style>
    <link href="../css/bootstrap-responsive.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet">
    <link href="../css/animate-custom.css" rel="stylesheet">
    <script type="text/javascript" src="../js/jquery-2.1.1.js"></script>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <script type="../js/bootstrap-waitingfor.js" type="text/javascript"></script>
    <script type="text/javascript" language="javascript" src="../css-Bootstrap-V4.1.3/js/sweetalert.min.js"></script> 
  </head>
  <body >
    <form class="form-horizontal" action="http://38.110.58.228//zonacgg/Vista/LoginSuperUsuario/form_VistaUsuariosAsignadosAdministrativso" method="GET">
    <div class="container" id="login-blockSuperUsuario" align="center">
      <div class="login-box clearfix animated flipInY">
        <div class="login-logo">
          <img src="../img/LogoGrupoGif.png" alt="Company Logo" />
        </div> 
        <div id="divtitulosuperusuario">
          <h4 style = "font-family:optima;">INGRESA TU SUPER USUARIO ASIGNADO</h4>
        </div>
        <div class="login-form">
            <input type="text" id="usuarioSuperUsuario" name="usuarioSuperUsuario" placeholder="Super Usuario" required/> 
            <input type="password" id="passSuperUsuario" name="passSuperUsuario" placeholder="Contraseña" required/> 
            <button type="button" class="btn btn-primary" id="btnAccederSuperUsuario">Acceder</button><br>
            <a href="http://http://38.110.58.228/zonacgg/Vista/form_activacionCuentaUsuario.php">Activar Cuenta</a>
            <div style="width: 50%;"></div>
        </div>                
      </div>
  </form>
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
    <script src="LoginSuperUsuario.js"></script>
  </body>
</html>