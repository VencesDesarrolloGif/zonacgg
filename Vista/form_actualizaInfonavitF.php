<div align="center">
  <h2>Actualización de Infonavit para finiquitos</h2>
  <br>
  <select id="slPeriodoIF" name="slPeriodoIF" class="input-large ">
              <option value="">PERIODO</option>
                <?php
                  for ($i = 0; $i < count($catalogoPeriodos); $i++)
                  {
                    echo "<option value='" . $catalogoPeriodos [$i]["tipoPeriodoId"] . "' >" . $catalogoPeriodos [$i]["descripcionTipoPeriodo"] . " </option>";
                  }
                ?>
            </select>
  <div class="card border-primary mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>Descargar Empleados</h4></div>
    <div class="card-body text-primary">
       <button class="btn-primary" onclick="getEmpleadosWithInfonavit()">Descargar</button>
    </div>
  </div>

  <div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>Actualizar Infonavit</h4></div>
	   <form enctype='multipart/form-data' id='infonavitFiniquito' name='infonavitFiniquito'>
    <div class="card-body text-primary">
			<label class="control-label label" for="deudorInfonavitF">Selecciona archivo: </label>
          <span class="btn btn-success btn-file" >Examinar
            <input type='file' class='btn-success' id='deudorInfonavitF' name='deudorInfonavitF'/> 
          </span>
    </div>            
    </form>
    <!--<button class='btn btn-success' type='button' onclick='actualizarDeudores();'> <img src='img/hojaDatos.png' width='20%'>Formato Alta</button>-->
  </div>
   <h4 id="hultimavezinfonavitfiniquito"></h4>
</div>
<script type="text/javascript">


  
  var fileExtension="";

  $('#deudorInfonavitF').change(function(){  
      var periodo=$('select[name="slPeriodoIF"] option:selected').text();
      if(periodo=="PERIODO"){
        alert("Seleccione el periodo");
        $("#infonavitFiniquito")[0].reset();
        return ;
      }         
      var file = $("#deudorInfonavitF")[0].files[0];      
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensión del archivo
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;

        //información del formulario
        var formData = new FormData($("#infonavitFiniquito")[0]);
        formData.append('tipo', 'infonavitF'+periodo);
        formData.append('documento', 'deudorInfonavitF');
        
        //var message = ""; 
        //hacemos la petición ajax  
        /*for (var value of formData.values()) {
              console.log(value); 
        }*/        
        if(!isDocument(fileExtension))
                {                  
                  alert("Formato de archivo incorrecto");
                  return;                  
                }    
        $.ajax({
            url: 'upload_deudores.php',  
            type: 'POST',
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,


            //mientras enviamos el archivo
            beforeSend: function(){
                //message = $("<span class='before'>Subiendo la imagen, por favor espere...</span>");
                //showMessage(message)                    
            },
            //una vez finalizado correctamente
            success: function(data){    
				        actualizaInfonavit();                              
            },
            //si ha ocurrido un error
            error: function(){
                alert("Error inesperado");
            }
        });
  });  


  function actualizaInfonavit(){
    //alert("actualizando");
      var periodo=$('select[name="slPeriodoIF"] option:selected').text();
      waitingDialog.show();
  		$.ajax({
            
            type: "POST",
            url: "ajax_actualizarDeudores.php",  
            data: {"tipo": "infonavitF"+periodo},        
            dataType: "json",
             success: function(response) {
             	var mensaje=response.mensaje;             	
                if (response.status == "correcto")
                {             		
                   alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Correcto: </strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   $("#infonavitFiniquito")[0].reset(); 
                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(2000).fadeOut('slow'); 
                    calculoFiniquito(0);                                          
                    waitingDialog.hide();                   

                }else
                {
                    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+mensjae+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                       $("#infonavitFiniquito")[0].reset(); 
                        $("#alertMsg").html(alertMsg1);
                        $('#msgAlert').delay(2000).fadeOut('slow');
                        waitingDialog.hide(); 
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                  waitingDialog.hide();
                  alert(jqXHR.responseText); 
                  //alert("Error funcion")
            }
        });
  }

  function isDocument(extension)
{
    switch(extension.toLowerCase()) 
    {
        case 'xlsx':
            return true;
        break;        
        default:
            return false;
        break;
    }
}     


function getEmpleadosWithInfonavit()
{
        
//  alert(apellido);  
  var periodo=$("#slPeriodoIF").val();
  if(periodo==""){
      alert("Seleccione el periodo");
      return 0;
  }       

  window.open("empleadosWithPrestamos.php?option=21&periodo="+periodo,'_self');

}

$("#slPeriodoIF").change(function(){
var periodo=$('select[name="slPeriodoIF"] option:selected').text();
consultarultimasubidadeduccioninfonavitfiniquito(periodo);
});

function consultarultimasubidadeduccioninfonavitfiniquito(periodo){
  $.ajax({
            type: "POST",
            url: "ajax_getultimadeduccion.php",  
            data: {"tipo": "infonavitF"+periodo},        
            dataType: "json",
             success: function(response) {
              //console.log("ultimadeduccionsubida");
             // console.log(response);
              if(response.datos.length!=0){
                var fecha =response.datos[0].fecha;
                $("#hultimavezinfonavitfiniquito").html("Última Carga de Archivo: "+ fecha);          
              }else{$("#hultimavezinfonavitfiniquito").html("Última Carga de Archivo: Sin Información");}
            },
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
               
            }
        });
}



  

</script>