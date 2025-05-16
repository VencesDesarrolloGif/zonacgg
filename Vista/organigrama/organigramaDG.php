<html>
  <head>
    <center>
    <table>
        <tr>
          <td valign="top"  align="center">
            <select id="selectLineaNegocio">
              <option value="0">LINEAS DE NEGOCIO</option>
            </select>
          </td>
          <td valign="top" align="center">
            <select id="selectentidad">
              <option>ENTIDADES</option>
            </select>
          </td>
          <td valign="top">
            <button id="btnagregarEntidad" class="btn btn-default" onclick="agregarEntidad(1)" disabled><span class="glyphicon glyphicon-plus"></span>Agregar</button>
          </td>
          <td valign="top">
            <button id="btnagregarEntidad" class="btn btn-default" onclick="drawChart()"><span ></span>Generar</button>
          </td>
        </tr>
        <tr>
          <td colspan="3" align="center">
            <div id="entidadesAgregadas"></div>
          </td>
        </tr>
      </table>
      </center>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {packages:["orgchart"]});
      // google.charts.setOnLoadCallback(drawChart);

      var entidadesCompletasCr = [];
      var entidadesCompletasSelect = [];
      var arrayNuevoEntidadesCompletasSelect = [];
      var entidadesSinQuitar = [];
      var arraySeleccionadas = [];
      var entidadARegresarArray = [];
$(document).ready(function() {
  consultarlineasNegocio();   
});

      function consultarlineasNegocio(){

    $.ajax({
      type: "POST",
      url: "organigrama/ajax_lineasNegocio.php",
      dataType: "json",
      success: function(response) {
      if(response.status == "success"){
         $("#selectLineaNegocio").empty(); 
         $('#selectLineaNegocio').append('<option value="0">LINEAS DE NEGOCIO</option>');
         if(response.status == "success"){
            for(var i = 0; i < response.lineas.length; i++){
                var idLineaNegocio= response.lineas[i]["idLineaNegocio"];
                $('#selectLineaNegocio').append('<option value="' + (idLineaNegocio) + '">' + response.lineas[i].descripcionLineaNegocio + '</option>');
            }
        }else{
              alert("Error Al Cargar Las Lineas de Negocio");
        }
       }
      },
      error: function(jqXHR, textStatus, errorThrown) {
         alert(jqXHR.responseText);
      }
    });
}

$('#selectLineaNegocio').change(function(){
    $("#tree").html('');
    var linea= $('#selectLineaNegocio').val();
    if(linea!='0'){
       consultarEntidades(linea);   
    }
});

function consultarEntidades(linea){

    $.ajax({
      type: "POST",
      url: "organigrama/ajax_Entidades.php",
      data:{linea},
      dataType: "json",
      success: function(response) {
      if(response.status == "success"){
         $("#selectentidad").empty(); 
         $('#selectentidad').append('<option value="0">ENTIDADES</option>');
         $('#selectentidad').append('<option value="100">TODAS</option>');
         if(response.status == "success"){
            for(var i = 0; i < response.entidades.length; i++){
                var idEntidad= response.entidades[i]["idEntidadFederativa"];
                var entidad= response.entidades[i].nombreEntidadFederativa;
                var entidadMayuscula=entidad.toUpperCase();
                entidadesCompletasCr.push(idEntidad);
                entidadesCompletasSelect.push(idEntidad);
                $('#selectentidad').append('<option value="' + (idEntidad) + '">' + entidadMayuscula + '</option>');
            }
        }else{
              alert("Error Al Cargar Las Lineas de Negocio");
        }
       }
      },
      error: function(jqXHR, textStatus, errorThrown) {
         alert(jqXHR.responseText);
      }
    });
}

$('#selectentidad').change(function(){
    $("#tree").html('');
    var ent= $('#selectentidad').val();
    if(ent=='0'){
       $('#btnagregarEntidad').prop("disabled", true);  
    }else{
       $('#btnagregarEntidad').prop("disabled", false);  
    }
});

var entidadesarray = [];
var entidadesarrayID = [];

