<center> 
  <br>
   <div class="col-lg-12" style="font-size:50px;">Escritura Constitutiva</div>
</center>
<br>
<center>
  <br>
  <br>
  <br>
  <br>
  <br>
  <div id="DivtxtnombreDocumento">
    <input type="hidden" id="txtnombreDocumentoHidden" class="input-xlarge">   
    <input type="hidden" id="txtcasoEP" class="input-xlarge">   
  </div>

  <input type="image" id="btnAbrirDocumento"  src="img\hojaDatos.png" style="width: 4%;" title="Abrir documento" class="cursorImg" hidden="true">
</center>

<script type="text/javascript">

$(obtenerEscrituraPublica());  

function obtenerEscrituraPublica(){
 $.ajax({
         type: "POST",
         url: "ajax_ObtenerUltimaEscrituraPublica.php",
         dataType: "json",
         success: function(response) {
             if(response.status == "success"){
                $("#txtnombreDocumentoHidden").val(response["nombreDocumento"]);
                $("#txtcasoEP").val(response["caso"]);
                var informacion= $("#txtcasoEP").val();
                $("#btnEditarEscritura").prop("hidden", false);
                //alert(informacion);
                if(informacion=='1') {//si tenga informacion
                    $("#btnAbrirDocumento").prop("hidden", false);
                }
              }
         },error:function(jqXHR, textStatus, errorThrown){
                 alert(jqXHR.responseText);
            }
  });
}

$("#btnAbrirDocumento").click(function(){
  var nombreDocumento = $("#txtnombreDocumentoHidden").val();
  //alert(nombreDocumento);
  window.open("ajax_CargarDocumentoEscrituraPublica.php?&nombreDocumento=" + nombreDocumento,'fullscreen=no');

});

</script>



