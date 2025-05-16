<div class="container" align="center">
  <form name="form_actualizacionSueldos" id="form_actualizacionSueldos">
	 <span class="label">Punto de servicio</span>
    <input type="hidden" name="txtFecha1ConsultaPuntosServicios" id="txtFecha1ConsultaPuntosServicios">
    <input type="hidden" name="txtFecha2ConsultaPuntosServicios" id="txtFecha2ConsultaPuntosServicios">
    <select id="selectPuntoServicioTabulador" name="selectPuntoServicioTabulador" class="input-large " onchange="consutaEmpleadosByPuntoIdTabulador();mostrarElementosSolicitados();" >
    </select>
    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
    <div id="divRequisicionesSueldo" name='divRequisicionesSueldo'> </div>

    <div id="listaEmpleadoSueldo" ></div>

  <div class="modal fade" id="modalMsgSueldos" name="modalMsgSueldos">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Actualización de sueldos</div></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p><div id="msgActualizacionSueldo" name="msgActualizacionSueldo"></div></p>
        </div>
        <div class="modal-footer">
          
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>


  </form>
</div>

<script type="text/javascript">


$(inicioActSPS());  

function inicioActSPS(){
  var date = new Date();
  var primerDia1 = new Date(date.getFullYear(), date.getMonth(), 1);
  var ultimoDia1 = new Date(date.getFullYear(), date.getMonth() + 1, 0);
  
  var primerDia = new Date(primerDia1).toISOString().slice(0,10);
  var ultimoDia = new Date(ultimoDia1).toISOString().slice(0,10);

  $("#txtFecha1ConsultaPuntosServicios").val(primerDia);
  $("#txtFecha2ConsultaPuntosServicios").val(ultimoDia);
  getPuntosServiciosSueldos();
}

function getPuntosServiciosSueldos()
    {

      var fecha1=$("#txtFecha1ConsultaPuntosServicios").val();
      var fecha2=$("#txtFecha2ConsultaPuntosServicios").val();    

       $.ajax({
            type: "POST",
            url: "ajax_getPuntosForFatigaByAnalista.php",
            data: {"fecha1":fecha1, "fecha2":fecha2},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    var puntos = response.puntos;

                    var puntosOptions = "<option>PUNTOS DE SERVICIOS</option>";
                                        
                    for (var i = 0; i < puntos.length; i++)
                    {

                      puntosOptions += "<option "+puntos[i].idPuntoServicio+" value='" + puntos[i].idPuntoServicio + "' >" + puntos[i].puntoServicio + "</option>";
                        
                    }

                     <?php
                    if($usuario["rol"] =="Nomina" ):
                    ?>

                    $("#selectPuntoServicioTabulador").html(puntosOptions);
                    
                    <?php
                    endif;
                    ?>

                  
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
        
                }
        });
    }

  function mostrarElementosSolicitados(){
  
  var puntoServicioId=$("#selectPuntoServicioTabulador").val();
  var formatter = new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: 'USD',
          minimumFractionDigits: 2,
        });


       $.ajax({
            
            type: "POST",
            url: "ajax_getDetalleRequisicionesByPuntoServicioId.php",
            data: {"puntoServicioId": puntoServicioId},
            dataType: "json",
            
            success: function(response) {
                if (response.status == "success")
                {
                     
                    var lista = response.lista;
                                    
                    listaTable="<table class='table tablaRH table-hover table-bordered'><thead><th>#Elementos</th><th>Puesto</th><th>Turno</th><th>Sexo</th><th>Fecha Inicio</th>";
                    listaTable+="<th>Sueldo</th><th>Cuota</th><th>Bono asistencia</th><th>Bono puntualidad</th></thead><tbody>";

                    for ( var i = 0; i < lista.length; i++ ){
                        
                        var numeroElementos = lista[i].numeroElementos;
                        var descripcionPuesto = lista[i].descripcionPuesto;
                        var descripcionTurno = lista[i].descripcionTurno;
                        var descripcionGenero = lista[i].descripcionGenero;
                        var fechaInicio=lista[i].fechaInicio;
                        var cuotaDiaria=lista[i].cuotaDiaria;
                        var sueldo=0;
                        //var sueldo=lista[i].cuotaDiaria;
                       
                        if (cuotaDiaria==""){
                            cuotaDiaria=0;

                        }else{
                            cuotaDiaria=lista[i].cuotaDiaria.cuotaDiaria;
                            sueldo=lista[i].cuotaDiaria.sueldo; 
                        }
                                                                 
                  listaTable += "<tr><td>"+numeroElementos+" </td><td>"+descripcionPuesto+" </td><td>"+descripcionTurno+"</td><td>"+descripcionGenero+"</td><td>"+ fechaInicio+"</td>";
                  listaTable += "<td>"+formatter.format(sueldo)+"</td><td>"+ formatter.format(cuotaDiaria)+"</td><td>$0</td><td>$0</td>";
                  listaTable +="</tr>";
 
                }
                     
                  listaTable += "</tbody></table>";
                  $('#divRequisicionesSueldo').html(listaTable);     
                   
                   
                 }
            },           

            error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
        
                }
        });
    }


    function consutaEmpleadosByPuntoIdTabulador()
  {
    var puntoServicioId = $("#selectPuntoServicioTabulador").val();
    

      $.ajax({
            
            type: "POST",
            url: "ajax_getEmpleadosByPuntoServicioId.php",
            data: {"puntoServicioId":puntoServicioId},
            dataType: "json",
             success: function(response) {
                if (response.status == "success")
                {
                  
                    var empleado = response.lista;
                    var formatter = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'USD',
                        minimumFractionDigits: 2,
                      });

                    
                    listaPersonalActivoTable="<form id='checkEmpleadosFormSueldo'>";
                    listaPersonalActivoTable+="<table class='table table-hover' id='Exportar_a_Excel'><thead><th># Empleado</th><th>Nombre</th><th>Puesto</th><th>Rol</th><th>Sueldo</th><th>Cuota Diaria</th><th>Bono asistencia</th><th>Bono puntualidad</th><th>Actualizar</th></thead><tbody>";

                    if (empleado.length > 0)
                    {
                        listaPersonalActivoTable+="<br/>";
                        listaPersonalActivoTable+="<a href='javascript:seleccionar_todo_sueldos()'>Marcar todos</a>";
                        listaPersonalActivoTable+="<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
                        listaPersonalActivoTable+="<a href='javascript:deseleccionar_todo_sueldos()'>Marcar ninguno</a>";
                        listaPersonalActivoTable+="<br/>";
                        
                    }
                    
                    for ( var i = 0; i < empleado.length; i++ ){
                      var numeroEmpleado = empleado[i].numeroEmpleado;
                      var nombreEmpleado = empleado[i].nombreEmpleado;
                      var puesto= empleado[i].descripcionPuesto;
                      var empleadoIdPuesto=empleado[i].empleadoIdPuesto;
                      var sueldoEmpleado=empleado[i].sueldoEmpleado;
                      var cuotaDiariaEmpleado=empleado[i].cuotaDiariaEmpleado;
                      var bonoAsistenciaEmpleado=empleado[i].bonoAsistenciaEmpleado;
                      var bonoPuntualidadEmpleado=empleado[i].bonoPuntualidadEmpleado;
                      var descripcionTurno=empleado[i].descripcionTurno;
                                                                 
                      listaPersonalActivoTable += "<tr></td><td>"+numeroEmpleado+"</td><td>"+nombreEmpleado+"</td><td>"+puesto+"</td><td>"+descripcionTurno+"</td>";
                      listaPersonalActivoTable+="<td>"+formatter.format(sueldoEmpleado)+"</td><td>"+formatter.format(cuotaDiariaEmpleado)+"</td><td>"+formatter.format(bonoAsistenciaEmpleado)+"</td>";
                      listaPersonalActivoTable+="<td>"+formatter.format(bonoPuntualidadEmpleado)+"</td>";
                      listaPersonalActivoTable+="<td><input type='checkbox' id="+numeroEmpleado+"  name="+numeroEmpleado+" value='"+numeroEmpleado+"' empleadoIdPuesto='"+empleadoIdPuesto+"'></td><tr>";
                    }

                    listaPersonalActivoTable += "</tbody></table>";
                    listaPersonalActivoTable+="<button type='button' class='btn btn-secondary' onclick='actualizarSueldosTabular();'><span class='glyphicon glyphicon-refresh'></span>Actualizar sueldos </button></form>";
                    $('#listaEmpleadoSueldo').html(listaPersonalActivoTable); 
                  
                }
                else if (response.status == "error" && response.message == "No autorizado")
                {
                    window.location = "login.php";
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
        
                }
        });
  
}
function seleccionar_todo_sueldos(){ 
   for (i=0;i<document.form_actualizacionSueldos.elements.length;i++) 
      if(document.form_actualizacionSueldos.elements[i].type == "checkbox")  
         document.form_actualizacionSueldos.elements[i].checked=1 
} 

