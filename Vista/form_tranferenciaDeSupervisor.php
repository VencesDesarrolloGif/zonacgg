    <div id="alertMsgTransferencia" name="alertMsgTransferencia"></div>

    Transferir del supervisor  
    <select id="selectSupervisorAsignacion1" name="selectSupervisorAsignacion1" class="input-xlarge">

    </select>
    al supervisor 
  <select id="selectSupervisorAsignacion2" name="selectSupervisorAsignacion2" class="input-xlarge" >
      <option>SUPERVISOR</option>
              <?php
                for ($i=0; $i<count($catalogoSupervisoresOperativos); $i++)
                {
                echo "<option value='". $catalogoSupervisoresOperativos[$i]["supervisorId"]."'>". $catalogoSupervisoresOperativos[$i]["nombre"] ." </option>";
                }
              ?>
   </select>
   <button type="button" class="btn btn-success" data-dismiss="modal" onclick="transferencia();">Transferir</button>

   <script type="text/javascript">
   
$(inicioTransSup());  

function inicioTransSup(){
    <?php
        if ($usuario["rol"] =="Analista Asistencia" ){
          ?>
          getSupervisoresBaja();
          <?php
        }
        ?>
}

   function transferencia () 
   {
   	
        var supervisor1=$("#selectSupervisorAsignacion1").val();
        var supervisor2=$("#selectSupervisorAsignacion2").val();
        

       $.ajax({
            type: "POST",
            url: "ajax_tranferenciaEntreSupervisores.php",
            data: {supervisor1:supervisor1, supervisor2:supervisor2},
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;
                if (response.status=="success") {
            
                    alertMsg1="<div id='msgAlert' class='alert alert-success'><trong>Directorio:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsgTransferencia").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    getSupervisoresBaja();


                } else if (response.status=="error")
                {
                    alert(mensaje);
                }

              },
            error: function(){
                  alert('error handing here');
            }
        });  
   }

   function getSupervisoresBaja()
    {
      
       $.ajax({
            type: "POST",
            url: "ajax_getSupervisoresEstatusBaja.php",
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    var supervisores = response.supervisores;
					
                    supervisoresOptions = "<option>SUPERVISOR</option>";
                    for (var i = 0; i < supervisores.length; i++)
                    {
                        supervisoresOptions += "<option value='" + supervisores[i].numeroEmpleado + "'>"+ supervisores[i].nombresupervisor +"</option>";

						
                    }
                    
                    $("#selectSupervisorAsignacion1").html (supervisoresOptions);
                }
            },
            error: function (response)
            {
                console.log (response);
            }
        });
    }
</script>

   