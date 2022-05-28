<?PHP
$hostname_localhost="192.168.2.210";

$info=array("Database"=>"bsis_rem_afr","UID"=>"reporte","PWD"=>"abc.123456","CharacterSet"=>"UTF-8");
$conexion = sqlsrv_connect($hostname_localhost,$info);
ini_set('mssql.charset', 'UTF-8');
if($conexion){
	$json=array();
    if(isset($_GET["idplanillaandroid"])&&isset($_GET["fechaactividad"])&&isset($_GET["idcuadrilla"])&&isset($_GET["idactividad"])&&isset($_GET["idfamilia"])
    &&isset($_GET["idzona"])&&isset($_GET["ciclo"])&&isset($_GET["etapa"])&&isset($_GET["idcuartel"])&&isset($_GET["idempresa"])
    &&isset($_GET["temporada"])){
        
        $idplanillaandroid=$_GET["idplanillaandroid"];
        $fechaactividad=$_GET["fechaactividad"];
        $idcuadrilla=$_GET["idcuadrilla"];
        $idactividad=$_GET["idactividad"];
        $idfamilia=$_GET["idfamilia"];
        $idzona=$_GET["idzona"];
        $ciclo=$_GET["ciclo"];
        $etapa=$_GET["etapa"];
        $idcuartel=$_GET["idcuartel"];
        $idempresa=$_GET["idempresa"];
        $temporada=$_GET["temporada"];
      
		
		$consulta="DELETE FROM ActividadTrabajadorAndroid where PLANILLA='{$idplanillaandroid}' and SW_VALIDADO IS NULL and Convert(date,fechaactividad)='{$fechaactividad}' and idcuadrilla='{$idcuadrilla}' and idactividad='{$idactividad}' and idfamilia='{$idfamilia}' and idzona='{$idzona}' and ciclo='{$ciclo}' and etapa='{$etapa}' and idcuartel='{$idcuartel}' and idempresa='{$idempresa}' and temporada='{$temporada}'";
		
		$resultado=sqlsrv_query($conexion,$consulta);
        
        if($resultado){
            
            $resulta["id"]='REGISTRA';
                $json[]=$resulta;
                echo json_encode($json);
            }
            else{
                $resulta["id"]='NO REGISTRA';
                $json[]=$resulta;
                echo json_encode($json);
            }
		

	}else{
		$resultar["message"]='Ws no Retorna';
		$json[]=$resultar;
		echo json_encode($json);
	}

}else{
	echo "CONEXION FALLIDA";
}
	
?>