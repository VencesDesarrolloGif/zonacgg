<div id='msgErrorVacacionesLab' name='msgErrorVacacionesLab' ></div>
<center><h3>Confirmación De Dias de Vacaciones Para Finiquito</h3></center><br>
<center>
    <img title='Consulta/Cargar/Actualizar Pagina' src='img/ActualizarEjecutar.jpg' class='cursorImg' id='btnguardar' onclick="consultaFiniquitosVacacionesPendientes();" width="50px"><br><br>
    <span class="add-on">Fecha Inicio:</span>
    <input class="input-medium" id="fechaInicioDiasVacacionesLab" name="fechaInicioDiasVacacionesLab" type="date">
    <span class="add-on">Fecha Fin:</span>
    <input class="input-medium" id="fechaTerminoDisasVacacionesLab" name="fechaTerminoDisasVacacionesLab" type="date">
</center>
<br>
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="ModalDiasVacaciones" name="ModalDiasVacaciones" >
  <div id="MsgDiasVacaciones"></div>
   <div class="modal-header">
      <h4 align="center"> <img src="img/ok.png">Dias De Vacaciones Finiquitos</h4>
    </div>
    <div class="modal-body">
        <div class="input-prepend" align="center">
          <span class="add-on">#Empleado</span>
          <input id="NumeroEmpleadoDiasVacaciones" name="NumeroEmpleadoDiasVacaciones" type="text" class="input-medium" readonly="true">
          <span class="add-on">Dias Totales</span>
          <input id="DiasTotalesVacaciones" name="DiasTotalesVacaciones" type="text" class="input-small" readonly="true">
        </div>
        <div class="input-prepend" align="center">
          <span class="add-on">Dias Aceptados</span>
          <input id="entidad" name="entidad" type="hidden" class="input-small">
          <input id="consecutivo" name="consecutivo" type="hidden" class="input-small">
          <input id="tipo" name="tipo" type="hidden" class="input-small">
          <input id="FolioBaja" name="FolioBaja" type="hidden" class="input-small">
          <input id="UltimoAniversario" name="UltimoAniversario" type="hidden" class="input-small">
          <input id="DiasTotales" name="DiasTotales" type="hidden" class="input-small">
          <input id="opcionEditar" name="opcionEditar" type="hidden" class="input-small">
          <input id="DiasVacacionesAcaptadas" name="DiasVacacionesAcaptadas" type="text" class="input-small">
        </div>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick='DiasVacacionesEditadas();'>Aceptar</button>
      </div>
    </div>  <!-- FIN MODAL confirmacion imss-->
<section>
  <table id="tablaConfirmacionVacacionesFiniquito"  width="100%" class="records_list table table-striped table-bordered table-hover" cellspacing="0" style="display: none;">
    <thead>
      <tr>
        <th style="text-align: center;background-color: #B0E76E">Número empleado</th>
        <th style="text-align: center;background-color: #B0E76E">Nombre Empleado</th>
        <th style="text-align: center;background-color: #B0E76E">Fecha Alta</th>
        <th style="text-align: center;background-color: #B0E76E">Fecha Baja</th>
        <th style="text-align: center;background-color: #B0E76E">roloperativo</th>
        <th style="text-align: center;background-color: #B0E76E">Dias Aniversarios Pasados</th>
        <th style="text-align: center;background-color: #B0E76E">Dias ultimo Aniversario</th>
        <th style="text-align: center;background-color: #B0E76E">Total Dias Aniversarios</th>
        <th style="text-align: center;background-color: #B0E76E">Confirmar</th>
        <th style="text-align: center;background-color: #B0E76E">Rechazar</th>
        <th style="text-align: center;background-color: #B0E76E">Editar</th>
      </tr>
    </thead>
  </table>
