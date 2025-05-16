<?php
 $fechaMinima="2017-01-01";
 $fechaInicio=strtotime($fechaMinima);
 $anioConsultaInicio=date('Y',$fechaInicio);
 $anioActual= DATE('Y');    
?>
<div><center><h3>REPORTE GENERAL POR REGIONES</h3></center></div>
<br>
<div align="center">
    <select id="periodoRegiones" name="periodoRegiones" class="input-large">
        <option value="0">PERIODO</option><option value="1">ENERO</option><option value="2">FEBRERO</option>
        <option value="3">MARZO</option><option value="4">ABRIL</option><option value="5">MAYO</option>
        <option value="6">JUNIO</option><option value="7">JULIO</option><option value="8">AGOSTO</option>
        <option value="9">SEPTIEMBRE</option><option value="10">OCTUBRE</option><option value="11">NOVIEMBRE</option><option value="12">DICIEMBRE</option>
    </select>
    <select id="ejercicioRegiones" name="ejercicioRegiones" data-live-search="true" class="input-large" data-size="9">
                      <option value="0">EJERCICIO</option>
                      <?php
                        for($i = $anioConsultaInicio; $i <= $anioActual; $i++) {                                
                          echo "<option value='" . $i. "'>" . $i. " </option>";
                        }
                      ?>
    </select>
<div align="center">
    <select id="selLineaNegocioRegiones" name="selLineaNegocioRegiones" class="input-large"></select>
    <select id="selRegiones" name="selRegiones" class="input-large" style="display: none;"></select>
    <select id="selEntidadesRegiones" name="selEntidadesRegiones" class="input-large" style="display: none;"></select>
</div>
<div align="center">
    <button id="btnCalcularCoberturaRegistro" name="btnCalcularCoberturaRegistro" class="btn btn-primary" type="button">CALCULAR</button>
</div>
<br><br>
<section>
    <table id="tablaCoberturaGeneral"  class="records_list table table-striped table-bordered table-hover" style="display: none;" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="text-align: center;background-color: #B0E76E">Region</th>
                <th style="text-align: center;background-color: #B0E76E">Entidad</th>
                <th style="text-align: center;background-color: #B0E76E"># Vehiculos</th>
                <th style="text-align: center;background-color: #B0E76E"># Puntos</th>
                <th style="text-align: center;background-color: #B0E76E">Elementos Requisición Ventas</th>       
                <th style="text-align: center;background-color: #B0E76E">Estado De Fuerza Operativa</th>       
                <th style="text-align: center;background-color: #B0E76E">Estado De Fuerza Administrativa</th>       
                <th style="text-align: center;background-color: #B0E76E">Estado De Fuerza Cubre</th>       
                <th style="text-align: center;background-color: #B0E76E">12X12X7</th>
                <th style="text-align: center;background-color: #B0E76E">12X12X6</th>
                <th style="text-align: center;background-color: #B0E76E">12x12x5</th> 
                <th style="text-align: center;background-color: #B0E76E">12X12X3</th> 
                <th style="text-align: center;background-color: #B0E76E">12X24X7</th> 
                <th style="text-align: center;background-color: #B0E76E">24X24X7</th> 
                <th style="text-align: center;background-color: #B0E76E">NO DEFINIDO</th> 
                <th style="text-align: center;background-color: #B0E76E">HORARIO DE OFICINA</th> 
                <th style="text-align: center;background-color: #B0E76E"># SUPERVISOR</th> 
                <th style="text-align: center;background-color: #B0E76E"># RECLUTADOR</th> 
                <th style="text-align: center;background-color: #B0E76E"># LIDER UNIDAD</th> 
                <th style="text-align: center;background-color: #B0E76E">Conteo General Cobertura(Ventas)</th>
                <th style="text-align: center;background-color: #B0E76E">Cobertura Dia(Ventas)</th> 
                <th style="text-align: center;background-color: #B0E76E">Cobertura Noche(Ventas)</th> 
                <th style="text-align: center;background-color: #B0E76E">Estimación De Cubre Turnos(7)</th>
            </tr>
        </thead>
   </table>
</section>
</div>
<script type="text/javascript"> //empieza lo de js

