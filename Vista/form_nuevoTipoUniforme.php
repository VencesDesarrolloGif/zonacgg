<div class="container" align="center">
<form class="form-horizontal"  method="post" name='form_nuevoUniforme' id="form_nuevoUniforme" enctype="multipart/form-data">
<br><br>
  <legend><h3>Nueva Mercancia</h3></legend>    
   <div style="display: flex; justify-content: space-between;">

  <table class="table1" style="width: 48%;">
    <tr>
      <td><label class="control-label label" for="selectLineaNegocio" >Linea de Negocio</label></td>
      <td><select id="selectLineaNegocio" name="selectLineaNegocio" class="input-large">
        <option>LiNEA NEGOCIO</option>
        <?php
          for ($i=0; $i<count($catalogoLineaNegocio); $i++) {
            echo "<option value='". $catalogoLineaNegocio[$i]["idLineaNegocio"]."'>". $catalogoLineaNegocio[$i]["descripcionLineaNegocio"] ." </option>";
          }
        ?>
      </select>
      </td>
    </tr>
    <tr>
      <td><label class="control-label label" for="entidadFederativa" >ENTIDAD FEDERATIVA</label></td>
      <td><select id="entidadFederativa" name="entidadFederativa" class="input-large " >
        <option value="0">TODAS</option>
        <?php
          for ($i=0; $i<count($catalogoEntidadesFederativasparaalmacen); $i++) {
            echo "<option value='". $catalogoEntidadesFederativasparaalmacen[$i]["idEntidadFederativa"]."'>". $catalogoEntidadesFederativasparaalmacen[$i]["nombreEntidadFederativa"] ." </option>";
          }
        ?>
      </select>
      </td>
    </tr>
    <tr>
      <td><label class="control-label label" for="selectTipoMerca" >Tipo Mercancia</label></td>
      <td><select id="selectTipoMerca" name="selectTipoMerca" class="input-large " > 
      <option value="0">MERCANCIA</option>            
        <?php
          for ($i=0; $i<count($catalogoTiposMercancia); $i++) {
            echo "<option value='". $catalogoTiposMercancia[$i]["idTipoMercancia"]."'>". $catalogoTiposMercancia[$i]["descripcionTipoMercancia"] ." </option>";
          }
        ?>
      </select>
      </td>
    </tr>
    <tr>
      <td><label class="control-label label " for="descripcionUni">Descripcion</label></td>
      <td><input id="descripcionUni" name="descripcionUni" type="text" class="input-large"  /></td>
    </tr>
    <tr>
      <td><label class="control-label label " for="codigoUniforme">Codigo</label> </td>          
      <td><input type="text" name="codigoUniforme" id="codigoUniforme"class="input-medium" readonly /></td>
    </tr>
    <tr>        
      <td><label class="control-label label " for="checkTalla">Talla</label></label> </td>
      <td><input id="checkTalla" name="checkTalla" type="checkbox" class="checkbox" onclick="habilitarTalla()" checked/></td>
    </tr>
    <tr>
      <td><label class="control-label label " for="talla1">Talla de</label></td>          
      <td><input type="text" name="talla1" id="talla1"class="input-mini" /> A <input type="text" name="talla2" id="talla2"class="input-mini" /></td>
      <td>¿Medios?
        <input id="checkMedio" name="checkMedio" type="checkbox" class="checkbox" onclick="habilitarIntervalo()" disabled />
      </td>
    </tr>
    <tr>        
      <td><label class="control-label label " for="checkTalla">Intervalo</label></label> </td>
      <td><select id="selectIntervalo" name="selectIntervalo" class="input-mini " >
        <option value="1">1</option>
        <option value="2">2</option>
      </select></td>
    </tr>
  </table>
<br>
<br>
<html>
<style>
#tablaRangos, #tablaRangos th, #tablaRangos td {
  border: 1px solid black;
  text-align: center;
  padding: 5px;
}

#tablaRangos th, #tablaRangos td {
  width: 80px;  /* Ajusta este valor según el ancho de los inputs */
}

.input-mini {
  width: 80px;  /* Ajusta el tamaño de los inputs */
}
</style>

