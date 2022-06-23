<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
		
		$consulta=" SELECT F.COD_FRI,F.COD_EMP,F.COD_TEM,F.ZON,Z.NOM_ZON,F.NOM_FRI
        FROM FRIOS F
        INNER JOIN ZONAS Z ON Z.COD_EMP=F.COD_EMP AND Z.COD_TEM=F.COD_TEM AND Z.ZON=F.ZON
        WHERE F.COD_EMP='{$COD_EMP}' AND F.COD_TEM='{$COD_TEM}'";
		
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