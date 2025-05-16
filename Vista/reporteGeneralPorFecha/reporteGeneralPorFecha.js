function generarReporteGeneralPorFechas()
    {
        var FechaInicialReportePorFechas = $("#FechaInicialReportePorFechas").val();
        var FechaFinalReportePorFechas = $("#FechaFinalReportePorFechas").val();
        if(FechaInicialReportePorFechas =="" || FechaFinalReportePorFechas==""){
                swal("Alto", "Ninguna de las dos fechas puede ir vacia por favor verifiquelas", "error");
        }else if(FechaInicialReportePorFechas>FechaFinalReportePorFechas){
                swal("Alto", "La fecha de incio no puede ser mayor que la fecha final", "error");

        }else{
                window.open("reporteGeneralPorFecha/consultaGeneralEmpleadosPorFechas.php?FechaInicialReportePorFechas="+FechaInicialReportePorFechas+"&FechaFinalReportePorFechas="+FechaFinalReportePorFechas+"","width=600,height=600,scrollbars=no");
        }
    }