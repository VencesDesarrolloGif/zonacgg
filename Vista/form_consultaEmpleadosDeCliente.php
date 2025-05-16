<?php
$mesActual= DATE('m');
$aux="2011-01-01";
$fechaI=strtotime($aux);
$anioInicio=date('Y',$fechaI);
$añoActual= DATE('Y');    
?>
<div class="container" align="center">
  <form class="form-horizontal"  method="post" id="form_empleadosCliente" name="form_empleadosCliente" action="" target="_blank">
    <fieldset>        
      <h1>Guardias</h1>
      <br>
      <label class=" control-label label " for="selectAnioEmpleadosCliente" style="margin-left: 38%;margin-right: -100%;">AÑO:</label>
      <select id="selectAnioEmpleadosCliente" name="selectAnioEmpleadosCliente" class="input-small" onchange="llenarMesesConsultaEmpleadosCloientes()">
        <option value="0">-SELECCIONE-</option>
        <?php
        for ($i = $anioInicio; $i <= $añoActual; $i++) {                                
          echo "<option value='" . $i. "'>" . $i. " </option>";

        }
        ?>
      </select>    
      <br>
      <label class=" control-label label " for="selectMesConsultaCliente" style="margin-left: 38%;margin-right: -41%;">MES:</label>
      <select id="selectMesConsultaCliente" name="selectMesConsultaCliente" class="input-large">
        <option value='0'>-SELECCIONE-</option>
      </select>    
      <br>
    </fieldset>

    <section>
      <table id="tableGuardias" class="display" cellspacing="0" width="80%">
        <thead>
          <tr>
            <th># Empleado</th>
            <th>Nombre</th>
            <th>Curp</th>
            <th>Rfc</th>
            <th>Delegación/Municipio</th>
            <th>Unidad</th>
            <th>Fecha Ingreso</th>
            <th>Determinante</th>                        
            <th>Formato</th>                        
            <th># Seguro Social</th>
            <th>Entidad</th>
            <th>Punto de Servicio</th>                        
            <th>Registro Patronal</th>                     
            <th>Puesto</th>
            <th>Tipo Turno</th>
            <th>Total SUA</th>
            <th>Hoja de Datos</th>
          </tr>
        </thead>

        <tbody></tbody>
      </table>
    </section>
  </form>
</div>
<script type="text/javascript">
  
  var meses = ['ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'];
  var tableGuardias = null;
  function getEmpleadosCliente(){
    var dataTableGuardias = [];
    var cliente=<?php echo $cliente?>;
  //alert(cliente); 
  var anio=$("#selectAnioEmpleadosCliente").val();
  var mes=$("#selectMesConsultaCliente").val();
  $.ajax ({
    type: "POST"
    ,url: "ajax_getEmpleadosByClienteEntidad.php"
    ,data: {"idCliente": cliente ,"anio": anio, "mes": mes}
    ,dataType: "json"
    ,async: false
    ,success: function (response)
    { console.log(response);
      if (response.status == "success")
      {
        for (var i = 0; i < response.data.length; i++)
        {
          var record = response.data[i];
                        //console.log(record);
                        //alert(record.esatusPunto);                                            
                        dataTableGuardias.push (record);                                          
                      }

                      loadDataInTableGuardias (dataTableGuardias);
                    }
                  }
                  ,error: function(jqXHR, textStatus, errorThrown){
                    alert(jqXHR.responseText); 
                  //alert("Error funcion")
                }
              });
}

function loadDataInTableGuardias (data)
{
  if (tableGuardias != null)
  {
    tableGuardias.destroy ();
            //tableServiciosFacturacion = null;
          }
          tableGuardias = $('#tableGuardias').DataTable( {
            "language" : {
              "emptyTable" :         "No hay empleados disponibles",
              "info" :               "Del _START_ al _END_ de _TOTAL_",
              "infoEmpty" :          "Mostrando 0 registros de un total de 0.",
              "infoFiltered" :       "(filtrados de un total de _MAX_ registros)",
              "infoPostFix" :        "(actualizados)",
              "lengthMenu" :         "Mostrar _MENU_ registros",
              "loadingRecords" :     "Cargando....",
              "processing"     :     "Procesando....",
              "search" :             "Buscar:",
              "searchPlaceholder" :  "Dato para buscar",
              "zeroRecords" :        "no se han encontrado coincidencias",
              "paginate" : {
               "first" :         "Primera",
               "last" :          "Ultima",
               "next" :          "Siguiente",
               "previous" :      "Anterior"
             },
             "aria" : {
               "sortAscending" :   "Ordenación ascendente",
               "sortDescending" :  "Ordenación descendente"
             }
           },
           data: data,
           destroy: true,
           "columns": [
           { "data": "numeroEmpleado"}
           ,{ "data": "nombreEmpleado"}
           ,{ "data": "curpEmpleado"}
           ,{ "data": "rfcEmpleado"}
           ,{ "data": "nombreMunicipio" }
           ,{ "data": "unidad" }
           ,{ "data": "fechaImss"}
           ,{ "data": "determinante"}
           ,{ "data": "formatodet"}
           ,{ "data": "empleadoNumeroSeguroSocial"}
           ,{ "data": "entidadT" }
           ,{ "data": "puntoServicio"}                        
           ,{ "data": "registroPatronal"}
           ,{ "data": "puesto"}
           ,{ "data": "turnoEmpleado" }
           ,{ "data": "subtotalEma" , render: $.fn.dataTable.render.number(',','.', 2,'$') }
           ,{ "data": "accion_datos" }

           ]
        //,serverSide: true
        ,processing: true
        ,dom: 'Bfrtip'
        ,buttons: ['excel']

      } );
          var cliente=<?php echo $cliente?>;
          if (cliente != 43) {
           var table = $("#tableGuardias").DataTable();
           table.columns([4,5,7,8]).visible(false);
         }

       }
       function mostrarHojaDeDatos(entidadEmpleado,consecutivoEmpleado,tipoEmpleado){
        window.open("generadorHojaDatos.php?entidadEmpleado="+entidadEmpleado+"&consecutivoEmpleado="+consecutivoEmpleado+"&tipoEmpleado="+tipoEmpleado+"",'Informe2','fullscreen=no');
        parent.opener=top;
      }


      function llenarMesesConsultaEmpleadosCloientes(){
        var sMeses="<option value='0'>-SELECCIONE-</option>";
        var mesActual= <?php echo $mesActual;?>;
        var anioSel=$("#selectAnioEmpleadosCliente").val(); 
        if(anioSel!=""){
          if(anioSel!= <?php echo $añoActual;?>){            
            for(var i=0;i<meses.length;i++){
              sMeses+="<option value='"+(i+1)+"'>"+meses[i]+"</option>";
            }
          }else{            
            for(var i=0;i<mesActual;i++){
              sMeses+="<option value='"+(i+1)+"'>"+meses[i]+"</option>";
            }
          }
          $("#selectMesConsultaCliente").html(sMeses);
        }else{
         $("#selectMesConsultaCliente").html(sMeses);
       }
     }


     $("#selectMesConsultaCliente").change(function(){
      getEmpleadosCliente();

    });

  </script>
