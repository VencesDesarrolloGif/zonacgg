<div class="container" align="center">

  <style>
    /* Estilo para la tabla */
    #tablaUniformes {
      width: 100%;
      border-collapse: collapse;
      background-color: #f0f8ff; /* Azul claro */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin: 20px 0;
    }

    /* Estilo para los encabezados */
    #tablaUniformes thead {
      background-color: #87cefa; /* Azul claro */
      color: white;
      font-size: 16px;
    }

    /* Estilo para las celdas del encabezado */
    #tablaUniformes th {
      padding: 12px;
      text-align: left;
      font-weight: bold;
    }

    /* Estilo para las filas del cuerpo de la tabla */
    #tablaUniformes tbody tr:nth-child(even) {
      background-color: #e6f7ff; /* Azul muy claro */
    }

    #tablaUniformes tbody tr:hover {
      background-color: #b3e0ff; /* Azul ligeramente más oscuro */
    }

    /* Estilo para las celdas de la tabla */
    #tablaUniformes td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    /* Estilo para el botón de acción */
    .acciones-btn {
      padding: 8px 16px;
      background-color: #87cefa; /* Azul claro */
      color: white;
      border: none;
      cursor: pointer;
      border-radius: 4px;
      transition: background-color 0.3s ease;
    }

    .acciones-btn:hover {
      background-color: #7ec8e7; /* Azul ligeramente más oscuro */
    }
  </style>

<form class="form-horizontal"  method="post" name='form_transferencias' id="form_transferencias" enctype="multipart/form-data">
  <legend><h3>Transferencia</h3></legend>
  <table id="tablasTransferenciasUni">
    <td>  
  <table class="table1"  >       
        <tr>
          <td><label class="control-label label" for="entidadFederativa" >Entidad Destino</label></td>
          <td><select id="entidadFederativaDestino" name="entidadFederativaDestino" class="input-large " >
             <option value="0">ENTIDAD FEDERATIVA</option>
              <?php
                for ($i=0; $i<count($catalogoEntidadesFederativasparaalmacen); $i++)
                {
                  if($i!=8)
                      echo "<option value='". $catalogoEntidadesFederativasparaalmacen[$i]["idEntidadFederativa"]."'>". $catalogoEntidadesFederativasparaalmacen[$i]["nombreEntidadFederativa"] ." </option>";
                }
              ?>
              </select>
          </td>
        </tr> 
        <tr>
          <td><label class="control-label label" for="sucursalDestino" >Sucursal Destino</label></td>
          <td><select id="sucursalDestino" name="sucursalDestino" class="input-large " >
             <option value="0">SUCURSAL</option>
              </select>
          </td>
        </tr> 
        <tr>
          <td><label class="control-label label " for="selectTipoMT">Tipo de Mercancia</label></td>          
            <td><select id="selectTipoMT" name="selectTipoMT" onchange="cambioTipoMercaT()">
                <option value="0">TIPO MERCANCIA</option>
              <?php
                for ($i=0; $i<count($catalogoTiposMercancia); $i++)
                {
                echo "<option value='". $catalogoTiposMercancia[$i]["idTipoMercancia"]."'>". $catalogoTiposMercancia[$i]["descripcionTipoMercancia"] ." </option>";
                }
              ?>
            </select></td>
        </tr> 
        <tr>      
          <td><label class="control-label label " for="txtUniformeTrans">Uniforme</label> </td>
          <td><input id="txtUniformeTrans" name="txtUniformeTrans" type="text" class="input-small" onchange="consultaExistenciasUni()" />
            <select id="selectUniformeTrans" name="selectUniformeTrans" onchange="cambioTipoUniformeTr()">
                
            </select></td>
        </tr>
        <tr>
          <td><label class="control-label label " for="txtExiste">Existencias</label></label> </td>
          <td><input id="txtExiste" name="txtExiste" type="text" class="input-small-mini" readonly /></td>          
        </tr> 
        <tr>
          <td><label class="control-label label " for="txtCantUni">Cantidad</label></label> </td>
          <td><input id="txtCantUni" name="txtCantUni" type="text" class="input-small-mini" /></td>   
           <td><button class="btn btn-primary" type='button' id='btnCantUniT' name='btnCantUniT' onclick='agregarUniTransfer()'><span class="glyphicon glyphicon-refresh"></span>Agregar</button></td>       
        </tr>    

        <tr>
          <td><label class="control-label label " for="txtGuia">No de Guia</label></label> </td>
          <td><input id="txtGuia" name="txtGuia" type="text" class="input-large" /></td>          
        </tr> 

        <tr>
          <td><label class="control-label label " for="txtPaqueteria">Paqueteria</label></label> </td>
          <td><input id="txtPaqueteria" name="txtPaqueteria" type="text" class="input-large" /></td>          
        </tr>  

         <tr>
          <td><label class="control-label label " for="txtObservaciones">Motivo</label></label> </td>
          <td><input id="txtObservaciones" name="txtObservaciones" type="text" class="input-xlarge" /></td>          
        </tr>    

   </table>
     </td>
     <td></td>
     <td></td>
