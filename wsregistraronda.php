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
            if(isset($_GET["IdEmpresa"])
            &&isset($_GET["IdTrabajador"])
            &&isset($_GET["Fecha"])
            &&isset($_GET["Hora"])
            &&isset($_GET["IdPredio"])
            &&isset($_GET["IDCuartel"])
            &&isset($_GET["Sw_Cumple"])
            &&isset($_GET["Sw_Inicio"])
            &&isset($_GET["Observacion"])
            &&isset($_GET["Latitud"])
            &&isset($_GET["Longitud"])
            &&isset($_GET["IdUsuario"])
            &&isset($_GET["IdEmpTrabajador"])){
                
                $IdEmpresa=$_GET["IdEmpresa"];
                $IdTrabajador=$_GET["IdTrabajador"];
                $Fecha=$_GET["Fecha"];
                $Hora=$_GET["Hora"];
                $IdPredio=$_GET["IdPredio"];
                $IDCuartel=$_GET["IDCuartel"];
                $Sw_Cumple=$_GET["Sw_Cumple"];
                $Sw_Inicio=$_GET["Sw_Inicio"];
                $Observacion=$_GET["Observacion"];
                $Latitud=$_GET["Latitud"];
                $Longitud=$_GET["Longitud"];
                $IdUsuario=$_GET["IdUsuario"];
                $swruta=$_GET["swruta"];
                $idruta=$_GET["idruta"];
                $IdEmpTrabajador=$_GET["IdEmpTrabajador"];
                    
                $consulta="INSERT INTO ANDROID_RONDIN (IdEmpresa, IdTrabajador, Fecha, Hora, IdPredio, IDCuartel, Sw_Cumple, Sw_Inicio, Observacion, Latitud, Longitud,IdUsuario,swruta,idruta,IdEmpresaTrabajador)                    
                VALUES ('{$IdEmpresa}', '{$IdTrabajador}', '{$Fecha}', '{$Hora}', '{$IdPredio}', '{$IDCuartel}','{$Sw_Cumple}', '{$Sw_Inicio}', '{$Observacion}', '{$Latitud}','{$Longitud}','{$IdUsuario}','{$swruta}','{$idruta}','{$IdEmpTrabajador}')";

               
                $resultado=sqlsrv_query($conexion,$consulta);
                if($resultado){
                    $resulta["id"]='REGISTRA';
                        $json[]=$resulta;
                        echo json_encode($json);
                    }
                    else{
                        $resulta["id"]='NO REGISTRA';
                        $json[]=$resulta;
                        echo json_encode($json);
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