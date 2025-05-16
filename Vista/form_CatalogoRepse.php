 <center>
     <body>
          <div id='divMSGRepse' name='divMSGRepse' ></div>
           <div class="container" align="center"><h1>Catálogo REPSE</h1></div>
           <div id="divErrorRepse" name="divErrorRepse"></div>
           <div style="margin-top: 2%"></div>
           <div class="container top-buffer-submenu vertical-buffer">
           </div>
           <input id="inpaccionRepse" type="hidden" value="Editar">
           <form enctype='multipart/form-data' id='archivoRepse' name='archivoRepse'>
             <div id="datosRepse" ></div>
              <label>Cargar Documento</label>
              <input type='file' class='btn-success' id='documentoCargadoAgregar' name='documentoCargadoAgregar[]' multiple="" disabled="true" /> 
            </form>
           <div class="container top-buffer-submenu vertical-buffer">
              <button  id="btnagregarREPSE" class="btn btn-default" onclick="agregarREPSE()"><span class="glyphicon glyphicon-plus"></span>Agregar</button>
              <button  id="btnguardarREPSEagregar" disabled='true' class="btn btn-success" onclick="guardarREPSE('agregar')">Guardar</button>
           </div>
           <div tabindex="-1" role="dialog" id="ModalRepse" name="ModalP" aria-labelledby="aaaa1" aria-hidden="true">
             <h1 align="center" id="procesandoRepse" name="procesandoRepse" style="display:none;" >Procesando ....</h1>
         </div>            
            <div id="DivtxtnombreDocumentoRepse1">
                <input type="hidden" id="txtnombreDocumentoREPSEHidden1" class="input-xlarge">   
                <input type="hidden" id="txtcasoEPrepse1" class="input-xlarge">   
            </div>
                <input type="hidden" id="banderaEditar" class="input-xlarge" value="0">   
                <input type="hidden" id="banderaAgregar" class="input-xlarge" value="0">   
     </body>
  </center>

<script type="text/javascript">
$(traerCatalogoRepse());  

function traerCatalogoRepse() {
 $("#divErrorRepse").html("");
 $("#btneditarREPSE").prop("disabled", false);
 $("#btnguardarREPSE").prop("disabled", true);
 $("#btnguardarREPSEagregar").prop("disabled", true);
 $("#btnagregarREPSE").prop('disabled', false);
 $.ajax({
  type: "POST",
  url: "ajax_ConsultaREPSE.php",
  dataType: "json",
  success: function(response) {
   if(response.status == "success") {
       var mensaje= response.message;
       var datos  = response.datos;
       $("#datosRepse").empty();
       var tabla  = "<table id='tabla' class='table table-bordered'><thead> <th>No</th> <th>No. de acuerdo</th> <th>No. de folio de ingreso</th><th>PDF</th><th>Editar</th><th>Eliminar</th><th>carga de Archivo</th></thead><tbody>";
       $(document).scrollTop(0);
       $.each(datos, function(i) {
        var nombreDocumento=datos[i]["nombreDocumento"];
        tabla += "<tr><td><input class='form-control' id='inpidRepse" + i + "' type='text' readonly='true' value='" + datos[i].idRepse + "'>    <input id='inpidRepseHidden" + i + "' type='hidden' value='" + datos[i].idRepse + "'></td>";                        
        tabla += "<td><input class='form-control' id='inpNoAcuerdo" + i + "' type='text' readonly='true' value='" + datos[i].NumAcuerdo + "'>   <input id='inpNoAcuerdoHidden"   + i + "' type='hidden'  value='" + datos[i].NumAcuerdo + "'>    </td>";
        tabla += "<td><input class='form-control' id='inpNoFolioIn" + i + "' type='text' readonly='true' value='" + datos[i].NumFolioIngreso+"'><input id='inpNoFolioHidden"+ i + "' type='hidden'  value='" + datos[i].NumFolioIngreso +"'></td>";
        tabla += "<td><img style='width: 60%' title='Abrir' src='img/hojaDatos.png' class='cursorImg'id='btncargar"+i+"' onclick='cargarDocRepse(\""+nombreDocumento+"\")'><input id='inpNombreDoc"+ i + "' type='hidden'  value='" + datos[i].nombreDocumento +"'></td>";
        tabla += "<td><img style='width:40%' title='editar' src='img/lapizEdit.png' id='btneditarREPSE"+i+"' onclick='editarREPSE("+i+")' class='cursorImg'></td>";
        tabla += "<td><img style='width:60%' title='Eliminar' src='img/eliminar.png'id='btneliminarRepse'    onclick='EliminarREPSEbtn("+ i +")'class='cursorImg' ></td>";
        tabla += "<td><input type='file' class='btn-success' id='documentoCargado"+i+"' name='documentoCargado"+i+"[]' multiple='' disabled='true' /> </td>";
       });                
       $("#datosRepse").append(tabla);
       $("#ModalRepse").modal("hide");
       $("#procesandoRepse").hide();
    }else{
          var mensaje = response.message;
         }
 },
 error: function(jqXHR, textStatus, errorThrown) {
     alert(jqXHR.responseText);
      }
 });
}

