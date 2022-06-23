<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["PLANILLA"])&&isset($_GET["ZON"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $PLANILLA=$_GET["PLANILLA"];
        $ZON=$_GET["ZON"];
		
		$consulta="SELECT DISTINCT COD_ENVOP FROM  PROPACKLOTE  
        WHERE  PLANILLA = '{$PLANILLA}'  AND ZON = '{$ZON}'  AND COD_TEM = '{$COD_TEM}' AND COD_EMP = '{$COD_EMP}'
        UNION SELECT DISTINCT COD_ENVOP FROM  PROPACKMIX  WHERE  PLANILLA = '{$PLANILLA}'  AND ZON = '{$ZON}' AND COD_TEM = '{$COD_TEM}' AND COD_EMP = '{$COD_EMP}'
        UNION  SELECT DISTINCT COD_ENVOP FROM ORDEN_EMBALAJE_DETALLE WHERE NRO_ORDEN = (SELECT NRO_ORDEN  FROM TIT_PROCEPACK 
        WHERE PLANILLA = '{$PLANILLA}' AND ZON = '{$ZON}'  AND COD_TEM = '{$COD_TEM}'  AND COD_EMP = '{$COD_EMP}') AND ZON = '{$ZON}'  AND COD_TEM = '{$COD_TEM}'  AND COD_EMP = '{$COD_EMP}' ORDER BY COD_ENVOP ";


       
		
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