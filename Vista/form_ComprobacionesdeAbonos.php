 <?php
    $catalogoLineadeNegocio = $negocio->negocio_obtenerListaLineaNegocio(); 
      $fechaActualddddd= $negocio -> negocio_consultaFecha();  
?>
<div id="msgerrortblcomprobacionesdeabonos" name="msgerrortblcomprobacionesdeabonos"> </div>
  <center><h3>COMPROBACION DE ABONOS REALIZADOS </h3><h5 style="" id="titulocomprobacionesdeabonos">Lista De Comprobaciones</h5></center>
    <section>
      <center>
        <div >
            <input id="accioncomprobacionesdeabonos" value="0" type="text" style="display: none">

            <select id="sellineanegociocomprobacionesdeabonos" name="sellineanegociocomprobacionesdeabonos" class="input-large " onChange="">
              <option value="0">Linea de Negocio</option>
              <?php
                for ($i = 0; $i < count($catalogoLineadeNegocio); $i++) {
                echo "<option value='" . $catalogoLineadeNegocio[$i]["idLineaNegocio"] . "'>" . $catalogoLineadeNegocio[$i]["descripcionLineaNegocio"] .     " </option>";
                }
              ?>
            </select>

            <select class="span3 " id="selectEntidadescomprobacionesdeabonos" name="selectEntidadescomprobacionesdeabonos" >
              <option value="0">ELIJA LA ENTIDAD</option>
              <?php
              for ($i = 0; $i < count($catalogoEntidadesFederativas); $i++){
                echo "<option value='" . $catalogoEntidadesFederativas[$i]["idEntidadFederativa"] . "'>" . $catalogoEntidadesFederativas[$i]["nombreEntidadFederativa"] . " </option>";
              }
             ?>
          </select>
        </div><br>
        <div>
          <input class="span3 input-medium"  id="fechadehoy" name="fechadehoy" type="date" style="display: none"  value= <?php echo $fechaActualddddd['0']["fechaActual"]; ?> >
         
            <label class="control-label label  " for="fechaIniciocomprobacionesdeabonos">Fecha Inicio</label>
            <input class="span3 input-medium"  id="fechaIniciocomprobacionesdeabonos" name="fechaIniciocomprobacionesdeabonos" type="date"  >

            <label class="control-label label  " for="fechaFinalcomprobacionesdeabonos">Fecha Final</label>
            <input class="span3 input-medium"  id="fechaFinalcomprobacionesdeabonos" name="fechaFinalcomprobacionesdeabonos" type="date"  >
          
        </div><br>
        <div >
          <button style="margin-bottom: 0.5%" type="button" class="btn btn-primary" onclick="obtenerlistadecomprobaciones();">Buscar</button>
        </div>
      </center>
    <div id="muestratablacomprobacionesdeabonos" style="display:none; max-width: 110rem;">
      <table id="tablacomprobacionesdeabonos"  width="100%">
        <thead>
          <tr>
            <th style="text-align: center;background-color: #85CFE9">El Movimiento Fue</th>
            <th style="text-align: center;background-color: #85CFE9">Estatus </th>
            <th style="text-align: center;background-color: #85CFE9">Fecha De Comprobación </th>
            <th style="text-align: center;background-color: #85CFE9">Linea De Negocio </th>
            <th style="text-align: center;background-color: #85CFE9">Entidad </th>
            <th style="text-align: center;background-color: #85CFE9">Departamento </th>
            <th style="text-align: center;background-color: #85CFE9">Sub Departamento</th>
            <th style="text-align: center;background-color: #85CFE9">Beneficiario</th>
            <th style="text-align: center;background-color: #85CFE9">Clave De Clasificacion</th>
            <th style="text-align: center;background-color: #85CFE9">Concepto</th>
            <th style="text-align: center;background-color: #85CFE9">Referencia</th>
            <th style="text-align: center;background-color: #85CFE9">Monto</th>
            <th style="text-align: center;background-color: #85CFE9">Documento PDF Anexado </th>
            <th style="text-align: center;background-color: #85CFE9">Revisado </th>


        </thead>
        <tbody>
      </table>
    </div>
  </section> 
 <script type="text/javascript">
