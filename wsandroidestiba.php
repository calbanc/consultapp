<?PHP
$hostname_localhost="192.168.2.210";

if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
	 

	$info=array("Database"=>"erpfrusys","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");

$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["COD_TEM"])&&isset($_GET["COD_EMP"])){
        
       
        $COD_TEM=$_GET["COD_TEM"];
        $COD_EMP=$_GET["COD_EMP"];
        $ZON=$_GET["ZON"];
		$COD_FRI=$_GET["COD_FRI"];


		if($ZON!='null'){
			$sqlWhere .= " AND  ZON='{$ZON}'";
		}
		if($COD_FRI!='null'){
			$sqlWhere .= " AND  COD_FRI='{$COD_FRI}'";
		}
		
		$consulta="SELECT COD_EMP,COD_TEM,ZON,COD_FRI,FRIO,COD_CAM,CAMARA,COD_BANDA,BANDA,FILAS,NFC_SERIAL,RACK FROM VIEW_ANDROID_ESTIBA
		 WHERE COD_EMP='{$COD_EMP}' and COD_TEM='{$COD_TEM}'  ".$sqlWhere." ";
		
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