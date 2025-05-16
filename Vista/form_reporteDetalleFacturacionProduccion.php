<div class="container" align="center" >
    <form class="form-horizontal" id="form_consultaReporteDetalle" name="form_consultaReporteDetalle" action="ficheroExportReporteDetalle.php" target="_blank" method="post">

        <div>
            CLIENTE: <select id="selectClienteReporte" name="selectClienteReporte" class="selectpicker" data-live-search="true" class="input-large" data-size="9"><option>TODOS</option>
            <?php
for ($i = 0; $i < count($catatoloClientes); $i++) {
    echo "<option value='" . $catatoloClientes[$i]["idCliente"] . "'>" . $catatoloClientes[$i]["razonSocial"] . " </option>";
}
?>
            </select>
            <br>
            <br>
       <!--     LINEA NEGOCIO:<select id="selLineaNegocioRporteF" name="selLineaNegocioRporteF" class="span3"></select>
            <br>
            <br>  -->
            DE:<input id="txtFechaReporteDetalle1" name="txtFechaReporteDetalle1" type="text" class="input-medium"> A: <input id="txtFechaReporteDetalle2" name="txtFechaReporteDetalle2" type="text" class="input-medium">

            <button class="btn btn-primary" type="button" onclick="seleccionarReporte();"> Generar Reporte</button>
        </div>

          <br>
          <br>
        <input type="hidden" id="datos_reporte" name="datos_reporte" />
        <div id="divReporteDetalle" name="divReporteDetalle" align="center" class='container'><br><br>
          <br>
          <br>
        <div id="divTableReporteDetalle" name="divTableReporteDetalle"></div><br><br>

        </div>
        <br>

        <br>
        <table id="tableReporteGeneral" name="tableReporteGeneral" class='table table-bordered table-striped'></table>

        <button id="descargarReporteDetalle" name="descargarReporteDetalle" class="btn btn-success" type="button"> <span class="glyphicon glyphicon-download-alt"></span>Descargar Excel</button>
        <br>
        <br>
    </form>
