<!DOCTYPE html>
<?php
 $mes= DATE('m');
 $anioInicio="2020";;
 $anioActual= DATE('Y');    
?>
<html lang="en">
<center>
     <body>
          <div id='divMsgSAT' name='divMsgSAT' ></div>
           <div class="container" align="center"><h1>SAT</h1></div>
           <div id="msgSAT" name="msgSAT"></div>

           <div style="margin-top: 2%"></div>
           <div class="container top-buffer-submenu vertical-buffer"></div>

            <select id="selectMovimientoSat" name="selectMovimientoSat" class="input-xlarge">
                <option value="0">DOCUMENTO</option>
                <option value="1">DECLARACIÓN ISR</option>
                <option value="2">DECLARACIÓN IVA</option>
                <option value="3">PAGOS ISR</option>
                <option value="4">PAGOS IVA</option>
                <option value="5">OPINION SAT</option>
                <option value="6">CONSTANCIA DE SITUACIÓN FISCAL</option>
                <option value="7">AFFIDAVIT</option>
            </select>
            <br>
            <br>
            <div id="divAnio" style="display:none">
                <select id="selectAnioDocSAT" name="selectAnioDocSAT" class="input-xlarge">
                    <option value="0">EJERCICIO</option>
                    <?php
                        for ($i = $anioActual; $i >= $anioInicio; $i--) {                                
                            echo "<option value='" . $i. "'>" . $i. " </option>";
                    }
                ?>
                </select> 
            </div>

            <div id="divMes" style="display:none">
                <select id="selectMesDocSAT" name="selectMesDocSAT" class="input-xlarge">
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
            <button style="display:none" id="btnBuscar" class="btn btn-success">Buscar</button>
        <br>
        <br>
        <div id="divDocAgregadosSAT" style="display:none">
           <form enctype='multipart/form-data' id='archivoAddSAT' name='archivoAddSAT'>
              <label>Cargar Documento</label>
              <input type='file' class='btn-success' id='documentoCargadoSAT' name='documentoCargadoSAT[]' multiple="" disabled="true" /> 
            </form>

            <div class="container top-buffer-submenu vertical-buffer">
              <button  id="btnagregarDocSAT" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span>Agregar</button>
              <button id="btnguardarDocSATAgregado" disabled='true' class="btn btn-success">Guardar</button>
            </div>
        </div>
        
        <form enctype='multipart/form-data' id='archivoEditadoSAT' name='archivoEditadoSAT'>
            <div id="tablaDatosDocSAT" style="display:none"></div>
        </form>
            <button id="btnguardarDocSATeditado" disabled="true" style="display:none" class="btn btn-success">Guardar</button>
     </body>
  </center>
  </html>
<script src="SAT/funciones_SAT.js"></script>