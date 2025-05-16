var entidadesCompletasCr = [];
var entidadesCompletasSelect = [];
var arrayNuevoEntidadesCompletasSelect = [];
var entidadesSinQuitar = [];
var arraySeleccionadas = [];
var entidadARegresarArray = [];
OrgChart.templates.myTemplate = Object.assign({}, OrgChart.templates.ana);

OrgChart.templates.myTemplate.menuButton =
    '<div style="position:absolute;right:{p}px;top:{p}px; width:40px;height:50px;cursor:pointer;" data-ctrl-menu="">'
    + '<hr style="background-color: rgb(34, 151, 249); height: 5px; border: none;">'
    + '<hr style="background-color: rgb(34, 151, 249); height: 5px; border: none;">'
    + '<hr style="background-color: rgb(34, 151, 249); height: 5px; border: none;">'
    + '</div>';

OrgChart.templates.myTemplate.pointer =
    '<g data-pointer="pointer" transform="matrix(0,0,0,0,100,100)">><g transform="matrix(0.3,0,0,0.3,-17,-17)">'
    + '<polygon fill="rgb(34, 151, 249)" points="53.004,173.004 53.004,66.996 0,120" />'
    + '<polygon fill="rgb(34, 151, 249)" points="186.996,66.996 186.996,173.004 240,120" />'
    + '<polygon fill="rgb(34, 151, 249)" points="66.996,53.004 173.004,53.004 120,0" />'
    + '<polygon fill="rgb(34, 151, 249)" points="120,240 173.004,186.996 66.996,186.996" />'
    + '<circle  fill="rgb(34, 151, 249)" cx="120" cy="120" r="30" />'
    + '</g></g>';

OrgChart.LAZY_LOADING_FACTOR = 1000
OrgChart.TEXT_THRESHOLD = 1000;
OrgChart.IMAGES_THRESHOLD = 1000;
OrgChart.LINKS_THRESHOLD = 5000;
OrgChart.BUTTONS_THRESHOLD = 200;
OrgChart.ANIM_THRESHOLD = 200;

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
                var idLN= response.lineas[i]["idLN"];
                $('#selectLineaNegocio').append('<option value="' + (idLN) + '">' + response.lineas[i].descripcionLN + '</option>');
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


OrgChart.SEARCH_PLACEHOLDER = "Buscar";

function crearConfiguracionesOrganigrama(){

$("#tree").html('');
var chart = new OrgChart(document.getElementById("tree"), {
showXScroll: OrgChart.scroll.visible,
showYScroll: OrgChart.scroll.visible,
mouseScrool: OrgChart.action.ctrlZoom,
enableSearch: true,//buscador
titleBinding:'fsdf',
template: "myTemplate",
miniMap: true,
scaleinitial: 1,
levelSeparation : 50,//entre niveles
subtreeSeparation : 50,//entre nodos de diferente padre
siblingSeparation : 85,//entre nodos del mismo padre
padding : 100,
// menu:{
//       pdf: { text: "EXPORTAR A PDF",header: 'GIF SEGURIDAD PRIVADA,S.A. DE C.V.',footer: '22/06/23'},
//       csv: { text: "EXPORTAR A EXCEL" },
//      },
menu: {
        export_pdf: {
            text: "EXPORTAR A PDF",
            icon: OrgChart.icon.pdf(24, 24, "#7A7A7A"),
            onClick: pdf
        },
        csv: { text: "EXPORTAR A EXCEL" },
    },
toolbar: {
        layout: true,
        zoom: true,
        fit: true,
    },
editForm:{
    titleBinding: "Nombre",
    photoBinding: "ImgUrl",
    generateElementsFromFields: false,
    elements:[
            { type: 'textbox', label: 'Full Name', binding: 'Name'},
            { type: 'textbox', label: 'Puesto', binding: 'Puesto'} ,       
            { type: 'textbox', label: 'Entidad', binding: 'entidad'},        
            { type: 'textbox', label: 'Nombre', binding: 'Nombre'},
            { type: 'textbox', label: 'No.Empleado', binding: 'noEmp'},        
            { type: 'textbox', label: 'E-Mail', binding: 'email'} ,       
            { type: 'textbox', label: 'Telefono', binding: 'tel'},       
    ],
    buttons:{
             pdf: null,
             share: null,
             edit: null,
    }
},
nodeBinding: {
    field_0: "Puesto",
    field_1: "Nombre",
    img_0: "ImgUrl"
},
    nodes: crearOrganigrama() });
    function pdf(nodeId) {
         var fechaHoy = new Date();
         var fechaActual=(fechaHoy.getDate() + "-" + (fechaHoy.getMonth() +1) + "-" + fechaHoy.getFullYear());
        chart.exportPDF({
            // format: "A4",
            header: "GIF SEGURIDAD PRIVADA,S.A. DE C.V.",
            footer: 'ORGANIGRAMA AL: '+fechaActual,
        });
    }
}


function crearOrganigrama (){

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
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
         alert(jqXHR.responseText);
      }
    });
    var idpadre = [];
    var Departamento_Region ="";
    console.log(datos2.length);

    if(datos2.length>200){
        var  largoEmpleados=200;
    }else{
var  largoEmpleados=datos2.length;
    }

    for(var i = 0; i < largoEmpleados; i++) {
                console.log([i]);
                console.log(datos2[i]);
                var idDepa = datos2[i]["idDepa"];
                var empleadoNum = datos2[i]["empleadoNum"];
                var departamentoAcargo = datos2[i]["departamentoAcargo"];
                var Nombre = datos2[i]["Nombre"];
                var puesto = datos2[i]["puesto"];
                var idPuesto = datos2[i]["idPuesto"];
                var idEntidad = datos2[i]["entidad"];
                var entidad = datos2[i]["nombreEntidad"];
                var tel = datos2[i]["tel"];
                var email = datos2[i]["email"];
                var ImgUrl = datos2[i]["ImgUrl"];
                var imgRuta=ImgUrl;
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
                var b = {id: idhijo, Puesto:puesto ,Nombre: Nombre,email: email, tel: tel,ImgUrl: imgRuta, pid: idpadreCAb,entidad: entidad,noEmp:empleadoNum}
                a.push(b);
    }
    return a;
}