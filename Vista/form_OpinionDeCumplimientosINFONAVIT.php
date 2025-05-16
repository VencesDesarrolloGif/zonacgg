<div align="center">
  <h2>Opinión de cumplimientos</h2>
  <div class="card border-success mb-3" style="max-width: 60rem;">
    <div class="card-header">
     <h2>INFONAVIT</h2>
    </div>    
    <br>
<input type='hidden' id='valorActualizar' value="">  
<select id="selectmesOP" name="selectmesOP">
  <option value="0">MES</option>
  <option value="01">ENERO</option>
  <option value="02">FEBRERO</option>
  <option value="03">MARZO</option>
  <option value="04">ABRIL</option>
  <option value="05">MAYO</option>
  <option value="06">JUNIO</option>
  <option value="07">JULIO</option>
  <option value="08">AGOSTO</option>
  <option value="09">SEPTIEMBRE</option>
  <option value="10">OCTUBRE</option>
  <option value="11">NOVIEMBRE</option>
  <option value="12">DICIEMBRE</option>
</select>              

   <select id="selectRegistroP" name="selectRegistroP" style="display: none;">
   <option value="">REGISTRO PATRONAL</option>
      <?php
      for($i = 0; $i < count($catalogoRegistrosPatronales); $i++){
          if($catalogoRegistrosPatronales[$i]["idcatalogoRegistrosPatronales"] != 'R1438682103') {
              echo "<option value='" . $catalogoRegistrosPatronales[$i]["idcatalogoRegistrosPatronales"] . "'>" . $catalogoRegistrosPatronales[$i]["idcatalogoRegistrosPatronales"] . " </option>";
            }
         }
      ?>
    </select>

    <div class="card-body text-primary">
        <form enctype='multipart/form-data' id='formOpinionInf' name='formOpinionInf'>

          <label class="control-label label" for="archivoOpinionInfonavit">Seleccionar archivo: </label>
          <span class="btn btn-success btn-file" >Examinar
            <input type='file' class='btn-success' id='archivoOpinionInfonavit' name='archivoOpinionInfonavit[]' multiple="" accept=".pdf"/>  
          </span>

         </div>  
         <div class="card-body text-primary">        
          <div id="divPDFActual" hidden="true"></div>      
          </div> 

         <div class="card-body text-primary">
         <button id="btncargar" type="button" class="btn btn-primary" onclick="cargarinfo()" disabled="true">Cargar</button>    
         </div>      
        </form>
    <!--<button class='btn btn-success' type='button' onclick='actualizarDeudores();'> <img src='img/hojaDatos.png' width='20%'>Formato Alta</button>-->
  </div>
</div>
<script type="text/javascript">

function cargarinfo (){     
        waitingDialog.show();
        var registro=$("#selectRegistroP").val();
        var mes=$("#selectmesOP").val();
        var valorAct=$("#valorActualizar").val();
        var archivoinfonavit=$("#archivoOpinionInfonavit").val();
        if(mes==="0"){
           waitingDialog.hide();
           alert("Selecciona un mes");
           return;
        }else if(registro==""){
            waitingDialog.hide();
            alert("Selecciona un registro patronal");
            return;

        }else if(archivoinfonavit==""){
           waitingDialog.hide();
           alert("Selecciona archivo Infonavit");
           return;
        }
        //información del formulario
        var formData = new FormData($("#formOpinionInf")[0]);
        formData.append('registro', registro);
        formData.append('mes', mes);
        formData.append('valorAct', valorAct);
         
        $.ajax({            
            type: "POST",
            url: "ajax_uploadOpinionCumplimientoInfonavit.php",
            data:formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            success: function(response){ 
                    var msj=response.message;
                    if(response.status=='success'){   
                        //alert("subido");
        				      alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Archivo subido correctamente </strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                           $("#formOpinionInf")[0].reset(); 
                            $("#alertMsg").html(alertMsg1);                    
                            $('#msgAlert').delay(2000).fadeOut('slow');   
                            waitingDialog.hide();                  
                    }else{
                          alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                          $("#formOpinionInf")[0].reset(); 
                          $("#alertMsg").html(alertMsg1);                    
                          $('#msgAlert').delay(2000).fadeOut('slow');       
                          waitingDialog.hide();                  
                    }
            },
            //si ha ocurrido un error
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText); 
            }
        });
  }

$("#selectmesOP").change(function(){
  if($("#selectmesOP").val()==0){
     $("#selectRegistroP").hide();
     $("#selectRegistroP").val("");
     $("#btncargar").prop("disabled", true);
     $("#divPDFActual").hide();

    }else{
          $("#selectRegistroP").show();
          $("#selectRegistroP").val("");
          $("#btncargar").prop("disabled", true);
          $("#divPDFActual").hide();
         }
 });


$("#selectRegistroP").change(function(){
  if($("#selectRegistroP").val()==0 && $("#selectRegistroP").val()==""){
    var msj="Elija un registro patronal";
     alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
     $("#formOpinionInf")[0].reset(); 
     $("#alertMsg").html(alertMsg1);                    
     $('#msgAlert').delay(2000).fadeOut('slow');
     $("#divPDFActual").hide();
  }else{
        var registro=$("#selectRegistroP").val();
        var mes=$("#selectmesOP").val();
        var archivoinfonavit=$("#archivoOpinionInfonavit").val();
        var fechaHoy = new Date();
        var anio=fechaHoy.getFullYear();

        $.ajax({            
            type: "POST",
            url: "ajax_ConsultaCargaPDF.php",
            data:{
                  "registro": registro,"mes":mes,"anio":anio
              },
            dataType: "json",
            success: function(response){ 
                    var msj=response.message;
                    var pdf=response.datos[0]["resultado"];
                    if(response.status=='success'){  
                    if(pdf!=0 && pdf!="") {
                        
                    var p="<a onclick=generarPDFOpinion('"+registro+"','"+mes+"','"+anio+"');><img src='img/pdf.png' height='24px' width='24px'  /></a>";
                    $("#divPDFActual").show();
                    $("#divPDFActual").html(p);
                    $("#btncargar").prop("disabled",false);  
                    $("#valorActualizar").val(1);             

                      }else{
                        var msj="Aún no se ha cargado esta información";
                        alertMsg1="<div id='msgAlert' class='alert alert-warning'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                        $("#formOpinionInf")[0].reset(); 
                        $("#alertMsg").html(alertMsg1);                    
                        $('#msgAlert').delay(2000).fadeOut('slow');
                        $("#btncargar").prop("disabled",false); 
                        $("#valorActualizar").val(0);  
                        $("#divPDFActual").hide();
                      }
                    }
            },
            //si ha ocurrido un error
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText); 
            }
        });
       }
 });

function generarPDFOpinion(registro,mes,anio){ 
     window.open("uploads/DocumentosOpinionCumplimiento/Infonavit/"+registro+mes+anio+"/opinionInfonavit"+mes+anio+".pdf",'fullscreen=no');
}




</script>