<table id="tablaRangos" style="width: 100%; table-layout: fixed;">
  <tr>
    <th></th>
    <th>Rango 1</th>
    <th>Rango 2</th>
    <th>Rango 3</th>
    <th>Rango 4</th>
    <th>Rango 5</th>
    <th>Rango 6</th>
  </tr>
  <tr>
    <td>Lavanderia</td>
    <td><input type="number" id="selectLavanderiaR1" name="selectLavanderiaR1" class="input-mini" min="0" max="100" value="0" class="solonumeros"></td>
    <td><input type="number" id="selectLavanderiaR2" name="selectLavanderiaR2" class="input-mini" min="0" max="100" value="0" class="solonumeros"></td>
    <td><input type="number" id="selectLavanderiaR3" name="selectLavanderiaR3" class="input-mini" min="0" max="100" value="0" class="solonumeros"></td>
    <td><input type="number" id="selectLavanderiaR4" name="selectLavanderiaR4" class="input-mini" min="0" max="100" value="0" class="solonumeros"></td>
    <td><input type="number" id="selectLavanderiaR5" name="selectLavanderiaR5" class="input-mini" min="0" max="100" value="0" class="solonumeros"></td>
    <td><input type="number" id="selectLavanderiaR6" name="selectLavanderiaR6" class="input-mini" min="0" max="100" value="0" class="solonumeros"></td>
  </tr>
  <tr>
    <td>Destruccion</td>
    <td><input type="number" id="selectDestruccionR1" name="selectDestruccionR1" class="input-mini" min="0" max="100" value="0" class="solonumeros"></td>
    <td><input type="number" id="selectDestruccionR2" name="selectDestruccionR2" class="input-mini" min="0" max="100" value="0" class="solonumeros"></td>
    <td><input type="number" id="selectDestruccionR3" name="selectDestruccionR3" class="input-mini" min="0" max="100" value="0" class="solonumeros"></td>
    <td><input type="number" id="selectDestruccionR4" name="selectDestruccionR4" class="input-mini" min="0" max="100" value="0" class="solonumeros"></td>
    <td><input type="number" id="selectDestruccionR5" name="selectDestruccionR5" class="input-mini" min="0" max="100" value="0" class="solonumeros"></td>
    <td><input type="number" id="selectDestruccionR6" name="selectDestruccionR6" class="input-mini" min="0" max="100" value="0" class="solonumeros"></td>
  </tr>
  <tr>
    <td>Cobro</td>
    <td><input type="number" id="selectCobroR1" name="selectCobroR1" class="input-mini" min="0" max="100" value="0" class="solonumeros"></td>
    <td><input type="number" id="selectCobroR2" name="selectCobroR2" class="input-mini" min="0" max="100" value="0" class="solonumeros"></td>
    <td><input type="number" id="selectCobroR3" name="selectCobroR3" class="input-mini" min="0" max="100" value="0" class="solonumeros"></td>
    <td><input type="number" id="selectCobroR4" name="selectCobroR4" class="input-mini" min="0" max="100" value="0" class="solonumeros"></td>
    <td><input type="number" id="selectCobroR5" name="selectCobroR5" class="input-mini" min="0" max="100" value="0" class="solonumeros"></td>
    <td><input type="number" id="selectCobroR6" name="selectCobroR6" class="input-mini" min="0" max="100" value="0" class="solonumeros"></td>
  </tr>
</table>
</html>
</div>
   <br>
   <button type='button' class='btn btn-success' id='btnGuardarUniforme' name='btnGuardarUniforme' onclick='guardarTipoUniforme()'>Guardar Uniforme</button>
</form>
</div>
<script type="text/javascript">

$('#entidadFederativa').change(function(){
  var entidadFed= $("#entidadFederativa").val();
  if (entidadFed=='0'){
    $("#sucursalNewMercancia").empty(); 
    $('#sucursalNewMercancia').append('<option value="0">TODAS</option>');
  }else{
    consultarSucursalesXentNuevoUnif(entidadFed);
  }
});

