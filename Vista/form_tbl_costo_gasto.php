 <?php

if ($usuario["rol"] == "Tesoreria" or $usuario["rol"] == "Finanzas") {
    $catalogoLineadeNegocio = $negocio->negocio_obtenerListaLineaNegocio(); 
      $fechaActual= $negocio -> negocio_consultaFecha();  
}
?>
<div id="msgerrortblgastocosto" name="msgerrortblgastocosto"> </div>
  <center><h3>Tipo Gasto / Costo </h3><h5 style="" id="titulogastocosto">Tendencia de abono</h5></center>
    <section>
      <center>
        <div >
            <input id="acciongastocosto" value="0" type="hidden">

            <select id="sellineanegociogastocosto" name="sellineanegociogastocosto" class="input-large " onChange="">
              <option value="0">Linea de Negocio</option>
              <option value="TODOS">TODOS</option>
              <?php
                for ($i = 0; $i < count($catalogoLineadeNegocio); $i++) {
                echo "<option value='" . $catalogoLineadeNegocio[$i]["idLineaNegocio"] . "'>" . $catalogoLineadeNegocio[$i]["descripcionLineaNegocio"] .     " </option>";
                }
              ?>
            </select>

            <select class="span3 " id="selectEntidadesGastoCosto" name="selectEntidadesGastoCosto" >
              <option value="0">ELIJA LA ENTIDAD</option>
              <?php
              for ($i = 0; $i < count($catalogoEntidadesFederativas); $i++){
                echo "<option value='" . $catalogoEntidadesFederativas[$i]["idEntidadFederativa"] . "'>" . $catalogoEntidadesFederativas[$i]["nombreEntidadFederativa"] . " </option>";
              }
             ?>
          </select>
        </div><br>
        <div>

            <label class="control-label label  " for="fecha1">Fecha Inicio</label>
            <input class="span3 input-medium"  id="fechaInicio" name="fechaInicio" type="date"   value= <?php echo $fechaActual['0']["fechaActual"]; ?> >

            <label class="control-label label  " for="fecha2">Fecha Final</label>
            <input class="span3 input-medium"  id="fechaFinal" name="fechaFinal" type="date"   value= <?php echo $fechaActual['0']["fechaActual"]; ?> >
          
        </div><br>
        <div >
          <button style="margin-bottom: 0.5%" type="button" class="btn btn-primary" onclick="buscarmovimientosgastocostodiarios();">Buscar</button>
        </div>
      </center>
    <div id="muestratablagastocosto" style="display:none; max-width: 110rem;">
      <table id="tablagastocosto"  width="100%">
        <thead>
          <tr>
            <th style="text-align: center;background-color: #85CFE9">Linea De Negocio </th>
            <th style="text-align: center;background-color: #85CFE9">Concepto</th>
            <th style="text-align: center;background-color: #85CFE9">Costo Fijo</th>
            <th style="text-align: center;background-color: #85CFE9">Costo Variable</th>
            <th style="text-align: center;background-color: #85CFE9">Gasto Fijo</th>
            <th style="text-align: center;background-color: #85CFE9">Gasto Variable</th>
            <th style="text-align: center;background-color: #85CFE9">Total De Tasa Iva</th>


        </thead>
        <tbody>
      </table>
    </div>
  </section> 
 <script type="text/javascript">

