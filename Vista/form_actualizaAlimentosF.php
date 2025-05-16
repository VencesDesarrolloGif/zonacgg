<div align="center">
  <h2>Actualización de Alimentos para nominas</h2>
  <br>
  <select id="slPeriodoAN" name="slPeriodoAN" class="input-large ">
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
       <button class="btn-primary" onclick="getEmpleadosWithAlimentosF()">Descargar</button>
    </div>
  </div>

  <div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>Actualizar Alimentos</h4></div>
	   
    <div class="card-body text-primary">
      <form enctype='multipart/form-data' id='AlimentosNomina' name='AlimentosNomina'>
			<label class="control-label label" for="alimentosNomi">Selecciona archivo: </label>
          <span class="btn btn-success btn-file" >Examinar
            <input type='file' class='' id='alimentosNomi' name='alimentosNomi' onchange="cambioAliF()" /> 
          </span>
      </form>
    </div>            
    
    <!--<button class='btn btn-success' type='button' onclick='actualizarDeudores();'> <img src='img/hojaDatos.png' width='20%'>Formato Alta</button>-->
  </div>
  <h4 id="hultimavezalimentosF"></h4>
</div>
<script type="text/javascript">


  

  function cambioAliF(){            
      var periodo=$('select[name="slPeriodoAN"] option:selected').text();
      if(periodo=="PERIODO"){
        alert("Seleccione el periodo");
        $("#AlimentosNomina")[0].reset();
        return ;
      }
      var file = $("#alimentosNomi")[0].files[0];      
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensión del archivo
        var fileExtensionF = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;

        //información del formulario
        var formData = new FormData($("#AlimentosNomina")[0]);
        formData.append('tipo', 'AlimentosN'+periodo);
        formData.append('documento', 'alimentosNomi');
        
        //var message = ""; 
        //hacemos la petición ajax  
        /*for (var value of formData.values()) {
              console.log(value); 
        }*/        
        if(!isDocumentAF(fileExtensionF))
                {                  
                  alert("Formato de archivo incorrecto");
                  return;                  
                }

        var msj=verificarCierrePeriodo($("#slPeriodoAN").val());
        if(msj!='correcto'){
            alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";             
              $("#alertMsg").html(alertMsg1);
              $('#msgAlert').delay(2000).fadeOut('slow'); 
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
				        actualizaAlimentosF();                              
            },
            //si ha ocurrido un error
            error: function(){
                alert("Error inesperado");
            }
        });
  } 


  function actualizaAlimentosF(){
    var periodo=$('select[name="slPeriodoAN"] option:selected').text();
     waitingDialog.show();
  		$.ajax({
            
            type: "POST",
            url: "ajax_actualizarDeudores.php",  
            data: {"tipo": "AlimentosN"+periodo},        
            dataType: "json",
             success: function(response) {
             	var mensaje=response.mensaje;             	
                if (response.status == "correcto")
                {             		
                   alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Correcto: </strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   $("#AlimentosNomina")[0].reset(); 
                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(2000).fadeOut('slow');                                            
                    waitingDialog.hide();           

                }else
                {
                    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+mensaje+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                       $("#fonacotFiniquito")[0].reset(); 
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

  function isDocumentAF(extension)
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


function getEmpleadosWithAlimentosF()
{
        
//  alert(apellido);  
  var periodo=$("#slPeriodoAN").val();
  if(periodo==""){
      alert("Seleccione el periodo");
      return 0;
  }
  window.open("empleadosWithPrestamos.php?option=31&periodo="+periodo,'_self');

}

$("#slPeriodoAN").change(function(){
var periodo=$('select[name="slPeriodoAN"] option:selected').text();
consultarultimasubidadeduccionalimentosF(periodo);
});

function consultarultimasubidadeduccionalimentosF(periodo){
  $.ajax({
            type: "POST",
            url: "ajax_getultimadeduccion.php",  
            data: {"tipo": "AlimentosN"+periodo},        
            dataType: "json",
             success: function(response) {
              //console.log("ultimadeduccionsubida");
             // console.log(response);
              if(response.datos.length!=0){
                var fecha =response.datos[0].fecha;
                $("#hultimavezalimentosF").html("Última Carga de Archivo: "+ fecha);          
              }else{$("#hultimavezalimentosF").html("Última Carga de Archivo: Sin Información");}
            },
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
               
            }
        });
}




  

</script>