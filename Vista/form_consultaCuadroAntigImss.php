
<div class="containerTableImss">
    <h4>CONSULTAR CUADRO ANTIGÜEDAD</h4>

     Del  <input type="date" id="fechaAltaPeriodo1" name="fechaAltaPeriodo1" class="input-medium">
        al
        <input type="date" id="fechaAltaPeriodo2" name="fechaAltaPeriodo2" class="input-medium">
        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="styleTable3();">Consultar</button>
        <br>
        <br>
<div style="text-align: left" id="divbtnexcel"> &nbsp<button style="margin-bottom: 0.5%" type="button" class="btn btn-default" onclick="downloadexcelcuadroantiguedad();">Excel</button></div>
        <section>
            <table id="example3" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th># Empleado</th>
                        <th>Nombre</th>
                        <th>Cliente</th>
                        <th>Estatus</th>
                        <th>Registro Patronal</th>
                        <th>Fecha Ingreso</th>
                        <th>Fecha Baja</th>
                        <th># Imss</th>
                        <th>Fecha Movimiento</th>
                        <th>Movimiento</th>
                        <th>Lote Imss</th>
                        <th>Salario Diario</th>
                        <th>Prima Vacacional</th>
                        <th>Factor Integracion</th>
                        <th>Salario Base Cot</th>
                        <th>Editar</th>
                        <!--<th>Detalle</th>-->
                        </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th># Empleado</th>
                        <th>Nombre</th>
                        <th>Cliente</th>
                        <th>Estatus</th>
                        <th>Registro Patronal</th>
                        <th>Fecha Movimiento</th>
                        <th>Fecha Baja</th>
                        <th># Imss</th>
                        <th>Fecha Ingreso</th>
                        <th>Movimiento</th>
                        <th>Lote Imss</th>
                        <th>Salario Diario</th>
                        <th>Prima Vacacional</th>
                        <th>Factor Integracion</th>
                        <th>Salario Base Cot</th>
                        <th>Editar</th>
                        <!--<th>Detalle</th>-->
                    </tr>
                </tfoot>
            </table>
        </section>
</div>
<div id="myModalEditarDatosImss" name="myModalEditarDatosImss" class="modalEdit hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  >
  <div id="alertMsg111111">
  </div>
   <div class="modal-header">
      <h4 class="modal-title" id="myModalLabel"> <img src="img/ok.png">CONFIRMAR IMSS</h4>
    </div>
    <div class="modal-body">
<input id="hdnfechaingreso" name="hdnfechaingreso" type="hidden" class="input-small" >
<input id="hdnfechabaja" name="hdnfechabaja" type="hidden" class="input-small" >
<input id="hdndiastranscurridos" name="hdndiastranscurridos" type="hidden" class="input-small" >
        <div class="input-prepend">
          <span class="add-on"># EMPLEADO</span>
          <input id="txtNumeroEmpleadoModalImssE" name="txtNumeroEmpleadoModalImssE" type="text" class="input-medium" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">NOMBRE EMPLEADO</span>
          <input id="txtNombreEmpleadoModalImssE" name="txtNombreEmpleadoModalImssE" type="text" class="input-xlarge" readonly>
        </div>

        <div class="input-prepend">
          <span class="add-on">SALARIO DIARIO $</span>
          <input id="txtSalarioDiarioE" name="txtSalarioDiarioE" type="text" class="input-small" maxlength="9" >
           <input id="txtSalarioDiarioAnterior" name="txtSalarioDiarioAnterior" type="hidden" class="input-small" maxlength="9" >
        </div>

         <div class="input-prepend">
          <span class="add-on">REGISTRO PAT.</span>
          <select id="selectRegistroPE" name="selectRegistroPE">

            <option >REGISTRO PATRONAL</option>
                <?php
for ($i = 0; $i < count($catalogoRegistrosPatronales); $i++) {
    echo "<option value='" . $catalogoRegistrosPatronales[$i]["idcatalogoRegistrosPatronales"] . "'>" . $catalogoRegistrosPatronales[$i]["idcatalogoRegistrosPatronales"] . " (" . $catalogoRegistrosPatronales[$i]["nombreEntidadFederativa"] . ") </option>";
}
?>
          </select>
           <input id="RegistroPAnterior" name="RegistroPAnterior" type="hidden" class="input-small" maxlength="9" >
        </div>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick='actualizarDatosCuadro();'>Guardar Cambios</button>
      </div>
    </div>  <!-- FIN MODAL BAJA EMPLEADO -->
