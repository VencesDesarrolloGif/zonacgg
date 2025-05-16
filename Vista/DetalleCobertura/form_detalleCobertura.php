<!DOCTYPE html>
<?php
 $mes= DATE('m');
 $fechaMinima="2021-01-01";
 $fechaInicio=strtotime($fechaMinima);
 $anioConsultaInicio=date('Y',$fechaInicio);
 $anioActual= DATE('Y');    
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link  href="css-Bootstrap-V4.1.3/css/bootstrap.min.css" >
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/popper.min.js" >
    </head>
    <body>
        <center><h3 class="card-title">Detalle Cobertura</h3>
        <div id="msgDetalleCobertura"></div>

        <br>
        <select id="lineaNegocioDetalleCobertura" name="lineaNegocioDetalleCobertura" class="input-large"></select>
        <br>
        <select id="selectAnioDetalleCobertura" name="selectAnioDetalleCobertura" class="input-large">
            <option value="0">EJERCICIO</option>
                <?php
                    for ($i = $anioActual; $i >= $anioConsultaInicio; $i--) {                                
                        echo "<option value='" . $i. "'>" . $i. " </option>";
                    }
                ?>
        </select> 
            <br>
        <select id="selectMesDetalleCobertura" name="selectMesDetalleCobertura" class="input-large">
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
        <br>
           <button id="btnCalcularTurnos" type="button" class="btn btn-primary">CARGAR</button>    
        </center>
        <br>
        <br>
        <section>
            <table id="tablaDetalleCobertura"  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" style="display: none;">
                <thead class="thead-dark">
                    <tr>
                        <th style="text-align: center;background-color: #B0E76E">Entidad</th>       
                        <th style="text-align: center;background-color: #B0E76E">Turnos Día Solicitados</th>
                        <th style="text-align: center;background-color: #B0E76E">Turnos Día Cubiertos</th>
                        <th style="text-align: center;background-color: #B0E76E">Porcentaje Turnos Día Cubiertos</th>
                        <th style="text-align: center;background-color: #B0E76E">Turnos Noche Solicitados</th>
                        <th style="text-align: center;background-color: #B0E76E">Turnos Noche Cubiertos</th>
                        <th style="text-align: center;background-color: #B0E76E">Porcentaje Turnos Noche Cubiertos</th>
                        <th style="text-align: center;background-color: #B0E76E">Total Turnos Solicitados</th>
                        <th style="text-align: center;background-color: #B0E76E">Total Turnos Cubiertos</th>
                        <th style="text-align: center;background-color: #B0E76E">Porcentaje General De Turnos Cubiertos</th>
                    </tr>
                </thead>
            </table>
        </section>
        <script src="DetalleCobertura/funciones_detalleCobertura.js"></script>
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/js/bootstrap.min.js">
    </body>
</html>