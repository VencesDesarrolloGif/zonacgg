 <div id="msgerrorVacacionesPendientesEmpleados"></div>
<center><h3>Registro De Vacaciones Pendientes</h3></center>
<center><h3 id="Tadministrativos" name="Tadministrativos" style="display: none;">ADMINISTRATIVOS</h3></center>
<center><h3 id="Topertativos" name="Topertativos" style="display: none;">OPERATIVOS</h3></center>
<br>

<a id="ConsultaAdministrativos"onclick="ConsultaEmpleadosConVacacionesPendientes(1)"style="cursor: pointer;margin-left: 38%" data-toggle="tab">VACACIONES PENDIENTES ADMINISTRATIVOS</a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
<a id="ConsultaOperativos"onclick="ConsultaEmpleadosConVacacionesPendientes(2)"style="cursor: pointer;" data-toggle="tab">VACACIONES PENDIENTES OPERATIVOS</a><br><br>


<section>
     <table id="tablaEmpleadosVacacionesPendientes"   class="records_list table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="display: none;">
        <thead>
            <tr>
                <th style="text-align: center;background-color: #B0E76E">Número Empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Nombre Empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Fecha Ingreso Empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Entidad Federativa</th>
                <th style="text-align: center;background-color: #B0E76E">Linea De Negocio</th> 
                <th style="text-align: center;background-color: #B0E76E">Ingresar Vacaciones</th>
                <th style="text-align: center;background-color: #B0E76E">Empleado Revisado</th>             
            </tr>  
        </thead>
    </table>
</section>

