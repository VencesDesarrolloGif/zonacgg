    <div id="muestratblfiniquitoscalculados" style="display :block">
      <div id="msgerrorbuscadorporfechasupervisiones" name="msgerrorbuscadorporfechasupervisiones"> </div>
      <div id='mserrorsubearchivo' name='mserrorsubearchivo' ></div>
      <div id='msgerrorinputpiramidar' name='msgerrorinputpiramidar' ></div>
        <center><h3>Finiquitos</h3></center><br>
      <section>
      <center>
        
        <div>
          <select id='selperiodofiniquito'>
            <option value="0">
              --Seleccione Periodo--
            </option>
            <option value='1'>
              QUINCENAL
            </option>
            <option value='2'>
              SEMANAL
            </option>
          </select>
        </div><br>
        <div >  
          <span class="add-on">Del:</span>
          <input class="input-medium" id="fechainiciobusquedafiniquito" name="fechainiciobusquedafiniquito" type="date">
          <span class="add-on">A:</span>
          <input class="input-medium" id="fechafinbusquedafiniquito" name="fechafinbusquedafiniquito" type="date">
          &nbsp<button style="margin-bottom: 0.5%" type="button" class="btn btn-primary" onclick="consultarporfechadefiniquito();">Buscar</button>
          <input class="input-medium" id="hdnaccionexcel" name="hdnaccionexcel" type="hidden" >
          <input class="input-medium" id="hdnentidad" name="hdnentidad" type="hidden" >
          <input class="input-medium" id="hdnLineanegocio" name="hdnLineanegocio" type="hidden" >
          <input class="input-medium" id="hdnrol" name="hdnrol" type="hidden" >
           <input  id="hdnaccioneditsave" name="hdnaccioneditsave" type="hidden" >
           <div id="btnexcel" style="display:none">
          <div  id="divbtnexcelfalso" style="text-align: left;"> &nbsp<button style="margin-bottom: 0.5%" type="button" class="btn btn-default" onclick="downloadexcel();">Excel</button></div>
           </div>
        </div>
      </center>
      <table id="tablaempleadosbajasfiniquitoscalculados"  width="100%">
        <thead>
          <tr>
            <th style="text-align: center;background-color: #B0E76E">Número empleado</th>
            <th style="text-align: center;background-color: #B0E76E">Nombre</th>
            <th style="text-align: center;background-color: #B0E76E">Puesto</th>
            <th style="text-align: center;background-color: #B0E76E">Entidad</th>
            <th style="text-align: center;background-color: #B0E76E">Fecha ingreso imss</th>
            <th style="text-align: center;background-color: #B0E76E">Fecha baja imss</th>
            <th style="text-align: center;background-color: #B0E76E">Prestamo</th>
            <th style="text-align: center;background-color: #B0E76E">Infonavit</th>
            <th style="text-align: center;background-color: #B0E76E">Fonacot</th>
            <th style="text-align: center;background-color: #B0E76E">Pensión</th>
            <th style="text-align: center;background-color: #B0E76E">Cuota</th>
            <th style="text-align: center;background-color: #B0E76E">Dias trabajados</th>
            <th style="text-align: center;background-color: #B0E76E">Separación</th>
            <th style="text-align: center;background-color: #B0E76E">Piramidar</th>        
            <th style="text-align: center;background-color: #B0E76E">Antiguedad total</th>
            <th style="text-align: center;background-color: #B0E76E">Dias para pp de vacaciones</th>
            <th style="text-align: center;background-color: #B0E76E">Dias de vacaciones</th>
            <th style="text-align: center;background-color: #B0E76E">Proporcion de vacaciones </th>
            <th style="text-align: center;background-color: #B0E76E">Calculo dias aguinaldo</th>
            <th style="text-align: center;background-color: #B0E76E">Dias de aguinaldo</th>
            <th style="text-align: center;background-color: #B0E76E">Proporcion de vacaciones</th>
            <th style="text-align: center;background-color: #B0E76E">Prima vacacional neta</th>
            <th style="text-align: center;background-color: #B0E76E">Proporcion neta aguinaldo</th>
            <th style="text-align: center;background-color: #B0E76E">Dias Vacaciones Pendientes</th>
            <th style="text-align: center;background-color: #B0E76E">Proporcion Vacaciones Pendiente</th>
            <th style="text-align: center;background-color: #B0E76E">Prima Vacaciones Pendientes</th>
            <th style="text-align: center;background-color: #B0E76E">Dias de pago</th>
            <th style="text-align: center;background-color: #B0E76E">Aumento en gratificacion</th>
            <th style="text-align: center;background-color: #B0E76E">Calculo bruto</th>
            <th style="text-align: center;background-color: #B0E76E">Pago neto</th>
            <th style="text-align: center;background-color: #B0E76E">Proporcion vacaciones $</th>
            <th style="text-align: center;background-color: #B0E76E">Prima vacacional $</th>
            <th style="text-align: center;background-color: #B0E76E">Proporcion aguinaldo $</th>
            <th style="text-align: center;background-color: #B0E76E">dias de pago $</th>
            <th style="text-align: center;background-color: #B0E76E">Pago neto 3</th>
            <th style="text-align: center;background-color: #B0E76E">Diferencia a gratificacion</th>
            <th style="text-align: center;background-color: #B0E76E">Ingresos acumulables</th>
            <th style="text-align: center;background-color: #B0E76E">Limite inferior</th>
            <th style="text-align: center;background-color: #B0E76E">Excedente sobre limite inferior</th>
            <th style="text-align: center;background-color: #B0E76E">Taza aplicable del limite</th>
            <th style="text-align: center;background-color: #B0E76E">resultado</th>
            <th style="text-align: center;background-color: #B0E76E">Cuota fija</th>
            <th style="text-align: center;background-color: #B0E76E">Isr</th>
            <th style="text-align: center;background-color: #B0E76E">Neto al pago</th>
            <th style="text-align: center;background-color: #B0E76E">Acción</th>
            <th style="text-align: center;background-color: #B0E76E">Comprobación</th>

          </tr>
        </thead>
        <tbody>
      </table>
    </section>
    </div>
 <script src="../Nominas/finiquitos/finiquitos.js"></script>
