<?php

?>
<div class="container" align="center" >

<form class="form-horizontal" id="form_bajasSolicitadas" name="form_bajasSolicitadas">
	<div id="divBajasSolicitadas">
        	
    </div>


    <!-- Modal  Baja Empleado-->
    <div id="myModalSolicitudBaja" name="myModalSolicitudBaja" class="modalEdit hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
  <div id="alertMsg1PB"> 
  </div>
  
   <div class="modal-header">

      <h4 class="modal-title" id="myModalLabel"> <img src="img/warning.png">¿DESEA APLICAR BAJA DEL EMPLEADO?</h4>
    </div>

    <div class="modal-body">


        <div class="input-prepend">
          <span class="add-on">NÚMERO EMPLEADO</span>
          <input id="txtNumeroEmpleadoModalPB" name="txtNumeroEmpleadoModalPB" type="text" class="input-medium" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">NOMBRE EMPLEADO</span>
          <input id="txtNombreEmpleadoModalPB" name="txtNombreEmpleadoModalPB" type="text" class="input-xlarge" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">FECHA INGRESO</span>
          <input id="txtFechaIngresoModalPB" name="txtFechaIngresoModalPB" type="date" class="input-medium" readonly>
        </div>

        <div class="input-prepend">
          <span class="add-on">FECHA BAJA</span>
          <input id="txtFechaBajaModalPB" name="txtFechaBajaModalPB" type="date" class="input-medium">
        </div>

        <div class="input-prepend">
          <span class="add-on">TIPO BAJA</span>
          <select id="selectTipoBajaPB" name="selectTipoBajaPB" class="input-large" onChange='selectMotivosBajaPorTipoBajaP();'>
            <option>TIPO BAJA</option>
                <?php
              for ($i=0; $i<count($catalogoTipoBaja); $i++)
              {
                echo "<option value='". $catalogoTipoBaja[$i]["idTipoBaja"]."'>". $catalogoTipoBaja[$i]["descripcionTipoBaja"] ." </option>";
              }
              ?>
          </select>
        </div>

        <div class="input-prepend">
          <span class="add-on">MOTIVO BAJA</span>
          <select id="selectMotivoBajaPB" name="selectMotivoBajaPB" class="input-large ">
          </select>
         </div>

        <div class="input-prepend">
          <span class="add-on">COMENTARIO</span>
          <input id="txtComentarioBajaPB" name="txtComentarioBajaPB" type="text" class="input-xlarge">
          <input id="txtPuestoBajaPB" name="txtPuestoBajaPB" type="hidden" class="input-small">

        </div>

        <div class="input-prepend">
          
          <input id="txtTipoPeriodoPB" name="txtTipoPeriodoPB" type="hidden" class="input-small">
        </div>
        <div class="input-prepend">
          
          <input id="txtPuntoServicioBajaPB" name="txtPuntoServicioBajaPB" type="hidden" class="input-small">
        </div>
        <div class="input-prepend">
          
          <input id="txtTipoEmpleadoPB" name="txtTipoEmpleadoPB" type="hidden" class="input-small">
        </div>

        <div class="input-prepend">
          
          <input id="txtResponsableAsistenciaPB" name="txtResponsableAsistenciaPB" type="hidden" class="input-small">
        </div>

   
    </div>
      <div class="modal-footer" id="footerBajaEmpleadoPB">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick='aplicarBaja();'>Guardar Cambios</button>
      </div>
    </div>  <!-- FIN MODAL BAJA EMPLEADO -->


<!-- modal de baja denegada -->
<div class="modal fade" tabindex="-1" role="dialog" name="modalErrorProcesarBajaImss" id="modalErrorProcesarBajaImss" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><img src="img/alert.png">No se puede procesar baja</h4>
      </div>
      <div class="modal-body">
        <p><strong>El empleado no puede darse de baja debido a que está en proceso de confirmación de alta en Imss, intente más tarde.</strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




</form>


</div>  <!-- div container fin -->

<script type="text/javascript">

