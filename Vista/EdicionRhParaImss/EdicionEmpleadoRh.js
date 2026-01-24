function ConsultarEmpleadosDeRhParaImss() {
  waitingDialog.show();
  empleadosParaImss = [];
  $.ajax({
    type: "POST",
    url: "EdicionRhParaImss/obtener_empleadosImssParaEdicion.php",
    dataType: "json",
    async: false,
    success: function (response) {
      if (response.status == "success") {
        for (var i = 0; i < response.datos.length; i++) {
          var record = response.datos[i];
          empleadosParaImss.push(record);
        }
        loadDataIntableEmpleadosRhParaImss(empleadosParaImss);
        $("#tablaEmpleadosParaImss").show();
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

var tablaDePeticionesempleadosParaImss = null;

function loadDataIntableEmpleadosRhParaImss(data) {
  if (tablaDePeticionesempleadosParaImss != null) {
    tablaDePeticionesempleadosParaImss.destroy();
  }
  tablaDePeticionesempleadosParaImss = $("#tablaEmpleadosParaImss").DataTable({
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
        data: "empleadoNumeroSeguroSocial",
      },
      {
        data: "Acciones",
      },
    ],
    processing: true,
    dom: "Bfrtip",
    buttons: {
      buttons: ["excel", "pdf"],
    },
  });
}
const RUTA_FOTOS = "thumbs/";
const FOTO_POR_DEFECTO = "https://via.placeholder.com/150";

function CorregirEmpleado(
  numeroEmpleado,
  nombreEmpleado,
  apellidoPaterno,
  apellidoMaterno,
  empleadoNumeroSeguroSocial,
  fotoEmpleado, // nombre del archivo
  fecha
) {
  // document.getElementById("fileFotoEmpleadoNuevaRh").value = "";
  let urlFoto = FOTO_POR_DEFECTO;
  if (fotoEmpleado && fotoEmpleado !== "") {
    urlFoto = RUTA_FOTOS + fotoEmpleado;
  }
  if (fotoEmpleado && fotoEmpleado.startsWith("http")) {
    urlFoto = fotoEmpleado;
  }
  $("#fileFotoEmpleadoNuevaRh").val("");
  $(".custom-file-label").html(
    '<i class="fas fa-upload"></i> Subir/Cambiar Foto'
  );

  $("#editNumeroEmpleadoRh").val(numeroEmpleado);
  $("#editNombre").val(nombreEmpleado);
  $("#editApellidoP").val(apellidoPaterno);
  $("#editApellidoM").val(apellidoMaterno);
  $("#editNss").val(empleadoNumeroSeguroSocial);

  $("#editNombrehidden").val(nombreEmpleado);
  $("#editApellidoPhidden").val(apellidoPaterno);
  $("#editApellidoMhidden").val(apellidoMaterno);
  $("#editNsshidden").val(empleadoNumeroSeguroSocial);

  $("#FechaIngresoEmpleadoRh").val(fecha);
  $("#editFotoPreview").attr("src", urlFoto);
  $("#modalEditarEmpleadosRhParaImss").modal();
}

$("#btnGuardarEdicionEmpleadosRh").click(function () {
  var editNumeroEmpleadoRh = $("#editNumeroEmpleadoRh").val();
  var editNombre = $("#editNombre").val();
  var editApellidoP = $("#editApellidoP").val();
  var editNss = $("#editNss").val();
  if (editNumeroEmpleadoRh == "") {
    AletaParaEdicionEMpleadoRh(
      "El Numero De Empleado No Puede Estar Vacio Ya Que Este Campo No Deberia Poderse Modificar",
      "error"
    );
  } else if (editNombre == "") {
    AletaParaEdicionEMpleadoRh("El Nombre No Puede Estar Vacio", "error");
  } else if (editApellidoP == "") {
    AletaParaEdicionEMpleadoRh(
      "El Apellido Paterno No Puede Estar Vacio",
      "error"
    );
  } else if (editNss == "") {
    AletaParaEdicionEMpleadoRh(
      "El Numero De Seguro Social No Puede Estar Vacio",
      "error"
    );
  } else {
    $("#modalEditarEmpleadosRhParaImss").modal("hide");
    $("#modalFirmaEdicionEmpleadoRh").modal();
  }
});

function RevisarFirmaEdicionEmpleadoRhParaImss() {
  var NumEmpModalBaja = $("#NumEmpModalFirmaEdicionEmpleadoRh").val();
  var constraseniaFirma = $("#constraseniaFirmaEdicionEmpleadoRh").val();
  if (NumEmpModalBaja == "") {
    cargaerroresFirmaInternaEdicionEmpleadoRh(
      "El numero de empleado no puede estar vacio"
    );
  } else if (constraseniaFirma == "") {
    cargaerroresFirmaInternaEdicionEmpleadoRh(
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
            cargaerroresFirmaInternaEdicionEmpleadoRh(
              "La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro"
            );
          } else {
            var contraseniaInsertadaCifrada =
              response.datos["0"].ContraseniaFirma;
            $("#constraseniaFirmaEdicionEmpleadoRhHidden").val(
              contraseniaInsertadaCifrada
            );
            $("#NumEmpModalFirmaEdicionEmpleadoRhhidden").val(NumEmpModalBaja);
            $("#modalFirmaEdicionEmpleadoRh").modal("hide");
            $("#NumEmpModalFirmaEdicionEmpleadoRh").val("");
            $("#constraseniaFirmaEdicionEmpleadoRh").val("");
            guardarEdicionEmpledoRhParaImss();
          }
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      },
    });
  }
}

