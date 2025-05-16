
<?php
function crearColumnasPeriodoQuincenal ()
{
    $result = "";
    $currentDay = date ("d");
    $currentMonth = date ("m");
    $currentYear = date ("Y");

    $startDay = 1;
    $endDay = 15;

    if ($currentDay > 15)
    {
        $startDay = 16;
        $endDay = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
    }

    for ($i = $startDay; $i <= $endDay; $i++)
    {
        $result .= "<th>" . $i . "</th>";
    }

    return $result;
}
?>



<button id="guardar" name="guardar" class="btn btn-info" type="button" onclick="styleAsistencia();" > <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button>

<br>






<div class="containerTableRequisiciones"  align="left" STYLE="background-color:white">

    <div class="row"> <!-- div row -->

      <div class="span2" STYLE="background-color:white; border-style: dotted;"> <!-- div span4 -->
        <h3>Periodo</h3>

        <?php
            for ( $i=0; $i<count($catalogoPeriodos); $i++)
            {
              echo "<input type='radio' name='periodoOperaciones' id='".$catalogoPeriodos[$i]["tipoPeriodoId"] ."' value='".$catalogoPeriodos[$i]["tipoPeriodoId"] ."' >".$catalogoPeriodos[$i]["descripcionTipoPeriodo"]."<br>";
            }
            ?>

      </div> <!-- fin span 4 -->

    </div> <!-- fin div row -->

        <section>
         

            <table id="tableEmpleadosSupervisor" class="display" cellspacing="0" width="90%">
                <thead>
                    <tr>
                        <th># Empleado</th>
                        <th>Nombre Empleado</th>
                        <th>Puesto</th>
                        <th>Turno</th>
                        <th>Punto Servicio</th>
                        <?php echo crearColumnasPeriodoQuincenal (); ?>
                        </tr>
                </thead>
                 <tfoot>
                    <tr>
                        <th># Empleado</th>
                        <th>Nombre Empleado</th>
                        <th>Puesto</th>
                        <th>Turno</th>
                        <th>Punto Servicio</th>
                        <?php echo crearColumnasPeriodoQuincenal (); ?>
                        
                        </tr>
                </tfoot>

                <tbody></tbody>

            </table>
         
            
        </section>
        
</div>


<script type="text/javascript">





    var tableEmpleadosSupervisor = null;	

    function styleAsistencia(){
  //alert("HOLA");

  if (tableEmpleadosSupervisor != null)
        {
            tableEmpleadosSupervisor.destroy ();
        }

        tableEmpleadosSupervisor = $('#tableEmpleadosSupervisor').DataTable( {

        ajax: {
            url: 'ajax_obtenerEmpleadosBySupervisor.php'
            ,type: 'POST'
            ,data : {"fecha1":'2016-04-01', "fecha2":'2016-04-15', "periodoId":'1' }
            //,data : {"estatusEmpleado":2}
        }
        ,"columns": [
             { "data": "numeroEmpleado"}
            ,{ "data": "nombreEmpleado" }
            ,{ "data": "descripcionPuesto" }
            ,{ "data": "descripcionTurno" }
            ,{ "data": "puntoServicio" }   

<?php
    $currentDay = date ("d");
    $currentMonth = date ("m");
    $currentYear = date ("Y");

    $startDay = 1;
    $endDay = 15;

    if ($currentDay > 15)
    {
        $startDay = 16;
        $endDay = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
    }
    
    for ($i = $startDay; $i <= $endDay; $i++)
    {
        echo ',{ "data": "dia_' . $i . '" }';
    }

?>

        ]
        //,serverSide: true
        ,processing: true
        //,paging: false
        //,"aLengthMenu": [100]
        ,initComplete: function () {
            new $.fn.dataTable.KeyTable( tableEmpleadosSupervisor );
        }
    } );

}

</script>

