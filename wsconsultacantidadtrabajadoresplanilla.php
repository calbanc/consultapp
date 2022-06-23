<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
    if(isset($_GET["idzona"])&&isset($_GET["fechaactividad"])&&isset($_GET["IDPLANILLAANDROID"])&&isset($_GET["IDCUADRILLA"])&&isset($_GET["ciclo"])&&isset($_GET["IdEmpresa"])
    &&isset($_GET["Temporada"])&&isset($_GET["idcuartel"])){
        
        $idzona=$_GET["idzona"];
        $fechaactividad=$_GET["fechaactividad"];
        $IDPLANILLAANDROID=$_GET["IDPLANILLAANDROID"];
        $IDCUADRILLA=$_GET["IDCUADRILLA"];
        $ciclo=$_GET["ciclo"];
        $IdEmpresa=$_GET["IdEmpresa"];
        $Temporada=$_GET["Temporada"];
        $idcuartel=$_GET["idcuartel"];
        
       
        
		$consulta="SELECT count(idtrabajador) as cantidad from ActividadTrabajadorAndroid 
        where IdZona='{$idzona}' and Convert(date,fechaactividad)='{$fechaactividad}' and SW_VALIDADO is null  and IDPLANILLAANDROID='{$IDPLANILLAANDROID}' 
        AND IDCUADRILLA='{$IDCUADRILLA}' and ciclo='{$ciclo}' and IdEmpresa='{$IdEmpresa}' and Temporada='{$Temporada}' and idcuartel='{$idcuartel}'";
		
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