<td valign="top">
      <table id="tablaUniformes" border="1">
        <thead>
          <tr>
            <th>Tipo de Uniforme</th>
            <th>Cantidad</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody id="cuerpoTabla">
          <!-- Los uniformes agregados aparecerán aquí -->
        </tbody>
      </table>
      </td>
  </table>

   <br>
   <button type='button' class='btn btn-success' id='btnTransferir' name='btnTransferir' onclick='transferirUniformeOk()'><span class="glyphicon glyphicon-floppy-save"></span>Transferir</button>
</form>
</div>
<!-- Enlace a la librería SweetAlert2 -->
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script type="text/javascript">

var listaUniformesTransfer = null;
var numUniformesTransfer=0;
// Variable para almacenar el valor antes del cambio
var entidadAnterior=0;
var sucursalAnterior=0;

$("#entidadFederativaDestino").focus(function () {
  // Al poner foco en el campo, guardamos el valor actual
  entidadAnterior = $(this).val();
});

$("#sucursalDestino").focus(function () {
  // Al poner foco en el campo, guardamos el valor actual
  sucursalAnterior = $(this).val();
});

$(reiniciarTransfer());  

function reiniciarTransfer(){    
// alert("dfsa") ;
    listaUniformesTransfer = new Array();
    numUniformesTransfer=0;                
    document.form_transferencias.reset();
    $('#cuerpoTabla').empty();  // Vacia las filas de la tabla
    $("#selectUniformeTrans").val("0");  // Reinicia el selector a su opción por defecto (puedes ajustar esto si lo necesitas)
    $("#txtUniformeTrans").val("");
    $("#txtCantUni").val("");
    $("#txtExiste").val("0");
    $('#sucursalDestino').empty().append('<option value="0" selected="selected">SUCURSAL</option>');
}

$("#entidadFederativaDestino").change(function (){
  var entidadElegida=$("#entidadFederativaDestino").val();
  // var entidadAnterior=entidadAnterior;
  consultaSucursalesTransferencia(entidadElegida);

  if(entidadAnterior!=0){

    if(entidadElegida==0){
       $('#entidadFederativaDestino').val(0);
    }else{
          Swal.fire({
            title: '¿Estás seguro de cambiar la entidad?',
            text: "Recuerda que todo lo agregado será enviado a esta entidad",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cambiar',
            cancelButtonText: 'No, cancelar'
          }).then((result) => {
            if (result.isConfirmed) {
              var descripcionEntidadSeleccionada = $("#entidadFederativaDestino option:selected").text();
              Swal.fire('Correcto', 'La transferencia será enviada a '+descripcionEntidadSeleccionada, 'success');
              entidadAnterior = entidadElegida; // Actualiza entidadAnterior después del cambio
              consultaSucursalesTransferencia(entidadElegida);
            }else {
              $("#entidadFederativaDestino").val(entidadAnterior);
              var descripcionEntidadSeleccionada = $("#entidadFederativaDestino option:selected").text();
              Swal.fire('Cancelado', 'La transferencia continuara hacia '+descripcionEntidadSeleccionada, 'success');
              consultaSucursalesTransferencia(entidadAnterior);
              entidadAnterior = entidadElegida; // Actualiza entidadAnterior después del cambio
            }
          });
    }
  }
});