</div> <!-- fin div container -->


 <script type="text/javascript">
    var contadorTurnos=0;
    var consulta=0;

    function seleccionarReporte(){
      var idClientePunto=$("#selectClienteReporte").val();
     /*var selLineaNegocioRporteF=$("#selLineaNegocioRporteF").val();
      if(selLineaNegocioRporteF=="0" || selLineaNegocioRporteF==""){
        alert("Selecciona Una Linea De Negocio Para Generar El Reporte");
      }else{*/
        if(idClientePunto!='TODOS'){
          crearTablaDetalleReporte(idClientePunto);
        }else{
          consulta=0;
          consultaClientes();
        }
      //} se comento para que este listo en caso de ser utilizado por lineas de negocio
    }

   /* function getLineasNegocioParaReporteF(){
    $.ajax({
      type: "POST",
      url: "ajax_obtenerlineanegocio.php",
      dataType: "json",
      success: function(response) {
        //console.log(response.placas);
        $("#selLineaNegocioRporteF").empty();
        $('#selLineaNegocioRporteF').append('<option value="0"></option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#selLineaNegocioRporteF').append('<option value="' + (response.datos[i].idLineaNegocio) + '">' + response.datos[i].descripcionLineaNegocio + '</option>');
          }
        }else{
          alert("Error al cargar Linea De Negocio");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }*/

     function crearTablaDetalleReporte1(idClientePunto){


     var fecha1=$("#txtFechaReporteDetalle1").val();
     var fecha2=$("#txtFechaReporteDetalle2").val();
    // var selLineaNegocioRporteF=$("#selLineaNegocioRporteF").val();
     var result="";
      $.ajax({

            type: "POST",
            url: "ajax_reporteIngresoByCliente.php",
            data : {"fecha1":fecha1, "fecha2":fecha2, idClientePunto:idClientePunto},// "selLineaNegocioRporteF":selLineaNegocioRporteF
            dataType: "json",
            async: false,
            success: function(response) {
             // console.log(response);
                if (response.status == "success")
                {


                    var lista = response.lista;



                    var nombreEntidadFederativaE="";

                    var turnosCliente=0;
                    var cobroCliente=0;
                    var turnosPresupuestadosCliente=0;
                    var cobroPresupuestadosCliente=0;

                    //listaTable="<table class='table table-bordered table-striped'><tbody>";
                     //ENCABEZADO DE FECHA
                    moment.locale('Es');
                    var dateTime = moment(fecha1);
                    var fullTime = dateTime.format('LL');
                    var dateTime2 = moment(fecha2);
                    var fullTime2 = dateTime2.format('LL');

                    var totalTurnosPresupuestados = 0;
                    var totalCobroPresuppuestado=0;
                    var totalTurnosCubiertos=0;
                    var totalCobroByCobertura=0;
                    var listaTable="";

                    var pagoNominaTotal=0;
                    var pagoNominaTotalEntidad=0;
                    var pagoNominaTotalCliente=0;

                    //CAMPOS PARA EMA
                    var totalDiasImssEntidad=0;
                    var totalPagoSuaEntidad=0


                    var totalDiasImssCliente=0;
                    var totalPagoSuaCliente=0;

                    //CAMPOS EBA
                    var totalDiasEbaEntidad=0;
                    var totalSumaEbaEntidad=0
                    var totalSumaInfonavitEntidad=0

                    var totalDiasInfoCliente=0;
                    var totalPagoEbaCliente=0;
                    var totalInfonavitCliente=0;

                    //VARIABLES FACTURACION
                    var turnosFacEntidad=0;
                    var turnosFacCliente=0;
                    var montoFacEntidad=0;
                    var montoFacCliente=0;



                    //VARIABLES DE COSTO UNIFORMES

                    var totalUniformesEntidad=0;
                    var totalUniformesCliente=0;

                    //VARIABLES GASTO

                    var totalGastoEntidad=0;
                    var totalGastoCliente=0;
                    var promedio=0.0;

                    var totalTurnos=0;
                    var totalTurnosEntidad=0;
                    var totalTurnosCliente=0;
                    var a=0;
                    if(consulta==0)
                      listaTable+= "<tr><td style='background-color:#5ECFF3; text-align:center ;font-size:x-large; font-weight: bold;display:none;' colspan='32'> PERIODO: "+fullTime+" AL "+fullTime2+"</td></tr>";
                    for (var i in lista)
                    {

                        var idEstado=lista[i].idEstado;
                        var nombreEntidadFederativa= lista[i].Entidad;
                        var fechaInicio=lista[i].fechaInicio;
                        var fechaTermino=lista[i].fechaTermino;
                        //$("#tableReporteGeneral").find("tr:gt(0)").remove();
                        var idPuntoServicioNom=lista[i].idPuntoServicio;
                        var puestoCobertura=lista[i].idPuesto;
                       var roloperativo =lista[i].rolOperativo;


                        if(nombreEntidadFederativaE!=nombreEntidadFederativa)
                        {
                          promedio=parseFloat(calculoSumaGastoEntidad(idEstado,fecha1,fecha2));

                          if (totalTurnosPresupuestados > 0)
                          {

                              var porcentajeTurnosT=(totalTurnosCubiertos/totalTurnosPresupuestados)*100;
                              listaTable += "<tr>";
                              listaTable += "<td colspan='14'>Total entidad:</td>";
                              listaTable += "<td style='background-color:#FFFF00;'>" +totalTurnosPresupuestados+"</td>";
                              listaTable += "<td style='background-color:#05F9AB;'>" +format(totalCobroPresuppuestado,2)+"</td>";
                              listaTable += "<td style='background-color:#FFFF00;'>" +totalTurnosCubiertos+"</td>";
                              listaTable += "<td style='background-color:#05F9AB;'>" +format(totalCobroByCobertura,2)+"</td>";
                              //listaTable += "<td style='background-color:#05F9AB;'>" +turnosFacEntidad+"</td>";
                              //listaTable += "<td style='background-color:#05F9AB;'>" +format(montoFacEntidad,2)+"</td>";

                              listaTable += "<td>" +diferenciaTurnosEntidad+"</td>";
                              listaTable += "<td style='background-color:#05F9AB;'>" +format(diferenciaCobroEntidad,2)+"</td>";
                              listaTable += "<td style='background-color:#F7AC20;'>" +totalTurnosEntidad+"</td>";
                              listaTable += "<td style='background-color:#F7AC20;'>" +format(pagoNominaTotalEntidad,2) +"</td>";
                              listaTable += "<td>" +totalDiasImssEntidad+"</td>";
                              listaTable += "<td>" +format(totalPagoSuaEntidad,2)+"</td>";
                              listaTable += "<td style='background-color:#F7CCCC;'>" +totalDiasEbaEntidad+"</td>";
                              listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalSumaEbaEntidad,2)+"</td>";
                              listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalSumaInfonavitEntidad,2)+"</td>";
                              listaTable += "<td style='background-color:#89E0F9;'>" +format(totalUniformesEntidad,2)+"</td>";
                              listaTable += "<td style='background-color:#89E0F9;'>" +format(totalGastoEntidad,2)+"</td>";
                              listaTable += "<td style='background-color:#FFFF00;'>" +porcentajeTurnosT.toFixed(2)+" %</td>";
                              listaTable += "</tr>";
                          }

                          listaTable+= "<tr><td style='background-color:#BCF5A9; text-align:center ; font-weight: bold;' colspan='32'>"+nombreEntidadFederativa+" </td></tr>";
                          listaTable+="<tr style='text-align:center ; font-weight: bold;'><td>#Elementos</td><td>Linea Negocio</td><td>Puesto</td><td>Rol</td><td>Rol Operativo</td><td>Punto Servicio</td><td>Region</td><td>Supervisor a Cargo</td><td>#Centro de Costo</td><td>Cuenta contable</td>";
                          listaTable+="<td>Entidad</td><td>Fecha inicio</td><td>Fecha fin</td><td>Costo Turno</td>";
                          listaTable+="<td style='background-color:#FFFF00;'>Turnos presupuestados</td><td style='background-color:#05F9AB;'>Cobro Presupuestado</td><td style='background-color:#FFFF00;'>Turnos Cubiertos Perfil</td><td style='background-color:#05F9AB;'>Cobro Cobertura</td><td>Diferencia Turnos</td><td style='background-color:#05F9AB;'>Diferencia $</td><td style='background-color:#F7AC20;'>Turnos Pagados</td><td style='background-color:#F7AC20;'>$ Pago Nomina</td><td>Dias Imss</td><td>Pago Sua</td><td style='background-color:#F7CCCC;'>Dias EBA</td><td style='background-color:#F7CCCC;'>Suma EBA</td><td style='background-color:#F7CCCC;'>Suma Infonavit</td><td style='background-color:#89E0F9;'>Costo Uniformes</td><td style='background-color:#89E0F9;'>Gasto</td><td style='background-color:#FFFF00;'>Cobertura %</td></tr>";//<td style='background-color:#FFFF00;'>Cobertura %</td> agregar cuando se corrija
                          //<td style='background-color:#FFFF00;' title='Recuerda que tu consulta debe ser mensual, Así mismo los datos ingresados deben ser mensuales. De lo contrario tu reporte se verá afectado.'>Turnos facturados</td><td style='background-color:#FFFF00;' title='Recuerda que tu consulta debe ser mensual, Así mismo los datos ingresados deben ser mensuales. De lo contrario tu reporte se verá afectado.'>Monto facturado</td> desabilitado por peticion

                          nombreEntidadFederativaE=nombreEntidadFederativa;

                           // Reiniciamos la variable de la sumatoria
                          totalTurnosPresupuestados = 0;
                          totalCobroPresuppuestado=0;
                          totalTurnosCubiertos=0;
                          totalCobroByCobertura=0;
                          pagoNominaTotalEntidad=0;
                          totalTurnosEntidad=0;

                          totalDiasImssEntidad=0;
                          totalPagoSuaEntidad=0;


                          //campos eba
                          totalDiasEbaEntidad=0;
                          totalSumaEbaEntidad=0;
                          totalSumaInfonavitEntidad=0;


                          //CAMPOS FACTURACION
                          turnosFacEntidad=0;
                          montoFacEntidad=0;


                          //CAMPOS COSTO UNIFORMES
                          totalUniformesEntidad=0;

                          totalGastoEntidad=0;

                        }
                        var turnosCubiertos=getCoberturaPerfil(lista[i].asistencia, lista[i].cobraDescansos, lista[i].cobraDiaFestivo, lista[i].cobra31);
                        var cobroCobertura= turnosCubiertos*lista[i].CostoTurno;
                        var turnosPresupuestados=lista [i].turnosPresupuestadosPeriodo;
                        var diferenciaTurnos= parseInt(turnosPresupuestados)- parseInt(turnosCubiertos);
                        var cobroPresupuestado=lista [i].cobroPresupuestado;
                        var diferenciaCobro=(cobroPresupuestado-cobroCobertura)* -1;
                        var diferenciaTurnosEntidad=0;
                        var diferenciaCobroEntidad=0;
                        pagoNominaTotal= obtenerNominaTotalPuntoServicio(puestoCobertura,fecha1,fecha2,idPuntoServicioNom,roloperativo);




                        valoresEma= obtenerTotalesEma (puestoCobertura,fecha1,fecha2,idPuntoServicioNom,roloperativo);

                        //FUNCION PARA OBTENER EL TOTAL DE COSTO EN ASIGNACIÓN DE UNIFORMES PARA EL PUNTO DE SERVICIO
                        var costoUniformes=parseFloat(obtenerCostoUniformes(puestoCobertura,fecha1,fecha2,idPuntoServicioNom,roloperativo));


                        //FUNCION PARA OBTENER GASTO POR ENTIDAD
                        var gastoElemento=parseFloat(promedio*lista [i].numEle);

                        var diasImss=valoresEma.totalDias;
                        var pagoSua= valoresEma.totalPago;

                        //CALCULO PARA EBA
                        var valoresEva= obtenerTotalesEva (puestoCobertura,fecha1,fecha2,idPuntoServicioNom,roloperativo);
                        var diasInfo=valoresEva.totalDias;
                        var suma1= valoresEva.totalSuma1;
                        var sumaInfo= valoresEva.totalInfonavit;


                        totalTurnos=contadorTurnos;
                        var totalCoberturat=(turnosCubiertos/lista [i].turnosPresupuestadosPeriodo)*100;


                        valores=obtenerDatosmontoturnosfacturados(idPuntoServicioNom,puestoCobertura,fecha1,fecha2,roloperativo);

                        var TurnosFacturadoos=valores.TurnosFacturados;
                        var montoFacturado=valores.montoFacturado;

                        TurnosFacturadoos=parseInt(TurnosFacturadoos);
                        montoFacturado=parseFloat(montoFacturado);

                        listaTable += "<tr>";
                        listaTable += "<td>" + lista [i].numEle + "</td>";




                        listaTable += "<td>" + lista [i].LineaNegocio + "</td>";
                        listaTable += "<td>" + lista [i].Puesto + "</td>";
                        listaTable += "<td>" + lista [i].Rol + "</td>";
                        listaTable += "<td>" + lista [i].rolOperativo + "</td>";
                        //alert(lista[i].PuntoServicio);

                        listaTable += "<td>" + lista [i].PuntoServicio + "</td>";
                        listaTable += "<td>" + lista [i].region + "</td>";
                        listaTable += "<td>" + lista [i].supervisor + "</td>";
                        listaTable += "<td>" + lista [i].centroCosto + "</td>";
                        listaTable += "<td>" + lista [i].claveClienteNomina + "</td>";
                        listaTable += "<td>" + lista [i].Entidad + "</td>";
                        listaTable += "<td>" + fechaInicio+ "</td>";
                        listaTable += "<td>" + fechaTermino + "</td>";
                        listaTable += "<td>" + lista [i].CostoTurno + "</td>";
                        listaTable += "<td style='background-color:#FFFF00;'>" + lista [i].turnosPresupuestadosPeriodo + "</td>";
                        listaTable += "<td style='background-color:#05F9AB;'>" +format(lista [i].cobroPresupuestado,2)+"</td>";
                        listaTable += "<td style='background-color:#FFFF00;'>" +turnosCubiertos+"</td>";
                        listaTable += "<td style='background-color:#05F9AB;'>" +format(cobroCobertura,2)+"</td>";

                       // listaTable += "<td style='background-color:#FFFF00;'><input id='turnosfacturacion"+a+"' value='"+TurnosFacturadoos+"' type='text' readonly></input><img title='Editar fila "+(a+1)+"'  align='right' src='img/edit.png' onclick='editar("+a+");'></td>";///////vacio para acomodar los td****************************************************
                       // listaTable += "<td style='background-color:#FFFF00;'><input  id='montofacturado"+a+"' type='text' readonly value='"+montoFacturado+"' ></input><img  title='Guardar fila "+(a+1)+"' readonly id='imgsave"+a+"'   align='left' src='img/save.png' onclick='guardar("+idPuntoServicioNom+","+puestoCobertura+","+a+");'></td>";///////vacio para acomodar los td**************************************************** Oculto




                        a++;
                       ///// totalTurnos=50;   *******/////////////esta es la variable que calcula los turnos pagados

                        listaTable += "<td>" +diferenciaTurnos * -1 +"</td>";
                        listaTable += "<td style='background-color:#05F9AB;'>" +format(diferenciaCobro,2)  +"</td>";
                        listaTable += "<td style='background-color:#F7AC20;'>" +totalTurnos+"</td>";
                        listaTable += "<td style='background-color:#F7AC20;'>" +format(pagoNominaTotal,2)+"</td>";
                        listaTable += "<td>" +diasImss +"</td>";
                        listaTable += "<td>" +format(pagoSua,2)+"</td>";
                        listaTable += "<td style='background-color:#F7CCCC;'>" +diasInfo+"</td>";
                        listaTable += "<td style='background-color:#F7CCCC;'>" +format(suma1,2)+"</td>";
                        listaTable += "<td style='background-color:#F7CCCC;'>" +format(sumaInfo,2)+"</td>";
                        listaTable += "<td style='background-color:#89E0F9;'>" +format(costoUniformes,2)+"</td>";
                        listaTable += "<td style='background-color:#89E0F9;'>" +format(gastoElemento,2)+"</td>";
                        listaTable += "<td style='background-color:#FFFF00;'>" +totalCoberturat.toFixed(2)+" %</td>";
                        listaTable += "</tr>";



                        // incrementamos la sumatoria
                        totalTurnosPresupuestados += lista [i].turnosPresupuestadosPeriodo;
                        totalCobroPresuppuestado += lista [i].cobroPresupuestado;

                        totalTurnosCubiertos+=turnosCubiertos;

                        totalCobroByCobertura+=cobroCobertura;

                        totalTurnosEntidad+=totalTurnos;
                        totalTurnosCliente+=totalTurnos;
                        //alert(totalTurnos);

                        pagoNominaTotalEntidad+=pagoNominaTotal;
                        pagoNominaTotalCliente+=pagoNominaTotal;

                        //CAMPOS EMA
                        totalDiasImssEntidad+=diasImss;
                        totalPagoSuaEntidad+=pagoSua;

                        totalDiasImssCliente+=diasImss;
                        totalPagoSuaCliente+=pagoSua;

                        //CAMPOS PARA EBA
                        totalDiasEbaEntidad+=diasInfo;
                        totalSumaEbaEntidad+=suma1;
                        totalSumaInfonavitEntidad+=sumaInfo;

                        totalDiasInfoCliente+=diasInfo;
                        totalPagoEbaCliente+=suma1;
                        totalInfonavitCliente+=sumaInfo;


                        //CAMPOS FACTURACION
                        turnosFacEntidad+=TurnosFacturadoos;
                        turnosFacCliente+=TurnosFacturadoos;

                        montoFacEntidad+=montoFacturado;
                        montoFacCliente+=montoFacturado;


                        //SUMATORIA PARA COSTOS UNIFORMES
                        totalUniformesEntidad+=costoUniformes;
                        totalUniformesCliente+=costoUniformes;


                        totalGastoEntidad+=gastoElemento;
                        totalGastoCliente+=gastoElemento;

                        turnosCliente+=turnosCubiertos;
                        cobroCliente+=cobroCobertura;
                        turnosPresupuestadosCliente+=lista [i].turnosPresupuestadosPeriodo;
                        cobroPresupuestadosCliente+=cobroPresupuestado;

                        diferenciaTurnosEntidad=(totalTurnosPresupuestados-totalTurnosCubiertos)*-1;
                        diferenciaCobroEntidad=(totalCobroPresuppuestado-totalCobroByCobertura)*-1;



                    } //termina for


                    if (totalTurnosPresupuestados > 0)
                      {
                          var totalCoberturaentidad=(totalTurnosCubiertos/totalTurnosPresupuestados)*100;
                          listaTable += "<tr>";
                          listaTable += "<td colspan='14'>Total entidad:</td>";
                          listaTable += "<td style='background-color:#FFFF00;'>" +totalTurnosPresupuestados+"</td>";
                          listaTable += "<td style='background-color:#05F9AB;'>" +format(totalCobroPresuppuestado,2)+"</td>";
                          listaTable += "<td style='background-color:#FFFF00;'>" +totalTurnosCubiertos+"</td>";
                          listaTable += "<td style='background-color:#05F9AB;'>" +format(totalCobroByCobertura,2)+"</td>";
                          //listaTable += "<td style='background-color:#05F9AB;'>" +turnosFacEntidad+"</td>";
                          //listaTable += "<td style='background-color:#05F9AB;'>" +format(montoFacEntidad,2)+"</td>";

                          listaTable += "<td>" +diferenciaTurnosEntidad+"</td>";
                          listaTable += "<td style='background-color:#05F9AB;'>" +format(diferenciaCobroEntidad,2)+"</td>";
                          listaTable += "<td style='background-color:#F7AC20;'>" +totalTurnosEntidad+"</td>";
                          listaTable += "<td style='background-color:#F7AC20;'>" +format(pagoNominaTotalEntidad,2)+"</td>";
                          listaTable += "<td>" +totalDiasImssEntidad+"</td>";
                          listaTable += "<td>" +format(totalPagoSuaEntidad,2)+"</td>";
                          listaTable += "<td style='background-color:#F7CCCC;'>" +totalDiasEbaEntidad+"</td>";
                          listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalSumaEbaEntidad,2)+"</td>";
                          listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalSumaInfonavitEntidad,2)+"</td>";
                          listaTable += "<td style='background-color:#89E0F9;'>" +format(totalUniformesEntidad,2)+"</td>";
                          listaTable += "<td style='background-color:#89E0F9;'>" +format(totalGastoEntidad,2)+"</td>";
                          listaTable += "<td style='background-color:#FFFF00;'>" +totalCoberturaentidad.toFixed(2)+" %</td>";
                          listaTable += "</tr>";
                      }
                      var totalCoberturacliente=(turnosCliente/turnosPresupuestadosCliente)*100;
                      listaTable += "<tr>";
                      listaTable += "<td colspan='14'>Total cliente:</td>";
                      listaTable += "<td style='background-color:#FFFF00;'>" +turnosPresupuestadosCliente+"</td>";
                      listaTable += "<td style='background-color:#05F9AB;'>" +format(cobroPresupuestadosCliente,2)+"</td>";
                      listaTable += "<td style='background-color:#FFFF00;'>" +turnosCliente+"</td>";
                      listaTable += "<td style='background-color:#05F9AB;'>" +format(cobroCliente,2)+"</td>";
                    //  listaTable += "<td style='background-color:#FFFF00;'>" +turnosFacCliente+"</td>";
                    //  listaTable += "<td style='background-color:#05F9AB;'>" +format(montoFacCliente,2)+"</td>";

                      listaTable += "<td>" +(turnosPresupuestadosCliente-turnosCliente)*-1+"</td>";
                      listaTable += "<td style='background-color:#05F9AB;'>" +format((cobroPresupuestadosCliente-cobroCliente)*-1,2)+"</td>";
                      listaTable += "<td style='background-color:#F7AC20;'>" +totalTurnosCliente+"</td>";
                      listaTable += "<td style='background-color:#F7AC20;'>" +format(pagoNominaTotalCliente,2)+"</td>";
                      listaTable += "<td>" +totalDiasImssCliente+"</td>";
                      listaTable += "<td>" +format(totalPagoSuaCliente,2)+"</td>";
                      listaTable += "<td style='background-color:#F7CCCC;'>" +totalDiasInfoCliente+"</td>";
                      listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalPagoEbaCliente,2)+"</td>";
                      listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalInfonavitCliente,2)+"</td>";
                      listaTable += "<td style='background-color:#89E0F9;'>" +format(totalUniformesCliente,2)+"</td>";
                      listaTable += "<td style='background-color:#89E0F9;'>" +format(totalGastoCliente,2)+"</td>";
                      listaTable += "<td style='background-color:#FFFF00;'>" +totalCoberturacliente.toFixed(2)+" %</td>";
                      listaTable += "</tr>";


                  //listaTable += "</tbody></table>";

                  //$('#tableReporteGeneral').append(listaTable);


                  //return listaTable;
                  //alert("listaTable:"+listaTable);
                  result=listaTable+"_"+turnosPresupuestadosCliente+"_"+cobroPresupuestadosCliente+"_"+turnosCliente+"_"+cobroCliente+"_"+pagoNominaTotalCliente+"_"+totalTurnosCliente+"_"+totalDiasImssCliente+"_"+totalPagoSuaCliente+"_"+totalUniformesCliente+"_"+totalGastoCliente+"_"+totalDiasInfoCliente+"_"+totalPagoEbaCliente+"_"+totalInfonavitCliente+"_"+turnosFacCliente+"_"+montoFacCliente;
                  //alert(result);
                  //return result;


                 } //termina if success
            },
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
            }
           });
        //alert("hola"+result);
        //alert("result"+ result);

      return result;

     }
     function crearTablaDetalleReporte(idClientePunto){

     var fecha1=$("#txtFechaReporteDetalle1").val();
     var fecha2=$("#txtFechaReporteDetalle2").val();
   //  var selLineaNegocioRporteF=$("#selLineaNegocioRporteF").val();
     waitingDialog.show();
      $.ajax({
            type: "POST",
            url: "ajax_reporteIngresoByCliente.php",
            data : {"fecha1":fecha1, "fecha2":fecha2, idClientePunto:idClientePunto},//,"selLineaNegocioRporteF":selLineaNegocioRporteF
            dataType: "json",
            success: function(response) {
              console.log(response);
                if (response.status == "success")
                {
                    var lista = response.lista;
                    var result = "";
                    var nombreEntidadFederativaE="";
                    //ENCABEZADO DE FECHA
                    moment.locale('Es');
                    var dateTime = moment(fecha1);
                    var fullTime = dateTime.format('LL');
                    var dateTime2 = moment(fecha2);
                    var fullTime2 = dateTime2.format('LL');

                    var turnosCliente=0;
                    var cobroCliente=0;
                    var turnosPresupuestadosCliente=0;
                    var cobroPresupuestadosCliente=0;

                    listaTable="";
                    var totalTurnosPresupuestados = 0;
                    var totalCobroPresuppuestado=0;
                    var totalTurnosCubiertos=0;
                    var totalCobroByCobertura=0;

                    var pagoNominaTotal=0;
                    var pagoNominaTotalEntidad=0;
                    var pagoNominaTotalCliente=0;
                    //NUEVOS CAMPOS DE SUA (EMA)
                    var totalDiasImssEntidad=0;
                    var totalPagoSuaEntidad=0

                    //CAMPOS PARA LA EBA
                    var totalDiasEbaEntidad=0;
                    var totalSumaEbaEntidad=0
                    var totalSumaInfonavitEntidad=0

                    var totalDiasInfoCliente=0;
                    var totalPagoEbaCliente=0;
                    var totalInfonavitCliente=0;



                    var totalDiasImssCliente=0;
                    var totalPagoSuaCliente=0;

                    //VARIABLES DE COSTO UNIFORMES

                    var totalUniformesEntidad=0;
                    var totalUniformesCliente=0;


                    //VARIABLES FACTURACION
                    var turnosFacEntidad=0;
                    var turnosFacCliente=0;
                    var montoFacEntidad=0;
                    var montoFacCliente=0;


                    //contadora de elementos
                    var totalGastoEntidad=0;
                    var totalGastoCliente=0;

                    var totalTurnos=0;
                    var totalTurnosEntidad=0;
                    var totalTurnosCliente=0;
                    var promedio=0.0;
                    var a=0;
                    listaTable+= "<tr><td style='background-color:#5ECFF3; text-align:center ;font-size:x-large; font-weight: bold;display:none;' colspan='32'> PERIODO: "+fullTime+" AL "+fullTime2+"</td></tr>";
                    for (var i in lista)
                    {

                      var nombreEntidadFederativa= lista[i].Entidad;
                      var idEstado=lista[i].idEstado;
                      var fechaInicio=lista[i].fechaInicio;
                      var fechaTermino=lista[i].fechaTermino;
                      var idPuntoServicioNom=lista[i].idPuntoServicio;
                      var puestoCobertura=lista[i].idPuesto;
                        var roloperativo =lista[i].rolOperativo;

                      if(nombreEntidadFederativaE!=nombreEntidadFederativa){

                          promedio=parseFloat(calculoSumaGastoEntidad(idEstado,fecha1,fecha2));

                          if (totalTurnosPresupuestados > 0)
                          {







                              var porcentajeTurnosT=(totalTurnosCubiertos/totalTurnosPresupuestados)*100;
                              listaTable += "<tr>";
                              listaTable += "<td colspan='14'>Total:</td>";
                              listaTable += "<td style='background-color:#FFFF00;'>" +totalTurnosPresupuestados+"</td>";
                              listaTable += "<td style='background-color:#05F9AB;'>" +format(totalCobroPresuppuestado,2)+"</td>";
                              listaTable += "<td style='background-color:#FFFF00;'>" +totalTurnosCubiertos+"</td>";
                              listaTable += "<td style='background-color:#05F9AB;'>" +format(totalCobroByCobertura,2)+"</td>";
                              //listaTable += "<td style='background-color:#FFFF00;'>" +turnosFacEntidad+"</td>";
                              //listaTable += "<td style='background-color:#FFFF00;'>" +format(montoFacEntidad,2)+"</td>";
                              listaTable += "<td>" +diferenciaTurnosEntidad+"</td>";
                              listaTable += "<td style='background-color:#05F9AB;'>" +format(diferenciaCobroEntidad,2)+"</td>";
                              listaTable += "<td style='background-color:#F7AC20;'>" +totalTurnosEntidad+"</td>";
                              listaTable += "<td style='background-color:#F7AC20;'>" +format(pagoNominaTotalEntidad,2)+"</td>";
                              listaTable += "<td>" +totalDiasImssEntidad+"</td>";
                              listaTable += "<td>" +format(totalPagoSuaEntidad,2)+"</td>";
                              listaTable += "<td style='background-color:#F7CCCC;'>" +totalDiasEbaEntidad+"</td>";
                              listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalSumaEbaEntidad,2)+"</td>";
                              listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalSumaInfonavitEntidad,2)+"</td>";
                              listaTable += "<td style='background-color:#89E0F9;'>" +format(totalUniformesEntidad,2)+"</td>";
                              listaTable += "<td style='background-color:#89E0F9;'>" +format(totalGastoEntidad,2)+"</td>";
                              listaTable += "<td style='background-color:#FFFF00;'>" +porcentajeTurnosT.toFixed(2)+" %</td>";
                              listaTable += "</tr>";
                          }

                          listaTable+= "<tr><td style='background-color:#BDBDBD; text-align:center ; font-weight: bold;' colspan='32'>"+nombreEntidadFederativa+" </td></tr>";
                          listaTable+="<tr style='text-align:center ; font-weight: bold;'><td>#Elementos</td><td>Linea Negocio</td><td>Puesto</td><td>Rol</td><td>Rol Operativo</td><td>Punto Servicio</td><td>Region</td><td>Supervisor a Cargo</td><td>#Centro de Costo</td><td>Cuenta contable</td>";
                          listaTable+="<td>Entidad</td><td>Fecha inicio</td><<td>Fecha fin</td><td>Costo Turno</td>";
                          listaTable+="<td style='background-color:#FFFF00;'>Turnos presupuestados</td> <td style='background-color:#05F9AB;'>Cobro Presupuestado</td><td style='background-color:#FFFF00;'>Turnos Cubiertos Perfil</td><td style='background-color:#05F9AB;'>Cobro Cobertura</td><td>Diferencia Turnos</td><td style='background-color:#05F9AB;'>Diferencia $</td><td style='background-color:#F7AC20;'>Turnos Pagados</td><td style='background-color:#F7AC20;'>$ Pago Nomina</td><td>Dias Imss</td><td>Pago Sua</td><td style='background-color:#F7CCCC;'>Dias EBA</td><td style='background-color:#F7CCCC;'>Suma EBA</td><td style='background-color:#F7CCCC;'>Suma Infonavit</td><td style='background-color:#89E0F9;'>Costo Uniformes</td><td style='background-color:#89E0F9;'>Gasto</td><td style='background-color:#FFFF00;'>Cobertura %</td></tr>"; // <td style='background-color:#FFFF00;'>Cobertura %</td> agregar cuando este bien
                          //<td style='background-color:#FFFF00;' title='Recuerda que tu consulta debe ser mensual, Así mismo los datos ingresados deben ser mensuales. De lo contrario tu reporte se verá afectado.'>Turnos facturados</td><td style='background-color:#FFFF00;' title='Recuerda que tu consulta debe ser mensual, Así mismo los datos ingresados deben ser mensuales. De lo contrario tu reporte se verá afectado.'>Monto facturado</td>  desabilitado por peticion


    nombreEntidadFederativaE=nombreEntidadFederativa;

                           // Reiniciamos la variable de la sumatoria
                           totalTurnosPresupuestados = 0;
                           totalCobroPresuppuestado=0;
                           totalTurnosCubiertos=0;
                           totalCobroByCobertura=0;
                           pagoNominaTotalEntidad=0;
                           totalTurnosEntidad=0;

                           //CAMPOS SUA
                          totalDiasImssEntidad=0;
                          totalPagoSuaEntidad=0


                          //CAMPOS EBA
                          totalDiasEbaEntidad=0;
                          totalSumaEbaEntidad=0;
                          totalSumaInfonavitEntidad=0;

                          //CAMPOS FACTURACION
                          turnosFacEntidad=0;
                          montoFacEntidad=0;

                          //CAMPOS COSTO UNIFORMES
                          totalUniformesEntidad=0;

                          totalGastoEntidad=0;
                        }

                        var turnosCubiertos=getCoberturaPerfil(lista[i].asistencia, lista[i].cobraDescansos, lista[i].cobraDiaFestivo, lista[i].cobra31);
                        var cobroCobertura= turnosCubiertos*lista[i].CostoTurno;
                        var turnosPresupuestados=lista [i].turnosPresupuestadosPeriodo;
                        var diferenciaTurnos= parseInt(turnosPresupuestados)- parseInt(turnosCubiertos);
                        var cobroPresupuestado=lista [i].cobroPresupuestado;
                        var diferenciaCobro=(cobroPresupuestado-cobroCobertura)* -1;
                        var diferenciaTurnosEntidad=0;
                        var diferenciaCobroEntidad=0;
                        pagoNominaTotal= obtenerNominaTotalPuntoServicio(puestoCobertura,fecha1,fecha2,idPuntoServicioNom,roloperativo);

                        //FUNCION QUE TRAE LOS COSTOS DE SUA POR PUNTO DE SERVICIO
                        valoresEma= obtenerTotalesEma (puestoCobertura,fecha1,fecha2,idPuntoServicioNom,roloperativo);

                        //FUNCION PARA OBTENER EL TOTAL DE COSTO EN ASIGNACIÓN DE UNIFORMES PARA EL PUNTO DE SERVICIO
                        var costoUniformes=parseFloat(obtenerCostoUniformes(puestoCobertura,fecha1,fecha2,idPuntoServicioNom,roloperativo));


                        //FUNCION PARA OBTENER GASTO POR ENTIDAD
                        var gastoElemento=parseFloat(promedio*lista [i].numEle);

                        var diasImss=valoresEma.totalDias;
                        var pagoSua= valoresEma.totalPago;


                        //OBTENCION DE DATOS PARA EBA
                        var valoresEva= obtenerTotalesEva (puestoCobertura,fecha1,fecha2,idPuntoServicioNom,roloperativo);
                        var diasInfo=valoresEva.totalDias;
                        var suma1= valoresEva.totalSuma1;
                        var sumaInfo= valoresEva.totalInfonavit;


                        //alert("diasTotal:"+valoresEma.totalDias);


                        totalTurnos=contadorTurnos;
                        contadorTurnos=0;
                       // alert("Punto Servicio: "+idPuntoServicioNom+" turnos: "+totalTurnos);
                        var porcentajeTurnos=(turnosCubiertos / (lista [i].turnosPresupuestadosPeriodo))*100;



                        valores=obtenerDatosmontoturnosfacturados(idPuntoServicioNom,puestoCobertura,fecha1,fecha2,roloperativo);

                        var TurnosFacturadoos=valores.TurnosFacturados;
                        var montoFacturado=valores.montoFacturado;

                        TurnosFacturadoos=parseInt(TurnosFacturadoos);
                        montoFacturado=parseFloat(montoFacturado);
                        //console.log(montoFacturado);




                        listaTable += "<tr>";
                        listaTable += "<td>" + lista [i].numEle + "</td>";
                        listaTable += "<td>" + lista [i].LineaNegocio +"</td>";
                        listaTable += "<td>" + lista [i].Puesto +"</td>";
                        listaTable += "<td>" + lista [i].Rol + "</td>";
                        listaTable += "<td>" + lista [i].rolOperativo + "</td>";
                        listaTable += "<td>" + lista [i].PuntoServicio + "</td>";
                        listaTable += "<td>" + lista [i].region + "</td>";
                        listaTable += "<td>" + lista [i].supervisor + "</td>";
                        listaTable += "<td>" + lista [i].centroCosto + "</td>";
                        listaTable += "<td>" + lista [i].claveClienteNomina + "</td>";
                        listaTable += "<td>" + lista [i].Entidad + "</td>";

                        listaTable += "<td>" + fechaInicio + "</td>";
                        listaTable += "<td>" + fechaTermino + "</td>";
                        listaTable += "<td>" + lista [i].CostoTurno + "</td>";

                        listaTable += "<td style='background-color:#FFFF00;'>" + lista [i].turnosPresupuestadosPeriodo + "</td>";

                        //new Intl.NumberFormat().format(lista [i].cobroPresupuestado)
                        listaTable += "<td style='background-color:#05F9AB;'>" +format(lista [i].cobroPresupuestado,2)+"</td>";

                        listaTable += "<td style='background-color:#FFFF00;'>" +turnosCubiertos+"</td>";
                        listaTable += "<td style='background-color:#05F9AB;'>" +format(cobroCobertura,2)+"</td>";
                        ///////////////////////////******************************************************************************///////////////////////////
                      //  listaTable += "<td style='background-color:#FFFF00;'><input id='turnosfacturacion"+a+"' value='"+TurnosFacturadoos+"' type='text' readonly></input><img title='Editar fila "+(a+1)+"'  align='right' src='img/edit.png' onclick='editar("+a+");'></td>";///////vacio para acomodar los td****************************************************
                      //  listaTable += "<td style='background-color:#FFFF00;'><input  id='montofacturado"+a+"' type='text' readonly value='"+montoFacturado+"' ></input><img  title='Guardar fila "+(a+1)+"' readonly id='imgsave"+a+"'   align='left' src='img/save.png' onclick='guardar("+idPuntoServicioNom+","+puestoCobertura+","+a+");'></td>";///////vacio para acomodar los td****************************************************




                        a++;





                        listaTable += "<td>" +diferenciaTurnos * -1 +"</td>";
                        listaTable += "<td style='background-color:#05F9AB;'>" +format(diferenciaCobro,2)  +"</td>";
                        listaTable += "<td style='background-color:#F7AC20;'>" +totalTurnos+"</td>";

                        listaTable += "<td style='background-color:#F7AC20;'>" +format(pagoNominaTotal,2) +"</td>";
                        listaTable += "<td>" +diasImss +"</td>";
                        listaTable += "<td>" +format(pagoSua,2)+"</td>";
                        listaTable += "<td style='background-color:#F7CCCC;'>" +diasInfo+"</td>";
                        listaTable += "<td style='background-color:#F7CCCC;'>" +format(suma1,2)+"</td>";
                        listaTable += "<td style='background-color:#F7CCCC;'>" +format(sumaInfo,2)+"</td>";
                        listaTable += "<td style='background-color:#89E0F9;'>" +format(costoUniformes,2)+"</td>";
                        listaTable += "<td style='background-color:#89E0F9;'>" +format(gastoElemento,2)+"</td>";
                        listaTable += "<td style='background-color:#FFFF00;'>" + porcentajeTurnos.toFixed(2) +" % </td>";
                        //alert(listaTable);

                        // incrementamos la sumatoria
                        totalTurnosPresupuestados += lista [i].turnosPresupuestadosPeriodo;
                        totalCobroPresuppuestado += lista [i].cobroPresupuestado;

                        totalTurnosCubiertos+=turnosCubiertos;

                        totalCobroByCobertura+=cobroCobertura;

                        totalTurnosEntidad+=totalTurnos;
                        totalTurnosCliente+=totalTurnos;

                        pagoNominaTotalEntidad+=pagoNominaTotal;
                        pagoNominaTotalCliente+=pagoNominaTotal;


                        //campos para ema
                        totalDiasImssEntidad+=diasImss;
                        totalPagoSuaEntidad+=pagoSua;

                        totalDiasImssCliente+=diasImss;
                        totalPagoSuaCliente+=pagoSua;

                        //CAMPOS EBA
                        totalDiasEbaEntidad+=diasInfo;
                        totalSumaEbaEntidad+=suma1;
                        totalSumaInfonavitEntidad+=sumaInfo;




                        totalDiasInfoCliente+=diasInfo;
                        totalPagoEbaCliente+=suma1;
                        totalInfonavitCliente+=sumaInfo;

                        //CAMPOS FACTURACION
                        turnosFacEntidad+=TurnosFacturadoos;
                        turnosFacCliente+=TurnosFacturadoos;

                        montoFacEntidad+=montoFacturado;
                        montoFacCliente+=montoFacturado;


                        //SUMATORIA PARA COSTOS UNIFORMES
                        totalUniformesEntidad+=costoUniformes;
                        totalUniformesCliente+=costoUniformes;

                        //alert(totalUniformesEntidad);

                        //SUMATORIA TOTAL CLIENTE GASTO
                        totalGastoEntidad+=gastoElemento;
                        totalGastoCliente+=gastoElemento;

                        turnosCliente+=turnosCubiertos;
                        cobroCliente+=cobroCobertura;
                        turnosPresupuestadosCliente+=lista [i].turnosPresupuestadosPeriodo;
                        cobroPresupuestadosCliente+=cobroPresupuestado;

                        diferenciaTurnosEntidad=(totalTurnosPresupuestados-totalTurnosCubiertos)*-1;
                        diferenciaCobroEntidad=(totalCobroPresuppuestado-totalCobroByCobertura)*-1;


                        listaTable += "</tr>";
                    }


                    if (totalTurnosPresupuestados > 0)
                      {
                          var porcentajeTurnosTotal1=(totalTurnosCubiertos/totalTurnosPresupuestados)*100;
                          listaTable += "<tr>";
                          listaTable += "<td colspan='14'>Total:</td>";
                          listaTable += "<td style='background-color:#FFFF00;'>" +totalTurnosPresupuestados+"</td>";
                          listaTable += "<td style='background-color:#05F9AB;'>" +format(totalCobroPresuppuestado,2)+"</td>";
                          listaTable += "<td style='background-color:#FFFF00;'>" +totalTurnosCubiertos+"</td>";
                          listaTable += "<td style='background-color:#05F9AB;'>" +format(totalCobroByCobertura,2)+"</td>";
                          //listaTable += "<td style='background-color:#FFFF00;'>" +turnosFacEntidad+"</td>";
                          //listaTable += "<td style='background-color:#FFFF00;'>" +format(montoFacEntidad,2)+"</td>";

                          listaTable += "<td>" +diferenciaTurnosEntidad+"</td>";
                          listaTable += "<td style='background-color:#05F9AB;'>" +format(diferenciaCobroEntidad,2)+"</td>";
                          listaTable += "<td style='background-color:#F7AC20;'>" +totalTurnosEntidad+"</td>";
                          listaTable += "<td style='background-color:#F7AC20;'>" +format(pagoNominaTotalEntidad,2)+"</td>";
                          listaTable += "<td>" +totalDiasImssEntidad+"</td>";
                          listaTable += "<td>" +format(totalPagoSuaEntidad,2)+"</td>";
                          listaTable += "<td style='background-color:#F7CCCC;'>" +totalDiasEbaEntidad+"</td>";
                          listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalSumaEbaEntidad,2)+"</td>";
                          listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalSumaInfonavitEntidad,2)+"</td>";
                          listaTable += "<td style='background-color:#89E0F9;'>" +format(totalUniformesEntidad,2)+"</td>";
                          listaTable += "<td style='background-color:#89E0F9;'>" +format(totalGastoEntidad,2)+"</td>";
                          listaTable += "<td style='background-color:#FFFF00;'>" +porcentajeTurnosTotal1.toFixed(2)+" %</td>";
                          listaTable += "</tr>";
                      }
                      var porcentajeTurnosTotal2=(turnosCliente/turnosPresupuestadosCliente)*100;
                      listaTable += "<tr>";
                      listaTable += "<td colspan='14'>Total:</td>";
                      listaTable += "<td style='background-color:#FFFF00;'>" +turnosPresupuestadosCliente+"</td>";
                      listaTable += "<td style='background-color:#05F9AB;'>" +format(cobroPresupuestadosCliente,2)+"</td>";
                      listaTable += "<td style='background-color:#FFFF00;'>" +turnosCliente+"</td>";
                      listaTable += "<td style='background-color:#05F9AB;'>" +format(cobroCliente,2)+"</td>";
                      //listaTable += "<td style='background-color:#FFFF00;'>" +turnosFacCliente+"</td>";
                      //listaTable += "<td style='background-color:#FFFF00;'>" +format(montoFacCliente,2)+"</td>";

                      listaTable += "<td>" +(turnosPresupuestadosCliente-turnosCliente)*-1+"</td>";
                      listaTable += "<td style='background-color:#05F9AB;'>" +format((cobroPresupuestadosCliente-cobroCliente)*-1,2)+"</td>";
                      listaTable += "<td style='background-color:#F7AC20;'>" +totalTurnosCliente+"</td>";
                      listaTable += "<td style='background-color:#F7AC20;'>" +format(pagoNominaTotalCliente,2)+"</td>";
                      listaTable += "<td>" +totalDiasImssCliente+"</td>";
                      listaTable += "<td>" +format(totalPagoSuaCliente,2)+"</td>";
                      listaTable += "<td style='background-color:#F7CCCC;'>" +totalDiasInfoCliente+"</td>";
                      listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalPagoEbaCliente,2)+"</td>";
                      listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalInfonavitCliente,2)+"</td>";
                      listaTable += "<td style='background-color:#89E0F9;'>" +format(totalUniformesCliente,2)+"</td>";
                      listaTable += "<td style='background-color:#89E0F9;'>" +format(totalGastoCliente,2)+"</td>";
                      listaTable += "<td style='background-color:#FFFF00;'>" +porcentajeTurnosTotal2.toFixed(2)+" %</td>";
                      listaTable += "</tr>";


                  //listaTable += "</tbody></table>";

                  $('#tableReporteGeneral').html(listaTable);

                  waitingDialog.hide();
                 }//termina if success
            },

            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
            }
           });


     }


     function consultaClientes(){

      $("#tableReporteGeneral").find("tr:gt(0)").remove();
      waitingDialog.show();

        $.ajax({

            type: "POST",
            url: "ajax_obtenerListaClientes.php",

            dataType: "json",
             success: function(response) {
              //console.log(response);
                if (response.status == "success")
                {

                    var listaClientes = response.listaClientes;

                    var listaTableClientes="";
                    var granTotalTurnosPresupuestados=0;
                    var granTotalcobroPresupuestadosCliente=0;
                    var granTotalturnosCliente=0;
                    var granTotalcobroCliente=0;

                    var granTotalNominaCliente=0;


                    var granTotalTurnosCliente=0;

                    //CAMPOS EMA
                    var granTotalDiasImssCliente=0;
                    var granTotalPagoSuaCliente=0;

                    //CAMPOS EBA
                    var granTotalDiasInfoCliente=0;
                    var granTotalSumaInfoCliente=0;
                    var granTotalInfonavitCliente=0;


                    //CAMPOS FACTURACION
                    var granTotalTurnosFacCliente=0;
                    var granTotalMontoFacCliente=0;



                    //CAMPOS COSTOS UNIFORMES

                    var granTotalUniformesCliente=0;

                    //CAMPO GASTO
                    var granTotalGastoCliente=0;

                    for ( var i = 0; i < listaClientes.length; i++ ){

                      var idClientePunto = listaClientes[i].idCliente;
                      var razonSocial = listaClientes[i].razonSocial;

                      listaTableClientes+= "<tr><td style='background-color:#BDBDBD; text-align:center ; font-weight: bold;' colspan='32'>"+idClientePunto+"-"+razonSocial+" </td></tr>";
                      if(idClientePunto!=13){
                        //crearTablaDetalleReporte1(idClientePunto);
                        //alert(resultado);
                        var resultado=crearTablaDetalleReporte1(idClientePunto);
                        consulta=1;
                        //alert("resultado de result:"+resultado);
                        var elementosResultado= resultado.split ("_");
                        var table=elementosResultado[0];
                        var turnosPresupuestados=elementosResultado[1];
                        var cobroPresupuestadosCliente=elementosResultado[2];
                        var turnosCliente=elementosResultado[3];
                        var cobroCliente=elementosResultado[4];
                        var nominaCliente=elementosResultado[5];
                        var turnosPagadosCliente=elementosResultado[6];
                        var diasImssTotal=elementosResultado[7];
                        var pagoSuaTotal=elementosResultado[8];
                        var costoUniformes=elementosResultado[9];
                        var gastoElemento=elementosResultado[10];
                        var diasInfo=elementosResultado[11];
                        var sumaInfo=elementosResultado[12];
                        var infonavit=elementosResultado[13];
                        var turnosFac=elementosResultado[14];
                        var montoFac=elementosResultado[15];
                        //alert(table);



                        granTotalTurnosPresupuestados=parseInt(granTotalTurnosPresupuestados)+parseInt(turnosPresupuestados);
                        granTotalcobroPresupuestadosCliente=parseInt(granTotalcobroPresupuestadosCliente)+parseInt(cobroPresupuestadosCliente);
                        granTotalturnosCliente=parseInt(granTotalturnosCliente)+parseInt(turnosCliente);
                        granTotalcobroCliente=parseInt(granTotalcobroCliente)+parseInt(cobroCliente);
                        granTotalNominaCliente=parseInt(granTotalNominaCliente)+parseInt(nominaCliente);
                        granTotalTurnosCliente=parseInt(granTotalTurnosCliente)+parseInt(turnosPagadosCliente);


                        //CAMPOS EBA
                        granTotalDiasInfoCliente=parseInt(granTotalDiasInfoCliente)+parseInt(diasInfo);
                        granTotalSumaInfoCliente=parseInt(granTotalSumaInfoCliente)+parseInt(sumaInfo);
                        granTotalInfonavitCliente=parseInt(granTotalInfonavitCliente)+parseInt(infonavit);

                        granTotalDiasImssCliente=parseInt(granTotalDiasImssCliente)+parseInt(diasImssTotal);
                        granTotalPagoSuaCliente=parseInt(granTotalPagoSuaCliente)+parseInt(pagoSuaTotal);

                        //CAMPOS FACTURACION
                        granTotalTurnosFacCliente=parseInt(granTotalTurnosFacCliente)+parseInt(turnosFac);
                        granTotalMontoFacCliente=parseFloat(granTotalMontoFacCliente)+parseFloat(montoFac);



                        granTotalUniformesCliente=parseInt(granTotalUniformesCliente)+parseInt(costoUniformes);

                        granTotalGastoCliente=parseInt(granTotalGastoCliente)+parseInt(gastoElemento);
                        //alert(turnosPresupuestados);
                        listaTableClientes +=table;


                      }//se cierraif de diferente cliente 13
                    }// se cierra el for de largo cliente
                      var coberturaTotalTurnos=(granTotalturnosCliente/granTotalTurnosPresupuestados)*100;
                      listaTableClientes += "<tr style='background-color:#F78181'>";
                      listaTableClientes += "<td colspan='14'> Gran Total:</td>";
                      listaTableClientes += "<td id='turnosTotalesPresupuestados' name='turnosTotalesPresupuestados' style='background-color:#FFFF00;'>"+granTotalTurnosPresupuestados+"</td>";
                      listaTableClientes += "<td style='background-color:#05F9AB;'>"+format(granTotalcobroPresupuestadosCliente,2)+"</td>";
                      listaTableClientes += "<td style='background-color:#FFFF00;'>"+granTotalturnosCliente+"</td>";
                      listaTableClientes += "<td style='background-color:#05F9AB;'>"+format(granTotalcobroCliente,2)+"</td>";
                      //listaTableClientes += "<td style='background-color:#FFFF00;'>"+granTotalTurnosFacCliente+"</td>";
                      //listaTableClientes += "<td style='background-color:#05F9AB;'>"+format(granTotalMontoFacCliente,2)+"</td>";

                      listaTableClientes += "<td>"+parseInt(granTotalTurnosPresupuestados-granTotalturnosCliente)*-1+"</td>";

                      listaTableClientes += "<td style='background-color:#05F9AB;'>"+format((granTotalcobroPresupuestadosCliente-granTotalcobroCliente)*-1,2)+"</td>";
                      listaTableClientes += "<td style='background-color:#F7AC20;'>"+granTotalTurnosCliente+"</td>";
                      listaTableClientes += "<td style='background-color:#F7AC20;'>"+format(granTotalNominaCliente,2)+"</td>";
                      listaTableClientes += "<td>"+granTotalDiasImssCliente+"</td>";
                      listaTableClientes += "<td>"+format(granTotalPagoSuaCliente,2)+"</td>";
                      listaTableClientes += "<td style='background-color:#F7CCCC;'>"+granTotalDiasInfoCliente+"</td>";
                      listaTableClientes += "<td style='background-color:#F7CCCC;'>"+format(granTotalSumaInfoCliente,2)+"</td>";
                      listaTableClientes += "<td style='background-color:#F7CCCC;'>"+format(granTotalInfonavitCliente,2)+"</td>";
                      listaTableClientes += "<td style='background-color:#89E0F9;'>"+format(granTotalUniformesCliente,2)+"</td>";
                      listaTableClientes += "<td style='background-color:#89E0F9;'>"+format(granTotalGastoCliente,2)+"</td>";
                      listaTableClientes += "<td style='background-color:#FFFF00;'>"+coberturaTotalTurnos.toFixed(2)+" %</td>";
                      listaTableClientes += "</tr>";

                    //alert(listaTableClientes);
                    $('#tableReporteGeneral').html(listaTableClientes);
                    waitingDialog.hide();



                }
                else if (response.status == "error" && response.message == "No autorizado")
                {
                    //window.location = "login.php";
                }
            },
           error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
            }
        });

     }


     function getCoberturaPerfil(asistencia, cobraDescansos,cobraDiaFestivo,cobra31){

      //alert(asistencia);

      var turnos=0;
      //alert(cobraDescansos);


      for(var i=0; i < asistencia.length; i++){
        var valorCobertura=asistencia[i].valorCobertura;
        var nomenclaturaIncidencia=asistencia[i].nomenclaturaIncidencia;
        var fechaAsistencia=asistencia[i].fechaAsistencia;

        //alert(valorCobertura);
        if (cobraDescansos==1){
          if(nomenclaturaIncidencia=="DES"){
            valorCobertura=1;

          }
        }

        if(cobraDiaFestivo==0){
          if(nomenclaturaIncidencia=="DF"){
            valorCobertura=0;

          }

        }

        if(cobra31==0){
          var dia=fechaAsistencia.substring(8);

          if(dia==31){
            valorCobertura=0;
          }
        }



        turnos=parseInt(turnos)+parseInt(valorCobertura);
      }

      return turnos;

     }


     function obtenerNominaTotalPuntoServicio(puesto,fecha1,fecha2,idPuntoServicioNom,roloperativo){

      var totalPagoNomina=0;

        $.ajax({
            async: false,
            type: "POST",
            url: "ajax_obtenerEmpleadorNominaPuntoServicio.php",
            data : {"fecha1":fecha1, "fecha2":fecha2, "puntoServicioId":idPuntoServicioNom, "puestoCubierto":puesto,"roloperativo":roloperativo},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {

                    var empleadoEncontrado = response.listaEmpleados;
                    var faltas=0;
                    var incapacidades=0;
                    var permisos=0;
                    var dt=0;

                    var vpagadas=0;
                    var vdisfrutadas=0;
                    var baja=0;
                    var tQuicena=0;
                    var sueldoBrutoE=0;
                    var montoVacacionesPagadas=0;
                    var contTurnos=0;
                    for ( var i = 0; i < empleadoEncontrado.length; i++ ){
                      var numeroEmpleado=empleadoEncontrado[i].empleadoEntidad+"-"+empleadoEncontrado[i].empleadoConsecutivo+"-"+empleadoEncontrado[i].empleadoTipo;
                      var listaAsistencia = empleadoEncontrado[i].asistencia;
                      var sumaTurnosExtras=empleadoEncontrado[i].turnosExtras.sumaTurnosExtras;
                      var descuentos=empleadoEncontrado[i].descuentos.descuentos;
                      var incidenciasEspeciales=empleadoEncontrado[i].incidenciasEspeciales.incidenciasEspeciales;
                      var sumaDiasFestivos=empleadoEncontrado[i].diasFestivos.diasFestivos;
                      var cuotaDiariaEmpleado=parseFloat(empleadoEncontrado[i].cuotaDiariaEmpleado).toFixed(2);
                      var bonoAsistenciaEmpleado=parseFloat(empleadoEncontrado[i].bonoAsistenciaEmpleado).toFixed(2);
                      var bonoPuntualidadEmpleado=parseFloat(empleadoEncontrado[i].bonoPuntualidadEmpleado).toFixed(2);
                      var bonoAplicado=parseInt(bonoAsistenciaEmpleado)+parseInt(bonoPuntualidadEmpleado);
                      if(incidenciasEspeciales==null){
                        incidenciasEspeciales=0;
                      }

                      if(descuentos==null){
                        descuentos=0;
                      }

                      if(sumaTurnosExtras==null){
                        sumaTurnosExtras=0;
                      }
                      for(var j=0; j<listaAsistencia.length; j++){

                          var asistenciaText = listaAsistencia [j]["nomenclaturaIncidencia"];
                          var valorAsistencia=listaAsistencia [j]["valorAsistencia"];
                          if(valorAsistencia== null)
                          {
                            valorAsistencia=0;
                          }

                          //alert(numeroEmpleado+" "+valorAsistencia+" "+listaAsistencia.length);

                          tQuicena+=parseInt(valorAsistencia);
                           if(asistenciaText=="F"){
                            faltas=faltas+1;

                          }
                          if(asistenciaText=="PER"){
                            permisos=permisos+1;
                          }
                          if(asistenciaText=="INC"){
                            incapacidades=incapacidades+1;
                          }
                          if(asistenciaText=="B"){
                            baja=baja+1;
                          }
                          if(asistenciaText=="V/P" || asistenciaText=="V/P2"){
                            vpagadas+=parseInt(valorAsistencia);
                          }
                          if(asistenciaText=="V/D" || asistenciaText=="V/D2"){
                            vdisfrutadas+=parseInt(valorAsistencia);
                          }



                      }

                    if(faltas>=1 || baja>=1){
                      bonoAplicado=0;
                    }
                    if(incapacidades>=3){
                      bonoAplicado=0;
                    }
                    if(permisos>=3){
                      bonoAplicado=0;
                    }
                    if(incidenciasEspeciales>=1){
                      bonoAplicado=0
                    }

                    if((incapacidades+permisos)>=3){
                      bonoAplicado=0;
                    }
                    if(tQuicena<=6){
                      bonoAplicado=0;
                    }

                    if(vpagadas>0){
                      montoVacacionesPagadas=parseInt(vpagadas)*parseFloat(cuotaDiariaEmpleado);

                    }


                    var diasVacaciones=parseInt(vpagadas)+parseInt(vdisfrutadas);
                    var primaVacacional=(diasVacaciones*cuotaDiariaEmpleado)*0.25;
                    var turnosTotales= parseInt(tQuicena) + parseInt(sumaTurnosExtras) - Math.abs(descuentos) + parseInt(sumaDiasFestivos);
                    //alert(numeroEmpleado+" "+sumaDiasFestivos);
                    contTurnos+=turnosTotales;
                   // if(idPuntoServicioNom==1371)
                     //   alert(numeroEmpleado+" "+turnosTotales+" "+contTurnos);
                    var sueldo=turnosTotales*cuotaDiariaEmpleado;
                    sueldoBrutoE+=(parseFloat(sueldo)+parseFloat(bonoAplicado)+parseFloat(montoVacacionesPagadas)+parseFloat(primaVacacional));
                    tQuicena=0;
                    faltas=0;
                    permisos=0;
                    incapacidades=0;
                    baja=0;
                    vpagadas=0;
                    vdisfrutadas=0;
                  }
                  contadorTurnos=contTurnos;
                  var sueldoTotales=sueldoBrutoE;
                  totalPagoNomina=  sueldoTotales;

                }//termina if success
            },

           error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
            }
           });
          return    totalPagoNomina;

     }

     function format(amount, decimals) {
        var ban=0;

        if(amount<0)
          ban=1;


        amount += ''; // por si pasan un numero en vez de un string
        amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

        decimals = decimals || 0; // por si la variable no fue fue pasada

        // si no es un numero o es igual a cero retorno el mismo cero
        if (isNaN(amount) || amount === 0)
            return parseFloat(0).toFixed(decimals);

        // si es mayor o menor que cero retorno el valor formateado como numero
        amount = '' + amount.toFixed(decimals);

        var amount_parts = amount.split('.'),
            regexp = /(\d+)(\d{3})/;

        while (regexp.test(amount_parts[0]))
            amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

        if(ban==0)
            return "$"+amount_parts.join('.');
        else
            return "-$"+amount_parts.join('.');
    }



    function obtenerTotalesEma (puesto,fecha1,fecha2,puntoServicio,roloperativo){

      var emaArray= new Array();

        $.ajax({
            async: false,
            type: "POST",
            url: "ajax_calculoEmaPuntoServicio.php",
            data : {"fecha1":fecha1, "fecha2":fecha2, "puntoServicio":puntoServicio, "puesto":puesto, "roloperativo":roloperativo},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {

                    var valores = response.valoresEma;
                    emaArray=valores;

                }//termina if success
            },

           error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
            }
           });

           return emaArray;
    }

    function obtenerTotalesEva (puesto,fecha1,fecha2,puntoServicio,roloperativo){

      var infoArray= new Array();

        $.ajax({
            async: false,
            type: "POST",
            url: "ajax_calculoEvaPuntoServicio.php",
            data : {"fecha1":fecha1, "fecha2":fecha2, "puntoServicio":puntoServicio, "puesto":puesto,"roloperativo":roloperativo},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {

                    var valores = response.valoresInfo;
                    infoArray=valores;

                }//termina if success
            },

           error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
            }
           });

           return infoArray;
    }

    function obtenerCostoUniformes (puesto,fecha1,fecha2,puntoServicio,roloperativo){

      var totalCosto= 0;

        $.ajax({
            async: false,
            type: "POST",
            url: "ajax_calcularCostoUniformes.php",
            data : {"fecha1":fecha1, "fecha2":fecha2, "puntoServicio":puntoServicio, "puesto":puesto, "roloperativo":roloperativo},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {

                    var costo = response.totalUniformes;
                    totalCosto=costo;

                }//termina if success
            },

           error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
            }
           });

           return totalCosto;
    }

    function calculoSumaGastoEntidad(entidad,fecha1,fecha2){
           var gasto=0;

           $.ajax({
                async: false,
                type: "POST",
                url: "ajax_sumaGastoByEntidad.php",
                data : {"fecha1":fecha1, "fecha2":fecha2, "entidad":entidad},
                dataType: "json",
                success: function(response) {
                    if (response.status == "success")
                    {

                        var total = response.totalPromedio;
                        gasto=total;

                    }//termina if success
                },

               error: function(jqXHR, textStatus, errorThrown){
                      alert(jqXHR.responseText);
                }
            });

           return gasto;
    }


    $("#descargarReporteDetalle").click(function(event) {
    $("#datos_reporte").val( $("<div>").append( $("#tableReporteGeneral").eq(0).clone()).html());
    $("#form_consultaReporteDetalle").submit();
    });

     $('#txtFechaReporteDetalle1').datetimepicker({
      timepicker:false,
      format:'Y-m-d',
      formatDate:'Y-m-d',

    });

      $('#txtFechaReporteDetalle2').datetimepicker({
      timepicker:false,
      format:'Y-m-d',
      formatDate:'Y-m-d',

    });




      function editar(i){
         $("#montofacturado"+i).prop('readonly', false);
         $("#turnosfacturacion"+i).prop('readonly', false);
         $("#imgsave"+i).prop('readonly', false);

     }

     function guardar(puntoservicio,puesto,i){
        // alert(puntoservicio + " campo " + i);
      var fechaini=$("#txtFechaReporteDetalle1").val();
      var fechafi=$("#txtFechaReporteDetalle2").val();
      var monto=$("#montofacturado"+i).val();
      var turnosfactu=  $("#turnosfacturacion"+i).val();
       //puntoservicio es el punto que recibimos en la funcion
       var llave=puntoservicio+"_"+puesto;

       if(fechaini=="" || fechafi ==""){
        alert("Por favor introduzca una fecha correcta");
       }else if(turnosfactu=="" || !/^([0-9])*$/.test(turnosfactu)){
        alert("Por favor verifique Turnos facturados en la fila: " +(i+1)+ " Solo Numeros");
       }else if(monto==""|| !/^([0-9]+\.?[0-9]{0,2})$/.test(monto)){
        alert("Por favor  verifique Monto facturado en la fila: " +(i+1)+ " Solo Numeros");
       }else{
         $.ajax({
             type: "POST",
             url: "ajax_insertUpdateturnomoontosfacturacion.php",
             dataType: "json",
             data: {
                 "fecha1": fechaini,
                 "fecha2": fechafi,
                 "monto":monto,
                 "turnosfactu":turnosfactu,
                 "llave":llave
             },
             success: function(response) {
                 //console.log(response);
                $("#montofacturado"+i).prop('readonly', true);
                $("#turnosfacturacion"+i).prop('readonly', true);
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
         });

       }
     }




    function obtenerDatosmontoturnosfacturados (puntoServicio,puesto,fecha1,fecha2,roloperativo){
      var key=puntoServicio+"_"+puesto;

      var lista= new Array();
        $.ajax({
            async: false,
            type: "POST",
            url: "ajax_traedatosmontoturnosbycliente.php",
            data : {"fecha1":fecha1, "fecha2":fecha2, "llave":key},
            dataType: "json",
            success: function(response) {
             // console.log(response);

                if (response.status == "success")
                {

                    var valores = response.valores;
                    lista=valores;
                   // console.log(valores);

                }//termina if success
            },

           error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
            }
           });

           return lista;
    }



 </script>