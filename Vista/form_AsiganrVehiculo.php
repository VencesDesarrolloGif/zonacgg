<?php

$catalogoEntidades = $negocio->negocio_obtenerListaEntidadesFeferativas();
$catalogoClientes  = $negocio->negocio_obtenerListaClientesActivos();
 $catalogoLineaNegocioRegistroPunto                = $negocio->negocio_obtenerListaLineaNegocio();
?>
<form class="form-horizontal"  method="post" id="form_AsignacionParqueVehicular" name="form_AsignacionParqueVehicular" action="" target="_blank">
  <div id="mensajeerrorasignacionvehiculo"></div>
  <div align="center">
    <fieldset >
      <legend>Asignaciones Del Parque Vehicular</legend>
    </fieldset>
    <div>
      <input id="ocultonumeropeticiontabla" name="ocultonumeropeticiontabla" type="hidden" class="input-medium" readonly>
      <input id="ocultoidentidadempleado" name="ocultoidentidadempleado" type="hidden" class="input-medium" readonly>
      <input id="ocultocaso" name="ocultocaso" type="hidden" class="input-medium" readonly>
      <input id="CuentaConGif" name="CuentaConGif" type="hidden" class="input-medium" readonly>
      <a id="todoslosvehiculos" onclick="MostrarTablaVehiculos(1);" data-toggle="tab" style="cursor: pointer;display: none;">TODOS LOS VEHICULOS</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
      <a id="vehiculosconasignacion" onclick="MostrarTablaVehiculos(2);" data-toggle="tab" style="cursor: pointer;display: none;">VEHICULOS CON ASIGNACIÓN</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
      <a id="vehiculossinasignacion" onclick="MostrarTablaVehiculos(3);" data-toggle="tab" style="cursor: pointer;display: none;">VEHICULOS SIN ASIGNACIÓN</a>
    </div>
    <div class="modal-header">
      <h4 class="modal-title" id="MosttrarTituloVehiculos1" style="display: none;">TODOS LOS VEHICULOS</h4>
      <h4 class="modal-title" id="MosttrarTituloVehiculos2" style="display: none;">VEHICULOS CON ASIGNACIÓN</h4>
      <h4 class="modal-title" id="MosttrarTituloVehiculos3" style="display: none;">VEHICULOS SIN ASIGNACIÓN</h4>
    </div>
  </div>

  <div id="modalasignarvehiculo" name="modalasignarvehiculo" class="modalEdit hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
     <div id="mensajeerrorModalasignacionvehiculo"></div>
    <div id="alertMsgReactivacion">
    </div>
    <div class="modal-header">
      <h4 class="modal-title" id="myModalLabel"> <img src="img/warning.png">ASIGNACIÓN DE VEHICULO!!</h4>
    </div>
    <div class="input-prepend">
      <span  class="add-on" style="margin-top: 3%; margin-left: -10%;">¿La Asignación Será Para Un Empleado Dado De Alta En Gif?</span>
    <div class="material-switch pull-right" align="left" >
      <span  class="add-on">NO  SI</span><br><br>
        <input class="input-large" id="PerteneceAlaEmpresa" name="PerteneceAlaEmpresa" type="checkbox">        
        <label for="PerteneceAlaEmpresa" class="label-success1"></label>
    </div>
  </div>
    <div class="modal-body">
  
      <div class="input-prepend">
        <span class="add-on">N° Economico Vehiculo</span>
        <input id="inpNumroEcoVehiculo" name="inpNumroEcoVehiculo" type="text" class="input-small" readonly>
        <span class="add-on">N° De Placas Del Vehiculo</span>
        <input id="inpNumeroPlacas" name="inpNumeroPlacas" type="text" class="input-medium" readonly>
      </div><br>
  
      <div class="input-prepend">
        <span class="add-on">Digite El Número De Empleado</span>
        <input id="inpNumeroEmpleado" name="inpNumeroEmpleado" type="text" class="input-large" onblur="verificarEmpleadoAsignacion();" placeholder="00-0000-00">
      </div><br>
      <div class="input-prepend">
        <span class="add-on">Kilometraje Del Vehiculo</span>
        <input id="Kilometraje" name="Kilometraje" type="text" class="input-small">
        <span class="add-on" id="motivoasignacion" style="display: none;">Motivo De Asignación</span>
        <span class="add-on" id="spmmotivocambio" style="display: none;">Motivo De Cambio</span>
        <input id="motivocambio" name="motivocambio" type="text" class="input-large" >
      </div>
      <div class="input-prepend">
        <span class="add-on">Nombre</span>
        <input id="NombreEmpleado" name="NombreEmpleado" type="text" class="input-medium" readonly>
        <span class="add-on">Apellido P</span>
        <input id="ApellidoPEmpleado" name="ApellidoPEmpleado" type="text" class="input-medium" readonly>
        <span class="add-on">Apellido M</span>
        <input id="ApellidoMEmpleado" name="ApellidoMEmpleado" type="text" class="input-medium" readonly>
      </div>
      <div class="input-prepend">
        <span class="add-on">Puesto</span>
        <input id="PuestoEmpleado" name="PuestoEmpleado" type="text" class="input-medium" readonly>
        <span class="add-on">Entidad Federativa</span>
        <input id="EntidadFEmpleado" name="EntidadFEmpleado" type="text" class="input-medium" readonly>
        <span class="add-on">N° Licencia</span>
        <input id="LicenciaEmpleado" name="LicenciaEmpleado" type="text" class="input-medium" readonly>
      </div><br>
      <div class="input-prepend">
        <span class="add-on">Estatus</span>
        <input id="EstatusEmpleado" name="EstatusEmpleado" type="text" class="input-medium" readonly>
      </div>

  
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" onclick='limpiarModalAsignacion();' data-dismiss="modal">Cancelar</button>
      <button type="button" class="btn btn-primary" onclick='validarModal();'>Asignar Vehiculo</button>
    </div>
  </div>  <!-- FIN MODAL reactivacion punto de servicio-->