$("#sucursalDestino").change(function (){

  var sucursalElegida=$("#sucursalDestino").val();
  if(sucursalAnterior!=0){

    if(sucursalElegida==0){
       $('#sucursalDestino').val(0);
    }else{
          Swal.fire({
            title: '¿Estás seguro de cambiar la sucursal?',
            text: "Recuerda que todo lo agregado será enviado a esta sucursal",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cambiar',
            cancelButtonText: 'No, cancelar'
          }).then((result) => {
            if (result.isConfirmed) {
              var descripcionSucursalSeleccionada = $("#sucursalDestino option:selected").text();
              Swal.fire('Correcto', 'La transferencia será enviada a la sucursal '+descripcionSucursalSeleccionada, 'success');
              sucursalAnterior = sucursalElegida; // Actualiza sucursalAnterior después del cambio
            }else {
              $("#sucursalDestino").val(sucursalAnterior);
              var descripcionSucursalSeleccionada = $("#sucursalDestino option:selected").text();
              Swal.fire('Cancelado', 'La transferencia continuara hacia la sucursal '+descripcionSucursalSeleccionada, 'success');
              sucursalAnterior = sucursalElegida; // Actualiza sucursalAnterior después del cambio
            }
          });
    }
  }
});

function consultaSucursalesTransferencia(entidadElegida){  

  $.ajax({
      type: "POST",
      url: "ajax_consultaSucursalesAlmacenTransferencia.php",
      data:{"entidadElegida":entidadElegida},
      dataType: "json",
      success: function(response) {
          // var msj=response.error;
          if (response.status == "success"){
            var sucursal=response.sucursales;
            $('#sucursalDestino').empty().append('<option value="0" selected="selected">SUCURSAL</option>');
            $.each(sucursal, function(i) {
              $('#sucursalDestino').append("<option value='"+sucursal[i].idSucursalI+"' title='"+sucursal[i].nombreSucursal+"'>"+sucursal[i].nombreSucursal+"</option>");
            });
            $('#sucursalDestino').focus();                  
          }else{
            alert(msj);
           }
      },error: function(jqXHR, textStatus, errorThrown){
             alert(jqXHR.responseText); 
       }
  });
}      


// function agregarUniTransfer(){        
//     var tipoMercancia=$("#txtUniformeTrans").val();
//     var codigoUni=$("#selectUniformeTrans").val(); 
//     var idTransfer=obtenerIdtransfer();  
//     var txtCantidad=$("#txtCantUni").val();        
//     var cantExist=$("#txtExiste").val();        
//     if(tipoMercancia==""){
//         alert("Selecciona o escribe el tipo de uniforme");
//     }else if(txtCantidad==""){
//         alert("Escribe la cantidad de uniformes");
//     }else{
//         var numUniformeSelect=obtenerTipoUniformeT(tipoMercancia);
//         if(numUniformeSelect=='0'){
//             alert("Tipo de uniforme invalido");
//         }else{                  
//             if(isNaN(parseInt(txtCantidad))){
//                 alert("La cantidad debe ser numero entero");
//             }else{
//                 var cantidad=parseInt(txtCantidad);
//                 var espera=parseInt(cantExist);                    
//                 if(cantidad>espera){
//                   alert("No hay suficientes uniformes para transferir");
//                   return;
//                 }                                                          
//                 var envio={};
//                 envio.idTransfer=idTransfer;
//                 envio.tipoUniforme=codigoUni;
//                 envio.cantidadUni=cantidad;                
//                 listaUniformesTransfer[numUniformesTransfer]=envio;                                                    
//                 numUniformesTransfer++;                     
//                 $("#txtUniformeTrans").val("");
//                 $("#txtCantUni").val("");
//                 $("#txtExiste").val("0");
//                 $("#selectUniformeTrans option[value='"+codigoUni+"']").remove();
                            
//             }
//         }
//     }    
// }

function agregarUniTransfer() {
    var tipoMercancia = $("#txtUniformeTrans").val();
    var codigoUni = $("#selectUniformeTrans").val();
    var idTransfer = obtenerIdtransfer();
    var txtCantidad = $("#txtCantUni").val();
    var cantExist = $("#txtExiste").val();

    if (tipoMercancia == "") {
        alert("Selecciona o escribe el tipo de uniforme");
    } else if (txtCantidad == "") {
        alert("Escribe la cantidad de uniformes");
    } else {
        var numUniformeSelect = obtenerTipoUniformeT(tipoMercancia);
        if (numUniformeSelect == '0') {
            alert("Tipo de uniforme invalido");
        } else {
            if (isNaN(parseInt(txtCantidad))) {
                alert("La cantidad debe ser numero entero");
            } else {
                var cantidad = parseInt(txtCantidad);
                var espera = parseInt(cantExist);

                if (cantidad > espera) {
                    alert("No hay suficientes uniformes para transferir");
                    return;
                }

                var envio = {};
                envio.idTransfer = idTransfer;
                envio.tipoUniforme = codigoUni;
                envio.cantidadUni = cantidad;
                envio.descripcionMercancia = tipoMercancia;

                // Agregar el uniforme a la lista
                listaUniformesTransfer[numUniformesTransfer] = envio;
                numUniformesTransfer++;

                // Actualizar la tabla con el nuevo uniforme agregado
                actualizarTabla();

                // Limpiar los campos después de agregar el uniforme
                $("#txtUniformeTrans").val("");
                $("#txtCantUni").val("");
                $("#txtExiste").val("0");
                $("#selectUniformeTrans option[value='" + codigoUni + "']").remove();
            }
        }
    }
}

