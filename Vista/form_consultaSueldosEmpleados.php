	<style>
		.editableSueldo span{display:block;}
		.editableSueldo span:hover {background:url(img/edit.png) 90% 50% no-repeat;cursor:pointer}
		td input{height:24px;width:200px;border:1px solid #ddd;padding:0 5px;margin:0;border-radius:6px;vertical-align:middle}
		a.enlaceSueldo{display:inline-block;width:24px;height:24px;margin:0 0 0 5px;overflow:hidden;text-indent:-999em;vertical-align:middle}
		.guardarSueldo{background:url(img/save.png) 0 0 no-repeat}
		.cancelarSueldo{background:url(img/cancel.png) 0 0 no-repeat}
	
		.mensajeSueldo{display:block;text-align:center;margin:0 0 20px 0}
		.okSueldo{display:block;padding:10px;text-align:center;background:green;color:#fff}
		.koSueldo{display:block;padding:10px;text-align:center;background:red;color:#fff}
	</style>
<div class="containertableSueldo"  align="left" STYLE="background-color:white">
 <center>

 <button type="button" class="btn btn-success" onclick="obtenerLista('sinSueldo');">Elementos sin sueldo</button>
 <button type="button" class="btn btn-warning" onclick="obtenerLista('conSueldo');">Elementos con sueldo</button>
 <img src="img/refresh-icon.png" class="cursorImg" onclick='getSueldosEmpleados();obtenerLista(cargarLista);'>
 
 </center> 
</div>

<div class="modal hide fade" id="modalEdicionSueldo" name="modalEdicionSueldo"> 
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div id="divMsgErrorSueldoN" name="divMsgErrorSueldoN"></div>
        <h5 class="modal-title">Edición de sueldo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body-edita-sueldo">
        <div class="input-prepend">
          <span class="add-on">NÚMERO EMPLEADO</span>
          <input id="txtNumeroEmpleadoES" name="txtNumeroEmpleadoES" type="text" class="input-medium" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">NOMBRE EMPLEADO</span>
          <input id="txtNombreEmpleadoES" name="txtNombreEmpleadoES" type="text" class="input-xlarge" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">FECHA INGRESO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
          <input id="txtFechaIngresoES" name="txtFechaIngresoES" type="date" class="input-medium" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">PUESTO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
          <input id="txtPuestoEmpleadoES" name="txtPuestoEmpleadoES" type="text" class="input-medium" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">ROL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
          <input id="txtRolEmpleadoES" name="txtRolEmpleadoES" type="text" class="input-medium" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">PUNTO SERVICIO &nbsp;&nbsp;&nbsp;</span>
          <input id="txtPuntoServicioEmpleadoES" name="txtPuntoServicioEmpleadoES" type="text" class="input-xlarge" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">ENTIDAD &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
          <input id="txtEntidadEmpleadoES" name="txtEntidadEmpleadoES" type="text" class="input-medium" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">SUELDO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
          <input id="txtSueldoEmpleadoES" name="txtSueldoEmpleadoES" onblur="calcularCuota();" type="text" class="input-medium" >

          <input id="hdnsueldoanteriorN" name="hdnsueldoanteriorN" type="hidden" readonly >

        </div>
        <div class="input-prepend">
          <span class="add-on">BONO ASISTENCIA&nbsp;&nbsp;</span>
          <input id="txtBonoAsistenciaEmpleadoES" name="txtBonoAsistenciaEmpleadoES" onblur="calcularCuota();" type="text" class="input-medium" >
        </div>
        <div class="input-prepend">
          <span class="add-on">BONO PUNTUALIDAD</span>
          <input id="txtbonoPuntualidadEmpleadoES" name="txtbonoPuntualidadEmpleadoES" onblur="calcularCuota();"  type="text" class="input-medium" >
        </div>
        <div class="input-prepend">
          <span class="add-on">CUOTA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
          <input id="txtCuotaEmpleadoES" name="txtCuotaEmpleadoES" type="text" onblur="calcularCuota();" class="input-medium" readonly>

          <input id="hdncuotaanteriorN" name="hdncuotaanteriorN" type="hidden" readonly >

          <input id="hdnlineanegocio" name="hdnlineanegocio" type="hidden"  readonly>
        </div>
      </div> <!-- fin modal body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="insertEdita();">Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

 	<table id="tableSueldo" name="tableSueldo" class="display editinplace" cellspacing="0" width="90%">
                <thead>
                    <tr>
                        <th>#Empleado</th>
                        <th>Nombre</th>
                        <th>Fecha Ingreso</th>
                        <th>Estatus empleado</th>
                        <th>Puesto</th>
                        <th>Turno</th>
                        <th>Punto Servicio</th>
                        <th>Entidad Federativa</th>
                        <th>Sueldo</th>                        
                        <th>Cuota Diaria</th> 
                        <th>Bono Asistencia</th>
                        <th>Bono Puntualidad</th>          
                        <th>Editar</th>      
                     </tr>
                </thead>
                 <tfoot>
                    <tr>
                        <th>#Empleado</th>
                        <th>Nombre</th>
                        <th>Fecha Ingreso</th>
                        <th>Estatus empleado</th>
                        <th>Puesto</th>
                        <th>Turno</th>
                        <th>Punto Servicio</th>
                        <th>Entidad Federativa</th>
                        <th>Sueldo</th>                        
                        <th>Cuota Diaria</th> 
                        <th>Bono Asistencia</th>
                        <th>Bono Puntualidad</th>
                        <th>Editar</th>      
                    </tr>
                </tfoot>

                <tbody></tbody>

    </table>
    <script type="text/javascript">
	var tableSueldo = null;	

    var dataTableElementosSueldo = [];
    var dataTableElementosSinSueldo = [];


    var cargarLista="conSueldo";

    function obtenerLista(dato){
        
            //alert(dato);
            if (dato=="sinSueldo"){

                showEmpleadosSinSueldo();
                cargarLista="sinSueldo";

            }else{
                cargarLista="conSueldo";
                showEmpleadosConSueldo();

            }
    }

    	function getSueldosEmpleados(){

        $.ajax ({
            type: "POST"
            ,url: "ajax_getSueldosEmpleados.php"
            ,dataType: "json"
            ,async: false
            ,success: function (response)
            {

                dataTableElementosSueldo = [];
                dataTableElementosSinSueldo = [];

                if (response.status == "success")
                {
                    for (var i = 0; i < response.data.length; i++)
                    {
                        var record = response.data [i];

                        if (record.sueldoEmpleado == 0 )
                        {
                            dataTableElementosSinSueldo.push (record);
                        }else {
                            dataTableElementosSueldo.push( record);
                        }
                        
                    }

                    //loadDataInTableSueldos (dataTableElementosSinSueldo);
                }
            }
            ,error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
      }
        });
    }

     function loadDataInTableSueldos (data)
    {
        if (tableSueldo != null)
        {
            tableSueldo.destroy ();
            tableSueldo = null;
        }

        if (data.length == 0)
        {
            alert ("No hay datos para cargar");
        }

        tableSueldo = $('#tableSueldo').DataTable( {
        data: data,
        destroy: true,
        "columns": [
            { "data": "numeroEmpleado"}
            ,{ "data": "nombreEmpleado" }
            ,{ "data": "fechaIngresoEmpleado" }
            ,{ "data": "descripcionEstatusEmpleado" }
            ,{ "data": "descripcionPuesto" }
            ,{ "data": "descripcionTurno" }
            ,{ "data": "puntoServicio" }
            ,{ "data": "nombreEntidadFederativa" }
            ,{ "data": "sueldoEmpleado" }
            ,{ "data": "cuotaDiaria" }
            ,{ "data": "bonoAsistencia" }
            ,{ "data": "bonoPuntualidad" }
            ,{ "data": "edicion" }
                        
            //,{ "data": "ElementosEnPuntoServicio" }
            //,{ "data": "diferencia" }
       ]
        //,serverSide: true
        ,processing: true
        ,dom: 'Bfrtip'
        ,buttons: [
            'copy', 'excel'
        ]

    } );

}

function showEmpleadosConSueldo ()
    {
        loadDataInTableSueldos (dataTableElementosSueldo);
    }


    function showEmpleadosSinSueldo ()
    {
        loadDataInTableSueldos (dataTableElementosSinSueldo);
    }

    function showModalEdicionSueldo(numeroEmpleado, nombreEmpleado, fechaIngreso, descripcionPuesto, descripcionTurno, puntoServicio, nombreEntidadFederativa,sueldoEmpleado, bonoAsistencia, bonoPuntualidad, cuotaDiaria,lineaNegocio){

    	$("#modalEdicionSueldo").modal();
        $("#txtNumeroEmpleadoES").val(numeroEmpleado);
        $("#txtNombreEmpleadoES").val(nombreEmpleado);
        $("#txtFechaIngresoES").val(fechaIngreso);
        $("#txtPuestoEmpleadoES").val(descripcionPuesto);
        $("#txtRolEmpleadoES").val(descripcionTurno);
        $("#txtPuntoServicioEmpleadoES").val(puntoServicio);
        $("#txtEntidadEmpleadoES").val(nombreEntidadFederativa);
        $("#txtSueldoEmpleadoES").val(sueldoEmpleado);
        $("#txtBonoAsistenciaEmpleadoES").val(bonoAsistencia);
        $("#txtbonoPuntualidadEmpleadoES").val(bonoPuntualidad);
        $("#txtCuotaEmpleadoES").val(cuotaDiaria);
        $("#hdnlineanegocio").val(lineaNegocio);  
        $("#hdnsueldoanteriorN").val(sueldoEmpleado);  
        $("#hdncuotaanteriorN").val(cuotaDiaria);     

        if(lineaNegocio==2){
            $("#txtBonoAsistenciaEmpleadoES").val(0).prop("readonly",true);
            $("#txtbonoPuntualidadEmpleadoES").val(0).prop("readonly",true);
        }else{
             $("#txtBonoAsistenciaEmpleadoES").prop("readonly",false);
            $("#txtbonoPuntualidadEmpleadoES").prop("readonly",false);
        }
    }

    function updateSueldo(){

        var numeroEmpleado=$("#txtNumeroEmpleadoES").val();
        var sueldoEmpleado=$("#txtSueldoEmpleadoES").val();
        var bonoAsistencia=$("#txtBonoAsistenciaEmpleadoES").val();
        var bonoPuntualidad=$("#txtbonoPuntualidadEmpleadoES").val();

        var cuotaDiariaEmpleado=$("#txtCuotaEmpleadoES").val();


            $.ajax({
            type: "POST",
            url: "ajax_updateSueldo.php",
            data: {numeroEmpleado:numeroEmpleado,sueldoEmpleado:sueldoEmpleado, bonoAsistencia:bonoAsistencia, bonoPuntualidad:bonoPuntualidad, cuotaDiariaEmpleado:cuotaDiariaEmpleado },
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {
            
                    $('#modalEdicionSueldo').modal('hide');

                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Actualización de sueldo: </strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsg").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');

                    getSueldosEmpleados();

                    if (cargarLista=="conSueldo"){
                        showEmpleadosConSueldo();

                    }else{
                        showEmpleadosSinSueldo();
                    }

                } else if (response.status=="error")
                {
                    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en actualización de sueldo:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#divMsgErrorSueldoN").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                }
              },
            error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
      }
        });
      

    }

    function insertSueldoEmpleado(){

        var numeroEmpleado=$("#txtNumeroEmpleadoES").val();
        var sueldoEmpleado=$("#txtSueldoEmpleadoES").val();
        var bonoAsistencia=$("#txtBonoAsistenciaEmpleadoES").val();
        var bonoPuntualidad=$("#txtbonoPuntualidadEmpleadoES").val();
        var cuotaDiariaEmpleado=$("#txtCuotaEmpleadoES").val();

                 
        $.ajax({
            type: "POST",
            url: "ajax_registroSueldoEmpleado.php",
            data: {numeroEmpleado:numeroEmpleado,sueldoEmpleado:sueldoEmpleado, bonoAsistencia:bonoAsistencia, bonoPuntualidad:bonoPuntualidad, cuotaDiariaEmpleado:cuotaDiariaEmpleado },
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {
                  
                    $('#modalEdicionSueldo').modal('hide');

                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Actualización de sueldo: </strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsg").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');

                    getSueldosEmpleados();

                    if (cargarLista=="conSueldo"){
                        showEmpleadosConSueldo();

                    }else{
                        showEmpleadosSinSueldo();
                    }
                              
                } else if (response.status=="error")
                {
                    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en actualización de sueldo:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#divMsgErrorSueldoN").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    //mostrarModalMediosComunicacion();
                }
              },
            error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
      }
        });  
    }

    function calcularCuota(){

        var numeroEmpleado=$("#txtNumeroEmpleadoES").val();
        var sueldoEmpleado=$("#txtSueldoEmpleadoES").val();
        var bonoAsistencia=$("#txtBonoAsistenciaEmpleadoES").val();
        var bonoPuntualidad=$("#txtbonoPuntualidadEmpleadoES").val();
        var cuotaDiariaEmpleado=(sueldoEmpleado-((bonoAsistencia*2)+(bonoPuntualidad*2) ))/30;

        $("#txtCuotaEmpleadoES").val(cuotaDiariaEmpleado);

    } 

    function insertEdita(){
        var lineanegocio=  $("#hdnlineanegocio").val(); 
        var sueldoEmpleado=$("#txtSueldoEmpleadoES").val();
    if(lineanegocio==2){
        if(sueldoEmpleado!=0 && sueldoEmpleado!=""){
            InsertHistoricoSuelods();
        }else{
            alert("Ingrese sueldo ");
        }
    }else{
        if (cargarLista=="sinSueldo"){
                insertSueldoEmpleado();
            }else{
                 updateSueldo();
        }
    }
}


