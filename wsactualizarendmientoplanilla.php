<?PHP
$hostname_localhost="192.168.2.210";
if(isset($_GET["usuario"])&&isset($_GET["clave"])){

	$usuario=$_GET["usuario"];
	$clave=$_GET["clave"];
	 
$info=array("Database"=>"bsis_rem_afr","UID"=>$usuario,"PWD"=>$clave,"CharacterSet"=>"UTF-8");

$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
    if(isset($_GET["IdActividad"])
    &&isset($_GET["IdFamilia"])
    &&isset($_GET["IdEmpresa"])
    &&isset($_GET["Temporada"])
    &&isset($_GET["IdCuartel"])
    &&isset($_GET["IdZona"])
    &&isset($_GET["FechaActividad"])
    &&isset($_GET["IdCuartel"])
    &&isset($_GET["IdCuadrilla"])
    &&isset($_GET["Ciclo"])
    &&isset($_GET["IDPLANILLAANDROID"])
    &&isset($_GET["rendimiento"])){
        
        $IdActividad=$_GET["IdActividad"];
        $IdFamilia=$_GET["IdFamilia"];
        $IdEmpresa=$_GET["IdEmpresa"];
        $Temporada=$_GET["Temporada"];
        $IdCuartel=$_GET["IdCuartel"];
        $IdZona=$_GET["IdZona"];
        $FechaActividad=$_GET["FechaActividad"];
        $IdCuadrilla=$_GET["IdCuadrilla"];
        $rendimiento=$_GET["rendimiento"];
        $Ciclo=$_GET["Ciclo"];
        $IDPLANILLAANDROID=$_GET["IDPLANILLAANDROID"];
        
		$consulta="Update ActividadTrabajadorAndroid
        Set UnidadProducida='{$rendimiento}'
        Where IdActividad='{$IdActividad}' and IdFamilia='{$IdFamilia}' and IdEmpresa='{$IdEmpresa}' and Temporada='{$Temporada}' 
        and IdCuartel='{$IdCuartel}' and IdZona='{$IdZona}' and Convert(date,FechaActividad)='{$FechaActividad}' 
        AND IdCuadrilla='{$IdCuadrilla}' and Ciclo='{$Ciclo}' and IDPLANILLAANDROID='{$IDPLANILLAANDROID}'";
        
        
        
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