// Función para actualizar la tabla con los uniformes en la lista
function actualizarTabla() {
    var cuerpoTabla = $("#cuerpoTabla");
    cuerpoTabla.empty();  // Limpiar la tabla antes de agregar las nuevas filas

    // Recorrer la lista de uniformes y agregar cada uno a la tabla
    listaUniformesTransfer.forEach(function (uniforme, index) {
        var fila = "<tr>" +
            "<td>" + uniforme.descripcionMercancia + "</td>" +
            "<td>" + uniforme.cantidadUni + "</td>" +
            "<td><button onclick='eliminarUniforme(" + index + ")'>Eliminar</button></td>" +
            "</tr>";
        cuerpoTabla.append(fila);  // Agregar la fila a la tabla
    });
}

// Función para eliminar un uniforme de la lista y actualizar la tabla
function eliminarUniforme(index) {
    // Eliminar el uniforme de la lista
    listaUniformesTransfer.splice(index, 1);
    // Actualizar la tabla después de la eliminación
    actualizarTabla();
    // Recargar el selector de uniformes después de eliminar uno
    cambioTipoMercaT();
     renumerarFilas(); 
}

function renumerarFilas() {
    $('#cuerpoTabla tr').each(function(index) {
        // Aquí puedes actualizar los IDs de las filas o realizar cualquier otra acción
        $(this).attr('id', 'filaUniforme' + index);  // Asignando nuevos IDs a las filas
        $(this).find('.eliminar-btn').attr('onclick', 'eliminarUniforme(' + index + ')');  // Actualizando los botones de eliminación
    });
}
function reconsultaTipoMercaT(){

 var tipoM=$("#selectTipoMT").val();

 $.ajax({
      type: "POST",
      url: "ajax_getUniformesByTipo.php",
      data:{"tipoMerca":tipoM},
      dataType: "json",
      success: function(response) {
          var msj=response.error;
          if (response.status == "success"){
            var uniformes=response.listaUni;
            $('#selectUniformeTrans').empty().append('<option value="0" selected="selected">UNIFORME</option>');
            $("#txtUniformeTrans").val("");
            $.each(uniformes, function(i) {
              $('#selectUniformeTrans').append("<option value='"+uniformes[i].idTipoUniforme+"' title='"+uniformes[i].descripcionTipo+"'>"+uniformes[i].codigoUniforme+"</option>");
            });
            $('#selectUniformeTrans').focus();                  
          }else{
            alert(msj);
           }
      },error: function(jqXHR, textStatus, errorThrown){
             alert(jqXHR.responseText); 
       }
  });
}   

