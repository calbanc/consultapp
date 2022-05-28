<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bpriv","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["IDUSUARIO"])){
        
        $IDUSUARIO=$_GET["IDUSUARIO"];
		
		$consulta="SELECT pu.*
        from PROTOCOLOS_USUARIOS pu
        INNER JOIN Perfil per ON  pu.IDUSUARIO=per.IdUsuario
        WHERE pu.IDUSUARIO='{$IDUSUARIO}' and per.IdMenu='marcaciones'  ";
		
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