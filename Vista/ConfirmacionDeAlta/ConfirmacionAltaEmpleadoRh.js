function ConsultarEmpleadosDeRhParaAlta() {
  waitingDialog.show();
  empleadosParaAlta = [];
  $.ajax({
    type: "POST",
    url: "ConfirmacionDeAlta/obtener_empleadosParaAlta.php",
    dataType: "json",
    async: false,
    success: function (response) {
      if (response.status == "success") {
        for (var i = 0; i < response.datos.length; i++) {
          var record = response.datos[i];
          empleadosParaAlta.push(record);
        }
        loadDataIntableEmpleadosRhParaAlta(empleadosParaAlta);
        $("#tablaEmpleadosParaAlta").show();
        waitingDialog.hide();
      } else {
        var mensaje = response.message;
        alert(mensaje);
        waitingDialog.hide();
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
      waitingDialog.hide();
    },
  });
}

var tablaDePeticionesempleadosParaAlta = null;

function loadDataIntableEmpleadosRhParaAlta(data) {
  if (tablaDePeticionesempleadosParaAlta != null) {
    tablaDePeticionesempleadosParaAlta.destroy();
  }
  tablaDePeticionesempleadosParaAlta = $("#tablaEmpleadosParaAlta").DataTable({
    language: {
      emptyTable: "No hay registro disponible",
      info: "Del _START_ al _END_ de _TOTAL_",
      infoEmpty: "Mostrando 0 registros de un total de 0.",
      infoFiltered: "(filtrados de un total de _MAX_ registros)",
      infoPostFix: "(actualizados)",
      lengthMenu: "Mostrar _MENU_ registros",
      loadingRecords: "Cargando....",
      processing: "Procesando....",
      search: "Buscar:",
      searchPlaceholder: "Dato para buscar",
      zeroRecords: "no se han encontrado coincidencias",
      paginate: {
        first: "Primera",
        last: "Ultima",
        next: "Siguiente",
        previous: "Anterior",
      },
      aria: {
        sortAscending: "Ordenación ascendente",
        sortDescending: "Ordenación descendente",
      },
    },
    data: data,
    destroy: true,
    columns: [
      {
        data: "Foto",
      },
      {
        data: "NumeroEmpleado",
      },
      {
        data: "NombreEmpleadoo",
      },
      {
        data: "Entidad",
      },
      {
        data: "puesto",
      },
      {
        data: "Turno",
      },
      {
        data: "Punto",
      },
      {
        data: "plantilla",
      },
      {
        data: "FechaIngreso",
      },
      {
        data: "Acciones",
      },
      {
        data: "Acciones1",
      },
    ],
    processing: true,
    dom: "Bfrtip",
    buttons: {
      buttons: ["excel", "pdf"],
    },
  });
}
function ConfirmarEmpleado(numeroEmpleado, nombreEmpleado, Caso) {
  // Obtener la hora actual
  var horaActual = new Date().getHours();
  // Verificar si la hora es mayor o igual a 16 (4 PM)
  if (horaActual >= 16) {
    // Mostrar alerta si es después de las 4 PM
    swal.fire({
      icon: "error",
      title: "ATENCION",
      text: "No se puede realizar esta acción ya que estas fuera de horario (hora maxima 16:00:00 hrs).",
    });
  } else {
    console.log(numeroEmpleado);
    // Si es antes de las 4 PM, continuar con la acción original
    $("#NumEmpAltaEmpleadoRhHidden").val(numeroEmpleado);
    $("#txtNombrEmpleadoDefinitivoAlta").val(nombreEmpleado);
    $("#txtcaso").val(Caso);
    $("#modalFirmaAltaEmpleadoRh").modal();
  }
}

function RevisarFirmaAltaEmpleadoRh() {
  var NumEmpModalBaja = $("#NumEmpModalFirmaAltaEmpleadoRh").val();
  var constraseniaFirma = $("#constraseniaFirmaAltaEmpleadoRh").val();
  var nombreEmpleado = $("#txtNombrEmpleadoDefinitivoAlta").val();
  var numeroEmpleado = $("#NumEmpAltaEmpleadoRhHidden").val();
  if (NumEmpModalBaja == "") {
    cargaerroresFirmaInternaAltaEmpleadoRh(
      "El numero de empleado no puede estar vacio"
    );
  } else if (constraseniaFirma == "") {
    cargaerroresFirmaInternaAltaEmpleadoRh(
      "Escriba la contraseña para continuar"
    );
  } else {
    $.ajax({
      type: "POST",
      url: "ajax_getFirmaSolicitada.php",
      data: {
        NumEmpModalBaja: NumEmpModalBaja,
        constraseniaFirma: constraseniaFirma,
      },
      dataType: "json",
      success: function (response) {
        if (response.status == "success") {
          var RespuestaLargo = response["datos"].length;
          if (RespuestaLargo == "0") {
            cargaerroresFirmaInternaAltaEmpleadoRh(
              "La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro"
            );
          } else {
            var contraseniaInsertadaCifrada =
              response.datos["0"].ContraseniaFirma;
            $("#constraseniaFirmaAltaEmpleadoRhHidden").val(
              contraseniaInsertadaCifrada
            );
            $("#NumEmpModalFirmaAltaEmpleadoRhhidden").val(NumEmpModalBaja);
            $("#modalFirmaAltaEmpleadoRh").modal("hide");
            $("#NumEmpModalFirmaAltaEmpleadoRh").val("");
            $("#constraseniaFirmaAltaEmpleadoRh").val("");
            var Caso = $("#txtcaso").val();
            if (Caso == 1) {
              guardarEdicionEmpledoRh();
            } else {
              $("#modalCancelacionEnvioAlta").modal();
              $("#txtEmpleadoSinImssDefinitivoAlta").val(nombreEmpleado);
              obtenerCatalogoMotivoNoAlta();
            }
          }
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      },
    });
  }
}

function cargaerroresFirmaInternaAltaEmpleadoRh(mensaje) {
  $("#errormodalFirmaAltaEmpleadoRh").fadeIn();
  msjerrorbaja =
    "<div id='errormodalFirmaAltaEmpleadoRh1' class='alert alert-error'><strong>ALERTA:</strong> " +
    mensaje +
    " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
  $("#errormodalFirmaAltaEmpleadoRh").html(msjerrorbaja);
  $(document).scrollTop(0);
  $("#errormodalFirmaAltaEmpleadoRh").delay(4000).fadeOut("slow");
}

function cancelarFirmaAltaEmpleadoRh() {
  $("#modalFirmaAltaEmpleadoRh").modal("hide");
}

function guardarEdicionEmpledoRh() {
  var NumeroFirma = $("#NumEmpModalFirmaAltaEmpleadoRhhidden").val();
  var ContraseniaFirma = $("#constraseniaFirmaAltaEmpleadoRhHidden").val();
  var numeroEmp = $("#NumEmpAltaEmpleadoRhHidden").val();

  $.ajax({
    type: "POST",
    url: "ConfirmacionDeAlta/ajax_ActualizarEmpleadoParaImss.php",
    data: {
      NumeroFirma: NumeroFirma,
      ContraseniaFirma: ContraseniaFirma,
      numeroEmp: numeroEmp,
    },
    dataType: "json",
    success: function (response) {
      var msj = response.message;
      if (response.status == "success") {
        AletaParaAltaEmpleadoRh(msj, "success");
        $("#modalFirmaAltaEmpleadoRh").modal("hide");
        ConsultarEmpleadosDeRhParaAlta();
      } else {
        AletaParaAltaEmpleadoRh(msj, "error");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    },
  });
}

function obtenerCatalogoMotivoNoAlta() {
  $.ajax({
    type: "POST",
    url: "ConfirmacionDeAlta/ajax_CatalogoMotivoNoAlta.php",
    dataType: "json",
    success: function (response) {
      if (response.status == "success") {
        var datos = response.datos;
        $("#selMotivoNoAlta")
          .empty()
          .append('<option value="0">SELECCIONA..</option>');
        $.each(datos, function (i) {
          $("#selMotivoNoAlta").append(
            '<option value="' +
              response.datos[i].idMotivo +
              '">' +
              response.datos[i].Descripcion +
              "</option>"
          );
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    },
  });
}

function actualizarEstatusImssDefinitivoEnAlta() {
  var numeroEmpleado = $("#NumEmpAltaEmpleadoRhHidden").val();
  var comentario = $("#selMotivoNoAlta").val();
  var contraseniaInsertadaCifrada = $(
    "#constraseniaFirmaAltaEmpleadoRhHidden"
  ).val();
  var NumEmpModal = $("#NumEmpModalFirmaAltaEmpleadoRhhidden").val();
  var estatusImss = 8;
  if (comentario == 0) {
    var alertMsg1 =
      "<div id='msgAlert' class='alert alert-error'><strong>Error: </strong>Seleccione un motivo<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#alertMsgDefinitivoAlta").html(alertMsg1);
    $("#msgAlert").delay(3000).fadeOut("slow");
  } else {
    $.ajax({
      type: "POST",
      url: "ajax_actualizarEstatusDefinitivo.php",
      data: {
        numeroEmpleado: numeroEmpleado,
        estatusImss: estatusImss,
        comentario: comentario,
        contraseniaInsertadaCifrada: contraseniaInsertadaCifrada,
        NumEmpModal: NumEmpModal,
      },
      dataType: "json",
      success: function (response) {
        var mensaje = response.message;

        if (response.status == "success") {
          //alert(mensaje);
          $("#txtNumEmpleadoDefinitivoAlta").val("");
          $("#selMotivoNoAlta").val(0);
          $("#modalCancelacionEnvioAlta").modal("hide");
          ConsultarEmpleadosDeRhParaAlta();
        } else if (response.status == "error") {
          var alertMsg1 =
            "<div id='msgAlert' class='alert alert-error'><strong>Error: </strong>" +
            mensaje +
            "<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

          $("#alertMsgDefinitivoAlta").html(alertMsg1);
          $("#msgAlert").delay(3000).fadeOut("slow");
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      },
    });
  }
}

function AletaParaAltaEmpleadoRh(mensaje, tipo = "warning") {
  swal.fire({
    icon: tipo,
    title: "ATENCION",
    text: mensaje,
  });
}