$("#sellineanegociogastocosto").change(function(){
    var sellineanegociogastocosto=$("#sellineanegociogastocosto").val();
       $("#selectEntidadesGastoCosto").val("0");
       $("#fechaInicio").val("<?php echo date("Y-m-d");?>" );
       $("#fechaFinal").val("<?php echo date("Y-m-d");?>" );
    if(sellineanegociogastocosto==0){
      cargaerroresgastocosto1("sellineanegociogastocosto","Seleccione Una Linea De Negocio");
       $("#muestratablagastocosto").hide();
    }   
    else{
      limpiaerroresgastocosto1();
      var acciongastocosto=0;
      var entidasgastocosto=0;
      var fechainicio0=0;
      var fechafinal0=0;
      var lineanegociogastocosto=$("#sellineanegociogastocosto").val();

       tablegastocostoxlinea0 = [];
             $.ajax({
                 type: "POST",
                 url: "ajax_consultatablacostogasto.php",
                 data:{"lineanegociogastocosto":lineanegociogastocosto,"acciongastocosto":acciongastocosto,"entidasgastocosto":entidasgastocosto,
                 "fechainicio":fechainicio0,"fechafinal":fechafinal0},
                 dataType: "json",
                 success: function(response) {
                  console.log(response); 
                  var iteracion =response[1].lineaneg;
                  for(var j = 1; j<= iteracion; j++){
                     if (response[j].status == "success") {
                        $("#muestratablagastocosto").show();
                          $("#titulogastocosto").html("Gasto/Costo Diario");
                         for (var i = 0; i < response[j].datos.length; i++) {
                             var record = response[j].datos[i];
                             tablegastocostoxlinea0.push(record);
                            // console.log(record);
                         }
                         loadDataInTablegastocosto(tablegastocostoxlinea0);
                     } else {var mensaje = response[j].message;}
                   }
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                     alert(jqXHR.responseText);
                 }
             });
      }
  });

  $("#selectEntidadesGastoCosto").change(function(){
     limpiaerroresgastocosto1();
    var ValidacionEntidades1=$("#selectEntidadesGastoCosto").val();
    if(ValidacionEntidades1==0){
    $("#muestratablagastocosto").hide();
    $("#sellineanegociogastocosto").val("0");

  }else{
    $("#muestratablagastocosto").hide();
  }
    });

 function buscarmovimientosgastocostodiarios(){
  $("#muestratablagastocosto").hide();
    limpiaerroresgastocosto1();
    var ValidacionLineaNegocio=$("#sellineanegociogastocosto").val();
    var ValidacionEntidades=$("#selectEntidadesGastoCosto").val();
    var ValidacionFechaInicio=$("#fechaInicio").val();
    var ValidacionFechaFinal=$("#fechaFinal").val();

    if(ValidacionLineaNegocio=="0"){
          cargaerroresgastocosto1("sellineanegociogastocosto","Seleccione Una Linea De Negocio");
    }
    else if(ValidacionFechaInicio=="" || ValidacionFechaInicio=="0"){
             cargaerroresgastocosto1("fechaInicio","Seleccione Una Fecha De Inicio");
    }
    else if(ValidacionFechaFinal=="" || ValidacionFechaFinal=="0"){
             cargaerroresgastocosto1("fechaFinal","Seleccione Una Fecha Final ");
    }
    else if(ValidacionFechaFinal<ValidacionFechaInicio){
             cargaerroresgastocosto1("fechaFinal","La Fecha Final No puede Ser Menor Que La Fecha De Inicio ");
    }
    else if(ValidacionLineaNegocio!="0" && ValidacionEntidades=="0" && ValidacionFechaFinal!="" && ValidacionFechaInicio!="" && (ValidacionFechaFinal>ValidacionFechaInicio || ValidacionFechaFinal==ValidacionFechaInicio) ){
          buscarmivimientosxlineadenegocioyfechas();
    }
    else if((ValidacionLineaNegocio!="0") && (ValidacionEntidades!="0") && ValidacionFechaFinal!="" && ValidacionFechaInicio!="" && (ValidacionFechaFinal>ValidacionFechaInicio || ValidacionFechaFinal==ValidacionFechaInicio)){
          buscarmovimientosxlienadenegocioxentidadesyfechas();
        }
      }
 var tablegastcost = null;
 function loadDataInTablegastocosto(data) {
     if (tablegastcost != null) {
         tablegastcost.destroy();
     }
     tablegastcost = $('#tablagastocosto').DataTable({
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
            "className": "dt-body-right",
             "data": "LineaNegocio"
         },{"className": "dt-body-right",
             "data": "cancepto"
         },{"className": "dt-body-right",
             "data": "costofijo"
         },{"className": "dt-body-right",
             "data": "costovariable"
         },{"className": "dt-body-right",
             "data": "gastodirecto"
         },{"className": "dt-body-right",
             "data": "gastoindirecto"
         },{"className": "dt-body-right",
             "data": "totalIva"
         }, ],
         // ]
         //,serverSide: true
         processing: true,
         dom: 'Bfrtip',
         buttons: ['excel']
     }); 
 }
 function buscarmivimientosxlineadenegocioyfechas(){
  limpiaerroresgastocosto1();
  tablegastocostoxlinea1 = [];
      var acciongastocosto1=1;
      var entidasgastocosto1="0";
      var fechainicio1=$("#fechaInicio").val();
      var fechafinal1=$("#fechaFinal").val();
      var lineanegociogastocosto1=$("#sellineanegociogastocosto").val();
             $.ajax({
                 type: "POST",
                 url: "ajax_consultatablacostogasto.php",
                 data:{"lineanegociogastocosto":lineanegociogastocosto1,"acciongastocosto":acciongastocosto1,"entidasgastocosto":entidasgastocosto1,"fechainicio":fechainicio1,"fechafinal":fechafinal1},
                 dataType: "json",
                 success: function(response) {
                  var iteracion =response[1].lineaneg;
                  for(var j = 1; j<= iteracion; j++){
                     if (response[j].status == "success") {
                        $("#muestratablagastocosto").show();
                         $("#titulogastocosto").html("Gasto/Costo Por Linea De Negocio Y Fechas");
                         for (var i = 0; i < response[j].datos.length; i++) {
                             var record = response[j].datos[i];
                             tablegastocostoxlinea1.push(record);
                            // console.log(record);
                         }
                         loadDataInTablegastocosto(tablegastocostoxlinea1);
                     } else {var mensaje = response.message;}
                    } 
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                     alert(jqXHR.responseText);
                 }
             });
    }

