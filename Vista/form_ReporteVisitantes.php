
<form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
<center>
<fieldset>

	<STRONG>CONSULTA DEL <input type="date" id="fechaConsulta1" onChange='obtenerListaVisitantesConFechaDe();' class='input-medium' ></input> AL
	<input type="date" id="fechaConsulta2" onChange='mensage();' class='input-medium' ></input></STRONG>
</fieldset>
</center>


<div id="listaDeVisitantes1">
	
</div>
<button id="descargar" name="descargar" class="btn btn-success" type="button" onclick="" > <span class="glyphicon glyphicon-download-alt"></span>Descargar</button>
<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>

<script type="text/javascript">
$(inicioReporteVisit());  
	
function obtenerListaVisitantesConFechaDe()
{
var fechaConsulta1 = $("#fechaConsulta1").val();
 $.ajax({
            
            type: "POST",
            url: "ajax_obtenerVisitatesDeUnDia.php",
            dataType: "json",
            data:{"fechaConsulta1":fechaConsulta1},
            success: function(response) {
                if (response.status == "success")
                {
                  
                    var listaVisitantesConFechaDe = response.listaVisitantesConFechaDe;

                    
                    listaVisitantesTable1="<table class='table table-hover' id='Exportar_a_Excel'><thead><th>Apellido Paterno</th><th>Apellido Materno</th><th>Nombre</th><th>Area Visita</th><th>Asunto</th><th>Identificacion</th><th>Hora Entrada</th><th>Hora Salida</th></thead><tbody>";

                    for ( var i = 0; i < listaVisitantesConFechaDe.length; i++ ){
                      var visitanteId = listaVisitantesConFechaDe[i].idVisitante;



                      listaVisitantesTable1 += "<tr><td>"+listaVisitantesConFechaDe[i].visitanteApPaterno+" </td><td>"+listaVisitantesConFechaDe[i].visitanteApMaterno+"</td><td>"+listaVisitantesConFechaDe[i].visitanteNombre+"</td><td>"+listaVisitantesConFechaDe[i].nombreDepto+"</td><td>"+listaVisitantesConFechaDe[i].descripcionAsunto+"</td><td>"+listaVisitantesConFechaDe[i].nombreIdentifiacion+"</td><td>"+listaVisitantesConFechaDe[i].horarioEntrada+"</td><td>"+listaVisitantesConFechaDe[i].horarioSalida+"</td><tr>";
                    }

                    listaVisitantesTable1 += "</tbody></table>";
                    $('#listaDeVisitantes1').html(listaVisitantesTable1); 
                  
                }
                else if (response.status == "error" && response.message == "No autorizado")
                {
                    window.location = "login.php";
                }
            },
            error: function (response)
            {
                console.log (response);

            }
        });
}

function obtenerListaVisitantesConRangoFecha()
{
var fechaConsulta1 = $("#fechaConsulta1").val();
var fechaConsulta2 = $("#fechaConsulta2").val();
 $.ajax({
            
            type: "POST",
            url: "ajax_obtenerListaVisitantesRangoFecha.php",
            dataType: "json",
            data:{"fechaConsulta1":fechaConsulta1, "fechaConsulta2":fechaConsulta2},
            success: function(response) {
                if (response.status == "success")
                {
                  
                    var listaVisitantesConRangoDeFecha = response.listaVisitantesConRangoDeFecha;

                    
                    listaVisitantesTable1="<table class='table table-hover' id='Exportar_a_Excel'><thead><th>Apellido Paterno</th><th>Apellido Materno</th><th>Nombre</th><th>Area Visita</th><th>Asunto</th><th>Identificacion</th><th>Hora Entrada</th><th>Hora Salida</th></thead><tbody>";

                    for ( var i = 0; i < listaVisitantesConRangoDeFecha.length; i++ ){
                      var visitanteId = listaVisitantesConRangoDeFecha[i].idVisitante;



                      listaVisitantesTable1 += "<tr><td>"+listaVisitantesConRangoDeFecha[i].visitanteApPaterno+" </td><td>"+listaVisitantesConRangoDeFecha[i].visitanteApMaterno+"</td><td>"+listaVisitantesConRangoDeFecha[i].visitanteNombre+"</td><td>"+listaVisitantesConRangoDeFecha[i].nombreDepto+"</td><td>"+listaVisitantesConRangoDeFecha[i].descripcionAsunto+"</td><td>"+listaVisitantesConRangoDeFecha[i].nombreIdentifiacion+"</td><td>"+listaVisitantesConRangoDeFecha[i].horarioEntrada+"</td><td>"+listaVisitantesConRangoDeFecha[i].horarioSalida+"</td><tr>";
                    }

                    listaVisitantesTable1 += "</tbody></table>";
                    $('#listaDeVisitantes1').html(listaVisitantesTable1); 
                  
                }
                else if (response.status == "error" && response.message == "No autorizado")
                {
                    window.location = "login.php";
                }
            },
            error: function (response)
            {
                console.log (response);

            }
        });
}

function mensage(){

	alert("Todavia no funciono =( ");
}

</script>


<script language="javascript">


function inicioReporteVisit(){
    $("#descargar").click(function(event) {
     $("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
     $("#FormularioExportacion").submit();
    });

}
</script>