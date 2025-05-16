<div class="containerTableImss">
    <center>    
            <strong>Mes:</strong><select name="selectMesReclutador" id="selectMesReclutador" onchange="styleTableReclutadores(); indicadorGeneralDelMes();">
            <option value="1">ENERO</option>
            <option value="2">FEBRERO</option>
            <option value="3">MARZO</option>
            <option value="4">ABRIL</option>
            <option value="5">MAYO</option>
            <option value="6">JUNIO</option>
            <option value="7">JULIO</option>
            <option value="8">AGOSTO</option>
            <option value="9">SEPTIEMBRE</option>
            <option value="10">OCTUBRE</option>
            <option value="11">NOVIEMBRE</option>
            <option value="12">DICIEMBRE</option>
            </select>
            <br>
            <strong>Tipo Busqueda:</strong><select name="slectTipoR" id="slectTipoR" >
                <option value="1">RECLUTADORES</option>
                <option value="2">SUPERVISORES</option>
            </select><img src="img/refresh-icon.png" onclick="styleTableReclutadores();">
    </center>
    <legend>Índice de rotación general</legend>
    <section>
    <center>
    <!-- <table border=1 cellspacing=0 cellpadding=2 bordercolor="666633"> -->
    <table>
        <tr>
            <td>
                <label class="control-label label " for="lblPlantillaGif">Altas del Mes &nbsp &nbsp</label>
                <input id="txtAltasMes" name="txtAltasMes" type="text" class="input-small" readonly>
                
            </td>
                        
        </tr>
        <tr>
            <td>
                <label class="control-label label " for="lblPlantillaGif">Bajas del Mes &nbsp</label>
                <input id="txtBajasMes" name="txtBajasMes" type="text" class="input-small" readonly>
            </td>
        </tr>
        <tr>
            <td>
                <label class="control-label label " for="lblPlantillaGif">Plantilla Gif &nbsp &nbsp &nbsp</label>
                <input id="txtPlantillaGif" name="txtPlantillaGif" type="text" class="input-small" readonly>
            </td>
            <td >
                
                <label class="control-label label " for="lblPlantillaGif">Índice de rotación &nbsp &nbsp &nbsp</label>
                <input id="txtIndiceRotacion" name="txtIndiceRotacion" type="text" class="input-small" readonly>
            </td>

        </tr>
        <tr>
            <td>
                <label class="control-label label " for="lblPlantillaVentas">Plantilla Ventas</label>
                <input id="txtPlantillaVentas" name="txtPlantillaVentas" type="text" class="input-small" readonly>
            </td>
            <td>
                
                
                <label class="control-label label " for="lblPlantillaGif">Índice de cobertura &nbsp &nbsp</label>
                <input id="txtIndiceCobertura" name="txtIndiceCobertura" type="text" class="input-small" readonly>
            </td>
        </tr>
        
        
    </table>
    </center>
    </section>
    <br>
    <br>
    
    <legend>Reclutadores</legend>
			
	 <section>

            <table id="tableReclutadores" class="display nowrap" cellspacing="0" width="80%">
                <thead>
                    <tr>
                        <th># Empleado</th>
                    	<th>Nombre</th>
                    	<th>Fecha Ingreso</th>
                        <th>Elementos Reclutados</th>
                        <th>Elementos activos</th>
                        <th>Elementos inactivos</th>
                        <th>Índice rotación</th>
                        <th>Índice productividad</th>
                    </tr>
                </thead>

                <tbody></tbody>

                <tfoot>
                    <tr>
                        <th># Empleado</th>
                    	<th>Nombre</th>
                    	<th>Fecha Ingreso</th>
                        <th>Elementos Reclutados</th>
                        <th>Elementos activos</th>
                        <th>Elementos inactivos</th>
                        <th>Índice rotación</th>
                        <th>Índice productividad</th>
                    	
                    </tr>
                </tfoot>

            </table>
                     
        </section>
</div>
<script type="text/javascript">
var tableReclutadores1 = null;
var f=new Date();
var mes=f.getMonth()+1;
var anio=f.getFullYear();

$(inicioReporteReclutador());  

function inicioReporteReclutador(){
    $("#selectMesReclutador > option[value='"+mes+"'").attr('selected', 'selected');
	styleTableReclutadores();
    indicadorGeneralDelMes();
}

function styleTableReclutadores(){
  //alert("HOLA");
  var month=$("#selectMesReclutador").val();
  var tipo=$("#slectTipoR").val();

  if (tableReclutadores1 != null)
        {
            tableReclutadores1.destroy ();
            
        }

        tableReclutadores1 = $('#tableReclutadores').DataTable( {
        ajax: {
            url: 'ajax_ConsultaReclutadores.php'
            ,type: 'POST'
            ,data : {"month":month,"tipo":tipo}
        }
        ,"columns": [
            { "data": "numeroEmpleado"}
            ,{ "data": "nombreEmpleado"}
            ,{ "data": "fechaIngresoEmpleado"}
            
            ,{ "data": "numeroElementosReclutados"}
            
            ,{ "data": "numeroElementosActivos"}
            ,{ "data": "numeroElementosInactivos"}
            ,{ "data": "indiceRotacion"}
            ,{ "data": "indiceProductividad"}
            
           

       ]
        //,serverSide: true
        ,processing: true
        ,"bPaginate": false
        ,dom: 'Bfrtip'
        ,buttons: ['excel']
        

    } );

}

function indicadorGeneralDelMes()

    {
        var month=$("#selectMesReclutador").val();
      
      $.ajax({
            type: "POST",
            url: "ajax_getAltasByMonth.php",
            data: {month:month, anio:anio},
            dataType: "json",
            async: false,
            success: function(response) {
                if (response.status == "success")
                {
                    var altasMes = response.altasMes.altasMes;
                    var bajasMes = response.bajasMes.bajasMes;
                    var numElementosGif=response.numElementosGif.numElementosGif;
                    var elementosVentas=response.elementosVentas.elementosVentas;

                    $("#txtAltasMes").val(altasMes);
                    $("#txtBajasMes").val(bajasMes);
                    $("#txtPlantillaGif").val(numElementosGif);
                    $("#txtPlantillaVentas").val(elementosVentas);
                    $("#txtPlantillaVentas").val(elementosVentas);
                    var indiceRotacion=((altasMes-bajasMes)/numElementosGif)*100;
                    var indiceCobertura=((altasMes-bajasMes)/elementosVentas)*100;
                    
                    
                    $("#txtIndiceRotacion").val(indiceRotacion.toFixed(2)+"%");
                    $("#txtIndiceCobertura").val(indiceCobertura.toFixed(2)+"%");

                    
                }
            },
            error: function (response)
            {
                console.log (response);
            }
        });
           
    }



</script>