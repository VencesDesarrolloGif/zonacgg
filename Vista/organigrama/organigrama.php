<!DOCTYPE html>
  <html lang="en">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>ORGANIGRAMA</title>
  <!-- <link href="organigrama/css/jquery.orgchart.css" rel="stylesheet"/> -->
  <script src = "organigrama/OrgChart.js" ></script> 
  <style type="text/css"> 
    html, body{
      width: 100%;
      height: 100%;
      padding: 0;
      margin:0;
      overflow: hidden;
      font-family: Helvetica;
    }
    #tree{
      width:100%;
      height:100%;
    }
  </style>
  <body>
    <center>
      <!-- <h2>GIF SEGURIDAD PRIVADA,S.A. DE C.V.</h2> -->
      <!-- <br> -->
      <!-- <br> -->
     <!-- <div> -->
     <!-- </div> -->
<!-- <br> -->
<!-- <br> -->
      <table>
        <tr>
          <td valign="top"  align="center">
            <select id="selectLineaNegocio">
              <option value="0">LINEAS DE NEGOCIO</option>
            </select>
          </td>
          <td valign="top" align="center">
            <select id="selectentidad">
              <option>ENTIDADES</option>
            </select>
          </td>
          <td valign="top">
            <button id="btnagregarEntidad" class="btn btn-default" onclick="agregarEntidad(1)" disabled><span class="glyphicon glyphicon-plus"></span>Agregar</button>
          </td>
          <td valign="top">
            <button id="btnagregarEntidad" class="btn btn-default" onclick="crearConfiguracionesOrganigrama()"><span ></span>Generar</button>
          </td>
        </tr>
        <tr>
          <td colspan="3" align="center">
            <div id="entidadesAgregadas"></div>
          </td>
        </tr>
      </table>

    </center>
    <div id="tree" ></div>
    <script src="organigrama/organigrama.js"></script>
  </body>
</html>