function agregarEntidad(tipo){

    $("#entidadesAgregadas").html("");
    var entidad= $("#selectentidad").val();
    $("#entidadesAgregadas").empty();

    if(tipo=='1'){
        if(entidad=='0'){
            return;
        }

        if(entidad=='100'){
            entidadesarray = [];
            entidadesarrayID = [];
            $("#btnagregarEntidad").prop('disabled', true);
            var entidad   = $('#selectentidad').val();
            var nombreEnt = $('select[id="selectentidad"] option:selected').text();
            entidadesarray.push(nombreEnt);
            entidadesarrayID.push(entidad);
             var tblEntidadesBusqueda = "<table id='tblEntidadesBusqueda' class='table table-bordered'><thead><th>ENTIDADES</th></thead><tbody>";
            tblEntidadesBusqueda += "<tr>";
            for(var i = 0; i < entidadesarray.length; i++) {
                tblEntidadesBusqueda += "<td>"+entidadesarray[i]+"</td>";
                tblEntidadesBusqueda += "<td align='center'><img src='img/eliminar.png' title='ELIMINAR ENTIDAD' style='cursor:pointer' width='45%'; onclick='eliminarEntidad(\""+i+"\",\""+nombreEnt+"\")'/></td></tr>"  
            }
            $("#entidadesAgregadas").show();
            $("#entidadesAgregadas").html(tblEntidadesBusqueda);
            $("#selectentidad").prop('disabled', true);
            $("#btnagregarEntidad").prop('disabled', true);
            $("#selectentidad option:selected").remove();
            $("#selectentidad").val(0);
        }else{
            var entidad   = $('#selectentidad').val();
            var nombreEnt = $('select[id="selectentidad"] option:selected').text();
            entidadesarray.push(nombreEnt);
            entidadesarrayID.push(entidad);
            arrayNuevoEntidadesCompletasSelect = entidadesCompletasSelect.filter(function(f) { return f ===entidad });

            if(arrayNuevoEntidadesCompletasSelect==''){
                arraySeleccionadas=arrayNuevoEntidadesCompletasSelect;
            }else{
                var entidadelegida= arrayNuevoEntidadesCompletasSelect[0];
                 arraySeleccionadas.push(entidadelegida);
            }
            entidadesSinQuitar = entidadesCompletasSelect.filter(function(f) { return f !==entidad });
            entidadesCompletasSelect=entidadesSinQuitar;

            var tblEntidadesBusqueda = "<table id='tblEntidadesBusqueda' class='table table-bordered'><thead><th>ENTIDADES</th></thead><tbody>";
            tblEntidadesBusqueda += "<tr>";
            for(var i = 0; i < entidadesarray.length; i++) {
                tblEntidadesBusqueda += "<td>"+entidadesarray[i]+"</td>";   
                tblEntidadesBusqueda += "<td align='center'><img src='img/eliminar.png' title='ELIMINAR ENTIDAD' style='cursor:pointer' width='45%'; onclick='eliminarEntidad(\""+i+"\",\""+nombreEnt+"\")'/></td></tr>"  
            }
            $("#entidadesAgregadas").show();
            $("#entidadesAgregadas").append(tblEntidadesBusqueda);
            $("#btnagregarEntidad").prop('disabled', true);
            $("#selectentidad option:selected").remove();
            $("#selectentidad").val(0);
        }
    }else{//solo cuando se reconsulta
            var tblEntidadesBusqueda = "<table id='tblEntidadesBusqueda' class='table table-bordered'><thead><th>ENTIDADES</th></thead><tbody>";
            tblEntidadesBusqueda += "<tr>";
            for(var i = 0; i < entidadesarray.length; i++) {
                tblEntidadesBusqueda += "<td>"+entidadesarray[i]+"</td>";   
                tblEntidadesBusqueda += "<td align='center'><img src='img/eliminar.png' title='ELIMINAR ENTIDAD' style='cursor:pointer' width='45%'; onclick='eliminarEntidad(\""+i+"\",\""+nombreEnt+"\")'/></td></tr>"  
            }
            $("#entidadesAgregadas").show();
            $("#entidadesAgregadas").append(tblEntidadesBusqueda);
            $("#btnagregarEntidad").prop('disabled', true);
            $("#selectentidad").val(0);
    }
}

function eliminarEntidad(i,nombreEnt){
    $("#tree").html('');
    var linea= $('#selectLineaNegocio').val();
    if(nombreEnt=='TODAS'){
        $("#selectentidad").prop('disabled', false);
        $("#btnagregarEntidad").prop('disabled', false);
        entidadesarray = [];
        entidadesarrayID = [];
        consultarEntidades(linea);
    }else{
        var entDesc=entidadesarray[i];
        var idEnt=entidadesarrayID[i];
        $('#selectentidad').append('<option value="' + (idEnt) + '">' + entDesc + '</option>');
        entidadARegresarArray = arraySeleccionadas.filter(function(f) { return f ===idEnt });
        var entidadQuitada=entidadARegresarArray[0];
        entidadesCompletasSelect.push(entidadQuitada);
        ReconsultarEntidades(entidadesCompletasSelect);
        entidadesarray.splice(i, 1);
        entidadesarrayID.splice(i, 1);
    }
    agregarEntidad(2);
}

