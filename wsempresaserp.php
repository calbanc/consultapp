<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["COD_EMP"])){
        
        $COD_EMP=$_GET["COD_EMP"];
       
		$COD_PAIS="";
		$consultaempresa="SELECT COD_PAIS FROM EMPRESAS WHERE COD_EMP='{$COD_EMP}' ";

	
		$execempresa=sqlsrv_query($conexion,$consultaempresa);
		if($resultadoempresa=sqlsrv_fetch_array($execempresa)){
			$COD_PAIS=$resultadoempresa['COD_PAIS'];	
		}
	
		$consulta="  SELECT COD_EMP ,NOM_EMP FROM EMPRESAS WHERE COD_PAIS='{$COD_PAIS}'";
	
		$resultado=sqlsrv_query($conexion,$consulta);
		
		while($registro=sqlsrv_fetch_array($resultado)){
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