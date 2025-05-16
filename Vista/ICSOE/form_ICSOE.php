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
      <div class="card border-success mb-3" style="max-width: 60rem;">
            <div class="card-header">
                <h2>ICSOE</h2>
            </div><br>
        <input type='hidden' id='valorActualizar' value="">  

        <div id="divPDFActualICSOE" hidden="true"></div>  

        <select id="selectAnioICSOE" name="selectAnioICSOE" class="input-medium">
            <option value="0">EJERCICIO</option>
                <?php
                    for ($i = $anioConsultaInicio; $i <= $anioActual; $i++) {                                
                        echo "<option value='" . $i. "'>" . $i. " </option>";
                    }
                ?>
        </select>    

      <br>
        <select id="selectCuatriICSOE" name="selectCuatriICSOE" style="display: none;">
          <option value="0">CUATRIMESTRE</option>
          <option value="01">ENERO-ABRIL</option>
          <option value="02">MAYO-AGOSTO</option>
          <option value="03">SEPTIEMBRE-DICIEMBRE</option>
        </select> 

      <br>            
            
        <div class="card-body text-primary">
          <form enctype='multipart/form-data' id='formICSOE' name='formICSOE'>
            <label class="control-label label" for="archivoICSOE">Seleccionar archivo: </label>
            <span class="btn btn-success btn-file" >Examinar
                <input type='file' class='btn-success' id='archivoICSOE' name='archivoICSOE[]' multiple="" accept=".pdf"/>  
            </span>
            <div class="card-body text-primary">
             <button id="btncargarICSOE" type="button" class="btn btn-primary" onclick="cargarICSOE()" disabled="true">CARGAR</button>    
            </div>      
          </form>
        </div>
      </div>
    </div>
<script src="ICSOE/form_ICSOE.js"></script>
<link rel="stylesheet" href="css-Bootstrap-V4.1.3/js/bootstrap.min.js">
</html>