$('#selectTipoMerca').change(function(){
  var tipoMerca= $("#selectTipoMerca").val();
  if (tipoMerca=='0'){
    limpiarSelectoresPorcentaje();
  }else{
    definirPorcentajesSugeridosXtipoMercancia(tipoMerca);
  }

  document.getElementById("checkMedio").checked = false;
  if (tipoMerca=='5'){
    $("#checkMedio").prop("disabled",false);
  }else{
    $("#checkMedio").prop("disabled",true);
  }
});

$('#selectLavanderiaR1').blur(function(){
  var sel= $("#selectLavanderiaR1").val();
  if (sel==''){
      $("#selectLavanderiaR1").val(0);
  }
});

function limpiarSelectoresPorcentaje(){
  $("#selectLavanderiaR1").val(0);
  $("#selectLavanderiaR2").val(0);
  $("#selectLavanderiaR3").val(0);
  $("#selectLavanderiaR4").val(0);
  $("#selectLavanderiaR5").val(0);
  $("#selectLavanderiaR6").val(0);
  $("#selectDestruccionR1").val(0);
  $("#selectDestruccionR2").val(0);
  $("#selectDestruccionR3").val(0);
  $("#selectDestruccionR4").val(0);
  $("#selectDestruccionR5").val(0);
  $("#selectDestruccionR6").val(0);
  $("#selectCobroR1").val(0);
  $("#selectCobroR2").val(0);
  $("#selectCobroR3").val(0);
  $("#selectCobroR4").val(0);
  $("#selectCobroR5").val(0);
  $("#selectCobroR6").val(0);
}

