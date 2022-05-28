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
	
        $consulta1="SELECT DISTINCT C.COD_CAT, 
        C.NOM_CAT 
        FROM CATEGORIA C 
        INNER JOIN  PROPACKLOTE  PK ON PK.COD_EMP=C.COD_EMP AND PK.COD_TEM=C.COD_TEM AND PK.COD_ESP=C.COD_ESP AND PK.COD_CAT=C.COD_CAT 
        
        WHERE PK.PLANILLA = '{$PLANILLA}' AND  PK.COD_TEM = '{$COD_TEM}' AND  PK.COD_EMP = '{$COD_EMP}' AND  PK.ZON= '{$ZON}' ORDER BY C.COD_CAT";
		
				
		$resultado2=sqlsrv_query($conexion,$consulta1);
		
		while($registro2 =sqlsrv_fetch_array($resultado2)){
			$json2[]=$registro2;
		}
		echo json_encode($json2);

	}else{
		$resultar["message"]='Ws no Retorna';
		$json[]=$resultar;
		echo json_encode($json);
	}

}else{
	echo "CONEXION FALLIDA";
}
	
?>