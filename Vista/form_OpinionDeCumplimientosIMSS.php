<div align="center">
    <h2>Opinión de cumplimientos</h2>
     <div class="card border-success mb-3" style="max-width: 60rem;">
        <div class="card-header">
            <h2>IMSS</h2>
        </div>    
        <br>
        <select id="selectmesOPIMSS" name="selectmesOPIMSS">
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

        <div class="card-body text-primary">
            <form enctype='multipart/form-data' id='formOpinionIMSS' name='formOpinionIMSS'>
                <label class="control-label label" for="archivoOpinionIMSS">Seleccionar archivo: </label>
                <span class="btn btn-success btn-file" >Examinar
                    <input type='file' class='btn-success' id='archivoOpinionIMSS' name='archivoOpinionIMSS[]' multiple="" accept=".pdf"/>  
                </span>
                <div class="card-body text-primary">        
                    <div id="divPDFActualImssOP" hidden="true"></div>      
                </div>

                <div class="card-body text-primary">
                    <button id="btncargarImssOP" type="button" class="btn btn-primary" onclick="btncargaroPimsS()">Cargar</button>    
                </div>      
            </form>
        </div>  
    </div>
</div>
<script type="text/javascript">

function btncargaroPimsS (){ 
        var mes=$("#selectmesOPIMSS").val();
        var archivoinfonavit=$("#archivoOpinionIMSS").val();
        if(mes==="0"){
           alert("Selecciona un mes");
           return;

        }else if(archivoinfonavit==""){
          alert("Selecciona archivo IMSS");
           return;
        }
        //información del formulario
        var formData = new FormData($("#formOpinionIMSS")[0]);
        formData.append('mes', mes);
         
        $.ajax({            
            type: "POST",
            url: "ajax_uploadOpinionCumplimientoIMSS.php",
            data:formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            success: function(response){ 
                    var msj=response.message;
                    if(response.status=='success'){   
        				    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Archivo subido correctamente </strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                            $("#formOpinionIMSS")[0].reset(); 
                            $("#alertMsg").html(alertMsg1);                    
                            $('#msgAlert').delay(2000).fadeOut('slow');                     
                    }else{
                          alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                          $("#formOpinionIMSS")[0].reset(); 
                          $("#alertMsg").html(alertMsg1);                    
                          $('#msgAlert').delay(2000).fadeOut('slow');       
                    }
            },
            //si ha ocurrido un error
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText); 
            }
        });
  }

  $("#selectmesOPIMSS").change(function(){
    if($("#selectmesOPIMSS").val()==0){
     $("#btncargarImssOP").prop("disabled", true);
     $("#divPDFActualImssOP").hide();

    }else{
        $("#btncargarImssOP").prop("disabled", true);
        $("#divPDFActualImssOP").hide();
//terminar el ajax
        var mes=$("#selectmesOPIMSS").val();
        var fechaHoy = new Date();
        var anio=fechaHoy.getFullYear();

        $.ajax({            
            type: "POST",
            url: "ajax_ConsultaCargaPDFImss.php",
            data:{"mes":mes,"anio":anio},
            dataType: "json",
            success: function(response){ 
                    var msj=response.message;
                    var pdf=response.datos[0]["resultado"];
                    if(response.status=='success'){  
                    if(pdf!=0 && pdf!="") {
                        
                    var p="<a onclick=generarPDFOpinionIMSS('"+mes+"','"+anio+"');><img src='img/pdf.png' height='24px' width='24px'  /></a>";
                    $("#divPDFActualImssOP").show();
                    $("#divPDFActualImssOP").html(p);
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
                        $("#divPDFActualImssOP").hide();
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

  function generarPDFOpinionIMSS(mes,anio){ 
     window.open("uploads/DocumentosOpinionCumplimiento/Imss/"+mes+anio+"/opinionIMSS"+mes+anio+".pdf",'fullscreen=no');     
}
</script>