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
	if(isset($_GET["IdEmpresa"])&&isset($_GET["FechaActividad"])&&isset($_GET["IdZona"])&&isset($_GET["Sw_Aprobado"])&&isset($_GET["IdCuartel"])){
        
        $IdEmpresa=$_GET["IdEmpresa"];
        $FechaActividad=$_GET["FechaActividad"];
        $IdZona=$_GET["IdZona"];
        $Sw_Aprobado=$_GET["Sw_Aprobado"];
        $IdCuartel=$_GET["IdCuartel"];

        $sqlwhere="";

        if($Sw_Aprobado=='1'){
            $sqlwhere.="AR.SW_Aprobado='1' " ;
        }else{
            $sqlwhere.="AR.SW_Aprobado='0' " ;
        }

        if($IdZona=='55'){
            $sqlwhere.=" AND AR.IdCuartel='{$IdCuartel}'";
        }
        
       	
		$consulta=" SELECT AR.Correlativo,AR.Idempresa,AR.IdZona,AR.Año,AR.MEs,[LABOR]=ltrim(str(AR.IdActividad))+' - '+ACT.Nombre,
        [ACTIVIDAD]=ltrim(str(FAM.IdFamilia)) +' - '+FAM.Nombre,AR.IdCuartel,CUA.Nombre,AR.Cantidad,AR.ETAPA,
        CASE WHEN AR.TURNO ='0' THEN 'DIA' ELSE 'NOCHE' END AS 'TURNO'
        FROM AsistenciaRapida AR
        INNER JOIN FamiliaActividades FAM on FAM.IdEmpresa=AR.IdEmpresa AND FAM.IdFamilia=AR.IdFamilia
        INNER JOIN Actividades ACT ON ACT.IdEmpresa=AR.IdEmpresa AND ACT.IdFamilia=AR.IdFamilia AND ACT.IdActividad=AR.IdActividad
        INNER JOIN Cuartel CUA ON CUA.IdEmpresa=AR.IdEmpresa AND CUA.IdZona=AR.IdZona AND CUA.IdCuartel=AR.IdCuartel
        WHERE AR.IdEmpresa='{$IdEmpresa}' AND  AR.Sw_App='1' AND AR.FechaActividad='{$FechaActividad}' AND AR.IdZona='{$IdZona}' AND ".$sqlwhere ;
		
       
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