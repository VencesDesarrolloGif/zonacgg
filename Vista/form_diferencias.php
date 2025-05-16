<?php
    require_once ("../Negocio/Negocio.class.php");
    $negocio = new Negocio ();
    //$diasAsistencia = $negocio -> obtenerListaDiasParaAsistencia ("QUINCENAL");
    //$diasAsistencia2="";
 
?>
<!--<div style="margin-left: 25%"><button type="button" class="btn btn-primary" onclick="seleccionPeriodo();">Calcular Diferencias</button></div>-->
<div class="container" align="center" >
	<form class="form-horizontal" id="form_diferencias" name="form_diferencias">
		 <div class="btn-group" >
  			<label class="btn btn-secondary">
    			<input type="radio" name="optionPeriodoDiferencias" id="optionPeriodoDiferenciasQuincenal" value="QUINCENAL" checked onclick="consultaPeticionesAsistenciaMermaParaCalcularDiferencias();"> QUINCENAL
  			</label>
  			<label class="btn btn-secondary ">
    			<input type="radio" name="optionPeriodoDiferencias" id="optionPeriodoDiferenciasSemanal" value="SEMANAL" onclick="consultaPeticionesAsistenciaMermaParaCalcularDiferencias();"> SEMANAL
  			</label>
  		</div>
      <br>
      <div class="input-prepend">
        <span class="add-on">Fecha Inicio Periodo</span>
        <input class="input-small" id="txtFechaInicioPeriodo" name="txtFechaInicioPeriodo" type="text" readonly>
      </div>
      <div class="input-prepend">
        <span class="add-on">Fecha termino Periodo</span>
        <input class="input-small" id="txtFechaTerminoPeriodo" name="txtFechaTerminoPeriodo" type="text" readonly>
      </div>
      <br>
      <div class="input-prepend">
        <span class="add-on">Fecha cierre</span>
        <input class="input-medium" id="txtFechaCierre" name="txtFechaCierre" type="text" readonly>
      </div>
      <br>
      <div class="input-prepend">
        <span class="add-on">Fecha cambio periodo</span>
        <input class="input-medium" id="txtCambioPeriodo" name="txtCambioPeriodo" type="text" readonly>
      </div>
      <br>
      <div id="divDiferencias" ></div>
	</form>
</div>


