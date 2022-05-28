<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
    $info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");

$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["COD_PRO"])&&isset($_GET["FDESDE"])&&isset($_GET["FHASTA"])){
        
        $COD_PRO=$_GET["COD_PRO"];
        $COD_TEM=$_GET["COD_TEM"];
        $COD_EMP=$_GET["COD_EMP"];
        $FDESDE=$_GET["FDESDE"];
        $FHASTA=$_GET["FHASTA"];
		
		$consulta="SELECT SUM(ISNULL (TOTAL_KILOS,0)) AS KILOS,SUM(CANTIDAD) AS CANTIDAD,COD_CUA 
        FROM COSECHA_HUERTO 
        WHERE COD_TEM='{$COD_TEM}' and COD_EMP='{$COD_EMP}' AND COD_PRO='{$COD_PRO}' AND CONVERT(VARCHAR,FECHA_COSECHA,23) BETWEEN '{$FDESDE}' AND '{$FHASTA}'
        GROUP BY COD_CUA";

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
}else{
	$resultar["message"]='Sin usuario';
		$json[]=$resultar;
		echo json_encode($json);
} 
	
?>