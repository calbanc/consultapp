<?PHP
$hostname_localhost="192.168.60.8\SQLEXPRESS";

$info=array("Database"=>"PRUEBAS","UID"=>"sa","PWD"=>"123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);


if($conexion){
	$json=array();

    if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["IDPLANILLA"])){
		
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $IDPLANILLA=$_GET["IDPLANILLA"];

		$consulta="SELECT * FROM DETALLE_PLANILLA WHERE IDEMPRESA='{$COD_EMP}' AND IDTEMPORADA='{$COD_TEM}' AND IDPLANILLA='{$IDPLANILLA}' ORDER BY IDPLANILLA,IDORDEN ";
		
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