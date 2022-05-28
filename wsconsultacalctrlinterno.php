<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["PLANILLA"])&&isset($_GET["ZON"])&&isset($_GET["COD_ESP"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $PLANILLA=$_GET["PLANILLA"];
        $ZON=$_GET["ZON"];
        $COD_ESP=$_GET["COD_ESP"];
		
		$consulta="SELECT DISTINCT COD_CAL 
        FROM  PROPACKLOTE  
        WHERE  PLANILLA = '{$PLANILLA}'  AND ZON = '{$ZON}'  AND COD_TEM = '{$COD_TEM}'  AND COD_EMP = '{$COD_EMP}'
        UNION SELECT DISTINCT COD_CAL FROM  PROPACKMIX  WHERE  PLANILLA = '{$PLANILLA}'  AND ZON = '{$ZON}' AND COD_TEM = '{$COD_TEM}'  AND COD_EMP = '{$COD_EMP}'
        UNION SELECT DISTINCT COD_CAL FROM  CALIBRES WHERE COD_ESP = '{$COD_ESP}' AND COD_TEM = '{$COD_TEM}'  AND COD_EMP = '{$COD_EMP}' ORDER BY COD_CAL";


       
		
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