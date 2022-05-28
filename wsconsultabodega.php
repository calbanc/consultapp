<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"erpfrusys","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["IDUSUARIO"])&&isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])){
        
		$IDUSUARIO=$_GET["IDUSUARIO"];
		$COD_EMP=$_GET["COD_EMP"];
		$COD_TEM=$_GET["COD_TEM"];
       
       
		
		$consulta="SELECT P.COD_BOD, P.IDZONA, B.NOM_BOD
        FROM ANDROID_PARAMETROS P WITH(NOLOCK)
        LEFT JOIN EMPRESAS E WITH(NOLOCK) ON E.COD_EMP=P.COD_EMP
        LEFT JOIN TEMPORADAS T WITH(NOLOCK) ON E.COD_EMP=T.COD_EMP AND P.COD_TEM=T.COD_TEM
        LEFT JOIN BODEGAS B WITH(NOLOCK) ON B.COD_BOD=P.COD_BOD AND B.COD_TEM=P.COD_TEM AND B.COD_EMP=P.COD_EMP AND B.COD_ZON=P.IDZONA
        WHERE P.IDUSUARIO='{$IDUSUARIO}' and P.COD_EMP='{$COD_EMP}' and P.COD_TEM='{$COD_TEM}'";
		
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