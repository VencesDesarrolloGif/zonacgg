<meta charset="utf-8"/>
<div id="mensajeserrorRegistroTelefono"></div>
<form class="form-inline" method="post" id="form_RegistrarTelefono" target="_blank" enctype="multipart/form-data">
  <div align="center" >
    <div  style="max-width: 100rem; border-style: groove; border-color: rgb(51,153,255); "><br> 
      <legend id="titulolgeneral" style="color:blue;"><h4>Registrar Nuevo Telefono !!!</h4></legend><br>

      <div class= "row">
        
        <label class="control-label label" for="empresaTel">Empresa</label>
        <select id="selempresaTel" name="selempresaTel" class="span3"></select>

        <label class="control-label label" for="LineaDeNegocioTel">Linea De Negocio</label>
        <select id="selLineaDeNegocioTel" name="selLineaDeNegocioTel" class="span3"></select>

        <label class="control-label label" for="NumContratoTel">N° Contrato</label>
        <input id="inpNumContratoTel" name="inpNumContratoTel" type="text" class="span3 input-medium">
        
      </div><br>

      <div class= "row">

        <label class="control-label label" for="CompaniaTel">Compañia Teléfonica</label>
        <select id="selCompaniaTel" name="selCompaniaTel" class="span3"></select>

        <label class="control-label label" for="NumLiniaTel">N° Linea Teléfonica</label>
        <input id="inpNumLiniaTel" name="inpNumLiniaTel" type="text" class="span3 input-medium">
                
        <label class="control-label label" for="NumSimTel">N° SIM</label>
        <input id="inpNumSimTel" name="inpNumSimTel" type="text" class="span3 input-medium">
        
      </div><br>

      <div class= "row">

        <label class=" control-label label " for="TipoPlanTel">Tipo De Plan</label>
        <select id="selTipoPlanTel" name="selTipoPlanTel" class="span3"></select>
        
        <label class="control-label label" for="MarcaTel">Marca Del Teléfono </label>
        <select id="selMarcaTel" name="selMarcaTel" class="span3"></select>

        <label class="control-label label" for="ModeloTel">Modelo Del Teléfono</label>
        <select id="selModeloTel" name="selModeloTel" class="span3"></select>

      </div><br>

      <div class= "row">

        <label class=" control-label label " for="NumImeiTel">N° IMEI</label>
        <input id="inpNumImeiTel" name="inpNumImeiTel" type="text" class="span3 input-medium">

        <label class=" control-label label " for="NumSerieTel">N° Serie</label>
        <input id="inpNumSerieTel" name="inpNumSerieTel" type="text" class="span3 input-medium">

        <label class=" control-label label " for="NipTel">N° Nip Desbloque</label>
        <input id="inpNipTel" name="inpNipTel" type="text" class="span3 input-medium">
      
      </div><br>

      <div class= "row">

        <label class=" control-label label " for="ComentarioTel">Comentario</label>
        <textarea  id="txtComentarioTel" name="txtComentarioTel" class="txtAreaComentarios" rows="5" ></textarea>
    
      </div><br>

      <div class= "row">

        <button id="guardarVehiculo" name="guardarVehiculo" class="btn btn-primary" type="button" onclick="ValidacionesTelefonos();"> 
        <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button>

      </div><br>
    </div>
  </div>
</form>

<div class="modal fade" tabindex="-1" role="dialog" name="modalTelefonia" id="modalTelefonia" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><img src="img/ok.png">Tu Telefono Ha Sido Registrado Con Éxito !!</h4>
      </div>
      <div class="modal-body">
        <p><strong id="RegistroTelefono"></strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  

<script type="text/javascript">

  $(document).ready(function() {
    GetEmpresaTel();
    cargarLineaDeNegocioTel();
  });

  function GetEmpresaTel(){
    $.ajax({
      type: "POST",
      url: "ajax_getcatalogempresas.php",
      dataType: "json",
      success: function(response) {
        //console.log(response.datos);
        $("#selempresaTel").empty(); 
        $('#selempresaTel').append('<option value="0">Empresa Destino</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#selempresaTel').append('<option value="' + (response.datos[i].idEmpresa) + '">' + response.datos[i].nombreEmpresa + '</option>');
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

  function cargarLineaDeNegocioTel(){
    $.ajax({
      type: "POST",
      url: "ajax_getcatlineanegocio.php",
      dataType: "json",
      async : false,
      success: function(response) {
        //console.log(response.datos);
        $('#selLineaDeNegocioTel').empty().append('<option value="0">Linea De Negocio</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#selLineaDeNegocioTel').append('<option value="' + (response.datos[i].idLineaNegocio) + '">' + response.datos[i].descripcionLineaNegocio + '</option>');
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






  function ValidacionesTelefonos(){
    alert("Hasta Aqui Llegaste");
  }

</script>