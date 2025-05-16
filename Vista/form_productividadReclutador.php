<meta charset="UTF-8">
<div class="containerTabledatos">
    <center>    
            <strong>Mes:</strong><select name="selectMesProductividadReclutador" id="selectMesProductividadReclutador" onchange="styleTableProductividadReclutadores();">
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
            <strong>Tipo Busqueda:</strong><select name="slectProductividadTipoR" id="slectProductividadTipoR" >
                <option value="1">RECLUTADORES</option>
                <option value="2">SUPERVISORES</option>
            </select><img src="img/refresh-icon.png" onclick="styleTableProductividadReclutadores();">
    </center>
   
    <br>
    <br>
    
    <legend>Reclutadores</legend>
			
	 <section>

            <table id="tableProductividadReclutadores" class="display nowrap" cellspacing="0" width="80%">
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

var f=new Date();
var mes=f.getMonth()+1;
var anio=f.getFullYear();

$(document).ready(function() {
	
	
	 $("#selectMesProductividadReclutador > option[value='"+mes+"'").attr('selected', 'selected');
	
	styleTableProductividadReclutadores();
    //indicadorGeneralDelMes();

} );



var tableReclutadores1 = null;
function styleTableProductividadReclutadores(){
  //alert("HOLA");
  var month=$("#selectMesProductividadReclutador").val();
  var tipo=$("#slectProductividadTipoR").val();

  if (tableReclutadores1 != null)
        {
            tableReclutadores1.destroy ();
            
        }

        tableReclutadores1 = $('#tableProductividadReclutadores').DataTable( {
        ajax: {
            url: 'ajax_consultaProductividadReclutadores.php'
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





</script>