</form>

<div class="containerTablePuntos" align="center" id="divtabla" style="display: none;">
        <section>

            <table id="tableVehiculos" class="display" cellspacing="0" width="150%">
                <thead>
                    <tr>
                        <th>N° ECONOMICO</th>
                        <th>LINEA NEGOCIO</th>
                        <th>N° PLACAS</th>
                        <th>MARCA</th>
                        <th>MODELO</th>
                        <th>COLOR</th>
                        <th>AÑO</th>
                        <th>CILINDRADA</th>
                        <th>ESTATUS DEL VEHICULO</th>
                        <th>ACCIÓN A REALIZAR</th>
                        <th>EMPLEADO ASIGNADO</th>
                        <th>ENTIDAD ASIGNADA DEL VEHICULO</th>
                        </tr>
                </thead>
                <tbody></tbody>
            </table>
        </section>
</div>

<script type="text/javascript">

var tablavehiculoscalulo = null;
var rolUsuario="<?php echo $usuario['rol']; ?>";

$(inicioAsignarVehiculo());  

function inicioAsignarVehiculo(){
  if(rolUsuario=="Control Vehicular"){
     mostraropcioestabla();
    }
}


function mostraropcioestabla(){
  $("#todoslosvehiculos").show();
  $("#vehiculosconasignacion").show();
  $("#vehiculossinasignacion").show();
}
function MostrarTablaVehiculos(casoVehiculo) {
  $("#divtabla").hide();
//alert(casoVehiculo);
  $("#ocultonumeropeticiontabla").val(casoVehiculo);
  if(casoVehiculo==1){
    $("#MosttrarTituloVehiculos1").show();
    $("#MosttrarTituloVehiculos2").hide();
    $("#MosttrarTituloVehiculos3").hide();
  }if(casoVehiculo==2){
    $("#MosttrarTituloVehiculos2").show();
    $("#MosttrarTituloVehiculos1").hide();
    $("#MosttrarTituloVehiculos3").hide();
  }if(casoVehiculo==3){
    $("#MosttrarTituloVehiculos3").show();
    $("#MosttrarTituloVehiculos2").hide();
    $("#MosttrarTituloVehiculos1").hide();
  }
     tablaVehiculos = [];
     $.ajax({
         type: "POST",
         url: "ajax_obtenerVehiculosTabla.php",
         data:{"casoVehiculo": casoVehiculo},
         dataType: "json",
         success: function(response) {
             if (response.status == "success") {

             // console.log(response);
                 for (var i = 0; i < response.data.length; i++) {
                     var record = response.data[i];
                     
                     tablaVehiculos.push(record);
                 }
                 loadDatatoblevehiculos(tablaVehiculos);

             } else {
                 var mensaje = response.message;
                 alert("mal");
             }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }


 function loadDatatoblevehiculos(data) {
     if (tablavehiculoscalulo != null) {
         tablavehiculoscalulo.destroy();
     }
     tablavehiculoscalulo = $('#tableVehiculos').DataTable({
         "language": {
             "emptyTable": "No hay registro disponible",
             "info": "Del _START_ al _END_ de _TOTAL_",
             "infoEmpty": "Mostrando 0 registros de un total de 0.",
             "infoFiltered": "(filtrados de un total de _MAX_ registros)",
             "infoPostFix": "(actualizados)",
             "lengthMenu": "Mostrar _MENU_ registros",
             "loadingRecords": "Cargando....",
             "processing": "Procesando....",
             "search": "Buscar:",
             "searchPlaceholder": "Dato para buscar",
             "zeroRecords": "no se han encontrado coincidencias",
             "paginate": {
                 "first": "Primera",
                 "last": "Ultima",
                 "next": "Siguiente",
                 "previous": "Anterior"
             },
             "aria": {
                 "sortAscending": "Ordenación ascendente",
                 "sortDescending": "Ordenación descendente"
             }
         },
         data: data,
         destroy: true
      ,"columns": [
       { "data": "idvehiculo"}
      ,{ "data": "LineaNegocio"}
      ,{ "data": "numeroplacas"}
      ,{ "data": "Marca"}
      ,{ "data": "Modelo"}
      ,{ "data": "ColorVehiculo"}
      ,{ "data": "anioVehuiculo"}
      ,{ "data": "celindradas"}
      ,{ "data": "EstatusVehiculo"}
      ,{ "data": "Asignacion"}
      ,{ "data": "NumeroEmpleado"}
      ,{ "data": "nombreEntidadF"}
      ],
         // ]
         //,serverSide: true
         processing: true,
         dom: 'Bfrtip',
         buttons: ['excel',{orientation:'landscape',extend:'pdf',pageSize:'LEGAL'}]
     });
$("#divtabla").show();
 }

function modalAsignarEmpleado(numeroeconomico,placas,casoo){
   if($('#PerteneceAlaEmpresa').is(":checked")) {

    $("#inpNumeroEmpleado").prop('readonly', false);
    $("#NombreEmpleado").prop('readonly', true);
    $("#ApellidoPEmpleado").prop('readonly', true);
    $("#ApellidoMEmpleado").prop('readonly', true);
    $("#EntidadFEmpleado").prop('readonly', true);
    $("#LicenciaEmpleado").prop('readonly', true);
    $("#inpNumeroEmpleado").val("");

    $("#PuestoEmpleado").val("");
    $("#EstatusEmpleado").val("");
    
  }else{

    $("#inpNumeroEmpleado").prop('readonly', true);
    $("#NombreEmpleado").prop('readonly', false);
    $("#ApellidoPEmpleado").prop('readonly', false);
    $("#ApellidoMEmpleado").prop('readonly', false);
    $("#EntidadFEmpleado").prop('readonly', false);
    $("#LicenciaEmpleado").prop('readonly', false);
    $("#PuestoEmpleado").val("No Asignado");
    $("#EstatusEmpleado").val("No Asignado"); 
    
  }
  if(casoo==1){
    $("#motivoasignacion").show();
    $("#spmmotivocambio").hide();
  }else{
    $("#spmmotivocambio").show();
    $("#motivoasignacion").hide();
  }
  $("#ocultocaso").val(casoo);
  $("#inpNumroEcoVehiculo").val(numeroeconomico);
  $("#inpNumeroPlacas").val(placas);
  $("#modalasignarvehiculo").modal();
}



$('#PerteneceAlaEmpresa').change(function() {
  if($('#PerteneceAlaEmpresa').is(":checked")) {
    $("#NombreEmpleado").val("");
    $("#ApellidoPEmpleado").val("");
    $("#ApellidoMEmpleado").val("");
    $("#EntidadFEmpleado").val("");
    $("#LicenciaEmpleado").val("");
    $("#Kilometraje").val("");
    $("#motivocambio").val("");
    $("#inpNumeroEmpleado").val("");
    $("#inpNumeroEmpleado").prop('readonly', false);
    $("#NombreEmpleado").prop('readonly', true);
    $("#ApellidoPEmpleado").prop('readonly', true);
    $("#ApellidoMEmpleado").prop('readonly', true);
    $("#EntidadFEmpleado").prop('readonly', true);
    $("#LicenciaEmpleado").prop('readonly', true);
    $("#PuestoEmpleado").val("");
    $("#EstatusEmpleado").val("");
  }else{ 
    $("#NombreEmpleado").val("");
    $("#ApellidoPEmpleado").val("");
    $("#ApellidoMEmpleado").val("");
    $("#EntidadFEmpleado").val("");
    $("#LicenciaEmpleado").val("");
    $("#Kilometraje").val("");
    $("#motivocambio").val("");
    $("#inpNumeroEmpleado").val("");
    $("#inpNumeroEmpleado").prop('readonly', true);
    $("#NombreEmpleado").prop('readonly', false);
    $("#ApellidoPEmpleado").prop('readonly', false);
    $("#ApellidoMEmpleado").prop('readonly', false);
    $("#EntidadFEmpleado").prop('readonly', false);
    $("#LicenciaEmpleado").prop('readonly', false);
    $("#PuestoEmpleado").val("No Asignado");
    $("#EstatusEmpleado").val("No Asignado");
  }
});

function verificarEmpleadoAsignacion()
{
  var inpNumeroEmpleado = $("#inpNumeroEmpleado").val ();
  var expreg2 = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
   var expreg3 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;

   //alert(txtSearch.length);

  if (inpNumeroEmpleado.length != 10 && inpNumeroEmpleado.length != 11)
    { 
        return;
    }

  if(expreg2.test(inpNumeroEmpleado) || expreg3.test(inpNumeroEmpleado))
  {
    var numeroEmpleadoAsignacion = $("#inpNumeroEmpleado").val();
    ConsultarEmpleadoAsignacion(numeroEmpleadoAsignacion);
  }else{
  }
}


function ConsultarEmpleadoAsignacion (numeroEmpleadoAsignacion)
{
  $("#NombreEmpleado").val("");
  $("#ApellidoPEmpleado").val("");
  $("#ApellidoMEmpleado").val("");
  $("#PuestoEmpleado").val("");
  $("#EntidadFEmpleado").val("");
  $("#LicenciaEmpleado").val("");
  $("#EstatusEmpleado").val("");
  $("#Kilometraje").val("");
  $("#motivocambio").val("");
  $("#CuentaConGif").val("");

  var numeroEmpleadoAsignacion1 = numeroEmpleadoAsignacion;
  $.ajax({
    type: "POST",
    url: "ajax_obtenerEmpleadoPorId.php",
    data:{"numeroEmpleado":numeroEmpleadoAsignacion1},
    dataType: "json",
    success: function(empleado) {

      var verificacion=empleado.empleado;
      if(verificacion==""){
        cargaerroresModalAsignacion("El Empleado Ingresado No Existe!!");
      }else{
      $("#NombreEmpleado").val(empleado.empleado[0].nombreEmpleado);
      $("#ApellidoPEmpleado").val(empleado.empleado[0].apellidoPaterno);
      $("#ApellidoMEmpleado").val(empleado.empleado[0].apellidoMaterno);
      $("#PuestoEmpleado").val(empleado.empleado[0].descripcionPuesto);
      $("#EntidadFEmpleado").val(empleado.empleado[0].nombreEntidadFederativa);
      $("#EstatusEmpleado").val(empleado.empleado[0].descripcionEstatusEmpleado);
      $("#ocultoidentidadempleado").val(empleado.empleado[0].idEntidadTrabajo);
      var licencia = empleado.empleado[0].numlicencia
      if(licencia!=null && licencia!=""){
        $("#LicenciaEmpleado").val(licencia);
      }else{
        $("#LicenciaEmpleado").val("Sin Licencia");
      }
}
    },
    error: function(jqXHR, textStatus, errorThrown) {
    //  alert("adios2");
    alert(jqXHR.responseText);
    }       
  }); 
}

function validarModal(){ 
  var inpNumeroEmpleado=$("#inpNumeroEmpleado").val();
  var EstatusEmpleado1=$("#EstatusEmpleado").val();
  var licencia1 = $("#LicenciaEmpleado").val();
  var Kilometraje= $("#Kilometraje").val();
  var motivocambio = $("#motivocambio").val();
  var NombreEmpleado =$("#NombreEmpleado").val();
  var ApellidoPEmpleado =$("#ApellidoPEmpleado").val();
  var ApellidoMEmpleado =$("#ApellidoMEmpleado").val();
  var EntidadFEmpleado =$("#EntidadFEmpleado").val();
  var LicenciaEmpleado =$("#LicenciaEmpleado").val();
  var ingresoreingreso = $("#ocultocaso").val();

  if($('#PerteneceAlaEmpresa').is(":checked")){
    $("#CuentaConGif").val("si");
    if(inpNumeroEmpleado==""){
      cargaerroresModalAsignacion("Ingrese El Numero Del Empleado A Asignar(00-0000-00)");
    }else if(Kilometraje== "" || !/^([0-9])*$/.test(Kilometraje)){
      cargaerroresModalAsignacion("Ingrese El Kilometraje Del Vehiculo(Solo Numeros sin Puntos)");
    }else if(motivocambio==""){
      cargaerroresModalAsignacion("Ingrese El Motivo Del Cambio Del Vehiculo");
    }else if(licencia1=="Sin Licencia"){
      cargaerroresModalAsignacion("No Es Posible Asignar Un Vehiculo A Un Elemento Que No Tiene Licencia");
    }else if(EstatusEmpleado1!="ACTIVO" && EstatusEmpleado1!="REINGRESO"){
      cargaerroresModalAsignacion("No Es Posible Asignar Un Vehiculo A Un Elemento Que No Está Activo");
      $("#inpNumeroEmpleado").val("");
      $("#NombreEmpleado").val("");
      $("#ApellidoPEmpleado").val("");
      $("#ApellidoMEmpleado").val("");
      $("#PuestoEmpleado").val("");
      $("#EntidadFEmpleado").val("");
      $("#LicenciaEmpleado").val("");
      $("#EstatusEmpleado").val("");
      $("#Kilometraje").val("");
      $("#motivocambio").val("");
    }else{
      if(ingresoreingreso==1){
        asignarvehiculoaempleado();
      }else{
        InsertarEnHistoricoo();
      }
    }
  }else{
    $("#CuentaConGif").val("No");
    if(Kilometraje== "" || !/^([0-9])*$/.test(Kilometraje))
    {
      cargaerroresModalAsignacion("Ingrese El Kilometraje Del Vehiculo(Solo Numeros sin Puntos)");
    }else if(motivocambio==""){
      cargaerroresModalAsignacion("Ingrese El Motivo Del Cambio Del Vehiculo");
    }else if(NombreEmpleado=="Sin Licencia" || NombreEmpleado=="" || !/^([A-Z-a-z])*$/.test(NombreEmpleado)){
      cargaerroresModalAsignacion("Ingrese El Nombre Del Resaponsable (Solo Letras)");
    }else if(ApellidoPEmpleado=="" || !/^([A-Z-a-z])*$/.test(ApellidoPEmpleado)){
      cargaerroresModalAsignacion("Ingrese El Apellido Paterno Del Resaponsable (Solo Letras)");
    }else if(ApellidoMEmpleado=="" || !/^([A-Z-a-z])*$/.test(ApellidoMEmpleado)){
      cargaerroresModalAsignacion("Ingrese El Apellido Materno Del Resaponsable (Solo Letras)");
    }else if(EntidadFEmpleado==""){
      cargaerroresModalAsignacion("Ingrese La Entidad Del Resaponsable (Solo Letras)");
    }else if(LicenciaEmpleado=="Sin Licencia" || LicenciaEmpleado==""){
      cargaerroresModalAsignacion("No Es Posible Asignar Un Vehiculo A Un Elemento Que No Tiene Licencia");
    }else{
      if(ingresoreingreso==1){ 
        asignarvehiculoaempleado();
      }else{
        InsertarEnHistoricoo();
      }
    }

  }
}
function InsertarEnHistoricoo(){
  var numeroeconomico = $("#inpNumroEcoVehiculo").val();
  var CuentaConGifHistorico = $("#CuentaConGif").val();
  $.ajax({
            type: "POST",
            url: "ajax_InsertarHistoricoReasignaciones.php",
            data: {"numeroeconomico": numeroeconomico,"CuentaConGifHistorico": CuentaConGifHistorico},
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {
                 // alert("Historico Insertado");
                   Reasignarvehiculoaempleado();
                } else if (response.status=="error")
                {
                  alert("Algo ha salido mal");
                }
              },error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
        });
}
function Reasignarvehiculoaempleado(){
  var datastring = $("#form_AsignacionParqueVehicular").serialize();
  $.ajax({
            type: "POST",
            url: "ajax_RegistrarReasignacionVehiculo.php",
            data: datastring,
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {
                   $('#MsjAsignacion').fadeIn('slow');
                  MsjAsignacion1="<div id='MsjAsignacion' class='alert alert-success'><trong>Reasignacion:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                  $("#alertMsg").html(MsjAsignacion1);
                  $(document).scrollTop(0);
                  $('#MsjAsignacion').delay(3000).fadeOut('slow');
                  limpiarModalAsignacion();
                } else if (response.status=="error")
                {
                  //waitingDialog.hide();
                  MsjAsignacion1="<div id='MsjAsignacion' class='alert alert-error'><strong>Error En El Registro De La Asignacion Del Vehiculo</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#alertMsg").html(MsjAsignacion1);
                    $(document).scrollTop(0);
                    $('#MsjAsignacion').delay(3000).fadeOut('slow');
                }
              },error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
        });
}

