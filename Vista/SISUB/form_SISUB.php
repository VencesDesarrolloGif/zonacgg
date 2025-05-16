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
                <h2>SISUB</h2>
            </div><br>
        <input type='hidden' id='valorActualizar' value="">  

        <div id="divPDFActualSISUB" hidden="true"></div>  

        <select id="selectAnioSISUB" name="selectAnioSISUB" class="input-medium">
            <option value="0">EJERCICIO</option>
                <?php
                    for ($i = $anioConsultaInicio; $i <= $anioActual; $i++) {                                
                        echo "<option value='" . $i. "'>" . $i. " </option>";
                    }
                ?>
        </select>    

      <br>

        <select id="selectCuatriSISUB" name="selectCuatriSISUB" style="display: none;">
          <option value="0">CUATRIMESTRE</option>
          <option value="01">ENERO-ABRIL</option>
          <option value="02">MAYO-AGOSTO</option>
          <option value="03">SEPTIEMBRE-DICIEMBRE</option>
        </select>              
            
        <div class="card-body text-primary">
          <form enctype='multipart/form-data' id='formSISUB' name='formSISUB'>
            <label class="control-label label" for="archivoSISUB">Seleccionar archivo: </label>
            <span class="btn btn-success btn-file" >Examinar
                <input type='file' class='btn-success' id='archivoSISUB' name='archivoSISUB[]' multiple="" accept=".pdf"/>  
            </span>
            <div class="card-body text-primary">
             <button id="btncargarSISUB" type="button" class="btn btn-primary" onclick="cargarSISUB()" disabled="true">CARGAR</button>    
            </div>      
          </form>
        </div>
      </div>
    </div>
<script src="SISUB/form_SISUB.js"></script>
<link rel="stylesheet" href="css-Bootstrap-V4.1.3/js/bootstrap.min.js">
</html>

