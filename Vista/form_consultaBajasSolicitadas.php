<center><h3>SOLICITUDES DE BAJAS</h3><br>
<img style='width: 50px' title='CARGAR LAS SOLICITUDES DE BAJAS ACTUALES' src='img/ActualizarEjecutar.jpg' class='cursorImg' onclick='getSolicitudesBajas();'></center><br>
<div class="container" align="center" >
<input id="txtIdTarjeta" name="txtIdTarjeta" type="hidden" class="input-small">
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
          <input id="txtFechaBajaModalPBhidden" name="txtFechaBajaModalPBhidden" type="hidden" class="input-medium">
        </div>

        <div class="input-prepend">
          <span class="add-on">TIPO BAJA</span>
          <select id="selectTipoBajaPB" name="selectTipoBajaPB" class="input-large" onChange='selectMotivosBajaPorTipoBajaP();'>
            <option>TIPO BAJA</option>
                <?php
for ($i = 0; $i < count($catalogoTipoBaja); $i++) {
    echo "<option value='" . $catalogoTipoBaja[$i]["idTipoBaja"] . "'>" . $catalogoTipoBaja[$i]["descripcionTipoBaja"] . " </option>";
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
          <input id="txtComentarioBajaPB" name="txtComentarioBajaPB" type="text" class="input-xlarge" readonly="true">
          <input id="txtPuestoBajaPB" name="txtPuestoBajaPB" type="hidden" class="input-small">

        </div>

        <div class="modal-body" id="TextoBetado" style="display: none;" align="center" >
          <span class="add-on" style="color:red;">EL ELEMENTO QUEDARÁ VETADO DE TODO EL CORPORATIVO GIF SEGURIDAD PRIVADA</span><br>
          <span class="add-on" style="color:red;">Y NO PODRÁ SER REINGRESADO EN NINGUNA PARTE DEL PAIS DENTRO DE ESTE CORPORATIVO!!!</span>
        </div>
        <div class="modal-body" id="divComentarioMotivoBetoSolicitud" style="display: none;" align="center">
          <span class="add-on">Motivo:</span>
          <textarea id="ComentarioBetadoSolicitud" name="ComentarioBetadoSolicitud" class="txtAreaIncidencia" readonly="true"></textarea>
          <input id="Estatusvetadosolicitud" name="Estatusvetadosolicitud" type="hidden" class="input-medium">
        </div>


        <div class="input-prepend">

          <input id="txtTipoPeriodoPB" name="txtTipoPeriodoPB" type="hidden" class="input-small">
        </div>
        <div class="input-prepend">

          <input id="txtPuntoServicioBajaPB" name="txtPuntoServicioBajaPB" type="hidden" class="input-small">
          <input id="txtIdPlantillaBajaPB" name="txtIdPlantillaBajaPB" type="hidden" class="input-small">
        </div>
        <div class="input-prepend">

          <input id="txtTipoEmpleadoPB" name="txtTipoEmpleadoPB" type="hidden" class="input-small">

           <input id="hdnsolicitudbajaroloperativo" name="hdnsolicitudbajaroloperativo" type="hidden" class="input-small">


          
        </div>

        <div class="input-prepend">

          <input id="txtResponsableAsistenciaPB" name="txtResponsableAsistenciaPB" type="hidden" class="input-small">
        </div>


    </div>
      <div class="modal-footer" id="footerBajaEmpleadoPB">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick='consultarEstatusTarjeta();'>Guardar Cambios</button>
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

<div class="modal fade" tabindex="-1" role="dialog" name="modalErrorProcesarBajaImssMSDImss" id="modalErrorProcesarBajaImssMSDImss" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><img src="img/alert.png">No se puede procesar baja</h4>
      </div>
      <div class="modal-body">
        <p><strong>El empleado no puede darse de baja debido a que está en proceso de modificación de salario</strong></p>
        <div id="DivPermanencioErrorBaja"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




</form>

<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElectronicaBajaTarjetaSB" id="modalFirmaElectronicaBajaTarjetaSB" data-backdrop="static">
  <div id="errorModalFirmaBajaTarjetaSB"></div>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y contraseña que generaste</h3>
      </div>
      <div class="modal-body" align="center">
        <h5>Baja Tarjeta</h5>
      </div>
      <div class="modal-body" align="center">
        <span class="add-on">No.Empleado</span>
        <input type="text" id="NoEmpModalFirmaBajaTarjetaSB" class="input-medium" name="NoEmpModalFirmaBajaTarjetaSB" placeholder="00-0000-00 Ó 00-00000-00">
        <span class="add-on">Contraseña</span>
        <input type="password" id="constraseniaFirmaBajaTarjetaSB" class="input-xlarge"name="constraseniaFirmaBajaTarjetaSB" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
      </div>
      <div class="modal-body" align="center">
        <button type="button" id="btnFirmarBajaTarjetaSB" name="btnFirmarBajaTarjetaSB" style="display: none;" onclick="revisarFirmaSolicitudBajaTarjeta();" class="btn btn-primary" >Firmar</button>
        <button type="button" id="btnCancelarFirmaBajaTarjetaSB" name="btnCancelarFirmaBajaTarjetaSB"onclick="cancelarFirmaBajaTarjetaSolicitud();" class="btn btn-danger" >Cancelar</button>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</div>  <!-- div container fin -->

<script type="text/javascript">

// <?php
// if ($usuario["rol"] == "Supervisor" || $usuario["rol"] == "Contrataciones" || $usuario["rol"] == "Consulta Supervisor" || $usuario["rol"] == "Analista Asistencia" || $usuario["rol"] == "Lider Unidad" || $usuario["rol"] == "Laborales") {
// ?>
//   getSolicitudesBajas();
//   setInterval("getSolicitudesBajas()",110000);
// <?php
// }
// ?>

 function getSolicitudesBajas()
  {
     var estatusEmpleadoOperaciones=3;
     //alert("Entre jaja");
      $.ajax({

            type: "POST",
            url: "ajax_getEmpleadosEstatusOperaciones.php",
            data : {"estatusEmpleadoOperaciones":estatusEmpleadoOperaciones},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                  console.log(response);
                    var lista = response.lista;

                    listaTable="<table class='table table-hover' ><thead><th>Numero Empleado</th><th>Nombre Empleado</th><th>Supervisor</th><th>Fecha alta</th><th>Fecha baja</th><th>Rol Usuario</th></thead><tbody>";

                    for ( var i = 0; i < lista.length; i++ ){

                        var numeroEmpleado = lista[i].numeroEmpleado;
                        var nombre = lista[i].nombre;
                        var fechaBajaOperaciones = lista[i].fechaBajaOperaciones;
                        var fechaIngresoEmpleado= lista[i].fechaIngresoEmpleado;
                        var tipoPeriodo= lista[i].tipoPeriodo;
                        var empleadoIdPuntoServicio= lista[i].empleadoIdPuntoServicio;
                        var idTipoPuesto= lista[i].idTipoPuesto;
                        var responsableAsistencia= lista[i].responsableAsistencia;
                        var supervisor= lista[i].supervisor;
                        var descripcionTipoPeriodo= lista[i].descripcionTipoPeriodo;
                        var empleadoIdPuesto=lista[i].empleadoIdPuesto;
                        var roloperativo=lista[i].roloperativo;
                        var estatusEmpleado= lista[i].empleadoEstatusId;
                        var estatusEmpleadoOperaciones= lista[i].estatusEmpleadoOperaciones;
                        var empleadoEstatusImss=lista[i].empleadoEstatusImss;
                        var RolUsuario=lista[i].RolUsuario;
                        var NombreArchivoBaja=lista[i].NombreArchivoBaja;
                        
                        var ComentarioEmpBajaSinTrim=lista[i].ComentarioEmpBaja;
                        var ComentarioEmpBaja = $.trim(ComentarioEmpBajaSinTrim);

                        // var ComentarioEmpBaja=lista[i].ComentarioEmpBaja;
                        var EstatusReingreso=lista[i].EstatusReingreso;
                        var MotivoReingresoSinTrim=lista[i].MotivoReingreso;
                        var MotivoReingreso = $.trim(MotivoReingresoSinTrim);
                        var idPlantillaServicio=lista[i].IdPlantilla;
                        var OrigenEstatusImss=lista[i].OrigenEstatusImss;
                        var fechaImss=lista[i].fechaImss;

                        listaTable += "<tr><td>"+numeroEmpleado+" </td><td>"+nombre+" </td><td>"+supervisor+"</th><td>"+fechaIngresoEmpleado+"</td><td>"+fechaBajaOperaciones+"</td><td>"+RolUsuario+"</td>";

                                 <?php
if ($usuario["rol"] == "Contrataciones"|| $usuario["rol"] == "Laborales") {
    ?>
                                  if(estatusEmpleado == "0" && estatusEmpleadoOperaciones == "0" && empleadoEstatusImss =="3"){
                                   
                                    listaTable += "<td><button id='guardar' name='guardar'  title='No Se Proceso La Baja Por Error De Comunicación Con El Servidor' class='btn btn-primary' type='button' onclick='modalProcesarBaja(\"" + numeroEmpleado + "\",\"" +fechaIngresoEmpleado + "\",\"" + nombre + "\",\"" + fechaBajaOperaciones + "\","+ tipoPeriodo +", "+ empleadoIdPuntoServicio +",\"" + idTipoPuesto + "\",\"" + responsableAsistencia + "\","+empleadoIdPuesto+","+empleadoEstatusImss+" ,\""+roloperativo+"\",\""+ComentarioEmpBaja+"\",\""+EstatusReingreso+"\",\""+MotivoReingreso+"\",\""+idPlantillaServicio+"\",\""+OrigenEstatusImss+"\",\""+fechaImss+"\")'></span>Procesar baja</button></td>";
                                  }else{

                                     listaTable += "<td><button id='guardar' name='guardar' class='btn btn-primary' type='button' onclick='modalProcesarBaja(\"" + numeroEmpleado + "\",\"" +fechaIngresoEmpleado + "\",\"" + nombre + "\",\"" + fechaBajaOperaciones + "\","+ tipoPeriodo +", "+ empleadoIdPuntoServicio +",\"" + idTipoPuesto + "\",\"" + responsableAsistencia + "\","+empleadoIdPuesto+","+empleadoEstatusImss+" ,\""+roloperativo+"\",\""+ComentarioEmpBaja+"\",\""+EstatusReingreso+"\",\""+MotivoReingreso+"\",\""+idPlantillaServicio+"\",\""+OrigenEstatusImss+"\",\""+fechaImss+"\")'></span>Procesar baja</button></td>";
                                     listaTable += "<td><button id='guardar' name='guardar' class='btn btn-success' type='button' onclick='rechazarBaja(\"" + numeroEmpleado + "\",\"" +fechaBajaOperaciones + "\",\"" +descripcionTipoPeriodo + "\");'></span>No procesar baja</button></td>";
                                     listaTable += "<td><img src='img/pdf.jpg' width='120' onclick='abrirarchivoSolicitudBaja(\"" + numeroEmpleado + "\",\"" + RolUsuario + "\",\"" + NombreArchivoBaja + "\");' title='Formato De Baja Empleado'></td></tr>";
                                  }
                                  

                                <?php
}
?>





                    }
                   listaTable += "</tbody></table>";
                    $('#divBajasSolicitadas').html(listaTable);


                 }
            },

            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText); 
            }
        });
  }

   function abrirarchivoSolicitudBaja(NumEmpBaja,RolUsuario,NombreArchivoBaja){
    if(NombreArchivoBaja=="" || NombreArchivoBaja=="NULL" || NombreArchivoBaja=="null" || NombreArchivoBaja== null){
      window.open("generadordocBajaEmpleado.php?numempleado=" + NumEmpBaja+"&RolUsuario=" + RolUsuario,'fullscreen=no');
    }else{
      window.open("uploads/ArchivosBaja/"+NumEmpBaja +"/"+NombreArchivoBaja, 'fullscreen=no',"scrollbars=no");
    }
  }

  function modalProcesarBaja(numeroEmpleado, fechaIngreso, nombreCompleto, fechaBajaOperaciones, tipoPeriodo, empleadoIdPuntoServicio, idTipoPuesto, responsableAsistencia, empleadoIdPuesto,empleadoEstatusImss,roloperativo,ComentarioEmpBaja,EstatusReingres,MotivoReingreso,idPlantillaServicio,OrigenEstatusImss,fechaImss){
  
    if(empleadoEstatusImss==1 || empleadoEstatusImss==2){
      if(OrigenEstatusImss=="3"){// indicando que viene d una actualizacion de sueldo
        var fechaHoy = new Date();
        var fechaActual=(fechaHoy.getFullYear() + "-" + (fechaHoy.getMonth() +1) + "-" + fechaHoy.getDate());
        var diaInicio = new Date(fechaImss);
        var diaFin = new Date(fechaActual);
        var difference= Math.abs(diaFin-diaInicio);
        var LargoFecha1 = difference/86400000;
        var diasDePermanencia = Math.round(LargoFecha1);
        var msjError = "<span>Total De Dias : "+diasDePermanencia+"</span>"
        $("#DivPermanencioErrorBaja").html(msjError);
        $("#modalErrorProcesarBajaImssMSDImss").modal();
      }else{
        $("#modalErrorProcesarBajaImss").modal();
      }

    }else{
      if(EstatusReingres=="0"){
        $("#ComentarioBetadoSolicitud").val(MotivoReingreso);
        $("#Estatusvetadosolicitud").val(EstatusReingres);
        $("#TextoBetado").show();
        $("#divComentarioMotivoBetoSolicitud").show();
      }else{
        $("#ComentarioBetadoSolicitud").val("");
        $("#Estatusvetadosolicitud").val(1);

        $("#TextoBetado").hide();
        $("#divComentarioMotivoBetoSolicitud").hide();
      }

      $('#myModalSolicitudBaja').modal();
      $("#txtNumeroEmpleadoModalPB").val(numeroEmpleado);
      $("#txtFechaIngresoModalPB").val(fechaIngreso);
      $("#txtNombreEmpleadoModalPB").val(nombreCompleto);
      $("#txtFechaBajaModalPB").val(fechaBajaOperaciones);
      $("#txtFechaBajaModalPBhidden").val(fechaBajaOperaciones);
      $("#txtTipoPeriodoPB").val(tipoPeriodo);
      $("#txtPuntoServicioBajaPB").val(empleadoIdPuntoServicio);
      $("#txtIdPlantillaBajaPB").val(idPlantillaServicio);
      $("#txtTipoEmpleadoPB").val(idTipoPuesto);
      $("#txtResponsableAsistenciaPB").val(responsableAsistencia);
      $("#txtPuestoBajaPB").val(empleadoIdPuesto);
      $("#txtComentarioBajaPB").val(ComentarioEmpBaja);
      $("#hdnsolicitudbajaroloperativo").val(roloperativo);

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
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText); 
            }
        });
  }

