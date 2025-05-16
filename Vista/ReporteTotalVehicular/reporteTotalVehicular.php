<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link  href="css-Bootstrap-V4.1.3/css/bootstrap.min.css" >
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/popper.min.js" >
    </head>
    <body>
        <center><h3 class="card-title">Reporte Total de Vehiculos</h3>
        <br>
        <!-- <img title='Consulta/Cargar/Actualizar Pagina' src='img/ActualizarEjecutar.jpg' class='cursorImg' id='btnguardar' width="50px" id="btnConsultarReporte"></center> -->
        <button id="btnConsultarReporte" style="width: 150px;height: 40px;border-radius: 20px;background-color: rgba(159, 209, 13, .8);color: blue;">Consultar</button>
        <br>
        <section>
            <table id="tablaPeticionesTurnosCapacitacionHis"  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" style="display: none;">
                <thead class="thead-dark">
                    <tr>
                        <th style="text-align: center;background-color: #B0E76E">Linea de Negocio</th>
                        <th style="text-align: center;background-color: #B0E76E">Entidad</th>       
                        <th style="text-align: center;background-color: #B0E76E">Placa</th>
                        <th style="text-align: center;background-color: #B0E76E">Marca</th> 
                        <th style="text-align: center;background-color: #B0E76E">Modelo</th> 
                        <th style="text-align: center;background-color: #B0E76E">Color</th> 
                        <th style="text-align: center;background-color: #B0E76E">Anio</th> 
                        <th style="text-align: center;background-color: #B0E76E">Motor</th> 
                        <th style="text-align: center;background-color: #B0E76E">Estatus Vehiculo</th> 
                        <th style="text-align: center;background-color: #B0E76E">Número de empleado</th>
                        <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                        <th style="text-align: center;background-color: #B0E76E">Estatus Empleado</th> 
                    </tr>
                </thead>
            </table>
        </section>
        <script src="ReporteTotalVehicular/reporteTotalVehicular.js"></script>
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/js/bootstrap.min.js">
    </body>
</html>