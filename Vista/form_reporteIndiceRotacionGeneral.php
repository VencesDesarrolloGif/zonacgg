<div class="container" align="center" >
	<legend>Índice de rotación por mes</legend>

	<label class="control-label label " for="lblPlantillaGif">Año:</label>
	<select name="selectAnioRotacion" id="selectAnioRotacion" onchange="crearTableMonth();">
            <?php
            for($i=date('o'); $i>=2016; $i--){
                if ($i == date('o'))
                    echo '<option value="'.$i.'" selected>'.$i.'</option>';
                else
                    echo '<option value="'.$i.'">'.$i.'</option>';
            }
            ?>
	</select><img src="img/refresh-icon.png" class="cursorImg" onclick="crearTableMonth();">
	<br>
	<br>
	<div name='divIndicadores' id='divIndicadores'>

	</div>

</div>



<script type="text/javascript">


	var meses=[
		 {nameMonth:"ENERO", numberMonth:"01"}
		,{nameMonth:"FEBRERO", numberMonth:"02"}
		,{nameMonth:"MARZO", numberMonth:"03"}
		,{nameMonth:"ABRIL", numberMonth:"04"}
		,{nameMonth:"MAYO", numberMonth:"05"}
		,{nameMonth:"JUNIO", numberMonth:"06"}
		,{nameMonth:"JULIO", numberMonth:"07"}
		,{nameMonth:"AGOSTO", numberMonth:"08"}
		,{nameMonth:"SEPTIEMBRE", numberMonth:"09"}
		,{nameMonth:"OCTUBRE", numberMonth:"10"}
		,{nameMonth:"NOVIEMBRE", numberMonth:"11"}
		,{nameMonth:"DICIEMBRE", numberMonth:"12"}
	];

$(inicioRepIndRotGral());  

function inicioRepIndRotGral(){
		crearTableMonth();
}

	function crearTableMonth () {
		var dataTable="<table class='table table-bordered'><th>Mes</th><th>Altas</th><th>Bajas</th><th>Plantilla Gif</th><th>Plantilla Ventas</th><th>Índice rotación</th><th>Índice cobertura</th>";
		var anio=$("#selectAnioRotacion").val();
		//var datosMeses=datosMeses;
		for(var i=0; i<meses.length; i++ ){

			var numberMonth=meses[i]["numberMonth"];
			var nameMonth=meses[i]["nameMonth"];

			dataTable+="<tr><td>"+nameMonth+"</td>"+generarIndicador(numberMonth,anio)+"</tr>";
			

		}
		dataTable+="</table>";
		$("#divIndicadores").html(dataTable);
	}

	function generarIndicador(month,anio){
		//alert(month+"/"+anio);
		//alert(month);
		
      var result="";
      $.ajax({
            type: "POST",
            url: "ajax_getAltasByMonth.php",
            data: {month:month,anio:anio},
            dataType: "json",
            async: false,
            success: function(response) {
                if (response.status == "success")
                {
                    var altasMes = response.altasMes.altasMes;
                    var bajasMes = response.bajasMes.bajasMes;
                    var numeroElementosGif=response.numElementosGif.numElementosGif;
                    var elementosVentas=response.elementosVentas.elementosVentas;
                    var indiceRotacion=((altasMes-bajasMes)/numeroElementosGif)*100;
                    var indiceCobertura=((altasMes-bajasMes)/elementosVentas)*100;
                    
                    result="<td>"+altasMes+"</td><td>"+bajasMes+"</td><td>"+numeroElementosGif+"</td><td>"+elementosVentas+"</td><td>"+indiceRotacion.toFixed(2)+"%</td><td>"+indiceCobertura.toFixed(2)+"%</td>";

     
                    
                }else{
                	result="<td>0</td>";
                	
                }
            },
            error: function (response)
            {
                console.log (response);
            }
        });
		return result;
	}
</script>
