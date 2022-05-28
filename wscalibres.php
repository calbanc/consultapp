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
		if(isset($_GET["COD_EMP"])&&isset($_GET["COD_TEM"])){
			
			$COD_EMP=$_GET["COD_EMP"];
			$COD_TEM=$_GET["COD_TEM"];
			$produccion=$_GET["produccion"];
			$sqlwhere="";

			if($produccion!="1"){
				$sqlwhere.="AND COMERCIAL='1'";
			}
			


			$consulta="SELECT COD_ESP,COD_CAL FROM CALIBRES where COD_EMP='{$COD_EMP}' and COD_TEM='{$COD_TEM}' ".$sqlwhere;

			$consulta;
			
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