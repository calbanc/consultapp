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
		
		$consulta="SELECT P.COD_PACK,P.COD_TEM,P.COD_EMP,P.ZON,Z.NOM_ZON,P.NOM_PACK
        FROM PACKINGS P
        INNER JOIN ZONAS Z ON Z.COD_EMP=P.COD_EMP AND Z.COD_TEM=P.COD_TEM AND Z.ZON=P.ZON
        WHERE P.COD_EMP='{$COD_EMP}' AND P.COD_TEM='{$COD_TEM}'";
		
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