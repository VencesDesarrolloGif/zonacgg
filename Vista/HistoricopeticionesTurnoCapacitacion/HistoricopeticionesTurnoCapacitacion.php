<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link  href="css-Bootstrap-V4.1.3/css/bootstrap.min.css" >
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/popper.min.js" > 
    </head>
    <body>
        <center><h3 class="card-title">Historico Peticiones De Turnos Capacitacion</h3>
        <br>
        <img title='Consulta/Cargar/Actualizar Pagina' src='img/ActualizarEjecutar.jpg' class='cursorImg' id='btnguardar' onclick="ConsultaHistoricoPeticionesCapacitacion();" width="50px"></center>
        <br>
        <section>
            <table id="tablaPeticionesTurnosCapacitacionHis"  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" style="display: none;">
                <thead class="thead-dark">
                    <tr>
                        <th style="text-align: center;background-color: #B0E76E">Número de empleado</th>
                        <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                        <th style="text-align: center;background-color: #B0E76E">Entidad</th>       
                        <th style="text-align: center;background-color: #B0E76E">Punto de Servicio</th>
                        <th style="text-align: center;background-color: #B0E76E">Puesto</th>
                        <th style="text-align: center;background-color: #B0E76E">Número de Supervisor</th> 
                        <th style="text-align: center;background-color: #B0E76E">Supervisor</th> 
                        <th style="text-align: center;background-color: #B0E76E">Fecha Capacitación</th> 
                        <th style="text-align: center;background-color: #B0E76E">Comentario</th> 
                        <th style="text-align: center;background-color: #B0E76E">Fecha Accion</th> 
                        <th style="text-align: center;background-color: #B0E76E">Usuario Accion</th> 
                        <th style="text-align: center;background-color: #B0E76E">Estatus</th> 
                    </tr>
                </thead>
            </table>
        </section>
        <script src="HistoricopeticionesTurnoCapacitacion/HistoricopeticionesTurnoCapacitacion.js"></script>
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/js/bootstrap.min.js">
    </body>
</html>