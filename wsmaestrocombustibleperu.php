<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])&&isset($_GET["MES"])&&isset($_GET["ANO"])){
        
        $COD_EMP=$_GET["COD_EMP"];
        $COD_TEM=$_GET["COD_TEM"];
        $MES=$_GET["MES"];
        $ANO=$_GET["ANO"];
		
		$consulta="SELECT IDEMPRESA,IDTRABAJADOR,TRABAJADOR,COD_MAQ,NOMCOD_MAQ,SUBITEM,NOMSUBITEM,CANTIDAD,CONSUMO,EMAIL,COD_EMP,COD_TEM,MES,ANO,SW_ODOMETRO,Ultimo_Valor FROM VIEW_ANDROIDN where COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}'and MES='{$MES}' and ANO='{$ANO}'";

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