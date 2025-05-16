<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link  href="css-Bootstrap-V4.1.3/css/bootstrap.min.css" >
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/popper.min.js" >
    </head>
    <body>
        <center><h3 class="card-title">ARCHIVO PARA ASIGNAR TARJETAS STOCK TITULARES MONEDEROS DESPENSA POR QUINCENA</h3>
        <br>
        <img title='Consulta/Cargar/Actualizar Pagina' src='img/start.png' class='cursorImg' id='btnguardar' onclick="obtenerEjercciosParaConsulta();" width="80px"><br>

        <div calss="row" id="DivEjercicio" style="display:none;">                
            <label class="control-label label" for="selectEjercicioT">Ejercicio</label>
            <select class="span3" id="selectEjercicioT" name="selectEjercicioT"></select>     
        </div><br>

        <div calss="row" id="DivFehcaInicio" style="display: none;">                
            <label class="control-label label" for="selectFehcaInixioTarj">Fecha Inicio</label>
            <select class="span3" id="selectFehcaInixioTarj" name="selectFehcaInixioTarj"></select>     

            <label class="control-label label" for="TotalStockMatriz">Fecha Fin</label>
            <input class="span3" id="FechaFin" name="FechaFin" type="text" readonly="true">
        </div>
        </center>
        <br>
        <div id="TableArchivoASignarTitulares" style="display:none;">
            <section>
                <table id="tablaestatusTarjetaDespensa"  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th style="text-align: center;background-color: #B0E76E">NUMERO EMPLEADO</th>
                            <th style="text-align: center;background-color: #B0E76E">LUGAR ENTREGA</th>
                            <th style="text-align: center;background-color: #B0E76E">NUM. EMPLEADO/REF.</th>
                            <th style="text-align: center;background-color: #B0E76E">NOMBRE EN TARJETA</th> 
                            <th style="text-align: center;background-color: #B0E76E">IUT</th> 
                            <th style="text-align: center;background-color: #B0E76E">NOMBRE EMPLEADO</th> 
                            <th style="text-align: center;background-color: #B0E76E">APELLIDO PATERNO</th> 
                            <th style="text-align: center;background-color: #B0E76E">APELLIDO MATERNO</th> 
                            <th style="text-align: center;background-color: #B0E76E">RFC</th> 
                            <th style="text-align: center;background-color: #B0E76E">CURP</th> 
                            <th style="text-align: center;background-color: #B0E76E">NSS</th> 
                            <th style="text-align: center;background-color: #B0E76E">TELÉFONO CELULAR</th> 
                            <th style="text-align: center;background-color: #B0E76E">CORREO ELECTRÓNICO</th> 
                        </tr>
                    </thead>
                </table>
            </section>
        </div>
        <script src="EstatusMovimientoTarjetaDespensa/EstatusMovimientoTarjetaDespensa.js"></script>
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/js/bootstrap.min.js">
    </body>
</html>