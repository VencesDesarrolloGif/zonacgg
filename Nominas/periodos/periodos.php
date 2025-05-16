<?php
session_start();
$usuario = $_SESSION;
if ($usuario == null) {
    header("Location: ../login/login.html");}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php
include '../encabezado.html';
?>
  </head>
<body>
		<form id="empw" name ="empw" method="post"  target="_blank">
		<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="emp" name="emp" >
			<div id="errorMsgModal" name="errorMsgModal"> </div>
		  	<div class="modal-header">
		   		<h4 class="modal-title" id="myModalLabel"> <img src="../img/ok.png">Editar Periodo</h4>
		   	</div>
		    <div class="modal-body">

<div class="row">
			    <div class="col-md-6">
      <label class="control-label">Fecha inicio:</label>
      <input class="form-control" type="date" id="fechainiciorango" name="fechainiciorango">
    </div>
       <div class="col-md-6">
      <label class="control-label">Dias de pago:</label>
      <input class="form-control" type="text" id="diaspagoedit" name="diaspagoedit" >


    </div>

<input class="form-control" type="hidden" id="idrango" name="idrango">
      <input class="form-control" type="hidden" id="idanio" name="idanio">
    </div>
		    </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick='editconfirmarperiodo();'>Confirmar</button>
			 </div>
		</div>
	</form>



  <div class="container" align="center"><h1>Periodos</h1></div>
  <div id="errorMsgtblperiodos" name="errorMsgtblperiodos"> </div>
  <br>
  <div class="container" align="center" id="muestracamposnuevo" style="display:none;">
    <div class="row">
      <div class="col-md-4">
        <label class="control-label">Periodo:</label>
        <select class="form-control" id="seldescripcionperiodonuevo" name="seldescripcionperiodonuevo"></select>
        <div style="display: none;" id="divinpdescripcion">
          <br>
          <label class="control-label">Descripción:</label>
        <input  class="form-control" type="text" id="descripcion" name="descripcion">
      </div>
      </div>
    <div class="col-md-4">
      <label class="control-label">Fecha inicio:</label>
      <input class="form-control" type="date" id="inicioderango" name="inicioderango">
    </div>
    <div class="col-md-4">
      <label class="control-label">Dias de pago:</label>
      <input class="form-control" type="text" id="diaspago" name="diaspago">
    </div>
    </div>
    <div class="clearfix">
      <div class="pull-right">
        <br>
        <button  id="btnguardar" class="btn btn-success" onclick="guardarnuevoperiodo()">Guardar <span class="glyphicon glyphicon-ok"></span></button>
        <button  id="btnconsultarperiodo"  class="btn btn-primary" onclick="consultarperiodobtn()">Consultar Periodo<span class="glyphicon glyphicon-list-alt"></span></button>
      </div>
    </div>
  </div>
  <div class="container" align="center" id="selectoresrango" style="display: block;">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-4">
        <label class="control-label">Periodo:</label>
        <select class="form-control" id="seldescripcionperiodo" name="seldescripcionperiodo"></select>
      </div>
      <div class="col-md-4">
        <label class="control-label">Descripción de dias de pago:</label>
        <select class="form-control" id="selanioperiodo" name="selanioperiodo"></select>
      </div>
    </div>
    <div class="clearfix">
      <div class="pull-center">
        <br><button  id="btnnuevo"  class="btn btn-default" onclick="nuevoperiodo()">Nuevo <span class="glyphicon glyphicon-plus"></span></button>
      </div>
    </div>
      <br><div id="datos" ></div>
  </div>
      <!--link href="../../Vista/css/bootstrap.css" rel="stylesheet"-->
      <style type="text/css"></style>
      <link rel="stylesheet" href="../bootstrap-3.3.5/dist/css/bootstrap.min.css"><!--el que guss ocupa-->
      <link href="../../Vista/css/bootstrap-responsive.css" rel="stylesheet">
      <link href="../../Vista/css/login.css" rel="stylesheet">
      <link href="../../Vista/css/animate-custom.css" rel="stylesheet">
      <script type="text/javascript" src="../../Vista/js/jquery-2.1.1.js"></script>
      <script type="text/javascript" src="../../Vista/js/bootstrap.js"></script>
      <link rel="stylesheet" type="text/css" href="../../Vista/css/bootstrap.css">
      <script src="periodos.js"></script>
  </body>
</html>

