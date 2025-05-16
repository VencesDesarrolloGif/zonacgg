function TraerElementosActivosParaActuSueldos(){ 
  waitingDialog.show();
  $.ajax({
    type: "POST",
    url: "ActualizarSueldosGeneralAnual/ajax_getElementosActivosParaActuSueldos.php",
    dataType: "json",
    Async:false,
    success: function(response) {
      if (response.status == "success")
      {
        var sueldos = response.datos;
        $('#divsueldos').html(""); 
        var listasueldosTable="<form id='checkEmpleadossueldos'>";
        listasueldosTable+="<table class='table table-bordered' id='Exportar_a_Excel'><thead><th># Empleado</th><th>Nombre</th><th>Fecha Ingreso</th><th>Linea Negocio</th><th>Registro Patronal</th>";
         listasueldosTable+="<th>Entidad</th><th>Sueldo Diario</th><th>Aplicar</th></thead><tbody>";
        if (sueldos.length > 0)
        {
          listasueldosTable+="<br/>";
          listasueldosTable+="<a href='javascript:seleccionar_Sueldos()'>Marcar todos</a>";
          listasueldosTable+="<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
          listasueldosTable+="<a href='javascript:deseleccionar_Sueldos()'>Marcar ninguno</a>";
          listasueldosTable+="<br/>";
          for ( var i = 0; i < sueldos.length; i++ )
          {
            var entidadFederativaId = sueldos[i].entidadFederativaId;
            var empleadoConsecutivoId = sueldos[i].empleadoConsecutivoId;
            var empleadoCategoriaId= sueldos[i].empleadoCategoriaId;
            var NumeroEmpleado=sueldos[i].NumeroEmpleado;
            var NombreEmpelado=sueldos[i].NombreEmpelado;
            var fechaIngresoEmpleado=sueldos[i].fechaIngresoEmpleado;
            var descripcionLineaNegocio=sueldos[i].descripcionLineaNegocio;
            var nombreEntidadFederativa=sueldos[i].nombreEntidadFederativa;
            var descripcionPuesto=sueldos[i].descripcionPuesto;
            var registroPatronal=sueldos[i].registroPatronal;
            var salarioDiario=sueldos[i].salarioDiario;
            var diasTranscurridos=sueldos[i].diasTranscurridos;              
            var fechaImss=sueldos[i].fechaImss;              
            var numeroLote=sueldos[i].numeroLote;              
            listasueldosTable += "<tr><td>"+NumeroEmpleado+"</td><td>"+NombreEmpelado+"</td><td>"+fechaIngresoEmpleado+"</td><td>"+descripcionLineaNegocio+"</td>";
            listasueldosTable += "<td>"+registroPatronal+"</td><td>"+nombreEntidadFederativa+"</td><td>"+salarioDiario+"</td>";
            listasueldosTable += "<td><input type='checkbox' id="+NumeroEmpleado+'_'+i+"  name="+NumeroEmpleado+'_'+i+" value='"+NumeroEmpleado+'_'+i+"'entidadFederativaId='"+entidadFederativaId+"' empleadoConsecutivoId='"+empleadoConsecutivoId+"' empleadoCategoriaId='"+empleadoCategoriaId+"'";
            listasueldosTable += " fechaIngresoEmpleado='"+fechaIngresoEmpleado+"' registroPatronal='"+registroPatronal+"' diasTranscurridos='"+diasTranscurridos+"' numeroLote='"+numeroLote+"' salarioDiario='"+salarioDiario+"' fechaImss='"+fechaImss+"'></td><tr>"; 
          }
          listasueldosTable += "</tbody></table>";
          listasueldosTable+="<button id='btnaplicaSueldos' type='button' class='btn btn-secondary' onclick='aplicarsueldos();'><span class='glyphicon glyphicon-ok'></span>Aplicar sueldos</button></form>";
          $('#divsueldos').html(listasueldosTable); 
          waitingDialog.hide();    
        }else{
          $('#divsueldos').html("<div><h1>No se encontraron sueldos</h1></div>"); 
          waitingDialog.hide();
        }  
      }
      else if (response.status == "error" && response.message == "No autorizado")
      {
        window.location = "login.php";
      }
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText); 
      alert("Error funcion getsueldos")
    }
  });
}


function seleccionar_Sueldos(){ 
 for (i=0;i<document.form_SueldosGral.elements.length;i++) 
    if(document.form_SueldosGral.elements[i].type == "checkbox")  
      document.form_SueldosGral.elements[i].checked=1 
} 
function deseleccionar_Sueldos(){ 
  for (i=0;i<document.form_SueldosGral.elements.length;i++) 
    if(document.form_SueldosGral.elements[i].type == "checkbox")  
      document.form_SueldosGral.elements[i].checked=0 
}

