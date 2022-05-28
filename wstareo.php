<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
		 
	$info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
	
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["IdEmpresa"])){
		$IdEmpresa=$_GET["IdEmpresa"];
	
		
		$consulta="SELECT distinct ac.IdEmpresa,ac.IdFamilia,fa.Nombre as NOOMBRE_FAMILIA,ac.IdActividad,ac.Nombre,ac.UnidadMedida
		from Actividades ac
		inner join FamiliaActividades fa on fa.IdFamilia=ac.IdFamilia and fa.IdEmpresa='{$IdEmpresa}'
		where ac.IdEmpresa='{$IdEmpresa}'";
		
		
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
}else{
	$resultar["message"]='Sin usuario';
	$json[]=$resultar;
	echo json_encode($json);
} 
?>