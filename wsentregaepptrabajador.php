<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["ruttrbajador"])&&isset($_GET["epp"])){
        
	
        $ruttrbajador=$_GET["ruttrbajador"];
        $epp=$_GET["epp"];
				
		$consulta="select fecha,hora from ReposicionCovid where epp='{$epp}' AND ruttrbajador='{$ruttrbajador}' order by fecha asc ";
		
		$resultado=sqlsrv_query($conexion,$consulta);
		
		while($registro =sqlsrv_fetch_array($resultado)){
			$json[]=$registro;
		}

		
		echo json_encode($json);
		

	}else{
		$resultar["message"]='Ws no Retorna';
		$json[]=$resultar;
		echo json_encode($json);
	}

}else{
	echo "CONEXION FALLIDA";
}
	
?>