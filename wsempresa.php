<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();		
		$consulta="SELECT IdEmpresa,Nombre  FROM [bsis_rem_afr].[dbo].Empresa";
		
		$resultado=sqlsrv_query($conexion,$consulta);
		
		while($registro =sqlsrv_fetch_array($resultado)){
            $json[]=$registro;
           
		}

		
		echo json_encode($json);
		

	

}else{
	echo "CONEXION FALLIDA";
}
	
?>  