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
	
        $consulta1="SELECT DISTINCT E.COD_ETI, 
        E.NOM_ETI 
        FROM ETIQUETA E 
        INNER JOIN  PROPACKLOTE  PK ON PK.COD_EMP=E.COD_EMP AND PK.COD_TEM=E.COD_TEM AND PK.COD_ETI=E.COD_ETI 
        WHERE PK.PLANILLA = '{$PLANILLA}' AND  PK.COD_TEM = '{$COD_TEM}' AND  PK.COD_EMP = '{$COD_EMP}' AND  PK.ZON= '{$ZON}' ORDER BY E.COD_ETI";
		
				
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