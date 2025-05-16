<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    </head>
    <body>
        <div align="center" ><br>
            <div  style="max-width: 100rem; border-style: groove; border-color: rgb(51,153,255); ">
                <h4>REPORTE DE INCIDENCIA</h4>
                <div  style="max-width: 85rem; border-style: groove; border-color: rgb(51,153,255); "><br>
                    <div class= "row">
                        <label class="control-label label" for="IncidenciaAceptacion">Tipo De Incidencia</label>
                        <select class="span3" id="SelectIncidenciaAceptacion" name="SelectIncidenciaAceptacion" ></select><br>
                        <input class="input-xlarge" id="SelectIncidenciaAceptacionhidden" name="SelectIncidenciaAceptacionhidden" type="hidden">

                        <label class="control-label label" for="IncidenciaAceptacion">Especificación De Incidencia</label>
                        <select class="span3" id="SelectEspecificacionIncidencia" name="SelectEspecificacionIncidencia" >
                            <option value="0">ESPECIFICACIÓN</option>
                        </select><br>
                        <input class="input-xlarge" id="SelectEspecificacionIncidenciahidden" name="SelectEspecificacionIncidenciahidden" type="hidden">
                    </div><br>
                    <div class= "row">
                        <label class="control-label label" for="NumeroGuardiaIncidencia">#Empleado Incidencia</label>
                        <input class="span3" id="inpNumeroGuardiaIncidencia" name="inpNumeroGuardiaIncidencia" type="text" placeholder="00-0000-00">

                        <label class="control-label label" for="NombreGuardiaIncidencia">Nombre Empleado</label>
                        <input class="input-xlarge" id="inpNombreGuardiaIncidencia" name="inpNombreGuardiaIncidencia" type="text" disabled>

                        <label class="control-label label" for="PuestoGuardiaIncidencia">Puesto Empleado</label>
                        <input class="input-xlarge" id="inpPuestoGuardiaIncidencia" name="inpPuestoGuardiaIncidencia" type="text" disabled>
                        <input class="span3" id="inpPuestoGuardiaIncidenciahidden" name="inpPuestoGuardiaIncidenciahidden" type="hidden">
                    </div>
                    <div class= "row">
                        <label class="control-label label" for="NumeroAdministrativoIncidencia">#Empleado Administrativo</label>
                        <input class="span3" id="inpNumeroAdministrativoIncidencia" name="inpNumeroAdministrativoIncidencia" type="text" placeholder="00-0000-00">

                        <label class="control-label label" for="NombreAdministrativoIncidencia">Nombre Administrativo</label>
                        <input class="input-xlarge" id="inpNombreAdministrativoIncidencia" name="inpNombreAdministrativoIncidencia" type="text" disabled>

                        <label class="control-label label" for="PuestoAdministrativoIncidencia">Puesto Administrativo</label>
                        <input class="input-xlarge" id="inpPuestoAdministrativoIncidencia" name="inpPuestoAdministrativoIncidencia" type="text" disabled>
                        <input class="span3" id="inpPuestoAdministrativoIncidenciahidden" name="inpPuestoAdministrativoIncidenciahidden" type="hidden" >
                    </div>
                    <div class= "row">
                        <label class="control-label label" for="EntidadIncidencia">Entidad Incidencia</label>
                        <select class="span3" id="SelectEntidadIncidencia" name="SelectEntidadIncidencia" ></select>

                        <label class="control-label label" for="FechaIncidencia">Fecha Incidencia</label>
                        <input class="span3" id="inpFechaIncidencia" name="inpFechaIncidencia" type="date">
                    </div>
                     <div class= "row">
                        <label class="control-label label" id="Existepunto">¿Existe el punto de servicio?</label>
                        <label class="control-label label" id="lblExistepuntoSi">Si</label>
                        <input id="ExistepuntoSi" name="ExistepuntoSi" type="checkbox" style="transform: scale(1.5);">

                        <label class="control-label label" id="lblExistepuntoNo">No</label>
                        <input id="ExistepuntoNo" name="ExistepuntoNo" type="checkbox" style="transform: scale(1.5);">
                    </div><br>
                    <div class= "row" id="divPuntosservicioCC" style="display: none;">
                        <label class="control-label label" for="PuntoServicioIncidencia">Punto Servicio Incidencia</label>
                        <select class="span3" id="SelectPuntoServicioIncidencia" name="SelectPuntoServicioIncidencia" ></select>
                        <input class="input-xlarge" id="SelectPuntoServicioIncidenciahidden" name="SelectPuntoServicioIncidenciahidden" type="hidden">
                    </div>
                    <div class= "row" id="divPuntoServicioEscritoCC" style="display: none;">
                        <label class="control-label label" for="PuntoServicioEscritoCC">Punto Servicio Incidencia Escrito</label>
                        <input class="input-xlarge" id="inpdivPuntoServicioEscritoCC" name="inpdivPuntoServicioEscritoCC" type="text">
                    </div>
                </div><br>
                <h4>DATOS A OBTENER</h4>
                <div  style="max-width: 70rem; border-style: groove; border-color: rgb(51,153,255); "><br>
                    <div class= "row">
                        <label class="control-label label" for="Testigos">Testigos o Personas Consultadas</label>
                        <img src="img/addMenu.png" id="agregarTestigo"  title="Agregar testigo">
                        <img src="img/restar.png"  id="eliminarTestigo" title="Eliminar testigo" style="display: none;">
                        <input type="hidden" id="conteoTestigos" value="1">
                        <p><label id="caracteresT1" >Caracteres restantes:<span id="span20"></span></label><textarea id="txtAreaTestigos1" maxlength="50" style="width: 330px; height: 20px;" placeholder="Testigo" onpaste="return false"></textarea></p>
                        <p><label style= "display:none" id="caracteresT2">Caracteres restantes:<span id="span21"></span></label><textarea id="txtAreaTestigos2" maxlength="50" style="width: 330px; height: 20px; display: none;" placeholder="Segundo testigo" onpaste="return false"></textarea></p>
                        <p><label style= "display:none" id="caracteresT3">Caracteres restantes:<span id="span22"></span></label><textarea id="txtAreaTestigos3" maxlength="50" style="width: 330px; height: 20px; display: none;" placeholder="Tercer testigo" onpaste="return false"></textarea></p>
                        <p><label style= "display:none" id="caracteresT4">Caracteres restantes:<span id="span23"></span></label><textarea id="txtAreaTestigos4" maxlength="50" style="width: 330px; height: 20px; display: none;" placeholder="Cuarto testigo" onpaste="return false"></textarea></p>
                        <p><label style= "display:none" id="caracteresT5">Caracteres restantes:<span id="span24"></span></label><textarea id="txtAreaTestigos5" maxlength="50" style="width: 330px; height: 20px; display: none;" placeholder="Quinto testigo" onpaste="return false"></textarea></p>
                        <p><label style= "display:none" id="caracteresT6">Caracteres restantes:<span id="span25"></span></label><textarea id="txtAreaTestigos6" maxlength="50" style="width: 330px; height: 20px; display: none;" placeholder="Sexto testigo" onpaste="return false"></textarea></p>
                        <p><label style= "display:none" id="caracteresT7">Caracteres restantes:<span id="span26"></span></label><textarea id="txtAreaTestigos7" maxlength="50" style="width: 330px; height: 20px; display: none;" placeholder="Septimo testigo" onpaste="return false"></textarea></p>
                    </div>
                    <div class= "row">
                        <label class="control-label label" for="ComoSePercataron">¿Cómo se percatarón de la situación?</label>
                        <p><label id="caracteresP1">Caracteres restantes:<span id="span27"></span></label><textarea id="txtAreaPercataron" maxlength="414" style="width: 330px; height: 20px;" onpaste="return false"></textarea></p>
                    </div>
                    <div class= "row">
                        <label class="control-label label" for="Recopilacion">Recopilación de Información y descripcion de hechos</label>
                        <img src="img/addMenu.png" id="agregarRecopilacion"  title="Agregar Recopilacion">
                        <img src="img/restar.png"  id="eliminarRecopilacion" title="Eliminar Recopilacion" style="display: none;">
                        <input type="hidden" id="conteoRecopilacion" value="1">
                        <p><label id="caracteresR1">Caracteres restantes:<span id="span1"></span></label><textarea id="txtAreaRecopilacion1" maxlength="790" style="width: 330px; height: 20px;" onpaste="return false"></textarea></p>
                        <p><label id="caracteresR2" style="display:none;">Caracteres restantes:<span id="span2"></span></label><textarea id="txtAreaRecopilacion2" maxlength="790" style="width: 330px; height: 20px; display: none;" onpaste="return false"></textarea></p>
                        <p><label id="caracteresR3" style="display:none;">Caracteres restantes:<span id="span3"></span></label><textarea id="txtAreaRecopilacion3" maxlength="790" style="width: 330px; height: 20px; display: none;" onpaste="return false"></textarea></p>
                        <p><label id="caracteresR4" style="display:none;">Caracteres restantes:<span id="span4"></span></label><textarea id="txtAreaRecopilacion4" maxlength="790" style="width: 330px; height: 20px; display: none;" onpaste="return false"></textarea></p>
                        <p><label id="caracteresR5" style="display:none;">Caracteres restantes:<span id="span5"></span></label><textarea id="txtAreaRecopilacion5" maxlength="790" style="width: 330px; height: 20px; display: none;" onpaste="return false"></textarea></p>
                        <p><label id="caracteresR6" style="display:none;">Caracteres restantes:<span id="span6"></span></label><textarea id="txtAreaRecopilacion6" maxlength="790" style="width: 330px; height: 20px; display: none;" onpaste="return false"></textarea></p>
                        <p><label id="caracteresR7" style="display:none;">Caracteres restantes:<span id="span7"></span></label><textarea id="txtAreaRecopilacion7" maxlength="790" style="width: 330px; height: 20px; display: none;" onpaste="return false"></textarea></p>
                        <p><label id="caracteresR8" style="display:none;">Caracteres restantes:<span id="span8"></span></label><textarea id="txtAreaRecopilacion8" maxlength="790" style="width: 330px; height: 20px; display: none;" onpaste="return false"></textarea></p>
                        <p><label id="caracteresR9" style="display:none;">Caracteres restantes:<span id="span9"></span></label><textarea id="txtAreaRecopilacion9" maxlength="790" style="width: 330px; height: 20px; display: none;" onpaste="return false"></textarea></p>
                        <p><label id="caracteresR10" style="display:none;">Caracteres restantes:<span id="span10"></span></label><textarea id="txtAreaRecopilacion10"maxlength="790" style="width: 330px; height: 20px; display: none;" onpaste="return false"></textarea></p>
                    </div>
                    <div class= "row">
                        <label class="control-label label" for="Tarea">Tarea realizada al momento</label>
                        <p><label id="caracteresTR1">Caracteres restantes:<span id="span11"></span></label><textarea id="txtAreaTarea" maxlength="497" style="width: 330px; height: 20px;" onpaste="return false"></textarea></p>
                    </div>
                </div><br>
                <h4>MEDIDAS ADOPTADAS</h4>
                <div  style="max-width: 70rem; border-style: groove; border-color: rgb(51,153,255); "><br>
                    <div class= "row">
                        <label class="control-label label" for="Responsabilidad">RESPONSABILIDAD</label>
                        <img src="img/addMenu.png" id="AgregarTextoResponsabilidad">
                        <img src="img/restar.png"  id="eliminarTextoResponsabilidad" title="Eliminar Recopilacion" style="display: none;">
                        <br>
                        <input type="hidden" id="conteoTxtResponsabilidad" value="1">
                        <label id="caracteresRP1">Caracteres restantes:<span id="span12"></span></label><textarea id="txtResponsabilidad1" maxlength="274" style="width: 430px; height: 20px;" onpaste="return false"></textarea>
                        <label id="caracteresRP2" style="display:none;">Caracteres restantes:<span id="span13"></span></label><textarea id="txtResponsabilidad2" maxlength="274" style="width: 430px; height: 20px; display: none;" onpaste="return false"></textarea>
                    </div>
                    <div class= "row">
                        <label class="control-label label" for="Ordenes">ORDENES DE PUESTO</label> 
                        <img src="img/addMenu.png" id="AgregarTextoOrdenes">
                        <img src="img/restar.png"  id="eliminarTextoOrdenes" title="Eliminar Recopilacion" style="display: none;">
                        <br>
                        <input type="hidden" id="conteoTxtOrdenes" value="1">
                        <label id="caracteresO1">Caracteres restantes:<span id="span14"></span></label><textarea id="txtAreaOrdenes1" maxlength="274" style="width: 430px; height: 20px;" onpaste="return false"></textarea>
                        <label id="caracteresO2" style="display:none;">Caracteres restantes:<span id="span15"></span></label><textarea id="txtAreaOrdenes2" maxlength="274" style="width: 430px; height: 20px; display: none;" onpaste="return false"></textarea>
                    </div>
                    <div class= "row">
                        <label class="control-label label" for="Evidencia">EVIDENCIA FOTOGRAFICA</label> 
                        <img src="img/addMenu.png" id="AgregarTextoEvidencia">
                        <img src="img/restar.png"  id="eliminarTextoEvidencia" title="Eliminar Recopilacion" style="display: none;">
                        <br>
                        <input type="hidden" id="conteoTxtEvidencia" value="1">
                        <label id="caracteresE1">Caracteres restantes:<span id="span16"></span></label><textarea id="txtAreaEvidencia1" maxlength="274" style="width: 430px; height: 20px;" onpaste="return false"></textarea>
                        <label id="caracteresE2" style="display:none;">Caracteres restantes:<span id="span7"></span></label><textarea id="txtAreaEvidencia2" maxlength="274" style="width: 430px; height: 20px; display: none;" onpaste="return false"></textarea>
                    </div>
                    <div class= "row">
                        <label class="control-label label" for="Supervision">SUPERVISIÓN </label> 
                        <img src="img/addMenu.png" id="AgregarTextoSupervision">
                        <img src="img/restar.png"  id="eliminarTextoSupervision" title="Eliminar Recopilacion" style="display: none;">
                        <br>
                        <input type="hidden" id="conteoTxtSupervision" value="1">
                        <label id="caracteresSP1">Caracteres restantes:<span id="span18"></span></label><textarea id="txtAreaSupervision1" maxlength="274" style="width: 430px; height: 20px;" onpaste="return false"></textarea>
                        <label id="caracteresSP2" style="display:none;">Caracteres restantes:<span id="span19"></span></label><textarea id="txtAreaSupervision2" maxlength="274" style="width: 430px; height: 20px; display: none;" onpaste="return false"></textarea>
                    </div>
                </div><br>
                <h4>DIGITALIZACIÓN DE DOCUMENTOS (EXTENCIONES ACEPTADAS (.JPG, .PNG))</h4>
                <div  style="max-width: 85rem; border-style: groove; border-color: rgb(51,153,255); "><br>
                  <form enctype='multipart/form-data' id='formDocReposrteIncCC' name='formDocReposrteIncCC'>
                    <div class= "row" id="divRobo">
                        <div class= "row">
                            <label class="control-label label " for="Ine">Ine</label>
                            <input type='file' class='btn-success ' id='Doc1' title="INE DE INVOLUCRADOS" name='Doc1[]'/>
                            <label class="control-label label " for="Ticket">Ticket</label>
                            <input type='file' class='btn-success ' id='Doc2' title="TICKET DE IMPORTE DE MERCANCIA" name='Doc2[]'/>
                            <label class="control-label label " for="CotizacionRobo">Cotización</label>
                            <input type='file' class='btn-success ' id='Doc3' title="COTIZACIÓN" name='Doc3[]'/>
                        </div><br>
                        <div class= "row">
                            <label class="control-label label " for="ficha">Ficha</label>
                            <input type='file' class='btn-success ' id='Doc4' title="FICHA DE DEPOSITO" name='Doc4[]'/>
                            <label class="control-label label " for="factura">Factura</label>
                            <input type='file' class='btn-success ' id='Doc5' title="FACTURA" name='Doc5[]'/>
                            <label class="control-label label " for="papeleta">Papeleta</label>
                            <input type='file' class='btn-success ' id='Doc6' title="PAPELETA DE DESCUENTO" name='Doc6[]'/>
                        </div><br>
                        <div class= "row">
                            <label class="control-label label " for="actaAdministrativa">Acta</label>
                            <input type='file' class='btn-success ' id='Doc10' title="ACTA ADMINISTRATIVA" name='Doc10[]'/>
                            <label class="control-label label " for="Denuncia">Denuncia</label>
                            <input type='file' class='btn-success ' id='Doc11' title="DENUNCIA ANTE AUTORIDADES" name='Doc11[]'/>
                            <label class="control-label label " for="dictamen">Dictamen</label>
                            <input type='file' class='btn-success ' id='Doc8' title="DECTAMEN DE ASEGURADORA" name='Doc8[]'/>
                        </div><br>
                        <div class= "row">
                            <label class="control-label label " for="reconocimiento">Reconocimiento</label>
                            <input type='file' class='btn-success ' id='Doc9' title="RECONOCIMIENTO" name='Doc9[]'/>
                            <label class="control-label label " for="evidencia">Evidencia</label>
                            <input type='file' class='btn-success ' id='Doc7' title="EVIDENCIA FOTOGRAFICA" name='Doc7[]' multiple onchange="revisarLimiteFotosGICC()" />
                        </div><br>
                    </div>
                  </form>
                </div><br>
            </div><br>
            <h4>TOMA DE DECISIÓN</h4>
            <div  style="max-width: 60rem; border-style: groove; border-color: rgb(51,153,255); "><br>
                <div class= "row">
                    <label class="control-label label" id="procede">¿Procederá El Reporte De Icidencia?</label>
                    <label class="control-label label" id="lblprocedesi">Si</label>
                    <input id="procedeSi" name="procedeSi" type="checkbox" style="transform: scale(1.5);">
                    <label class="control-label label" id="lblprocedeno">No</label>
                    <input id="procedeNo" name="procedeNo" type="checkbox" style="transform: scale(1.5);">
                </div><br>
                <div class= "row" style="display: none;" id="dviprocedeNo">
                    <label class="control-label label" for="MotivoCancelacion">Motivo</label>
                    <select class="span3" id="SelectMotivoCancelacion" name="SelectMotivoCancelacion" ></select>
                    <input class="input-xlarge" id="SelectMotivoCancelacionhidden" name="SelectMotivoCancelacionhidden" type="hidden">
                </div>
                <div class= "row" style="display: none;" id="dviprocedeSi">
                    <label class="control-label label" for="IncidenciaAceptacion">Lineas de Negocio</label><br>
                    <div id="divChecksLineaNegocio"></div><br>
                    <div id="divSupervisores"></div>
                    <input class="input-xlarge" id="ChecksLineaNegociohidden" name="ChecksLineaNegociohidden" type="hidden">
                </div><br>
            </div><br>
            <div id="divBtnIncidenciaCc" style="display: none;">                
                <button id="guardarIncidenciaCC" name="guardarIncidenciaCC" class="btn btn-primary " type="button" ;> 
                <span class="glyphicon glyphicon-floppy-save "></span>Guardar</button>
            </div><br>
        </div><br>

        <div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaReporteincidenciaCC" id="modalFirmaReporteincidenciaCC" data-backdrop="static">
          <div id="errormodalFirmaReporteincidenciaCC"></div>
          <div class="modal-dialog" role="document">
            <div class="modal-content">  
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y la contraseña que generaste !!</h3>
              </div>
              <div class="modal-body" align="center">
                <span class="add-on"># Empleado</span>
                <input type="text" id="NumEmpModalFirmaReporteincidenciaEmpleado" class="input-medium" name="NumEmpModalFirmaReporteincidenciaEmpleado" placeholder="00-0000-00 Ó 00-00000-00">
                <input type="hidden" id="NumEmpModalFirmaReporteincidenciaEmpleadohidden" class="input-medium" name="NumEmpModalFirmaReporteincidenciaEmpleadohidden">
                <span class="add-on">Contraseña</span>
                <input type="password" id="constraseniaFirmaParaReporteincidenciaEmpleado" class="input-xlarge"name="constraseniaFirmaParaReporteincidenciaEmpleado" title="El campo identifica entre mayusculas y    minusculas favor de considerarlo">
                <input type="hidden" id="constraseniaFirmaParaReporteincidenciaEmpleadoHidden" class="input-xlarge"name="constraseniaFirmaParaReporteincidenciaEmpleadoHidden">
              </div>
              <div class="modal-body" align="center">
                <button type="button" id="btnFirmarReporteincidenciaEmpleado" name="btnFirmarReporteincidenciaEmpleado" onclick="RevisarFirmaInternaParaReingresoEmpleado();" style="display: block;" class="btn btn-primary" >Firmar</button><br>
                <button type="button" id="btnCancelarReporteincidenciaEmpleado" name="btnCancelarReporteincidenciaEmpleado"onclick="cancelarFirmaParaReingresoEmpleado();" class="btn btn-danger" >Cancelar</button>
              </div>      
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <script src="IncidenciaCentroControl/GenerarIncidenciaCC.js"></script>
    </body>
</html>