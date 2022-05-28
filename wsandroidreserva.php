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
		
		$consulta="SELECT ID,COD_EMP,COD_TEM,GLOSA,LOTE,CONVERT (date,FECHA,23) as FECHA,HORA,TEMP,IDUSUARIO,SW_ENVIADO
          FROM ANDROID_RESERVA
          WHERE COD_EMP='{$COD_EMP}' AND COD_TEM='{$COD_TEM}' AND FECHA  BETWEEN  DATEADD(DAY,-7,CONVERT (date, GETDATE())) and CONVERT (date, GETDATE()) ";
		
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