function definirPorcentajesSugeridosXtipoMercancia(tipoMerca){

  if(tipoMerca==1){//camisas
    $("#selectLavanderiaR1").val(15);
    $("#selectLavanderiaR2").val(12);
    $("#selectLavanderiaR3").val(9);
    $("#selectLavanderiaR4").val(6);
    $("#selectLavanderiaR5").val(3);
    $("#selectLavanderiaR6").val(0);
    $("#selectDestruccionR1").val(67);
    $("#selectDestruccionR2").val(50);
    $("#selectDestruccionR3").val(33);
    $("#selectDestruccionR4").val(17);
    $("#selectDestruccionR5").val(7);
    $("#selectDestruccionR6").val(0);
    $("#selectCobroR1").val(67);
    $("#selectCobroR2").val(50);
    $("#selectCobroR3").val(33);
    $("#selectCobroR4").val(17);
    $("#selectCobroR5").val(7);
    $("#selectCobroR6").val(0);
  }//if camisas 

  if(tipoMerca==2){//pantalones
    $("#selectLavanderiaR1").val(15);
    $("#selectLavanderiaR2").val(12);
    $("#selectLavanderiaR3").val(9);
    $("#selectLavanderiaR4").val(6);
    $("#selectLavanderiaR5").val(3);
    $("#selectLavanderiaR6").val(0);
    $("#selectDestruccionR1").val(73);
    $("#selectDestruccionR2").val(54);
    $("#selectDestruccionR3").val(36);
    $("#selectDestruccionR4").val(22);
    $("#selectDestruccionR5").val(7);
    $("#selectDestruccionR6").val(0);
    $("#selectCobroR1").val(70);
    $("#selectCobroR2").val(49);
    $("#selectCobroR3").val(35);
    $("#selectCobroR4").val(22);
    $("#selectCobroR5").val(7);
    $("#selectCobroR6").val(0);
  }//if pantalones 

  if(tipoMerca==3){//sastre
    $("#selectLavanderiaR1").val(11);
    $("#selectLavanderiaR2").val(18);
    $("#selectLavanderiaR3").val(5);
    $("#selectLavanderiaR4").val(3);
    $("#selectLavanderiaR5").val(2);
    $("#selectLavanderiaR6").val(0);
    $("#selectDestruccionR1").val(62);
    $("#selectDestruccionR2").val(46);
    $("#selectDestruccionR3").val(31);
    $("#selectDestruccionR4").val(15);
    $("#selectDestruccionR5").val(8);
    $("#selectDestruccionR6").val(0);
    $("#selectCobroR1").val(62);
    $("#selectCobroR2").val(46);
    $("#selectCobroR3").val(31);
    $("#selectCobroR4").val(15);
    $("#selectCobroR5").val(8);
    $("#selectCobroR6").val(0);
  }//if sastre

  if(tipoMerca==4){//aditamentos
    $("#selectLavanderiaR1").val(0);
    $("#selectLavanderiaR2").val(0);
    $("#selectLavanderiaR3").val(0);
    $("#selectLavanderiaR4").val(0);
    $("#selectLavanderiaR5").val(0);
    $("#selectLavanderiaR6").val(0);
    $("#selectDestruccionR1").val(80);
    $("#selectDestruccionR2").val(60);
    $("#selectDestruccionR3").val(40);
    $("#selectDestruccionR4").val(20);
    $("#selectDestruccionR5").val(6);
    $("#selectDestruccionR6").val(0);
    $("#selectCobroR1").val(80);
    $("#selectCobroR2").val(60);
    $("#selectCobroR3").val(40);
    $("#selectCobroR4").val(20);
    $("#selectCobroR5").val(6);
    $("#selectCobroR6").val(0);
  }//if aditamentos

  if(tipoMerca==5){//calzado
    $("#selectLavanderiaR1").val(0);
    $("#selectLavanderiaR2").val(0);
    $("#selectLavanderiaR3").val(0);
    $("#selectLavanderiaR4").val(0);
    $("#selectLavanderiaR5").val(0);
    $("#selectLavanderiaR6").val(0);
    $("#selectDestruccionR1").val(100);
    $("#selectDestruccionR2").val(100);
    $("#selectDestruccionR3").val(100);
    $("#selectDestruccionR4").val(100);
    $("#selectDestruccionR5").val(100);
    $("#selectDestruccionR6").val(100);
    $("#selectCobroR1").val(100);
    $("#selectCobroR2").val(100);
    $("#selectCobroR3").val(100);
    $("#selectCobroR4").val(100);
    $("#selectCobroR5").val(100);
    $("#selectCobroR6").val(100);
  }//if calzado

  if(tipoMerca==6){//abrigos
    $("#selectLavanderiaR1").val(11);
    $("#selectLavanderiaR2").val(8);
    $("#selectLavanderiaR3").val(5);
    $("#selectLavanderiaR4").val(3);
    $("#selectLavanderiaR5").val(2);
    $("#selectLavanderiaR6").val(0);
    $("#selectDestruccionR1").val(75);
    $("#selectDestruccionR2").val(56);
    $("#selectDestruccionR3").val(38);
    $("#selectDestruccionR4").val(19);
    $("#selectDestruccionR5").val(9);
    $("#selectDestruccionR6").val(0);
    $("#selectCobroR1").val(75);
    $("#selectCobroR2").val(56);
    $("#selectCobroR3").val(38);
    $("#selectCobroR4").val(19);
    $("#selectCobroR5").val(9);
    $("#selectCobroR6").val(0);
  }//if abrigos

  if(tipoMerca==7){//chamarras
    $("#selectLavanderiaR1").val(15);
    $("#selectLavanderiaR2").val(12);
    $("#selectLavanderiaR3").val(9);
    $("#selectLavanderiaR4").val(6);
    $("#selectLavanderiaR5").val(3);
    $("#selectLavanderiaR6").val(0);
    $("#selectDestruccionR1").val(77);
    $("#selectDestruccionR2").val(58);
    $("#selectDestruccionR3").val(39);
    $("#selectDestruccionR4").val(19);
    $("#selectDestruccionR5").val(8);
    $("#selectDestruccionR6").val(0);
    $("#selectCobroR1").val(77);
    $("#selectCobroR2").val(58);
    $("#selectCobroR3").val(39);
    $("#selectCobroR4").val(19);
    $("#selectCobroR5").val(8);
    $("#selectCobroR6").val(0);
  }//if chamarras
}

