<form class="form-inline"  method="post" id="form_PdfCapacitacion" action="ficheroExcelMovimientos.php" target="_blank" enctype='multipart/form-data'>
<div id="Mensaje1"></div>
<h2>CARGAR TODOS LOS ARCHIVOS</h2>
<br><br>
<i><h4 class="modal-title">PRIMER MODULO</h4></i>
<br>
<div class="input-prepend">
  <span class="add-on">Cargar Archivo</span>
  <input class="btn-success" id="archivomodulo1" name="archivomodulo1[]" type="file">
</div>

<br><br>
<i><h4 class="modal-title">SEGUNDA MODULO</h4></i>
<br>
<div class="input-prepend">
  <span class="add-on">Cargar Archivo</span>
  <input class="btn-success" id="archivomodulo2" name="archivomodulo2[]" type="file">
</div>

<br><br>
<i><h4 class="modal-title">TERCERO MODULO</h4></i>
<br>
<div class="input-prepend">
  <span class="add-on">Cargar Archivo</span>
  <input class="btn-success" id="archivomodulo3" name="archivomodulo3[]" type="file">
</div>

<br><br>
<i><h4 class="modal-title">CUARTO MODULO</h4></i>
<br>
<div class="input-prepend">
  <span class="add-on">Cargar Archivo</span>
  <input class="btn-success" id="archivomodulo4" name="archivomodulo4[]" type="file">
</div>

<br><br>
<i><h4 class="modal-title">QUINTO MODULO</h4></i>
<br>
<div class="input-prepend">
  <span class="add-on">Cargar Archivo</span>
  <input class="btn-success" id="archivomodulo5" name="archivomodulo5[]" type="file">
</div>
<br><br>

<div>                
  <button id="guardarArchivos" name="guardarArchivos" class="btn btn-primary " type="button" ;> 
  <span class="glyphicon glyphicon-floppy-save "></span>Guardar</button>
</div>
</form>

<script type="text/javascript">

  $("#guardarArchivos").click(function () 
  {
    var archivomodulo1=$("#archivomodulo1").val();
    var archivomodulo2=$("#archivomodulo2").val();
    var archivomodulo3=$("#archivomodulo3").val();
    var archivomodulo4=$("#archivomodulo4").val();
    var archivomodulo5=$("#archivomodulo5").val();

    if(archivomodulo1!=""){
      var archivomodulo11 = archivomodulo1.split('.');
      var archivomodulo111 = archivomodulo11.length
      var archivomodulo1ext = archivomodulo11[archivomodulo111-1];
    }if(archivomodulo2!=""){
      var archivomodulo22 = archivomodulo2.split('.');
      var archivomodulo222 = archivomodulo22.length
      var archivomodulo2ext = archivomodulo22[archivomodulo222-1];
    }if(archivomodulo3!=""){
      var archivomodulo33 = archivomodulo3.split('.');
      var archivomodulo333 = archivomodulo33.length
      var archivomodulo3ext = archivomodulo33[archivomodulo333-1];
    }if(archivomodulo4!=""){
      var archivomodulo44 = archivomodulo4.split('.');
      var archivomodulo444 = archivomodulo44.length
      var archivomodulo4ext = archivomodulo44[archivomodulo444-1];
    }if(archivomodulo5!=""){
      var archivomodulo55 = archivomodulo5.split('.');
      var archivomodulo555 = archivomodulo55.length
      var archivomodulo5ext = archivomodulo55[archivomodulo555-1];
    }
    // Condicionales

    if(archivomodulo1!="" && archivomodulo1ext !="PDF" && archivomodulo1ext!="pdf" && archivomodulo1ext!="Pdf"){
      ErrorDeArchivo("El Archivo Del Primer Modulo Ingresado Debe Ser Con Extencion Pdf");
    }else if(archivomodulo2!="" && archivomodulo2ext !="PDF" && archivomodulo2ext!="pdf" && archivomodulo2ext!="Pdf"){
      ErrorDeArchivo("El Archivo Del Segundo Modulo Ingresado Debe Ser Con Extencion Pdf");
    }else if(archivomodulo3!="" && archivomodulo3ext !="PDF" && archivomodulo3ext!="pdf" && archivomodulo3ext!="Pdf"){
      ErrorDeArchivo("El Archivo Del Tercer Modulo Ingresado Debe Ser Con Extencion Pdf");
    }else if(archivomodulo4!="" && archivomodulo4ext !="PDF" && archivomodulo4ext!="pdf" && archivomodulo4ext!="Pdf"){
        ErrorDeArchivo("El Archivo Del Cuarto Modulo Ingresado Debe Ser Con Extencion Pdf");
    }else if(archivomodulo5!="" && archivomodulo5ext !="PDF" && archivomodulo5ext!="pdf" && archivomodulo5ext!="Pdf"){
      ErrorDeArchivo("El Archivo Del Quinto Modulo Ingresado Debe Ser Con Extencion Pdf");
    }else{
      cargararchivos(); 
    }
  });

  function cargararchivos(){

    var formData = new FormData($("#form_PdfCapacitacion")[0]);
      //hacemos la petición ajax  
      for (var value of formData.values()) {
          console.log(value); 
        }       
        $.ajax({
            type: "POST",
            url: "upload_ArchivoCapacitacion.php",
            data:formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,        
            //una vez finalizado correctamente
             success: function(response) {
              var mensaje = response.message;
              alert(mensaje);
              limpiarCampo();
            // console.log(response); 
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
          
        });
  }

  function ErrorDeArchivo(mensaje1){
    alertMsj1="<div class='alert alert-error' id='Mensaje21'>"+mensaje1+"<data-dismiss='alert'>";
  $("#Mensaje1").html(alertMsj1).fadeIn();
  $(document).scrollTop(0);
  $('#Mensaje1').delay(3000).fadeOut('slow');
  }

  function limpiarCampo(){
    $("#archivomodulo1").val("");
    $("#archivomodulo2").val("");
    $("#archivomodulo3").val("");
    $("#archivomodulo4").val("");
    $("#archivomodulo5").val("");
  }
  




</script>
