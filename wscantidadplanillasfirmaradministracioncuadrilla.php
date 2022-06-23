<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
	if(isset($_GET["idzona"])&&isset($_GET["fechaactividad"])&&isset($_GET["IdCuartel"])&&isset($_GET["IdCuadrilla"])){
        
        $idzona=$_GET["idzona"];
        $fechaactividad=$_GET["fechaactividad"];
        $IdCuartel=$_GET["IdCuartel"];
        $IdCuadrilla=$_GET["IdCuadrilla"];
		
		$consulta="SELECT COUNT(DISTINCT(IDPLANILLAANDROID)) as cantidad
        FROM ActividadTrabajadorAndroid
        WHERE IdZona='{$idzona}' and Convert(date,fechaactividad)='{$fechaactividad}' and IdCuartel='{$IdCuartel}' and IdCuadrilla='{$IdCuadrilla}' and SW_VALIDADO='1' ";
		
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