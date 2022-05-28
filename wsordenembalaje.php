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
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["COD_PACK"])&&isset($_GET["fecha"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $COD_PACK=$_GET["COD_PACK"];
        $fecha=$_GET["fecha"];
		
		$consulta="SELECT NRO_ORDEN,COD_PACK,COD_VAR,COD_VAR_ETI,COD_ESP,COD_ETI,COD_EMB,COD_ENV,COD_ENVOP,PLU,ALTURA,COD_BP,
		COD_CAT,COD_CAL,COD_MER,T_PROCESO,CPL_ENV,NOM_VAR_ETI,ISNULL(COD_CAL_EQ,'') AS COD_CAL_EQ
        FROM VIEW_CONSULTA_ORDEN_EMBALAJE_ANDROID
         WHERE  COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND COD_PACK='{$COD_PACK}' and '{$fecha}' BETWEEN INICIO AND TERMINO";
		
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