function cargarDocRepse(nombreDocumento){
  window.open("ajax_CargarDocumentoREPSE.php?&nombreDocumento=" + nombreDocumento,'fullscreen=no');
}

function EliminarREPSEbtn(i){
    var idRep = $("#inpidRepseHidden" + i).val();
    $("#ModalRepse").modal("show"); 
    $("#procesandoRepse").show(); 
    $.ajax({
        type: "POST",
        url: 'ajax_EliminarRepse.php',
        data: {idRep},
        success: function(response){ 
            $("#divMSGRepse").html("");
            $("#procesandoRepse").hide();
            $("#ModalRepse").modal("hide");
            $("#divMSGRepse").fadeIn();
            traerCatalogoRepse();
            var mensajeElim = "Se Eliminó Correctamente"
            alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeElim+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#divMSGRepse").html(alertMsg1); 
            $("#divMSGRepse").delay('4000').fadeOut('slow');         
        }
    });
}
            
function editarREPSE(i) {

    if($("#banderaAgregar").val()=='1'){
        $(document).scrollTop(0);
        var mensajeElim = "no puede editar mientras agrega un elemento"
        alertMsg1="<div id='msgAlert' class='alert alert-warning'><strong>"+mensajeElim+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        $("#divMSGRepse").html(alertMsg1); 
        $("#divMSGRepse").delay('4000').fadeOut('slow');
    }else{
       $("#banderaEditar").val("1");
       $("#divErrorRepse").html("");
       $("#inpaccionRepse").val("Editar");
       $("#documentoCargado" +i).prop("disabled", false);

       $("#inpNoAcuerdo" + i).prop('readonly', false);
       $("#inpNoFolioIn" + i).prop('readonly', false);
       $("#btneditarREPSE"+i).prop("disabled", true);
       
       $("#btnguardarREPSEagregar").prop("disabled", false);
       $("#btneditarREPSE"+i).prop("disabled", true);
       $("#btnagregarREPSE").prop('disabled', true);

       var b = $("#tabla tr").length;
       var c = $("#tabla tr:last td").length;
    }
   
}

