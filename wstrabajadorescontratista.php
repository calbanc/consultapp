<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["IdEmpresa"])&&isset($_GET["IdZona"])){
		$IdEmpresa=$_GET["IdEmpresa"];
		$IdZona=$_GET["IdZona"];
	   
		
		

		$consulta="SELECT tc.IdEmpresa,tc.IdContratista,c.Nombre as nombrecontratista,tc.IdTrabXContratista,tc.Rut,tc.Digito,tc.Nombre,tc.IdZona FROM TrabajadorXContratista tc
        inner join Contratista c on c.IdContratista=tc.IdContratista and c.IdEmpresa=tc.IdEmpresa where tc.IdEmpresa='{$IdEmpresa}' and tc.IdZona='{$IdZona}' and Activo='1'";
		
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