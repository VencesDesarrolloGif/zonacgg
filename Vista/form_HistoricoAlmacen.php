<center><h3>Historico Almacén</h3></center>
<br>
<div id="divMsjEmpHisAlm"></div>
<!-- <img id="btnActualizarHisAlm" src="img\Actualizar1.JPG" onclick="consultaHistoricoAlmacen(1);" style="width: 2%; display: none;" title="Actualizar"> -->
<!-- <img id="btnActualizarHisAlmOper" src="img\Actualizar1.JPG" onclick="consultaHistoricoAlmacen(2);" style="width: 2%; display: none;" title="Actualizar"> -->
<br> 
<br> 
<center>
   <select name="seleccionarTipoEmpHisA" id="seleccionarTipoEmpHisA">
           <option value="0">TIPO</option>
           <option value="1">ADMINISTRATIVOS</option>
           <option value="2">OPERATIVOS</option>
           <option value="3">POR EMPLEADO</option>
           
    </select>


    <select name="seleccionarEstatusEmpHisA" id="seleccionarEstatusEmpHisA" style="display:none;">
           <option value="3">ESTATUS</option>
           <option value="0">BAJAS</option>
           <option value="1">ACTIVOS</option>
           <option value="2">TODOS</option>
    </select>
<br>
    <div id='divRangoFechasHA' style="display:none;">
        <span>DE:</span><input type="date" id="fechaconsultaInicial">
        <span>A:</span><input type="date" id="fechaconsultaFin">
    <br>
    <button id='buscarHA' type="success" onclick="consultaHistoricoAlmacen();" style="display:none;">Buscar</button>
    </div>
    <br>
  <div id="divInpNoEmpHisAlm" style="display: none;">
    <td><label class="control-label label " for="EmpHisAlm">No. de Empleado</label> </td>          
    <td><input type="text" name="EmpHisAlm" id="EmpHisAlm" placeholder="Buscar  (00-0000-00)" aria-describedby="basic-addon2" onkeyup="validacionEmpHisAlm();"><img src="img/search.png"></td>
  </div>
</center>
<div id="DivTablaHisAlm">
    <table id="tablaHistoricoAlm"  class="records_list table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="display: none;">
        <thead>
            <tr>
                <th style="text-align: center;background-color: #B0E76E">Número empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                <th style="text-align: center;background-color: #B0E76E">Fecha de ingreso</th> 
                <th style="text-align: center;background-color: #B0E76E">fecha baja</th>
                <th style="text-align: center;background-color: #B0E76E">Fecha Asignación</th> 
                <th style="text-align: center;background-color: #B0E76E">Uniforme</th> 
                <th style="text-align: center;background-color: #B0E76E">Cantidad</th> 
                <th style="text-align: center;background-color: #B0E76E">Estatus de Uniforme Recibido</th> 
                <th style="text-align: center;background-color: #B0E76E">Entidad Recepcion</th> 
                <th style="text-align: center;background-color: #B0E76E">Fecha Recepción</th> 
                <th style="text-align: center;background-color: #B0E76E">Movimiento</th>  
                <th style="text-align: center;background-color: #B0E76E">Permanencia del Empleado</th>
            </tr>
        </thead>
    </table>
</div>

<div id="DivTablaHisEmpAlm">
    <table id="tablaHistoricoEmpAlm"  class="records_list table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="display: none;">
        <thead>
            <tr>
                <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                <th style="text-align: center;background-color: #B0E76E">Fecha de ingreso</th> 
                <th style="text-align: center;background-color: #B0E76E">Fecha baja</th>
                <th style="text-align: center;background-color: #B0E76E">Permanencia del Empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Entidad de trabajo</th>  
                <th style="text-align: center;background-color: #B0E76E">Id de Orden</th>  
                <th style="text-align: center;background-color: #B0E76E">Fecha de Asignacion</th>
                <th style="text-align: center;background-color: #B0E76E">Cantidad de Uniformes</th>
                <th style="text-align: center;background-color: #B0E76E">Tipo</th>
                <th style="text-align: center;background-color: #B0E76E">Historial Uniformes</th>
            </tr>
        </thead>
    </table>