<script type="text/javascript">

$(inicioCuadroAntImss());  

function inicioCuadroAntImss(){
    $("#divbtnexcel").hide();
}

var table1 = null;
$(document).ready(function() {
} );
function styleTable3(){
    $("#divbtnexcel").show();
    var fechaAltaPeriodo1=$("#fechaAltaPeriodo1").val();
    var fechaAltaPeriodo2=$("#fechaAltaPeriodo2").val();
    if (fechaAltaPeriodo1=="")
    {
        alertMsg1="<div id='msgAlert' class='alert alert-danger'><strong>Consulta Cuadro de Antigüedad</strong> Proporcione Fecha Inicio de consulta <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#alertMsg").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    $(document).scrollTop(0);
    return;
    }
    if (fechaAltaPeriodo2=="")
    {
        alertMsg1="<div id='msgAlert' class='alert alert-danger'><strong>Consulta Cuadro de Antigüedad</strong> Proporcione Fecha Final de consulta <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#alertMsg").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    $(document).scrollTop(0);
    return;
    }
    if (table1 != null)
        {
            table1.destroy ();
        }
        table1 = $('#example3').on('error.dt', function (e, settings, techNote, message) {
        //console.log('An error has been reported by DataTables: ', settings);
    }).DataTable( {
        ajax: {
            url: 'ajax_ConsultaCuadroAntig.php'
            ,type: 'POST'
            ,data : {"fechaAltaPeriodo1":fechaAltaPeriodo1, "fechaAltaPeriodo2":fechaAltaPeriodo2 }
       }
        ,"columns":
        [
            { "data": "numeroEmpleadoC"}
            ,{ "data": "nombreCompletoC" }
            ,{ "data": "razonSocial" }

            ,{ "data": "descripcionEstatusEmpleado" }

            ,{ "data": "registroMovimiento" }



            ,{ "data": "fechaAlta" }
             ,{ "data": "fechaBaja" }
            ,{ "data": "empleadoNumeroSeguroSocial" }
            ,{ "data": "fechaMovimiento" }
            ,{ "data": "descMovimientoImss" }
            ,{ "data": "loteImss" }
            ,{ "data": "sdiMovimiento" }
            ,{ "data": "prima_vacacional" }
            ,{ "data": "FIntegracionMovimiento" }
            ,{ "data": "SBCMovimiento" }
            ,{ "data": "accion_editar" }
             //,{ "data": "detalle" }
        ]
        //,serverSide: true
        ,processing: true
        ,dom: 'Bfrtip'
        ,buttons: [
           // 'copy', 'excel'
        ]});
}


