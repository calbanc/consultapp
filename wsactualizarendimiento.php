<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
    if(isset($_GET["IdActividadTrabajador"])&&isset($_GET["UnidadProducida"])){
        
        $IdActividadTrabajador=$_GET["IdActividadTrabajador"];
        
        $UnidadProducida=$_GET["UnidadProducida"];
       
        
		$consulta="UPDATE ActividadTrabajadorAndroid 
		Set UnidadProducida='{$UnidadProducida}'
		where IdActividadTrabajador='{$IdActividadTrabajador}'";
		
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