<?php 
  if ($usuario["rol"] =="Supervisor" 	|| $usuario["rol"] =="Contrataciones" || $usuario["rol"] =="Analista Asistencia" || $usuario["rol"] =="Lider Unidad")
                {
                ?>
                
                getSolicitudesBajas();
                setInterval("getSolicitudesBajas()",110000);

                <?php
            }
            ?>
	
 function getSolicitudesBajas()
  {
  	 var estatusEmpleadoOperaciones=3;

      $.ajax({
            
            type: "POST",
            url: "ajax_getEmpleadosEstatusOperaciones.php",
            data : {"estatusEmpleadoOperaciones":estatusEmpleadoOperaciones},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                     
                    var lista = response.lista;
                      
                    listaTable="<table class='table table-hover' ><thead><th>Numero Empleado</th><th>Nombre Empleado</th><th>Supervisor</th><th>Fecha alta</th><th>Fecha baja</th></thead><tbody>";

                    for ( var i = 0; i < lista.length; i++ ){

                    	var numeroEmpleado = lista[i].numeroEmpleado;
                        var nombre = lista[i].nombre;
                        var fechaBajaOperaciones = lista[i].fechaBajaOperaciones;
                        var fechaIngresoEmpleado= lista[i].fechaIngresoEmpleado;
                        var estatusEmpleado= lista[i].empleadoEstatusId;
                        var tipoPeriodo= lista[i].tipoPeriodo;
                        var empleadoIdPuntoServicio= lista[i].empleadoIdPuntoServicio;
                        var idTipoPuesto= lista[i].idTipoPuesto;
                        var responsableAsistencia= lista[i].responsableAsistencia;
                        var supervisor= lista[i].supervisor;
                        var descripcionTipoPeriodo= lista[i].descripcionTipoPeriodo;
                        var empleadoIdPuesto=lista[i].empleadoIdPuesto;
                        var empleadoEstatusImss=lista[i].empleadoEstatusImss;


                  listaTable += "<tr><td>"+numeroEmpleado+" </td><td>"+nombre+" </td><td>"+supervisor+"</th><td>"+fechaIngresoEmpleado+"</td><td>"+fechaBajaOperaciones+"</td>";

                 <?php 
  				if ( $usuario["rol"] =="Contrataciones")
                {
                ?>
                
                  listaTable += "<td><button id='guardar' name='guardar' class='btn btn-primary' type='button' onclick='modalProcesarBaja(\"" + numeroEmpleado + "\",\"" +fechaIngresoEmpleado + "\",\"" + nombre + "\",\"" + fechaBajaOperaciones + "\","+ tipoPeriodo +", "+ empleadoIdPuntoServicio +",\"" + idTipoPuesto + "\",\"" + responsableAsistencia + "\","+empleadoIdPuesto+","+empleadoEstatusImss+")'></span>Procesar baja</button></td>";
                  listaTable += "<td><button id='guardar' name='guardar' class='btn btn-success' type='button' onclick='rechazarBaja(\"" + numeroEmpleado + "\",\"" +fechaBajaOperaciones + "\",\"" +descripcionTipoPeriodo + "\");'></span>No procesar baja</button></td></tr>";
                
                <?php
            }
            ?>


                  
                  

                }       
                  listaTable += "</tbody></table>";
                  $('#divBajasSolicitadas').html(listaTable);     
                   
                   
                 }
            },           

            error: function (response)
            {
                console.log (response);

            }
        });
  }

  function modalProcesarBaja(numeroEmpleado, fechaIngreso, nombreCompleto, fechaBajaOperaciones, tipoPeriodo, empleadoIdPuntoServicio, idTipoPuesto, responsableAsistencia, empleadoIdPuesto,empleadoEstatusImss){

    if(empleadoEstatusImss==1 || empleadoEstatusImss==2){
      $("#modalErrorProcesarBajaImss").modal();

    }else{

      $('#myModalSolicitudBaja').modal();
      $("#txtNumeroEmpleadoModalPB").val(numeroEmpleado);
      $("#txtFechaIngresoModalPB").val(fechaIngreso);
      $("#txtNombreEmpleadoModalPB").val(nombreCompleto);
      $("#txtFechaBajaModalPB").val(fechaBajaOperaciones);
      $("#txtTipoPeriodoPB").val(tipoPeriodo);
      $("#txtPuntoServicioBajaPB").val(empleadoIdPuntoServicio);
      $("#txtTipoEmpleadoPB").val(idTipoPuesto);
      $("#txtResponsableAsistenciaPB").val(responsableAsistencia);
      $("#txtPuestoBajaPB").val(empleadoIdPuesto);

    }
  

}

 function selectMotivosBajaPorTipoBajaP()
  {
       
       var idTipoBaja = $("#selectTipoBajaPB").val();
       $.ajax({
            type: "POST",
            url: "ajax_obtenerMotivosBajaPorTipoBaja.php",
            data: {"idTipoBaja": idTipoBaja},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    
                    var listaMotivos = response.motivosBaja;
                    
                    motivosOptions = "<option>MOTIVO BAJA</option>";
                    for (var i = 0; i < listaMotivos.length; i++)
                    {
                        motivosOptions += "<option value='" + listaMotivos[i].idcatalogoMotivosBaja + "'>"+listaMotivos[i].descripcionMotivoBaja+ "</option>";
                    }
                    
                    $("#selectMotivoBajaPB").html (motivosOptions);
                   // $("#selectMotivoBaja").val(idClaveMovimiento);
                }
            },
            error: function (response)
            {
                console.log (response);
            }
        });
  }

  function aplicarBaja ()
    {
     
        var numeroEmpleado=$("#txtNumeroEmpleadoModalPB").val();
        var fechaIngreso=$("#txtFechaIngresoModalPB").val();
        var fechaBaja=$("#txtFechaBajaModalPB").val();
        var motivoBaja=$("#selectMotivoBajaPB").val();
        var comentarioBaja=$("#txtComentarioBajaPB").val();

        var puntoServicioId=$("#txtPuntoServicioBajaPB").val();
        var tipoPeriodo=$("#txtTipoPeriodoPB").val();
        var supervisorId=$("#txtResponsableAsistenciaPB").val();
        var puestoCubiertoId=$("#txtPuestoBajaPB").val();
       
        
        $("#footerBajaEmpleadoPB").html ("<img src='img/loading-sm.gif' />");
        
        /*
        setTimeout(function(){
            console.log("in pause);
        }, 2000);
        */
        
        $.ajax({
            type: "POST",
            url: "ajax_registroHistoricoBaja.php",
            data: {"numeroEmpleado":numeroEmpleado,"idMotivoBaja":motivoBaja, "fechaIngreso":fechaIngreso,"fechaCausaBaja":fechaBaja,"comentarioBaja":comentarioBaja, puntoServicioId:puntoServicioId, tipoPeriodo:tipoPeriodo, supervisorId:supervisorId, puestoCubiertoId:puestoCubiertoId},
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {
  
                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Registro de baja</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsg1PB").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');

                    solicitaBajaImssPB();

                    $("#selectMotivoBajaPB").val("MOTIVO BAJA");
                    $("#txtComentarioBajaPB").val("");
                    $("#selectTipoBajaPB").val("TIPO BAJA");
                    
                    $("#footerBajaEmpleadoPB").html ("<button class='btn btn-primary' onclick='cerrarModalBajaEmpleadoPB ();' type='button'>Cerrar</button>");

                    cerrarModalBajaEmpleadoPB();
                                      
                    getSolicitudesBajas();

                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Registro baja:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsg1PB").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    
                    configureFooterBajaEmpleadoPB ();
                }
              },
            error: function(){
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Registro baja:</strong>Ocurrio un error en la comunicación con el servidor.<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                  $("#alertMsg1PB").html(alertMsg1);
                  $('#msgAlert').delay(3000).fadeOut('slow');
                  
                  configureFooterBajaEmpleadoPB ();
            }
        });
    }

    function cerrarModalBajaEmpleadoPB ()
{
    $("#myModalSolicitudBaja").modal("hide");
    
    configureFooterBajaEmpleadoPB ();
}

