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
    <form class="form-horizontal" id="form_usuariosSuper" name="form_usuariosSuper" action="http://38.110.58.228/zonacgg/Vista/form_login.php" method="GET" >

    <div class="container" align="center">
      <div id="divtitulosuperusuario"></div>
      <div id="divUsuariosAsignadosSU"></div> 
      <input type="hidden" id="NombreSuperUsuario" name="NombreSuperUsuario">       
      <input type="hidden" id="NumeroSuperUsuario" name="NumeroSuperUsuario">
      <input type="hidden" id="UsuarioOtroFormulario" name="UsuarioOtroFormulario" value="<?php $usuario = $_GET['aes']; echo$usuario;?>">
      <div id="divbotoneditar">

        <button id='btnEditarUsuarios' type='button' class='btn btn-primary'>Actualizar Contraseñas</button>
      </div> 

      <div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaCambioContrasenia" id="modalFirmaCambioContrasenia" data-backdrop="static">
      <div id="errormodalFirmaCambioContrasenia"></div>
      <div class="modal-dialog" role="document">
        <div class="modal-content">  
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title" align="center"><img src="../img/alert.png">Escribe tu número de empleado y la contraseña interna que generaste !!</h3>
          </div>
          <div class="modal-body" align="center">
            <span class="add-on"># Empleado</span>
            <input type="text" id="NumEmpModalFirmaCambioContrasenia" class="input-medium" name="NumEmpModalFirmaCambioContrasenia" placeholder="00-0000-00 Ó 00-00000-00">
            <input type="hidden" id="NumEmpModalFirmaCambioContraseniahidden" class="input-medium" name="NumEmpModalFirmaCambioContraseniahidden">
            <span class="add-on">Contraseña</span>
            <input type="password" id="constraseniaFirmaCambioContrasenia" class="input-xlarge"name="constraseniaFirmaCambioContrasenia" title="El campo identifica entre mayusculas y    minusculas favor de considerarlo">
            <input type="hidden" id="constraseniaFirmaCambioContraseniaHidden" class="input-xlarge"name="constraseniaFirmaCambioContraseniaHidden"><br>
            <h4>Ingresa la nueva contraseña para tus usuarios seleccionados</h4><br>
            <span class="add-on">Nueva Contraseña</span>
            <input type="password" id="ContraseniaCambioContrasenia" class="input-medium" name="ContraseniaCambioContrasenia" placeholder="xxxxxxxxxxx">
          </div>
          <div class="modal-body" align="center">
            <button type="button" id="btnFirmarCambioContrasenia" name="btnFirmarCambioContrasenia" onclick="RevisarFirmaCambioContrasenia();" style="display: block;" class="btn btn-primary" >Firmar</button><br>
            <button type="button" id="btnCancelarFirmaCambioContrasenia" name="btnCancelarFirmaCambioContrasenia"onclick="cancelarFirmaCambioContrasenia();" class="btn btn-danger" >Cancelar</button>
          </div>      
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div> 
    </form>
    <script src="UsuariosAsignadosSU.js"></script>
  </body>
</html>