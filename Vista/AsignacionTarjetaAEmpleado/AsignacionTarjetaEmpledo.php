<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link  href="css-Bootstrap-V4.1.3/css/bootstrap.min.css" >
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/popper.min.js" >
    </head>
    <body>
        <center><h3 class="card-title">REPORTE ENTREGA DE TARJETA DE DESPENSA A EMPLEADOS </h3>
        <br>
        <img title='Consulta/Cargar/Actualizar Pagina' src='img/start.png' class='cursorImg' onclick="obtenerSucursalReporteTarjetaDes();" width="80px"><br><br>

        <div calss="row" id="DivSucursalReporteTarjetaDes" style="display:none;">                
            <label class="control-label label" for="selectSucursalReporteTarjetaDes">Sucursal</label>
            <select class="span3" id="selectSucursalReporteTarjetaDes" name="selectSucursalReporteTarjetaDes"></select>     
        </div><br>

        <div calss="row" id="DivFehcaInicioReporteTarjetaDes" style="display: none;">                
            <label class="control-label label" for="InputFechaInicio">Fecha Inicio</label>
            <input id="InputFechaInicioReporteTarjetaDes" name="InputFechaInicioReporteTarjetaDes" type="date" class="input-medium">   

            <label class="control-label label" for="InputFechaFin">Fecha Fin</label>
            <input id="InputFechaFinReporteTarjetaDes" name="InputFechaFinReporteTarjetaDes" type="date" class="input-medium">   
        </div>

        <div id="divBotonBuscar" style="display: none;">
            <button id="BuscarMovimientosTjDespensa" name="BuscarMovimientosTjDespensa" class="btn btn-success" type="button"><span class="glyphicon glyphicon-refresh"></span>Buscar</button>
        </div>
        </center>
        <br>
        <div id="divTableDatosMovimientosTarjetaAEmpleados" style="display:none;">
            <section>
                <table id="TableDatosMovimientosTarjetaAEmpleados"  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th style="text-align: center;background-color: #B0E76E">SUCURSAL</th>
                            <th style="text-align: center;background-color: #B0E76E">IUT TARJETA</th>
                            <th style="text-align: center;background-color: #B0E76E">NÚMERO EMPLEADO</th>
                            <th style="text-align: center;background-color: #B0E76E">NOMBRE EMPLEADO</th>
                            <th style="text-align: center;background-color: #B0E76E">NUMERO QUE ASIGNO</th> 
                            <th style="text-align: center;background-color: #B0E76E">NOMBRE QUE ASIGNO</th> 
                            <th style="text-align: center;background-color: #B0E76E">CONTRASEÑA QUE ASIGNO</th> 
                            <th style="text-align: center;background-color: #B0E76E">FECHA ASIGNACIÓN</th> 
                            <th style="text-align: center;background-color: #B0E76E">USUARIO USADO PARA ASIGNAR</th> 
                            <th style="text-align: center;background-color: #B0E76E">ESTATUS TARJETA</th> 
                            
                        </tr>
                    </thead>
                </table>
            </section>
        </div>
        <script src="AsignacionTarjetaAEmpleado/AsignacionTarjetaEmpledo.js"></script>
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/js/bootstrap.min.js">
    </body>
</html>