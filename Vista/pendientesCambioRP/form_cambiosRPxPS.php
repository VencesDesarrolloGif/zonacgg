<!DOCTYPE html>
<?php
 $mes= DATE('m');
 $fechaMinima="2021-01-01";
 $fechaInicio=strtotime($fechaMinima);
 $anioConsultaInicio=date('Y',$fechaInicio);
 $anioActual= DATE('Y');    
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link  href="css-Bootstrap-V4.1.3/css/bootstrap.min.css" >
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/popper.min.js" >
    </head>
    <body>
        <center>
            <h3 class="card-title">CAMBIOS RP</h3>

            <div id="msgCRP"></div>
            <br>
            <button id="btnConsultarPendientesCRP" type="button" class="btn btn-primary">Consultar</button>    
        </center>
<br>
<br>
<div id="modalCRP" name="modalCRP" class="modalEdit hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabelCRP" aria-hidden="true"  >
  <div id="alertMsgCRP">
  </div>
   <div class="modal-header">
      <h4 class="modal-title" id="myModalLabelCRP"> <img src="img/ok.png">MODIFICAR REGISTRO PATRONAL</h4>
    </div>
    <div class="modal-body">
        <div class="input-prepend">
          <span class="add-on"># EMPLEADO</span>
          <input id="noEmpModal" name="noEmpModal" type="text" class="input-medium" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">NOMBRE EMPLEADO</span>
          <input id="nombreEmpModal" name="nombreEmpModal" type="text" class="input-xlarge" readonly>
        </div>

        <div class="input-prepend">
          <span class="add-on">REGISTRO PAT.</span>
          <select id="selectRPmodal" name="selectRPmodal">
            <option >REGISTRO PATRONAL</option>
          </select>
        </div>

        <div class="input-prepend">
          <span class="add-on">REGISTRO PATRONAL SUGERIDO</span>
           <input id="registroPSugeridoModal" name="registroPSugeridoModal" type="text" class="input-small" readonly >
        </div>

    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick='actualizarRP();'>Guardar Cambios</button>
      </div>
    </div>  <!-- FIN MODAL BAJA EMPLEADO -->
        <section>
            <table id="tablaPendientesCRP"  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" style="display: none;">
                <thead class="thead-dark">
                    <tr>
                        <th style="text-align: center;background-color: #B0E76E"># Empleado</th>       
                        <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                        <th style="text-align: center;background-color: #B0E76E">Registro Patronal Actual</th>
                        <th style="text-align: center;background-color: #B0E76E">Registro Patronal Nuevo</th>
                        <th style="text-align: center;background-color: #B0E76E">Punto de servicio</th>
                        <th style="text-align: center;background-color: #B0E76E">Entidad</th>
                        <th style="text-align: center;background-color: #B0E76E">Modificar</th>
                        <th style="text-align: center;background-color: #B0E76E">Declinar</th>
                    </tr>
                </thead>
            </table>
        </section>
        <script src="pendientesCambioRP/funciones_cambioRPxPS.js"></script>
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/js/bootstrap.min.js">
    </body>
</html>