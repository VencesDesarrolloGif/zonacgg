<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link  href="css-Bootstrap-V4.1.3/css/bootstrap.min.css" >
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/popper.min.js" >
    </head>
    <body>
        <center><h3 class="card-title">Peticiones de turnos capacitacion</h3>
            <div id="MensajePeticionCapacitacion"></div>
            <img title='Consulta/Cargar/Actualizar Pagina' src='img/ActualizarEjecutar.jpg' class='cursorImg' id='btnguardar' onclick="ConsultaPeticionesCapacitacion();" width="50px"></center>
        
                <br>
        <br>
        <div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalRechazarPeticionTurno" id="modalRechazarPeticionTurno" data-backdrop="static">
           <div id="errorModalRechazarPeticion"></div>
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h3 class="modal-title" align="center"><img src="img/alert.png">Escriba el motivo por el cual es rechazada esta petición</h3>
                </div>
                    <div class="modal-body" align="center">
                       <span class="add-on">Comentario (Obligatorio)</span>
                        <input type="text" id="ComentarioRechazoPet" class="input-xlarge"name="ComentarioRechazoPet" title="Indique el motivo por el cual fue rechazada la petición de asistencia por capacitación">
                    </div>
                      <div class="modal-body" align="center">
                        <button type="button" id="btnAceptarRechazoPet" name="btnAceptarRechazoPet" onclick="ProcesarRechazoDePeticionCap();" class="btn btn-primary" >Guardar</button>
                      </div>      
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <input type="hidden" id="BanderaAccion" name="BanderaAccion">
        <input type="hidden" id="BanderaIdPeticion" name="BanderaIdPeticion">

        <section>
            <table id="tablaPeticionesTurnosCapacitacion"  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead class="thead-dark">
                    <tr>
                        <th style="text-align: center;background-color: #B0E76E">Número de empleado</th>
                        <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                        <th style="text-align: center;background-color: #B0E76E">Entidad</th>       
                        <th style="text-align: center;background-color: #B0E76E">Punto de Servicio</th>
                        <th style="text-align: center;background-color: #B0E76E">Puesto</th>
                        <th style="text-align: center;background-color: #B0E76E">Número de empleado Supervisor</th> 
                        <th style="text-align: center;background-color: #B0E76E">Supervisor</th> 
                        <th style="text-align: center;background-color: #B0E76E">Fecha Capacitación</th> 
                        <th style="text-align: center;background-color: #B0E76E">Aceptar/Rechazar</th> 
                    </tr>
                </thead>
            </table>
        </section>
        <script src="PeticionesTurnoCapacitacion/funciones_PeticionesTurnosCapacitacion.js"></script>
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/js/bootstrap.min.js">
    </body>
</html>