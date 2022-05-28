<?PHP
$hostname_localhost="192.168.2.210";


if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
		 
	$info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");$conexion = sqlsrv_connect($hostname_localhost,$info);
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["HoraInicio"])&&isset($_GET["HoraFinal"])&&isset($_GET["UnidadProducida"])&&isset($_GET["COD_BUS"])&&isset($_GET["IdActividadTrabajador"])&&isset($_GET["OBSERVACION"])&&isset($_GET["REFRIGERIO"])&&isset($_GET["POR_TAREA"])){
        
        $HoraInicio=$_GET["HoraInicio"];
        $HoraFinal=$_GET["HoraFinal"];
        $UnidadProducida=$_GET["UnidadProducida"];
        $COD_BUS=$_GET["COD_BUS"];
        $IdActividadTrabajador=$_GET["IdActividadTrabajador"];
		$OBSERVACION=$_GET["OBSERVACION"];
		$REFRIGERIO=$_GET["REFRIGERIO"];
		$POR_TAREA=$_GET["POR_TAREA"];
        
	
       
		
		$consulta="UPDATE ActividadTrabajadorAndroid
        SET POR_TAREA='{$POR_TAREA}',HoraInicio='{$HoraInicio}',HoraFinal='{$HoraFinal}',COD_BUS='{$COD_BUS}',UnidadProducida='{$UnidadProducida}',OBSERVACION_ANDROID='{$OBSERVACION}',REFRIGERIO='{$REFRIGERIO}'
        WHERE IdActividadTrabajador='{$IdActividadTrabajador}'";
		
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