

<form class="form-horizontal"  method="post" id="form_menuReportes"  target="_blank">
<div align="center">
	<legend>
		REPORTES
	</legend>

	

	<TABLE align="center">
		<tr><td><img src="img/personalActivo.png" class="cursorImg" onclick=''></td><td></td></tr>
		<tr><td>PERSONAL ACTIVO</td><td>      </td></tr>
	</TABLE>

</div>


<table>
<tr>
    <td valign="top"><div id="ingresosEgresos" align="center"></div></td>
    <td valign="top"><div id="grafica"></div><div id="grafica2"></div></td>
 
</tr>
<tr>
  <td></td>

</tr>
</table>


</form>

<script type="text/javascript">

var valoresGraficacion = [];

function accion(){
	alert("hola");
}


function obtenerIngresosEgresos()
  {
       
      $.ajax({
            
            type: "POST",
            url: "ajax_obtenerIngresosEgresos.php",
            data: {"mes":3, "anio":2015, "empresaId":1},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                     
                    var listaIngresosEgresos = response.listaIngresosEgresos;
              
                      
                    listaIngresosEgresosTable="<table class='table table-hover' data-toggle='table' ><thead>";

                    listaIngresosEgresosTable +="<th>Casificación</th><th>Descripción</th><th>TipoMovimiento</th><th>Saldo Inicial</th><th>Ingreso</th><th>Egreso</th><td>Porcentaje</th><th>Porcentaje</th></thead><tbody>";

                    var v = "a=0";
                    var v_index = 0;

                    var v2 = "b=0";
                    var v2_index = 0;

                    var v3 = "c=0";
                    var v3_index = 0;

                    var v4 = "d=0";
                    var v4_index = 0;
                    
                    for ( var i = 0; i < listaIngresosEgresos.length; i++ ){
                        //var clasificacionId = listaIngresosEgresos[i].idClasificacion;
                        var clasificacionClave = listaIngresosEgresos[i].claveClasificacion;
                        var descripcionClasificacion = listaIngresosEgresos[i].descripcionClasificacion;
                        var tipoMovimiento = listaIngresosEgresos[i].descripcionMovimientoFinanciero;
                        var saldoInicial=listaIngresosEgresos[i].saldoInicial;
                        var egreso =listaIngresosEgresos[i].Egreso;
                        var ingreso= listaIngresosEgresos[i].Ingreso;
                        var porcentaje=listaIngresosEgresos[i].Porcentaje

                        if (clasificacionClave=="claveClasificacion" && descripcionClasificacion=="descripcionClasificacion" && tipoMovimiento=="descripcionMovimientoFinanciero" && egreso=="Egreso" && ingreso=="Ingreso" )
                        {
                            clasificacionClave="";
                            descripcionClasificacion="";
                            tipoMovimiento="";
                            egreso="";
                            ingreso="";
                            porcentaje="";
                          
                        }
                        
                        if(porcentaje=="%"){
                            porcentaje="0%";
                        }
                       
                       valoresGraficacion.push(porcentaje.replace("%",""));
                       
                       
                       if (ingreso != "" && ingreso != null && descripcionClasificacion != "TOTAL")
                       {
                           console.log ("ingreso=" + ingreso + "," + ingreso.replace(/,/g, ""));
                           v += "&v[" + v_index + "]=" + ingreso.replace(/,/g, "");
                           v_index++;
                       }

                       if (descripcionClasificacion != "" && clasificacionClave != "" && descripcionClasificacion != "TOTAL" &&  tipoMovimiento=="ABONO" && ingreso !=null)
                       {
                           console.log (descripcionClasificacion);
                           v2 += "&v2[" + v2_index + "]=" + descripcionClasificacion;
                           v2_index++;
                       }

                        if (egreso != "" && egreso != null && descripcionClasificacion != "TOTAL")
                       {
                           console.log ("egreso=" + egreso + "," + egreso.replace(/,/g, ""));
                           v3 += "&v3[" + v3_index + "]=" + egreso.replace(/,/g, "");
                           v3_index++;
                       }

                        if (descripcionClasificacion != "" && clasificacionClave != "" && descripcionClasificacion != "TOTAL" &&  tipoMovimiento=="CARGO" && egreso !=null)
                       {
                           console.log (descripcionClasificacion);
                           v4 += "&v4[" + v4_index + "]=" + descripcionClasificacion;
                           v4_index++;
                       }




                       if (tipoMovimiento=="ABONO"){
                        listaIngresosEgresosTable += "<tr><td>"+clasificacionClave+" </td><td>"+descripcionClasificacion+"</td><td>"+tipoMovimiento+"</td><td>"+saldoInicial+"</td><td>"+ingreso+"</td><td>"+egreso+"</td><td>"+porcentaje+"</td>";
                       }else if (tipoMovimiento="CARGO"){
                        listaIngresosEgresosTable += "<tr><td>"+clasificacionClave+" </td><td>"+descripcionClasificacion+"</td><td>"+tipoMovimiento+"</td><td>"+saldoInicial+"</td><td>"+ingreso+"</td><td>"+egreso+"</td><td></td><td>"+porcentaje+"</td>";

                       }

                        
                    
                        
                }       
                  listaIngresosEgresosTable += "</tbody></table>";
                  $('#ingresosEgresos').html(listaIngresosEgresosTable);     
                   
                   console.log (v);
                   console.log (v2);
                   console.log (v3);
                   console.log (v4);
                   
                   $("#grafica").html("<img src='ejemplo2.php?" + v + v2 +"' />");
                   $("#grafica2").html("<img src='grafic_Egresos.php?" + v3 + v4 + "' />");
                   
                   
                 }
            },           

            error: function (response)
            {
                console.log (response);

            }
        });
  }

</script>



