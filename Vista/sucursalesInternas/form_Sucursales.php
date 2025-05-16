<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link  href="css-Bootstrap-V4.1.3/css/bootstrap.min.css" >
  <link rel="stylesheet" href="css-Bootstrap-V4.1.3/popper.min.js">
</head>

<body>
  <div class="container" align="center">
  <legend><h3>Sucursales</h3></legend>
  <div id="divMensajeSucursales"></div>
        <select id="selectMovimiento" name="selectMovimiento" class="input-medium">
          <option value="0">SELECCIONAR</option>
          <option value="1">AGREGAR</option>
          <option value="2">DAR DE BAJA</option>
          <option value="3">ACTIVAR</option>
        </select>
        
  <br><br>

      <div id="divTablaAgregarSucursal" style="display: none;">
          <label class="label" for="entidadAPertenecer">ENTIDAD A LA QUE PERTENECERÁ</label><br>
          <select id="entidadAPertenecer" name="entidadAPertenecer" class="input-medium"></select>
        <br>
        <br>
          <label class="label" for="nombreSucursalAgregar">NOMBRE DE LA SUCURSAL</label><br>
          <input id="nombreSucursalAgregar" name="nombreSucursalAgregar" type="text" class="input-medium" placeholder="SUCURSAL" onkeyup="value.toUpperCase();">
        <br>
        <br> 
          <button type='button' class='btn btn-success' id='btnAgregarSucursal' name='btnAgregarSucursal'>Agregar</button>
      </div><br>



      <div id="divTablaDarDeBajaSucursal" style="display: none;">
        <label class="label" for="entidadQuePertenece">ENTIDAD A LA QUE PERTENECE</label><br>
          <select id="entidadQuePertenece" name="entidadQuePertenece" class="input-medium"></select>
        <br>
        <br>
          <label class="label" for="sucursalAEliminar">SUCURSAL</label><br>
          <select id="sucursalAEliminar" name="sucursalAEliminar" class="input-medium">
            <option value='0'>SUCURSAL</option>
          </select>
        <br>
        <br> 
          <button type='button' class='btn btn-success' id='btnEliminarSucursal' name='btnEliminarSucursal'>DAR DE BAJA</button>
      </div><br>


      <div id="divTablaActivarSucursal" style="display: none;">
        <label class="label" for="entidadPerteneciente">ENTIDAD A LA QUE PERTENECE</label><br>
          <select id="entidadPerteneciente" name="entidadPerteneciente" class="input-medium"></select>
        <br>
        <br>
          <label class="label" for="sucursalActivar">SUCURSAL</label><br>
          <select id="sucursalActivar" name="sucursalActivar" class="input-medium">
            <option value='0'>SUCURSAL</option>
          </select>
        <br>
        <br> 
          <button type='button' class='btn btn-success' id='btnActivarSucursal' name='btnActivarSucursal'>ACTIVAR</button>
      </div><br>


  </div>
</body>

</html>
<script src="sucursalesInternas/funciones_Sucursales.js"></script>