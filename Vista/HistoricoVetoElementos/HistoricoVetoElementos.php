<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    </head>
    <body>
        <center><h3 class="card-title">HISTORICO DE ELEMENTOS VETADOS</h3>
        <br>
        <img title='Consulta/Cargar/Actualizar Pagina' src='img/ActualizarEjecutar.jpg' class='cursorImg' id='btnguardar' onclick="ConsultaElementosVetadosEmp();" width="50px"></center>
        <br>
        <section>
            <table id="tablaHistoricoVeto" style="display:none;"  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead class="thead-dark">
                    <tr>
                        <th style="text-align: center;background-color: #B0E76E">Número de empleado</th>
                        <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                        <th style="text-align: center;background-color: #B0E76E">Comentario Vetado</th>
                        <th style="text-align: center;background-color: #B0E76E">Procedencia Del Veto</th>
                        <th style="text-align: center;background-color: #B0E76E">Documento Veto</th>
                    </tr>
                </thead>
            </table>
        </section>

        <script src="HistoricoVetoElementos/HistoricoVetoElementos.js"></script>
    </body>
</html>