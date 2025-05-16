<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link  href="css-Bootstrap-V4.1.3/css/bootstrap.min.css" >
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/popper.min.js" >
    </head>
    <body>
        <center><h3 class="card-title">REVISAR NUEVOS REPORTES DE INCIDENCIAS DE CENTRO DE CONTROL </h3>
        <br>
        <img title='Consulta/Cargar/Actualizar Pagina' src='img/ActualizarEjecutar.jpg' class='cursorImg' id='btnguardar' onclick="ConsultaHistoricotablaRevisarReporteIncidenciasCentroDeControl();" width="50px"></center>
        <br>
        <section>
            <table id="tablaRevisarReporteIncidenciasCentroDeControl"  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead class="thead-dark">
                    <tr>
                        <th style="text-align: center;background-color: #B0E76E">Id Incidencia</th>       
                        <th style="text-align: center;background-color: #B0E76E">Tipo De Incidencia</th>       
                        <th style="text-align: center;background-color: #B0E76E">Número De Supervisor Asignado</th>
                        <th style="text-align: center;background-color: #B0E76E">Nombre De Supervisor Asignado</th>
                        <th style="text-align: center;background-color: #B0E76E">Número De Empleado</th>
                        <th style="text-align: center;background-color: #B0E76E">Nombre De Empleado</th>      
                        <th style="text-align: center;background-color: #B0E76E">Entidad Federativa</th>       
                        <th style="text-align: center;background-color: #B0E76E">Punto De Servicio</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha Incidencia</th>
                        <th style="text-align: center;background-color: #B0E76E">Estatus Reporte</th> 
                        <th style="text-align: center;background-color: #B0E76E">Archivo</th> 
                    </tr>
                </thead>
            </table>
        </section>
        <div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaRevisionReporteCC" id="modalFirmaRevisionReporteCC" data-backdrop="static">
            <div id="errormodalFirmaRevisionReporteCC"></div>
                <div class="modal-dialog" role="document">
                    <div class="modal-content">  
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y la contraseña que generaste !!</h3>
                        </div>
                        <div class="modal-body" align="center">
                            <span class="add-on"># Empleado</span>
                            <input type="text" id="NumEmpModalFirmaRevisionReporteCC" class="input-medium" name="NumEmpModalFirmaRevisionReporteCC" placeholder="00-0000-00 Ó 00-00000-00">
                            <input type="hidden" id="NumEmpModalFirmaRevisionReporteCChidden" class="input-medium" name="NumEmpModalFirmaRevisionReporteCChidden">
                            <span class="add-on">Contraseña</span>
                            <input type="password" id="constraseniaFirmaRevisionReporteCC" class="input-xlarge"name="constraseniaFirmaRevisionReporteCC" title="El campo identifica entre mayusculas y    minusculas favor de considerarlo">
                            <input type="hidden" id="constraseniaFirmaRevisionReporteCCHidden" class="input-xlarge"name="constraseniaFirmaRevisionReporteCCHidden">
                        </div>
                        <div class="modal-body" align="center">
                            <button type="button" id="btnFirmaRevisionReporteCC" name="btnFirmaRevisionReporteCC" onclick="RevisarFirmaInternaParaReingresoEmpleado();" style="display: block;" class="btn btn-primary" >Firmar</button><br>
                            <button type="button" id="btnCancelarFirmaRevisionReporteCC" name="btnCancelarFirmaRevisionReporteCC"onclick="cancelarFirmaParaReingresoEmpleado();" class="btn btn-danger" >Cancelar</button>
          </div>      
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
        <script src="RevisionReporteIncidenciaCentroControl/RevisionReporteIncidenciaCentroControl.js"></script>
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/js/bootstrap.min.js">
    </body>
</html>