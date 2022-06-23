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
	if(isset($_GET["idzona"])&&isset($_GET["fechaactividad"])&&isset($_GET["IdEmpresa"])
    &&isset($_GET["Temporada"])&&isset($_GET["Temporada"])&&isset($_GET["IdCuartel"])&&isset($_GET["firmados"])&&isset($_GET["Idcuadrilla"])){
        
        $idzona=$_GET["idzona"];
        $fechaactividad=$_GET["fechaactividad"];
        $IdEmpresa=$_GET["IdEmpresa"];
        $Temporada=$_GET["Temporada"];
        $firmados=$_GET["firmados"];
        $IdCuartel=$_GET["IdCuartel"];
        $Idcuadrilla=$_GET["Idcuadrilla"];
        $sqlwhere="";

        if($firmados=='SI'){
            $sqlwhere.=" AND SW_VALIDADO IS NOT NULL";
        }else{
            $sqlwhere.=" AND SW_VALIDADO IS NULL";
        }

        if($IdEmpresa=='9' && $idzona=='55'){
            $sqlwhere.="  AND  IdCuartel='{$IdCuartel}'";
        }
        if($Idcuadrilla!='TODOS'){
            $sqlwhere.="  AND  Idcuadrilla='{$Idcuadrilla}'";
        }

		
		$consulta="SELECT COUNT(DISTINCT(IDPLANILLAANDROID)) as cantidad
        FROM ActividadTrabajadorAndroid
        WHERE IdEmpresa='{$IdEmpresa}' and Temporada='{$Temporada}' and IdZona='{$idzona}' and Convert(date,fechaactividad)='{$fechaactividad}' ".$sqlwhere. " ";
		
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