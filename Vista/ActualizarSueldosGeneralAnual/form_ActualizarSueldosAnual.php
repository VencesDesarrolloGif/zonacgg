<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    </head>
    <body>
        <form class="form-horizontal" id="form_SueldosGral" name="form_SueldosGral">
            <center><h3 class="card-title">LISTA DE EMPLEADOS ACTIVOS PARA ACTUALIZACION DE SUELDO ANUAL</h3>
            <br>
            <img title='Consulta/Cargar/Actualizar Pagina' src='img/ActualizarEjecutar.jpg' class='cursorImg' onclick="TraerElementosActivosParaActuSueldos();" width="50px">
            <br><br>
            <span>Ingresa el nuevo sueldo</span><br>
            <input type="text" name="InpNuevoSueldo" id="InpNuevoSueldo" class="input-medium">
            <div id="divsueldos"></div>
            </center>
        </form>
        <script src="ActualizarSueldosGeneralAnual/ActualizarSueldosAnual.js"></script>
    </body>
</html>