function transferirUniformeOk(){
  // $("#btnTransferir").attr("disabled", true);
  var uniforme=$("#txtUniformeTrans").val();             
  var entidad=$("#entidadFederativaDestino").val();                     
  var guia=$("#txtGuia").val();
  var paqueteria=$("#txtPaqueteria").val();
  var observaciones=$("#txtObservaciones").val();
  var sucursalElegida=$("#sucursalDestino").val();

  if(entidad == 0){
      alert("Seleccione la entidad destino");
        return;   
  }else if(sucursalElegida==0){
           alert("Elija una sucursal");
           return; 
  }else if(listaUniformesTransfer.length ==0){
      alert("Agregue uniformes para transferir");
      return;    
  }else if(guia ==""){
      alert("Ingrese el numero de guia");
      return;    
  }else if(paqueteria ==""){
      alert("Ingrese el proveedor de paqueteria");
      return;    
  }else{            
    $.ajax({            
      type: "POST",
      url: "ajax_transferirUniforme.php",
      data: {"entidad":entidad, "listaUniformes":listaUniformesTransfer, "nGuia":guia, "paqueteria":paqueteria, "observaciones":observaciones, "sucursalElegida":sucursalElegida},
      dataType: "json",
      success: function(response) {
          var mensaje=response.message;

          if (response.status=="success") {   
        console.log(response);
          $("#btnTransferir").attr("disabled", false);                 
              // alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Transferencia: </strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
              // $("#alertMsg").html(alertMsg1);
              // $('#msgAlert').delay(4000).fadeOut('slow');
              getStockUniforme();
              reiniciarTransfer();
              swal("Listo", "Transferido correctamente","success");
          } else if (response.status=="error")
          {
            alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Transferencia:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
              $("#btnTransferir").attr("disabled", false);    
             
              $("#alertMsg").html(alertMsg1);
              $('#msgAlert').delay(4000).fadeOut('slow');
          }                 
      },error : function (jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }
}

function cambioTipoMercaT(){

 var tipoM=$("#selectTipoMT").val();

 $.ajax({
      type: "POST",
      url: "ajax_getUniformesByTipo.php",
      data:{"tipoMerca":tipoM},
      dataType: "json",
      success: function(response) {
          var msj=response.error;
          if (response.status == "success"){
            var uniformes=response.listaUni;
            $('#selectUniformeTrans').empty().append('<option value="0" selected="selected">UNIFORME</option>');
            $("#txtUniformeTrans").val("");
            $.each(uniformes, function(i) {
              $('#selectUniformeTrans').append("<option value='"+uniformes[i].idTipoUniforme+"' title='"+uniformes[i].descripcionTipo+"'>"+uniformes[i].codigoUniforme+"</option>");
            });
            $('#selectUniformeTrans').focus();                  
          }else{
            alert(msj);
           }
      },error: function(jqXHR, textStatus, errorThrown){
             alert(jqXHR.responseText); 
       }
  });
}
    
function cambioTipoUniformeTr(){          
  var select=document.getElementById("selectUniformeTrans");          
  var opcion=select.selectedIndex;          
  var nombreTipoUniforme=select.options[opcion].text; 
  if(opcion!=0){         
    $("#txtUniformeTrans").val(nombreTipoUniforme);
    consultaExistenciasUni();
  }else{
    $("#txtUniformeTrans").val("");
  }
}

function consultaExistenciasUni() {
    var tipoUniforme = $("#txtUniformeTrans").val();
    var idUniforme = obtenerTipoUniformeT(tipoUniforme);
    var entidad = '09';
    var sucursalStock = '8';
    $.ajax({
        type: "POST",  // Tipo de solicitud
        url: "ajax_getExistenciasByUniforme.php",  // URL del servidor
        data: { "entidad": entidad, "idUniforme": idUniforme, "sucursalStock": sucursalStock },  // Datos a enviar
        dataType: "json",  // Tipo de datos esperado de la respuesta
        success: function(response) {
            if (response.status == "success") {
                var total = response.totalUni;  // Total de existencias obtenidas
                $("#txtExiste").val(total);  // Asignar el valor de total a un campo de entrada
            } else if (response.status == "error") {
                console.error("Error al obtener existencias: " + response.message);
            }
        },
        error: function() {
            alert('Error al consultar las existencias.');
        }
    });
}

function obtenerIdtransfer(){        
  var idResult=0;
  $.ajax ({
      type: "POST"  
      ,url: "ajax_getIdUltimaTransfer.php"
      ,dataType: "json"
      ,async: false
      ,success: function (response){
          if (response.status == "success"){
              var idTransfer=response.idTransfer;  
              idResult= parseInt(idTransfer);                                                     
          }
      }
      ,error : function (jqXHR, textStatus, errorThrown)
      {
          alert(jqXHR.responseText);
      }
  });
  return (idResult+1);
}

function obtenerTipoUniformeT(txtMercancia){        
  var totalOpciones=document.form_transferencias.selectUniformeTrans.length;

  for(var i = 1; i < totalOpciones; i++){
      var opcionUniforme=document.form_transferencias.selectUniformeTrans.options[i].text;            
      if(txtMercancia == opcionUniforme){                
          var valor=document.form_transferencias.selectUniformeTrans.options[i].value;                
          return valor;
      }
  }
  return 0;
}
</script>