</section>
<script type="text/javascript">

    function consultaFiniquitosVacacionesPendientes(){
      var fechaInicioDiasVacacionesLab = $("#fechaInicioDiasVacacionesLab").val();
      var fechaTerminoDisasVacacionesLab = $("#fechaTerminoDisasVacacionesLab").val();
      if(fechaInicioDiasVacacionesLab != "" && fechaTerminoDisasVacacionesLab ==""){
        var mensajee = "Ingrese La Fecha Fin";
        $("#tablaConfirmacionVacacionesFiniquito").hide();
        ErrorVacionesLaborales(mensajee);
        var caso='1';
      }else if(fechaInicioDiasVacacionesLab == "" && fechaTerminoDisasVacacionesLab !=""){
        var mensajee = "Ingrese La Fecha De Inicio";
        $("#tablaConfirmacionVacacionesFiniquito").hide();
        ErrorVacionesLaborales(mensajee);
        var caso='2';
      }else if(fechaInicioDiasVacacionesLab > fechaTerminoDisasVacacionesLab){
        var mensajee = "La Fecha De Inicio NO Puede Ser Mayor Que La Fecha Final";
        $("#tablaConfirmacionVacacionesFiniquito").hide();
        ErrorVacionesLaborales(mensajee);
        var caso='3';
      }else if(fechaInicioDiasVacacionesLab != "" && fechaTerminoDisasVacacionesLab !=""){
        var caso='4';
      }else if(fechaInicioDiasVacacionesLab == "" && fechaTerminoDisasVacacionesLab ==""){
        var caso='5';
      }
      if(caso=="4" || caso=='5'){
        waitingDialog.show();
        $("#tablaConfirmacionVacacionesFiniquito").show();
        tableVacacionesFini = [];
        $.ajax ({
          type: "POST",
          url: "ajax_consultaFiniquitosConfirmacionVacaciones.php",
          data:{"fechaInicioDiasVacacionesLab":fechaInicioDiasVacacionesLab,"fechaTerminoDisasVacacionesLab":fechaTerminoDisasVacacionesLab,"caso":caso},
          dataType: "json",
          success: function (response) {
            if (response.status == "success") {
              for (var i = 0; i < response.datos.length; i++) {
                var record = response.datos[i];
                tableVacacionesFini.push(record);
              }
              loadDataInTablaVacacionesFiniquitoss(tableVacacionesFini);
              waitingDialog.hide();  
            }else{
              waitingDialog.hide();
            }
          },
          error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
            waitingDialog.hide(); 
          }
        });
      }
    }
  var tablaVacacionesFi = null;
  function loadDataInTablaVacacionesFiniquitoss(data) {
   if (tablaVacacionesFi != null) {
     tablaVacacionesFi.destroy();
   }
   tablaVacacionesFi = $('#tablaConfirmacionVacacionesFiniquito').DataTable({
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
     "columns": [{
           "data": "NumeroEmpleado"
        },{"data": "NombreEmpleado"
        },{"data": "FechaAltaImss"
        },{"data": "fechaBajaImss"
        },{"data": "roloperativo"
        },{"className": "dt-body-center","data": "AniversariosPasados"
        },{"className": "dt-body-center","data": "Ultimoaniversario"
        },{"className": "dt-body-center","data": "TotalAniversarios"
        },{"className": "dt-body-center","data": "Confirmar"
        },{"className": "dt-body-center","data": "Rechazar"
        },{"className": "dt-body-center","data": "Editar"
        },],
         // ]
         //,serverSide: true
         processing: true,
         dom: 'Bfrtip',
         buttons: ['excel']
       });
     }

  function ConfirmarRechazarEditarDiasVacacionesFiniquito(entidad,consecutivo,tipo,TotalDias,opcion, folioTxtBaja){

    $.ajax ({
      type: "POST",
      url: "ajax_UpdateFiniquitoVacacionesPendientes.php",
      data: {"entidad":entidad,"consecutivo":consecutivo,"tipo":tipo,"TotalDias":TotalDias},
      dataType: "json",
      async: false,
      success: function (response) {
        if (response.status == "success") {
          calculoFiniquito(folioTxtBaja); 
          if(opcion=="3");{$("#ModalDiasVacaciones").modal("hide");}
          alert("Vacaciones Pendientes Agregadas Correctamente");
          consultaFiniquitosVacacionesPendientes();
        }
        else{
          alert("error");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText); 
      }
    });
  }

  function EditarDiasVacacionesFiniquito(entidad,consecutivo,tipo,DiasTotales,opcionEditar,folioTxtBaja,UltimoAniversario){

    var NumeorEmpleado = entidad+"-"+consecutivo+"-"+tipo;
    $("#NumeroEmpleadoDiasVacaciones").val(NumeorEmpleado);
    $("#DiasTotalesVacaciones").val(DiasTotales);   
    $("#entidad").val(entidad);
    $("#consecutivo").val(consecutivo);
    $("#tipo").val(tipo);
    $("#FolioBaja").val(folioTxtBaja);
    $("#DiasTotales").val(DiasTotales);
    $("#opcionEditar").val(opcionEditar);
    $("#UltimoAniversario").val(UltimoAniversario);
    $("#DiasVacacionesAcaptadas").val("");
    $("#ModalDiasVacaciones").modal();
  }

  function DiasVacacionesEditadas(){

    var entidad = $("#entidad").val();
    var consecutivo = $("#consecutivo").val();
    var tipo = $("#tipo").val();
    var FolioBaja = $("#FolioBaja").val();
    var DiasTotales = $("#DiasTotales").val();
    var DiasVacacionesAcaptadas = $("#DiasVacacionesAcaptadas").val();
    var opcionEditar = $("#opcionEditar").val();
    var UltimoAniversario = $("#UltimoAniversario").val();
    var Resta = DiasTotales-DiasVacacionesAcaptadas;
   // var RestaUltimoAniversario = DiasVacacionesAcaptadas-UltimoAniversario;
    //alert(RestaUltimoAniversario + "RestaUltimoAniversario");


    if(DiasVacacionesAcaptadas==""){
      alert("El Campo Dias Aceptados No Puede Estar Vacio");
      $("#DiasVacacionesAcaptadas").val("");
    }else if(!/^([0-9])*$/.test(DiasVacacionesAcaptadas)){
      alert("Ingresa Los dias Aceptados Sin Puntos Ni Letras (Solo Números)");
      $("#DiasVacacionesAcaptadas").val("");
    }else if(DiasVacacionesAcaptadas>"18"){
      alert("Los Dias Aceptados No Pueden Ser Mayor A 18 Ingresa Un Numero Menor");
      $("#DiasVacacionesAcaptadas").val("");
    }else if(DiasVacacionesAcaptadas<"0"){
      alert(" Los Dias Aceptados No Pueden Ser Menor A 0 Ingresa Un Numero Mayor ");
      $("#DiasVacacionesAcaptadas").val("");
    }else if(DiasVacacionesAcaptadas<"0"){
      alert("Ingrese Los Dias De Vacaciones A Pagar Que Esten entre El Rango "+ UltimoAniversario +" A "+ DiasTotales +" Sin Puntos Decimales");
      $("#DiasVacacionesAcaptadas").val("");
    }else{
      ConfirmarRechazarEditarDiasVacacionesFiniquito(entidad,consecutivo,tipo,DiasVacacionesAcaptadas,opcionEditar,FolioBaja);
    }

  }

  function ErrorVacionesLaborales(mensajee){
    $('#msgErrorVacacionesLab').fadeIn('slow');
    alerterror="<div class='alert alert-error' id='msgErrorVacacionesLab'>"+mensajee+"<data-dismiss='alert'>";
    $("#msgErrorVacacionesLab").html(alerterror);
    $('#msgErrorVacacionesLab').delay(3000).fadeOut('slow');
  }

  </script>