function buscarmovimientosxlienadenegocioxentidadesyfechas(){
  limpiaerroresgastocosto1();
  tablegastocostoxlinea2 = [];
  var acciongastocosto2=2;
      var entidasgastocosto2=$("#selectEntidadesGastoCosto").val();
      var fechainicio2=$("#fechaInicio").val();
      var fechafinal2=$("#fechaFinal").val();
      var lineanegociogastocosto2=$("#sellineanegociogastocosto").val();
             $.ajax({
                 type: "POST",
                 url: "ajax_consultatablacostogasto.php",
                 data:{"lineanegociogastocosto":lineanegociogastocosto2,"acciongastocosto":acciongastocosto2,"entidasgastocosto":entidasgastocosto2,"fechainicio":fechainicio2,"fechafinal":fechafinal2},
                 dataType: "json",
                 success: function(response) {
                  //console.log(response);
                   var iteracion =response[1].lineaneg;
                  for(var j = 1; j<= iteracion; j++){
                     if (response[j].status == "success") {
                        $("#muestratablagastocosto").show();
                         $("#titulogastocosto").html("Gasto/Costo Por Linea De Negocio, Entidades Y Fechas");
                         for (var i = 0; i < response[j].datos.length; i++) {
                             var record = response[j].datos[i];
                             tablegastocostoxlinea2.push(record);
                            // console.log(record);
                         }
                         loadDataInTablegastocosto(tablegastocostoxlinea2);
                     } else {var mensaje = response.message;}
                  } 
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                     alert(jqXHR.responseText);
                 }
             });
}

 function cargaerroresgastocosto1(obj,mensaje){
   var Msgerrorgastocosto = "<div id='msgerrortblgastocosto' class='alert alert-danger'><strong  class='text-justify'>"+mensaje+"</strong> <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#msgerrortblgastocosto").html(Msgerrorgastocosto);
          $("#"+obj).css('border', '#D0021B 1px solid');
 }
 function limpiaerroresgastocosto1(){
    $("#msgerrortblgastocosto").html("");
    $("#sellineanegociogastocosto").removeAttr("style");
    $("#selectEntidadesGastoCosto").removeAttr("style");
    $("#fechaInicio").removeAttr("style");
    $("#fechaFinal").removeAttr("style");

  }


</script>
