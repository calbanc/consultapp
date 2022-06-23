<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
    $info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
    $conexion = sqlsrv_connect($hostname_localhost,$info);
    ini_set('mssql.charset', 'UTF-8');
        if($conexion){
            $json=array();
            if(isset($_GET["idempresa"])
            &&isset($_GET["idzona"])
            &&isset($_GET["rut"])
            &&isset($_GET["grupo"])
            &&isset($_GET["fecha"])
            &&isset($_GET["cod_campo"])
            &&isset($_GET["cod_ruta"])
            &&isset($_GET["cod_troncal"])
            &&isset($_GET["TIPO"])
            &&isset($_GET["tipo_ingreso"])){
                
                $idempresa=$_GET["idempresa"];
                $idzona=$_GET["idzona"];
                $rut=$_GET["rut"];
                $grupo=$_GET["grupo"];
                $fecha=$_GET["fecha"];
                $cod_campo=$_GET["cod_campo"];
                $cod_ruta=$_GET["cod_ruta"];
                $cod_troncal=$_GET["cod_troncal"];
                $tipo_ingreso=$_GET["tipo_ingreso"];
                $TIPO=$_GET["TIPO"];

                $consultaantes="SELECT Id,Usuario FROM ANDROID_Fotografias WHERE RutTrabajador='{$rut}' and Fecha='{$fecha}' ";
                $resultadoantes=sqlsrv_query($conexion,$consultaantes);
                
                if($TIPO=="1"){
                    $update="UPDATE Trabajador set SW_DCTO_IDENTIDAD='1' WHERE RutTrabajador='{$rut}'";
                }else{
                    $update="UPDATE Trabajador set SW_FOTO='1' WHERE RutTrabajador='{$rut}'";
                }
                
                $resultadoactualiza=sqlsrv_query($conexion,$update);
                

             
                if($registros=sqlsrv_fetch_array($resultadoantes)){
                    $Id=$registros['Id'];
                    $usuarioregistro=$registros['Usuario'];
                    $resulta["Id"]="ANTES";
                    $resulta["Codigo"]=$Id;
                    $resulta["Usuario"]=$usuarioregistro;
                    $json[]=$resulta;
                    echo json_encode($json);
                
                }else{

                    if($TIPO=="1"){
                        $consulta="INSERT INTO ANDROID_Fotografias(RutTrabajador,Grupo,Usuario,Fecha,COD_RUTA,COD_TRONCAL,Tipo_ingreso,CodigoCampo,IdEmpresa,IdZona)VALUES('{$rut}','{$grupo}','{$usuario}','{$fecha}','{$cod_ruta}','{$cod_troncal}','{$tipo_ingreso}','{$cod_campo}','{$idempresa}','{$idzona}')";
                    }

                    
                   
    
    
                    $resultado=sqlsrv_query($conexion,$consulta);
                    if($resultado){
                        $resulta["Id"]='OK';
                            $json[]=$resulta;
                            echo json_encode($json);
                        }
                        else{
                            $resulta["Id"]='NO REGISTRA';
                            $json[]=$resulta;
                            echo json_encode($json);
                        }
    
                }
              
                    
                }else{
                $resultar["id"]='FALTAN DATOS';
                $json[]=$resultar;
                echo json_encode($json);
            }

        }else{
            echo "CONEXION FALLIDA";
        }
}else{
	$resultar["message"]='Sin usuario';
	$json[]=$resultar;
	echo json_encode($json);
} 
?>