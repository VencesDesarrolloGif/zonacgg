<meta charset="utf-8"/>
<legend>Campos Obligatorios </legend>

<input id="banderaRegistroVehicular" name="banderaRegistroVehicular" type="hidden" class="input-medium">

<div id="mensajeserrorRegistroVehicular"></div>

<form class="form-inline" method="post" id="form_RegistrarVehiculo" target="_blank" enctype="multipart/form-data">
  <div align="center" >
    <div  style="max-width: 112rem; border-style: groove; border-color: rgb(51,153,255); "><br> 
      <legend id="titulolgeneral" style="color:blue;"><h4>Consulta De Vehiculos</h4></legend><br>
      <div class= "row">
        <input id="banderachechs" name="banderachechs" type="hidden">
        <label class="control-label label" id="BuscarVehiculo">Buscar Vehiculo</label>
        <select id="selBuscarVehiculo" name="selBuscarVehiculo" class="span3"></select>
      
        <label class="control-label label" id="DigiteNumeroPlaca">Digite El Numero De Placa</label>
        <input id="inpDigiteNumeroPlaca" name="inpDigiteNumeroPlaca" type="text" class="input-medium" onblur ="validacionesconsultavehicular(1);">
      
        <label class="control-label label" id="DigiteNumeroEconomico">Digite El Numero Economico</label>
        <input id="inpDigiteNumeroEconomico" name="inpDigiteNumeroEconomico" type="text" class="input-medium" onblur="validacionesconsultavehicular(2);">

      </div><br>

      <legend id="titulolgeneral" style="color:blue;"><h4>Datos Generales del Vehiculo</h4></legend><br>
      <div class= "row">

        <label class="control-label label" for="numeroeconomicoconsulta" id="labelnumeroeconomicoconsulta">NUMERO ECONOMICO</label>
        <input id="numeroeconomicoconsulta" name="numeroeconomicoconsulta" type="text" readonly class="input-medium">

        <label class="control-label label" for="EstatusVehiculoConsulta" id="labelEstatusVehiculoConsulta">ESTATUS DEL VEHICULO</label>
        <input id="EstatusVehiculoConsulta" name="EstatusVehiculoConsulta" type="text" readonly class="input-medium">
        
      </div><br>
      <div class= "row">
        
        <label class="control-label label" for="empresaexterno">Asignación De Vehículo</label>
        <select id="selempresaexterno" name="selempresaexterno" class="span3"></select>

        <label class="control-label label" for="fechaingreso">Fecha De Ingreso(Empresa)</label>
        <input id="fechaingreso" name="fechaingreso" type="date" class="input-medium">

        <label class="control-label label" for="LineaDeNegocio">Linea De Negocio</label>
        <select id="selLineaDeNegocio" name="selLineaDeNegocio" class="span3"></select>
        <input id="selLineaDeNegocioHiden" name="selLineaDeNegocioHiden" type="hidden">

        <label class="control-label label" for="Entidad">Entidad Federativa De Contratación</label>
        <select id="selEntidad" name="selEntidad" class="span3"></select>
        <input id="selEntidadHiden" name="selEntidadHiden" type="hidden">
        
      </div><br>

      <div class= "row">

        <label class="control-label label" for="Placas">Placas Tipo De Servicio</label>
        <select id="selPlacas" name="selPlacas" class="span3"></select>

        <label class="control-label label" for="Modalidad">Placas Modalidad  </label>
        <select id="selModalidad" name="selModalidad" class="span3"></select>
        
        <label class="control-label label" for="Engomado">Color Del Engomado (Placas) </label>
        <select id="selEngomado" name="selEngomado" class="span3"></select>
        <input id="colorengomadohiden" name="colorengomadohiden" type="hidden">

        <label class=" control-label label " for="numeroPlacas">Numero De Placas</label>
        <input id="numeroPlacas" name="numeroPlacas" type="text" class="span3 input-medium">
        <input id="numeroplacashiden" name="numeroplacashiden" type="hidden">
        
      </div><br>

      <div class= "row">
        
        <label class="control-label label " for="tarjetacirculacion">La Tarjeta De Circulación Es</label>
        <select id="seltarjetacirculacion" name="seltarjetacirculacion" class="span3"></select>
        <input id="tarjetchiden" name="tarjetchiden" type="hidden">
        
        <label class="control-label label" id="lblFechaDeIniciotarjeta">Vigencia Inicio(Tarjata Circulación)</label>
        <input id="inpFechaDeIniciotarjeta" name="inpFechaDeIniciotarjeta" type="date" class="span3 input-medium">
        <input id="fechainiciotarjetahiden" name="fechainiciotarjetahiden" type="hidden">
  
        <label class="control-label label" id="lblFechaDeTerminotarjeta">Vigencia Término(Tarjeta Circulación)</label>
        <input id="inpFechaDeTerminotarjeta" name="inpFechaDeTerminotarjeta" type="date" class="span3 input-medium">
        <input id="fechaterminotarjetahiden" name="fechaterminotarjetahiden" type="hidden">
      
      </div><br>

      <div class= "row">

        <label class="control-label label" for="TipoDeVehiculo">Tipo De Vehículo</label>
        <select id="selTipoDeVehiculo" name="selTipoDeVehiculo" class="span3"></select>

        <label class="control-label label" for="Marca">Marca </label>
        <select id="selMarca" name="selMarca" class="span3"></select>

        <label class="control-label label" for="Modelo">Modelo </label>
        <select id="selModelo" name="selModelo" class="span3"></select>

        <label class="control-label label" for="Color">Color Del Vehículo</label>
        <select id="selColor" name="selColor" class="span3"></select>

      </div><br>

      <div class= "row">

        <label class="control-label label " for="Año">Año del Modelo</label>
        <input id="inpAnio" name="inpAnio" type="text" maxlength="4" class="span3 input-medium" placeholder="1999">

        <label class="control-label label " for="NumeroDeSerie">Número De Serie</label>
        <input id="inpNumeroDeSerie" name="inpNumeroDeSerie" type="text" maxlength="17" class="span3 input-medium">
     
        <label class="control-label label " for="CuentaConNumeroMotro">Cuenta Con Número De Motor</label>
        <select id="selCuentaConNumeroMotro" name="selCuentaConNumeroMotro" class="span3"></select>
        <input id="tienemotorhiden" name="tienemotorhiden" type="hidden">

        <label class="control-label label"for="NumeroDeMotor"id="lblNumeroDeMotor">Número De Motor</label>
        <input id="inpNumeroDeMotor" name="inpNumeroDeMotor" type="text"maxlength="11"class="span3 input-medium">
        <input id="numeromotrohiden" name="numeromotrohiden" type="hidden">

        <label class="control-label label " for="PaisOrigen" id="lblPaisOrigen">País De Origen</label> 
        <select id="selPaisOrigen" name="selPaisOrigen" class="span3"></select>
        <input id="paishiden" name="paishiden" type="hidden">
        
      </div><br>

      <div class= "row">
        
        <label class="control-label label" for="VehiculoNuevoViejo">El Vehículo Es:</label>
        <select id="selVehiculoNuevoViejo" name="selVehiculoNuevoViejo" class="span3"></select>  

        <label class="control-label label">Fecha De Compra</label>
        <input id="fechaCompra" name="fechaCompra" type="date" class="span3 input-medium">

        <label class="control-label label" for="CilindrosDelVehiculo">Cilindros Del Vehiculo</label>
        <select id="selCilindrosDelVehiculo" name="selCilindrosDelVehiculo" class="span3"></select>

        <label class="control-label label " for="CentimetrosCubicos">Centimetros Cubicos Del Vehiculo</label>
        <input id="inpCentimetrosCubicos" name="inpCentimetrosCubicos" type="text" class="span3 input-medium">      
      
      </div><br>

      <legend id="titulol" style="color:blue;"><h4>Póliza De Seguro</h4></legend><br>

      <div class= "row">
        
        <label class="control-label label" for="Aseguradora">Aseguradora</label>
        <select id="selAseguradora" name="selAseguradora" class="span3"></select>
        <input id="selAseguradorahiden" name="selAseguradorahiden" type="hidden">
        
        <label class="control-label label" for="TipoDePoliza">Tipo De Póliza</label>
        <select id="selTipoDePoliza" name="selTipoDePoliza" class="span3"></select>
        <input id="selTipoDePolizahiden" name="selTipoDePolizahiden" type="hidden">

        <label class="control-label label " for="NumeroPolisa">Número De Póliza</label>
        <input id="inpNumeroPoliza" name="inpNumeroPoliza" type="text" class="span3 input-medium">
        <input id="numeropolizahiden" name="numeropolizahiden" type="hidden">
        
      </div><br>

      <div class= "row">
        
        <label class="control-label label" for="FechaIniciPoliza">Fecha De Inicio(Póliza)</label>
        <input id="selFechaIniciPoliza" name="selFechaIniciPoliza" type="date" class="span3 input-medium">
        <input id="selFechaIniciPolizaHiden" name="selFechaIniciPolizaHiden" type="hidden">

        <label class="control-label label" for="FechaFinPoliza">Fecha De Término(Póliza)</label>
        <input id="selFechaFinPoliza" name="selFechaFinPoliza" type="date" class="span3 input-medium">
        <input id="selFechaFinPolizaHiden" name="selFechaFinPolizaHiden" type="hidden">

      </div><br>

        <div class= "row">

          <label class="control-label label" id="lblDMPTotal">Daños Materiales Pérdida Total</label>
          <input id="DMPTotal" name="DMPTotal" type="checkbox" style="transform: scale(1.5);">
  
          <label class="control-label label"for="CantidadPerdidaTotal"id="lblCantidadPerdidaTotal">Cantidad Asegurada</label>
          <input id="inpCantidadPerdidaTotal" name="inpCantidadPerdidaTotal" type="text" placeholder="$" class="span3 input-medium">
      
          <label class="control-label label" id="lblCristales">Cristales</label>
          <input id="Cristales" name="Cristales" type="checkbox" style="transform: scale(1.5);">
  
          <label class="control-label label" id="lblAparadaCristales">Están Amparados</label>
          <select id="selAparadaCristales" name="selAparadaCristales" class="span3"></select>
  
          <label class="control-label label" for="PorcentajeCristales" id="lblPorcentajeCristales">Porcentaje Amparado</label>
          <input id="inpPorcentajeCristales" name="inpPorcentajeCristales" maxlength="3" type="text" placeholder="%" class="span3 input-medium">
  
          <label class="control-label label"for="CantidadCristales"id="lblCantidadCristales">Cantidad Asegurada</label>
          <input id="inpCantidadCristales" name="inpCantidadCristales" type="text" placeholder="$" class="span3 input-medium">

      </div><br>

      <div class= "row">

        <label class="control-label label" id="lblDMPParcial">Daños Materiales Pérdida Parcial</label>
        <input id="DMPParcial" name="DMPParcial" type="checkbox" style="transform: scale(1.5);">

        <label class="control-label label"for="CantidadPerdidaParcial" id="lblCantidadPerdidaParcial">Cantidad Asegurada</label>
        <input id="inpCantidadPerdidaParcial" name="inpCantidadPerdidaParcial" type="text" placeholder="$" class="span3 input-medium">
    
        <label class="control-label label" id="lblProteccionLegal">Protección Legal</label>
        <input id="ProteccionLegal" name="ProteccionLegal" type="checkbox" style="transform: scale(1.5);">

        <label class="control-label label" id="lblAparadaProteccionLegal">Es Amparada</label>
        <select id="selAparadaProteccionLegal" name="selAparadaProteccionLegal" class="span3"></select>

        <label class="control-label label" for="PorcentajeProteccionLegal"id="lblPorcentajeProteccionLegal">Porcentaje Amparado</label>
        <input id="inpPorcentajeProteccionLegal" name="inpPorcentajeProteccionLegal" maxlength="3" type="text" placeholder="%" class="span3 input-medium">

        <label class="control-label label"for="CantidadProteccionLegal"id="lblCantidadProteccionLegal">Cantidad Asegurada</label>
        <input id="inpCantidadProteccionLegal" name="inpCantidadProteccionLegal" type="text" placeholder="$" class="span3 input-medium">

      </div><br>

      <div class= "row">

        <label class="control-label label" id="lblRobototal">Robo Total</label>
        <input id="Robototal" name="Robototal" type="checkbox" style="transform: scale(1.5);">

        <label class="control-label label"for="CantidadRobototal" id="lblCantidadRobototal">Cantidad Asegurada</label>
        <input id="inpCantidadRobototal" name="inpCantidadRobototal" type="text" placeholder="$" class="span3 input-medium">
    
        <label class="control-label label" id="lblClub">Club Autos</label>
        <input id="Club" name="Club" type="checkbox" style="transform: scale(1.5);">

        <label class="control-label label" id="lblAparadaClub">Es Amparada</label>
        <select id="selAparadaClub" name="selAparadaClub" class="span3"></select>

        <label class="control-label label" for="PorcentajeClub" id="lblPorcentajeClub">Porcentaje Amparado</label>
        <input id="inpPorcentajeClub" name="inpPorcentajeClub" type="text" maxlength="3" placeholder="%" class="span3 input-medium">

        <label class="control-label label"for="CantidadClub"id="lblCantidadClub">Cantidad Asegurada</label>
        <input id="inpCantidadClub" name="inpCantidadClub" type="text" placeholder="$" class="span3 input-medium">

      </div><br>

      <div class= "row">
        
        <label class="control-label label" id="lblDanosATerceros">Responsabilidad Civil Por daños A Terceros</label>
        <input id="DanosATerceros" name="DanosATerceros" type="checkbox" style="transform: scale(1.5);">

        <label class="control-label label"for="CantidadDanosATerceros"id="lblCantidadDanosATerceros">Cantidad Asegurada</label>
        <input id="inpCantidadDanosATerceros" name="inpCantidadDanosATerceros" type="text" placeholder="$" class="span3 input-medium">

        <label class="control-label label" id="lblGastosMedicos">Gastos Médicos Ocupantes</label>
        <input id="GastosMedicos" name="GastosMedicos" type="checkbox" style="transform: scale(1.5);">

        <label class="control-label label"for="CantidadGastosMedicos"id="lblCantidadGastosMedicos">Cantidad Asegurada</label>
        <input id="inpCantidadGastosMedicos" name="inpCantidadGastosMedicos" type="text" placeholder="$" class="span3 input-medium">

      </div><br>

      <div class= "row">

        <label class="control-label label" id="lblAccidentes">Accidentes Al Conductor</label>
        <input id="Accidentes" name="Accidentes" type="checkbox" style="transform: scale(1.5);">

        <label class="control-label label"for="CantidadAccidentes"id="lblCantidadAccidentes">Cantidad Asegurada</label>
        <input id="inpCantidadAccidentes" name="inpCantidadAccidentes" type="text" placeholder="$" class="span3 input-medium">
        
      </div><br>

      <legend id="titulolkit" style="color:blue;"><h4>Kit De Emergencia</h4></legend><br>
      <div class= "row">
        
        
        <label class="control-label label" for="DesarmadorC">Desarmador De Cruz</label>
        <input id="DesarmadorC" name="DesarmadorC" type="checkbox" style="transform: scale(1.5);">

        <label class="control-label label" for="DesarmadorP">Desarmador Plano</label>
        <input id="DesarmadorP" name="DesarmadorP" type="checkbox" style="transform: scale(1.5);">
    
        <label class="control-label label" for="Cables">Cables De Pasa Corriente</label>
        <input id="Cables" name="Cables" type="checkbox" style="transform: scale(1.5);">

        <label class="control-label label" for="Senal">Señal De Precaución</label>
        <input id="Senal" name="Senal" type="checkbox" style="transform: scale(1.5);">

        <label class="control-label label" for="CLlave">Copia De La Llave</label>
        <input id="CLlave" name="CLlave" type="checkbox" style="transform: scale(1.5);">

        <label class="control-label label" for="Llanta">Llanta De Refacción</label>
        <input id="Llanta" name="Llanta" type="checkbox" style="transform: scale(1.5);">
      </div><br>
      <div>

        <label class="control-label label" for="Llave">Llave De Cruz</label>
        <input id="Llave" name="Llave" type="checkbox" style="transform: scale(1.5);">

        <label class="control-label label" for="Gato">Gato Hidraulico</label>
        <input id="Gato" name="Gato" type="checkbox" style="transform: scale(1.5);">

        <label class="control-label label" for="TarjetaLlave">Tarjeta Llave</label>
        <input id="TarjetaLlave" name="TarjetaLlave" type="checkbox" style="transform: scale(1.5);">

        <label class="control-label label"for="NumeroTarjetaLLave"id="lblNumeroTarjetaLLave">N° De La Tarjeta LLave</label>
        <input id="inpNumeroTarjetaLLave" name="inpNumeroTarjetaLLave" type="text" class="span3 input-medium" maxlength="15">
        <input id="inpNumeroTarjetaLLavehiden" name="inpNumeroTarjetaLLavehiden" type="hidden">

        <label class="control-label label" for="TarjetaGasolina">Tarjeta Gasolina</label>
        <input id="TarjetaGasolina" name="TarjetaGasolina" type="checkbox" style="transform: scale(1.5);">

        <label class="control-label label"for="NumeroTarjetaGasolina"id="lblNumeroTarjetaGasolina">N° De La Tarjeta Gasolina</label>
        <input id="inpNumeroTarjetaGasolina" name="inpNumeroTarjetaGasolina" type="text" class="span3 input-medium" maxlength="16">
        <input id="inpNumeroTarjetaGasolinahiden" name="inpNumeroTarjetaGasolinahiden" type="hidden">

        <label class="control-label label"for="NIP"id="lblNIP">NIP</label>
        <input id="inpNIP" name="inpNIP" type="text" class="input-mini" maxlength="4">
        <input id="inpNIPhiden" name="inpNIPhiden" type="hidden">

      </div><br>

      <div class= "row">
        
        <label class="control-label label" for="Ninguno">Ninguno</label>
        <input id="inpNinguno" name="inpNinguno" type="checkbox" value="0" style="transform: scale(1.5);">

      </div><br>

      <legend id="titulol" style="color:blue;"><h4>Fotos</h4></legend><br>

    <table  name='tableVehicule' id='tableVehicule'>
        <tr>
          <td>
            <label class="control-label label" for="banco">Vehiculo</label>
            <div id="fotoVehiculo" style="width:150px;height:133px;border:1px solid;"></div>
            <input type="hidden" name="idfotoVehiculo" id="idfotoVehiculo" />
            <input type="file" id="filefotoVehiculo" name="filefotoVehiculo" >
          </td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          <td>
            <label class="control-label label" for="banco">Tarjeta De Circulación</label>
            <div id="fotoTarjeta" style="width:150px;height:133px;border:1px solid;"></div>
            <input type="hidden" name="idfotoTarjeta" id="idfotoTarjeta" />
            <input id="fototarjetahiden" name="fototarjetahiden" type="hidden" class="span3 input-medium">
            <input type="file" id="filefotoTarjeta" name="filefotoTarjeta" >
          </td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          <td>
            <label class="control-label label" for="banco">Poliza Del Seguro</label>
            <div id="fotoPoliza" style="width:150px;height:133px;border:1px solid;"></div>
            <input type="hidden" name="idfotoPoliza" id="idfotoPoliza" />
            <input id="fotopolizahiden" name="fotopolizahiden" type="hidden" class="span3 input-medium">
            <input type="file" id="filefotoPoliza" name="filefotoPoliza" >
          </td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          <td>
            <label class="control-label label" for="banco">Factura o Comprobante de Compra</label>
            <div id="fotoFactura" style="width:150px;height:133px;border:1px solid;"></div>
            <input type="hidden" name="idfotoFactura" id="idfotoFactura" />
            <input id="fotofacturahiden" name="fotofacturahiden" type="hidden" class="span3 input-medium">
            <input type="file" id="filefotoFactura" name="filefotoFactura" >
            </td>

        </tr>
      </table><br>

      <div class= "row">

        <button id="guardarVehiculo" name="guardarVehiculo" class="btn btn-primary" type="button" onclick="validarRegistroVehicular();"> 
        <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button>

        <button id="editarVehiculo" name="editarVehiculo" class="btn btn-warning" type="button" onclick="editardatosconsulta();"> 
        <span></span>Editar Vehiculo</button>

        <button id="DarDeBajaVehiculo" name="DarDeBajaVehiculo" class="btn btn-danger" type="button" onclick="AbrirModalBaja(1);"> 
        <span></span>Dar De Baja Vehiculo</button>

        <button id="guardaredicion" name="guardaredicion" class="btn btn-primary" type="button" onclick="validarEdicionVehicular();"> 
        <span class="glyphicon glyphicon-floppy-save"></span>Guardar Edición</button>

        <button id="ReingresarVehiculo" name="ReingresarVehiculo" class="btn btn-primary" type="button" onclick="AbrirModalBaja(2);"> 
        <span class="glyphicon glyphicon-floppy-save"></span>Reingresar Vehiculo</button>

      </div><br>

    </div>
      <div id="modalDarDeBajaVehiculo" name="modalDarDeBajaVehiculo" class="modalEdit hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
     <div id="mensajeerrorModalBajaVehiculo"></div>
    <div class="modal-header">
      <h4 class="modal-title" id="myModalLabel"> <img src="img/warning.png">Dar Da Baja Vehiculo!!</h4>
    </div>
    <div class="modal-body">
      <div class="input-prepend">
        <span class="add-on">Número Economico</span>
        <input id="NumEcoBaja" name="NumEcoBaja" type="text" class="input-medium" readonly>
        <span class="add-on">M° Placas</span>
        <input id="numPlacasBaja" name="numPlacasBaja" type="text" class="input-medium" readonly>
        <span class="add-on">N° Serie</span>
        <input id="NumSerieBaja" name="NumSerieBaja" type="text" class="input-medium" readonly>
      </div><br>
      <div class="modal-body">
      <div class="input-prepend">

        <label class="control-label label " for="MotivoBaja" id="motivobajaid" >Motivo Baja</label>
         <label class="control-label label " for="MotivoBaja" id="motivoReingresoid" >Motivo Alta</label>
        <select id="selMotivoBaja1212" name="selMotivoBaja1212" class="span3"></select>
        <label class="control-label label " for="MotivoSiniestro" id="lblMotivoSiniestro" style="display: none;">Motivo Del Siniestro</label>
        <select id="selMotivoSiniestro" name="selMotivoSiniestro" class="span3" style="display: none;"></select>

      </div><br>
      <div class="input-prepend">

        <label class="control-label label " for="hojafiniquito" id="hojafiniquito" style="display: none;">Hoja De Finiquito</label>
        <input type='file' class='btn-success ' id='DocFiniquito12' name='DocFiniquito12[]' style="display: none;"/>
        <input id="DocFiniquitoHiden" name="DocFiniquitoHiden" type="hidden">
        <label class="control-label label " for="cheque" id="cheque"style="display: none;">Cheque</label>
        <input type='file' class='btn-success ' id='DocCheques12' name='DocCheques12[]' style="display: none;" />
        <input id="DocChequesHiden" name="DocChequesHiden" type="hidden">

      </div><br>


      <div class="input-prepend">

        <span class="add-on">Comentarios:</span>
          <textarea  id="ComentariosBaja" name="ComentariosBaja" class="txtAreaComentarios" rows="5" ></textarea>
      </div><br>
        
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick='DarBajaVehiculo();' id="aplicarbaja">Aplicar Baja</button>
      <button type="button" class="btn btn-primary" onclick='ReingresarVehiculo1();' id="aplicarreingeso">Aplicar Reingreso</button>
      <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
    </div>
  </div> 
  </div>
