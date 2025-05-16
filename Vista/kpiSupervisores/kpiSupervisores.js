$(function() {
    const añoActual = new Date().getFullYear();
    const select = document.getElementById('selEjercicioKpiSup');
    const selectPeriodo = document.getElementById('selPeriodoKpiSup');

    // Agregar la opción por defecto "EJERCICIO"
    const opcionDefault = document.createElement('option');
    opcionDefault.value = "0";
    opcionDefault.textContent = "EJERCICIO";
    select.appendChild(opcionDefault);

    // Añadir años desde el actual hacia 2020
    for (let año = añoActual; año >= 2020; año--) {
        const option = document.createElement('option');
        option.value = año;
        option.textContent = año;
        select.appendChild(option);
    }

    // Agregar opción por defecto "PERIODO"
    const optionPeriodoDefault = document.createElement('option');
    optionPeriodoDefault.value = "0";
    optionPeriodoDefault.textContent = "PERIODO";
    selectPeriodo.appendChild(optionPeriodoDefault);

    // Añadir periodos del 1 al 24
    for (let i = 1; i <= 24; i++) {
        const option1 = document.createElement('option');
        option1.value = i;
        option1.textContent = i;
        selectPeriodo.appendChild(option1);
    }
});


$('#selEjercicioKpiSup').change(function(){
    $("#selMesKpiSup").val(0);
    $("#selPeriodoKpiSup").val(0);
});

$('#selMesKpiSup').change(function(){
    $("#selPeriodoKpiSup").val(0);
});

$('#selPeriodoKpiSup').change(function(){
    $("#selMesKpiSup").val(0);
});

$('#btnBuscarKpiSupervisor').click(function(){
    $("#FechaInicioBuscar").val("");
    $("#FechaFinBuscar").val("");
    $("#divFechasParaBuscar").hide();
    const selEjercicioKpiSup = $("#selEjercicioKpiSup").val();
    const selMesKpiSup = $("#selMesKpiSup").val();
    const selPeriodoKpiSup = $("#selPeriodoKpiSup").val();
    if(selEjercicioKpiSup == 0){
        swal.fire({ icon: 'error', title: 'ALTO', text: "SELECCIONA EL EJERCICIO PARA CONTINUAR" });
    }else if(selMesKpiSup == 0 && selPeriodoKpiSup == 0){
        swal.fire({ icon: 'error', title: 'ALTO', text: "SELECCIONA EL MES O EL PERIODO PARA CONTINUAR" });
    }else{
        if(selMesKpiSup != 0){
            ConsultarKpiSupervisor(selEjercicioKpiSup,selMesKpiSup,1); 
        }else{
            ConsultarKpiSupervisor(selEjercicioKpiSup,selPeriodoKpiSup,2); 
        }
    }
});

function ConsultarKpiSupervisor(Ejercicio,MesPeriodo,busqueda){
    if(busqueda == 1){// busqueda por mes
        if(MesPeriodo <= 9){
            MesPeriodo = "0"+MesPeriodo;
        }
        const fechaInicio = Ejercicio+"-"+MesPeriodo+"-01"; 
        const fechaFin1 = new Date(Ejercicio, MesPeriodo, 0).getDate();
        const fechaFin = Ejercicio+"-"+MesPeriodo+"-"+fechaFin1
        $("#FechaInicioBuscar").val(fechaInicio);
        $("#FechaFinBuscar").val(fechaFin);
        $("#divFechasParaBuscar").show();
    }else{
        let mes = Math.floor((MesPeriodo - 1) / 2); 
        let diaInicio, diaFin;
        if (MesPeriodo % 2 === 1) {
            diaInicio = 1;
            diaFin = 15;
        } else {
            diaInicio = 16;
            diaFin = new Date(Ejercicio, mes + 1, 0).getDate();
        }
        let fechaInicio = new Date(Ejercicio, mes, diaInicio);
        let fechaFin = new Date(Ejercicio, mes, diaFin);
        let inicio = `${fechaInicio.getFullYear()}-${(fechaInicio.getMonth() + 1).toString().padStart(2, '0')}-${fechaInicio.getDate().toString().padStart(2, '0')}`;
        let fin = `${fechaFin.getFullYear()}-${(fechaFin.getMonth() + 1).toString().padStart(2, '0')}-${fechaFin.getDate().toString().padStart(2, '0')}`;
        $("#FechaInicioBuscar").val(inicio);
        $("#FechaFinBuscar").val(fin);
        $("#divFechasParaBuscar").show();
    }
    var fechaIn = $("#FechaInicioBuscar").val();
    var fechaFi = $("#FechaFinBuscar").val();
    $('#divTablaKPIParaSupervisor').empty(); 
    $('#divparacanvasKpiSupervisor').empty(); 
    var fechasAsistenciaSupervisores = [];
    const fechas = [];
    const fechaActual = new Date(fechaIn);
    while (fechaActual <= new Date(fechaFi)) {
        fechaActual.setDate(fechaActual.getDate() + 1); 
        fechas.push(new Date(fechaActual));
    }

    tableSupervisoresB = "<table class='table table-bordered table-striped'>";
    tableSupervisoresB += "<thead><tr><th rowspan='2' colspan='2'># Supervisor</th><th rowspan='2' colspan='2'>Nombre Supervisor</th>";
    const diasDeLaSemana = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];
    for (var i = 0; i < fechas.length ; i++) {
        var fecha = fechas[i];
        const diaSemana = diasDeLaSemana[fecha.getDay()];
        const diaDelMes = fecha.getDate().toString().padStart(2, '0');
        const mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
        const anio = (fecha.getFullYear()).toString().padStart(4, '0');
        const dia = `${anio}-${mes}-${diaDelMes}`;
        const anioa = `${anio}`.toString().slice(-2);
        fechasAsistenciaSupervisores.push(dia);
        tableSupervisoresB += "<th colspan='2'>" + `${diaSemana} ${diaDelMes}-${mes}-`+anioa+"</th>";
    }
    tableSupervisoresB += "</tr><tr>";
    for (var i = 0; i < fechas.length; i++) {
        tableSupervisoresB += "<th>calif. Superv </th><th>% Asis</th>";
    }
    tableSupervisoresB += "</tr></thead><tbody>";  // Aquí empieza el cuerpo de la tabla

    $('#divTablaKPIParaSupervisor').html(tableSupervisoresB);
    
    ObtenerDatosSupervisiones(fechasAsistenciaSupervisores);
}