$("#NoEmpModalFirmaBajaTarjetaSB").keyup(function (){
  var NumEmpModalRT = $("#NoEmpModalFirmaBajaTarjetaSB").val();
  var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
  var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;
 
  if(expreg.test(NumEmpModalRT) || expreg1.test(NumEmpModalRT)){
    consultaEmpleadoFirmaInternaBajaTarjetaSB(NumEmpModalRT);
  }else{
    $("#constraseniaFirmaBajaTarjetaSB").val("");
    $("#btnFirmarBajaTarjetaSB").hide();
  }
});

 function consultaEmpleadoFirmaInternaBajaTarjetaSB(numeroEmpleado){
  $.ajax({
    type: "POST",
    url: "ajax_obtenerEmpXIdSolicitudBajaTarjetas.php",
    data:{"numeroEmpleado":numeroEmpleado},
    dataType: "json",
    success: function(response) {
      if (response.status == "success"){
        var empleadoExtiste = response["empleado"].length;
        if(empleadoExtiste=="0"){
          cargaerrorModalSB("El Empleado No Existe En La Base De Registro De Firmas Favor De Verificar");
          $("#NoEmpModalFirmaBajaTarjetaSB").val("");
          $("#btnFirmarBajaTarjetaSB").hide();
        }else{
          var EstatusFirmaInterna = response.empleado[0].EstatusFirmaInterna;
          if(EstatusFirmaInterna=="0"){
            cargaerrorModalSB("Esta Firma Fue Dada De Baja Favor de solicitar Otra o Comunicarse Con RH"); 
            $("#NoEmpModalFirmaBajaTarjetaSB").val("");
            $("#btnFirmarBajaTarjetaSB").hide();
          }else{
            $("#btnFirmarBajaTarjetaSB").show();
          }
        }
      }else{
        cargaerrorModalSB("error ajax_obtenerEmpXIdSolicitudBajaTarjetas"); 
        $("#NoEmpModalFirmaBajaTarjetaSB").val("");
        $("#btnFirmarBajaTarjetaSB").hide();
      }
    },error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  });
}