function deseleccionar_todo_sueldos(){ 
   for (i=0;i<document.form_actualizacionSueldos.elements.length;i++) 
      if(document.form_actualizacionSueldos.elements[i].type == "checkbox")  
         document.form_actualizacionSueldos.elements[i].checked=0 
}


    function actualizarSueldosTabular()
    {
      var entidadCredenciales=$("#idEndidadFederativaCredencial").val();
      
      var empleadosSeleccionados = $( "input[type=checkbox]:checked");

      
      var empleadosConfirmadosParaActualizar = [];
      
        for (var i = 0; i < empleadosSeleccionados.length; i++)
        {
            if (empleadosSeleccionados[i].checked == true && empleadosSeleccionados[i].value.match (/[0-9]{2}\-[0-9]{4,5}\-[0-9]{2}/g))
            {
                empleadosConfirmadosParaActualizar.push (empleadosSeleccionados[i].value);

            }
        }
       
        if (empleadosConfirmadosParaActualizar.length > 0)
        {

          //waitingDialog.show();
          
          $.ajax({
                type: "POST",
                url: "ajax_actualizarSueldoPorPuntoServicio.php",
                data: {empleadosConfirmadosParaActualizar:empleadosConfirmadosParaActualizar},
                dataType: "json",
                success: function(response) {
                    var mensaje=response.message;

                    if (response.status=="success") {
                      consutaEmpleadosByPuntoIdTabulador();

                      $("#msgActualizacionSueldo").html("<img src='img/ok.png'><strong>"+mensaje+"</strong>");
                                          
                    } else if (response.status=="error")
                    {
 
                      $("#msgActualizacionSueldo").html("<img src='img/rechazarImss.png'><strong>"+mensaje+"</strong>");
                     
                    }
                    
                    $("#modalMsgSueldos").modal();
                  },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
        
                }
            });
               } else
                {
                    alert ("Seleccione los empleados para los que quiere actualizar.");
                }
    }
	//form_actualizacionSueldoByPuntoServicio.php
</script>
