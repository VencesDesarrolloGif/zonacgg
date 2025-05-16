<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link  href="css-Bootstrap-V4.1.3/css/bootstrap.min.css" >
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/popper.min.js" >
    </head>
    <body>
        <center><h3 class="card-title">REPORTES DE INCIDENCIAS DE CENTRO DE CONTROL </h3>
        <br>
        <img title='Consulta/Cargar/Actualizar Pagina' src='img/ActualizarEjecutar.jpg' class='cursorImg' id='btnguardar' onclick="ConsultaHistoricotablaReporteIncidenciasCentroDeControl();" width="50px"></center>
        <br>
        <section>
            <table id="tablaReporteIncidenciasCentroDeControl"  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead class="thead-dark">
                    <tr>
                        <th style="text-align: center;background-color: #B0E76E">Id Incidencia</th>       
                        <th style="text-align: center;background-color: #B0E76E">Tipo De Incidencia</th>       
                        <th style="text-align: center;background-color: #B0E76E">Especificación De Incidencia</th>       
                        <th style="text-align: center;background-color: #B0E76E">Número De Supervisor Asignado</th>
                        <th style="text-align: center;background-color: #B0E76E">Nombre De Supervisor Asignado</th>
                        <th style="text-align: center;background-color: #B0E76E">Número De Empleado</th>
                        <th style="text-align: center;background-color: #B0E76E">Nombre De Empleado</th>      
                        <th style="text-align: center;background-color: #B0E76E">Entidad Federativa</th>       
                        <th style="text-align: center;background-color: #B0E76E">Punto De Servicio</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha Incidencia</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha Registro</th> 
                        <th style="text-align: center;background-color: #B0E76E">Firma Administrativo</th> 
                        <th style="text-align: center;background-color: #B0E76E">Fecha Edición</th> 
                        <th style="text-align: center;background-color: #B0E76E">Estatus Reporte</th> 
                        <th style="text-align: center;background-color: #B0E76E">Archivo</th> 
                        <th style="text-align: center;background-color: #B0E76E">Edición</th> 
                    </tr>
                </thead>
            </table>
        </section>
        <div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalestatusdocumentosupervisor" id="modalestatusdocumentosupervisor" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">  
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title" align="center"><img src="img/alert.png">Estatus Revisión Documentos Por Supervisor</h3>
                    </div>
                    <div class="modal-body" align="center">
                        <table id="tablaEstatusSupervisorCC"  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="text-align: center;background-color: #B0E76E"># Supervisor</th>       
                                    <th style="text-align: center;background-color: #B0E76E">Nombre Supervisor</th>    
                                    <th style="text-align: center;background-color: #B0E76E">Fecha Revisión</th>
                                    <th style="text-align: center;background-color: #B0E76E">Estatus Revisión</th>
                                </tr>
                            </thead>
                        </table>
                    </div>    
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalEdicionReporteCC" id="modalEdicionReporteCC" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">  
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title" align="center"><img src="img/alert.png">Edición Reporte Centro De Control </h3>
                    </div>
                    <div class="modal-body" align="center">

                <h4>REPORTE DE INCIDENCIA</h4>
                <div  style="max-width: 85rem; border-style: groove; border-color: rgb(51,153,255); "><br>
                    <div class= "row">
                        <label class="control-label label" for="IncidenciaAceptacion">Tipo De Incidencia</label>
                        <input class="input-xlarge" id="inpTipoincidenciaEdit" name="inpTipoincidenciaEdit" type="text" disabled>

                        <label class="control-label label" for="PuntoServicioEscritoCC">Punto Servicio Incidencia Escrito</label>
                        <input class="input-xlarge" id="inpdivPuntoServicioEscritoCCEdit" name="inpdivPuntoServicioEscritoCCEdit" type="text" disabled>
                    </div><br>
                    <div class= "row">
                        <label class="control-label label" for="NumeroGuardiaIncidencia">#Empleado Incidencia</label>
                        <input class="span3" id="inpNumeroGuardiaIncidenciaEdit" name="inpNumeroGuardiaIncidenciaEdit" type="text" disabled >

                        <label class="control-label label" for="NombreGuardiaIncidencia">Nombre Empleado</label>
                        <input class="input-xlarge" id="inpNombreGuardiaIncidenciaEdit" name="inpNombreGuardiaIncidenciaEdit" type="text" disabled>
                    </div>
                    <div class= "row">
                        <label class="control-label label" for="NumeroAdministrativoIncidencia">#Empleado Administrativo</label>
                        <input class="span3" id="inpNumeroAdministrativoIncidenciaEdit" name="inpNumeroAdministrativoIncidenciaEdit" type="text" disabled>

                        <label class="control-label label" for="NombreAdministrativoIncidencia">Nombre Administrativo</label>
                        <input class="input-xlarge" id="inpNombreAdministrativoIncidenciaEdit" name="inpNombreAdministrativoIncidenciaEdit" type="text" disabled>
                    </div>
                </div><br>
                <form enctype='multipart/form-data' id='formEdicionreporteICC' name='formEdicionreporteICC'>
                    <input type="hidden" id="IdIncidenciaEdit">
                <h4>DATOS A EDITAR</h4>
                <div  style="max-width: 70rem; border-style: groove; border-color: rgb(51,153,255); "><br>
                    <div class= "row">
                        <label class="control-label label" for="Testigos">Testigos o Personas Consultadas</label>
                        <img src="img/addMenu.png" id="agregarTestigoEdit"  title="Agregar testigo">
                        <img src="img/restar.png"  id="eliminarTestigoEdit" title="Eliminar testigo" style="display: none;">
                        <input type="hidden" id="conteoTestigosEdit" value="1">
                        <p><label id="caracteresTEdit1" >Caracteres restantes:<span id="spanEdit20"></span></label><textarea id="txtAreaTestigosEdit1" maxlength="50" style="width: 330px; height: 20px;" placeholder="Testigo" onpaste="return false"></textarea></p>
                        <p><label style= "display:none" id="caracteresTEdit2">Caracteres restantes:<span id="spanEdit21"></span></label><textarea id="txtAreaTestigosEdit2" maxlength="50" style="width: 330px; height: 20px; display: none;" placeholder="Segundo testigo" onpaste="return false"></textarea></p>
                        <p><label style= "display:none" id="caracteresTEdit3">Caracteres restantes:<span id="spanEdit22"></span></label><textarea id="txtAreaTestigosEdit3" maxlength="50" style="width: 330px; height: 20px; display: none;" placeholder="Tercer testigo" onpaste="return false"></textarea></p>
                        <p><label style= "display:none" id="caracteresTEdit4">Caracteres restantes:<span id="spanEdit23"></span></label><textarea id="txtAreaTestigosEdit4" maxlength="50" style="width: 330px; height: 20px; display: none;" placeholder="Cuarto testigo" onpaste="return false"></textarea></p>
                        <p><label style= "display:none" id="caracteresTEdit5">Caracteres restantes:<span id="spanEdit24"></span></label><textarea id="txtAreaTestigosEdit5" maxlength="50" style="width: 330px; height: 20px; display: none;" placeholder="Quinto testigo" onpaste="return false"></textarea></p>
                        <p><label style= "display:none" id="caracteresTEdit6">Caracteres restantes:<span id="spanEdit25"></span></label><textarea id="txtAreaTestigosEdit6" maxlength="50" style="width: 330px; height: 20px; display: none;" placeholder="Sexto testigo" onpaste="return false"></textarea></p>
                        <p><label style= "display:none" id="caracteresTEdit7">Caracteres restantes:<span id="spanEdit26"></span></label><textarea id="txtAreaTestigosEdit7" maxlength="50" style="width: 330px; height: 20px; display: none;" placeholder="Septimo testigo" onpaste="return false"></textarea></p>
                    </div>
                    <div class= "row">
                        <label class="control-label label" for="ComoSePercataron">¿Cómo se percatarón de la situación?</label>
                        <p><label id="caracteresPEdit1">Caracteres restantes:<span id="spanEdit27"></span></label><textarea id="txtAreaPercataronEdit" maxlength="414" style="width: 330px; height: 20px;" onpaste="return false"></textarea></p>
                    </div>
                    <div class= "row">
                        <label class="control-label label" for="Recopilacion">Recopilación de Información y descripcion de hechos</label>
                        <img src="img/addMenu.png" id="agregarRecopilacionEdit"  title="Agregar Recopilacion">
                        <img src="img/restar.png"  id="eliminarRecopilacionEdit" title="Eliminar Recopilacion" style="display: none;">
                        <input type="hidden" id="conteoRecopilacionEdit" value="1">
                        <p><label id="caracteresREdit1">Caracteres restantes:<span id="spanEditEdit1"></span></label><textarea id="txtAreaRecopilacionEdit1" maxlength="281" style="width: 330px; height: 20px;" onpaste="return false"></textarea></p>
                        <p><label id="caracteresREdit2" style="display:none;">Caracteres restantes:<span id="spanEdit2"></span></label><textarea id="txtAreaRecopilacionEdit2" maxlength="281" style="width: 330px; height: 20px; display: none;" onpaste="return false"></textarea></p>
                        <p><label id="caracteresREdit3" style="display:none;">Caracteres restantes:<span id="spanEdit3"></span></label><textarea id="txtAreaRecopilacionEdit3" maxlength="281" style="width: 330px; height: 20px; display: none;" onpaste="return false"></textarea></p>
                        <p><label id="caracteresREdit4" style="display:none;">Caracteres restantes:<span id="spanEdit4"></span></label><textarea id="txtAreaRecopilacionEdit4" maxlength="281" style="width: 330px; height: 20px; display: none;" onpaste="return false"></textarea></p>
                        <p><label id="caracteresREdit5" style="display:none;">Caracteres restantes:<span id="spanEdit5"></span></label><textarea id="txtAreaRecopilacionEdit5" maxlength="281" style="width: 330px; height: 20px; display: none;" onpaste="return false"></textarea></p>
                        <p><label id="caracteresREdit6" style="display:none;">Caracteres restantes:<span id="spanEdit6"></span></label><textarea id="txtAreaRecopilacionEdit6" maxlength="281" style="width: 330px; height: 20px; display: none;" onpaste="return false"></textarea></p>
                        <p><label id="caracteresREdit7" style="display:none;">Caracteres restantes:<span id="spanEdit7"></span></label><textarea id="txtAreaRecopilacionEdit7" maxlength="281" style="width: 330px; height: 20px; display: none;" onpaste="return false"></textarea></p>
                        <p><label id="caracteresREdit8" style="display:none;">Caracteres restantes:<span id="spanEdit8"></span></label><textarea id="txtAreaRecopilacionEdit8" maxlength="281" style="width: 330px; height: 20px; display: none;" onpaste="return false"></textarea></p>
                        <p><label id="caracteresREdit9" style="display:none;">Caracteres restantes:<span id="spanEdit9"></span></label><textarea id="txtAreaRecopilacionEdit9" maxlength="281" style="width: 330px; height: 20px; display: none;" onpaste="return false"></textarea></p>
                        <p><label id="caracteresREdit10" style="display:none;">Caracteres restantes:<span id="spanEdit10"></span></label><textarea id="txtAreaRecopilacionEdit10"maxlength="281" style="width: 330px; height: 20px; display: none;" onpaste="return false"></textarea></p>
                    </div>
                    <div class= "row">
                        <label class="control-label label" for="Tarea">Tarea realizada al momento</label>
                        <p><label id="caracteresTREdit1">Caracteres restantes:<span id="spanEdit11"></span></label><textarea id="txtAreaTareaEdit" maxlength="497" style="width: 330px; height: 20px;" onpaste="return false"></textarea></p>
                    </div>
                </div><br>
                <h4>MEDIDAS ADOPTADAS</h4>
                <div  style="max-width: 70rem; border-style: groove; border-color: rgb(51,153,255); "><br>
                    <div class= "row">
                        <label class="control-label label" for="Responsabilidad">RESPONSABILIDAD</label>
                        <img src="img/addMenu.png" id="AgregarTextoResponsabilidadEdit">
                        <img src="img/restar.png"  id="eliminarTextoResponsabilidadEdit" title="Eliminar Recopilacion" style="display: none;">
                        <br>
                        <input type="hidden" id="conteoTxtResponsabilidadEdit" value="1">
                        <label id="caracteresRPEdit1">Caracteres restantes:<span id="spanEdit12"></span></label><textarea id="txtResponsabilidadEdit1" maxlength="274" style="width: 430px; height: 20px;" onpaste="return false"></textarea>
                        <label id="caracteresRPEdit2" style="display:none;">Caracteres restantes:<span id="spanEdit13"></span></label><textarea id="txtResponsabilidadEdit2" maxlength="274" style="width: 430px; height: 20px; display: none;" onpaste="return false"></textarea>
                    </div>
                    <div class= "row">
                        <label class="control-label label" for="Ordenes">ORDENES DE PUESTO</label> 
                        <img src="img/addMenu.png" id="AgregarTextoOrdenesEdit">
                        <img src="img/restar.png"  id="eliminarTextoOrdenesEdit" title="Eliminar Recopilacion" style="display: none;">
                        <br>
                        <input type="hidden" id="conteoTxtOrdenesEdit" value="1">
                        <label id="caracteresEditO1">Caracteres restantes:<span id="span14"></span></label><textarea id="txtAreaOrdenesEdit1" maxlength="274" style="width: 430px; height: 20px;" onpaste="return false"></textarea>
                        <label id="caracteresEditO2" style="display:none;">Caracteres restantes:<span id="spanEdit15"></span></label><textarea id="txtAreaOrdenesEdit2" maxlength="274" style="width: 430px; height: 20px; display: none;" onpaste="return false"></textarea>
                    </div>
                    <div class= "row">
                        <label class="control-label label" for="Evidencia">EVIDENCIA FOTOGRAFICA</label> 
                        <img src="img/addMenu.png" id="AgregarTextoEvidenciaEdit">
                        <img src="img/restar.png"  id="eliminarTextoEvidenciaEdit" title="Eliminar Recopilacion" style="display: none;">
                        <br>
                        <input type="hidden" id="conteoTxtEvidenciaEdit" value="1">
                        <label id="caracteresEditE1">Caracteres restantes:<span id="spanEdit16"></span></label><textarea id="txtAreaEvidenciaEdit1" maxlength="274" style="width: 430px; height: 20px;" onpaste="return false"></textarea>
                        <label id="caracteresEditE2" style="display:none;">Caracteres restantes:<span id="spanEdit7"></span></label><textarea id="txtAreaEvidenciaEdit2" maxlength="274" style="width: 430px; height: 20px; display: none;" onpaste="return false"></textarea>
                    </div>
                    <div class= "row">
                        <label class="control-label label" for="Supervision">SUPERVISIÓN </label> 
                        <img src="img/addMenu.png" id="AgregarTextoSupervisionEdit">
                        <img src="img/restar.png"  id="eliminarTextoSupervisionEdit" title="Eliminar Recopilacion" style="display: none;">
                        <br>
                        <input type="hidden" id="conteoTxtSupervisionEdit" value="1">
                        <label id="caracteresSPEdit1">Caracteres restantes:<span id="spanEdit18"></span></label><textarea id="txtAreaSupervisionEdit1" maxlength="274" style="width: 430px; height: 20px;" onpaste="return false"></textarea>
                        <label id="caracteresSPEdit2" style="display:none;">Caracteres restantes:<span id="spanEdit19"></span></label><textarea id="txtAreaSupervisionEdit2" maxlength="274" style="width: 430px; height: 20px; display: none;" onpaste="return false"></textarea>
                    </div>
                </div><br>  
                <div class= "row">        
                    <button id="guardarIncidenciaCCEdit" name="guardarIncidenciaCCEdit" class="btn btn-primary " type="button" ;> 
                    <span class="glyphicon glyphicon-floppy-save "></span>Guardar</button>
                </div><br>
               </form>
                
                    </div>    
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
<div class="modalEdit hide fade" name="modalFirmaReporteincidenciaCCEdit" id="modalFirmaReporteincidenciaCCEdit">
                    <div id="errormodalFirmaReporteincidenciaCCEdit"></div>
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">  
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y la contraseña que generaste !!</h3>
                            </div>
                            <div class="modal-body" align="center">
                                <span class="add-on"># Empleado</span>
                                <input type="text" id="NumEmpModalFirmaReporteincidenciaEmpleadoEdit" class="input-medium" name="NumEmpModalFirmaReporteincidenciaEmpleadoEdit" placeholder="00-0000-00 Ó 00-00000-00">
                                <input type="hidden" id="NumEmpModalFirmaReporteincidenciaEmpleadohiddenEdit" class="input-medium" name="NumEmpModalFirmaReporteincidenciaEmpleadohiddenEdit">
                                <span class="add-on">Contraseña</span>
                                <input type="password" id="constraseniaFirmaParaReporteincidenciaEmpleadoEdit" class="input-xlarge"name="constraseniaFirmaParaReporteincidenciaEmpleadoEdit" title="El campo identifica entre mayusculas y    minusculas favor de considerarlo">
                                <input type="hidden" id="constraseniaFirmaParaReporteincidenciaEmpleadoHiddenEdit" class="input-xlarge"name="constraseniaFirmaParaReporteincidenciaEmpleadoHiddenEdit">
                            </div>
                            <div class="modal-body" align="center">
                                <button type="button" id="btnFirmarReporteincidenciaEmpleadoEdit" name="btnFirmarReporteincidenciaEmpleadoEdit" onclick="RevisarFirmaInternaParaReingresoEmpleadoEdit();" style="display: block;" class="btn btn-primary" >Firmar</button><br>
                                <button type="button" id="btnCancelarReporteincidenciaEmpleadoEdit" name="btnCancelarReporteincidenciaEmpleadoEdit"onclick="cancelarFirmaParaReingresoEmpleadoEdit();" class="btn btn-danger" >Cancelar</button>
                            </div>      
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

        <script src="HistoricoReporteIncidenciasCentroDeControl/HistoricoReporteIncidenciaCC.js"></script>
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/js/bootstrap.min.js">
    </body>
</html>