</div>
<script type="text/javascript"> 

function cargarmsjHisAlm(mensaje){
  $('#divMsjEmpHisAlm').fadeIn('slow');
  mensajeErrorP="<div id='msgAlert' class='alert alert-error'><strong>Error:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
  $("#divMsjEmpHisAlm").html(mensajeErrorP);
  $(document).scrollTop(0);
  $('#divMsjEmpHisAlm').delay(3000).fadeOut('slow');
}

$("#seleccionarTipoEmpHisA").change(function(){
   $("#tablaHistoricoEmpAlm").hide();
   $("#DivTablaHisEmpAlm").hide();
   $("#DivTablaHisAlm").hide();
   $("#seleccionarEstatusEmpHisA").val(3);
   var tipo = $("#seleccionarTipoEmpHisA").val();

   if(tipo==1 || tipo==2){
        $("#seleccionarEstatusEmpHisA").show();
        $("#divInpNoEmpHisAlm").hide();
        $("#divRangoFechasHA").show();
        $("#buscarHA").show();
   }else{
        $("#divInpNoEmpHisAlm").show();
        $("#seleccionarEstatusEmpHisA").hide();
        $("#divRangoFechasHA").hide();
   }
});

$("#seleccionarEstatusEmpHisA").change(function(){

   
    /*else{
        consultaHistoricoAlmacen();   
    }*/

});


 function consultaHistoricoAlmacen() { 

    var tipo = $("#seleccionarTipoEmpHisA").val();
    var estatusEmpleado = $("#seleccionarEstatusEmpHisA").val();

        var fechaconsultaInicial =$("#fechaconsultaInicial").val();
        var fechaconsultaFin =$("#fechaconsultaFin").val();
    if(tipo==1 || tipo==2){

        if(fechaconsultaInicial=='' || fechaconsultaInicial==null || fechaconsultaInicial=='NULL' || fechaconsultaInicial=='null'){
           swal("Alto", "Seleccione la fecha inicial","error");
           return;
        }
        if(fechaconsultaFin=='' || fechaconsultaFin==null || fechaconsultaFin=='NULL' || fechaconsultaFin=='null'){
           swal("Alto", "Seleccione la fecha final","error");
           return;
        }
    }

     $("#tablaHistoricoEmpAlm").hide();
    $("#DivTablaHisEmpAlm").hide();
    $("#DivTablaHisAlm").hide();
    var tipo = $("#seleccionarTipoEmpHisA").val();
    var estatusEmpleado = $("#seleccionarEstatusEmpHisA").val();
    
    /*if(tipo==0){
       alert("Por favor elija un tipo de empleado");
       $("#seleccionarEstatusEmpHisA").hide();
       $("#DivTablaHisAlm").hide();
       $("#tablaHistoricoAlm").hide();
       $("#btnActualizarHisAlm").hide();
       $("#btnActualizarHisAlmOper").hide();
       $("#divInpNoEmpHisAlm").hide();
    }else */
    if(tipo==1 ){//ADM
        $("#seleccionarEstatusEmpHisA").show();
        $("#DivTablaHisAlm").show();
        $("#tablaHistoricoAlm").show();
        $("#btnActualizarHisAlm").show();
        $("#btnActualizarHisAlmOper").hide();
        $("#divInpNoEmpHisAlm").hide();    
    }else if(tipo==2){//OP
        $("#divRangoFechasHA").show();
        $("#seleccionarEstatusEmpHisA").show();
        // consultaHistoricoAlmacen(tipo,estatusEmpleado);
        $("#DivTablaHisAlm").show();
        $("#tablaHistoricoAlm").show();
        $("#btnActualizarHisAlm").hide();
        $("#btnActualizarHisAlmOper").show();
        $("#divInpNoEmpHisAlm").hide();
    }else if(tipo==3){//POR EMP
            $("#buscarHA").hide();
            $("#divRangoFechasHA").hide();
            $("#seleccionarEstatusEmpHisA").hide();
            $("#DivTablaHisAlm").hide();
            $("#tablaHistoricoAlm").hide();
            $("#btnActualizarHisAlm").hide();
            $("#btnActualizarHisAlmOper").hide();
            $("#divInpNoEmpHisAlm").show();
    }
    if(estatusEmpleado==3){
       swal("Alto", "Seleccione el estatus de los empleados","error");
       return;
    }

    waitingDialog.show(); 
     tablehistoricoAlmacen = [];
     $.ajax({
         type: "POST",
         url: "ajax_HistoricoAlmacen.php",
         data:{"tipo":tipo,"estatusEmpleado":estatusEmpleado,"fechaconsultaInicial":fechaconsultaInicial,"fechaconsultaFin":fechaconsultaFin},
         dataType: "json", 
         success: function(response) {
             if (response.status == "success") {
                waitingDialog.hide();

                 for (var i = 0; i < response.datos.length; i++) {

                    var fechaIngresoEmpleado = response.datos[i]["fechaIngresoEmpleado"];
                    var fechaBajaEmpleado1 = response.datos[i]["fechaBajaEmpleado1"];
                    var fechaHoy = new Date();
                    var fechaActual=(fechaHoy.getFullYear() + "-" + (fechaHoy.getMonth() +1) + "-" + fechaHoy.getDate());
                  if(fechaBajaEmpleado1 == 0){
                     var fechaBajaEmpleado1 = fechaActual;
                    }else{
                          var fechaBajaEmpleado1 = response.datos[i]["fechaBajaEmpleado"];
                         }
                         console.log(fechaIngresoEmpleado);
                         console.log(fechaBajaEmpleado1);

                  var diaInicio = new Date(fechaIngresoEmpleado);
                  var diaFin = new Date(fechaBajaEmpleado1);
                  var difference= Math.abs(diaFin-diaInicio);
                  var LargoFecha1 = difference/86400000;
                  var diasDePermanencia = Math.round(LargoFecha1);

                  response.datos[i]["diasDePermanencia"] = diasDePermanencia;

                     var record = response.datos[i];
                     tablehistoricoAlmacen.push(record);
                 }
                 loadDataInTableHistoricoAlmacen(tablehistoricoAlmacen);
             } else {
                    waitingDialog.hide();
                    var mensaje = response.message;
                // console.log("mal");
             }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }
 var tableHisAlm = null;

 function loadDataInTableHistoricoAlmacen(data) {
     if (tableHisAlm != null) {
         tableHisAlm.destroy();
     }
     tableHisAlm = $('#tablaHistoricoAlm').DataTable({
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
         destroy: true,
         "columns": [
         {   
             "data": "numeroEmpleado"
         }, 
         {   
             "data": "nombreEmpleado"
         }, 
         {   "className": "dt-body-center",
             "data": "fechaIngresoEmpleado"
         }, 
         {   "className": "dt-body-center",
             "data": "fechaBajaEmpleado"
         }, 
         {   
             "data": "fechaAsignacionHis"
         }, 
         {   "className": "dt-body-center",
             "data": "descripcionTipo" 
         }, 
         {  "className": "dt-body-center",
             "data": "cantidadUniformeHis"
         },  
         {   
             "data": "estatusUniformeRecibido"
         },
         {   "className": "dt-body-center",
             "data": "entidadRecepcionHis"
         },
         {   "className": "dt-body-center",
             "data": "fechaRecibidoHis"
         },
         {   "className": "dt-body-center",
             "data": "tipoMovimiento"
         },
         {   "className": "dt-body-center",
             "data": "diasDePermanencia"
         }, ],
         processing: true,
         dom: 'Bfrtip',
         buttons:{
                  buttons: ['excel']
                 }
     });
 }


function validacionEmpHisAlm(){
 var EmpHisAlm = $("#EmpHisAlm").val ();
 var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
 var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;
 
 if(expreg.test(EmpHisAlm) || expreg1.test(EmpHisAlm)){
    var numeroEmpleado = $("#EmpHisAlm").val();    
    consultaEmpleadoHisAlm(numeroEmpleado);
   }
}

function consultaEmpleadoHisAlm (numeroEmpleado){
    tablehistoricoEmpAlmacen = [];
    //alert("entre");
    var numeroEmpleado1 = numeroEmpleado;
    var mansaje="";
    $.ajax({
        type: "POST",
        url: "ajax_obtenerInfoXEmpID.php",
        data:{"numeroEmpleado":numeroEmpleado1},
        dataType: "json",
        async: false,
        success: function(response) {
            $("#DivTablaHisEmpAlm").show();
            $("#tablaHistoricoEmpAlm").show();
            var empleadoEncontrado = response.empleado[0];
            var ordenesXemp = response.ordenes;
            if (response.status == "success"){
                if(empleadoEncontrado.length == 0){
                    mansaje ="No existe Número de empleado";
                    cargarmsjHisAlm(mansaje);
                }else{ 
                    empleadoEncontrado1 = [];
                    var Bandera = "0";
                    for (var i = 0; i < ordenesXemp.length; i++) {
                        empleadoEncontrado1[i]=new Array();
                        var ordenID1 = ordenesXemp[i]["ordenID"];
                        var fechaAsignacionHis = ordenesXemp[i]["fechaAsignacionHis"];
                        var tipoMovimiento = ordenesXemp[i]["tipoMovimiento"];
                        var nnombreEncargado = ordenesXemp[i]["NombreEncargado"];
                        var nombreEmpleadosE = nnombreEncargado.replace(/\s+/g, '-');
                        //alert(nombreEmpleadosE);
                        var FirmaEncargado = ordenesXemp[i]["FirmaEncargado"];
                        var cantidadAsignados = ordenesXemp[i]["cantidadAsignados"];
                        var idEntidadTrabajo = empleadoEncontrado["idEntidadTrabajo"];
                        var fechaIngresoEmpleado = empleadoEncontrado["fechaIngresoEmpleado"];
                        var fechaBajaEmpleado = empleadoEncontrado["fechaBajaEmpleado"];
                        var nombreEmpleado = empleadoEncontrado["nombreEmpleado"];
                        var apellidoPaterno = empleadoEncontrado["apellidoPaterno"];
                        var apellidoMaterno = empleadoEncontrado["apellidoMaterno"];
                        var empleadoEntidad = empleadoEncontrado["entidadFederativaId"];
                        var empleadoConsecutivo = empleadoEncontrado["empleadoConsecutivoId"];
                        var empleadoCategoria = empleadoEncontrado["empleadoCategoriaId"];
                        var fechaHoy = new Date();
                        var fechaActual=(fechaHoy.getFullYear() + "-" + (fechaHoy.getMonth() +1) + "-" + fechaHoy.getDate());
                        if(fechaBajaEmpleado == "" || fechaBajaEmpleado == "NULL" || fechaBajaEmpleado == "null" || fechaBajaEmpleado == null || fechaBajaEmpleado == "0000-00-00"){
                            var fechaBajaEmpleado = fechaActual;
                            empleadoEncontrado1[i]["fechaBajaEmpleado"]="-";
                        }else{
                              var fechaBajaEmpleado = empleadoEncontrado["fechaBajaEmpleado"];
                              empleadoEncontrado1[i]["fechaBajaEmpleado"]=fechaBajaEmpleado;
                             }
                        var diaInicio = new Date(fechaIngresoEmpleado);
                        var diaFin = new Date(fechaBajaEmpleado);
                        var difference= Math.abs(diaFin-diaInicio);
                        var LargoFecha1 = difference/86400000;
                        var diasDePermanencia = Math.round(LargoFecha1);
                        var largoN = (nombreEmpleado.split(" ")).length;
                        var caso="0";
                        var nombre1 = "";
                        var nombre2 = "";
                        var nombre3 = "";
                        var nombre4 = "";
                        if(largoN==1){
                            caso = "1";
                            var nombre1 = nombreEmpleado;
                        }else if(largoN==2){
                            var nombreemp = nombreEmpleado.split(" ");
                            nombre1=nombreemp[0];
                            nombre2=nombreemp[1];
                            caso = "2";
                        }else if(largoN==3){
                            var nombreemp = nombreEmpleado.split(" ");
                            nombre1=nombreemp[0];
                            nombre2=nombreemp[1];
                            nombre3=nombreemp[2];
                            caso = "3";
                        }else if(largoN==4){
                            var nombreemp = nombreEmpleado.split(" ");
                            nombre1=nombreemp[0];
                            nombre2=nombreemp[1];
                            nombre3=nombreemp[2];
                            nombre4=nombreemp[3];
                            caso = "4";
                        }
                        if (tipoMovimiento== '1') {
                            empleadoEncontrado1[i]["fechaIngresoEmpleado"] = fechaIngresoEmpleado;
                            empleadoEncontrado1[i]["idEntidadTrabajo"] = idEntidadTrabajo;
                            empleadoEncontrado1[i]["fechaIngresoEmpleado"] = fechaIngresoEmpleado;
                            empleadoEncontrado1[i]["nombreCompletoEmp"] = apellidoPaterno+ ' ' + apellidoMaterno + ' ' + nombreEmpleado;
                            empleadoEncontrado1[i]["nombreCompletoEmp"] = apellidoPaterno+ ' ' + apellidoMaterno + ' ' + nombreEmpleado;
                            empleadoEncontrado1[i]["ordenID"] = ordenID1;
                            empleadoEncontrado1[i]["diasDePermanencia"] = diasDePermanencia;
                            empleadoEncontrado1[i]["fechaAsignacionHis"] = fechaAsignacionHis;
                            empleadoEncontrado1[i]["cantidadAsignados"] = cantidadAsignados;
                            empleadoEncontrado1[i]["tipoPDF"] = "<label style='color:green'> ASIGNACIÓN </label>";
                            empleadoEncontrado1[i]["pdf"]="<img style='width: 15%' title='' src='img/hojaDatos.png' class='cursorImg' id='btnPDFHistorialUniformesAsignacion' onclick=generarResponsivaUniformeAsignacionHA('"+empleadoEntidad+"','"+empleadoConsecutivo+"','"+empleadoCategoria+"',"+ordenID1+")>";
                        }else if (tipoMovimiento== '2' && Bandera=="0"){
                            empleadoEncontrado1[i]["fechaIngresoEmpleado"] = fechaIngresoEmpleado;
                            empleadoEncontrado1[i]["idEntidadTrabajo"] = idEntidadTrabajo;
                            empleadoEncontrado1[i]["fechaIngresoEmpleado"] = fechaIngresoEmpleado;
                            empleadoEncontrado1[i]["nombreCompletoEmp"] = apellidoPaterno+ ' ' + apellidoMaterno + ' ' + nombreEmpleado;
                            empleadoEncontrado1[i]["numeroCompletoEmp"] = empleadoEntidad+ '-' + empleadoConsecutivo + '-' + empleadoCategoria;
                            empleadoEncontrado1[i]["ordenID"] = ordenID1;
                            empleadoEncontrado1[i]["diasDePermanencia"] = diasDePermanencia;
                            empleadoEncontrado1[i]["fechaAsignacionHis"] = fechaAsignacionHis;
                            empleadoEncontrado1[i]["cantidadAsignados"] = cantidadAsignados;
                            empleadoEncontrado1[i]["tipoPDF"] = "<label style='color:red'> RECEPCIÓN </label>";
                            empleadoEncontrado1[i]["pdf"]="<img style='width: 15%' title='' src='img/hojaDatos.png' class='cursorImg' id='btnPDFRecep' onclick=generarPDFUniformesEntregados('"+empleadoEntidad+"','"+empleadoConsecutivo+"','"+empleadoCategoria+"','"+fechaIngresoEmpleado+"','"+caso+"','"+nombre1+"','"+nombre2+"','"+nombre3+"','"+nombre4+"','"+apellidoPaterno+"','"+apellidoMaterno+"','"+nombreEmpleadosE+"','"+FirmaEncargado+"','"+tipoMovimiento+"')>"; 

                            Bandera="1";
                        }else if (tipoMovimiento== '3') {
                            empleadoEncontrado1[i]["fechaIngresoEmpleado"] = fechaIngresoEmpleado;
                            empleadoEncontrado1[i]["idEntidadTrabajo"] = idEntidadTrabajo;
                            empleadoEncontrado1[i]["fechaIngresoEmpleado"] = fechaIngresoEmpleado;
                            empleadoEncontrado1[i]["nombreCompletoEmp"] = apellidoPaterno+ ' ' + apellidoMaterno + ' ' + nombreEmpleado;
                            empleadoEncontrado1[i]["nombreCompletoEmp"] = apellidoPaterno+ ' ' + apellidoMaterno + ' ' + nombreEmpleado;
                            empleadoEncontrado1[i]["ordenID"] = ordenID1;
                            empleadoEncontrado1[i]["diasDePermanencia"] = diasDePermanencia;
                            empleadoEncontrado1[i]["fechaAsignacionHis"] = fechaAsignacionHis;
                            empleadoEncontrado1[i]["cantidadAsignados"] = cantidadAsignados;
                            empleadoEncontrado1[i]["tipoPDF"] = "<label style='color:blue'> PARA ASIGNACIÓN </label>";
                            empleadoEncontrado1[i]["pdf"]="<img style='width: 15%' title='' src='img/hojaDatos.png' class='cursorImg' id='btnPDFParaAsignacion' onclick=generarResponsivaUniformeAsignacionHA('"+empleadoEntidad+"','"+empleadoConsecutivo+"','"+empleadoCategoria+"',"+ordenID1+")>";
                        }else if (tipoMovimiento== '4') {
                            empleadoEncontrado1[i]["fechaIngresoEmpleado"] = fechaIngresoEmpleado;
                            empleadoEncontrado1[i]["idEntidadTrabajo"] = idEntidadTrabajo;
                            empleadoEncontrado1[i]["fechaIngresoEmpleado"] = fechaIngresoEmpleado;
                            empleadoEncontrado1[i]["nombreCompletoEmp"] = apellidoPaterno+ ' ' + apellidoMaterno + ' ' + nombreEmpleado;
                            empleadoEncontrado1[i]["nombreCompletoEmp"] = apellidoPaterno+ ' ' + apellidoMaterno + ' ' + nombreEmpleado;
                            empleadoEncontrado1[i]["ordenID"] = ordenID1;
                            empleadoEncontrado1[i]["diasDePermanencia"] = diasDePermanencia;
                            empleadoEncontrado1[i]["fechaAsignacionHis"] = fechaAsignacionHis;
                            empleadoEncontrado1[i]["cantidadAsignados"] = cantidadAsignados;
                            empleadoEncontrado1[i]["tipoPDF"] = "<label style='color:black'> ASIGNADO POR SUPERVISOR </label>";
                            empleadoEncontrado1[i]["pdf"]="<img style='width: 15%' title='' src='img/hojaDatos.png' class='cursorImg' id='btnPDFAsignadoSupervisor' onclick=generarResponsivaUniformeAsignacionHA('"+empleadoEntidad+"','"+empleadoConsecutivo+"','"+empleadoCategoria+"',"+ordenID1+")>";
                        }else if (tipoMovimiento== '5') {
                            empleadoEncontrado1[i]["fechaIngresoEmpleado"] = fechaIngresoEmpleado;
                            empleadoEncontrado1[i]["idEntidadTrabajo"] = idEntidadTrabajo;
                            empleadoEncontrado1[i]["fechaIngresoEmpleado"] = fechaIngresoEmpleado;
                            empleadoEncontrado1[i]["nombreCompletoEmp"] = apellidoPaterno+ ' ' + apellidoMaterno + ' ' + nombreEmpleado;
                            empleadoEncontrado1[i]["nombreCompletoEmp"] = apellidoPaterno+ ' ' + apellidoMaterno + ' ' + nombreEmpleado;
                            empleadoEncontrado1[i]["ordenID"] = ordenID1;
                            empleadoEncontrado1[i]["diasDePermanencia"] = diasDePermanencia;
                            empleadoEncontrado1[i]["fechaAsignacionHis"] = fechaAsignacionHis;
                            empleadoEncontrado1[i]["cantidadAsignados"] = cantidadAsignados;
                            empleadoEncontrado1[i]["tipoPDF"] = "<label style='color:gray'> ASIGNADO POR CONSULTA SUPERVISOR </label>";
                            empleadoEncontrado1[i]["pdf"]="<img style='width: 15%' title='' src='img/hojaDatos.png' class='cursorImg' id='btnPDFasignadoConsultaSup' onclick=generarResponsivaUniformeAsignacionHA('"+empleadoEntidad+"','"+empleadoConsecutivo+"','"+empleadoCategoria+"',"+ordenID1+")>";
                        }else if (tipoMovimiento== '6') {
                            empleadoEncontrado1[i]["fechaIngresoEmpleado"] = fechaIngresoEmpleado;
                            empleadoEncontrado1[i]["idEntidadTrabajo"] = idEntidadTrabajo;
                            empleadoEncontrado1[i]["fechaIngresoEmpleado"] = fechaIngresoEmpleado;
                            empleadoEncontrado1[i]["nombreCompletoEmp"] = apellidoPaterno+ ' ' + apellidoMaterno + ' ' + nombreEmpleado;
                            empleadoEncontrado1[i]["nombreCompletoEmp"] = apellidoPaterno+ ' ' + apellidoMaterno + ' ' + nombreEmpleado;
                            empleadoEncontrado1[i]["ordenID"] = ordenID1;
                            empleadoEncontrado1[i]["diasDePermanencia"] = diasDePermanencia;
                            empleadoEncontrado1[i]["fechaAsignacionHis"] = fechaAsignacionHis;
                            empleadoEncontrado1[i]["cantidadAsignados"] = cantidadAsignados;
                            empleadoEncontrado1[i]["tipoPDF"] = "<label style='color:blueviolet'> ASIGNADO POR RECLUTADOR </label>";
                            empleadoEncontrado1[i]["pdf"]="<img style='width: 15%' title='' src='img/hojaDatos.png' class='cursorImg' id='btnPDFAsignadoPorReclutador' onclick=generarResponsivaUniformeAsignacionHA('"+empleadoEntidad+"','"+empleadoConsecutivo+"','"+empleadoCategoria+"',"+ordenID1+")>";
                        }else if (tipoMovimiento== '7') {
                            empleadoEncontrado1[i]["fechaIngresoEmpleado"] = fechaIngresoEmpleado;
                            empleadoEncontrado1[i]["idEntidadTrabajo"] = idEntidadTrabajo;
                            empleadoEncontrado1[i]["fechaIngresoEmpleado"] = fechaIngresoEmpleado;
                            empleadoEncontrado1[i]["nombreCompletoEmp"] = apellidoPaterno+ ' ' + apellidoMaterno + ' ' + nombreEmpleado;
                            empleadoEncontrado1[i]["nombreCompletoEmp"] = apellidoPaterno+ ' ' + apellidoMaterno + ' ' + nombreEmpleado;
                            empleadoEncontrado1[i]["ordenID"] = ordenID1;
                            empleadoEncontrado1[i]["diasDePermanencia"] = diasDePermanencia;
                            empleadoEncontrado1[i]["fechaAsignacionHis"] = fechaAsignacionHis;
                            empleadoEncontrado1[i]["cantidadAsignados"] = cantidadAsignados;
                            empleadoEncontrado1[i]["tipoPDF"] = "<label style='color:blueviolet'> RECEPCIÓN(uniformes Plantilla) </label>";
                            empleadoEncontrado1[i]["pdf"]="<img style='width: 15%' title='' src='img/hojaDatos.png' class='cursorImg' id='btnPDFRecepcionUniPlant' onclick=generarPDFUniformesEntregados('"+empleadoEntidad+"','"+empleadoConsecutivo+"','"+empleadoCategoria+"','"+fechaIngresoEmpleado+"','"+caso+"','"+nombre1+"','"+nombre2+"','"+nombre3+"','"+nombre4+"','"+apellidoPaterno+"','"+apellidoMaterno+"','"+nombreEmpleadosE+"','"+FirmaEncargado+"','"+tipoMovimiento+"')>";
                        }

                        //  console.log(empleadoEncontrado1);
                        tablehistoricoEmpAlmacen.push(empleadoEncontrado1[i]);
                    }
                   // console.log(tablehistoricoEmpAlmacen);
                    loadDataInTableHistoricoEmpAlm(tablehistoricoEmpAlmacen);   
                }
            }else if(response.status == "error"){
                  alert(response.error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
}


var tableEmpHisAlm = null;
function loadDataInTableHistoricoEmpAlm(data) {
     if (tableEmpHisAlm != null) {
         tableEmpHisAlm.destroy();
     }
     tableEmpHisAlm = $('#tablaHistoricoEmpAlm').DataTable({
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
         destroy: true,
         "columns": [
         {   "className": "dt-body-center",
             "data": "nombreCompletoEmp"
         },
         {   "className": "dt-body-center",
             "data": "fechaIngresoEmpleado"
         },
         {   "className": "dt-body-center",
             "data": "fechaBajaEmpleado"
         },
         {   "className": "dt-body-center",
             "data": "diasDePermanencia"
         },
         {   "className": "dt-body-center",
             "data": "idEntidadTrabajo"
         },
         {   "className": "dt-body-center",
             "data": "ordenID"
         },
         {   "className": "dt-body-center",
             "data": "fechaAsignacionHis"
         },
         {   "className": "dt-body-center",
             "data": "cantidadAsignados"
         },
         {   "className": "dt-body-center",
             "data": "tipoPDF"
         },
          {   "className": "dt-body-center",
             "data": "pdf"
         },],
         processing: true,
         dom: 'Bfrtip',
         buttons: {
         buttons: []
    }
         
     });
 }

function generarPDFUniformesEntregados(empleadoEntidad,empleadoConsecutivo,empleadoCategoria,fechaIngresoEmpleado,caso,nombre1,nombre2,nombre3,nombre4,apellidoPaterno,apellidoMaterno,NombreEncargado,FirmaEncargado,tipoMovimiento){ 
  window.open("ajax_cargaPDFRecepcionUniforme.php?&empleadoEntidad=" + empleadoEntidad + "&empleadoConsecutivo=" + empleadoConsecutivo + "&empleadoCategoria=" + empleadoCategoria +  "&fechaIngresoEmpleado=" +fechaIngresoEmpleado+  "&caso=" +caso+"&nombre1=" +nombre1+"&nombre2=" +nombre2+"&nombre3=" +nombre3+ "&nombre4=" +nombre4+ "&apellidoPaterno=" +apellidoPaterno+  "&apellidoMaterno=" +apellidoMaterno+  "&NombreEncargado=" +NombreEncargado+  "&FirmaEncargado=" +FirmaEncargado+  "&tipoMovimiento=" +tipoMovimiento,'fullscreen=no');
}
 
function generarResponsivaUniformeAsignacionHA(empleadoEntidad,empleadoConsecutivo,empleadoCategoria,ordenID){  
 window.open("GeneradorResponsivaXOrden.php?entidadEmpleado="+empleadoEntidad+"&consecutivoEmpleado="+empleadoConsecutivo+"&tipoEmpleado="+empleadoCategoria+"&noordenID="+ordenID);
}

/*function consultaHistorialUniforme(empleadoEntidad,empleadoConsecutivo,empleadoCategoria,ordenID){ 
 window.open("uploads/DocFirmadoEntregaUniformes/"+empleadoEntidad+"-"+empleadoConsecutivo+"-"+empleadoCategoria+"/Orden_"+ordenID);
}*/
</script>