<div class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="overflow-y: scroll; max-height:85%;  margin-top: 60px; margin-bottom:60px;" id="ModalVacacionesPendientesEmpleados" name="ModalVacacionesPendientesEmpleados">
    <div id="msgerrormodlVacacionesPendientesEmpleados"></div>
    <div class="input-prepend" id="divmuestraVacacionesPendientesEmpleados" style="display:none;" align="center"><!--este div es para las vacaciones disfrutadas -->
      <div class="input-prepend" align="center">
        <h3> REGISTRO DE VACACIONES PENDIENTES</h3>
      </div><br>

      <div class="input-prepend">
        <span class="add-on">Numero Empleado</span>
        <input id="numempleadoVacacionesPendientesEmpleados" name="numempleadoVacacionesPendientesEmpleados" type="text" class="input-large" readonly>
      </div><br>
      <div id="divVacacionesotrasEmpresas">
       <h5> Tiene Vacaciones Pendientes De Otras Empresas</h5>

       <div class="input-prepend">
        <span class="add-on" style='margin-left: 0%;'>Si</span>
        <input id="CheckVacacionessi" name="CheckVacacionessi" type="checkbox" style='transform: scale(1.5); margin-left: 5%;'>
        <span class="add-on" style='margin-left: 5%;'>No</span>
        <input id="CheckVacacionesno" name="CheckVacacionesno" type="checkbox" style='transform: scale(1.5); margin-left: 5%;'>
         <span class="add-on" style="margin-left: 5%;">Dias Pendientes</span>
        <input id="DisVacacionesPendientesOtrasEmpresas" name="DisVacacionesPendientesOtrasEmpresas" type="text" class="input-medium" title="Está Información Se Estará Agregando En El Aniversario 0" readonly>
      </div><br>
      </div>

      <h5>Ingrese El Total De Vacaciones Tomadas Según El Aniversario</h5>

      <div class="input-prepend">
        <span class="add-on">Periodo Inicio</span>
        <input id="PeriodoInicioVacacionesPendientesEmpleados" name="PeriodoInicioVacacionesPendientesEmpleados" type="text" class="input-medium" readonly>

        <span class="add-on">Periodo Fin</span>
        <input id="PeriodoFinVacacionesPendientesEmpleados" name="PeriodoFinVacacionesPendientesEmpleados" type="text" class="input-medium" readonly>
      </div><br>

      <div class="input-prepend">
        <span class="add-on">Dias Restantes De Vacaciones</span>
        <input id="VacacionesRestntesVacacionesPendientesEmpleados" name="VacacionesRestntesVacacionesPendientesEmpleados" type="text" class="input-medium" readonly>
      </div><br>

      <div class="input-prepend">
        <span class="add-on">Aniversarios</span>
        <select id="selectPeriodoInicioVacacionesPendientesEmpleados" name="selectPeriodoInicioVacacionesPendientesEmpleados" class="input-large"></select>
        <select id="selectPeriodoInicioVacacionesPendientesEmpleados1" name="selectPeriodoInicioVacacionesPendientesEmpleados1" class="input-large" style="display: none" ></select>
      </div><br>

      <div class="input-prepend">
        <span class="add-on">Dias De Vacaciones Tomadas</span>
        <input id="inpdiasvacacionesVacacionesPendientesEmpleados" name="inpdiasvacacionesVacacionesPendientesEmpleados" type="text" class="input-small" readonly >
      </div><br>
      <div class="input-prepend">
        <button style="margin-left: 20%" id="btnAgregarVacaciones" name="btnAgregarVacaciones" type="button" class="btn btn-primary" onclick="AgregarVacacionesTabla()" title="Se Agregará Las Vacaciones que Asigne A Cada Aniversario(Uno Por Uno)">Agregar</button> 
        <button id="ntvConfirmarEmpleadoterminado" name="ntvConfirmarEmpleadoterminado" type="button" class="btn btn-success" onclick="RegistrarRevisionEmpleado('1','1','1')" style="margin-left: 5%" title="Se Procesará Al Empleado Haciendo Que Desaparezca De La Lista!!">Procesar Empleado</button> 
      </div><br>
   
    <!-- <div id="DivTablaVacacionesConfirmadas" name="DivTablaVacacionesConfirmadas" style="display: block;">

        <h4>Vacaciones Confirmadas !!</h4>
        <div class="input-prepend">
            <span class="add-on">Periodo Inicio</span>
            <input id="PeriodoInicioVacacionesConfirmadas" name="PeriodoInicioVacacionesConfirmadas" type="text" class="input-medium" readonly>

            <span class="add-on">Periodo Fin</span>
            <input id="PeriodoFinVacacionesConfirmadas" name="PeriodoFinVacacionesConfirmadas" type="text" class="input-medium" readonly>
        </div><br>

        <div class="input-prepend">
            <span class="add-on">Aniversarios</span>
            <input id="AnivrsarioConfirmado" name="AnivrsarioConfirmado" type="text" class="input-medium" readonly>

            <span class="add-on">Dias De Vacaciones Tomadas</span>
            <input id="inpdiasvacacionesVacacionesConfirmadas" name="inpdiasvacacionesVacacionesConfirmadas" type="text" class="input-small" readonly >
        </div><br>

      </div> -->
        <input id="empleadoEntidadVacacionesPendientesEmpleados" name="empleadoEntidadVacacionesPendientesEmpleados" type="hidden" class="input-small" >
        <input id="empleadoConsecutivoVacacionesPendientesEmpleados" name="empleadoConsecutivoVacacionesPendientesEmpleados" type="hidden" class="input-small" >
        <input id="empleadoTipoVacacionesPendientesEmpleados" name="empleadoTipoVacacionesPendientesEmpleados" type="hidden" class="input-small" >
      
    </div>
  </div>
    
<script type="text/javascript"> 

