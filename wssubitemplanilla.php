<?PHP
$hostname_localhost="192.168.60.8\SQLEXPRESS";

$info=array("Database"=>"PRUEBAS","UID"=>"sa","PWD"=>"123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);


if($conexion){
	$json=array();

        
		
		$consulta="SELECT * FROM SUBITEMS";
		
		$resultado=sqlsrv_query($conexion,$consulta);
		
		while($registro =sqlsrv_fetch_array($resultado)){
			$json[]=$registro;
		}

		
		echo json_encode($json);
		

	


}else{
	echo "CONEXION FALLIDA";
}


	
?>