<?php
 $fechaMinima="2020-01-01";
 $fechaInicio=strtotime($fechaMinima);
 $anioConsultaInicioRI=date('Y',$fechaInicio);
 $anioActualRI= DATE('Y');    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link  href="css-Bootstrap-V4.1.3/css/bootstrap.min.css" >
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/popper.min.js" >
    </head>
    <body>
        <center>
            <b><h3 class="card-title">Incidencias</h3></b>
            <div id="msgInc"></div>
            
            <br>

            <select id="selectTipoBusquedaRI" name="selectTipoBusquedaRI" data-live-search="true" class="input-large" data-size="9">
              <option value="0">RANGO DE FECHAS</option>
              <option value="1">QUINCENAL</option>
              <option value="2">MENSUAL</option>
            </select>

            <select id="selectEjercicioRI" name="selectEjercicioRI" data-live-search="true" class="input-large" data-size="9">
                      <option value="0">EJERCICIO</option>
                      <?php
                        for($i = $anioConsultaInicioRI; $i <= $anioActualRI; $i++) {                                
                          echo "<option value='" . $i. "'>" . $i. " </option>";
                        }
                      ?>
            </select>


            <select id="selectMesRI" name="selectMesRI"  data-live-search="true" class="input-extralarge">
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

            <div id="divSelectQuincenaRI" style="display: none;">
              <select id="selectQuincenaRI" name="selectQuincenaRI">
                <option value="0">QUINCENA</option>
              </select>
            </div>
            <br>
        <select id="lineaNegocioInc" name="lineaNegocioInc">
            <option value="0">LINEA DE NEGOCIO</option>
            <option value="1">SEGURIDAD FISICA</option>
            <option value="2">SEGURIDAD ELECTRÓNICA</option>
            <option value="3">SEGURIDAD TRANSPORTE</option>
            <option value="4">SEGURIDAD SATELITAL</option>
            <option value="5">DIRECCION GA</option>
        </select>
        <br>
        <select id="selectTipoBusquedaInc" name="selectTipoBusquedaInc">
          <option value="0">TIPO</option>
          <option value="1">GENERAL</option>
          <option value="2">CLIENTE</option>
          <option value="3">ENTIDAD</option>
          <!-- <option value="4">SUPERVISOR</option> -->
        </select>
        <br>
        <select id="selectXTipo" style="display: none;"></select>
        <br>
           <button id="btnConsultarInc" type="button" class="btn btn-primary">CONSULTAR</button>    
        </center>
        <br>
        <br>
        <section>
<form class="form-horizontal" id="form_tablasDinamicasInc" name="form_tablasDinamicasInc" action="IncidenciaReporte/ficheroExportReporteIncidencias.php" target="_blank" method="post">

        <input type="hidden" id="datos_TablaInc" name="datos_TablaInc"/>
        <div class="container top-buffer-submenu vertical-buffer">
                <div id="tablaDinamicaTP" align="center"></div>
            </div><br><br>
            <div class="container top-buffer-submenu vertical-buffer">
                <div id="tablaDinamicaTurnosP" align="center"></div>
            </div>
            <br>
            <br>
           <div class="container top-buffer-submenu vertical-buffer">
                <div id="tablaDinamicaInc" align="center"></div>
            </div>
            <br>
            <br>
            <div class="container top-buffer-submenu vertical-buffer">
                <div id="tablaDinamicaIncEsp" align="center"></div>
            </div>
            <center>
            <button id="descargaTablaInc" name="descargaTablaInc" class="btn btn-success" type="button" style="display:none;"> <span class="glyphicon glyphicon-download-alt"></span>Descargar</button>
            </center>
</form>

        </section>
        <script src="IncidenciaReporte/funciones_Incidencias.js"></script>
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/js/bootstrap.min.js">
    </body>
</html>