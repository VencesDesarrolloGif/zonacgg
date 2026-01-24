<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
$log = new KLogger ( "ajax_ActualizarYCargarFotoEmpleado.log" , KLogger::DEBUG );
$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
$log->LogInfo("Valor de la variable _SESSION: " . var_export ($_SESSION, true));
$log->LogInfo("Valor de la variable _FILES: " . var_export ($_FILES, true));
$response= array();
$Numero             = $_POST["editNumeroEmpleadoRh"];
$Nombre             = $_POST["editNombre"];
$ApellidoP          = $_POST["editApellidoP"];
$ApellidoM          = $_POST["editApellidoM"];
$Nss                = $_POST["editNss"];
$Foto               = $_POST["archivoFoto"];
$FechaI             = $_POST["FechaIngresoEmpleadoRh"];
$NumeroFirma        = $_POST["NumeroFirma"];
$ContraseniaFirma   = $_POST["ContraseniaFirma"];
$Nombrehidden       = $_POST["editNombrehidden"];
$ApellidoPhidden    = $_POST["editApellidoPhidden"];
$ApellidoMhidden    = $_POST["editApellidoMhidden"];
$Nsshidden          = $_POST["editNsshidden"];
$permitidos1        = "image/jpeg";
$permitidos2        = "image/png";
$permitidos         = "image/jpg";
$usuarioCaptura     = $_SESSION ["userLog"]["usuario"];
$correcto           = true;
$foto               = false;
$NumeroExplde       = explode("-", $Numero);