function ConsultaEmpleadosConVacacionesPendientes(OpcionBusqueda) {
  waitingDialog.show();
    $("#bandera").val(OpcionBusqueda);
    if(OpcionBusqueda == "1"){
        $("#Tadministrativos").show();
        $("#Topertativos").hide();
    }else{
        $("#Tadministrativos").hide();
        $("#Topertativos").show();
    }
    $("#tablaEmpleadosVacacionesPendientes").show();

    tableCOnsultaEmp = [];
    $.ajax({
     type: "POST",
     url: "ajax_ConsultaEmpleadosConVacacionesPendientes.php",
     data: {"OpcionBusqueda":OpcionBusqueda},
     dataType: "json",
     success: function(response) {
        if (response.status == "success") {
            for (var i = 0; i < response.datos.length; i++) {
                var record = response.datos[i];
                tableCOnsultaEmp.push(record);
            }
            loadDataVacacionesPendientes(tableCOnsultaEmp);
            waitingDialog.hide();
         } else {
             var mensaje = response.message;
             console.log("mal");
         }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }
 var tablaVacacionesPendientesEmpleados = null;

 function loadDataVacacionesPendientes(data) {
     if (tablaVacacionesPendientesEmpleados != null) {
         tablaVacacionesPendientesEmpleados.destroy();
     }
     tablaVacacionesPendientesEmpleados = $('#tablaEmpleadosVacacionesPendientes').DataTable({
   
        "dataTables_filter" : { "display": "none" },
        "pageLength" : 20,
        "lengthMenu": [[5, 10, 20, -1], [5, 10, 20, 'Todos']],
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
             "data": "NumeroEmpleado"
         }, 
         {   
             "data": "NombreEmpleado"
         }, 
         {   
             "data": "fechaIngresoEmpleado"
         }, 
         {   
             "data": "nombreEntidadFederativa"
         },
         {   
             "data": "descripcionLineaNegocio"
         },
         {   
             "data": "editarVacaciones"
         }, 
         {   
             "data": "EmpleadoRevisado"
         },
        ],
         processing: true,
         dom: 'Bfrtip',

          buttons: {
        buttons: []
    } 
     }); 
 }

 function registrarVacacionesPendientes(entidadEmpFiniquito,consecutivoEmpFiniquito,categoriaEmpFiniquito){
    arreglo=[];
    $("#divVacacionesotrasEmpresas").show();
    $("#CheckVacacionessi").prop("checked",false);
    $("#CheckVacacionessi").val("");
    $("#CheckVacacionesno").prop("checked",false);
    $("#CheckVacacionesno").val("");
    $("#DisVacacionesPendientesOtrasEmpresas").val("");
    $("#DisVacacionesPendientesOtrasEmpresas").prop("readonly",true);
    $("#PeriodoInicioVacacionesPendientesEmpleados").val("");
    $("#PeriodoFinVacacionesPendientesEmpleados").val("");
    $("#VacacionesRestntesVacacionesPendientesEmpleados").val("");
    $("#inpdiasvacacionesVacacionesPendientesEmpleados").val("");
    $("#inpdiasvacacionesVacacionesPendientesEmpleados").prop("readonly",true);
    $("#empleadoEntidadVacacionesPendientesEmpleados").val(entidadEmpFiniquito);
    $("#empleadoConsecutivoVacacionesPendientesEmpleados").val(consecutivoEmpFiniquito);
    $("#empleadoTipoVacacionesPendientesEmpleados").val(categoriaEmpFiniquito);
    var Numeroempleado1 = entidadEmpFiniquito + "-" + consecutivoEmpFiniquito + "-" + categoriaEmpFiniquito;
    $("#numempleadoVacacionesPendientesEmpleados").val(Numeroempleado1);
    CargarSelectorVacaione(0);
    $("#ModalVacacionesPendientesEmpleados").modal();
    $("#divmuestraVacacionesPendientesEmpleados").show();

 }

 function CargarSelectorVacaione(){
  var empleadoEntidadId = $("#empleadoEntidadVacacionesPendientesEmpleados").val();
  var empleadoConsecutivoId = $("#empleadoConsecutivoVacacionesPendientesEmpleados").val();
  var empleadoTipoId = $("#empleadoTipoVacacionesPendientesEmpleados").val();
  $.ajax({
    type: "POST",
    url: "ajax_getPeriodosanualesALtaEmpleado.php",
    data: {"empleadoEntidadId":empleadoEntidadId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoTipoId":empleadoTipoId},
    dataType: "json",
    success: function(response) {
      var datos=response.datos;
      //llenar el selector de periodos
      $('#selectPeriodoInicioVacacionesPendientesEmpleados').empty().append('<option value="0"></option>');
      $('#selectPeriodoInicioVacacionesPendientesEmpleados1').empty().append('<option value="0"></option>');
      $.each(datos, function(i) {
        $('#selectPeriodoInicioVacacionesPendientesEmpleados').append('<option value="' + datos[i].IdAnio + '">' +datos[i].Aniversario + '</option>');
        $('#selectPeriodoInicioVacacionesPendientesEmpleados1').append('<option value="' + datos[i].IdAnio + '">' +datos[i].Aniversario + '</option>');
      });
      },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}

$("#selectPeriodoInicioVacacionesPendientesEmpleados").change(function()
{

  var Aniversario = $("#selectPeriodoInicioVacacionesPendientesEmpleados").val();
  var empleadoEntidadId = $("#empleadoEntidadVacacionesPendientesEmpleados").val();
  var empleadoConsecutivoId = $("#empleadoConsecutivoVacacionesPendientesEmpleados").val();
  var empleadoTipoId = $("#empleadoTipoVacacionesPendientesEmpleados").val();
 
  $("#inpdiasvacacionesVacacionesPendientesEmpleados").prop("readonly", true);
  $("#PeriodoInicioVacacionesPendientesEmpleados").val("");
  $("#PeriodoFinVacacionesPendientesEmpleados").val("");
  $("#VacacionesRestntesVacacionesPendientesEmpleados").val("");
  if(Aniversario=="0" || Aniversario==null || Aniversario=="null" || Aniversario=="NULL"){
    CargaerrorModal("Seleccione Un Aniversario Para Mostrar Las Vacaciones ","error");
  }else
  {
    $.ajax({
      type: "POST",
      url: "ajax_getDiasRestantesVacaciones.php",
      data:{"empleadoEntidadId":empleadoEntidadId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoTipoId":empleadoTipoId,"Aniversario":Aniversario},
      dataType: "json",
      success: function(response) {
        $("#VacacionesRestntesVacacionesPendientesEmpleados").val("");
        $("#PeriodoInicioVacacionesPendientesEmpleados").val("");
        $("#PeriodoFinVacacionesPendientesEmpleados").val("");
        var datos=response.DiasDisponibles;
        var FechaUno=response.FechaUno;
        var FechaDos=response.FechaDos;
        $("#VacacionesRestntesVacacionesPendientesEmpleados").val(datos);
        $("#PeriodoInicioVacacionesPendientesEmpleados").val(FechaUno);
        $("#PeriodoFinVacacionesPendientesEmpleados").val(FechaDos);
        if(Aniversario!="0" && datos!="0"){
          $("#inpdiasvacacionesVacacionesPendientesEmpleados").prop("readonly", false);
        }else{
          $("#inpdiasvacacionesVacacionesPendientesEmpleados").prop("readonly", true);
        }

        },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }
});

  $('#CheckVacacionessi').change(function() {
    if($('#CheckVacacionessi').is(":checked")) {
        $('#CheckVacacionessi').val(1);
        $('#DisVacacionesPendientesOtrasEmpresas').prop('readonly', false);
        $("#CheckVacacionesno").prop("checked", false); 
        $('#CheckVacacionesno').val(0); 
    } 
    else {
        $('#CheckVacacionessi').val(0);
        $('#DisVacacionesPendientesOtrasEmpresas').prop('readonly', true);
     
    }
  });

  $('#CheckVacacionesno').change(function() {
    if($('#CheckVacacionesno').is(":checked")) {
        $('#CheckVacacionesno').val(1);
        $('#DisVacacionesPendientesOtrasEmpresas').prop('readonly', true);
        $('#DisVacacionesPendientesOtrasEmpresas').val("");;
        $("#CheckVacacionessi").prop("checked", false); 
        $('#CheckVacacionessi').val(0); 
    } 
    else {
        $('#CheckVacacionesno').val(0);
        $('#DisVacacionesPendientesOtrasEmpresas').prop('readonly', true);
     
    }
  });

  function AgregarVacacionesTabla(){

   // $("#btnAgregarVacaciones").hide();     $('#selectRolOpE > option[value="3"]').attr('selected','selected');
    var combo = document.getElementById("selectPeriodoInicioVacacionesPendientesEmpleados"); // me da todos los aniversarios c
    var idSelector = document.getElementById("selectPeriodoInicioVacacionesPendientesEmpleados").value;// me da el id del aniversario 
    var largoselector = document.getElementById("selectPeriodoInicioVacacionesPendientesEmpleados1").length;// me da el largo del selector
    var selected = combo.options[combo.selectedIndex].text;// da el texto del aniversario 
    var DiasVacacionesConfirmadas = $("#inpdiasvacacionesVacacionesPendientesEmpleados").val();
    var vacacionesRes = $("#VacacionesRestntesVacacionesPendientesEmpleados").val();
    var CheckVacacionessi = $("#CheckVacacionessi").val();
    var CheckVacacionesno = $("#CheckVacacionesno").val();
    var DisVacacionesAceptadasOtrasE = $("#DisVacacionesPendientesOtrasEmpresas").val();
    var NumeroEmpleado = $("#numempleadoVacacionesPendientesEmpleados").val();
    var fecharegistroVacaciones = $("#PeriodoInicioVacacionesPendientesEmpleados").val();
    var resta = vacacionesRes - DiasVacacionesConfirmadas;

    if(((CheckVacacionessi != "0" && CheckVacacionessi != "1") && (CheckVacacionesno != "0" && CheckVacacionesno != "1")) || (CheckVacacionessi == "0" && CheckVacacionesno == "0") ){
        CargaerrorModal("Favor De Seleccionar Si El Empleado Tiene Vacaciones Pendientes De Otras Empresas","error");
    }else if(CheckVacacionessi==1 && !/^([0-9])*$/.test(DisVacacionesAceptadasOtrasE)){
        CargaerrorModal("Favor De Ingresar Unicanmente Números En Dias Pendientes Otras Empresas","error");
    }else if(CheckVacacionessi==1 && DisVacacionesAceptadasOtrasE==""){
        CargaerrorModal("Favor De Ingresar La Cantidad De Vacacione En Deuda De Otras Empresas","error");
    }else if(CheckVacacionessi==1 && DisVacacionesAceptadasOtrasE < 1){
        CargaerrorModal("La Cantidad De Vacaciones De Otras Empresas Ingresadas No Pueden Ser Menor o Igual A 0","error");
    }else if(idSelector!="0" && idSelector!=""){
        if(idSelector==="0" || idSelector===""){
            CargaerrorModal("Ingresa El Aniversario a Editar","error");
        }else if(!/^([0-9])*$/.test(DiasVacacionesConfirmadas)){
            CargaerrorModal("Favor De Ingresar Unicanmente Números En Dias De Vacaciones Tomadas","error");
        }else if(DiasVacacionesConfirmadas==""){
            CargaerrorModal("Favor De Ingresar La Cantidad De Vacaciones Del Aniversario Seleccionado","error");
        }else if(resta<"0"){
            CargaerrorModal("Las Vacaciones Ingresadas Superan Las Vacaciones Permitidas En El Aniversario Seleccionado","error");
        }else{
          var opcion = "1";
          RegistrarEnTablaVacaciones(idSelector,DiasVacacionesConfirmadas,DisVacacionesAceptadasOtrasE,NumeroEmpleado,fecharegistroVacaciones,opcion);
        }
    }else{
          var opcion = "2";
          if(CheckVacacionesno === "0"){
          RegistrarEnTablaVacaciones(idSelector,DiasVacacionesConfirmadas,DisVacacionesAceptadasOtrasE,NumeroEmpleado,fecharegistroVacaciones,opcion);            
          }else{
            CargaerrorModal("Si El Empleado No Tiene Vacaciones Pendientes Salir Y Dar Click En El Circulo Verde  ","error");
          }
    }
  }
var arreglo = [];
function RegistrarEnTablaVacaciones(idSelector,DiasVacacionesConfirmadas,DisVacacionesAceptadasOtrasE,NumeroEmpleado,fecharegistroVacaciones,opcion){

  $.ajax({
            type: "POST",
            url: "ajax_RegistrarVacacionesPendientes.php",
            data:{"idSelector":idSelector, "DiasVacacionesConfirmadas":DiasVacacionesConfirmadas,"DisVacacionesAceptadasOtrasE":DisVacacionesAceptadasOtrasE,"NumeroEmpleado":NumeroEmpleado,"    fecharegistroVacaciones":fecharegistroVacaciones,"opcion":opcion},
            dataType: "json",
            async: false,
            success: function(response) {
                var mensaje = response.message;
                if(opcion==="1"){
                  arreglo[idSelector]= idSelector;
                  var largoselector = document.getElementById("selectPeriodoInicioVacacionesPendientesEmpleados1").length;// me da el largo del selector
                  alert(largoselector);
                  $('#selectPeriodoInicioVacacionesPendientesEmpleados').empty();
                  $('#selectPeriodoInicioVacacionesPendientesEmpleados').append('<option value="0"></option>');
                  for(var i=0; i<largoselector; i++){
                      if(i != arreglo[i] && i!=0){
                          var valor = i;
                          var Desc = "Aniversario N°"+i;
                          $('#selectPeriodoInicioVacacionesPendientesEmpleados').append('<option value="' + valor + '">' +Desc + '</option>');
                      }
                  }
                }
                $("#PeriodoInicioVacacionesPendientesEmpleados").val("");
                $("#PeriodoFinVacacionesPendientesEmpleados").val("");
                $("#VacacionesRestntesVacacionesPendientesEmpleados").val("");
                $("#inpdiasvacacionesVacacionesPendientesEmpleados").val("");
                $("#divVacacionesotrasEmpresas").hide();
                CargaerrorModal(mensaje,"success");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
                var mensaje = response.message;
                CargaerrorModal(mensaje,"error");
            }
        });
}  

function RegistrarRevisionEmpleado(entidadEmpFiniquito,consecutivoEmpFiniquito,categoriaEmpFiniquito){
    var opcionDeBusqueda = $("#bandera").val();
    if(entidadEmpFiniquito=="1" && consecutivoEmpFiniquito =="1" && categoriaEmpFiniquito =="1"){
      var empleadoNum = $("#numempleadoVacacionesPendientesEmpleados").val();
      var empleadoSplit = empleadoNum.split("-");
      var entidadEmpFiniquito = empleadoSplit[0];
      var consecutivoEmpFiniquito = empleadoSplit[1];
      var categoriaEmpFiniquito = empleadoSplit[2];
      $("#ModalVacacionesPendientesEmpleados").modal("hide");
    }    

    $.ajax({
        type: "POST",
        url: "ajax_ConfirmarRevisionVacacionesPendientes.php",
        data:{"entidadEmpFiniquito":entidadEmpFiniquito, "consecutivoEmpFiniquito":consecutivoEmpFiniquito,"categoriaEmpFiniquito":categoriaEmpFiniquito},
        dataType: "json",
        async: false,
        success: function(response) {
            var mensaje = response.message;
            alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensaje+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#msgerrorVacacionesPendientesEmpleados").html(alertMsg1);
            $(document).scrollTop(0);
            $('#msgAlert').delay(3000).fadeOut('slow');
            ConsultaEmpleadosConVacacionesPendientes(opcionDeBusqueda);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            var mensaje = response.message;
            alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+mensaje+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#msgerrorVacacionesPendientesEmpleados").html(alertMsg1);
            $(document).scrollTop(0);
            $('#msgAlert').delay(3000).fadeOut('slow');
        }
    });
}
//msgerrorVacacionesPendientesEmpleados
  function CargaerrorModal(mensaje,tipo){
    alertMsg1="<div id='msgAlert' class='alert alert-"+ tipo +"'><strong>"+mensaje+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#msgerrormodlVacacionesPendientesEmpleados").html(alertMsg1);
    $(document).scrollTop(0);
    $('#msgAlert').delay(3000).fadeOut('slow');
  }



</script>