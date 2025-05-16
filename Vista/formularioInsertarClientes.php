<!--<!DOCTYPE html-->




<html>
<head>
    <meta charset="utf-8">
       
  
    <title> Registro </title>
</head>
<body>
        
    <fieldset>

  <form action='../Negocio/parameters.php' method="post">
<fieldset>

<!-- Form Name -->
<legend>Campos Obligatorios</legend>

<!-- Text input-->
<div >
  <label class="control-label" for="numeroCliente">N. Cliente</label>
  <div class="controls">
    <input id="numeroCliente" name="numeroCliente" type="text" placeholder="00-0000-00" class="input-small">
    
  </div>
</div>

<!-- Text input-->
<div >
  <label for="razonSocial">Razon Social</label>
  <div >
    <input id="razonSocial" name="razonSocial" type="text" placeholder="Solo Letras" >
   
  </div>
</div>

<!-- Text input-->
<div >
  <label  for="nombreComercial">NombreComercial</label>
  <div >
    <input id="nombreComercial" name="nombreComercial" type="text" placeholder="Solo letras" >
   
  </div>
</div>

<!-- Text input-->


<!-- Button -->
<div >
  
  <div >
    <button id="guardar" name="guardar" type="submit">Guardar</button>
  </div>
</div>

</fieldset>
</form>
</body>


</html>


