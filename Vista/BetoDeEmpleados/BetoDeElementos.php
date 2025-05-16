<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    </head>
    <body>
        <center><h3 class="card-title">LISTA DE EMPLEADOS DADOS DE BAJA PARA POSIBLE VETO</h3>
        <br>
        <img title='Consulta/Cargar/Actualizar Pagina' src='img/ActualizarEjecutar.jpg' class='cursorImg' id='btnguardar' onclick="ConsultaElementosParaVetar();" width="50px">
        <br><br>
        <span class="add-on">Fecha Inicio:</span>
        <input class="input-medium" id="fechaInicioDiasVetoEmpleado" name="fechaInicioDiasVetoEmpleado" type="date">
        <span class="add-on">Fecha Fin:</span>
        <input class="input-medium" id="fechaTerminoDisasVetoEmpleado" name="fechaTerminoDisasVetoEmpleado" type="date"></center>
        <section>
            <table id="tablaAccionBetar" style="display:none;"  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead class="thead-dark">
                    <tr>
                        <th style="text-align: center;background-color: #B0E76E">Número de empleado</th>
                        <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                        <th style="text-align: center;background-color: #B0E76E">Entidad De Trabajo</th>
                        <th style="text-align: center;background-color: #B0E76E">Punto De Servicio</th>
                        <th style="text-align: center;background-color: #B0E76E">Número Supervisor</th>
                        <th style="text-align: center;background-color: #B0E76E">Nombre Supervisor</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha De Alta</th>       
                        <th style="text-align: center;background-color: #B0E76E">Fecha De Baja</th>
                        <th style="text-align: center;background-color: #B0E76E">Acción</th>
                    </tr>
                </thead>
            </table>
        </section>
        <div class="modalEdit hide fade" tabindex="-1" role="dialog" name="ModalBetarElemento" id="ModalBetarElemento" data-backdrop="static">
            <div id="errorModalBetarElemento"></div>
            <div class="modal-dialog" role="document">
              <div class="modal-content">  
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h3 class="modal-title" align="center"><img src="img/alert.png">Veto Del Empleado</h3>
                </div>
                <div class="modal-body" align="center">
                    <div class="input-prepend">
                        <span class="add-on"># Empleado</span>
                        <input type="text" id="NumeroEmpleadoModalBeto" class="input-medium" name="NumeroEmpleadoModalBeto" readonly="true">
                        <span class="add-on">Nombre</span>
                        <input type="text" id="NombrEmpeladoModalBeto" class="input-large" name="NombrEmpeladoModalBeto" readonly="true">
                    </div><br>
                    <div class="input-prepend">
                        <span class="add-on">Comentario Por Que Vetara Al Empleado</span>
                        <input type="text" id="ComentarioVetoElemento" class="input-large" name="ComentarioVetoElemento">
                    </div><br>
                    <div class="input-prepend">
                        <h4>Se Anexará Archivo Del Motivo Por Lo Que Se Vetara Al Empleado?</h4>
                    </div><br>
                    <div class="input-prepend">
                        <label class="control-label label" id="labelCheckArchivoBeto">Si  </label>
                        <input id="checkSiVeto" name="checkSiVeto" type="checkbox" style="transform: scale(1.5);">
                    </div>
                    <div class="input-prepend">
                        <label class="control-label label" id="labelCheckArchivoBeto">No  </label>
                        <input id="checkNoVeto" name="checkNoVeto" type="checkbox" style="transform: scale(1.5);">
                    </div><br>
                    <div class="input-prepend" style="display: none;" id="inpComentarioNoArchivo">
                        <span class="add-on">Comentario Por Que no Se Anexara archivo</span>
                        <input type="text" id="ComentarioArchivoVetoElemento" class="input-large" name="ComentarioArchivoVetoElemento">
                    </div><br>
                    <div class="input-prepend" style="display: none;" id="divArchivoVeto">
                        <form enctype='multipart/form-data' id='formArchivoVetoEmpleado' name='formArchivoVetoEmpleado'>
                            <label class="control-label label" for="archivoVetoEmpleado">Seleccionar archivo: </label>
                            <span class="btn btn-success btn-file" >Examinar
                                <input type='file' class='btn-success' id='archivoVetoEmpleado' name='archivoVetoEmpleado[]'/>  
                            </span>     
                        </form>
                    </div>
                </div>
                <div class="modal-footer" align="center">
                  <button type="button" id="btnVetarElemento" name="btnVetarElemento" class="btn btn-primary" >Aceptar</button>
                  <button type="button" id="btnCancelarVeto" name="btnCancelarVeto" class="btn btn-danger" >Cancelar</button>
                </div>      
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <script src="BetoDeEmpleados/BetoDeElementos.js"></script>
    </body>
</html>