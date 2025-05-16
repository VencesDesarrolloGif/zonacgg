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
     <?php 
        include '../encabezado.html';
     ?>
   </head>
     <body>
          <div id='divMSGDependencia' name='divMSGDependencia' ></div>
           <div class="container" align="center"><h1>Catálogo Dependencias</h1></div>
           <div id="divErrorDependencia" name="divErrorDependencia"></div>
           <div style="margin-top: 2%"></div>
           <div class="container top-buffer-submenu vertical-buffer">
             <div id="datosDependencia" ></div>
           </div>
           <input id="inpaccionDependencia" type="hidden" value="Editar">
           <div class="container top-buffer-submenu vertical-buffer">
              <button  id="btneditarDependencia"  class="btn btn-warning" onclick="editarDependencia()"> Editar <span class="glyphicon glyphicon-pencil"></span></button>
              <button  id="btnguardarDependencia" disabled='true' class="btn btn-success" onclick="guardarDependencia()">Guardar</button>
              <button  id="btnagregarDependencia" class="btn btn-default" onclick="agregarDependencia()"><span class="glyphicon glyphicon-plus"></span>Agregar</button>
           </div>
           <div tabindex="-1" role="dialog" id="ModalDependencia" name="ModalP" aria-labelledby="aaaa1" aria-hidden="true">
             <h1 align="center" id="procesandoDependencia" name="procesandoDependencia" style="display:none;" >Procesando ....</h1></div>            
           </div>  
           <link href="../../Vista/css/bootstrap.css" rel="stylesheet">
           <style type="text/css"></style>
           <link rel="stylesheet" href="../css/bootstrap-3.3.5/dist/css/bootstrap.min.css">
           <link href="../../Vista/css/bootstrap-responsive.css" rel="stylesheet">
           <link href="../../Vista/css/login.css" rel="stylesheet">
           <link href="../../Vista/css/animate-custom.css" rel="stylesheet">
           <script type="text/javascript" src="../../Vista/js/jquery-2.1.1.js"></script>
           <script type="text/javascript" src="../../Vista/js/bootstrap.js"></script>
           <script src="CatalogoDependencias.js"></script>
     </body>
  </html>