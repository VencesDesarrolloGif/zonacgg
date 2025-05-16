<center> 
  <br>
   <div class="col-lg-12" style="font-size:50px;">REPSE</div>
</center>
<br>
<center>
  <br>
  <br>
  <br>
  <br>
  <br>
  <div id="DivtxtnombreDocumentoRepse">
    <input type="hidden" id="txtnombreDocumentoREPSEHidden" class="input-xlarge">   
    <input type="hidden" id="txtcasoEPrepse" class="input-xlarge">   
  </div>

  <input type="image" id="btnAbrirDocumentoRepse"  src="img\hojaDatos.png" style="width: 4%;" title="Abrir documento" class="cursorImg" hidden="true">
</center>

<script type="text/javascript">

$(obtenerDocumentoREPSE());  

function obtenerDocumentoREPSE(){
 $.ajax({
         type: "POST",
         url: "ajax_obtenerUltimoDocumentoRepse.php",
         dataType: "json",
         success: function(response) {
             if(response.status == "success"){
                $("#txtnombreDocumentoREPSEHidden").val(response["nombreDocumento"]);
                $("#txtcasoEPrepse").val(response["caso"]);
                var informacion= $("#txtcasoEPrepse").val();
                //alert(informacion);
                if(informacion=='1') {//si tenga informacion
                    $("#btnAbrirDocumentoRepse").prop("hidden", false);
                }
              }
         },error:function(jqXHR, textStatus, errorThrown){
                 alert(jqXHR.responseText);
            }
  });
}

$("#btnAbrirDocumentoRepse").click(function(){
  var nombreDocumento = $("#txtnombreDocumentoREPSEHidden").val();
  //alert(nombreDocumento);
  window.open("ajax_CargarDocumentoREPSE.php?&nombreDocumento=" + nombreDocumento,'fullscreen=no');

});

</script>



