<div class="container" align="center">

<form class="form-horizontal"  method="post" name='form_crearProveedor' id="form_crearProveedor" enctype="multipart/form-data">

  

<br><br>
  <legend><h3>Datos del Proveedor</h3></legend>
  <table class="table2"  >
        <tr><td  rowspan="10"><img src="img/clientes.jpg"></td><td><label class="control-label1 label" for="txtNumeroContable">Numero Contable</label></td>
            <td><input id="txtNumeroContable" placeholder="0000-000-000" name="txtNumeroContable" type="text" class="input-medium" maxlength="12" ></td>
        </tr>
        <tr >
          <td><label class="control-label1 label " for="nombreProveedor">Nombre</label></td>
          <td><input id="nombreProveedor" name="nombreProveedor" type="text" class="input-large"/></td>

        </tr>
        <tr>
          <td><label class="control-label1 label " for="rfcProveedor">RFC</label></label> </td>
          <td><input id="rfcProveedor" name="rfcProveedor" type="text" class="input-large" /></td>
        </tr>
        <tr>
          <td><label class="control-label1 label " for="contactoProveedor">Nombre Contacto</label></label> </td>
          <td><input id="contactoProveedor" name="contactoProveedor" type="text" class="input-large" /></td>
        </tr>
       <tr>
          <td><label class="control-label1 label " for="selectBancoProv">Banco</label></label> </td>
          <td><select id="selectBancoProv" name="selectBancoProv" class="input-large">
              <?php
                  for ($i=0; $i<count($catalogoBancos); $i++)
                  {
                    echo "<option value='". $catalogoBancos[$i]["idCuentaBanco"]."'>". $catalogoBancos[$i]["nombreBanco"] ." </option>";
                  }                  
                ?>
                </select>
          </td>
        </tr>
        <tr>
          <td><label class="control-label1 label " for="noCuentaProveedor">No Cuenta</label></label> </td>
          <td><input id="noCuentaProveedor" name="noCuentaProveedor" type="text" class="input-large" /></td>
        </tr>
        <tr>
          <td><label class="control-label1 label " for="ctaProveedor">CTA Clabe</label></label> </td>
          <td><input id="ctaProveedor" name="ctaProveedor" type="text" class="input-large" /></td>
        </tr>
        <tr>
          <td><label class="control-label1 label " for="correoProveedor">Email</label></label> </td>
          <td><input id="correoProveedor" name="correoProveedor" type="text" class="input-large" /></td>
        </tr>
         <tr>
          <td><label class="control-label1 label " for="telefonoProveedor">Telefono</label></label> </td>
          <td><input id="telefonoProveedor" name="telefonoProveedor" type="text" class="input-large" /></td>
        </tr>
        <tr>
          <td><label class="control-label1 label " for="domicilioProveedor">Domicilio Fiscal</label></label> </td>
          <td><input id="domicilioProveedor" name="domicilioProveedor" type="text" class="input-large" /></td>
        </tr>
        
                

   </table>
   <br>
   <button type='button' class='btn btn-success' id='btnRegistrarProveedor' name='btnRegistrarProveedor' onclick='registrarProveedor()'>Registrar</button>


</form>

</div>

<script type="text/javascript">
  


function registrarProveedor(){

        var datastring = $("#form_crearProveedor").serialize();

        //datastring += "&puntoServicio=" + puntoServicio; 
        //alert(datastring);              
        $.ajax({            
            type: "POST",
            url: "ajax_newProveedor.php",
            data: datastring,
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {
            

                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Registro de proveedor: </strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(6000).fadeOut('slow');

                    limpiarFormNuevoProveedor();
                    getProveedores();


                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Registro de proveedor:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(4000).fadeOut('slow');
                }                 


            },
           error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText); 
            }
        });  

  
      }


      function limpiarFormNuevoProveedor(){

        $("#nombreProveedor").val("");
        $("#rfcProveedor").val("");                    
        $("#contactoProveedor").val("");
        $("#bancoProveedor").val("");
        $("#noCuentaProveedor").val("");
        $("#ctaProveedor").val("");
        $("#correoProveedor").val("");
        $("#telefonoProveedor").val("");
        $("#domicilioProveedor").val("");

      }

     

</script>