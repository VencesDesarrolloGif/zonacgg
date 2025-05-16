<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    </head>
    <body>
        <center><h3 class="card-title">Geolocalización</h3>
        <br>
        <img title='Consulta/Cargar/Actualizar Pagina' src='img/ActualizarEjecutar.jpg' class='cursorImg' id='BuscarGeo' width="50px"></center>
        <br>
        <section>
            <table id="tablaGeoPorPuntos"  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" style="display: none;">
                <thead class="thead-dark">
                    <tr>
                        <th style="text-align: center;background-color: #B0E76E">Id Punto</th>
                        <th style="text-align: center;background-color: #B0E76E">Nombre Punto</th>
                        <th style="text-align: center;background-color: #B0E76E">Estatus</th>       
                        <th style="text-align: center;background-color: #B0E76E">Fecha Inicio</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha Termino</th>
                        <th style="text-align: center;background-color: #B0E76E">Usuario</th> 
                        <th style="text-align: center;background-color: #B0E76E">Latitud</th> 
                        <th style="text-align: center;background-color: #B0E76E">Longitud</th> 
                    </tr>
                </thead>
            </table>
        </section>
        <script src="GeoPorPuntos/GeoPorPuntos.js"></script>
    </body>
</html>