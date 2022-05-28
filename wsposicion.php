<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["COD_TEM"])&&isset($_GET["COD_EMP"])){
        
       
        $COD_TEM=$_GET["COD_TEM"];
        $COD_EMP=$_GET["COD_EMP"];
        
		
		$consulta=" SELECT MAX(FILA) AS FILA, PISO, COD_CAM, COD_BANDA, COD_FRI,COD_EMP,COD_TEM
        FROM EXISTENCIA
        where COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND FILA IS NOT NULL
        GROUP BY PISO, COD_CAM, COD_BANDA, COD_FRI,COD_EMP,COD_TEM";
		
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