<?PHP
$hostname_localhost="192.168.2.210";

if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
	 

	$info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
	
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["SERIE"])&&isset($_GET["GUIA"])&&isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])){
        
        $SERIE=$_GET["SERIE"];
        $GUIA=$_GET["GUIA"];
		$COD_EMP=$_GET["COD_EMP"];
		$COD_TEM=$_GET["COD_TEM"];
       
		
		$consulta="SELECT SERIE AS PATENTE,GUIA AS CHOFER,SUM(CANTIDAD)AS CANTIDAD FROM COSECHA_HUERTO WHERE SERIE='{$SERIE}' AND GUIA='{$GUIA}' AND COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' group by SERIE, GUIA  ";
		
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