<?php
session_start();
$usuario = $_SESSION;
if ($usuario == null) {
    header("Location: ../login/login.html");
}
?>
<!DOCTYPE html>
  <html lang="en">
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <head>
      <?php include '../encabezado.html';?>
    </head>
    <body>
  <form id="empleadosProcesoBaja" name ="empleadosProcesoBaja" method="post" action="" target="_blank">
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modalformulacion" name="modalformulacion" >
        <div class="modal-header">
           <h1>Formulaciones</h1>

        </div>
         <div id="errormsgformulacion" name="errormsgformulacion"></div>
        <div class="modal-body">
           <select id="seltablas"></select>
            <select id="selcolumns"></select>
            <div>
              <input type="text" id="hdnnumtipopercepcion">
              <input type="text" id="hdndistinctcolumntbl">
            <button id="btnagregarenmodal" disabled="true" type="button" class="btn btn-primary" onclick='agregarconcepto(1);'>Agregar</button>
            <button id="btndeshacer"  type="button" class="btn btn-primary" onclick='quitarconcepto();'>Deshacer</button>
          </div>
          <br>
          <textarea readonly id="txtareaformula" class="form-control" rows="10"></textarea>
            <h1 style="cursor:pointer;display:inline;margin-left: 19% " id="imgsum2"  value="+" onclick="agregarconcepto(2);">+</h1>
            <h1 style="cursor:pointer;display:inline;margin-left: 5%" id="imgsum3"  value="-" onclick="agregarconcepto(3);">-</h1>&nbsp
            <h1 style="cursor:pointer;display:inline;margin-left: 5%" id="imgsum4"  value="*" onclick="agregarconcepto(4);">*</h1>&nbsp
            <h1 style="cursor:pointer;display:inline;margin-left: 5%" id="imgsum5"  value="/" onclick="agregarconcepto(5);">/</h1>&nbsp
            <h1 style="cursor:pointer;display:inline;margin-left: 5%" id="imgsum6"  value="=" onclick="agregarconcepto(6);">=</h1>&nbsp
            <h1 style="cursor:pointer;display:inline;margin-left: 5%" id="imgsum7"  value="(" onclick="agregarconcepto(7);">(</h1>&nbsp
            <h1 style="cursor:pointer;display:inline;margin-left: 5%" id="imgsum8"  value=")" onclick="agregarconcepto(8);">)</h1>&nbsp
        </div>
      <div class="modal-footer">
        <button type="button" id='' class="btn btn-primary" onclick='guardarformula();'>Confirmar</button>
       </div>
    </div>
  </form>

      <form   id="formulariopaso">
</form>





          <div class="container" align="center"><h1>Catálogo de tipos de percepciones</h1></div>
          <div id="errorMsg" name="errorMsg"></div>
          <div style="margin-top: 2%"></div>
            <div class="table-responsive">
              <div id="datos" ></div>
            </div>
            <input id="inpaccion" type="hidden" value="Editar">
            <div class="container top-buffer-submenu vertical-buffer">
              <button  id="btneditar"  class="btn btn-warning" onclick="editar()">Editar <span class="glyphicon glyphicon-pencil"></span></button>
              <button  id="btnguardar" disabled='true' class="btn btn-success" onclick="guardar()">Guardar</button>
              <button  id="btnagregar"  class="btn btn-default" onclick="agregarfila()"><span class="glyphicon glyphicon-plus"></span>Agregar</button>
            </div>
            <style type="text/css"></style>
            <link rel="stylesheet" href="../css/bootstrap-3.3.5/dist/css/bootstrap.min.css"><!--el que guss ocupa-->
            <link href="../../Vista/css/bootstrap-responsive.css" rel="stylesheet">
            <link href="../../Vista/css/login.css" rel="stylesheet">
            <link href="../../Vista/css/animate-custom.css" rel="stylesheet">
            <script type="text/javascript" src="../../Vista/js/jquery-2.1.1.js"></script>
            <script type="text/javascript" src="../../Vista/js/bootstrap.js"></script>
            <link href="../../Vista/css/bootstrap.css" rel="stylesheet">
            <link href="../../Vista/css/bootstrap-responsive.css" rel="stylesheet">
            <script src="tipopercepcion.js"></script>
    </body>
  </html>