$("#sellineanegociocomprobacionesdeabonos").change(function(){
    limpiaerrorescomprobacionesdeabonos();
    var lineanegociocomprobacionesdeabonos0=$("#sellineanegociocomprobacionesdeabonos").val();

    if(lineanegociocomprobacionesdeabonos0=="0" )
    {
      $("#selectEntidadescomprobacionesdeabonos").val("0");
      $("#muestratablacomprobacionesdeabonos").hide();
      $("#fechaIniciocomprobacionesdeabonos").val("");
      $("#fechaFinalcomprobacionesdeabonos").val("");
      $("#titulocomprobacionesdeabonos").html("Lista De Comprobaciones");
    }
    else 
    {
      $("#selectEntidadescomprobacionesdeabonos").val("0");
      $("#accioncomprobacionesdeabonos").val("0");
      $("#fechaIniciocomprobacionesdeabonos").val("");
      $("#fechaFinalcomprobacionesdeabonos").val("");
      $("#titulocomprobacionesdeabonos").html("Lista De Comprobaciones Por Linea De Negocio");
      obtenertablacomprobacion();    
      }
  });
  $("#selectEntidadescomprobacionesdeabonos").change(function(){
      limpiaerrorescomprobacionesdeabonos();
      var ValidacionEntidadescomprobacionesdeabonos1=$("#selectEntidadescomprobacionesdeabonos").val();
      var ValidacionLineaNegociocomprobacionesdeabonos=$("#sellineanegociocomprobacionesdeabonos").val();
     if(ValidacionLineaNegociocomprobacionesdeabonos=="0" && ValidacionEntidadescomprobacionesdeabonos1!="0")
     {
      cargaerrorescomprobacionesdeabonos("sellineanegociocomprobacionesdeabonos","Seleccione Una Linea De Negocio"); 
      $("#selectEntidadescomprobacionesdeabonos").val("0");
      $("#fechaIniciocomprobacionesdeabonos").val("");
      $("#fechaFinalcomprobacionesdeabonos").val("");
      $("#titulocomprobacionesdeabonos").html("Lista De Comprobaciones ");

      }
    else if (ValidacionLineaNegociocomprobacionesdeabonos!="0" && ValidacionEntidadescomprobacionesdeabonos1=="0")
    {
      $("#sellineanegociocomprobacionesdeabonos").val("0");
      $("#fechaIniciocomprobacionesdeabonos").val("");
      $("#fechaFinalcomprobacionesdeabonos").val("");
      $("#muestratablacomprobacionesdeabonos").hide();
      $("#titulocomprobacionesdeabonos").html("Lista De Comprobaciones "); 
    }
    else if (ValidacionLineaNegociocomprobacionesdeabonos!="0" && ValidacionEntidadescomprobacionesdeabonos1!="0")
    {
      $("#fechaIniciocomprobacionesdeabonos").val("");
      $("#fechaFinalcomprobacionesdeabonos").val("");
      $("#accioncomprobacionesdeabonos").val("2");
      $("#titulocomprobacionesdeabonos").html("Lista De Comprobaciones Por Linea De Negocio y Entidad");
      obtenertablacomprobacion();
    }
    
    });
 function obtenerlistadecomprobaciones(){
  $("#muestratablacomprobacionesdeabonos").hide();
   limpiaerrorescomprobacionesdeabonos();
    var ValidacionLineaNegociocomprobacionesdeabonos1=$("#sellineanegociocomprobacionesdeabonos").val();
    var ValidacionEntidadescomprobacionesdeabonos1=$("#selectEntidadescomprobacionesdeabonos").val();
    var ValidacionFechaIniciocomprobacionesdeabonos1=$("#fechaIniciocomprobacionesdeabonos").val();
    var ValidacionFechaFinalcomprobacionesdeabonos1=$("#fechaFinalcomprobacionesdeabonos").val();

    if(ValidacionLineaNegociocomprobacionesdeabonos1=="0"){
          cargaerrorescomprobacionesdeabonos("sellineanegociocomprobacionesdeabonos","Seleccione Una Linea De Negocio");
    }
    else if(ValidacionFechaIniciocomprobacionesdeabonos1=="" || ValidacionFechaIniciocomprobacionesdeabonos1=="0"){
             cargaerrorescomprobacionesdeabonos("fechaInicio","Seleccione Una Fecha De Inicio");
    }
    else if(ValidacionFechaFinalcomprobacionesdeabonos1=="" || ValidacionFechaFinalcomprobacionesdeabonos1=="0"){
             cargaerrorescomprobacionesdeabonos("fechaFinal","Seleccione Una Fecha Final ");
    }
    else if(ValidacionFechaFinalcomprobacionesdeabonos1<ValidacionFechaIniciocomprobacionesdeabonos1){
             cargaerrorescomprobacionesdeabonos("fechaFinal","La Fecha Final No puede Ser Menor Que La Fecha De Inicio ");
    }
    else if(ValidacionLineaNegociocomprobacionesdeabonos1!="0" && ValidacionEntidadescomprobacionesdeabonos1=="0" ){
        $("#accioncomprobacionesdeabonos").val("1");
        $("#titulocomprobacionesdeabonos").html("Lista De Comprobaciones Por Linea De Negocio y Fechas");
        obtenertablacomprobacion();
    }
    else if(ValidacionLineaNegociocomprobacionesdeabonos1!="0" && ValidacionEntidadescomprobacionesdeabonos1!="0"){
        $("#accioncomprobacionesdeabonos").val("3");
        $("#titulocomprobacionesdeabonos").html("Lista De Comprobaciones Por Linea De Negocio, Entidad Y Fechas");
        obtenertablacomprobacion();
        }
      }

