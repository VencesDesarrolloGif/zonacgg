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
          <div id='divMSGRepse' name='divMSGRepse' ></div>
           <div class="container" align="center"><h1>DEPARTAMENTOS</h1></div>
           <div id="divErrorRepse" name="divErrorRepse"></div>
           <div style="margin-top: 2%"></div>
           <div class="container top-buffer-submenu vertical-buffer">
             <div id="datosRepse" ></div>
           </div>
           <div>
           <center>
              <select id="selCategoriaEmpleados" name="selCategoriaEmpleados" type="text" placeholder="Solo numeros" class="input-large">
                <option value="0">CATEGORIA</option>
                <option value="02">ADMINISTRATIVOS</option>
                <option value="03">OPERATIVOS</option>
              </select>
              <br>
              <br>
              <select id="selLineaNegocio" name="selLineaNegocio" type="text" placeholder="Solo numeros" class="input-large">
                <option value="0">LINEA DE NEGOCIO</option>
              </select>
              <br>
              <br>
              <select id="selDepartamento" name="selDepartamento" type="text" placeholder="Solo numeros" class="input-large">
                <option value="0">DEPARTAMENTO</option>
              </select>
           </div>
           <br>
           <br>
           <div style="display: none;position: absolute;left:20%;top:40%;" id="divDatosPuestosSinAsignar"></div>
           <br>
           <br> 
           <div style="display: none;position: absolute;left:50%;top:40%;" id="divDatosPuestosAsignados"></div> 
           </center>

           <link href="../../Vista/css/bootstrap.css" rel="stylesheet">
           <style type="text/css"></style>
           <link rel="stylesheet" href="../css/bootstrap-3.3.5/dist/css/bootstrap.min.css">
           <link href="../../Vista/css/bootstrap-responsive.css" rel="stylesheet">
           <link href="../../Vista/css/login.css" rel="stylesheet">
           <link href="../../Vista/css/animate-custom.css" rel="stylesheet">
           <script type="text/javascript" src="../../Vista/js/jquery-2.1.1.js"></script>
           <script type="text/javascript" src="../../Vista/js/bootstrap.js"></script>
           <script src="departamentos.js"></script>
     </body>
  </html>