<script type="text/javascript">


  var tipoPeriodoDiferencias="QUINCENAL";
  var idTipoPeriodo=1;
  var fechaPeriodoInicio="";
  var fechaPeriodoTermino="";
  var diasPeriodo=[];
  var fechaInicioPeriodo="";
  var fechaTerminoPeriodo="";


  
  function consultaPeticionesAsistenciaMermaParaCalcularDiferencias() { 
    seleccionPeriodo(0);
    var fechaInicioPeriodo = $("#txtFechaInicioPeriodo").val();  
    var fechaTerminoPeriodo = $("#txtFechaTerminoPeriodo").val();
    // alert(fechaInicioPeriodo);
    // alert(fechaTerminoPeriodo);
    var caso = "1";
    $.ajax({
        type: "POST",
        url: "ajax_consultaPeticionesAsistenciaMermaParaCerrar.php",
        data: {"fechaInicioPeriodo":fechaInicioPeriodo,"fechaTerminoPeriodo":fechaTerminoPeriodo,"caso":caso},
        dataType: "json", 
        async: false,
        success: function(response) {
            if (response.status == "success") {
                var dato = response.datos;
                if(dato == "0"){
                  seleccionPeriodo(1);
                }else{
                  alert("Tienes Peticiones De Merma Pendientes, Dirigete Al Modulo De 'Peticiones Merma' Para Aceptar/Declinar Y Poder Continuar Con El Cierre De Nomina");
                }
             } else {
                 var mensaje = response.message;
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
 }

  function seleccionPeriodo(AplicarDiferencias) {
    var tipoPeriodoDiferencias = $('input:radio[name=optionPeriodoDiferencias]:checked').val();


    if(tipoPeriodoDiferencias=="QUINCENAL"){
      idTipoPeriodo=1;
      <?php
      date_default_timezone_set('America/Mexico_City');
        $dias= $negocio -> obtenerListaDiasParaCierre ("QUINCENAL");
        //echo $diasAsistencia;
      ?>
      diasPeriodo=[];
      <?php
        foreach ($dias as $dia):
        ?>
        
        <?php echo "diasPeriodo.push ('" . $dia["fecha"] . "');\n" ?>
        <?php
        endforeach;
        ?>

        fechaInicioPeriodo = diasPeriodo [0];
		 fechaTerminoPeriodo = diasPeriodo [diasPeriodo.length - 1];
		 
		  // fechaInicioPeriodo = "2022-04-01";
      //  fechaTerminoPeriodo = "2022-04-15";
		 
       $("#txtFechaInicioPeriodo").val(fechaInicioPeriodo);
       $("#txtFechaTerminoPeriodo").val(fechaTerminoPeriodo);
		

 
       

    }else if(tipoPeriodoDiferencias=="SEMANAL")
    {
      idTipoPeriodo=2;
      <?php

        $dias= $negocio -> obtenerListaDiasParaCierre ("SEMANAL");
        //echo $diasAsistencia;
      ?>
      diasPeriodo=[];


        <?php
        foreach ($dias as $dia):
        ?>
        
        <?php echo "diasPeriodo.push ('" . $dia["fecha"] . "');\n" ?>
        <?php
        endforeach;
        ?>


        fechaInicioPeriodo = diasPeriodo [0];
        fechaTerminoPeriodo = diasPeriodo [diasPeriodo.length - 1];

       // fechaInicioPeriodo = "2022-04-01";
       // fechaTerminoPeriodo = "2022-04-15";
        
        $("#txtFechaInicioPeriodo").val(fechaInicioPeriodo);
        $("#txtFechaTerminoPeriodo").val(fechaTerminoPeriodo);
    }
    if(AplicarDiferencias=="1"){
      obtenerCierrePeriodo(fechaInicioPeriodo, fechaTerminoPeriodo, idTipoPeriodo);
    }
  }//termina funcion seleccion periodo 

  function obtenerCierrePeriodo(fechaInicioPeriodo, fechaTerminoPeriodo, idTipoPeriodo){

   $.ajax({
              
    type: "POST",
    url: "ajax_consultaCierrePeriodo.php",
    data:{fechaInicioPeriodo:fechaInicioPeriodo,fechaTerminoPeriodo:fechaTerminoPeriodo,idTipoPeriodo:idTipoPeriodo },
    dataType: "json",
     success: function(response) {
      //console.log(response);
        if (response.status == "success")
        {
     
           var datos = response.datosCierrePeriodo;
           var fechaCierre="";
           var fechaCambioPeriodo="";

            for ( var i = 0; i < datos.length; i++ ){

              fechaCierre=datos[i].fechaCierrePeriodo;
              fechaCambioPeriodo=datos[i].fechaCambioPeriodo;

            }




            $("#txtFechaCierre").val(fechaCierre);
            $("#txtCambioPeriodo").val(fechaCambioPeriodo);

            if(fechaCierre!=""){
              consultaDiferencias(fechaInicioPeriodo, fechaTerminoPeriodo, fechaCierre,fechaCambioPeriodo, idTipoPeriodo);
            }else{
              
              $('#divDiferencias').html("<div><h1>No se encontró fecha de cierre del periodo seleccionado</h1></div>"); 
            }

        }else if (response.status == "error" && response.message == "No autorizado")
        {
            window.location = "index.php";
        }
    },
    error: function (response)
    {
        console.log (response);

    }
    });

  }

function consultaDiferencias(fechaInicioPeriodo, fechaTerminoPeriodo, fechaCierre,fechaCambioPeriodo, idTipoPeriodo)
{
  waitingDialog.show();
  $.ajax({
    type: "POST",
    url: "ajax_getDiferenciasAlCierre.php",
    data: {fechaCierre:fechaCierre,fechaCambioPeriodo:fechaCambioPeriodo,idTipoPeriodo:idTipoPeriodo},
    dataType: "json",
	  Async:false,
    success: function(response) {
      if (response.status == "success")
      {
        var diferencias = response.incidenciasAlCierre;
        $('#divDiferencias').html(""); 
        var listaDiferenciasTable="<form id='checkEmpleadosDiferencias'>";
        listaDiferenciasTable+="<table class='table table-bordered' id='Exportar_a_Excel'><thead><th># Empleado</th><th>Nombre</th><th>Puesto</th><th>Rol</th><th>Punto Servicio</th>";
        listaDiferenciasTable+="<th>Supervisor</th><th>Fecha asistencia</th><th>Incidencia cierre</th><th>Incidencia</th><th>Movimiento</th><th>Fecha Modificación</th><th>Aplicar</th></thead><tbody>";
        if (diferencias.length > 0)
        {
          listaDiferenciasTable+="<br/>";
          listaDiferenciasTable+="<a href='javascript:seleccionar_incidencias()'>Marcar todos</a>";
          listaDiferenciasTable+="<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
          listaDiferenciasTable+="<a href='javascript:deseleccionar_incidencias()'>Marcar ninguno</a>";
          listaDiferenciasTable+="<br/>";
          for ( var i = 0; i < diferencias.length; i++ )
          {
            var numeroEmpleado = diferencias[i].numeroEmpleado;
            var nombreEmpleado = diferencias[i].nombreEmpleado;
            var puesto= diferencias[i].descripcionPuesto;
            var empleadoIdPuesto=diferencias[i].puestoCubiertoId;
            var descripcionTurno=diferencias[i].descripcionTurno;
            var supervisor=diferencias[i].supervisor;
            var puntoServicio=diferencias[i].puntoServicio;
            var fechaRegistroAsistencia=diferencias[i].fechaRegistroAsistencia;
            var lastEditedIncidencia=diferencias[i].lastEditedIncidencia;
            var modificacion=diferencias[i].nomenclaturaIncidencia;
            var diaFestivo=diferencias[i].DiaFestivo;
            var fechaAsistencia=diferencias[i].fechaAsistencia;
            var fecha=lastEditedIncidencia;
            var valorAsistencia=diferencias[i].valorAsistencia;
            var incidenciaCierre=diferencias[i].incidenciaCierre[0]["nomenclaturaIncidencia"];
            var roloperativo=diferencias[i].roloperativo;
            var aplicarIncidencia="";
            var supervisorId=diferencias[i].supervisorId;
            var idNuevaIncidencia="";
            var idEntidadTrabajo=diferencias[i].idEntidadTrabajo; 
            var comentarioIncidencia=diferencias[i].comentarioIncidencia; 
            if(incidenciaCierre==null){
              incidenciaCierre="0";
            }
            var movimiento="Edición";
            if(fecha==null || fecha==""){
              fecha=fechaRegistroAsistencia;
              movimiento="Registro";
            }
            // SI EL ELEMENTO NO TUVO REGISTRO DE ASISTENCIA AL CIERRE Y APLICAN 
            //MODIFICACION POSTERIOR AL CIERRE CON 1,DES,V/P,V/D 
            //SE DEBE APLICAR TURNO EXTRA
            if(modificacion=="V/P"){
              modificacion="VP";
            }
            if(modificacion=="V/P2"){
              modificacion="VP2";
            }
            if(modificacion=="V/D"){
              modificacion="VD";
            }
            if(modificacion=="V/D2"){
              modificacion="VD2";
            }
            if(incidenciaCierre=="V/P"){
              incidenciaCierre="VP";
            }
            if(incidenciaCierre=="V/P2"){
              incidenciaCierre="VP2";
            }
            if(incidenciaCierre=="V/D"){
              incidenciaCierre="VD";
            }
            if(incidenciaCierre=="V/D2"){
              incidenciaCierre="VD2";
            }
            
            if(incidenciaCierre==0 ){
              if(modificacion==1 || modificacion=="DES" || modificacion=="VP" || modificacion=="VD" || modificacion=="TE" || modificacion=="TEN"){
                aplicarIncidencia="+1";
                idNuevaIncidencia=1;
              }else if(modificacion==2 || modificacion=="DT12"){
                aplicarIncidencia="+2";
                idNuevaIncidencia=1;
              }
              //condicion para cuando se cerro asistencia con turno de 12x12
            }else if(incidenciaCierre==1 || incidenciaCierre=="DES"){
              if(modificacion=="PER" || modificacion=="F" || modificacion=="INC" || modificacion=="B" || modificacion=="D"){
                if(diaFestivo=="" || diaFestivo=="null" || diaFestivo==null || diaFestivo=="NULL"){
                  aplicarIncidencia="-1";
                }else{
                  aplicarIncidencia="-2";
                }
                idNuevaIncidencia=4;
              }else if(modificacion==2 ||modificacion=="DT12" || modificacion=="VP2" || modificacion=="VD2" || modificacion=="TE" || modificacion=="TEN"){
                aplicarIncidencia="+1";
                idNuevaIncidencia=1;
              }
                //condicion para cuando se cerro asistencia con turno de 24x24
            }else if(incidenciaCierre==2 || incidenciaCierre=="DT12"){
              if(modificacion=="DES" || modificacion==1 || modificacion=="VP"|| modificacion=="VD"){
                if(diaFestivo=="" || diaFestivo=="null" || diaFestivo==null || diaFestivo=="NULL"){
                  aplicarIncidencia="-1";
                }else{
                  aplicarIncidencia="-2";
                }
                idNuevaIncidencia=4;
              }else if(modificacion=="F" || modificacion=="PER" || modificacion=="INC" || modificacion=="B"){
                if(diaFestivo=="" || diaFestivo=="null" || diaFestivo==null || diaFestivo=="NULL"){
                  aplicarIncidencia="-2";
                }else{
                  aplicarIncidencia="-3";
                }
                idNuevaIncidencia=4;
              }
            }else if(incidenciaCierre=="F" || incidenciaCierre=="PER" || incidenciaCierre=="INC"){
              if(modificacion=="DES" || modificacion==1 || modificacion=="VP"|| modificacion=="VD"){
                aplicarIncidencia="+1";
                idNuevaIncidencia=1;
              }else if(modificacion==2 || modificacion=="DT12" || modificacion=="VP2"|| modificacion=="VD2"){
                aplicarIncidencia="+2";
                idNuevaIncidencia=1;
              }
            }else if(incidenciaCierre=="VP" || incidenciaCierre=="VD"){
              if(modificacion==2 || modificacion=="DT12" || modificacion=="VP2"|| modificacion=="VD2"){
                aplicarIncidencia="+1";
                idNuevaIncidencia=1;
              }else if(modificacion=="F" || modificacion=="PER" || modificacion=="INC" || modificacion=="B"){
                if(diaFestivo=="" || diaFestivo=="null" || diaFestivo==null || diaFestivo=="NULL"){
                  aplicarIncidencia="-1";
                }else{
                  aplicarIncidencia="-2";
                }
                idNuevaIncidencia=4;
              }
            }else if(incidenciaCierre=="VP2" || incidenciaCierre=="VD2"){
              if(modificacion=="DES" || modificacion==1 || modificacion=="VP"|| modificacion=="VD"){
                if(diaFestivo=="" || diaFestivo=="null" || diaFestivo==null || diaFestivo=="NULL"){
                  aplicarIncidencia="-1";
                }else{
                  aplicarIncidencia="-2";
                }
                idNuevaIncidencia=4;
              }else if(modificacion=="F" || modificacion=="PER" || modificacion=="INC" || modificacion=="B"){
                if(diaFestivo=="" || diaFestivo=="null" || diaFestivo==null || diaFestivo=="NULL"){
                  aplicarIncidencia="-2";
                }else{
                  aplicarIncidencia="-3";
                }
                idNuevaIncidencia=4;
              }
            }
            
            listaDiferenciasTable += "<tr><td>"+numeroEmpleado+"</td><td>"+nombreEmpleado+"</td><td>"+puesto+"</td><td>"+descripcionTurno+"</td>";
            listaDiferenciasTable += "<td>"+puntoServicio+"</td><td>"+supervisor+"</td><td>"+fechaAsistencia+"</td><td>"+incidenciaCierre+"</td>";
            listaDiferenciasTable += "<td>"+modificacion+"</td><td>"+movimiento+"</td><td>"+fecha+"</td>";
            if(aplicarIncidencia==""){
             listaDiferenciasTable +="<td>No aplica</td></tr>";
            }else{


             listaDiferenciasTable += "<td>"+aplicarIncidencia+" <input type='checkbox' id="+numeroEmpleado+'_'+modificacion+'_'+i+"  name="+numeroEmpleado+'_'+modificacion+'_'+i+" value='"+numeroEmpleado+'_'+modificacion+'_'+i+"' ";
             listaDiferenciasTable += " empleadoIdPuesto='"+empleadoIdPuesto+"' aplicarIncidencia='"+aplicarIncidencia+"' puntoServicioCubierto='"+puntoServicio+"'";
             listaDiferenciasTable += " fechaIncidenciaCierre='"+fechaAsistencia+"' supervisorId='"+supervisorId+"' idNuevaIncidencia='"+idNuevaIncidencia+"'  comentarioIncidencia='"+comentarioIncidencia+"' idEntidadTrabajo='"+idEntidadTrabajo+"' fechaCambioPeriodo='"+fechaCambioPeriodo+"'    neomenclaturaIncidencia='"+modificacion+"' roloperativo='"+roloperativo+"'></td><tr>";
            }
          }
          listaDiferenciasTable += "</tbody></table>";
          listaDiferenciasTable+="<button id='btnaplicadiferncias' type='button' class='btn btn-secondary' onclick='aplicarDiferencias();'><span class='glyphicon glyphicon-ok'></span>Aplicar diferencias</button></form>";
          $('#divDiferencias').html(listaDiferenciasTable); 
          waitingDialog.hide();    
        }else{
          $('#divDiferencias').html("<div><h1>No se encontraron diferencias</h1></div>"); 
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
      alert("Error funcion getdiferencias")
    }
  });
}

  function seleccionar_incidencias(){ 
   for (i=0;i<document.form_diferencias.elements.length;i++) 
      if(document.form_diferencias.elements[i].type == "checkbox")  
         document.form_diferencias.elements[i].checked=1 
} 
  function deseleccionar_incidencias(){ 
   for (i=0;i<document.form_diferencias.elements.length;i++) 
      if(document.form_diferencias.elements[i].type == "checkbox")  
         document.form_diferencias.elements[i].checked=0 
}

function aplicarDiferencias(){

var fechaCierre=$("#txtFechaCierre").val();

    
  var diferenciasSeleccionadas = $( "input[type=checkbox]:checked");



      var diferenciasConfirmadasParaAplicar = [];
      var puestos=[];
      var diferenciaParaAplicar=[];
      var puntoServicioCubiertoAlCierre=[];
      var fechaAsistenciaAlCierre=[];
      var comentarioIncidencia1=[];
      //var centrosDeCosto=[];
      var supervisores=[];
      var nuevasIncidencias=[];
      var entidadesTrabajo=[];
      var fechasCambioPeriodo=[];
      var neomenclaturaIncidencias=[];

      var roloperativos=[];
      
        for (var i = 0; i < diferenciasSeleccionadas.length; i++)
        {
          
            if ((diferenciasSeleccionadas[i].checked == true && diferenciasSeleccionadas[i].value.match (/[0-9]{2}\-[0-9]{4}\-[0-9]{2}/g)) || (diferenciasSeleccionadas[i].checked == true && diferenciasSeleccionadas[i].value.match (/[0-9]{2}\-[0-9]{5}\-[0-9]{2}/g)))
            {
                diferenciasConfirmadasParaAplicar.push (diferenciasSeleccionadas[i].value);

                var iteracion = $("#"+diferenciasSeleccionadas[i].value).attr("iteracion");
                var a = diferenciasSeleccionadas[i].value;
                var puesto = $("#"+diferenciasSeleccionadas[i].value).attr("empleadoIdPuesto");
                var aplicarIncidencia = $("#"+diferenciasSeleccionadas[i].value).attr("aplicarIncidencia");
                var puntoServicioAlCierre=$("#"+diferenciasSeleccionadas[i].value).attr("puntoServicioCubierto");
                var fechaAsistencia=$("#"+diferenciasSeleccionadas[i].value).attr("fechaIncidenciaCierre");
                 var comentarioIncidencia=$("#"+diferenciasSeleccionadas[i].value).attr("comentarioIncidencia");
                //var centroDeCosto=$("#"+diferenciasSeleccionadas[i].value).attr("centroDeCosto");
                var supervisorId=$("#"+diferenciasSeleccionadas[i].value).attr("supervisorId");
                var idNuevaIncidencia=$("#"+diferenciasSeleccionadas[i].value).attr("idNuevaIncidencia");
                var idEntidadTrabajo=$("#"+diferenciasSeleccionadas[i].value).attr("idEntidadTrabajo");
                var fechaCambioPeriodo=$("#"+diferenciasSeleccionadas[i].value).attr("fechaCambioPeriodo");
                var neomenclaturaIncidencia=$("#"+diferenciasSeleccionadas[i].value).attr("neomenclaturaincidencia");
                var roloperativo=$("#"+diferenciasSeleccionadas[i].value).attr("roloperativo");

                if(neomenclaturaIncidencia=="VP"){
                  neomenclaturaIncidencia="V/P";
                }
                if(neomenclaturaIncidencia=="VP2"){
                  neomenclaturaIncidencia="V/P2";
                }
                if(neomenclaturaIncidencia=="VD"){
                  neomenclaturaIncidencia="V/D";
                }
                if(neomenclaturaIncidencia=="VD2"){
                  neomenclaturaIncidencia="V/D2";
                }
                console.log(neomenclaturaIncidencia);
                           
                puestos.push(puesto);
                diferenciaParaAplicar.push(aplicarIncidencia);
                puntoServicioCubiertoAlCierre.push(puntoServicioAlCierre);
                fechaAsistenciaAlCierre.push(fechaAsistencia);
                comentarioIncidencia1.push(comentarioIncidencia);
                //centrosDeCosto.push(centroDeCosto);
                supervisores.push(supervisorId);
                nuevasIncidencias.push(idNuevaIncidencia);
                entidadesTrabajo.push(idEntidadTrabajo);
                fechasCambioPeriodo.push(fechaCambioPeriodo);
                neomenclaturaIncidencias.push(neomenclaturaIncidencia);

                 roloperativos.push(roloperativo);
                 
            }
        }

        var data = [];

        for(var i = 0; i < diferenciasConfirmadasParaAplicar.length; i++){
        data.push({
          numeroEmpleado: diferenciasConfirmadasParaAplicar[i]
          ,puestoCubierto: puestos[i]
          ,diferencia:diferenciaParaAplicar[i]
          ,puntoServicioCierre:puntoServicioCubiertoAlCierre[i]
          ,fechaAsistencia:fechaAsistenciaAlCierre[i]
          //,centroCosto:centrosDeCosto[i]
          ,supervisorId:supervisores[i]
          ,idNuevaIncidencia:nuevasIncidencias[i]
          ,idEntidadTrabajo:entidadesTrabajo[i]
          ,fechaCambioPeriodo:fechasCambioPeriodo[i]
          ,neomenclaturaIncidencia:neomenclaturaIncidencias[i]
          ,roloperativo:roloperativos[i]
          ,comentarioIncidencia:comentarioIncidencia1[i]
        });
        }
        if (diferenciasConfirmadasParaAplicar.length > 0)
        {
          //waitingDialog.show();

            $("#btnaplicadiferncias").attr("disabled", true);


         $.ajax({
                type: "POST",
                url: "ajax_aplicarDiferenciasCierre.php",
                data: {data:data},
                dataType: "json",
                success: function(response) {
                    var mensaje=response.message;

                    if (response.status=="success") {
                      alert(mensaje);
                      consultaDiferencias(fechaInicioPeriodo, fechaTerminoPeriodo, fechaCierre,fechaCambioPeriodo, idTipoPeriodo);
                       $("#btnaplicadiferncias").attr("disabled", false);
                                          
                    } else if (response.status=="error")
                    {
                      $("#btnaplicadiferncias").attr("disabled", false);
                      alert(mensaje);
                     
                    }
                    
                    $("#modalMsgSueldos").modal();
                  },
                error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText); 
    }
            });
        } else
        {
          alert ("Seleccione los empleados para los que quiere actualizar.");
          $("#btnaplicadiferncias").attr("disabled", false);
        }

}


</script>