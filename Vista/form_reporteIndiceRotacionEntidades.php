<div class="container">
    <center>
    <legend>índice de rotación por entidad</legend>

	<label class="control-label label " for="lblPlantillaGif">Mes:</label>
	<select id="selectMesRotacion" name="selectMesRotacion" onchange="getListaEntidades();">
		
	</select>
	<label class="control-label label " for="lblPlantillaGif">De:</label>

	<select name="selectAnioRotacionEntidad" id="selectAnioRotacionEntidad" onchange="getListaEntidades();">
            <?php
            for($i=date('o'); $i>=2016; $i--){
                if ($i == date('o'))
                    echo '<option value="'.$i.'" selected>'.$i.'</option>';
                else
                    echo '<option value="'.$i.'">'.$i.'</option>';
            }
            ?>
	</select><img src="img/refresh-icon.png" class="cursorImg" onclick="getListaEntidades();">
	<br>
	<br>
	<table class='table table-bordered' id="tableEntidadRotacion" name="tableEntidadRotacion">
		<th>Mes</th><th>Altas</th><th>Bajas</th><th>Plantilla Gif</th><th>Plantilla Ventas</th><th>Índice rotación</th><th>Índice cobertura</th>
		
	</table>
    </center>
</div>
<script type="text/javascript">
	//ajax_indiceRotacionEntidad.php
    $(inicioRepIndRotEnt());  

function inicioRepIndRotEnt(){
    createOptionMonth();
}
	function generarIndicadorEntidad(entidadId){
		//alert(month+"/"+anio);
		//alert(month);
		//waitingDialog.show();
		
		var month=$("#selectMesRotacion").val();
		var anio=$("#selectAnioRotacionEntidad").val();

		
      var result="";
      $.ajax({
            type: "POST",
            url: "ajax_indiceRotacionEntidad.php",
            data: {month:month,anio:anio, entidadId:entidadId},
            dataType: "json",
            async: false,
            success: function(response) {
                if (response.status == "success")
                {
                    var altasMes = response.altasMes.altasMes;
                    var bajasMes = response.bajasMes.bajasMes;
                    var numElementosGif=response.numElementosGif.numElementosGif;
                    var elementosVentas=response.elementosVentas.elementosVentas;
                    if(numElementosGif!=0){
                    var indiceRotacion=((altasMes-bajasMes)/numElementosGif)*100;	
                    }
                    else{
                    	var indiceRotacion=0;
                    }

                    if(elementosVentas!=0){

                    	var indiceCobertura=((altasMes-bajasMes)/elementosVentas)*100;

                    }else{
                    	var indiceCobertura=0;
                    }
                    
                    
                    result="<td>"+altasMes+"</td><td>"+bajasMes+"</td><td>"+numElementosGif+"</td><td>"+elementosVentas+"</td><td>"+indiceRotacion.toFixed(2)+"%</td><td>"+indiceCobertura.toFixed(2)+"%</td>";
                    //result="<td>"+altasMes+"</td><td>"+bajasMes+"</td><td>"+numElementosGif+"</td><td>"+elementosVentas+"</td>";
     
                    
                }else{
                	result="<td>0</td>";
                	
                }
                //waitingDialog.hide();  
            },
            error: function (response)
            {
                console.log (response);
            }
        });
		return result;
	}

	function createOptionMonth(){
		 var optionMesEntidad="<option>MES:</option>";
		 for(var i=0; i<meses.length; i++ ){

		 	var numberMonth=meses[i]["numberMonth"];
		 	var nameMonth=meses[i]["nameMonth"];

		 	optionMesEntidad+="<option value='"+numberMonth+"'>"+nameMonth+"</option>";

		 }
		 $("#selectMesRotacion").html(optionMesEntidad);
	}

	 function getListaEntidades()
  {

  	  waitingDialog.show();
      $("#tableEntidadRotacion").find("tr:gt(0)").remove();
      $.ajax({
            
            type: "POST",
            url: "ajax_getEntidadesFederativas.php",
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                     
                    var listaEntidades = response.listaEntidades;
                    var totalAltas=0;
              
                      
                    filasTable="";

                    for ( var i = 0; i < listaEntidades.length; i++ ){
                    	var idEntidad = listaEntidades[i].idEntidadFederativa;
                        var nombreEntidad = listaEntidades[i].nombreEntidadFederativa;
                        if(nombreEntidad!="EXTRANJERO"){

                        	filasTable+="<tr><td>"+nombreEntidad.toUpperCase()+"</td>"+generarIndicadorEntidad(idEntidad)+"</tr>"	
                        }
                    }

                  
                  $('#tableEntidadRotacion').append(filasTable);     
                   
                   
                 }
            },           

            error: function (response)
            {
                console.log (response);

            }
        });
waitingDialog.hide();  
  }


	

</script>