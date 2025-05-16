<style type="text/css">
    /* Estilo para las tablas */
    .tabla-estilizada {
        border: 1px solid #ccc;
        border-collapse: collapse;
        width: 100%;
        font-family: 'Arial', sans-serif;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
        table-layout: fixed; /* Hace que la tabla se ajuste a su contenedor */
    }

    .tabla-estilizada td,
    .tabla-estilizada th {
        padding: 12px 15px;
        text-align: center;
        border: 1px solid #ddd;
        font-size: 14px;
    }

    .tabla-estilizada th {
        background-color:rgb(253, 1, 224); /* Azul claro */
        color: white;
        font-weight: bold;
        text-transform: uppercase;
    }

    .tabla-estilizada tr:nth-child(even) {
        background-color:rgb(249, 199, 223); /* Azul muy claro para las filas alternas */
    }

    .tabla-estilizada tr:hover {
        background-color:rgb(239, 133, 229); /* Azul suave al pasar el ratón */
    }

    /* Contenedor de la tabla para adaptarse al tamaño de la pantalla */
    .tabla-container {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch; /* Para mejorar la experiencia en dispositivos táctiles */
        margin-bottom: 20px;
    }

    /* Estilo para los selectores */
    select {
        padding: 10px;
        margin: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
        font-size: 14px;
        background-color: rgb(250, 183, 224); /* Azul claro */
        transition: background-color 0.3s ease;
        cursor: pointer;
        color: white;
    }

    select:focus {
        border-color:rgb(250, 183, 224); /* Azul brillante */
        background-color:rgb(250, 183, 224); /* Azul más claro cuando está enfocado */
        outline: none;
    }

    /* Estilo para los botones */
    .btn-semaforo {
        padding: 10px 20px;
        background-color: rgb(253, 1, 224); /* Azul más oscuro */
        color: white;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        white-space: nowrap;
        border-color: #4682b4;
        font-color
    }

    .btn-semaforo:hover {
        background-color: white;
        color: rgb(253, 1, 224);
        border-color: #4682b4;
    }

    .btn-semaforo:focus {
        outline: none;
    }

    /* Estilo para el título y los contenedores */
    h4 {
        font-family: 'Arial', sans-serif;
        font-size: 24px;
        color: #333;
    }

    .label {
        font-size: 16px;
        color: #555;
    }

    .control-label {
        font-weight: bold;
    }

    /* Diseño centrado y espaciado */
    .centered-container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        margin-top: 20px;
    }

    .centered-container select {
        margin: 10px;
    }
</style>

<div class="centered-container">
    <h4>SEMAFORO</h4>  

    <label class="control-label" for="selectMesSemaforo">MES:</label>
    <select id="selectMesSemaforo" name="selectMesSemaforo">
        <option value="01">Enero</option>
        <option value="02">Febrero</option>
        <option value="03">Marzo</option>
        <option value="04">Abril</option>
        <option value="05">Mayo</option>
        <option value="06">Junio</option>
        <option value="07">Julio</option>
        <option value="08">Agosto</option>
        <option value="09">Septiembre</option>
        <option value="10">Octubre</option>
        <option value="11">Noviembre</option>
        <option value="12">Diciembre</option>
    </select>

    <button class="btn-semaforo" onclick="consultaPorMesyAnio()">Consultar</button>
</div>

<section>
    <center>
        <div id="divTablas" style="display: none;">

            <h2>CUATRIMESTRE</h2>
            <div class="tabla-container">
                <table id="tablaCuatrimestre" class="tabla-estilizada">
                    <thead>
                        <tr>
                            <th>DOCUMENTO</th>
                            <th>ENERO-ABRIL</th>
                            <th>MAYO-AGOSTO</th>
                            <th>SEPTIEMBRE-DICIEMBRE</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <h2>MESES</h2>
            <div class="tabla-container">
                <table id="tablaMeses" class="tabla-estilizada">
                    <thead>
                        <tr>
                            <th>DOCUMENTO</th>
                            <th>ENERO</th>
                            <th>FEBRERO</th>
                            <th>MARZO</th>
                            <th>ABRIL</th>
                            <th>MAYO</th>
                            <th>JUNIO</th>
                            <th>JULIO</th>
                            <th>AGOSTO</th>
                            <th>SEPTIEMBRE</th>
                            <th>OCTUBRE</th>
                            <th>NOVIEMBRE</th>
                            <th>DICIEMBRE</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <h2>REGISTROS PATRONALES</h2>
            <div class="tabla-container">
                <table id="tablaRegistrosPatronales" class="tabla-estilizada">
                    <thead>
                        <tr>
                            <th>REGISTRO PATRONAL</th>
                            <th>IDSE EBA</th>
                            <th>IDSE EMA</th>
                            <th>OPINIÓN INFONAVIT</th>
                            <th>RESUMEN LIQUIDACION(SUA)</th>
                            <th>LINEA DE CAPTURA(SUA)</th>
                            <th>PUNTO SUA</th>
                            <th>PAGO SUA</th>
                            <th>INFONAVIT</th>
                            <th>IMSS</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </center>
</section>
<script src="semaforoImss/semaforoImss.js"></script>