function revisarFirmaSolicitudBajaTarjeta(){

  var noEmpFirma =$("#NoEmpModalFirmaBajaTarjetaSB").val();
  var pwdEmpFirma=$("#constraseniaFirmaBajaTarjetaSB").val();
 
  if(noEmpFirma==""){
    cargaerrorModalSB("Ingrese un numero de empleado");
  }else if(pwdEmpFirma==""){
           cargaerrorModalSB("Escriba la contraseña para continuar");
  }else{
     $.ajax({
            type: "POST",
            url: "ajax_RevisarFirmaSolicitudBajaTarjeta.php",
            data: {"noEmpFirma":noEmpFirma,"pwdEmpFirma":pwdEmpFirma},
            dataType: "json",
            success: function(response) {
              if(response.status == "success"){
                  var RespuestaLargo = response["datos"].length;
                  if(RespuestaLargo == "0"){
                     cargaerrorModalSB("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingresó en el registro");
                  }else{
                      darDeBajaTarjeta();  
                }
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
              }
            });
   }
}

function darDeBajaTarjeta (){
   
   var noEmpFirma =$("#NoEmpModalFirmaBajaTarjetaSB").val();
   var pwdEmpFirma=$("#constraseniaFirmaBajaTarjetaSB").val();
   var idTarjeta=$("#txtIdTarjeta").val();
    $.ajax({
        type: "POST",
        url: "ajax_DarDBajaTarjetabySolicitudBaja.php", 
        data: {"noEmpFirma":noEmpFirma,"pwdEmpFirma":pwdEmpFirma,"idTarjeta":idTarjeta},
        dataType: "json",
        success: function(response) {
          if(response.status=="success"){
            aplicarBaja();
            $("#modalFirmaElectronicaBajaTarjetaSB").modal("hide");
          } else if (response.status=="error"){
            var mensaje=response.mensaje;
            alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Registro de baja</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#alertMsg1PB").html(alertMsg1);
            $('#msgAlert').delay(3000).fadeOut('slow');
            $("#modalFirmaElectronicaBajaTarjetaSB").modal("hide");
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    waitingDialog.hide();
                }
      });
}

  function consultarEstatusTarjeta (){
    $("#NoEmpModalFirmaBajaTarjetaSB").val("");
    $("#constraseniaFirmaBajaTarjetaSB").val("");
   var numeroEmpleado=$("#txtNumeroEmpleadoModalPB").val();

    $.ajax({
        type: "POST",
        url: "ajax_consultarTarjetaDespensaXemp.php", 
        data: {"numeroEmpleado":numeroEmpleado}, 
        dataType: "json",
        success: function(response) {
          if(response.status=="success"){

            var idTarjeta= response.datos[0]["IdTarjetaDespensa"];
            var idEstatusTarjeta =response.datos[0]["idEstatusTarjeta"];
          
            if(idEstatusTarjeta=='1') {
              $("#txtIdTarjeta").val(idTarjeta);
              $("#modalFirmaElectronicaBajaTarjetaSB").modal();
              $("#myModalSolicitudBaja").modal("hide");
              
            }else{
              $("#modalFirmaElectronicaBajaTarjetaSB").modal("hide");
              aplicarBaja();
            }

          } else if (response.status=="error"){
            var mensaje=response.message;
          }
        },
        error: function(jqXHR, textStatus, errorThrown){
          alert(jqXHR.responseText);
          configureFooterBajaEmpleadoPB ();
        }
      });
}

  function aplicarBaja ()
  {
    var numeroEmpleado=$("#txtNumeroEmpleadoModalPB").val();
    var fechaIngreso=$("#txtFechaIngresoModalPB").val();
    var fechaBaja=$("#txtFechaBajaModalPB").val();
    var txtFechaBajaModalPBhidden=$("#txtFechaBajaModalPBhidden").val();
    var motivoBaja=$("#selectMotivoBajaPB").val();
    var comentarioBaja=$("#txtComentarioBajaPB").val();
    var puntoServicioId=$("#txtPuntoServicioBajaPB").val();
    var idPlantillaServicio=$("#txtIdPlantillaBajaPB").val();
    var tipoPeriodo=$("#txtTipoPeriodoPB").val();
    var supervisorId=$("#txtResponsableAsistenciaPB").val();
    var puestoCubiertoId=$("#txtPuestoBajaPB").val();
    var roloperativo=$("#hdnsolicitudbajaroloperativo").val();
    var ComentarioBetado = $("#ComentarioBetadoSolicitud").val();
    var banderaBetado = $("#Estatusvetadosolicitud").val();        
    $("#footerBajaEmpleadoPB").html ("<img src='img/loading-sm.gif' />");
    var SueldoEstatus=ConsultaSueldoEmpleadoBajaBajaSolicitada(numeroEmpleado);
    if(!SueldoEstatus){
      alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Registro de baja</strong>El empleado carece de una Cuota en tabulares !!<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        $("#alertMsg1PB").html(alertMsg1);
        $('#msgAlert').delay(3000).fadeOut('slow');
        configureFooterBajaEmpleadoPB ();
    }else{
      $.ajax({
        type: "POST",
        url: "ajax_registroHistoricoBaja.php", 
        data: {"ComentarioBetado":ComentarioBetado,"banderaBetado":banderaBetado,"numeroEmpleado":numeroEmpleado,"idMotivoBaja":motivoBaja, "fechaIngreso":fechaIngreso,"fechaCausaBaja":fechaBaja,"comentarioBaja":comentarioBaja,puntoServicioId:puntoServicioId, tipoPeriodo:tipoPeriodo, supervisorId:supervisorId, puestoCubiertoId:puestoCubiertoId,"roloperativo":roloperativo,"idPlantillaServicio":idPlantillaServicio},
        dataType: "json",
        success: function(response) {
          var mensaje=response.message;
          if (response.status=="success") {
            alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Registro de baja</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#alertMsg1PB").html(alertMsg1);
            $('#msgAlert').delay(3000).fadeOut('slow');
            GuardarMovimientoPlantillaHistoricoBajaPorSolicitud("BAJA POR SOLICITUD");
            solicitaBajaImssPB();
            $("#selectMotivoBajaPB").val("MOTIVO BAJA");
            $("#txtComentarioBajaPB").val("");
            $("#selectTipoBajaPB").val("TIPO BAJA");
            $("#footerBajaEmpleadoPB").html ("<button class='btn btn-primary' onclick='cerrarModalBajaEmpleadoPB ();' type='button'>Cerrar</button>");
            cerrarModalBajaEmpleadoPB();
            getSolicitudesBajas();
            var caso = "1";
            updateFechaArchivoBajaEmpleado(numeroEmpleado,txtFechaBajaModalPBhidden,caso);
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
  }

    function ConsultaSueldoEmpleadoBajaBajaSolicitada(numeroEmpleado){
  var valor1;
        $.ajax({
            type: "POST",
            url: "ajax_ConsultaSueldoEmpleadoBaja.php",
            data: {"numeroEmpleado":numeroEmpleado},
            dataType: "json",
            async: false, 
            success: function(response) {
                var mensaje=response.message;
                if (response.status=="success") {
                    var ExisteEmpleado = response.datos[0]["ExisteEmpleado"];
                    var cuotaDiariaEmpleado = response.datos[0]["cuotaDiariaEmpleado"];
                    //alert(cuotaDiariaEmpleado);
                    if(ExisteEmpleado == "0"){
                        valor1 = false;
                    }else if(ExisteEmpleado != "0" && cuotaDiariaEmpleado <=0){
                        valor1 = false;
                    }else{
                        valor1 = true; 
                    }
                } else if (response.status=="error")
                {
                  valor1 = false;
                  alert(mensaje);
                }
              },
              error: function(){
                  alert(jqXHR.responseText);
            }
        });
        return valor1;
    }

function updateFechaArchivoBajaEmpleado(numeroEmpleado,fechaBaja,caso){ 
  $.ajax({
    type: "POST",
    url: "ajax_UpdateDeleteArchivoBajaEmpleado.php",
    data : {"numeroEmpleado":numeroEmpleado,"fechaBaja":fechaBaja,"caso":caso},
    dataType: "json",
    async:false,
    success: function(response) {
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
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
    $("#footerBajaEmpleadoPB").html ("<button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button><button type='button' class='btn btn-primary' onclick='consultarEstatusTarjeta();'>Guardar Cambios</button>");
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
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText); 
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
                  var caso = "2";
                  updateFechaArchivoBajaEmpleado(numeroEmpleado,fechaBajaOperaciones,caso);
                  getSolicitudesBajas();
                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Cancelacion de baja: </strong>" + mensaje + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#alertMsg").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
        });
  }

function cancelarFirmaBajaTarjetaSolicitud(){
    $("#modalFirmaElectronicaBajaTarjetaSB").modal("hide");
    $("#myModalSolicitudBaja").modal();
    $("#NoEmpModalFirmaBajaTarjetaSB").val("");
    $("#constraseniaFirmaBajaTarjetaSB").val("");
  }
 


function GuardarMovimientoPlantillaHistoricoBajaPorSolicitud(TipoMovimiento){
  var numeroEmpleado=$("#txtNumeroEmpleadoModalPB").val();
  var PuntoServicioSeleccionado=$("#txtPuntoServicioBajaPB").val();
  var idPlantillaSeleccionada=$("#txtIdPlantillaBajaPB").val();
  var numeroEmpleadosplit  = numeroEmpleado.split("-");
  var EntidadEmp    = numeroEmpleadosplit[0];
  var CategoriaEmp= numeroEmpleadosplit[1];
  var TipoEmp= numeroEmpleadosplit[2];
  
  $.ajax({
    type: "POST",
    url: "ajax_RegistrarHistoricoMovPorPlantilla.php", 
    data: {"idPlantillaSeleccionada":idPlantillaSeleccionada,"PuntoServicioSeleccionado":PuntoServicioSeleccionado,"EntidadEmp":EntidadEmp,"CategoriaEmp":CategoriaEmp,"TipoEmp":TipoEmp,"TipoMovimiento":TipoMovimiento},
    dataType: "json",
    async:false,
    success: function(response) {
      if (response.status != "success")
      {   
      }else{
        alert(response.message);
      }
    },error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}




</script>