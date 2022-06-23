<?PHP
$hostname_localhost="192.168.2.210";

if(isset($_GET["IDUSUARIO"])&&isset($_GET["clave"])){

$IDUSUARIO=$_GET["IDUSUARIO"];
$clave=$_GET["clave"];
 

$info=array("Database"=>"bpriv","UID"=>$IDUSUARIO,"PWD"=>$clave,"CharacterSet"=>"UTF-8");


$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["IDUSUARIO"])){
        
        $IDUSUARIO=$_GET["IDUSUARIO"];
		
		$consulta=" SELECT * FROM PROTOCOLOS_USUARIOS where IDUSUARIO='{$IDUSUARIO}' ";
		
		$resultado=sqlsrv_query($conexion,$consulta);
		

		session_start();
		/*session is started if you don't write this line can't use $_Session  global variable*/
		$_SESSION["usuario"]=$IDUSUARIO;
		$_SESSION["clave"]=$clave;
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