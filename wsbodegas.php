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
		$COD_PAIS="";
		$consultaempresa="SELECT COD_PAIS FROM EMPRESAS WHERE COD_EMP='{$COD_EMP}' ";

	
		$execempresa=sqlsrv_query($conexion,$consultaempresa);
		if($resultadoempresa=sqlsrv_fetch_array($execempresa)){
			$COD_PAIS=$resultadoempresa['COD_PAIS'];	
		}
	
		$consulta="SELECT NOM_ZON,bod.COD_ZON,bod.COD_BOD,bod.NOM_BOD,bod.COD_EMP
        FROM BODEGAS bod
        INNER JOIN ZONAS zon ON bod.COD_ZON=zon.zon and bod.COD_EMP=zon.COD_EMP and bod.COD_TEM=zon.COD_TEM 
		INNER JOIN EMPRESAS emp on emp.COD_EMP=BOD.COD_EMP
        
        WHERE  emp.COD_PAIS='{$COD_PAIS}' and bod.COD_TEM='{$COD_TEM}'";
		
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