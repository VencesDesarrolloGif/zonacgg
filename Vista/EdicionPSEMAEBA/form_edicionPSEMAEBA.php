<!DOCTYPE html>
<?php
 $mes= DATE('m');
 $anioInicio="2020";;
 $anioActual= DATE('Y');    
?>
<html lang="en">
<center>
     <body>
          <div id='divMsgEdicionPSEMAEBA' name='divMsgEdicionPSEMAEBA' ></div>
           <div class="container" align="center"><h1>Edición</h1></div>

           <div style="margin-top: 2%"></div>
           <div class="container top-buffer-submenu vertical-buffer"></div>

            <select id="selectDocEdicion" name="selectDocEdicion" class="input-medium">
                <option value="0">DOCUMENTO</option>
                <option value="1">PUNTO SUA</option>
                <option value="2">EMA</option>
                <option value="3">EBA</option>
            </select>
            <br>
            <br>
            <select id="selectRegPatEdicionPS" name="selectRegPatEdicionPS" Class="input-medium" style="display:none">
                <option value="">REGISTRO PATRONAL</option>
            </select>

            <div id="divAnioEdit" style="display:none">
                <select id="selectAnioDoEdit" name="selectAnioDoEdit" class="input-medium">
                    <option value="0">EJERCICIO</option>
                    <?php
                        for ($i = $anioActual; $i >= $anioInicio; $i--) {                                
                            echo "<option value='" . $i. "'>" . $i. " </option>";
                    }
                ?>
                </select> 
            </div>

            <div id="divMesEdit" style="display:none">
                <select id="selectMesDocEdit" name="selectMesDocEdit" class="input-medium">
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
            </div>
            <br>
            <button style="display:none" id="btnBuscarEdit" class="btn btn-success">Buscar</button>
        <br>
        <br>
        
        <form enctype='multipart/form-data' id='archivoEditadoEdit' name='archivoEditadoEdit'>
            <div id="tablaDatosDocEdit" style="display:none"></div>
        </form>
            <button id="btnguardarDocEditeditado" disabled="true" style="display:none" class="btn btn-success">Guardar</button>
     </body>
  </center>
  </html>
<script src="EdicionPSEMAEBA/funciones_edicionPSEMAEBA.js"></script>