function editarDatosImss(empleadoId, nombreEmpleado, fechaIngreso, salario, registro,fechabaja,diasTranscurridos)
{
   // alert (fechabaja);
    $('#myModalEditarDatosImss').modal();
    $("#txtNumeroEmpleadoModalImssE").val(empleadoId);
    $("#txtNombreEmpleadoModalImssE").val(nombreEmpleado);
    $("#txtSalarioDiarioE").val(salario);
    $("#selectRegistroPE").val(registro);
    $("#txtSalarioDiarioAnterior").val(salario);
    $("#RegistroPAnterior").val(registro);
    $("#hdnfechaingreso").val(fechaIngreso);
    $("#hdnfechabaja").val(fechabaja);
    $("#hdndiastranscurridos").val(diasTranscurridos);
}
function actualizarDatosCuadro(){
    var numeroEmpleado=$("#txtNumeroEmpleadoModalImssE").val();
    var salarioDiariosp=$("#txtSalarioDiarioE").val();
    var registroPatronal=$("#selectRegistroPE").val();
    var registroPatronalAnterior=$("#RegistroPAnterior").val();
    var salarioDiarioAnteriorsp=$("#txtSalarioDiarioAnterior").val();
    var tipomovimiento=0;
    var fechaingreso= $("#hdnfechaingreso").val();
    var fechabaja= $("#hdnfechabaja").val();
    var diastranscurridos=$("#hdndiastranscurridos").val();
    var salarioDiario=parseFloat(salarioDiariosp);
    var salarioDiarioAnterior=parseFloat(salarioDiarioAnteriorsp);     
    if(salarioDiario <= salarioDiarioAnterior && registroPatronal==registroPatronalAnterior ){
     // alert("error no puedes bajar el saliario del empleado debes dar de baja al empleado ");
                      var alertMsg1="<div id='alertMsg111111' class='alert alert-danger'><strong>No puedes bajar el salario del empleado</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#alertMsg111111").html(alertMsg1);
                    $('#alertMsg111111').delay(3000).fadeOut('slow');



     return 0;
    }
     else if(salarioDiario!=salarioDiarioAnterior && registroPatronal==registroPatronalAnterior){
        //alert("se modifico salario");
            tipomovimiento=4;
      }else if(salarioDiario==salarioDiarioAnterior && registroPatronal!=registroPatronalAnterior){
      // alert("se modifico registropatronal");
            tipomovimiento=5;
      }else if(salarioDiario!=salarioDiarioAnterior && registroPatronal!=registroPatronalAnterior){
        //alert("se modifico salario y reg patronal");
            tipomovimiento=6;
      }else{$('#myModalEditarDatosImss').modal('hide');
        return 0;
      }
       
        $.ajax({
            type: "POST",
            url: "ajax_actualizarDatosCuadroImss.php",
            data: {"numeroEmpleado":numeroEmpleado, "salarioDiario":salarioDiario, "registroPatronal":registroPatronal,"tipomovimiento":tipomovimiento},
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;
                if (response.status=="success") {
                  datosGuardadosPadre=1;
                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Actualizacion Datos Cuadro</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#alertMsg").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    $('#myModalEditarDatosImss').modal('hide');
                    $(document).scrollTop(0);
                     if(salarioDiario!=salarioDiarioAnterior || registroPatronal!=registroPatronalAnterior){
                        inserthistoricomovimss(numeroEmpleado,tipomovimiento,salarioDiario,registroPatronal,fechaingreso,fechabaja,diastranscurridos);
                      }
                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en la actualizacion Datos Cuadro:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#alertMsg").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    $(document).scrollTop(0);
                }
              },
            error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
        });

  }

  function inserthistoricomovimss(numeroEmpleado,tipomovimiento,salarioDiario,registroPatronal,fechaingreso,fechabaja,diastranscurridos){
    
    var elementosNumeroEmpleado = numeroEmpleado.split ("-");
    var entidademp = elementosNumeroEmpleado[0];
    var consecutivoemp = elementosNumeroEmpleado[1];
    var categoriaemp = elementosNumeroEmpleado[2];
    /*
    var entidademp=numeroEmpleado.substring(0,2);
    var consecutivoemp=numeroEmpleado.substring(3,7);
    var categoriaemp=numeroEmpleado.substring(8,10);*/
    $.ajax({
            type: "POST",
            url: "ajax_inserthistoryimmsmodifysueldoandregpat.php",
            data: {"entidademp":entidademp, "consecutivoemp":consecutivoemp, "categoriaemp":categoriaemp,
                    "tipomovimiento":tipomovimiento,"salarioDiario":salarioDiario,"registroPatronal":registroPatronal
                    ,"fechaingreso":fechaingreso,"fechabaja":fechabaja,"diastranscurridos":diastranscurridos},
            dataType: "json",
            success: function(response) {
                        styleTable3();
                        //alert();
                        //styleTableImss();

              },
           error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
        });


  }

//funciones que haces desaparecer el btn de excel por si el usuario mueve un selector antes de descargar
//debe traer justamente los datos que en ese miomento esten en pantalla
$("#fechaAltaPeriodo1").change(function(){
    $("#divbtnexcel").hide();
});
$("#fechaAltaPeriodo2").change(function(){
   $("#divbtnexcel").hide();
});
   function downloadexcelcuadroantiguedad() {
     //var accion = $("#hdnaccionexcel").val();
     var fechinicio = $("#fechaAltaPeriodo1").val();
    var fechafin = $("#fechaAltaPeriodo2").val();
     window.open("ajax_downloadexcelcuadroantiguedad.php?finicio=" + fechinicio + "&" + "ffin=" + fechafin, '_self');
    //alert(fechinicio);
 }
</script>
