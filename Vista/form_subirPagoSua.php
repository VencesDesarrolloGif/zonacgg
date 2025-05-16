<?php
 $mes= DATE('m');
 $anioInicio="2020";;
 $anioActual= DATE('Y');    
?>
<div align="center">
  <h2>Subir Pago SUA</h2>
  <div class="card border-success mb-3" style="max-width: 851rem;">
    <div class="card-header"></div>    
    <select id="selectReg" name="selectReg">
        <option value="0">REGISTRO PATRONAL</option>
        <?php
        for($i = 0; $i < count($catalogoRegistrosPatronales); $i++) {
           if ($catalogoRegistrosPatronales[$i]["idcatalogoRegistrosPatronales"] != 'R1438682103') {
        echo "<option value='" . $catalogoRegistrosPatronales[$i]["idcatalogoRegistrosPatronales"] . "'>" . $catalogoRegistrosPatronales[$i]["idcatalogoRegistrosPatronales"] . " </option>";
            }
        }
        ?>
    </select>

        <select id="selectAnioPagoSUA" name="selectAnioPagoSUA">
            <option value="0">EJERCICIO</option>
            <?php
                for ($i = $anioActual; $i >= $anioInicio; $i--) {                                
                    echo "<option value='" . $i. "'>" . $i. " </option>";
                }
            ?>
        </select> 

    <select id="selectmes" name="selectmes">
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
			
        <form enctype='multipart/form-data' id='formSuaImss' name='formSuaImss'>
            <label class="control-label label" for="pagoSuaImss">Selecciona archivo Imss: </label>
            <span class="btn btn-success btn-file" >Examinar
              <input type='file' class='btn-success' id='pagoSuaImss' name='pagoSuaImss[]' multiple="" accept=".pdf"/>  
            </span>
        </form>

        <form enctype='multipart/form-data' id='formSuaInfonavit' name='formSuaInfonavit'>
            <label class="control-label label" for="pagoSuaInfonavit">Selecciona archivo Infonavit: </label>
            <span class="btn btn-success btn-file" >Examinar
              <input type='file' class='btn-success' id='pagoSuaInfonavit' name='pagoSuaInfonavit[]' multiple="" accept=".pdf"/>  
            </span>
        </form>

        <form enctype='multipart/form-data' id='formSuaPagoSua' name='formSuaPagoSua'>

            <label class="control-label label" for="pagoSuaPago">Selecciona archivo Pago: </label>
            <span class="btn btn-success btn-file" >Examinar
              <input type='file' class='btn-success' id='pagoSuaPago' name='pagoSuaPago[]' multiple="" accept=".pdf"/>  
            </span>
        </form>

        <form enctype='multipart/form-data' id='formSuaPunto' name='formSuaPunto'>
            <label class="control-label label" for="puntoSUA">Selecciona Punto SUA: </label>
            <span class="btn btn-success btn-file" >Examinar
              <input type='file' class='btn-success' id='puntoSUA' name='puntoSUA[]' multiple="" accept=".pdf"/>  
            </span>
        </form>

        <form enctype='multipart/form-data' id='formSuaLineaC' name='formSuaLineaC'>

            <label class="control-label label" for="puntoSUA">Selecciona Linea de captura: </label>
            <span class="btn btn-success btn-file" >Examinar
              <input type='file' class='btn-success' id='lineaCaptura' name='lineaCaptura[]' multiple="" accept=".pdf"/>  
            </span>
        </form>

        <form enctype='multipart/form-data' id='formSuaresumenL' name='formSuaresumenL'>
            <label class="control-label label" for="puntoSUA">Resumen de liquidacion: </label>
            <span class="btn btn-success btn-file" >Examinar
              <input type='file' class='btn-success' id='resumenLiquidacion' name='resumenLiquidacion[]' multiple="" accept=".pdf"/>  
            </span>
        </form>  
        
        <div class="card-body text-primary">
            <button type="button" class="btn btn-primary" onclick="enviarP()">Cargar</button>    
        </div>      
    </div>  
  </div>
