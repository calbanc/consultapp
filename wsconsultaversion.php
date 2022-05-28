<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
	 
	
	$info=array("Database"=>"bpriv","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8"); 
	
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["SISTEMA"])){
       
        $SISTEMA=$_GET["SISTEMA"];
		
		$consulta=" SELECT SISTEMA, FECHA_SISTEMA, VERSION_SIS FROM VERSIONES_SISTEMA WHERE SISTEMA = '{$SISTEMA}'";
		
		$resultado=sqlsrv_query($conexion,$consulta);

		if($registros=sqlsrv_fetch_array($resultado)){
		
			$version=$registros['VERSION_SIS'];
			$data=array('VERSION_SIS'=>$version); 
                        $json[]=$data;
                        echo json_encode($json);
		}
		

	}else{
		$resultar["message"]='Ws no Retorna';
		$json[]=$resultar;
		echo json_encode($json);
	}

}else{
	$version='CONEXION';
	$data=array('VERSION_SIS'=>$version); 
                        $json[]=$data;
                        echo json_encode($json);
}
}else{
	$resultar["message"]='Sin usuario';
		$json[]=$resultar;
		echo json_encode($json);
} 
	
?>