function ReconsultarEntidades(entidadesCompletasSelect){

    $.ajax({
      type: "POST",
      url: "organigrama/ajax_EntidadesReconsulta.php",
      data:{entidadesCompletasSelect},
      dataType: "json",
      success: function(response) {
      if(response.status == "success"){
         $("#selectentidad").empty(); 
         $('#selectentidad').append('<option value="0">ENTIDADES</option>');
         $('#selectentidad').append('<option value="100">TODAS</option>');
         if(response.status == "success"){
            for(var i = 0; i < response.entidades.length; i++){
                var idEntidad= response.entidades[i]["idEntidadFederativa"];
                var entidad= response.entidades[i].nombreEntidadFederativa;
                var entidadMayuscula=entidad.toUpperCase();
                entidadesCompletasCr.push(idEntidad);
                entidadesCompletasSelect.push(idEntidad);
                $('#selectentidad').append('<option value="' + (idEntidad) + '">' + entidadMayuscula + '</option>');
            }
        }else{
              alert("Error Al Cargar Las Lineas de Negocio");
        }
       }
      },
      error: function(jqXHR, textStatus, errorThrown) {
         alert(jqXHR.responseText);
      }
    });
}
      
function drawChart() {

  var linea= $('#selectLineaNegocio').val();
  var a = [];
  
  var tipoEntidad=entidadesarrayID[0];
  var entidadesCom=entidadesCompletasCr;
  if(tipoEntidad==100){
     entidadesarrayID = [];
     entidadesarrayID=entidadesCompletasCr;
  }
  $.ajax({
      type: "POST",
      url: "organigrama/ajax_RelacionesOrganigrama.php",
      data:{entidadesarrayID,linea},
      dataType: "json",
      async:false,
        success: function(response) {
        if(response.status == "success"){
           datos2 = response.datos;
           console.log(response.datos);
           console.log(datos2);
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Name');
          data.addColumn('string', 'Manager');
          data.addColumn('string', 'ToolTip');
          // data.addColumn('number', 'id');
          var arrayNodos= [];
          // var arrayNodos1= [];

          var idpadre = [];
          var Departamento_Region ="";

          for (var i = 0; i < datos2.length; i++) {
          // for (var i = 0; i < 19; i++) {
           console.log(datos2[i]);

            var idDepa     =  datos2[i]["idDepa"];
            var empleadoNum= datos2[i]["empleadoNum"];
            var departamentoAcargo = datos2[i]["departamentoAcargo"];
            var nombre  = datos2[i]["Nombre"];
            var puesto  = datos2[i]["puesto"];
            var idPuesto= datos2[i]["idPuesto"];
            var entidad = datos2[i]["entidad"];
            var idEntidad = datos2[i]["entidad"];
            var nombreEntidad = datos2[i]["nombreEntidad"];
            var tel   = datos2[i]["tel"];
            var email = datos2[i]["email"];
            var ImgUrl= datos2[i]["ImgUrl"];

            if(idPuesto === '42'){
                Departamento_Region = idDepa;  
                idpadre[idDepa+"_"+idEntidad] = empleadoNum+"_"+idPuesto+"_"+idEntidad;
            }else{
                idpadre[idDepa] = empleadoNum+"_"+idPuesto+"_"+idEntidad;
            }
            
            var idhijo = idDepa+"_"+empleadoNum+"_"+idPuesto+"_"+idEntidad;
            if(i==0){
                var idpadreCAb = 0; 
            }else{
                if(Departamento_Region === departamentoAcargo){
                    var NumPadre = idpadre[departamentoAcargo+"_"+idEntidad];
                }else{
                    var NumPadre = idpadre[departamentoAcargo];
                }
                var idpadreCAb = departamentoAcargo+"_"+NumPadre;
                
            }
            /*if(puesto=="VICEPRESIDENTE"){
               var arrayNodos1 = [{'v':''+idDepa+'', 'f':'<img src="'+ImgUrl+'"><div style="color:red; font-style:italic">'+puesto+'</div>'},''+departamentoAcargo+'', ''+puesto+''];
            }
            else if(puesto=="PRESIDENTE"){
              var arrayNodos1 = [{'v':''+idDepa+'', 'f':'<img src="'+ImgUrl+'"><div style="color:red; font-style:italic">'+puesto+'</div>'},'', ''+puesto+''];
            }
            else{*/
              var arrayNodos1 = [{'v':''+idhijo+'', 'f':''+nombre+'<img src="'+ImgUrl+'"><div style="color:red; font-style:italic">'+puesto+'</div> <div style="color:black; font-style:italic">CORREO:'+email+'</div><div style="color:black; font-style:italic">TEL:'+tel+'</div><div style="color:black; font-style:italic">ENTIDAD:'+nombreEntidad+'</div>'},''+idpadreCAb+'', ''+puesto+''];
            // }
            
            arrayNodos.push(arrayNodos1);
          }//for i
          data.addRows(arrayNodos);
          var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
          chart.draw(data, {'allowHtml':true, 'allowCollapse':true});
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
         alert(jqXHR.responseText);
      }
    });
}
   </script>
    </head>
  <body>
    <div id="chart_div"></div>
  </body>
</html>
