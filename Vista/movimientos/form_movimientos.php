<!DOCTYPE html>
<?php
 $mes= DATE('m');
 $fechaMinima="2024-01-01";
 $fechaInicio=strtotime($fechaMinima);
 $anioConsultaInicio=date('Y',$fechaInicio);
 $anioActual= DATE('Y');    
?>
<html lang="en">
    <div align="center">
      <div class="card border-success mb-3" style="max-width: 60rem;">
            <div class="card-header">
                <h2>Movimientos</h2>
            </div><br>
        <input type='hidden' id='valorActualizarMov' value="">  

          <div id="divZIPActualMov"></div>      


        <select id="selectAnioMov" name="selectAnioMov" class="input-medium">
            <option value="0">EJERCICIO</option>
                <?php
                    for ($i = $anioConsultaInicio; $i <= $anioActual; $i++) {                                
                        echo "<option value='" . $i. "'>" . $i. " </option>";
                    }
                ?>
        </select>    
      <br>
        <select id="selectMesMov" name="selectMesMov" style="display: none;" class="input-medium">
          <option value="0">MES</option>
          <option value="1">ENERO</option>
          <option value="2">FEBRERO</option>
          <option value="3">MARZO</option>
          <option value="4">ABRIL</option>
          <option value="5">MAYO</option>
          <option value="6">JUNIO</option>
          <option value="7">JULIO</option>
          <option value="8">AGOSTO</option>
          <option value="9">SEPTIEMBRE</option>
          <option value="10">OCTUBRE</option>
          <option value="11">NOVIEMBRE</option>
          <option value="12">DICIEMBRE</option>
        </select>   
            
        <div class="card-body text-primary">
          <form enctype='multipart/form-data' id='formMov' name='formMov'>
            <label class="control-label label" for="archivoMov">Seleccionar archivo: </label>
            <span class="btn btn-success btn-file" >Examinar
                <input type='file' class='btn-success' id='archivoMov' name='archivoMov[]' multiple=""/>  
            </span>
            <div class="card-body text-primary">
             <button id="btncargarMov" type="button" class="btn btn-primary" onclick="cargarMov()" disabled="true">CARGAR</button>    
            </div>      
          </form>
        </div>
      </div>
    </div>


<script src="movimientos/form_movimientos.js"></script>
<link rel="stylesheet" href="css-Bootstrap-V4.1.3/js/bootstrap.min.js">
</html>

