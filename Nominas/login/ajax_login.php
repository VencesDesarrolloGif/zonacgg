<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();
require "../conexion/conexion.php";
$response = array ();
$response ["status"] = "error";
if (!empty ($_POST))
{	
    $usuario=$_POST ["usuario"];
    $password=$_POST ["pass"];
    $contrasenia=md5($password);
    $usuarios=array();
      try{

            $sql="SELECT u.usuario,u.entidadFederativaUsuario, u.apellidoPaterno,u.apellidoMaterno, u.nombre, r.descripcionRolUsuario as rol 
            from  usuarios u, catalogorolesusuarios r 
            where 
            u.usuarioRolId=r.idRolUsuario AND usuario='" . mysqli_real_escape_string ($conexion ,$usuario) . "' " .
            "and contrasenia='" . mysqli_real_escape_string ($conexion, $contrasenia) . "'";
            $res=mysqli_query($conexion, $sql);
            
                
            while(($reg=mysqli_fetch_array($res, MYSQLI_ASSOC))){                

                $usuarios[]=$reg;
            }
            

            if($usuarios!= null ){
                if($usuarios[0]["rol"]!="Nominas"){
                    $response ["message"] = "Acceso no permitido";
                }else{
                    $response ["status"] = "success";
                    $userLog=$usuarios[0]["usuario"];

                    $_SESSION ['userLog'] = $userLog;
                    $response ["usuario"] = $userLog;
                }

            }else{
                $response ["message"] = "Usuario y/o contraseña incorrectos";
            }

        } catch (Exception $e){

              $response ["message"]= "Error al iniciar sesion";

        }  
}
else
{    
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}

echo json_encode ($response);
?>