</div>
<script type="text/javascript">

  function enviarP (){     
        var registro=$("#selectReg").val();
        var mes=$("#selectmes").val();
        var anio=$("#selectAnioPagoSUA").val();
        var archivoimss     =$("#pagoSuaImss").val();
        var archivoinfonavit=$("#pagoSuaInfonavit").val();
        var archivopago     =$("#pagoSuaPago").val();
        var archivoPunto    =$("#puntoSUA").val();
        var archivoLineaCaptura =$("#lineaCaptura").val();
        var archivoResumenLiquidacion =$("#resumenLiquidacion").val();

        if(registro==""){
            alert("Selecciona un registro patronal");
            //$("#formSua")[0].reset();
            return;
        }else if(mes==="0"){
           alert("Selecciona un mes");
           return;

        }else if(anio==="0"){
           alert("Selecciona un mes");
           return;

        }else if(archivoimss!="" || archivoinfonavit!="" || archivopago!="" || archivoPunto!="" || archivoLineaCaptura!="" || archivoResumenLiquidacion!=""){


            if(archivoimss!=""){
                // alert("entre archivoimss");
                cargarDocumentoPagoSUA(0,registro,mes,anio,"formSuaImss","pagoSuaImss");
            }if(archivoinfonavit!=""){
                // alert("entre archivoinfonavit");
                cargarDocumentoPagoSUA(1,registro,mes,anio,"formSuaInfonavit","pagoSuaInfonavit");
            }if(archivopago!=""){
                // alert("entre archivopago");
                cargarDocumentoPagoSUA(2,registro,mes,anio,"formSuaPagoSua","pagoSuaPago");
            }if(archivoPunto!=""){
                // alert("entre archivoPunto");
                cargarDocumentoPagoSUA(3,registro,mes,anio,"formSuaPunto","puntoSUA");
            }if(archivoLineaCaptura!=""){
                // alert("entre archivoLineaCaptura");
                cargarDocumentoPagoSUA(4,registro,mes,anio,"formSuaLineaC","lineaCaptura");
            }if(archivoResumenLiquidacion!=""){
                // alert("entre archivoResumenLiquidacion");
                cargarDocumentoPagoSUA(5,registro,mes,anio,"formSuaresumenL","resumenLiquidacion");
            }

            
    }else if(archivoimss=="" || archivoinfonavit=="" || archivopago=="" || archivoPunto=="" || archivoLineaCaptura==""){
            alert("cargue al menos un documento para continuar");
            return;
    }
  }

  function cargarDocumentoPagoSUA(caso,registro,mes,anio,nombreForm,idInput){

    var formData = new FormData($("#"+nombreForm+"")[0]);
            formData.append('registro', registro);
            formData.append('mes', mes);
            formData.append('anio', anio);
            formData.append('caso', caso);
            formData.append('caso', caso);
            formData.append('idInput', idInput);

            $.ajax({            
                type: "POST",
                url: "upload_pagoSua.php",
                data:formData,
                dataType: "json",

                cache: false,
                contentType: false,
                processData: false,
                success: function(response){ 
                        var msj=response.message;
                        if(response.status=='success'){   
                                  alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Archivo subido correctamente </strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                               $("#"+nombreForm+"")[0].reset(); 
                                $("#alertMsg").html(alertMsg1);                    
                                $('#msgAlert').delay(2000).fadeOut('slow');    
                                $("#selectReg").val(0);
                                $("#selectAnioPagoSUA").val(0);
                                $("#selectmes").val(0);
                                $("#pagoSuaImss").val("");                 
                        }else{
                            alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                               $("#"+nombreForm+"")[0].reset(); 
                                $("#alertMsg").html(alertMsg1);                    
                                $('#msgAlert').delay(2000).fadeOut('slow');       
                        }
                },
                error: function(jqXHR, textStatus, errorThrown){
                      alert(jqXHR.responseText); 
                }
            });
  }
</script>