function cargaerroresFirmaInternaEdicionEmpleadoRh(mensaje) {
  $("#errormodalFirmaEdicionEmpleadoRh").fadeIn();
  msjerrorbaja =
    "<div id='errormodalFirmaEdicionEmpleadoRh1' class='alert alert-error'><strong>ALERTA:</strong> " +
    mensaje +
    " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
  $("#errormodalFirmaEdicionEmpleadoRh").html(msjerrorbaja);
  $(document).scrollTop(0);
  $("#errormodalFirmaEdicionEmpleadoRh").delay(4000).fadeOut("slow");
}

function cancelarFirmaEdicionEmpleadoRh() {
  $("#modalFirmaEdicionEmpleadoRh").modal("hide");
  $("#modalEditarEmpleadosRhParaImss").modal("show");
  $("#NumEmpModalFirmaEdicionEmpleadoRh").val("");
  $("#constraseniaFirmaEdicionEmpleadoRh").val("");
}

function guardarEdicionEmpledoRhParaImss() {
  console.log("!-- Guardando Edicion Empleado RH Para IMSS --!");
  var editNumeroEmpleadoRh = $("#editNumeroEmpleadoRh").val();
  var editNombre = $("#editNombre").val();
  var editApellidoP = $("#editApellidoP").val();
  var editApellidoM = $("#editApellidoM").val();
  var editNss = $("#editNss").val();
  var archivoFoto = $("#fileFotoEmpleadoNuevaRh").val();
  var FechaIngresoEmpleadoRh = $("#FechaIngresoEmpleadoRh").val();
  var NumeroFirma = $("#NumEmpModalFirmaEdicionEmpleadoRhhidden").val();
  var ContraseniaFirma = $("#constraseniaFirmaEdicionEmpleadoRhHidden").val();
  var editNombrehidden = $("#editNombrehidden").val();
  var editApellidoPhidden = $("#editApellidoPhidden").val();
  var editApellidoMhidden = $("#editApellidoMhidden").val();
  var editNsshidden = $("#editNsshidden").val();

  var formData = new FormData($("#formEdicionEmpleadoRh")[0]);
  formData.append("editNumeroEmpleadoRh", editNumeroEmpleadoRh);
  formData.append("editNombre", editNombre);
  formData.append("editApellidoP", editApellidoP);
  formData.append("editApellidoM", editApellidoM);
  formData.append("editNss", editNss);
  formData.append("archivoFoto", archivoFoto);
  formData.append("NumeroFirma", NumeroFirma);
  formData.append("ContraseniaFirma", ContraseniaFirma);
  formData.append("FechaIngresoEmpleadoRh", FechaIngresoEmpleadoRh);
  formData.append("editNombrehidden", editNombrehidden);
  formData.append("editApellidoPhidden", editApellidoPhidden);
  formData.append("editApellidoMhidden", editApellidoMhidden);
  formData.append("editNsshidden", editNsshidden);
  console.log(formData);
  $.ajax({
    type: "POST",
    url: "EdicionRhParaImss/ajax_ActualizarYCargarFotoEmpleado.php",
    data: formData,
    dataType: "json",
    cache: false,
    contentType: false,
    processData: false,
    success: function (response) {
      var msj = response.message;
      if (response.status == "success") {
        AletaParaEdicionEMpleadoRh(msj, "success");
        $("#modalEditarEmpleadosRhParaImss").modal("hide");
        ConsultarEmpleadosDeRhParaImss();
      } else {
        AletaParaEdicionEMpleadoRh(msj, "error");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    },
  });
}

function mostrarVistaPrevia(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      // 1. Sustituye la foto en la vista previa
      $("#editFotoPreview").attr("src", e.target.result);
    };

    // 2. Actualiza el texto del label personalizado (conservando el icono)
    var fileName = input.files[0].name;
    $(".custom-file-label").html(
      '<i class="fas fa-file-image"></i> ' + fileName
    );

    // Lee el archivo de imagen como una URL de datos (Data URL)
    reader.readAsDataURL(input.files[0]);
  } else {
    // Si no hay archivo seleccionado (ej. al cancelar la selección)
    $(".custom-file-label").html(
      '<i class="fas fa-upload"></i> Subir/Cambiar Foto'
    );
    $("#editFotoPreview").attr("src", FOTO_POR_DEFECTO); // O la URL de la foto original
  }
}

function AletaParaEdicionEMpleadoRh(mensaje, tipo = "warning") {
  swal.fire({
    icon: tipo,
    title: "ATENCION",
    text: mensaje,
  });
}

// Función para convertir un elemento a mayúsculas mientras se escribe
function convertirAMayusculas(element) {
  element.value = element.value.toUpperCase();
}

// Aplicar la conversión a mayúsculas a los campos relevantes
$(document).ready(function () {
  // Escucha el evento 'input' en los campos del formulario de edición.
  // Esto asegura que la conversión suceda en tiempo real mientras el usuario escribe.

  $("#editNombre").on("input", function () {
    convertirAMayusculas(this);
  });

  $("#editApellidoP").on("input", function () {
    convertirAMayusculas(this);
  });

  $("#editApellidoM").on("input", function () {
    convertirAMayusculas(this);
  });

  $("#editNss").on("input", function () {
    // Opcional: El NSS podría no necesitar mayúsculas, pero lo incluimos si es necesario.
    convertirAMayusculas(this);
  });

  // El campo 'editNumeroEmpleadoRh' es readonly, no necesita conversión.
  // El campo 'editComentario' está disabled, tampoco necesita conversión.
});