function guardarREPSE(boton) {

 var inpaccionRepse = $("#inpaccionRepse").val();
 var formData = new FormData($("#archivoRepse")[0]);

    if (inpaccionRepse === "Agregar") {
        var documentoCargadoRepse = $("#documentoCargadoAgregar").val();
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
        
        for(var i = b - 2; i < b - 1; i++) {
            var noAcuerdo = $("#inpNoAcuerdo" + i).val();
            var noFolioIn = $("#inpNoFolioIn" + i).val();
           }
        if (noAcuerdo == "") {
            $(document).scrollTop(0);
            $("#ModalRepse").modal("hide"); 
            $("#procesandoRepse").hide();
            var Msgerror = "<div id='divErrorRepse' class='alert alert-error'><strong>Ingrese el numero de acuerdo</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#divErrorRepse").html(Msgerror);

        }else if (noFolioIn == "") {
            $(document).scrollTop(0);
            $("#ModalRepse").modal("hide"); 
            $("#procesandoRepse").hide();
            var Msgerror = "<div id='divErrorRepse' class='alert alert-error'><strong>Ingrese el numero de folio de ingreso</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#divErrorRepse").html(Msgerror);

        }else if(documentoCargadoRepse == "") {
            $(document).scrollTop(0);
            $("#ModalRepse").modal("hide"); 
            $("#procesandoRepse").hide();
            var Msgerror = "<div id='divErrorRepse' class='alert alert-error'><strong>Carge documento PDF</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#divErrorRepse").html(Msgerror);

        }else {
            $("#divErrorRepse").html("");
            $("#btneditarREPSE").prop("disabled", false);
            $("#btnagregarREPSE").prop('disabled', false);
            $("#btnguardarREPSEagregar").prop("disabled", true);

            for (var i = b - 2; i < b - 1; i++) {
                $("#inpNoAcuerdo" + i).prop('readonly', true);
                $("#inpNoFolioIn" + i).prop('readonly', true);
            }
             $("#ModalRepse").modal("show"); 
             $("#procesandoRepse").show();

             formData.append('noAcuerdo',noAcuerdo);
             formData.append('noFolioIn',noFolioIn);

             $.ajax({
                type: "POST",
                url: 'ajax_InsertRepse.php',
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                async:false, 
                success: function() {
                    $("#divMSGRepse").html("");
                    $("#procesandoRepse").hide();
                    $("#ModalRepse").modal("hide");
                    $("#divMSGRepse").fadeIn();
                    traerCatalogoRepse();
                    var mensajeAgregar = "Se Agregó Correctamente"
                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeAgregar+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#divMSGRepse").html(alertMsg1); 
                    $("#divMSGRepse").delay('4000').fadeOut('slow');
                    $("#documentoCargadoAgregar").val("");    
                    $("#documentoCargadoAgregar").prop("disabled",true);
                    $("#banderaAgregar").val("0");
                },error:function(jqXHR, textStatus, errorThrown){
                    alert(jqXHR.responseText);
                }
            });
        }

    }else if (inpaccionRepse === "Editar") {
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
       
      for(var i = 0; i < b - 1; i++) {
            var documentoCargadoRepse = $("#documentoCargado"+i).val();//boton es =i osea el numero de documento que se cargo
            var numeroAcuerdo = $("#inpNoAcuerdo" + i).val();
            var numeroAcuerdoH= $("#inpNoAcuerdoHidden" + i).val();
            var numeroFolio = $("#inpNoFolioIn" + i).val();
            var numeroFolioH= $("#inpNoFolioHidden" + i).val();
            var idRepse     = $("#inpidRepse" + i).val();
            var nombreDocIn = $("#inpNombreDoc" + i).val();
            //NO SE PONE EL INPUT DEL DOCUMENTO HIDDEN POR QUE SI ESTA VACIO ES QUE NO CAMBIO NADA

            if(documentoCargadoRepse!='' && documentoCargadoRepse!='NULL' && documentoCargadoRepse!='null' && documentoCargadoRepse!=null) {
              var casoDocumento='1';//se debe modificar el archivo
            }else if (documentoCargadoRepse=='' || documentoCargadoRepse=='NULL' || documentoCargadoRepse=='null') {
              var casoDocumento='0';// se debe quedar el documento anterior
            }

            if(numeroAcuerdo == "") {
               $(document).scrollTop(0);
               var Msgerror = "<div id='divErrorRepse' class='alert alert-error'><strong>Ingrese el numero de acuerdo en la fila :" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
               $("#divErrorRepse").html(Msgerror);
               return 0;
            }

            if(numeroFolio == "") {
               $(document).scrollTop(0);
               var Msgerror = "<div id='divErrorRepse' class='alert alert-error'><strong>Ingrese el numero de folio de ingreso en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
               $("#divErrorRepse").html(Msgerror);
               return 0;
            }
        if((numeroAcuerdo != numeroAcuerdoH) || (numeroFolio != numeroFolioH) || (documentoCargadoRepse!='' && documentoCargadoRepse!='NULL' && documentoCargadoRepse!='null' && documentoCargadoRepse!=null)){
        $("#ModalRepse").modal("show"); 
        $("#procesandoRepse").show();

        var idDocumentoCargado= "documentoCargado"+i;
        formData.append('noAcuerdo',numeroAcuerdo);
        formData.append('noFolioIn',numeroFolio);
        formData.append('idRepse',idRepse);
        formData.append('casoDocumento',casoDocumento);
        formData.append('nombreDocIn',nombreDocIn);
        formData.append('idDocumentoCargado',idDocumentoCargado);

            $.ajax({
            type: "POST",
            url: 'ajax_UpdateRepse.php',
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            async:false,      
              success: function() {
                $("#divMSGRepse").html("");
                $("#procesandoRepse").hide();
                $("#ModalRepse").modal("hide");
                $("#divMSGRepse").fadeIn();
                traerCatalogoRepse();
                var mensajeEdit = "Se Editó Correctamente"
                alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeEdit+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#divMSGRepse").html(alertMsg1); 
                $("#divMSGRepse").delay('4000').fadeOut('slow'); 
                $("#documentoCargadoAgregar").val("");    
                $("#documentoCargadoAgregar").prop("disabled",true); 
                $("#banderaEditar").val("0");
              }//success
            });
        }
      }//FOR
    }//else if editar
}//funcion

function agregarREPSE() {
    $("#banderaAgregar").val("1");
    $("#divErrorRepse").html("");
    $("#btneditarREPSE").prop("disabled", true);
    $("#documentoCargadoAgregar").prop("disabled", false);
    var b       = $("#tabla tr").length;
    var table   = document.getElementById("tabla");
    var row     = table.insertRow(b);
    var contfila= row.insertCell(0);
    var cell1   = row.insertCell(1);
    var cell2   = row.insertCell(2);

    for (var i = 0; i < b; i++) {
        contfila.innerHTML = " <td > " + (i + 1) + " </td>";
        cell1.innerHTML = "<input id='inpNoAcuerdo" + i + "' type='text'>";
        cell2.innerHTML = "<input id='inpNoFolioIn" + i + "' type='text' >";;
    }
    $("#btnagregarREPSE").prop('disabled', true);
    $("#inpaccionRepse").val("Agregar");
    $("#btnguardarREPSEagregar").prop('disabled', false);
}

</script>