$(CargarselectorLineaNegocioRegiones());  

   $("#btnCalcularCoberturaRegistro").click(function() {
    var selLineaNegocioRegiones = $("#selLineaNegocioRegiones").val();
    var selRegiones = $("#selRegiones").val();
    var selEntidadesRegiones = $("#selEntidadesRegiones").val();
    var periodoRegiones = $("#periodoRegiones").val();
    var ejercicioRegiones = $("#ejercicioRegiones").val();
    var bandera = 0;
    var bandera1 = 0;
    var bandera2 = 0;
    if(selLineaNegocioRegiones!="" && selLineaNegocioRegiones!="null" && selLineaNegocioRegiones!=null && selLineaNegocioRegiones!="0" && selLineaNegocioRegiones!=0){ bandera= 1; }else{ bandera= 0; }
    if(selRegiones != "" && selRegiones !="null" && selRegiones !=null && selRegiones !="0" && selRegiones !=0){ bandera= 2; }
    if(selEntidadesRegiones != "" && selEntidadesRegiones !="null" && selEntidadesRegiones !=null && selEntidadesRegiones !="0" && selEntidadesRegiones !=0){ bandera= 3;}
    if(periodoRegiones=="0" || periodoRegiones=="NULL" || periodoRegiones=="null" || periodoRegiones=="" || periodoRegiones==null){
        bandera1=0;
    }else{ 
        if(ejercicioRegiones=="0" || ejercicioRegiones=="NULL" || ejercicioRegiones=="null" || ejercicioRegiones=="" || ejercicioRegiones==null ){
            alert("AL Seleccionar Periodo Debe Seleccionar el Ejercicio Para Realizar El Calculo");
            bandera2 = "1";
        }else{
            bandera1=1;
        }
    }
    if(bandera=="0"){
        alert("Seleccione una linea de negocio para calcular la cobertura");
        $("#tablaCoberturaGeneral").hide();
    }else{
        if(bandera2 == "1"){
            $("#tablaCoberturaGeneral").hide();
        }else{
            ConsultaCoberturaPorRegionGeneral(selLineaNegocioRegiones,selRegiones,selEntidadesRegiones,periodoRegiones,bandera,bandera1,ejercicioRegiones);
            $("#tablaCoberturaGeneral").show();
        }
    }
   });

   $("#periodoRegiones").change(function() {
        var periodoRegiones1 = $("#periodoRegiones").val();
        if(periodoRegiones1=="0"){
            $("#ejercicioRegiones").hide();
        }else{
            $("#ejercicioRegiones").show();
        }
        $("#ejercicioRegiones").val(0);
   });

   function CargarselectorLineaNegocioRegiones(){
    $.ajax({
      type: "POST",
      url: "ajax_ObtenerLineaNegocioRegiones.php",
      dataType: "json",
      success: function(response) {
        //console.log(response.placas);
        $("#selLineaNegocioRegiones").empty().append('<option value="0">LINEA NEGOCIO</option>');      
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#selLineaNegocioRegiones').append('<option value="' + (response.datos[i].idLineaNegocio) + '">' + response.datos[i].descripcionLineaNegocio + '</option>');
          }
        }else{
          alert("Error al cargar Lineas de Negocio");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }

   $("#selLineaNegocioRegiones").change(function() {
    var selLineaNegocioRegiones = $("#selLineaNegocioRegiones").val();
    if(selLineaNegocioRegiones !="0"){
        $.ajax({
      type: "POST",
      data: {"selLineaNegocioRegiones" : selLineaNegocioRegiones},
      url: "ajax_ObtenerRegiones.php",
      dataType: "json",
      success: function(response) {
        //console.log(response.placas);
        $("#selRegiones").empty().append('<option value="0">REGIONES</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#selRegiones').append('<option value="' + (response.datos[i].idRegionI) + '">' + response.datos[i].DescripcionI + '</option>');
          }
        $("#selRegiones").show();
        $("#selEntidadesRegiones").hide();
        $("#selEntidadesRegiones").empty();
        }else{
          alert("Error al cargar motivo de Baja");
          $("#selRegiones").hide();
          $("#selRegiones").empty();
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
        $("#selRegiones").hide();
        $("#selRegiones").empty();
      }
    });
    }else{
        $("#selRegiones").hide();
        $("#selEntidadesRegiones").hide();
        $("#selRegiones").empty();
        $("#selEntidadesRegiones").empty();
    }
  });
  $("#selRegiones").change(function() {
    var selLineaNegocioRegiones = $("#selLineaNegocioRegiones").val();
    var selRegiones = $("#selRegiones").val();
    if(selRegiones!="0"){
        $.ajax({
            type: "POST",
            url: "ajax_ObtenerEntidadesPorRegion.php",
            data: {"selLineaNegocioRegiones": selLineaNegocioRegiones,"selRegiones": selRegiones},
            dataType: "json",
            success: function(response) {
              var datos = response.datos;
              //console.log(response);
              $('#selEntidadesRegiones').empty().append('<option value="0">ENTIDAD</option>');
              $.each(datos, function(i) {
                  $('#selEntidadesRegiones').append('<option value="' + response.datos[i].idEntidadFederativa + '">' + response.datos[i].nombreEntidadFederativa +'</option>');
                });
              $("#selEntidadesRegiones").show();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
                $("#selEntidadesRegiones").hide();
                $("#selEntidadesRegiones").empty();
            }
        });
    }else{
        $("#selEntidadesRegiones").hide();
        $("#selEntidadesRegiones").empty();
    }
  });

 function ConsultaCoberturaPorRegionGeneral(lineaNegocioregion,region,entidadregion,periodoRegiones,casoConsulta,casoFechas,ejercicioRegiones) { 
    waitingDialog.show();
    tablaCoberturaGeneralArray = [];
    $.ajax({
        type: "POST",
        url: "ajax_ConsultaCoberturaPorRegionGeneral.php",
        data: {"lineaNegocioregion": lineaNegocioregion,"region": region,"entidadregion": entidadregion,"periodoRegiones": periodoRegiones,"casoConsulta": casoConsulta,"casoFechas": casoFechas,"ejercicioRegiones": ejercicioRegiones},
        dataType: "json", 
        async: false,
        success: function(response) {
            if (response.status == "success") {
                 for (var i = 0; i < response.datos.length; i++) {
                     var record = response.datos[i];
                     tablaCoberturaGeneralArray.push(record);
                 }
                 waitingDialog.hide();
                 loadDataIntableCoberturaGeneral(tablaCoberturaGeneralArray);
                 
             } else {
                 var mensaje = response.message;
                 waitingDialog.hide();
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();
        }
    });
 }
 var tablaCoberGeneral = null;

 function loadDataIntableCoberturaGeneral(data) {
     if (tablaCoberGeneral != null) {
         tablaCoberGeneral.destroy();
     }
     tablaCoberGeneral = $('#tablaCoberturaGeneral').DataTable({
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
             "data": "region"
         },
         {  
             "data": "EntidadesRegion"
         },
         {  
             "data": "TotalVehiculos"
         },
         {  
             "data": "TotalPuntos"
         },
         {  
             "data": "RequisicionVentas"
         },
         {  
             "data": "TotalElementosOp"
         },
         {  
             "data": "TotalElementosTA"
         },
         {  
             "data": "TotalElementosOpGif"
         },

         {  
             "data": "Rol12x7"
         },
         {  
             "data": "Rol12x6"
         }, 
         {  
             "data": "Rol12x5"
         },
         {  
             "data": "Rol12x3"
         },
         {  
             "data": "Rol24x7"
         },
         {  
             "data": "Rol24x24"
         },
         {  
             "data": "RolNA"
         },
         {  
             "data": "RolOF"
         },
         {  
             "data": "RolSup"
         },
         {  
             "data": "RolRec"
         },
         {  
             "data": "RolLid"
         },
         {  
             "data": "turnosPorDia"
         },
         {  
             "data": "turnoDeDia"
         },
         {  
             "data": "turnosDeNoche"
         },
         {  
             "data": "estimadoCubre"
         }, ],
         processing: true,
         dom: 'Bfrtip',

          buttons: {
        buttons: ['excel']
    }
         
     });
 }

 

 </script>