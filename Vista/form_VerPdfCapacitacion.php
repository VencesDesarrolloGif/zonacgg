
<h2>VISUALIZAR TODOS LOS ARCHIVOS</h2>
<br><br>
<i><h4 class="modal-title">PRIMER MODULO</h4></i>
<br>
<div class="input-prepend">
  <button id="VerArchivoM1" name="VerArchivoM1" oncontextmenu="return false;" class="btn btn-primary " type="button" onclick="AbrirArchivo(1)"> 
  <span class="glyphicon glyphicon-floppy-save "></span>Ver Archivo Modulo 1</button>
</div>

<br><br>
<i><h4 class="modal-title">SEGUNDA MODULO</h4></i>
<br>
<div class="input-prepend">
  <button id="VerArchivoM2" name="VerArchivoM2" class="btn btn-primary " type="button" onclick="AbrirArchivo(2)"> 
  <span class="glyphicon glyphicon-floppy-save "></span>Ver Archivo Modulo 2</button>
</div>

<br><br>
<i><h4 class="modal-title">TERCERO MODULO</h4></i>
<br>
<div class="input-prepend">
  <embed><button id="VerArchivoM3" name="VerArchivoM3" class="btn btn-primary " type="button" onclick="AbrirArchivo(3)"> 
  <span class="glyphicon glyphicon-floppy-save "></span>Ver Archivo Modulo 3</button></embed>
 
</div>

<br><br>
<i><h4 class="modal-title">CUARTO MODULO</h4></i>
<br>
<div class="input-prepend">
  <button id="VerArchivoM4" name="VerArchivoM4" class="btn btn-primary " type="button" onclick="AbrirArchivo(4)"> 
  <span class="glyphicon glyphicon-floppy-save "></span>Ver Archivo Modulo 4</button>
</div>

<br><br>
<i><h4 class="modal-title">QUINTO MODULO</h4></i>
<br>
<div class="input-prepend">
  <button id="VerArchivoM5" name="VerArchivoM5" class="btn btn-primary " type="button" onclick="AbrirArchivo(5)"> 
  <span class="glyphicon glyphicon-floppy-save "></span>Ver Archivo Modulo 5</button>
</div>

<div id="modal1" name="modal1" class="modalEdit4 hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
<div id="DivVerPdf">
  
</div>

</div>

<script type="text/javascript">

$(inicioVerPDFCap());  

function inicioVerPDFCap(){
  document.oncontextmenu = function(){
    return false
  }
}

  function AbrirArchivo(caso) {
    var CasoA = caso; 
    var a = "Location=no, menubar=no, resizable=no, scrollbars=no, status=no, titlebar=no, toolbar=no";
    var b = document.oncontextmenu = function(){return false};

//<a href="pagina.htm" target="_blank" onclick="window.open(this.href,this.target,'width=400,height=250,top=120,left=100,toolbar=no,location=no,status=no,menubar=no');return false;">Mi popup mal hecho</a>
  //window.open(this.href,this.target,'width=400,height=250,top=120,left=100,toolbar=no,location=no,status=no,menubar=no');return false;
  //var boton = "<embed src="'../Vista/uploads/archivosCapacitaciones/Modulo5/Modulo5.pdf#toolbar=0'">"

  window.open(" ../Vista/uploads/archivosCapacitaciones/Modulo" + CasoA + "/Modulo" + CasoA + ".pdf#toolbar=0");

   /* var pdf0="<embed src= ../Vista/uploads/archivosCapacitaciones/Modulo" + CasoA + "/Modulo" + CasoA + ".pdf#toolbar=0 width=1500 height=1375></embed>";
$('#DivVerPdf').bind('contextmenu',function() { return false; });
//document.oncontextmenu = function(){return false}
    $("#DivVerPdf").html(pdf0);
    $("#modal1").modal("show");
*/
  }
  
</script>