function asignarvehiculoaempleado(){
   var datastring = $("#form_AsignacionParqueVehicular").serialize();
  $.ajax({
            type: "POST",
            url: "ajax_RegistrarAsignacionVehiculo.php",
            data: datastring,
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {
                  MsjAsignacion1="<div id='MsjAsignacion' class='alert alert-success'><trong>Asignacion:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                  $("#alertMsg").html(MsjAsignacion1);
                  $(document).scrollTop(0);
                  $('#MsjAsignacion').delay(3000).fadeOut('slow');
                  limpiarModalAsignacion();
                } else if (response.status=="error")
                {
                  //waitingDialog.hide();
                  MsjAsignacion1="<div id='MsjAsignacion' class='alert alert-error'><strong>Error En El Registro De La Asignacion Del Vehiculo</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#alertMsg").html(MsjAsignacion1);
                    $(document).scrollTop(0);
                    $('#MsjAsignacion').delay(3000).fadeOut('slow');
                }
              },error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
        });
}
  function limpiarModalAsignacion(){
    var casotabla = $("#ocultonumeropeticiontabla").val();
    $("#modalasignarvehiculo").modal("hide");
    $("#inpNumeroEmpleado").val("");
    $("#NombreEmpleado").val("");
    $("#ApellidoPEmpleado").val("");
    $("#ApellidoMEmpleado").val("");
    $("#PuestoEmpleado").val("");
    $("#EntidadFEmpleado").val("");
    $("#LicenciaEmpleado").val("");
    $("#EstatusEmpleado").val("");
    $("#Kilometraje").val("");
    $("#motivocambio").val("");
    $("#CuentaConGif").val("");
    MostrarTablaVehiculos(casotabla);
  }
  function cargaerroresModalAsignacion(mensaje){
  $('#mensajeerrorModalasignacionvehiculo').fadeIn('slow');
  alerterror="<div class='alert alert-error' id='mensajeerrorModalasignacionvehiculo'>"+mensaje+"<data-dismiss='alert'>";
  $("#mensajeerrorModalasignacionvehiculo").html(alerterror);
  $('#mensajeerrorModalasignacionvehiculo').delay(3000).fadeOut('slow');
  $(document).scrollTop(0);
}



  </script>