if($Foto == "" && $Nombre == $Nombrehidden && $ApellidoP == $ApellidoPhidden && $ApellidoM == $ApellidoMhidden && $Nss == $Nsshidden){
    $response["status"] = "error";
    $response["message"]= "No se realizaron cambios";
    echo json_encode($response);
    return;
}else{
    $sql = "UPDATE empleados set ";
    if($Foto!=""){
            $foto=true;
            $valor=$_FILES["fileFotoEmpleadoNuevaRh"]['type'];
            $log->LogInfo("Valor de la variable valor: " . var_export ($valor, true));
        if($valor!=$permitidos && $valor!=$permitidos1 && $valor!=$permitidos2){
            $correcto=false;        
        }   
        if(!$correcto){
            $response["status"] = "error";
            $response["message"]= "Tipo de arhivo incorrecto";
            echo json_encode($response);
            return;    
        }else{
            if($_FILES["fileFotoEmpleadoNuevaRh"]["name"]){
                $filename  = $_FILES["fileFotoEmpleadoNuevaRh"]["name"]; //Obtenemos el nombre original del archivo
                $source    = $_FILES["fileFotoEmpleadoNuevaRh"]["tmp_name"]; //Obtenemos un nombre temporal dearchivo          
                $directorio= "../uploads/fotosempleados/"; //Declaramos un  variable con la ruta donde guardaremos los archivos
                $ExtencionLargo = explode("/", $_FILES["fileFotoEmpleadoNuevaRh"]["type"]);
                $Extencion= $ExtencionLargo[1];
                $FechaSinGuiones = str_replace("-", "", $FechaI);
                $HoraActual = date("His");
                $Hash = sha1(uniqid());
                $nombrearchivo = $FechaSinGuiones . "_" . $HoraActual . "_" . $Hash . "." . $Extencion;
                if(!file_exists($directorio)){
                    mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");     
                }
                $dir=opendir($directorio); //Abrimos el directorio de destino
                $target_path = $directorio.'/'.$nombrearchivo; //Indicamos la ruta de destino, así como el nombre del archivo
                if(!move_uploaded_file($source, $target_path)){ 
                    $response["status"] = "error";
                    $response["message"]= "Error al subir archivos";
                    echo json_encode($response);
                    return;    
                }
                closedir($dir);//Cerramos el directorio de destino
                // segunda foto 
                $directorio1= "../thumbs/"; //Declaramos un  variable con la ruta donde guardaremos los archivos
                if(!file_exists($directorio1)){
                    mkdir($directorio1, 0777) or die("No se puede crear el directorio de extracci&oacute;n");     
                }
                $dir1=opendir($directorio1); //Abrimos el directorio de destino
                $target_path1 = $directorio1.'/'.$nombrearchivo; //Indicamos la ruta de destino, así como el nombre del archivo
                if(!copy($target_path, $target_path1)){ 
                    $response["status"] = "error";
                    $response["message"]= "Error al subir archivos (miniatura)"; // Mensaje más específico
                    echo json_encode($response);
                    return;
                }
                closedir($dir1);
            }
            $sqlFotografia = "INSERT INTO modificacioPorRh (idModRh, entidadEmpleado, consecutivoEmpleado, categoriaEmpleado, idRechazoPorImss, Fecha, UsuarioEdit) VALUES (null,'$NumeroExplde[0]','$NumeroExplde[1]','$NumeroExplde[2]',5,now(),'$usuarioCaptura ')";//5 significa que se modifico la fotografia
            $log->LogInfo("Ejecutando consulta  sqlFotografia: " . $sqlFotografia);
            $resFotografia = mysqli_query($conexion, $sqlFotografia);  
            if ($resFotografia !== true) {
                $response["status"] = "error";
                $response["message"]='Ocurrio Un Error Al Insertar La Modificacion En El Historico.';
                return;
            }else{
                $response ["status"] = "success";
                $response ["message"] = "Empleado actualizado éxitosamente";
            }
            $sql.=" fotoEmpleado='$nombrearchivo',";
            $log->LogInfo("Valor de la variable sql: " . var_export ($sql, true));
        }
    }

    if($Nombre != $Nombrehidden){
        $sqlNombre = "INSERT INTO modificacioPorRh (idModRh, entidadEmpleado, consecutivoEmpleado, categoriaEmpleado, idRechazoPorImss, Fecha, UsuarioEdit) VALUES (null,'$NumeroExplde[0]','$NumeroExplde[1]','$NumeroExplde[2]',1,now(),'$usuarioCaptura ')";//5 significa que se modifico el nombre
        $resNombre = mysqli_query($conexion, $sqlNombre);  
        if ($resNombre !== true) {
            $response["status"] = "error";
            $response["message"]='Ocurrio Un Error Al Insertar La Modificacion En El Historico.';
            return;
        }else{
            $response ["status"] = "success";
            $response ["message"] = "Empleado actualizado éxitosamente";
        }
        $log->LogInfo("Ejecutando consulta  sqlNombre: " . $sqlNombre);
        $sql.=" nombreEmpleado='$Nombre',";
            $log->LogInfo("Valor de la variable sql: " . var_export ($sql, true));

    }
    if($ApellidoP != $ApellidoPhidden){
        $sqlApellidoP = "INSERT INTO modificacioPorRh (idModRh, entidadEmpleado, consecutivoEmpleado, categoriaEmpleado, idRechazoPorImss, Fecha, UsuarioEdit) VALUES (null,'$NumeroExplde[0]','$NumeroExplde[1]','$NumeroExplde[2]',2,now(),'$usuarioCaptura ')";//2 significa que se modifico el apellido paterno
        $resApellidoP = mysqli_query($conexion, $sqlApellidoP);  
        if ($resApellidoP !== true) {
            $response["status"] = "error";
            $response["message"]='Ocurrio Un Error Al Insertar La Modificacion En El Historico.';
            return;
        }else{
            $response ["status"] = "success";
            $response ["message"] = "Empleado actualizado éxitosamente";
        }
        $log->LogInfo("Ejecutando consulta  sqlApellidoP: " . $sqlApellidoP);
        $sql.=" apellidoPaterno='$ApellidoP',";
            $log->LogInfo("Valor de la variable sql: " . var_export ($sql, true));

    }
    if($ApellidoM != $ApellidoMhidden){
        $sqlApellidoM = "INSERT INTO modificacioPorRh (idModRh, entidadEmpleado, consecutivoEmpleado, categoriaEmpleado, idRechazoPorImss, Fecha, UsuarioEdit) VALUES (null,'$NumeroExplde[0]','$NumeroExplde[1]','$NumeroExplde[2]',3,now(),'$usuarioCaptura ')";//3 significa que se modifico el apellido materno
        $resApellidoM = mysqli_query($conexion, $sqlApellidoM);  
        if ($resApellidoM !== true) {
            $response["status"] = "error";
            $response["message"]='Ocurrio Un Error Al Insertar La Modificacion En El Historico.';
            return;
        }else{
            $response ["status"] = "success";
            $response ["message"] = "Empleado actualizado éxitosamente";
        }
        $log->LogInfo("Ejecutando consulta  sqlApellidoM: " . $sqlApellidoM);
        $sql.=" apellidoMaterno='$ApellidoM',";
            $log->LogInfo("Valor de la variable sql: " . var_export ($sql, true));

    }
    if($Nss != $Nsshidden){
        $sqlNss = "INSERT INTO modificacioPorRh (idModRh, entidadEmpleado, consecutivoEmpleado, categoriaEmpleado, idRechazoPorImss, Fecha, UsuarioEdit) VALUES (null,'$NumeroExplde[0]','$NumeroExplde[1]','$NumeroExplde[2]',4,now(),'$usuarioCaptura ')";//4 significa que se modifico el nss
        $resNss = mysqli_query($conexion, $sqlNss);  
        if ($resNss !== true) {
            $response["status"] = "error";
            $response["message"]='Ocurrio Un Error Al Insertar La Modificacion En El Historico.';
            return;
        }else{
            $response ["status"] = "success";
            $response ["message"] = "Empleado actualizado éxitosamente";
        }
        $log->LogInfo("Ejecutando consulta  sqlNss: " . $sqlNss);
        $sql.=" empleadoNumeroSeguroSocial='$Nss',";
            $log->LogInfo("Valor de la variable sql: " . var_export ($sql, true));
        
    }
    $sql.=" FechaEditPorImss=NOW()
            where entidadFederativaId='$NumeroExplde[0]' 
            and empleadoConsecutivoId='$NumeroExplde[1]' 
            and empleadoCategoriaId='$NumeroExplde[2]'";
    $log->LogInfo("Ejecutando consulta  sql: " . $sql);
    $res = mysqli_query($conexion, $sql);  
    if ($res !== true) {
        $response["status"] = "error";
        $response["message"]='Ocurrio Un Error Al Actualizar Al Elemento.';
        return;
    }else{
        $response ["status"] = "success";
        $response ["message"] = "Empleado actualizado éxitosamente";
    }
    $sql1 = "UPDATE datosimss set idRechazado='4',UsuarioRevision='$usuarioCaptura',NumeroFirmaRevision='$NumeroFirma',ContraseniaFirmaRevision='$ContraseniaFirma',FechaRevision=NOW()
            where empladoEntidadImss='$NumeroExplde[0]' 
            and empleadoConsecutivoImss='$NumeroExplde[1]' 
            and empleadoCategoriaImss='$NumeroExplde[2]'";
    $log->LogInfo("Ejecutando consulta  sql1: " . $sql1);
    $res1 = mysqli_query($conexion, $sql1);  
    if ($res1 !== true) {
        $response["status"] = "error";
        $response["message"]='Ocurrio Un Error Al Actualizar Imss.';
        return;
    }else{
        $response ["status"] = "success";
        $response ["message"] = "Empleado actualizado éxitosamente";
    }
}
echo json_encode($response);
?> 