function aplicarsueldos(){
  bandera ="0";
var InpNuevoSueldo=$("#InpNuevoSueldo").val();
if(InpNuevoSueldo==""){
  swal("ATENCIÓN","Escriba el nuevo sueldo que tendran los empleados","warning");
  $(document).scrollTop(0);
}else{
  var sueldosSeleccionados = $( "input[type=checkbox]:checked");
  var sueldosConfirmadosParaAplicar = [];
  var entidadFederativaIdArray=[];
  var empleadoConsecutivoIdArray=[];
  var empleadoCategoriaIdArray=[];
  var fechaIngresoEmpleadoArray=[];
  var registroPatronalArray=[];
  var diasTranscurridosArray=[];    
  var numeroLoteArray=[];    
  var fechaImssArray=[];    
  var salarioDiarioArray=[]; 
  var nuevoSueldoArray=[]; 
  var bandera ="0";   
  for (var i = 0; i < sueldosSeleccionados.length; i++)
    {
      if(sueldosSeleccionados[i].checked == true)
      {
        sueldosConfirmadosParaAplicar.push (sueldosSeleccionados[i].value);
        var entidadFederativaId = $("#"+sueldosSeleccionados[i].value).attr("entidadFederativaId");
        var empleadoConsecutivoId = $("#"+sueldosSeleccionados[i].value).attr("empleadoConsecutivoId");
        var empleadoCategoriaId=$("#"+sueldosSeleccionados[i].value).attr("empleadoCategoriaId");
        var fechaIngresoEmpleado=$("#"+sueldosSeleccionados[i].value).attr("fechaIngresoEmpleado");
        var registroPatronal=$("#"+sueldosSeleccionados[i].value).attr("registroPatronal");
        var diasTranscurridos=$("#"+sueldosSeleccionados[i].value).attr("diasTranscurridos");         
        var numeroLote=$("#"+sueldosSeleccionados[i].value).attr("numeroLote");         
        var fechaImss=$("#"+sueldosSeleccionados[i].value).attr("fechaImss");         
        var salarioDiario=$("#"+sueldosSeleccionados[i].value).attr("salarioDiario");
        if(salarioDiario>InpNuevoSueldo){
          swal("ERROR","El sueldo diario del empleado con numero "+entidadFederativaId+"-"+empleadoConsecutivoId+"-"+empleadoCategoriaId+" es mayor al nuevo sueldo diario que ingreso favor de verificar el sueldo que ha asignar ","error");
          bandera ="1";
          i=sueldosSeleccionados.length;
          $(document).scrollTop(0);
        }else{       
          entidadFederativaIdArray.push(entidadFederativaId);
          empleadoConsecutivoIdArray.push(empleadoConsecutivoId);
          empleadoCategoriaIdArray.push(empleadoCategoriaId);
          fechaIngresoEmpleadoArray.push(fechaIngresoEmpleado);
          registroPatronalArray.push(registroPatronal);
          diasTranscurridosArray.push(diasTranscurridos);
          numeroLoteArray.push(numeroLote);
          fechaImssArray.push(fechaImss);
          salarioDiarioArray.push(salarioDiario);
          nuevoSueldoArray.push(InpNuevoSueldo);
        }
      }
    }
    if(bandera != "1"){
      var data = [];
      for(var i = 0; i < sueldosConfirmadosParaAplicar.length; i++){
        data.push({
          entidadFederativaIdArray: entidadFederativaIdArray[i]
          ,empleadoConsecutivoIdArray: empleadoConsecutivoIdArray[i]
          ,empleadoCategoriaIdArray:empleadoCategoriaIdArray[i]
          ,fechaIngresoEmpleadoArray:fechaIngresoEmpleadoArray[i]
          ,registroPatronalArray:registroPatronalArray[i]
          ,diasTranscurridosArray:diasTranscurridosArray[i]
          ,numeroLoteArray:numeroLoteArray[i]
          ,fechaImssArray:fechaImssArray[i]
          ,nuevoSueldoArray:nuevoSueldoArray[i]
        });
      }
      if (sueldosConfirmadosParaAplicar.length > 0)
      {  
        $("#btnaplicaSueldos").attr("disabled", true);
        $.ajax({
          type: "POST",
          url: "ActualizarSueldosGeneralAnual/ajax_aplicarSueldosGeneral.php",
          data: {data:data},
          dataType: "json",
          success: function(response) {
            var mensaje=response.message;
            if (response.status=="success") {
              swal("LISTO",mensaje,"success");
              TraerElementosActivosParaActuSueldos();
              $("#btnaplicaSueldos").attr("disabled", false);  
              $("#InpNuevoSueldo").val("");                    
            } else if (response.status=="error")
            {
              $("#btnaplicaSueldos").attr("disabled", false);
              swal("ERROR",mensaje,"error");
            } 
          },
          error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText); 
          }
        });
      }else
      {
        swal("ATENCIÓN","Seleccione los empleados para los que quiere actualizar.","warning");
        $("#btnaplicaSueldos").attr("disabled", false);
      }
    }
  }
}