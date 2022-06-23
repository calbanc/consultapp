<?PHP
$hostname_localhost="192.168.2.210";


if(isset($_GET["IDUSUARIO"])&&isset($_GET["clave"])){

	$IDUSUARIO=$_GET["IDUSUARIO"];
	$clave=$_GET["clave"];
	 
	$info=array("Database"=>"bsis_rem_afr","UID"=>$IDUSUARIO,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
	
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["COD_EMP"])){
        $COD_EMP=$_GET["COD_EMP"];
       
		$consulta="SELECT *  FROM TipoHistoriaClinica  WHERE IdEmpresa = '{$COD_EMP}'";
		
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
	$resultar["IdTipoHistoriaClinica"]='CONEXION';
	$json[]=$resultar;
	echo json_encode($json);
}
}else{
	$resultar["message"]='Sin usuario';
		$json[]=$resultar;
		echo json_encode($json);
}
?>