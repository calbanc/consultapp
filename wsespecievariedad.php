<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
		 
	$info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");
	$conexion = sqlsrv_connect($hostname_localhost,$info);

if($conexion){
	$json=array();
	if(isset($_GET["IdEmpresa"])){
		$IdEmpresa=$_GET["IdEmpresa"];
        
		
		$consulta="SELECT  V.IdVariedad,V.Nombre AS 'DESCRIPCION_VARIEDAD',E.IdEspecie,E.Nombre AS 'NOMBRE_ESPECIE'
        FROM Variedad V 
        INNER JOIN Especie E ON E.IdEmpresa=V.IdEmpresa AND E.IdEspecie=V.IdEspecie
        where V.IdEmpresa='{$IdEmpresa}'";
		
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