function consultarSucursalesXentNuevoUnif(EntidadSeleccionada){

  $.ajax({
    type: "POST",
    url: "ajax_SucursalesXentNuevoUnif.php",
    data:{"EntidadSeleccionada":EntidadSeleccionada},
    dataType: "json",
    success: function(response) {
      $("#sucursalNewMercancia").empty(); 
      $('#sucursalNewMercancia').append('<option value="0">TODAS</option>');
      if(response.status == "success"){
      $("#sucursalNewMercancia").prop("disabled",false);
        for(var i = 0; i < response.sucursales.length; i++){
             $('#sucursalNewMercancia').append('<option value="' + (response.sucursales[i].idSucursalI) + '">' + response.sucursales[i].nombreSucursal + '</option>');
        }
      }else{
            alert("Error Al Cargar Las Entidades");
      }
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}


function guardarTipoUniforme(){

  var lineaNegocio=document.form_nuevoUniforme.selectLineaNegocio.selectedIndex;
  var entidad=document.form_nuevoUniforme.entidadFederativa.selectedIndex;
  var intervalo=document.form_nuevoUniforme.selectIntervalo.selectedIndex+1;
  var tipoMercancia=$("#selectTipoMerca").val();
  var descripcion=$("#descripcionUni").val().toUpperCase();
  var codigoUni=$("#codigoUniforme").val().toUpperCase();
  var talla1=$("#talla1").val();
  var talla2=$("#talla2").val();              
  var medios=0;   
        // var sucursalNM=$("#sucursalNewMercancia").val();
  if((talla1=="" || talla2=="") && document.form_nuevoUniforme.checkTalla.checked == true){
      alert("Ingresa rango de talla completo");
  }else if(descripcion==""){
      alert("Introduce la descripción del uniforme");
  }else if(lineaNegocio == 0){
      alert("Selecciona la linea de negocio");
  }else if(codigoUni == ""){
      alert("No hay codigo de uniforme");
  }else{
    if(document.form_nuevoUniforme.checkTalla.checked == false){
        talla1=0;
        talla2=0;
    }else{
        if(document.form_nuevoUniforme.checkMedio.checked == true){
            medios=1;
        }else{
            medios=2;
        }
        if(isNaN(parseInt(talla1)) || isNaN(parseInt(talla2))){
            alert("Las tallas deben ser numeros enteros");
            return;
        }
    } 

    var LavanderiaR1=$("#selectLavanderiaR1").val();
    var LavanderiaR2=$("#selectLavanderiaR2").val();
    var LavanderiaR3=$("#selectLavanderiaR3").val();
    var LavanderiaR4=$("#selectLavanderiaR4").val();
    var LavanderiaR5=$("#selectLavanderiaR5").val();
    var LavanderiaR6=$("#selectLavanderiaR6").val();
    var DestruccionR1=$("#selectDestruccionR1").val();
    var DestruccionR2=$("#selectDestruccionR2").val();
    var DestruccionR3=$("#selectDestruccionR3").val();
    var DestruccionR4=$("#selectDestruccionR4").val();
    var DestruccionR5=$("#selectDestruccionR5").val();
    var DestruccionR6=$("#selectDestruccionR6").val();
    var CobroR1=$("#selectCobroR1").val();
    var CobroR2=$("#selectCobroR2").val();
    var CobroR3=$("#selectCobroR3").val();
    var CobroR4=$("#selectCobroR4").val();
    var CobroR5=$("#selectCobroR5").val();
    var CobroR6=$("#selectCobroR6").val();

    if(LavanderiaR1==""){alert("El porcentaje de Lavanderia Rango 1 no puede estar vacio");return;}
    if(LavanderiaR2==""){alert("El porcentaje de Lavanderia Rango 2 no puede estar vacio");return;}
    if(LavanderiaR3==""){alert("El porcentaje de Lavanderia Rango 3 no puede estar vacio");return;}
    if(LavanderiaR4==""){alert("El porcentaje de Lavanderia Rango 4 no puede estar vacio");return;}
    if(LavanderiaR5==""){alert("El porcentaje de Lavanderia Rango 5 no puede estar vacio");return;}
    if(LavanderiaR6==""){alert("El porcentaje de Lavanderia Rango 6 no puede estar vacio");return;}
    if(DestruccionR1==""){alert("El porcentaje de Destruccion Rango 1 no puede estar vacio");return;}
    if(DestruccionR2==""){alert("El porcentaje de Destruccion Rango 2 no puede estar vacio");return;}
    if(DestruccionR3==""){alert("El porcentaje de Destruccion Rango 3 no puede estar vacio");return;}
    if(DestruccionR4==""){alert("El porcentaje de Destruccion Rango 4 no puede estar vacio");return;}
    if(DestruccionR5==""){alert("El porcentaje de Destruccion Rango 5 no puede estar vacio");return;}
    if(DestruccionR6==""){alert("El porcentaje de Destruccion Rango 6 no puede estar vacio");return;}
    if(CobroR1==""){alert("El porcentaje de Cobro Rango 1 no puede estar vacio");return;}
    if(CobroR2==""){alert("El porcentaje de Cobro Rango 2 no puede estar vacio");return;}
    if(CobroR3==""){alert("El porcentaje de Cobro Rango 3 no puede estar vacio");return;}
    if(CobroR4==""){alert("El porcentaje de Cobro Rango 4 no puede estar vacio");return;}
    if(CobroR5==""){alert("El porcentaje de Cobro Rango 5 no puede estar vacio");return;}
    if(CobroR6==""){alert("El porcentaje de Cobro Rango 6 no puede estar vacio");return;}

    $.ajax({            
      type: "POST",
      url: "ajax_newTipoUniforme.php",
      data:{"entidadFederativa":entidad, "lineaNegocio":lineaNegocio,"tipoMerca":tipoMercancia,"descripcionUniforme":descripcion,"codigoUniforme":codigoUni,"talla1":talla1,"talla2":talla2,"tallaMedia":medios,"intervalo":intervalo,LavanderiaR1,LavanderiaR2,LavanderiaR3,LavanderiaR4,LavanderiaR5,LavanderiaR6,DestruccionR1,DestruccionR2,DestruccionR3,DestruccionR4,DestruccionR5,DestruccionR6,CobroR1,CobroR2,CobroR3,CobroR4,CobroR5,CobroR6},
        dataType: "json",
      success:function(response) {
        var mensaje=response.message;
        if(response.status=="success") {                    
           alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Nuevo tipo de uniforme: </strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
           $("#alertMsg").html(alertMsg1);
           $(document).scrollTop(0);
           $('#msgAlert').delay(2000).fadeOut('slow');
           // window.setTimeout('location.reload()', 1000);                                     
        }else if(response.status=="error"){
                 alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Nuevo tipo de uniforme:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                 $("#alertMsg").html(alertMsg1);
                 $(document).scrollTop(0);
                 $('#msgAlert').delay(2000).fadeOut('slow');
        }                 
      },error:function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText); 
      }
    });
  }                  
}

$('#descripcionUni').blur(function(){
  var descripcion= $("#descripcionUni").val();
  var separador=" ";
  var arreglo= descripcion.split(separador);
  var codigo="";
  for(var i=0;i<arreglo.length;i++){
     var palabra=arreglo[i];
     codigo+=palabra.charAt(0);
  }
  $("#codigoUniforme").val(codigo);

});

function habilitarTalla(){
  if(document.form_nuevoUniforme.checkTalla.checked == false){
      $( "#talla1" ).prop( "disabled", true );
      $( "#talla2" ).prop( "disabled", true );
      $("#checkMedio").prop( "disabled", true );
      $("#selectIntervalo").prop( "disabled", true );
  }else{
      $( "#talla1" ).prop( "disabled", false );
      $( "#talla2" ).prop( "disabled", false );
      $("#checkMedio").prop( "disabled", false );
      if(document.form_nuevoUniforme.checkMedio.checked == false)
          $("#selectIntervalo").prop( "disabled", false );
      else
          $("#selectIntervalo").prop( "disabled", true );
  }
}

function habilitarIntervalo(){
  if(document.form_nuevoUniforme.checkMedio.checked == false){
     $( "#selectIntervalo" ).prop( "disabled", false );
  }else{
     $( "#selectIntervalo" ).prop( "disabled", true );
  }
}
</script>