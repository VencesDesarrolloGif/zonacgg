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

    <style>
      table,th,td{
        border: 1px solid black;
      }
    </style>
    </head>
              <!-- <div style="margin-top: 2%"></div> -->
              <!-- <div class="container top-buffer-submenu vertical-buffer"> -->
     <!-- <body> -->
          <div id='divMSGOrganigrama' name='divMSGOrganigrama' ></div>
           <div id="divErrorOrganigrama" name="divErrorOrganigrama"></div>
           <br>
           <br>
           <!-- <center> -->
    <table >
      <tr>
        <th><h1 align="center">Catálogo Departamentos</h1></th>
        <th rowspan="2"><h1 align="center">Catálogo Dependencias</h1></th>
        <th colspan="2"><h1 align="center">Departamentos</h1></th>
        <th colspan="2"><h1 align="center">Dependencias</h1></th>
        <th colspan="2"><h1 align="center">SubDependencias</h1></th>
      </tr>
<!-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
      <tr>
          <!-- catalogo departamentos -->
        <td>
          <select id="selCategoriaEmpleadosCatDep" name="selCategoriaEmpleadosCatDep" type="text" class="input-large">
              <option value="0">CATEGORIA</option>
              <option value="02">ADMINISTRATIVOS</option>
              <option value="03">OPERATIVOS</option>
            </select>
            <select id="selLineaNegocioCatDep" name="selLineaNegocioCatDep" type="text" class="input-large">
              <option value="0">LINEA DE NEGOCIO</option>
            </select>
        </td>

        <!-- catalogo dependencias NADA POR QUE NO TIENE SELECTORES EN EL DIV SE USO UN ROWSPAN DE 2-->

        <!-- departamentos -->
        <td colspan="2">
          <select id="selCategoriaEmpleadosDepa" name="selCategoriaEmpleadosDepa" type="text" placeholder="Solo numeros" class="input-large">
            <option value="0">CATEGORIA</option>
            <option value="02">ADMINISTRATIVOS</option>
            <option value="03">OPERATIVOS</option>
          </select>

          <select id="selLineaNegocioDepa" name="selLineaNegocioDepa" type="text" placeholder="Solo numeros" class="input-large">
            <option value="0">LINEA DE NEGOCIO</option>
          </select>

          <select id="selDepartamento" name="selDepartamento" type="text" placeholder="Solo numeros" class="input-large">
            <option value="0">DEPARTAMENTO</option>
          </select>
        </td>

        <!-- dependencias -->
        <td colspan="2">
          <select id="selCategoriaEmpleados" name="selCategoriaEmpleados" type="text" placeholder="Solo numeros" class="input-large">
               <option value="0">CATEGORIA</option>
               <option value="02">ADMINISTRATIVOS</option>
               <option value="03">OPERATIVOS</option>
             </select>

             <select id="selLineaNegocio" name="selLineaNegocio" type="text" placeholder="Solo numeros" class="input-large">
               <option value="0">LINEA DE NEGOCIO</option>
             </select>

             <select id="selNivel" name="selNivel" type="text" placeholder="Solo numeros" class="input-large">
               <option value="0">NIVEL</option>
             </select>
        </td>
        <td colspan="2">
          <select id="selCategoriaEmpleadosSubDep" name="selCategoriaEmpleadosSubDep" type="text" placeholder="Solo numeros" class="input-large">
               <option value="0">CATEGORIA</option>
               <option value="02">ADMINISTRATIVOS</option>
               <option value="03">OPERATIVOS</option>
             </select>

             <select id="selLineaNegocioSubDep" name="selLineaNegocioSubDep" type="text" placeholder="Solo numeros" class="input-large">
               <option value="0">LINEA DE NEGOCIO</option>
             </select>

             <select id="selNivelSubDep" name="selNivelSubDep" type="text" placeholder="Solo numeros" class="input-large">
               <option value="0">NIVEL</option>
             </select>

             <select id="selDepartamentoSubDep" name="selDepartamentoSubDep" type="text" placeholder="Solo numeros" class="input-large">
               <option value="0">DEPARTAMENTO</option>
             </select>
        </td>
      </tr>
      <tr>
            <td valign="top">
              <div id="datosDepartamento" style="display:none;"></div> <!-- catalogo departamentos -->
              <center>
                <input id="inpaccionCatDepartamento" type="hidden" value="Editar">
                <button  id="btneditarCatDepartamento"  class="btn btn-warning" onclick="editarCatDepartamento()" style="display:none;">Editar <span class="glyphicon glyphicon-pencil"></span></button>
                <button  id="btnguardarCatDepartamento" disabled='true' class="btn btn-success" onclick="guardarCatDepartamento()" style="display:none;">Guardar</button>
                <button  id="btnagregarCatDepartamento" class="btn btn-default" onclick="agregarCatDepartamento()" style="display:none;"><span class="glyphicon glyphicon-plus"></span>Agregar</button>
              </center>
            </td>
            <td valign="top">
              <div id="datosDependencia"></div><!-- catalogo dependencias -->
              <center>
              <input id="inpaccionDependencia" type="hidden" value="Editar">
              <button  id="btneditarDependencia"  class="btn btn-warning" onclick="editarDependencia()"> Editar <span class="glyphicon glyphicon-pencil"></span></button>
              <button  id="btnguardarDependencia" disabled='true' class="btn btn-success" onclick="guardarDependencia()">Guardar</button>
              <button  id="btnagregarDependencia" class="btn btn-default" onclick="agregarDependencia()"><span class="glyphicon glyphicon-plus"></span>Agregar</button>
              </center>
            </td>
            <td valign="top">
              <div id="divDatosPuestosSinAsignar"></div><!-- departamentos -->
            </td>
            <td valign="top">
              <div id="divDatosPuestosAsignados"></div> 
            </td>
            <td valign="top">
              <div style="display: none;" id="divDatosdepartamentosSinAsignar"></div><!-- dependencias -->
            </td>
            <td valign="top">
              <div style="display: none;" id="divDatosDepartamentosAsignados"></div> 
            </td>
            <td valign="top">
              <div style="display: none;" id="divSubDependenciasSinAsignar"></div><!-- dependencias -->
            </td>
            <td valign="top">
              <div style="display: none;" id="divSubDependenciasAsignados"></div> 
            </td>
      </tr>
    </table>


           <div tabindex="-1" role="dialog" id="ModalDepartamento" name="ModalP" aria-labelledby="aaaa1" aria-hidden="true">
             <h1 align="center" id="procesandoDepartamento" name="procesandoDepartamento" style="display:none;" >Procesando ....</h1>
           </div>            
           <link href="../../Vista/css/bootstrap.css" rel="stylesheet">
           <style type="text/css"></style>
           <link rel="stylesheet" href="../css/bootstrap-3.3.5/dist/css/bootstrap.min.css">
           <link href="../../Vista/css/bootstrap-responsive.css" rel="stylesheet">
           <link href="../../Vista/css/login.css" rel="stylesheet">
           <link href="../../Vista/css/animate-custom.css" rel="stylesheet">
           <script type="text/javascript" src="../../Vista/js/jquery-2.1.1.js"></script>
           <script type="text/javascript" src="../../Vista/js/bootstrap.js"></script>
           <script src="estructuraOrganigrama.js"></script>
     <!-- </body> -->
  </html>