<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["IdContratista"])&&isset($_GET["IdEmpresa"])&&isset($_GET["IdTrabXContratista"])&&isset($_GET["IdZona"])){
        $IdContratista=$_GET["IdContratista"];
        $IdEmpresa=$_GET["IdEmpresa"];
        $IdTrabXContratista=$_GET["IdTrabXContratista"];
        $IdZona=$_GET["IdZona"];
		
		$consulta="SELECT IdEmpresa,IdContratista,IdTrabXContratista,Rut,Digito,Nombre,Activo,IdZona FROM TrabajadorXContratista where IdEmpresa='{$IdEmpresa}'  and IdContratista='{$IdContratista}' and IdTrabXContratista='{$IdTrabXContratista}'and IdZona='{$IdZona}'";
		
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