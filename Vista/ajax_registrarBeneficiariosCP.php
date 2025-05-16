<?php
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
verificarInicioSesion ($negocio);
if (!empty ($_POST)){
    try{
        // $log = new KLogger ( "registrarBeneficiariosCP.log" , KLogger::DEBUG );
        // $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
        $usuario = $_SESSION ["userLog"]["usuario"];

        $Entidad=getValueFromPost("numeroEmpleadoEntidadEdited");
        $Consecutivo=getValueFromPost("numeroEmpleadoConsecutivoEdited");
        $Tipo=getValueFromPost("numeroEmpleadoTipoEdited");

        $conteoBenef=getValueFromPost("conteoBenef");
        // $log->LogInfo("Valor de la variable conteoBenef: " . var_export ($conteoBenef, true));

        for($i=1; $i <= $conteoBenef; $i++) { 
            if($i=='1'){
                $idBeneficiario='14';
            }else{
                $idBeneficiario++;
            }
            $parentescoB=getValueFromPost("txtParentescoBeneficiarioCP".$i);
            $nombreB=getValueFromPost("txtNombreBeneficiarioCP".$i);
            $porcentajeB=getValueFromPost("txtPorcentajeBeneficiarioCP".$i);
            $negocio -> registrarBeneficiarios($Entidad,$Consecutivo,$Tipo,$parentescoB,$nombreB,$porcentajeB,$usuario,$i,$idBeneficiario);
        }
        $response ["status"] = "success";
        $response ["message"] = "Datos Familiares registrados Exitosamente";
    }catch (Exception $e){
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }
}else{
    $response ["status"] = "error";
    $response ["message"]= "No se proporcionaron datos";
}
echo json_encode ($response);
?>