function InsertHistoricoSuelods(){
var numempleadoN=$("#txtNumeroEmpleadoES").val();
var sueldoEmpleadoN=$("#txtSueldoEmpleadoES").val();
var cuotadiariaN=$("#txtCuotaEmpleadoES").val();

var sueldoanteriorN=$("#hdnsueldoanteriorN").val();
var cuotaanteriorN=$("#hdncuotaanteriorN").val();
$.ajax({
            type: "POST",
            url: "ajax_registrohistoricosueldoadmin.php",
            data: {numeroEmpleado:numempleadoN,sueldoEmpleado:sueldoEmpleadoN,  cuotaDiariaEmpleado:cuotadiariaN ,sueldoAnterior:sueldoanteriorN,cuotaAnterior:cuotaanteriorN},
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;
                $("#modalEdicionSueldo").modal('hide');

                if (response.message=="EXISTE UNA PETICION DE SUELDO ANTERIOR") {
                    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Actualización de sueldo: </strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#alertMsg").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    $(document).scrollTop(0);
                    getSueldosEmpleados();
                } else if (response.message=="PETICION ENVIADA"){ 
                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Actualización de sueldo: </strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#alertMsg").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    $(document).scrollTop(0);
                    getSueldosEmpleados();
                }  else if (response.status=="error")
                {
                    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en actualización de sueldo:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#divMsgErrorSueldoN").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    //mostrarModalMediosComunicacion();
                }
              },
           error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText); 
            }
        });

    }

$(inicioConsultaSueldosEmp());  

function inicioConsultaSueldosEmp(){
    <?php if ($usuario ["rol"] == "Nomina") : ?>
        getSueldosEmpleados();
        obtenerLista('sinSueldo');
    <?php endif; ?>
}
</script>