<?PHP

$hostname_localhost="192.168.2.210";



if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
    $clave=$_GET["clave"];
  
    $info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
    

		$conexion = sqlsrv_connect($hostname_localhost,$info);
		ini_set('mssql.charset', 'UTF-8');
		if($conexion){
			$json=array();
			if(isset($_GET["RUT"]))	{
				
				$RUT=$_GET["RUT"];
				

               
                    $consulta="SELECT TOP 1 NOMBRECONDUCTOR,ISNULL(PATENTE,'') AS PATENTE FROM ANDROID_RECEPCION_CAMIONES WHERE RUTCONDUCTOR='{$RUT}' ORDER BY Fecha_ingreso DESC ";

				
                    $resultado=sqlsrv_query($conexion,$consulta);
                    
                    while($registro =sqlsrv_fetch_array($resultado)){
                        $registro["respuesta"]='NUEVO';
                        $json[]=$registro;
                    }
       
                    echo json_encode($json);
                    
    
                
               
				

			}else{
				$resultar["message"]='Faltan parametros';
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