function configureFooterBajaEmpleadoPB ()
{
    $("#footerBajaEmpleadoPB").html ("<button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button><button type='button' class='btn btn-primary' onclick='aplicarBaja();'>Guardar Cambios</button>");
}

  function solicitaBajaImssPB(){
    
          var numeroEmpleado=$("#txtNumeroEmpleadoModalPB").val();
          var empleadoEstatusImss="5";
          var idMotivoBajaImss="2";
          var fechaBajaImss=$("#txtFechaBajaModalPB").val();



        $.ajax({
            type: "POST",
            url: "ajax_registraBajaImss.php",
            data: {"numeroEmpleado":numeroEmpleado,"idMotivoBajaImss":idMotivoBajaImss,"empleadoEstatusImss":empleadoEstatusImss,"fechaBajaImss":fechaBajaImss },
            dataType: "json",
            async: false,
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {
            

                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error al procesar baja Imss: </strong>" + mensaje + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsg1PB").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');

                    
                }
              },
            error: function(){
                  alert('error handing here');
            }
        });

      }


function rechazarBaja(numeroEmpleado, fechaBajaOperaciones, descripcionTipoPeriodo)
  {
       
       $.ajax({
            type: "POST",
            url: "ajax_rechazarBaja.php",
            data: {"numeroEmpleado": numeroEmpleado, "fechaBajaOperaciones":fechaBajaOperaciones, "descripcionTipoPeriodo":descripcionTipoPeriodo },
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                	var mensaje=response.message;

                	getSolicitudesBajas();
                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Cancelacion de baja: </strong>" + mensaje + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsg").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    
                }
            },
            error: function (response)
            {
                console.log (response);
            }
        });
  }

    
</script>