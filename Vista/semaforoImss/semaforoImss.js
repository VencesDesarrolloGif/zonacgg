// Función principal para consultar por mes y año
async function consultaPorMesyAnio() {
    waitingDialog.show();

    // Reiniciar variables
    tableICSOE = [];
    tableSISUB = [];
    tableMovimientos = [];
    tableOpIMSS = [];
    tableXMLImss = [];
    tableXMLInfonavit = [];

    arregloXCuatrimestre = [];
    arregloXmes = [];
    arregloRegPat = [];

    const anio = $("#selectAnioSemaforo").val();
    const mes = document.getElementById('selectMesSemaforo').value;
    
//!se puede usar de esta manera para enviar mas documentos
    // let body = JSON.stringify({
    //     anio: anio,
    //     mes: mes
    // });

    try {
        const response = await fetch("semaforoImss/ajax_ConsultaSemaforo.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
              },
              body: JSON.stringify({ mes })
              
        });

        const result = await response.json();

        if (result.status === "success") {
            $("#divTablas").show();
            waitingDialog.hide();

            // Cuatrimestres
            arregloXCuatrimestre.push(result.icsoe[0]);
            arregloXCuatrimestre.push(result.sisub[0]);
            loadDatatablaCuatrimestre(arregloXCuatrimestre);

            // Meses
            arregloXmes.push(result.movimientos[0]);
            arregloXmes.push(result.docOpImss[0]);
            arregloXmes.push(result.docXMLImss[0]);
            arregloXmes.push(result.docXMLInfonavit[0]);
            loadDataTableMeses(arregloXmes);

            // Registros patronales
            arregloRegPat = result.docRegPat;
            loadDataTableRegPatronales(arregloRegPat);
        } else {
            swal("Error", result.message, "error");
            waitingDialog.hide();
        }
    } catch (error) {
        console.error("Error en la consulta:", error);
        alert("Hubo un error al consultar los datos.");
        waitingDialog.hide();
    }
}

// Tablas
var tablaCuatrimestre = null;
function loadDatatablaCuatrimestre(data) {
    if (tablaCuatrimestre) tablaCuatrimestre.destroy();
    tablaCuatrimestre = $('#tablaCuatrimestre').DataTable({
        data,
        destroy: true,
        columns: [
            { data: "nombreDocumentoCuatri" },
            { data: "cuatrimestreUno" },
            { data: "cuatrimestreDos" },
            { data: "cuatrimestreTres" }
        ],
        processing: true,
        dom: 't',
        paging: false,
        info: false,
        searching: false,
        ordering: false,
        buttons: false
    });
}

var tablaMeses = null;
function loadDataTableMeses(data) {
    if (tablaMeses) tablaMeses.destroy();
    tablaMeses = $('#tablaMeses').DataTable({
        data,
        destroy: true,
        columns: Array.from({ length: 13 }, (_, i) => ({ data: String(i) })),
        processing: true,
        dom: 't',
        paging: false,
        info: false,
        searching: false,
        ordering: false,
        buttons: false
    });
}

var tablaRegistrosPatronales = null;
function loadDataTableRegPatronales(data) {
    if (tablaRegistrosPatronales) tablaRegistrosPatronales.destroy();
    tablaRegistrosPatronales = $('#tablaRegistrosPatronales').DataTable({
        data,
        destroy: true,
        columns: [
            { data: "idcatalogoRegistrosPatronales" },
            { data: "idseEBA" },
            { data: "idseEMA" },
            { data: "opInfonavit" },
            { data: "resumenLiquidacion" },
            { data: "LineaCaptura" },
            { data: "PuntoSUA" },
            { data: "PagoSUA" },
            { data: "infonavit" },
            { data: "imss" }
        ],
        processing: true,
        dom: 't',
        paging: false,
        info: false,
        searching: false,
        ordering: false,
        buttons: false
    });
}

// Abrir documentos
function abrirDocICSOE(nombreDoc) {
    window.open(`uploads/DocumentosICSOE/${nombreDoc}.pdf`, 'fullscreen=no');
}

function abrirDocSISUB(nombreDoc) {
    window.open(`uploads/DocumentosSISUB/${nombreDoc}.pdf`, 'fullscreen=no');
}

function abrirDocMovimientos(nombreDoc) {
    window.open(`uploads/movimientos/${nombreDoc}.zip`, 'fullscreen=no');
}

function abrirDocOpIMSS(anio, mes, nombreDoc) {
    const nombreCarpeta = mes + anio;
    window.open(`uploads/DocumentosOpinionCumplimiento/Imss/${nombreCarpeta}/${nombreDoc}.pdf`, 'fullscreen=no');
}

function abrirDocXMLIMSS(nombreDoc) {
    window.open(`uploads/DocumentosXMLIMSS/${nombreDoc}`, 'fullscreen=no');
}

function abrirDocXMLINFONAVIT(nombreDoc) {
    window.open(`uploads/DocumentosXMLINFONAVIT/${nombreDoc}`, 'fullscreen=no');
}

function abrirDocIDSEEBA(nombreDoc) {
    window.open(`uploads/DocumentosIDSEEBA/${nombreDoc}`, 'fullscreen=no');
}

function abrirDocIDSEEMA(nombreDoc) {
    window.open(`uploads/DocumentosIDSEEMA/${nombreDoc}`, 'fullscreen=no');
}

function abrirDocSUA(nombreDoc, carpeta) {
    window.open(`uploads/documentosContabilidad/pagoSua/${carpeta}/${nombreDoc}`, 'fullscreen=no');
}
