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
          <div id='divMSGDepartamento' name='divMSGDepartamento' ></div>
           <div class="container" align="center"><h1>Catálogo Departamentos</h1></div>
           <div id="divErrorDepartamento" name="divErrorDepartamento"></div>
           <br>
           <br>
           <center>
           <select id="selCategoriaEmpleadosDep" name="selCategoriaEmpleadosDep" type="text" class="input-large">
              <option value="0">CATEGORIA</option>
              <option value="02">ADMINISTRATIVOS</option>
              <option value="03">OPERATIVOS</option>
            </select>
            <br>
            <br>
            <select id="selLineaNegocioDep" name="selLineaNegocioDep" type="text" class="input-large">
              <option value="0">LINEA DE NEGOCIO</option>
            </select>
            </center>
           <div style="margin-top: 2%"></div>
           <div class="container top-buffer-submenu vertical-buffer">
             <div id="datosDepartamento" style="display:none;"></div>
           </div>
           <input id="inpaccionDepartamento" type="hidden" value="Editar">
           <div class="container top-buffer-submenu vertical-buffer">
              <button  id="btneditarDepartamento"  class="btn btn-warning" onclick="editarDepartamento()" style="display:none;">Editar <span class="glyphicon glyphicon-pencil"></span></button>
              <button  id="btnguardarDepartamento" disabled='true' class="btn btn-success" onclick="guardarDepartamento()" style="display:none;">Guardar</button>
              <button  id="btnagregarDepartamento" class="btn btn-default" onclick="agregarDepartamento()" style="display:none;"><span class="glyphicon glyphicon-plus"></span>Agregar</button>
           </div>
           <div tabindex="-1" role="dialog" id="ModalDepartamento" name="ModalP" aria-labelledby="aaaa1" aria-hidden="true">
             <h1 align="center" id="procesandoDepartamento" name="procesandoDepartamento" style="display:none;" >Procesando ....</h1></div>            
           </div>  
           <link href="../../Vista/css/bootstrap.css" rel="stylesheet">
           <style type="text/css"></style>
           <link rel="stylesheet" href="../css/bootstrap-3.3.5/dist/css/bootstrap.min.css">
           <link href="../../Vista/css/bootstrap-responsive.css" rel="stylesheet">
           <link href="../../Vista/css/login.css" rel="stylesheet">
           <link href="../../Vista/css/animate-custom.css" rel="stylesheet">
           <script type="text/javascript" src="../../Vista/js/jquery-2.1.1.js"></script>
           <script type="text/javascript" src="../../Vista/js/bootstrap.js"></script>
           <script src="CatalogoDepartamentos.js"></script>
     
            
     </body>
  </html>