</div>
</form>


<div class="modal fade" tabindex="-1" role="dialog" name="modalvehicular" id="modalvehicular" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><img src="img/ok.png">Tu Vehículo Ha Sido Registrado Con Éxito !!</h4>
      </div>
      <div class="modal-body">
        <p><strong id="strongnumeroeconomico"></strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  
<script type="text/javascript">
  $(document).ready(function() {

  });
///////////////////**********************Formulario De Consulta Vehicular***********///////////
  function BloquearYocultarCamposConsulta()
  {

    $("#DMPTotal").prop("checked", false);  
    $("#Cristales").prop("checked", false);  
    $("#DMPParcial").prop("checked", false);  
    $("#ProteccionLegal").prop("checked", false);  
    $("#Robototal").prop("checked", false);  
    $("#Club").prop("checked", false);  
    $("#DanosATerceros").prop("checked", false);  
    $("#GastosMedicos").prop("checked", false);  
    $("#Accidentes").prop("checked", false); 
    $("#DesarmadorC").prop('checked', false);
    $("#DesarmadorP").prop('checked', false);
    $("#Cables").prop('checked', false);     
    $("#Senal").prop('checked', false);     
    $("#Llave").prop('checked', false);     
    $("#CLlave").prop('checked', false); 
    $("#Llanta").prop('checked', false);   
    $("#Gato").prop('checked', false);
    $("#TarjetaLlave").prop('checked', false);
    $("#TarjetaGasolina").prop('checked', false);
    
    $("#selempresaexterno").empty();
    $("#selLineaDeNegocio").empty();
    $("#selPlacas").empty();
    $("#seltarjetacirculacion").empty();
    $("#selMarca").empty();
    $("#inpAnio").val("");
    $("#inpNumeroDeSerie").val("");
    $("#selCuentaConNumeroMotro").empty();
    $("#selVehiculoNuevoViejo").empty();
    $("#selCilindrosDelVehiculo").empty();
    $("#selAseguradora").empty();
    $("#filefotoVehiculo").empty();
    $("#filefotoTarjeta").empty();
    $("#filefotoPoliza").empty();
    $("#filefotoFactura").empty();
    $("#fechaCompra").val("");
    $("#fechaingreso").val("");
    $("#inpFechaDeIniciotarjeta").val("");
    $("#inpFechaDeTerminotarjeta").val("");
    $("#inpNumeroPoliza").val("");
    $("#selFechaIniciPoliza").val("");
    $("#selFechaFinPoliza").val("");


    $("#inpDigiteNumeroPlaca").hide();
    $("#DigiteNumeroPlaca").hide();
    $("#inpDigiteNumeroEconomico").hide();
    $("#DigiteNumeroEconomico").hide();
    $("#guardarVehiculo").hide();
    $("#editarVehiculo").hide();
    $("#guardaredicion").hide();
    $("#DarDeBajaVehiculo").hide();
    $("#ReingresarVehiculo").hide();
    $("#labelnumeroeconomicoconsulta").show();
    $("#labelEstatusVehiculoConsulta").show();
    $("#numeroeconomicoconsulta").show();
    $("#EstatusVehiculoConsulta").show();
    $("#numeroeconomicoconsulta").val("");
    $("#EstatusVehiculoConsulta").val("");

    $("#lblCantidadPerdidaTotal").hide();
    $("#inpCantidadPerdidaTotal").hide();
    $("#lblAparadaCristales").hide();
    $("#selAparadaCristales").hide();
    $("#lblPorcentajeCristales").hide();
    $("#inpPorcentajeCristales").hide();
    $("#lblCantidadCristales").hide();
    $("#inpCantidadCristales").hide();
    $("#lblCantidadPerdidaParcial").hide();
    $("#inpCantidadPerdidaParcial").hide();
    $("#lblAparadaProteccionLegal").hide();
    $("#selAparadaProteccionLegal").hide();
    $("#lblPorcentajeProteccionLegal").hide();
    $("#inpPorcentajeProteccionLegal").hide();
    $("#lblCantidadProteccionLegal").hide();
    $("#inpCantidadProteccionLegal").hide();
    $("#lblCantidadRobototal").hide();
    $("#inpCantidadRobototal").hide();
    $("#lblAparadaClub").hide();
    $("#selAparadaClub").hide();
    $("#lblPorcentajeClub").hide();
    $("#inpPorcentajeClub").hide();
    $("#lblCantidadClub").hide();
    $("#inpCantidadClub").hide();
    $("#lblCantidadDanosATerceros").hide();
    $("#inpCantidadDanosATerceros").hide();
    $("#lblCantidadGastosMedicos").hide();
    $("#inpCantidadGastosMedicos").hide();
    $("#lblCantidadAccidentes").hide();
    $("#inpCantidadAccidentes").hide();
    $("#lblNumeroTarjetaLLave").hide();
    $("#inpNumeroTarjetaLLave").hide();
    $("#lblNumeroTarjetaGasolina").hide();
    $("#inpNumeroTarjetaGasolina").hide();
    $("#lblNIP").hide();
    $("#inpNIP").hide();

    $("#lblNumeroDeMotor").hide();
    $("#inpNumeroDeMotor").hide();
    $("#lblPaisOrigen").hide();
    $("#selPaisOrigen").hide();

    $("#selempresaexterno").prop('disabled', true);
    $("#selLineaDeNegocio").prop('disabled', true);
    $("#selPlacas").prop('disabled', true);
    $("#seltarjetacirculacion").prop('disabled', true);
    $("#selMarca").prop('disabled', true);
    $("#inpAnio").prop('readonly', true);
    $("#inpNumeroDeSerie").prop('readonly', true);
    $("#selCuentaConNumeroMotro").prop('disabled', true);
    $("#selVehiculoNuevoViejo").prop('disabled', true);
    $("#selCilindrosDelVehiculo").prop('disabled', true);
    $("#selAseguradora").prop('disabled', true);

    $("#filefotoVehiculo").hide();
    $("#filefotoTarjeta").hide();
    $("#filefotoPoliza").hide();
    $("#filefotoFactura").hide();

    $("#DMPTotal").prop('disabled', true);
    $("#Cristales").prop('disabled', true);
    $("#DMPParcial").prop('disabled', true);
    $("#ProteccionLegal").prop('disabled', true);
    $("#Robototal").prop('disabled', true);
    $("#Club").prop('disabled', true);
    $("#DanosATerceros").prop('disabled', true);
    $("#GastosMedicos").prop('disabled', true);
    $("#Accidentes").prop('disabled', true);

    $("#selTipoDePoliza").prop('disabled', true);
    $('#selTipoDePoliza').empty();
    $("#inpFechaDeIniciotarjeta").prop('readonly', true);
    $("#inpFechaDeTerminotarjeta").prop('readonly', true);
    $('#inpCentimetrosCubicos').val("");
    $('#inpCentimetrosCubicos').prop('placeholder',"");
    $('#inpCentimetrosCubicos').prop('readonly', true);
    $("#fechaCompra").prop('disabled', true);
    $("#inpNumeroPoliza").prop('readonly', true);
    $("#selFechaIniciPoliza").prop('readonly', true);
    $("#selFechaFinPoliza").prop('readonly', true);
    $("#fechaingreso").prop('disabled', true);
    $('#selModalidad').empty();
    $('#selModalidad').prop('disabled', true);
    $('#selEngomado').empty();
    $('#selEngomado').prop('disabled', true);
    $("#selEntidad").empty();
    $("#selEntidad").prop('disabled', true);
    $('#numeroPlacas').val("");
    $('#numeroPlacas').prop('placeholder',"");
    $('#numeroPlacas').prop('readonly', true);
    $('#selModelo').empty();
    $('#selModelo').prop('disabled', true);
    $('#selTipoDeVehiculo').empty();
    $('#selTipoDeVehiculo').prop('disabled', true);
    $('#selColor').empty();
    $('#selColor').prop('disabled', true);
    $('#selEntidad').empty();
    $('#selEntidad').prop('disabled', true);

    $("#DesarmadorC").prop('disabled', true);
    $("#DesarmadorP").prop('disabled', true);
    $("#Cables").prop('disabled', true);     
    $("#Senal").prop('disabled', true);     
    $("#Llave").prop('disabled', true);     
    $("#CLlave").prop('disabled', true); 
    $("#Llanta").prop('disabled', true);   
    $("#Gato").prop('disabled', true);
    $("#TarjetaLlave").prop('disabled', true);
    $("#TarjetaGasolina").prop('disabled', true);
    $("#inpNinguno").prop('disabled', true);

    $("#inpCantidadPerdidaTotal").prop('readonly', true);
    $("#selAparadaCristales").prop('disabled', true);
    $("#inpPorcentajeCristales").prop('readonly', true);
    $("#inpCantidadCristales").prop('readonly', true);
    $("#inpCantidadPerdidaParcial").prop('readonly', true);
    $("#selAparadaProteccionLegal").prop('disabled', true);
    $("#inpPorcentajeProteccionLegal").prop('readonly', true);
    $("#inpCantidadProteccionLegal").prop('readonly', true);
    $("#inpCantidadRobototal").prop('readonly', true);
    $("#selAparadaClub").prop('disabled', true);
    $("#inpPorcentajeClub").prop('readonly', true);
    $("#inpCantidadClub").prop('readonly', true);
    $("#inpCantidadDanosATerceros").prop('readonly', true);
    $("#inpCantidadGastosMedicos").prop('readonly', true);
    $("#inpCantidadAccidentes").prop('readonly', true);
    $("#inpNumeroTarjetaLLave").prop('readonly',true);
    $("#inpNumeroTarjetaGasolina").prop('readonly',true);
    $("#inpNIP").prop('readonly',true);

    $("#inpNumeroDeMotor").prop('readonly', true);
    $("#selPaisOrigen").prop('disabled', true);

    CargarFotoFactura();
    CargarFotoPoliza();
    CargarFotoTarjeta();
    CargarFotoCarro();

    $("#titulolgeneral").show();
    $("#selBuscarVehiculo").show();
    $("#BuscarVehiculo").show();
  }

    function cargarOpcionesDeConsulta(){
    var opcinesvehiculo=["Numero Economico","Numero De Placa"];
    $("#selBuscarVehiculo").empty();
    $('#selBuscarVehiculo').append('<option value="0">Buscar</option>');

      for (var i = 0; i < opcinesvehiculo.length; i++)
      {
        $('#selBuscarVehiculo').append('<option value="' + (i+1) + '">' + opcinesvehiculo[i] + '</option>');
      }
  }

  function editardatosconsulta(){
    var selEngomado = $("#selEngomado").val();
    var selLineaDeNegocio = $("#selLineaDeNegocio").val();
    var selEntidad = $("#selEntidad").val();
    var numeroPlacas = $("#numeroPlacas").val();
    var seltarjetacirculacion = $("#seltarjetacirculacion").val();
    var inpFechaDeIniciotarjeta = $("#inpFechaDeIniciotarjeta").val();
    var inpFechaDeTerminotarjeta = $("#inpFechaDeTerminotarjeta").val();
    var selCuentaConNumeroMotro = $("#selCuentaConNumeroMotro").val();
    var inpNumeroDeMotor = $("#inpNumeroDeMotor").val();
    var selPaisOrigen = $("#selPaisOrigen").val();
    // alert(selPaisOrigen);
    var inpNumeroPoliza = $("#inpNumeroPoliza").val();
    var selFechaIniciPoliza = $("#selFechaIniciPoliza").val();
    var selFechaFinPoliza = $("#selFechaFinPoliza").val();
    var idfotoTarjeta =$("#idfotoTarjeta").val();
    var idfotoPoliza =$("#idfotoPoliza").val();
    var idfotoFactura =$("#idfotoFactura").val();
    var inpNumeroTarjetaLLave = $("#inpNumeroTarjetaLLave").val();
    var inpNumeroTarjetaGasolina = $("#inpNumeroTarjetaGasolina").val();
    var inpNIP = $("#inpNIP").val();
    var selAseguradora = $("#selAseguradora").val();
    var selTipoDePoliza = $("#selTipoDePoliza").val();

    $("#colorengomadohiden").val(selEngomado);
    
    $("#numeroplacashiden").val(numeroPlacas);
    $("#tarjetchiden").val(seltarjetacirculacion);
    $("#fechainiciotarjetahiden").val(inpFechaDeIniciotarjeta);
    $("#fechaterminotarjetahiden").val(inpFechaDeTerminotarjeta);
    $("#tienemotorhiden").val(selCuentaConNumeroMotro);
    $("#numeromotrohiden").val(inpNumeroDeMotor);
    $("#paishiden").val(selPaisOrigen);
    $("#numeropolizahiden").val(inpNumeroPoliza);
    $("#selFechaIniciPolizaHiden").val(selFechaIniciPoliza);
    $("#selFechaFinPolizaHiden").val(selFechaFinPoliza);
    $("#fototarjetahiden").val(idfotoTarjeta);
    $("#fotopolizahiden").val(idfotoPoliza);
    $("#fotofacturahiden").val(idfotoFactura);
    $("#inpNumeroTarjetaLLavehiden").val(inpNumeroTarjetaLLave);
    $("#inpNumeroTarjetaGasolinahiden").val(inpNumeroTarjetaGasolina);
    $("#inpNIPhiden").val(inpNIP);
    $("#selAseguradorahiden").val(selAseguradora);
    $("#selTipoDePolizahiden").val(selTipoDePoliza);
    $("#selLineaDeNegocioHiden").val(selLineaDeNegocio);
    $("#selEntidadHiden").val(selEntidad);

    $("#editarVehiculo").hide();
    $("#DarDeBajaVehiculo").hide();
    $("#ReingresarVehiculo").hide();
    $("#guardaredicion").show();
    $("#selEngomado").prop('disabled',false);
    $("#selLineaDeNegocio").prop('disabled',false);
    $("#selEntidad").prop('disabled',false);
    $("#numeroPlacas").prop('readonly',false);
    $("#seltarjetacirculacion").prop('disabled',false);
    $("#selCuentaConNumeroMotro").prop('disabled',false);
    $("#inpNumeroTarjetaLLave").prop('readonly',false);
    $("#inpNumeroTarjetaGasolina").prop('readonly',false);
    $("#inpNIP").prop('readonly',false);
    $("#selAseguradora").prop('disabled',false);
    $("#selTipoDePoliza").prop('disabled',false);
    if(selCuentaConNumeroMotro=="1"){
      $("#inpNumeroDeMotor").show();
      $("#selPaisOrigen").hide();
      $("#inpNumeroDeMotor").prop('readonly',false);
    }else{
      $("#inpNumeroDeMotor").hide();
      $("#selPaisOrigen").show();
      $("#selPaisOrigen").prop('disabled',false);
    }
    $("#inpNumeroPoliza").prop('readonly',false);
    $("#selFechaIniciPoliza").prop('readonly',false);
    $("#selFechaFinPoliza").prop('readonly',false);
    $("#filefotoTarjeta").attr('style', 'display : block');
    $("#filefotoPoliza").attr('style', 'display : block');
    $("#filefotoFactura").attr('style', 'display : block');
    $("#banderachechs").val(1);
    getcataseguradoras();
    getcolorvehiculoengomado(1);
    getcattarjetacirculacion();
    getcatnummotor();
    cargarLineaDeNegocio();
    getentidades();
    //$( "#selCanal option:selected" ).text();
    $("#selLineaDeNegocio").val(selLineaDeNegocio);
    $("#selEntidad").val(selEntidad);
    $("#selAseguradora").val(selAseguradora);
    $("#selEngomado").val(selEngomado);
    $("#seltarjetacirculacion").val(seltarjetacirculacion);
    $("#selCuentaConNumeroMotro").val(selCuentaConNumeroMotro);

  }
  function limpiarcamposhiden(){

    $("#selEngomado").empty();
    $("#selLineaDeNegocio").empty();
    $("#selEntidad").empty();
    $("#colorengomadohiden").val("");
    $("#numeroPlacas").val("");
    $("#numeroplacashiden").val("");
    $("#seltarjetacirculacion").empty();
    $("#tarjetchiden").val("");
    $("#inpFechaDeIniciotarjeta").val("");
    $("#fechainiciotarjetahiden").val("");
    $("#inpFechaDeTerminotarjeta").val("");
    $("#fechaterminotarjetahiden").val("");
    $("#selCuentaConNumeroMotro").empty();
    $("#tienemotorhiden").val("");
    $("#inpNumeroDeMotor").val("");
    $("#numeromotrohiden").val("");
    $("#selPaisOrigen").empty();
    $("#paishiden").empty();
    $("#inpNumeroPoliza").val("");
    $("#selFechaIniciPoliza").val("");
    $("#selFechaFinPoliza").val("");
    $("#numeropolizahiden").val("");
    $("#selFechaIniciPolizaHiden").val("");
    $("#selFechaFinPolizaHiden").val("");
    $("#idfotoTarjeta").val("");
    $("#fototarjetahiden").val("");
    $("#idfotoPoliza").val("");
    $("#fotopolizahiden").val("");
    $("#idfotoFactura").val("");
    $("#fotofacturahiden").val("");
  }

    $("#selBuscarVehiculo").change(function() {

      $("#inpDigiteNumeroPlaca").hide();
      $("#DigiteNumeroPlaca").hide();
      $("#inpDigiteNumeroEconomico").hide();
      $("#DigiteNumeroEconomico").hide();
      var valoerselselBuscarVehiculo=$("#selBuscarVehiculo").val();
      if (valoerselselBuscarVehiculo!="0")
      {
        if (valoerselselBuscarVehiculo=="1")
        {
          $("#inpDigiteNumeroEconomico").show();
          $("#DigiteNumeroEconomico").show();
        }
        else if (valoerselselBuscarVehiculo=="2")
        {
          $("#inpDigiteNumeroPlaca").show();
          $("#DigiteNumeroPlaca").show();
        }
      }
    });

    function validacionesconsultavehicular(idinput){
      var inpDigiteNumeroEconomico=$("#inpDigiteNumeroEconomico").val();
      var inpDigiteNumeroPlaca=$("#inpDigiteNumeroPlaca").val();
      var selBuscarVehiculo=$("#selBuscarVehiculo").val();
      if(selBuscarVehiculo=="1" && inpDigiteNumeroEconomico=="" || selBuscarVehiculo=="1" && !/^([0-9])*$/.test(inpDigiteNumeroEconomico)){
        cargaerroresregistroVehicular('Digite El Numero Economico Del Vehiculo Correcto (Acepta Solo Digitos)');
      }
      else if(selBuscarVehiculo=="2" && inpDigiteNumeroPlaca==""){
        cargaerroresregistroVehicular('Digite Las Placas Del Vehiculo Correctas');
      }
      else{
        BuscarConNumeroDePlacas(idinput);
      }
    }
     function BuscarConNumeroDePlacas(consultavehicular)
  { 
    //resetearformulariovehicular();
    BloquearYocultarCamposConsulta();
    var valordelcampodeconsulta="";
    if(consultavehicular==1){

      $("#inpDigiteNumeroPlaca").show();
      $("#DigiteNumeroPlaca").show();
      valordelcampodeconsulta=$("#inpDigiteNumeroPlaca").val();
    }
    else{
      $("#inpDigiteNumeroEconomico").show();
      $("#DigiteNumeroEconomico").show();
      valordelcampodeconsulta=$("#inpDigiteNumeroEconomico").val();
    }
    // alert("entre");
    $.ajax({
              type: "POST",
              url: "ajax_getconsultavehicular.php",
              data: {"consultavehicular": consultavehicular,"valordelcampodeconsulta": valordelcampodeconsulta},
              dataType: "json",
              success: function(response) {
                var datos = response.datos[0];
                if(response.datos=="" && consultavehicular=="2"){
                  cargaerroresregistroVehicular('No Existe Un Vehiculo Con El Numero Economico Ingresado, Ingrese El Numero Economico Correcto');
                }
                else if(response.datos=="" && consultavehicular=="1"){
                   cargaerroresregistroVehicular('No Existe Un Vehiculo Con El Numero De Placas Ingresado, Ingrese El Numero De placas Correcto');
                }
                else{
                  limpiarcamposhiden();
                
                if(datos["EstatusVehiculo"]=="1"){
                  $("#EstatusVehiculoConsulta").val("ACTIVO");
                  $("#editarVehiculo").show();
                  $("#DarDeBajaVehiculo").show();
                }else{
                  $("#EstatusVehiculoConsulta").val("BAJA");
                  $("#editarVehiculo").hide();
                  $("#DarDeBajaVehiculo").hide();
                  $("#ReingresarVehiculo").show();
                }
                $("#numeroeconomicoconsulta").val(datos["idvehiculo"]);
                $('#selempresaexterno').empty().append('<option value="' + datos["destinoempresa"] + '" >' + datos["destinoempresa"] +'</option>');
                $('#fechaingreso').val(datos["fechaIngresoVehiculo"]);
                $('#selLineaDeNegocio').empty().append('<option value="' + datos["IdLineaNegocio"] + '">' + datos["lineanegocio"] +'</option>');
                $('#selEntidad').empty().append('<option value="' + datos["IdEntidadF"] + '">' + datos["entidadfederativa"] +'</option>');
                $('#selPlacas').empty().append('<option >' + datos["tipodeservicio"] +'</option>');
                $('#selModalidad').empty().append('<option >' + datos["modalidadplacas"] +'</option>');
                $('#selEngomado').empty().append('<option value="' + datos["idcolorengomado"] + '">' + datos["colorengomado"] +'</option>');
                $('#numeroPlacas').val(datos["numeroplacas"]);
                $('#selMarca').empty().append('<option >' + datos["Marca"] +'</option>');
                $('#selModelo').empty().append('<option >' + datos["Modelo"] +'</option>');
                $('#selTipoDeVehiculo').empty().append('<option >' + datos["tipoDeVehiculo"] +'</option>');
                $('#selColor').empty().append('<option >' + datos["ColorVehiculo"] +'</option>');
                $('#inpAnio').val(datos["anioVehuiculo"]);
                $('#inpNumeroDeSerie').val(datos["NumeroSerie"]);
                $('#selVehiculoNuevoViejo').empty().append('<option >' + datos["EstadoDelVehiculo"] +'</option>');
                $('#fechaCompra').val(datos["FechaCompra"]);
                $('#selCilindrosDelVehiculo').empty().append('<option >' + datos["Cilindrada"] +'</option>');
                $('#inpCentimetrosCubicos').val(datos["CentimetrosCubicos"]);
                $('#selAseguradora').empty().append('<option value="' + datos["IdAseguradora"] + '">' + datos["Aseguradora"] +'</option>');
                $('#selTipoDePoliza').empty().append('<option value="' + datos["idtipoDePoliza"] + '">' + datos["tipoDePoliza"] +'</option>');
                $('#inpNumeroPoliza').val(datos["NumeroPoliza"]);
                $('#selFechaIniciPoliza').val(datos["FechaIniciPoliza"]);
                $('#selFechaFinPoliza').val(datos["FechaFinalPoliza"]);
                $('#seltarjetacirculacion').empty().append('<option  value="' + datos["idtarjetaDeCirculacion"] + '">' + datos["tarjetaDeCirculacion"] +'</option>');
                $('#selCuentaConNumeroMotro').empty().append('<option value="' + datos["idTieneNumeroDeMotor"] + '">' + datos["TieneNumeroDeMotor"] +'</option>');
                $("#idfotoTarjeta").val(datos["NombreFotoTarjetaDeCirculacion"]);
                $("#idfotoPoliza").val(datos["NombreFotoPoliza"]);
                $("#idfotoFactura").val(datos["NombreFotoFactura"]);
      
                if(datos["TieneNumeroDeMotor"]=="Si"){
                  $("#inpNumeroDeMotor").show();
                  $('#inpNumeroDeMotor').val(datos["NumeroMotor"]);
                }
               if(datos["TieneNumeroDeMotor"]=="No"){
                  $("#selPaisOrigen").show();
                  $('#selPaisOrigen').empty().append('<option value="' + datos["idPais"] + '">' + datos["PaisDeOrigen"] +'</option>');
                }
                if(datos["tarjetaDeCirculacion"]=="Con Vigencia"){
                  $('#inpFechaDeIniciotarjeta').val(datos["fechainicioVigencia"]);
                  $('#inpFechaDeTerminotarjeta').val(datos["fechaTerminoVigencia"]);
                }
                if(datos["checkDMPT"]=="1"){
                  $("#DMPTotal").prop("checked",true);
                  $("#lblCantidadPerdidaTotal").show();
                  $("#inpCantidadPerdidaTotal").show();
                  $('#inpCantidadPerdidaTotal').val(datos["CantidadDMPT"]);
                }
                if(datos["CheckCristales"]=="1"){
                  $("#Cristales").prop("checked",true);
                  $("#lblAparadaCristales").show();
                  $("#selAparadaCristales").show();
                  $('#selAparadaCristales').empty().append('<option >' + datos["AmparoDeCristales"] +'</option>');
                }
                if(datos["AmparoDeCristales"]=="Si"){
                  $("#inpPorcentajeCristales").show();
                  $("#lblPorcentajeCristales").show();
                  $('#inpPorcentajeCristales').val(datos["Porcentajecristales"]);
                }if(datos["AmparoDeCristales"]=="No"){
                  $("#inpCantidadCristales").show();
                  $("#lblCantidadCristales").show();
                  $('#inpCantidadCristales').val(datos["CantidadCristales"]);
                }
                if(datos["checkDMPP"]=="1"){
                  $("#DMPParcial").prop("checked",true);
                  $("#lblCantidadPerdidaParcial").show();
                  $("#inpCantidadPerdidaParcial").show();
                  $('#inpCantidadPerdidaParcial').val(datos["CantidadDMPP"]);
                }
                if(datos["CheckProteccion"]=="1"){
                  $("#ProteccionLegal").prop("checked",true);
                  $("#lblAparadaProteccionLegal").show();
                  $("#selAparadaProteccionLegal").show();
                  $('#selAparadaProteccionLegal').empty().append('<option >' + datos["AmparoProteccion"] +'</option>');
                }
                if(datos["AmparoDeCristales"]=="Si"){
                  $("#lblPorcentajeProteccionLegal").show();
                  $("#inpPorcentajeProteccionLegal").show();
                  $('#inpPorcentajeProteccionLegal').val(datos["PorcentajeProteccion"]);
                }if(datos["AmparoDeCristales"]=="No"){
                  $("#lblCantidadProteccionLegal").show();
                  $("#inpCantidadProteccionLegal").show();
                  $('#inpCantidadProteccionLegal').val(datos["CantidadProteccion"]);
                }
                if(datos["CheckRobo"]=="1"){
                  $("#Robototal").prop("checked",true);
                  $("#lblCantidadRobototal").show();
                  $("#inpCantidadRobototal").show();
                  $('#inpCantidadRobototal').val(datos["CantidadRobo"]);
                }
                if(datos["CheckClub"]=="1"){
                  $("#Club").prop("checked",true);
                  $("#lblAparadaClub").show();
                  $("#selAparadaClub").show();
                  $('#selAparadaClub').empty().append('<option >' + datos["AmparoClub"] +'</option>');
                }
                if(datos["PorcentajeClub"]=="Si"){
                  $("#lblPorcentajeClub").show();
                  $("#inpPorcentajeClub").show();
                  $('#inpPorcentajeClub').val(datos["PorcentajeClub"]);
                }if(datos["AmparoDeCristales"]=="No"){
                  $("#lblCantidadClub").show();
                  $("#inpCantidadClub").show();
                  $('#inpCantidadClub').val(datos["CantidadClub"]); 
                }
                if(datos["CheckRCDAT"]=="1"){
                  $("#DanosATerceros").prop("checked",true);
                  $("#lblCantidadDanosATerceros").show();
                  $("#inpCantidadDanosATerceros").show();
                  $('#inpCantidadDanosATerceros').val(datos["CantidadRCDAT"]);               
                }
                if(datos["CheckGMO"]=="1"){
                  $("#GastosMedicos").prop("checked",true);
                  $("#lblCantidadGastosMedicos").show();
                  $("#inpCantidadGastosMedicos").show();
                  $('#inpCantidadGastosMedicos').val(datos["CantidadGMO"]);
                }
                if(datos["CheckAccidenteC"]=="1"){
                  $("#Accidentes").prop("checked",true);
                  $("#lblCantidadAccidentes").show();
                  $("#inpCantidadAccidentes").show();
                  $('#inpCantidadAccidentes').val(datos["CantidadAccidenteC"]);
                }
                if(datos["DCruz"]=="1"){
                   $("#DesarmadorC").prop("checked",true);
                }
                if(datos["DPlano"]=="1"){
                   $("#DesarmadorP").prop("checked",true);
                }
                if(datos["Cable"]=="1"){
                   $("#Cables").prop("checked",true);
                }
                if(datos["Senal"]=="1"){
                   $("#Senal").prop("checked",true);
                }
                if(datos["Cllaves"]=="1"){
                   $("#Llave").prop("checked",true);
                }
                if(datos["Llanta"]=="1"){
                   $("#Llanta").prop("checked",true);
                }
                if(datos["LaveCruz"]=="1"){
                   $("#CLlave").prop("checked",true);
                }
                if(datos["Gato"]=="1"){
                   $("#Gato").prop("checked",true);
                }

                if(datos["idTarjetaLlave"]=="1"){
                  $("#TarjetaLlave").prop("checked",true);
                  $("#lblNumeroTarjetaLLave").show();
                  $("#inpNumeroTarjetaLLave").show();
                  $('#inpNumeroTarjetaLLave').val(datos["NumeroTarjetaLlave"]);
                }
                if(datos["idTarjetaGasolina"]=="1"){
                  $("#TarjetaGasolina").prop("checked",true);
                  $("#lblNumeroTarjetaGasolina").show();
                  $("#inpNumeroTarjetaGasolina").show();
                  $('#inpNumeroTarjetaGasolina').val(datos["NumeroTarjetaGasolina"]);
                  $("#lblNIP").show();
                  $("#inpNIP").show();
                  $('#inpNIP').val(datos["NipTarjetaGasolina"]);
                }

                var extencionNombreFotoVehiculo=datos["NombreFotoVehiculo"].split(".");
                var extencionNombreFotoVehiculo1=extencionNombreFotoVehiculo[1];
                if(extencionNombreFotoVehiculo1=="pdf"){
                  var pdf="20200224_182044_23198d7dee715b681d8cebef96fdf67b8b4afe83.png";
                $("#fotoVehiculo").html ("<img style='margin:0 auto;' src='" + "uploads/ParqueVehicular/fotosvehiculos/" + pdf + "'/>");
                }else{
                $("#fotoVehiculo").html ("<img style='margin:0 auto;' src='" + "uploads/ParqueVehicular/fotosvehiculos/" + datos["NombreFotoVehiculo"] + "'/>");
                }
                var extencionNombreFotoTarjetaDeCirculacion=datos["NombreFotoTarjetaDeCirculacion"].split(".");
                var extencionNombreFotoTarjetaDeCirculacion1=extencionNombreFotoTarjetaDeCirculacion[1];
                if(extencionNombreFotoTarjetaDeCirculacion1=="pdf"){
                  var pdf="20200224_182055_23198d7dee715b681d8cebef96fdf67b8b4afe83.png";
                $("#fotoTarjeta").html ("<img style='margin:0 auto;' src='" + "uploads/ParqueVehicular/fotostarjetacirculacion/" + pdf + "'/>");
                }
                else{
                $("#fotoTarjeta").html ("<img style='margin:0 auto;' src='" + "uploads/ParqueVehicular/fotostarjetacirculacion/" + datos["NombreFotoTarjetaDeCirculacion"] + "'/>");
                }
                var extencionNombreFotoPoliza=datos["NombreFotoPoliza"].split(".");
                var extencionNombreFotoPoliza1=extencionNombreFotoPoliza[1];
                if(extencionNombreFotoPoliza1=="pdf"){
                  var pdf="20200224_182103_23198d7dee715b681d8cebef96fdf67b8b4afe83.png";
                $("#fotoPoliza").html ("<img style='margin:0 auto;' src='" + "uploads/ParqueVehicular/fotospolizaseguros/" + pdf + "'/>");
                }
                else{
                $("#fotoPoliza").html ("<img style='margin:0 auto;' src='" + "uploads/ParqueVehicular/fotospolizaseguros/" + datos["NombreFotoPoliza"] + "'/>");
                }
                var extencionNombrefotoFactura=datos["NombreFotoFactura"].split(".");
                var extencionfotoFactura1=extencionNombrefotoFactura[1];
                if(extencionfotoFactura1=="pdf"){
                  var pdf="20200224_182112_23198d7dee715b681d8cebef96fdf67b8b4afe83.png";
                $("#fotoFactura").html ("<img style='margin:0 auto;' src='" + "uploads/ParqueVehicular/fotosfacturascarros/" + pdf + "'/>");
                }
                else{
                $("#fotoFactura").html ("<img style='margin:0 auto;' src='" + "uploads/ParqueVehicular/fotosfacturascarros/" + datos["NombreFotoFactura"] + "'/>");
              }
              }
              },

              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
  }

  function validarEdicionVehicular(){

    var numeroeconomicovalidacion= $("#numeroeconomicoconsulta").val();
    var selEngomado = $("#selEngomado").val();
    var selLineaDeNegocio = $("#selLineaDeNegocio").val(); 
    var selEntidad = $("#selEntidad").val();
    var selLineaDeNegocioHiden = $("#selLineaDeNegocioHiden").val();
    var selEntidadHiden = $("#selEntidadHiden").val();
    var numeroPlacas = $("#numeroPlacas").val();
    var seltarjetacirculacion = $("#seltarjetacirculacion").val();
    var inpFechaDeIniciotarjeta = $("#inpFechaDeIniciotarjeta").val();
    var inpFechaDeTerminotarjeta = $("#inpFechaDeTerminotarjeta").val();
    var selCuentaConNumeroMotro = $("#selCuentaConNumeroMotro").val();
    var inpNumeroDeMotor = $("#inpNumeroDeMotor").val();
    var selPaisOrigen = $("#selPaisOrigen").val();
    var inpNumeroPoliza = $("#inpNumeroPoliza").val();
    var selFechaIniciPoliza = $("#selFechaIniciPoliza").val();
    var selFechaFinPoliza = $("#selFechaFinPoliza").val();
    var idfotoTarjeta =$("#idfotoTarjeta").val();
    var idfotoPoliza =$("#idfotoPoliza").val();
    var idfotoFactura =$("#idfotoFactura").val();
    var inpNumeroTarjetaLLave = $("#inpNumeroTarjetaLLave").val();
    var inpNumeroTarjetaGasolina = $("#inpNumeroTarjetaGasolina").val();
    var inpNIP = $("#inpNIP").val();
    var selAseguradora = $("#selAseguradora").val();
    var selTipoDePoliza = $("#selTipoDePoliza").val();
    var colorengomadohiden = $("#colorengomadohiden").val();
    var numeroplacashiden = $("#numeroplacashiden").val();
    var tarjetchiden = $("#tarjetchiden").val();
    var fechainiciotarjetahiden = $("#fechainiciotarjetahiden").val();
    var fechaterminotarjetahiden = $("#fechaterminotarjetahiden").val();
    var selFechaIniciPolizaHiden = $("#selFechaIniciPolizaHiden").val();
    var selFechaFinPolizaHiden = $("#selFechaFinPolizaHiden").val();
    var tienemotorhiden = $("#tienemotorhiden").val();
    var numeromotrohiden = $("#numeromotrohiden").val();
    var inpFechaDeIniciotarjeta1= new Date (inpFechaDeIniciotarjeta);
    var inpFechaDeTerminotarjeta1= new Date (inpFechaDeTerminotarjeta);
    var selFechaIniciPoliza1= new Date (selFechaIniciPoliza);
    var selFechaFinPoliza1= new Date (selFechaFinPoliza);
    var inpNumeroTarjetaLLavehiden = $("#inpNumeroTarjetaLLavehiden").val();
    var inpNumeroTarjetaGasolinahiden = $("#inpNumeroTarjetaGasolinahiden").val();
    var inpNIPhiden = $("#inpNIPhiden").val();
    var selAseguradorahiden = $("#selAseguradorahiden").val();
    var selTipoDePolizahiden = $("#selTipoDePolizahiden").val();
    var TarjetaGasolina =$("#TarjetaGasolina").val();
    if(selPaisOrigen== null){
      $("#paishiden").val("null");
    }else{
    var paishiden = $("#paishiden").val();  
    }
    var numeropolizahiden = $("#numeropolizahiden").val();
    var fototarjetahiden = $("#fototarjetahiden").val();
    var fotopolizahiden = $("#fotopolizahiden").val();
    var fotofacturahiden = $("#fotofacturahiden").val();

  if(selFechaIniciPoliza =="" ||  selFechaIniciPoliza =="0" || selFechaFinPoliza =="" ||  selFechaFinPoliza =="0"){
      cargaerroresregistroVehicular('Ingresa La Fecha De Inicio y Fin de La Póliza');
  }else{
    if(selLineaDeNegocio == selLineaDeNegocioHiden && selEntidad ==selEntidadHiden && selEngomado == colorengomadohiden && numeroPlacas == numeroplacashiden && seltarjetacirculacion == tarjetchiden && inpFechaDeIniciotarjeta == fechainiciotarjetahiden && 
      inpFechaDeTerminotarjeta == fechaterminotarjetahiden && selCuentaConNumeroMotro == tienemotorhiden && 
      inpNumeroDeMotor == numeromotrohiden && selPaisOrigen == paishiden &&
      inpNumeroPoliza == numeropolizahiden && selFechaIniciPoliza == selFechaIniciPolizaHiden && selFechaFinPoliza == selFechaFinPolizaHiden &&
       idfotoTarjeta == fototarjetahiden && idfotoPoliza == fotopolizahiden && idfotoFactura == fotofacturahiden && inpNumeroTarjetaLLavehiden == inpNumeroTarjetaLLave && inpNumeroTarjetaGasolinahiden == inpNumeroTarjetaGasolina && inpNIPhiden == inpNIP && selAseguradorahiden == selAseguradora && selTipoDePolizahiden ==  selTipoDePoliza){

      alert("No Se Editó Ningun Campo, No Se Realizará ninguna Acción");
      var busqueda = $("#selBuscarVehiculo").val();
      if(busqueda=="1"){
        BuscarConNumeroDePlacas("2");
      }else{
        BuscarConNumeroDePlacas("1");
      }
      

    }else{
      
      if(selLineaDeNegocio =="" ||  selLineaDeNegocio =="0"){
        cargaerroresregistroVehicular('Seleccione La Linea De Negocio');
      }
      else if(selEntidad =="" ||  selEntidad =="0"){
        cargaerroresregistroVehicular('Seleccione La Entidad Federativa');
      }
      else if(selEngomado =="" ||  selEngomado =="0"){
        cargaerroresregistroVehicular('Seleccione El Color Del Engomado');
      }
      else if (numeroPlacas =="" ||  numeroPlacas =="0") {
      cargaerroresregistroVehicular('Ingrese El Numero De PLaca');
      }
      else if (seltarjetacirculacion =="" ||  seltarjetacirculacion =="0") {
      cargaerroresregistroVehicular('Seleccione El Tipo De La Tarjeta De Circulación');
      }
      else if (seltarjetacirculacion =="2" && inpFechaDeIniciotarjeta ==""){
      cargaerroresregistroVehicular('Ingrese La Fecha De Expedición De la Tarjeta De Circulación');
      }
      else if (seltarjetacirculacion =="2" && inpFechaDeTerminotarjeta ==""){
      cargaerroresregistroVehicular('Ingrese La Fecha De Termino De la Vigencia De La Tarjeta De Circulación');
      }
      else if (seltarjetacirculacion =="2" && inpFechaDeTerminotarjeta1<inpFechaDeIniciotarjeta1){
      cargaerroresregistroVehicular('La Fecha De Termino De Vigencia No Puede Ser Menor Que La Fecha De Expedición De la Tarjeta De Circulación');
      }
      else if ((selCuentaConNumeroMotro =="1" && inpNumeroDeMotor=="") || (selCuentaConNumeroMotro =="1" && !/^([A-Z-a-z-0-9])*$/.test(inpNumeroDeMotor)) || (selCuentaConNumeroMotro =="1" && inpNumeroDeMotor=="")) {
      cargaerroresregistroVehicular('Ingrese El numero De Motor Correcto Del Vehiculo (Debe Contener 11 Digitos Alfanumericos)');
      }
      else if (selCuentaConNumeroMotro =="2" && selPaisOrigen  =="" || selCuentaConNumeroMotro =="2" && selPaisOrigen  =="0" ) {
      cargaerroresregistroVehicular('Seleccione El Pais De Origen Del Vehiculo');
      }
      else if (inpNumeroPoliza=="" ||  inpNumeroPoliza=="0") {
      cargaerroresregistroVehicular('Ingrese El Numero De La Poliza'); 
      }
      else if (selFechaIniciPoliza=="" ||  selFechaIniciPoliza=="0") {
      cargaerroresregistroVehicular('Ingrese la Fecha Inicial De La Poliza');
      }
      else if (selFechaFinPoliza=="" ||  selFechaFinPoliza=="0") {
      cargaerroresregistroVehicular('Ingrese La Fecha Final De La Poliza');
      }
      else if (selFechaIniciPoliza1>selFechaFinPoliza1) {
      cargaerroresregistroVehicular('La Fecha de Inicio No Puede ser Mayor a La Fecha Final De La Póliza');
      }
      else if (selAseguradora=="" ||  selAseguradora=="0") {
      cargaerroresregistroVehicular('Seleccione Una Aseguradora De Seguro');
      }
      else if (selTipoDePoliza=="" ||  selTipoDePoliza=="0") {
      cargaerroresregistroVehicular('Seleccione El Tipo De Poliza');
      }
      else if (idfotoTarjeta=="" ||  idfotoTarjeta=="0") {
      cargaerroresregistroVehicular('Seleccione Una Foto o Archivo Correcto De La Tarjeta De Circulacion');
      }
      else if (idfotoPoliza=="" ||  idfotoPoliza=="0") {
      cargaerroresregistroVehicular('Seleccione Una Foto o Archivo Correcto De La Poliza del Seguro');
      }
      else if (idfotoFactura=="" ||  idfotoFactura=="0") {
      cargaerroresregistroVehicular('Seleccione Una Foto o Archivo Correcto De La Factura Del Vehiculo');
      }else if (TarjetaLlave=="1" && inpNumeroTarjetaLLave==""){
      cargaerroresregistroVehicular('Ingrese El Numero De La Tarjeta LLave Asiganda AL Vehiculo');
      }
      else if ((TarjetaGasolina=="1" && inpNumeroTarjetaGasolina=="")||(TarjetaGasolina=="1" && !/^([0-9])*$/.test(inpNumeroTarjetaGasolina)) ){
      cargaerroresregistroVehicular('Ingrese El Numero De La Tarjeta De Gasolina Asiganda AL Vehiculo (Solo Numeros)');
      }
      else if ((TarjetaGasolina=="1" && inpNIP=="")||(TarjetaGasolina=="1" && !/^([0-9])*$/.test(inpNIP)) ){
      cargaerroresregistroVehicular('Ingrese El NIP De La Tarjeta De Gasolina Asiganda AL Vehiculo (Solo Numeros)');
      }
      else
      {
        insertarHistoricoEdicion();
      }
    }
  } 
}
  
function guardaredicion(){
    var numeroeconomicoconsulta = $("#numeroeconomicoconsulta").val();
    var idfotoTarjeta =$("#idfotoTarjeta").val();
    var idfotoPoliza =$("#idfotoPoliza").val();
    var idfotoFactura =$("#idfotoFactura").val();

    datastring += "&idfotoTarjeta=" + idfotoTarjeta;  
    datastring += "&idfotoPoliza=" + idfotoPoliza;  
    datastring += "&idfotoFactura=" + idfotoFactura;  
    var datastring = $("#form_RegistrarVehiculo").serialize();
    //console.log(datastring);
    //alert(idfotoVehiculo);
    $.ajax({
      type: "POST",
      data: datastring,
      url: "ajax_ActualizarVehiculo.php",
      dataType: "json",
      success: function(response) {
        var mensaje=response.message; 
        var estatus=response.status;
        if (estatus=="success") {
          $("#banderachechs").val("");
          $('#mensajeserrorRegistroVehicular').fadeIn('slow');
          alertMsgregistrado="<div id='msgAlert' class='alert alert-success'><strong>Datos Gegerales</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#mensajeserrorRegistroVehicular").html(alertMsgregistrado);
          $(document).scrollTop(0);
          $('#mensajeserrorRegistroVehicular').delay(3000).fadeOut('slow');
            var busqueda = $("#selBuscarVehiculo").val();
            if(busqueda=="1"){
              BuscarConNumeroDePlacas("2");
            }else{
              BuscarConNumeroDePlacas("1");
            }
          }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }
  function insertarHistoricoEdicion(){

    var datastring = $("#form_RegistrarVehiculo").serialize();
    $.ajax({
      type: "POST",
      data: datastring,
      url: "ajax_InsertarHistoricoEdicionVehicular.php",
      dataType: "json",
      success: function(response) {
        var mensaje=response.message; 
        var estatus=response.status;
        if (estatus=="success") {
          // alert("historico insertado correctamente");
          guardaredicion();
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }
  function AbrirModalBaja(TipoOrden){
    var numeroeconomicoconsulta = $("#numeroeconomicoconsulta").val();
    var numeroPlacas = $("#numeroPlacas").val();
    var inpNumeroDeSerie = $("#inpNumeroDeSerie").val();
    $("#NumEcoBaja").val(numeroeconomicoconsulta);
    $("#numPlacasBaja").val(numeroPlacas);
    $("#NumSerieBaja").val(inpNumeroDeSerie);
    if(TipoOrden=="1"){
      $("#hojafiniquito").show();
      $("#DocFiniquito12").show();
      $("#cheque").show();
      $("#DocCheques12").show();
      $("#aplicarbaja").show();
      cargarSelectorMotivoBaja(TipoOrden);
      $("#motivobajaid").show();
      $("#motivoReingresoid").hide();
      $("#aplicarbaja").show();
      $("#aplicarreingeso").hide();
    }else{
      $("#hojafiniquito").hide();
      $("#DocFiniquito12").hide();
      $("#cheque").hide();
      $("#DocCheques12").hide();
      $("#aplicarreingeso").show();
      cargarSelectorMotivoBaja(TipoOrden);
      $("#motivobajaid").hide();
      $("#motivoReingresoid").show();
      $("#aplicarbaja").hide();
      $("#aplicarreingeso").show();
    }
    $("#modalDarDeBajaVehiculo").modal("show");
  }
  function cargarSelectorMotivoBaja(TipoSelector){
    $.ajax({
      type: "POST",
      data: {"TipoSelector" : TipoSelector},
      url: "ajax_getcatalogoMotivoBaja.php",
      dataType: "json",
      success: function(response) {
        //console.log(response.placas);
        if(TipoSelector=="1"){
           $("#selMotivoBaja1212").empty().append('<option value="0">Motivo Baja</option>');
        }else{
           $("#selMotivoBaja1212").empty().append('<option value="0">Motivo De Alta</option>');
        }
       
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#selMotivoBaja1212').append('<option value="' + (response.datos[i].idBajaVehiculos) + '">' + response.datos[i].Descripcion + '</option>');
          }
        }else{
          alert("Error al cargar motivo de Baja");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }
  $("#selMotivoBaja1212").change(function() {
    $("#lblMotivoSiniestro").hide();
    $("#selMotivoSiniestro").hide();
      var selMotivoBaja1 = $("#selMotivoBaja1212").val();
      if(selMotivoBaja1=="2"){
          $.ajax({
              type: "POST",
              url: "ajax_getMotivoBajaSiniestro.php",
              data: {
                  "selMotivoBaja1": selMotivoBaja1
              },
              dataType: "json",
              success: function(response) {
                var datos = response.datos;
                //console.log(response);
                $('#selMotivoSiniestro').empty().append('<option value="0">Motivo Siniestro</option>');
                $.each(datos, function(i) {
                    $('#selMotivoSiniestro').append('<option value="' + response.datos[i].IdBajaSiniestro + '">' + response.datos[i].Descripcion +'</option>');
                  });
                $("#lblMotivoSiniestro").show();
                $("#selMotivoSiniestro").show();
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
      }
  });

function enviardocumentosbaja(){  
  var formData = new FormData($("#form_RegistrarVehiculo")[0]);   
  //hacemos la petición ajax  
  for (var value of formData.values()) {
    //console.log(value); 
  }       
  $.ajax({
    type: "POST",
    url: "upload_ArchivoBaja.php",
    data:formData,
    dataType: "json",
    cache: false,
    contentType: false,
    processData: false, 
    async:false,       
    //una vez finalizado correctamente
    success: function(response) {
    // console.log(response);
    var DocFiniquito= response.DocFiniquito;
    var DocCheque= response.DocCheque;
    $("#DocFiniquitoHiden").val(DocFiniquito);
    $("#DocChequesHiden").val(DocCheque);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  });
}
function DarBajaVehiculo(){
    var numeroeconomicoBaja = $("#numeroeconomicoconsulta").val();
    var selMotivoBaja1 = $("#selMotivoBaja1212").val();
    var selMotivoSiniestro1 = $("#selMotivoSiniestro").val();
    var numeroeconomicoconsulta1 = $("#numeroeconomicoconsulta").val();
    var numeroPlacas1 = $("#numeroPlacas").val();
    var inpNumeroDeSerie1 = $("#inpNumeroDeSerie").val();
    var ComentariosBaja1 = $("#ComentariosBaja").val();


    if(selMotivoBaja1=="0" || selMotivoBaja1==""){
      alert("Seleccione El Motivo De La Baja");
    }else if((selMotivoBaja1=="2" && selMotivoSiniestro1=="0") || (selMotivoBaja1=="2" && selMotivoSiniestro1=="")){
      alert("Seleccione El Motivo De Baja Por Siniestro");
    }
    else{
      enviardocumentosbaja();
      var DocFiniquitoHiden = $("#DocFiniquitoHiden").val();
      var DocChequesHiden = $("#DocChequesHiden").val();
      $("#aplicarbaja").hide();
      $.ajax({
      type: "POST",
      data: { "numeroeconomicoBaja" : numeroeconomicoBaja,"selMotivoBaja1" : selMotivoBaja1,"selMotivoSiniestro1" : selMotivoSiniestro1,
              "numeroeconomicoconsulta1" : numeroeconomicoconsulta1,"numeroPlacas1" : numeroPlacas1,"inpNumeroDeSerie1" : inpNumeroDeSerie1,"ComentariosBaja1" : ComentariosBaja1,"DocFiniquitoHiden" : DocFiniquitoHiden,"DocChequesHiden" : DocChequesHiden},
      url: "ajax_BajaVehiculo.php",
      dataType: "json",
      async:false,
      success: function(response) {
       
        var mensaje=response.message; 
        var estatus=response.status;
        if (estatus=="success") {
          
          $("#modalDarDeBajaVehiculo").modal("hide");
          BuscarConNumeroDePlacas(numeroeconomicoBaja);
          $('#mensajeserrorRegistroVehicular').fadeIn();
          alertMsgregistrado="<div id='msgAlert' class='alert alert-success'><strong>Datos Gegerales</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#mensajeserrorRegistroVehicular").html(alertMsgregistrado);
          $(document).scrollTop(0);
          $('#mensajeserrorRegistroVehicular').delay(3000).fadeOut('slow');
          $("#ComentariosBaja").val("");
          $("#lblMotivoSiniestro").hide();
          $("#selMotivoSiniestro").hide();
            }else{
              alert("error");
              $("#aplicarbaja").show();
            }

      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
        $("#aplicarbaja").show();
      }
    });
    }
  }

  function ReingresarVehiculo1(){
    $("#aplicarreingeso").hide();
    var numeroeconomicoReingreso2 = $("#numeroeconomicoconsulta").val();
    var selMotivoReingreso2 = $("#selMotivoBaja1212").val();
    var selMotivoSiniestro2 = $("#selMotivoSiniestro").val();
    var numeroPlacas2 = $("#numeroPlacas").val();
    var inpNumeroDeSerie2 = $("#inpNumeroDeSerie").val();
    var ComentariosBaja2 = $("#ComentariosBaja").val();
    $.ajax({
      type: "POST",
      data: {"numeroeconomicoReingreso2" : numeroeconomicoReingreso2,"selMotivoReingreso2" : selMotivoReingreso2,"selMotivoSiniestro2" : selMotivoSiniestro2,"numeroPlacas2" : numeroPlacas2,"inpNumeroDeSerie2" : inpNumeroDeSerie2,"ComentariosBaja2" : ComentariosBaja2},
      url: "ajax_ReingresarVehiculo.php",
      dataType: "json",
      success: function(response) {
        var mensaje=response.message; 
        var estatus=response.status;
        if (estatus=="success") {
          $("#modalDarDeBajaVehiculo").modal("hide");
          $("#ComentariosBaja").val("");
          editardatosconsulta();
          $('#mensajeserrorRegistroVehicular').fadeIn();
          alertMsgregistrado="<div id='msgAlert' class='alert alert-success'><strong>Datos Gegerales</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#mensajeserrorRegistroVehicular").html(alertMsgregistrado);
          $(document).scrollTop(0);
          $('#mensajeserrorRegistroVehicular').delay(3000).fadeOut('slow');

          // alert("Revise Los datos Del Vehiculo Y De Guardar");
          
         // BuscarConNumeroDePlacas(numeroeconomicoconsulta);
            }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
        $("#aplicarreingeso").show();
      }
    });
  }
  
/////////////**********Formulario De Registro Vehicular////////////*****************
  function bloquearylimpiarcamposdeinicio()
  {
    $("#guardarVehiculo").show();
    $("#editarVehiculo").hide();
    $("#guardaredicion").hide();
    $("#ReingresarVehiculo").hide();
    $("#DarDeBajaVehiculo").hide();
    $("#numeroeconomicoconsulta").hide();
    $("#labelnumeroeconomicoconsulta").hide();
    $("#EstatusVehiculoConsulta").hide();
    $("#labelEstatusVehiculoConsulta").hide();

    $("#inpCantidadPerdidaTotal").prop('readonly', false);
    $("#selAparadaCristales").prop('disabled', false);
    $("#inpPorcentajeCristales").prop('readonly', false);
    $("#inpCantidadCristales").prop('readonly', false);
    $("#inpCantidadPerdidaParcial").prop('readonly', false);
    $("#selAparadaProteccionLegal").prop('disabled', false);
    $("#inpPorcentajeProteccionLegal").prop('readonly', false);
    $("#inpCantidadProteccionLegal").prop('readonly', false);
    $("#inpCantidadRobototal").prop('readonly', false);
    $("#selAparadaClub").prop('disabled', false);
    $("#inpPorcentajeClub").prop('readonly', false);
    $("#inpCantidadClub").prop('readonly', false);
    $("#inpCantidadDanosATerceros").prop('readonly', false);
    $("#inpCantidadGastosMedicos").prop('readonly', false);
    $("#inpCantidadAccidentes").prop('readonly', false);
    $("#inpNumeroTarjetaLLave").prop('readonly', false);
    $("#inpNumeroTarjetaGasolina").prop('readonly', false);
    $("#inpNIP").prop('readonly', false);

    $("#selempresaexterno").prop('disabled', false);
    $("#selLineaDeNegocio").prop('disabled', false);
    $("#selPlacas").prop('disabled', false);
    $("#seltarjetacirculacion").prop('disabled', false);
    $("#selMarca").prop('disabled', true);
    $("#inpAnio").prop('readonly', false);
    $("#inpNumeroDeSerie").prop('readonly', false);
    $("#selCuentaConNumeroMotro").prop('disabled', false);
    $("#selVehiculoNuevoViejo").prop('disabled', false);
    $("#selCilindrosDelVehiculo").prop('disabled', false);
    $("#selAseguradora").prop('disabled', false);
    $("#filefotoVehiculo").show();
    $("#filefotoTarjeta").show();
    $("#filefotoPoliza").show();
    $("#filefotoFactura").show();

    $("#titulolgeneral").hide();
    $("#selBuscarVehiculo").hide();
    $("#BuscarVehiculo").hide();
    $("#inpDigiteNumeroPlaca").hide();
    $("#DigiteNumeroPlaca").hide();
    $("#inpDigiteNumeroEconomico").hide();
    $("#DigiteNumeroEconomico").hide();

    $("#DMPTotal").prop('disabled', true);
    $("#Cristales").prop('disabled', true);
    $("#DMPParcial").prop('disabled', true);
    $("#ProteccionLegal").prop('disabled', true);
    $("#Robototal").prop('disabled', true);
    $("#Club").prop('disabled', true);
    $("#DanosATerceros").prop('disabled', true);
    $("#GastosMedicos").prop('disabled', true);
    $("#Accidentes").prop('disabled', true);

    $("#lblCantidadPerdidaTotal").hide();
    $("#inpCantidadPerdidaTotal").hide();
    $("#lblAparadaCristales").hide();
    $("#selAparadaCristales").hide();
    $("#lblPorcentajeCristales").hide();
    $("#inpPorcentajeCristales").hide();
    $("#lblCantidadCristales").hide();
    $("#inpCantidadCristales").hide();
    $("#lblCantidadPerdidaParcial").hide();
    $("#inpCantidadPerdidaParcial").hide();
    $("#lblAparadaProteccionLegal").hide();
    $("#selAparadaProteccionLegal").hide();
    $("#lblPorcentajeProteccionLegal").hide();
    $("#inpPorcentajeProteccionLegal").hide();
    $("#lblCantidadProteccionLegal").hide();
    $("#inpCantidadProteccionLegal").hide();
    $("#lblCantidadRobototal").hide();
    $("#inpCantidadRobototal").hide();
    $("#lblAparadaClub").hide();
    $("#selAparadaClub").hide();
    $("#lblPorcentajeClub").hide();
    $("#inpPorcentajeClub").hide();
    $("#lblCantidadClub").hide();
    $("#inpCantidadClub").hide();
    $("#lblCantidadDanosATerceros").hide();
    $("#inpCantidadDanosATerceros").hide();
    $("#lblCantidadGastosMedicos").hide();
    $("#inpCantidadGastosMedicos").hide();
    $("#lblCantidadAccidentes").hide();
    $("#inpCantidadAccidentes").hide();
    $("#lblNumeroTarjetaLLave").hide();
    $("#inpNumeroTarjetaLLave").hide();
    $("#lblNumeroTarjetaGasolina").hide();
    $("#inpNumeroTarjetaGasolina").hide();
    $("#lblNIP").hide();
    $("#inpNIP").hide();


    $("#lblNumeroDeMotor").hide();
    $("#inpNumeroDeMotor").hide();
    $("#lblPaisOrigen").hide();
    $("#selPaisOrigen").hide();

    $("#selTipoDePoliza").prop('disabled', true);
    $('#selTipoDePoliza').empty();
    $("#inpFechaDeIniciotarjeta").prop('readonly', true);
    $("#inpFechaDeTerminotarjeta").prop('readonly', true);
    $('#inpCentimetrosCubicos').val("");
    $('#inpCentimetrosCubicos').prop('placeholder',"");
    $('#inpCentimetrosCubicos').prop('readonly', true);
    $("#fechaCompra").prop('disabled', true);
    $("#inpNumeroPoliza").prop('readonly', true);
    $("#selFechaIniciPoliza").prop('readonly',true);
    $("#selFechaFinPoliza").prop('readonly',true);
    $("#fechaingreso").prop('disabled', true);
    $('#selModalidad').empty();
    $('#selModalidad').prop('disabled', true);
    $('#selEngomado').empty();
    $('#selEngomado').prop('disabled', true);
    $('#numeroPlacas').val("");
    $('#numeroPlacas').prop('placeholder',"");
    $('#numeroPlacas').prop('readonly', true);
    $('#selModelo').empty();
    $('#selModelo').prop('disabled', true);
    $('#selTipoDeVehiculo').empty();
    $('#selTipoDeVehiculo').prop('disabled', false);
    $('#selColor').empty();
    $('#selColor').prop('disabled', true);
    $('#selEntidad').empty();
    $('#selEntidad').prop('disabled', true);
    $("#selLineaDeNegocio").empty();

    $("#DesarmadorC").prop('disabled', false);
    $("#DesarmadorP").prop('disabled', false);
    $("#Cables").prop('disabled', false);     
    $("#Senal").prop('disabled', false);     
    $("#Llave").prop('disabled', false);     
    $("#CLlave").prop('disabled', false); 
    $("#Llanta").prop('disabled', false);   
    $("#Gato").prop('disabled', false);
    $("#TarjetaLlave").prop('disabled', false);
    $("#TarjetaGasolina").prop('disabled', false);
    $("#inpNinguno").prop('disabled', false);

    $("#DesarmadorC").val("0");
    $("#DesarmadorP").val("0");
    $("#Cables").val("0");     
    $("#Senal").val("0");     
    $("#Llave").val("0");     
    $("#CLlave").val("0"); 
    $("#Llanta").val("0");   
    $("#Gato").val("0");
    $("#TarjetaLlave").val("0");  
    $("#TarjetaGasolina").val("0");
    $("#inpNinguno").val("0");

    $("#fotoVehiculo").val("");
    $("#idfotoVehiculo").val("");
    $("#filefotoVehiculo").val("");
    $("#fotoTarjeta").val("");
    $("#idfotoTarjeta").val("");
    $("#filefotoTarjeta").val("");
    $("#fotoPoliza").val("");
    $("#idfotoPoliza").val("");
    $("#filefotoPoliza").val("");
    $("#fotoFactura").val("");
    $("#idfotoFactura").val("");
    $("#filefotoFactura").val("");
    CargarFotoFactura();
    CargarFotoPoliza();
    CargarFotoTarjeta();
    CargarFotoCarro();
  }
  function getcatplacastipodeservicio(){
    $.ajax({
      type: "POST",
      url: "ajax_getcatalogoplacas.php",
      dataType: "json",
      success: function(response) {
        //console.log(response.placas);
        $("#selPlacas").empty();
        $('#selPlacas').append('<option value="0">Placas</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.placas.length; i++)
          {
            $('#selPlacas').append('<option value="' + (response.placas[i].idPlacas) + '">' + response.placas[i].TipoDeServicio + '</option>');
          }
        }else{
          alert("Error al cargar placas");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }

  $("#selPlacas").change(function() {

      $('#numeroPlacas').val("");
      $('#numeroPlacas').prop('placeholder',"");
      $('#numeroPlacas').prop('readonly', true);
      $('#selEngomado').empty();
      $('#selEngomado').prop('disabled', true);
      var valorselectorplacas = $("#selPlacas").val();
      if (valorselectorplacas != 0 && valorselectorplacas != "Placas") {
          $.ajax({
              type: "POST",
              url: "ajax_getmodalidadplacas.php",
              data: {
                  "valorselectorplacas": valorselectorplacas
              },
              dataType: "json",
              success: function(response) {
                var datos = response.datos;
                //console.log(response);
                $('#selModalidad').empty();
                $('#selModalidad').prop('disabled', false);
                $('#selModalidad').empty().append('<option value="0">Modalidad</option>');
                $.each(datos, function(i) {
                    $('#selModalidad').append('<option value="' + response.datos[i].idModalidadDePlacas + '">' + response.datos[i].DesacripcionDeModalidad +'</option>');
                      
                  });
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
      } else {

        $('#selModalidad').prop('disabled', true);
      }
  });
  $("#selModalidad").change(function() {
      var valorselectomodalidad = $("#selModalidad").val();
      if (valorselectomodalidad != 0 && valorselectomodalidad != "Modalidad") {
          $.ajax({
              type: "POST",
              url: "ajax_getestructuradeplaca.php",
              data: {
                  "valorselectomodalidad": valorselectomodalidad
              },
              dataType: "json",
              success: function(response) {
                  var datos = response.datos;
                  //console.log(response);
                  $('#numeroPlacas').prop('readonly', false);
                  $('#numeroPlacas').prop('placeholder',""+response.datos[0].OrdenDeCaracteres);
                  getcolorvehiculoengomado(1);
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
      } else {
        $('#selEngomado').empty();
        $('#selEngomado').prop('disabled', true);
        $('#selModalidad').prop('readonly', true);
        $('#numeroPlacas').val("");
        $('#numeroPlacas').prop('placeholder'," ");
        $('#numeroPlacas').prop('readonly', true);
      }
  });     

    function getcolorvehiculoengomado(caso){
    $.ajax({
      type: "POST",
      url: "ajax_getcatalogocolor.php",
      data: {"caso": caso},
      dataType: "json",
      async: false,
      success: function(response) {
        //console.log(response.datos);
        $('#selEngomado').empty().append('<option value="0">Color Engomado</option>');
        $('#selEngomado').prop('disabled', false);
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#selEngomado').append('<option value="' + (response.datos[i].idcolor) + '">' + response.datos[i].Descripcion + '</option>');
          }
        }else{
          alert("Error al cargar Colores Del Engomado");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }

   function getcattarjetacirculacion(){
    $.ajax({
      type: "POST",
      url: "ajax_getcatalogotarjeta.php",
      dataType: "json",
      async: false,
      success: function(response) {
        //console.log(response.datos);
        $("#seltarjetacirculacion").empty(); 
        $('#seltarjetacirculacion').append('<option value="0">Tarjeta Circulacion</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#seltarjetacirculacion').append('<option value="' + (response.datos[i].idtarjetaC) + '">' + response.datos[i].Descripcion + '</option>');
          }
        }else{
          alert("Error al cargar el tipo de tarjeta de circulación");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }

$("#seltarjetacirculacion").change(function() {

    var valorselectortarjeta = $("#seltarjetacirculacion").val();
      if (valorselectortarjeta ==("2")) {
        $("#inpFechaDeIniciotarjeta").prop('readonly', false);
        $("#inpFechaDeTerminotarjeta").prop('readonly', false);
      } else {
        $("#inpFechaDeIniciotarjeta").prop('readonly', true);
        $("#inpFechaDeIniciotarjeta").val("");
        $("#inpFechaDeTerminotarjeta").prop('readonly', true);
        $("#inpFechaDeTerminotarjeta").val("");
      }

  });
  function gettipodevehiculo(){
    $.ajax({
        type: "POST",
        url: "ajax_getcatalogotipovehiculo.php",
        dataType: "json",
        success: function(response) {
                  var datos = response.datos;
                  //console.log(response);
                  $('#selTipoDeVehiculo').empty();
                  $('#selTipoDeVehiculo').prop('disabled', false);
                  $('#selTipoDeVehiculo').empty().append('<option value="0">Tipo De Vehiculo</option>');
                  $.each(datos, function(i) {
                      $('#selTipoDeVehiculo').append('<option value="' + response.datos[i].idTipoDeVehiculo + '">' + response.datos[i].Descripcion +'</option>');    
                  });
              },
        error: function(jqXHR, textStatus, errorThrown){
          alert(jqXHR.responseText);
        }
        });
  }
  $("#selTipoDeVehiculo").change(function() {
        $('#selMarca').empty();
        $('#selMarca').prop('disabled', true);
        $('#selModelo').empty();
        $('#selModelo').prop('disabled', true);
        $('#selColor').empty();
        $('#selColor').prop('disabled', true);
      var valorselectorTipoDeVehiculo = $("#selTipoDeVehiculo").val();

      if (valorselectorTipoDeVehiculo != 0 && valorselectorTipoDeVehiculo != "Tipo De Vehiculo") {
        $.ajax({
      type: "POST",
      url: "ajax_getcatalogomarca.php",
      data: {
                  "valorselectorTipoDeVehiculo": valorselectorTipoDeVehiculo
              },
      dataType: "json",
      success: function(response) {
        //console.log(response.datos);
        $("#selMarca").empty();  
        $('#selMarca').append('<option value="0">Marca</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#selMarca').append('<option value="' + (response.datos[i].idMarca) + '">' + response.datos[i].Marca + '</option>');
          }
          $('#selMarca').prop('disabled', false);
        }else{
          alert("Error al cargar Modelos");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
      }
  });

  $("#selMarca").change(function() {

    $('#selModelo').empty();
    $('#selModelo').prop('disabled', true);
    $('#selColor').empty();
    $('#selColor').prop('disabled', true);
    var valorselectormarca = $("#selMarca").val();
      if (valorselectormarca != 0 && valorselectormarca != "Marca") {
          $.ajax({
              type: "POST",
              url: "ajax_getmodeloxmarca.php",
              data: {
                  "valorselectormarca": valorselectormarca
              },
              dataType: "json",
              success: function(response) {
                  var datos = response.datos;
                  //console.log(response);
                  $('#selModelo').prop('disabled', false);
                  $('#selModelo').empty().append('<option value="0">Modelo</option>');
                  $.each(datos, function(i) {
                      $('#selModelo').append('<option value="' + response.datos[i].idModelo + '">' + response.datos[i].Modelo +'</option>');    
                  });
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
      }
  });
    $("#selModelo").change(function() {
      $('#selColor').empty();
      $('#selColor').prop('disabled', true);
      var valorselectormodelo = $("#selModelo").val();
      if (valorselectormodelo != 0 && valorselectormodelo != "Modelo") {
      getcolorvehiculo(0);
      }
      });

  function getcolorvehiculo(caso){
    $.ajax({
      type: "POST",
      url: "ajax_getcatalogocolor.php",
      data: {"caso": caso},
      dataType: "json",
      success: function(response) {
        //console.log(response.datos);
        $('#selColor').empty();
        $('#selColor').prop('disabled', false);
        $('#selColor').append('<option value="0">Color Del Vehiculo</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#selColor').append('<option value="' + (response.datos[i].idcolor) + '">' + response.datos[i].Descripcion + '</option>');
          }
        }else{
          alert("Error al cargar Colores");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }

    function getcatnummotor(){
      $.ajax({
      type: "POST",
      url: "ajax_getcatalognummotor.php",
      dataType: "json",
      async: false,
      success: function(response) {
        //console.log(response.datos); 
        $("#selCuentaConNumeroMotro").empty();
        $('#selCuentaConNumeroMotro').append('<option value="0">Numero De Motor</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#selCuentaConNumeroMotro').append('<option value="' + (response.datos[i].idnumeroMotor) + '">' + response.datos[i].Descripcion + '</option>');
          }
        }else{
          alert("Error Al Cargar Opciones Del Numero De Motor");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }

  $("#selCuentaConNumeroMotro").change(function() {
    var valorselectornumeromotor = $("#selCuentaConNumeroMotro").val();
      if (valorselectornumeromotor !=("0")) {

        if(valorselectornumeromotor==("1")){

          $("#lblPaisOrigen").hide();
          $("#selPaisOrigen").hide();
          $("#selPaisOrigen").empty();
          $("#lblNumeroDeMotor").show();
          $("#inpNumeroDeMotor").show();
          $("#inpNumeroDeMotor").prop("readonly",false);

        }else if(valorselectornumeromotor==("2")){
          $("#lblNumeroDeMotor").hide();
          $("#inpNumeroDeMotor").hide();
          $("#inpNumeroDeMotor").val("");
          $("#lblPaisOrigen").show();
          $("#selPaisOrigen").show();
          $("#selPaisOrigen").prop("disabled",false);
          CargarCatPaises();
        }

      } else {
        $("#lblNumeroDeMotor").hide();
        $("#inpNumeroDeMotor").hide();
        $("#inpNumeroDeMotor").val("");
        $("#lblPaisOrigen").hide();
        $("#selPaisOrigen").hide();
        $("#selPaisOrigen").empty();
      }
  });
  function CargarCatPaises(){
    
    $.ajax({
      type: "POST",
      url: "ajax_getcatalogpaises.php",
      dataType: "json",
      success: function(response) {
        $("#selPaisOrigen").empty();
        //console.log(response.datos);
        $('#selPaisOrigen').append('<option value="0">País De Origen</option>');
        if (response.status == "success")
        {
          for (var i = 1; i < response.datos.length; i++)
          {
            $('#selPaisOrigen').append('<option value="' + (response.datos[i].idPais) + '">' + response.datos[i].      nombrePais + '</option>');
          }
        }else{
          alert("Error Al Cargar Opciones El Catalogo De Países");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
      }
    });}

  function getcatestadovehiculo(){ 
    $.ajax({
      type: "POST",
      url: "ajax_getcatalogoestadovehiculo.php",
      dataType: "json",
      success: function(response) {
        //console.log(response.datos);
        $("#selVehiculoNuevoViejo").empty();  
        $('#selVehiculoNuevoViejo').append('<option value="0">Estado Del Vehiculo</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#selVehiculoNuevoViejo').append('<option value="' + (response.datos[i].idestadovehiculo) + '">' + response.datos[i].Descripcion + '</option>');
          }
        }else{
          alert("Error Al Cargar Opciones Del Estado Del Vehiculo");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }

  $("#selVehiculoNuevoViejo").change(function() {

    var valorselectorVehiculoNuevoViejo = $("#selVehiculoNuevoViejo").val();
      if (valorselectorVehiculoNuevoViejo !="0"  && valorselectorVehiculoNuevoViejo != "Estado Del Vehiculo") {

        $("#fechaCompra").prop('disabled', false);

      } else {
        $("#fechaCompra").prop('disabled', true);
        $("#fechaCompra").val("");
      }
  });

    function getcatestadocilindadavehiculo(){ 
    $.ajax({
      type: "POST",
      url: "ajax_getcatalogocilindrosvehiculos.php",
      dataType: "json",
      success: function(response) {
        //console.log(response.datos);
        $("#selCilindrosDelVehiculo").empty();   
        $('#selCilindrosDelVehiculo').append('<option value="0">Cilindros</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#selCilindrosDelVehiculo').append('<option value="' + (response.datos[i].idCilindos) + '">' + response.datos[i].Descripcion + '</option>');
          }
        }else{
          alert("Error Al Cargar los Cilindros Del Vehiculo");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }

  $("#selCilindrosDelVehiculo").change(function() {
    $('#inpCentimetrosCubicos').prop('placeholder',"");
    $('#inpCentimetrosCubicos').val("");
    $('#inpCentimetrosCubicos').prop('readonly', true);

    var valorselectorCilindrosDelVehiculo = $("#selCilindrosDelVehiculo").val();
      if (valorselectorCilindrosDelVehiculo !="0"  && valorselectorCilindrosDelVehiculo != "Cilindros") {

        $('#inpCentimetrosCubicos').prop('placeholder',"Ejemplo 1.6");
        $('#inpCentimetrosCubicos').prop('readonly', false);

      }
  });

    function getcataseguradoras(){
    $.ajax({
      type: "POST",
      url: "ajax_getcatalogoaseguradoras.php",
      dataType: "json",
      async : false,
      success: function(response) {
        //console.log(response.datos);
        $("#selAseguradora").empty().append('<option value="0">Aseguradora</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#selAseguradora').append('<option value="' + (response.datos[i].idaseguradora) + '">' + response.datos[i].Descripcion + '</option>');
          }
        }else{
          alert("Error Al Cargar El Catalogo De Aseguradoras");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }

   $("#selAseguradora").change(function() {
    var bandera =$("#banderachechs").val();
    //alert(bandera);
    if(bandera!="1"){
      bloquearchecks();
    }
    $("#inpNumeroPoliza").prop('readonly', true);
    $('#inpNumeroPoliza').val("");
    $("#selFechaIniciPoliza").prop('readonly',true);
    $("#selFechaIniciPoliza").val("");
    $("#selFechaFinPoliza").prop('readonly',true);
    $("#selFechaFinPoliza").val("");
    var valorselectorAseguradora = $("#selAseguradora").val();
    if (valorselectorAseguradora != 0 && valorselectorAseguradora != "Aseguradora") {
      $.ajax({
        type: "POST",
        url: "ajax_getcatalogotipocobertura.php",
        dataType: "json",
        success: function(response) {
          var datos = response.datos;
         //console.log(response);
          $('#selTipoDePoliza').empty();
          $('#selTipoDePoliza').prop('disabled', false);
          $('#selTipoDePoliza').empty().append('<option value="0">Tipo De Cobertura</option>');
          $.each(datos, function(i) {
            $('#selTipoDePoliza').append('<option value="' + response.datos[i].idTipoCobertura + '">' + response.datos[i].Descripcion +'</option>') 
            });
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
        }
      });
    } else {     
        $('#selTipoDePoliza').prop('disabled', true);
      }
  });

  $("#selTipoDePoliza").change(function() {

    var valorselectorTipoDePoliza = $("#selTipoDePoliza").val();
      if (valorselectorTipoDePoliza !="0"  && valorselectorTipoDePoliza != "Tipo De Cobertura") {

        $("#inpNumeroPoliza").prop('readonly', false);
        $("#selFechaIniciPoliza").prop('readonly',false);
        $("#selFechaFinPoliza").prop('readonly',false);
        desbloquearchecks();

      } else {
        bloquearchecks();
        $("#inpNumeroPoliza").prop('readonly', true);
        $("#inpNumeroPoliza").val("");
        $("#selFechaIniciPoliza").prop('readonly',true);
        $("#selFechaIniciPoliza").val("");
        $("#selFechaFinPoliza").prop('readonly',true);
        $("#selFechaFinPoliza").val("");
      }
  });

    function desbloquearchecks(){

    $("#DMPTotal").prop('disabled', false);
    $("#Cristales").prop('disabled', false);
    $("#DMPParcial").prop('disabled', false);
    $("#ProteccionLegal").prop('disabled', false);
    $("#Robototal").prop('disabled', false);
    $("#Club").prop('disabled', false);
    $("#DanosATerceros").prop('disabled', false);
    $("#GastosMedicos").prop('disabled', false);
    $("#Accidentes").prop('disabled', false);
    }
    function bloquearchecks(){
    
    $("#DMPTotal").prop("checked", false);  
    $("#Cristales").prop("checked", false);  
    $("#DMPParcial").prop("checked", false);  
    $("#ProteccionLegal").prop("checked", false);  
    $("#Robototal").prop("checked", false);  
    $("#Club").prop("checked", false);  
    $("#DanosATerceros").prop("checked", false);  
    $("#GastosMedicos").prop("checked", false);  
    $("#Accidentes").prop("checked", false);  
    $("#DMPTotal").prop('disabled', true);
    $("#Cristales").prop('disabled', true);
    $("#DMPParcial").prop('disabled', true);
    $("#ProteccionLegal").prop('disabled', true);
    $("#Robototal").prop('disabled', true);
    $("#Club").prop('disabled', true);
    $("#DanosATerceros").prop('disabled', true);
    $("#GastosMedicos").prop('disabled', true);
    $("#Accidentes").prop('disabled', true);

    $("#lblCantidadPerdidaTotal").hide();
    $("#inpCantidadPerdidaTotal").hide();
    $("#lblAparadaCristales").hide();
    $("#selAparadaCristales").hide();
    $("#lblPorcentajeCristales").hide();
    $("#inpPorcentajeCristales").hide();
    $("#lblCantidadCristales").hide();
    $("#inpCantidadCristales").hide();
    $("#lblCantidadPerdidaParcial").hide();
    $("#inpCantidadPerdidaParcial").hide();
    $("#lblAparadaProteccionLegal").hide();
    $("#selAparadaProteccionLegal").hide();
    $("#lblPorcentajeProteccionLegal").hide();
    $("#inpPorcentajeProteccionLegal").hide();
    $("#lblCantidadProteccionLegal").hide();
    $("#inpCantidadProteccionLegal").hide();
    $("#lblCantidadRobototal").hide();
    $("#inpCantidadRobototal").hide();
    $("#lblAparadaClub").hide();
    $("#selAparadaClub").hide();
    $("#lblPorcentajeClub").hide();
    $("#inpPorcentajeClub").hide();
    $("#lblCantidadClub").hide();
    $("#inpCantidadClub").hide();
    $("#lblCantidadDanosATerceros").hide();
    $("#inpCantidadDanosATerceros").hide();
    $("#lblCantidadGastosMedicos").hide();
    $("#inpCantidadGastosMedicos").hide();
    $("#lblCantidadAccidentes").hide();
    $("#inpCantidadAccidentes").hide();
    $("#lblNumeroTarjetaLLave").hide();  
    $("#inpNumeroTarjetaLLave").hide();      
    $("#lblNumeroTarjetaGasolina").hide();      
    $("#inpNumeroTarjetaGasolina").hide();      
    $("#lblNIP").hide();      
    $("#inpNIP").hide();      


    $("#inpCantidadPerdidaTotal").val("");
    $("#selAparadaCristales").empty();
    $("#inpPorcentajeCristales").val("");
    $("#inpCantidadCristales").val("");
    $("#inpCantidadPerdidaParcial").val("");
    $("#selAparadaProteccionLegal").empty();
    $("#inpPorcentajeProteccionLegal").val("");
    $("#inpCantidadProteccionLegal").val("");
    $("#inpCantidadRobototal").val("");
    $("#selAparadaClub").empty();
    $("#inpPorcentajeClub").val("");
    $("#inpCantidadClub").val("");
    $("#inpCantidadDanosATerceros").val("");
    $("#inpCantidadGastosMedicos").val("");
    $("#inpCantidadAccidentes").val("");
    $("#inpNumeroTarjetaLLave").val("");
    $("#inpNumeroTarjetaGasolina").val("");
    $("#inpNIP").val("");

    $("#DMPTotal").val("0");
    $("#Cristales").val("0");  
    $("#DMPParcial").val("0");  
    $("#ProteccionLegal").val("0");  
    $("#Robototal").val("0");  
    $("#Club").val("0"); 
    $("#DanosATerceros").val("0"); 
    $("#GastosMedicos").val("0");  
    $("#Accidentes").val("0");  

    }

  $('#DMPTotal').change(function() {
    if($('#DMPTotal').is(":checked")) {
      $('#DMPTotal').val(1);
      $('#lblCantidadPerdidaTotal').show();
      $('#inpCantidadPerdidaTotal').show();
    } 
    else {
      $('#DMPTotal').val(0);
      $('#inpCantidadPerdidaTotal').val("");
      $('#lblCantidadPerdidaTotal').hide();
      $('#inpCantidadPerdidaTotal').hide();
    }
  });

    $('#Cristales').change(function() {
    if($('#Cristales').is(":checked")) {
      $('#Cristales').val(1);
      $('#lblAparadaCristales').show();
      $('#selAparadaCristales').show();
      $.ajax({
      type: "POST",
      url: "ajax_getcatalognummotor.php",
      dataType: "json",
      success: function(response) {
        //console.log(response.datos);
        $('#selAparadaCristales').empty();
        $("#selAparadaCristales").empty();
        $('#selAparadaCristales').append('<option value="0">Amparada</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#selAparadaCristales').append('<option value="' + (response.datos[i].idnumeroMotor) + '">' + response.datos[i].Descripcion + '</option>');
          }
        }else{
          alert("Error Al Cargar Opciones Del La Aseguradora");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
    } 
    else {
      $('#Cristales').val(0);
      $("#selAparadaCristales").empty();
      $('#inpPorcentajeCristales').val("");
      $('#inpCantidadCristales').val("");
      $('#lblAparadaCristales').hide();
      $('#selAparadaCristales').hide();
      $('#lblPorcentajeCristales').hide();
      $('#inpPorcentajeCristales').hide();
      $('#lblCantidadCristales').hide();
      $('#inpCantidadCristales').hide();
    }
  });

    $("#selAparadaCristales").change(function() {

        $('#lblPorcentajeCristales').hide();
        $('#inpPorcentajeCristales').hide();
        $("#inpPorcentajeCristales").val("");
        $('#lblCantidadCristales').hide();
        $('#inpCantidadCristales').hide();
        $("#inpCantidadCristales").val("");

    var valorselectoAparadaCristales = $("#selAparadaCristales").val();
      if (valorselectoAparadaCristales !="0"  && valorselectoAparadaCristales != "Amparada") {
        if(valorselectoAparadaCristales=="1"){

          $('#lblPorcentajeCristales').show();
          $('#inpPorcentajeCristales').show();

        }else if(valorselectoAparadaCristales=="2"){

          $('#lblCantidadCristales').show();
          $('#inpCantidadCristales').show();

        }
      } else {

      }
  });

    $('#DMPParcial').change(function() {
    if($('#DMPParcial').is(":checked")) {
      $('#DMPParcial').val(1);
      $('#lblCantidadPerdidaParcial').show();
      $('#inpCantidadPerdidaParcial').show();
    } 
    else {
      $('#DMPParcial').val(0);
      $('#inpCantidadPerdidaParcial').val("");
      $('#lblCantidadPerdidaParcial').hide();
      $('#inpCantidadPerdidaParcial').hide();
    }
  });

      $('#ProteccionLegal').change(function() {
    if($('#ProteccionLegal').is(":checked")) {
      $('#ProteccionLegal').val(1);
      $('#lblAparadaProteccionLegal').show();
      $('#selAparadaProteccionLegal').show();
      $.ajax({
      type: "POST",
      url: "ajax_getcatalognummotor.php",
      dataType: "json",
      success: function(response) {
        //console.log(response.datos);
        $("#selAparadaProteccionLegal").empty();
        $('#selAparadaProteccionLegal').append('<option value="0">Amparada</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#selAparadaProteccionLegal').append('<option value="' + (response.datos[i].idnumeroMotor) + '">' + response.datos[i].Descripcion + '</option>');
          }
        }else{
          alert("Error Al Cargar Opciones Del La Aseguradora");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
    } 
    else {
      $('#ProteccionLegal').val(0);
      $("#selAparadaProteccionLegal").empty();
      $('#inpPorcentajeProteccionLegal').val("");
      $('#inpCantidadProteccionLegal').val("");
      $('#lblAparadaProteccionLegal').hide();
      $('#selAparadaProteccionLegal').hide();
      $('#lblPorcentajeProteccionLegal').hide();
      $('#inpPorcentajeProteccionLegal').hide();
      $('#lblCantidadProteccionLegal').hide();
      $('#inpCantidadProteccionLegal').hide();
    }
  });

  $("#selAparadaProteccionLegal").change(function() {

        $('#lblPorcentajeProteccionLegal').hide();
        $('#inpPorcentajeProteccionLegal').hide();
        $("#inpPorcentajeProteccionLegal").val("");
        $('#lblCantidadProteccionLegal').hide();
        $('#inpCantidadProteccionLegal').hide();
        $("#inpCantidadProteccionLegal").val("");

    var valorselectoProteccionLegal = $("#selAparadaProteccionLegal").val();
      if (valorselectoProteccionLegal !="0"  && valorselectoProteccionLegal != "Amparada") {
        if(valorselectoProteccionLegal=="1"){

          $('#lblPorcentajeProteccionLegal').show();
          $('#inpPorcentajeProteccionLegal').show();

        }else if(valorselectoProteccionLegal=="2"){

          $('#lblCantidadProteccionLegal').show();
          $('#inpCantidadProteccionLegal').show();

        }
      }
  });

    $('#Robototal').change(function() {
    if($('#Robototal').is(":checked")) {
      $('#Robototal').val(1);
      $('#lblCantidadRobototal').show();
      $('#inpCantidadRobototal').show();
    } 
    else {
      $('#Robototal').val(0);
      $('#inpCantidadRobototal').val("");
      $('#lblCantidadRobototal').hide();
      $('#inpCantidadRobototal').hide();
    }
  });

  $('#Club').change(function() {
    if($('#Club').is(":checked")) {
      $('#Club').val(1);
      $('#lblAparadaClub').show();
      $('#selAparadaClub').show();
      $.ajax({
      type: "POST",
      url: "ajax_getcatalognummotor.php",
      dataType: "json",
      success: function(response) {
        //console.log(response.datos);
        $("#selAparadaClub").empty();
        $('#selAparadaClub').append('<option value="0">Amparada</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#selAparadaClub').append('<option value="' + (response.datos[i].idnumeroMotor) + '">' + response.datos[i].Descripcion + '</option>');
          }
        }else{
          alert("Error Al Cargar Opciones Del La Aseguradora");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
    } 
    else {
      $('#Club').val(0);
      $("#selAparadaClub").empty();
      $('#inpPorcentajeClub').val("");
      $('#inpCantidadClub').val("");
      $('#lblAparadaClub').hide();
      $('#selAparadaClub').hide();
      $('#lblPorcentajeClub').hide();
      $('#inpPorcentajeClub').hide();
      $('#lblCantidadClub').hide();
      $('#inpCantidadClub').hide();
    }
  });

  $("#selAparadaClub").change(function() {

        $('#lblPorcentajeClub').hide();
        $('#inpPorcentajeClub').hide();
        $("#inpPorcentajeClub").val("");
        $('#lblCantidadClub').hide();
        $('#inpCantidadClub').hide();
        $("#inpCantidadClub").val("");

    var valorselectoselAparadaClub = $("#selAparadaClub").val();
      if (valorselectoselAparadaClub !="0"  && valorselectoselAparadaClub != "Amparada") {
        if(valorselectoselAparadaClub=="1"){

          $('#lblPorcentajeClub').show();
          $('#inpPorcentajeClub').show();

        }else if(valorselectoselAparadaClub=="2"){

          $('#lblCantidadClub').show();
          $('#inpCantidadClub').show();

        }
      } else {

      }
  });

  $('#DanosATerceros').change(function() {
    if($('#DanosATerceros').is(":checked")) {
      $('#DanosATerceros').val(1);
      $('#lblCantidadDanosATerceros').show();
      $('#inpCantidadDanosATerceros').show();
    } 
    else {
      $('#DanosATerceros').val(0);
      $('#inpCantidadDanosATerceros').val("");
      $('#lblCantidadDanosATerceros').hide();
      $('#inpCantidadDanosATerceros').hide();
    }
  });

  $('#GastosMedicos').change(function() {
    if($('#GastosMedicos').is(":checked")) {
      $('#GastosMedicos').val(1);
      $('#lblCantidadGastosMedicos').show();
      $('#inpCantidadGastosMedicos').show();
    } 
    else {
      $('#GastosMedicos').val(0);
      $('#inpCantidadGastosMedicos').val("");
      $('#lblCantidadGastosMedicos').hide();
      $('#inpCantidadGastosMedicos').hide();
    }
  });

  $('#Accidentes').change(function() {
    if($('#Accidentes').is(":checked")) {
      $('#Accidentes').val(1);
      $('#lblCantidadAccidentes').show();
      $('#inpCantidadAccidentes').show();
    } 
    else {
      $('#Accidentes').val(0);
      $('#inpCantidadAccidentes').val("");
      $('#lblCantidadAccidentes').hide();
      $('#inpCantidadAccidentes').hide();
    }
  });

    $('#TarjetaLlave').change(function() {
    if($('#TarjetaLlave').is(":checked")) {
      $('#TarjetaLlave').val(1);
      $('#lblNumeroTarjetaLLave').show();
      $('#inpNumeroTarjetaLLave').show();
    } 
    else {
      $('#TarjetaLlave').val(0);
      $('#inpNumeroTarjetaLLave').val("");
      $('#lblNumeroTarjetaLLave').hide();
      $('#inpNumeroTarjetaLLave').hide();
    }
  });

    $('#TarjetaGasolina').change(function() {
    if($('#TarjetaGasolina').is(":checked")) {
      $('#TarjetaGasolina').val(1);
      $('#lblNumeroTarjetaGasolina').show();
      $('#inpNumeroTarjetaGasolina').show();
       $('#lblNIP').show();
      $('#inpNIP').show();
    } 
    else {
      $('#TarjetaGasolina').val(0);
      $('#inpNumeroTarjetaGasolina').val("");
      $('#inpNIP').val("");
      $('#lblNumeroTarjetaGasolina').hide();
      $('#inpNumeroTarjetaGasolina').hide();
      $('#lblNIP').hide();
      $('#inpNIP').hide();
    }
  });

  function getDestinoVehicular(){

    $.ajax({
      type: "POST",
      url: "ajax_getcatalogempresas.php",
      dataType: "json",
      success: function(response) {
        //console.log(response.datos);
        $("#selempresaexterno").empty(); 
        $('#selempresaexterno').append('<option value="0">Destino Del Vehiculo</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#selempresaexterno').append('<option value="' + (response.datos[i].idEmpresa) + '">' + response.datos[i].nombreEmpresa + '</option>');
          }
        }else{
          alert("Error Al Cargar Las Empresas");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }

  $("#selempresaexterno").change(function() {

    var valorselectorempresaexterno = $("#selempresaexterno").val();
      if (valorselectorempresaexterno !="0") {

        $("#fechaingreso").prop('disabled', false);

      } else {
        $("#fechaingreso").prop('disabled', true);
        $("#fechaingreso").val("");
      }
  });

  function CargarFotoCarro(){
  $("#fotoVehiculo").html ("<img style='margin:0 auto;' src='img/vehiculo.png'/>");
  var filefotoVehiculo = $("#filefotoVehiculo");
    filefotoVehiculo.fileinput({
        uploadUrl: "upload_fotoVehiculo.php", // server upload action
        uploadAsync: false,
        showUpload: false, // hide upload button
        showRemove: false, // hide remove button
        showPreview: false
    }).on("filebatchselected", function(event, files) {
        // trigger upload method immediately after files are selected
        filefotoVehiculo.fileinput("upload");
        
    }).on('filebatchuploadsuccess', function(event, data, previewId, index) {
      //console.log(data);
        var form = data.form, files = data.files, extra = data.extra,
            response = data.response, reader = data.reader, tipo= data.files[0].type;
        if (response.status == "error")
        {   
          alert(response.message);
            return;
        }
        if(tipo=="application/pdf"){
          var pdf="20200224_182044_23198d7dee715b681d8cebef96fdf67b8b4afe83.png";
        $("#fotoVehiculo").html ("<img style='margin:0 auto;' src='thumbs/" + pdf + "'/>");
        }else{
        $("#fotoVehiculo").html ("<img style='margin:0 auto;' src='thumbs/" + response.file + "'/>");
        }
    $("#idfotoVehiculo").val (response.file);
    });
  }
    function CargarFotoTarjeta(){
  $("#fotoTarjeta").html ("<img style='margin:0 auto;' src='img/vehiculo.png'/>");
  var filefotoTarjeta = $("#filefotoTarjeta");
    filefotoTarjeta.fileinput({
        uploadUrl: "upload_TarjetaCirculacion.php", // server upload action
        uploadAsync: false,
        showUpload: false, // hide upload button
        showRemove: false, // hide remove button
        showPreview: false
    }).on("filebatchselected", function(event, files) {
        // trigger upload method immediately after files are selected
        filefotoTarjeta.fileinput("upload");
    }).on('filebatchuploadsuccess', function(event, data, previewId, index) {
      //console.log(data);
        var form = data.form, files = data.files, extra = data.extra,
            response = data.response, reader = data.reader, tipo= data.files[0].type;

        if (response.status == "error")
        {
            alert(response.message);
            return;
        }
        if(tipo=="application/pdf"){
          var pdf="20200224_182055_23198d7dee715b681d8cebef96fdf67b8b4afe83.png";
        $("#fotoTarjeta").html ("<img style='margin:0 auto;' src='thumbs/" + pdf + "'/>");
        }else{
        $("#fotoTarjeta").html ("<img style='margin:0 auto;' src='thumbs/" + response.file + "'/>");
        }
      $("#idfotoTarjeta").val (response.file);
    });
  }
    function CargarFotoPoliza(){
  $("#fotoPoliza").html ("<img style='margin:0 auto;' src='img/vehiculo.png'/>");
  var filefotoPoliza = $("#filefotoPoliza");
    filefotoPoliza.fileinput({
        uploadUrl: "upload_fotoPoliza.php", // server upload action
        uploadAsync: false,
        showUpload: false, // hide upload button
        showRemove: false, // hide remove button
        showPreview: false
    }).on("filebatchselected", function(event, files) {
        // trigger upload method immediately after files are selected
        filefotoPoliza.fileinput("upload");
    }).on('filebatchuploadsuccess', function(event, data, previewId, index) {
      //console.log(data);
        var form = data.form, files = data.files, extra = data.extra,
            response = data.response, reader = data.reader, tipo= data.files[0].type;

        if (response.status == "error")
        {
            alert(response.message);
            return;
        }
        if(tipo=="application/pdf"){
          var pdf="20200224_182103_23198d7dee715b681d8cebef96fdf67b8b4afe83.png";
        $("#fotoPoliza").html ("<img style='margin:0 auto;' src='thumbs/" + pdf + "'/>");
        }else{
        $("#fotoPoliza").html ("<img style='margin:0 auto;' src='thumbs/" + response.file + "'/>");
        }
    $("#idfotoPoliza").val (response.file);
    });
  }
    function CargarFotoFactura(){
  $("#fotoFactura").html ("<img style='margin:0 auto;' src='img/vehiculo.png'/>");
  var filefotoFactura = $("#filefotoFactura");
    filefotoFactura.fileinput({
        uploadUrl: "upload_fotoFactura.php", // server upload action
        uploadAsync: false,
        showUpload: false, // hide upload button
        showRemove: false, // hide remove button
        showPreview: false
    }).on("filebatchselected", function(event, files) {
        // trigger upload method immediately after files are selected
        filefotoFactura.fileinput("upload");
    }).on('filebatchuploadsuccess', function(event, data, previewId, index) {
      //console.log(data);
        var form = data.form, files = data.files, extra = data.extra,
            response = data.response, reader = data.reader, tipo= data.files[0].type;

        if (response.status == "error")
        {
            alert(response.message);
            return;
        }
        if(tipo=="application/pdf"){
          var pdf="20200224_182112_23198d7dee715b681d8cebef96fdf67b8b4afe83.png";
        $("#fotoFactura").html ("<img style='margin:0 auto;' src='thumbs/" + pdf + "'/>");
        }else{
        $("#fotoFactura").html ("<img style='margin:0 auto;' src='thumbs/" + response.file + "'/>");
        }
    $("#idfotoFactura").val (response.file);
    });
  }

  function cargarLineaDeNegocio(){
    $.ajax({
      type: "POST",
      url: "ajax_getcatlineanegocio.php",
      dataType: "json",
      async : false,
      success: function(response) {
        //console.log(response.datos);
        $('#selLineaDeNegocio').empty().append('<option value="0">Linea De Negocio</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#selLineaDeNegocio').append('<option value="' + (response.datos[i].idLineaNegocio) + '">' + response.datos[i].descripcionLineaNegocio + '</option>');
          }
        }else{
          alert("Error al cargar Las Lineas De Negocio");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }  

      $("#selLineaDeNegocio").change(function() {
      var valorselectorlinea = $("#selLineaDeNegocio").val();
      if (valorselectorlinea != 0 && valorselectorlinea != "Linea De Negocio") {
        $('#selEntidad').empty();
        getentidades();
      } else {
      
        $('#selEntidad').empty();
        $('#selEntidad').prop('disabled', true);
      }
  });

    function getentidades(){
    $.ajax({
      type: "POST",
      url: "ajax_getcatalogoentidades.php",
      dataType: "json",
      async : false,
      success: function(response) {
        //console.log(response.datos);
        $('#selEntidad').empty().append('<option value="0">Entidades Federativas</option>');
        $('#selEntidad').prop('disabled', false);
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#selEntidad').append('<option value="' + (response.datos[i].idEntidadFederativa) + '">' + response.datos[i].nombreEntidadFederativa + '</option>');
          }
        }else{
          alert("Error al cargar Entidades Federativas");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }

  $('#inpNinguno').change(function() {
    if ($('#inpNinguno').is(":checked")) {
      $('#inpNinguno').val(1);
      $('#DesarmadorC').prop('disabled', true);
      $('#DesarmadorP').prop('disabled', true);
      $('#Cables').prop('disabled', true);
      $('#Senal').prop('disabled', true);
      $('#Llave').prop('disabled', true);
      $('#CLlave').prop('disabled', true);
      $('#Llanta').prop('disabled', true);
      $('#Gato').prop('disabled', true);
      $('#TarjetaLlave').prop('disabled', true);
      $('#TarjetaGasolina').prop('disabled', true);
    } 
    else {
      $('#inpNinguno').val(0);
      $('#DesarmadorC').prop('disabled', false);
      $('#DesarmadorP').prop('disabled', false);
      $('#Cables').prop('disabled', false);
      $('#Senal').prop('disabled', false);
      $('#Llave').prop('disabled', false);
      $('#CLlave').prop('disabled', false);
      $('#Llanta').prop('disabled', false);
      $('#Gato').prop('disabled', false);
      $('#TarjetaLlave').prop('disabled', false);
      $('#TarjetaGasolina').prop('disabled', false);
  }
  });

    $('#DesarmadorC').change(function() {
      var DesarmadorP =$("#DesarmadorP").val();
      var Cables =$("#Cables").val();
      var Senal =$("#Senal").val();
      var Llave =$("#Llave").val();
      var CLlave =$("#CLlave").val();
      var Llanta =$("#Llanta").val();
      var Gato =$("#Gato").val();

    if ($('#DesarmadorC').is(":checked")) {
      $('#DesarmadorC').val(1);
      $('#inpNinguno').prop('disabled', true);
      $('#inpNinguno').val("-1");
    }else{
      $('#DesarmadorC').val(0);
      if(DesarmadorP=="1" ||Cables=="1" ||Senal=="1" ||Llave=="1" ||Llanta=="1" ||Gato=="1" ||CLlave=="1")
      {
        $('#inpNinguno').prop('disabled', true);
      }else{
        $('#inpNinguno').prop('disabled', false);
        $('#inpNinguno').val(0);
      }
    }
  });

  $('#DesarmadorP').change(function() {
    var DesarmadorC =$("#DesarmadorC").val();
      var Cables =$("#Cables").val();
      var Senal =$("#Senal").val();
      var Llave =$("#Llave").val();
      var Llanta =$("#Llanta").val();
      var CLlave =$("#CLlave").val();
      var Gato =$("#Gato").val();

    if ($('#DesarmadorP').is(":checked")) {
      $('#DesarmadorP').val(1);
      $('#inpNinguno').prop('disabled', true);
      $('#inpNinguno').val("-1");
    }else{
      $('#DesarmadorP').val(0);
      if(DesarmadorC =="1" ||Cables=="1" ||Senal=="1" ||Llave=="1" ||Llanta=="1" ||Gato=="1"||CLlave=="1")
      {
        $('#inpNinguno').prop('disabled', true);
      }else{
        $('#inpNinguno').prop('disabled', false);
        $('#inpNinguno').val(0);
      }
    }
  });

    $('#Cables').change(function() {
      var DesarmadorC =$("#DesarmadorC").val();
      var DesarmadorP =$("#DesarmadorP").val();
      var Senal =$("#Senal").val();
      var Llave =$("#Llave").val();
      var Llanta =$("#Llanta").val();
      var CLlave =$("#CLlave").val();
      var Gato =$("#Gato").val();

    if ($('#Cables').is(":checked")) {
      $('#Cables').val(1);
      $('#inpNinguno').prop('disabled', true);
      $('#inpNinguno').val("-1");
    }else{
      $('#Cables').val(0);
      if(DesarmadorC =="1" ||DesarmadorP=="1" ||Senal=="1" ||Llave=="1" ||Llanta=="1" ||Gato=="1"||CLlave=="1")
      {
        $('#inpNinguno').prop('disabled', true);
      }else{
        $('#inpNinguno').prop('disabled', false);
        $('#inpNinguno').val(0);
      }
    }
  });

    $('#Senal').change(function() {
      var DesarmadorC =$("#DesarmadorC").val();
      var DesarmadorP =$("#DesarmadorP").val();
      var Cables =$("#Cables").val();
      var Llave =$("#Llave").val();
      var Llanta =$("#Llanta").val();
      var CLlave =$("#CLlave").val();
      var Gato =$("#Gato").val();

    if ($('#Senal').is(":checked")) {
      $('#Senal').val(1);
      $('#inpNinguno').prop('disabled', true);
      $('#inpNinguno').val("-1");
    }else{
      $('#Senal').val(0);
      if(DesarmadorC =="1" ||DesarmadorP=="1" ||Cables=="1" ||Llave=="1" ||Llanta=="1" ||Gato=="1"||CLlave=="1")
      {
        $('#inpNinguno').prop('disabled', true);
      }else{
        $('#inpNinguno').prop('disabled', false);
        $('#inpNinguno').val(0);
      }
    }
  });

    $('#Llave').change(function() {
      var DesarmadorC =$("#DesarmadorC").val();
      var DesarmadorP =$("#DesarmadorP").val();
      var Cables =$("#Cables").val();
      var Senal =$("#Senal").val();
      var Llanta =$("#Llanta").val();
      var CLlave =$("#CLlave").val();
      var Gato =$("#Gato").val();

    if ($('#Llave').is(":checked")) {
      $('#Llave').val(1);
      $('#inpNinguno').prop('disabled', true);
      $('#inpNinguno').val("-1");
    }else{
      $('#Llave').val(0);
      if(DesarmadorC =="1" ||DesarmadorP=="1" ||Cables=="1" ||Senal=="1" ||Llanta=="1" ||Gato=="1"||CLlave=="1")
      {
        $('#inpNinguno').prop('disabled', true);
      }else{
        $('#inpNinguno').prop('disabled', false);
        $('#inpNinguno').val(0);
      }
    }  });

    $('#Llanta').change(function() {
      var DesarmadorC =$("#DesarmadorC").val();
      var DesarmadorP =$("#DesarmadorP").val();
      var Cables =$("#Cables").val();
      var Senal =$("#Senal").val();
      var CLlave =$("#CLlave").val();
      var Llave =$("#Llave").val();
      var Gato =$("#Gato").val();


    if ($('#Llanta').is(":checked")) {
      $('#Llanta').val(1);
      $('#inpNinguno').prop('disabled', true);
      $('#inpNinguno').val("-1");
    }else{
      $('#Llanta').val(0);
      if(DesarmadorC =="1" ||DesarmadorP=="1" ||Cables=="1" ||Senal=="1" ||Llave=="1" ||Gato=="1"||CLlave=="1")
      {
        $('#inpNinguno').prop('disabled', true);
      }else{
        $('#inpNinguno').prop('disabled', false);
        $('#inpNinguno').val(0);
      }
    }  });
var CLlave =$("#CLlave").val();$('#CLlave').prop('disabled', true);
    $('#CLlave').change(function() {
      var DesarmadorC =$("#DesarmadorC").val();
      var DesarmadorP =$("#DesarmadorP").val();
      var Cables =$("#Cables").val();
      var Senal =$("#Senal").val();
      var Llanta =$("#Llanta").val();
      var Llave =$("#Llave").val();
      var Gato =$("#Gato").val();


    if ($('#CLlave').is(":checked")) {
      $('#CLlave').val(1);
      $('#inpNinguno').prop('disabled', true);
      $('#inpNinguno').val("-1");
    }else{
      $('#CLlave').val(0);
      if(DesarmadorC =="1" ||DesarmadorP=="1" ||Cables=="1" ||Senal=="1" ||Llave=="1" ||Gato=="1"||Llanta=="1")
      {
        $('#inpNinguno').prop('disabled', true);
      }else{
        $('#inpNinguno').prop('disabled', false);
        $('#inpNinguno').val(0);
      }
    }  });

    $('#Gato').change(function() {
      var DesarmadorC =$("#DesarmadorC").val();
      var DesarmadorP =$("#DesarmadorP").val();
      var Cables =$("#Cables").val();
      var Senal =$("#Senal").val();
      var Llave =$("#Llave").val();
      var CLlave =$("#CLlave").val();
      var Llanta =$("#Llanta").val();


    if ($('#Gato').is(":checked")) {
      $('#Gato').val(1);
      $('#inpNinguno').prop('disabled', true);
      $('#inpNinguno').val("-1");
    }else{
      $('#Gato').val(0);
      if(DesarmadorC =="1" ||DesarmadorP=="1" ||Cables=="1" ||Senal=="1" ||Llave=="1" ||Llanta=="1" ||CLlave=="1" )
      {
        $('#inpNinguno').prop('disabled', true);
      }else{
        $('#inpNinguno').prop('disabled', false);
        $('#inpNinguno').val(0);
      }
    }  });

     function validarRegistroVehicular(){

      $("#mensajeserrorRegistroVehicular").removeClass('alert alert-error').html('');
      $('#mensajeserrorRegistroVehicular').fadeIn();

      var selempresaexterno =$("#selempresaexterno").val();
      var fechaingreso =$("#fechaingreso").val();
      var fechaingreso1 = new Date (fechaingreso);
      var selLineaDeNegocio =$("#selLineaDeNegocio").val();
      var selEntidad =$("#selEntidad").val();
      var selPlacas =$("#selPlacas").val();
      var selModalidad =$("#selModalidad").val();
      var selEngomado =$("#selEngomado").val();
      var numeroPlacas =$("#numeroPlacas").val();
      var seltarjetacirculacion =$("#seltarjetacirculacion").val();
      var inpFechaDeIniciotarjeta =$("#inpFechaDeIniciotarjeta").val();
      var inpFechaDeTerminotarjeta =$("#inpFechaDeTerminotarjeta").val();
      var inpFechaDeIniciotarjeta1= new Date (inpFechaDeIniciotarjeta);
      var inpFechaDeTerminotarjeta1= new Date (inpFechaDeTerminotarjeta);
      var selMarca =$("#selMarca").val();
      var selModelo =$("#selModelo").val();
      var selTipoDeVehiculo =$("#selTipoDeVehiculo").val();
      var selColor =$("#selColor").val();
      var inpAnio =$("#inpAnio").val();
      var inpNumeroDeSerie =$("#inpNumeroDeSerie").val();
      var selCuentaConNumeroMotro =$("#selCuentaConNumeroMotro").val();
      var inpNumeroDeMotor =$("#inpNumeroDeMotor").val();
      var selPaisOrigen =$("#selPaisOrigen").val();
      var selVehiculoNuevoViejo =$("#selVehiculoNuevoViejo").val();
      var fechaCompra =$("#fechaCompra").val();
      var fechaCompra1 = new Date (fechaCompra);
      var selCilindrosDelVehiculo =$("#selCilindrosDelVehiculo").val();
      var inpCentimetrosCubicos =$("#inpCentimetrosCubicos").val();
      var selAseguradora =$("#selAseguradora").val();
      var selTipoDePoliza =$("#selTipoDePoliza").val();
      var inpNumeroPoliza =$("#inpNumeroPoliza").val();
      var selFechaIniciPoliza =$("#selFechaIniciPoliza").val();
      var selFechaFinPoliza =$("#selFechaFinPoliza").val();
      var DMPTotal =$("#DMPTotal").val();
      var inpCantidadPerdidaTotal =$("#inpCantidadPerdidaTotal").val();
      var Cristales =$("#Cristales").val();
      var selAparadaCristales =$("#selAparadaCristales").val();
      var inpPorcentajeCristales =$("#inpPorcentajeCristales").val();
      var inpCantidadCristales =$("#inpCantidadCristales").val();
      var DMPParcial =$("#DMPParcial").val();
      var inpCantidadPerdidaParcial =$("#inpCantidadPerdidaParcial").val();
      var ProteccionLegal =$("#ProteccionLegal").val();
      var selAparadaProteccionLegal =$("#selAparadaProteccionLegal").val();
      var inpPorcentajeProteccionLegal =$("#inpPorcentajeProteccionLegal").val();
      var inpCantidadProteccionLegal =$("#inpCantidadProteccionLegal").val();
      var Robototal =$("#Robototal").val();
      var inpCantidadRobototal =$("#inpCantidadRobototal").val();
      var Club =$("#Club").val();
      var selAparadaClub =$("#selAparadaClub").val();
      var inpPorcentajeClub =$("#inpPorcentajeClub").val();
      var inpCantidadClub =$("#inpCantidadClub").val();
      var DanosATerceros =$("#DanosATerceros").val();
      var inpCantidadDanosATerceros =$("#inpCantidadDanosATerceros").val();
      var GastosMedicos =$("#GastosMedicos").val();
      var inpCantidadGastosMedicos =$("#inpCantidadGastosMedicos").val();
      var Accidentes =$("#Accidentes").val();
      var inpCantidadAccidentes =$("#inpCantidadAccidentes").val();
      var inpNumeroTarjetaLLave =$("#inpNumeroTarjetaLLave").val();
      var inpNumeroTarjetaGasolina =$("#inpNumeroTarjetaGasolina").val();
      var inpNIP =$("#inpNIP").val();
      var TarjetaLlave =$("#TarjetaLlave").val();
      var TarjetaGasolina =$("#TarjetaGasolina").val();


      var DesarmadorC =$("#DesarmadorC").val();
      var DesarmadorP =$("#DesarmadorP").val();
      var Cables =$("#Cables").val();
      var Senal =$("#Senal").val();
      var Llave =$("#Llave").val();
      var Llanta =$("#Llanta").val();
      var CLlave =$("#CLlave").val();
      var Gato =$("#Gato").val();
      var inpNinguno =$("#inpNinguno").val();

      var idfotoVehiculo =$("#idfotoVehiculo").val();
      var idfotoTarjeta =$("#idfotoTarjeta").val();
      var idfotoPoliza =$("#idfotoPoliza").val();
      var idfotoFactura =$("#idfotoFactura").val();
      //&& DesarmadorP=="0" && Cables=="0" && Senal=="0" && Llave=="0" && Llanta=="0" && Gato=="0" && CLlave=="0"

      if (selempresaexterno =="" ||  selempresaexterno =="0") {
      cargaerroresregistroVehicular('Seleccione El Destino Del Vehiculo');
      }
      else if (fechaingreso==""){
      cargaerroresregistroVehicular('Seleccione La Fecha De Ingreso Del Vehiculo A La Empresa');
      }
      else if (selLineaDeNegocio=="" ||  selLineaDeNegocio=="0") {
      cargaerroresregistroVehicular('Seleccione la linea De Negocio');
      }
      else if (selEntidad=="" ||  selEntidad=="0") {
      cargaerroresregistroVehicular('Seleccione La Entidad Federetavia');
      }
      else if (selPlacas=="" ||  selPlacas=="0") {
      cargaerroresregistroVehicular('Seleccione El Tipo De Servicio De Las Placas');
      }
      else if (selModalidad=="" ||  selModalidad=="0") {
      cargaerroresregistroVehicular('Seleccione La Modalidad De Las Placas');
      }
      else if (selEngomado=="" ||  selEngomado=="0") {
      cargaerroresregistroVehicular('Seleccione El Color Del Engomado De Las Placas');
      }
      else if (numeroPlacas=="" ||  numeroPlacas=="0" ) {
      cargaerroresregistroVehicular('Digite El Numero De Placa Correcto Siguiendo El Formato');
      }
      else if (seltarjetacirculacion =="" ||  seltarjetacirculacion =="0") {
      cargaerroresregistroVehicular('Seleccione El Tipo De La Tarjeta De Circulación');
      }
      else if (seltarjetacirculacion =="2" && inpFechaDeIniciotarjeta ==""){
      cargaerroresregistroVehicular('Seleccione La Fecha De Expedición De la Tarjeta De Circulación');
      }
      else if (seltarjetacirculacion =="2" && inpFechaDeTerminotarjeta ==""){
      cargaerroresregistroVehicular('Seleccione La Fecha De Termino De la Vigencia De La Tarjeta De Circulación');
      }
      else if (seltarjetacirculacion =="2" && inpFechaDeTerminotarjeta1<inpFechaDeIniciotarjeta1){
      cargaerroresregistroVehicular('La Fecha De Termino De Vigencia No Puede Ser Menor Que La Fecha De Expedición De la Tarjeta De Circulación');
      }
      else if (selMarca=="" ||  selMarca=="0") {
      cargaerroresregistroVehicular('Seleccione La Marca Del Vehiculo');
      }
      else if (selModelo=="" ||  selModelo=="0") {
      cargaerroresregistroVehicular('Seleccione El Modelo Del Vehiculo');
      }
      else if (selTipoDeVehiculo=="" || selTipoDeVehiculo=="0") {
      cargaerroresregistroVehicular('Seleccione El Tipo De Vehiculo');
      }
      else if (selColor=="" || selColor=="0") {
      cargaerroresregistroVehicular('Seleccione El Color Del Vehiculo');
      }
      else if (inpAnio=="" || !/^([0-9]{4})*$/.test(inpAnio)) {
      cargaerroresregistroVehicular('Ingrese El Año Del Vehiculo Correcto');
      }
      else if (inpNumeroDeSerie=="" || !/^([A-Z-a-z-0-9]{17})*$/.test(inpNumeroDeSerie)) {
      cargaerroresregistroVehicular('Ingrese el Numero De Serie Correcto Del Vehiculo (Debe Contener 17 Digitos Alfanumericos)');
      }
      else if (selCuentaConNumeroMotro =="" || selCuentaConNumeroMotro =="0") {
      cargaerroresregistroVehicular('Seleccione Si Cuenta Con numero De Motor');
      }
      else if ((selCuentaConNumeroMotro =="1" && inpNumeroDeMotor=="") || (selCuentaConNumeroMotro =="1" && !/^([A-Z-a-z-0-9]{5,11})*$/.test(inpNumeroDeMotor))) {
      cargaerroresregistroVehicular('Ingrese El numero De Motor Correcto Del Vehiculo (Debe Contener (Minimo 5 Y Maximo 11) Digitos Alfanumericos)');
      }
      else if (selCuentaConNumeroMotro =="2" && selPaisOrigen  =="" || selCuentaConNumeroMotro =="2" && selPaisOrigen  =="0" ) {
      cargaerroresregistroVehicular('Seleccione El Pais De Origen Del Vehiculo');
      }
      else if (selVehiculoNuevoViejo  =="" || selVehiculoNuevoViejo  =="0") {
      cargaerroresregistroVehicular('Seleccione Si El Vehiculo Es De Agencia o Es De Uso');
      }
      else if (fechaCompra=="" ||  fechaCompra=="0") {
      cargaerroresregistroVehicular('Seleccione La Fecha De Compra Del Vehiculo');
      }
      else if (fechaCompra1>fechaingreso1) {
      cargaerroresregistroVehicular('La Fecha De Compra No Puede Ser Menor Que La Fecha De Ingreso A La Empresa');
      }
      else if (fechaCompra1>inpFechaDeIniciotarjeta1) {
      cargaerroresregistroVehicular('La Fecha De Compra No Puede Ser Menor Que La Fecha De Ecpedición De La Tarjeta De Circulación');
      }  
      else if (selCilindrosDelVehiculo   =="" || selCilindrosDelVehiculo   =="0") {
      cargaerroresregistroVehicular('Seleccione La Cilindrada Del Vehiculo');
      }
      else if (inpCentimetrosCubicos=="") {
      cargaerroresregistroVehicular('Ingrese Los Centimetros Cubicos Del Vehiculo (Ejemplo "1.6")');
      }
      else if (selAseguradora   =="" || selAseguradora   =="0") {
      cargaerroresregistroVehicular('Seleccione La Aseguradora Del Vehiculo');
      }
      else if (selTipoDePoliza   =="" || selTipoDePoliza   =="0") {
      cargaerroresregistroVehicular('Seleccione El tipo De Poliza De la Aseguradora Del Vehiculo');
      }
      else if (inpNumeroPoliza=="" ||  inpNumeroPoliza=="0" ||  !/^([A-Z-a-z-0-9])*$/.test(inpNumeroPoliza)) {
      cargaerroresregistroVehicular('Ingrese el Numero De Póliza Correcto Del Vehiculo');
      } 
      else if (selFechaIniciPoliza=="" ||  selFechaIniciPoliza=="0") {
      cargaerroresregistroVehicular('Ingrese La Fecha Inicial De La Póliza Correcta');
      } 
      else if (selFechaFinPoliza=="" ||  selFechaFinPoliza=="0" ) {
      cargaerroresregistroVehicular('Ingrese La Fecha Final De La Póliza Correcta');
      } 
      else if (selFechaIniciPoliza>selFechaFinPoliza ) {
      cargaerroresregistroVehicular('La Fecha Inicial No Puede Ser Mayor A La Fecha Final De La Póliza');
      } 
      else if ((selTipoDePoliza !="0" && DMPTotal != "0" && inpCantidadPerdidaTotal=="")|| (selTipoDePoliza !="0" && DMPTotal != "0" && !/^([0-9])*$/.test(inpCantidadPerdidaTotal)) ){
      cargaerroresregistroVehicular('Ingrese La Cantidad Asegurada En Caso De Perdida Total (Solo La Cantidad En Numero)');
      }
      else if ( selTipoDePoliza !="0" && Cristales != "0" && selAparadaCristales=="0") {
      cargaerroresregistroVehicular('Seleccione La Opcion "SI" Si Los Cristales Estan Amparados o "NO" Si La Poliza Asegura Con Una Cantidad');
      }
      else if ( selTipoDePoliza !="0" && Cristales != "0" && selAparadaCristales=="1" && inpPorcentajeCristales=="" ||
               (selTipoDePoliza !="0" && Cristales != "0" && selAparadaCristales=="1" &&  !/^([0-9])*$/.test(inpPorcentajeCristales)) ) {
      cargaerroresregistroVehicular('Ingrese El Porcentaje Del Amparo De Los Cristales Indicado En La Poliza (Solo El Porcentaje En Numero)');
      }
      else if ((selTipoDePoliza !="0" && Cristales != "0" && selAparadaCristales=="2" && inpCantidadCristales=="")||
               (selTipoDePoliza !="0" && Cristales != "0" && selAparadaCristales=="2" &&  !/^([0-9])*$/.test(inpCantidadCristales)) ) {
      cargaerroresregistroVehicular('Ingrese La Cantidad Asegurada De Los Cristales Indicado En La Poliza (Solo La Cantidad En Numero)');
      }
      else if (( selTipoDePoliza !="0" && DMPParcial != "0" && inpCantidadPerdidaParcial=="") || (selTipoDePoliza !="0" && DMPParcial != "0" && !/^([0-9])*$/.test(inpCantidadPerdidaParcial))) {
      cargaerroresregistroVehicular('Ingrese La Cantidad Asegurada En Caso De Perdida Parcial (Solo La Cantidad En Numero)');
      }
      else if ( selTipoDePoliza !="0" && ProteccionLegal != "0" && selAparadaProteccionLegal=="0") {
      cargaerroresregistroVehicular('Seleccione La Opcion "SI" Si La Protección Legal Esta Amparada o "NO" Si La Poliza Asegura Con Una Cantidad');
      }
      else if ( selTipoDePoliza !="0" && ProteccionLegal != "0" && selAparadaProteccionLegal=="1" && inpPorcentajeProteccionLegal=="" ||
               (selTipoDePoliza !="0" && ProteccionLegal != "0" && selAparadaProteccionLegal=="1" &&  !/^([0-9])*$/.test(inpPorcentajeProteccionLegal)) ) {
      cargaerroresregistroVehicular('Ingrese El Porcentaje Amparado De La Protección Legal Indicado En La Poliza (Solo El Porcentaje En Numero)');
      }
      else if ((selTipoDePoliza !="0" && ProteccionLegal != "0" && selAparadaProteccionLegal=="2" && inpCantidadProteccionLegal=="")||
               (selTipoDePoliza !="0" && ProteccionLegal != "0" && selAparadaProteccionLegal=="2" &&  !/^([0-9])*$/.test(inpCantidadProteccionLegal)) ) {
      cargaerroresregistroVehicular('Ingrese La Cantidad Asegurada La Protección Legal Indicado En La Poliza (Solo La Cantidad En Numero)');
      }
      else if (( selTipoDePoliza !="0" && Robototal != "0" && inpCantidadRobototal=="") || ( selTipoDePoliza !="0" && Robototal != "0" && !/^([0-9])*$/.test(inpCantidadRobototal))) {
      cargaerroresregistroVehicular('Ingrese La Cantidad Asegurada En Caso De Robo Total (Solo La Cantidad En Numero)');
      }
      else if ( selTipoDePoliza !="0" && Club != "0" && selAparadaClub=="0") {
      cargaerroresregistroVehicular('Seleccione La Opcion "SI" Si El Club De Autos Esta Amparado o "NO" Si La Poliza Asegura Con Una Cantidad');
      }
      else if ( selTipoDePoliza !="0" && Club != "0" && selAparadaClub=="1" && inpPorcentajeClub=="" ||
               (selTipoDePoliza !="0" && Club != "0" && selAparadaClub=="1" &&  !/^([0-9])*$/.test(inpPorcentajeClub)) ) {
      cargaerroresregistroVehicular('Ingrese El Porcentaje Del Amparo Del Club De Autos Indicado En La Poliza (Solo El Porcentaje En Numero)');
      }
      else if ((selTipoDePoliza !="0" && Club != "0" && selAparadaClub=="2" && inpCantidadClub=="")||
               (selTipoDePoliza !="0" && Club != "0" && selAparadaClub=="2" &&  !/^([0-9])*$/.test(inpCantidadClub)) ) {
      cargaerroresregistroVehicular('Ingrese La Cantidad Asegurada Del Club De Autos Indicado En La Poliza (Solo La Cantidad En Numero)');
      }
      else if (( selTipoDePoliza !="0" && DanosATerceros != "0" && inpCantidadDanosATerceros=="") || ( selTipoDePoliza !="0" && DanosATerceros != "0" && !/^([0-9])*$/.test(inpCantidadDanosATerceros))) {
      cargaerroresregistroVehicular('Ingrese La Cantidad Asegurada En Caso De Daños A Terceros (Solo La Cantidad En Numero)');
      }
      else if (( selTipoDePoliza !="0" && GastosMedicos != "0" && inpCantidadGastosMedicos=="") || ( selTipoDePoliza !="0" && GastosMedicos != "0" && !/^([0-9])*$/.test(inpCantidadGastosMedicos))) {
      cargaerroresregistroVehicular('Ingrese La Cantidad Asegurada En Caso Gastos Medicos Ocupantes (Solo La Cantidad En Numero)');
      }
      else if (( selTipoDePoliza !="0" && Accidentes != "0" && inpCantidadAccidentes=="") || ( selTipoDePoliza !="0" && Accidentes != "0" && !/^([0-9])*$/.test(inpCantidadAccidentes))) {
      cargaerroresregistroVehicular('Ingrese La Cantidad Asegurada En Caso De Accidente Al Conductor (Solo La Cantidad En Numero)');
      }
      else if (TarjetaLlave=="1" && inpNumeroTarjetaLLave==""){
      cargaerroresregistroVehicular('Ingrese El Numero De La Tarjeta LLave Asiganda AL Vehiculo');
      }
      else if ((TarjetaGasolina=="1" && inpNumeroTarjetaGasolina=="")||(TarjetaGasolina=="1" && !/^([0-9])*$/.test(inpNumeroTarjetaGasolina)) ){
      cargaerroresregistroVehicular('Ingrese El Numero De La Tarjeta De Gasolina Asiganda AL Vehiculo (Solo Numeros)');
      }
      else if ((TarjetaGasolina=="1" && inpNIP=="")||(TarjetaGasolina=="1" && !/^([0-9])*$/.test(inpNIP)) ){
      cargaerroresregistroVehicular('Ingrese El NIP De La Tarjeta De Gasolina Asiganda AL Vehiculo (Solo Numeros)');
      }
      else if (inpNinguno=="0"){
      cargaerroresregistroVehicular('Seleccione Algun Campo Si El Vehiculo No Cuenta Con Nada De lo Mensionado Seleccione El Campo "Ninguno"');
      }
      else if (idfotoVehiculo=="" ||  idfotoVehiculo=="0") {
      cargaerroresregistroVehicular('Seleccione Una Foto o Archivo Correcto Del Vehiculo');
      }
      else if (idfotoTarjeta=="" ||  idfotoTarjeta=="0") {
      cargaerroresregistroVehicular('Seleccione Una Foto o Archivo Correcto De La Tarjeta De Circulacion');
      }
      else if (idfotoPoliza=="" ||  idfotoPoliza=="0") {
      cargaerroresregistroVehicular('Seleccione Una Foto o Archivo Correcto De La Poliza del Seguro');
      }
      else if (idfotoFactura=="" ||  idfotoFactura=="0") {
      cargaerroresregistroVehicular('Seleccione Una Foto o Archivo Correcto De La Factura Del Vehiculo');
      }
      else
      {
        GuardarDatosGeneralesVehiculo();
      } 
  }

  

  function GuardarDatosGeneralesVehiculo(){

    var idfotoVehiculo =$("#idfotoVehiculo").val();
    var idfotoTarjeta =$("#idfotoTarjeta").val();
    var idfotoPoliza =$("#idfotoPoliza").val();
    var idfotoFactura =$("#idfotoFactura").val();

    datastring += "&idfotoVehiculo=" + idfotoVehiculo;  
    datastring += "&idfotoTarjeta=" + idfotoTarjeta;  
    datastring += "&idfotoPoliza=" + idfotoPoliza;  
    datastring += "&idfotoFactura=" + idfotoFactura;  
    var datastring = $("#form_RegistrarVehiculo").serialize();
    //console.log(datastring);
    //alert(idfotoVehiculo);
    $.ajax({
      type: "POST",
      data: datastring,
      url: "ajax_registrarvehiculo.php",
      dataType: "json",
      success: function(response) {
        var mensaje=response.message; 
        var estatus=response.status;
        if (estatus=="success") {
          GuardarDatosGeneralesPoliza();
          GuardaraccesoriosVehiculo();
          numeroeconomico();
          $('#mensajeserrorRegistroVehicular').fadeIn('slow');
          alertMsgregistrado="<div id='msgAlert' class='alert alert-success'><strong>Datos Gegerales</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#mensajeserrorRegistroVehicular").html(alertMsgregistrado);
          $(document).scrollTop(0);
          $('#mensajeserrorRegistroVehicular').delay(3000).fadeOut('slow');
          showMessageRegistrarVehiculo(mensaje,estatus);
            }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }

  function GuardarDatosGeneralesPoliza(){

    var DMPTotal =$("#DMPTotal").val();
    var Cristales =$("#Cristales").val();  
    var DMPParcial =$("#DMPParcial").val();  
    var ProteccionLegal =$("#ProteccionLegal").val();  
    var Robototal =$("#Robototal").val();  
    var Club =$("#Club").val(); 
    var DanosATerceros =$("#DanosATerceros").val(); 
    var GastosMedicos =$("#GastosMedicos").val();  
    var Accidentes =$("#Accidentes").val();

    var datastring = $("#form_RegistrarVehiculo").serialize();

    datastring += "&DMPTotal=" + DMPTotal ;
    datastring += "&Cristales=" + Cristales ;
    datastring += "&DMPParcial=" + DMPParcial ;
    datastring += "&ProteccionLegal=" + ProteccionLegal ;
    datastring += "&Robototal=" + Robototal ;
    datastring += "&Club=" + Club;
    datastring += "&DanosATerceros=" + DanosATerceros;
    datastring += "&GastosMedicos=" + GastosMedicos  ;
    datastring += "&Accidentes=" + Accidentes ;

    //console.log(datastring);
    $.ajax({
      type: "POST",
      data: datastring,
      url: "ajax_registrarDatosGeneralesPoliza.php",
      dataType: "json",
      success: function(response) {
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }

    function GuardaraccesoriosVehiculo(){

    var DesarmadorC =$("#DesarmadorC").val();
    var DesarmadorP =$("#DesarmadorP").val();
    var Cables =$("#Cables").val();
    var Senal =$("#Senal").val();
    var Llave =$("#Llave").val();
    var Llanta =$("#Llanta").val();
    var CLlave =$("#CLlave").val();
    var Gato =$("#Gato").val();
    var TarjetaLlave =$("#TarjetaLlave").val();
    var TarjetaGasolina =$("#TarjetaGasolina").val();
    var datastring = $("#form_RegistrarVehiculo").serialize();
    datastring += "&DesarmadorC=" + DesarmadorC;
    datastring += "&DesarmadorP=" + DesarmadorP;
    datastring += "&Cables=" + Cables;
    datastring += "&Senal=" + Senal;
    datastring += "&Llave=" + Llave;
    datastring += "&Llanta=" + Llanta;
    datastring += "&CLlave=" + CLlave;
    datastring += "&Gato=" + Gato;
    datastring += "&TarjetaLlave=" + TarjetaLlave;
    datastring += "&TarjetaGasolina=" + TarjetaGasolina;

    //console.log(datastring);
    $.ajax({
      type: "POST",
      data: datastring,
      url: "ajax_registrarAccesoriosVehiculo.php",
      dataType: "json",
      success: function(response) {
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }


  function numeroeconomico(){
    $.ajax({
      type: "POST",
      url: "ajax_getnumeroeconomico.php",
      dataType: "json",
      success: function(response) {
        var numeroeconomico=response.datos[0].idNumeroEconomico;
        $("#modalvehicular").modal("show");
        $("#strongnumeroeconomico").html("El Número Económico De Tu Vehículo Es : "+numeroeconomico);
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }

  function cargaerroresregistroVehicular(mensaje){
  alertMsjvehicular="<div class='alert alert-error' id='Mensaje'>"+mensaje+"<data-dismiss='alert'>";
  $("#mensajeserrorRegistroVehicular").html(alertMsjvehicular).fadeIn();
  $(document).scrollTop(0);
  $('#mensajeserrorRegistroVehicular').delay(3000).fadeOut('slow');
  }

   function showMessageRegistrarVehiculo(mensaje, status) {

    $(document).scrollTop(0);
    if (status =="success") {
      $("#form_RegistrarVehiculo")[0].reset();
      bloquearylimpiarcamposdeinicio();
    }
    else if (status == "error") {
      $('#msg').fadeIn('slow');
        alertMsg1 = "<div class='alert alert-error' id='msg'><strong>Error en el registro de movimiento:</strong>" + mensaje + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        $("#alertMsg").html(alertMsg1);
        $('#msg').delay(3000).fadeOut('slow');
    }
  } 

  function resetearformulariovehicular(){
    $("#form_RegistrarVehiculo")[0].reset();
  } 

</script>