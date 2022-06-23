<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["LOTE"])&&isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["KILOS"])&&isset($_GET["TOTAL_KILOS"])&&isset($_GET["HORA_RECEP"])){
        
        $LOTE=$_GET["LOTE"];
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $KILOS=$_GET["KILOS"];
        $TOTAL_KILOS=$_GET["TOTAL_KILOS"];
        $HORA_RECEP=$_GET["HORA_RECEP"];
	
       
		
		$consulta="UPDATE COSECHA_HUERTO
        SET KILOS='{$KILOS}',TOTAL_KILOS='{$TOTAL_KILOS}',HORA_RECEP='{$HORA_RECEP}'
        WHERE LOTE='{$LOTE}' and COD_TEM='{$COD_TEM}' AND COD_EMP='{$COD_EMP}'";
		
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