<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["TIP_TRA"])&&isset($_GET["PLANILLA"])){
        
        $TIP_TRA=$_GET["TIP_TRA"];
        $COD_TEM=$_GET["COD_TEM"];
        $COD_EMP=$_GET["COD_EMP"];
        $PLANILLA=$_GET["PLANILLA"];
		
		$consulta="SELECT DISTINCT COD_REC,NOM_REC,COD_VAR FROM VIEW_ANDROID_OEM where COD_EMP='{$COD_EMP}' and COD_TEM='{$COD_TEM}' AND TIP_TRA='{$TIP_TRA}' AND PLANILLA='{$PLANILLA}'";
		
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