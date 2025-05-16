<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    </head>
    <body>
        <center>
        <form class="form-horizontal"  method="post" id="form_consultaGeneralPorFechas" name='form_consultaGeneralPorFechas' target="_blank">
            <fieldset ><legend>REPORTE GENERAL POR FECHAS</legend></fieldset>
            <span>FECHA INICIAL</span><input type="date" name="FechaInicialReportePorFechas" id="FechaInicialReportePorFechas">
            <span>FECHA FINAL</span><input type="date" name="FechaFinalReportePorFechas" id="FechaFinalReportePorFechas"><br><br>
            <button type='button' class='btn btn-info' onclick='generarReporteGeneralPorFechas();'>Generar Reporte <span class='glyphicon glyphicon-refresh' ></span></button> 
 
        </form>
        </center>
        <script src="reporteGeneralPorFecha/reporteGeneralPorFecha.js"></script>
    </body>
</html>

