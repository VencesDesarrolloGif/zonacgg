<!DOCTYPE html>
<?php
 $mes= DATE('m');
 $fechaMinima="2021-01-01";
 $fechaInicio=strtotime($fechaMinima);
 $anioConsultaInicio=date('Y',$fechaInicio);
 $anioActual= DATE('Y');    
?>
<html lang="en">
    <div align="center">
        <div class="card-header">
            <h2>XML</h2>
        </div><br>
        <div class="card border-success mb-3" style="max-width: 60rem;">        
            <br>
            <select id="selectDocXML" name="selectDocXML">
                <option value="0">DOCUMENTO</option>
                <option value="1">IMSS</option>
                <option value="2">INFONAVIT</option>
            </select>

            <select id="selectAnioXML" name="selectAnioXML" style="display:none;">
                <option value="0">EJERCICIO</option>
                    <?php
                        for ($i = $anioActual; $i >= $anioConsultaInicio; $i--) {                                
                            echo "<option value='" . $i. "'>" . $i. " </option>";
                        }
                    ?>
            </select>    

            <select id="selectMesXML" name="selectMesXML" style="display: none;">
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
            
            <div id="divPDFActualXML" hidden="true"></div>  
            
            <div class="card-body text-primary">
              <form enctype='multipart/form-data' id='formXML' name='formXML'>
                <label class="control-label label" for="archivoXML">Seleccionar archivo: </label>
                <span class="btn btn-success btn-file" >Examinar
                    <input type='file' class='btn-success' id='archivoXML' name='archivoXML[]' multiple="" accept=".pdf"/>  
                </span>
                <div class="card-body text-primary">
                 <button id="btncargarXML" type="button" class="btn btn-primary" onclick="cargarXML()" disabled="true">CARGAR</button>    
                </div>      
              </form>
            </div>
      </div>
    </div><!-- DIV CENTER-->
<script src="XML/form_XML.js"></script>
<link rel="stylesheet" href="css-Bootstrap-V4.1.3/js/bootstrap.min.js">
</html>

