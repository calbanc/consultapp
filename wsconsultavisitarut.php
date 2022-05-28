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
				
				$Id=$_GET["RUT"];
				
                $consulta="SELECT Id,RutConductor,NombreConductor,
				isnull(PROCEDENCIA,'') as PROCEDENCIA,
				isnull(Telefono,'') as Telefono,
				isnull(Patente,'') as Patente,
				isnull(DESTINO,'') as DESTINO,
				isnull(Motivo,'') as Motivo,
				isnull(AUTORIZADO,'') as AUTORIZADO,
				isnull(Observacion,'') as Observacion,
				isnull(NROLICENCIA,'') as NROLICENCIA,
				isnull(SGROVIGENTE,'') as SGROVIGENTE,
				ISNULL(CONVERT(VARCHAR,FECHAINICIOSCTR,103),'') AS FECHAINICIOSCTR,
				isnull(CONVERT(VARCHAR,FECHATERMINOSCTR,103),'') as FECHATERMINOSCTR,
				isnull(BUENASALUD , '') as BUENASALUD,
				isnull(OBSERVACIONSALUD,'') as OBSERVACIONSALUD
				FROM ANDROID_RECEPCION_CAMIONES WHERE Id='{$Id}'  ";
				
		
				
				$resultado=sqlsrv_query($conexion,$consulta);
				
				while($registro =sqlsrv_fetch_array($resultado)){
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