async function ObtenerDatosSupervisiones(fechasAsistenciaSupervisores) {
    var kpis1 = [];
    var kpis11 = [];
    var supervisiones1 = [];
    var tableRows = "";
    var fechas = []; // Para almacenar las fechas de cada supervisor

    $.ajax({
        type: "POST",
        url: "kpiSupervisores/ajax_ObtenerKPIDeSupervisores.php",
        data: { "fechasAsistenciaSupervisores": fechasAsistenciaSupervisores },
        dataType: "json",
        async: false,
        success: function (response) {
            if (response.status === "success") {

                //tabla calificaciones//
                tablaCalif = "<table class='table table-bordered table-striped'>";
                tablaCalif += "<thead><tr><th rowspan='1' colspan='1'>Numero de supervisiones</th><th rowspan='1' colspan='1'>Calificación</th></thead>";
                tablaCalif += "<tbody>";
                for (var j = 0; j < response.calificaciones.length; j++) {
                    tablaCalif += "<tr><td colspan='1'>" + response.calificaciones[j]["NumeroSupervisiones"] + "</td><td colspan='1'>" + response.calificaciones[j]["Calificacion"] + "</td></tr>";
                }
                tablaCalif += "<tbody>";  // Aquí empieza el cuerpo de la tabla

                $('#divTablaCalificaciones').html(tablaCalif);
                ////////////////////////
                var resultado = response.resulta;
                var numero = resultado.numero;
                var nombre = resultado.nombre;

                for (var i = 0; i < fechasAsistenciaSupervisores.length; i++) {
                    var fecha = fechasAsistenciaSupervisores[i];
                    var kpi = resultado[fecha].kpi || 0; 
                    var supervisiones = resultado[fecha].supervisiones || 0;  
                    kpis1.push(kpi);  // Almacena el valor del KPI
                    supervisiones1.push(supervisiones);  // Almacena el valor de las supervisiones
                    fechas.push(fecha);  // Almacena la fecha
                    kpis11.push("<td>" + supervisiones + "</td><td>" + kpi + "%</td>");
                }

                tableRows += "<tr><td colspan='2'>" + numero + "</td><td colspan='2'>" + nombre + "</td>" + kpis11.join('') + "</tr>";

                // Finalmente, agregar las filas a la tabla
                $('#divTablaKPIParaSupervisor').find('tbody').html(tableRows);

                // Llamar a la función para crear las gráficas después de recibir los datos
                canvasparakpisupervisiones = "<canvas id='canvaskpisupervisones' style='height: 500px; width: 900px;display: inline;'></canvas>";
                $('#divparacanvasKpiSupervisor').html(canvasparakpisupervisiones);
                canvasparasupervisionessuper = "<canvas id='canvassupervisionesupervisores' style='height: 500px; width: 900px;display: inline;'></canvas>";
                $('#divparacanvasCalifiacionSupervisor').html(canvasparasupervisionessuper);
                crearGraficaKPI(kpis1, fechas);
                crearGraficaSupervisiones(supervisiones1, fechas);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
}

function crearGraficaKPI(kpis, fechas) {
    var ctx = document.getElementById('canvaskpisupervisones').getContext('2d');
    var graficaKpi = new Chart(ctx, {
        type: 'line',
        data: {
            labels: fechas,
            datasets: [{
                label: '% ASISTENCIA',
                data: kpis,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
}

function crearGraficaSupervisiones(supervisiones, fechas) {
    var ctx2 = document.getElementById('canvassupervisionesupervisores').getContext('2d');
    
    // Mapeamos los valores de 'supervisiones' a colores según el valor
    var colores = supervisiones.map(valor => {
        return valor <= 5 ? 'rgba(255, 99, 132, 1)' : 'rgba(75, 192, 192, 1)'; // Rojo si <= 5, Verde si > 5
    });

    var graficaSupervisiones = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: fechas,
            datasets: [{
                label: 'CALIFICACIÓN',
                data: supervisiones,
                borderColor: colores,
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: colores // Aquí asignamos los colores de los puntos
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 10
                }
            }
        }
    });
}
// function crearGraficaSupervisiones(supervisiones, fechas) {
//     var ctx2 = document.getElementById('canvassupervisionesupervisores').getContext('2d');
//     var graficaSupervisiones = new Chart(ctx2, {
//         type: 'line',
//         data: {
//             labels: fechas,
//             datasets: [{
//                 label: 'CALIFICACIÓN',
//                 data: supervisiones,
//                 borderColor: 'rgba(153, 102, 255, 1)',
//                 backgroundColor: 'rgba(153, 102, 255, 0.2)',
//                 fill: true,
//                 tension: 0.4
//             }]
//         },
//         options: {
//             responsive: true,
//             scales: {
//                 y: {
//                     beginAtZero: true,
//                     max: 10
//                 }
//             }
//         }
//     });
// }