function obtenertablacomprobacion(){
 limpiaerrorescomprobacionesdeabonos();
    $("#muestratablacomprobacionesdeabonos").hide();
    var lineanegocio=$("#sellineanegociocomprobacionesdeabonos").val();
    var entidades=$("#selectEntidadescomprobacionesdeabonos").val();
    var fechainicio=$("#fechaIniciocomprobacionesdeabonos").val();
    var fechafinal=$("#fechaFinalcomprobacionesdeabonos").val();
    var accion=$("#accioncomprobacionesdeabonos").val();
       tablecomprobacionesdeabonosxlinea0 = [];
             $.ajax({
                 type: "POST",
                 url: "ajax_consultatablalibromovimientos.php",
                 data:{"accioncomprobacionesdeabonos":accion,"entidadescomprobacionesdeabonos":entidades,"fechainiciocomprobacionesdeabonos":fechainicio,
                 "fechafinalcomprobacionesdeabonos":fechafinal,"lineanegociocomprobacionesdeabonos":lineanegocio},
                 dataType: "json",
                 success: function(response) {
                  console.log(response);
                     if (response.status == "success") 
                     {
                        $("#muestratablacomprobacionesdeabonos").show();
                         for (var i = 0; i < response.datos.length; i++) 
                         {                
                                  var record=response.datos[i];
                                  tablecomprobacionesdeabonosxlinea0.push(record);
                                  // console.log(tablecomprobacionesdeabonosxlinea0); 
                       }
                        loadDataInTablecomprobacionesdeabonos(tablecomprobacionesdeabonosxlinea0);
                     } else {var mensaje = response.message;}
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                     alert(jqXHR.responseText);
                 }
             });
}
 function cargarpdfComprobaciondeabono(idmovimientofinanciero,idlibromovcomproba,idlibromov,Fecha)
 {
  var idmovimientofinanciero1 = idmovimientofinanciero;
   var idlibromovcomproba1 = idlibromovcomproba;
  var idlibromov1 = idlibromov;
  var Fecha1 = Fecha;

  if (idmovimientofinanciero1==2){

       window.open("uploads/archivoComprobaciones/Comprobaciones/" + idlibromovcomproba1 +  "_" + idlibromov1 + "_" + Fecha1 + ".pdf", "_blank");  
  }else{
       window.open("uploads/archivosFinanzas/cargo/" + idlibromov1 +  "_" + Fecha1 + ".pdf", "_blank");  
  }
  
  //var idSulicitud =1;
  //window.open("uploads/archivosSolicutudPago/" + "SolicitudPago"+ idSulicitud + ".pdf", "_blank");
  }
  function datochecadoComprobaciondeabono(idmovimiento,accionSoli){
    table = [];
  $.ajax({
              type: "POST",
               url: "ajax_updatetablalibromovimientos.php",
               data:{"idmovimiento":idmovimiento,"accionSoli":accionSoli},
               dataType: "json",
               success: function(response) {
                  //console.log(response);
                     if (response.status == "success") {
                      obtenertablacomprobacion();
                     } else {var mensaje = response.message;}
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                     alert(jqXHR.responseText);
                 }
           });
 }
var tablecomprobacionesdeabono = null;
 function loadDataInTablecomprobacionesdeabonos(data) {
     if (tablecomprobacionesdeabono != null) {
         tablecomprobacionesdeabono.destroy();
     }
     tablecomprobacionesdeabonos = $('#tablacomprobacionesdeabonos').DataTable({
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
             "data": "tipomovimiento"
         },{
             "data": "Estatus"
         },{
             "data": "FechaComprobación"
         },{
             "data": "LineaNegocio"
         },{
             "data": "Entidad"
         },{
             "data": "Departamento"
         },{
             "data": "SubDepartamento"
         },{
             "data": "Beneficiario"
         },{
             "data": "ClaveClasificacion"
         },{
             "data": "Concepto"
         },{
             "data": "Referencia"
         },{"className": "dt-body-right",
             "data": "Monto"
         },{
             "data": "DocumentoPDFAnexado"
         },{
             "data": "Revisado"
         }, ],
         // ]
         //,serverSide: true
         processing: true,
         dom: 'Bfrtip',
         buttons: ['excel']
     }); 
 }
function cargaerrorescomprobacionesdeabonos(obj,mensaje){
   var Msgerror1 = "<div id='msgerrortblcomprobacionesdeabonos' class='alert alert-danger'><strong  class='text-justify'>"+mensaje+"</strong> <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#msgerrortblcomprobacionesdeabonos").html(Msgerror1);
          $("#"+obj).css('border', '#D0021B 1px solid');
 }
 function limpiaerrorescomprobacionesdeabonos(){
    $("#msgerrortblcomprobacionesdeabonos").html("");
    $("#sellineanegociocomprobacionesdeabonos").removeAttr("style");
    $("#selectEntidadescomprobacionesdeabonos").removeAttr("style");
    $("#fechaIniciocomprobacionesdeabonos").removeAttr("style");
    $("#fechaFinalcomprobacionesdeabonos").removeAttr("style");

  }
</script>
